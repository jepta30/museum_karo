<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Komentar Pengunjung</title>
    <style>
        @page { margin: 140px 40px 40px 40px; }
        body { font-family: "Times New Roman", Times, serif; line-height: 1.5; }
        .header { position: fixed; top: -120px; left: 0; right: 0; height: 120px; text-align: center; }
        .header img { width: 100%; max-height: 120px; object-fit: contain; }
        .title { text-align: center; margin-top: 10px; margin-bottom: 20px; }
        .title h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        th, td { border: 1px solid black; padding: 6px; text-align: left; }
        th { font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/kop_surat.png') }}">
    </div>
    <div class="title">
        <h2>LAPORAN KOMENTAR PENGUNJUNG</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 20%">Nama</th>
                <th style="width: 15%">Email</th>
                <th style="width: 20%">Koleksi</th>
                <th style="width: 30%">Komentar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($komentars as $item)
            <tr>
                <td style="text-align: center">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->email ?? '-' }}</td>
                <td>{{ $item->koleksi->nama_sementara ?? '-' }}</td>
                <td>{{ $item->isi_komentar }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
