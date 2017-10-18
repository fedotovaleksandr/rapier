<?php

namespace AppBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventVoter extends Voter
{
    use VoterTrait;

    const VIEW = 'view';

    const EDIT = 'edit';

    const VIEW_SCHEDULES = 'edit';
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
        // @todo: Implement supports() method.
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // @todo: Implement voteOnAttribute() method.
    }
}
