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
    #[Route('/displayAllTrips', name: 'display_all_updated', methods: ['GET', 'POST'])]
    public function filter(Request $request, TripRepository $tr): Response
    {
        $trips = $tr->findAll();

        $filter = new FilterModel();
        $filterForm = $this->createForm(FilterType::class, $filter);
        $filterForm->handleRequest($request);
        var_dump($filter);


        if($filterForm->isSubmitted()){
            var_dump($filter);
            var_dump($filterForm);
            $trips->$tr->personnalizedSearch([$filter->campus,
                $filter->contains,
                $filter->dateStartTime,
                $filter->dateEndTime,
                $filter->isOrganizer,
                $filter->isRegisteredTo,
                $filter->isNotRegisteredTo,
                $filter->isPassed]);
            # Modify SQL request according to the filter object $filter properties
            var_dump($filter);
        }

        return $this->render('trip/tripList.html.twig', [
            'trips' => $trips,
            'filterForm' =>$filterForm
        ]);
    }
}
