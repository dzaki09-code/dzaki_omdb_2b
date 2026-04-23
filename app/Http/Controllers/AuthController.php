<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
    
    public function register_process(Request $request)
    {
        try {
            $response = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if (!$response) {
                return redirect()->back()->with('error', 'Registrasi gagal');
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil');
        } catch (\Throwable $th) {
            Log::error('Failed to register user', [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage(),
            ]);
        }
    }
}
