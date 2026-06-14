<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission untuk manajemen data master
        Permission::create(['name' => 'kelola-kategori']);
        Permission::create(['name' => 'kelola-fakultas']);
        Permission::create(['name' => 'kelola-prodi']);
        Permission::create(['name' => 'kelola-user']);

        // Permission untuk dokumen
        Permission::create(['name' => 'upload-dokumen']);
        Permission::create(['name' => 'edit-dokumen']);
        Permission::create(['name' => 'hapus-dokumen']);
        Permission::create(['name' => 'verifikasi-dokumen']); // Admin memverifikasi dosen
        Permission::create(['name' => 'verifikasi-dokumen-mahasiswa']); // Dosen memverifikasi mahasiswa

        // Laporan
        Permission::create(['name' => 'lihat-laporan']);

        // Roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'dosen']);
        Role::create(['name' => 'mahasiswa']);

        // Admin permissions
        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'kelola-kategori',
            'kelola-fakultas',
            'kelola-prodi',
            'kelola-user',
            'verifikasi-dokumen',
            'lihat-laporan',
            'edit-dokumen',
            'hapus-dokumen',
        ]);

        // Dosen permissions
        $dosen = Role::findByName('dosen');
        $dosen->givePermissionTo([
            'upload-dokumen',
            'edit-dokumen',
            'hapus-dokumen',
            'verifikasi-dokumen-mahasiswa'
        ]);

        // Mahasiswa permissions
        $mahasiswa = Role::findByName('mahasiswa');
        $mahasiswa->givePermissionTo([
            'upload-dokumen',
            'edit-dokumen',
            'hapus-dokumen'
        ]);
    }
}
