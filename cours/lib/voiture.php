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
     * couleur : FR
     * @var null
     */
    protected $color = null;

    /**
     * Parc auto auquel appartient le véhicule
     * @var null
     */
    protected $parc = null;

    /**
     * id du  Parc auto auquel appartient le véhicule
     * @var null
     */
    protected $idParcAuto = null;

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

    public function __construct($id=null)
    {
        // requete BDD get properties for $id


        // Attempt to connect to our DB
        if (!empty($id)) {
            $dbConnection = BDD::getConnexion();
            $inst = $dbConnection->query('SELECT * FROM cars as c LEFT JOIN cars_color as cc ON c.couleur = cc.couleur WHERE id='.$id);
            if(!$inst)
                return;
            $result = $inst->fetch(PDO::FETCH_ASSOC);
            if(!$result || empty($result['id']))
                return;
            //var_dump($result);
            foreach ($result as $k => $v) {
                $this->$k = $v;
            }
            /*
            $result = [
                'id' => $id,
                'color' => 'blue',
                'nbDoors' => 3,
                'imat' => 'DG 564 YS'
            ];
            */
            //$this->id = $result['id'];
            //$this->couleur = $result['couleur'];
            //$this->nbPortes = $result['nbPortes'];
            //$this->immatriculation = $result['immatriculation'];

        }
        $this->parc = new ParcAuto($this->idParcAuto);
    }

    public function printColor()
    {
        echo $this->couleur;
    }

    public function getColor()
    {
        return $this->couleur;
    }

    public function paint($couleur)
    {
      return $this->update('couleur', $couleur);
    }

    public function update ($property, $value)
    {

        $properties = array_keys(get_object_vars($this));
        if (in_array($property, $properties)) {
            $this->$property = $value;
        }
        return $this->__save();
    }

    public function __save()
    {

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

    public static function getFromImat($imat)
    {
        $bdd = BDD::getConnexion();
        $query = 'SELECT id FROM cars WHERE immatriculation="'.$imat.'" ';
        $req = $bdd->query($query);
        var_dump($req);
        $id = $req->fetch(PDO::FETCH_UNIQUE|PDO::FETCH_COLUMN);
        var_dump($id);
    }

    public static function create($params)
    {

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

    /* public static function findAll() {
        $bdd = BDD::getConnexion();
        $query = 'SELECT * FROM cars';
        $res = $bdd->query($query);
        $response = [] ;

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $response[] = new Voiture($row['id']);
        }
        return $response;
    } */

    public static function findAll($filters=[])
    {
        $bdd = BDD::getConnexion();

        $clauses = [];
        foreach ($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }
        $where = '';
        if (!empty($clauses)) {
            $where = 'WHERE '.implode(' AND ', $clauses);
        }
        $query = 'SELECT * FROM cars as c LEFT JOIN cars_color as cc ON c.couleur = cc.couleur '.$where;
        var_dump($query);
        $res = $bdd->query($query);
        return $res->fetchAll(PDO::FETCH_CLASS, 'Voiture');
    }



    public function changeImat($immatriculation)
    {
        return $this->update('immatriculation', $immatriculation) ;
    }
}


//echo $maVoiture->color;
//$maVoiture->color = 'red';
//echo $maVoiture->color;
//
//$maVoiture->printColor();
//echo $maVoiture->getColor;

