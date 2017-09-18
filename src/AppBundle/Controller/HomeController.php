<?php

/*
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * rapierController.
 */
class HomeController extends Controller
{

    /**
     * @Route("/", name="app_homepage")
     *
     * @param Request $request Request
     *
     * @return Response
     */
    public function homepageAction(Request $request)
    {
        return $this->render('base.html.twig', []);
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     *
     * @param Request $request Request
     *
     * @return Response
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('base.html.twig', []);
    }
}
