<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Form\VisitorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\Node\Stmt\Use_;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/signup", name="security_registration")
     */
    public function registration(ObjectManager $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $visitor = new Visitor();

        //On relie les champs du visitor aux champs du formulaire
        $form = $this->createForm(VisitorType::class, $visitor);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //Encode password (security.yaml)
            $hash = $encoder->encodePassword($visitor, $visitor->getPwdVisitor());

            $visitor->setPwdVisitor($hash);

            //Set createdAt date
            $visitor->setCreatedAtVisitor(new \DateTime());

            //Save and push to DB
            $manager->persist($visitor);
            $manager->flush();
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
