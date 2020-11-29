
<div class="">
  <h2> SAS PRESTIGEPATISS</h2>
  <h3>25 Rue Emile Zola</h3>
  <h3>69120 Vaulx-en-Velin</h3>
</div>
<div class="">

  <?php
  $client = new Users;

  foreach ($Action['data'] as $key => $value) {
    $search_result = $client->search(["ID" => $value['user_ID']]);

    if (isset($search_result['data']) && count($search_result['data']) >=1){
      $nom = $search_result['data'][0]["nom"];
      $raison_s = $search_result['data'][0]["raison_sociale"];
      $adresse = $search_result['data'][0]["adresse"];
      $ville = $search_result['data'][0]["ville"];
      $code_p = $search_result['data'][0]["code_postale"];

    }
  ?>
  <h2> <?=$nom ?> <?=$raison_s ?></h2>
  <h3> <?=$adresse ?></h3>
  <h3> <?=$code_p ?> <?=$ville ?> </h3>
  <?php } ?>

</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Référence</th>
      <th scope="col">Désignation</th>
      <th scope="col">Quantité</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $article = new Articles;

    foreach ($Action['data'] as $key => $value) {
      $search_result = $article->search(["ID" => $value['article_ID']]);

      if (isset($search_result['data']) && count($search_result['data']) >=1){
        $nom = $search_result['data'][0]["nom"];
        $id = $search_result['data'][0]["ID"];

      }
    ?>

      <tr>
        <td> <?= $id ?> </td>
        <td> <?= $nom ?> </td>
        <td> <?= $value['quantite'] ?></td>

      </tr>
    <?php } ?>
  </tbody>

</table>
