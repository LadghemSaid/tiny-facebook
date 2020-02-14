<?php

function check_login() {
    if (isset($_SESSION['id'])) {
       return true;
    }
    else {
       return false;
    }
}

function notif(){
    global $pdo;
    $sql = "SELECT COUNT(*) FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.idfriend = ? AND f.isvalidate IS NULL"; //Renvoie liste des nom des demande d'amitie de la personne co
    $q = $pdo->prepare($sql);
    $q->execute(array($_SESSION["id"]));
    $result = $q->fetch();
    //var_dump($result);
    return $result;
    
    
    
}

function checkcookie(){
    $cookie =$_COOKIE['cookie'];
    global $pdo;
    $sql = "SELECT * FROM user WHERE remember = ?";
    $q = $pdo->prepare($sql); 
    $q->execute(array($cookie));
    if($result = $q->fetch()){
        $_SESSION['login'] = $result['login'];
        $_SESSION['id'] = $result['id'];
    }
        //var_dump($result,$cookie);
        //exit();
    
}
