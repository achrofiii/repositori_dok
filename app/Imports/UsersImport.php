<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class UsersImport implements ToCollection, WithCalculatedFormulas
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function collection(Collection $rows)
    {
        $headerIndex = $rows->search(fn($row) => $row[2] === 'NPM');
        if ($headerIndex === false) return;

        $data = $rows->slice($headerIndex + 1);

        foreach ($data as $row) {
            if (!isset($row[3], $row[2], $row[4], $row[5])) continue;

            $rawName = trim($row[3]);
            $name = ucwords(strtolower($rawName));
            $usernameBase = strtolower(preg_replace('/[^a-z0-9]/i', '', $name));
            $username = $usernameBase;
            $counter = 1;

            while (User::where('username', $username)->exists()) {
                $username = $usernameBase . str_pad($counter, 3, '0', STR_PAD_LEFT);
                $counter++;
            }

            $nip_nim = preg_replace('/\D/', '', $row[2]);

            $tahunMasuk = $row[5];
            $password = 'unibamadura' . $tahunMasuk;

            // hindari duplikat email
            if (User::where('email', $row[4])->exists()) {
                continue;
            }

            $user = User::create([
                'name' => $name,
                'username' => $username,
                'nip_nim' => $nip_nim,
                'email' => $row[4],
                'password' => Hash::make($password),
            ]);

            $user->assignRole($this->role);
        }
    }
}
