<?php

require_once 'bdd.php';

protected $id;
protected $name;
protected $city;

class ParcAuto
{
    public function __construct($id=null)
    {
        if (!empty($id)) {
            $bdd = BDD::getConnexion();
            $res = $bdd->query('SELECT * FROM parcAuto WHERE id=' . $id);
            $result = $res->fetch(PDO::FETCH_ASSOC);
            //var_dump($result);

            foreach ($result as $k => $v) {
                $this->$k = $v;
            }
        }
    }


    public static function findOne($filters)
    {
        $bdd = BDD::getConnexion();
        $where = '';
        $clauses = [];
        foreach ($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }

        if (!empty($clauses)) {
            $where = 'WHERE '.implode(' AND ', $clauses);
        }
        $query = 'SELECT * FROM parcAuto '.$where.'LIMIT 0,1';
        var_dump($query);
        $res = $bdd->query($query);
        $res->setFetchMode(PDO::FETCH_CLASS, 'ParcAuto');
        return $res->fetch();

    }

    public static function findAll($filters=[])
    {
        $bdd = BDD::getConnexion();

        $clauses = [];
        $where = '';
        foreach ($filters as $k => $f) {
            $clauses[] = $k.'='.$bdd->quote($f);
        }

        if (!empty($clauses)) {
            $where = 'WHERE '.implode(' AND ', $clauses);
        }
        $query = 'SELECT * FROM parcAuto '.$where;
        var_dump($query);
        $res = $bdd->query($query);
        return $res->fetchAll(PDO::FETCH_CLASS, 'ParcAuto');
    }

    public function getAllCars($filters=[])
    {
        $filters['idParcAuto'] = $this->id;
        $cars = Voiture::findAll($filters);
        return $cars;
    }
}







