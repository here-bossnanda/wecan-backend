<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPanitiaMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_panitia_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('npm')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('angkatan');
            $table->string('no_telp');
            $table->longText('alamat')->nullable();
            $table->enum('jenis_kelamin',['L','P']);
            $table->string('foto',100)->nullable();
            $table->foreignId('jurusan_id')->constrained('jurusans')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('master_panitia_mahasiswas');
    }
}
