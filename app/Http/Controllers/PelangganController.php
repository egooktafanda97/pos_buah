<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Services\ActorService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'pelanggan', middleware: ['auth'])]

class PelangganController extends Controller
{
    public function __construct(
        public ActorService $actorService
    ) {
    }

    #[Get("")]
    public function index()
    {
        $pelanggan = Pelanggan::all();

        return view('Page.Pelanggan.index', ['pelanggan' => $pelanggan]);
    }


    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.Pelanggan.tambah');
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return redirect()->route('pelanggan.index')->withErrors(['Pelanggan tidak ditemukan.']);
        }
        return view('Page.Pelanggan.edit', compact('pelanggan'));
    }


    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string|max:255',
            'nomor_telepon_pelanggan' => 'required|string|max:255',
        ]);

        try {
            $pelanggan = Pelanggan::create([
                'toko_id' => $this->actorService->toko()->id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat_pelanggan' => $request->alamat_pelanggan,
                'nomor_telepon_pelanggan' => $request->nomor_telepon_pelanggan,
            ]);

            if ($pelanggan) {
                Alert::success('Success', 'Pelanggan berhasil ditambahkan!');
                return redirect()->route('pelanggan.index');
            } else {
                throw new \Exception('Gagal menyimpan pelanggan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan pelanggan: ' . $e->getMessage())->withErrors(['Gagal menambahkan pelanggan: ' . $e->getMessage()]);
        }
    }






    #[Post("editdata/{id}")]
    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string|max:255',
            'nomor_telepon_pelanggan' => 'required|string|max:255',
        ]);

        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return redirect()->route('pelanggan.index')->withErrors(['Pelanggan tidak ditemukan.']);
        }

        $pelanggan->nama_pelanggan = $request->nama_pelanggan;
        $pelanggan->alamat_pelanggan = $request->alamat_pelanggan;
        $pelanggan->nomor_telepon_pelanggan = $request->nomor_telepon_pelanggan;

        $pelanggan->save();

        Alert::success('Success', 'Pelanggan berhasil diperbarui!');
        return redirect()->route('pelanggan.index');
    }


    #[Get("hapus/{id}")]
    public function hapus($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return Redirect::back()->withErrors(['Pelanggan tidak ditemukan.']);
        }
        $pelanggan->delete();
        Alert::success('Success', 'Pelanggan berhasil dihapus!');
        return redirect()->back();
    }

    #[Get("search")]
    #[RestController(middleware: ['auth:api'])]
    public function search(Request $request)
    {
        $pelanggan = Pelanggan::where(function ($q) {
            $q->where('nama_pelanggan', 'like', '%' . request('search') . '%')
                ->orWhere('nomor_telepon_pelanggan', 'like', '%' . request('search') . '%');
        })
            ->take(3)
            ->get();
        return response()->json($pelanggan);
    }
}
