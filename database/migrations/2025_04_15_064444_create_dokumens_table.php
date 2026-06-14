<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('token_dokumen', 12)->unique();

            // Kolom dasar
            $table->string('judul');
            $table->text('abstrak');
            $table->string('kata_kunci'); // Contoh: "AI, Pendidikan, Laravel"
            $table->year('tahun_publikasi');
            $table->string('file_path'); // Path/lokasi file (PDF/DOC)
            $table->string('thumbnail_path')->nullable(); // Untuk gambar cover (opsional)

            // Relasi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengunggah dokumen
            $table->foreignId('kategori_id')->constrained('kategoris'); // Kategori dokumen
            $table->foreignId('fakultas_id')->constrained('fakultas'); // Fakultas
            $table->foreignId('jurusan_id')->constrained('jurusans'); // Jurusan

            // Dosen pembimbing (hanya diisi jika user adalah mahasiswa)
            $table->foreignId('dosen_id')->nullable()->constrained('users')->onDelete('set null');

            // Status
            $table->boolean('is_verified')->default(false); // Verifikasi admin
            $table->boolean('is_published')->default(false); // Status publikasi dokumen
            $table->integer('jumlah_diunduh')->default(0); // Jumlah unduhan dokumen

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
