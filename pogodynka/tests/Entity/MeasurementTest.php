<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use App\Entity\Location;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public function dataGetFarhenheit(): array
    {
        return [
            ['0', 32],
            ['10', 50],
            ['15', 59],
            ['20', 68],
            ['25', 77],
            ['30', 86],
            ['35', 95],
            ['40', 104],
            ['45', 113],
            ['50', 122],
            ['55', 131],
            ['60', 140],
            ['65', 149],
            ['70', 158],
            ['75', 167],
            ['80', 176],
            ['85', 185],
            ['90', 194],
            ['95', 203],
            ['100', 212],
        ];
    }

    /**
     * @dataProvider dataGetFarhenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCalsius($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit(), "Expected $expectedFahrenheit Fahrenheit for $celsius Celsius, got {$measurement->getFahrenheit()}");
    }
}
