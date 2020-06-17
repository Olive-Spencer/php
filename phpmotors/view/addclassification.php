<?php
if ($sessionLevel <= 1){
    header('Location: /phpmotors');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="../css/style.css" />
        <title>Add Classification | PHP motors</title>
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
<section><h2>Add Classification</h2>
<?php
if (isset($message)) {
 echo $message;
}
?>
<form method="post" action="/phpmotors/vehicles/index.php">
<label for="classificationName">Classification Name<input name="classificationName" id="classificationName" type="text" <?php if(isset($classificationName)){echo "value='$classificationName'";}  ?> required></label>
    <input type="submit" name="submit" id="regbtn" value="Add Classification">
    <input type="hidden" name="action" value="addc">
</form>
</section>


</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>