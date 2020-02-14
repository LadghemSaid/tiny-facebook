<?php

include("../config/fonctionhelper.php");
include "../config/bd.php";
if(!check_login()){
session_start();
}
//Getting value of "search" variable from "script.js".
 
if (isset($_POST['search'])) {
 
//Search box value assigning to $Name variable.
 
 $Name = $_POST['search'];
 
//Search query.
 
$sql = "SELECT login FROM user WHERE login LIKE '%$Name%' LIMIT 5";
 
//Query execution
 
$q = $pdo->prepare($sql);

// Etape 2 : execution : 2 paramètres dans la requêtes !!
$q->execute();
$pasamis=false;
$notfound=false;
$listeFriend=[];
//Creating unordered list to display result.
 
 echo "<ul>";
   //Fetching result from database.
       $resultAjax = $q->fetch()     
 
    // var_dump($resultAjax);
 
        

        //Pour chaque resulat de la recherche :
       ?>
  
        <li>



            <?php  echo "<a class='searchebar_result' href ='index.php?action=friendwall?".$resultAjax["login"]."'>".$resultAjax["login"]."</a>"; //Resultat de la recherche AJAX?>

            <?php

            $sql = "SELECT login FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.iduser = ? AND f.isvalidate=1"; //Renvoie liste des nom AMIS de la personne connecté 
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION["id"]));
            while ($result = $q->fetch()){ 
                // pour chaque amis renvoie 
                $listeFriend[] = $result;
                }

    $array=[];
    //var_dump($array);
    foreach($listeFriend as $elem){
        foreach($elem as $friend){  
           $array = array_unique (array_merge ($elem, $array));
        }
    }
                //var_dump($resultAjax);
                if(in_array($resultAjax["login"],$array)){
               ?>
                <form name='form-search' class='myform' action='index.php?action=delfriendaction' method='POST'>
                    <?php
                echo "<input type='hidden' name='friendname' id='friendname' value='".$resultAjax['login']."' />";
                echo "<button type='button' class='btn btn-secondary btn-sm' disabled>Déja amis</button>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Supprimer</button>";   
                ?></form>
                <?php
                }else{
                   $pasamis=true;  
                }
                
                if(!$resultAjax){
                  $notfound=true;
                 }

$sql = "SELECT * FROM user u INNER JOIN friends f on f.iduser = u.id WHERE f.idfriend = ? AND f.isvalidate IS NULL OR f.iduser = ? AND f.isvalidate IS NULL"; //Renvoie liste des nom des demande d'amitie de la personne co
$q5 = $pdo->prepare($sql);
$q5->execute(array($_SESSION["id"],$_SESSION["id"]));
$pasderequete=true;
while ($result = $q5->fetch()){ 
    //var_dump($result);
    if ($result['login']==$resultAjax["login"]){
       // var_dump($resultAjax);
        $pasderequete = false;
    }
    
}
    
    
    if($notfound){
        $pasamis=false;  
        echo"Nous n'avons personne à ce nom désolé :(";
    } 
    
    if($pasamis && $resultAjax['login'] != $_SESSION['login']  && $pasderequete){
        
        ?>
                    <form name='form-search' class="myform" action='index.php?action=addfriendaction' method='POST'>
                        <?php
                  
        echo "<input type='hidden' class='friendname' name='friendname' value='".$resultAjax['login']."' />";
          echo "<button type='submit' id='addfriend' class='btn btn-success btn-sm'>Envoyer une demande</button>";  
        ?>
                            <?php
    }
    if(!$pasderequete){
        echo"
<a href='index.php?action=friendwall?".$resultAjax['login']."'>".$resultAjax['login']."</a>

<form name='formaccept' action='index.php?action=acceptfriendaction' method='POST' style='display:inline'>
<input type='hidden' name='friendname' id='friendname' value='".$resultAjax['login']."' />
<button type='submit' class='btn btn-success btn-sm floatbtn' >Accepter</button> 
        </form>
        
        <form name='formrefuse' action='index.php?action=refusefriendaction' method='POST' style='display:inline'>
<input type='hidden' name='friendname' id='friendname' value='".$resultAjax['login']."' />
<button type='submit' class='btn btn-danger btn-sm floatbtn' >Refuser</button> 
        </form>

    
    

";
    }
                
           
                
            
            ?>



                    </form>

        </li>


        <?php
 

}
 
 
?>

    </ul>
