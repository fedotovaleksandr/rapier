<?php


namespace AppBundle\Security\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EmployeeDayVoter extends Voter
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
     *
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        // TODO: Implement supports() method.
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // TODO: Implement voteOnAttribute() method.
    }
}