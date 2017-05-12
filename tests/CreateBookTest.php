<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use App\Book;

class CreateBookTest extends TestCase
{
    use DatabaseTransactions;

    protected $method = 'POST';
    protected $uri = '/api/book';

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
    public function shouldNotSaveBookWithEmptyPayload()
    {
        $this->json($this->method, $this->uri, [])
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'author' => ['The author field is required.'],
                'title' => ['The title field is required.'],
                'price' => ['The price field is required.'],
            ]);

        $this->assertEquals(2, Book::count());
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithEmptyTitle()
    {
        $payload = [
            'author' => 'Martin Fowler',
            'price' => 54.03,
        ];

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'title' => ['The title field is required.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithEmptyAuthor()
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'price' => 54.03,
        ];

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'author' => ['The author field is required.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithEmptyPrice()
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'author' => 'Martin Fowler',
        ];

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'price' => ['The price field is required.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithTooShortTitle()
    {
        $payload = [
            'title' => 'hq',
            'author' => 'Martin Fowler',
            'price' => 54.03,
        ];
        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'title' => ['The title must be between 3 and 128 characters.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithTooLongTitle()
    {
        $payload = [
            'title' => str_repeat('h', 129),
            'author' => 'Martin Fowler',
            'price' => 54.03,
        ];
        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'title' => ['The title must be between 3 and 128 characters.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithTooShortAuthor()
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'author' => 'hq',
            'price' => 54.03,
        ];
        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'author' => ['The author must be between 3 and 128 characters.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithTooLongAuthor()
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'author' => str_repeat('h', 129),
            'price' => 54.03,
        ];

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'author' => ['The author must be between 3 and 128 characters.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithNegativePrice()
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'author' => 'Martin Fowler',
            'price' => -0.01,
        ];

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'price' => ['The price must be at least 0.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookWithInvalidStringPrice()
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'author' => 'Martin Fowler',
            'price' => 'hq',
        ];

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJson([
                'price' => ['The price must be a number.'],
            ]);

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);
    }

    /**
     * @test
     *
     * @param int $booksCountOnSuccess
     * @return array
     */
    public function shouldSaveBookWithProperPayloadAndReturnItsData($booksCountOnSuccess = 3)
    {
        $payload = [
            'title' => 'Patterns of Enterprise Application Architecture',
            'author' => 'Martin Fowler',
            'price' => 54.03
        ];

        $this->assertEquals(2, Book::count());
        $this->notSeeInDatabase('books', $payload);

        $this->json($this->method, $this->uri, $payload)
            ->assertResponseOk()
            ->seeJsonStructure(['id', 'created_at', 'updated_at', 'title', 'author'])
            ->seeJson($payload);

        $this->seeInDatabase('books', $payload);
        $this->assertEquals($booksCountOnSuccess, Book::count());

        return $payload;
    }
}
