<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Visitor;

class VisitorFixtures extends Fixture

{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 10; $i++) 
        {
            $visitor = new Visitor();
            $visitor->setPseudoVisitor("Visitor $i")
                ->setPwdVisitor("Password $i")
                ->setCreatedAtVisitor(new \DateTime());

            $manager->persist($visitor);
        }

        $manager->flush();
    }
}
