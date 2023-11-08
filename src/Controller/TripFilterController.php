<?php

namespace App\Controller;

use App\Form\FilterType;
use App\Form\Models\FilterModel;
use App\Repository\StateRepository;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use function Symfony\Component\Clock\now;

class TripFilterController extends AbstractController
{
    #[Route('/displayAllTrips', name: 'display_all_updated', methods: ['GET', 'POST'])]
    public function filter(Request $request, TripRepository $tr, StateRepository $sr): Response
    {
        $trips = $tr->findAll();

        $filter = new FilterModel();
        $filterForm = $this->createForm(FilterType::class, $filter);
        $filterForm->handleRequest($request);
        $date = now();
        $dateUpdated =  $date->format('Y-m-d');
        var_dump($dateUpdated);
        foreach($trips as $trip){
            $datesTrips = $trip->getDateStartTime()->format('Y-m-d');
            if($datesTrips == $dateUpdated){
                $trip->setState($sr->findOneBy(['name' => 'In progress']));
            }
        }
        if($filterForm->isSubmitted()){
            $trips = $tr->personnalizedSearch($filter, $this->getUser());
        }

        return $this->render('trip/tripList.html.twig', [
            'trips' => $trips,
            'filterForm' =>$filterForm
        ]);
    }
}
