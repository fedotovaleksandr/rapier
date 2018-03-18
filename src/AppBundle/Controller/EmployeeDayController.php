<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EmployeeDay;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Employeeday controller.
 *
 * @Route("employeeday")
 */
class EmployeeDayController extends Controller
{
    /**
     * Lists all employeeDay entities.
     *
     * @Route("/", name="employeeday_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $employeeDays = $em->getRepository('AppBundle:EmployeeDay')->findAll();

        return $this->render('employeeday/index.html.twig', array(
            'employeeDays' => $employeeDays,
        ));
    }

    /**
     * Creates a new employeeDay entity.
     *
     * @Route("/new", name="employeeday_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $employeeDay = new Employeeday();
        $form = $this->createForm('AppBundle\Form\EmployeeDayType', $employeeDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($employeeDay);
            $em->flush();

            return $this->redirectToRoute('employeeday_show', array('day' => $employeeDay->getDay()));
        }

        return $this->render('employeeday/new.html.twig', array(
            'employeeDay' => $employeeDay,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a employeeDay entity.
     *
     * @Route("/{day}", name="employeeday_show")
     * @Method("GET")
     */
    public function showAction(EmployeeDay $employeeDay)
    {
        $deleteForm = $this->createDeleteForm($employeeDay);

        return $this->render('employeeday/show.html.twig', array(
            'employeeDay' => $employeeDay,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing employeeDay entity.
     *
     * @Route("/{day}/edit", name="employeeday_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EmployeeDay $employeeDay)
    {
        $deleteForm = $this->createDeleteForm($employeeDay);
        $editForm = $this->createForm('AppBundle\Form\EmployeeDayType', $employeeDay);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employeeday_edit', array('day' => $employeeDay->getDay()));
        }

        return $this->render('employeeday/edit.html.twig', array(
            'employeeDay' => $employeeDay,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a employeeDay entity.
     *
     * @Route("/{day}", name="employeeday_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EmployeeDay $employeeDay)
    {
        $form = $this->createDeleteForm($employeeDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employeeDay);
            $em->flush();
        }

        return $this->redirectToRoute('employeeday_index');
    }

    /**
     * Creates a form to delete a employeeDay entity.
     *
     * @param EmployeeDay $employeeDay The employeeDay entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EmployeeDay $employeeDay)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employeeday_delete', array('day' => $employeeDay->getDay())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
