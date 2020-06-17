<?php
//this is the reviews controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the reviews model
require_once '../model/reviews-model.php';
//get vehicle model
require_once '../model/vehicles-model.php';

// Create or access a Session
session_start();

// Get the array of classifications
$classifications = getClassifications();

//var_dump($classifications);
//	exit;

// Build a navigation bar using the $classifications array
//$navList = '<ul>';
//$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
//foreach ($classifications as $classification) {
// $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
//}
//$navList .= '</ul>';
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}
switch ($action){
    case 'add':
       
       //filter and store data
       $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
       $invId =  filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
       $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    
    if(empty($reviewText)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        $_SESSION['message'] = $message;
        header('location: /phpmotors/vehicles/?action=vehiclePage&invId='.$invId);
        exit;
    }

    $result = addReview($reviewText,$invId,$clientId);
          //echo $carOutcome;
          //verify success or failure
          if($result === 1){
                  $message = "<p>Review Uploaded!</p>";
                  $_SESSION['message'] = $message;
                  header('location: /phpmotors/accounts/');
                  exit;
              } else {
                  $message = "<p>Sorry, Something went wrong. Please try again.</p>";
                  $_SESSION['message'] = $message;
                  header('location: /phpmotors/vehicles/?action=vehiclePage&invId='.$invId);
                  exit;
              }


    break;
    case 'edit':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['reviewId'] = $reviewId;
        $review = reviewByReviewId($reviewId);
        $client = getCliInfo($review['clientId']);
        $review['screenName'] = substr($client['clientFirstname'],0,1).$client['clientLastname'];
        $reviewDisplay = buildReviewEditDisplay($review);
        include '../view/edit-review.php';
    break;
    case 'update':
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $reviewId = $_SESSION['reviewId'];
        echo $reviewText;
        

        if(empty($reviewText)){
            $error = "Review can't be blank. Please enter information!";
            
            $review = reviewByReviewId($reviewId);
            $client = getCliInfo($review['clientId']);
            $review['screenName'] = substr($client['clientFirstname'],0,1).$client['clientLastname'];
            $reviewDisplay = buildReviewEditDisplay($review);
            
            include '../view/edit-review.php';
            exit;
        }

        $upOutcome = updateReview($reviewText, $reviewId);

        if($upOutcome === 1){
            $message = "<p>Review updated successfully!</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p>Sorry, updating the review failed. Please try again.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/');
            exit;
        }





    break;
    case 'confirmDelete':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['reviewId'] = $reviewId;
        $review = reviewByReviewId($reviewId);
        $car = getVehicleById($review['invId']);
        $client = getCliInfo($review['clientId']);
        $review['screenName'] = substr($client['clientFirstname'],0,1).$client['clientLastname'];
        $review['car'] = $car[0]['invModel'];
        $reviewDisplay = buildExistingReviewDisplay($review);
        include '../view/delete-review.php';
    break;
    case 'delete':
        $reviewId = $_SESSION['reviewId'];

        $deleteOutcome = deleteReview($reviewId);
        if($deleteOutcome === 1){
            $message = "<p>Review deleted successfully!</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/accounts/');
            exit;
        } else {
          $message = "<p>Review was not deleted!</p>";
          $_SESSION['message'] = $message;
          header('location: /phpmotors/accounts/');
          exit;
        }


    break;
    default: 
    break;


}








?>