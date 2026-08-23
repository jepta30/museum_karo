<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Koleksi;
use App\Models\Kategori;

class KoleksiMockSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::first();
        $katId = $kategori ? $kategori->id : 1;

        // Create 8 items waiting for approval
        $items = [
            [
                'nama_sementara' => 'Piso Surit',
                'nama_penyerah' => 'Bpk. Tarigan (Kurator)',
                'tanggal_terima' => now()->subDays(2),
                'kondisi_awal' => 'Kondisi baik, sedikit karat di bilah.',
                'path_foto' => 'koleksi_photos/mock1.png',
                'sejarah_asal_usul' => 'Ditemukan di daerah Berastagi.',
                'draf_nomor_inventaris' => 'INV-2023-10-8821',
            ],
            [
                'nama_sementara' => 'Kain Uis Nipes (Restorasi)',
                'nama_penyerah' => 'Ibu Ginting (Konservasi)',
                'tanggal_terima' => now()->subDays(5),
                'kondisi_awal' => 'Ada robekan kecil di ujung.',
                'path_foto' => 'koleksi_photos/mock2.png',
                'sejarah_asal_usul' => 'Warisan keluarga Ginting dari Kabanjahe.',
                'draf_nomor_inventaris' => 'INV-2023-10-8822',
            ],
            [
                'nama_sementara' => 'Koleksi Patung Kayu Pangulubalang',
                'nama_penyerah' => 'Sdr. Sembiring (Registrar)',
                'tanggal_terima' => now()->subDays(10),
                'kondisi_awal' => 'Kayu mulai keropos di dasar.',
                'path_foto' => 'koleksi_photos/mock3.png',
                'sejarah_asal_usul' => 'Patung penolak bala dari desa Barusjahe.',
                'draf_nomor_inventaris' => 'INV-2023-10-8823',
            ],
            [
                'nama_sementara' => 'Tumbuk Lada Emas',
                'nama_penyerah' => 'Hamba Budaya',
                'tanggal_terima' => now()->subDays(12),
                'kondisi_awal' => 'Sangat baik.',
                'path_foto' => 'koleksi_photos/mock4.png',
                'sejarah_asal_usul' => 'Senjata pusaka keturunan raja Karo.',
                'draf_nomor_inventaris' => 'INV-2023-10-8824',
            ],
            [
                'nama_sementara' => 'Pustaka Laklak',
                'nama_penyerah' => 'Anonim',
                'tanggal_terima' => now()->subDays(15),
                'kondisi_awal' => 'Kertas kulit kayu rapuh.',
                'path_foto' => 'koleksi_photos/mock5.png',
                'sejarah_asal_usul' => 'Buku mantra kuno beraksara Karo.',
                'draf_nomor_inventaris' => 'INV-2023-10-8825',
            ],
            [
                'nama_sementara' => 'Gundala-Gundala',
                'nama_penyerah' => 'Sanggar Seni Karo',
                'tanggal_terima' => now()->subDays(18),
                'kondisi_awal' => 'Topeng butuh pengecatan ulang.',
                'path_foto' => 'koleksi_photos/mock6.png',
                'sejarah_asal_usul' => 'Topeng tradisional pemanggil hujan.',
                'draf_nomor_inventaris' => 'INV-2023-10-8826',
            ],
            [
                'nama_sementara' => 'Perhiasan Padung-Padung',
                'nama_penyerah' => 'Keluarga Perangin-angin',
                'tanggal_terima' => now()->subDays(20),
                'kondisi_awal' => 'Lengkap sepasang.',
                'path_foto' => 'koleksi_photos/mock7.png',
                'sejarah_asal_usul' => 'Anting perak khas wanita Karo zaman dahulu.',
                'draf_nomor_inventaris' => 'INV-2023-10-8827',
            ],
            [
                'nama_sementara' => 'Alat Musik Keteng-Keteng',
                'nama_penyerah' => 'Bpk. Sitepu',
                'tanggal_terima' => now()->subDays(22),
                'kondisi_awal' => 'Bambu masih kokoh.',
                'path_foto' => 'koleksi_photos/mock8.png',
                'sejarah_asal_usul' => 'Alat musik perkusi bambu tradisional.',
                'draf_nomor_inventaris' => 'INV-2023-10-8828',
            ]
        ];

        foreach ($items as $item) {
            Koleksi::create(array_merge($item, [
                'status' => 'menunggu_persetujuan',
                'kategori_id' => $katId
            ]));
        }
    }
}
