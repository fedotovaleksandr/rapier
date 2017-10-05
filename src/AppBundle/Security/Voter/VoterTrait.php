<?php


namespace AppBundle\Security\Voter;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

trait VoterTrait
{
    /**
     * @param string $wrongAction
     * @return \InvalidArgumentException
     */
    protected function createActionException(string $wrongAction): \InvalidArgumentException
    {
        new \InvalidArgumentException(sprintf('%s not supported action',$wrongAction));
    }

    /**
     * @param TokenInterface $token
     * @return User
     */
    protected function getUser(TokenInterface $token): User{
        return $token->getUser();
    }
}