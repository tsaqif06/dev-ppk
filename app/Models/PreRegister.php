<?php

namespace App\Models;

use App\Models\Register;
use App\Models\PjBarantin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreRegister extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'pemohon',
        'nama',
        'email',
        'verify_email',
        'jenis_perusahaan',
    ];

    public function barantin(): HasOne
    {
        return $this->hasOne(PjBarantin::class, 'pre_register_id');
    }
    public function register(): HasMany
    {
        return $this->hasMany(Register::class, 'pre_register_id', 'id');
    }
}
