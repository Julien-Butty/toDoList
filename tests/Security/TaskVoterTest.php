<?php


namespace App\tests\Security;


use App\Entity\Task;
use App\Entity\User;
use App\Security\TaskVoter;
use PHPUnit\Framework\TestCase;

class TaskVoterTest extends TestCase
{

    public function voteOnAttributeTest()
    {
        $reflectionClass = new \ReflectionClass(TaskVoterTest::class);
        $reflectionMethod = $reflectionClass->getMethod('voteOnAttribute');
        $reflectionMethod->setAccessible(true);

        $voter = new TaskVoter();
        $task = new Task();
        $attribute = 'EDIT';




    }
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