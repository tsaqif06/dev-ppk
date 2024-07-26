<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PjBaratanKpp extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_perusahaan',
        'nama_perusahaan',
        'jenis_identitas',
        'npwp',
        'nomor_identitas',
        'alamat',
        'kota',
        'telepon',
        'nama_cp',
        'alamat_cp',
        'telepon_cp',
        'nama_tdd',
        'jenis_identitas_tdd',
        'nomor_identitas_tdd',
        'jabatan_tdd',
        'alamat_tdd',
        'nama_pendaftar',
        'ktp_pendaftar',
        'jenis_perusahaan',
        'kontak_ppjk',
        'email',
        'fax',
        'kecamatan_id',
        'provinsi_id',
        'status_import',
        'status',
        'upt_id',
        'is_password',
        'alasan',
        'negara_id',
        'a1',
        'a2',
        'a3',
        'a4',
        'is_active',
        'status_prioritas',
    ];

}
