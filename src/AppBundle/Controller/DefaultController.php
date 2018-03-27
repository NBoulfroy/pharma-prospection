<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Profile;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        if ($this->getUser() != null || !empty($this->getUser())) {
            return $this->render('default/index.html.twig');
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction()
    {
        if ($this->getUser() != null || !empty($this->getUser())) {
            $profile = $this->getDoctrine()->getRepository(Profile::class)->findBy(array(
                'person' => $this->getUser()->getId()
            ));

            return $this->render('default/profile.html.twig', array(
                'data' => $profile
            ));
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
