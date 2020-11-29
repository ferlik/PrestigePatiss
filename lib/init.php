<?php
ini_set("display_errors",1);
error_reporting(E_ALL);



session_start();


global $BDD;
$BDD = new PDO('mysql:host=localhost;dbname=dbprestigepatiss', "root", "");


include_once 'lib/functions.php';

include_once 'classes/controller.php';

include_once 'classes/main.php';


$controller = new Controller();

include_once 'classes/users.php';

include_once 'classes/articles.php';

include_once 'classes/commandes.php';
