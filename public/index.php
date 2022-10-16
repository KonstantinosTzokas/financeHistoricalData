<?php

// include NASDAQ json file list
include '../config/boot.php';

?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>XM PHP Exercise - v21.03</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- dataTables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
</head>
<body>
<div class="header">
    <div class="logoContainer">
        <img id="myLogo" src="assets/images/XMLogo-2021_homepage.svg">
    </div>
    <div class="textContainer">
        <p id="myText">PHP Exercise - v21.0.3</p>
    </div>
</div>
<div class="main" id="myContainer">
    <div class="row">
        <div class="inner-container">
            <div class="alert alert-danger" id="myError" role="alert" style="visibility: hidden"></div>
            <div id="form-container">
                <form id="myForm" method="post">
                    <div class="form-group">
                        <label for="compSymbol">Company Symbol</label>
                        <select class="form-select" type="text" name="compSymbol" id="compSymbol">
                            <option value="0">-Eπιλέξτε-</option>
                            <?php foreach (NASDAQ as $item) { ?>
                                <option value="<?= $item['Symbol'] ?>"><?= $item['Symbol'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Company Symbol is required!</div>
                    </div>
                    <div class="form-group myFormSpace">
                        <label for="startDate">Start Date</label>
                        <input class="form-control" type="text" name="startDate" id="startDate"
                               value="<?= date('Y-m-d', time()); ?>" readonly>
                        <div class="invalid-feedback">Start Date is required!</div>
                    </div>
                    <div class="form-group myFormSpace">
                        <label for="endDate">End Date</label>
                        <input class="form-control" type="text" name="endDate" id="endDate"
                               value="<?= date('Y-m-d', time()); ?>" readonly>
                        <div class="invalid-feedback">End Date is required!</div>
                    </div>
                    <div class="form-group myFormSpace">
                        <label for="myEmail">Email</label>
                        <input class="form-control" type="text" name="myEmail" id="myEmail">
                        <div class="invalid-feedback">Email address is required!</div>
                    </div>
                    <div class="btn-container">
                        <button type="submit" class="btn btn-success" id="mySubmit">Submit</button>
                    </div>
                </form>
            </div>
            <div id="chart-container">
                <div class="alert alert-primary myInfoMsg" role="alert">
                    <p>Please select a <strong>Company Symbol</strong>, a <strong>Start Date</strong>,
                        an <strong>End Date</strong> and type a valid <strong>email</strong> address!</p>
                    <p><strong>Start Date</strong> and <strong>End Date</strong> maximum value is the current date (Today).</p>
                    <p>The <strong>End Date</strong> cannot be greater than <strong>start date</strong>.</p>
                    <p>All form fields are required in order to get results!</p>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="inner-container" id="table-container"></div>
    </div>
</div>
<div class="footer">
</div>

<!-- jQuery 3.6.0  -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<!-- Boostrap 5 JS -->
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
<!-- dataTables JS -->
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- Application Javascript -->
<script src="assets/js/app.js"></script>
<!-- Initialize datepickers -->
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
</body>
</html>