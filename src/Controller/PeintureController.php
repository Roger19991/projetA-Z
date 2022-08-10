<?php

namespace App\Controller;

use App\Repository\PeintureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PeintureController extends AbstractController
{
    #[Route('/realisations', name: 'app_realisations')]
    public function realisations(PeintureRepository $peintureRepository): Response
    {
        return $this->render('peinture/realisations.html.twig', [
            'peintures_name' => $peintureRepository->findAll(),
        ]);
    }
}
