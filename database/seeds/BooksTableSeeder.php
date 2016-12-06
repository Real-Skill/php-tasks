<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->truncate();

        DB::table('books')->insert([
            'title' => 'Test Driven Development: By Example',
            'author' => 'Kent Beck',
            'price' => 39.51,
            'created_at' => '2016-11-07 19:26:55',
            'updated_at' => '2016-11-07 19:26:55',
        ]);

        DB::table('books')->insert([
            'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
            'author' => 'Robert C. Martin',
            'price' => 41.60,
            'created_at' => '2016-11-08 19:26:55',
            'updated_at' => '2016-11-08 19:26:55',
        ]);
    }
}
