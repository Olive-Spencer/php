<?php
//insert review function
function addReview($reviewText, $invId, $clientId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId)
        VALUES (:reviewText, :invId, :clientId)';
    

                     
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)

    return $rowsChanged;
    
    
   }






//get reviews for specific inventory item
function insertReview($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE invId = :invId ORDER BY reviewId DESC' ;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

//get reviews written by specific client
function reviewByClientId($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE clientId = :clientId ORDER BY reviewId DESC' ;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

//get a specific review
function reviewByReviewId($reviewId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE reviewId = :reviewId' ;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
}
//update a specific review

function updateReview($reviewText, $reviewId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    

                     
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    
    
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)

    return $rowsChanged;

}

//delete a specific review
function deleteReview($reviewId){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    

                     
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)

    return $rowsChanged;

}
?>