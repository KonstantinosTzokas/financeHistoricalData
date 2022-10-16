<?php

require_once('../../vendor/autoload.php');

// include NASDAQ json file list
include '../../config/boot.php';

use app\Historical;
use app\Validator;

$historical = new Historical();
$validator = new Validator();

// get values
$mySymbol = $_REQUEST['compSymbol'];
$startDate = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];
$email = $_REQUEST['myEmail'];
$status = $errorMessage = $tableData = '';
$endDateFlag = $startDateFlag = '';

// filter variable
$mySymbol = $validator->checkInputs($mySymbol);
$startDate = $validator->checkInputs($startDate);
$endDate = $validator->checkInputs($endDate);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// validate inputs
$flag1 = $validator->validateSymbol($mySymbol);
$flag2 = $validator->validateDate($startDate);
$flag3 = $validator->validateDate($endDate);
$flag4 = $validator->validateEmail($email);
// compare dates
$flag5 = $validator->compareDates($endDate, $startDate);
$startDateFlag = $flag2 && $flag5;
$endDateFlag = $flag3 && $flag5;

// validation status;
$status = $flag1 && $flag2 && $flag3 && $flag4 && $flag5;

// get data from API
$apiData = $historical->getApiData($mySymbol);

// get table data
$tableData = $historical->getHistoricalData($apiData, $startDate, $endDate);

// get chart data
$chartData = json_encode($historical->getChartData($apiData, $startDate, $endDate), true);

// Error messages
$errorMessage = !$flag1 ? '<p>Company Symbol is invalid! Please pick a valid Company Symbol!</p>' : '';
$errorMessage .= !$flag2 ? '<p>Start Date is invalid! Please pick a valid date! Pick a date less or equal than current date!</p>' : '';
$errorMessage .= !$flag3 ? '<p>End Date is invalid! Please pick a valid date! Pick a date less or equal than current date!</p>' : '';
$errorMessage .= !$flag5 ? '<p>Invalid current dates! Start Date must be less or equal to End Date </p>' : '';
$errorMessage .= !$flag4 ? '<p>Email is invalid! Please type a valid email address!</p>' : '';

$mailStatus = true; // commented it out if the swiftmailer functions below are to be used!.

// Uncomment sections from smtp to check for results

// Send email
if($status) {
    $mailSubject = $historical->getCompanyName(NASDAQ, $mySymbol);
    $mailBody = 'From ' . $startDate . ' to ' . $endDate;

    /* I have commented out the swift mailer commands to avoid display exception error that occurs
     * due to google gmail authentication error. The app password creation is now deprecated fill in the necessary
     * details even if used different smtp along with credential (located in config->boot.php global variables
     * and sending a mail via gmail.smtp is hard to pass the current authentication. */

//    // try - catch swift mailer exception
//    try {
//         Create transport GMAIL - SMTP
//        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
//            ->setUsername(EMAIL_USERNAME)
//            ->setPassword(EMAIL_PASSWORD);
//
//        // Create mailer using the transport
//        $mailer = new Swift_Mailer($transport);
//
//        // Create message
//        $message = (new Swift_Message($mailSubject))
//            ->setFrom(['sender email address' => 'sender name or text'])
//            ->setTo($email)
//            ->setBody($mailBody);
//
//        // Send mail - google
//
//        //comment out to hide the exception error
//        $mailer->send($message);
//        $mailStatus = true;
//
//    } catch (Swift_TransportException $exception) {
//        $mailStatus = false;
//        $errorMessage .= 'failed to send mail' . $exception->getMessage();
//    } catch (Swift_RfcComplianceException $ex) {
//        $mailStatus = false; // comment out to avoid displaying status
//        $errorMessage .= 'failed to send mail' . $ex->getMessage();
//    }

}

?>

<div class="row">
    <div class="inner-container">
        <div class="alert alert-danger" id="myError" role="alert"
             style="visibility:<?php echo (!$status || !$mailStatus) ? 'visible' : 'hidden'; ?>"><?= $errorMessage ?></div>
        <div id="form-container">
            <form id="myForm" method="post">
                <div class="form-group">
                    <label for="compSymbol">Company Symbol</label>
                    <select class="form-select <?php echo !$flag1 ? 'inputError' : '' ?>" type="text" name="compSymbol" id="compSymbol">
                        <option value="0">-Eπιλέξτε-</option>
                        <?php foreach (NASDAQ as $item) { ?>
                            <option value="<?= $item['Symbol'] ?>"
                                <?php echo ($item['Symbol'] == $mySymbol) ? 'selected' : ''; ?> ><?= $item['Symbol'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">Company Symbol is required!</div>
                </div>
                <div class="form-group myFormSpace">
                    <label for="startDate">Start Date</label>
                    <input class="form-control <?php echo !$startDateFlag ? 'inputError' : '' ?>"
                           type="text" name="startDate" id="startDate" value="<?= $startDate ?>" readonly>
                    <div class="invalid-feedback">Start Date is required!</div>
                </div>
                <div class="form-group myFormSpace">
                    <label for="endDate">End Date</label>
                    <input class="form-control <?php echo !$endDateFlag ? 'inputError' : '' ?>"
                           type="text" name="endDate" id="endDate" value="<?= $endDate ?>" readonly>
                    <div class="invalid-feedback">End Date is required!</div>
                </div>
                <script>
                    $(function () {
                        $("#startDate").datepicker({
                            maxDate: '0',
                            dateFormat: "yy-mm-dd"
                        });

                        $("#endDate").datepicker({
                            maxDate: '0',
                            dateFormat: "yy-mm-dd"
                        });
                    });
                </script>
                <div class="form-group myFormSpace">
                    <label for="myEmail">Email</label>
                    <input class="form-control <?php echo !$flag4 ? 'inputError' : '' ?>"
                           type="email" name="myEmail" id="myEmail" value="<?= $email ?>">
                    <div class="invalid-feedback">Email address is required!</div>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-success" id="mySubmit">Submit</button>
                </div>
            </form>
        </div>
        <div id="chart-container">
            <canvas id="myChart" style="width:100%;"></canvas>
            <script>
                var chartData = JSON.parse(<?= $chartData ?>);

                var data = {
                    labels: chartData.dateLabels,
                    datasets: [{
                        label: 'Open Prices',
                        data: chartData.openPrices,
                        backgroundColor: '#80c8bb',
                        order: 1,
                        stack: 'stack0'
                    },
                        {
                            label: 'Close Prices',
                            data: chartData.closePrices,
                            backgroundColor: 'rgb(241,151,151)',
                            order: 2,
                            stack: 'stack1'
                        }
                    ]
                };

                var config = {
                    type: 'bar',
                    data: data,
                    options: {
                        title: {
                            display: true,
                            position: 'top',
                            align: 'center',
                            fontSize: '25',
                            fontColor: '#000000',
                            text: 'Open and Close Values Chart'
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index'
                            }
                        },
                        scales: {
                            x: {
                                stacked: true
                            },
                            y: {
                                stacked: true
                            }
                        }
                    },
                };

                var reportOutput = new Chart(
                    $('#myChart'),
                    config
                );
            </script>
        </div>
    </div>
</div>
<div class="row">
    <div class="inner-container" id="table-container">
        <table id="dataTable" class="table table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>Volume</th>
            </tr>
            </thead>
            <tbody><?= $tableData ?></tbody>
            <tfooter>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfooter>
        </table>
        <script>
            $(document).ready( function () {
                $('#dataTable').DataTable({
                    order: [[0, 'desc']],
                });
            });
        </script>
    </div>
</div>
