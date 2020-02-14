<?php
  if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }

function recommendation($id){
    global $pdo;
    $sql = "SELECT * FROM user u LEFT JOIN friends f on u.id=f.iduser WHERE isvalidate=1
                    AND ((f.iduser=? AND u.id != ?) OR ((f.idfriend=? AND u.id!=?)))"; 
    
    $q = $pdo->prepare($sql);
    $q->execute(array($id,$id,$id,$id));
    
   //var_dump($id);
        echo "<p>Vous connaisser peut etre:</p>
              <ul id ='recommendation'>";
              $amiscommun = array();
              $denominateur = array();
        while($line = $q->fetch()){
           // echo $line['id'].$line['login'];
        //recupération de la liste des amis
                //echo "<li>".$line['login']." est amis";
        // "select * from friends where iduser in(select GROUP_CONCAT(iduser) form user u JOIN friends f where f.iduser = u.id and u.id= $uid) AND id NOT IN(select GROUP_CONCAT(id) from friends where id = $id)";
        //Pour chaque amis recupération de leur liste d'amis egalement 
        //var_dump($line);
        $sql = "SELECT * FROM user u LEFT JOIN friends f on u.id = f.iduser WHERE isvalidate=1 AND u.id != ?
                    AND ((f.iduser=? AND u.id != ?) OR (f.idfriend=? AND u.id!=?))
					AND u.id NOT IN (SELECT u.id FROM user u LEFT JOIN friends f on u.id=f.iduser WHERE isvalidate=1
                    AND ((f.iduser=? AND u.id != ?) OR (f.idfriend=? AND u.id!=?)))"; 
        $q2 = $pdo->prepare($sql);
        $q2->execute(array($id,$line['id'],$line['id'],$line['id'],$line['id'],$id,$id,$id,$id,));
        //COUNT de nombre de d'amis en commun
       
           $amis=array();
            while($line2=$q2->fetch()){
                
               $amis[$line['login']][] = array($line2['login']) ;
               $amiscommunnbr[$line2['login']][] = $line['login'] ;
               //Stockage a chaque iteration de boucle des amis commun dans un tableau
            }
        }
        
        $newarray = $amiscommunnbr;
        
        if(!empty($newarray)){
        //comptage et affichage de l'amis commun si un minimum est atteint 
    
            foreach($newarray as $key => $value){
                
                //var_dump($key);
                //var_dump($nbr);
                $nbr = count($value);
                echo "<li><a href='index.php?action=bio?".$key."'>".$key."</a> - ".$nbr." Amis en commun(";
                foreach($value as $key2 => $value2){
                //var_dump($value2);
                    echo "<a class='amiscommun' href='index.php?action=bio?".$value2."'>".$value2."</a>";

                    //var_dump($value2);
                    echo "<a href='index.php?action=bio?".$value2."'>".$value2."</a>";
                    
                }
                echo ")</li>";
              
            }
        }
        echo "</ul>";
    }


?>
    <div class="dim" id="dim"></div>
    <div class="col-md-6">
        <fieldset>
            <legend>
                <h1>Mon Profil</h1>
            </legend>

            <?php

include("$_SERVER[DOCUMENT_ROOT]/tiny-facebook/tiny-facebook-project/config/fonctionhelper_bio.php");
            
$sql = "SELECT * FROM user WHERE id=?";

// Etape 1  : preparation
$q = $pdo->prepare($sql);

// Etape 2 : execution : 2 paramètres dans la requêtes !!
$q->execute(array($_SESSION['id']));

// Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
$line = $q->fetch();
   
// REQUETE Pour la liste des gens DEJA amis
$sql = "SELECT * FROM user u LEFT JOIN friends f on u.id=f.iduser WHERE isvalidate=1
                    AND ((f.iduser=? AND u.id != ?) OR ((f.idfriend=? AND u.id!=?)))";  //Renvoie liste des nom AMIS de la personne connecté 
$q2 = $pdo->prepare($sql);
$q2->execute(array($_SESSION["id"],$_SESSION["id"],$_SESSION["id"],$_SESSION["id"]));
         
            
            
?>


                <div class="image-upload">

                    <label for="file-input"><?php
                   if($line['avatar'] != null){
    echo ("<img id='imgpp' src='uploads/".$line['avatar']."'/>");
}else{
    echo ("<p>Vous n'avez pas de photo pour l'instant</p>");
}

?>
                    <div class="overlay">
                <p id="modifyprofilepic">Modifier</p>

                </div>
                        </label>
                </div>
        </fieldset>

        <form enctype="multipart/form-data" role="form" action="index.php?action=upload" method="POST">

            <input type="file" name="fileToUpload" id="file-input" />
            <input type="hidden" name="profil" value="yes" id="file-input" />
            <input type="submit" name="sub" id="submit" class="btn btn-success btn-lg" value="Envoyer" />
        </form>

    </div>
    <div class="col-md-6">
        <p>Mes amis:</p>
        <ul id="friendlist">
            <?php
