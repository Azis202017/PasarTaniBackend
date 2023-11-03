<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function checkEmail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'gagal'], 404);
    }
    public function sendPasswordForgetLink(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
             Password::sendResetLink($request->only('email'));
            return response()->json(['Kirim password berhasil' => 'success' ], 200);
        }

        return response()->json(['status' => 'gagal'], 404);
    }
}
