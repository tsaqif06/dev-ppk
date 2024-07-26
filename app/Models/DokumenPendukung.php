<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPendukung extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['pj_barantin_id', 'pre_register_id', 'jenis_dokumen', 'nomer_dokumen', 'tanggal_terbit', 'file', 'pengajuan_update_pj_id'];


}
