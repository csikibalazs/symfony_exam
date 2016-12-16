<?php

namespace Innonic\JobBundle\Controller;

use Innonic\JobBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class JobController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function IndexAction()
    {
        $categories = $this->getDoctrine()->getRepository('JobBundle:Category')->findAll();

        foreach ($categories as $category) {
            $jobCategories[$category->getId()]['jobs'] = $this->getDoctrine()->getRepository('JobBundle:Job')->findBy(
                array(
                    'category' => $category->getId()
                )
            );
            $jobCategories[$category->getId()]['name'] = $category->getCategory();
            $jobCategories[$category->getId()]['slug'] = $category->getSlug();

        }

        return $this->render('JobBundle:Job:index.html.twig', array(
            'jobCategories' => $jobCategories
        ));
    }

    /**
     * show a job
     *
     * @param string $slug
     * @return array
     *
     * @Route("/job/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        $job = $this->getDoctrine()->getRepository('JobBundle:Job')->findOneBy(
            array(
                'slug' => $slug
            )
        );

        return $this->render('JobBundle:Job:_job.html.twig', array(
            'job' => $job
        ));
    }

    /**
     * Show jobs in category
     *
     * @param $slug
     * @return array
     *
     * @Route("/category/{slug}")
     * @Template()
     */
    public function categoryListAction($slug)
    {
        $category = $this->getDoctrine()->getRepository('JobBundle:Category')->findOneBy(
            array(
                'slug' => $slug
            )
        );

        $jobsInCategory = $this->getDoctrine()->getRepository('JobBundle:Job')->findBy(
            array(
                'category' => $category->getId()
            )
        );

        return $this->render('JobBundle:Job:category.html.twig', array(
            'jobsInCategory' => $jobsInCategory
        ));
    }

    /**
     * Creates a new job entity.
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
        $job = new Job();
        $form = $this->createForm('Innonic\JobBundle\Form\JobType', $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $job->setSlug($form->getData()->getTitle());
            $em->persist($job);
            $em->flush();
            return $this->redirectToRoute('innonic_job_job_index', array('id' => $job->getId()));
        }
        return $this->render('JobBundle:Job:new.html.twig', array(
                'job' => $job,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @param Request $request
     * @param Job    $job
     *
     * @return array
     *
     * @Route("/edit/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Job $job)
    {
        $editForm = $this->createForm('Innonic\JobBundle\Form\JobType', $job);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
            return $this->redirectToRoute('innonic_job_job_edit', array('id' => $job->getId()));
        }
        return $this->render('JobBundle:Job:edit.html.twig', array(
                'menu' => $job,
                'edit_form' => $editForm->createView(),
            )
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @param Request $request
     * @param Job    $job
     *
     * @return RedirectResponse
     *
     * @Route("/delete/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }
        return $this->redirectToRoute('innonic_job_job_index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Job $job
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_admin_post_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}
