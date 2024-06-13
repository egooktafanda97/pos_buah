<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Models\LogBarangMasuk;
use App\Models\DetailTransaksi;



class LaporanController extends Controller
{
    public function laporanbarangmasuk(Request $request)
    {
        $query = LogBarangMasuk::with(['user', 'produk', 'supplier', 'satuanBeli', 'satuanStok', 'toko', 'status']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $logBarangMasuks = $query->get();

        return view('page.Laporan.barangmasuk', compact('logBarangMasuks'));
    }
    public function printbarangmasuk(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $logBarangMasuks = LogBarangMasuk::with(['user', 'produk', 'supplier', 'satuanBeli', 'satuanStok', 'toko', 'status'])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        return view('page.Laporan.printbarangmasuk', compact('logBarangMasuks', 'start_date', 'end_date'));
    }
    public function laporanbarangkeluar()
    {
        $detailTransaksis = DetailTransaksi::with(DetailTransaksi::withAll())->get();
        
        return view('page.Laporan.barangkeluar', compact('detailTransaksis'));
    }
}
