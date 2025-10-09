<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return new RedirectResponse($this->router->generate('app_admins'));
        }

        if (in_array('ROLE_TEACHER', $user->getRoles())) {
            return new RedirectResponse($this->router->generate('app_teachers'));
        }

        if (in_array('ROLE_PARENT', $user->getRoles())) {
            return new RedirectResponse($this->router->generate('app_parents'));
        }

        if (in_array('ROLE_USER', $user->getRoles())) {
            return new RedirectResponse($this->router->generate('app_profile'));
        }

        return new RedirectResponse($this->router->generate('app_home'));
    }
}
