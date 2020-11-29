<?php


class Main {

  // est un array, contient un tableau qui énumère les champs de la BDD en fonction de la table
  protected $fields = [];

  // est un string, contient le nom de la table de la BDD
  protected $table = '';

  // est un array multi, contient 2 tableaux " data et other";
  // si le nom du champs est éxistant dans une table de la BDD il sera stocké dans data sinon dans other
  protected $values = [];



/**
 * lorsque un formulaire est validé on stock les valeures $_POST dans la variable $values
 * @return Array = Un tableau avec error = true si une erreur, false sinon
 */
  public function fromPost(){

    // $_POST = [
    // "nom"=> "ferdi",
    // "age"=> 37,
    // "adresse"=>"sainté"
    // ]
    foreach ($_POST as $Postkey => $Postvalue) {
      if ( !isset($Postvalue) || ( empty($Postvalue) && $Postvalue != 0 ) ){
        return ['error'=> true];
      }

      if ( isset($this->fields[$Postkey]) ){
        $this->values['data'][$Postkey] = htmlentities($Postvalue);
      }
      else {
        $this->values['other'][$Postkey] = htmlentities($Postvalue);
      }

    }
    return ['error' => false];
  }




/**
 * Récupère tous les éléments d'une table
 * @return ARRAY = Un tableau avec error = true si une erreur, false sinon
 *                  Et si false retourne un array de données
 */
  public function getAll($group = null){

    // On établie la connexion avec la BDD
    global $BDD;

    // On stock la requête sql dans une variable
    $SQL = "SELECT * FROM $this->table";
      if (isset($group)){
        $SQL .= " GROUP BY `$group`";
      }
    // On prépare la requête sql
    $req = $BDD->prepare($SQL);

    // On éxecute la requete sql et verifie qu'elle est bien fonctionnée
    if ( $req->execute() == false ){
      return ['error' => true];
    }

    // On récupère le résultat de la requete sql
    $ligne = $req->fetchAll(PDO::FETCH_ASSOC);

    if ($ligne == false){
      return ['error' => true,'data'=>[]];
    }
      return ['error' => false,'data' => $ligne];
  }




  /**
   * methode qui va nous permettre d'avoir toute les infos d'une table par rapport à des critères
   * @param  ARRAY argument de recherche dans un tableau
   * @return ARRAY returne un tableau d'erreur true si erreur, fasle sinon
   *                si false retourne un array de donées
   */
  public function search($tableOfSearchedElement){

    // On établie la connexion avec la BDD
    global $BDD;

    // On stock la requête sql dans une variable
    $SQL = "SELECT * FROM `$this->table` WHERE ";

    $set = [];
    $param = [];

    foreach ($tableOfSearchedElement as $key => $value) {

      $set[] = " `$key` = :$key";
      $param[":$key"] = $value;
    }


    $SQL .= implode( ", ", $set);

    // On prépare la requête sql
    $req = $BDD->prepare($SQL);

    // On éxecute la requete sql et verifie qu'elle est bien fonctionnée
    if ( $req->execute($param) == false ){
      return ['error' => true];
    }

    // On récupère le résultat de la requete sql
    $ligne = $req->fetchAll(PDO::FETCH_ASSOC);

    if ($ligne == false){
      return ['error' => true];
    }
      return ['error' => false,'data' => $ligne];
  }



/**
 * On insert une nouvelle ligne dans une table de la BDD avec le contenu de $values
 * @return ARRAY returne un tableau d'erreur true si erreur, fasle sinon
 *                si false returne l'ID du dernier éléments d'ajouter
 */
  public function insert(){

    if ( !isset($this->values['data'])){
      return ['error'=> true];
    }

    // On établie la connexion avec la BDD
    global $BDD;
    $SQL = "INSERT INTO $this->table SET ";

    $set = [];
    $param = [];

    // [
    //  data => [
    //  "nom" => "ferdi",
    //  "ID" => 5,
    //  "passwd" => "xxx"
    //  ],
    //  other => [
    //  "age" =>17,
    //  "plat_prefere" => "tanoulet"
    //  ]
    // ]
    foreach ($this->values['data'] as $key => $value) {

      // [
      //   " 'nom' = :nom",
      //   " 'ID' = :ID"
      // ]
      $set[] = " `$key` = :$key";

      if ($key == "passwd"){
        $value = password_hash($value, PASSWORD_DEFAULT);
        //"48d965zq46d465zq4d65q4z6d5zq54d65q415d"
      }

      if ($this->fields[$key] == "date") {

        $value = date('Y-m-d', strtotime($value));

      }
      $param[":$key"] = $value;
    }

    $SQL .= implode( ", ", $set);

    // On prépare la requête sql
    $req = $BDD->prepare($SQL);



    // On éxecute la requete sql et verifie qu'elle est bien fonctionnée
    if ( $req->execute($param) == false ){
      return ['error' => true];
    }

    return ['error'=>false, "data" => ["LastInsertID" => $BDD->lastInsertId() ]];

  }




/**
 * Méthode pour supprimer une ligne dans une table en renseignant l'ID
 * @param  ARRAY argument optionnel qui fourni l'ID de la ligne à supprimer
 * @return ARRAY retourne un tableau d'erreur true si erreur, fasle sinon
 */
  public function delete($id = null){

    if ( !isset($id) && empty($id) && count($id) <= 0 ){
      if (isset($this->values['data']['ID'])) {

        $id = ['ID' => $this->values['data']['ID'] ];
      }
      else {
        return ['error'=>true];
      }
    }
    //on établie la conn
    global $BDD;

    $column = array_key_first($id);

    // On stock la requête sql dans une variable
    $SQL = "DELETE FROM $this->table WHERE $column = :$column ";

    // On prépare la requête sql
    $req = $BDD->prepare($SQL);

    $param = [ ":$column" => $id[$column] ];

    // On éxecute la requete sql et verifie qu'elle est bien fonctionnée
    if ( $req->execute($param) == false ){
      return ['error' => true];
    }


    return ['error' => false];


  }


/**
 * Méthode qui va nous permettre de savoir le nombre de ligne dans une table de la BDD
 * @return ARRAY retourne un tableau d'erreur true si erreur, fasle sinon
 *                si false retourne aussi le nombre d'éléments dans la table
 */
public function count($group = null){

  // On établie la connexion avec la BDD
  global $BDD;

  // On stock la requête sql dans une variable
  $SQL = "SELECT * FROM $this->table";

  if (isset($group)){
    $SQL .= " GROUP BY `$group`";

  }

  // On prépare la requête sql
  $req = $BDD->prepare($SQL);

  // On éxecute la requete sql et verifie qu'elle est bien fonctionnée
  if ( $req->execute() == false ){
    return ['error' => true];
  }

  // On récupère le résultat de la requete sql
  $ligne = $req->fetchAll(PDO::FETCH_ASSOC);

  if ($ligne == false){
    return ['error' => true, 'data'=> ["nbr_ligne"=>0]];
  }
    return ['error' => false,'data' => ["nbr_ligne"=>count($ligne)]];
}
}
