<?php

//Accounts Controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
//get reviews model
require_once '../model/reviews-model.php';
//get vehicle model
require_once '../model/vehicles-model.php';
// Get the functions library
require_once '../library/functions.php';
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

//echo $navList;
//exit;




$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}
switch ($action){
  case 'login':
    include "../view/login.php";
    break;
  case 'registration':
    include "../view/registration.php";
    break; 
  case 'executeLogin':
    // Filter and store data
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
    //Send data to functions to be checked
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);
    //Check for missing data
    if(empty($clientEmail) || empty($checkPassword)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/login.php';
      exit; 
    }
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against
    // the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if(!$hashCheck) {
      $message = '<p class="notice">Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
    }
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;

    //set variables to display in view
    $sessionFirstname = $_SESSION['clientData']['clientFirstname'];
    $sessionLastname = $_SESSION['clientData']['clientLastname'];
    $sessionEmail = $_SESSION['clientData']['clientEmail'];
    $sessionLevel = $_SESSION['clientData']['clientLevel'];
    $clientId = $_SESSION['clientData']['clientId'];

    //set welcome session message
    $_SESSION['welcome'] = "$sessionFirstname";

    //delete cookie on login
    
    setcookie('firstname', '', time() - 3600 , '/'); 

    //get reviews
    $reviewsById = reviewByClientId($clientId);
    $reviewString = '';
    
    if(!empty($reviewsById)){
      foreach($reviewsById as $review){
        $car = getVehicleById($review['invId']);
        $client = getCliInfo($review['clientId']);
        $review['car'] = $car[0]['invModel'];
        $review['screenName'] = substr($client['clientFirstname'],0,1).$client['clientLastname'];
        $reviewString.= buildExistingReviewDisplay($review);
        $reviewString.= '<h3><a href="../reviews/index.php?action=edit&reviewId=';
        $reviewString.= $review['reviewId'];
        $reviewString.= '">EDIT</a></h3>';
        $reviewString.= '<h3><a href="../reviews/index.php?action=confirmDelete&reviewId=';
        $reviewString.= $review['reviewId'];
        $reviewString.= '">DELETE</a></h3>';
      }
    }

    
    

    // Send them to the admin view
    include '../view/admin.php';
    exit;
    break;
  case 'register':
    // Filter and store the data
    $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
    $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
    //send data to functions to be checked
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);
    $existingEmail = checkExistingEmail($clientEmail);

    // Check for existing email address in the table
    if($existingEmail){
        $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
        include '../view/login.php';
        exit;
    }
    // Check for missing data
    if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit; 
    }
    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    // Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    // Check and report the result
    if($regOutcome === 1){
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
  case 'logout':
    //unset session variables.
    $_SESSION = array();
    session_destroy();
    header('Location: /phpmotors');
  case 'update':
     //session variables
     $sessionFirstname = $_SESSION['clientData']['clientFirstname'];
     $sessionLastname = $_SESSION['clientData']['clientLastname'];
     $sessionEmail = $_SESSION['clientData']['clientEmail'];
     $clientId = $_SESSION['clientData']['clientId'];
     
    include "../view/client-update.php";
    break; 
  case 'updateInformation':
    $sessionEmail = $_SESSION['clientData']['clientEmail'];

    // Filter and store the data
    $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
    $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    //send data to functions to be checked
    $clientEmail = checkEmail($clientEmail);
    //$clientEmail = checkEmail($clientEmail);

    $existingEmail = null; 

    if ($sessionEmail !== $clientEmail){
    $existingEmail = checkExistingEmail($clientEmail);
    }

    // Check for existing email address in the table
    if($existingEmail){
        $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
        include '../view/login.php';
        exit;
    }
    // Check for missing data
    if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/client-update.php';
      exit; 
    }
    
    // Send the data to the model
    $upOutcome = upClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    //$clientData = getClient($clientEmail);
      $clientData = getCliInfo($clientId);

    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Check and report the result
    if($upOutcome === 1){
      $message = "<p>Thanks for Updating.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/accounts/');
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the update failed. Please try again.</p>";
      $_SESSION['message'] = $message;
      header('Location: /phpmotors/accounts/');
      exit;
    }
  case 'updatePassword':
    //get password
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    //check password
    $checkPassword = checkPassword($clientPassword);
    //error if invalid
    if(empty($checkPassword)){
      $messagePass = '<p>ERROR: Invalid password. Please try again!</p>';
      include '../view/client-update.php';
      exit; 
    }
    
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    
    $upOutcomepass = upClientpass($hashedPassword, $clientId);
    // Check and report the result
    
     if($upOutcomepass === 1){
       $_SESSION['message'] = "SUCCESS: new password set";
       header('Location: /phpmotors/accounts/');
       exit;
     } else {
       $_SESSION['message'] = "ERROR: new password not set";
       header('Location: /phpmotors/accounts/');
       exit;
     }
  
    break;

  default:
    $sessionFirstname = $_SESSION['clientData']['clientFirstname'];
    $sessionLastname = $_SESSION['clientData']['clientLastname'];
    $sessionEmail = $_SESSION['clientData']['clientEmail'];
    $sessionLevel = $_SESSION['clientData']['clientLevel'];  

    $clientId = $_SESSION['clientData']['clientId'];
    $reviewsById = reviewByClientId($clientId);
    $reviewString = '';
    
    if(!empty($reviewsById)){
      foreach($reviewsById as $review){
        $car = getVehicleById($review['invId']);
        $client = getCliInfo($review['clientId']);
        $review['car'] = $car[0]['invModel'];
        $review['screenName'] = substr($client['clientFirstname'],0,1).$client['clientLastname'];
        $reviewString.= buildExistingReviewDisplay($review);
        $reviewString.= '<h3><a href="../reviews/index.php?action=edit&reviewId=';
        $reviewString.= $review['reviewId'];
        $reviewString.= '">EDIT</a></h3>';
        $reviewString.= '<h3><a href="../reviews/index.php?action=confirmDelete&reviewId=';
        $reviewString.= $review['reviewId'];
        $reviewString.= '">DELETE</a></h3>';
      }
    }
    include '../view/admin.php';
    
  }


    
    
  
     
   


   

?>