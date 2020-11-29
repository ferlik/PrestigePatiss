<?php


class Articles extends Main {

  protected $fields = [
    "ID" => "INT",
    "nom" => "TEXT",
    "prix" => "DEC",
    "desactive" => "BOOLEAN"

  ];

  protected $table = "article";


  protected $values = [];
}
