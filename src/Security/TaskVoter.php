<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 15/07/2018
 * Time: 11:27
 */

namespace App\Security;





use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;


class TaskVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::EDIT, self::DELETE))) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        /** @var Task $task */
        $task = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($task, $user);
            case  self::DELETE:
                return $this->canDelete($task, $user);
        }

        throw new \LogicException('This code should not be reached');
    }

    public function canEdit(Task $task, User $user)
    {
        if ($task->getUser() === $user ) {
            return true;
        }

        if ($task->getUser() === null && in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return false;
    }

    public function canDelete(Task $task, User $user)
    {
        if ($task->getUser() === $user ) {
            return true;
        }

        if ($task->getUser() === null && in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return false;
    }


}