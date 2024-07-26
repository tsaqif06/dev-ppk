<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PreRegister;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perorangan = PreRegister::where('pemohon', 'perorangan')->where('email', 'nandaputraservice@outlook.co.id')->first();
        $induk = PreRegister::where('jenis_perusahaan', 'induk')->where('email', 'ridlo.pakis@outlook.co.id')->first();
        $cabang = PreRegister::where('jenis_perusahaan', 'cabang')->inRandomOrder()->first();

        $userPerorangan = User::create([
            'nama' => $perorangan->barantin->nama_perusahaan,
            'email' => $perorangan->barantin->email,
            'username' => 'perorangan',
            'role' => 'perorangan',
            'status_user' => 1,
            'password' => 12345678
        ]);
        $perorangan->barantin()->update(['user_id' => $userPerorangan->id]);

        $userInduk = User::create([
            'nama' => $induk->barantin->nama_perusahaan,
            'email' => $induk->barantin->email,
            'username' => 'induk',
            'role' => 'induk',
            'status_user' => 1,
            'password' => 12345678
        ]);
        $induk->barantin()->update(['user_id' => $userInduk->id]);

        $userCabang = User::create([
            'nama' => $cabang->barantin->nama_perusahaan,
            'email' => $cabang->barantin->email,
            'username' => 'cabang',
            'role' => 'cabang',
            'status_user' => 1,
            'password' => 12345678
        ]);
        $cabang->barantin()->update(['user_id' => $userCabang->id]);
    }
}
