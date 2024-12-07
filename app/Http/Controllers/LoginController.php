<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proses(Request $request)
    {
        $validate['username'] = 'required';
        $validate['password'] = 'required';

        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return response()->json([
                'inputerror' => $validator->errors()->keys(),
                'error_string' => $validator->errors()->all()
            ]);
        }

        $username = $request->input('username');
        $getUserEmail = User::where('email', $username)->first();
        if ($getUserEmail) {
            $kredensial = ['email' => $getUserEmail->email, 'password' => $request->password];
        } else {
            return back()->with(['message' => "User tidak ditemukan.!"]);
        }

        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $sessData['user_id'] = $user->id;
            $sessData['name'] = $user->name;
            $sessData['username'] = $user->username;
            $sessData['email'] = $user->email;
            session($sessData);

        }

        return back()->with(['message' => "User tidak ditemukan.!"]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
