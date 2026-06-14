<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show(string $role)
    {
        $user = Auth::user();

        // Cek apakah role yang diakses sesuai dengan role user
        if (!$user->hasRole($role)) {
            abort(403, 'Anda tidak memiliki akses ke dashboard ini.');
        }

        // Jika role sesuai, tampilkan dashboard untuk role tersebut
        $data = [];

        // Data berdasarkan role
        switch ($role) {
            case 'admin':
                $data = [
                    'totalDokumen'    => Dokumen::where('is_verified', 1)->count(),
                    'totalFakultas'   => Fakultas::count(),
                    'totalJurusan'    => Jurusan::count(),
                    'totalDosen'      => User::role('dosen')->count(),
                    'totalMahasiswa'  => User::role('mahasiswa')->count(),
                    'totalKategori'   => Kategori::count(),
                    'totalMenunggu'   => Dokumen::where('is_verified', 0)->count(),
                    'dokumenTerbaru'  => Dokumen::with(['user', 'kategori'])->latest()->take(5)->get(),
                ];
                break;

            case 'dosen':
                $data = [
                    'totalDokumenDiterima'    => Dokumen::where('dosen_id', $user->id)->where('is_verified', 1)->count(),
                    'totalDokumenDitolak'     => Dokumen::where('dosen_id', $user->id)->where('is_verified', 0)->count(),
                    'totalDokumenDipublikasi' => Dokumen::where('dosen_id', $user->id)->where('is_verified', 1)->where('is_published', 1)->count(),
                    'totalMahasiswaBimbingan' => Dokumen::where('dosen_id', $user->id)
                        ->whereHas('user', fn($q) => $q->role('mahasiswa'))
                        ->distinct('user_id')->count('user_id'),
                    'dokumenMenunggu'         => Dokumen::with(['user', 'kategori'])
                        ->where('dosen_id', $user->id)->where('is_verified', 0)->latest()->take(5)->get(),
                ];
                break;

            case 'mahasiswa':
                $data = [
                    'totalDokumen'            => Dokumen::where('user_id', $user->id)->count(),
                    'totalDokumenDiterima'    => Dokumen::where('user_id', $user->id)->where('is_verified', 1)->count(),
                    'totalDokumenDitolak'     => Dokumen::where('user_id', $user->id)->where('is_verified', 0)->count(),
                    'totalDokumenDipublikasi' => Dokumen::where('user_id', $user->id)->where('is_verified', 1)->where('is_published', 1)->count(),
                    'dokumenSaya'             => Dokumen::with(['kategori'])->where('user_id', $user->id)->latest()->take(5)->get(),
                ];
                break;

            default:
                abort(403, 'Role tidak dikenali.');
        }

        // Kirim role dan data ke view utama
        return view('dashboard.dashboard', array_merge(['role' => $role], $data));
    }
}
