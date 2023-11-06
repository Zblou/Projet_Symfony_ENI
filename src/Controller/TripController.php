<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\StateRepository;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trip')]
class TripController extends AbstractController
{

    #[Route('/create', name: 'create_trip', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, StateRepository $sr): Response
    {
        $trip = new Trip();
        $trip->setState($sr->findOneBy(['name' => 'Créée']));
        $trip->setOrganizer($this->getUser());

        $tripForm = $this->createForm(TripType::class, $trip);
        $tripForm->handleRequest($request);

        if($tripForm->isSubmitted() && $tripForm->isValid()){
            #Check if submit button is either publish or register, and set state according to it
            if($tripForm->get('publish')->isClicked()){
                $trip->setState($sr->findOneBy(['name' => 'Ouverte']));
            }elseif ($tripForm->get('register')->isClicked()){
                $trip->setState($sr->findOneBy(['name' => 'Créée']));
            }

            $em->persist($trip);
            $em->flush();

            $this->addFlash('success', 'La sortie a bien été enregistrée !');

            return $this->redirectToRoute('displayAll');
        }

        return $this->render('trip/tripCreate.html.twig', [
            'tripForm' => $tripForm
        ]);
    }

    #[Route('/display/{id}', name: 'trip_display', requirements: ['id' => '\d+'],  methods: ['GET'])]
    public function display(Trip $trip,TripRepository $tripRepository): Response
    {
        return $this->render('trip/tripDisplay.html.twig',['trip' => $trip]);

    }
}
