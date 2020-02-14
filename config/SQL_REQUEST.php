<?php

$sql = "SELECT * FROM friends WHERE isvalidate=1 AND ((iduser=? AND idfriend=?) OR ((idfriend=? AND iduser=?)))";
$q0 = $pdo->prepare($sql);
$q0->execute(array($_GET["id"],$_SESSION["id"]));
$line = $q0->fetch();

Renvoie tout les  champ ou iduser = moi et idfriend = $_get et isvalide est a 1

//


$sql = "SELECT login FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.iduser = ? AND f.isvalidate=0"; 
$q6 = $pdo->prepare($sql);
$q6->execute(array($_SESSION["id"]));
while ($result = $q6->fetch()){ 

    //Renvoie liste des nom AMIS de la personne connecté qui ont refusé l'invite INUTILE
//
  
    
$sql = "SELECT * FROM user WHERE id=?";
$q1 = $pdo->prepare($sql);
$q1->execute(array($_SESSION['id']));
// Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
$me = $q1->fetch();
    Renvoi toute les infos me concernant
//
    
    
$sql = "SELECT * FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.iduser = ? AND f.isvalidate=1"; 
$qamis = $pdo->prepare($sql);
$qamis->execute(array($_SESSION["id"]));
    $line2 = $qamis->fetch();

    //Renvoie liste des nom AMIS de la personne connecté TRES UTILE !!! 
//
    
    
$sql = "SELECT * FROM ecrit left JOIN friends f on f.idfriend=ecrit.idAuteur  WHERE ecrit.idAuteur=? OR f.isvalidate=1 order by dateEcrit DESC";  
$qmain = $pdo->prepare($sql);
$qmain->execute(array($_SESSION["id"]));
    
    //Selectionne tout les ecrits des personne amis IS validate et de moi idAuteur=me trier par ordre
//
    
 while($line = $qmain->fetch()){
     //recupere tout les POSTE DE MOI ET MES AMIS
//
     
    $sql = "SELECT * FROM user WHERE id=? ";  
    $q4 = $pdo->prepare($sql);
    $q4->execute(array($line['idAuteur']));
    $auteurnom = $q4->fetch();
     
        //SELECTIONNE DANS CES POST le nom de l'auteur grace a la requete precedente   (pour chaque post)
    //

    $sql = "SELECT * FROM commentaire c JOIN ecrit e ON e.id=c.idComment WHERE c.idComment= ?"; 
    $q5 = $pdo->prepare($sql);
    $q5->execute(array($line['id']));
     
     //selectionne tous les commentaire du post passer en idComment
    //

    $sql = "SELECT COUNT(*) FROM commentaire WHERE idComment = ?";  
    $q6 = $pdo->prepare($sql);
    $q6->execute(array($line['id']));
    $nbrcom=$q6->fetch();
     
        //Compte les commentaire (pour chaque post)
    //

    while($auteurnom=$q5->fetch()){ 
        //

        $sql = "SELECT * FROM user WHERE id=? ";  
        $q7 = $pdo->prepare($sql);
        $q7->execute(array($auteurnom['idAuteur']));
        $auteurnomcom = $q7->fetch(); 
        
        //Pour chaque commentaire selectionne on cherche le nom dans la base USER

//
while ($result = $qamis->fetch()){
    $sql = "SELECT login FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.idfriend = ? AND f.isvalidate IS NULL"; 
    //Renvoie liste des nom AMIS de la personne connecté 
    $q9 = $pdo->prepare($sql);
    $q9->execute(array($_SESSION["id"]));
//
    while ($result = $q9->fetch()){

//  
        $sql = "SELECT login FROM user u INNER JOIN friends f on f.iduser = u.id WHERE f.idfriend = ? AND f.isvalidate IS NULL"; 
        //Renvoie liste des nom AMIS de la personne connecté 
        $q10 = $pdo->prepare($sql);
        $q10->execute(array($_SESSION["id"]));
        $res = $q10->fetch();

    
    
    
    
    
?>
