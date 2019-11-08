#!/usr/bin/php
<?php
//my_tar
$tree = array();
$name_archive = "output.mytar"; 
$jsonArray = array():
$filesArray = $argv;
array_splice($filesArray, 0,1); // supprime les éléments désignés par 0 et 1 du tableau 

//vérification que tout est bon.
if (empty($filesArray))
{
	$erreur =  "Enter name for archive !\n";
	exit;
}
else if (count($filesArray) < 2)
{
	$erreur = "Insert minimum 2 files here !\n"
	exit;
}

// Déclaration des fonction

//list folder :
function list_files_folders($fileArray)
{
	global $tree;
	foreach ($fileArray as $file) {
		if(is_dir($file))
		{
			$tree = scan_folder('/'. $file);S
		}
		else if (file_exists($file))
		{
			array_push($tree,'./'. $file)
		}
		else
		{
			$erreur = "Erreur : $file n'existe pas !\n"
			exit;
		}
	}
	return $tree;
}
