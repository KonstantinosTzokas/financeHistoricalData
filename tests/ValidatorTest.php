<?php

namespace app;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function validateDateTest()
    {
        $date = '2022-09-12';
        $validator = new Validator();
        $this->assertEquals(true, $validator->validateDate($date));

    }

    /**
     * @test
     * @return void
     */
    public function validateSymbolTest()
    {
        $symbol = 'ABCD';
        $validator = new Validator();
        $this->assertEquals(true, $validator->validateSymbol($symbol));
    }

    /**
     * @test
     * @return void
     */
    public function compareDatesTest()
    {
        $date1 = '2022-09-11';
        $date2 = '2022-11-21';
        $validator = new Validator();
        $this->assertEquals(true, $validator->compareDates($date2, $date1));
    }

    /**
     * @test
     * @return void
     */
    public function validateEmailTest()
    {
        $email = 'test@email.com';
        $validator = new Validator();
        $this->assertEquals(true, $validator->validateEmail($email));
    }
}