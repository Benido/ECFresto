<?php

namespace App\Enum;

enum Weekdays: string {
    case lundi =  'lundi';
    case mardi =  'mardi';
    case mercredi = 'mercredi';
    case jeudi = 'jeudi';
    case vendredi = 'vendredi';
    case samedi = 'samedi';
    case dimanche = 'dimanche';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            Weekdays::lundi => 'lundi',
            Weekdays::mardi => 'mardi',
            Weekdays::mercredi => 'mercredi',
            Weekdays::jeudi => 'jeudi',
            Weekdays::vendredi => 'vendredi',
            Weekdays::samedi => 'samedi',
            Weekdays::dimanche => 'dimanche'
        };
    }
}

