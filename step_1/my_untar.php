#!/usr/bin/php
<?php
unset($argv[0]); // suppression des anciennes valeurs 
$Nom_Archive = $argv;
if (empty($Nom_Archive))
{
	echo "veuillez indiquer au moins le nom d'archive a décompresser !\n";
	exit;
}

foreach ($Nom_Archive as $archive) {
	if (!file_exists($Nom_Archive))
	{
		echo " Erreur : Archive inexistante !";
		exit;
	}
}

if (unarchive($Nom_Archive))
{
	echo "Désarchivage terminé !\n";
}
else 
{
	echo "une erreur s'est produite lors du désarchivage !\n";
}

function unarchive($archive)
{
	$erreur = false;
	foreach ($Nom_Archive as $archive ) {
		$data = file_get_contents($archive);
		$json_array = json_decode($data, true);
		foreach ($json_array as $file) {
			if (!is_dir($file['path']))
			{
				mkdir($file['path'], 0755, true); // création du dossier ou on vas intégré la décompression.
			}
//si le fichier n'existe pas on le créé
			if (!file_exists($file['path']. '/' . $file['name']))
			{
				if (file_put_contents($file['path'] . '/' . $file['name'], utf8_decode($file['content'] === false)))
				{
					echo 'Erreur lors de l\'écriture du fichier : ' . $file['name'] . "\n";
				}
				else
				{
					echo 'le fichier a été extrait : ' . $file['name'] . "\n";
				}
		
			}
			else
			{
				echo 'Le fichier existe déjà : ' . $file['name'] . "\n";
				$erreur = true;
			}
		}
	}
}
if ($erreur)
{
	$a = readline("Entrez un choix : \n");
	echo "1 : Ecraser le fichier existant\n";
	echo "2 : Ne pas écraser le fichier existant\n";
	echo "3 : Ecraser pour tous, ne plus demander\n";
	echo "4 : Ne pas écraser pour tous, ne plus demander\n";
	echo "5 : Arrêter et quitter\n";
	switch($a){
		case 1:
			@system('del /f'.$file['name']);//windows.
			shell_exec("rm -r " .$file['name']);//linux
		case 2:
			echo "Le fichier" .$file['name']. "ne seras pas supprimé";
			break;
		case 3:
			echo "Aucun fichier n'a été supprimé".$file['name']."est toujour existant (je vous laisserais tranquille) !";
			break;
		case 4:
			echo "Aucun". $file['name']." ne seras supprimé (je vous laisserais tranquille)";
		case 5:
			exit;
	}
}