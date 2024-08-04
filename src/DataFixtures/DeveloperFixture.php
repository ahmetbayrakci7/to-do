<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeveloperFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $developer = new Developer();
            $developer->setName('DEV'.$i);
            $developer->setDuration(1);
            $developer->setDifficulty($i);
            $developer->setWeeklyHours(45);
            $developer->setCreatedAt(new \DateTime());
            $manager->persist($developer);
        }

        $manager->flush();
    }
}
