<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class VerifikasiDokumenController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Admin: verifikasi dokumen milik dosen
            $dokumens = Dokumen::where('is_verified', false)
                ->whereHas('user', function ($query) {
                    $query->role('dosen');
                })
                ->with(['user', 'kategori', 'fakultas', 'jurusan'])
                ->get();
        } elseif ($user->hasRole('dosen')) {
            // Dosen: verifikasi dokumen mahasiswa bimbingan
            $dokumens = Dokumen::where('is_verified', false)
                ->where('dosen_id', $user->id)
                ->whereHas('user', function ($query) {
                    $query->role('mahasiswa');
                })
                ->with(['user', 'kategori', 'fakultas', 'jurusan'])
                ->get();
        } else {
            abort(403);
        }

        return view('verifikasi.verifikasi-view', compact('dokumens'));
    }

    // -----------------------------------------------------------------------
    // Admin: verifikasi dokumen dosen + simpan nilai_kelayakan
    // -----------------------------------------------------------------------
    public function verifyDosen(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        if (!$dokumen->user || !$dokumen->user->hasRole('dosen')) {
            return redirect()->back()->with('error', 'Dokumen ini bukan milik dosen.');
        }

        // Validasi nilai kelayakan jika diisi
        $request->validate([
            'nilai_kelayakan' => 'nullable|numeric|min:0|max:100',
        ]);

        $dokumen->is_verified      = true;
        $dokumen->is_published     = true;
        $dokumen->status           = 'diterima';
        $dokumen->catatan_revisi   = null;
        $dokumen->nilai_kelayakan  = $request->filled('nilai_kelayakan')
            ? $request->nilai_kelayakan
            : null;
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diverifikasi.');
    }

    // -----------------------------------------------------------------------
    // Dosen: verifikasi dokumen mahasiswa bimbingan + simpan nilai_kelayakan
    // -----------------------------------------------------------------------
    public function verifyMahasiswa(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $user    = auth()->user();

        if (!$dokumen->user || !$dokumen->user->hasRole('mahasiswa')) {
            return redirect()->back()->with('error', 'Dokumen ini bukan milik mahasiswa.');
        }

        if ($dokumen->dosen_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda bukan dosen pembimbing dokumen ini.');
        }

        // Validasi nilai kelayakan
        $request->validate([
            'nilai_kelayakan' => 'nullable|numeric|min:0|max:100',
        ]);

        $dokumen->is_verified      = true;
        $dokumen->is_published     = true;
        $dokumen->status           = 'diterima';
        $dokumen->catatan_revisi   = null;
        $dokumen->nilai_kelayakan  = $request->filled('nilai_kelayakan')
            ? $request->nilai_kelayakan
            : null;
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen mahasiswa berhasil diverifikasi.');
    }

    // -----------------------------------------------------------------------
    // Batalkan verifikasi (admin atau dosen)
    // -----------------------------------------------------------------------
    public function unverify($id)
    {
        $dokumen = Dokumen::with('user')->findOrFail($id);
        $user    = auth()->user();

        if ($user->hasRole('admin')) {
            $dokumen->is_verified = false;
            $dokumen->is_published = false;
            $dokumen->status = 'pending';
            $dokumen->save();
            return redirect()->back()->with('success', 'Verifikasi dokumen berhasil dibatalkan oleh admin.');
        }

        if ($user->hasRole('dosen') && $dokumen->user->hasRole('mahasiswa')) {
            $dokumen->is_verified = false;
            $dokumen->is_published = false;
            $dokumen->status = 'pending';
            $dokumen->save();
            return redirect()->back()->with('success', 'Verifikasi dokumen mahasiswa berhasil dibatalkan.');
        }

        abort(403, 'Anda tidak memiliki izin untuk membatalkan verifikasi dokumen ini.');
    }

    // -----------------------------------------------------------------------
    // Tolak dokumen
    // -----------------------------------------------------------------------
    public function tolak(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        $request->validate([
            'catatan_revisi' => 'nullable|string'
        ]);

        $dokumen->is_verified = false;
        $dokumen->is_published = false;
        $dokumen->status = 'ditolak';
        $dokumen->catatan_revisi = $request->catatan_revisi;
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen berhasil ditolak.');
    }

    // -----------------------------------------------------------------------
    // Minta revisi dokumen
    // -----------------------------------------------------------------------
    public function revisi(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        $request->validate([
            'catatan_revisi' => 'required|string'
        ]);

        $dokumen->is_verified = false;
        $dokumen->is_published = false;
        $dokumen->status = 'direvisi';
        $dokumen->catatan_revisi = $request->catatan_revisi;
        $dokumen->save();

        return redirect()->back()->with('success', 'Permintaan revisi berhasil dikirim.');
    }

    // -----------------------------------------------------------------------
    // Tampilkan detail dokumen
    // -----------------------------------------------------------------------
    public function show($id)
    {
        $dokumen = Dokumen::with('user')->findOrFail($id);
        $user    = auth()->user();

        if ($user->hasRole('admin')) {
            return view('verifikasi.verifikasi-detail', compact('dokumen'));
        }

        if ($user->hasRole('dosen')) {
            if ($dokumen->user_id === $user->id || optional($dokumen->user)->pembimbing_id === $user->id) {
                return view('verifikasi.verifikasi-detail', compact('dokumen'));
            }
            abort(403, 'Anda tidak memiliki izin untuk melihat dokumen ini.');
        }

        if ($user->hasRole('mahasiswa')) {
            if ($dokumen->user_id === $user->id) {
                return view('verifikasi.verifikasi-detail', compact('dokumen'));
            }
            abort(403, 'Anda tidak memiliki izin untuk melihat dokumen ini.');
        }

        abort(403, 'Akses ditolak.');
    }
}
