<?php

namespace App\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use App\Repository\BusinessHoursRepository;

class TwigGlobalSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Twig\Environment
     */
    private $twig;
    /**
     * @var BusinessHoursRepository
     */
    private BusinessHoursRepository $manager;

    public function __construct(Environment $twig, BusinessHoursRepository $manager)
    {
        $this->twig = $twig;
        $this->manager = $manager;
    }

    public function injectGlobalVariables(ControllerEvent $event)
    {
        $weeklyBusinessHours = $this->manager->getFormattedWeeklySchedule();
        $this->twig->addGlobal('weeklyBusinessHours', $weeklyBusinessHours);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => 'injectGlobalVariables'];
    }
}