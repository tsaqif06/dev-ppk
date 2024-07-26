<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Register extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['pj_barantin_id', 'master_upt_id', 'status', 'pre_register_id', 'keterangan', 'blockir'];

    public function barantin(): BelongsTo
    {
        return $this->belongsTo(PjBarantin::class, 'pj_barantin_id', 'id');
    }
    public function preregister(): BelongsTo
    {
        return $this->belongsTo(PreRegister::class, 'pre_register_id', 'id');
    }
}
