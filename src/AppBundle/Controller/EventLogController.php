<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EventLog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Eventlog controller.
 *
 * @Route("eventlog")
 */
class EventLogController extends Controller
{
    /**
     * Lists all eventLog entities.
     *
     * @Route("/", name="eventlog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eventLogs = $em->getRepository('AppBundle:EventLog')->findAll();

        return $this->render('eventlog/index.html.twig', array(
            'eventLogs' => $eventLogs,
        ));
    }

    /**
     * Finds and displays a eventLog entity.
     *
     * @Route("/{id}", name="eventlog_show")
     * @Method("GET")
     */
    public function showAction(EventLog $eventLog)
    {
        return $this->render('eventlog/show.html.twig', array(
            'eventLog' => $eventLog,
        ));
    }
}
