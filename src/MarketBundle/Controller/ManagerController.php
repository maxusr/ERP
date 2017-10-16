<?php

namespace MarketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

class ManagerController extends Controller
{
    public function indexAction()
    {

        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        return $this->render('MarketBundle:Manager:index.html.twig');
    }

    public function manageAction(Request $request, $entity, $id = null) {

        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();

        $entityName = ucfirst($entity);
        $form = null;
        $obj = $em->getRepository('MarketBundle:'.$entityName)->oneOrNew($id);
        switch ($entity) {
            case 'product':
                $form = $this->createForm(\MarketBundle\Form\ProductType::class, $obj);
                break;
            case 'productVariant':
                $form = $this->createForm(\MarketBundle\Form\ProductVariantType::class, $obj);
                break;
            case 'client':
                $form = $this->createForm(\MarketBundle\Form\ClientType::class, $obj);
                break;
            case 'productAttribute':
                $form = $this->createForm(\MarketBundle\Form\ProductAttributeType::class, $obj);
                break;
        }

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
                    $this->addFlash('info', 'Données du formulaire '.$entityName.' enregistrées avec succès.');
                    return $this->redirectToRoute('market_setting_manage', ['entity' => $entity]);
                }else{
                    $this->addFlash('danger', 'Formulaire incorrect. Veuillez vérifier les champs.');
                }
            }
            if($entity == 'productVariant') {
                if($request->request->has('quantity')){
                    $quantity = new \MarketBundle\Entity\ProductQuantity;
                    $quantity->setQuantity($request->request->get('quantity'));
                    $quantity->setAction($request->request->get('action'));
                    $quantity->setInsertedAt(\DateTime::createFromFormat('d-m-Y', $request->request->get('date')));
                    $product = $em->getRepository('MarketBundle:ProductVariant')->findOneById($request->request->get('product'));
                    $quantity->setProduct($product);
                    $em->persist($quantity);
                    $em->flush();
                    $this->addFlash('info', 'Nouvelle quantité enregistrée avec succès.');
                    return $this->redirectToRoute('market_setting_manage', ['entity' => $entity]);
                }
                if($request->request->has('attribute')){
                    $value = new \MarketBundle\Entity\ProductAttributeValue;
                    $value->setValue($request->request->get('value'));
                    $product = $em->getRepository('MarketBundle:ProductVariant')->findOneById($request->request->get('product'));
                    $attribute = $em->getRepository('MarketBundle:ProductAttribute')->findOneById($request->request->get('attribute'));
                    $value->setAttribute($attribute);
                    $value->setProduct($product);
                    $em->persist($value);
                    $em->flush();
                    $this->addFlash('info', 'Nouvelle valeur enregistrée avec succès.');
                    return $this->redirectToRoute('market_setting_manage', ['entity' => $entity]);
                }
            }
        }
        $entities = $em->getRepository('MarketBundle:'.$entityName)->findBy([],['id' => 'desc']);
        $attributes = [];
        if($entity == 'productVariant')
            $attributes = $em->getRepository('MarketBundle:ProductAttribute')->findBy([],['id' => 'desc']);

        return $this->render('MarketBundle:Manager:manage.html.twig', ['attributes' => $attributes, 'form' => $form->createView(), 'entity' => $entity, 'entities' => $entities]);

    }

    public function deleteAction(Request $request, $type, $id)
    {

        if(!$this->getUser()->can('ACCESS_MARKET')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MarketBundle:'.ucfirst($type))->findOneById($id);

        if(!$entity)
            return $this->createNotFoundException("L'entité que vous essayez de supprimer n'existe pas.");

        $em->remove($entity);
        $em->flush();
        $this->addFlash('info', ucfirst($type)." supprimé.");

        return $this->redirectToRoute('market_homepage');
    }
}
