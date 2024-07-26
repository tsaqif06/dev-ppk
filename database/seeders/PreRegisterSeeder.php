<?php

namespace Database\Seeders;

use App\Models\PreRegister;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PreRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PreRegister::create([
            'pemohon' => 'perorangan',
            'nama' => 'ridlo nanda putra',
            'email' => 'funtechnongalam@gmail.com',
        ]);
    }
}
