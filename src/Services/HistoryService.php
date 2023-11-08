<?php

namespace App\Services;

use App\Repository\StateRepository;
use App\Repository\TripRepository;
use function Symfony\Component\Clock\now;

class HistoryService
{
    public function __construct(private TripRepository $tr, private StateRepository $sr){

    }

    public function getTableTrip():void{

        $dateToday = now();
        $dateTodayFormated = $dateToday->format('Y-m-d');

        $tableTrip = $this->tr->findAll();
        foreach($tableTrip as $trip){
            $dateStart = $trip->getDateStartTime();
            $datePlusUnMois = $dateStart->modify('+ 1 month');
            $datePlusUnMoisFormated = $datePlusUnMois->format('Y-m-d');
            if ($dateTodayFormated > $datePlusUnMoisFormated){
                $trip->setState($this->sr->findOneBy(['name' => 'Historicized']));
            }

        }

    }


}