<?php

namespace WSP\ThirdBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class TestLoader extends DataFixtureLoader
{

    /**
     * Returns an array of file paths to fixtures
     *
     * @return array<string>
     */
    protected function getFixtures()
    {
        return array(
            __DIR__ . '/students.yml',
        );
    }
}
