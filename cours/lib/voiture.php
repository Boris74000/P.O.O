<?php
require_once ("bdd.php");
class Voiture
{
    /**
     *couleur de la voiture
     * @var null
     */
    protected $couleur = null;

    /**
     *nombre de portes
     * @var null
     */
    protected $nbPortes = null;

    /**
     * immatriculation du véhicule
     * @var null
     */
    protected $immatriculation = null;

    /**
     * id du véhicule
     * @var null
     */
    protected $id = null;

    public static $authoriseUpdate = ['immatriculation', 'nbPortes', 'couleur'];

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
        $this->couleur = $result['couleur'];
        $this->nbPortes = $result['nbPortes'];
        $this->immatriculation = $result['immatriculation'];

    }
    public function printColor() {
        echo $this->couleur;
    }

    public function getColor() {
        return $this->couleur;
    }

    public function paint($couleur) {
      return $this->update('couleur', $couleur);
    }

    public function update ($property, $value) {

        $properties = array_keys(get_object_vars($this));
        if (in_array($property, $properties)) {
            $this->$property = $value;
        }
        return $this->__save();
    }

    public function __save() {

        $bdd = BDD::getConnexion();

        $update = [];

        $properties = array_keys(get_object_vars($this));
        var_dump($properties);
        for ($i=0; $i < count($properties); $i++) {
            $property = $properties[$i];
            if($property === 'id') {
                continue ;
            }
            var_dump($properties[$i]);
            $update[] = $property.'="'.$this->{$properties[$i]}.'"';

        }

        //var_dump($update);

        if (empty($update)) {
            return false;
        }

        $query = 'UPDATE cars
                 SET '.implode(',',$update).'
                 WHERE id='.$this->id ;

        var_dump($query);


        $res = $bdd->query( $query);

                return !! ($res && $res->rowCount()); // Retourne le nombre de lignes
        /*
        if($res->rowCount()) {
            $this->color = $color ;
            return true ;
        } else {
            return false ;
        }
    */
    }

    public static function getFromImat($imat) {
        $bdd = BDD::getConnexion();
        $query = 'SELECT id FROM cars WHERE immatriculation="'.$imat.'" ';
        $req = $bdd->query($query);
        var_dump($req);
        $id = $req->fetch(PDO::FETCH_UNIQUE|PDO::FETCH_COLUMN);
        var_dump($id);
    }

    public static function create($params) {

            $bdd = BDD::getConnexion();
            $properties = [];
            $values = [];
            foreach ($params as $p => $v) {
                var_dump($p);
                if (in_array($p, Voiture::$authoriseUpdate)) {
                    $properties[] = $p;
                    $values[] = $bdd->quote($v);
                }
        }
            $query = 'INSERT INTO cars ('.implode(',',$properties).')
                            VALUES ('.implode(',', $values).')';

            $bdd->query($query);
            $id = $bdd->lastInsertId();

            return new Voiture($id);
    }

    public function changeImat($immatriculation) {
        return $this->update('immatriculation', $immatriculation) ;
    }
}

/*
echo $maVoiture->color;
$maVoiture->color = 'red';
echo $maVoiture->color;

$maVoiture->printColor();
echo $maVoiture->getColor();
*/
