<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title></title>
  </head>
  <body>
    
    <header>
      <?php include_once 'templates/parts/header.php' ?>
    </header>
    <main>
      <?php include_once "templates/parts/$content.php" ?>
    </main>
    <footer>
      <?php include_once 'templates/parts/footer.php' ?>
    </footer>

  </body>
</html>
