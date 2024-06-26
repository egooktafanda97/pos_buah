<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSatuan;
use App\Services\ActorService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'satuan', middleware: ['auth'])]
class JenisSatuanController extends Controller
{
    public function __construct(
        public ActorService $actorService
    ) {
    }

    #[Get("")]
    public function index()
    {
        $jenissatuan = JenisSatuan::all();

        return view('Page.JenisSatuan.index', ['jenissatuan' => $jenissatuan]);
    }


    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.JenisSatuan.tambah');
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $jenissatuan = JenisSatuan::find($id);
        if (!$jenissatuan) {
            return redirect()->route('satuan.index')->withErrors(['Jenis Satuan tidak ditemukan.']);
        }
        return view('Page.JenisSatuan.edit', compact('jenissatuan'));
    }


    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            $jenissatuan = JenisSatuan::create([
                'toko_id' => $this->actorService->toko()->id,
                'nama' => $request->nama,
            ]);

            if ($jenissatuan) {
                Alert::success('Success', 'Jenis Satuan berhasil ditambahkan!');
                return redirect()->route('satuan.index');
            } else {
                throw new \Exception('Gagal menyimpan jenis Satuan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan jenis satuan: ' . $e->getMessage())->withErrors(['Gagal menambahkan jenis satuan: ' . $e->getMessage()]);
        }
    }



    #[Post("editdata/{id}")]

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',

        ]);

        $jenissatuan = JenisSatuan::find($id);

        if (!$jenissatuan) {
            return redirect()->route('satuan.index')->withErrors(['Jenis Produk tidak ditemukan.']);
        }

        $jenissatuan->nama = $request->nama;


        $jenissatuan->save();

        Alert::success('Success', 'Jenis satuan berhasil diperbarui!');
        return redirect()->route('satuan.index');
    }


    #[Get("hapus/{id}")]
    public function hapus($id)
    {
        $jenissatuan = JenisSatuan::find($id);

        if (!$jenissatuan) {
            return Redirect::back()->withErrors(['Jenis Satuan tidak ditemukan.']);
        }



        // Hapus data produk dari database
        $jenissatuan->delete();

        Alert::success('Success', 'Jenis Satuan berhasil dihapus!');
        return redirect()->back();
    }
}
