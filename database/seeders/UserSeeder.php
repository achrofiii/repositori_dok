<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => $this->generateUsername('Admin'),
                'nip_nim' => $this->generateNipNim(),
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );
        $admin->assignRole('admin');

        // Dosen
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@gmail.com'],
            [
                'name' => 'Dosen',
                'username' => $this->generateUsername('Dosen'),
                'nip_nim' => $this->generateNipNim(),
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );
        $dosen->assignRole('dosen');

        // Mahasiswa 1
        $mahasiswa1 = User::updateOrCreate(
            ['email' => 'mahasiswa1@gmail.com'],
            [
                'name' => 'Mahasiswa Satu',
                'username' => $this->generateUsername('Mahasiswa Satu'),
                'nip_nim' => $this->generateNipNim(),
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );
        $mahasiswa1->assignRole('mahasiswa');

        // Mahasiswa 2
        $mahasiswa2 = User::updateOrCreate(
            ['email' => 'mahasiswa2@gmail.com'],
            [
                'name' => 'Mahasiswa Dua',
                'username' => $this->generateUsername('Mahasiswa Dua'),
                'nip_nim' => $this->generateNipNim(),
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );
        $mahasiswa2->assignRole('mahasiswa');
    }

    /**
     * Generate username dari nama lengkap
     */
    private function generateUsername(string $name): string
    {
        // Ubah ke huruf kecil dan hapus spasi
        $baseUsername = Str::lower(str_replace(' ', '', $name));

        // Hapus karakter khusus, hanya alphanumeric
        $baseUsername = preg_replace('/[^a-z0-9]/', '', $baseUsername);

        $username = $baseUsername;

        // Cek apakah username sudah ada
        while (User::where('username', $username)->exists()) {
            // Tambahkan 3 digit acak
            $randomNumbers = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $username = $baseUsername . $randomNumbers;
        }

        return $username;
    }

    /**
     * Generate NIP/NIM unik
     */
    private function generateNipNim(): string
    {
        do {
            // Untuk Admin dan Dosen: NIP format 18 digit (YYYYMMDDXXXXXXXXXX)
            // Untuk Mahasiswa: NIM format 10 digit (YYXXXXXXXX)
            $nipNim = rand(1000000000, 9999999999); // 10 digit random
        } while (User::where('nip_nim', $nipNim)->exists());

        return (string) $nipNim;
    }
}
