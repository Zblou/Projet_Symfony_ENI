<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trip')]
class TripController extends AbstractController
{

    #[Route('/create', name: 'create_trip', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $trip = new Trip();
        $tripForm = $this->createForm(TripType::class, $trip);

        if($tripForm->isSubmitted() && $tripForm->isValid()){
            $trip->setOrganizer($request->getUser());
            $em->persist($trip);
            $em->flush();

            $this->addFlash('success', 'La sortie à bien été enregistrée !');

            return $this->redirectToRoute('trip_details', ['id' => $trip->getId()]);
        }

        return $this->render('trip/tripCreate.html.twig', [
            'tripForm' => $tripForm
        ]);
    }
}
