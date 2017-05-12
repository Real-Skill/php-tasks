<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class RetrieveBookTest extends TestCase
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
    public function shouldReturn404StatusCodeIfBookNotExists()
    {
        $this->assertEquals(2, App\Book::count());

        $this->notSeeInDatabase('books', ['id' => 3]);
        $this->json('GET', '/api/book/3')
            ->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function shouldReturnCertainBookDataIfBookExists()
    {
        $this->assertEquals(2, App\Book::count());

        $this->seeInDatabase('books', ['id' => 1]);
        $this->json('GET', '/api/book/1')
            ->assertResponseOk()
            ->seeJsonStructure([
                'id',
                'title',
                'author',
                'price',
                'created_at',
                'updated_at',
            ])
            ->seeJsonEquals([
                'id' => 1,
                'title' => 'Test Driven Development: By Example',
                'author' => 'Kent Beck',
                'price' => 39.51,
                'created_at' => '2016-11-07 19:26:55',
                'updated_at' => '2016-11-07 19:26:55',
            ]);
        $this->seeInDatabase('books', ['id' => 2]);
        $this->json('GET', '/api/book/2')
            ->assertResponseOk()
            ->seeJsonStructure([
                'id',
                'title',
                'author',
                'price',
                'created_at',
                'updated_at',
            ])
            ->seeJsonEquals([
                'id' => 2,
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'price' => 41.60,
                'created_at' => '2016-11-08 19:26:55',
                'updated_at' => '2016-11-08 19:26:55',
            ]);
    }
}
