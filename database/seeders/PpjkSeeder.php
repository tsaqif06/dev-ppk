<?php

namespace Database\Seeders;

use App\Models\BarantinCabang;
use App\Models\Ppjk;
use App\Models\PjBarantin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PpjkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $pengguna = PjBarantin::all();
        // $cabang = BarantinCabang::all();
        foreach ($pengguna as $value) {
            Ppjk::create([
                'pj_barantin_id' => $value->id,
                'nama_ppjk' => $faker->name,
                'jenis_identitas_ppjk' => 'NPWP',
                'nomor_identitas_ppjk' => $faker->unique()->numerify('################'),
                'email_ppjk' => $faker->email,
                'tanggal_kerjasama_ppjk' => $faker->date(),
                'alamat_ppjk' => $faker->address,
                'master_negara_id' => 99,
                'master_provinsi_id' => 11,
                'master_kota_kab_id' => 1101,
                'nama_cp_ppjk' => $faker->name,
                'alamat_cp_ppjk' => $faker->address,
                'telepon_cp_ppjk' => $faker->phoneNumber,
                'nama_tdd_ppjk' => $faker->name,
                'jenis_identitas_tdd_ppjk' => 'KTP',
                'nomor_identitas_tdd_ppjk' => $faker->numerify('################'),
                'jabatan_tdd_ppjk' => 'Manager',
                'alamat_tdd_ppjk' => $faker->address,
            ]);
        }
    }
}
