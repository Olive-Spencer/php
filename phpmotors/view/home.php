<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel=stylesheet media="screen" href="css/style.css" />
        <title>Home | PHP motors</title>
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
<section><h2>Welcome to PHP Motors!</h2>
<img src="images/vehicles/delorean.jpg" alt="delorean" class="mainImg">
<div class="textBox"><strong>DMC Delorean</strong> Cup Holders
Superman doors
Fuzzy dice!
<a href="home.php" title="Own Today"><img src="images/site/own_today.png" alt="Own Today" class="ownLarge"></a>
</div>

</section>
<a href="home.php" title="Own Today"><img src="images/site/own_today.png" alt="Own Today" class="own"></a>

<article><div class="reviews">
    <h3>DMC Delorean Reviews</h3>
    <ul>
        <li>"So fast its almost like traveling in time. [4/5]</li>
        <li>"coolest ride on the road." [4/5]</li>
        <li>"I'm feeling Marty McFly!" [5/5]</li>
        <li>"The most futuristic ride of our day" [5/5]</li>
        <li>"80's livin and I love it!" [5/5]</li>
    </ul>
</div>

<div class="upgrades">
    <h3>Delorean Upgrades</h3>
    <div class="upgradeWrap">
    <div class="upgradeAdjust"><a href="home.php" title="Flux-Cap"><img src="images/upgrades/flux-cap.png" class="upgradeImg" alt="Flux Capacitor"><div class="text">Flux Capacitor</div></a>
    </div>
    <div class="upgradeAdjust"><a href="home.php" title="Flames"><img src="images/upgrades/flame.jpg" class="upgradeImg" alt="flames"><div class="text">Flames</div></a>
    </div><div class="upgradeAdjust"><a href="home.php" title="Bumper Sticker"><img src="images/upgrades/bumper_sticker.jpg" class="upgradeImg" alt="Bumper Sticker"><div class="text">Bumper Sticker</div></a>
    </div><div class="upgradeAdjust"><a href="home.php" title="Hub Caps"><img src="images/upgrades/hub-cap.jpg" class="upgradeImg" alt="Hub Caps"><div class="text">Hub Caps</div></a>
    </div>
    </div>
    </div>
   </article>


</main>

<footer>

<?php include $_SERVER['DOCUMENT_ROOT']. '/phpmotors/common/footer.php'; ?>
</footer>
    </div>
    </body>
    
</html>