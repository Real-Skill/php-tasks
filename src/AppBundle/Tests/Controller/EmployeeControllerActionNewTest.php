<?php

namespace AppBundle\Tests\Controller;

/**
 * Class EmployeeControllerActionNewTest
 * @package AppBundle\Tests\Controller
 */
class EmployeeControllerActionNewTest extends AbstractEmployeeControllerActionEditTest
{
    /**
     * @return string
     */
    protected function getPath()
    {
        return '/employee/new';
    }
}
