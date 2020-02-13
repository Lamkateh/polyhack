<?php $title ='Configuration'; ?>

<?php ob_start(); ?>

<div class="configuration-page">
  <div class="add-stopArea-container">
    <a href="index.php?action=boxConfiguration">Lier les boitiers</a>
    <form class="" action="index.php?action=addStopArea" method="post">
      <h1>Ajouter un arrêt</h1>
      <div class="group">
        <label for="codeInput">Code Navitia de l'arret :</label>
        <input type="text" name="code" id="codeInput">
        <input type="submit" value="Ajouter" class="btn">
      </div>
    </form>
  </div>
  <table class="stopArea-list">
    <?php foreach ($stopAreas as $stopArea) { ?>
      <tr class="stopArea">
        <td><?= $stopArea['Nom'] ?></td>
        <td><?= $stopArea['Code_Arret'] ?></td>
        <td>Travaux : <input class="worksCheckbox" type="checkbox"<?php if ($stopArea['Travaux']) {echo 'checked';} ?> data-stop-id='<?= $stopArea['ID_Arret'] ?>'></td>
        <td>
          <button type="button" class="btn delete-toggle">Supprimer</button>
          <button type="button" class="btn delete-button" data-stop-id="<?= $stopArea['ID_Arret'] ?>">Confirmer</button>
        </td>
      </tr>


    <?php } ?>
  </table>
</div>

<script type="text/javascript">
  $('.worksCheckbox').change(function() {
    $.ajax({
      url : 'index.php?action=updateWorks&stopId=' + $(this).data('stop-id') + '&worksValue=' + $(this).is(":checked"),
      type: 'GET',
      success : function(result){

      }
    });
  });

  $('.delete-toggle').click(function() {
    $(this).css('display', 'none')
    $(this).siblings('.delete-button').css('display', 'inline-block')
  });
  $('.delete-button').click(function() {
    console.log($(this).data('stop-id'));
    $(this).parent().parent().remove();
    $.ajax({
      url : 'index.php?action=deleteStopArea&code=' + $(this).data('stop-id'),
      type: 'GET',
      success : function(result){

      }
    });
  });
</script>

<?php $content = ob_get_clean(); ?>

<?php require('../application/view/template.php'); ?>
