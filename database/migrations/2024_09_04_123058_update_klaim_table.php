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
        Schema::table('klaim', function (Blueprint $table) {
            Schema::table('klaim', function (Blueprint $table) {
                $table->string('sub_cob')->nullable();
                $table->integer('id_wilker')->nullable();
                $table->integer('jumlah_terjamin')->nullable();
                $table->dateTime('tgl_keputusan_klaim')->nullable();
                $table->integer('debet_kredit')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klaim', function (Blueprint $table) {
            //
        });
    }
};
