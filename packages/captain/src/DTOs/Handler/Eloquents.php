<?php

namespace Captain\DTOs\Handler;


use CrudMaster\Attributes\Model;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

trait Eloquents
{
    public $Qresult;

    public function create(array $data)
    {
        $attributesInMethod = $this->class_attributes[Model::class] ?? throw new \Exception('Model attribute is required');
        $model = $attributesInMethod->model;

        return $model::create(collect($data)->toArray());
    }

    public function update(array $data, $id)
    {
        $attributesInMethod = $this->class_attributes[Model::class] ?? throw new \Exception('Model attribute is required');
        $model = $attributesInMethod->model;
        $model = $model::find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $Xmodels = $this->class_attributes[Model::class] ?? throw new \Exception('Model attribute is required');
        $model = $Xmodels->model;
        $model = $model::find($id);
        if (!empty($model))
            return $model::whereId($id)->delete();
        throw new \Exception("delete error");
    }

    public function getModels()
    {
        $attributesInMethod = $this->class_attributes[Model::class] ?? throw new \Exception('Model attribute is required');
        $model = $attributesInMethod->model;
        return $model;
    }

    public  function  fillable()
    {
        return $this->getProperty();
    }

    public function dbTransactions($func)
    {
        DB::beginTransaction();
        try {
            $results = $func();
            DB::commit();
            $this->Qresult = $results;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("error created " . $e->getMessage());
        }
        return $this;
    }

    public function getQresult()
    {
        return $this->Qresult;
    }

    public function showPaging($with = [], $perpage = 15)
    {
        return $this->getModels()::orderBy("id", "desc")->with($with)->paginate($perpage);
    }

    public function getById($id, $with = [])
    {
        return $this->getModels()::with($with)
            ->whereId($id)
            ->first();
    }

    public function getAll($with = [])
    {
        return $this->getModels()::with($with)
            ->get();
    }
}
