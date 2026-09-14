<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Hasil Layanan - {{ $pengajuan->kode_tracking }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 1cm 2cm;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h1, .kop-surat h2, .kop-surat h3 {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }
        .kop-surat h1 { font-size: 14pt; font-weight: normal; }
        .kop-surat h2 { font-size: 18pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 11pt; }
        .judul-surat {
            text-align: center;
            margin-bottom: 30px;
        }
        .judul-surat h3 {
            margin: 0;
            text-decoration: underline;
            font-size: 14pt;
        }
        .judul-surat p {
            margin: 0;
        }
        .isi-surat {
            text-align: justify;
        }
        .table-data {
            margin: 15px 0 15px 30px;
        }
        .table-data td {
            vertical-align: top;
            padding-bottom: 5px;
        }
        .table-data td:first-child {
            width: 150px;
        }
        .table-data td:nth-child(2) {
            width: 20px;
        }
        .tanda-tangan {
            width: 100%;
            margin-top: 50px;
        }
        .ttd-box {
            width: 300px;
            float: right;
            text-align: center;
        }
        .ttd-nama {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>PEMERINTAH KABUPATEN {{ strtoupper($desa->kabupaten) }}</h1>
        <h1>KECAMATAN {{ strtoupper($desa->kecamatan) }}</h1>
        <h2>KANTOR KEPALA DESA {{ strtoupper($desa->name) }}</h2>
        <p>{{ $desa->address ?: 'Alamat Desa Belum Diatur' }}</p>
        <p>Telepon: {{ $desa->contact_phone ?: '-' }} | Email: {{ $desa->contact_email ?: '-' }}</p>
    </div>

    <div class="judul-surat">
        <h3>SURAT KETERANGAN {{ strtoupper($layanan->name) }}</h3>
        <p>Nomor: {{ $nomor_surat }}</p>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa {{ $desa->name }}, Kecamatan {{ $desa->kecamatan }}, Kabupaten {{ $desa->kabupaten }}, menerangkan dengan sebenarnya bahwa:</p>

        <table class="table-data">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ strtoupper($data_pemohon['nama'] ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td>N I K</td>
                <td>:</td>
                <td>{{ $data_pemohon['nik'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $data_pemohon['alamat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $data_pemohon['keperluan'] ?? '-' }}</td>
            </tr>
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga kami dan surat keterangan ini dibuat untuk keperluan sebagaimana disebutkan di atas.</p>
        <p>Demikian surat keterangan ini kami buat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="tanda-tangan">
        <div class="ttd-box">
            <p>{{ $desa->name }}, {{ $tanggal }}</p>
            <p>Kepala Desa {{ $desa->name }}</p>
            <div class="ttd-nama">KEPALA DESA</div>
        </div>
    </div>
</body>
</html>
