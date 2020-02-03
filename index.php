<?php

// définir objet parc auto
require_once("lib/voiture.php");



// définir objet voitures

/*
$maVoiture = new Voiture(1);
echo $maVoiture->getColor().'<br>';
$maVoiture->paint("rouge");
unset($maVoiture);
$maVoiture = new Voiture(1);
echo $maVoiture->getColor().'<br>';
*/

$maVoiture = new Voiture(1);
$maVoiture->changeImat("DD 100 JJ");


// liste les parcs auto

// Je récupère celui qui a le plus de voitures

// je l'interroge pour avoir le nombre de véhicules bleu

// je liste les plaques d'immatriculation des véhicules qui ne sont pas en panne

