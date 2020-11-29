<h1>Client: <?= $_SESSION['personnal']['raison_sociale'] ?></h1>


<form class=""  method="post">
  <input type="date" name="date_commande" value="">
  <input type="number" min ="1" name="quantite[]" value="" placeholder="quantite">

  <?php
  $articles = new Articles;
  $search_result = $articles->search(["desactive" => 0]);

  $users = new Users;
  $getAll_result = $users->getAll();
  ?>

  <select class="" name="article_ID[]">
    <?php foreach ($search_result['data'] as $key => $value) {?>
      <option value="<?=$value['ID']?>"><?=$value['nom']?></option>
    <?php } ?>

  </select>
  <button type="button" onclick="clone()"> ajouter </button>
  <?php
  if ($_SESSION['personnal']['role']== 1 ){?>


    <select class="" name="user_ID">
      <?php foreach ($getAll_result['data'] as $key => $value) {?>
        <option value="<?=$value['ID']?>"><?=$value['nom']?></option>
      <?php } ?>
    </select>
<?php } ?>
  <input type="submit" name="" value="envoyer">
</form>

<script type="text/javascript">

  function clone(){
  var quantite = document.querySelector('[name="quantite[]"]');
  var article_ID = document.querySelector('[name="article_ID[]"]');
  document.querySelector("form").appendChild(quantite.cloneNode())
  document.querySelector("form").appendChild(article_ID.cloneNode(true))
}
</script>
