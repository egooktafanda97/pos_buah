<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisProduk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

    #[Controllers()]
    #[Group(prefix: 'jenis')]

class JenisProdukController extends Controller
{
    #[Get("")]
    public function index()
    {
         $jenisproduk = JenisProduk::all();
 
        return view('Page.JenisProduk.index',['jenisproduk' => $jenisproduk]);
    }
    
    
    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.JenisProduk.tambah');
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $jenisproduk = JenisProduk::find($id);
        if (!$jenisproduk) {
            return redirect()->route('jenis.index')->withErrors(['Jenis Produk tidak ditemukan.']);
        }
        return view('Page.JenisProduk.edit', compact('jenisproduk'));
    }


    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_produk' => 'required|string|max:255',
           
        ]);
    
        try {
            $jenisproduk = JenisProduk::create([
                'nama_jenis_produk' => $request->nama_jenis_produk,
               
            ]);
    
            if ($jenisproduk) {
                Alert::success('Success', 'Jenis Produk berhasil ditambahkan!');
                return redirect()->route('jenis.index');
            } else {
                throw new \Exception('Gagal menyimpan jenis produk.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan jenis produk: ' . $e->getMessage())->withErrors(['Gagal menambahkan jenis produk: ' . $e->getMessage()]);
        }
    }
    
    

    #[Post("editdata/{id}")]

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_jenis_produk' => 'required|string|max:255',
          
        ]);
    
        $jenisproduk = JenisProduk::find($id);
    
        if (!$jenisproduk) {
            return redirect()->route('jenis.index')->withErrors(['Jenis Produk tidak ditemukan.']);
        }
    
        $jenisproduk->nama_jenis_produk = $request->nama_jenis_produk;
      
    
        $jenisproduk->save();
    
        Alert::success('Success', 'enis Produk berhasil diperbarui!');
        return redirect()->route('jenis.index');
    }
    
    
    #[Get("hapus/{id}")]
    public function hapus($id)
        {
            $jenisproduk = JenisProduk::find($id);

            if (!$jenisproduk) {
                return Redirect::back()->withErrors(['Jenis Produk tidak ditemukan.']);
            }

       

            // Hapus data produk dari database
            $jenisproduk->delete();

            Alert::success('Success', 'Jenis Produk berhasil dihapus!');
            return redirect()->back();
        }
    
    
}
