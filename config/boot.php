<?php

// Get Correct Path
$filePath = __DIR__;
$filePath = str_replace("\\", "/", $filePath);

// Get Correct JSON file path
$filePath .= '/../config/nasdaq-listed_json.json';

// Get FILE JSON contents
$fileContents = file_get_contents($filePath);

// Json File contents
define('NASDAQ', json_decode($fileContents, true));


// Gmail account username
define('EMAIL_USERNAME', 'email username'); // Type the email account username for sending emails
// Gmail account password
define('EMAIL_PASSWORD', 'email password'); // Type the email account password for sending emails
