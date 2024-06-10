<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            size: 3.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        #logo {
            width: 60%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            padding: 5px;
            margin: 2px;
            display: block;
            margin: 0 auto;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top: 1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {

            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }

        .total {
            font-size: 13px;
            border-top: 1px dashed black !important;
            border-bottom: 1px dashed black !important;
        }

        .total.text,
        .total.price {
            text-align: right;
        }

        .total.price::before {
            content: "\20B9";
        }

        .line {
            border-top: 1px solid black !important;
        }

        .heading.rate {
            width: 20%;
        }

        .heading.amount {
            width: 25%;
        }

        .heading.qty {
            width: 5%
        }

        p {
            padding: 1px;
            margin: 0;
        }

        section,
        footer {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <header>
        <div class="media" data-src="logo.png" id="logo" src="./logo.png"></div>
        {{-- nama toko --}}

    </header>
    <h3>{{ $trx->toko->nama ?? '' }}</h3>
    <p>Invoice : {{ $invoice }}</p>
    <p>Kasir : {{ $trx->kasir->nama ?? '' }}</p>
    <table class="bill-details">
        <tbody>
            <tr>
                <td>Date : <span>{{ \Carbon\Carbon::parse($trx->created_at ?? date('Y-m-d'))->format('Y-m-d') }}</span>
                </td>
                <td>Time : <span>{{ \Carbon\Carbon::parse($trx->created_at ?? date('Y-m-d'))->format('H:s:i') }}</span>
                </td>
            </tr>
            <tr>
                <td>Pelanggan #: <span>{{ $trx->pelanggan->nama_pelanggan ?? '' }}</span></td>
            </tr>
            <tr>
                <th class="center-align" colspan="2"><span class="receipt">Order</span></th>
            </tr>
        </tbody>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th class="heading name">Item</th>
                <th class="heading qty">Qty</th>
                <th class="heading rate">Rate</th>
                <th class="heading amount">Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($trx->troli as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk ?? '' }}</td>
                    <td>{{ $item->jumlah }} {{ $item->harga->jenisSatuan->nama ?? '' }}</td>
                    <td class="price">{{ 'Rp. ' . number_format($item->harga->harga) }}</td>
                    <td class="price">{{ 'Rp. ' . number_format($item->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="sum-up line" colspan="3">Subtotal</td>
                <td class="line price">{{ 'Rp. ' . number_format($trx->total_belanja) }}</td>
            </tr>
            <tr>
                <td class="sum-up" colspan="3">Diskon {{ $trx->diskon }} %</td>
                <td class="price">{{ 'Rp. ' . number_format($trx->sub_total_diskon) }}</td>
            </tr>
            <tr>
                <td class="sum-up" colspan="3">Pph {{ $trx->pph }} %</td>
                <td class="price">{{ 'Rp. ' . number_format($trx->sub_total_pph) }}</td>
            </tr>
            <tr>
                <th class="total text" colspan="3">Total</th>
                <th class="total price">{{ 'Rp. ' . number_format($trx->total_bayar) }}</th>
            </tr>

        </tbody>
    </table>
    <section>
        <p>
            Paid by : <span>CASH</span>
        </p>
        <p style="text-align:center">
            Terimakasih Telah Berbelanja
        </p>
    </section>
    <footer style="text-align:center">
        <p>{{ $trx->toko->nama }}</p>
        <p>www.{{ $trx->toko->nama }}.in</p>
    </footer>
    <script>
        window.print()
    </script>
</body>

</html>
