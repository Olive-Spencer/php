<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title>Login | PHP motors</title>
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
<section><h2>Sign In</h2>
<?php
if (isset($message)) {
 echo $message;
}
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   }
?>
<form method="post" action="/phpmotors/accounts/index.php">
    <label for="clientEmail">Email <input name="clientEmail" id="clientEmail" type="email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required></label>
    <span class="span">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> 
    <label for="clientPassword">Password <input name="clientPassword" id="clientPassword" type="password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"></label>
    <input type="submit">
    <input type="hidden" name="action" value="executeLogin">
    <a href='/phpmotors/accounts/index.php?action=registration'>Not yet a member? Click Here!</a>


</form>
</section>

</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>