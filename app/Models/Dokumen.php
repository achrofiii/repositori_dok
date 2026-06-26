<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Dokumen extends Model
{
    public function getRouteKey()
    {
        return Hashids::encode($this->getKey());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $decoded = Hashids::decode($value);
        if (empty($decoded)) {
            abort(404);
        }
        return $this->where('id', $decoded[0])->firstOrFail();
    }

    protected $table = 'dokumens';

    protected $fillable = [
        'token_dokumen',
        'judul',
        'abstrak',
        'kata_kunci',
        'tahun_publikasi',
        'file_path',
        'thumbnail_path',
        'user_id',
        'kategori_id',
        'fakultas_id',
        'jurusan_id',
        'dosen_id',
        'is_verified',
        'is_published',
        'jumlah_diunduh',
        'nilai_kelayakan',
        'status',
        'catatan_revisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
