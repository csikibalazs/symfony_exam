<?php

namespace Innonic\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MenuController extends Controller
{
    /**
     *
     * @param string $position
     * @return array
     *
     * @Route("")
     */
    public function indexAction($position)
    {
        $menu = $this->getDoctrine()->getRepository('JobBundle:Menu')->findBy(
            array(
                'position' => $position
            )
        );

        return $this->render('JobBundle:Menu:menu.html.twig', array(
            'menu' => $menu
        ));
    }

}
