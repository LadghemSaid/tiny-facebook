<?php



if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
if(isset($_SESSION["error"]) && $_SESSION["error"] !== 0){
    phpAlert($_SESSION["error"]);        
    unset($_SESSION["error"]); 
    
} 
    
    
    // On veut affchier notre mur ou celui d'un de nos amis et pas faire n'importe quoi

$monmur = true;
$pattern = "/friendwall\?.*/";
//declaration des function
include("$_SERVER[DOCUMENT_ROOT]/tiny-facebook/tiny-facebook-project/config/fonctionhelper_Mur.php");

if($_GET["action"]=="monmur"){
        $id = $_SESSION["id"];
        $monmur = true; // On a le droit d afficher notre mur
}else if (preg_match($pattern,$_GET['action'])){

    $id = $_GET["action"];
    //var_dump($id);
    // Verifions si on est amis avec cette personne
    $pattern2 = "/friendwall\?/";
    $amis = preg_replace($pattern2,'',$_GET['action']);
   // var_dump($amis);
    $sql = "SELECT * FROM user WHERE login = ?";
    $q0 = $pdo->prepare($sql);
    $q0->execute(array($amis));
        if($infoamis = $q0->fetch()){
            
          // var_dump($infoamis);
           
           // exit();
            //Si on est la c'est que Frienwall?machin existe
            
            $idamis = $infoamis['id'];
            $sql = "SELECT * FROM friends WHERE isvalidate=1
                    AND ((iduser=? AND idfriend=?) OR ((iduser=? AND idfriend=?)))";
            $q0 = $pdo->prepare($sql);
            $q0->execute(array($_SESSION["id"],$idamis,$idamis,$_SESSION["id"]));
                if($line = $q0->fetch()){
                    $sql = "Select e.* From ecrit e where e.idAuteurPost = ? order by e.dateEcrit desc";
                    $q1 = $pdo->prepare($sql);
                    $q1->execute(array($idamis,));
                    $monmur=false;
                    $moicompris = false;
                //On est amis sur la page de qq'un qui existe ET donc on va afficher tout les post de cette personne uniquement
                //ca fonctionne !
                
                    afficherwraperMD10();
                    postApost($infoamis,$moicompris,$me);
                    //var_dump($infoamis); 
                    while($line = $q1->fetch()){
                        recupPosts($line,$moicompris);
                    }
                    
                      $line=$q1->rowCount ();
                     //var_dump($line); On verifie si il a un post a afficher sinon on ecris votre amis n'a aucun post
                     if($line==0){
                       pasdepost($monmur);
                      }
                
                
                }else if($amis != $_SESSION['login']){
                    //Si l'amis passer en Get n'est pas dans notre liste d'amis ET n'est pas nous meme on renvoie sur le mur
                     header('Location: index.php?action=bio?'.$infoamis['login']);
                     //$_SESSION['error'] = "Vous n'êtes pas encore ami, vous ne pouvez voir son mur !!!";
                     //var_dump($line);
                     //exit();
                     //header('Location: index.php?action=monmur');
                }
            
        }else{
            //Si la personne n'existe pas en BD on renvoie
            $_SESSION['error'] = "Cette personne n'existe pas !";
            //var_dump($line);
            //exit();
            header('Location: index.php?action=monmur');
        }
}

/*
$myself ="friendwall?".$_SESSION['login'];
if($_GET["action"]==$myself){
    $id = $_SESSION["id"];
    var_dump($_GET['action']);
    $monmur = true; // On a le droit d afficher notre mur
    }
*/


if($monmur==true) {
    //$sql = "SELECT * FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.iduser = ? AND f.isvalidate=1  OR u.id= ?"; // OR u.id= ?Renvoie liste des nom AMIS de la personne connecté ANSI QUE SOI MEME 
    $me=me();
    $moicompris=true;
    $moi=true;
    afficherwraperMD10();
    postApost($me,$moicompris,$me);
    
    //$sql = "SELECT e.* FROM ecrit e WHERE e.idAuteurPost = ? OR EXISTS (SELECT 1 FROM friends f WHERE f.idfriend = ? AND f.isvalidate = 1 ) ORDER BY e.dateEcrit 
    //desc";
/*
    $sql = 
    "  
   select * from ecrit where  ecrit.idAuteurPost in 
   (select iduser from friends where idfriend=?  and isvalidate=1)
   or 
   (select idfriend from friends where iduser=? and isvalidate=1) 
   AND ecrit.idAuteurPost= ?
   ORDER BY ecrit.dateEcrit DESC
    ";
    */
    
      $sql = 
    "SELECT * FROM ecrit e 
                LEFT JOIN friends f on f.idfriend = e.idAuteurPost
	            WHERE e.idAuteurPost  IN 
                				(SELECT u.id FROM user u 
                                 LEFT JOIN friends f on u.id = f.iduser 
                                 WHERE isvalidate=1
                                 AND ((f.iduser=? AND u.id != ?) 
                                 OR 
                                 (f.idfriend=? AND u.id!=?))) 
                OR e.idAuteurPost=?

        GROUP BY e.id 
        ORDER BY e.dateEcrit DESC
    ";
    
    $posts = $pdo->prepare($sql);
    $posts->execute(array($_SESSION["id"],$_SESSION["id"],$_SESSION["id"],$_SESSION["id"],$_SESSION["id"]));

        while($post = $posts->fetch()){
            //var_dump($post);
            recupPosts($post,$moicompris);
          
        }
        $post=$posts->rowCount ();
        //var_dump($post);  On verifie si il y a un post a afficher sinon on ecris vous n'avez aucun post
        if($post==0){
            pasdepost($monmur);
        }
            
        
    
}

friendlist();
echo"</div>";
