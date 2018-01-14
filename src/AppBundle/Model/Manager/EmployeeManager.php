<?php
namespace AppBundle\Model\Manager;
use AppBundle\Entity\Employee;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class EmployeeManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $empRepo;

    /**
     * EmployeeManager constructor.
     *
     * @param EntityManager    $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->empRepo = $entityManager->getRepository(Employee::class);
    }
}
