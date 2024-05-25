<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[RestController()]
#[Group(prefix: 'auth', middleware: ["api"])]
class AuthController extends Controller
{
    #[Post(uri: 'login')]
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'message' => 'Login Berhasil',
                'data' => [
                    'user' => $user,
                    'access_token' => $token
                ]
            ]);
        } else {
            return response()->json([
                'message' => 'Login Gagal',
                'data' => null
            ]);
        }
    }
}
