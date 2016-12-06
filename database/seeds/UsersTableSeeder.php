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
        DB::table('users')->truncate();

        \App\User::create([
            'name' => 'Hakier',
            'email' => 'hakier@fake.pl',
            'password' => '$2y$10$nWXf.Oz0dbjtnEWgzYjWYuO2EktremBwSLBcqqIE.g27O1g8BJmgW'
        ]);
    }
}
