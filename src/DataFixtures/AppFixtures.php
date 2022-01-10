<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName('Grab1');

        $category2 = new Category();
        $category2->setName('Rotation1');

        $category3 = new Category();
        $category3->setName('Flip1');

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);


        $user = new User();
        $user   ->setFirstname('user2')
                ->setLastname('user2')
                ->setEmail('user2@email.com')
                ->setPassword('password2') 
                ->setRoles(['ROLE_USER']);

        $manager->persist($user);  

        $trick = new Trick();
        $trick  ->setName('360')
                ->setDescription('description')
                ->setCategory($category3) 
                ->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ;

        $manager->persist($trick);

        $comment = new Comment();
        $comment ->setUser($user)
                ->setContent('Mon comment')      
                ->setTrick($trick); 

        $manager->persist($comment);

        $manager->flush();
    }

}
