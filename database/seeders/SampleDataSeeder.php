<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Investasi;
use App\Models\Sedekah;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 1; // Admin user ID

        // Get current month and previous month for 2025
        $currentMonth = Carbon::now()->month;
        $previousMonth = $currentMonth - 1;
        if ($previousMonth < 1) {
            $previousMonth = 12;
        }

        $currentYear = 2025;

        // Sample Transaksi Data - Current Month
        $transaksiData = [
            // Previous Month Data
            ['tanggal' => "2025-{$previousMonth}-05", 'kategori' => 'pendapatan', 'keterangan' => 'Gaji Bulanan', 'jumlah' => 5500000],
            ['tanggal' => "2025-{$previousMonth}-10", 'kategori' => 'pengeluaran', 'keterangan' => 'Belanja Bulanan', 'jumlah' => 1800000],
            ['tanggal' => "2025-{$previousMonth}-15", 'kategori' => 'pendapatan', 'keterangan' => 'Bonus Tahunan', 'jumlah' => 2000000],
            ['tanggal' => "2025-{$previousMonth}-20", 'kategori' => 'pengeluaran', 'keterangan' => 'Bayar Listrik', 'jumlah' => 450000],
            ['tanggal' => "2025-{$previousMonth}-25", 'kategori' => 'pendapatan', 'keterangan' => 'Freelance Project', 'jumlah' => 1500000],
            ['tanggal' => "2025-{$previousMonth}-28", 'kategori' => 'pengeluaran', 'keterangan' => 'Bayar Internet', 'jumlah' => 350000],

            // Current Month Data
            ['tanggal' => "2025-{$currentMonth}-01", 'kategori' => 'pendapatan', 'keterangan' => 'Gaji Bulanan', 'jumlah' => 5500000],
            ['tanggal' => "2025-{$currentMonth}-05", 'kategori' => 'pengeluaran', 'keterangan' => 'Belanja Bulanan', 'jumlah' => 1600000],
            ['tanggal' => "2025-{$currentMonth}-10", 'kategori' => 'pendapatan', 'keterangan' => 'Komisi Penjualan', 'jumlah' => 800000],
            ['tanggal' => "2025-{$currentMonth}-15", 'kategori' => 'pengeluaran', 'keterangan' => 'Bayar Listrik', 'jumlah' => 480000],
            ['tanggal' => "2025-{$currentMonth}-20", 'kategori' => 'pendapatan', 'keterangan' => 'Dividen Saham', 'jumlah' => 300000],
            ['tanggal' => "2025-{$currentMonth}-25", 'kategori' => 'pengeluaran', 'keterangan' => 'Bayar Internet', 'jumlah' => 350000],
        ];

        foreach ($transaksiData as $data) {
            Transaksi::create([
                'user_id' => $userId,
                'tanggal' => $data['tanggal'],
                'kategori' => $data['kategori'],
                'keterangan' => $data['keterangan'],
                'jumlah' => $data['jumlah']
            ]);
        }

        // Sample Investasi Data - Current Month
        $investasiData = [
            // Previous Month Data
            ['tanggal' => "2025-{$previousMonth}-03", 'jenis' => 'Saham', 'keterangan' => 'Beli Saham BBCA', 'jumlah' => 1200000],
            ['tanggal' => "2025-{$previousMonth}-12", 'jenis' => 'Reksadana', 'keterangan' => 'Investasi Reksadana Pasar Uang', 'jumlah' => 2500000],
            ['tanggal' => "2025-{$previousMonth}-18", 'jenis' => 'Emas', 'keterangan' => 'Beli Emas 5 gram', 'jumlah' => 3200000],
            ['tanggal' => "2025-{$previousMonth}-25", 'jenis' => 'Saham', 'keterangan' => 'Beli Saham TLKM', 'jumlah' => 1800000],

            // Current Month Data
            ['tanggal' => "2025-{$currentMonth}-02", 'jenis' => 'Saham', 'keterangan' => 'Beli Saham ASII', 'jumlah' => 1500000],
            ['tanggal' => "2025-{$currentMonth}-08", 'jenis' => 'Reksadana', 'keterangan' => 'Investasi Reksadana Saham', 'jumlah' => 3000000],
            ['tanggal' => "2025-{$currentMonth}-15", 'jenis' => 'Emas', 'keterangan' => 'Beli Emas 3 gram', 'jumlah' => 2000000],
            ['tanggal' => "2025-{$currentMonth}-22", 'jenis' => 'Saham', 'keterangan' => 'Beli Saham UNVR', 'jumlah' => 2200000],
        ];

        foreach ($investasiData as $data) {
            Investasi::create([
                'user_id' => $userId,
                'tanggal' => $data['tanggal'],
                'jenis' => $data['jenis'],
                'keterangan' => $data['keterangan'],
                'jumlah' => $data['jumlah']
            ]);
        }

        // Sample Sedekah Data - Current Month
        $sedekahData = [
            // Previous Month Data
            ['tanggal' => "2025-{$previousMonth}-02", 'penerima' => 'Masjid Al-Ikhlas', 'keterangan' => 'Sedekah Jumat', 'jumlah' => 120000],
            ['tanggal' => "2025-{$previousMonth}-10", 'penerima' => 'Panti Asuhan', 'keterangan' => 'Bantuan Anak Yatim', 'jumlah' => 600000],
            ['tanggal' => "2025-{$previousMonth}-18", 'penerima' => 'Masjid Al-Ikhlas', 'keterangan' => 'Sedekah Jumat', 'jumlah' => 120000],
            ['tanggal' => "2025-{$previousMonth}-25", 'penerima' => 'Korban Bencana', 'keterangan' => 'Bantuan Bencana Alam', 'jumlah' => 400000],

            // Current Month Data
            ['tanggal' => "2025-{$currentMonth}-01", 'penerima' => 'Masjid Al-Ikhlas', 'keterangan' => 'Sedekah Jumat', 'jumlah' => 120000],
            ['tanggal' => "2025-{$currentMonth}-08", 'penerima' => 'Panti Asuhan', 'keterangan' => 'Bantuan Anak Yatim', 'jumlah' => 550000],
            ['tanggal' => "2025-{$currentMonth}-15", 'penerima' => 'Masjid Al-Ikhlas', 'keterangan' => 'Sedekah Jumat', 'jumlah' => 120000],
            ['tanggal' => "2025-{$currentMonth}-22", 'penerima' => 'Yayasan Pendidikan', 'keterangan' => 'Beasiswa Siswa Berprestasi', 'jumlah' => 350000],
        ];

        foreach ($sedekahData as $data) {
            Sedekah::create([
                'user_id' => $userId,
                'tanggal' => $data['tanggal'],
                'penerima' => $data['penerima'],
                'keterangan' => $data['keterangan'],
                'jumlah' => $data['jumlah']
            ]);
        }
    }
}
