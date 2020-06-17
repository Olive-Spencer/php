<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title>Vehicle Management | PHP motors</title>
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
<?php
if (isset($message)) {
 echo $message;
}
?>
<section><h2>Vehicle Management</h2>

<ul>
    <li><a href='/phpmotors/vehicles/index.php?action=addClass'>Add Classification</a><br></li>
    <li><a href='/phpmotors/vehicles/index.php?action=addVehicle'>Add Vehicle</a><br></li>
</ul>
</section>
<?php
if (isset($message)) { 
 echo $message; 
} 
if (isset($classificationList)) { 
 echo '<h2>Vehicles By Classification</h2>'; 
 echo '<p>Choose a classification to see those vehicles</p>'; 
 echo $classificationList; 
}
?>
<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>
<table id="inventoryDisplay"></table>

</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    <script src="../js/inventory.js"></script>
    </body>
    
</html>
<?php unset($_SESSION['message']); ?>