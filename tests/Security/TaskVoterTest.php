<?php


namespace App\tests\Security;


use App\Entity\Task;
use App\Entity\User;
use App\Security\TaskVoter;
use PHPUnit\Framework\TestCase;

class TaskVoterTest extends TestCase
{
    public function testCanEdit()
    {
        $user = new User();
        $user->setRoles(['ROLE-ADMIN']);

        $task = new Task();
        $task->setUser($user);

        $voter = new TaskVoter();

        $this->assertTrue($voter->canEdit($task, $user));
    }

    public function testCanDelete()
    {
        $user = new User();
        $user->setRoles(['ROLE-ADMIN']);

        $task = new Task();
        $task->setUser($user);

        $voter = new TaskVoter();

        $this->assertTrue($voter->canDelete($task, $user));
    }
}