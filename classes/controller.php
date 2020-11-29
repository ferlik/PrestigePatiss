<?php

/**
 *
 */
class Controller
{
  /**
   * Méthode permettant de récuperer la valeure de action dans l'url
   * et renoie le nom de la page à charger ou execute une autre méthode du même nom
   * @return ARRAY renvoie la page demandée et éxecute la méthode si besion
   */
  public function getAction()
  {

      if (isset($_GET['action'])){

        if ($_GET['action'] == 'getAction'){
          //si la valeure de action est égale à getAction alors...
          return ['redirect' => ''];
        }
        if ( method_exists('controller', $_GET['action']) ){
          // si une méthode existe dans le controlleur et porte le nom de la valeure action alors...
          $func = $_GET['action'];
          $return = $this->$func(); // ['content'=>'pageLogin']
          return $return;
        }
        if (file_exists('templates/parts/' .$_GET['action'] . ".php")){
          // si le fichier dans templates/parts/ valeure de action .php existe alors ...
          return ['content' => $_GET['action']];
        }
        else {
          // sinon ...
          return ['content'=> 'default'];
        }
    }
    else {
      // sinon ...
      return ['content'=> 'default'];
    }
  }


  /*public function template(){
    if ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ){

    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    }
    return ['content'=> 'xxx'];
  }*/


/**
 * [pageLogin description]
 * @return [type] [description]
 */
  public function pageLogin(){
    if ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ){
      return ['content' => 'default'];
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      $users = new Users;

      if ( isset($users->fromPost()['error']) && $users->fromPost()['error'] == true){
        return ['content' => 'pageLogin'];
      }
      if (isset($users->login()['error']) && $users->login()['error'] == true){
        return ['content' => 'pageLogin'];
      }

      return ['redirect' => 'ajoutCommandes'];

    }
    return ['content' => 'pageLogin'];
  }



/**
 * Vérifie si un utilistaur est connecté si oui quel est son role et affiche la page et fourni les données en conséquence
 * @return ARRAY contenant un tableau d'instruction pour le routeur
 */
  public function client(){

    if ( (isset($_SESSION['connected']) || isset($_SESSION['personnal']) )&& $_SERVER['REQUEST_METHOD'] == 'GET' ){
      if ( $_SESSION['personnal']['role'] == 1 ){
          $user = new Users;

        $getAll_result = $user->getAll();

        if (isset($getAll_result['error']) && $getAll_result['error'] == true){
          return ['content' => 'default'];
        }

          return ['content' => 'client','data'=> $getAll_result['data'] ];

      }else{
        return ['redirect'=>'default'];
        }
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

      $user = new Users;
      $fromPost_result = $user->fromPost();
        if ( isset($fromPost_result['error']) && $fromPost_result['error'] == true){
          return ['content'=>'default'];
        }

      $insert_result = $user->insert();
        if ( isset($insert_result['error']) && $insert_result['error'] == true){
          return ['content'=>'default'];
        }

        return ['redirect'=>'client'];
    }

    return ['redirect' => 'pageLogin'];

  }



  public function ajoutArticles(){

    if ( ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ) && $_SERVER['REQUEST_METHOD'] == 'GET'){

        if ($_SESSION['personnal']['role'] != 1){
          return ['content'=>'default'];
        }
        $articles = new Articles;
        $getAll_result = $articles->getAll();
        return ['content'=>'ajoutArticles','data'=> $getAll_result['data']];
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $articles = new Articles;
        $fromPost_result = $articles->fromPost();
        if ( isset($fromPost_result['error']) && ($fromPost_result['error'] == true)){
          return ['content'=>'default'];
        }

        $insert_result = $articles->insert();
        if ( isset($insert_result['error']) && ($insert_result['error'] == true)){
          return ['content'=>'default'];
        }
        return ['redirect'=>'ajoutArticles'];

    }
    return ['content'=> 'default'];

  }

  public function ajoutCommandes(){

    if ( ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ) && $_SERVER['REQUEST_METHOD'] == 'GET'){
      return ['content'=>'ajoutCommandes'];
    }

    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

      $commandes = new Commandes;

      if ($_SESSION['personnal']['role'] == 0){
        $_POST['user_ID'] = $_SESSION['personnal']['ID'];
      }

      $article_id = $_POST['article_ID'];
      $quantite = $_POST['quantite'];

      $_POST['commande_number'] = $commandes->count("commande_number")['data']['nbr_ligne']+1;
      foreach ($article_id as $key => $value) {
        $_POST['article_ID'] = $value;
        $_POST['quantite'] = $quantite[$key];

        $fromPost_result = $commandes->fromPost();

        if ( isset($fromPost_result['error']) && ($fromPost_result['error'] == true)){
          return ['content'=>'default'];
        }

        $insert_result = $commandes->insert();
        if ( isset($insert_result['error']) && ($insert_result['error'] == true)){
          return ['content'=>'default'];
        }
      }
      return ['content'=>'ajoutCommandes'];
    }
    return ['content'=> 'default'];

  }

  public function commande(){

    if ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ){
      if ( $_SESSION['personnal']['role']== 1){

        $commandes = new Commandes;

        $getAll_result = $commandes->getAll("commande_number");

        return ['content'=>'commande', 'data' => $getAll_result['data']];
      }

    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    }
    return ['content'=> 'default'];

  }

  public function logout()
  {
    if (!isset($_SESSION['connected']) || !isset($_SESSION['personnal'])) {
      return ['redirect' => 'default'];
    }
    unset($_SESSION['connected']);
    unset($_SESSION['personnal']);
    session_unset();
    session_destroy();
    return ['return' => "default"];
  }


  public function deleteArticle(){

    if ( ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ) && isset($_GET['ID']) ){
        if ( $_SESSION['personnal']['role'] == 1){
          $articles = new Articles;
          $articles->delete(['ID'=>$_GET['ID']]);
          return['redirect' => 'ajoutArticles'];
        }
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    }
    return ['redirect'=> 'default'];

  }

  public function deleteCommande(){

    if ( ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ) && isset($_GET['ID']) ){
        if ( $_SESSION['personnal']['role'] == 1){
        $commandes = new Commandes;
          $commandes->delete(['commande_number'=>$_GET['ID']]);
          return['redirect' => 'commande'];
        }
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    }
    return ['redirect'=> 'default'];

  }

  public function deleteUser(){

    if ( ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ) && isset($_GET['ID']) ){
        if ( $_SESSION['personnal']['role'] == 1){
          $users = new Users;
          $users->delete(['ID'=>$_GET['ID']]);
          return['redirect' => 'client'];
        }
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    }
    return ['redirect'=> 'default'];

  }

  public function commandeDetail(){
    if ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ){
      if ( $_SESSION['personnal']['role']== 1){
        $commandes = new Commandes;

        $search_result = $commandes->search(['commande_number'=>$_GET['ID']]);

        return ['content'=>'commandeDetail', 'data' => $search_result['data']];
    }
    if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    }
    return ['content'=> 'xxx'];

  }}
}
