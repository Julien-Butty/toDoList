<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 20/07/2018
 * Time: 17:13.
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadUsers extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('admin');
        $user1->setEmail('julienbutty@gmail.com');
        $password = $this->encoder->encodePassword($user1, '123456');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setActive(1);
        $manager->persist($user1);
        $this->addReference('user1', $user1);

        $user2 = new User();
        $user2->setUsername('user');
        $user2->setEmail('julienbutty+1@gmail.com');
        $password = $this->encoder->encodePassword($user2, '123456');
        $user2->setPassword($password);
        $user2->setRoles(['ROLE_USER']);
        $user1->setActive(1);
        $manager->persist($user2);
        $this->addReference('user2', $user2);

        $manager->flush();
    }
}
