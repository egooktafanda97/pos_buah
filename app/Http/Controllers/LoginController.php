<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: '')]
class LoginController extends Controller
{
    #[Get("login")]
    public function halamanlogin()
    {
        return view('auth.login');
    }

    #[Post("postlogin")]
    public function postlogin(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            Alert::success('Login Berhasil', 'Selamat datang kembali!');
            return redirect('/home');
        } else {
            Alert::error('Login Gagal', 'Username atau password salah!');
            return redirect('/login');
        }
    }

    #[Get("logout")]
    public function logout()
    {
        Auth::logout();
        Alert::success('Logout Berhasil', 'Anda telah berhasil keluar.');
        return redirect('/login');
    }
}
