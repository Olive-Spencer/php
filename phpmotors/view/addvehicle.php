<?php
// Build a dropdown using $classifications array
$classificationList = '<select name="classificationId" id="classificationId">';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
if(isset($classificationId)){
    if($classification['classificationId'] === $classificationId){
       $classificationList .= ' selected ';
    }
}


    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= "</select>";

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
        <title>Add Vehicle | PHP motors</title>
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
<section><h2>Add Vehicle</h2>
<?php
if (isset($message)) {
 echo $message;
}
?>
<form method="post" action="/phpmotors/vehicles/index.php">
<label for=classificationId>Choose a Classification:<?php echo $classificationList; ?></label>
<label for="invMake">Make
    <input name="invMake" id="invMake" type="text" required <?php if(isset($invMake)){echo "value='$invMake'";} ?>></label>
    <label for="invModel">Model
    <input name="invModel" id="invModel" type="text" required <?php if(isset($invModel)){echo "value='$invModel'";} ?>></label>
    <label for="invDescription">Description
    <textarea name="invDescription" id="invDescription" rows="4" cols="21" required><?php if(isset($invDescription)){echo "$invDescription";}?></textarea></label>
    <label for="invImage">Image Path
    <input name="invImage" id="invImage" type="text" <?php if(isset($invImage)){echo "value='$invImage'";}else{echo "value='phpmotors/images/vehicles/no-image.png'";} ?> required></label>
    <label for="invThumbnail">Thumbnail Path
    <input name="invThumbnail" id="invThumbnail" type="text" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}else{echo "value='phpmotors/images/vehicles/no-image.png'";} ?> required></label>
    <label for="invPrice">Price
    <input name="invPrice" id="invPrice" type="number" step="0.01" min="0" <?php if(isset($invPrice)){echo "value='$invPrice'";} ?> required></label>
    <label for="invStock">Stock
    <input name="invStock" id="invStock" type="number" <?php if(isset($invStock)){echo "value='$invStock'";} ?> required></label>
    <label for="invColor">Color
    <input name="invColor" id="invColor" type="text" <?php if(isset($invColor)){echo "value='$invColor'";} ?> required></label>
    <input type="submit" name="submit" id="regbtn" value="Add Vehicle">
    <input type="hidden" name="action" value="addv">

</form>
</section>


</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>