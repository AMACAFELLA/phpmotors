<?php
//This is the vechicles controller

//Create or access a session
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vechicles-model.php';
require_once '../library/functions.php';
require_once '../model/uploads-model.php';

// Get the array of classifications
$classifications = getClassifications();

$navList = buildClassificationList($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'addClass':
        include '../view/add-class.php';
        break;

    case 'addVehicle':
        include '../view/add-vehicle.php';
        break;

    case 'addClass':
        // Filter and store the data
        $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Check for missing data
        if (empty($classificationName)) {
            $message = '<p class="paraBold">Please provide information for empty form field.</p>';
            include '../view/add-class.php';
            exit;
        }
        // Send the data to the model
        $classOutcome = addClass($classificationName);
        // Check and report the result
        if ($classOutcome === 1) {
            include '../view/vehicle-man.php';
            exit;
        } else {
            $message = "<p>Sorry, the car classification submission failed. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;

    case 'addVehicle':
        //Filter and store the vehicle data
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_FLOAT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
        // Check for missing data
        if (
            empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail)
            || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)
        ) {
            $message = '<p class="paraBold">Note all Fields are required</p>';
            include '../view/add-vehicle.php';
            exit;
        }
        // Send the data to the model
        $vechOutCome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
        // Check and report the result
        if ($vechOutCome === 1) {
            $message = "<p>The $invMake $invModel was added successfully</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p>Sorry, the vehicle submission failed. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;

        /* * **********************************
  * Get vehicles by classificationId
  * Used for starting Update & Delete process
  * ********************************** */
    case 'getInventoryItems':
        // Get the classificationId
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back
        echo json_encode($inventoryArray);
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p>Please complete all information for the update item! Double check the classification of the item.</p>';
            include '../view/vehicle-update.php';
            exit;
        }
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($updateResult) {
            $message = "<p>$invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>$invMake $invModel was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;

    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p>$invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Error: $invMake $invModel was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vehicles = getVehiclesByClassification($classificationName);
        if (!count($vehicles)) {
            $message = "<p>Sorry, no $classificationName could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        // Test the $vehicleDisplay
        //echo $vehicleDisplay;
        //exit;
        include '../view/classification.php';
        break;

    case 'vehicleDetails':
        $invId = filter_input(INPUT_GET, 'valueId', FILTER_SANITIZE_NUMBER_INT);
        $vehicleDetail = getInvItemInfo($invId);
        if (count($vehicleDetail) < 1) {
            $message = 'Sorry, no vehicle information could be found';
        } else {
            $displayDetails = displayVehicleDetails($vehicleDetail);
        }
        $thumbImg = getThumbnail($invId);
        $thumbnailsImg =  pathThumbnails($thumbImg);

        include '../view/vehicle-detail.php';
        break;

    default:
        $classificationList = buildClassificationList2($classifications);
        include '../view/vehicle-man.php';
        break;
}
