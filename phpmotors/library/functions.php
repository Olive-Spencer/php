<?php

//Check valid e-mail
function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}

// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
function checkPassword($clientPassword){
 $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
 return preg_match($pattern, $clientPassword);
}

function buildNav($classifications){
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 

    
   }

//Build the Vehicles Display
function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
     $dv .= '<li>';
     $dv .= "<a href='/phpmotors/vehicles/?action=vehiclePage&invId=".urlencode($vehicle['invId'])."'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
     $dv .= '<hr>';
     $dv .= "<a href='/phpmotors/vehicles/?action=vehiclePage&invId=".urlencode($vehicle['invId'])."'><h2>$vehicle[invMake] $vehicle[invModel]</h2></a>";
     $price = number_format($vehicle['invPrice']);
     $dv .= "<span>$$price</span>";
     $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
   }

function buildVehicleDisplay($vehicles){

    $price= number_format($vehicles[0]['invPrice']);
    
    
    foreach ($vehicles as $vehicle) {
     $dv = "<div class='inline-element'><img src='$vehicle[invImage]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com' id='disImage'></div>";
     $dv .= "<div class='inline-element'><hr>";
     $dv .= "<h2>$vehicle[invColor] $vehicle[invMake] $vehicle[invModel]</h2>";
    

     $dv .= "<span>Price: $$price | Stock: $vehicle[invStock] | Color: $vehicle[invColor] </span>";
     
    
     $dv .= "<hr><span>Description: $vehicle[invDescription]</span><hr></div>";
    }

    return $dv;

}
//builds display to add a review
function buildReviewDisplay($invId){
    $sessionFirstname = $_SESSION['clientData']['clientFirstname'];
    $sessionLastname = $_SESSION['clientData']['clientLastname'];
    $sessionClientId = $_SESSION['clientData']['clientId'];
    $screenName = substr($sessionFirstname,0,1).$sessionLastname;

    $display = "<h3>Write a review:</h3>";
    $display .= "<form method='post' action='/phpmotors/reviews/index.php'>";
    $display .= "<label for='screenName'>Screen Name:<input type='text' name='screenName' id='screenName' value='$screenName' readonly></label>";
    $display .= "<label for='reviewText'>Review:<textarea id='reviewText' name='reviewText' rows='3' cols='40' required></textarea></label>";
    $display .= "<input type='submit' value='Submit' id='revSubmit' class='submitBtn' name='submit'>";
    $display .= "<input type='hidden' name='invId' id='invId' value='$invId'>";
    $display .= "<input type='hidden' name='clientId' id='clientId' value='$sessionClientId'>";
    $display .= "<input type='hidden' name='action' value='add'></form>";

    return $display;

}
//builds display for existing reviews
function buildExistingReviewDisplay($review){
    $date = date('l jS \of F Y h:i:s A', strtotime($review['reviewDate']));
    $dr = "<hr>";
    $dr .= "<h2>Review</h2>";
    $dr .= "<h3>$review[reviewText]</h3>";
    $dr .= "<h5>Review by $review[screenName] of ";
    $dr .= "$review[car] published ";
    $dr .= "$date </h5>";
    
    

    return $dr;


}
function buildReviewEditDisplay($review){
    
    $sessionClientId = $review['clientId'];
    $screenName = $review['screenName'];
    $invId = $review['invId'];
    $reviewText = $review['reviewText'];

    $display = "<h3>Edit Review:</h3>";
    $display .= "<form method='post' action='/phpmotors/reviews/index.php'>";
    $display .= "<label for='screenName'>Screen Name:<input type='text' name='screenName' id='screenName' value='$screenName' readonly></label>";
    $display .= "<label for='reviewText'>Review:<textarea id='reviewText' name='reviewText' rows='3' cols='40' required>$reviewText</textarea></label>";
    $display .= "<input type='submit' value='Submit' id='revSubmit' class='submitBtn' name='submit'>";
    $display .= "<input type='hidden' name='invId' id='invId' value='$invId'>";
    $display .= "<input type='hidden' name='clientId' id='clientId' value='$sessionClientId'>";
    $display .= "<input type='hidden' name='action' value='update'></form>";

    return $display;

}

?>
