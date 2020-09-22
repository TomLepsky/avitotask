<?php


namespace Avitotask;


class Validator {

    public static function isValidDestination(string $str) : bool {
        if (!empty($str) && strlen($str) > 2)
            return true;
        else
            return false;
    }

    public static function isValidPrice(float $price) : bool {
        if ($price > 0.0)
            return true;
        else
            return false;
    }

    public static function isValidDate(int $timeStamp) : bool {
        if (($timeStamp - time()) > 0)
            return true;
        else
            return false;
    }
}