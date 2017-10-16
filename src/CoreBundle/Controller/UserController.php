<?php

namespace CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CoreBundle\Entity\User;
use CoreBundle\Form\UserType;

class UserController extends BaseController
{
    public function indexAction()
    {
        return $this->render('CoreBundle:User:index.html.twig');
    }

    public function createAction(Request $request, $email, $password) {
        $user = new User;
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setName("Administrateur");
        $user->setSurname("EPAB");
        $user->setCivility("M.");
        $roles = $user->getRoles();
        $roles[] = 'ROLE_SUPER_ADMIN';
        $user->setRoles($roles);
    

        $this->persistUser($user);

        return $this->redirectToRoute('core_login');
    }

    public function resetAction(Request $request, $email, $password) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CoreBundle:User')->findOneByEmail($email);
        if(is_null($user)) {
            return new Response("Aucun compte créé avec l'email $email");
        }
        $user->setPassword($password);

        $this->persistUser($user);

        return $this->redirectToRoute('core_login');
    }

    private function persistUser(User $user) {
        $em = $this->getDoctrine()->getManager();
        $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $em->persist($user);
        $em->flush();
    	$this->addFlash('info', 'User enregistré ou modifié avec succès.');
    }

    public function insertAction(Request $request)
    {

    	$user = new User();
    	$userForm = $this->createForm(UserType::class, $user);

    	if($request->getMethod() == 'POST'){
    		$userForm->handleRequest($request);
    		if($userForm->isSubmitted() && $userForm->isValid()){
                $user = $this->grant($user);
                $this->persistUser($user);
    			return $this->redirectToRoute('core_User_fetch_all');
    		}else{
    			$this->addFlash('error', 'Erreur sur votre formulaire. Veuillez vérfier vos champs.');
    		}
    	}

        return $this->render('CoreBundle:User:insert.html.twig', array('title' => 'Ajout User', 'formUser' => $userForm->createView()));
    }

    public function grant(User $user) {
        $roles = $user->getRoles();

        if($user->getAttribution()->getNiveau() == 1){
            $roles[] = 'ROLE_AGENT';
        }

        if($user->getAttribution()->getNiveau() == 2){
            $roles[] = 'ROLE_MAJOR';
        }

        if($user->getAttribution()->getNiveau() == 3){
            $roles[] = 'ROLE_CHEF';
        }

        if($user->getAttribution()->getType() == 5){
            $roles[] = 'ROLE_PEV';
        }

        if($user->getAttribution()->getType() == 6){
            $roles[] = 'ROLE_OMS';
        }

        $user->setRoles($roles);

        return $user;
    }
}
