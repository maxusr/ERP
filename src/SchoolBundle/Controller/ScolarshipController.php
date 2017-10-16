<?php

namespace SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use SchoolBundle\Entity\Student;
use SchoolBundle\Entity\StudentNote;
use SchoolBundle\Entity\Sanction;
use SchoolBundle\Entity\Bulletin;

use SchoolBundle\Form\StudentType;
use SchoolBundle\Form\StudentNewClassroomType;
use SchoolBundle\Form\StudentNoteType;
use SchoolBundle\Form\SanctionType;
use SchoolBundle\Form\BulletinType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ScolarshipController extends Controller
{
    public function indexAction()
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        return $this->render('SchoolBundle:Default:index.html.twig');
    }
    
    public function studentsAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        if(!$this->getUser()->can('MANAGE_SCOLARSHIP')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('school_homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('SchoolBundle:Student')->findBy([],['id' => 'desc']);

        return $this->render('SchoolBundle:Scolarship:students.html.twig', ['students' => $students]);
    }
    
    public function studentManageAction(Request $request, $id = null)
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        if(!$this->getUser()->can('MANAGE_SCOLARSHIP')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('school_homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository('SchoolBundle:Student')->oneOrNew($id);
        $form = $this->createForm(StudentType::class, $student);

        
        $form->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $em->persist($student);
                    $em->flush();
                    $this->addFlash('info', 'Etudiant enregistré avec succès.');
                    return $this->redirectToRoute('school_student', ['id' => $student->getId()]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
        }

        return $this->render('SchoolBundle:Scolarship:studentManage.html.twig', ['form' => $form->createView()]);
    }
    
    public function studentAction(Request $request, Student $student)
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();

        if(empty($student)) {
            $this->addFlash('warning', "Etudiant non retrouvé.");
            return $this->redirectToRoute('school_homepage');
        }

        $note = new StudentNote;
        $note->setStudent($student);
        $formNote = $this->createForm(StudentNoteType::class, $note);
        $formNote->remove('student');
        $formNote->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        $sanction = new Sanction;
        $sanction->setStudent($student);
        $formSanction = $this->createForm(SanctionType::class, $sanction);

        $bulletin = new Bulletin;
        $bulletin->setStudent($student);
        $formBulletin = $this->createForm(BulletinType::class, $bulletin);
        $formBulletin->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);
        
        $formStudentNewClassroom = $this->createForm(StudentNewClassroomType::class, $student);
        $formStudentNewClassroom->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $formNote->handleRequest($request);
            $formSanction->handleRequest($request);
            $formBulletin->handleRequest($request);
            $formStudentNewClassroom->handleRequest($request);
            if($formNote->isSubmitted()) {
                if($formNote->isValid()) {
                    $em->persist($note);
                    $em->flush();
                    $this->addFlash('info', 'Note ajoutée.');
                    return $this->redirectToRoute('school_student', ['id' => $student->getId()]);
                }else{
                    $this->addFlash('warning', 'Erreur dans le formulaire de note.');
                }
            }

            if($formSanction->isSubmitted()) {
                if($formSanction->isValid()) {
                    $em->persist($sanction);
                    $em->flush();
                    $this->addFlash('info', 'Sanction ajoutée.');
                    return $this->redirectToRoute('school_student', ['id' => $student->getId()]);
                }else{
                    $this->addFlash('warning', 'Erreur dans le formulaire de sanction.');
                }
            }

            if($formBulletin->isSubmitted()) {
                if($formBulletin->isValid()) {
                    $em->persist($bulletin);
                    $em->flush();
                    $this->addFlash('info', 'Bulletin ajouté.');
                    return $this->redirectToRoute('school_student', ['id' => $student->getId()]);
                }else{
                    $this->addFlash('warning', 'Erreur dans le formulaire de bulletin.');
                }
            }

            if($formStudentNewClassroom->isSubmitted()) {
                if($formStudentNewClassroom->isValid()) {
                    $em->persist($student);
                    $em->flush();
                    $this->addFlash('info', 'Nouvelle salle de classe attribuée.');
                    return $this->redirectToRoute('school_student', ['id' => $student->getId()]);
                }else{
                    $this->addFlash('warning', 'Erreur dans le formulaire de nouvelle classe.');
                }
            }
        }

        return $this->render('SchoolBundle:Scolarship:student.html.twig', ['student' => $student, 
                                                                            'formNote' => $formNote->createView(),
                                                                            'formBulletin' => $formBulletin->createView(),
                                                                            'formSanction' => $formSanction->createView(),
                                                                            'formStudentNewClassroom' => $formStudentNewClassroom->createView(),
                                                                        ]);
    }
}
