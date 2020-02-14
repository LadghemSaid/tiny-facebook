<?php

    
$friend = $_POST['friendname'];
$me = $_SESSION['id'];

$sql = "SELECT id FROM user WHERE login = ?";
//Renvoie liste des nom AMIS de la personne connecté 
$q = $pdo->prepare($sql);
$q->execute(array($friend));
$idfriend = $q->fetch();


    
$sql = "DELETE FROM friends WHERE iduser = ? AND idfriend= ?";
$q = $pdo->prepare($sql);
$q->execute(array($me,$idfriend['id']));
$sql = "DELETE FROM friends WHERE  idfriend= ? AND iduser = ? ";
$q = $pdo->prepare($sql);
$q->execute(array($me,$idfriend['id']));


if(isset($_POST['monmur'])){
    
header('Location: index.php?action=monmur');
}else{
header('Location: index.php?action=monprofile');
}
