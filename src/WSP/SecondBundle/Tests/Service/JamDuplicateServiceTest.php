<?php

namespace WSP\SecondBundle\Tests\Service;

use PHPUnit_Framework_TestCase;
use WSP\SecondBundle\Service\JamDuplicateService;

class JamDuplicateServiceTest extends PHPUnit_Framework_TestCase
{
    public function duplicateProvider()
    {
        return array(
            array(0, 0),
            array(1, 1),
            array(2, 2),
            array(5, 5),
            array(20, 20),
        );
    }

    /**
     * @dataProvider duplicateProvider
     */
    public function testDuplicate($count, $expectedCount)
    {
        $jam = $this->getMock('\WSP\SecondBundle\Entity\Jam');
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->exactly($expectedCount))
            ->method('persist');
        $em->expects($this->once())
            ->method('flush');
        $jamService = new JamDuplicateService($em);
        $jamService->duplicate($jam, $count);
    }
}
