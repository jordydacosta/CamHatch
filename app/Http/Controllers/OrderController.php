<?php

namespace App\Http\Controllers;

use App\Country;
use App\Product;
use App\Tax;
use App\Voucher;
use App\Invoice;
use App\InvoiceLine;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Order as Order;

use DB, Response, Input, Redirect;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index()
    {
        // directories
        $orders = $this
            ->order
            ->select(DB::raw("count(*) AS all_orders, count(case orderstatus_id when 5 then 1 else null end) AS on_hold, count(case orderstatus_id when 7 then 1 else null end) AS completed, count(case orderstatus_id when 6 then 1 else null end) AS cancelled"))
            ->get();
        return view('backend.pages.orders.index', ['title' => 'Orders', 'orders' => $orders]);
    }

    /**
     * Return the data to inject into datatables
     *
     * @param null $status
     *
     * @return mixed
     */
    public function getData($status = null)
    {
        $orders = $this
            ->order
            ->select('id', 'orderId', 'orderstatus_id', 'quantity', 'firstname', 'shipping_firstname', 'lastname', 'shipping_lastname', 'email', 'address', 'shipping_address', 'zipcode', 'shipping_zipcode', 'city', 'shipping_city', 'created_at', 'price', 'same_as_billing_address');

        if (!is_null($status)) {
            $orders = $orders->where('orderstatus_id', '=', $status);
        }
        $orders = $orders->orderBy('created_at', 'DESC');

        return datatables()->of($orders)
            ->editColumn('id', '<input type="checkbox" name="check-row" class="check-row" value="{{ $id }}" >')
            ->editColumn('orderId', '<b><a href="{{ route("orders_show", $id) }}" data-toggle="tooltip" data-placement="bottom" title="Tooltip on left">#{{ $orderId }}</a></b><br> by {{ $firstname." ".$lastname }} <br> <small>{{ $email }}</small>')
            ->editColumn('orderstatus_id', '<b>@lang("backend.order_status.".$orderstatus_id)</b>')
            ->editColumn('quantity', '{{ $quantity }} @if($quantity == 1) item @else items @endif')
            ->editColumn('firstname', '@if($same_as_billing_address == 1) {{ $firstname." ".$lastname }} <br> {{ $address }} <br> {{ $zipcode." ".$city }} @else {{ $shipping_firstname." ".$shipping_lastname }} <br> {{ $shipping_address }} <br> {{ $shipping_zipcode." ".$shipping_city }} @endif')
            ->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}')
            ->editColumn('price', '€ {{ $price }}')
            ->addColumn('actions', '@if($orderstatus_id != 7) <button class="complete_order btn btn-xs btn-default" data-id="{{$id}}"><i class="icon-check"></i></button> @endif <button class="remove_order btn btn-xs btn-danger" data-id="{{$id}}"><i class="icon-trash"></i></button>')
            ->removeColumn('lastname')
            ->removeColumn('email')
            ->removeColumn('address')
            ->removeColumn('zipcode')
            ->removeColumn('city')
            # Shipping details
            ->removeColumn('shipping_firstname')
            ->removeColumn('shipping_lastname')
            ->removeColumn('shipping_address')
            ->removeColumn('shipping_zipcode')
            ->removeColumn('shipping_city')
            ->removeColumn('same_as_billing_address')
            ->rawColumns(['id', 'orderId', 'orderstatus_id', 'quantity', 'firstname', 'created_at', 'price', 'actions'])
            ->make();
    }

    /**
     * Get the order count depending on the status
     *
     * @return array
     */
    public function getOrderStatusCounts()
    {
        $orders = $this->order;

        $all = $orders->count();
        $on_hold = $orders->orderType([config("config.order_status.on_hold")])->count();
        $cancelled = $orders->orderType([config("config.order_status.cancelled")])->count();
        $completed = $orders->orderType([config("config.order_status.completed")])->count();

        return array(
            'all' => $all,
            'on_hold' => $on_hold,
            'cancelled' => $cancelled,
            'completed' => $completed
        );
    }

    public function updateOrderStatus()
    {
        if ($this->order->whereIn('id', Input::get('rows'))->update(['orderstatus_id' => Input::get('new_status')])) {
            DB::commit();

            // check if the order has been set on complete, if yes, send shipping confirmation to all orders
            if (Input::get('new_status') == config('config.order_status.completed')) {
                $orders = $this->order->whereIn('id', Input::get('rows'))->get();

                foreach ($orders as $order) {
                    $this->sendMail($order);
                }
            }

            return Response::json(array(
                    'changed' => 1
                )
            );
        }

        return Response::json(array(
                'changed' => 0
            )
        );
    }

    /**
     * Export the customer to csv file and download
     * @return [type] [description]
     */
    public function export($type)
    {
        // check the type that needs to be downloaded
        if ($type == "users") {
            $filename = "users.csv";

            $data = $this
                ->order
                ->select('firstname', 'lastname', 'email', 'phone', 'address', 'zipcode', 'city', 'country')
                ->get()
                ->toArray();

            $c_headers = array('Firstname', 'Lastname', 'Email', 'Phone', 'Address', 'Zipcode', 'City', 'Country.php');

        } elseif ($type == "orders") {
            $filename = "orders.csv";

            $data = $this
                ->order
                ->select('firstname', 'lastname', 'email', 'phone', 'address', 'zipcode', 'city', 'country')
                ->get()
                ->toArray();

            $c_headers = array('Firstname', 'Lastname', 'Email', 'Phone', 'Address', 'Zipcode', 'City', 'Country.php');
        }

        // set the headers
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-Encoding' => 'UTF-8'
            , 'Content-type' => 'text/csv; charset=UTF-8'
            , 'Content-Disposition' => 'attachment; filename=' . $filename
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];

        // add headers for each column in the CSV download
        array_unshift($data, $c_headers);

        $callback = function () use ($data) {
            $FH = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        // download the file
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Order $order, $id)
    {
        $order = $order->findOrFail($id);
        $invoice = Invoice::where('order_id',$order->id)->first();
        $country = Country::where('isocode', $order->country)->first();
        if( $country == null){
            $country = Country::where('country_nl', $order->country )->first();
            if($country == null){
                $country = Country::where('country_en', $order->country )->first();
            }
        }

        return view('backend.pages.orders.show', ['title' => 'Order Details', 'order' =>$order, 'invoice' =>$invoice,
            'country' =>$country]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request ,$id)
    {
        $new_order_status = Input::get('order-status');
        $order = $this->order->find($id);
        $order->orderstatus_id = $new_order_status;

        $invoice = Invoice::where('order_id',$order->id)->get();
        if($new_order_status != 6 && $new_order_status > 1){
            if($invoice->count() == 0){
                $this->ship($id);
            }
        }

        $request->session()->flash('status', ' Order status has been succesfully changed');

        if ($order->save()) {
            DB::commit();
            // send shipping confirmation when a order has been set on completed status
            if ($new_order_status == config('config.order_status.completed')) {
                // send shipping confirmation
                $this->sendMail($order);
            }
            return Redirect::route('orders');
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // fetch the deed
        $order = $this->order->find($id);
        $invoice = Invoice::where('order_id',$order->id)->first();


        $order->orderstatus_id = config('config.order_status.completed');

        if ($order->save()) {
            DB::commit();

            // send shipping confirmation
            $this->sendMail($order);
            $this->sendPdf($request ,$invoice->id);

            return Response::json(array(
                    'changed' => 1
                )
            );
        }
    }

    private function sendMail($order)
    {
        $data = [
            'firstname' => $order->firstname,
            'lastname' => $order->lastname,
            'orderId' => $order->orderId
        ];

        \Mail::send('backend.emails.order_sent', $data, function ($message) use ($data, $order) {

            $message->to($order->email);
            $message->bcc('smail@pegus-apps.com');
            $message->subject('Your order has been shipped');
        });
    }
    /**
     * Remove the specified resource from storage.
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {
        if ($this->order->whereIn('id', Input::get('rows'))->delete()) {
            $request->session()->flash('status', ' Order has succesfully been deleted');

            return Response::json(array(
                    'deleted' => 1
                )
            );
        }

        return Response::json(array(
                'deleted' => 0
            )
        );
    }
    //Opslaan orders
    public function store(Request $request){
        //het opslaan van de new order
        $product = Product::find(1);
        $data = $request->validate([
            'quantity' => 'required|integer',
            'firstname'=> 'required',
            'lastname'=> 'required',
            'email' =>'required|email',
            'phone' =>'required|min:7',
            'company' => 'nullable|string',
            'address'=> 'required',
            'zipcode'=> 'required',
            'city' =>'required',
            'country'=>'required',
            'comment' =>'nullable|string',
            'voucher' =>'nullable|string',
            'reference' => 'nullable|string',
            'deliverydate' => 'nullable|date',
        ]);
        // create new order
        $order = new Order;
        $countryTax = Country::where('isocode',Input::get('country'))->first();

        // Order Information getting filled
        $order->firstname = $data['firstname'];
        $order->lastname = $data['lastname'];
        $order->email = $data['email'];
        $order->phone = $data['phone'];
        $order->customer_ip = \Request::getClientIp();
        $order->company = (Input::get('company') ? Input::get('company') : null);
        $order->address = $data['address'];;
        $order->zipcode = $data['zipcode'];;
        $order->city = $data['city'];;
        $order->country = strtolower($data['country']);
        $order->same_as_billing_address = 0;
        $order->quantity = $data['quantity'];
        $order->comment = $data['comment'];
        $order->voucher_id = (Input::get('voucher') ? Input::get('voucher') : null);
        $order->reference = $data['reference'];
        $order->delivery_date = $data['deliverydate'];
        $order->country_id = $countryTax->id;
        $order->shipping_price = $countryTax->shipment_rate;
        // Shipping address
        $order->shipping_firstname =  Input::get('firstname');
        $order->shipping_lastname =  Input::get('lastname');
        $order->shipping_company =  (Input::get('company') ? Input::get('company') : null);
        $order->shipping_address = Input::get('address');
        $order->shipping_zipcode =  Input::get('zipcode');
        $order->shipping_city =  Input::get('city');
        $order->shipping_country = Input::get('country');

        $order->price = $data['quantity'] * $product->price + $countryTax->shipment_rate;
        $order->price_ex = $data['quantity'] * $product->price_ex;
        $order->price_btw = $data['quantity'] * $product->BTW;
        $order->quantity = $data['quantity'];
        $order->comment = Input::get('comment');
        if($data['country'] == 'nl')
        {
            $order->shipping_plan = 3;
        }
        elseif($data['country'] == 'be')
        {$order->shipping_plan = 1;}
        else{
            $order->shipping_plan = 2;
        }

        $order->orderstatus_id = 1;

        $order->save();
        $request->session()->flash('status', ' Order has been succesfully created');
        return Redirect::route('orders_show', $order->id);
    }
    //het bewerken van orders
    public function overtake(Request $request, Order $order, $id){

        //get order I want to change
        $order = $order->find($id);
        $product = Product::find(1);
        $taxes = Tax::find($product->tax_id);
        $invoice = Invoice::where('order_id',$order->id)->first();

        $data = $request->validate([
            'quantity' => 'required|integer',
            'firstname'=> 'required',
            'lastname'=> 'required',
            'email' => 'required|email',
            'phone' => 'required|min:7',
            'company' => 'nullable|string',
            'address'=> 'required',
            'zipcode'=> 'required',
            'city' =>'required',
            'country'=>'required',
            'comment' =>'nullable|string',
            'voucher' =>'nullable|string',
            'reference' => 'nullable|string',
            'delivery_date' => 'nullable|date',
            'orderId' => 'required'
        ]);

        strtolower( $data['country']);

        $countryTax = Country::where('isocode', $data['country'] )->first();
        $order->price = $data['quantity'] * $product->price + $countryTax->shipment_rate;
        $order->price_ex = $data['quantity'] * $product->price_ex;
        $order->price_btw = $data['quantity'] * $product->BTW;
        $order->orderId = $data['orderId'];
        $order->reference = $data['reference'];
        $order->delivery_date = $data['delivery_date'];
        $order->shipping_firstname =  Input::get('firstname');
        $order->shipping_lastname =  Input::get('lastname');
        $order->shipping_company =  (Input::get('company') ? Input::get('company') : null);
        $order->shipping_address = Input::get('address');
        $order->shipping_zipcode =  Input::get('zipcode');
        $order->shipping_city =  Input::get('city');
        $order->shipping_country = Input::get('country');
        $order->country_id = $countryTax->id;

        if($invoice != null){
            //het checken of het wel een invoice heeft
            if($order->orderstatus_id != 1 ||$order->orderstatus_id != 5 ){
                $invoice->quantity = $data['quantity'];
                $invoice->price = $order->price;
                $invoice->tax = ($order->price) / ($taxes->tax_rate /100+1) ;
                $invoice->update();
            }
        }
        if($data['country'] == 'nl')
            $order->shipping_plan = 3;

        elseif($data['country'] == 'be')
            $order->shipping_plan = 1;
        else
            $order->shipping_plan = 2;


        $order->update($data);
        $request->session()->flash('status', ' Order has been succesfully changed');
        return Redirect::route('orders_show', $order->id);
    }

    public function editor(){
        $country = Country::all();
        return view('backend.pages.orders.editor', ['country'=> $country]);
    }

    public function change($id){
        $order = $this->order::where('id',$id)->first();
        $invoice = Invoice::where('order_id',$order->id)->first();
        $country = Country::all();
        return view('backend.pages.orders.update',[ 'order' =>$order, 'invoice'=>$invoice, 'country'=> $country]);
    }
    //all country functions
    public function country(){
        //get index page
        $country = Country::all()->sortBy('country_en');
        return view('backend.pages.countries.index', ['title' => 'Orders', 'country' => $country]);
    }

    public function countryCreate()
    {
        //get create page
        return view('backend.pages.countries.edit');
    }

    public function countryEdit($id){
        //get update page
        $country = Country::findorFail($id);
        return view('backend.pages.countries.update',compact('country'));
    }

    public function updateCountry(Request $request, $id){
        //Edit Country [id]
        $country = Country::find($id);
        $data = $request->validate([
            "country_name_nl"    => 'required',
            "country_name_en"    => 'required',
            'iso_code'           => 'required',
            'shipment_rate'      => 'required',
            'continents'          => 'nullable|string',
        ]);

        //Check to remove dots
        $data['shipment_rate'] = str_replace('.', '', $data['shipment_rate']);
        //Check to change comma for dots
        $data['shipment_rate'] = str_replace(',', '.', $data['shipment_rate']);

        $country->continents = strtolower($data['continents']);
        $country->country_en = $data['country_name_en'];
        $country->country_nl = $data['country_name_nl'];
        $country->isocode = strtolower($data['iso_code']);
        $country->continents = $data['continents'];
        $country->shipment_rate = $data['shipment_rate'];
        $country->save();

        $request->session()->flash('status', trans('general.country_saved'));
        return Redirect::route('country');
    }

    public function saveCountry(Request $request){
        ///add the new Country
        $data = $request->validate([
            'continents'          => 'nullable|string',
            "country_name_nl"    => 'required',
            "country_name_en"    => 'required',
            'iso_code'           => 'required',
            'shipment_rate'      => 'required',
        ]);
        $checker = Country::where('country_nl', '=' ,$data['country_name_nl'])->first();
        $controle2 = Country::where('isocode', '=' ,$data['iso_code'])->first();
        $controle3 =  Country::where('country_en','=',$data['country_name_en'])->first();

        if ($controle2 != null || $controle3 != null || $checker != null){
            $request->session()->flash('status', trans('general.info_exists'));
            return view('backend.pages.countries.edit')->with('data',$data);
        }

        $country = new Country();
        $country->isocode = strtolower($data ['iso_code']);
        $country->country_nl = $data['country_name_nl'];
        $country->country_en = $data['country_name_en'];
        $country->shipment_rate = $data['shipment_rate'];
        $country->continents = strtolower($data['continents']);

        $country->save();

        $request->session()->flash('status', trans('general.country_saved'));
        return Redirect::route('country');
    }

    //kortingscodes
    public function voucher(){
        $voucher = Voucher::all()->sortBy('id');
        return view('backend.pages.voucher.index', ['title' => 'Orders', 'voucher' => $voucher]);
    }

    public function deleteCountry(Request $request,$id){
        //delete Country [id]
        $country = Country::findOrFail($id);
        $country->delete();
        $request->session()->flash('status', trans('general.country_deleted'));
        return Redirect::route('country');
    }

    public function voucherCreate(){

        //gen code
        $randomvoucher = uniqid();
        //stuur code mee
        return view('backend.pages.voucher.edit',compact('randomvoucher'));
    }

    public function voucherEdit($id){
        $voucher = Voucher::findorFail($id);
        return view('backend.pages.voucher.update',compact('voucher'));
    }

    public function voucherSave(Request $request){
        $data = $request->validate([
            'vouchercode' =>            'required',
            'amount' =>                 'required|integer|between:1,100',
            'discount_percent' =>       'required|integer|between:1,100',
            'expires_at' =>             'required',
            'minimum_order_quantity' => 'required|integer|between:1,100',
        ]);

        if(Voucher::where('vouchercode', $data['vouchercode'])->first()){
            return false;
        }
        if($request->expires_at >= Carbon::today()->toDateString()) {

            $voucher = new Voucher();

            $voucher->vouchercode = $data ['vouchercode'];
            $voucher->amount = $data['amount'];
            $voucher->discount_percent = $data['discount_percent'];
            $voucher->expires_at = $data['expires_at'];
            $voucher->minimum_order_quantity = $data['minimum_order_quantity'];

            $voucher->save();
            $request->session()->flash('status', ' Voucher has succesfully been saved');
            return Redirect::route('voucher');
        }
        $request->session()->flash('alert', ' Voucher expires at was not correct');
        return Redirect::route('voucher');
    }

    public function voucherUpdate(Request $request, $id){

        $voucher = Voucher::find($id);
        $data = $request->validate([
            'vouchercode' => 'required',
            'amount' => 'required|integer|between:1,100',
            'discount_percent' => 'required|integer|between:1,100',
            'expires_at' => 'required',
            'minimum_order_quantity' => 'required|integer|between:1,100',
        ]);

        if($request->expires_at >= Carbon::today()->toDateString()) {
            $voucher->update($data);
            $request->session()->flash('status', 'Voucher was successfully updated');
            return Redirect::route('voucher');
        }
        $request->session()->flash('alert', 'Voucher expires date is not correct');
        return Redirect::route('voucher');
    }

    public function voucherDelete(Request $request, $id){

        $voucher = Voucher::findOrFail($id);
        $order = Order::where('voucher_id',($voucher->id))->first();
        if ($order == null){
            $voucher->delete();
            $request->session()->flash('status','Voucher has successfully been deleted');
        }
        else
            $request->session()->flash('alert',' Voucher can not be deleted because it has been used');

        return Redirect::route('voucher');
    }

    public function ship($id){

        //get all invoice
        $invoice = Invoice::all();
        $invoice_line = new InvoiceLine;
        $tax = Tax::find(1);
        $product =Product::find(1);

        $order = $this->order->find($id);
        $countryTax = Country::where('isocode', $order->country )->first();
        if( $countryTax == null){
            $countryTax = Country::where('country_nl', $order->country )->first();
            if($countryTax == null){
                $countryTax = Country::where('country_en', $order->country )->first();
            }
        }

        //get all count +1 for every invoice
        $count = 1000;
        foreach ($invoice as $I){
            $count += 1;
        }

        $count = (string) $count;
        $invoice_id ='F'.date('Y'). ".0000." . $count;

        //make invoice empty and fill it with variables
        $invoice = new Invoice();
        $invoice->invoice_id = $invoice_id;
        $invoice->order_id = $order->id;
        $invoice->quantity = $order->quantity;
        $invoice->price = $order->price;
        $invoice->tax = ($order->price ) / ($tax->tax_rate/100 + 1 );
        $invoice->save();

        $invoice_line->quantity = $order->quantity;
        $invoice_line->invoice_id = $invoice->id;
        $invoice_line->price = $order->price;
        $invoice_line->product_id = $product->id;
        $invoice_line->tax = ($order->price ) / ($tax->tax_rate/100 + 1);
        $invoice_line->save();
        // Mail::to($userOrder)->send(new OrderShipped());
        return Redirect::route('orders');
    }
    //PDF knoppen bij orders

    public function getPdf($id){

        $invoice = Invoice::find($id);

        $product = Product::where('id', 1)->first();
        $product->price_ex = $product->price / 1.21;
        $product->BTW = $product->price - $product->price_ex;
        $product->update();

        $order = $this->order->find($invoice->order_id);
        $country = Country::where('isocode', $order->country )->first();
        $voucher = null;
        if( $country == null){
            $country = Country::where('country_nl', $order->country )->first();
            if($country == null){
                $country = Country::where('country_en', $order->country )->first();
            }
        }

        if ($order->voucher_id != null)
        {
            $voucher = Voucher::findOrFail($order->voucher_id);
        }
        return view('backend.pages.orders.invoice',['invoice' => $invoice, 'order' => $order, 'country' =>$country, 'voucher' =>$voucher, 'product'=> $product]);
    }

    public function downloadPdf(Request $request, $id){

        $invoice = Invoice::find($id);

        $product = Product::where('id', 1)->first();
        $product->price_ex = $product->price / 1.21;
        $product->BTW = $product->price - $product->price_ex;
        $product->update();

        $order = $this->order->find($invoice->order_id);
        $country = Country::where('isocode', $order->country )->first();

        if( $country == null){
            $country = Country::where('country_nl', $order->country )->first();
            if($country == null){
                $country = Country::where('country_en', $order->country )->first();
            }
        }

        $getbasename = Storage::disk('google')->listcontents();
        for ($i = 0; $i<sizeof($getbasename); $i++) {
            if($getbasename[$i]['name'] == 'invoice'.$invoice->invoice_id.'.pdf') {
                $request->session()->flash('status', ' PDF word nu gedownload!');
                return Storage::disk('google')->download('178ahK_-k4baPM06ywuu7ZUr_rKnAmF9V/'.$getbasename[$i]['basename'],$getbasename[$i]['name']);
            }
        }

        $pdf = PDF::loadView('backend.pages.orders.pdf', ['invoice' => $invoice, 'order' => $order,'country' =>$country,'product'=> $product]);
        $request->session()->flash('status', ' PDF word nu gedownload!');
        return $pdf->download($invoice->invoice_id.'.pdf');
    }

    public function uploadPdf(Request $request, $id){

        $invoice = Invoice::find($id);

        $product = Product::where('id', 1)->first();
        $product->price_ex = $product->price / 1.21;
        $product->BTW = $product->price - $product->price_ex;
        $product->update();

        $order = $this->order->find($invoice->order_id);
        $country = Country::where('isocode', $order->country )->first();
        if( $country == null){
            $country = Country::where('country_nl', $order->country )->first();
            if($country == null){
                $country = Country::where('country_en', $order->country )->first();
            }
        }
        $pdf = PDF::loadView('backend.pages.orders.pdf', ['invoice' => $invoice, 'order' => $order,'country' =>$country,'product'=> $product]);
        Storage::disk('google')->put('invoice'.$invoice->invoice_id.'.pdf',$pdf->download('invoice.pdf'));

        $request->session()->flash('status', ' PDF succesful opgeslagen!');
        return Redirect::route('orders_show', $order->id);
    }

    public function sendPdf(Request $request ,$id){

        $invoice = Invoice::find($id);
        $order = $this->order->find($invoice->order_id);

        $product = Product::where('id', 1)->first();
        $product->price_ex = $product->price / 1.21;
        $product->BTW = $product->price - $product->price_ex;
        $product->update();

        $country = Country::where('isocode', $order->country )->first();
        if( $country == null){
            $country = Country::where('country_nl', $order->country )->first();
            if($country == null){
                $country = Country::where('country_en', $order->country )->first();
            }
        }

        \Mail::send('backend.pages.orders.invoice', [ 'order' => $order, 'country' =>$country, 'invoice' => $invoice,'product'=> $product],
            function ($message) use ($invoice, $order,$country, $product) {
            // if the app is in debug mode, send the email to the web designer
            if (\Config::get('app.debug')) {
                $message->to($order->email);
                $message->bcc('smail@pegus-apps.com');
            } else {
                $message->to($order->email);
                $message->bcc([
                    'info@camhatch.nl',
                    'wendy.seys@pegusapps.com',
                    'smail@pegus-apps.com'
                ]);
            }
            $message->subject(trans('orders.emailSubject') . $order->orderId);

        });
        $request->session()->flash('status', ' De Mail is verzonden naar de klant!');
        return Redirect::route('orders_show', $order->id);
    }
}
