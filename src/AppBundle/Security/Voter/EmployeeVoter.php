<?php

namespace AppBundle\Security\Voter;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EmployeeVoter extends Voter
{
    use VoterTrait;

    const VIEW = 'view';

    const EDIT = 'edit';
    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * EmployeeVoter constructor.
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }


    public static function getAvailableActions(): array
    {
        return [self::EDIT, self::VIEW];
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Employee) {
            return false;
        }
        if (!in_array($attribute, self::getAvailableActions(), true)) {
            throw $this->createActionException($attribute);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, [User::ROLE_SUPER_ADMIN, User::ROLE_COMPANY_OWNER])) {
            return true;
        }

        if ($attribute === self::VIEW) {
            return $this->voteView($subject, $token);
        } elseif ($attribute === self::EDIT) {
            return $this->voteEdit($subject, $token);
        }

        return false;
    }

    /**
     * @param Employee       $employee
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteView(Employee $employee, TokenInterface $token): bool
    {
        if ($this->decisionManager->decide($token, [User::ROLE_ADMIN])) {
            return true;
        }

        if ($this->decisionManager->decide($token, [User::ROLE_MANAGER])) {
            if ($this->getUser($token)->getEmployee()->getEmployees()->contains($employee)) {
                return true;
            }
        }

        if ($this->decisionManager->decide($token, [User::ROLE_EMPLOYEE])) {
            $currentUserEmployee = $this->getUser($token)->getEmployee();
            $managerEmployee = $currentUserEmployee->getManager();
            if ($managerEmployee->getEmployees()->contains($employee)) {
                return true;
            };
        }

        return false;
    }

    /**
     * @param Employee       $employee
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteEdit(Employee $employee, TokenInterface $token): bool
    {
        if ($this->decisionManager->decide($token, [User::ROLE_ADMIN])) {
            if ($employee->getUser() !== $this->getUser($token) && !$employee->getUser()->hasRole(User::ROLE_COMPANY_OWNER)) {
                return true;
            }
        }

        if ($this->decisionManager->decide($token, [User::ROLE_MANAGER])) {
            if ($this->getUser($token)->getEmployee()->getEmployees()->contains($employee)) {
                return true;
            }
        }

        return false;
    }
}