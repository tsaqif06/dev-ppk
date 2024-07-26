<?php

namespace Database\Seeders;

use App\Models\PjBaratanKpp;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PjBaratanKppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PjBaratanKpp::create([
            'kode_perusahaan' => '46MSJ01',
            'nama_perusahaan' => 'MANAT SIMANJUNTAK',
            'jenis_identitas' => 13,
            'npwp' => '',
            'nomor_identitas' => '2101072303740003',
            'alamat' => 'JL. INDUSTRI KP. MEKAR SARI RT/RW 004/001 TJ. UBAN TIMUR KEC. BINTAN UTARA',
            'kota' => 2102,
            'telepon' => '081364986293',
            'nama_cp' => 'MANAT SIMANJUNTAK',
            'alamat_cp' => 'JL. INDUSTRI KP. MEKAR SARI RT/RW 004/001 TJ. UBAN TIMUR KEC. BINTAN UTARA',
            'telepon_cp' => '081364986293',
            'nama_tdd' => 'MANAT SIMANJUNTAK',
            'jenis_identitas_tdd' => 13,
            'nomor_identitas_tdd' => '2101072303740003',
            'jabatan_tdd' => 'Pemilik',
            'alamat_tdd' => 'JL. INDUSTRI KP. MEKAR SARI RT/RW 004/001 TJ. UBAN TIMUR KEC. BINTAN UTARA',
            'nama_pendaftar' => '',
            'ktp_pendaftar' => '',
            'jenis_perusahaan' => 'PEMILIK_BARANG',
            'kontak_ppjk' => NULL,
            'email' => 'ridlonanda37@gmail.com',
            'fax' => 0,
            'kecamatan_id' => 2102050,
            'provinsi_id' => 21,
            'status_import' => 0,
            'status' => 'DISETUJUI',
            'upt_id' => 1,
            'is_password' => 1,
            'alasan' => NULL,
            'created_at' => '2023-11-01 15:31:59',
            'updated_at' => '2023-11-01 20:02:05',
            'negara_id' => 99,
            'a1' => 0,
            'a2' => 0,
            'a3' => 0,
            'a4' => 0,
            'is_active' => 1,
            'status_prioritas' => 1,
        ]);
    }
}
