<?php

$friend = $_POST['friendname'];
$me = $_SESSION['id'];

$sql = "SELECT id FROM user WHERE login = ?";
//Renvoie liste des nom AMIS de la personne connecté 
$q = $pdo->prepare($sql);
$q->execute(array($friend));
$idfriend = $q->fetch();

$sql = "SELECT COUNT(*) FROM friends WHERE isvalidate IS NULL AND (idfriend = ? AND iduser = ?) "; 
$q1 = $pdo->prepare($sql);
$q1->execute(array($idfriend['id'],$_SESSION["id"]));
$isfriend = $q1->fetch();
    //var_dump($idfriend);
    //var_dump($friend);
//exit();
    if(intval($isfriend[0])>=1){
        
        header('Location: index.php?action=monprofile');
    }else{
        $sql = "UPDATE friends SET isvalidate='1' WHERE (idfriend=? AND iduser = ?)";
        $q2 = $pdo->prepare($sql); 
        $q2->execute(array($me,$idfriend['id']));
        
        $sql = "SELECT * FROM friends WHERE isvalidate=0 AND (idfriend = ? AND iduser = ?) OR (iduser=? AND idfriend= ?)"; 
        $q3 = $pdo->prepare($sql);
        $q3->execute(array($idfriend['id'],$_SESSION["id"],$idfriend['id'],$_SESSION["id"]));
        $isfriend = $q3->fetch();
    //var_dump($idfriend);
    //var_dump($isfriend);
    //exit();
    if($isfriend){
        $sql = "UPDATE friends SET isvalidate='1' WHERE (iduser=? AND idfriend=?)";
        $q4 = $pdo->prepare($sql); 
        $q2->execute(array($me,$idfriend['id']));
          
        $sql = "INSERT into friends (iduser, idfriend, isvalidate) values (?, ?, 1);";
        $q5 = $pdo->prepare($sql); 
        $q5->execute(array($me,$idfriend['id']));
        
         header('Location: index.php?action=monprofile');
    }else{
        $sql = "INSERT into friends (iduser, idfriend, isvalidate) values (?, ?, 1);";
        $q5 = $pdo->prepare($sql); 
        $q5->execute(array($me,$idfriend['id']));
        header('Location: index.php?action=monprofile');        
    }
    }
