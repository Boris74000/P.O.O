<?php
require_once ("bdd.php");

class Article {

    /**
     * titre de l'article
     * @var null
     */
    protected $title = null;

    /**
     * id de l'article
     * @var null
     */
    protected $id = null;

    /**
     * Slug de l'article
     * @var null
     */
    protected $slug = null;

    /**
     * texte de l'article
     * @var null
     */
    protected $text = null;

    /**
     * article constructor.
     * @param $id
     */

    public function __construct($id) {

        $dbConnection = BDD::getConnexion();
        $inst = $dbConnection->query('SELECT * FROM post WHERE id='.$id);

        $result = $inst->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);



        /*
        $this->id = $result['id'];
        $this->slug = $result['slug'];
        $this->title = $result['title'];
        $this->text = $result['text'];
        */
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
            //var_dump($properties[$i]);
            $update[] = $property.'="'.$this->{$properties[$i]}.'"';
        }
        //var_dump($update);

        if (empty($update)) {
            return false;
        }

        $query = 'UPDATE post
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



}

