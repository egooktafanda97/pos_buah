<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Nette\Utils\Callback;

abstract class BaseRepository
{
    protected array $validated;

    public function __construct(
        public $model
    ) {
    }
    abstract public function fillable();

    abstract public function rule();

    public function getValidated()
    {
        return $this->validated;
    }

    public function validate(array $data)
    {
        try {
            $validation = Validator::make($data, $this->rule());
            if ($validation->fails()) {
                throw new \Exception($validation->errors()->first());
            }
            $this->validated = $validation->validated();
            return $this;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    //crud here
    public function create(array $data = [], $next = null)
    {
        try {
            if (count($data) == 0)
                $data = $this->validated;
            $created = $this->model->create($data);
            if ($next)
                $next($created);
            return $created;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function createOrUpdate($data = [])
    {
        try {
            if (empty($data['id']))
                return $this->model->create($this->validated);
            else
                return $this->model->whereId($data['id'])->update($data['data']);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $model = $this->model->find($id);
            $model->update($data);
            return $model;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $model = $this->model->find($id);
            $model->delete();
            return $model;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getWhere($where, $with = [])
    {
        return $this->model->where(function ($q) use (&$where) {
            return $where($q);
        })->with($with)
            ->orderBy('id', 'desc')
            ->get();
    }
    public function findWhere($obj)
    {
        return $this->model->where(function ($q) use (&$obj) {
            return $obj($q);
        })->first();
    }


    public function findWhereWith($where, $with = [])
    {
        return  $this->model->where(function ($q) use (&$where) {
            return $where($q);
        })->with($with)->first();
    }
}
