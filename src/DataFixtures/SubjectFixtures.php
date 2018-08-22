<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Subject;
use App\Entity\Message;
use App\Entity\Visitor;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Create 5 fake categories
        for ($c = 1; $c < 6; $c++)
        {
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

            $manager->persist($category);

            //Create 4 visitors
            for ($v = 1; $v < 5; $v++)
            {

                $visitor = new Visitor();
                $visitor->setPseudoVisitor($faker->userName())
                        ->setPwdVisitor($faker->password())
                        ->setCreatedAtVisitor($faker->dateTimeBetween('-8 months'));

                $manager->persist($visitor);

                //Create between 2 and 3 subjects
                for ($s = 1; $s <= mt_rand(2, 3); $s++)
                {
                    $subject = new Subject();

                    //Paragraphs is an array
                    $content = join($faker->paragraphs(5));

                    $subject->setTitleSubject($faker->sentence())
                            ->setCreatedAtSubject($faker->dateTimeBetween('-8 months'))
                            ->setContent($content)
                            ->setCategory($category)
                            ->setVisitor($visitor);

                    $manager->persist($subject);

                    //Create between 2 and 5 messages
                    for ($m = 1; $m <= mt_rand(2, 5); $m++)
                    {

                        //Message is necessarily written after subject
                        $now = new \DateTime();
                        $interval = $now->diff($subject->getCreatedAtSubject());
                        $days = $interval->days;
                        $minimum = '-' . $days . ' days'; //100 days

                        $message = new Message();
                        $message->setCreatedAtMessage($faker->dateTimeBetween($minimum))
                                ->setContent($faker->paragraph())
                                ->setVisitor($visitor)
                                ->setSubject($subject);

                        $manager->persist($message);
                    }
                }
            }
        }

        $manager->flush();

    }
}
