<form class="" method="post">
  <input type="text" name="nom" value="" placeholder="nom">
  <input type="text" name="siret" value="" placeholder="siret">
  <input type="text" name="raison_sociale" value="" placeholder="R_social">
  <input type="text" name="passwd" value="" placeholder="password">
  <input type="text" name="telephone" value="" placeholder="phone">
  <input type="text" name="adresse" value="" placeholder="adresse">
  <input type="text" name="code_postale" value="" placeholder="c-p">
  <input type="text" name="ville" value="" placeholder="ville">

  <input type="text" name="mail" value="" placeholder="mail">
  <select class="" name="role">
    <option value="0">client</option>
    <option value="1">admin</option>
  </select>
  <input type="submit" name="" value="créer">
</form>


<table>
  <thead>
    <tr>
      <th>nom</th>
      <th>siret</th>
      <th>raison sociale</th>
      <th>option</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Action['data'] as $key => $value) {?>
      <tr>
        <td> <?= $value['nom'] ?> </td>
        <td> <?= $value['siret'] ?> </td>
        <td> <?= $value['raison_sociale'] ?></td>
        <td> <a href="?action=deleteUser&ID=<?=$value['ID']?>">supprimer</a> </td>
      </tr>
    <?php } ?>
  </tbody>

</table>
<a href="?action=commande">commande</a>
