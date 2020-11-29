<?php

/**
 *
 */
class Users extends Main
{

  protected $fields = [
    "ID"=> 'INT',
    "nom"=> 'TEXT',
    "raison_sociale" => 'TEXT',
    "siret" => 'TEXT',
    "passwd" => 'TEXT',
    "adresse" => 'TEXT',
    "telephone" => 'TEXT',
    "ville" => 'TEXT',
    "code_postale" => 'TEXT',
    "mail" => 'TEXT',
    "role" => 'INT'];


  protected $table = "users";


  protected $values = [];


/**
 * Vérifie les identifiants et connecte l'utilisateur
 * @return ARRAY Un tableau avec error = true si une erreur, false sinon
 */
  public function login(){

    if ( !isset($this->values['data'])){
      return ['error' => true];
    }

    // On établie la connexion avec la BDD
    global $BDD;

    // On stock la requête sql dans une variable
    $SQL = "SELECT * FROM $this->table WHERE `ID` = :ID ";

    // On détermine l'ID du formulaire et on le stock
    $param = [":ID" => $this->values['data']['ID']];

    // On prépare la requête sql
    $req = $BDD->prepare($SQL);

    // On éxecute la requete sql et verifie qu'elle est bien fonctionnée
    if ( $req->execute($param) == false ){
      return ['error' => true];
    }

    // On récupère le résultat de la requete sql
    $ligne = $req->fetch(PDO::FETCH_ASSOC);

    if ($ligne == false){
      return ['error' => true];
    }

    if (!password_verify($this->values['data']['passwd'], $ligne['passwd'])){
      return ['error'=> true];
    }

    if ($ligne['role'] == -1){
      return ['error'=> true];
    }

    $_SESSION['connected'] = true;

    $_SESSION['personnal'] = $ligne;

    return ['error'=> false];


  }


}
