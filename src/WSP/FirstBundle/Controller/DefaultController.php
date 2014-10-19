<?php

namespace WSP\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WSP\FirstBundle\Service\SportCalendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="first_homepage")
     */
    public function indexAction()
    {
        $statistic = $this->get('wsp_first_bundle.sport_calendar')->getStatistic($this->getUser());
        return $this->render('FirstBundle:Default:statistic.html.twig', array('statistic' => $statistic));
    }
}
