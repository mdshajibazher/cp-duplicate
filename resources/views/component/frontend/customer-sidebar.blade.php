<ul class="list-group proflie-sidemenu  mb-5">
    
    <li class="list-group-item {{Request::is('myaccount/inventorystatements') ? 'active' : '' }}"><a href="{{route('inventorystatements.index')}}">My WholeSale Statements</a></li>
    <li class="list-group-item {{Request::is('myaccount/orders') ? 'active' : '' }}"><a href="{{route('orders.show')}}">My E-Commerce Order</a> </li>
    <li class="list-group-item {{Request::is('myaccount/profile') ? 'active' : '' }}"><a href="{{route('profile.show')}}">My Profile</a></li>
    <li class="list-group-item {{Request::is('myaccount/profile/edit') ? 'active' : '' }}"> <a href="{{route('profile.editprofile')}}">Edit Profile</a> </li>
    <li class="list-group-item {{Request::is('myaccount/profile/changepassword') ? 'active' : '' }}"> <a href="{{route('profile.changepassword')}}">Change Password</a> </li>
    </ul>
    