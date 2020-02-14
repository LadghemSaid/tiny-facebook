<?php
include("$_SERVER[DOCUMENT_ROOT]/tiny-facebook/tiny-facebook-project/config/bd.php");

   function getLikes($id)
{
  global $pdo;
  $sql = "SELECT COUNT(*) FROM rating_info
  		  WHERE post_id = ? AND rating_action='like'";
  $rs = $pdo->prepare($sql);
  $rs->execute(array($id));
  $result=$rs->fetch();
  echo $result[0];
}
   function getLikesCom($id)
{
  global $pdo;
  $sql = "SELECT COUNT(*) FROM rating_info_commentaire
  		  WHERE id_commentaire = ? AND action='like'";
  $rs = $pdo->prepare($sql);
  $rs->execute(array($id));
  $result=$rs->fetch();
  echo $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{
   global $pdo;
  $sql = "SELECT COUNT(*) FROM rating_info
  		  WHERE post_id = ? AND rating_action='dislike'";
  $rs = $pdo->prepare($sql);
  $rs->execute(array($id));
  $result=$rs->fetch();
  echo $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
   global $pdo;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM rating_info WHERE post_id = ? AND rating_action='like'";
  $dislikes_query = "SELECT COUNT(*) FROM rating_info
		  			WHERE post_id = ? AND rating_action='dislike'";
  $likes_rs = $pdo->prepare($likes_query);
  $dislikes_rs = $pdo->prepare($dislikes_query);
  $likes_rs->execute(array($id));
  $dislikes_rs->execute(array($id));
  $likes=$likes_rs->fetch();
  $dislikes=$dislikes_rs->fetch();
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  global $pdo;
  $user_id = $_SESSION['id'];
  $sql = "SELECT * FROM rating_info WHERE user_id=?
  		  AND post_id=? AND rating_action='like'";
  $result = $pdo->prepare($sql);
  $result->execute(array($user_id,$post_id));
  if ($result->fetch() > 0) {
  	return true;
  }else{
  	return false;
  }
}

//Check les commmentaire liker par l'user
function userLikedCom($post_id)
{
  global $pdo;
  $user_id = $_SESSION['id'];
  $sql = "SELECT * FROM rating_info_commentaire WHERE id_user_like=?
  		  AND id_commentaire=? AND action='like'";
  $result = $pdo->prepare($sql);
  $result->execute(array($user_id,$post_id));
  if ($result->fetch() > 0) {
  	return true;
  }else{
  	return false;
  }
}


// Check if user already dislikes post or not
function userDisliked($post_id)
{
  global $pdo;
  $user_id=$_SESSION['id'];
  $sql = "SELECT * FROM rating_info WHERE user_id=?
  		  AND post_id=? AND rating_action='dislike'";
  $result = $pdo->prepare($sql);
  $result->execute(array($user_id,$post_id));

  if ($result->fetch() > 0) {
  	return true;
  }else{
  	return false;
  }
}


 function humanTiming ($time){
    date_default_timezone_set('Europe/Paris');
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'an',
        2592000 => 'mois',
        604800 => 'semaine',
        86400 => 'jour',
        3600 => 'heure',
        60 => 'minute',
        1 => 'secondes'
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}



function me(){
    global $pdo;
    $sql = "SELECT * FROM user WHERE id=?";
    // Etape 1  : preparation
    $q1=$pdo->prepare($sql);
    // Etape 2 : execution : 2 paramètres dans la requêtes !!
    $q1->execute(array($_SESSION['id']));
    // Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
    $me = $q1->fetch();
     if($me['avatar']==null){
        $me['avatar']="user404.png";
        }
    return $me;
}


function recupCountCom($post){
    global $pdo;
    $sql = "SELECT COUNT(*) FROM commentaire WHERE idComment = ?";
    $q6 = $pdo->prepare($sql);
    $q6->execute(array($post));
    if($nbrcom=$q6->fetch()){
        //var_dump($nbrcom[0]);
        return $nbrcom[0];
    }
    
}

function recupAuteur($id){
    global $pdo;
    $sql = "SELECT * FROM user WHERE id=? ";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    if($auteur = $q->fetch()){
        return $auteur;
    }
    
}


function afficherpost($post,$auteur,$me,$nbrcom,$heure){
    //var_dump($post);
     echo"
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <section class='post-heading'>
                        <div class='row'>
                            <div class='col-md-11'>
                                <div class='media'>
                                    <div class='media-left'>
                                        <a href='index.php?action=friendwall?".$auteur['login']."'>
                                        <img class='media-object photo-profile' src='uploads/".$auteur['avatar']."' width='40' height='40' alt='...'>
                                        </a>
                                    </div>
                                    <div class='media-body'>
                                        <a href='index.php?action=friendwall?".$auteur['login']."' class='anchor-username'>
                                            <h4 class='media-heading'>".$auteur['login']."</h4>
                                        </a>
                                        <p  class='anchor-time'>Il y a ".$heure."</p>
                                    </div>
                                </div>
                            </div>";
                            
                        
 if($auteur['id']==$me['id']){
    $itsmypostdelete =" <a href='#' id='submitdeletepost'><i class='glyphicon glyphicon-remove'></i></a>";
}else{
    $itsmypostdelete =" <p class='badge badge-primary'>Amis</p>";
}

                    echo"<div class='col-md-1'>
                            <form action='index.php?action=deletepost' id='deletepostform' method='POST'>
                                <input type='hidden' name='idpostdelete' value=".$post['id']." />".$itsmypostdelete."
                            </form>
                        </div>";

                   echo "</div>
                    </section>
                    
                    <section class='post-body'>
                       
                        <p>".$post['contenu']."</p>";
                        
    if($post['image']!=null){
        $info = pathinfo("uploads/".$post['image']);
        //var_dump($info);
        if ($info["extension"] == "mp4"){
         echo "<video width='100%' height='100%'  autoplay='autoplay' muted loop>
                <source src='uploads/".$post['image']."' type='video/mp4'>
                Your browser does not support the video tag.
                </video> ";
                
            
        }else{
             
            echo " <img src='uploads/".$post['image']."'   style='width: 100%;'/>";}
           
        }
        
         echo "</section>
                    <section class='post-footer'>
                     
                        <hr>
                        <div class='post-footer-option container'>
                            <ul class='list-unstyled'>"; 
                

    if (userLiked($post['id'])){
      		                echo "<i class='glyphicon glyphicon-thumbs-up liked like-btn' data-id='".$post['id']."' ></i>";
    }else{
      		                echo "<i class='glyphicon glyphicon-thumbs-up like-btn' data-id='".$post['id']."'></i>";
    }

                             echo "<span class='likes'>";
                             echo getLikes($post['id']);
                             echo "</span>";

	   // <!-- if user dislikes post, style button differently -->

    if (userDisliked($post['id'])){
                             echo "<i class='glyphicon glyphicon-thumbs-down disliked dislike-btn' data-id='".$post['id']."' ></i>";
    }else{
      	                     echo "<i class='glyphicon glyphicon-thumbs-down dislike-btn' data-id='".$post['id']."' ></i>";
    }
                             echo "<span class='dislikes'>";
    echo getDislikes($post['id']);
                             echo "</span>";
    

                            echo "
                                <li><p  id='affichercomment".$post['id']."' onClick='afficherCom(".$post['id'].")' ><i class='glyphicon glyphicon-comment'></i> Commentaire (".$nbrcom[0].")</p></li>

                            </ul>
                        </div>

                    </section>
                </div>
            </div>";

}

function afficherCom($auteur,$com,$post){
  //var_dump($auteur);
  //var_dump($com);
  //var_dump($post);
    $heurecom=humanTiming(strtotime($com['datecom']));


    if($auteur['avatar']==null){
        $auteur['avatar']="user404.png";
    }


    //var_dump($auteurnomcom['avatar']);

    echo"

            <div class='wraper' >
                <div class='commentsection".$post." hided' >

                    <div class='box-comments'>
                        <div class='comment'><img src='uploads/".$auteur['avatar']."' alt='' />
                            <div class='content'>
                                <div class='media-body'>
                                    <a href='index.php?action=friendwall?".$auteur['login']."' class='anchor-username'>
                                        <h4 class='media-heading'>".$auteur['login']."</h4>
                                    </a>
                                    <p class='anchor-time'>".$heurecom."</p>
                                </div>";


    if (userLikedCom($com[0])){
      		 echo "  <i class='glyphicon glyphicon-thumbs-up like com-like liked' data-id='".$com[0]."' data-post='".$post."'></i>";
    }else{
      		  echo " <i class='glyphicon glyphicon-thumbs-up like com-like' data-id='".$com[0]."' data-post='".$post."'></i>";
    }


                                echo "
                                <span class='com-likes like'>";
    echo getLikesCom($com[0]);
   // var_dump($auteurnom[0]);
    echo "</span>

                                <p>".$com['content']."</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>";

                //var_dump($line['id']);
}
function ajouterCom($me,$post){
    //var_dump($post);
    //exit();
          echo"

                <div class='box-new-comment commentsection".$post['id']." hided'>
                    <img src='uploads/".$me['avatar']."' alt='' />
                    <div class='content'>
                          <form action='index.php?action=postacomment' method='POST' >
                        <div class='row'>
                            <input type='hidden' name='murde' value='".$_GET['action']."' />
                            <input type='hidden' name='whichcomment' value='".$post['id']."' />
                            <textarea name='contents' placeholder='Ecrire un commentaire...'></textarea>
                        </div>
                        <div class='row'>

                            <button type='submit' class='glyphicon glyphicon-pencil'></button>

                        </div>
                        </form>
                    </div>

                </div>
            ";
}

function recupCom($idPost){
    global $pdo;
    $sql = "SELECT * FROM commentaire c JOIN ecrit e ON e.id=c.idComment WHERE c.idComment=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($idPost));
    while($com = $q->fetch()){
        $auteur = recupAuteur($com['idAuteur']);
        afficherCom($auteur,$com,$idPost);
        
    }
}

function recupPosts($post,$moicompris){
    global $pdo;
    $me = me();
    //var_dump($post);
    /*
    if($moicompris){
        //$sql = "Select * From ecrit where idAuteurPost = ? OR idAuteurPost = ? order by dateEcrit desc";
        $sql = "Select * From ecrit where id= ? OR idAuteurPost = ? order by dateEcrit desc";
        $posts = $pdo->prepare($sql);
        $posts->execute(array($id,$me['id']));
    }else{
        $sql = "Select * From ecrit where idAuteurPost = ? order by dateEcrit desc";
        $posts = $pdo->prepare($sql);
        $posts->execute(array($id));
    }
    */
    
    if(!$moicompris){
        $auteur2 =  recupAuteur($id);
        //afficherwraperMD10();
        //postApost($auteur2,$moicompris,$me);
    }else{
        $auteur2 = recupAuteur($me);
        //afficherwraperMD10();
        //postApost($auteur2,$moicompris,$me);
    }
    
   // while($post=$posts->fetch()){
        $heure=humanTiming(strtotime($post['dateEcrit']));
        $auteur =  recupAuteur($post['idAuteurPost']);
        //var_dump($auteur);
        $nbrcom = recupCountCom($post['id']);
        afficherpost($post,$auteur,$me,$nbrcom,$heure);
        recupCom($post['id']);
        ajouterCom($me,$post);
    //}
}

function afficherwraperMD10(){
    echo "  <div class='dim' id='dim'></div>
    <div class='col-md-12'>";
}


function postApost($auteur,$moicompris,$me){
  
    if(!$moicompris){
           echo "
    
        <fieldset>
            <h1 class='col-xs-12 col-md-10'>Mur de ".$auteur['login']." <a href='index.php?action=bio?".$auteur['login']."' class='btn btn-primary btn-lg '>En savoir plus</a></h1>
            
        </fieldset>";
        
    }else{
        
    
    
    
    echo "
    
  
        <fieldset>
            <h1 class='col-xs-12 col-sm-7 col-md-10'>Mon Mur</h1>

            <form enctype='multipart/form-data' action='index.php?action=postapost' method='POST' id='usrform'>
                <div class='col-xs-12 col-sm-7 col-md-12' id='new_status'>
                    <ul class='navbar-nav col-xs-12' id='post_header'>
                        <li>





                        </li>
                    </ul>
                    <div class='col-xs-12' id='post_content'>
                        <img alt='profile picture' class='col-xs-1' src='uploads/".$me["avatar"]."'>
                        <div class='textarea_wrap'>
                            <textarea class='col-xs-11' name='content' form='usrform' placeholder='Quoi de neuf ?'></textarea>

                        </div>
                    </div>
                    <div class='col-xs-12' id='post_footer'>
                            <div class='dropZoneOverlay'>
                                <p>Ajoutez une photo
                                    <span class='glyphicon glyphicon-picture'></span></p>
                                <input type='file' name='file' id='file' />
                            </div>

                            <input type='hidden' name='whopost' id='whopost' value='".$me['id']."' />
                            <button type='submit' class='btn btn-primary'>Postez</button>
                        
                    </div>
                </div>
            </form>
        </fieldset>
        ";

    }
}
function pasdepost($monmur){
    if($monmur){
        echo"<div><h1>Vous n'avez aucun post.<h1></div>";
    }else{
        echo"<div><h1>Votre amis n'a aucun post.<h1></div>";
    }
}


function friendlist(){
    global $pdo;
    
    echo"<div class='col-md-12' id='friendlistwrap'>

        <a class='boutonfriend' href='index.php?action=bio'>Ma bio</a>
        <br/>
        <p class='boutonfriend' >Mes amis :</p>
        <ul id='friendlist'>";
$sql = "SELECT * FROM user u LEFT JOIN friends f on u.id=f.iduser WHERE isvalidate=1
                    AND ((f.iduser=? AND u.id != ?) OR ((f.idfriend=? AND u.id!=?)))";
$qamis = $pdo->prepare($sql);
$qamis->execute(array($_SESSION["id"],$_SESSION["id"],$_SESSION["id"],$_SESSION["id"]));
while ($result = $qamis->fetch()){
    echo"
    <form name='formdel' action='index.php?action=delfriendaction' method='POST'>
    <li style='
        display: inline-table;
    '><a href='index.php?action=friendwall?".$result['login']."'>".$result['login']."</a>
    
    <input type='hidden' name='friendname' id='friendname' value=".$result['login']." />
    
    <input type='hidden' name='monmur' value=".$monmur." />
    <button type='submit' class='btn btn-danger btn-sm' >X</button>
    </li>
            </form>
    ";
}
echo"</ul></div>";
}