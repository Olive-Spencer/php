<?php
if ($_SESSION['loggedin'] != TRUE ){
    header('Location: /phpmotors/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title>Client Update | PHP motors</title>
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
<section><h2> Update Account</h2>
<?php
if (isset($message)) {
 echo $message;
}
?>
<form method="post" action="/phpmotors/accounts/index.php">
    <label for="clientFirstname">First Name <input name="clientFirstname" id="clientFirstname" type="text" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}elseif(isset($sessionFirstname)){echo "value='$sessionFirstname'";} ?> required></label>
    <label for="clientLastname">Last Name <input name="clientLastname" id="clientLastname" type="text" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}elseif(isset($sessionLastname)){echo "value='$sessionLastname'";}   ?> required></label>
    <label for="clientEmail">Email <input name="clientEmail" id="clientEmail" type="email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}elseif(isset($sessionEmail)){echo "value='$sessionEmail'";}   ?> required></label>
    <input type="submit" name="submit" id="updateClientBtn" value="Update Information">
    <input type="hidden" name="action" value="updateInformation">
    <input type="hidden" name="clientId" value="<?php if(isset($clientId)){ echo $clientId;}?>">
</form>
<h2>Update Password</h2>
<?php
if (isset($messagePass)) {
 echo $messagePass;
}
?>
<form method="post" action="/phpmotors/accounts/index.php">
    <span class="span">The password requires at least 8 characters and must have at least 1 uppercase character, 1 number and 1 special character.</span>
    <label for="clientPassword">Password <input name="clientPassword" id="clientPassword" type="password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"></label>
    <input type="submit" name="submit" id="updatePassBtn" value="Update Password">
    <input type="hidden" name="action" value="updatePassword">
    <input type="hidden" name="clientId" value="<?php if(isset($clientId)){ echo $clientId;}?>">
    


</form>
</section>

</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>