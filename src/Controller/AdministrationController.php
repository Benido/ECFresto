<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BusinessHoursRepository;
use App\Enum\Weekdays;

class AdministrationController extends AbstractController
{
    #[Route('/administration', name: 'app_administration')]
    public function index(BusinessHoursRepository $businessHoursRepository ): Response
    {
        $weeklyScheduleDraft = $businessHoursRepository->findAllAndStringify();
        $formattedWeeklySchedule = $this->ScheduleFormatter($weeklyScheduleDraft);
        return $this->render('administration/index.html.twig', [
            'controller_name' => 'AdministrationController',
            'formatted_weekly_schedule' => $formattedWeeklySchedule
        ]);
    }

    private function ScheduleFormatter(array $weeklyScheduleDraft): array
    {
        function dailyFormatter(string $day, array $Draft ): array
        {

            $temp_array[] = array_filter($Draft, fn($a) => in_array($day, $a));
            $temp_array = array_merge(...$temp_array);
            $dailyHours = [];
            foreach($temp_array as $array) {
                //$dailyHours[] = $array[1][0] === null ? 'fermé' : $array[1];   pour l'instant géré par twig
                $dailyHours[] = $array[1];
                //echo '<pre>'; var_dump($array[1]); echo '</pre>';
            }
            return $dailyHours;
        }

        $formattedWeeklySchedule = [];
        foreach (Weekdays::values() as $day ) {
            $formattedWeeklySchedule[$day] = dailyFormatter($day, $weeklyScheduleDraft);
        }


        return $formattedWeeklySchedule;
    }
}
