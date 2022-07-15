<?php
function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}


// The new function should 1) receive the $carclassifications array as a parameter and 2) build the navigation list HTML around the values found in the $carclassifications array. When done, it should return a string variable holding the HTML navigation list to wherever called the function. Be sure to add a comment to the function indicating what it does.
function buildClassificationList($carclassifications)
{
    // Start the list
    $navList = '<ul class=mainNav>';
    // Create the list
    $navList .= "<li class=classList><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    // Display each classification
    foreach ($carclassifications as $classification) {
        // Add each classification to the navigation list
        $navList .= "<li class=classList><a href='/phpmotors/vehicles/?action=classification&classificationName=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

// Build the classifications select list
function buildClassificationList2($classifications)
{
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}

function buildVehiclesDisplay($vehicles)
{
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
        $vehiclePrice = '$' . number_format($vehicle['invPrice'], 2);
        $dv .= '<li>';
        $dv .= "<a href='/phpmotors/vehicles/?action=vehicleDetails&valueId=$vehicle[invId]'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
        $dv .= '<hr>';
        $dv .= "<h2><a href='/phpmotors/vehicles/?action=vehicleDetails&valueId=$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        $dv .= "<span>$vehiclePrice</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function displayVehicleDetails($vehicleDetail)
{
    $div = "<section class='vehicleDetails'>";
    $div .= "<div class='vehicleImg'>
               <img src='$vehicleDetail[invThumbnail]' alt='Image of $vehicleDetail[invMake] $vehicleDetail[invModel] on phpmotors.com'>
               </div>
               <div class='details'>
                   <h2>$vehicleDetail[invMake] $vehicleDetail[invModel] Details</h2>
                   <p>$vehicleDetail[invDescription]</p>
                   <p>Color: $vehicleDetail[invColor]</p>
                   <p># in Stock: $vehicleDetail[invStock]</p>
               </div>
           </section>";
    return $div;
}
/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image)
{
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
 $id = '<ul id="image-display">';
 foreach ($imageArray as $image) {
  $id .= '<li>';
  $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
  $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
  $id .= '</li>';
}
 $id .= '</ul>';
 return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles)
{
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
        $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name)
{
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename)
{
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir . makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{

    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the swith

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
} // ends resizeImage function

function pathThumbnails($tns)
{
    $thumbnails = "<div class='thunbnailsImg'>";
    foreach ($tns as $tn) {
        $thumbnails .= '<img src="' . $tn['imgPath'] . '" alt="' . $tn['imgName'] . '"> ';
    }
    $thumbnails .= "</div>";
    return $thumbnails;
}
//function to show search results
function viewSearchResults($search){
    $display = "<div class='searchDisplay'>";
    foreach ($search as $vehicle) {
        $display .= "<div class='searchDisplayItem'>";
        $display .= "<h2><a href='/phpmotors/vehicles/?action=vehicleDetails&valueId=$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        $display .= '<p>' . $vehicle['invDescription'] . '</p>';
        $display .= '<img src="' . $vehicle['imgPath'] . '" alt="' . $vehicle['invModel'] . '">';
        $display .= "</div>";
    }
    return $display;
}

//function to index the viewSearchResults function and display only 10 results at a time
function view10($searchResults)
{
    //array to store the 10 results
    $tenViewer = array();
    $i = 0;
    $o = 0;
    //loop through the search results and add them to the array
    foreach ($searchResults as $search) {
        $tenViewer[$i][$o] = $search;
        $o++;
        //if the array is full, reset the array and increment the counter
        if($o == 10){
            $o = 0;
            $i++;
        }
        if($i > 9){
            break;
        }
    }
    //return the array
    return $tenViewer;
}

function pagination($searchTerm, $tenViewer, $currentPage)
{
    // Pagination for the search results
    if (isset($tenViewer[$currentPage - 1])) {
        $previousLink = '<a href="/phpmotors/search/index.php?action=prev&page=' . ($currentPage - 1) . '&searchQuery=' . $searchTerm . '">'.'<<<' . '</a>';
        $previousLink .= '<a href="/phpmotors/search/index.php?action=prev&page=' . ($currentPage - 1) . '&searchQuery=' . $searchTerm . '"> ' . ($currentPage) . ' </a>';

    } else {
        //don't show a link to the previous page
        $prev = '';
    }
    if (isset($tenViewer[$currentPage + 1])) {
        $next = '<a href="/phpmotors/search/index.php?action=next&page=' . ($currentPage + 1) . '&searchQuery=' . $searchTerm . '"> ' . ($currentPage + 2) . ' </a>';
        $next .= '<a href="/phpmotors/search/index.php?action=next&page=' . ($currentPage + 1) . '&searchQuery=' . $searchTerm . '">' . '>>>' . '</a>';
    } else {
        //don't show a link to the next page
        $next = '';
    }
    $paginationLinks = '<div class="pagination">' . $previousLink . ($currentPage + 1) . $next . '</div>';
    //show pagination if there is more than one page of results
    if (count($tenViewer) > 1) {
        return $paginationLinks;
    } else {
        //don't show pagination if there is only one page of results
        return '';
    }
}