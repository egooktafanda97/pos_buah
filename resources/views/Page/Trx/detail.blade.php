@extends('Template.layout')
@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js.map"></script>
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        referrerpolicy="no-referrer" rel="stylesheet" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">History</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li aria-current="page" class="breadcrumb-item active">History Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <h2 class="text-lg font-bold">Deskripsi</h2>
                                </div>
                                <div>
                                    <button class="btn btn-secondary" x-data="{ invoice: `{{ $trx->invoice }}` }"
                                        x-on:click="(()=>{
                                            openPrintWindow(invoice);
                                    })()">
                                        <i class="fa fa-print"></i> PRINT
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example" style="width:100%">
                                    @foreach ($detail as $key => $item)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>:</td>
                                            <td>{{ $item }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-2">
                                <h2 class="text-lg font-bold">Items</h2>
                            </div>
                            <hr>
                            <table class="table table-striped table-bordered" id="example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                @php $i=1 @endphp
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item['Nama Produk'] }}</td>
                                        <td>{{ $item['Harga'] }}</td>
                                        <td>{{ $item['Jumlah'] }}</td>
                                        <td>{{ $item['Total'] }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function openPrintWindow($inv) {
            const printWindow = window.open(`{{ url('trx/faktur') }}/${$inv}`, 'PrintWindow', 'width=800,height=600');
            printWindow.focus();
        }
    </script>
@endpush
