<?php


namespace App\tests\Form;


use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitForm()
    {
        $task = new Task();

        $formData = [
            'title' => 'test',
            'content' => 'test'
        ];

        $form = $this->factory->create(TaskType::class, $task);

        $task->setTitle('test');
        $task->setContent('test');

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($task, $form->getData());
    }

    protected function getExtensions()
    {
        return [new ValidatorExtension(Validation::createValidator())];
    }

}