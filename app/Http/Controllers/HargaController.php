<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Produk;
use App\Models\JenisSatuan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

    #[Controllers()]
    #[Group(prefix: 'harga',middleware:['role:SUPER-ADMIN'])]

class HargaController extends Controller
{
    #[Get("")]
    public function index()
    {
         $harga = Harga::with('produk','jenisSatuan')->get();
 
        return view('Page.Harga.index',['harga' => $harga]);
    }
    
    
    #[Get("tambah")]
    public function formtambah()
    {
        $produk = Produk::all();
        $satuan = JenisSatuan::all();
        
        return view('Page.Harga.tambah', compact('produk', 'satuan'));
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $harga = Harga::find($id);
    
        if (!$harga) {
            return redirect()->back()->withErrors(['Harga tidak ditemukan.']);
        }
    
        $produk = Produk::all();
        $satuan = JenisSatuan::all();
    
        return view('Page.Harga.edit', compact('harga','produk', 'satuan'));
    }


    #[Post("tambahdata")]

    public function store(Request $request)
    {
        $request->validate([
            'harga_satuan' => 'required|string|max:255',
            'produk_id' => 'required|numeric|min:0',
            'jenis_satuan_id' => 'required|numeric|min:0',
        ]);
    
        try {
            $harga = Harga::create([
                'harga_satuan' => $request->harga_satuan,
                'produk_id' => $request->produk_id,
                'jenis_satuan_id' => $request->jenis_satuan_id,
            ]);
    
            if ($harga) {
                Alert::success('Success', 'Harga berhasil ditambahkan!');
                return redirect()->route('harga.index');
            } else {
                throw new \Exception('Gagal menyimpan harga.');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menambahkan harga: ' . $e->getMessage());
            return redirect()->route('harga.index');
        }
    }


    #[Post("editdata/{id}")]

    public function edit(Request $request, $id)
    {
        $request->validate([
            'harga_satuan' => 'required|string|max:255',
            'produk_id' => 'required|numeric|min:0',
            'jenis_satuan_id' => 'required|numeric|min:0',
        ]);
    
        $harga = Harga::find($id);
    
        if (!$harga) {
            return Redirect::back()->withErrors(['Harga tidak ditemukan.']);
        }
    
        $harga->harga_satuan = $request->harga_satuan;
        $harga->produk_id = $request->produk_id;
        $harga->jenis_satuan_id = $request->jenis_satuan_id;
    
        $harga->save();
    
        Alert::success('Success', 'Harga berhasil diperbarui!');
        return redirect()->route('harga.index');
    }
    
    #[Get("hapus/{id}")]
    public function hapus($id)
        {
            $harga = Harga::find($id);

            if (!$harga) {
                return Redirect::back()->withErrors(['Harga tidak ditemukan.']);
            }

          

            // Hapus data produk dari database
            $harga->delete();

            Alert::success('Success', 'Harga berhasil dihapus!');
            return redirect()->back();
        }
    
    
}
