<?php

namespace App\Http\Controllers;

use App\Constant\HttpStatus;
use App\Services\HttpResponse;
use App\Services\TrxService;
use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'trx', middleware: ['auth'])]
class TrxController extends Controller
{
    public function __construct(
        public TrxService $trxService
    ) {
    }

    #[Get('')]
    public function show()
    {
        return view('Page.Trx.index');
    }

    #[Get('total-order')]
    #[RestController]
    public function summary(Request $request)
    {
        try {
            $required = collect([
                'items' => (array) $request->items
            ])->toArray();
            return response()->json($this->trxService->initialize($required)->summary());
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => 'tidak dapat melalukan summary'
            ], 500);
        }
    }

    #[Get('shop')]
    #[RestController]
    public function trxProcessing(Request $request)
    {
        try {
            $required = collect([
                'items' => (array) $request->items, // string json parsing,
                'pelanggan_id' => $request->pelanggan ?? null,
                'payment_type_id' => $request->payment_type_id ?? null,
                "total_bayar" => $request->bayar ?? 0
            ])->toArray();
            $trx = $this->trxService->initialize($required)->trxProccessing();
            return HttpResponse::success($trx)->code(HttpStatus::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
