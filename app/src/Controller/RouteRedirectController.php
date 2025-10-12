<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class RouteRedirectController extends AbstractController
{
    // Route accessible via /redirect-after-login, nommée 'app_redirect'
    #[Route('/redirect-after-login', name: 'app_redirect')]
    public function redirectAfterLogin(AuthorizationCheckerInterface $authorizationChecker): Response
    {
        // Si l'utilisateur a le rôle ROLE_ADMIN, redirige vers la route admin
        if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admins');
        }

        // Sinon si l'utilisateur a le rôle ROLE_TEACHER, redirige vers la route teacher
        if ($authorizationChecker->isGranted('ROLE_TEACHER')) {
            return $this->redirectToRoute('app_teachers');
        }

        // Sinon si l'utilisateur a le rôle ROLE_PARENT, redirige vers la route parents
        if ($authorizationChecker->isGranted('ROLE_PARENT')) {
            return $this->redirectToRoute('app_parents');
        }

        // Sinon redirige vers la page de profil par défaut (ROLE_USER ou autre)
        return $this->redirectToRoute('app_profile');
    }
}
