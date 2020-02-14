<?php
if(isset($_SESSION)){
    $_SESSION = array();
    setcookie("cookie", "", time()-3600);
    session_destroy();
    header('Location: index.php');
    
}