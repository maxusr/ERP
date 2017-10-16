<?php

namespace SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class LibraryController extends Controller
{
    public function indexAction()
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }
        return $this->redirectToRoute('school_homepage');
    }
    public function borrowsAction(Request $request)
    {
        if(!$this->getUser()->can('ACCESS_SCHOOL')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('core_logout');
        }

        if(!$this->getUser()->can('MANAGE_LIBRARY')){
            $this->addFlash('danger', "Vous n'avez pas accès à cette section.");
            return $this->redirectToRoute('school_homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $borrowings = $em->getRepository('SchoolBundle:BookBorrowing')->findBy([],['id' => 'desc']);

        return $this->render('SchoolBundle:Library:borrows.html.twig', ['borrowings' => $borrowings]);
    }
}
