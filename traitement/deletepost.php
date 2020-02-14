<?php
if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
$idpostdelete =$_POST['idpostdelete'];
$me=$_SESSION['id'];

$sql="SELECT * FROM ecrit WHERE idAuteurPost=? AND id=?";
$q=$pdo->prepare($sql);
$q->execute(array($me,$idpostdelete));

$mypost=$q->fetch();
if($mypost!==null){
    if($mypost['image']!=null){
        //var_dump($mypost['image']);
        //exit();
        //suppression d'eventuelle image dans le post
       
        $myFile = "uploads/".$mypost['image'];

        if (file_exists($myfile)) {
            unlink($myFile) or die("Impossible de supprimer le fichier ".$myFile);
        }
    }
     //suppression des likes du post
    $sql="DELETE FROM rating_info WHERE post_id=? AND user_id=?";
    $q= $pdo->prepare($sql);
    $q->execute(array($idpostdelete,$me));
    
    //suppression des commentaires
    $sql="DELETE FROM commentaire WHERE idComment=?";
    $q= $pdo->prepare($sql);
    $q->execute(array($idpostdelete));
    //var_dump($idpostdelete);
    //exit();
    //suppression des likes des commentaire 
    $sql="DELETE FROM rating_info_commentaire WHERE id_post_p=?";
    $q= $pdo->prepare($sql);
    $q->execute(array($idpostdelete));
    
    //supression du post
    $sql="DELETE FROM ecrit WHERE idAuteurPost=? AND id=?";
    $q= $pdo->prepare($sql);
    $q->execute(array($me,$idpostdelete));
    //var_dump($idpostdelete);
    //exit();
    header("Location:index.php?action=monmur");
}else{
    header("Location:index.php?action=monmur");
}


