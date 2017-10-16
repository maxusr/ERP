<?php

namespace CMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CMBundle\Form\ProductType;
use CMBundle\Form\CategoryType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

class ManagerController extends Controller
{
    public function indexAction()
    {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        return $this->render('CMBundle:Manager:index.html.twig');
    }

    public function manageAction(Request $request, $entity, $id = null) {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $entityName = ucfirst($entity);
        $form = null;
        $obj = $em->getRepository('CMBundle:'.$entityName)->oneOrNew($id);
        switch ($entity) {
            case 'product':
                $form = $this->createForm(ProductType::class, $obj);
                break;
            case 'category':
                $form = $this->createForm(CategoryType::class, $obj);
                break;
        }

        if($form == null) {
            $this->addFlash('danger', 'Formulaire non trouvé.');
            return $this->redirectToRoute('cm_homepage');
        }

        $form->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $em->persist($obj);
                    $em->flush();
                    $this->addFlash('info', 'Données du formulaire '.$entityName.' enregistrées avec succès.');
                    return $this->redirectToRoute('cm_setting_manage', ['entity' => $entity]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
        }
        $entities = $em->getRepository('CMBundle:'.$entityName)->findBy([],['id' => 'desc']);

        return $this->render('CMBundle:Manager:manage.html.twig', ['form' => $form->createView(), 'entity' => $entity, 'entities' => $entities]);

    }

    public function deleteAction(Request $request, $type, $id)
    {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CMBundle:'.ucfirst($type))->findOneById($id);

        if(!$entity)
            return $this->createNotFoundException("L'entité que vous recherchez à supprimer n'existe pas.");

        $em->remove($entity);
        $em->flush();
        $this->addFlash('info', ucfirst($type)." supprimé.");

        return $this->redirectToRoute('cm_homepage');
    }
}
