<?php

namespace App\Services;

use App\Repositories\RakRepository;

class RakService
{
    public function __construct(public RakRepository $rakRepository)
    {
    }
    //crud
    public function all()
    {
        return $this->rakRepository->all();
    }
    public function store($data)
    {
        return $this->rakRepository->create($data);
    }
    public function update($data, $id)
    {
        return $this->rakRepository->update($data, $id);
    }
    public function destroy($id)
    {
        return $this->rakRepository->delete($id);
    }
}
