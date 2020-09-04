<?php

namespace Mbarlow\Timezones\Tests;

use MBarlow\Timezones\Timezones;
use PHPUnit\Framework\TestCase;

class TimezonesTests extends TestCase
{
    /**
     * @test
     */
    public function can_convertToUTC_convert_correctly()
    {
        $timezones = new Timezones;

        $this->assertSame(
            $timezones->convertToUTC(
                '2017-08-14 13:00:00',
                'Europe/London'
            ),
            '2017-08-14 12:00:00'
        );

        $this->assertSame(
            $timezones->convertToUTC(
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
            $timezones->convertToUTC(
                '2017-08-14 13:00:00',
                'America/New_York'
            ),
            '2017-08-14 17:00:00'
        );

        $this->assertSame(
            $timezones->convertToUTC(
                '2017-08-14 13:00:00',
                'America/New_York',
                'jS M Y g:ia'
            ),
            '14th Aug 2017 5:00pm'
        );
    }

    /**
     * @test
     */
    public function convertToUTC_throws_exception_when_no_timezone()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$Timezone must be defined when $DateTime is not an instance of DateTime');

        $timezones = new Timezones;
        $timezones->convertToUTC('2017-08-14 13:00:00');
    }

    /**
     * @test
     */
    public function convertToUTC_throws_exception_when_invalid_timezone_object()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid DateTimeZone object could not be loaded');

        $timezones = new Timezones;
        $timezones->convertToUTC('2017-08-14 13:00:00', new \stdClass);
    }

    /**
     * @test
     */
    public function convertToUTC_throws_exception_when_invalid_timezone_string()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('DateTimeZone::__construct(): Unknown or bad timezone (Foobar/Barfoo)');

        $timezones = new Timezones;
        $timezones->convertToUTC('2017-08-14 13:00:00', 'Foobar/Barfoo');
    }

    /**
     * @test
     */
    public function convertToLocal_can_convert_correctly()
    {
        $timezones = new Timezones;

        $this->assertSame(
            $timezones->convertToLocal(
                '2017-08-14 13:00:00',
                'Europe/London'
            ),
            '2017-08-14 14:00:00'
        );

        $this->assertSame(
            $timezones->convertToLocal(
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
            $timezones->convertToLocal(
                '2017-08-14 13:00:00',
                'America/New_York'
            ),
            '2017-08-14 09:00:00'
        );

        $this->assertSame(
            $timezones->convertToLocal(
                '2017-08-14 13:00:00',
                'America/New_York',
                'jS M Y g:ia'
            ),
            '14th Aug 2017 9:00am'
        );
    }

    /**
     * @test
     */
    public function convertToLocal_throws_exception_when_invalid_timezone_object()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid DateTimeZone object could not be loaded');

        $timezones = new Timezones;
        $timezones->convertToLocal('2017-08-14 13:00:00', new \stdClass);
    }

    /**
     * @test
     */
    public function convertToLocal_throws_exception_when_invalid_timezone_string()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('DateTimeZone::__construct(): Unknown or bad timezone (Foobar/Barfoo)');

        $timezones = new Timezones;
        $timezones->convertToLocal('2017-08-14 13:00:00', 'Foobar/Barfoo');
    }

    /**
     * @test
     */
    public function can_return_timezone_list_as_ordered_array()
    {
        $timezones = new Timezones;
        $list = $timezones->timezoneList('2020-09-04 09:00:00');

        $this->assertCount(426, $list);

        $keys = array_keys($list);
        $values = array_values($list);

        $this->assertSame(
            'Pacific/Midway',
            $keys[0]
        );

        $this->assertSame(
            'Pacific/Kiritimati',
            end($keys)
        );

        $this->assertSame(
            'Pacific/Midway',
            $keys[0]
        );

        $this->assertSame(
            '(UTC -11:00) Midway',
            $values['0']
        );

        $this->assertSame(
            '(UTC +14:00) Kiritimati',
            end($values)
        );
    }
}
