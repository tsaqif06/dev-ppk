<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MitraPerusahaan extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'create_at', 'updated_at'];
    protected $fillable = [
        'pj_barantin_id',
        'nama_mitra',
        'jenis_identitas_mitra',
        'nomor_identitas_mitra',
        'alamat_mitra',
        'telepon_mitra',
        'master_negara_id',
        'master_provinsi_id',
        'master_kota_kab_id',
    ];

    public function barantin(): BelongsTo
    {
        return $this->belongsTo(PjBarantin::class, 'pj_barantin_id');
    }
}
