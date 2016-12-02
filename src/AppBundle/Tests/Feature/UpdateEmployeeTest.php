<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;

/**
 * Class UpdateEmployeeTest
 * @package AppBundle\Tests\Feature
 */
class UpdateEmployeeTest extends CreateEmployeeTest
{
    /**
     * @test
     * @param int $count
     */
    public function shouldSaveEmployeeIfProperDataIsGivenAndRedirectToEmployeesList($count = 1)
    {
        parent::shouldSaveEmployeeIfProperDataIsGivenAndRedirectToEmployeesList(3);
    }

    /**
     * @test
     * @param int $count
     */
    public function shouldNotRequireBio($count = 1)
    {
        parent::shouldNotRequireBio(3);
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadEmployeeData()];
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/employee/1/edit';
    }
}
