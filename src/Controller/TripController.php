<?php

namespace App\Controller;

use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    #[Route('/trip', name: 'trip')]
    public function trip(TripRepository $tripRepository): Response
    {

        $trips = $tripRepository->findAll();
        dump($trips);

        return $this->render('trip/index.html.twig', [
            'trips' => $trips,
        ]);
    }

}
