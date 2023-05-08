<?php

namespace App\Service;

use App\Repository\BusinessHoursRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use DateTime;

class AvailableReservationDateGetter
{

    public function __construct(
        private ReservationRepository $reservationRepository,
        private BusinessHoursRepository $businessHoursRepository,
        private RestaurantRepository $restaurantRepository)
    {}

    public function getAvailableReservationDate(DateTime $inputDate, int $seatsNumber): array
    {
        //On récupère la capacité du restaurant et on déduit le nombre de couverts entré par l'utilisateur
        $maxCapacity = $this->restaurantRepository->getOne()->getMaxCapacity() - $seatsNumber;

        //On trouve le jour de la semaine
        $weekday = $this->getWeekday($inputDate);

        //On cherche les horaires correspondants
        $hours = $this->businessHoursRepository->findBy(['weekday' => $weekday]);
        $businessHours = [];
        $index = 0;
        foreach($hours as $item){
            $businessHours[$index] = [];
            $openingHour = $item->getOpeningHour();
            $lastTimeSlot = $item->getLastTimeSlot();
            //On applique les horaires au jour donné, on modifie la date du jour si l'horaire dépasse minuit, et on les intègre au tableau
            $openingHour?->setDate($inputDate->format('Y'), $inputDate->format('m'),$inputDate->format('d'));
            if ($openingHour && $openingHour->format('H') <= 4) $openingHour->modify('+1 day');
            $businessHours[$index][] = $openingHour;
            $lastTimeSlot?->setDate($inputDate->format('Y'), $inputDate->format('m'),$inputDate->format('d'));
            if ($lastTimeSlot && $lastTimeSlot->format('H') <= 4) $lastTimeSlot->modify('+1 day');
            $businessHours[$index][] = $lastTimeSlot;
            $index++;
        }

        //On génère un tableau de créneaux
        $timeSlots = [];
        $interval15 = new \DateInterval('PT15M');
        $interval45 = new \DateInterval('PT45M');

        foreach($businessHours as $item){
            //On vérifie que le restaurant est ouvert
            if ($item[0]) {
                $timeSlotsSub = [];
                if ($this->checkOccupancy($maxCapacity, $item[0], $interval45)) {
                    $timeSlotsSub[$item[0]->format('H:i')] = $item[0];
                }
                $tempSlot = clone $item[0];
                while ($tempSlot < $item[1]) {
                    $newSlot = clone $tempSlot->add($interval15);
                    //On vérifie le taux d'occupation du restaurant avant d'ajouter le créneau
                    if ($this->checkOccupancy($maxCapacity, $newSlot, $interval45)) {
                        $timeSlotsSub[$newSlot->format('H:i')] = $newSlot;
                    }
                }
                $timeSlots[] = $timeSlotsSub;
            }
        }
        return $timeSlots;
    }

    public function checkOccupancy($maxCapacity, $slot, $interval): bool
    {
            //On soustrait l'intervalle à la date donnée pour prendre en compte les clients
            // arrivés avant et déjà présents dans le restaurant
            $dateMinus = clone $slot;
            $dateMinus->sub($interval);

            //On vérifie l'occupation du restaurant pour le créneau donné
            $occupancy = $this->reservationRepository->getOccupancy($slot, $dateMinus);
            return ($occupancy <= $maxCapacity);

    }

    public function getWeekday(Datetime $inputDate): string
    {
        $dateFormatter = new \IntlDateFormatter(
            'fr-FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            null,
            null,
            'eeee'
        );
        return $dateFormatter->format($inputDate);
    }
}

