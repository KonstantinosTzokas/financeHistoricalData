<?php

namespace app;

use PHPUnit\Util\Json;

/**
 *
 */
class Historical{

    /**
     * @var string
     */
    private static string $myApiKey = 'YOUR API KEY HERE';

    /**
     * @var string
     */
    private static string $myApiHost = 'yh-finance.p.rapidapi.com';

    /**
     * @var string
     */
    private static string $myUrl = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';

    // Get Data from API

    /**
     * @param string $mySymbol
     * @param string $myRegion
     *
     * @return object
     */
    public function getApiData(string $mySymbol, string $myRegion = '')
    {
        $myUrl = self::$myUrl;
        $myApiKey = self::$myApiKey;
        $myApiHost = self::$myApiHost;

        $apiUrl = $myUrl . '?symbol=' . $mySymbol;

        if (!empty($myRegion)) {
            $apiUrl .= '&region=' . $myRegion;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-RapidAPI-Key: ' . $myApiKey,
                'X-RapidAPI-Host: ' . $myApiHost,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $myData = json_decode($response, true);

        return $myData['prices'];
    }

    // Get Table Data

    /**
     * @param string $mySymbol
     *
     * @return string
     */
    public function getHistoricalData($myData, $date1, $date2)
    {
        $myHtml = '';
        $startStamp = strtotime($date1);
        $endStamp = strtotime($date2);

        if (!empty($myData)) {
            foreach ($myData as $values) {

                // reference array
                $refArray = array(
                    'date' => '',
                    'open' => '',
                    'high' => '',
                    'low' => '',
                    'close' => '',
                    'volume' => '',
                    'adjclose' => '',
                );
                // check if array has expected reference;
                $check = empty(array_diff_key($refArray, $values)) ? true : false;
                // if array the same then get values
                if($check) {
                    if ($values['date'] >= $startStamp && $values['date'] <= $endStamp) {
                        $myDate = date('Y-m-d', $values['date']);
                        $open = !empty($values['open']) ? $values['open'] : '--';
                        $high = !empty($values['high']) ? $values['high'] : '--';
                        $low = !empty($values['low']) ? $values['low'] : '--';
                        $close = !empty($values['close']) ? $values['close'] : '--';
                        $volume = !empty($values['volume']) ? $values['volume'] : '--';
                        $myHtml .= '<tr>
                    <td>' . $myDate . '</td>
                    <td>' . $open . '</td>
                    <td>' . $high . '</td>
                    <td>' . $low . '</td>
                    <td>' . $close . '</td>
                    <td>' . $volume . '</td>
                  </tr>';
                    }
                }
            }
        }
        return $myHtml;
    }


    public function getChartData ($myData, $date1, $date2) {
        $myObject = '';
        $startStamp = strtotime($date1);
        $endStamp = strtotime($date2);
        if(!empty($myData)) {
            $labels = [];
            $openPrices = [];
            $closePrices = [];

            foreach ($myData as $values) {

                // reference array
                $refArray = array(
                    'date' => '',
                    'open' => '',
                    'high' => '',
                    'low' => '',
                    'close' => '',
                    'volume' => '',
                    'adjclose' => '',
                );
                // check if array has expected reference;
                $check = empty(array_diff_key($refArray, $values)) ? true : false;
                if ($check) {
                    if ($values['date'] >= $startStamp && $values['date'] <= $endStamp) {
                        $timestamp = $values['date'];
                        $date = date('Y-m-d', $timestamp);
                        array_push($labels, $date);
                        array_push($openPrices, $values['open']);
                        array_push($closePrices, $values['close']);
                    }
                }
            }

            $myObject = array(
                'dateLabels' => array_reverse($labels),
                'openPrices' => array_reverse($openPrices),
                'closePrices' => array_reverse($closePrices)
            );
        }
        return json_encode($myObject, true);
    }

    /**
     * @param json $json
     * @param string $symbol
     * @return mixed|string
     */
    public function getCompanyName ($json, $symbol) {
        foreach ($json as $value) {
            if ($symbol == $value['Symbol']) {
                return $value['Company Name'];
            }
        }
        return '';
    }
}
