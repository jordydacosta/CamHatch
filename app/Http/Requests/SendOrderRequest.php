<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SendOrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname'     => 'required|max:255',
            'lastname'      => 'required|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required',
            'address'       => 'required',
            'zipcode'       => 'required',
            'city'          => 'required',

            'shipping_firstname'     => 'max:255|required_without:same-billing-addres',
            'shipping_lastname'      => 'max:255|required_without:same-billing-addres',
            'shipping_address'       => 'required_without:same-billing-addres',
            'shipping_zipcode'       => 'required_without:same-billing-addres',
            'shipping_city'          => 'required_without:same-billing-addres'
        ];
    }
}