<?php

class RetrieveBooksTest extends TestCase
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
    public function shouldSeeBooksHeader()
    {
        $this->visit('/book')->seeInElement('h1', 'Books');
    }

    /**
     * @test
     */
    public function shouldSeeBooksListTableHeader()
    {
        $this->visit('/book')
            ->seeInElement('thead .id', 'ID')
            ->seeInElement('thead .title', 'Title')
            ->seeInElement('thead .author', 'Author')
            ->seeInElement('thead .price', 'Price')
            ->seeInElement('thead .actions', 'Actions');
    }

    /**
     * @test
     */
    public function shouldSeeBooksListTableContent()
    {
        $this->visit('/book')
            ->seeInElement('tbody tr:nth-child(1) .id', '1')
            ->seeInElement('tbody tr:nth-child(1) .title', 'Test Driven Development: By Example')
            ->seeInElement('tbody tr:nth-child(1) .author', 'Kent Beck')
            ->seeInElement('tbody tr:nth-child(1) .price', '39.51')
            ->seeInElement('tbody tr:nth-child(2) .id', '2')
            ->seeInElement('tbody tr:nth-child(2) .title', 'Clean Code: A Handbook of Agile Software Craftsmanship')
            ->seeInElement('tbody tr:nth-child(2) .author', 'Robert C. Martin')
            ->seeInElement('tbody tr:nth-child(2) .price', '41.60');
    }

    /**
     * @test
     */
    public function shouldSeeButtonShowForEachBookWithProperLink()
    {
        $this->visit('/book')
            ->within('tbody tr:nth-child(1)', function () {
                $this->seeLink('Show', '/book/1');
            })
            ->within('tbody tr:nth-child(2)', function () {
                $this->seeLink('Show', '/book/2');
            });
    }

    /**
     * @test
     */
    public function shouldSeeButtonEditForEachBookWithProperLink()
    {
        $this->visit('/book')
            ->within('tbody tr:nth-child(1)', function () {
                $this->seeLink('Edit', '/book/1/edit');
            })
            ->within('tbody tr:nth-child(2)', function () {
                $this->seeLink('Edit', '/book/2/edit');
            });
    }

    /**
     * @test
     */
    public function shouldSeeButtonDeleteForEachBookWithinFormToPerformDeleteOperation()
    {
        $this->visit('/book')
            ->within('tbody tr:nth-child(1)', function () {
                $form = $this->getForm('Delete');
                $this->assertRegExp('#/book/1$#', $form->getUri());
                $this->assertEquals($form->getMethod(), 'POST');
                $this->assertEquals($form->get('_method')->getValue(), 'DELETE');
            })
            ->within('tbody tr:nth-child(2)', function () {
                $form = $this->getForm('Delete');
                $this->assertRegExp('#/book/2$#', $form->getUri());
                $this->assertEquals($form->getMethod(), 'POST');
                $this->assertEquals($form->get('_method')->getValue(), 'DELETE');
            });
    }

    /**
     * @test
     */
    public function shouldSeeCreateButton()
    {
        $this->visit('/book')->seeLink('Create', '/book/create');
    }
}
