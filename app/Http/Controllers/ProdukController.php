<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
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
    #[Group(prefix: 'produk',middleware:['role:SUPER-ADMIN'])]

class ProdukController extends Controller
{
    #[Get("")]
    public function index()
    {
         $produk = Produk::with('harga','supplier','jenisProduk')->get();
 
        return view('Page.Produk.index',['produk' => $produk]);
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
        $produk = Produk::find($id);
    
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
        'nama_produk' => 'required|string|max:255',
        'supplier_id' => 'required|numeric|min:0',
        'jenis_produk_id' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        $gambarFile = $request->file('gambar');
        $gambarPath = null;

        if ($gambarFile) {
            $gambarName = time() . '_' . $gambarFile->getClientOriginalName();
            $gambarPath = $gambarFile->move(public_path('imgproduk'), $gambarName);
            $gambarPath = '/imgproduk/' . $gambarName;
        }

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'jenis_produk_id' => $request->jenis_produk_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        if ($produk) {
            Alert::success('Success', 'Produk berhasil ditambahkan!');
            return redirect()->route('produk.index');
        } else {
            throw new \Exception('Gagal menyimpan produk.');
        }
    } catch (\Exception $e) {
        // Jika terjadi kesalahan, hapus file gambar jika ada
        if ($gambarPath) {
            unlink($gambarPath);
        }
        Alert::error('Error', 'Gagal menambahkan produk: ' . $e->getMessage());
        return redirect()->route('produk.index');
    }
}


    #[Post("editdata/{id}")]

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'supplier_id' => 'required|numeric|min:0',
            'jenis_produk_id' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $produk = Produk::find($id);
    
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
    
        $produk->nama_produk = $request->nama_produk;
        $produk->supplier_id = $request->supplier_id;
        $produk->jenis_produk_id = $request->jenis_produk_id;
        $produk->stok = $request->stok;
        $produk->deskripsi = $request->deskripsi;
    
        if ($request->hasFile('gambar')) {
            $gambarFile = $request->file('gambar');
            $gambarName = time() . '_' . $gambarFile->getClientOriginalName();
            $gambarPath = $gambarFile->move(public_path('imgproduk'), $gambarName);
            $produk->gambar = '/imgproduk/' . $gambarName;
        }
    
        $produk->save();
    
        Alert::success('Success', 'Produk berhasil diperbarui!');
        return redirect()->route('produk.index');
    }
    
    #[Get("hapus/{id}")]
    public function hapus($id)
        {
            $produk = Produk::find($id);

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

            Alert::success('Success', 'Produk berhasil dihapus!');
            return redirect()->back();
        }
    
    
}