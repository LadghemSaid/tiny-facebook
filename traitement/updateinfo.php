<?php
//var_dump($_POST);
if(!isset($_SESSION["id"])) {
    // On n est pas connecté, il faut retourner à la pgae de login
    header("Location:index.php?action=login");
}
 
$music_style = []; // liste a cocher des gout musicaux

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && $_POST['age'] >= 16 && isset($_POST['status']) && isset($_POST['genre']) && isset($_POST['description']) ){
    // formulaire bien remplie on insert dans la bd
     if(isset($_POST['pop'])){
        array_push($music_style,"pop");
    }
     if(isset($_POST['rock'])){
        array_push($music_style,"rock");
    }
    if(isset($_POST['rap'])){
       array_push($music_style,"rap");
    }
    if(isset($_POST['r_b'])){
       array_push($music_style,"rnb");
    }
    if(isset($_POST['metal'])){
       array_push($music_style,"metal");
    }
    var_dump($music_style);
    $music_style = implode(",",$music_style);
    var_dump($music_style);
    // Je verifie si une entree pour l'user existe deja ou non
    $sql = "SELECT * FROM info_user WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_SESSION['id']));
    if($line=$q->fetch()){
        //Une entree existe donc on ne cree pas on update
        $sql = "UPDATE info_user SET nom = ?, prenom = ?, age = ?, description = ?, status = ?, genre = ?, music_style = ?, favorite_music_style = ?, food = ?, relationship = ?, interest = ? WHERE id = ? ";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['nom'],$_POST['prenom'],$_POST['age'],$_POST['description'],
                                          $_POST['status'],$_POST['genre'],$music_style,$_POST['favorite_music_style'],
                                          $_POST['food'],$_POST['relation'],$_POST['interest'],$_SESSION['id']));
    }else{
        //Il n'existe pas d'entree on doit la cree
        $sql = "INSERT INTO info_user VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_SESSION['id'],$_POST['nom'],$_POST['prenom'],$_POST['age'],$_POST['description'],
                                          $_POST['status'],$_POST['genre'],$music_style,$_POST['favorite_music_style'],
                                          $_POST['food'],$_POST['relation'],$_POST['interest']));  
    }
    
    header('Location:index.php?action=monprofile');
    
    
    /*
    $_SESSION['error'] = "Nom d'utilisateur déjà pris.";
    header('Location:index.php?action=monprofile');
    */          
}   

