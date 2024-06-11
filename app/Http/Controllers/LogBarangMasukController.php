<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\JenisSatuan;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\JenisProduk;
use App\Models\LogBarangMasuk;
use App\Models\Supplier;
use App\Models\User;
use App\Services\ActorService;
use App\Services\BarangMasukService;
use App\Services\ProdukService;
use App\Services\TrxService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Resources;
use TaliumAttributes\Collection\Rutes\Delete;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'barangmasuk', middleware: [])]
class LogBarangMasukController extends Controller
{
    public function __construct(
        public ActorService $actorService,
        public BarangMasukService $barangMasukService
    ) {
    }

    #[Get("")]
    public function index()
    {
        $barangMasuks = LogBarangMasuk::with('produk', 'supplier', 'satuanBeli')
            ->orderby("id", "Desc")
            ->get();
        return view('Page.BarangMasuk.index', compact('barangMasuks'));
    }



    #[Get("tambah")]
    public function formtambah()
    {
        $produk = Produk::all();
        $suppliers = Supplier::all();
        $JenisSatuan = JenisSatuan::all();
        return view('Page.BarangMasuk.tambah', compact('produk', 'suppliers', 'JenisSatuan'));
    }

    #[Get("edit/{id}")]
    public function edit($id)
    {
        try {
            $barangMasuk = LogBarangMasuk::find($id);
            $produk = Produk::all();
            $suppliers = Supplier::all();
            $JenisSatuan = JenisSatuan::all();
            return view('Page.BarangMasuk.edit', compact('barangMasuk', 'produk', 'suppliers', 'JenisSatuan'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Produk tidak ditemukan: ' . $e->getMessage());
            return redirect()->route('barangmasuk.index');
        }
    }

    #[Post("tambahdata")]
    public function store(Request $request)
    {
        try {
            $this->barangMasukService->initialize([
                'produks_id' => $request->produks_id,
                'supplier_id' => $request->supplier_id ?? null,
                'harga_beli' => $request->harga_beli, // harnga satuan
                'satuan_beli_id' => $request->satuan_beli_id,
                'jumlah_barang_masuk' => $request->jumlah_barang_masuk
            ])->store();
            Alert::success('Success', 'Barang masuk berhasil ditambahkan!');
            return redirect('barangmasuk');
        } catch (\Exception $e) {
            Alert::error('Error', 'Produk tidak ditemukan: ' . $e->getMessage());
            return redirect('barangmasuk/tambah');
        }
    }

    // edit proccess
    #[Post("edit-proccess")]
    public function editProccess(Request $request)
    {
        try {
            $this->barangMasukService->initialize([
                'id' => $request->id,
                'produks_id' => $request->produks_id,
                'supplier_id' => $request->supplier_id ?? null,
                'harga_beli' => $request->harga_beli, // harnga satuan
                'satuan_beli_id' => $request->satuan_beli_id,
                'jumlah_barang_masuk' => $request->jumlah_barang_masuk
            ])->update();
            Alert::success('Success', 'Barang masuk berhasil diubah!');
            return redirect('barangmasuk');
        } catch (\Exception $e) {
            Alert::error('Error', 'Produk tidak ditemukan: ' . $e->getMessage());
            return redirect('barangmasuk/edit/' . $request->id);
        }
    }

    #[Post("delete-proccess/{id}")]
    public function destoryProccess($id)
    {
        try {
            $loging = LogBarangMasuk::find($id);
            $this->barangMasukService->initialize([
                'id' => $id,
                'produks_id' => $loging->produks_id,
                'supplier_id' => $loging->supplier_id ?? null,
                'harga_beli' => $loging->harga_beli, // harnga satuan
                'satuan_beli_id' => $loging->satuan_beli_id,
                'jumlah_barang_masuk' => $loging->jumlah_barang_masuk
            ])->logProccessDelete();
            Alert::success('Success', 'Barang masuk berhasil dihapus!');
            return redirect('barangmasuk');
        } catch (\Exception $e) {
            Alert::error('Error', 'Produk tidak ditemukan: ' . $e->getMessage());
            return redirect('barangmasuk');
        }
    }






    // #[Post("tambahdata")]
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'produks_id' => 'required|numeric|max:255',
    //         'supplier_id' => 'required|numeric|min:0',
    //         'harga_beli' => 'required|numeric|min:0',
    //         'satuan_beli_id' => 'required|integer|min:0',
    //         'jumlah_barang_masuk' => 'required|numeric|min:0',
    //         'jumlah_barang_keluar' => 'required|numeric|min:0'
    //     ]);

    //     try {
    //         $tokoId =  $this->actorService->toko()->id; // Assuming the user is associated with a toko
    //         $userId = auth()->user()->id;

    //         $produk = Produk::create([
    //             'toko_id' => $tokoId,
    //             'user_id' => $userId,
    //             'produks_id' => $request->produks_id,
    //             'supplier_id' => $request->supplier_id,
    //             'harga_beli' => $request->harga_beli,
    //             'satuan_beli_id' => $request->satuan_beli_id,
    //             'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
    //             'jumlah_barang_keluar' => $request->jumlah_barang_keluar,
    //         ]);

    //         if ($produk) {
    //             Alert::success('Success', 'Barang masuk berhasil ditambahkan!');
    //             return redirect()->route('barangmasuk.index');
    //         } else {
    //             throw new \Exception('Gagal menyimpan Barang masuk.');
    //         }
    //     } catch (\Exception $e) {
    //         Alert::error('Error', 'Gagal menambahkan produk: ' . $e->getMessage());
    //         return redirect()->route('barangmasuk.index');
    //     }
    // }

    // #[Post("editdata/{id}")]
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'produks_id' => 'required|numeric|max:255',
    //         'supplier_id' => 'required|numeric|min:0',
    //         'harga_beli' => 'required|numeric|min:0',
    //         'satuan_beli_id' => 'required|integer|min:0',
    //         'jumlah_barang_masuk' => 'required|numeric|min:0',
    //         'jumlah_barang_keluar' => 'required|numeric|min:0'
    //     ]);

    //     try {
    //         $barangMasuk = BarangMasuk::findOrFail($id);
    //         $barangMasuk->update([
    //             'produks_id' => $request->produks_id,
    //             'supplier_id' => $request->supplier_id,
    //             'harga_beli' => $request->harga_beli,
    //             'satuan_beli_id' => $request->satuan_beli_id,
    //             'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
    //             'jumlah_barang_keluar' => $request->jumlah_barang_keluar,
    //         ]);

    //         Alert::success('Success', 'Barang masuk berhasil diperbarui!');
    //         return redirect()->route('barangmasuk.index');
    //     } catch (\Exception $e) {
    //         Alert::error('Error', 'Gagal memperbarui Barang masuk: ' . $e->getMessage());
    //         return redirect()->route('barangmasuk.index');
    //     }
    // }


    #[Delete("destroy/{id}")]
    public function destroy($id)
    {
        try {
            $barangMasuk = BarangMasuk::findOrFail($id);

            if ($barangMasuk->delete()) {
                Alert::success('Success', 'Barang masuk berhasil dihapus!');
                return redirect()->route('barangmasuk.index');
            } else {
                throw new \Exception('Gagal menghapus Barang masuk.');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus Barang masuk: ' . $e->getMessage());
            return redirect()->route('barangmasuk.index');
        }
    }
}
