<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_FORMATEUR')]
class SeanceController extends AbstractController
{
    #[Route('/seance', name: 'seance_index')]
    public function index(SeanceRepository $repo): Response
    {
        $seances = $repo->findBy(['formateur' => $this->getUser()]);
        return $this->render('seance/index.html.twig', ['seances' => $seances]);
    }

    #[Route('/seance/new', name: 'seance_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $seance->setFormateur($this->getUser());
            $em->persist($seance);
            $em->flush();
            return $this->redirectToRoute('seance_index');
        }
        return $this->render('seance/new.html.twig', ['form' => $form]);
    }
}
