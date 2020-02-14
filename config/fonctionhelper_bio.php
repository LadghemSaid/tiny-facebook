<?php
include("$_SERVER[DOCUMENT_ROOT]/tiny-facebook/tiny-facebook-project/config/bd.php");

function interestlist($list){
    $keywords = preg_split("/,/", $list);
    
    echo "<ul class='interest_ul'>";
    foreach($keywords as $item){
        echo "<li class='interest_li'>$item</li>";
    }
    echo "</ul>";
}
function musicstyle($list,$fav){
    $keywords = preg_split("/,/", $list);
    //var_dump($keywords);
    //var_dump($list);
    //var_dump (strtolower($fav));
    //var_dump(array_search(strtolower($fav), $keywords));
     echo "<ul class='music_ul'>";
     if($fav!=null){
        if (array_search(strtolower($fav), array_map('strtolower', $keywords))!== FALSE) {
            echo "<li class='music_li'>".$fav."<img src='uploads/loved.png' width =20px height=20px/></li>";
            $i = array_search(strtolower($fav), array_map('strtolower', $keywords));
            unset($keywords[$i]);
        }else{
            
            echo "<li class='music_li'>".$fav."<img src='uploads/loved.png' width =20px height=20px/></li>";
        }
     }
      foreach($keywords as $item){
        echo "<li class='music_li'>$item</li>";
    }
    echo "</ul>";
}

