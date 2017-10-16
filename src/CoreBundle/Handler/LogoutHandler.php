<?php
namespace CoreBundle\Handler;

use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutHandler implements LogoutHandlerInterface
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;

    /**
     * Invalidate the current session.
     *
     * @param Request        $request
     * @param Response       $response
     * @param TokenInterface $token
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        if(!empty($token->getUser())){
            if($request->query->has('timeout')){
                $timeout = $request->query->get('timeout') / 60;
                $this->container->get('session')->getFlashBag()->add('danger', 'Aurevoir. Vous avez été déconnecté à la suite d\'une période d\'inactivité de '.$timeout.' minutes par mesure de sécurité');
            }else{
                $this->container->get('session')->getFlashBag()->add('info', 'Aurevoir.');
            }
            $token->getUser()->setLastLogout(new \DateTime());
            $this->container->get('doctrine')->getManager()->flush();
        }
    }
}