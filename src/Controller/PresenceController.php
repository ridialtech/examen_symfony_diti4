<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Repository\SeanceRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_FORMATEUR')]
class PresenceController extends AbstractController
{
    #[Route('/presence/{seance}', name: 'presence_mark')]
    public function mark(
        Request $request,
        SeanceRepository $seanceRepository,
        StudentRepository $studentRepository,
        EntityManagerInterface $em,
        int $seance
    ): Response {
        $seance = $seanceRepository->find($seance);
        $students = $studentRepository->findAll();

        if ($request->isMethod('POST')) {
            foreach ($students as $student) {
                $status = $request->request->get('status_'.$student->getId());
                if (!$status) {
                    continue;
                }
                $presence = new Presence();
                $presence->setStudent($student)
                    ->setSeance($seance)
                    ->setStatus($status);
                $em->persist($presence);
            }
            $em->flush();
            return $this->redirectToRoute('seance_index');
        }

        return $this->render('presence/mark.html.twig', [
            'students' => $students,
            'seance' => $seance,
        ]);
    }
}