while ($result = $q2->fetch()){ 
echo"
<form name='formdel' action='index.php?action=delfriendaction' method='POST'>
<li><a href='index.php?action=friendwall?".$result['login']."'>".$result['login']."</a>
    
<input type='hidden' name='friendname' id='friendname' value=".$result['login']." />
<button type='submit' class='btn btn-danger btn-sm floatbtn' >Supprimer</button> 
</li>
        </form>
    
    

";}

$sql = "SELECT login FROM user u INNER JOIN friends f on f.iduser = u.id WHERE f.isvalidate IS NULL AND (f.idfriend = ? AND f.idfriend = ? )"; //Renvoie liste des nom AMIS de la personne connecté 
$q4 = $pdo->prepare($sql);
$q4->execute(array($_SESSION["id"],$_SESSION["id"]));
while($res = $q4->fetch()){

echo"

<li><a href='index.php?action=friendwall?".$res['login']."'>".$res['login']."</a>

<form name='formaccept' action='index.php?action=acceptfriendaction' method='POST' style='display:inline'>
<input type='hidden' name='friendname' id='friendname' value=".$res['login']." />
<button type='submit' class='btn btn-success btn-sm floatbtn' >Accepter</button> 
        </form>
        
        <form name='formrefuse' action='index.php?action=refusefriendaction' method='POST' style='display:inline'>
<input type='hidden' name='friendname' id='friendname' value=".$res['login']." />
<button type='submit' class='btn btn-danger btn-sm floatbtn' >Refuser</button> 
        </form>
</li>
    
    

";
}
            
?>
        </ul>
        <p>Mes demandes amis en attente:</p>
        <ul id ="attentes">
            <?php

            
$sql = "SELECT login FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.iduser = ? AND f.isvalidate IS NULL"; //Renvoie liste des nom des demande d'amitie de la personne co
$q5 = $pdo->prepare($sql);
$q5->execute(array($_SESSION["id"]));
while ($result = $q5->fetch()){ 
echo"
<form name='formdel' action='index.php?action=delfriendaction' method='POST'>
<li><a href='index.php?action=friendwall?".$result['login']."'>".$result['login']."</a>
    
<input type='hidden' name='friendname' id='friendname' value=".$result['login']." />
<button type='submit' class='btn btn-secondary btn-sm floatbtn' disabled>En attente de validation</button> 
</li>
        </form>
    
    

";}  
$sql = "SELECT login FROM user u INNER JOIN friends f on f.idfriend = u.id WHERE f.iduser = ? AND f.isvalidate=0"; //Renvoie liste des nom AMIS de la personne connecté qui ont refusé l'invite
$q6 = $pdo->prepare($sql);
$q6->execute(array($_SESSION["id"]));
while ($result = $q6->fetch()){ 
echo"
<form name='formdel' action='index.php?action=delfriendaction' method='POST'>
<li><a href='index.php?action=friendwall?".$result['login']."'>".$result['login']."</a>
<button type='submit' class='btn btn-secondary btn-sm floatbtn' disabled>Refusé</button> 
</li>
        </form>
    
    

";
    
}  
    $info_user = recupinfobio();
   
            
            ?>
        </ul>
        <?php
        //Section vous connaisser peut etre
        
      
        recommendation($_SESSION['id']);
        
        ?>
        
        
        <button class="btn btn-primary toggle">Mes informations</button>
        <div class="search-box" id="target">
          
               
                    <form class="form-card" role="form" action="index.php?action=updateinfo" method="POST">
    <fieldset class="form-fieldset">
        <legend class="form-legend">En savoir plus sur moi </legend>
          
      
        <div class="form-element form-input">
            <input name="nom" id="field-omv6eo-metm0n-5j55wv-w3wbws-6nm2b9" class="form-element-field" placeholder="Merci d'entrer votre nom" value="<?php if($info_user['nom']!=null){echo $info_user['nom'];} ?>" type="input" required/>
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="field-omv6eo-metm0n-5j55wv-w3wbws-6nm2b9">Nom *</label>
        </div>
           <div class="form-element form-input">
            <input name="prenom" id="field-omv6eo-metm0n-5j55wv-w3wbws-6nm2b9" class="form-element-field" placeholder="Merci d'entrer votre prenom" value="<?php if($info_user['prenom']!=null){echo $info_user['prenom'];} ?>" type="input" required/>
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="field-omv6eo-metm0n-5j55wv-w3wbws-6nm2b9">Prenom *</label>
        </div>
        <div class="form-element form-input">
            <input name="age" id="field-x98ezh-s6s2g8-vfrkgb-ngrhef-atfkop" class="form-element-field -hasvalue" placeholder=" " type="number" min="16" type="number" required value="<?php if($info_user['age']!=null){echo $info_user['age'];} ?>" />
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="field-x98ezh-s6s2g8-vfrkgb-ngrhef-atfkop">Votre age *</label>
        </div>
          <div class="form-element form-textarea">
            <textarea name="description" id="field-3naeph-0f3yuw-x153ph-dzmahy-qhkmgm" class="form-element-field" placeholder="Une courte bio fera l'affaire"  required><?php if($info_user['description']!=null){echo $info_user['description'];} ?></textarea>
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="field-3naeph-0f3yuw-x153ph-dzmahy-qhkmgm">Presentez vous *:</label>

        </div>
          <div class="form-element form-select">
            <select name=status  id="field-be1h8i-ll2hpg-q4efzm-nfjj1e-udkw5r" class="form-element-field" required>
                <option  disabled selected value="" class="form-select-placeholder" ></option>
                <option value="Etudiant" <?php if($info_user['status']!=null && $info_user['status'] == "Etudiant"){echo "selected";} ?>>Etudiant</option>
                <option value="Salarie"  <?php if($info_user['status']!=null && $info_user['status'] == "Salarie"){echo "selected";} ?>>Salarie</option>
                <option value="Auto-entrepreneur"  <?php if($info_user['status']!=null && $info_user['status'] == "Auto-entrepreneur"){echo "selected";} ?>>Auto-entrepreneur</option>
                <option value="Rien"  <?php if($info_user['status']!=null && $info_user['status'] == "Rien"){echo "selected";} ?>>Rien</option>
                <option value="Beaucoup de choses"  <?php if($info_user['status']!=null && $info_user['status'] == "Beaucoup de choses"){echo "selected";} ?>>Beaucoup de choses</option>
            </select>
            <label class="form-element-label" for="field-be1h8i-ll2hpg-q4efzm-nfjj1e-udkw5r">Que faites vous dans la vie *:</label>
            <div class="form-element-bar"></div>
        </div>
         <div class="form-radio form-radio-inline">
            <div class="form-radio-legend">Genre *</div>
            <label class="form-radio-label">
                <input name=genre class="form-radio-field" type="radio" required value="homme"  <?php if($info_user['genre']!=null && $info_user['genre'] == "homme"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Homme</span>
            </label>
            <label class="form-radio-label">
                <input name=genre class="form-radio-field" type="radio" required value="femme"<?php if($info_user['genre']!=null && $info_user['genre'] == "femme"){echo "checked";} ?> />
                <i class="form-radio-button"></i>
                <span>Femme</span>
            </label>
            <label class="form-radio-label">
                <input name=genre class="form-radio-field" type="radio" required value="autre" <?php if($info_user['genre']!=null && $info_user['genre'] == "autre"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Autre</span>
            </label>
            <label class="form-radio-label">
                <input name=genre class="form-radio-field" type="radio" required value="none" <?php if($info_user['genre']!=null && $info_user['genre'] == "none"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Secret</span>
            </label>
            <small class="form-element-hint">Test anti-sjw</small>
        </div>
        <div class="form-checkbox form-checkbox-inline">
            <div class="form-checkbox-legend">Quelle genre de musique tu aime ?</div>
            <label class="form-checkbox-label">
                <input name=rap class="form-checkbox-field" type="checkbox" <?php if($info_user['music_style']!=null && $info_user['music_style']!= "" && strpos($info_user['music_style'],"rap")!== false){echo "checked";} ?>/>
                <i class="form-checkbox-button"></i>
                <span>Rap</span>
            </label>
            <label class="form-checkbox-label">
                <input name=pop class="form-checkbox-field" type="checkbox" <?php if($info_user['music_style']!=null && $info_user['music_style']!= "" && strpos($info_user['music_style'],"pop")!== false){echo "checked";} ?>/>
                <i class="form-checkbox-button"></i>
                <span>Pop</span>
            </label>
            <label class="form-checkbox-label">
                <input name=rock class="form-checkbox-field" type="checkbox" <?php if($info_user['music_style']!=null && $info_user['music_style']!= "" && strpos($info_user['music_style'],"rock")!== false){echo "checked";} ?>/>
                <i class="form-checkbox-button"></i>
                <span>Rock</span>
            </label>
            <label class="form-checkbox-label">
                <input name=metal class="form-checkbox-field" type="checkbox" <?php if($info_user['music_style']!=null && $info_user['music_style']!= "" && strpos($info_user['music_style'],"metal")!== false){echo "checked";} ?>/>
                <i class="form-checkbox-button"></i>
                <span>Metal</span>
            </label>
            <label class="form-checkbox-label">
                <input name=r_b class="form-checkbox-field" type="checkbox" <?php if($info_user['music_style']!=null && $info_user['music_style']!= "" && strpos($info_user['music_style'],"rnb")!== false){echo "checked";} ?>/>
                <i class="form-checkbox-button"></i>
                <span>R&amp;B</span>
            </label>
        </div>
        <div class="form-element form-select">
            <select name=favorite_music_style  id="field-be1h8i-ll2hpg-q4efzm-nfjj1e-udkw5r" class="form-element-field" >
                <option disabled selected value="" class="form-select-placeholder"></option>
                <option value="Rap" <?php if($info_user['favorite_music_style']!=null && $info_user['favorite_music_style'] == "Rap"){echo "selected";} ?>>Rap</option>
                <option value="Pop" <?php if($info_user['favorite_music_style']!=null && $info_user['favorite_music_style'] == "Pop"){echo "selected";} ?>>Pop</option>
                <option value="Rock" <?php if($info_user['favorite_music_style']!=null && $info_user['favorite_music_style'] == "Rock"){echo "selected";} ?>>Rock</option>
                <option value="Metal" <?php if($info_user['favorite_music_style']!=null && $info_user['favorite_music_style'] == "Metal"){echo "selected";} ?>>Metal</option>
                <option value="RnB" <?php if($info_user['favorite_music_style']!=null && $info_user['favorite_music_style'] == "RnB"){echo "selected";} ?>>R&amp;B</option>
            </select>
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="field-be1h8i-ll2hpg-q4efzm-nfjj1e-udkw5r">Mais tu préfére :</label>
        </div>
        <div class="form-radio form-radio-block">
            <div class="form-radio-legend">Je suis plutot…</div>
            <label class="form-radio-label">
                <input name=food class="form-radio-field" type="radio" value="Vegan" <?php if($info_user['food']!=null && $info_user['food'] == "Vegan"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Vegan</span>
            </label>
            <label class="form-radio-label">
                <input name=food class="form-radio-field" type="radio" value="Végétarien" <?php if($info_user['food']!=null && $info_user['food'] == "Végétarien"){echo "checked";} ?> />
                <i class="form-radio-button"></i>
                <span>Végétarien</span>
            </label>
            <label class="form-radio-label">
                <input name=food class="form-radio-field" type="radio" value="Omnivore" <?php if($info_user['food']!=null && $info_user['food'] == "Omnivore"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Omnivore</span>
            </label>
            <label class="form-radio-label">
                <input name=food class="form-radio-field" type="radio" value="Carnivore" <?php if($info_user['food']!=null && $info_user['food'] == "Carnivore"){echo "checked";} ?> />
                <i class="form-radio-button"></i>
                <span>Carnivore</span>
            </label>
        </div>
          <div class="form-radio form-radio-block">
            <div class="form-radio-legend">Relationship …</div>
            <label class="form-radio-label">
                <input name=relation class="form-radio-field" type="radio" value="En couple" <?php if($info_user['relationship']!=null && $info_user['relationship'] == "En couple"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>En couple</span>
            </label>
            <label class="form-radio-label">
                <input name=relation class="form-radio-field" type="radio" value="Marié" <?php if($info_user['relationship']!=null && $info_user['relationship'] == "Marié"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Marié</span>
            </label>
            <label class="form-radio-label">
                <input name=relation class="form-radio-field" type="radio" value="Célibataire" <?php if($info_user['relationship']!=null && $info_user['relationship'] == "Célibataire"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>Célibataire</span>
            </label>
            <label class="form-radio-label">
                <input name=relation class="form-radio-field" type="radio" value="Compliqué" <?php if($info_user['relationship']!=null && $info_user['relationship'] == "Compliqué"){echo "checked";} ?>/>
                <i class="form-radio-button"></i>
                <span>C'est compliqué</span>
            </label>
        </div>
        <div class="form-checkbox-legend">
            <label class="labeldesc" for="interest">Mes centres d'interet :</label>
        </div>
        <input name=interest class="inputdesc" type="text" id="interest" value="<?php if($info_user['interest']!=null){echo $info_user['interest'];}else{echo"Jeux video,Netflix,Les films de Miyazaki";} ?>" data-role="tagsinput"></input>
                    
    
        
    </fieldset>
    <div class="form-actions">
        <button class="form-btn" type="submit">Envoyer</button>
        <button class="form-btn-cancel -nooutline" type="reset">Recomencer</button>
    </div>
</form>
        </div>


    </div>
