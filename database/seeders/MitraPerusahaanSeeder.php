<?php

namespace Database\Seeders;

use App\Models\PreRegister;
use Faker\Factory as Faker;
use App\Models\MitraPerusahaan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MitraPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        /* INDUK MITRA  */
        foreach (range(1, 50) as $i) {
            $induk = PreRegister::where('jenis_perusahaan', 'induk')->inRandomOrder()->first();
            MitraPerusahaan::create([
                'pj_barantin_id' => $induk->barantin->id, // Sesuaikan dengan rentang ID yang sesuai
                'nama_mitra' => $faker->company,
                'jenis_identitas_mitra' => $faker->randomElement(['KTP', 'SIM', 'Passport']), // Sesuaikan dengan jenis identitas yang ada
                'nomor_identitas_mitra' => $faker->unique()->numerify('##########'), // Contoh nomor identitas acak
                'alamat_mitra' => $faker->address,
                'telepon_mitra' => $faker->phoneNumber,
                'master_negara_id' => $faker->numberBetween(1, 100), // Sesuaikan dengan rentang ID yang sesuai
                'master_provinsi_id' => $faker->numberBetween(1, 100), // Sesuaikan dengan rentang ID yang sesuai
                'master_kota_kab_id' => $faker->numberBetween(1, 100), // Sesuaikan dengan rentang ID yang sesuai
            ]);
        }

    }
}
