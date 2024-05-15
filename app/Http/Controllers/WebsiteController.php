<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Controller\Controllers;

#[Controllers()]
#[Group(prefix: '')]

class WebsiteController extends Controller
{
    #[Get("")]
    public function index(){
        $dataproduk = Harga::with('produk', 'jenisSatuan')->get();
        return view('Pageweb.index',compact('dataproduk'));

    }
}
