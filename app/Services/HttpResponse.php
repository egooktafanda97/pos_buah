<?php

namespace App\Services;

use App\Constant\HttpStatus;

class HttpResponse
{
    private $resposes;

    public static function success($data = [])
    {
        return (new HttpResponse())->setResponse([
            "msg" => 'success',
            "data" => $data
        ]);
    }
    public function setResponse($resposes)
    {
        $this->resposes = $resposes;
        return $this;
    }

    public function code($status)
    {
        return response()->json($this->resposes, $status ?? HttpStatus::HTTP_OK);
    }
}
