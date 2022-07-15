<?php
//The search controller

session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vechicles-model.php';
require_once '../library/functions.php';
require_once '../model/search-model.php';
require_once '../model/uploads-model.php';

// Get the array of classifications
$classifications = getClassifications();

$navList = buildClassificationList($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'searchPage':
        include '../view/search.php';
        break;

    case 'search':
        $searchTerm = trim(filter_input(INPUT_POST, 'searchTerm', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (empty($searchTerm)) {
            $_SESSION['message'] = '<p class="paraBold">Please provide a search term.</p>';
            include '../view/search.php';
            exit;
        }
        //if illegal search term, redirect to search page
        if (preg_match('/[^a-zA-Z0-9]/', $searchTerm)) {
            $_SESSION['message'] = '<p class="paraBold">Please provide a valid search term.</p>';
            include '../view/search.php';
            exit;
        }

        $currentPage = 0;
        $searchResults = searchInventory($searchTerm);
        $countSearch = count($searchResults);
        $tenViewer = view10($searchResults);
        $searchDisplay = viewSearchResults($tenViewer[$currentPage]);
        $pagi = pagination($searchTerm, $tenViewer,$currentPage);
        include '../view/search.php';
        break;
    
   case 'next';
        $currentPage = filter_input(INPUT_POST, 'page');
        if ($currentPage == NULL) {
            $currentPage = filter_input(INPUT_GET, 'page');
        }

        $searchTerm = filter_input(INPUT_POST, 'searchQuery');
        if ($searchTerm == NULL) {
            $searchTerm = filter_input(INPUT_GET, 'searchQuery');
        }

        $searchResults = searchInventory($searchTerm);
        $countSearch = count($searchResults);
        $tenViewer = view10($searchResults);

        $searchDisplay = viewSearchResults($tenViewer[$currentPage]);

        $pagi = pagination($searchTerm, $tenViewer, $currentPage);
        include '../view/search.php';
        break;

    case 'prev';
        $currentPage = filter_input(INPUT_POST, 'page');
        if ($currentPage == NULL) {
            $currentPage = filter_input(INPUT_GET, 'page');
        }

        $searchTerm = filter_input(INPUT_POST, 'searchQuery');
        if ($searchTerm == NULL) {
            $searchTerm = filter_input(INPUT_GET, 'searchQuery');
        }

        $searchResults = searchInventory($searchTerm);
        $countSearch = count($searchResults);
        $tenViewer = view10($searchResults);

        $searchDisplay = viewSearchResults($tenViewer[$currentPage]);

        $pagi = pagination($searchTerm, $tenViewer, $currentPage);

        include '../view/search.php';
        break;

    default:
        include '../view/search.php';
}
