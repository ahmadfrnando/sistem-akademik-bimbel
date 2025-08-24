<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ref_kategori_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->timestamps();
        });

        DB::table('ref_kategori_tugas')->insert([
            ['id' => 1, 'kategori' => 'Pilihan Ganda'],
            ['id' => 2, 'kategori' => 'Essay'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kategori_tugas');
    }
};
