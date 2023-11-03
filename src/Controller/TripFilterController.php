<?php

namespace App\Controller;

use App\Form\FilterType;
use App\Form\Models\FilterModel;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripFilterController extends AbstractController
{
    #[Route('/displayAllTrips', name: 'display_all_updated')]
    public function filter(Request $request, TripRepository $tripRepository): Response
    {
        $trips = $tripRepository->findAll();

        $filter = new FilterModel();
        $filterForm = $this->createForm(FilterType::class, $filter);
        $filterForm->handleRequest($request);

        if($filterForm->isSubmitted()){
            # Modify SQL request according to the filter object $filter properties
            var_dump($filter);
        }

        return $this->render('trip/tripList.html.twig', [
            'trips' => $trips,
            'filterForm' =>$filterForm
        ]);
    }
}
