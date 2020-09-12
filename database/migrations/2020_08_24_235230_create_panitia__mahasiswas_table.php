<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanitiaMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panitia_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->foreignId('jabatan_id')->constrained('jabatans')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->onDelete('SET NULL');
            $table->foreignId('master_panitia_mahasiswa_id')->constrained('master_panitia_mahasiswas')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('aktivasi_wecan_id')->constrained('aktivasi_wecans')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panitia_mahasiswas');
    }
}
