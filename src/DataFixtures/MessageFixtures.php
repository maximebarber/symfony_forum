<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Message;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 3; $i < 10; $i++) 
        {
        $message = new Message();
        $message->setCreatedAtMessage(new \DateTime())
                ->setVisitor($i)
                ->contentMessage("lol $i"); 
        $manager->persist($message);
        }

        $manager->flush();
    }
}
