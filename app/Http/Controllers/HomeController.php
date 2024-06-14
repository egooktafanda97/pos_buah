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
        $p = Transaksi::selectRaw('sum(total_belanja) as total_belanja, created_at')
            ->whereMonth("created_at", Carbon::now()->month)
            ->whereYear("created_at", Carbon::now()->year)
            ->groupBy('created_at')
            ->get();
        return $p;

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
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $transactions = Transaksi::whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->get();

        $dailySales = [];
        $totalPenjualanBulanan = 0;

        if ($transactions->count() > 0) {
            foreach ($transactions as $transaction) {
                $day = date('d', strtotime($transaction->tanggal));

                if (!isset($dailySales[$day])) {
                    $dailySales[$day] = 0;
                }

                $dailySales[$day] += $transaction->total_belanja;
                $totalPenjualanBulanan += $transaction->total_belanja;
            }

            ksort($dailySales);
        }

        return view('Page.Dashboard.index', compact('dailySales', 'totalPenjualanBulanan'));
    }
}
