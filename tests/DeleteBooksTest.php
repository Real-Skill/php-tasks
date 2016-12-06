<?php

class DeleteBookTest extends TestCase
{
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
    public function shouldReturn404IfNoSuchBook()
    {
        $this->json('DELETE', '/book/3')->assertResponseStatus(\Illuminate\Http\Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function shouldDeleteConcreteBookAndRedirectToBookIndexAndDisplayFlashMessage()
    {
        $books = [
            [
                'title' => 'Test Driven Development: By Example',
                'author' => 'Kent Beck',
                'price' => 39.51,
                'created_at' => '2016-11-07 19:26:55',
                'updated_at' => '2016-11-07 19:26:55',
            ],
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'price' => 41.60,
                'created_at' => '2016-11-08 19:26:55',
                'updated_at' => '2016-11-08 19:26:55',
            ],
        ];

        $this
            ->seeInDatabase('books', $books[0])
            ->seeInDatabase('books', $books[1])
            ->makeRequest('DELETE', '/book/1')
            ->seeRouteIs('book.index')
            ->see('Successfully deleted the book!')
            ->notSeeInDatabase('books', $books[0])
            ->seeInDatabase('books', $books[1])
            ->makeRequest('DELETE', '/book/2')
            ->seeRouteIs('book.index')
            ->see('Successfully deleted the book!')
            ->notSeeInDatabase('books', $books[1]);
    }
}
