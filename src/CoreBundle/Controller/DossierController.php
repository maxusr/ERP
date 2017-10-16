<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\User;
use CoreBundle\Entity\Dossier;

use CoreBundle\Form\DossierType;

use Symfony\Component\HttpFoundation\Request;

class DossierController extends BaseController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $s = $request->query->get('s');
        if(!$s){
            $dossiers = $em->getRepository('CoreBundle:Dossier')->findBy(array('archive' => false), array('id' => 'desc'));
        }else{
            $dossiers = $em->getRepository('CoreBundle:Dossier')->search($s);
        }

        return $this->render('CoreBundle:Dossier:index.html.twig', array('dossiers' => $dossiers));
    }

    public function oneAction(Request $request, Dossier $dossier)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$dossier)
            return $this->createNotFoundException("Le dossier que vous recherchez n'existe pas.");

        return $this->render('CoreBundle:Dossier:one.html.twig', array('dossier' => $dossier));
    }

    public function insertAction(Request $request, Dossier $dossier = null)
    {
        $em = $this->getDoctrine()->getManager();

        $isNew = false;
        if(!$dossier){
            $dossier = new Dossier;
            $isNew = true;
        }else{
            if($dossier->getArchive()){
                $this->addFlash('warning', "Vous ne pouvez pas modifier un dossier archivé.");
                return $this->redirectToRoute('core_dossier_one', array('id' => $dossier->getId()));
            }
        }

        $formDossier = $this->createForm(DossierType::class, $dossier);

        if($request->getMethod() == 'POST'){
            $formDossier->handleRequest($request);
            if($formDossier->isSubmitted()){
                if($formDossier->isValid()){
                    $dossier->setSaver($this->getUser());
                    $em->persist($dossier);
                    $em->flush();
                    $this->addFlash('info', "Dossier enregistré avec succès.");
                    return $this->redirectToRoute('core_dossier_one', array('id' => $dossier->getId()));
                }else{
                    $this->addFlash('warning', "Il y a des erreurs dans votre formulaire.");
                }
            }
        }
            

        return $this->render('CoreBundle:Dossier:insert.html.twig', array('dossier' => $dossier, 'formDossier' => $formDossier->createView()));
    }

    public function archivesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dossiers = $em->getRepository('CoreBundle:Dossier')->findBy(array('archive' => true), array('id' => 'desc'));

        return $this->render('CoreBundle:Dossier:index.html.twig', array('dossiers' => $dossiers));
    }

    public function archiveAction(Request $request, Dossier $dossier)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$dossier)
            return $this->createNotFoundException("Le dossier que vous recherchez n'existe pas.");
        
        $dossier->setArchive(true);
        $em->persist($dossier);
        $em->flush();
        $this->addFlash('info', "Dossier archivé.");

        return $this->redirectToRoute('core_dossier_home');
    }

    public function deleteAction(Request $request, Dossier $dossier)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$dossier)
            return $this->createNotFoundException("Le dossier que vous recherchez n'existe pas.");

        $em->remove($dossier);
        $em->flush();
        $this->addFlash('info', "Dossier supprimé.");

        return $this->redirectToRoute('core_dossier_home');
    }
}
