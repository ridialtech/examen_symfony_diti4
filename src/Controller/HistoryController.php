<?php

namespace App\Controller;

use App\Repository\PresenceRepository;
use App\Repository\StudentRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HistoryController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/history/student/{id}', name: 'history_student')]
    public function byStudent(PresenceRepository $presenceRepository, StudentRepository $studentRepository, int $id): Response
    {
        $student = $studentRepository->find($id);
        $presences = $presenceRepository->findBy(['student' => $student]);
        return $this->render('history/student.html.twig', [
            'student' => $student,
            'presences' => $presences,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/history/seance/{id}', name: 'history_seance')]
    public function bySeance(PresenceRepository $presenceRepository, SeanceRepository $seanceRepository, int $id): Response
    {
        $seance = $seanceRepository->find($id);
        $presences = $presenceRepository->findBy(['seance' => $seance]);
        return $this->render('history/seance.html.twig', [
            'seance' => $seance,
            'presences' => $presences,
        ]);
    }
}
