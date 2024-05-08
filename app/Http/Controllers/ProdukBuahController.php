<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukBuah;
use App\Models\JenisProduk;
use App\Models\Supplier;
use App\Models\Harga;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

    #[Controllers()]
    #[Group(prefix: 'produk')]

class ProdukBuahController extends Controller
{
    #[Get("")]
    public function index()
    {
         $produkbuah = ProdukBuah::all(); 
        return view('Page.Produk.index',compact('produkbuah'));
    }
    
    
    #[Get("tambah")]
    public function formtambah()
    {
        $jenisProduk = JenisProduk::all();
        $suppliers = Supplier::all();
        $hargas = Harga::all();
        
        return view('Page.Produk.tambah', compact('jenisProduk', 'suppliers', 'hargas'));
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $produk = ProdukBuah::find($id);
    
        if (!$produk) {
            return redirect()->back()->withErrors(['Produk tidak ditemukan.']);
        }
    
        $jenisProduk = JenisProduk::all();
        $suppliers = Supplier::all();
        $hargas = Harga::all();
    
        return view('Page.Produk.edit', compact('produk', 'jenisProduk', 'suppliers', 'hargas'));
    }


    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_id' => 'required|numeric|min:0',
            'supplier_id' => 'required|numeric|min:0',
            'jenis_produk_id' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $gambarFile = $request->file('gambar');
    
        if ($gambarFile) {
            $gambarName = time() . '_' . $gambarFile->getClientOriginalName();
    
            $gambarPath = $gambarFile->move(public_path('imgbuah'), $gambarName);
    
            $gambarPath = '/imgbuah/' . $gambarName;
        } else {
            $gambarPath = null;
        }
    
        $produk = ProdukBuah::create([
            'nama' => $request->nama,
            'harga_id' => $request->harga_id,
            'jenis_produk_id' => $request->jenis_produk_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);
    
        if ($produk) {
            Alert::success('Success', 'Buah berhasil ditambahkan!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Gagal menambahkan buah.');
            return redirect()->back()->withErrors(['Gagal menambahkan buah.']);
        }
    }


    #[Post("editdata/{id}")]

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_id' => 'required|numeric|min:0',
            'supplier_id' => 'required|numeric|min:0',
            'jenis_produk_id' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $produk = ProdukBuah::find($id);
    
        if (!$produk) {
            return Redirect::back()->withErrors(['Produk tidak ditemukan.']);
        }
    
        // Hapus gambar lama jika ada
        if ($request->hasFile('gambar') && $produk->gambar) {
            $oldImagePath = public_path($produk->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
    
        $produk->nama = $request->nama;
        $produk->harga_id = $request->harga_id;
        $produk->supplier_id = $request->supplier_id;
        $produk->jenis_produk_id = $request->jenis_produk_id;
        $produk->stok = $request->stok;
        $produk->deskripsi = $request->deskripsi;
    
        if ($request->hasFile('gambar')) {
            $gambarFile = $request->file('gambar');
            $gambarName = time() . '_' . $gambarFile->getClientOriginalName();
            $gambarPath = $gambarFile->move(public_path('imgbuah'), $gambarName);
            $produk->gambar = '/imgbuah/' . $gambarName;
        }
    
        $produk->save();
    
        Alert::success('Success', 'Buah berhasil diperbarui!');
        return redirect()->back();
    }
    
    #[Get("hapus/{id}")]
    public function hapus($id)
        {
            $produk = ProdukBuah::find($id);

            if (!$produk) {
                return Redirect::back()->withErrors(['Produk tidak ditemukan.']);
            }

            // Hapus gambar dari direktori
            if ($produk->gambar) {
                $gambarPath = public_path($produk->gambar);
                if (file_exists($gambarPath)) {
                    unlink($gambarPath);
                }
            }

            // Hapus data produk dari database
            $produk->delete();

            Alert::success('Success', 'Buah berhasil dihapus!');
            return redirect()->back();
        }
    
    
}
