<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert(
            //['email' => 'admin@admin.com', 'password' => \Hash::make(env('ADMIN_PASSWORD', '123456'))]
            ['email' => '694093654@qq.com', 'password' => \Hash::make('Haomeiyu')],
            ['email' => '1220312020@qq.com', 'password' => \Hash::make('WENCY1993806')]
        );
    }
}
