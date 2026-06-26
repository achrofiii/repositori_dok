<?php

namespace Database\Seeders;

use App\Models\DetailDosen;
use App\Models\DetailMahasiswa;
use App\Models\Dokumen;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================================
        // 1. KATEGORI
        // =====================================================================
        $kategorisData = [
            ['nama_kategori' => 'Skripsi',     'deskripsi' => 'Tugas akhir mahasiswa strata satu (S1)'],
            ['nama_kategori' => 'Jurnal',      'deskripsi' => 'Artikel ilmiah yang dipublikasikan di jurnal'],
            ['nama_kategori' => 'Tesis',       'deskripsi' => 'Karya ilmiah mahasiswa strata dua (S2)'],
            ['nama_kategori' => 'Laporan PKL', 'deskripsi' => 'Laporan Praktik Kerja Lapangan mahasiswa'],
            ['nama_kategori' => 'Prosiding',   'deskripsi' => 'Makalah seminar / konferensi ilmiah'],
        ];
        foreach ($kategorisData as $d) {
            Kategori::firstOrCreate(['nama_kategori' => $d['nama_kategori']], array_merge($d, [
                'token_kategori' => Str::upper(Str::random(12)),
            ]));
        }

        // =====================================================================
        // 2. FAKULTAS
        // =====================================================================
        $fakultasData = [
            ['kode_fakultas' => 'FT',    'nama_fakultas' => 'Fakultas Teknik'],
            ['kode_fakultas' => 'FEB',   'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['kode_fakultas' => 'FISIP', 'nama_fakultas' => 'Fakultas Ilmu Sosial dan Politik'],
            ['kode_fakultas' => 'FH',    'nama_fakultas' => 'Fakultas Hukum'],
            ['kode_fakultas' => 'FKIP',  'nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
        ];
        foreach ($fakultasData as $d) {
            Fakultas::firstOrCreate(['kode_fakultas' => $d['kode_fakultas']], array_merge($d, [
                'token_fakultas' => Str::upper(Str::random(12)),
            ]));
        }

        $ft    = Fakultas::where('kode_fakultas', 'FT')->first();
        $feb   = Fakultas::where('kode_fakultas', 'FEB')->first();
        $fisip = Fakultas::where('kode_fakultas', 'FISIP')->first();
        $fh    = Fakultas::where('kode_fakultas', 'FH')->first();
        $fkip  = Fakultas::where('kode_fakultas', 'FKIP')->first();

        // =====================================================================
        // 3. JURUSAN
        // =====================================================================
        $jurusanData = [
            ['kode_jurusan' => 'TI',   'nama_jurusan' => 'Teknik Informatika',      'fakultas_id' => $ft->id],
            ['kode_jurusan' => 'SI',   'nama_jurusan' => 'Sistem Informasi',         'fakultas_id' => $ft->id],
            ['kode_jurusan' => 'TS',   'nama_jurusan' => 'Teknik Sipil',             'fakultas_id' => $ft->id],
            ['kode_jurusan' => 'TE',   'nama_jurusan' => 'Teknik Elektro',           'fakultas_id' => $ft->id],
            ['kode_jurusan' => 'MNJ',  'nama_jurusan' => 'Manajemen',               'fakultas_id' => $feb->id],
            ['kode_jurusan' => 'AKT',  'nama_jurusan' => 'Akuntansi',               'fakultas_id' => $feb->id],
            ['kode_jurusan' => 'EP',   'nama_jurusan' => 'Ekonomi Pembangunan',      'fakultas_id' => $feb->id],
            ['kode_jurusan' => 'IKOM', 'nama_jurusan' => 'Ilmu Komunikasi',          'fakultas_id' => $fisip->id],
            ['kode_jurusan' => 'IP',   'nama_jurusan' => 'Ilmu Pemerintahan',        'fakultas_id' => $fisip->id],
            ['kode_jurusan' => 'IH',   'nama_jurusan' => 'Ilmu Hukum',              'fakultas_id' => $fh->id],
            ['kode_jurusan' => 'PGSD', 'nama_jurusan' => 'Pendidikan Guru SD',       'fakultas_id' => $fkip->id],
            ['kode_jurusan' => 'PBSI', 'nama_jurusan' => 'Pendidikan Bahasa Indonesia', 'fakultas_id' => $fkip->id],
        ];
        foreach ($jurusanData as $d) {
            Jurusan::firstOrCreate(['kode_jurusan' => $d['kode_jurusan']], array_merge($d, [
                'token_jurusan' => Str::upper(Str::random(12)),
            ]));
        }

        $jurusansAll = Jurusan::all();

        // =====================================================================
        // 4. DOSEN (15 dosen) + detail_dosens
        // =====================================================================
        $namaDosen = [
            ['name' => 'Dr. Ahmad Fauzi, M.Kom',       'email' => 'ahmad.fauzi@uniba.ac.id',      'nip' => '197501012005011001', 'fak' => 'FT',    'jur' => 'TI',   'keahlian' => 'Kecerdasan Buatan'],
            ['name' => 'Dr. Siti Rahayu, M.T',         'email' => 'siti.rahayu@uniba.ac.id',      'nip' => '197802152006042002', 'fak' => 'FT',    'jur' => 'SI',   'keahlian' => 'Sistem Informasi'],
            ['name' => 'Prof. Budi Hartono, Ph.D',     'email' => 'budi.hartono@uniba.ac.id',     'nip' => '196903201995031003', 'fak' => 'FT',    'jur' => 'TS',   'keahlian' => 'Struktur Bangunan'],
            ['name' => 'Dr. Dewi Anggraini, M.M',      'email' => 'dewi.anggraini@uniba.ac.id',   'nip' => '198105102008042004', 'fak' => 'FEB',   'jur' => 'MNJ',  'keahlian' => 'Manajemen SDM'],
            ['name' => 'Dr. Hendra Kusuma, M.Si',      'email' => 'hendra.kusuma@uniba.ac.id',    'nip' => '197604252003031005', 'fak' => 'FEB',   'jur' => 'AKT',  'keahlian' => 'Akuntansi Keuangan'],
            ['name' => 'Dr. Rina Wulandari, M.I.Kom',  'email' => 'rina.wulandari@uniba.ac.id',   'nip' => '198209142009042006', 'fak' => 'FISIP', 'jur' => 'IKOM', 'keahlian' => 'Komunikasi Massa'],
            ['name' => 'Dr. Fajar Setiawan, M.H',      'email' => 'fajar.setiawan@uniba.ac.id',   'nip' => '197812302007031007', 'fak' => 'FH',    'jur' => 'IH',   'keahlian' => 'Hukum Perdata'],
            ['name' => 'Dr. Lestari Ningrum, M.Pd',    'email' => 'lestari.ningrum@uniba.ac.id',  'nip' => '198307182010042008', 'fak' => 'FKIP',  'jur' => 'PGSD', 'keahlian' => 'Pendidikan Dasar'],
            ['name' => 'Dr. Wahyu Santoso, M.Kom',     'email' => 'wahyu.santoso@uniba.ac.id',    'nip' => '197911052006031009', 'fak' => 'FT',    'jur' => 'TI',   'keahlian' => 'Jaringan Komputer'],
            ['name' => 'Dr. Nurul Hidayah, M.Si',      'email' => 'nurul.hidayah@uniba.ac.id',    'nip' => '198401202011042010', 'fak' => 'FEB',   'jur' => 'EP',   'keahlian' => 'Ekonomi Makro'],
            ['name' => 'Dr. Agus Prasetyo, M.T',       'email' => 'agus.prasetyo@uniba.ac.id',    'nip' => '197706302004031011', 'fak' => 'FT',    'jur' => 'TE',   'keahlian' => 'Elektronika Daya'],
            ['name' => 'Dr. Maya Sari, M.Sos',         'email' => 'maya.sari@uniba.ac.id',        'nip' => '198508122012042012', 'fak' => 'FISIP', 'jur' => 'IP',   'keahlian' => 'Kebijakan Publik'],
            ['name' => 'Dr. Rizal Maulana, M.Kom',     'email' => 'rizal.maulana@uniba.ac.id',    'nip' => '198002252008031013', 'fak' => 'FT',    'jur' => 'SI',   'keahlian' => 'Basis Data'],
            ['name' => 'Dr. Indah Permatasari, M.Pd',  'email' => 'indah.permatasari@uniba.ac.id', 'nip' => '198610302013042014', 'fak' => 'FKIP',  'jur' => 'PBSI', 'keahlian' => 'Linguistik Terapan'],
            ['name' => 'Dr. Yusuf Priyambodo, M.H',    'email' => 'yusuf.priyambodo@uniba.ac.id', 'nip' => '197503152003031015', 'fak' => 'FH',    'jur' => 'IH',   'keahlian' => 'Hukum Pidana'],
        ];

        $dosenIds = [];
        foreach ($namaDosen as $d) {
            $base     = strtolower(preg_replace('/[^a-z]/i', '', explode(' ', $d['name'])[1] ?? 'dosen'));
            $user = User::firstOrCreate(['email' => $d['email']], [
                'name'              => $d['name'],
                'username'          => $base . rand(10, 99),
                'nip_nim'           => $d['nip'],
                'password'          => Hash::make('123'),
                'email_verified_at' => now(),
            ]);
            if (!$user->hasRole('dosen')) $user->assignRole('dosen');

            $fak = Fakultas::where('kode_fakultas', $d['fak'])->first();
            $jur = Jurusan::where('kode_jurusan', $d['jur'])->first();
            DetailDosen::updateOrCreate(['user_id' => $user->id], [
                'fakultas_id'     => $fak?->id,
                'jurusan_id'      => $jur?->id,
                'bidang_keahlian' => $d['keahlian'],
                'no_hp'           => '08' . rand(100000000, 999999999),
                'alamat'          => 'Jl. Kampus No. ' . rand(1, 100) . ', Kota Akademik',
            ]);

            $dosenIds[] = $user->id;
        }

        // =====================================================================
        // 5. MAHASISWA (20 mahasiswa) + detail_mahasiswas
        // =====================================================================
        $namaMahasiswa = [
            ['name' => 'Andi Pratama',        'email' => 'andi.pratama@student.uniba.ac.id',        'nim' => '2021001001', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2021'],
            ['name' => 'Budi Santoso',         'email' => 'budi.santoso@student.uniba.ac.id',         'nim' => '2021001002', 'fak' => 'FT',    'jur' => 'SI',   'angkatan' => '2021'],
            ['name' => 'Citra Dewi',           'email' => 'citra.dewi@student.uniba.ac.id',           'nim' => '2020001003', 'fak' => 'FEB',   'jur' => 'MNJ',  'angkatan' => '2020'],
            ['name' => 'Dian Rahayu',          'email' => 'dian.rahayu@student.uniba.ac.id',          'nim' => '2020001004', 'fak' => 'FEB',   'jur' => 'AKT',  'angkatan' => '2020'],
            ['name' => 'Eko Wahyudi',          'email' => 'eko.wahyudi@student.uniba.ac.id',          'nim' => '2022001005', 'fak' => 'FT',    'jur' => 'TS',   'angkatan' => '2022'],
            ['name' => 'Fitri Handayani',      'email' => 'fitri.handayani@student.uniba.ac.id',      'nim' => '2021001006', 'fak' => 'FISIP', 'jur' => 'IKOM', 'angkatan' => '2021'],
            ['name' => 'Gilang Saputra',       'email' => 'gilang.saputra@student.uniba.ac.id',       'nim' => '2020001007', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2020'],
            ['name' => 'Hana Permata',         'email' => 'hana.permata@student.uniba.ac.id',         'nim' => '2022001008', 'fak' => 'FKIP',  'jur' => 'PGSD', 'angkatan' => '2022'],
            ['name' => 'Ivan Kurniawan',       'email' => 'ivan.kurniawan@student.uniba.ac.id',       'nim' => '2021001009', 'fak' => 'FH',    'jur' => 'IH',   'angkatan' => '2021'],
            ['name' => 'Joko Susilo',          'email' => 'joko.susilo@student.uniba.ac.id',          'nim' => '2020001010', 'fak' => 'FEB',   'jur' => 'EP',   'angkatan' => '2020'],
            ['name' => 'Kartika Putri',        'email' => 'kartika.putri@student.uniba.ac.id',        'nim' => '2022001011', 'fak' => 'FT',    'jur' => 'SI',   'angkatan' => '2022'],
            ['name' => 'Lukman Hakim',         'email' => 'lukman.hakim@student.uniba.ac.id',         'nim' => '2021001012', 'fak' => 'FT',    'jur' => 'TE',   'angkatan' => '2021'],
            ['name' => 'Mira Susanti',         'email' => 'mira.susanti@student.uniba.ac.id',         'nim' => '2020001013', 'fak' => 'FISIP', 'jur' => 'IP',   'angkatan' => '2020'],
            ['name' => 'Nanda Wijaya',         'email' => 'nanda.wijaya@student.uniba.ac.id',         'nim' => '2022001014', 'fak' => 'FEB',   'jur' => 'MNJ',  'angkatan' => '2022'],
            ['name' => 'Oktavia Sari',         'email' => 'oktavia.sari@student.uniba.ac.id',         'nim' => '2021001015', 'fak' => 'FKIP',  'jur' => 'PBSI', 'angkatan' => '2021'],
            ['name' => 'Pandu Wibisono',       'email' => 'pandu.wibisono@student.uniba.ac.id',       'nim' => '2020001016', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2020'],
            ['name' => 'Qonita Azzahra',       'email' => 'qonita.azzahra@student.uniba.ac.id',       'nim' => '2022001017', 'fak' => 'FH',    'jur' => 'IH',   'angkatan' => '2022'],
            ['name' => 'Rendi Firmansyah',     'email' => 'rendi.firmansyah@student.uniba.ac.id',     'nim' => '2021001018', 'fak' => 'FEB',   'jur' => 'AKT',  'angkatan' => '2021'],
            ['name' => 'Salsabila Nur',        'email' => 'salsabila.nur@student.uniba.ac.id',        'nim' => '2020001019', 'fak' => 'FISIP', 'jur' => 'IKOM', 'angkatan' => '2020'],
            ['name' => 'Taufik Hidayat',       'email' => 'taufik.hidayat@student.uniba.ac.id',       'nim' => '2022001020', 'fak' => 'FT',    'jur' => 'TS',   'angkatan' => '2022'],
            ['name' => 'Umar Faruq',           'email' => 'umar.faruq@student.uniba.ac.id',           'nim' => '2021001021', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2021'],
            ['name' => 'Vina Oktaviani',       'email' => 'vina.oktaviani@student.uniba.ac.id',       'nim' => '2020001022', 'fak' => 'FEB',   'jur' => 'MNJ',  'angkatan' => '2020'],
            ['name' => 'Wahyu Nugroho',        'email' => 'wahyu.nugroho@student.uniba.ac.id',        'nim' => '2022001023', 'fak' => 'FT',    'jur' => 'SI',   'angkatan' => '2022'],
            ['name' => 'Xenia Maharani',       'email' => 'xenia.maharani@student.uniba.ac.id',       'nim' => '2021001024', 'fak' => 'FISIP', 'jur' => 'IP',   'angkatan' => '2021'],
            ['name' => 'Yoga Pradana',         'email' => 'yoga.pradana@student.uniba.ac.id',         'nim' => '2020001025', 'fak' => 'FT',    'jur' => 'TE',   'angkatan' => '2020'],
            ['name' => 'Zahra Aulia',          'email' => 'zahra.aulia@student.uniba.ac.id',          'nim' => '2022001026', 'fak' => 'FKIP',  'jur' => 'PGSD', 'angkatan' => '2022'],
            ['name' => 'Arif Budiman',         'email' => 'arif.budiman@student.uniba.ac.id',         'nim' => '2021001027', 'fak' => 'FH',    'jur' => 'IH',   'angkatan' => '2021'],
            ['name' => 'Bella Safitri',        'email' => 'bella.safitri@student.uniba.ac.id',        'nim' => '2020001028', 'fak' => 'FEB',   'jur' => 'AKT',  'angkatan' => '2020'],
            ['name' => 'Chandra Kusuma',       'email' => 'chandra.kusuma@student.uniba.ac.id',       'nim' => '2022001029', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2022'],
            ['name' => 'Desy Anggraini',       'email' => 'desy.anggraini@student.uniba.ac.id',       'nim' => '2021001030', 'fak' => 'FISIP', 'jur' => 'IKOM', 'angkatan' => '2021'],
            ['name' => 'Endra Setiawan',       'email' => 'endra.setiawan@student.uniba.ac.id',       'nim' => '2020001031', 'fak' => 'FT',    'jur' => 'TS',   'angkatan' => '2020'],
            ['name' => 'Farida Hanum',         'email' => 'farida.hanum@student.uniba.ac.id',         'nim' => '2022001032', 'fak' => 'FKIP',  'jur' => 'PBSI', 'angkatan' => '2022'],
            ['name' => 'Galih Permana',        'email' => 'galih.permana@student.uniba.ac.id',        'nim' => '2021001033', 'fak' => 'FEB',   'jur' => 'EP',   'angkatan' => '2021'],
            ['name' => 'Hesti Wulandari',      'email' => 'hesti.wulandari@student.uniba.ac.id',      'nim' => '2020001034', 'fak' => 'FT',    'jur' => 'SI',   'angkatan' => '2020'],
            ['name' => 'Imam Santoso',         'email' => 'imam.santoso@student.uniba.ac.id',         'nim' => '2022001035', 'fak' => 'FH',    'jur' => 'IH',   'angkatan' => '2022'],
            ['name' => 'Juliana Putri',        'email' => 'juliana.putri@student.uniba.ac.id',        'nim' => '2021001036', 'fak' => 'FEB',   'jur' => 'MNJ',  'angkatan' => '2021'],
            ['name' => 'Kevin Ramadhan',       'email' => 'kevin.ramadhan@student.uniba.ac.id',       'nim' => '2020001037', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2020'],
            ['name' => 'Laila Fitriani',       'email' => 'laila.fitriani@student.uniba.ac.id',       'nim' => '2022001038', 'fak' => 'FISIP', 'jur' => 'IP',   'angkatan' => '2022'],
            ['name' => 'Maulana Yusuf',        'email' => 'maulana.yusuf@student.uniba.ac.id',        'nim' => '2021001039', 'fak' => 'FT',    'jur' => 'TE',   'angkatan' => '2021'],
            ['name' => 'Nabila Rahma',         'email' => 'nabila.rahma@student.uniba.ac.id',         'nim' => '2020001040', 'fak' => 'FKIP',  'jur' => 'PGSD', 'angkatan' => '2020'],
            ['name' => 'Oscar Wijaya',         'email' => 'oscar.wijaya@student.uniba.ac.id',         'nim' => '2022001041', 'fak' => 'FEB',   'jur' => 'AKT',  'angkatan' => '2022'],
            ['name' => 'Putri Melani',         'email' => 'putri.melani@student.uniba.ac.id',         'nim' => '2021001042', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2021'],
            ['name' => 'Raka Adiputra',        'email' => 'raka.adiputra@student.uniba.ac.id',        'nim' => '2020001043', 'fak' => 'FISIP', 'jur' => 'IKOM', 'angkatan' => '2020'],
            ['name' => 'Sinta Kurnia',         'email' => 'sinta.kurnia@student.uniba.ac.id',         'nim' => '2022001044', 'fak' => 'FEB',   'jur' => 'MNJ',  'angkatan' => '2022'],
            ['name' => 'Teguh Prasetya',       'email' => 'teguh.prasetya@student.uniba.ac.id',       'nim' => '2021001045', 'fak' => 'FT',    'jur' => 'SI',   'angkatan' => '2021'],
            ['name' => 'Ulfa Rahmawati',       'email' => 'ulfa.rahmawati@student.uniba.ac.id',       'nim' => '2020001046', 'fak' => 'FH',    'jur' => 'IH',   'angkatan' => '2020'],
            ['name' => 'Vicky Fernanda',       'email' => 'vicky.fernanda@student.uniba.ac.id',       'nim' => '2022001047', 'fak' => 'FT',    'jur' => 'TS',   'angkatan' => '2022'],
            ['name' => 'Winda Lestari',        'email' => 'winda.lestari@student.uniba.ac.id',        'nim' => '2021001048', 'fak' => 'FKIP',  'jur' => 'PBSI', 'angkatan' => '2021'],
            ['name' => 'Yandi Maulana',        'email' => 'yandi.maulana@student.uniba.ac.id',        'nim' => '2020001049', 'fak' => 'FEB',   'jur' => 'EP',   'angkatan' => '2020'],
            ['name' => 'Zulfa Khoirunnisa',    'email' => 'zulfa.khoirunnisa@student.uniba.ac.id',    'nim' => '2022001050', 'fak' => 'FT',    'jur' => 'TI',   'angkatan' => '2022'],
        ];

        $mahasiswaIds = [];
        foreach ($namaMahasiswa as $d) {
            $base = strtolower(preg_replace('/[^a-z]/i', '', explode(' ', $d['name'])[0]));
            $user = User::firstOrCreate(['email' => $d['email']], [
                'name'              => $d['name'],
                'username'          => $base . rand(100, 999),
                'nip_nim'           => $d['nim'],
                'password'          => Hash::make('123'),
                'email_verified_at' => now(),
            ]);
            if (!$user->hasRole('mahasiswa')) $user->assignRole('mahasiswa');

            $fak = Fakultas::where('kode_fakultas', $d['fak'])->first();
            $jur = Jurusan::where('kode_jurusan', $d['jur'])->first();
            DetailMahasiswa::updateOrCreate(['user_id' => $user->id], [
                'fakultas_id' => $fak?->id,
                'jurusan_id'  => $jur?->id,
                'angkatan'    => $d['angkatan'],
                'no_hp'       => '08' . rand(100000000, 999999999),
                'alamat'      => 'Jl. Mahasiswa No. ' . rand(1, 50) . ', Kota Pelajar',
            ]);

            $mahasiswaIds[] = $user->id;
        }

        // =====================================================================
        // 6. DOKUMEN DUMMY (50 dokumen, bervariasi per kategori)
        // =====================================================================
        $kategorisDb = Kategori::all()->keyBy('nama_kategori');

        // [nama_kategori, jumlah, verified_rate, avg_unduhan, avg_nilai]
        $distribusi = [
            ['Skripsi',     75, 0.88, 130, 83.0],
            ['Jurnal',      55, 0.78, 210, 88.0],
            ['Tesis',       30, 0.85,  85, 85.0],
            ['Laporan PKL', 25, 0.60,  45, 70.0],
            ['Prosiding',   15, 0.50, 165, 77.0],
        ];

        $judulList = [
            'Implementasi Machine Learning untuk Klasifikasi Data Akademik',
            'Analisis Sistem Informasi Manajemen Berbasis Web Responsif',
            'Pengembangan Aplikasi Mobile dengan Framework Flutter dan Firebase',
            'Optimasi Algoritma Pencarian Data Menggunakan Metode Heuristik',
            'Sistem Pendukung Keputusan dengan Metode PROMETHEE II',
            'Rancang Bangun Aplikasi E-Commerce Berbasis Laravel dan Vue.js',
            'Penerapan Deep Learning pada Pengenalan Citra Digital',
            'Analisis Kinerja Jaringan Komputer pada Lingkungan Kampus',
            'Implementasi IoT untuk Monitoring Lingkungan Cerdas Berbasis ESP32',
            'Sistem Manajemen Perpustakaan Digital Berbasis Cloud Computing',
            'Pengaruh Teknologi Informasi terhadap Produktivitas Kerja Karyawan',
            'Model Prediksi Mahasiswa Berprestasi Menggunakan Data Mining',
            'Keamanan Siber pada Aplikasi Web: Analisis dan Solusi Terkini',
            'Pengujian Performa Aplikasi REST API dengan Load Testing',
            'Transformasi Digital dalam Layanan Publik Pemerintah Daerah',
            'Efisiensi Energi pada Sistem Komputasi Terdistribusi',
            'Evaluasi User Experience Aplikasi Akademik Mahasiswa',
            'Blockchain untuk Autentikasi Dokumen Akademik Digital',
            'Analisis Sentimen Media Sosial Menggunakan Natural Language Processing',
            'Framework Agile dalam Pengembangan Perangkat Lunak Skala Menengah',
        ];

        $kataKunciList = [
            'machine learning, klasifikasi, python, scikit-learn',
            'sistem informasi, manajemen, web, laravel',
            'mobile, flutter, android, firebase',
            'algoritma, optimasi, heuristik, pencarian',
            'SPK, PROMETHEE, keputusan, multikriteria',
            'e-commerce, laravel, vue.js, php',
            'deep learning, citra, CNN, tensorflow',
            'jaringan, komputer, bandwidth, analisis',
            'IoT, sensor, ESP32, monitoring',
            'perpustakaan, digital, cloud, AWS',
            'produktivitas, teknologi, kinerja, SDM',
            'data mining, prediksi, akademik, naive bayes',
            'keamanan, siber, SQL injection, XSS',
            'API, REST, load testing, JMeter',
            'transformasi, digital, e-government, pelayanan',
            'energi, komputasi, green computing, efisiensi',
            'UX, usability, aplikasi, evaluasi heuristik',
            'blockchain, autentikasi, hash, dokumen',
            'NLP, sentimen, twitter, BERT',
            'agile, scrum, sprint, perangkat lunak',
        ];

        $counter = 0;
        foreach ($distribusi as [$namaKat, $jumlah, $verRate, $avgUnduh, $avgNilai]) {
            $kat = $kategorisDb[$namaKat] ?? null;
            if (!$kat) continue;

            for ($i = 0; $i < $jumlah; $i++) {
                $isVerified  = (rand(1, 100) / 100) <= $verRate;
                $isPublished = $isVerified;
                $unduhan     = max(0, $avgUnduh + rand(-40, 80));
                $nilai       = $isVerified ? round(max(60, min(100, $avgNilai + rand(-12, 12))), 2) : null;

                $jurusan = $jurusansAll->random();
                $userId  = $mahasiswaIds[array_rand($mahasiswaIds)];
                $dosenId = $dosenIds[array_rand($dosenIds)];

                Dokumen::create([
                    'token_dokumen'   => strtoupper(Str::random(12)),
                    'judul'           => $judulList[$counter % count($judulList)] . ' (' . $namaKat . ' ' . ($i + 1) . ')',
                    'abstrak'         => 'Penelitian ini bertujuan untuk menganalisis dan mengembangkan solusi terkait topik yang dibahas. '
                        . 'Metode yang digunakan meliputi studi literatur, pengumpulan data, dan pengujian sistem. '
                        . 'Hasil penelitian menunjukkan peningkatan signifikan pada aspek yang diteliti dan memberikan kontribusi bagi pengembangan ilmu pengetahuan.',
                    'kata_kunci'      => $kataKunciList[$counter % count($kataKunciList)],
                    'tahun_publikasi' => rand(2020, 2025),
                    'file_path'       => 'dokumen/dummy/' . Str::slug($namaKat) . '_' . ($i + 1) . '.pdf',
                    'thumbnail_path'  => null,
                    'user_id'         => $userId,
                    'kategori_id'     => $kat->id,
                    'fakultas_id'     => $jurusan->fakultas_id,
                    'jurusan_id'      => $jurusan->id,
                    'dosen_id'        => $dosenId,
                    'is_verified'     => $isVerified,
                    'is_published'    => $isPublished,
                    'jumlah_diunduh'  => $unduhan,
                    'nilai_kelayakan' => $nilai,
                    'status'          => $isVerified ? 'diterima' : 'pending',
                    'created_at'      => now()->subDays(rand(1, 365)),
                ]);

                $counter++;
            }
        }

        $this->command->info('✅ DummySeeder selesai!');
        $this->command->info('   Kategori  : ' . Kategori::count());
        $this->command->info('   Fakultas  : ' . Fakultas::count());
        $this->command->info('   Jurusan   : ' . Jurusan::count());
        $this->command->info('   Dosen     : ' . User::role('dosen')->count());
        $this->command->info('   Mahasiswa : ' . User::role('mahasiswa')->count());
        $this->command->info('   Dokumen   : ' . Dokumen::count());
    }
}
