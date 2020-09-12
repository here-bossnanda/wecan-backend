<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPanitiaDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_panitia_dosens', function (Blueprint $table) {
            $table->id();
            $table->integer('nip')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_telp')->nullable();
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
        Schema::dropIfExists('master_panitia_dosens');
    }
}
