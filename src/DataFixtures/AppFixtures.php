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

        $category = new Category();
        $category->setName('test');

        $manager->persist($category);

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
                ->setCategory($category) 
                ->setUser($user);

        $manager->persist($trick);

        $comment = new Comment();
        $comment ->setUser($user)
                ->setContent('Mon comment')      
                ->setTrick($trick); 

        $manager->persist($comment);

        $manager->flush();
    }

}
