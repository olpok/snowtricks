<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Address;
use App\Entity\Comment;
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

        $user = new User();
        $user   ->setFirstname('user1')
                ->setLastname('user1')
                ->setEmail('user1@email.com')
                ->setPassword('password1')
                ->setPhoto('photo1') 
                ->setPhoneNumber(0600000000) 
                ->setRole('user');

        $manager->persist($user);
            
        $address = new Address();
        $address->setUser($user)
                ->setNumber(10)
                ->setStreet('rue') 
                ->setComplement('rien')
                ->setZip('33000')      
                ->setCity('Bordeaux')
                ->setCountry('France');  

        $manager->persist($address);  

        $trick = new Trick();
        $trick  ->setName('Mute')
                ->setDescription('description')
                ->setCategory($category1) 
                ->setUser($user);

        $manager->persist($trick);

        $comment = new Comment();
        $comment ->setUser($user)
                ->setContent('Mon premier comment')      
                ->setTrick($trick); 

        $manager->persist($comment);

        $manager->flush();
    }


}
