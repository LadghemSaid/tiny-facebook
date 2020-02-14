<?php
 if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
if(isset($_FILES)){
$temp = $_FILES["file"]["tmp_name"];
$image = basename($_FILES["file"]["name"]);
$img = "uploads/".$image;
move_uploaded_file($temp, $img); 
    
$file=$_FILES['file']['name'];
$content = $_POST['content'];
$me = $_SESSION['id'];
    
$sql = "INSERT into ecrit (contenu,dateEcrit,idAuteurPost,image) values
(?,CURRENT_TIMESTAMP,?,?)";
$q = $pdo->prepare($sql); 
$q->execute(array($_POST['content'],$me,$file));
header('Location: index.php?action=monmur');
}else{
    
$content = $_POST['content'];
$me = $_SESSION['id'];

//var_dump($_POST);
//var_dump($_FILES);
//var_dump($me);
//exit();
$sql = "INSERT into ecrit (contenu,dateEcrit,idAuteurPost) values
        (?,CURRENT_TIMESTAMP,?)";
$q = $pdo->prepare($sql); 
$q->execute(array($_POST['content'],$me));
header('Location: index.php?action=monmur');

}
