<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // Assigner éventuellement un rôle par défaut si non défini
            if (empty($user->getRoles())) {
                $user->setRoles(['ROLE_USER']); // rôle par défaut
            }

            // Redirection selon le rôle
            if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                return $this->redirectToRoute('app_admins');
            } elseif (in_array('ROLE_TEACHER', $user->getRoles(), true)) {
                return $this->redirectToRoute('app_teachers');
            } elseif (in_array('ROLE_STUDENT', $user->getRoles(), true)) {
                return $this->redirectToRoute('app_parents');
            }

            // Par défaut
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}

