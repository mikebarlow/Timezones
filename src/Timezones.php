<?php

namespace Snscripts\Timezones;

use DateTime;
use DateTimeZone;

class Timezones
{
    /**
     * convert the given DateTime into UTC timezone
     *
     * @param DateTime|string $DateTime
     * @param DateTimeZone|string|null $Timezone
     * @param string $format
     * @return string
     */
    public function convertToUTC($DateTime, $Timezone = null, $format = 'Y-m-d H:i:s')
    {
        if (! ($DateTime instanceof DateTime)) {
            if (is_null($Timezone)) {
                throw new \InvalidArgumentException(
                    '$Timezone must be defined when $DateTime is not an instance of DateTime'
                );
            }

            if (is_string($Timezone)) {
                $Timezone = new DateTimeZone($Timezone);
            }

            if (! ($Timezone instanceof DateTimeZone)) {
                throw new \InvalidArgumentException(
                    'A valid DateTimeZone object could not be loaded'
                );
            }

            $DateTime = new DateTime(
                $DateTime,
                $Timezone
            );
        }

        $DateTime->setTimezone(
            new DateTimeZone('UTC')
        );

        return $DateTime->format($format);
    }

    /**
     * convert the given DateTime into local Timezone from UTC
     *
     * @param DateTime|string $DateTime
     * @param DateTimeZone|string|null $Timezone
     * @param string $format
     * @return string
     */
    public function convertToLocal($DateTime, $Timezone = null, $format = 'Y-m-d H:i:s')
    {
        if (is_null($Timezone)) {
            throw new \InvalidArgumentException(
                '$Timezone must be defined when $DateTime is not an instance of DateTime'
            );
        }

        if (is_string($Timezone)) {
            $Timezone = new DateTimeZone($Timezone);
        }

        if (! ($Timezone instanceof DateTimeZone)) {
            throw new \InvalidArgumentException(
                'A valid DateTimeZone object could not be loaded'
            );
        }

        if (! ($DateTime instanceof DateTime)) {
            $DateTime = new DateTime(
                $DateTime,
                new \DateTimeZone('UTC')
            );
        }

        $DateTime->setTimezone(
            $Timezone
        );

        return $DateTime->format($format);
    }
}
