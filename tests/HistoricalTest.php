<?php

namespace app;

include '../config/boot.php';
use PHPUnit\Framework\TestCase;

class HistoricalTest extends TestCase {

    private static $mySymbol = 'AMRN';

    /**
     * @test
     * @return json
     */
    public function getApiDataTest()
    {
        $symbol = 'GOOG';
        $historical = new Historical();
        $apiData = $historical->getApiData($symbol);
        print_r($apiData);
        $checkApi = !empty($apiData) ? true : false;
        self::assertTrue(true,$checkApi);
    }

    /**
     * @return void
     */
    public function getHistoricalDataTest ()
    {
        $symbol = 'GOOG';
        $date1 = '2022-07-01';
        $date2 = '2022-09-03';
        $historical = new Historical();
        $apiData = $historical->getApiData($symbol);
        print_r($historical->getHistoricalData($apiData, $date1, $date2));
    }

    /**
     * @test
     * @return void
     */
    public function getChartDataTest ()
    {
        $symbol = 'GOOG';
        $date1 = '2022-07-01';
        $date2 = '2022-09-03';
        $historical = new Historical();
        $apiData = $historical->getApiData($symbol);
        print_r($historical->getChartData($apiData, $date1, $date2));
    }

    /**
     * @test
     * @return void
     */
    public function getCompanyNameTest()
    {
        $symbol ='GOOG';
        $historical = new Historical();
        $name = $historical->getCompanyName(NASDAQ,$symbol);
        self::assertEquals('Google Inc.', $name);
    }

}