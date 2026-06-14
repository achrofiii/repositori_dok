<?php

namespace App\Http\Controllers;

use App\Http\Requests\DokumenRequest;
use App\Models\Dokumen;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $filter = $request->query('filter', 'pribadi'); // default 'pribadi'

        if ($user->hasRole('admin')) {
            // Admin lihat semua dokumen yang sudah verified
            $dokumens = Dokumen::with(['kategori', 'fakultas', 'jurusan'])
                ->where('is_verified', true)
                ->latest()
                ->get();
        } elseif ($user->hasRole('dosen') && $filter === 'bimbingan') {
            // Dosen lihat dokumen mahasiswa bimbingannya
            $dokumens = Dokumen::with(['kategori', 'fakultas', 'jurusan', 'user', 'dosen'])
                ->where('dosen_id', $user->id)
                ->where('is_verified', true)
                ->latest()
                ->get();
        } else {
            // Dokumen pribadi dosen atau mahasiswa
            $dokumens = Dokumen::with(['kategori', 'fakultas', 'jurusan'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('dokumen.dokumen', compact('dokumens', 'filter'));
    }

    public function create()
    {
        $user = auth()->user();
        $isMahasiswa = $user->hasRole('mahasiswa');

        // Ambil detail mahasiswa untuk default fakultas & jurusan
        $detailMahasiswa = $isMahasiswa ? $user->detailMahasiswa : null;

        $data = [
            'dosens'             => User::role('dosen')->get(),
            'kategori'           => Kategori::all(),
            'fakultas'           => Fakultas::all(),
            'defaultFakultasId'  => $detailMahasiswa?->fakultas_id,
            'defaultJurusanId'   => $detailMahasiswa?->jurusan_id,
            'jurusanDefault'     => $detailMahasiswa?->fakultas_id
                ? Jurusan::where('fakultas_id', $detailMahasiswa->fakultas_id)->get()
                : collect(),
        ];

        return view('dokumen.tambahdokumen', $data);
    }

    public function store(DokumenRequest $request)
    {
        $tokenDokumen = Str::upper(Str::random(12));
        $thumbnailPath = null;
        $filePath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . '_' . uniqid() . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailFile->storeAs('dokumen/thumbnail', $thumbnailName, 'public');
        }

        if ($request->hasFile('file_dokumen')) {
            $dokumenFile = $request->file('file_dokumen');
            $dokumenName = time() . '_' . uniqid() . '.' . $dokumenFile->getClientOriginalExtension();
            $dokumenFile->storeAs('dokumen/file', $dokumenName, 'public');
        }

        $dosenId = auth()->user()->hasRole('mahasiswa') ? $request->dosen_id : null;

        try {
            Dokumen::create([
                'judul' => $request->judul,
                'abstrak' => $request->abstrak,
                'kata_kunci' => $request->kata_kunci,
                'tahun_publikasi' => $request->tahun_publikasi,
                'token_dokumen' => $tokenDokumen,
                'user_id' => auth()->id(),
                'thumbnail_path' => $thumbnailName,
                'file_path' => $dokumenName,
                'kategori_id' => $request->kategori,
                'fakultas_id' => $request->fakultas,
                'jurusan_id' => $request->jurusan,
                'dosen_id' => $dosenId,
                'is_verified' => false,
                'is_published' => false,
                'jumlah_diunduh' => 0,
            ]);

            return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil disimpan');
        } catch (\Exception $e) {
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()
                ->withErrors(['error' => 'Gagal menyimpan dokumen: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Dokumen $dokumen)
    {
        //
    }

    public function edit(Dokumen $dokumen)
    {
        $data = [
            'dokumen' => $dokumen,
            'dosens' => User::role('dosen')->get(),
            'kategori' => Kategori::all(),
            'fakultas' => Fakultas::all(),
            // untuk jurusan kita ambil sesuai fakultas dokumen ini
            'jurusanSelected' => Jurusan::where('fakultas_id', $dokumen->fakultas_id)->get(),
            'isMahasiswa' => auth()->user()->hasRole('mahasiswa'),
        ];

        return view('dokumen.dokumen-edit', $data);
    }

    public function update(DokumenRequest $request, Dokumen $dokumen)
    {
        Log::info('Sebelum update dokumen', ['dokumen_id' => $dokumen->id]);
        $thumbnailName = $dokumen->thumbnail_path;
        $dokumenName = $dokumen->file_path;

        // Cek dan simpan thumbnail baru jika diupload
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $newThumbnailName = time() . '_' . uniqid() . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailFile->storeAs('dokumen/thumbnail', $newThumbnailName, 'public');

            // Hapus thumbnail lama jika ada
            if ($thumbnailName && Storage::disk('public')->exists('dokumen/thumbnail/' . $thumbnailName)) {
                Storage::disk('public')->delete('dokumen/thumbnail/' . $thumbnailName);
            }

            $thumbnailName = $newThumbnailName;
        }

        // Cek dan simpan file dokumen baru jika diupload
        if ($request->hasFile('file_dokumen')) {
            $dokumenFile = $request->file('file_dokumen');
            $newDokumenName = time() . '_' . uniqid() . '.' . $dokumenFile->getClientOriginalExtension();
            $dokumenFile->storeAs('dokumen/file', $newDokumenName, 'public');

            // Hapus file lama jika ada
            if ($dokumenName && Storage::disk('public')->exists('dokumen/file/' . $dokumenName)) {
                Storage::disk('public')->delete('dokumen/file/' . $dokumenName);
            }

            $dokumenName = $newDokumenName;
        }

        // Tetapkan dosen_id jika user adalah mahasiswa
        $dosenId = auth()->user()->hasRole('mahasiswa') ? $request->dosen_id : null;

        // dd($request->all(), $dosenId, $dokumenName, $thumbnailName);
        try {
            $dokumen->update([
                'judul' => $request->judul,
                'abstrak' => $request->abstrak,
                'kata_kunci' => $request->kata_kunci,
                'tahun_publikasi' => $request->tahun_publikasi,
                'thumbnail_path' => $thumbnailName,
                'file_path' => $dokumenName,
                'kategori_id' => $request->kategori,
                'fakultas_id' => $request->fakultas,
                'jurusan_id' => $request->jurusan,
                'dosen_id' => $dosenId,
            ]);
            // Log::info('Data update:', [
            //     'request' => $request->all(),
            //     'dosen_id' => $dosenId,
            //     'dokumenName' => $dokumenName,
            //     'thumbnailName' => $thumbnailName,
            // ]);
            Log::info('Setelah update dokumen');
            return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Gagal memperbarui dokumen: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Dokumen $document)
    {
        if ($document->is_verified) {
            return back()->withErrors(['error' => 'Dokumen yang sudah diverifikasi tidak dapat dihapus.']);
        }

        try {
            // Hapus file dari storage jika ada
            if ($document->thumbnail_path && Storage::disk('public')->exists($document->thumbnail_path)) {
                Storage::disk('public')->delete($document->thumbnail_path);
            }

            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Hapus dari database
            $document->delete();

            return back()->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus dokumen: ' . $e->getMessage()]);
        }
    }

    public function getJurusan($fakultas_id)
    {
        $jurusan = Jurusan::where('fakultas_id', $fakultas_id)->get();
        return response()->json($jurusan);
    }

    public function unduh(Dokumen $dokumen)
    {
        $filePath = 'dokumen/file/' . $dokumen->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        // Kembalikan file download
        return Storage::disk('public')->download($filePath, $dokumen->file_path);
    }

    public function download(Dokumen $dokumen)
    {
        $filePath = 'dokumen/file/' . $dokumen->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        // Tambahkan jumlah unduhan
        $dokumen->increment('jumlah_diunduh');

        // Kembalikan file download
        return Storage::disk('public')->download($filePath, $dokumen->file_path);
    }
}
