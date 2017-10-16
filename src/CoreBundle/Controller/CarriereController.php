<?php

namespace CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;


use CoreBundle\Entity\User;
use CoreBundle\Entity\Conge;
use CoreBundle\Entity\Contrat;
use CoreBundle\Entity\Sanction;
use CoreBundle\Entity\UserEchelon;
use CoreBundle\Entity\Mission;
use CoreBundle\Entity\Penalite;

use CoreBundle\Form\UserType;
use CoreBundle\Form\CongeType;
use CoreBundle\Form\ContratType;
use CoreBundle\Form\SanctionType;
use CoreBundle\Form\UserEchelonType;
use CoreBundle\Form\MissionType;
use CoreBundle\Form\PenaliteType;

class CarriereController extends BaseController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $actifs = $em->getRepository('CoreBundle:User')->findBy(array('active' => true), array('id' => 'desc'));
        $inactifs = $em->getRepository('CoreBundle:User')->findBy(array('active' => false), array('id' => 'desc'));

        $users = [];
        foreach ($inactifs as $key => $value) {
            $contrat = $value->getContrat();
            if(!is_null($contrat) && $contrat->duree() < 30) {
                $users = $value;
            }
        }
        
        foreach ($actifs as $key => $value) {
            $contrat = $value->getContrat();
            if(!is_null($contrat) && $contrat->duree() < 30) {
                $users = $value;
            }
        }

        return $this->render('CoreBundle:Carriere:index.html.twig', array('actifs' => $actifs, 'inactifs' => $inactifs, 'users' => $users));
    }

    public function oneAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$user)
            return $this->createNotFoundException("L'employé que vous recherchez n'existe pas.");

        $userEchelon = new UserEchelon;
        $userEchelon->setUser($user);
        $userEchelonForm = $this->createForm(UserEchelonType::class, $userEchelon);

        $userContrat = new Contrat;
        $userContrat->setEmploye($user);
        $userContratForm = $this->createForm(ContratType::class, $userContrat);

        $sanction = new Sanction;
        $sanction->setEmploye($user);
        $sanctionForm = $this->createForm(SanctionType::class, $sanction);

        $conge = new Conge;
        $conge->setEmploye($user);
        $congeForm = $this->createForm(CongeType::class, $conge);

        $penalite = new Penalite;
        $penalite->setUser($user);
        $penaliteForm = $this->createForm(PenaliteType::class, $penalite);

        $mission = new Mission;
        $mission->setUser($user);
        $missionForm = $this->createForm(MissionType::class, $mission);

        if($request->getMethod() == 'POST') {
            $userEchelonForm->handleRequest($request);
            $congeForm->handleRequest($request);
            $sanctionForm->handleRequest($request);
            $missionForm->handleRequest($request);
            $penaliteForm->handleRequest($request);
            $userContratForm->handleRequest($request);

            if($userContratForm->isSubmitted()) {
                if($userContratForm->isValid()) {
                    $em->persist($userContrat);
                    $user->setContrat($userContrat);
                    $em->persist($user);
                    $em->persist($userContrat);
                    $em->flush();
                    $this->addFlash('info', "Nouveau contrat enregistré");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Erreur dans le formulaire du nouveau contrat");
                }
            }

            if($userEchelonForm->isSubmitted()) {
                if($userEchelonForm->isValid()) {
                    $em->persist($userEchelon);
                    $em->flush();
                    $this->addFlash('info', "Echelonnage enregistré");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Erreur dans le formulaire d'échelonnage");
                }
            }
            
            if($congeForm->isSubmitted()) {
                if($congeForm->isValid()) {
                    $em->persist($conge);
                    $em->flush();
                    $this->addFlash('info', "Congé enregistré");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Erreur dans le formulaire de congé");
                }
            }
            
            if($sanctionForm->isSubmitted()) {
                if($sanctionForm->isValid()) {
                    $em->persist($sanction);
                    $em->flush();
                    $this->addFlash('info', "Sanction enregistrée");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Erreur dans le formulaire de sanction");
                }
            }
            
            if($missionForm->isSubmitted()) {
                if($missionForm->isValid()) {
                    $em->persist($mission);
                    $em->flush();
                    $this->addFlash('info', "Mission enregistrée");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Erreur dans le formulaire de mission");
                }
            }
            
            if($penaliteForm->isSubmitted()) {
                if($penaliteForm->isValid()) {
                    $em->persist($penalite);
                    $em->flush();
                    $this->addFlash('info', "Pénalité enregistrée");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Erreur dans le formulaire de pénalité");
                }
            }
        }

        return $this->render('CoreBundle:Carriere:one.html.twig', array(
                                'user' => $user, 
                                'congeMois' => $user->congeCeMois(),
                                'congeAnnee' => $user->congeCetteAnnee(),
                                'formUserEchelon' => $userEchelonForm->createView(),
                                'formConge' => $congeForm->createView(),
                                'formPenalite' => $penaliteForm->createView(),
                                'formMission' => $missionForm->createView(),
                                'formContrat' => $userContratForm->createView(),
                                'formSanction' => $sanctionForm->createView()
                                ));
    }

    public function insertAction(Request $request, User $user = null)
    {
        $em = $this->getDoctrine()->getManager();

        $isNew = false;
        if(!$user){
            $user = new User;
            $isNew = true;
        }else{
            if($user->getArchive()){
                $this->addFlash('warning', "Vous ne pouvez pas modifier un user archivé.");
                return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
            }
        }

        $formUser = $this->createForm(UserType::class, $user);

        if($request->getMethod() == 'POST'){
            $formUser->handleRequest($request);
            if($formUser->isSubmitted()){
                if($formUser->isValid()){
                    $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
                    $user->setPassword($password);
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('info', "Utilisateur enregistré avec succès.");
                    return $this->redirectToRoute('core_carriere_one', array('id' => $user->getId()));
                }else{
                    $this->addFlash('warning', "Il y a des erreurs dans votre formulaire.");
                }
            }
        }
            

        return $this->render('CoreBundle:Carriere:insert.html.twig', array('user' => $user, 'formUser' => $formUser->createView()));
    }

    public function deleteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$user)
            return $this->createNotFoundException("L'utilisateur que vous recherchez n'existe pas.");

        $em->remove($user);
        $em->flush();
        $this->addFlash('info', "Utilisateur supprimé.");

        return $this->redirectToRoute('core_carriere_home');
    }
}
