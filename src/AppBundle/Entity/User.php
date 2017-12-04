<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_user")
 */
class User extends BaseUser
{
    const ROLE_COMPANY_OWNER = 'ROLE_COMPANY_OWNER';
    const ROLE_MANAGER = 'ROLE_MANAGER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_EMPLOYEE = 'ROLE_EMPLOYEE';

    /**
     * @return array
     */
    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_DEFAULT,
            self::ROLE_SUPER_ADMIN,
            self::ROLE_COMPANY_OWNER,
            self::ROLE_ADMIN,
            self::ROLE_MANAGER,
            self::ROLE_EMPLOYEE,
        ];
    }

    /**
     * @return array
     */
    public static function getEmployeeAvailableRoles(): array
    {
        return [
            self::ROLE_COMPANY_OWNER,
            self::ROLE_ADMIN,
            self::ROLE_MANAGER,
            self::ROLE_EMPLOYEE,
        ];
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Employee
     * @ORM\OneToOne(targetEntity="Employee", mappedBy="user", cascade="all")
     */
    protected $employee;

    /**
     * @return Employee|null
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee|null $employee
     */
    public function setEmployee(?Employee $employee)
    {
        $this->employee = $employee;
    }
}
