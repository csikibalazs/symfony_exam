<?php

namespace Innonic\JobBundle\Controller;

use Innonic\JobBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("admin/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('JobBundle:Category')->findAll();

        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/show/{id}")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {

        return $this->render('category/show.html.twig', array(
            'category' => $category,
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
        $category = new Category();
        $form = $this->createForm('Innonic\JobBundle\Form\CategoryType', $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category->setSlug($form->getData()->getCategory());
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('innonic_job_category_index', array('id' => $category->getId()));
        }
        return $this->render('menu/new.html.twig', array(
                'category' => $category,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @param Request $request
     * @param Category    $category
     *
     * @return array
     *
     * @Route("/edit/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createForm('Innonic\JobBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('innonic_job_category_edit', array('id' => $category->getId()));
        }
        return $this->render('menu/edit.html.twig', array(
                'category' => $category,
                'edit_form' => $editForm->createView(),
            )
        );
    }
}
