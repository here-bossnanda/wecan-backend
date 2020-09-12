<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('role_user')->delete();
    DB::table('roles')->delete();

    //Membuat data roles
    DB::table('roles')->insert(array(
        [
        'id'=>'1',
        'name'=>'Super Admin',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    ));

        $admin = DB::table('users')->first();
        //Membuat relasi antara user pertama kali login di aplikasi sinaker
        //Pertama kali login pasti sebagai Admin dengan roles id 2 lihat coding diatas
        DB::table('role_user')->insert([
        'user_id'=> $admin->id,
        'role_id'=>'1',
        ]);
    }
}
