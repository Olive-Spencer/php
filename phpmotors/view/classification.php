<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
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
<h1><?php echo $classificationName; ?> vehicles</h1>
<?php if(isset($message)){
 echo $message; }
 ?>
 <?php if(isset($vehicleDisplay)){
 echo $vehicleDisplay;
} ?>
</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>