<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Uang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 200);
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->error([
                    'message' => 'Unauthorized'
                ], 500);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('calmifyToken')->plainTextToken;
            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => ' username dan password salah',
            ], 500);
        }
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',],
                'role' => ['required', 'string', Rule::in(['petani', 'koperasi'])],
            ]);


            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto' => $request->foto,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,

                'role' => $request->role,
            ]);


            $user = User::where('email', $request->email)->first();
            if ($user->role == "petani") {
                Uang::create([
                    'id_petani' => $user->id,
                    'saldo' => 0
                ]);
                
            }



            return response()->json([
                'token_type' => 'Bearer',
                'message' => 'Berhasil registrasi',
                'user' => $user
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Ada sesuatu yang salah',
                'error' => $error->getMessage(),
            ], 403);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Token berhasil dihapus']);
    }
    public function ambilKoperasi() {
        $user = User::where('role','koperasi')->get();
        return response()->json($user);
    }
}
