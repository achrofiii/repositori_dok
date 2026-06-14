<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Fakultas extends Model
{
    use HasFactory;

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

    protected $table = 'fakultas';

    protected $fillable = [
        'token_fakultas',
        'nama_fakultas',
        'kode_fakultas',
    ];

    public function getRouteKeyName()
    {
        return 'token_fakultas';
    }

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class);
    }
}
