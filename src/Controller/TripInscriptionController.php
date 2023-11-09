<?php

namespace App\Controller;

use App\Entity\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripInscriptionController extends AbstractController
{
    #[Route('/trip/{id}/inscription', name: 'trip_inscription',requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function inscription(Trip $trip, EntityManagerInterface $em): Response
    {
        $trip->addUser($this->getUser());
        $em->persist($trip);
        $em->flush();
        $this->addFlash('success', 'You have been subscribe for this trip');
        return $this->redirectToRoute('display_all_updated');
    }

    #[Route('/trip/{id}/desinscription', name: 'trip_desinscription',requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function desinscription(Trip $trip, EntityManagerInterface $em): Response
    {
        $trip->removeUser($this->getUser());
        $em->persist($trip);
        $em->flush();
        $this->addFlash('success', 'You have been unsubscribe for this trip');
        return $this->redirectToRoute('display_all_updated');
    }
}
