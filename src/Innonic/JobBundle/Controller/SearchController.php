<?php

namespace Innonic\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Innonic\JobBundle\Services\JobManager;

class SearchController extends Controller
{
    /**
     * @Route("/search")
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        $results = $this->getJobManager()->findByKeyWord($request->query->get('keywords'));

        return $this->render('JobBundle:Search:index.html.twig', array(
            'results' => $results
        ));
    }

    /**
     * Get post manager
     *
     * @return JobManager
     */
    private function getJobManager()
    {
        return $this->get('jobManager');
    }

}
