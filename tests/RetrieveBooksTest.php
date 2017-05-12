<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RetrieveBooksTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @before
     */
    public function seedBooks()
    {
        $this->seed(BooksTableSeeder::class);
    }

    /**
     * @test
     */
    public function shouldReturnBooksData()
    {
        $this->assertEquals(2, App\Book::count());

        $this->json('GET', '/api/book')
            ->assertResponseOk()
            ->seeJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'author',
                    'price',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->seeJsonEquals([
                [
                    'id' => 1,
                    'title' => 'Test Driven Development: By Example',
                    'author' => 'Kent Beck',
                    'price' => 39.51,
                    'created_at' => '2016-11-07 19:26:55',
                    'updated_at' => '2016-11-07 19:26:55',
                ],
                [
                    'id' => 2,
                    'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                    'author' => 'Robert C. Martin',
                    'price' => 41.6,
                    'created_at' => '2016-11-08 19:26:55',
                    'updated_at' => '2016-11-08 19:26:55',
                ],
            ]);
    }
}
