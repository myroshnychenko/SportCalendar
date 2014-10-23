<?php

namespace WSP\ThirdBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WSP\ThirdBundle\Entity\Student;

class DefaultController extends Controller
{
    /**
     * @Route("/show/{path}")
     * @Cache(maxage="+900 seconds", public=true)
     * @param Student $student
     * @return Response
     */
    public function showAction(Student $student)
    {
        return $this->render('ThirdBundle:Default:index.html.twig', array('student' => $student));
    }
}
