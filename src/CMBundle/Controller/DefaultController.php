<?php

namespace CMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use CMBundle\Entity\Input;
use CMBundle\Entity\Output;
use CMBundle\Entity\State;

use CMBundle\Form\OutputType;
use CMBundle\Form\InputType;
use CMBundle\Form\StateType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $e = $request->query->get('e');
        $i = $request->query->get('i');

        $input = new Input;
        $output = new Output;
        if($e == 'input') {
            $input = $em->getRepository('CMBundle:Input')->oneOrNew($i);
        }

        if($e == 'output') {
            $output = $em->getRepository('CMBundle:Output')->oneOrNew($i);
        }

        if(empty($input->getSaver())){
            $input->setSaver($this->getUser());
        }
        if(empty($output->getSaver())){
            $output->setSaver($this->getUser());
        }

        $formInput = $this->createForm(InputType::class, $input);
        $formOutput = $this->createForm(OutputType::class, $output);
        $formInput->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);
        $formOutput->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $formInput->handleRequest($request);
            $formOutput->handleRequest($request);

            if($formInput->isSubmitted()){
                if($formInput->isValid() && $input->getSaver()->isEqualTo($this->getUser())){
                    $em->persist($input);
                    $em->flush();

                    $this->addFlash('info', "Entrée enregistrée avec succès.");
                    return $this->redirectToRoute('cm_homepage');
                }else{
                    $this->addFlash('danger', "Erreur dans le formulaire d'enregistrement de l'entrée ou vous ne pouvez pas modifier cette Entrée.");
                }
            }

            if($formOutput->isSubmitted()){
                if($formOutput->isValid() && $output->getSaver()->isEqualTo($this->getUser())){
                    if($output->getQuantity() <= $output->getProduct()->getQuantity()) {
                    $em->persist($output);
                    $em->flush();

                    $this->addFlash('info', "Sortie enregistrée avec succès.");
                    return $this->redirectToRoute('cm_homepage');
                    }else{
                        $this->addFlash('danger', "Vous ne pouvez pas retirer plus qu'il y en a. Nombre de ".$output->getProduct()->getName().": ".$output->getProduct()->getQuantity());
                    }
                }else{
                    $this->addFlash('danger', "Erreur dans le formulaire d'enregistrement de la sortie ou vous ne pouvez pas modifier cette Sortie.");
                }
            }
        }

        $inputs = $em->getRepository('CMBundle:Input')->findBy(array(), array('id' => 'desc'),4,0);
        $outputs = $em->getRepository('CMBundle:Output')->findBy(array(), array('id' => 'desc'),4,0);

        return $this->render('CMBundle:Default:index.html.twig', array('formOutput' => $formOutput->createView() ,'formInput' => $formInput->createView() ,'inputs' => $inputs, 'outputs' => $outputs));
    }

    public function allAction(Request $request, $entity) {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CMBundle:'.ucfirst($entity));

        if($entity == 'input'){
            $name = 'Entrée';
        }else{
            $name = 'Sortie';
        }

        $s = $request->query->get('s');

        $entities = $repository->findBy(array(), array('id' => 'desc'));

        $ent = array();
        if(!is_null($s)){
            $date = \DateTime::createFromFormat('d-m-Y', $s);
            foreach ($entities as $key => $value) {
                $diff = $date->diff($value->getCreatedAt());
                if($diff && $diff->days < 1){
                    $ent[] = $value;
                }
            }
        }else{
            $ent = $entities;
        }
        

        return $this->render('CMBundle:Default:all.html.twig', array('entities' => $ent, 'name' => $name));
    }

    public function consommableAction(Request $request) {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        $name = 'Consommable';
        $s = $request->query->get('s');
        $entities = $em->getRepository('CMBundle:Product')->findBy(['isConsommable' => true],['id' => 'desc']);
        $ent = array();
        if(!is_null($s)){
            foreach ($entities as $key => $value) {
                if(stripos($value->getName(), $s) > -1) {
                    $ent[] = $value;
                }
            }
        }else{
            $ent = $entities;
        }

        return $this->render('CMBundle:Default:consommable.html.twig', array('entities' => $ent, 'name' => $name));
    }

    public function inventaireAction(Request $request) {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        $name = 'Inventaire';
        $entities = $em->getRepository('CMBundle:Product')->findBy([],['id' => 'desc']);
        $ent = array();
        if(!is_null($s)){
            foreach ($entities as $key => $value) {
                if(stripos($value->getName(), $s) > -1) {
                    $ent[] = $value;
                }
            }
        }else{
            $ent = $entities;
        }

        return $this->render('CMBundle:Default:inventaire.html.twig', array('entities' => $ent, 'name' => $name));
    }

    public function statesAction(Request $request, State $state = null) {

        if(!$this->getUser()->can('ACCESS_CM')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        if(is_null($state)) {
            $state = new State;
        }
        $formState = $this->createForm(StateType::class, $state);
        $formState->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if(empty($state->getInsertedBy())){
            $state->setInsertedBy($this->getUser());
        }


        if($request->isMethod('POST')) {
            $formState->handleRequest($request);

            if($formState->isSubmitted()){
                if($formState->isValid() && $state->getInsertedBy()->isEqualTo($this->getUser())){
                    $em->persist($state);
                    $em->flush();

                    $this->addFlash('info', "Etat enregistré avec succès.");
                    return $this->redirectToRoute('cm_product_states');
                }else{
                    $this->addFlash('danger', "Erreur dans le formulaire d'enregistrement de l'état ou vous ne pouvez pas modifier cette Etat.");
                }
            }
        }

        $name = 'Etat';
        $entities = $em->getRepository('CMBundle:State')->findBy([],['id' => 'desc']);

        return $this->render('CMBundle:Default:states.html.twig', array('entities' => $entities, 'name' => $name, 'formState' => $formState->createView()));
    }
}
