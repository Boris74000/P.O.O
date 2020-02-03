<?php
require_once ("bdd.php");
class Voiture
{
    /**
     *couleur de la voiture
     * @var null
     */
    protected $color = null;

    /**
     *nombre de portes
     * @var null
     */
    protected $nbDoors = null;

    /**
     * immatriculation du véhicule
     * @var null
     */
    protected $imat = null;

    /**
     * id du véhicule
     * @var null
     */
    protected $id = null;

    /**
     * Voiture constructor.
     * @param $id
     */

    public function __construct($id)
    {
        // requete BDD get properties for $id


        // Attempt to connect to our DB
        $dbConnection = BDD::getConnexion();
        $inst = $dbConnection->query('SELECT * FROM cars WHERE id='.$id);

        $result = $inst->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
        /*
        $result = [
            'id' => $id,
            'color' => 'blue',
            'nbDoors' => 3,
            'imat' => 'DG 564 YS'
        ];
        */
        $this->id = $result['id'];
        $this->color = $result['couleur'];
        $this->nbDoors = $result['nbPortes'];
        $this->imat = $result['immatriculation'];

    }
    public function printColor() {
        echo $this->color;
    }

    public function getColor() {
        return $this->color;
    }

    public function paint($color) {

       //$this->color = $color;
        //var_dump('color='.$this->color);
       $bdd = BDD::getConnexion();
       $res = $bdd->query( 'UPDATE cars
                 SET couleur="'.$color.'"
                 WHERE id='.$this->id);
        if($res->rowCount()) {
            $this->color = $color ;
            return true ;
        } else {
            return false ;
        }

    }

    public function changeImat($imat) {
        $bdd = BDD::getConnexion();
        $res = $bdd->query( 'UPDATE cars
                 SET immatriculation="'.$imat.'"
                 WHERE id='.$this->id);
        /*
        if($res->rowCount()) {
            $this->imat = $imat ;
            return true ;
        } else {
            return false ;
        }
        */
        echo $res->rowCount().' changement(s) effetué(s)';
    }
}

/*
echo $maVoiture->color;
$maVoiture->color = 'red';
echo $maVoiture->color;

$maVoiture->printColor();
echo $maVoiture->getColor();
*/
