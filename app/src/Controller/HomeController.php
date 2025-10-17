<?php

namespace App\Controller;

use App\Form\ContactsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $form = $this->createForm(ContactsType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($form->getData());
            $entityManagerInterface->flush();
    
            $this->addFlash('success', 'Message a été envoyé');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/index.html.twig', compact('form'));
    }

}
