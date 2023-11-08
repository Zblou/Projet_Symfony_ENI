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
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ModifyTripController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/modify/trip/{id}', name: 'modify_trip', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function modifyTrip(Trip $trip, EntityManagerInterface $em, Request $request, StateRepository $sr): Response
    {
        if($trip->getOrganizer() !== $this->getUser()){
            throw $this->createAccessDeniedException();
        }
        $modifyTripForm = $this->createForm(TripType::class,$trip);
        $modifyTripForm->handleRequest($request);

        if($modifyTripForm->isSubmitted() and $modifyTripForm->isValid()){
            if($request->get('buttonPressed') == 'Publish'){
                $trip->setState($sr->findOneBy(['name' => 'Opened']));
            }elseif ($request->get('buttonPressed') == 'Save'){
                $trip->setState($sr->findOneBy(['name' => 'Created']));
            }

            $this->addFlash('success', 'Your trip has been modified');
            $em->persist($trip);
            $em->flush();
            return $this->redirectToRoute('display_all_updated');
        }

        return $this->render('trip/modifytrip.html.twig', [
            'modifyTripForm' => $modifyTripForm,
            'trip' => $trip
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('delete/trip/{id}', name: 'delete_trip', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function deleteTrip(Trip $trip, EntityManagerInterface $em): Response
    {
        if($trip->getOrganizer() !== $this->getUser()){
            throw $this->createAccessDeniedException();
        }

        $em->remove($trip);
        $em->flush();
        $this->addFlash('success','Your trip has been removed');
        return $this->redirectToRoute('display_all_updated');
    }
}
