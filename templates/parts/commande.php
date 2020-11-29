<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Numéro commande</th>
      <th scope="col">date</th>
      <th scope="col">Client</th>
      <th scope="col">raison sociale</th>
      <th scope="col">supprimer</th>
      <th scope="col">Détail</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $user = new Users;

    foreach ($Action['data'] as $key => $value) {

      $search_result = $user->search(["ID" => $value['user_ID']]);

      if (isset($search_result['data']) && count($search_result['data']) >=1){
        $nom_Client = $search_result['data'][0]["nom"];
        $raison_sociale_Client = $search_result['data'][0]["raison_sociale"];
      }
    ?>
      <tr style="border: 1px solid black">
        <td> com <?= $value['ID'] ?> </td>
        <td> <?= $value['date_commande'] ?> </td>
        <td> <?= $nom_Client ?> </td>
        <td> <?= $raison_sociale_Client ?></td>
        <td> <a href="?action=deleteCommande&ID=<?=$value['commande_number']?>">supprimer</a> </td>
        <td> <a href="?action=commandeDetail&ID=<?=$value['commande_number']?>">detail</a> </td>
      </tr>
    <?php } ?>
  </tbody>

</table>
<td> <a href="?action=ajoutCommandes">ajouter</a> </td>
