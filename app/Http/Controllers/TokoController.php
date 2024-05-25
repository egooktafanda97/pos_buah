<?php

namespace App\Http\Controllers;

use App\Services\ActorService;
use App\Services\TokoService;
use App\Services\UploadedService;
use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'toko', middleware: ['auth'])]
class TokoController extends Controller
{
    public function __construct(
        public ActorService $actorService,
        public TokoService $tokoService
    ) {
    }

    // crud toko
    #[Get("")]
    public function index()
    {
        $toko = $this->tokoService->tokoRepository->all();
        return view('Page.Toko.index', ['toko' => $toko]);
    }

    #[Get("tambah")]
    public function formtambah()
    {
        return view('Page.Toko.tambah');
    }

    #[Get("edit/{id}")]
    public function editForm($id)
    {
        $toko = $this->tokoService->tokoRepository->find($id);
        if (!$toko) {
            return redirect()->route('toko.index')->withErrors(['Toko tidak ditemukan.']);
        }
        return view('Page.Toko.edit', compact('toko'));
    }

    #[Post("tambahdata")]
    public function store(UploadedService $uploadedService, Request $request)
    {
        try {
            $toko = $this->tokoService
                ->create([
                    'username' => $request->username ?? null,
                    'password' => $request->password ?? null,
                    'role' => 'toko',
                    'nama' => $request->nama ?? null,
                    'alamat' => $request->alamat ?? null,
                    'telepon' => $request->telepon ?? null,
                    'logo' => $uploadedService->saveImage($request, 'logo', 'image/logo/')->name ?? null,
                    'deskripsi' => $request->deskripsi ?? null,
                ]);
            if (!$toko)
                throw new \Exception('Toko gagal ditambahkan.');
            return redirect()->route('toko.index')->with('success', 'Toko berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('toko.index')->withErrors(['Toko gagal ditambahkan.']);
        }
    }

    #[Post("editdata/{id}")]
    public function update(UploadedService $uploadedService, Request $request, $id)
    {
        try {
            $data = $request->all();
            unset($data['logo']);
            $logo =  $uploadedService->saveImage($request, 'logo', 'image/logo/')->name ?? false;
            $data = collect($data);
            if ($logo)
                $data = collect($data)->merge(['logo' => $logo]);
            $toko = $this->tokoService
                ->update($id, $data->toArray());
            if (!$toko)
                throw new \Exception('Toko gagal diubah.');
            return redirect()->route('toko.index')->with('success', 'Toko berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->route('toko.index')->withErrors(['Toko gagal diubah.']);
        }
    }

    #[Post("destory/{id}")]
    public function destroy($id)
    {
        try {
            $toko = $this->tokoService->delete($id);
            if (!$toko)
                throw new \Exception('Toko gagal dihapus.');
            return redirect()->route('toko.index')->with('success', 'Toko berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('toko.index')->withErrors(['Toko gagal dihapus.']);
        }
    }
}
