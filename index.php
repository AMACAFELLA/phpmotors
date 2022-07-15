<?php
//This is the main controller

//Create or access a session
session_start();

//Get the database connection file
require_once 'library/connections.php';
//Get the main model for use as needed
require_once 'model/main-model.php';
require_once 'library/functions.php';

//Get the array of classifications from DB using model
$classifications = getClassifications();

//var_dump($classifications);
//exit;

// Build a navigation bar using the $classifications array
$navList = buildClassificationList($classifications);
//echo $navList;
//exit;

//Check if the firstname cookie exists, get its value
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'template':
        include 'template/template.php';
        break;

    default:
        include 'view/home.php';
}
