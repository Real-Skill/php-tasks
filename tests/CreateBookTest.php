<?php

class CreateBookTest extends TestCase
{
    protected $uri = '/book/create';
    protected $flashMessageAfterSave = 'Successfully created book!';

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
    public function shouldSeeIndexButton()
    {
        $this->visit($this->uri)->seeLink('Index', '/book');
    }

    /**
     * @test
     */
    public function shouldSeeProperHeader()
    {
        $this->visit($this->uri)->seeInElement('h1', 'Create book');
    }

    /**
     * @test
     */
    public function shouldSeeTitleInputOfTypeTextInForm()
    {
        $this->visit($this->uri)
            ->seeInElement('form label[for=title]', 'Title:')
            ->seeElement('form #title', ['name' => 'title', 'type' => 'text']);
    }

    /**
     * @test
     */
    public function shouldSeeAuthorInputOfTypeTextInForm()
    {
        $this->visit($this->uri)
            ->seeInElement('form label[for=author]', 'Author:')
            ->seeElement('form #author', ['name' => 'author', 'type' => 'text']);
    }

    /**
     * @test
     */
    public function shouldSeePriceInputOfTypeNumberWithHtml5MinNumberValidationInForm()
    {
        $this->visit($this->uri)
            ->seeInElement('form label[for=price]', 'Price:')
            ->seeElement('form #price', ['name' => 'price', 'type' => 'number', 'min' => 0]);
    }

    /**
     * @test
     */
    public function shouldSeeSubmitButtonWithTextSaveBookInForm()
    {
        $this->visit($this->uri)->seeElement('form [type=submit]', ['value' => 'Save book']);
    }

    /**
     * @test
     */
    public function shouldNotSaveBookIfTitleIsTooShortAndShowProperErrorMessage()
    {
        $values = [
            'title' => 'aa',
            'author' => 'bbb',
            'price' => -1,
        ];

        $this->visit($this->uri)->submitForm('Save book', $values)
            ->notSeeInDatabase('books', $values)
            ->see('The title must be between 3 and 128 characters.');
    }

    /**
     * @test
     */
    public function shouldNotSaveBookIfTitleIsTooLongAndShowProperErrorMessage()
    {
        $values = [
            'title' => str_repeat('a', 129),
            'author' => 'bbb',
            'price' => -1,
        ];

        $this->visit($this->uri)->submitForm('Save book', $values)
            ->notSeeInDatabase('books', $values)
            ->see('The title must be between 3 and 128 characters.');
    }

    /**
     * @test
     */
    public function shouldNotSaveBookIfAuthorIsTooShortAndShowProperErrorMessage()
    {
        $values = [
            'title' => 'aaa',
            'author' => 'bb',
            'price' => -1,
        ];

        $this->visit($this->uri)->submitForm('Save book', $values)
            ->notSeeInDatabase('books', $values)
            ->see('The author must be between 3 and 128 characters.');
    }

    /**
     * @test
     */
    public function shouldNotSaveBookIfAuthorIsTooLongAndShowProperErrorMessage()
    {
        $values = [
            'title' => 'aaa',
            'author' => str_repeat('b', 129),
            'price' => -1,
        ];

        $this->visit($this->uri)->submitForm('Save book', $values)
            ->notSeeInDatabase('books', $values)
            ->see('The author must be between 3 and 128 characters.');
    }

    /**
     * @test
     */
    public function shouldNotSaveBookIfPriceIsNegative()
    {
        $values = [
            'title' => 'aaa',
            'author' => 'bbb',
            'price' => -1,
        ];

        $this->visit($this->uri)->submitForm('Save book', $values)
            ->notSeeInDatabase('books', $values)
            ->see('The price must be at least 0.');
    }

    /**
     * @test
     */
    public function shouldSaveBookIfProperValuesHasBeenGivenAndRedirectToBookIndexAndDisplayFlashMessage()
    {
        $values = [
            'title' => str_repeat('a', 128),
            'author' => str_repeat('b', 128),
            'price' => 0,
        ];

        $this->visit($this->uri)->submitForm('Save book', $values)
            ->seeInDatabase('books', $values)
            ->seeRouteIs('book.index')
            ->see($this->flashMessageAfterSave);
    }
}
