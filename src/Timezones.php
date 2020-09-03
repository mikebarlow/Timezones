<?php

namespace MBarlow\Timezones;

use DateTime;
use DateTimeZone;

class Timezones
{
    /**
     * convert the given DateTime into UTC timezone
     *
     * @param DateTime|string $dateTime
     * @param DateTimeZone|string|null $tz
     * @param string $format
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function convertToUTC($dateTime, $tz = null, $format = 'Y-m-d H:i:s')
    {
        if (! ($dateTime instanceof DateTime)) {
            if (is_null($tz)) {
                throw new \InvalidArgumentException(
                    '$Timezone must be defined when $DateTime is not an instance of DateTime'
                );
            }

            if (is_string($tz)) {
                $tz = new DateTimeZone($tz);
            }

            if (! ($tz instanceof DateTimeZone)) {
                throw new \InvalidArgumentException(
                    'A valid DateTimeZone object could not be loaded'
                );
            }

            $dateTime = new DateTime(
                $dateTime,
                $tz
            );
        }

        $dateTime->setTimezone(
            new DateTimeZone('UTC')
        );

        return $dateTime->format($format);
    }

    /**
     * convert the given DateTime into local Timezone from UTC
     *
     * @param DateTime|string $dateTime
     * @param DateTimeZone|string|null $tz
     * @param string $format
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function convertToLocal($dateTime, $tz, $format = 'Y-m-d H:i:s')
    {
        if (is_string($tz)) {
            $tz = new DateTimeZone($tz);
        }

        if (! ($tz instanceof DateTimeZone)) {
            throw new \InvalidArgumentException(
                'A valid DateTimeZone object could not be loaded'
            );
        }

        if (! ($dateTime instanceof DateTime)) {
            $dateTime = new DateTime(
                $dateTime,
                new \DateTimeZone('UTC')
            );
        }

        $dateTime->setTimezone(
            $tz
        );

        return $dateTime->format($format);
    }

    public function timezoneList()
    {
        $timezones = DateTimeZone::listIdentifiers();
        $now = new DateTime('now');

        $list = array_map(
            function ($zone) use ($now) {
                $timezone = new DateTimeZone($zone);
                $offset = (int)$timezone->getOffset($now);
                $offsetNice = gmdate('H:i', abs($offset));

                list(,$location) = explode('/', $zone, 2);
                $location = str_replace('_', ' ', $location);

                $offsetDisplay = '';
                if ($offset > 0) {
                    $offsetDisplay = ' +' . $offsetNice;
                } elseif ($offset < 0) {
                    $offsetDisplay = ' -' . $offsetNice;
                }

                return [
                    'timezone' => $zone,
                    'offset'   => $offset,
                    'location' => $location,
                    'label'    => '(UTC' . $offsetDisplay . ') ' . $location,
                ];
            },
            $timezones
        );

        usort(
            $list,
            function ($a, $b) {
                return ($a['offset'] == $b['offset'])
                    ? strcmp($a['location'], $b['location'])
                    : $a['offset'] - $b['offset'];
            }
        );

        return array_combine(
            array_column($list, 'timezone'),
            array_column($list, 'label')
        );
    }
}
