<?php

namespace SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SchoolBundle\Form\BookBorrowingType;

use SchoolBundle\Entity\BookBorrowing;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    public function indexAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        $em = $this->getDoctrine()->getManager();
        $borrows = $em->getRepository('SchoolBundle:BookBorrowing')->findBy(['returnAt' => null],['id' => 'desc']);
        $students = $em->getRepository('SchoolBundle:Student')->findBy([],['id' => 'desc'], 8, 0);

        $borrowing = new BookBorrowing;
        $formBorrow = $this->createForm(BookBorrowingType::class, $borrowing);
        $formBorrow->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn btn-block btn-success']]);

        if($request->isMethod('POST')) {
            $formBorrow->handleRequest($request);
            if($formBorrow->isSubmitted()) {
                if($formBorrow->isValid()) {
                    $em->persist($borrowing);
                    $em->flush();
                    $this->addFlash('info', 'Emprunt enregistré avec succès.');
                }else{
                    $this->addFlash('warning', 'Erreur dans le formulaire d\'insertion d\'un emprunt.');
                }
            }
        }

        $borrowings = [];
        foreach ($borrows as $key => $borrow) {
            if($borrow->finished()) {
                $borrowings[] = $borrow;
            }
        }

        return $this->render('SchoolBundle:App:index.html.twig', ['formBorrow' => $formBorrow->createView(), 'students' => $students, 'borrowings' => $borrowings]);
    }
}
