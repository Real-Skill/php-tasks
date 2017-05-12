<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class DeleteBookTest extends TestCase
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
        $this->json('DELETE', '/api/book/3')
            ->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function shouldReturnCertainBookDataIfBookExists()
    {
        $this->assertEquals(2, App\Book::count());

        $this->seeInDatabase('books', ['id' => 1]);
        $this->seeInDatabase('books', ['id' => 2]);

        $this->json('DELETE', '/api/book/1')->assertResponseStatus(Response::HTTP_ACCEPTED);
        $this->notSeeInDatabase('books', ['id' => 1]);
        $this->seeInDatabase('books', ['id' => 2]);

        $this->json('DELETE', '/api/book/2')->assertResponseStatus(Response::HTTP_ACCEPTED);
        $this->notSeeInDatabase('books', ['id' => 2]);
    }
}
