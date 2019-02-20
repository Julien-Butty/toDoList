<?php

namespace Repository;

use App\Entity\Task;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testFindAllByCached()
    {
        $task = $this->entityManager->getRepository(Task::class)->findAllByCached();

        $this->assertGreaterThan(0, $task);
    }

    public function testFindDOneByCached()
    {
        $task = $this->entityManager->getRepository(Task::class)->findDOneByCached();
        $this->assertGreaterThan(0, $task);
    }
}
