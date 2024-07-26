<?php

namespace Database\Seeders;

use App\Models\Register;
use App\Models\MasterUpt;
use App\Models\PjBarantin;
use App\Models\PreRegister;
use Faker\Factory as Faker;
use App\Models\MasterKotaKab;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PjBaratinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $pemohon = [
            'perusahaan',
            'perorangan'
        ];

        $emailUse = ['ridlo.pakis@outlook.co.id', 'nandaputraservice@outlook.co.id'];
        foreach (range(1, 50) as $index => $value) {
            // $provinsi_id = $faker->numberBetween(1, 34); // assuming 34 provinces in Indonesia
            DB::transaction(function () use ($faker, $pemohon, $index, $emailUse) {

                $jenis_pemohon = $index <= 1 ? ($index === 0 ? 'perusahaan' : 'perorangan') : $faker->randomElement($pemohon);
                $nama = $faker->name;
                $email = $index <= 1 ? $emailUse[$index] : $faker->unique()->safeEmail;
                $register = PreRegister::create([
                    'pemohon' => $jenis_pemohon,
                    'nama' => $nama,
                    'email' => $email,
                    'verify_email' => Carbon::now(),
                    'jenis_perusahaan' => $jenis_pemohon === 'perusahaan' ? ($index <= 1 ? 'induk' : $faker->randomElement(['induk', 'cabang'])) : null,
                ]);

                $baratin = PjBarantin::create([
                    'kode_perusahaan' => $faker->unique()->randomNumber(5),
                    'pre_register_id' => $register->id,
                    'password' => bcrypt('password'), // assuming password is always 'password'
                    'nama_perusahaan' => $faker->company,
                    'jenis_identitas' => $register->pemohon === 'perusahaan' ? 'NPWP' : $faker->randomElement(['KTP', 'NPWP', 'PASSPORT']),
                    'nomor_identitas' => $register->jenis_perusahaan === 'cabang' ? PjBarantin::inRandomOrder()->where('nitku', '000000')->value('nomor_identitas') ?? $faker->unique()->numerify('################') : $faker->unique()->numerify('################'),
                    'alamat' => $faker->address,
                    'telepon' => $faker->phoneNumber,
                    'nama_cp' => $faker->name,
                    'alamat_cp' => $faker->address,
                    'telepon_cp' => $faker->phoneNumber,
                    'nitku' => $register->jenis_perusahaan === 'induk' ? '000000' : $faker->unique()->randomNumber(6),
                    'kota' => 1101,
                    'provinsi_id' => 11,
                    'negara_id' => 99, // assuming flat 99 for country
                    'nama_tdd' => $faker->name,
                    'jenis_identitas_tdd' => $faker->randomElement(['KTP', 'NPWP', 'PASSPORT']),
                    'nomor_identitas_tdd' => $faker->unique()->numerify('################'),
                    'jabatan_tdd' => $faker->jobTitle,
                    'alamat_tdd' => $faker->address,
                    'nama_pendaftar' => $faker->name,
                    'ktp_pendaftar' => $faker->unique()->numerify('################'),
                    'jenis_perusahaan' => $faker->randomElement(['PEMILIK BARANG', 'PPJK', 'EMKL', 'EMKU', 'LAINNYA']),
                    'kontak_ppjk' => $faker->phoneNumber,
                    'email' => $register->email,
                    'fax' => $faker->phoneNumber,
                    'kecamatan_id' => $faker->numberBetween(1, 100), // assuming 100 kecamatan
                    'status_import' => $faker->randomElement([
                        25,
                        26,
                        27,
                        28,
                        29,
                        30,
                        31,
                        32,
                    ]),
                    'lingkup_aktifitas' => '1,2,3,4',
                    'is_active' => $faker->boolean,
                    'status_prioritas' => $faker->boolean,
                ]);

                Register::create([
                    'pj_barantin_id' => $baratin->id,
                    'master_upt_id' => 2100,
                    'status' => $faker->randomElement(['DISETUJUI', 'DITOLAK', 'MENUNGGU']),
                    'pre_register_id' => $register->id
                ]);
                if ($index == 1) {
                    $emailUse = null;
                }
            });
        }
    }
}
