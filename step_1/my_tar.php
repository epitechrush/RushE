#!/usr/bin/php 
<?php
$branche = array();			   //Structure des Dossier.
$Nom_Archive = "output.mytar";//Nom de Sortie.
$jsonArray = array();        //Intégration du tableau en json.
$Fichier_Array = $argv;     //Stockage du tableau.
$erreur = "";			   //Stockage des erreurs dans une variable spécifique.
if (empty($Fichier_Array))
{
	echo "Veuillez entrez le nom des fichiers à archiver.\n";
	exit;
}
else if (count($Fichier_Array) < 1)
{
	echo "Veuillez insérer au moins un dossier.\n";
}

function list_files_folders($Fichier_Array)
{
	global $branche; // Je donne l'accès a ces nouvelles valeur.
	foreach ($Fichier_Array as $file) {
		if(is_dir($file))
		{
			$branche = scan_folder("/".$file); //Ajout dans la variable $branche les path avec leur noms
		}
		else if (file_exists($file)) // Vérification de l'existance des fichiers.
		{
			array_push($branche, "./".$file); //Empile un ou plusieur élément a la fin du tableau.
		}
		else
		{
			$erreur : "Erreur : $file n'existe pas !";
		}

	}
	return $tree; // On retourne le tableau avec les path des fichier.
}

function scan_folder($directory)
{
	global $branche
}