<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Video;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture   
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName('Grab');

        $category2 = new Category();
        $category2->setName('Rotation');

        $category3 = new Category();
        $category3->setName('Flip');

        $category4 = new Category();
        $category4->setName('Slide');

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);


        $user = new User();
        $password = $this->passwordEncoder->encodePassword($user, 'Password');
        $user->setPassword($password);
        $user   ->setFirstname('user')
                ->setLastname('user')
                ->setEmail('user@email.com')
                ->setRoles([])
                ->setIsVerified('true');

        $manager->persist($user);  

        $trick1 = new Trick();
        $trick1  ->setName("front flip")
                ->setDescription('Rotation verticale avant')
                ->setCategory($category3) 
                ->setUser($user)
                ;
                for ($k=1; $k < mt_rand(4,12); $k++) { 
                                $comment = new Comment();
                                $comment ->setUser($user)
                                        ->setContent("Comment N° $k")      
                                        ->setTrick($trick1); 
                                $manager->persist($comment);
                        }

        $trick2 = new Trick();
        $trick2  ->setName("back flip")
                ->setDescription('Rotation verticale arrière')
                ->setCategory($category3) 
                ->setUser($user)
                ;

        $trick3 = new Trick();
        $trick3  ->setName('1080')
                ->setDescription('Trois tours complets en effectuant une rotation horizontale pendant le saut')
                ->setCategory($category2) 
                ->setUser($user)
                ;

                 for ($j=1; $j <= mt_rand(1,3); $j++) { 
                        $video = new Video();
                        $video->setUrl('https://youtu.be/4M1lRDo_O9I')
                                ->setTrick($trick3);
                        $manager->persist($video);

                        //entre 2 et 12 comments
                        for ($k=1; $k < mt_rand(4,12); $k++) { 
                                $comment = new Comment();
                                $comment ->setUser($user)
                                        ->setContent("Comment N° $k")      
                                        ->setTrick($trick3); 
                                $manager->persist($comment);
                        }
                }

        
        $trick4 = new Trick();
        $trick4  ->setName('mute')
                ->setDescription('Saisie de la carre frontside de la planche entre les deux pieds avec la main avant')
                ->setCategory($category1) 
                ->setUser($user)
                ;

        $trick5 = new Trick();
        $trick5 ->setName('stalefish')
                ->setDescription('Saisie de la carre backside de la planche entre les deux pieds avec la main arrière')
                ->setCategory($category1) 
                ->setUser($user)
                ;
                 for ($j=1; $j <= mt_rand(1,3); $j++) { 
                        $video = new Video();
                        $video->setUrl('https://youtu.be/4M1lRDo_O9I')
                                ->setTrick($trick5);
                        $manager->persist($video);

                        //entre 2 et 12 comments
                        for ($k=1; $k < mt_rand(4,12); $k++) { 
                                $comment = new Comment();
                                $comment ->setUser($user)
                                        ->setContent("Comment N° $k")      
                                        ->setTrick($trick5); 
                                $manager->persist($comment);
                        }
                }
        
        $trick6 = new Trick();
        $trick6  ->setName('truck driver')
                ->setDescription('Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)')
                ->setCategory($category3) 
                ->setUser($user)
                ;   


        $trick7 = new Trick();
        $trick7  ->setName('360')
                ->setDescription('Un tour complet en effectuant une rotation horizontale pendant le saut')
                ->setCategory($category2) 
                ->setUser($user)
                ; 
                

        $trick8 = new Trick();
        $trick8  ->setName('720')
                ->setDescription('Deux tours complets en effectuant une rotation horizontale pendant le saut')
                ->setCategory($category2) 
                ->setUser($user)
                ;

        $trick9 = new Trick();
        $trick9  ->setName('tail slide')
                ->setDescription('Glisser sur une barre de slide avec l\'arrière de la planche')
                ->setCategory($category4) 
                ->setUser($user)
                ;

        
        $trick10 = new Trick();
        $trick10  ->setName('nose slide')
                ->setDescription('Glisser sur une barre de slide avec l\'avant de la planche')
                ->setCategory($category4) 
                ->setUser($user)
                ;

                 for ($j=1; $j <= mt_rand(1,3); $j++) { 
                        $video = new Video();
                        $video->setUrl('https://youtu.be/4M1lRDo_O9I')
                                ->setTrick($trick10);
                        $manager->persist($video);

                        //entre 2 et 12 comments
                        for ($k=1; $k < mt_rand(4,12); $k++) { 
                                $comment = new Comment();
                                $comment ->setUser($user)
                                        ->setContent("Comment N° $k")      
                                        ->setTrick($trick10); 
                                $manager->persist($comment);
                        }
                }

        $manager->persist($trick1);
        $manager->persist($trick2);
        $manager->persist($trick3);
        $manager->persist($trick4);
        $manager->persist($trick5);
        $manager->persist($trick6);
        $manager->persist($trick7);
        $manager->persist($trick8);
        $manager->persist($trick9);
        $manager->persist($trick10);


        
    //  6 faux tricks 
        for ($i=1; $i <=5; $i++) { 
            $trick = new Trick();
            $trick->setName("nom-$i")
                ->setDescription("Description de trick $i")
                ->setCategory($category2) 
                ->setUser($user)
                ;

            $manager->persist($trick);
    
                //entre 1 et 3 video
                for ($j=1; $j <= mt_rand(1,3); $j++) { 
                        $video = new Video();
                        $video->setUrl('https://youtu.be/4M1lRDo_O9I');
                        $manager->persist($video);

                        //entre 2 et 12 comments
                        for ($k=1; $k < mt_rand(4,12); $k++) { 
                                $comment = new Comment();
                                $comment ->setUser($user)
                                        ->setContent("Comment N° $k")      
                                        ->setTrick($trick); 
                                $manager->persist($comment);
                        }
                }
        }

        $manager->flush();
    }
}
