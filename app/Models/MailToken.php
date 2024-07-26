<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailToken extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'token',
        'expire_at_token'
    ];
    protected $fillable = [
        'pre_register_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $key = env('MAIL_SECRET', 'B4r4t1N'); // Ganti dengan kata kunci rahasia Anda
            $data = Str::random(40); // String acak panjang 40 karakter
            $model->token = hash_hmac('sha256', $data, $key);
            $model->expire_at_token = now()->addMinutes(30); // Token kedaluwarsa dalam 30 menit
        });
    }


}
