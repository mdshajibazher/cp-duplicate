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
    public function login(Request $request)
    {
        $this->validate($request, [
            'email_or_phone' => 'required',
            'password' => 'required'
        ]);
        if ($admin = Admin::where('phone', $request->email_or_phone)->first()) {
            if ($admin->status == 0) {
                throw ValidationException::withMessages([
                    'message' => ['User currently disabled contact administrator for activation'],
                ]);
            } else {
                if (!$admin || !Hash::check($request->password, $admin->password)) {
                    throw ValidationException::withMessages([
                        'message' => ['The provided credentials are incorrect'],
                    ]);
                } else {
                    $token = $admin->createToken('admin_token');
                    return ['token_object' => $token];
                }

            }
        }
        throw ValidationException::withMessages([
            'message' => ['The provided credentials are incorrect'],
        ]);

    }
}
