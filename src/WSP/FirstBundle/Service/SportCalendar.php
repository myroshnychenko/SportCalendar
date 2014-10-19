<?php
<<<<<<< HEAD

namespace WSP\FirstBundle\Service;

use Doctrine\ORM\EntityRepository;
use WSP\FirstBundle\Entity\User;

class SportCalendar
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->repository = $entityRepository;
    }

    /**
     * Get exercises statistic
     *
     * @param User $user
     * @param \DateTime $date
     * @return array
     */
    public function getStatistic(User $user, \DateTime $date = null)
    {
        if (null === $date) {
            $date = new \DateTime('today');
        }
        $oneWeekAgo = new \DateTime();
        $oneWeekAgo->sub(new \DateInterval('P1W'));
        $twoWeeksAgo = new \DateTime();
        $twoWeeksAgo->sub(new \DateInterval('P2W'));
        $statistic = array(
            'today' =>
                $this->repository->findBy(array(
                    'user' => $user,
                    'date' => $date,
                )),
            'oneWeekAgo' =>
                $this->repository->findBy(array(
                    'user' => $user,
                    'date' => $oneWeekAgo,
                )),
            'twoWeeksAgo' =>
                $this->repository->findBy(array(
                    'user' => $user,
                    'date' => $twoWeeksAgo,
                )),
        );
        return $statistic;
    }
}
=======
/**
 * Created by PhpStorm.
 * User: d.myroshnychenko
 * Date: 10/18/2014
 * Time: 7:48 PM
 */

namespace WSP\Service;


class SportCalendar {

} 
>>>>>>> fac676bc20acf68e0807073b9d0f07df9638cc59
