<?php
include_once 'lib/init.php';


$Action = $controller->getAction();



if ($Action != false) {

  if ( isset($Action['content']) ){
    $content = $Action['content'];
    if ( !file_exists("templates/parts/$content.php") ){
      $content = 'default';
    }
  }
  if ( isset($Action['message']) ){
    print_r($Action['message']);
  }
  if ( isset($Action['data']) ){
  }
  if ( isset($Action['redirect']) ){
  
    header('location: ?action='.$Action['redirect']);
  }

}
if ( !isset($content) ) {
  $content = 'default';
}

include_once 'templates/pages/main.php';
