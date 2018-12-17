<?php


namespace App\tests\DataFixtures;


use App\DataFixtures\LoadUsers;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoadFixturesTest extends WebTestCase
{

    private $objectManager;

    private $userRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->objectManager = $this->createMock(ObjectManager::class);
    }

    public function testLoad()
    {
//        $task = new Task();
//
//        $this->userRepository
//            ->expects($this->any())
//            ->method('findOneBy')
//            ->willReturn(new User());
//
//        $this->objectManager
//            ->expects($this->any())
//            ->method('getRepository')
//            ->willReturn($this->userRepository);
//
//        $this->objectManager
//            ->expects($this->any())
//            ->method('persist');
//
//        $this->objectManager
//            ->expects($this->any())
//            ->method('flush');
//
//        $client = static::createClient();
//
//        $passwordEncoder = $client->getContainer()->get('security.password_encoder');
//
//        $fixtures = new LoadUsers($passwordEncoder);
//
//
//        $task->setUser($fixtures->setReference('user1', new User()));
//
//        $fixtures->load($this->objectManager);
//dump($fixtures);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->objectManager = null;
    }
}