<?php

namespace App\Http\Controllers;

use App\Http\Requests\JurusanRequest;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Support\Str;

class JurusanController extends Controller
{
    // Show jurusan
    public function index()
    {
        $jurusans = Jurusan::with('fakultas')->get();
        $fakultas = Fakultas::all();
        return view('fakultas.jurusan.jurusan', compact('jurusans', 'fakultas'));
    }

    // Create jurusan
    public function store(JurusanRequest $request)
    {
        Jurusan::create([
            'token_jurusan' => Str::random(12),
            'nama_jurusan' => $request->nama_jurusan,
            'kode_jurusan' => $request->kode_jurusan,
            'fakultas_id' => $request->fakultas_id,
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    // Update jurusan
    public function update(JurusanRequest $request, Jurusan $jurusan)
    {
        $updated = $jurusan->update($request->validated());

        if ($updated) {
            return redirect()->back()->with('success', 'Fakultas berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Fakultas gagal diperbarui.');
        }
    }

    // Hapus jurusan
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->back()->with('delete_success', 'Jurusan berhasil dihapus.');
    }
}
