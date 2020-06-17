<?php
if (isset($_SESSION['message'])) {
    $error = $_SESSION['message'];
   }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title><?php echo $vehicle[0]['invMake']," ", $vehicle[0]['invModel']; ?> | PHP Motors, Inc.</title>
    </head>
    <body>
    <div class="container">
<header>
    <?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/header.php'; ?>

</header>


<nav>
<?php //include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/nav.php'; 
    echo $navList;
?>

</nav>

<main>
<h1><?php echo $vehicle[0]['invMake']," ", $vehicle[0]['invModel']; ?></h1>
<h3>Scroll down for reviews.</h3>
<?php if(isset($message)){
 echo $message; }
 ?>
 <?php if(isset($vehicleDisplay)){
 echo $vehicleDisplay;
} ?>
<hr>
<h2>Vehicle Reviews</h2>

<hr>
<?php if(isset($error)){
 echo $error; }
 ?>
<?php if(!isset($_SESSION['welcome'])){ echo "<a href='/phpmotors/accounts/index.php?action=login'>Login to add a review</a>"; }
else{ echo $reviewDisplay;    
} if(!empty($existingReviews)){
    echo $existingReviewsDisplay;
    echo "<hr>";
}else{
    echo "<hr><h3>Be the first to add a review!</h3>";
} ?>

</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>