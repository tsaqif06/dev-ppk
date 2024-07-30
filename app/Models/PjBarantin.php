<?php

namespace App\Models;

use App\Models\MasterNegara;
use App\Models\MasterKotaKab;
use App\Models\MasterProvinsi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PjBarantin extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'create_at', 'updated_at'];
    protected $fillable = [
        'kode_perusahaan',
        'pre_register_id',
        'user_id',
        'password',
        'nama_perusahaan',
        'jenis_identitas',
        'nomor_identitas',
        'nitku',
        'alamat',
        'telepon',
        'nama_cp',
        'alamat_cp',
        'telepon_cp',
        'nama_alias_perusahaan',

        'kota',
        'provinsi_id',
        'negara_id',

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

        'status_import',
        'status',

        'is_active',
        'status_prioritas',
        'lingkup_aktifitas',

        'rerata_frekuensi',
        'daftar_komoditas',
        'tempat_karantina',
        'status_kepemilikan',
        'nomor_registrasi',
    ];


    public function register(): HasMany
    {
        return $this->hasMany(Register::class, 'id', 'pj_barantin_id');
    }
    public function preregister(): BelongsTo
    {
        return $this->belongsTo(PreRegister::class, 'pre_register_id', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function mitra(): HasMany
    {
        return $this->hasMany(MitraPerusahaan::class);
    }
    public function ppjk(): HasMany
    {
        return $this->hasMany(Ppjk::class);
    }
    public function pengajuanupdatepj(): HasMany
    {
        return $this->hasMany(PengajuanUpdatePj::class, 'pj_barantin_id', 'id');
    }
}
