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

    #[Route('/create', name: 'create_trip', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, StateRepository $sr): Response
    {
        $trip = new Trip();
        $trip->setState($sr->findOneBy(['name' => 'Created']));
        $trip->setOrganizer($this->getUser());
        $trip->addUser($this->getUser());

        $tripForm = $this->createForm(TripType::class, $trip);
        $tripForm->handleRequest($request);

        //exemple à utiliser pour enregistrer l'annulation d'une sortie
        if($tripForm->isSubmitted() && $tripForm->isValid()){
            if($request->get('buttonPressed') == 'Publish'){
                $trip->setState($sr->findOneBy(['name' => 'Opened']));
            }elseif($request->get('buttonPressed') == 'Save'){
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



    #[Route('/cancel/{id}', name: 'trip_cancel', requirements: ['id' => '\d+'],  methods: ['GET','POST'])]
    public function cancel(Trip $trip,TripRepository $tripRepository, EntityManagerInterface $em,
                           Request $request, StateRepository $sr): Response
    {
        $reasonForm = $this->createForm(AnnulationType::class, $trip);
        $reasonForm->handleRequest($request);

        if($reasonForm->isSubmitted() && $reasonForm->isValid()){
            #Check if submit button is either publish or register, and set state according to it
//récupérer l'objet "etat" annuler grace au staterepository et setter l'etat dans le trip
            if($request->get('buttonPressed') == 'Save') {
                $trip->setState($sr->findOneBy(['name' => 'Canceled']));
            }

            $em->persist($trip);
            $em->flush();

            $this->addFlash('success', 'Votre sortie a bien été annulée !');

            return $this->redirectToRoute('display_all_updated');
        }
        return $this->render('trip/tripCancel.html.twig', ['trip' => $trip, 'reasonForm' => $reasonForm]);

    }

//    #[Route('/save', name: 'trip_save', methods: ['GET','POST'])]
//    public function save(Trip $trip, EntityManagerInterface $em): Response
//    {
//        $trip->getState()->setName('Created');
//        $em->persist($trip);
//        $em->flush();
//        return $this->redirectToRoute('display_all_updated');
//    }


}
