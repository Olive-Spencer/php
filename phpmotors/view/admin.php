<?php
if ($_SESSION['loggedin'] != TRUE ){
    header('Location: /phpmotors/index.php');
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $_SESSION['message'] = ''; 
   }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title>Admin Page | PHP motors</title>
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
    <h1><span>Welcome <?php if(isset($sessionFirstname) && isset($sessionLastname)){
 echo " $sessionFirstname $sessionLastname";
} ?>. You are logged in!</span></h1>
<?php
if (isset($message)) {
 echo $message;
}
?>

<ul>
<li><label>First Name:</label><?php if(isset($sessionFirstname)){
 echo " $sessionFirstname";
} ?></li>
<li><label>Last Name:</label><?php if(isset($sessionLastname)){
 echo " $sessionLastname";
} ?></li>
<li><label>Email:</label><?php if(isset($sessionEmail)){
 echo " $sessionEmail";
} ?></li>
</ul>
<a href='/phpmotors/accounts/index.php?action=update' title='Account Management'><p>Update account information</p></a>
<?php 
    if ($sessionLevel > 1){
        echo "<hr><h3>Manage Vehicles</h3><p>Admin access only.</p><p>Use the following link to adjust inventory:</p><a href='/phpmotors/vehicles' title='Vehicle Management'><p>Vehicle Management</p></a>";
    }
    if(isset($reviewString)){
        echo $reviewString;}
?>

</main>


<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>