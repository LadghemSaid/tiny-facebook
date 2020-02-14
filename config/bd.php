<?php

$db="************"; // le nom de votre base de données.
$user="**************";
            
$passwd="***************"; 
        
$host="***************"; // le chemin vers le serveur (localhost dans 99% des cas) addresse pour chez moi

try {
	// On essaie de créer une instance de PDO.
	$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  
catch(Exception $e) {
	echo "Erreur : ".$e->getMessage()."<br />";
}
