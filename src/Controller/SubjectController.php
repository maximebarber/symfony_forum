<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Entity\Message;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @Route("/subject")
 */
class SubjectController extends Controller
{
    /**
     * @Route("/", name="subject_index", methods="GET")
     */
    public function index(): Response
    {
        $subjects = $this->getDoctrine()
                         ->getRepository(Subject::class)
                         ->getSubjectsOrderByDate();
        
        return $this->render('subject/index.html.twig',
                             ['subjects' => $subjects]);
    }

    /**
     * @Route("/new", name="subject_new", methods="GET|POST")
     * @Route("/{id}/edit", name="subject_edit")
     */
    public function subjectForm(Subject $subject = null, Request $request, ObjectManager $manager)
    {
        if (!$subject)
            $subject = new Subject();

        $form = $this->createForm(SubjectType::class, $subject);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if (!$subject->getId())
                $subject->setCreatedAtSubject(new \DateTime());
            else 
                $subject->setModifiedAtSubject(new \DateTime());

            //$subject = $form->getData();
            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            return $this->redirectToRoute('subject_show', [
                'id' => $subject->getId()
            ]);
        }

        return $this->render('subject/subjectForm.html.twig', [
            'subjectForm' => $form->createView(),
            'editMode' => $subject->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="subject_show", methods="GET")
     */
    //Retrieve messages and title of subject
    public function show(int $id): Response
    {
        
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findMessagesBySubject($id);

        $subject = $this->getDoctrine()
            ->getRepository(Subject::class)
            ->findSubjectById($id); 

        return $this->render(
            'subject/show.html.twig',
            ['messages' => $messages,
             'subject' => $subject]
        );
    }

    /**
     * @Route("/{id}", name="subject_delete", methods="DELETE")
     */
    public function delete(Request $request, Subject $subject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subject->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();
        }

        return $this->redirectToRoute('subject_index');
    }
}
