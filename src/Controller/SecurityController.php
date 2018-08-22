<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    /**
     * @Route("/signup", name="security_registration")
     */
    public function registration()
    {
        $visitor = new Visitor();

        //On relie les champs du visitor aux champs du formulaire
        $form = $this->createForm(ResgistrationType::class, $visitor);

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
