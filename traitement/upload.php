<?php

 function normalizeString ($str = '')
{
    $str = strip_tags($str); 
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    $str = strtolower($str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '-', $str);
    $str = rawurlencode($str);
    $str = str_replace('%', '-', $str);
    return $str;
}
if(isset($_POST['profil'])){
$allowedExts = array("jpg", "jpeg", "png",);
$extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
if ((($_FILES["fileToUpload"]["type"] == "image/pjpeg")
|| ($_FILES["fileToUpload"]["type"] == "image/jpeg"))
&& ($_FILES["fileToUpload"]["size"] < 2000000)
&& in_array($extension, $allowedExts))

  {
  if ($_FILES["fileToUpload"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["fileToUpload"]["name"] . "<br />";
    echo "Type: " . $_FILES["fileToUpload"]["type"] . "<br />";
    echo "Size: " . ($_FILES["fileToUpload"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["fileToUpload"]["tmp_name"] . "<br />";

    if (file_exists("uploads/" . $_FILES["fileToUpload"]["name"]))
      {
      echo $_FILES["fileToUpload"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
      "uploads/" . $_FILES["fileToUpload"]["name"]);
      echo "Stored in: " . "uploads/" . $_FILES["fileToUpload"]["name"];
       $sql = "SELECT * FROM user WHERE id=?";
        // Etape 1  : preparation
        $q = $pdo->prepare($sql);
        // Etape 2 : execution : 2 paramètres dans la requêtes !!
        $q->execute(array($_SESSION['id']));
        // Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
        $line = $q->fetch();
        if($line['avatar'] != null){
            if($line['avatar'] == "user404.png"){
                
            }else{
                //On supprime la potentiel ancienne image dans le repertoire upload
            $myFile = "uploads/".$line['avatar'];
            unlink($myFile) or die("Impossible de supprimer le fichier ".$myFile);
            }
 //On supprime la potentiel ancienne image dans la DB
            $sql = "UPDATE user SET avatar =null WHERE id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION['id'],));
        }
        
        
        
        //On ajoute la nouvelle image dans la DB
        $sql = "UPDATE user SET avatar =? WHERE id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($_FILES["fileToUpload"]["name"],$_SESSION['id']));
        
        header('Location: index.php?action=monmur');
        
      }
    }
  }
else
  {
  echo "Invalid file";
  }


}else{

$allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
$extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
if ((($_FILES["fileToUpload"]["type"] == "video/mp4")
|| ($_FILES["fileToUpload"]["type"] == "audio/mp3")
|| ($_FILES["fileToUpload"]["type"] == "audio/wma")
|| ($_FILES["fileToUpload"]["type"] == "image/pjpeg")
|| ($_FILES["fileToUpload"]["type"] == "image/gif")
|| ($_FILES["fileToUpload"]["type"] == "image/jpeg"))

&& ($_FILES["fileToUpload"]["size"] < 2000000)
&& in_array($extension, $allowedExts))

  {
  if ($_FILES["fileToUpload"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["fileToUpload"]["name"] . "<br />";
    echo "Type: " . $_FILES["fileToUpload"]["type"] . "<br />";
    echo "Size: " . ($_FILES["fileToUpload"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["fileToUpload"]["tmp_name"] . "<br />";

    if (file_exists("uploads/" . $_FILES["fileToUpload"]["name"]))
      {
      echo $_FILES["fileToUpload"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
      "uploads/" . $_FILES["fileToUpload"]["name"]);
      echo "Stored in: " . "uploads/" . $_FILES["fileToUpload"]["name"];
       $sql = "SELECT * FROM user WHERE id=?";
        // Etape 1  : preparation
        $q = $pdo->prepare($sql);
        // Etape 2 : execution : 2 paramètres dans la requêtes !!
        $q->execute(array($_SESSION['id']));
        // Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
        $line = $q->fetch();
        if($line['avatar'] != null){
            if($line['avatar'] == "user404.png"){
                
            }else{
                //On supprime la potentiel ancienne image dans le repertoire upload
            $myFile = "uploads/".$line['avatar'];
            unlink($myFile) or die("Impossible de supprimer le fichier ".$myFile);
            }
 //On supprime la potentiel ancienne image dans la DB
            $sql = "UPDATE user SET avatar =null WHERE id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION['id'],));
        }
        
        
        
        //On ajoute la nouvelle image dans la DB
        $sql = "UPDATE user SET avatar =? WHERE id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($_FILES["fileToUpload"]["name"],$_SESSION['id']));
        
        header('Location: index.php?action=monmur');
        
      }
    }
  }
else
  {
  echo "Invalid file";
  }

    
}


/*
$target_dir = "uploads/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"]) && isset($_FILES["fileToUpload"])) {
    $check = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
   $uploadOk = 0;
}
// Check file size

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
   $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error


if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
//if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      
        $sql = "SELECT * FROM user WHERE id=?";
        // Etape 1  : preparation
        $q = $pdo->prepare($sql);
        // Etape 2 : execution : 2 paramètres dans la requêtes !!
        $q->execute(array($_SESSION['id']));
        // Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
        $line = $q->fetch();
        if($line['avatar'] != null){
            if($line['avatar'] == "user404.png"){
                
            }else{
                //On supprime la potentiel ancienne image dans le repertoire upload
            $myFile = "uploads/".$line['avatar'];
            unlink($myFile) or die("Impossible de supprimer le fichier ".$myFile);
            }
 //On supprime la potentiel ancienne image dans la DB
            $sql = "UPDATE user SET avatar =null WHERE id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION['id'],));
        }
        
        
       
        
        
       
        
        
        //On ajoute la nouvelle image dans la DB
        $sql = "UPDATE user SET avatar =? WHERE id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($_FILES["fileToUpload"]["name"],$_SESSION['id']));
        
        header('Location: index.php?action=monmur');
        
        
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    
}
?>
*/