function recupbio($id,$mabio,$amis){
    global $pdo;
    //debuging
    /*
    echo"* from USER de la personne qui invoque la fonction : ";
    var_dump($id);
    echo "Somme nous amis  : ";
    var_dump($amis);
    echo "Cette page est ma bio : ";
    var_dump($mabio);
    */
    //debuging
    if($mabio){
              $sql = "SELECT * FROM info_user WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id['id']));
        
        //var_dump($id);
        if($info_user = $q->fetch()){
            $sql = "SELECT * FROM user WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($info_user['id']));
            $user=$q->fetch();
            
            
             
            if($info_user['genre'] == "homme"){
                $genre = " <img src='uploads/homme.png' width='50px' height='50px;'/>";
            }elseif($info_user['genre']=="femme"){
               $genre = " <img src='uploads/femme.png' width='50px' height='50px;'/>";
            }elseif($info_user['genre']=="autre"){
                $genre = " <img src='uploads/autre.png' width='50px' height='50px;'/>";
            }
            if($user['lastco'] !== "0000-00-00 00:00:00" ){
                $userlastseen=humanTiming(strtotime($user['lastco']));;
                
            }else{
                $userlastseen = "Tres longtemps";
            }
            //$info_user contient les info de la personne passer en id
            //var_dump($info_user);
                       echo"  
    <article class='card-60 social'>
        <figure>
         
          <img src='uploads/".$user['avatar']."' alt='Profil pic'>
        </figure>
        <!-- end figure-->
        <div class='flex-content'>
          <header>
            <p class='user'>
             
              <img class='avatar-32' src='uploads/".$user['avatar']."' alt='Avatar'>
              <strong>
    					<a title='Full Name' href='#' style='text-transform:uppercase;'>
    					 ".$info_user['nom']."  ".$info_user['prenom']."
    					</a>
    			</strong>
    			
              <span>Vu il y a :<bold>".$userlastseen."</bold> · France · ".$info_user['age']." ans  </span>
              
                <p class='badge badge-primary btn-amis'>Moi</p>
              
            </p>
            
          </header>
          <h2>
    Presentation
    		</h2>
          <p>
            ".$info_user['description']."
          </p>
          <footer>
          <ul class='relation_job_ul'>
          <li class='relation_job_li'>
            <p>
              ".$genre."
            </p>
            </li>
            <li class='relation_job_li'>
              <p>".$info_user['relationship']." </p> 
              </li>
              <li class='relation_job_li'>
              <p>".$info_user['status']."</p>
              </li>
             </ul>
              ";
            //Insertion de la preference musicale
            
            
            if($info_user['music_style'] != '' ){
                if($info_user['favorite_music_style']!=""){
                    $fav = $info_user['favorite_music_style'];
                }else{
                    $fav = null;
                }
                    echo "<h2>Gout musicaux</h2>";
                 musicstyle($info_user['music_style'],$fav);
            }
            
            //decoupage du echo pour inserer le interest   
                if($info_user['interest'] != '' ){
                    echo "<h2>Centres d'interet</h2>";
                 interestlist($info_user['interest']);
            }
            
         
            
            //fin du decoupage  
        echo  "
            </footer>
        </div>
        
      </article>";
    }        
    
        

    }
    if($amis){
      
        $sql = "SELECT * FROM info_user WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id['id']));
        date_default_timezone_set('Europe/Paris');
        $date = date('m/d/Y h:i:s a', time());
       //echo $date;
        
        if($info_user = $q->fetch()){
            $sql = "SELECT * FROM user WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($info_user['id']));
            $user=$q->fetch();
            
            
            
            if($info_user['genre'] == "homme"){
                $genre = " <img src='uploads/homme.png' width='50px' height='50px;'/>";
            }elseif($info_user['genre']=="femme"){
               $genre = " <img src='uploads/femme.png' width='50px' height='50px;'/>";
            }elseif($info_user['genre']=="autre"){
                $genre = " <img src='uploads/autre.png' width='50px' height='50px;'/>";
            }
            if($user['lastco'] !== "0000-00-00 00:00:00" ){
                $userlastseen=humanTiming(strtotime($user['lastco']));;
                
            }else{
                $userlastseen = "Tres longtemps";
            }
           
            //var_dump($keywords);
        
            //$info_user contient les info de la personne passer en id
            //var_dump($info_user);
             echo"  
    <article class='card-60 social'>
        <figure>
         
          <img src='uploads/".$user['avatar']."' alt='Profil pic'>
        </figure>
        <!-- end figure-->
        <div class='flex-content'>
          <header>
            <p class='user'>
             
              <img class='avatar-32' src='uploads/".$user['avatar']."' alt='Avatar'>
              <strong>
    					<a title='Full Name' href='#' style='text-transform:uppercase;'>
    					 ".$info_user['nom']."  ".$info_user['prenom']."
    					</a>
    			</strong>
    			
              <span>Vu il y a :<bold>".$userlastseen."</bold> · France · ".$info_user['age']." ans  </span>
               <p class='badge badge-primary btn-amis'>Amis</p>
            </p>
            
          </header>
          <h2>
    Presentation
    		</h2>
          <p>
            ".$info_user['description']."
          </p>
          <footer>
          <ul class='relation_job_ul'>
          <li class='relation_job_li'>
            <p>
              ".$genre."
            </p>
            </li>
            <li class='relation_job_li'>
              <p>".$info_user['relationship']." </p> 
              </li>
              <li class='relation_job_li'>
              <p>".$info_user['status']."</p>
              </li>
             </ul>
              ";
            //Insertion de la preference musicale
            if($info_user['music_style'] != '' ){
                if($info_user['favorite_music_style']!=""){
                    $fav = $info_user['favorite_music_style'];
                }else{
                    $fav = null;
                }
                    echo "<h2>Gout musicaux</h2>";
                 musicstyle($info_user['music_style'],$fav);
            }
            
            //decoupage du echo pour inserer le interest   
                if($info_user['interest'] != '' ){
                    echo "<h2>Centres d'interet</h2>";
                 interestlist($info_user['interest']);
            }
            
         
            
            //fin du decoupage  
        echo  "
            </footer>
        </div>
        
      </article>";
        
            
        }
        
    }
    if(!$amis && !$mabio){
        $sql = "SELECT * FROM info_user WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id['id']));
        
        //var_dump($id);
        if($info_user = $q->fetch()){
            $sql = "SELECT * FROM user WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($info_user['id']));
            $user=$q->fetch();
            
            
             
            if($info_user['genre'] == "homme"){
                $genre = " <img src='uploads/homme.png' width='50px' height='50px;'/>";
            }elseif($info_user['genre']=="femme"){
               $genre = " <img src='uploads/femme.png' width='50px' height='50px;'/>";
            }elseif($info_user['genre']=="autre"){
                $genre = " <img src='uploads/autre.png' width='50px' height='50px;'/>";
            }
            if($user['lastco'] !== "0000-00-00 00:00:00" ){
                $userlastseen=humanTiming(strtotime($user['lastco']));;
                
            }else{
                $userlastseen = "Tres longtemps";
            }
            //$info_user contient les info de la personne passer en id
            //var_dump($info_user);
                       echo"  
    <article class='card-60 social'>
        <figure>
         
          <img src='uploads/".$user['avatar']."' alt='Profil pic'>
        </figure>
        <!-- end figure-->
        <div class='flex-content'>
          <header>
            <p class='user'>
             
              <img class='avatar-32' src='uploads/".$user['avatar']."' alt='Avatar'>
              <strong>
    					<a title='Full Name' href='#' style='text-transform:uppercase;'>
    					 ".$info_user['nom']."  ".$info_user['prenom']."
    					</a>
    			</strong>
    			
              <span>Vu il y a :<bold>".$userlastseen."</bold> · France · ".$info_user['age']." ans  </span>
              
                <form name='form-search' class='myform2' action='index.php?action=addfriendaction' method='POST'>
        <input type='hidden' class='friendname' name='friendname' value='".$user['login']."' />
        <button type='submit' id='addfriend' class='btn btn-success btn-sm btn-amis2'>Envoyer une demande</button>
        </form>
              
            </p>
            
          </header>
          <h2>
    Presentation
    		</h2>
          <p>
            ".$info_user['description']."
          </p>
          <footer>
          <ul class='relation_job_ul'>
          <li class='relation_job_li'>
            <p>
              ".$genre."
            </p>
            </li>
            <li class='relation_job_li'>
              <p>".$info_user['relationship']." </p> 
              </li>
              <li class='relation_job_li'>
              <p>".$info_user['status']."</p>
              </li>
             </ul>
              ";
            //Insertion de la preference musicale
            if($info_user['music_style'] != '' ){
                if($info_user['favorite_music_style']!=""){
                    $fav = $info_user['favorite_music_style'];
                }else{
                    $fav = null;
                }
                    echo "<h2>Gout musicaux</h2>";
                 musicstyle($info_user['music_style'],$fav);
            }
            
            //decoupage du echo pour inserer le interest   
                if($info_user['interest'] != '' ){
                    echo "<h2>Centres d'interet</h2>";
                 interestlist($info_user['interest']);
            }
            
         
            
            //fin du decoupage  
        echo  "
            </footer>
        </div>
        
      </article>";
    }        
    }
        

    
}
function recupinfobio(){
    global $pdo;
    $sql = "SELECT * FROM info_user WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($_SESSION['id']));
    if($info_user = $q->fetch()){
        //On a recupére les info de l'user dans $info_user
        //var_dump($info_user);
        return $info_user;
    }
}