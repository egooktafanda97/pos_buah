<?php

namespace App\Http\Controllers;

use App\Services\ActorService;
use App\Services\TokoService;
use App\Models\Toko;
use Illuminate\Support\Facades\Log;
use App\Services\UploadedService;
use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Delete;
use TaliumAttributes\Collection\Rutes\Post;
use TaliumAttributes\Collection\Rutes\Put;

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

    #[Put("editdata/{id}")]
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

    #[Delete("destroy/{id}")]
    public function destroy($id)
    {
        try {
            // Attempt to find the Toko record
            $toko = Toko::findOrFail($id);
    
            // Attempt to find the associated User record
            $user = $toko->user;
    
            // Attempt to delete the Toko record
            $toko->delete();
    
            // Attempt to delete the associated User record if it exists
            if ($user) {
                $user->delete();
            }
    
            // Redirect back to the index with a success message
            return redirect()->route('toko.index')->with('success', 'Toko dan pengguna terkait berhasil dihapus.');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error deleting Toko or User:', ['message' => $e->getMessage()]);
    
            // Redirect back to the index with an error message
            return redirect()->route('toko.index')->withErrors(['Toko gagal dihapus: ' . $e->getMessage()]);
        }
    }
    

}
