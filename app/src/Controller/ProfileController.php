<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Students;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();
        /**
         * @var string $getStudents
         */
        $student = $user?->getStudents();

        // Valeurs par défaut
        $grades = $student ? $student->getGrades() : [];
        $courses = $student ? $student->getCourses() : [];
        $payments = $student ? $student->getPayments() : [];
        $parent = $student && $student->getParentUsers()->count() > 0
                    ? $student->getParentUsers()->first()
                    : null;

        $averageGrade = null;
        if ($grades instanceof \Doctrine\Common\Collections\Collection && $grades->count() > 0) {
            $total = 0;
            foreach ($grades as $grade) {
                $total += (float) $grade->getValue();
            }
            $averageGrade = $total / $grades->count();
        }

        // Même si aucun étudiant, Twig aura des objets "vides" ou listes vides
        return $this->render('profile/index.html.twig', [
            'student' => $student ?: new Students(), // objet vide si pas d'étudiant
            'grades' => $grades,
            'courses' => $courses,
            'pendingPayments' => $payments,
            'parent' => $parent,
            'averageGrade' => $averageGrade,
        ]);
    }
}
