<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use Session;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\adminLoginRequest;

class AdminLoginController extends Controller
{
    public function adminLogin(){
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.inventorydashboard'));
        }else{
            return view('admin.auth.login');
        }

    }


    function validateinput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    public function adminLoginSubmit(adminLoginRequest $request){

        $remember = $request->remember;
        $adminuserinfo = $this->validateinput($request->email_or_phone);

        if( $admin = Admin::where('phone',$adminuserinfo)->first()){
            if($admin->status == 0){
                Session()->flash('error', 'user currently disabled contact administrator for activation');
                return redirect()->back()->withInput($request->only('email_or_phone', 'remember'));
        }else{
                if(Auth::guard('admin')->attempt(['phone'=> $adminuserinfo, 'password' => $request->password],$remember)){
                    return redirect(route('admin.inventorydashboard'));
                }else{
                    Session()->flash('error', 'Invalid Password');
                    return redirect()->back()->withInput($request->only('email_or_phone', 'remember'));
                }
        }
        }else{
            Session()->flash('error', 'Invalid Credentials');
            return redirect()->back()->withInput($request->only('email_or_phone', 'remember'));
        }



    }

    public function adminLogout(){
        Auth::guard('admin')->logout();
        Session::regenerate();
        return redirect(route('admin.login'));
    }



}
