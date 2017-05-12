<?php

class UpdateBookTest extends CreateBookTest
{
    protected $method = 'PUT';
    protected $uri = '/api/book/1';

    /**
     * @test
     */
    public function shouldSaveBookWithProperPayloadAndReturnItsData()
    {
        $payload = parent::shouldSaveBookWithProperPayloadAndReturnItsData(2);
        $book = App\Book::find(1);

        $this->assertEquals($payload, [
            'title' => $book->title,
            'author' => $book->author,
            'price' => $book->price,
        ]);
    }
}
