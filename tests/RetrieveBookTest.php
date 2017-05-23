<?php

class RetrieveBookTest extends TestCase
{
    /**
     * @before
     */
    protected function seedBooks()
    {
        $this->seed(BooksTableSeeder::class);
    }

    /**
     * @test
     */
    public function shouldReturn404IfNoSuchBook()
    {
        $this->json('GET', '/book/3')->assertResponseStatus(\Illuminate\Http\Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function shouldSeeIndexButton()
    {
        $this->visit('/book/2')->seeLink('Index', '/book');
    }

    /**
     * @test
     */
    public function shouldSeeBookTitleAsHeading()
    {
        $this->visit('/book/2')->seeInElement('h1', 'Clean Code: A Handbook of Agile Software Craftsmanship');
    }

    /**
     * @test
     */
    public function shouldSeeAuthor()
    {
        $this->visit('/book/2')
            ->seeInElement('.author strong', 'Author:')
            ->seeInElement('.author span', 'Robert C. Martin');
    }

    /**
     * @test
     */
    public function shouldSeePriceWithDollarSign()
    {
        $this->visit('/book/2')
            ->seeInElement('.price strong', 'Price:')
            ->seeInElement('.price span', '41.6 $');
    }

    /**
     * @test
     */
    public function shouldSeeEditButton()
    {
        $this->visit('/book/2')->seeLink('Edit', '/book/2/edit');
    }
}
