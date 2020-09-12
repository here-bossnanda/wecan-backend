<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(array(
            ['email' => 'wecan@mdp.ac.id','username' => 'Super Admin','password' => bcrypt('secret'),'status' => 1,'created_at' => now(),'updated_at' => now()]
        ));
    }
}
