<?php

namespace app;

class Validator {

    /**
     * @param string $inputData
     * @return string
     */
    public function checkInputs($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }

    /**
     * @param $date
     * @return bool
     */
    public function validateDate($date)
    {
        $date1 = strtotime(date('Y-m-d', time()));
        $testDate = explode('-', $date);
        if (count($testDate) == 3) {
            if (checkdate($testDate[1], $testDate[2], $testDate[0])) {
                if ($date1 >= strtotime($date)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $date1
     * @param $date2
     * @return bool
     */
    public function compareDates($date1, $date2) {
        if(strtotime($date1) >= strtotime($date2)) {
            return true;
        }
        if (strtotime($date1) < strtotime($date2)) {
            return false;
        }
        return false;
    }

    /**
     * @param string $symbol
     * @return boolean
     */
    public function validateSymbol($symbol)
    {
        if (gettype($symbol) != 'string') {
            return false;
        }
        if(strlen($symbol) < 2) {
            return false;
        }
        if(!preg_match('/^[A-Z]+$/', $symbol)){
            return false;
        }
        return true;
    }

    public function validateEmail($email)
    {
        if ($email = filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}