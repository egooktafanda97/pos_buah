<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;
use TaliumAttributes\Collection\Rutes\Middleware;
use App\Models\LogBarangMasuk;
use App\Models\Pelanggan;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;

#[Controllers()]
#[Group(prefix: 'home', middleware: ['role:SUPER-ADMIN'])]
class HomeController extends Controller
{
    #[Get("")]
    public function index()
    {
        $barangMasukCount = LogBarangMasuk::count();
        $pelangganCount = Pelanggan::count();
        
        $transaksiTodayCount = DetailTransaksi::whereDate('created_at', Carbon::today())->count();
    
        $pemasukanTodayCount = Transaksi::whereDate('tanggal', Carbon::today())
                                        ->sum('total_belanja');
    
        return view('Page.Dashboard.index', compact('barangMasukCount', 'pelangganCount', 'transaksiTodayCount', 'pemasukanTodayCount'));
    }
    
    #[Get("testpage")]
    public function testpage()
    {
        return view('Page.TestPage.index');
    }

    #[Get("get/{id}")]
    public function getId($id)
    {
    }

    #[Post("")]
    public function store(Request $request)
    {
    }

    #[Post("{id}")]
    public function update($id)
    {
    }

    #[Post("delete/{id}")]
    public function destory($id)
    {
    }

    // CHART
    public function totalpenjualanchart()
    {
        $data_penjualan = Transaksi::selectRaw('MONTH(created_at) as bulan, SUM(total_belanja) as total_bulan')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    $labels = [];
    $data = [];

    foreach ($data_penjualan as $item) {
        $labels[] = Carbon::createFromFormat('!m', $item->bulan)->format('M'); 
        $data[] = $item->total_bulan;
    }

    return response()->json([
        'labels' => $labels,
        'data' => $data,
    ]);
    }
    
}
