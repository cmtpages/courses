<?php  if (! defined('BASEPATH')) {
     exit('No direct script access allowed');
 }

 
if (! function_exists('convertir')) {
    function convertir($unite_origine, $unite_reference, $valeur) {
		if($unite_reference=='kg') {
			if($unite_origine=='kg')     return $valeur;
			elseif($unite_origine=='g')  return $valeur/1000;
			else                         return 'Erreur : unités incohérentes.';
		}
		elseif($unite_reference=='L') {
			if($unite_origine=='mL')     return $valeur/1000;
			elseif($unite_origine=='cL') return $valeur/100;
			elseif($unite_origine=='dL') return $valeur/10;
			elseif($unite_origine=='L')  return $valeur;
			else                         return 'Erreur : unités incohérentes.';
		}
		else return $valeur;
    }       
}

if (! function_exists('unite_reference')) {
    function unite_reference($unite_origine) {
		if($unite_origine=='kg')     return 'kg';
		elseif($unite_origine=='g')  return 'kg';
		elseif($unite_origine=='L')  return 'L';
		elseif($unite_origine=='mL') return 'L';
		elseif($unite_origine=='cL') return 'L';
		elseif($unite_origine=='dL') return 'L';
		else                         return $unite_origine;
    }
}

if (! function_exists('affiche_nombre')) {
    function affiche_nombre($valeur) {
		echo number_format($valeur, 2, '.', ' ');
    }
}

