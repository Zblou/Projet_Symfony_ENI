<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifyTripController extends AbstractController
{
    #[Route('/modify/trip/{id}', name: 'modify_trip', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function modifyTrip(Trip $trip, EntityManagerInterface $em, Request $request): Response
    {
        $modifyTripForm = $this->createForm(TripType::class,$trip);
        $modifyTripForm->handleRequest($request);

        if($modifyTripForm->isSubmitted() and $modifyTripForm->isValid()){
            $this->addFlash('success', 'Your trip has been modified');
            $em->persist($trip);
            $em->flush();
        }

        return $this->render('trip/modifytrip.html.twig', [
            'modifyTripForm' => $modifyTripForm,
            'trip' => $trip
        ]);
    }

    #[Route('delete/trip/{id}', name: 'delete_trip', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function deleteTrip(Trip $trip, EntityManagerInterface $em): Response
    {
        $em->remove($trip);
        $em->flush();
        $this->addFlash('success','Your trip has been removed');
        return $this->redirectToRoute('displayAll');
    }
}
