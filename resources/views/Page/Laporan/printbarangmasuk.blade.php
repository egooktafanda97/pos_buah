<!DOCTYPE html>
<html>

<head>
    <title>Laporan Barang Masuk</title>
    <style>
        @media print {

            /* CSS untuk mengatur tampilan saat dicetak */
            body {
                padding: 20px;
                font-family: Arial, sans-serif;
            }

            #table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
            }

            #table th,
            #table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            #table th {
                background-color: #f2f2f2;
            }
        }

        /* CSS tambahan untuk desain tabel */
        #table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
        }

        #table th,
        #table td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        #table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        #table td {
            text-align: left;
        }
    </style>
</head>

<body>
    <table class="table table-borderless text-center"
        style="border-width:0px!important; border:none; text-align:center; width:100%">
        <tbody>
            <tr>
                <td>
                    <h4>
                        LAPORAN BARANG MASUK DARI TANGGAL {{ $start_date }} SAMPAI {{ $end_date }}<br />
                        TOKO BUAH VIVI
                    </h4>
                    <p style="margin-left:0px; margin-right:0px">
                        Alamat: Taluk Kuantan, Kode Pos: 29295, No. Telp: 6692232
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <div
        style="background:#000000; cursor:text; height:4px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; width:100%">
        &nbsp;
    </div>

    <div style="background:#000000; cursor:text; height:2px; margin-top:2px; width:100%">
        &nbsp;
    </div>

    <table id="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Toko</th>
                <th>Produk</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Jumlah Barang Masuk</th>
                <th>Stok Sisa</th>
                <th>Satuan Beli</th>
                <th>Satuan Stok</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logBarangMasuks as $logBarangMasuk)
                <tr>
                    <td>{{ $logBarangMasuk->kode }}</td>
                    <td>{{ $logBarangMasuk->toko->nama }}</td>
                    <td>{{ $logBarangMasuk->produk->nama_produk }}</td>
                    <td>{{ $logBarangMasuk->supplier->nama_supplier }}</td>
                    <td>{{ $logBarangMasuk->harga_beli }}</td>
                    <td>{{ $logBarangMasuk->jumlah_barang_masuk }}</td>
                    <td>{{ $logBarangMasuk->stok_sisa }}</td>
                    <td>{{ $logBarangMasuk->satuanBeli->nama }}</td>
                    <td>{{ $logBarangMasuk->satuanStok->nama }}</td>
                    <td>{{ $logBarangMasuk->status->nama }}</td>
                    <td>{{ $logBarangMasuk->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>
