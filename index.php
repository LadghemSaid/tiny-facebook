<?php

include("config/config.php");
include("config/bd.php"); // Ajout de la base de donnee
include("divers/balises.php");
include("config/actions.php");
include("config/fonctionhelper.php");
session_start();
ob_start(); // Je démarre le buffer de sortie : les données à afficher sont stockées


?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tiny Facebook</title>

        <!-- Bootstrap core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
        <link href="./css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="#">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
      
-->
       <?php if(isset($_COOKIE['cookie'])){
           checkcookie();
       }
       ?>

        <?php if(!isset($_SESSION['id'])){
    echo"<link href='./css/connect.css' rel='stylesheet'>";
 
          
      }
?>

        <!-- Ma feuille de style à moi -->

    </head>

    <body>

        <header>


                            <?php
        if (isset($_SESSION['id'])) {
            
               $notif=notif();
        
            echo"<ul class='facebook '>";
            echo"    <a class='fa fa-facebook-official' href='index.php?action=monmur'>Bonjour " . $_SESSION['login']."</a>";
            echo " <li class='facebook__brand' id='searchli' >";
         
            echo "  <form role='form' autocomplete='off'>
                    <input type='text' class='search' placeholder='Recherchez un amis' size='30' id='search'/>
                    </form>
                    <div id='display'></div> " ;
            echo " <li class='facebook__brand'><a class='fa fa-facebook-official' href='index.php?action=bio'>Ma Bio</a></li>";
            echo " <li class='facebook__brand'><a class='fa fa-facebook-official' href='index.php?action=monmur'>Mon mur</a></li>";
            echo " <li class='facebook__brand'><a class='fa fa-facebook-official' href='index.php?action=monprofile'>Mon Profil<p class='notif'>(".$notif[0].")</p></a></li>";
            echo " <li class='facebook__deco deco'><a class='fa fa-facebook-official' href='index.php?action=deconnexion'>Deconnexion</a></li>";
            echo'</ul>';
        }
        ?>

    
        </header>
        
   




        <div class="container">
            <?php
if (isset($_SESSION['info'])) {
    echo "<div class='alert alert-info alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button>
        <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
    unset($_SESSION['info']);
}
?>


     <?php  
    if(!isset($_SESSION['id'])){
       
        if(isset($_GET['action']) && $_GET['action']=='create'){
            
            include'./vues/create.php';
        }else{
            
            include'./vues/login.php';
   
        }
    } ?>


       




                
                        


                        
               



                <!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">-->

                <?php
               
                
                
            function phpAlert($msg) {
            echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
            //Affiche les erreurs 
            if(isset($_SESSION["error"]) && $_SESSION["error"] !== 0){
               phpAlert($_SESSION["error"]);         unset($_SESSION["error"]); } 
            // Quelle est l'action à faire ?
            if (isset($_GET["action"])) {
                $action = $_GET["action"];
               // var_dump($action);
                //exit();
                 $pattern = "/friendwall\?.*/";
                 
                 $pattern2 = "/bio\?.*/";
                if(preg_match($pattern,$action)){
                    //echo"Yes";
                    //exit();
                     $action= "friendwall";
                }elseif(preg_match($pattern2,$action)){
                     $action= "bio";
                }
            }
        
            else {
                $action = "accueil";
            }

            // Est ce que cette action existe dans la liste des actions
            if (array_key_exists($action, $listeDesActions) == false) {
                include("vues/404.php"); // NON : page 404
           
        
                }else{
                include($listeDesActions[$action]); // Oui, on la charge
                }
            

            ob_end_flush(); // Je ferme le buffer, je vide la mémoire et affiche tout ce qui doit l'être
            ?>



        </div>
        <?php include('./vues/footer.php')?>


        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>
