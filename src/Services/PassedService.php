<?php

namespace App\Services;

use App\Repository\StateRepository;
use App\Repository\TripRepository;
use function Symfony\Component\Clock\now;

class PassedService
{
    public function __construct(private TripRepository $tr, private StateRepository $sr){

    }
    public function  setStateToPassed():void{

        $dateToday = now();
        $dateTodayFormated = $dateToday->format('Y-m-d');

        $tableTrip = $this->tr->findAll();
        foreach($tableTrip as $trip){

            $dateTripCreated = $trip->getDateStartTime();
            $dateTripCreatedPlusOneDay = $dateTripCreated->modify('+ 1 day');
            $dateTripCreatedPlusOneDayFormated = $dateTripCreatedPlusOneDay->format('Y-m-d');
                if($dateTodayFormated >= $dateTripCreatedPlusOneDayFormated){
                    $trip->setState($this->sr->findOneBy(['name' => 'Passed']));
                }

        }

    }

}