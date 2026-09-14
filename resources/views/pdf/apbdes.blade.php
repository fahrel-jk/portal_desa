<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan APBDes {{ $selectedYear }} — {{ $village->name }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 1cm 1.5cm;
            color: #000;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .kop-surat h1, .kop-surat h2, .kop-surat h3 {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }
        .kop-surat h1 { font-size: 12pt; font-weight: normal; }
        .kop-surat h2 { font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat p { margin: 3px 0 0 0; font-size: 9pt; }
        .judul-surat {
            text-align: center;
            margin: 15px 0 20px 0;
        }
        .judul-surat h3 {
            margin: 0;
            text-decoration: underline;
            font-size: 13pt;
        }
        .judul-surat p {
            margin: 3px 0 0 0;
            font-size: 10pt;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9pt;
        }
        table.data-table th,
        table.data-table td {
            border: 1px solid #333;
            padding: 4px 8px;
            vertical-align: top;
        }
        table.data-table th {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .kategori-header {
            background-color: #f0f0f0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }
        .total-row {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        .ringkasan {
            margin: 15px 0;
            page-break-inside: avoid;
        }
        .ringkasan table {
            border-collapse: collapse;
            width: 60%;
            margin: 0 auto;
        }
        .ringkasan table td {
            padding: 5px 10px;
            font-size: 10pt;
        }
        .ringkasan table td:last-child {
            text-align: right;
            font-family: "Courier New", monospace;
        }
        .tanda-tangan {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .ttd-box {
            width: 250px;
            float: right;
            text-align: center;
            font-size: 10pt;
        }
        .ttd-nama {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    {{-- Kop Surat --}}
    <div class="kop-surat">
        <h1>PEMERINTAH KABUPATEN {{ strtoupper($village->kabupaten) }}</h1>
        <h1>KECAMATAN {{ strtoupper($village->kecamatan) }}</h1>
        <h2>KANTOR KEPALA DESA {{ strtoupper($village->name) }}</h2>
        <p>{{ $village->address ?: 'Alamat Desa Belum Diatur' }}</p>
        <p>Telepon: {{ $village->contact_phone ?: '-' }} | Email: {{ $village->contact_email ?: '-' }}</p>
    </div>

    {{-- Judul --}}
    <div class="judul-surat">
        <h3>LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA DESA</h3>
        <p>TAHUN ANGGARAN {{ $selectedYear }}</p>
    </div>

    {{-- Ringkasan --}}
    <div class="ringkasan">
        <table>
            <tr>
                <td class="font-bold">Total Pendapatan</td>
                <td>Rp {{ number_format($totals['pendapatan']['anggaran'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Total Belanja</td>
                <td>Rp {{ number_format($totals['belanja']['anggaran'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Total Pembiayaan</td>
                <td>Rp {{ number_format($totals['pembiayaan']['anggaran'], 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 2px solid #000;">
                <td class="font-bold">Selisih (SiLPA)</td>
                <td class="font-bold">{{ $selisih >= 0 ? '' : '-' }}Rp {{ number_format(abs($selisih), 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- Tabel Rincian --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Uraian</th>
                <th style="width: 15%;">Bidang</th>
                <th style="width: 18%;">Anggaran (Rp)</th>
                <th style="width: 18%;">Realisasi (Rp)</th>
                <th style="width: 9%;">Capaian (%)</th>
                <th style="width: 5%;">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @php $currentKategori = ''; $no = 1; @endphp
            @foreach($anggarans as $item)
                @if($currentKategori !== $item->kategori)
                    @php $currentKategori = $item->kategori; @endphp
                    <tr class="kategori-header">
                        <td colspan="7">{{ strtoupper($item->kategori) }}</td>
                    </tr>
                @endif
                @php
                    $pct = $item->jumlah_anggaran > 0
                        ? round(($item->jumlah_realisasi / $item->jumlah_anggaran) * 100, 1)
                        : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $item->uraian }}</td>
                    <td>{{ $item->bidang ?? '-' }}</td>
                    <td class="text-right">{{ number_format($item->jumlah_anggaran, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->jumlah_realisasi, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $pct }}%</td>
                    <td>{{ $item->keterangan ? Str::limit($item->keterangan, 20) : '' }}</td>
                </tr>
            @endforeach

            {{-- Totals --}}
            <tr class="total-row">
                <td colspan="3" class="text-center">TOTAL KESELURUHAN</td>
                <td class="text-right">{{ number_format($totals['pendapatan']['anggaran'] + $totals['belanja']['anggaran'] + $totals['pembiayaan']['anggaran'], 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totals['pendapatan']['realisasi'] + $totals['belanja']['realisasi'] + $totals['pembiayaan']['realisasi'], 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="tanda-tangan">
        <div class="ttd-box">
            <p>{{ $village->name }}, {{ $tanggal }}</p>
            <p>Kepala Desa {{ $village->name }}</p>
            <div class="ttd-nama">KEPALA DESA</div>
        </div>
    </div>
</body>
</html>
