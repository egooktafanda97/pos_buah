<?php

namespace App\Http\Controllers;

use App\Constant\HttpStatus;
use App\Models\ConfigToko;
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

    #[Get('init-trx')]
    #[RestController(middleware: ['auth:api'])]
    public function initTrx(Request $request)
    {
        try {
            $data = [
                "config" => ConfigToko::where('toko_id', $this->trxService->actorService->toko()->id)->get(),
            ];
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json([
                "msg" => 'tidak dapat melalukan init trx'
            ], 500);
        }
    }


    #[Get('total-order')]
    #[RestController(middleware: ['api:auth'])]
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

    #[Post('shop')]
    #[RestController(middleware: ['auth:api'])]
    public function trxProcessing(Request $request)
    {
        try {
            $required = collect([
                'items' => (array) $request->orders, // string json parsing,
                'pelanggan_id' => $request->pelanggan_id ?? $request->user->id ?? $request->user['id'] ?? null,
                'payment_type_id' => $request->payment_type_id ?? null,
                "total_bayar" => $request->total_pembayaran ?? 0,
                "diskon" => $request->diskon ?? 0,
                "pph" => $request->pph ?? 0,
            ])->toArray();

            // validasi items dan total_bayar
            if (empty($required['items']) || empty($required['total_bayar'])) {
                return HttpResponse::error('items dan total_bayar tidak boleh kosong')->code(HttpStatus::HTTP_BAD_REQUEST);
            }

            $trx = $this->trxService->initialize($required)->trxProccessing();
            return HttpResponse::success($trx)->code(HttpStatus::HTTP_OK);
        } catch (\Throwable $th) {
            return HttpResponse::error($th->getMessage())->code(HttpStatus::HTTP_BAD_REQUEST);
            //throw $th;
        }
    }

    // faktur
    #[Get('faktur/{invoice}')]
    public function faktur($invoice)
    {
        return view('Page.Trx.invoice', [
            'invoice' => $invoice,
            "trx" => $this->trxService->fackture($invoice)
        ]);
    }

    // history
    #[Get('history')]
    public function history()
    {
        return view('Page.Trx.history', [
            'trx' => $this->trxService->getList()
        ]);
    }

    // detail history
    #[Get('history/{invoice}')]
    public function detailHistory($invoice)
    {

        return view('Page.Trx.detail', [
            'trx' => $this->trxService->fackture($invoice),
            'items' => $this->trxService->fackture($invoice)->troli,
            "detail" => $this->trxService->detailDTO(collect($this->trxService->fackture($invoice))->toArray()),
            "items" => $this->trxService->ItemsDTO(collect($this->trxService->fackture($invoice))->toArray())
        ]);
    }

    // remove
    #[Get('remove/{invoice}')]
    public function remove($invoice)
    {
        try {
            $trx = $this->trxService->remove($invoice);
            return redirect()->route('trx.history');
        } catch (\Throwable $th) {
            return HttpResponse::error($th->getMessage())->code(HttpStatus::HTTP_BAD_REQUEST);
        }
    }
}
