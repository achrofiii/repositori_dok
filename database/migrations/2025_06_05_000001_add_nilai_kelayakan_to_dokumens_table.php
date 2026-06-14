<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            // Nilai kelayakan dari dosen pembimbing (0–100).
            // Nullable karena kategori bebas dospem tidak memiliki penilaian ini.
            $table->decimal('nilai_kelayakan', 5, 2)
                ->nullable()
                ->after('is_published')
                ->comment('Nilai kelayakan dari dosen/admin (0-100). Null jika tanpa dospem.');
        });
    }

    public function down(): void
    {
        Schema::table('dokumens', function (Blueprint $table) {
            $table->dropColumn('nilai_kelayakan');
        });
    }
};
