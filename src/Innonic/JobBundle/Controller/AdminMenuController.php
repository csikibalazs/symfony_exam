<?php

namespace Innonic\JobBundle\Controller;

use Innonic\JobBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Menu controller.
 *
 * @Route("admin/menu")
 */
class AdminMenuController extends Controller
{
    /**
     * Lists all menu entities.
     *
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('JobBundle:Menu')->findAll();

        return $this->render('menu/index.html.twig', array(
            'menus' => $menus,
        ));
    }

    /**
     * Finds and displays a menu entity.
     *
     * @param Menu $menu
     * @return array
     *
     * @Route("/show/{id}")
     * @Method("GET")
     */
    public function showAction(Menu $menu)
    {

        return $this->render('menu/show.html.twig', array(
            'menu' => $menu,
        ));
    }

    /**
     * Creates a new menu entity.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $menu = new Menu();
        $form = $this->createForm('Innonic\JobBundle\Form\MenuType', $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute('innonic_job_adminmenu_index', array('id' => $menu->getId()));
        }
        return $this->render('menu/new.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @param Request $request
     * @param Menu    $menu
     *
     * @return array
     *
     * @Route("/edit/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Menu $menu)
    {
        $editForm = $this->createForm('Innonic\JobBundle\Form\MenuType', $menu);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute('innonic_job_adminmenu_edit', array('id' => $menu->getId()));
        }
        return $this->render('menu/edit.html.twig', array(
            'menu' => $menu,
            'edit_form' => $editForm->createView(),
            )
        );
    }
}
