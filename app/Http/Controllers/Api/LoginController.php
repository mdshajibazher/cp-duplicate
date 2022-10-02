<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){
        $this->validate($request,[
            'email_or_phone' => 'required',
            'password'       => 'required'
        ]);
        if( $admin = Admin::where('phone',$request->email_or_phone)->first()){
            if($admin->status == 0){
                return response()->json(['error'=> 'user currently disabled contact administrator for activation'],403);
            }else{
                if (! $admin || ! Hash::check($request->password, $admin->password)) {
                    throw ValidationException::withMessages([
                        'email_or_phone' => ['The provided credentials are incorrect.'],
                    ]);
                }else{
                    $token = $admin->createToken('admin_token');
                    return ['token' => $token];
                }

            }
        }else{
            return response()->json(['error' => 'Invalid phone/password'],404);
        }
    }
}