<?php

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// get accounts model
require_once '../model/accounts-model.php';
// Get the vehicle model
require_once '../model/vehicles-model.php';
// Get the functions library
require_once '../library/functions.php';
// Create or access a Session
require_once '../model/reviews-model.php';
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

// Build a dropdown using $classifications array
//$classificationList = '<select name="classificationId" id="classificationId">';
//foreach ($classifications as $classification) {
//    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
//}
//$classificationList .= "</select>";

//echo $classificationList

if(isset($_SESSION['clientData'])){
 $sessionLevel = $_SESSION['clientData']['clientLevel'];
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}
switch ($action){
  case 'addClass':
    include "../view/addclassification.php";
    break;
  case 'addVehicle':
    include "../view/addvehicle.php";
    break;
  //case for adding a vehicle
  case 'addv':
    //filter and store the data
    $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
    $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
    $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
    $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
    $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
   

    //Check for missing data
    if(empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription)
       || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) 
       || empty($invStock) || empty($invColor)){
           $message = '<p>Please provide information for all empty form fields.</p>';
           include '../view/addvehicle.php';
           exit;
       }
       

    
   
    
    
       // send the data to the model 
       $carOutcome = addCar($classificationId, $invMake, $invModel, $invDescription,
                            $invImage, $invThumbnail, $invPrice, $invStock, $invColor);

        //echo $carOutcome;
        //verify success or failure
        if($carOutcome === 1){
                $message = "<p>Vehicle added successfully!</p>";
                include '../view/vehiclemanagement.php';
                exit;
            } else {
                $message = "<p>Sorry, adding the vehicle failed. Please try again.</p>";
                include '../view/addvehicle.php';
                exit;
            }
      break;
    //case for adding a classification
    case'addc':
      //filter and store the data
      $classificaionName = filter_input(INPUT_POST,'classificationName', FILTER_SANITIZE_STRING);
      //check for missing data
      if(empty($classificaionName)){
        $message = '<p>Please provide information for all empty form fields.</p>';
           include '../view/addclassification.php';
           exit;
      }

      //send the data to the model
      $classOutcome = addClass(ucfirst($classificaionName));
      //verify success or failure
      if($classOutcome === 1){
        header("Refresh:0");
        exit;
    } else {
        $message = "<p>Sorry, adding the classification failed. Please try again.</p>";
        include '../view/addclassification.php';
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
    $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
     $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-update.php';
    exit;
break;
case 'updateVehicle':
      //filter and store the data
      $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
      $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
      $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
      $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
      $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
      $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
      $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
      $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
      $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
  
      //Check for missing data
      if(empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription)
         || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) 
         || empty($invStock) || empty($invColor)){
             $message = '<p>Please provide information for all empty form fields.</p>';
             include '../view/vehicle-update.php';
             exit;
         }
         
  
      
     
      
      
         // send the data to the model 
         $updateResult = updateVehicle($classificationId, $invMake, $invModel, $invDescription,
                              $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $invId);
  
          //echo $carOutcome;
          //verify success or failure
          if($updateResult === 1){
                  $message = "<p>Vehicle updated successfully!</p>";
                  $_SESSION['message'] = $message;
                  header('location: /phpmotors/vehicles/');
                  exit;
              } else {
                  $message = "<p>Sorry, updating the vehicle failed. Please try again.</p>";
                  include '../view/vehicle-update.php';
                  exit;
              }
        break;
case 'del':
  $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  $invInfo = getInvItemInfo($invId);
  if(count($invInfo)<1){
   $message = 'Sorry, no vehicle information could be found.';
  }
  include '../view/vehicle-delete.php';
  exit;
break;
case 'deleteVehicle':
    //filter and store the data
    
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

       // send the data to the model 
       $deleteResult = deleteVehicle($invId);

        //echo $carOutcome;
        //verify success or failure
        if($deleteResult === 1){
                $message = "<p>Vehicle deleted successfully!</p>";
                $_SESSION['message'] = $message;
                header('location: /phpmotors/vehicles/');
                exit;
            } else {
              $message = "<p>Vehicle was not deleted!</p>";
              $_SESSION['message'] = $message;
              header('location: /phpmotors/vehicles/');
              exit;
            }
break;
case 'classification':
  $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
  $vehicles = getVehiclesByClassification($classificationName);
  if(!count($vehicles)){
    $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
  } else {
    $vehicleDisplay = buildVehiclesDisplay($vehicles);
  }
  //echo $vehicleDisplay;
  //exit;
  include '../view/classification.php';
  break;
case 'vehiclePage':
  $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
  $vehicle = getVehicleById($invId);
  if(!isset($vehicle)){
    $message = "<p class='notice'>Sorry, no $invId vehicle could be found.</p>";
  } else {
    $vehicleDisplay = buildVehicleDisplay($vehicle);
    $invName = $vehicle[0]['invMake'];
  if(isset($_SESSION['clientData'])){
    $reviewDisplay = buildReviewDisplay($invId);
  }
  $existingReviews = insertReview($invId);
  $existingReviewsDisplay = "";
  if(isset($existingReviews)){
    foreach($existingReviews as $review){
      $client = getCliInfo($review['clientId']);
      $car = getVehicleById($invId);
      $review['screenName'] = substr($client['clientFirstname'],0,1).$client['clientLastname'];
      $review['car'] = $car[0]['invModel'];
      $existingReviewsDisplay.= buildExistingReviewDisplay($review);
    }
  }
  //print_r ($existingReviews);
  //exit;
  


    
    //echo '<pre>';
    //print_r (array_values($vehicle));
    //echo '</pre>';
    
  }
  include '../view/vehicle-detail.php';

break;
default:
    $classificationList = buildClassificationList($classifications);

    include "../view/vehiclemanagement.php";
break;
}
?>