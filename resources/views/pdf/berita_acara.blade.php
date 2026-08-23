<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara - {{ $collection->nomor_inventaris_final }}</title>
    <style>
        @page {
            margin: 140px 40px 40px 40px; /* Top margin to accommodate fixed header */
        }
        body {
            font-family: "Times New Roman", Times, serif;
            line-height: 1.5;
        }
        .header {
            position: fixed;
            top: -120px; /* Place header inside the top margin */
            left: 0;
            right: 0;
            height: 120px;
            text-align: center;
        }
        .header img {
            width: 100%;
            max-height: 120px;
            object-fit: contain;
        }
        .title {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        .title h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .title p {
            margin: 5px 0;
            font-size: 14px;
        }
        .content {
            font-size: 14px;
            text-align: justify;
        }
        .content p {
            margin: 10px 0;
        }
        .details-table {
            width: 100%;
            margin-left: 20px;
            margin-bottom: 15px;
        }
        .details-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .details-table td:first-child {
            width: 150px;
        }
        .details-table td:nth-child(2) {
            width: 10px;
        }
        .signature-section {
            width: 100%;
            margin-top: 50px;
            text-align: center;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            margin-top: 20px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            height: 100px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/kop_surat.png') }}">
    </div>

    <div class="title">
        <h2>BERITA ACARA</h2>
        <h2>PENERIMAAN PEMINJAMAN KOLEKSI</h2>
        <p>Nomor: 027/YAPUKA/MPK/{{ \Carbon\Carbon::now()->format('m/Y') }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini <strong>{{ \Carbon\Carbon::now()->translatedFormat('l') }}</strong>, tanggal <strong>{{ \Carbon\Carbon::now()->translatedFormat('d') }}</strong>, bulan <strong>{{ \Carbon\Carbon::now()->translatedFormat('F') }}</strong>, tahun <strong>{{ \Carbon\Carbon::now()->translatedFormat('Y') }}</strong>, telah dilakukan penerimaan peminjaman koleksi, dengan diketahui oleh kedua belah pihak yang bertanda tangan di bawah ini:</p>
        
        <table class="details-table">
            <tr>
                <td>1. Nama</td>
                <td>:</td>
                <td><strong>{{ $collection->nama_penyerah }}</strong></td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $collection->tempat_lahir_penyerah ?: '-' }}, {{ $collection->tanggal_lahir_penyerah ? \Carbon\Carbon::parse($collection->tanggal_lahir_penyerah)->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $collection->pekerjaan_penyerah ?: '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $collection->alamat_penyerah ?: '-' }}</td>
            </tr>
        </table>
        
        <p>dengan ini bertindak untuk dan atas nama PEMILIK KOLEKSI/PEMBERI PINJAMAN koleksi yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>

        <table class="details-table">
            <tr>
                <td>2. Nama</td>
                <td>:</td>
                <td><strong>Tangsi Barus, S.Pd</strong></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>Ketua Yayasan Pusaka Karo</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>Jalan Perwira No. 3 Kelurahan Gundaling I, Kecamatan Berastagi, Kabupaten Karo</td>
            </tr>
        </table>

        <p>dengan ini bertindak untuk atas nama YAYASAN PUSAKA KARO/ PENERIMA PEMINJAMAN koleksi yang selanjutnya disebut <strong>PIHAK KEDUA</strong>.</p>

        <p>Kedua belah pihak telah melaksanakan:</p>
        <ol>
            <li>Pemeriksaan Kondisi Koleksi.</li>
            <li>Serah terima koleksi berupa <strong>{{ $collections->count() }} buah benda</strong> dengan kondisi sebagai berikut:
                <ol type="a">
                    @foreach($collections as $col)
                    <li>Sebuah <strong>{{ $col->nama_sementara }}</strong> (No.Inv. <strong>{{ $col->nomor_inventaris_final ?? $col->draf_nomor_inventaris ?? 'Belum ada NIK' }}</strong>) dengan kondisi: {{ $col->kondisi_awal }}. {{ $col->kondisi_kuratorial }}</li>
                    @endforeach
                </ol>
            </li>
        </ol>

        <p><strong>PIHAK PERTAMA</strong> menyerahkan koleksi-koleksi sebanyak tersebut diatas secara <strong>DIPINJAMKAN/DITITIPKAN</strong> kepada <strong>PIHAK KEDUA</strong> dengan batas waktu yang tidak terbatas. Kedua belah pihak telah memahami dan menyetujui bersama bahwa apabila sewaktu-waktu barang-barang tersebut diminta/ditarik kembali oleh PIHAK PERTAMA, maka PIHAK KEDUA bersedia mengembalikan semua benda koleksi tersebut diatas.</p>

        <p>Demikian Berita Acara ini dibuat dalam rangkap 2 (Dua) dan ditandatangan pada hari, tanggal, bulan, tahun tersebut diatas oleh kedua belah pihak dan didampingi oleh saksi-saksi untuk dapat dipergunakan sebagaimana semestinya.</p>
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>PIHAK KEDUA<br><br><br><br><br><strong>( Tangsi Barus S.Pd )</strong><br>Ketua Yayasan Pusaka Karo</td>
                <td>PIHAK PERTAMA<br><br><br><br><br><strong>( {{ $collection->nama_penyerah }} )</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; padding-top: 40px; font-weight: bold;">SAKSI-SAKSI:</td>
            </tr>
            <tr>
                <td><br><br><br><br><strong>( Kurator Museum Pusaka Karo )</strong></td>
                <td><br><br><br><br><strong>( Bendehara Yayasan Pusaka Karo )</strong></td>
            </tr>
        </table>
    </div>

</body>
</html>
