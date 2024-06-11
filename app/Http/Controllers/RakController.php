<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Toko;
use Illuminate\Http\Request;
use App\Services\ActorService;
use RealRashid\SweetAlert\Facades\Alert;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;
use TaliumAttributes\Collection\Rutes\Put;

#[Controllers()]
#[Group(prefix: 'rak', middleware: ['auth'])]
class RakController extends Controller
{

    public function __construct(
        public ActorService $actorService
    ) {
    }


    // crud toko
    #[Get("")]
    public function index()
    {
        $rak = Rak::all();
        return view('Page.Rak.index', compact('rak'));
    }

    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.Rak.tambah');
    }

    #[Get("edit/{id}")]
    public function edit($id)
    {
        $rak = Rak::findOrFail($id);
        return view('Page.Rak.edit', compact('rak'));
    }

    #[Post("tambahdata")]
    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:0',
        ]);

        try {

            // Create a new Rak instance and save the data
            $rak = Rak::create([
                'toko_id' => Toko::where('user_id', auth()->user()->id)->first()->id,  // Corrected to get the id property of the Toko object
                'nomor' => $request->nomor,
                'nama' => $request->nama,
                'kapasitas' => $request->kapasitas,
            ]);

            // Check if the Rak instance was successfully created
            if ($rak) {
                Alert::success('Success', 'Rak berhasil ditambahkan!');
                return redirect()->route('rak.index');
            } else {
                throw new \Exception('Gagal menyimpan Rak.');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menambahkan Rak: ' . $e->getMessage());
            return redirect()->route('rak.index');
        }
    }


    #[Put("editdata/{id}")]

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:0',
        ]);

        try {
            $rak = Rak::findOrFail($id);
            $rak->nomor = $request->nomor;
            $rak->nama = $request->nama;
            $rak->kapasitas = $request->kapasitas;
            $rak->save();

            Alert::success('Success', 'Rak berhasil diperbarui!');
            return redirect()->route('rak.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal memperbarui Rak: ' . $e->getMessage());
            return redirect()->route('rak.index');
        }
    }

    #[Get("hapus/{id}")]
    public function destroy($id)
    {
        try {
            $rak = Rak::findOrFail($id);
            $rak->delete();

            Alert::success('Success', 'Rak berhasil dihapus!');
            return redirect()->route('rak.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus Rak: ' . $e->getMessage());
            return redirect()->route('rak.index');
        }
    }
}
