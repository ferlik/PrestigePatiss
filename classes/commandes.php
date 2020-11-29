<?php


class Commandes extends Main {

  protected $fields = [
    "ID" => "INT",
    "date_commande" => "date",
    "quantite" => "INT",
    "user_ID" => "INT",
    "article_ID" => "INT",
    "commande_number" => "INT"
  ];

  protected $table = "commande";


  protected $values = [];
}
