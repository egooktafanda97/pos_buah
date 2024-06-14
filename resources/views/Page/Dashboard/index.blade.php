@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Barang</p>
                                    <h4 class="my-1 text-info">{{ $barangMasukCount ?? 0 }}</h4>
                                    <p class="mb-0 font-13"></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                    <i class='bx bxs-package'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Pelanggan</p>
                                    <h4 class="my-1 text-danger">{{ $pelangganCount ?? 0 }}</h4>
                                    <p class="mb-0 font-13"></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                    <i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Terjual Hari Ini</p>
                                    <h4 class="my-1 text-success">{{ $transaksiTodayCount ?? 0 }}</h4>
                                    <p class="mb-0 font-13"></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                    <i class='bx bxs-bar-chart-alt-2'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Pemasukan Hari Ini</p>
                                    <h4 class="my-1 text-warning">{{ $pemasukanTodayCount }}</h4>
                                    <p class="mb-0 font-13"></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                    <i class='bx bxs-package'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Penjualan</h6>
                                </div>
                            </div>

                            <div class="chart-container-1">
                                <canvas id="salesChart"></canvas>
                            </div>

                            @if (!empty($dailySales))
                                <p>Total Penjualan Bulan Ini: Rp {{ number_format($totalPenjualanBulanan, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
@endsection
@push('script')
    <script>
        var dailySales = @json($dailySales);
        var labels = Object.keys(dailySales);
        var data = Object.values(dailySales);

        var ctx = document.getElementById('salesChart').getContext('2d');

        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: data,
                    borderColor: '#6078ea',
                    backgroundColor: 'rgba(96, 120, 234, 0.1)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#6078ea',
                    pointBorderColor: '#ffffff',
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#6078ea',
                    pointHoverBorderColor: '#ffffff',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    lineTension: 0.4
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Sales'
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Rp ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    }
                }
            }
        });
    </script>
@endpush
