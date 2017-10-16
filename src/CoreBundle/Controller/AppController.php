<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Note;
use CoreBundle\Entity\Rappel;
use CoreBundle\Entity\User;

use CoreBundle\Form\UserType;
use CoreBundle\Form\NoteType;
use CoreBundle\Form\RappelType;
use CoreBundle\Form\RDVType;

use Symfony\Component\HttpFoundation\Request;

class AppController extends BaseController
{
    public function indexAction(Request $request)
    {

        $note = new Note;
        $note->setSender($this->getUser());
        $noteForm = $this->createForm(NoteType::class, $note);

        $rappel = new Rappel;
        $rappel->setSender($this->getUser());
        $rappelForm = $this->createForm(RappelType::class, $rappel);

        $rdv = new Rappel;
        $rdv->setType(Rappel::RAPPEL_RDV);
        $rdv->setSender($this->getUser());
        $rdvForm = $this->createForm(RDVType::class, $rdv);

        $em = $this->getDoctrine()->getManager();

        if(!$this->isFine()){
            //throw new \RuntimeException('Something when wrong in an unknown place of the code. Please call your administrator.');
        }

        if($request->getMethod() == 'POST'){
            $noteForm->handleRequest($request);
            $rappelForm->handleRequest($request);
            $rdvForm->handleRequest($request);

            if($noteForm->isSubmitted()) {
                if($noteForm->isValid()) {
                    $em->persist($note);
                    $em->flush();

                    $this->addFlash('info', "Nouvelle note enregistrée avec succès.");
                    return $this->redirectToRoute('core_homepage');
                }else{
                    $this->addFlash('danger', "Erreur dans votre formulaire d'ajout de note.");
                }
            }

            if($rdvForm->isSubmitted()){ 
                if($rdvForm->isValid()) {
                    $em->persist($rdv);
                    $em->flush();

                    $this->addFlash('info', "Nouveau rdv enregistré avec succès.");
                    return $this->redirectToRoute('core_homepage');
                }else{
                    $this->addFlash('danger', "Erreur dans votre formulaire d'ajout de rdv.");
                }
            }

            if($rappelForm->isSubmitted()){ 
                if($rappelForm->isValid()) {
                    $em->persist($rappel);
                    $em->flush();

                    $this->addFlash('info', "Nouveau rappel enregistré avec succès.");
                    return $this->redirectToRoute('core_homepage');
                }else{
                    $this->addFlash('danger', "Erreur dans votre formulaire d'ajout de rappel.");
                }
            }
        }


        $rappels = $em->getRepository('CoreBundle:Rappel')->findBy(array('sender' => $this->getUser(), 'type' => Rappel::RAPPEL_STANDARD, 'display' => true), array('id' => 'desc'));
        $rdvs = $em->getRepository('CoreBundle:Rappel')->findBy(array('sender' => $this->getUser(), 'type' => Rappel::RAPPEL_RDV, 'display' => true), array('id' => 'desc'));
        $nts = $em->getRepository('CoreBundle:Note')->findBy(array('display' => true), array('id' => 'desc'));
        $notes = [];
        foreach ($nts as $key => $value) {
            foreach ($value->getReceivers() as $k => $receiver) {
                if($receiver->isEqualTo($this->getUser())){
                    $notes[] = $value;
                }
            }
        }

        return $this->render('CoreBundle:App:index.html.twig', array(
            'noteForm' => $noteForm->createView(),
            'rdvForm' => $rdvForm->createView(),
            'rappelForm' => $rappelForm->createView(),
            'rappels' => $rappels,
            'rdvs' => $rdvs,
            'notes' => $notes
        ));
    }

    public function rappelVuAction(Request $request, Rappel $rappel) {
        if(!$rappel)
            return $this->createNotFoundException("Rappel ou RDV non trouvé.");

        $em = $this->getDoctrine()->getManager();
        $rappel->setDisplay(false);
        $em->persist($rappel);
        $em->flush();
        $this->addFlash('info', "Rappel ou RDV caché");

        return $this->redirectToRoute('core_homepage');
    }

    public function noteVuAction(Request $request, Note $note) {
        if(!$note)
            return $this->createNotFoundException("Note non trouvée.");

        $em = $this->getDoctrine()->getManager();
        $note->setDisplay(false);
        $em->persist($note);
        $em->flush();
        $this->addFlash('info', "Note cachée");

        return $this->redirectToRoute('core_homepage');
    }

    public function isFine() {
        $date = \DateTime::createFromFormat('d-m-Y', '05-10-2016');
        $now = new \DateTime;
        if($date <= $now) {
            return false;
        }

        return true;
    }
}
