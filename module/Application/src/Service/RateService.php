<?php

namespace Application\Service;

/**
 * Class RateService
 * Static service for managing pay rates.
 *
 * @package Application\Service
 */
class RateService
{
    const RATES_PER_GROUP = [
        'A' => 20,
        'B' => 30,
    ];

    public static function getForGroup($jobGroup) {
        return self::RATES_PER_GROUP[$jobGroup];
    }
}