<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 28/03/2018
 * Time: 21:13
 */

namespace UserBundle\Entity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


/**
 * Class AfterLoginRedirection
 * @package UserBundle\Entity
 */

class AfterLoginRedirection implements  AuthenticationSuccessHandlerInterface
{

    private $router;

    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request        $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_ADMIN', $rolesTab, true)) {
            // c'est un aministrateur : on le rediriger vers l'espace admin
            $redirection = new RedirectResponse($this->router->generate('admin'));
        } else if (in_array('ROLE_CLIENT', $rolesTab, true)) {
            // c'est un utilisaeur lambda : on le rediriger vers l'accueil
            $redirection = new RedirectResponse($this->router->generate('acceuil_user'));

        }
        else if (in_array('ROLE_VETERINAIRE', $rolesTab, true)) {
            // c'est un utilisaeur lambda : on le rediriger vers l'accueil
            $redirection = new RedirectResponse($this->router->generate('acceuil_veterinaire'));

        }
        else
        {$redirection = new RedirectResponse($this->router->generate('lay'));}

        return $redirection;
    }

}