
    <a href="http://localhost:8080/phpmotors" title = "Home"><img src="http://localhost:8080/phpmotors/images/site/logo.png" alt="logo" class="logo"></a><br><br><?php 
    if(isset($_SESSION['welcome'])){
 echo ' <div><a href="/phpmotors/accounts/index.php" title = "Account management">Welcome ', $_SESSION['welcome'], ' </a>';
}elseif(isset($_COOKIE['firstname'])){
    echo ' <div>Welcome ',$_COOKIE['firstname'],' | ';
}
else{
    echo '<div>';
}
  if(isset($_SESSION['clientData'])) {
    echo '<a href="http://localhost:8080/phpmotors/accounts/index.php?action=logout" title="LogOut"><span>| Log Out</span></a></div>';}
    else{
        echo '<a href="http://localhost:8080/phpmotors/accounts/index.php?action=login" title="Login"><span>Login</span></a></div>';
    }
     ?>
    

