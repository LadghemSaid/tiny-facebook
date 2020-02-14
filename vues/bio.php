<?php



if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
if(isset($_SESSION["error"]) && $_SESSION["error"] !== 0){
    phpAlert($_SESSION["error"]);        
    unset($_SESSION["error"]); 
    
} 
    
    
    // On veut affchier notre bio ou celui d'un de nos amis et pas faire n'importe quoi

$mabio = true;
$pattern = "/bio\?.*/";

//declaration des function
include("$_SERVER[DOCUMENT_ROOT]/tiny-facebook/tiny-facebook-project/config/fonctionhelper_Mur.php");
include("$_SERVER[DOCUMENT_ROOT]/tiny-facebook/tiny-facebook-project/config/fonctionhelper_bio.php");
if($_GET["action"]=="bio"){
        $id = $_SESSION["id"];
        $mabio = true; // On a le droit d afficher notre bio
        
}else if (preg_match($pattern,$_GET['action'])){

    $id = $_GET["action"];
    // Verifions si on est amis avec cette personne
    $pattern2 = "/bio\?/";
    $amis = preg_replace($pattern2,'',$_GET['action']);
   // var_dump($amis);
    $sql = "SELECT * FROM user WHERE login = ?";
    $q0 = $pdo->prepare($sql);
    $q0->execute(array($amis));
    
        if($infoamis = $q0->fetch()){
            
          // var_dump($infoamis);
           
           // exit();
            //Si on est la c'est que bio?machin existe
            
            $idamis = $infoamis['id'];
            $sql = "SELECT * FROM friends WHERE isvalidate=1
                    AND ((iduser=? AND idfriend=?) OR ((iduser=? AND idfriend=?)))";
            $q0 = $pdo->prepare($sql);
            $q0->execute(array($_SESSION["id"],$idamis,$idamis,$_SESSION["id"]));
                if($line = $q0->fetch()){
                //On est amis sur la page de qq'un qui existe ET donc on va afficher sa bio uniquement
                    //var_dump($line);
                    //var_dump($infoamis);
                    $mabio=false;
                    $amis=true;
                    recupbio($infoamis,$mabio,$amis);
   
                }else if($amis != $_SESSION['login']){
                    //Si l'amis passer en Get n'est pas dans notre liste d'amis ET n'est pas nous meme on renvoie sur le bio
                    //$_SESSION['error'] = "Vous n'êtes pas encore ami, vous ne pouvez voir son bio !!!";
                    //exit();
                    //header('Location: index.php?action=monmur');
                    $amis=false;
                    $mabio=false;
                    //echo"Test";
                    //var_dump($infoamis);
                    recupbio($infoamis,$mabio,$amis);
                  
                    
                    
                }
            
        }else{
            //Si la personne n'existe pas en BD on renvoie
            $_SESSION['error'] = "Cette personne n'existe pas !";
            //var_dump($line);
            //exit();
            header('Location: index.php?action=monmur');
        }
}




if($mabio==true) {
    $amis = false;
    $me = me();
    recupbio($me,$mabio,$amis);
    
}

friendlist();
echo" </div>";
