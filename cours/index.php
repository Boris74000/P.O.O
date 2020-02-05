<?php

// définir objet parc auto
require_once("lib/voiture.php");
require_once("lib/parcAuto.php");



// définir objet voitures

/*
$maVoiture = new Voiture(1);
echo $maVoiture->getColor().'<br>';
$maVoiture->paint("rouge");
unset($maVoiture);
$maVoiture = new Voiture(1);
echo $maVoiture->getColor().'<br>';
*/

//$maVoiture = new Voiture(1);

//$plate = "CF 238 XF";
//$obj = Voiture::getFromImat($plate);

/*
$myCar = Voiture::create([
    'couleur' => 'cameleon',
    'immatriculation' => 'JB 007 JB',
    'nbPortes' => '3',

        ]);
*/
//$allCars = Voiture::findAll();
//var_dump($allCars);



$parcs = ParcAuto::findOne(['city' => 'Geneve']);

$allBlueCars = $parcs->getAllCars(['couleur'=> 'bleu']);
var_dump($allBlueCars);





// liste les parcs auto

// Je récupère celui qui a le plus de voitures

// je l'interroge pour avoir le nombre de véhicules bleu

// je liste les plaques d'immatriculation des véhicules qui ne sont pas en panne

