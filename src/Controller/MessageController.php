<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Subject;
use App\Form\MessageType;
use App\Repository\MessageRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @Route("/message")
 */
class MessageController extends Controller
{
    /**
     * @Route("/", name="message_index", methods="GET")
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', ['messages' => $messageRepository->findAll()]);
    }

    //Add OR edit a message

    /**
     * @Route("/new", name="message_new", methods="GET|POST")
     * @Route("/{id}/edit", name="message_edit")
     */
    public function messageForm(Message $message = null, Request $request, ObjectManager $manager, Subject $subject)
    {
        $subject = new Subject();

        if(!$message)
        {
            $message = new Message();
        }

        /* $form = $this->createFormBuilder($message)
                     ->add('subject')
                     ->add('visitor')
                     ->add('content')
                     ->getForm(); */

        //Retrieves the form from MessageType.php
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$message->getId())
            {
                $message->setCreatedAtMessage(new \DateTime());
                $message->setSubject($subject);
            }
            else
                $message->setModifiedAtMessage(new \DateTime());

            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('subject_show', [
                'id' => $message->getSubject()
            ]);
        }

        return $this->render('message/messageForm.html.twig', [
            'messageForm' => $form->createView(),
            'editMode' => $message->getId() !== null,
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods="GET")
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', ['message' => $message]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods="DELETE")
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_index');
    }
}