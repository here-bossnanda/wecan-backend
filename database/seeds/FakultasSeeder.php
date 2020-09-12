<?php

use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fakultas')->delete();
        DB::table('jurusans')->delete();
        DB::table('divisis')->delete();
        DB::table('jabatans')->delete();
        DB::table('master_panitia_mahasiswas')->delete();

        DB::table('fakultas')->insert(array(
            ['name' => 'STMIK','created_at' => now(),'updated_at' => now()],
            ['name' => 'STIE','created_at' => now(),'updated_at' => now()],
            ['name' => 'AMIK','created_at' => now(),'updated_at' => now()],
        ));

        DB::table('jurusans')->insert(array(
            ['name' => 'Teknik Informatika','fakultas_id'=>1,'created_at' => now(),'updated_at' => now()],
        ));

        DB::table('divisis')->insert(array(
            ['name' => 'Divisi Acara','created_at' => now(),'updated_at' => now()],
            ['name' => 'Divisi Dokumentasi','created_at' => now(),'updated_at' => now()],
            ['name' => 'Divisi Perlengkapan','created_at' => now(),'updated_at' => now()],
        ));

        DB::table('jabatans')->insert(array(
            ['name' => 'Anggota Divisi Acara','divisi_id'=>1,'created_at' => now(),'updated_at' => now()],
        ));

        DB::table('aktivasi_wecans')->insert(array(
            ['name' => 'Wecan 2020','tahun_akademik'=>'2020/2021','status'=> 1,'tgl_mulai' => now(),'tgl_selesai' => now(),'created_at' => now(),'updated_at' => now()],
        ));


        DB::table('master_panitia_mahasiswas')->insert(array(
            [
            'npm'=>'1620250078',
            'name' => 'Mochammad Trinanda Noviardy',
            'email' => 'm.trinandanoviardy@mhs.mdp.ac.id',
            'angkatan'=>'2016',
            'no_telp'=>'082279655366',
            'alamat' => '<p>Kompleks Kelapa Gading Blok k-10</p>',
            'jenis_kelamin' => 'L',
            'jurusan_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
            ]
        ));
    }
}
