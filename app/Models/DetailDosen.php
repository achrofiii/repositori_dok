<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailDosen extends Model
{
    protected $fillable = [
        'user_id',
        'fakultas_id',
        'jurusan_id',
        'bidang_keahlian',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
