<?php

namespace CrudMaster\Trait;

use Illuminate\Http\Request;
use TaliumAttributes\Collection\Rutes\Get;

use function PHPUnit\Framework\returnSelf;

trait Queryes
{

    #[Get("/find/{id}")]
    public function find(Request $request, $id)
    {
        try {
            $isModel = $request->header("Q");
            $with = $request->header("with") ?? [];
            return $this->useModel($isModel)::whereId($id)->with($with)->first();
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function useModel($keys)
    {
        switch ($keys) {
            case 'employee':
                return \App\Models\Employees::class;
                break;

            default:
                # code...
                break;
        }
    }
}
