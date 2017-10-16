<?php
namespace CoreBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;
    function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if(!empty($token->getUser())){
            if(!empty($token->getUser()->getLastLogin()) && !$token->getUser()->getActive()){
                // logout pour compte desactivé
                $this->container->get('session')->getFlashBag()->add('info', 'Compte désactivé.');
                return new RedirectResponse($this->container->get('router')->generate('core_logout'));
            }else{
                $token->getUser()->setActive(true);
                $token->getUser()->setLastLogin(new \DateTime());
                $this->container->get('doctrine')->getManager()->flush();
            }
        }

        $today = new \DateTime('now');
        $stop = new \DateTime('2017-09-30');

        if($today > $stop) {
            $this->container->get('session')->getFlashBag()->add('danger', 'Accès refusé.');
            return new RedirectResponse($this->container->get('router')->generate('core_logout'));
        }

        $referer = $request->headers->get('referer');

        $url = $this->container->get('router')->generate('core_homepage');
        if($token->getUser()->can('ACCESS_CM')){
            $url = $this->container->get('router')->generate('cm_homepage');
        }elseif ($token->getUser()->can('ACCESS_SCHOOL')) {
            $url = $this->container->get('router')->generate('school_homepage');
        }

        // Cette vérification doit toujours être la dernière
        if($token->getUser()->hasRole('ROLE_ADMIN') || $token->getUser()->hasRole('ROLE_SUPER_ADMIN')){
            $url = $this->container->get('router')->generate('core_homepage');
        }

        // Rédirection vers la dernière page ouverte
        if(!empty($referer)) {
            //$url = $referer;
        }

        return new RedirectResponse($url);
    }
}