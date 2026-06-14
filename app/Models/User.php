<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Vinkla\Hashids\Facades\Hashids;

class User extends Authenticatable
{
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

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'nip_nim',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Dokumen yang diunggah oleh user (mahasiswa/dosen)
    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    // Dokumen yang dibimbing oleh dosen (jika user adalah dosen)
    public function dokumenBimbingan()
    {
        return $this->hasMany(Dokumen::class, 'dosen_id');
    }

    // Detail profil mahasiswa
    public function detailMahasiswa()
    {
        return $this->hasOne(DetailMahasiswa::class);
    }

    // Detail profil dosen
    public function detailDosen()
    {
        return $this->hasOne(DetailDosen::class);
    }
}
