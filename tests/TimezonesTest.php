<?php

namespace Mbarlow\Timezones\Tests;

use MBarlow\Timezones\Timezones;
use PHPUnit\Framework\TestCase;

class TimezonesTests extends TestCase
{
    public function testConvertToUTCCanConvertCorrectly()
    {
        $Timezones = new Timezones;

        $this->assertSame(
            $Timezones->convertToUTC(
                '2017-08-14 13:00:00',
                'Europe/London'
            ),
            '2017-08-14 12:00:00'
        );

        $this->assertSame(
            $Timezones->convertToUTC(
                new \DateTime(
                    '2017-11-14 13:00:00',
                    new \DateTimeZone(
                        'Europe/London'
                    )
                )
            ),
            '2017-11-14 13:00:00'
        );

        $this->assertSame(
            $Timezones->convertToUTC(
                '2017-08-14 13:00:00',
                'America/New_York'
            ),
            '2017-08-14 17:00:00'
        );

        $this->assertSame(
            $Timezones->convertToUTC(
                '2017-08-14 13:00:00',
                'America/New_York',
                'jS M Y g:ia'
            ),
            '14th Aug 2017 5:00pm'
        );
    }

    public function testConvertToUTCThrowsExceptionWhenNoTimezone()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$Timezone must be defined when $DateTime is not an instance of DateTime');

        $Timezones = new Timezones;
        $Timezones->convertToUTC('2017-08-14 13:00:00');
    }

    public function testConvertToUTCThrowsExceptionWhenInvalidTimezoneObjectGiven()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid DateTimeZone object could not be loaded');

        $Timezones = new Timezones;
        $Timezones->convertToUTC('2017-08-14 13:00:00', new \stdClass);
    }

    public function testConvertToUTCThrowsExceptionWhenInvalidTimezoneGiven()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('DateTimeZone::__construct(): Unknown or bad timezone (Foobar/Barfoo)');

        $Timezones = new Timezones;
        $Timezones->convertToUTC('2017-08-14 13:00:00', 'Foobar/Barfoo');
    }

    public function testConvertToLocalCanConvertCorrectly()
    {
        $Timezones = new Timezones;

        $this->assertSame(
            $Timezones->convertToLocal(
                '2017-08-14 13:00:00',
                'Europe/London'
            ),
            '2017-08-14 14:00:00'
        );

        $this->assertSame(
            $Timezones->convertToLocal(
                new \DateTime(
                    '2017-11-14 13:00:00',
                    new \DateTimeZone(
                        'UTC'
                    )
                ),
                new \DateTimeZone('Europe/London')
            ),
            '2017-11-14 13:00:00'
        );

        $this->assertSame(
            $Timezones->convertToLocal(
                '2017-08-14 13:00:00',
                'America/New_York'
            ),
            '2017-08-14 09:00:00'
        );

        $this->assertSame(
            $Timezones->convertToLocal(
                '2017-08-14 13:00:00',
                'America/New_York',
                'jS M Y g:ia'
            ),
            '14th Aug 2017 9:00am'
        );
    }

    public function testConvertToLocalThrowsExceptionWhenInvalidTimezoneObjectGiven()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid DateTimeZone object could not be loaded');

        $Timezones = new Timezones;
        $Timezones->convertToLocal('2017-08-14 13:00:00', new \stdClass);
    }

    public function testConvertToLocalThrowsExceptionWhenInvalidTimezoneGiven()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('DateTimeZone::__construct(): Unknown or bad timezone (Foobar/Barfoo)');

        $Timezones = new Timezones;
        $Timezones->convertToLocal('2017-08-14 13:00:00', 'Foobar/Barfoo');
    }
}
