<?php

namespace App\Http\Controllers;

use App\Contract\AttributesFeature\Attributes\Rules;
use App\Models\Kasir;
use App\Services\ActorService;
use App\Services\KasirService;
use App\Services\TokoService;
use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'kasir', middleware: [], name: "kasirs")]
class KasirController extends Controller
{
    public function __construct(
        public ActorService $actorService,
        public TokoService $tokoService,
        public KasirService $kasirService
    ) {
    }

    //crud
    #[Get("")]
    #[RestController]
    public function index()
    {

        $kasir = $this->kasirService->kasirRepository->all();
        return view('Page.Kasir.index', ['kasir' => $kasir]);
    }

    #[Get("tambah")]
    #[Rules('required')]
    public function create()
    {
        app('ioC')->index();
        return view('kasir.create', [
            "kasir" => Kasir::whereId("")->first()
        ]);
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $kasir = $this->kasirService->kasirRepository->find($id);
        if (!$kasir) {
            return redirect()->route('kasir.index')->withErrors(['Kasir tidak ditemukan.']);
        }
        return view('Page.Kasir.edit', compact('kasir'));
    }

    #[Post("tambahdata")]
    public function store(Request $request)
    {
        try {
            $kasir = $this->kasirService
                ->create([
                    'username' => $request->username ?? null,
                    'password' => $request->password ?? null,
                    'role' => 'kasir',
                    'nama' => $request->nama ?? null,
                    'alamat' => $request->alamat ?? null,
                    'telepon' => $request->telepon ?? null,
                ]);
            return redirect()->route('kasir.index')->with('success', 'Kasir berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->route('kasir.index')->withErrors(['Kasir gagal ditambahkan.']);
        }
    }

    #[Post("editdata/{id}")]
    public function update(Request $request, $id)
    {
        try {
            $kasir = $this->kasirService
                ->update($id, $request->all());
            return redirect()->route('kasir.index')->with('success', 'Kasir berhasil diubah.');
        } catch (\Throwable $th) {
            return redirect()->route('kasir.index')->withErrors(['Kasir gagal diubah.']);
        }
    }

    #[Post("hapus/{id}")]
    public function delete($id)
    {
        try {
            $kasir = $this->kasirService
                ->delete($id);
            return redirect()->route('kasir.index')->with('success', 'Kasir berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->route('kasir.index')->withErrors(['Kasir gagal dihapus.']);
        }
    }
}
