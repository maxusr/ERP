<?php

namespace SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SchoolBundle\Form\BookType;
use SchoolBundle\Form\ClassroomType;
use SchoolBundle\Form\MatterType;
use SchoolBundle\Form\ExamType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

class ManagerController extends Controller
{
    public function indexAction()
    {

        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        return $this->redirectToRoute('shool_homepage');
    }

    public function manageAction(Request $request, $entity, $id = null) {

        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $entityName = ucfirst($entity);
        $form = null;
        $obj = $em->getRepository('SchoolBundle:'.$entityName)->oneOrNew($id);
        switch ($entity) {
            case 'book':
                $form = $this->createForm(BookType::class, $obj);
                break;
            case 'matter':
                $form = $this->createForm(MatterType::class, $obj);
                break;
            case 'classroom':
                $form = $this->createForm(ClassroomType::class, $obj);
                break;
            case 'exam':
                $form = $this->createForm(ExamType::class, $obj);
                break;
        }

        if($form == null) {
            $this->addFlash('danger', 'Formulaire non trouvé.');
            return $this->redirectToRoute('school_homepage');
        }

        $form->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $em->persist($obj);
                    $em->flush();
                    $this->addFlash('info', 'Données du formulaire '.$entityName.' enregistrées avec succès.');
                    return $this->redirectToRoute('school_setting_manage', ['entity' => $entity]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
        }
        $entities = $em->getRepository('SchoolBundle:'.$entityName)->findBy([],['id' => 'desc']);

        return $this->render('SchoolBundle:Manager:manage.html.twig', ['form' => $form->createView(), 'entity' => $entity, 'entities' => $entities]);

    }

    public function deleteAction(Request $request, $entity, $id)
    {
        $type = $entity;
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SchoolBundle:'.ucfirst($type))->findOneById($id);

        if(!$entity)
            return $this->createNotFoundException("L'entité que vous recherchez à supprimer n'existe pas.");

        $em->remove($entity);
        $em->flush();
        $this->addFlash('info', ucfirst($type)." supprimé.");

        return $this->redirectToRoute('school_homepage');
    }
}
