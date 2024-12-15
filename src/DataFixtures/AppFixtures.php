<?php

namespace App\DataFixtures;

use App\Entity\user;
use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $recettesData = [
            [
                'title' => 'Couscouss',
                'image' => 'https://www.diari.tn/sites/default/files/image/recette/couscous-viande_0.jpg',
                'description' => 'Un délicieux couscous traditionnel avec des légumes et de la viande.',
                'ingredients' => [
                    'Semoule de couscous',
                    'Viande (agneau ou poulet)',
                    'Carottes',
                    'Courgettes',
                    'Pois chiches',
                    'Raisins secs',
                    'Épices (cumin, curcuma, paprika, cannelle)',
                    'Bouillon de légumes'
                ],
                'preparation' => '1. Faites cuire la viande dans une grande marmite avec des épices. 2. Préparez les légumes (carottes, courgettes). 3. Faites cuire le couscous et servez avec la viande, les légumes et les pois chiches.'
            ],
            [
                'title' => 'Tagine de poulet aux citrons confits',
                'image' => 'https://www.finedininglovers.fr/sites/g/files/xknfdk1291/files/styles/recipes_1200_800/public/2023-02/tajine%20poulet%20-%20Fine%20Dining%20Lovers.jpg.webp?itok=vd1vOzJ1',
                'description' => 'Un tagine savoureux avec du poulet, des citrons confits et des olives.',
                'ingredients' => [
                    'Poulet',
                    'Citrons confits',
                    'Olives vertes',
                    'Oignons',
                    'Ail',
                    'Gingembre',
                    'Épices (ras el hanout, curcuma, cannelle)',
                    'Bouillon de poulet'
                ],
                'preparation' => '1. Faites dorer le poulet avec les oignons et l’ail. 2. Ajoutez les épices, le bouillon, les citrons confits et les olives. 3. Laissez mijoter à feu doux jusqu’à ce que le poulet soit tendre. 4. Servez avec du riz ou du pain.'
            ],
            [
                'title' => 'Pizza Margherita',
                'image' => 'https://cdn.shopify.com/s/files/1/0274/9503/9079/files/20220211142754-margherita-9920_5a73220e-4a1a-4d33-b38f-26e98e3cd986.jpg?v=1723650067?w=1024',
                'description' => 'La pizza classique italienne avec de la sauce tomate, de la mozzarella et du basilic frais.',
                'ingredients' => [
                    'Pâte à pizza',
                    'Sauce tomate',
                    'Mozzarella',
                    'Basilic frais',
                    'Huile d\'olive',
                    'Sel et poivre'
                ],
                'preparation' => '1. Étalez la pâte à pizza. 2. Ajoutez la sauce tomate, puis la mozzarella en tranches. 3. Enfournez à 220°C pendant 10-12 minutes. 4. Ajoutez le basilic frais après la cuisson et un filet d\'huile d\'olive.'
            ]
        ];

        foreach ($recettesData as $data) {
            $recette = new Recette();
            $recette->setTitle($data['title'])
                    ->setImage($data['image'])
                    ->setDescription($data['description'])
                    ->setIngredients($data['ingredients'])
                    ->setPreparation($data['preparation']);

 
            $manager->persist($recette);
        }

        $user = new user();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']); 
 
        $hashedPassword = $this->passwordHasher->hashPassword(
            user: $user,
            plainPassword: 'password123' 
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);

        $manager->flush();
    }
}
