<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Place;
use App\Form\PlaceFormType;
use App\Repository\CityRepository;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PlaceController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/addplace', name: 'add_place', methods: ['GET','POST'])]
    public function addPlace(Request $request, EntityManagerInterface $em): Response
    {
        $place = new Place();
        $placeForm = $this->createForm(PlaceFormType::class, $place);
        $placeForm->handleRequest($request);

        if($placeForm->isSubmitted() and $placeForm->isValid()){
            $place->setLongitude(-4.5695);
            $place->setLatitude(85.5698);
            $this->addFlash('success', 'You added a place');
            $em->persist($place);
            $em->flush();
            return $this->redirectToRoute('create_trip');
        }
        return $this->render('place/addPlace.html.twig',[
            'placeForm' => $placeForm,
            'place' => $place
    ]);
    }
}
