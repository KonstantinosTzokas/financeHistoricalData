# financeHistoricalData

This is my solution for the assigment

file structure

xm.exercise.localhost
|-- app
|	|-- Historical.php
|	|-- Validator.php
|-- config
|	|-- boot.php 
|   |-- nasdaq-listed_json.json 
|--public
|	|--ajax
|	|	|-- getFinanceData.php
|	|-- assets
|	|-- index.php
|-- tests
|	|-- HistoricalTest.php 
|   |-- ValidatorTest.php
|-- vendor
|-- .phpunit.result.cache
|-- composer.json
|-- composer.lock
|-- READMEN.MD

Use composer.json to install all the necessary additional libraries but also install the application
with all the correct routing from the autoload.php located inside the vendor folder

I used the xs.exercise.localhost address for the live testing and I run the application from XAMPP.

Although I was tempted to use laravel framework, but in the near future I will try to make a laravel version of it. yet not familiar completly I decided to implement the application with plain php and used the jQuery library (ajax calls etc.) for the javascript functionality.

In addition for some styling the application uses bootstrap ^5.0, dataTables library and Chart.js for the
creation of the chart bar.

For mail service swift mailer library was used and intended to be used with gmail account but the validation
rules changed by google, do not allow to create app password for testing the received mail. All the exception messages if the necessary data are provided (like username, password etc.) will appear on the hidden error message area.

I had a lot of fun creating this application as was a great challenge to see how my skills are progressed so far. And how to move on from now on.
