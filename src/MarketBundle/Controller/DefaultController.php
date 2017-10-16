<?php

namespace MarketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('MarketBundle:Commande')->findBy([], ['id' => 'desc'], 10, 0);
        $sales = $em->getRepository('MarketBundle:Sale')->findBy([], ['id' => 'desc'], 10, 0);

        return $this->render('MarketBundle:Default:index.html.twig',
            [
                'sales' => $sales,
                'commandes' => $commandes
            ]
        );
    }

    public function statisticsAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('MarketBundle:Commande')->findBy([], ['id' => 'desc']);
        $sales = $em->getRepository('MarketBundle:Sale')->findBy([], ['id' => 'desc']);
        $shippings = [];
        $billings = [];
        foreach ($commandes as $key => $commande) {
            if(!empty($commande->getShippingMode())){
                if(array_key_exists($commande->getShippingMode(), $shippings)){
                    $shippings[$commande->getShippingMode()] += 1;
                }else{
                    $shippings[$commande->getShippingMode()] = 1;
                }
            }

            if(!empty($commande->getBillingMode())){
                if(array_key_exists($commande->getBillingMode(), $billings)){
                    $billings[$commande->getBillingMode()] += 1;
                }else{
                    $billings[$commande->getBillingMode()] = 1;
                }
            }
        }

        $date = new \DateTime('-90 days');
        $salings = [];
        foreach ($sales as $key => $sale) {
            if($sale->getDate() > $date) {
                $d = $sale->getDate()->format('d-m-Y');
                if(array_key_exists($d, $salings)){
                    $salings[$d] += 1;
                }else{
                    $salings[$d] = 1;
                }
            }
        }

        return $this->render('MarketBundle:Default:statistics.html.twig',
            [
                'salings' => $salings,
                'billings' => $billings,
                'shippings' => $shippings
            ]
        );
    }

    public function commandeAction(Request $request, \MarketBundle\Entity\Commande $commande)
    {
        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('MarketBundle:CommandeItem')->findBy(['commande' => $commande]);

        return $this->render('MarketBundle:Default:commande.html.twig',
            [
                'items' => $items,
                'commande' => $commande
            ]
        );
    }

    public function commandesAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();

        $limit = 10;
        $offset = $request->query->get('offset');
        $s = $request->query->get('s');
        if(empty($offset))
            $offset = 0;
        if(empty($s)){
            $commandes = $em->getRepository('MarketBundle:Commande')->findBy([], ['id' => 'desc'], $limit, $offset);
        }else{
            $commandes = $em->getRepository('MarketBundle:Commande')->findBy(['reference' => $s]);
        }

        return $this->render('MarketBundle:Default:commandes.html.twig',
            [
                's' => empty($s) ? $s : '',
                'offset' => count($commandes) > $limit ? $offset + $limit : -1,
                'onset' => $offset >= $limit ? $offset : -1,
                'commandes' => $commandes
            ]
        );
    }

    public function saleAction(Request $request, \MarketBundle\Entity\Sale $sale)
    {
        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('MarketBundle:Commande')->findBy(['sale' => $sale]);

        return $this->render('MarketBundle:Default:sale.html.twig',
            [
                'commandes' => $commandes,
                'sale' => $sale
            ]
        );
    }

    public function salesAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();

        $limit = 10;
        $offset = $request->query->get('offset');
        $s = $request->query->get('s');
        if(empty($offset))
            $offset = 0;
        if(empty($s)){
            $sales = $em->getRepository('MarketBundle:Sale')->findBy([], ['id' => 'desc'], $limit, $offset);
        }else{
            $sales = $em->getRepository('MarketBundle:Sale')->findBy(['date' => $s]);
        }

        return $this->render('MarketBundle:Default:sales.html.twig',
            [
                's' => empty($s) ? $s : '',
                'offset' => count($sales) > $limit ? $offset + $limit : -1,
                'onset' => $offset >= $limit ? $offset : -1,
                'sales' => $sales
            ]
        );
    }

    public function saleEditAction(Request $request, $id = null) {

        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $form = null;
        $obj = $em->getRepository('MarketBundle:Sale')->oneOrNew($id);
        $form = $this->createForm(\MarketBundle\Form\SaleType::class, $obj);

        if($form == null) {
            $this->addFlash('danger', 'Formulaire non trouvé.');
            return $this->redirectToRoute('market_homepage');
        }

        $form->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $em->persist($obj);
                    $em->flush();
                    foreach ($obj->getCommandes() as $key => $commande) {
                        $commande->setSale($obj);
                        $em->persist($commande);
                    }
                    $obj->prePersist();
                    $em->persist($obj);
                    if($obj->getSale()){
                        $sale = $obj->getSale();
                        $commandes = $em->getRepository('MarketBundle:Commande')->findBy(['sale' => $sale]);
                        foreach ($commandes as $key => $commande) {
                            if($commande->getId() != $obj->getId()){
                                $sale->addCommande($commande);
                            }else{
                                $sale->addCommande($obj);
                            }
                        }
                        $em->persist($sale);
                    }
                    $em->flush();
                    $this->addFlash('info', 'Données du formulaire de vente enregistrées avec succès.');
                    return $this->redirectToRoute('market_sale', ['id' => $obj->getId()]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
        }

        return $this->render('MarketBundle:Default:saleEdit.html.twig', ['form' => $form->createView()]);

    }

    public function commandeEditAction(Request $request, $id = null) {

        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $form = null;
        $obj = $em->getRepository('MarketBundle:Commande')->oneOrNew($id);
        $form = $this->createForm(\MarketBundle\Form\CommandeType::class, $obj);

        if($form == null) {
            $this->addFlash('danger', 'Formulaire non trouvé.');
            return $this->redirectToRoute('market_homepage');
        }

        $form->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $em->persist($obj);
                    $em->flush();
                    foreach ($obj->getItems() as $key => $item) {
                        $item->setCommande($obj);
                        $em->persist($item);
                    }
                    $obj->prePersist();
                    $em->persist($obj);
                    $em->flush();
                    $this->addFlash('info', 'Données du formulaire de commande enregistrées avec succès.');
                    return $this->redirectToRoute('market_commande', ['id' => $obj->getId()]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
        }

        return $this->render('MarketBundle:Default:commandeEdit.html.twig', ['form' => $form->createView()]);

    }
}
