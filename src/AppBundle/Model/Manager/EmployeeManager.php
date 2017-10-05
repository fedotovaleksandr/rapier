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
     * @param EntityRepository $roleRepository
     * @param EntityManager    $entityManager
     */
    public function __construct(EntityRepository $roleRepository,EntityManager $entityManager)
    {
        $this->roleRepository = $roleRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array|string[]    $roleNames
     * @param Employee $employee
     */
    public function addEntityRoles(array $roleNames , Employee $employee): void
    {
        foreach ($roleNames as $roleName) {
            $entityRole = new Role($roleName);
            $existedRole = $this->roleRepository->findOneBy(['roleName'=> $entityRole->getRoleName()]) ?? $entityRole;
            $employee->addRole($existedRole);
            $this->entityManager->persist($employee);
            $this->entityManager->flush();
        }
    }

    public function addRemoveRoles(array $roleNames , Employee $employee)
    {
        //@todo implement me
    }
}