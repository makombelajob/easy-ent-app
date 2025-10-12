<?php

namespace App\Controller;

use App\Repository\ParentUsersRepository;
use App\Repository\PaymentsRepository;
use App\Repository\StudentsRepository;
use App\Repository\TeachersRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminsController extends AbstractController
{
    #[Route('/admins', name: 'app_admins')]
    public function index(
        StudentsRepository $studentsRepo,
        TeachersRepository $teachersRepo,
        ParentUsersRepository $parentsRepo,
        PaymentsRepository $paymentsRepo
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admins/index.html.twig', [
            'students' => $studentsRepo->findAll(),
            'teachers' => $teachersRepo->findAll(),
            'parents' => $parentsRepo->findAll(),
            'payments' => $paymentsRepo->findAll(),
        ]);
    }

    #[Route('/admin/facture/{id}', name: 'admin_invoice')]
    public function generateInvoice(PaymentsRepository $paymentsRepo, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $payment = $paymentsRepo->find($id);

        if (!$payment) {
            throw $this->createNotFoundException('Paiement introuvable');
        }

        $student = $payment->getStudents();
        $parent = $payment->getParentUsers();

        // Configuration Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($pdfOptions);

        // HTML à rendre
        $html = $this->renderView('admins/invoice.html.twig', [
            'payment' => $payment,
            'student' => $student,
            'parent' => $parent,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'facture_' . $payment->getId() . '.pdf';
        return new Response($dompdf->stream($fileName, ["Attachment" => false]));
    }
}
