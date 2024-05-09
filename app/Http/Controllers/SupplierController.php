<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

    #[Controllers()]
    #[Group(prefix: 'supplier')]

class SupplierController extends Controller
{
    #[Get("")]
    public function index()
    {
         $supplier = Supplier::all();
 
        return view('Page.Supplier.index',['supplier' => $supplier]);
    }
    
    
    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.Supplier.tambah');
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return redirect()->route('supplier.index')->withErrors(['Supplier tidak ditemukan.']);
        }
        return view('Page.Supplier.edit', compact('supplier'));
    }


    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat_supplier' => 'required|string|max:255',
            'nomor_telepon_supplier' => 'required|string|max:255',
        ]);
    
        try {
            $supplier = Supplier::create([
                'nama_supplier' => $request->nama_supplier,
                'alamat_supplier' => $request->alamat_supplier,
                'nomor_telepon_supplier' => $request->nomor_telepon_supplier,
            ]);
    
            if ($supplier) {
                Alert::success('Success', 'Supplier berhasil ditambahkan!');
                return redirect()->route('supplier.index');
            } else {
                throw new \Exception('Gagal menyimpan supplier.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan supplier: ' . $e->getMessage())->withErrors(['Gagal menambahkan supplier: ' . $e->getMessage()]);
        }
    }
    
    

    #[Post("editdata/{id}")]

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat_supplier' => 'required|string|max:255',
            'nomor_telepon_supplier' => 'required|string|max:255',
        ]);
    
        $supplier = Supplier::find($id);
    
        if (!$supplier) {
            return redirect()->route('supplier.index')->withErrors(['Supplier tidak ditemukan.']);
        }
    
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->alamat_supplier = $request->alamat_supplier;
        $supplier->nomor_telepon_supplier = $request->nomor_telepon_supplier;
    
        $supplier->save();
    
        Alert::success('Success', 'Supplier berhasil diperbarui!');
        return redirect()->route('supplier.index');
    }
    
    
    #[Get("hapus/{id}")]
    public function hapus($id)
        {
            $supplier = Supplier::find($id);

            if (!$supplier) {
                return Redirect::back()->withErrors(['Supplier tidak ditemukan.']);
            }

       

            // Hapus data produk dari database
            $supplier->delete();

            Alert::success('Success', 'Supplier berhasil dihapus!');
            return redirect()->back();
        }
    
    
}
