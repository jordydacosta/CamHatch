<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <ul class="nav menu">
        <li @if(Request::is('admin/dashboard')) class="active" @endif>
            <a href="{{ route('dashboard') }}">
                <span class="icon-dashboard"></span> Dashboard
            </a>
        </li>
        <li @if(Request::is('admin/orders*')) class="active" @endif>
            <a href="{{ route('orders') }}">
                <span class="icon-shopping-cart"></span> Orders
            </a>
        </li>
        <li @if(Request::is('admin/reviews*')) class="active" @endif>
            <a href="{{ route('reviews') }}">
                <span class="icon-eye"></span> Reviews
            </a>
        </li>
        <li @if(Request::is('admin/country*')) class="active" @endif>
            <a href="{{ route('country') }}">
                <span class="icon-export"></span> Shipping Rates
            </a>
        </li>
        <li @if(Request::is('admin/voucher*')) class="active" @endif>
            <a href="{{ route('voucher') }}">
                <span class="icon-moneybag"></span> Vouchers
            </a>
        </li>
        <li @if(Request::is('admin/profiles*')) class="active" @endif>
            <a href="{{ route('profiles') }}">
                <span class="icon-user"></span> Users
            </a>
        </li>
        {{-- <li @if(Request::is('admin/settings*')) class="active" @endif>
            <a href="{{ route('settings') }}">
                <span class="icon-cog"></span> Settings
            </a>
        </li> --}}
    </ul>
</div>