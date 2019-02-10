<?php

namespace App\tests\Service\ControllerHandler;

use App\Entity\Task;
use App\Entity\User;
use App\Service\ControllerHandler\TaskHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormInterface;

class TaskHandlerTest extends TestCase
{
    /**
     * @dataProvider formStatus
     */
    public function testCreateTask(bool $status)
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $taskType = $this->createMock(FormInterface::class);
        $task = new Task();
        $task->setContent('test');
        $user = new User();

        $taskHandler = new TaskHandler($entityManager);

        $taskType->method('isSubmitted')->willReturn($status);
        $taskType->method('isValid')->willReturn($status);

        $this->assertEquals($status, $taskHandler->createTask($taskType, $task, $user));
    }

    public function testEditTaskSubmitted()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $taskType = $this->createMock(FormInterface::class);
        $task = new Task();
        $task->setContent('test');

        $taskHandler = new TaskHandler($entityManager);

        $taskType->method('isSubmitted')->willReturn(true);
        $taskType->method('isValid')->willReturn(true);

        $task->setContent('testedit');

        $this->assertTrue($taskHandler->editTask($taskType, $task));
        $this->assertEquals('testedit', $task->getContent());
    }

    public function testEditTaskNoSubmitted()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $taskType = $this->createMock(FormInterface::class);
        $task = new Task();
        $task->setContent('test');

        $taskHandler = new TaskHandler($entityManager);

        $this->assertFalse($taskHandler->editTask($taskType, $task));
    }

    public function testToggleTask()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $task = new Task();

        $taskHandler = new TaskHandler($entityManager);

        $this->assertEquals($task->isDone(), $taskHandler->toggleTask($task));
    }

    public function testDeleteTask()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $task = new Task();
        $taskHandler = new TaskHandler($entityManager);

        $taskHandler->deleteTask($task);

        $this->assertNull($task->getId());
    }

    public function formStatus()
    {
        return [
            [
                'status' => true,
            ],
            [
                'status' => false,
            ],
        ];
    }
}
