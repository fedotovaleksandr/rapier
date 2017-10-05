<?php

/*
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_user")
 */
class User extends BaseUser
{
    const ROLE_COMPANY_OWNER  = 'ROLE_COMPANY_OWNER';
    const ROLE_MANAGER  = 'ROLE_MANAGER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_EMPLOYEE = 'ROLE_EMPLOYEE';

    public static function getAvailableRoles(): array {
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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;
    }
}
