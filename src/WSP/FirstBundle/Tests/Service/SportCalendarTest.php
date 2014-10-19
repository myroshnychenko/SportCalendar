<?php

namespace WSP\FirstBundle\Tests\Service;

use WSP\FirstBundle\Service\SportCalendar;

class SportCalendarTest extends \PHPUnit_Framework_TestCase
{
    public function testGetListData()
    {
        $expectedData = array(
            'today' => array(),
            'oneWeekAgo' => array(),
            'twoWeeksAgo' => array(),
        );

        $user = $this->getMock('\WSP\FirstBundle\Entity\User');

        $date = new \DateTime('today');
        $oneWeekAgo = new \DateTime();
        $oneWeekAgo->sub(new \DateInterval('P1W'));
        $twoWeeksAgo = new \DateTime();
        $twoWeeksAgo->sub(new \DateInterval('P2W'));

        $exerciseRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $exerciseRepository->expects($this->exactly(3))
            ->method('findBy')
            ->withConsecutive(
                array(array('user' => $user, 'date' => $date), null, null, null),
                array(array('user' => $user, 'date' => $oneWeekAgo), null, null, null),
                array(array('user' => $user, 'date' => $twoWeeksAgo), null, null, null)
            )
            ->will($this->returnValue(array()));

        $calendar = new SportCalendar($exerciseRepository);
        $realData = $calendar->getStatistic($user, $date);

        $this->assertEquals($expectedData, $realData);
    }
}
