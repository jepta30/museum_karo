<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Koleksi Museum</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; }
        th { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        Induk Inventaris Benda Koleksi Museum Pusaka Karo {{ date('Y') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Nomor<br>Koleksi</th>
                <th>Nama Koleksi</th>
                <th>Jenis Koleksi</th>
                <th>Nama<br>Penghibah<br>/Penitip</th>
                <th>Cara<br>Perolehan</th>
                <th>Tempat<br>Perolehan</th>
                <th>Tanggal<br>masuk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($koleksi as $item)
            <tr>
                <td>{{ $item->nomor_inventaris_final }}</td>
                <td>{{ $item->nama_sementara }}</td>
                <td>{{ $item->kategori->nama ?? '' }}</td>
                <td>{{ $item->nama_penyerah }}</td>
                <td>{{ $item->klaim_asal_usul ?? '-' }}</td>
                <td>{{ $item->alamat_penyerah }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('Y-m-d') }}</td>
                <td>{{ $item->kondisi_awal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
