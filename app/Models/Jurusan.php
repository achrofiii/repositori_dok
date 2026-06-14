<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';
    public function getRouteKey()
    {
        return Hashids::encode($this->getKey()); // encode id asli ke URL
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $decoded = Hashids::decode($value);
        if (empty($decoded)) {
            abort(404); // tidak bisa decode, return 404
        }

        return $this->where('id', $decoded[0])->firstOrFail();
    }

    protected $fillable = [
        'token_jurusan', 'nama_jurusan', 'kode_jurusan', 'fakultas_id'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
}
