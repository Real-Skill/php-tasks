<?php

class UpdateBookTest extends CreateBookTest
{
    protected $uri = '/book/1/edit';
    protected $flashMessageAfterSave = 'Successfully updated book!';

    /**
     * @test
     */
    public function shouldSeeProperHeader()
    {
        $this->visit($this->uri)->seeInElement('h1', 'Edit Test Driven Development: By Example');
    }
}
