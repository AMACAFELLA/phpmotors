<?php
//This is the accounts controller

//Create or access a session
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../library/functions.php';
// Get the array of classifications
$classifications = getClassifications();

$navList = buildClassificationList($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'login':
        include '../view/login.php';
        break;

    case 'registration':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        //Check for existing email address
        $existingEmail = checkExisitingEmail($clientEmail);

        // Deal with existing email address during registration
        if ($existingEmail) {
            $message = '<p>The email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');

            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;

    case 'Login':
        // Filter and store the data
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid password exists, so attempt to login
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against the hashed password in the database
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // if the hashes don't match, create an error message
        // and return to the login view
        if (!$hashCheck) {
            $message = '<p>Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        //Remove the password from the array
        // the array_pop function removes the last
        // element of an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view
        include '../view/admin.php';
        exit;
        break;

    case 'logout':
        //If a "Logout" is received then the session data should be unset (hint, hint) and the session destroyed (hint, hint) and the client is returned to the main phpmotors controller.
        unset($_SESSION);
        session_destroy();
        header('Location: /phpmotors/');
        exit;
        break;

    case 'update':
        include '../view/client-update.php';
        break;

    case 'updateAccount':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientId =  trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        $clientEmail = checkEmail($clientEmail);

        //if the email is the not the same as the original email then check for existing email address
        if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
            $existingEmail = checkExisitingEmail($clientEmail);
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)) {
            $_SESSION['message'] = '<p>Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit;
        }

        // Send the data to the model
        $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
        if ($updateOutcome === 1) {
            unset($_SESSION['clientData']);
            $_SESSION['clientData'] = getClient($clientEmail);
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "$clientFirstname, your account has been successfully updated.";
            header('Location: /phpmotors/accounts/');
        } else {
            $_SESSION['message'] = "$clientFirstname, we were unable to update your account. Please try again.";
            include '../view/client-update.php';
            exit;
        }
        break;

    case 'updatePassword':
        // Filter and store the data
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($checkPassword)) {
            $_SESSION['passwordMessage'] = "Please provide information for all empty form fields.";
            include '../view/client-update.php';
            exit;
        }
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $updatePasswordOutcome = updatePassword($hashedPassword, $clientId);
        if ($updatePasswordOutcome === 1) {
            $_SESSION['message'] = "$clientFirstname, your password has been successfully updated.";
            header('Location: /phpmotors/accounts/');
            exit;
        } else {
            $_SESSION['passwordMessage'] = "Please make sure your password matches the desired pattern.";
            include '../view/client-update.php';
            exit;
        }
        break;


    default:
        include '../view/admin.php';
        break;
}
