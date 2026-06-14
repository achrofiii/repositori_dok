<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;

class SpkController extends Controller
{
    /**
     * Halaman SPK PROMETHEE — Rangking Kategori Repositori Terpopuler.
     * Hanya dapat diakses oleh Admin.
     */
    public function index()
    {
        // =====================================================================
        // TAHAP 1 — Pembentukan Matriks Keputusan
        // Ambil data agregat dari DB untuk setiap kategori (= alternatif).
        // =====================================================================
        $kategoris = Kategori::all();
        $matriks   = [];

        foreach ($kategoris as $kategori) {
            $totalDokumen = Dokumen::where('kategori_id', $kategori->id)->count();

            // C1 — Jumlah Unggahan Terverifikasi (benefit, max)
            $c1 = Dokumen::where('kategori_id', $kategori->id)
                ->where('is_verified', true)
                ->count();

            // C2 — Jumlah Unduhan (benefit, max)
            $c2 = (int) Dokumen::where('kategori_id', $kategori->id)
                ->sum('jumlah_diunduh');

            // C3 — Persentase Kelayakan: (verified / total) × 100 (benefit, max)
            $c3 = $totalDokumen > 0
                ? round(($c1 / $totalDokumen) * 100, 2)
                : 0.00;

            // C4 — Rata-rata Nilai Kelayakan dari dosen/admin (benefit, max)
            // Null-safe: jika tidak ada nilai dospem → gunakan default 75 (passing score)
            $c4Raw = Dokumen::where('kategori_id', $kategori->id)
                ->where('is_verified', true)
                ->whereNotNull('nilai_kelayakan')
                ->avg('nilai_kelayakan');

            $c4IsDefault = ($c4Raw === null);
            $c4 = $c4IsDefault ? 75.00 : round((float) $c4Raw, 2);

            $matriks[$kategori->id] = [
                'id'            => $kategori->id,
                'nama_kategori' => $kategori->nama_kategori,
                'C1'            => $c1,
                'C2'            => $c2,
                'C3'            => $c3,
                'C4'            => $c4,
                'c4_is_default' => $c4IsDefault,
            ];
        }

        // Bobot kriteria — total = 1.00
        $bobot = [
            'C1' => 0.25, // Jumlah Unggahan
            'C2' => 0.25, // Jumlah Unduhan
            'C3' => 0.20, // Persentase Kelayakan
            'C4' => 0.30, // Rata-rata Nilai Kelayakan
        ];

        $kriterias       = ['C1', 'C2', 'C3', 'C4'];
        $alternatifIds   = array_keys($matriks);
        $n               = count($alternatifIds);

        // =====================================================================
        // TAHAP 2 — Perbandingan Berpasangan: Selisih d_j(a,b) = g_j(a) - g_j(b)
        // =====================================================================
        $selisih = [];
        foreach ($alternatifIds as $a) {
            foreach ($alternatifIds as $b) {
                if ($a === $b) continue;
                foreach ($kriterias as $k) {
                    $selisih[$a][$b][$k] = round($matriks[$a][$k] - $matriks[$b][$k], 4);
                }
            }
        }

        // =====================================================================
        // TAHAP 3 — Fungsi Preferensi Tipe I (Usual Criterion)
        // P_j(a,b) = 0 jika d_j(a,b) <= 0  |  1 jika d_j(a,b) > 0
        // =====================================================================
        $preferensi = [];
        foreach ($alternatifIds as $a) {
            foreach ($alternatifIds as $b) {
                if ($a === $b) continue;
                foreach ($kriterias as $k) {
                    $preferensi[$a][$b][$k] = ($selisih[$a][$b][$k] > 0) ? 1 : 0;
                }
            }
        }

        // =====================================================================
        // TAHAP 4 — Indeks Preferensi Multikriteria pi(a,b)
        // pi(a,b) = Sigma w_j * P_j(a,b)
        // =====================================================================
        $pi = [];
        foreach ($alternatifIds as $a) {
            foreach ($alternatifIds as $b) {
                if ($a === $b) {
                    $pi[$a][$b] = 0;
                    continue;
                }
                $piAB = 0;
                foreach ($kriterias as $k) {
                    $piAB += $bobot[$k] * $preferensi[$a][$b][$k];
                }
                $pi[$a][$b] = round($piAB, 4);
            }
        }

        // =====================================================================
        // TAHAP 4 & 5 — Aliran Arus (PROMETHEE II Net Flow)
        // Φ⁺(a) = 1/(n−1) × Σ π(a,x)   ← Leaving Flow
        // Φ⁻(a) = 1/(n−1) × Σ π(x,a)   ← Entering Flow
        // Φ(a)  = Φ⁺(a) − Φ⁻(a)         ← Net Flow
        // =====================================================================
        $hasil = [];
        foreach ($alternatifIds as $a) {
            $leaving  = 0;
            $entering = 0;
            foreach ($alternatifIds as $x) {
                $leaving  += $pi[$a][$x];
                $entering += $pi[$x][$a];
            }
            $leaving  = ($n > 1) ? round($leaving  / ($n - 1), 4) : 0;
            $entering = ($n > 1) ? round($entering / ($n - 1), 4) : 0;
            $netFlow  = round($leaving - $entering, 4);

            $hasil[$a] = array_merge($matriks[$a], [
                'leaving_flow'  => $leaving,
                'entering_flow' => $entering,
                'net_flow'      => $netFlow,
            ]);
        }

        // Urutkan descending by Net Flow → rangking
        usort($hasil, fn($a, $b) => $b['net_flow'] <=> $a['net_flow']);
        foreach ($hasil as $i => &$item) {
            $item['rangking'] = $i + 1;
        }
        unset($item);

        return view('spk.spk', compact('hasil', 'matriks', 'bobot', 'selisih', 'preferensi', 'pi', 'alternatifIds', 'kriterias'));
    }
}
