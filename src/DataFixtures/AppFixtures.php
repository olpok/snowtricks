<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $category1 = new Category();
        $category1->setName('Grab');

        $category2 = new Category();
        $category2->setName('Rotation');

        $category3 = new Category();
        $category3->setName('Flip');

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);

        $manager->flush();
    }
}
