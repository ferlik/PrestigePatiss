<form class=""  method="post">
  <input type="text" name="nom" value="" placeholder="nom">
  <input type="number" step="0.01"  min="0.01" name="prix" value="" placeholder="prix">
  <select class="" name="desactive">
    <option value="1">désactivé</option>
    <option value="0" selected="selected">activé</option>
  </select>
  <input type="submit" name="" value="ajouter">
</form>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Prix</th>
      <th>Retiré</th>
      <th colspan="2">option</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($Action['data'] as $key => $value) {
    ?>
      <tr style="border: 1px solid black">
        <td> <?= $value['nom'] ?> </td>
        <td> <?= $value['prix'] ?> </td>
        <?php
        if ($value['desactive'] == 0){ ?>
            <td>Non</td>
        <?php
        } else { ?>
          <td>Oui</td>
        <?php } ?>
        <td> <a href="?action=deleteArticle&ID=<?=$value['ID']  ?>"> Supprimer</a> </td>
        <td> boutoon </td>
      </tr>
    <?php } ?>
  </tbody>

</table>
