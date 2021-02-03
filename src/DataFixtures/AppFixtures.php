<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class AppFixtures extends Fixture
{

    protected UserPasswordEncoderInterface $encoder;
    private SluggerInterface $slugger;


    public function __construct(UserPasswordEncoderInterface $encoder, SluggerInterface $slugger)
    {
        $this->encoder = $encoder;
        $this->slugger = $slugger;
    }


    public function load(ObjectManager $manager)
    {

        // Make admin User
        $admin = new User();
        $admin
            ->setFirstname('Yohann')
            ->setLastname('Hommet')
            ->setEmail('admin@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->encodePassword($admin, 'soleil'))
        ;
        $manager->persist($admin);

        for ($u = 0; $u < 10; $u++) {
            $user = new User();
            $user
                ->setFirstname("UserFirstname$u")
                ->setLastname("UserLastname$u")
                ->setEmail("user$u@gmail.com")
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->encoder->encodePassword($user, "soleil"))
            ;
            $manager->persist($user);

            for ($c = 0; $c < 6; $c++) {
                $category = new Category;
                $category
                    ->setName("Catégorie au hasard n°$c")
                    ->setSlug($category->getName());
    
                $manager->persist($category);
    
                for ($i = 0; $i < 25; $i++) {
                    $article = new Article;
                    $article
                        ->setTitle("Super article n$i")
                        ->setDescription("Description du super article n$i")
                        ->setImage("https://picsum.photos/500/500")
                        ->setUser($admin)
                        ->setCategory($category)
                        ->setSlug($this->slugger->slug($article->getTitle()));
                    $manager->persist($article);
                }
    
            }

        }   

        $manager->flush();
    }
}
