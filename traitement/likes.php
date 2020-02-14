<?php
session_start();
include "../config/bd.php";

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
function getRatingCom($id)
{
  global $pdo;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM rating_info_commentaire WHERE id_commentaire = ? AND action='like'";
 
  $likes_rs = $pdo->prepare($likes_query);
 
  $likes_rs->execute(array($_POST['com_id']));
  
  $likes=$likes_rs->fetch();
 
  $rating = [
  	'likes' => $likes[0],
  ];
  return json_encode($rating);
}




if (isset($_POST['action'])) {
$user_id=$_SESSION['id'];
  $post_id = $_POST['post_id'];
  $com_id = $_POST['com_id'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'like':
         $sql="INSERT INTO rating_info (user_id, post_id, rating_action) 
         	   VALUES (?,?, 'like') 
         	   ON DUPLICATE KEY UPDATE rating_action='like'";
         	    $q = $pdo->prepare($sql);
                $q->execute(array($user_id,$post_id));
         break;
  	case 'dislike':
          $sql="INSERT INTO rating_info (user_id, post_id, rating_action) 
               VALUES (?,?, 'dislike') 
         	   ON DUPLICATE KEY UPDATE rating_action='dislike'";
         	   $q = $pdo->prepare($sql);
         	   $q->execute(array($user_id,$post_id));
         break;
  	case 'unlike':
	      $sql="DELETE FROM rating_info WHERE user_id=? AND post_id=?";
	       $q = $pdo->prepare($sql);
	       $q->execute(array($user_id,$post_id));
	      break;
  	case 'undislike':
      	  $sql="DELETE FROM rating_info WHERE user_id=? AND post_id=?";
      	   $q = $pdo->prepare($sql);
      	   $q->execute(array($user_id,$post_id));
      break;
      	case 'like-com':
      	 $sql="SELECT * FROM rating_info_commentaire WHERE id_post_p = ? AND id_commentaire = ? AND id_user_like = ? AND action='like' "; 
      	 $q = $pdo->prepare($sql);
         $q->execute(array($post_id,$com_id,$user_id));
         if($res=$q->fetch()){
            echo getRatingCom($post_id);
            exit(0);
         }else{
      	    
         $sql="INSERT INTO rating_info_commentaire (id_post_p, id_commentaire,id_user_like,action) 
         	   VALUES (?,?, ?,'like')ON DUPLICATE KEY UPDATE action='like'";
         	    $q = $pdo->prepare($sql);
                $q->execute(array($post_id,$com_id,$user_id));
                echo getRatingCom($post_id);
                exit(0);
             
         }
         break;
      	    
  	case 'unlike-com':
          $sql="DELETE FROM rating_info_commentaire  WHERE id_user_like=? AND id_post_p= ? AND id_commentaire= ? ";
         	    $q = $pdo->prepare($sql);
         	    $q->execute(array($user_id,$post_id,$com_id));
         	    echo getRatingCom($post_id);
                exit(0);
         break;
      
  	default:
  		break;
  }



  
  echo getRating($post_id);
  exit(0);
}
  
  
  
header('Content-type: application/json');
  //$r["json"] = json_encode($r);
  //echo json_encode($r);
  //json_encode($post_id);
//header('Location: index.php?action=monmur');
