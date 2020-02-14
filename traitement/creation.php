<?php 

if(!empty($_POST['login']) && !empty($_POST['mdp']) && !empty($_POST['mdp2'])){
    if($_POST['mdp'] === $_POST['mdp2']){
            
            $sql = "SELECT * FROM user WHERE login=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($_POST['login']));
            $line = $q->fetch();
        
            if($line == NULL){
                $sql = "INSERT INTO user VALUES(NUll,?,PASSWORD(?),?,NULL,'user404.png')";

                $q = $pdo->prepare($sql);
                $q->execute(array($_POST['login'],$_POST['mdp'],$_POST['email']));
                $_SESSION['login']=$_POST['login'];
                $_SESSION['id']= $pdo->lastInsertId();
                print_r($_POST);
                header('Location:index.php?action=monmur');
            }else{
                $_SESSION['error'] = "Nom d'utilisateur déjà pris.";
                $_SESSION['Prev_mdp'] = $_POST['mdp2'];
                header('Location:index.php');
            }
            
                
    }else{
        $_SESSION['Prev_login'] = $_POST['login'];
        $_SESSION['error'] = "Mdp non identique";
        header('Location:index.php');
    }
    
}else{
    $_SESSION['error'] = "Remplir tous les champs";
    header('Location:index.php');
    
}
