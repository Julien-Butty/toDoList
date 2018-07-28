<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 20/07/2018
 * Time: 17:20
 */

namespace App\DataFixtures;


use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTask extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $task1 = new Task();
        $task1->setTitle('Mise en place de l\'authorisation');
        $task1->setContent('Créer le systeme de voter');
        $task1->setUser($this->getReference('user1'));
        $manager->persist($task1);


        $task2 = new Task();
        $task2->setTitle('Implémentation des tests automatisés');
        $task2->setContent("Faire les test unitaires et fonctionnels");
        $task2->setUser($this->getReference('user2'));
        $manager->persist($task2);


        $task3 = new Task();
        $task3->setTitle('Task Anonyme');
        $task3->setContent("Essai user anonyme");
        $manager->persist($task3);

        $task4 = new Task();
        $task4->setTitle('Task 2 Anonyme');
        $task4->setContent("Essai 2 user anonyme");
        $manager->persist($task4);

        $task5 = new Task();
        $task5->setTitle('Task pour essai ');
        $task5->setContent("Essai");
        $task5->setUser($this->getReference('user1'));
        $manager->persist($task5);

        $task6 = new Task();
        $task6->setTitle('Task pour essai 2');
        $task6->setContent('Essai 2');
        $task6->setUser($this->getReference('user2'));
        $manager->persist($task6);

        $manager->flush();


    }

    public function getDependencies()
    {
        return array(
            LoadUsers::class,
        );
    }


}