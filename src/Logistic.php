<?php


namespace Avitotask;


class Logistic {

    public static function calculatePrice(string $departure, string $destination) : float {
        return floatval(abs(self::evaluatePlace($departure) - self::evaluatePlace($destination)));
    }

    private static function evaluatePlace(string $place) : float {
        $sum = 0.0;
        for ($i = 0; $i < strlen($place); $i++) {
            $place = substr($place, $i);
            $sum += ord($place);
        }
        return floatval($sum);
    }
}