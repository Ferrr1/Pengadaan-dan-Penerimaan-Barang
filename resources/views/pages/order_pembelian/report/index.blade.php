<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../../../public/assets/images/bx-package.svg" />
    <title>Laporan Permintaan Pembelian</title>
    <style>
        @page {
            margin: 0px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #888;
            margin-bottom: 5px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000000;
            padding: 4px;
            text-align: left;
        }

        .main-table th {
            background-color: #ffffff;
            text-align: center;
        }

        .total {
            font-weight: bold;
            text-align: center;
        }

        .header::after {
            content: "";
            border-bottom: #bababa 5px solid;
            display: block;
            bottom: 2;
            position: relative;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .sub-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .sub-title span {
            font-size: 14px;
            font-weight: normal;
            color: #888;
        }

        .sub-title-1 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 10px;
        }

        .report-title {
            text-align: center;
            font-weight: bolder;
            margin-bottom: 10px;
        }

        .ket-permintaan {
            font-size: 12px;
            width: 97%;
            padding: 10px;
            overflow: hidden;
            border: #000000 1px solid;
            margin-bottom: 20px;
        }

        .ket-permintaan-left {
            float: left;
            width: 65%;
        }

        .ket-permintaan-right {
            float: right;
            width: 35%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .info-table,
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 20px;
        }

        .info-table td,
        .signature-table td {
            border: none;
        }

        .signature-table .signature td {
            vertical-align: bottom;
            text-align: center;
        }

        .signature-middle td {
            height: 80px;
            font-size: 13px;
            vertical-align: bottom;
            text-align: center;
        }

        .signature-middle-copy td {
            height: 5px;
            font-size: 13px;
            vertical-align: bottom;
            text-align: center;
        }

        .signature-bottom td {
            font-size: 13px;
            vertical-align: bottom;
            text-align: center;
        }

        .signature-table .border-bottom {
            border-bottom: 1px solid #000;
        }

        .signature-line {
            position: relative;
        }

        .signature-line::after {
            content: '';
            position: absolute;
            left: 10%;
            right: 10%;
            bottom: 0;
            border-bottom: 1px solid #bababa;
        }

        .keterangan-cell {
            max-width: 200px;
            max-height: 2.4em;
            /* 2 baris dengan line-height 1.2 */
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.2em;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2 class="title">PT FATONI INDONESIA</h2>
        <p class="sub-title">Semen Indonesia <span>Group</span></p>
        <p class="sub-title-1">Your Reliable Partner in Construction</p>
    </div>
    <h3 class="report-title">ORDER PEMBELIAN</h3>
    <h2 class="report-title" style="font-size: 13px; margin-top: -10px">Nomor: {{ $orderPembelian->nomor_op }}</h2>
    <div class="ket-permintaan clearfix">
        <table class="ket-permintaan-left">
            <tr>
                <td>
                    <p>Kepada Yth.</p>
                    <p style="font-weight: bold">{{ $orderPembelian->rekanan->nama_rekanan }}
                        ({{ $orderPembelian->rekanan->kode_rekanan }})</p>
                    <p>{{ $orderPembelian->rekanan->alamat_rekanan }}</p>
                </td>
            </tr>
        </table>
        <table class="ket-permintaan-right">
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td>1</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($orderPembelian->tgl_op)->isoFormat('DD/MM/YYYY') }}</td>
            </tr>
            <tr>
                <td>Nomor PP</td>
                <td>:</td>
                <td>{{ $orderPembelian->permintaanPembelian->nomor_pp }}
                </td>
            </tr>
        </table>
    </div>
    <div class="ket-permintaan clearfix" style="margin-top: -15px; padding: 4px 10px">
        <table>
            <tr>
                <td>Unit</td>
                <td>:</td>
                <td>{{ $orderPembelian->permintaanPembelian->anggaran->project->kode_project }} ,
                    {{ $orderPembelian->permintaanPembelian->anggaran->project->nama_project }}
                </td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Kuantitas</th>
                <th>Harga Satuan</th>
                <th>Jumlah Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subOrderPembelians as $index => $subOP)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td style="text-align: center">
                        {{ $subOP->subPermintaanPembelian->produk->nama_produk }}</td>
                    <td style="text-align: center">
                        {{ $subOP->subPermintaanPembelian->produk->satuan->singkatan_satuan }}</td>
                    <td style="text-align: center">{{ $subOP->kuantitas_sub_order_pembelian }}</td>
                    <td style="text-align: center">{{ $subOP->subPermintaanPembelian->harga_sub_permintaan_pembelian }}
                    </td>
                    <td style="text-align: center">{{ formatRupiah($subOP->total_sub_order_pembelian) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data permintaan pembelian yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="padding: 10px; width: 50%;">Terbilang :
                    {{ Riskihajar\Terbilang\Facades\Terbilang::make($totalWithPPN) }}
                </td>
                <td colspan="2" style="padding: 10px; width: 50%;">
                    <p>Total Sebelum Pajak : {{ formatRupiah($total_jumlah_harga) }}</p>
                    <p>PPN {{ $subOP->ppn_sub_order_pembelian }}% :
                        {{ formatRupiah($ppn_jumlah_harga) }}</p>
                    <p>Total Akhir : {{ formatRupiah($totalWithPPN) }}</p>
                </td>
            </tr>
        </tfoot>
    </table>

    <table class="info-table ket-permintaan-bottom">
        <tr>
            <td style="width: 20%;">Material Dibutuhkan</td>
            <td style="width: 5%;">:</td>
            <td>{{ \Carbon\Carbon::parse($orderPembelian->tgl_op)->isoFormat('DD/MM/YYYY') }}</td>
        </tr>
        <tr>
            <td>Catatan</td>
            <td>:</td>
            <td>
                @forelse ($subOrderPembelians as $index => $subPP)
                    <p>{{ $subPP->catatan_sub_order_pembelian }}</p>
                @empty
                    <p>Tidak ada catatan</p>
                @endforelse
            </td>
        </tr>
    </table>

    <br><br>

    <table class="signature-table">
        <tr class="signature">
            <td style="width: 20%;"></td>
            <td style="width: 20%;">
                <p>
                    Menyetujui Supplier,</p>
                <p>{{ $orderPembelian->rekanan->nama_rekanan }}</p>
            </td>
            <td style="width: 20%;">
                <p>
                    Gresik, {{ \Carbon\Carbon::parse($orderPembelian->tgl_op)->isoFormat('D MMMM Y') }}
                </p>
                <p>PT FATONI INDONESIA</p>
            </td>
        </tr>
        <tr class="signature-middle">
            <td style="width: 20%;"></td>
            <td style="width: 20%;">{{ $orderPembelian->tandatangan_op[0]['tanda_tangan'] ?? 'XXXXXXXX' }}</td>
            <td style="width: 20%;">{{ $orderPembelian->tandatangan_op[1]['tanda_tangan'] ?? 'XXXXXXXX' }}</td>
        </tr>
        <tr class="signature-middle-copy">
            <td style="width: 20%;"></td>
            <td style="width: 20%;" class="signature-line"></td>
            <td style="width: 20%;" class="signature-line"></td>
        </tr>
        <tr class="signature-bottom">
            <td style="width: 20%;"></td>
            <td style="width: 20%;">{{ $orderPembelian->tandatangan_op[0]['posisi_jabatan'] ?? 'XXXXXXXX' }}</td>
            <td style="width: 20%;">{{ $orderPembelian->tandatangan_op[1]['posisi_jabatan'] ?? 'XXXXXXXX' }}</td>
        </tr>
    </table>
</body>

</html>
