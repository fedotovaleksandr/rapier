<?php

namespace AppBundle\Model\Manager;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Role;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class EmployeeManager
{
    /**
     * @var EntityRepository
     */
    private $roleRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * EmployeeManager constructor.
     *
     * @param EntityRepository $roleRepository
     * @param EntityManager    $entityManager
     */
    public function __construct(EntityRepository $roleRepository, EntityManager $entityManager)
    {
        $this->roleRepository = $roleRepository;
        $this->entityManager = $entityManager;
    }
}
