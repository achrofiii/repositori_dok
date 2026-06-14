<?php

namespace App\Http\Controllers\landingpage;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();

        // =====================================================================
        // SPK PROMETHEE II — Ranking Kategori Terpopuler untuk Landing Page
        // =====================================================================
        $matriks = [];

        foreach ($kategoris as $kategori) {
            $totalDokumen = Dokumen::where('kategori_id', $kategori->id)->count();

            $c1 = Dokumen::where('kategori_id', $kategori->id)
                ->where('is_verified', true)->count();

            $c2 = (int) Dokumen::where('kategori_id', $kategori->id)
                ->sum('jumlah_diunduh');

            $c3 = $totalDokumen > 0
                ? round(($c1 / $totalDokumen) * 100, 2) : 0.00;

            $c4Raw = Dokumen::where('kategori_id', $kategori->id)
                ->where('is_verified', true)
                ->whereNotNull('nilai_kelayakan')
                ->avg('nilai_kelayakan');

            $c4 = ($c4Raw === null) ? 75.00 : round((float) $c4Raw, 2);

            $matriks[$kategori->id] = [
                'id'            => $kategori->id,
                'nama_kategori' => $kategori->nama_kategori,
                'C1'            => $c1,
                'C2'            => $c2,
                'C3'            => $c3,
                'C4'            => $c4,
            ];
        }

        $bobot       = ['C1' => 0.25, 'C2' => 0.25, 'C3' => 0.20, 'C4' => 0.30];
        $kriterias   = ['C1', 'C2', 'C3', 'C4'];
        $ids         = array_keys($matriks);
        $n           = count($ids);

        $pi = [];
        foreach ($ids as $a) {
            foreach ($ids as $b) {
                if ($a === $b) {
                    $pi[$a][$b] = 0;
                    continue;
                }
                $piAB = 0;
                foreach ($kriterias as $k) {
                    $d     = $matriks[$a][$k] - $matriks[$b][$k];
                    $piAB += $bobot[$k] * ($d > 0 ? 1 : 0);
                }
                $pi[$a][$b] = round($piAB, 4);
            }
        }

        $hasilSpk = [];
        foreach ($ids as $a) {
            $leaving = $entering = 0;
            foreach ($ids as $x) {
                $leaving  += $pi[$a][$x];
                $entering += $pi[$x][$a];
            }
            $leaving  = ($n > 1) ? round($leaving  / ($n - 1), 4) : 0;
            $entering = ($n > 1) ? round($entering / ($n - 1), 4) : 0;
            $netFlow  = round($leaving - $entering, 4);

            $hasilSpk[$a] = array_merge($matriks[$a], [
                'leaving_flow'  => $leaving,
                'entering_flow' => $entering,
                'net_flow'      => $netFlow,
            ]);
        }

        usort($hasilSpk, fn($a, $b) => $b['net_flow'] <=> $a['net_flow']);
        foreach ($hasilSpk as $i => &$item) {
            $item['rangking'] = $i + 1;
        }
        unset($item);

        return view('landing.home', compact('kategoris', 'hasilSpk'));
    }

    public function document(Request $request)
    {
        $kategoris = Kategori::all();

        $dokumen = Dokumen::where('is_published', true)
            ->when($request->kategori_id, function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('landing.documents', compact('dokumen', 'kategoris'));
    }

    public function search(Request $request)
    {
        $search_type = $request->input('search_type', 'judul'); // Default ke 'judul' jika tidak ada
        $judul_query = $request->input('judul_query');
        $abstrak_query = $request->input('abstrak_query');
        $kategori_id = $request->input('kategori_id');

        $dokumen = Dokumen::with('kategori'); // Eager load relasi kategori

        // Terapkan kondisi pencarian berdasarkan search_type yang aktif
        if ($search_type == 'judul' && !empty($judul_query)) {
            $dokumen->where('judul', 'like', '%' . $judul_query . '%');
        } elseif ($search_type == 'abstrak' && !empty($abstrak_query)) {
            $dokumen->where('abstrak', 'like', '%' . $abstrak_query . '%');
        } elseif ($search_type == 'kategori' && !empty($kategori_id)) {
            $dokumen->where('kategori_id', $kategori_id);
        }

        $dokumen = $dokumen->orderBy('created_at', 'desc')->paginate(10);

        $kategoris = Kategori::all(); // Ambil semua kategori untuk dropdown di form

        // Mengirim kembali nilai-nilai pencarian untuk mempertahankan state form
        return view('landing.documents', compact(
            'dokumen',
            'kategoris',
            'search_type',
            'judul_query',
            'abstrak_query',
            'kategori_id'
        ));
    }
}
