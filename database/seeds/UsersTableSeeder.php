<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        //
        DB::connection("mysql")->table('users')->insert([
            'username' => 'mdc',
            'password' => bcrypt('06042012')
        ]);
    }
}
