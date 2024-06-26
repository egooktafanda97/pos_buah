<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\JenisProduk;
use App\Models\Supplier;
use App\Models\Harga;
use App\Models\JenisSatuan;
use App\Models\Rak;
use App\Models\User;
use App\Services\ActorService;
use App\Services\ProdukService;
use App\Services\StatusService;
use App\Services\TrxService;
use App\Utils\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Resources;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'produk', middleware: [])]
class ProdukController extends Controller
{
    public function __construct(
        public ActorService $actorService
    ) {
    }

    #[Get("")]
    public function index()
    {
        $produk = Produk::with('harga', 'supplier', 'jenisProduk')->get();

        return view('Page.Produk.index', ['produk' => $produk]);
    }


    #[Get("tambah")]
    public function formtambah()
    {
        $rak = Rak::where('toko_id', $this->actorService->toko()->id)->get();
        $satuan_jual = JenisSatuan::where('toko_id', $this->actorService->toko()->id)->get();

        $jenisProduk = JenisProduk::all();
        $suppliers = Supplier::all();
        $hargas = Harga::all();
        return view('Page.Produk.tambah', compact('jenisProduk', 'suppliers', 'hargas', 'rak', 'satuan_jual'));
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $rak = Rak::where('toko_id', $this->actorService->toko()->id)->get();
        $satuan_jual = JenisSatuan::where('toko_id', $this->actorService->toko()->id)->get();

        $produk = Produk::find($id);
        if (!$produk) {
            return redirect()->back()->withErrors(['Produk tidak ditemukan.']);
        }
        $jenisProduk = JenisProduk::all();
        $suppliers = Supplier::all();
        $hargas = Harga::all();

        return view('Page.Produk.edit', compact('produk', 'jenisProduk', 'suppliers', 'hargas', 'rak', 'satuan_jual'));
    }


    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'supplier_id' => 'nullable|numeric|min:0',
            'jenis_produk_id' => 'required|numeric|min:0',
            'barcode' => 'nullable',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = [
                'toko_id' => $this->actorService->toko()->id,
                'user_id' => $this->actorService->authId(),
                'nama_produk' => $request->nama_produk,
                'jenis_produk_id' => $request->jenis_produk_id,
                'supplier_id' => $request->supplier_id,
                'barcode' => $request->barcode ?? '',
                'deskripsi' => $request->deskripsi,
                'rak_id' => $request->rak_id,
                'satuan_jual_terkecil_id' => $request->satuan_jual_terkecil_id,
                'status_id' => StatusService::Active,
            ];
            $uploaded = Helpers::Images($request, 'gambar', 'imgproduk');
            if ($uploaded->status) {
                $data['gambar'] = $uploaded->name;
            }
            $produk = Produk::create($data);
            if ($produk) {
                Alert::success('Success', 'Produk berhasil ditambahkan!');
                return redirect()->route('produk.index');
            } else {
                throw new \Exception('Gagal menyimpan produk.');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menambahkan produk: ' . $e->getMessage());
            return redirect()->route('produk.index');
        }
    }


    #[Post("editdata/{id}")]
    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'supplier_id' => 'nullable|numeric|min:0',
            'jenis_produk_id' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
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
        if (!empty($request->supplier_id))
            $produk->supplier_id = $request->supplier_id;
        $produk->jenis_produk_id = $request->jenis_produk_id;
        $produk->rak_id = $request->rak_id;
        $produk->satuan_jual_terkecil_id = $request->satuan_jual_terkecil_id;
        if (!empty($request->barcode))
            $produk->barcode = $request->barcode ?? '';
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
        $produk->delete();
        Alert::success('Success', 'Produk berhasil dihapus!');
        return redirect()->back();
    }

    #[Get('search/{search}')]
    #[RestController]
    public function getProduk(ProdukService $produkServiecs, Request $request, $search)
    {
        $produk = $produkServiecs->searchProduk($search);
        return response()->json($produk);
    }

    #[Post('priece')]
    #[RestController]
    public function getPriece(ProdukService $produkServiecs, Request $request)
    {
        $produk = $produkServiecs->getPriece($request);
        return response()->json($produk);
    }
}
