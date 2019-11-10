#!/usr/bin/php 
<?php
$branche = array();			             //Structure des Dossier.					   \\
$Nom_Archive = "output.mytar";          //Nom de Sortie.		 				 		\\
$jsonArray = array();                  //Intégration du tableau en json.				 \\
var_dump($Fichier_Array = $argv);     //Stockage des fichier dans un tableau.			  \\	
$erreur = "";			             //Stockage des erreurs dans une variable spécifique.  \\
if (empty($Fichier_Array))
{
	echo "Veuillez entrez le nom des fichiers à archiver.\n";
	exit;
}
else if (count($Fichier_Array) < 1)
{
	echo "Veuillez insérer au moins un dossier.\n";
}
$branche = list_files_folders($Fichier_Array);
$jsonArray = branche_to_json($branche,$jsonArray);
$Nom_Archive = AddFilesToArchive($Nom_Archive,$jsonArray);
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
			echo "Erreur : $file n'existe pas !";
		}

	}
	return $branche; // On retourne le tableau avec les path des fichier.
}

function scan_folder($directory) // Scan du dossier courant.
{
	global $branche; // Accès au nouvelle valeur grâce a global.
	$relative = ".".$directory;
	if ($dh = opendir($relative))
	{
		while(false !== ($file = readdir($dh)))
		{
			if (($file !== '.') && ($file !== '..'))
			{
				array_push($branche, "." . $directory . $file);
			}
			else
			{
				scan_folder(($directory.$file.'/'));
			}
		}
	}
	return $branche;
}

function createArchive($name) // Préparation à la création de l'archive.
{
	fopen($name,'a'); // Ouverture du fichier en ecriture et place le pointeur à la fin du fichier.
	echo  "Création de l'archive : " . $name . "\n";
	return true;
}

function branche_to_json($branche, $jsonArray) //Créé un tableau de style json
{
	foreach ($branche as $file) //Parcours des dossier.
	{
		$tmp = explode('/',$file);
		$fileName = end($tmp);
		$fileContents = file_get_contents($file);//Récupère le contenu des fichier dans le tableau.
		$path = array_splice($tmp, 0,-1); // efface et remplace tous les éléments du tableau. 
		$path = implode('/', $path);
		$jsonArray[] = array('name' => $fileName, 'path' => $path, 'contenu' => $fileContents);
	}
	return $jsonArray;
}

function AddFilesToArchive($Nom_Archive,$jsonArray) //Préparation des fichier pour compression.
{
	createArchive($Nom_Archive);
	foreach ($jsonArray as $file) {
		echo  "Ajout du fichier : " .$file['name'] . "\n";
		file_put_contents($Nom_Archive, utf8_encode(json_encode($jsonArray)));
	}
	echo "Fin de l'archivage de vos fichier !\n";
	return $Nom_Archive;
}



?>