<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\PlaceFormType;
use App\Repository\CityRepository;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    #[Route('/addplace', name: 'add_place', methods: ['GET','POST'])]
    public function addPlace(Request $request, EntityManagerInterface $em, CityRepository $cr, PlaceRepository $pr): Response
    {
        $place = new Place();
        $placeForm = $this->createForm(PlaceFormType::class, $place);
        $placeForm->handleRequest($request);

        if($placeForm->isSubmitted() and $placeForm->isValid()){
            $this->addFlash('success', 'You added a place');
            $em->persist($place);
            $em->flush();
        }
        return $this->render('place/addPlace.html.twig',[
            'placeForm' => $placeForm
    ]);
    }
}
