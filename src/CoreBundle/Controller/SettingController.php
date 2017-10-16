<?php

namespace CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;


use CoreBundle\Entity\User;
use CoreBundle\Entity\Domaine;
use CoreBundle\Entity\Poste;
use CoreBundle\Entity\Echelon;
use CoreBundle\Entity\Region;
use CoreBundle\Entity\Service;
use CoreBundle\Entity\Mission;
use CoreBundle\Entity\Taxe;

use CoreBundle\Form\RegionType;
use CoreBundle\Form\PosteType;
use CoreBundle\Form\EchelonType;
use CoreBundle\Form\DomaineType;
use CoreBundle\Form\ServiceType;
use CoreBundle\Form\MissionType;
use CoreBundle\Form\TaxeType;
use CoreBundle\Form\CompetenceType;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SettingController extends BaseController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $domaine = new Domaine;
        $domaineForm = $this->createForm(DomaineType::class, $domaine);

        $taxe = new Taxe;
        $taxeForm = $this->createForm(TaxeType::class, $taxe);

        $region = new Region;
        $regionForm = $this->createForm(RegionType::class, $region);

        if($request->getMethod() == "POST") {
            $domaineForm->handleRequest($request);
            $taxeForm->handleRequest($request);
            $regionForm->handleRequest($request);

            if($regionForm->isSubmitted()){
                if($regionForm->isValid()) {
                    $em->persist($region);
                    $em->flush();
                    $this->addFlash('info', "Région enregistrée.");
                    return $this->redirectToRoute('core_setting_home');
                }else{
                    $this->addFlash('danger', "Erreur dans votre formulaire.");
                }
            }

            if($taxeForm->isSubmitted()){
                if($taxeForm->isValid()) {
                    $em->persist($taxe);
                    $em->flush();
                    $this->addFlash('info', "Taxe enregistrée.");
                    return $this->redirectToRoute('core_setting_home');
                }else{
                    $this->addFlash('danger', "Erreur dans votre formulaire.");
                }
            }

            if($domaineForm->isSubmitted()){
                if($domaineForm->isValid()) {
                    $em->persist($domaine);
                    $em->flush();
                    $this->addFlash('info', "Domaine enregistré.");
                    return $this->redirectToRoute('core_setting_home');
                }else{
                    $this->addFlash('danger', "Erreur dans votre formulaire.");
                }
            }
        }

        $domaines = $em->getRepository('CoreBundle:Domaine')->findBy(array(), array('name' => 'asc'));
        $taxes = $em->getRepository('CoreBundle:Taxe')->findBy(array(), array('name' => 'asc'));
        $regions = $em->getRepository('CoreBundle:Region')->findBy(array(), array('name' => 'asc'));

        return $this->render('CoreBundle:Setting:index.html.twig', array(
            'domaines' => $domaines,
            'taxes' => $taxes,
            'regions' => $regions,
            'regionForm' => $regionForm->createView(),
            'taxeForm' => $taxeForm->createView(), 
            'domaineForm' => $domaineForm->createView()
        ));
    }

    public function manageAction(Request $request, $entity, $id = null) {
        $em = $this->getDoctrine()->getManager();

        $entityName = ucfirst($entity);
        $form = null;
        $obj = $em->getRepository('CoreBundle:'.$entityName)->oneOrNew($id);
        switch ($entity) {
            case 'service':
                $form = $this->createForm(ServiceType::class, $obj);
                break;
            case 'poste':
                $form = $this->createForm(PosteType::class, $obj);
                break;
            case 'competence':
                $form = $this->createForm(CompetenceType::class, $obj);
                break;
            case 'echelon':
                $form = $this->createForm(EchelonType::class, $obj);
                break;
        }

        if($form == null) {
            $this->addFlash('danger', 'Formulaire non trouvé.');
            return $this->redirectToRoute('core_homepage');
        }

        $form->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $em->persist($obj);
                    $em->flush();
                    $this->addFlash('info', 'Données du formulaire '.$entityName.' enregistrées avec succès.');
                    return $this->redirectToRoute('core_setting_manage', ['entity' => $entity]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
        }
        $entities = $em->getRepository('CoreBundle:'.$entityName)->findBy([],['id' => 'desc']);

        return $this->render('CoreBundle:Setting:manage.html.twig', ['form' => $form->createView(), 'entity' => $entity, 'entities' => $entities]);

    }

    public function deleteAction(Request $request, $type, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CoreBundle:'.ucfirst($type))->findOneById($id);

        if(!$entity)
            return $this->createNotFoundException("L'entité que vous recherchez à supprimer n'existe pas.");

        $em->remove($entity);
        $em->flush();
        $this->addFlash('info', ucfirst($type)." supprimé.");

        return $this->redirectToRoute('core_setting_home');
    }

    public function salaireAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('CoreBundle:User')->findAll();
        
        $employes = [];
        foreach ($users as $key => $user) {
            if($user->lastEchelon() != null && $user->lastEchelon()->getEchelon()&& $user->lastEchelon()->getEchelon()->getSalaire() && !$user->hasRole('ROLE_SUPER_ADMIN')) {
                $employes[]['user'] = $user;
                // Salaire brut de l'utilisateur
                $employes[]['sbrut'] = $user->lastEchelon()->getEchelon()->getSalaire()->getMontant();
                $snet = $user->lastEchelon()->getEchelon()->getSalaire()->getMontant();
                $datePaiement = \DateTime::createFromFormat('d',$user->lastEchelon()->getEchelon()->getSalaire()->getDatePaiement());
                $sday = $snet / $user->lastEchelon()->getEchelon()->getSalaire()->getDuration();
                $spenalite = 0;
                $jpenalite = 0;
                foreach ($user->getPenalites() as $key => $penalite) {
                    if($datePaiement <= $penalite->getDate()) {
                        $jpenalite = $jpenalite + $penalite->getDuration();
                        $spenalite = $spenalite + ($sday * $penalite->getDuration());
                    }
                }
                $snet = $snet  - $spenalite;
                $staxe = 0;
                foreach ($$user->lastEchelon()->getEchelon()->getSalaire()->getTaxes() as $key => $taxe) {
                    $staxe = $staxe + ($snet * $taxe->getPercent() / 100);
                }
                $snet = $snet - $staxe;
                // Jour de pénalité de l'utilisateur
                $employes[]['jpenalite'] = $jpenalite;
                // Total de la somme à déduire en fonction de ses pénalités
                $employes[]['spenalite'] = $spenalite;
                // Total des taxes
                $employes[]['staxe'] = $staxe;
                // Total net à payer
                $employes[]['snet'] = $snet;
                // Date du salaire
                $employes[]['date'] = \CoreBundle\Utils\Utils::dateFormat($datePaiement);
            }
        }


        return $this->render('CoreBundle:Setting:salaire.html.twig', ['employes' => $employes]);
    }

    public function profilAction(Request $request, $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('CoreBundle:User')->findAll();
        $personnes = $em->getRepository('CoreBundle:Personne')->findAll();
        
        $profils = [];
        foreach ($users as $key => $user) {
            if(!$user->hasRole('ROLE_SUPER_ADMIN')){
                $profils[$user->getEmail()] = $user;
            }
        }

        foreach ($personnes as $key => $personne) {
            if(!array_key_exists($personne->getEmail(), $profils)) {
                $profils[$personne->getEmail()] = $personne;
            }
        }

        $elements = [];
        $entities = [];
        if($entity == 'poste') {
            $postes = $em->getRepository('CoreBundle:Poste')->findAll();
        }else{
            $postes = $em->getRepository('CoreBundle:Service')->findAll();
        }

        foreach ($postes as $key => $poste) {
            $elements[$key]['item'] = $poste;
            $elements[$key]['competences'] = [];
            $elements[$key]['profiles'] = [];
            $elements[$key]['domaines'] = [];
            foreach ($profils as $k => $profil) {
                if(is_object($profil) && $profil instanceof \CoreBundle\Utils\Conditionnable && $this->condition($poste->getConditions(), $profil)) {
                    $elements[$key]['competences'][$k] = $this->competence($poste->getCompetence(), $profil->getCompetence());
                    $elements[$key]['profiles'][$k] = $this->profile($poste->getProfil(), $profil->getProfile());
                    $elements[$key]['domaines'][$k] = $this->domaine($poste->getDomaines(), $profil->getDomaines());
                }
            }  
        }

        foreach ($elements as $key => $element) {
            $entities[$key]['item'] = $element['item'];
            $entities[$key]['items'] = [];
            foreach ($element['competences'] as $k => $competence) {
                $entities[$key]['items'][$k] = $competence + $element['profiles'][$k] + $element['domaines'][$k];
            }
            $items = $entities[$key]['items'];
            arsort($items);
            $entities[$key]['items'] = [];
            foreach ($items as $k => $item) {
                $entities[$key]['items'][] = $profils[$k];
            }
        }
        
        return $this->render('CoreBundle:Setting:profil.html.twig', ['entities' => $entities, 'name' => $entity]);
    }

    private function condition($conditions, $b) {
        if($b instanceof \CoreBundle\Utils\Conditionnable) {
            foreach ($conditions as $key => $condition) {
                if(!$condition->isOk($b)) {
                    return false;
                }
            }

            return true;
        }else {
            return false;
        }
    }

    private function domaine($a, $b) {
        $mark = 0;
        $names = [];
        foreach ($b as $key => $value) {
            if(!is_null($value)) {
                $names[] = $value->getName();
            }
        }
        foreach ($a as $key => $value) {
            if(in_array($value->getName(), $names)) {
                $mark++;
            }
        }

        return $mark;
    }

    private function profile($a, $b) {
        return similar_text($a, $b);
    }

    private function competence($a, $b) {
        $competencesA = explode(',', strtolower($a));
        $competencesB = explode(',', strtolower($b));

        $mark = 0;

        foreach ($competencesA as $key => $value) {
            if(in_array($value, $competencesB)) {
                $mark++;
            }
        }
        return $mark;
    }
}
