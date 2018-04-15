<?php
/**
 * Created by PhpStorm.
 * User: afedotov
 * Date: 14.04.18
 * Time: 15:08.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\RouteResource("common", pluralize=false)
 */
class CommonController extends FOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns employee Events",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@ApiDoc\Model(type=Event::class, groups={"list"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="employeeId",
     *     in="query",
     *     type="integer",
     *     description="The employeeId"
     * )
     * @SWG\Tag(name="Common")
     * @Rest\View(serializerGroups={"list"})
     * @ApiDoc\Security(name="ApiKey")
     *
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getEventsAction(Request $request)
    {
        $employeeId = $request->get('employeeId');
        $user = null;
        if ($employeeId) {
            $employee = $this->getEmployeeRepository()->find($employeeId);
        }

        if (!$employee) {
            throw $this->createNotFoundException(
                sprintf('%s employee does not exist', $employeeId)
            );
        }

        return $this->view($this->getEventRepository()->findBy(['employee' => $employee]));
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@ApiDoc\Model(type=Employee::class, groups={"list"}))
     *     )
     * )
     * @SWG\Tag(name="Common")
     * @Rest\View(serializerGroups={"list"})
     * @ApiDoc\Security(name="ApiKey")
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getEmployeesAction()
    {
        return $this->view($this->getEmployeeRepository()->findAll());
    }

    protected function getEmployeeRepository(): EntityRepository
    {
        return $this->get('doctrine.orm.default_entity_manager')
            ->getRepository(Employee::class);
    }

    protected function getEventRepository(): EntityRepository
    {
        return $this->get('doctrine.orm.default_entity_manager')
            ->getRepository(Event::class);
    }
}
