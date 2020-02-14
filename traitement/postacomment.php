<?php
 if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }

$mur_de = $_POST['murde'];
$content = $_POST['contents'];
$idcomment = $_POST['whichcomment'];
$me = $_SESSION['id'];
$pattern = "/friendwall\?.*/";
//var_dump($content);
//var_dump($idcomment);
//var_dump($me);
date_default_timezone_set('Europe/Paris');
$date = date('Y-m-d H:i:s');
$sql = "INSERT into commentaire (idAuteur,idComment,content,datecom) values
        (?,?,?,?)";
$q = $pdo->prepare($sql); 
$q->execute(array($me,$idcomment,$content,$date));
        
        
if(preg_match($pattern,$mur_de)){
    $pattern2 = "/friendwall\?/";
    $amis = preg_replace($pattern2,'',$mur_de);
    //var_dump($amis);
    //exit();
    header('Location: index.php?action=friendwall?'.$amis);
}else{
    //var_dump($mur_de);
    //exit();
    header('Location: index.php?action=monmur');
}