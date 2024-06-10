<?php

namespace App\Services;

use App\Models\Kasir;
use App\Models\Pelanggan;
use App\Models\Supplier;
use App\Models\Toko;
use App\Models\User;

class ActorService
{
    public function __construct(
        public User $user,
        public Toko $toko,
        public Kasir $kasir,
        public Supplier $supplier,
        public Pelanggan $pelanggan
    ) {
    }
    public function authId()
    {
        return auth()->user()->id ?? 1;
    }

    public function toko($tokoId = null)
    {
        $user = auth()->user();
        if (!empty($tokoId)) {
            return $this->toko->where('id', $tokoId)->with('user')->first();
        }

        if ($user?->hasRole("toko") ?? false) {
            return $this->toko->where('user_id', $user->id)->with('user')->first();
        }

        if ($user?->hasRole("kasir") ?? false) {
            $kasir = $this->kasir->where('user_id', $user->id)
                ->with('user', 'toko')
                ->first();
            return $kasir->toko ?? null;
        }


        return null;
    }

    public function kasir()
    {
        $user = auth()->user();

        if ($user->hasRole("kasir")) {
            return $this->kasir->where('user_id', $user->id)->with('user')->first();
        }

        return null;
    }

    public function supplier($supplier_id = null)
    {
        $supId = request()->supplier_id ?? $supplier_id ?? null;
        if ($supId) {
            return $this->supplier->where('id', $supId)
                ->first();
        }

        return null;
    }

    public function pelanggan($id)
    {
        $pelangganId = $this->pelanggan->where('id', $id)->first();
        return $pelangganId->id ?? null;
    }

    public function blok($id)
    {
        try {
            $actor = $this->user->find($id)->actor;
            $actor->status = 14;
            $actor->save();
            return $this->user->find($id)->actor;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
