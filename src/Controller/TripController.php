<?php

namespace App\Controller;

use App\Entity\State;
use App\Entity\Trip;
use App\Form\AnnulationType;
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
    #[Route('/displayAll', name: 'displayAll')]
    public function trip(TripRepository $tripRepository): Response
    {

        $trips = $tripRepository->findAll();
        dump($trips);

        return $this->render('trip/tripList.html.twig', [
            'trips' => $trips,
        ]);
    }

    #[Route('/create', name: 'create_trip', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, StateRepository $sr): Response
    {
        $trip = new Trip();
        $trip->setState($sr->findOneBy(['name' => 'Créée']));
        $trip->setOrganizer($this->getUser());
        $trip->addUser($this->getUser());

        $tripForm = $this->createForm(TripType::class, $trip);
        $tripForm->handleRequest($request);

        if($tripForm->isSubmitted() && $tripForm->isValid()){
            #Check if submit button is either publish or register, and set state according to it
            if($tripForm->get('publish')->isClicked()){
                $trip->setState($sr->findOneBy(['name' => 'Opened']));
            }elseif ($tripForm->get('register')->isClicked()){
                $trip->setState($sr->findOneBy(['name' => 'Created']));
            }

            $em->persist($trip);
            $em->flush();

            $this->addFlash('success', 'La sortie a bien été enregistrée !');

            return $this->redirectToRoute('display_all_updated');
        }

        return $this->render('trip/tripCreate.html.twig', [
            'tripForm' => $tripForm,

        ]);
    }

    #[Route('/display/{id}', name: 'trip_display', requirements: ['id' => '\d+'],  methods: ['GET'])]
    public function display(Trip $trip): Response
    {
        return $this->render('trip/tripDisplay.html.twig',['trip' => $trip]);

    }
    #[Route('/cancel/{id}', name: 'trip_cancel', requirements: ['id' => '\d+'],  methods: ['GET'])]
    public function cancel(Trip $trip,TripRepository $tripRepository, EntityManagerInterface $em,
                           Request $request): Response
    {
        $reasonForm = $this->createForm(AnnulationType::class, $trip);
        $reasonForm->handleRequest($request);
        return $this->render('trip/tripCancel.html.twig', ['trip' => $trip, 'reasonForm' => $reasonForm]);

    }
    #[Route('/{id}/publish', name: 'trip_publish',requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function publish(Trip $trip, EntityManagerInterface $em): Response
    {
        $trip->getState()->setName('Opened');
        $em->persist($trip);
        $em->flush();
        return $this->redirectToRoute('display_all_updated');
    }


    #[Route('/{id}/save', name: 'trip_save',requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function save(Trip $trip, EntityManagerInterface $em): Response
    {
        $trip->getState()->setName('Created');
        $em->persist($trip);
        $em->flush();
        return $this->redirectToRoute('display_all_updated');
    }


}
