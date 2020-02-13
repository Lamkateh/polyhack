<?php $title ='Configuration des boîtiers'; ?>

<?php ob_start(); ?>

<table class="stopArea-list">
  <?php $iBoitier = 1; ?>
  <?php for ($i=0; $i < $countStopAreas; $i++) { ?>
    <tr class="stopArea">
      <td><?= $iBoitier ?></td>
      <td>
        <?php if(!checkAssignementBox($iBoitier)) { ?>
          <select class="selectStopArea" data-box-id="<?= $iBoitier ?>">
            <option value=""<?php if(!checkAssignementBox($iBoitier)) { echo 'selected'; } ?>>Aucun</option>
            <?php foreach ($freeStopAreas as $freeStopArea) { ?>
              <option value="<?= $freeStopArea['ID_Arret'] ?>" <?php if ($freeStopArea['ID_Boitier'] == $iBoitier) {echo 'selected';} ?> ><?= $freeStopArea['Nom'] ?> | <?= $freeStopArea['Code_Arret'] ?></option>
            <?php } ?>
          </select>
        <?php } else {
          echo checkAssignementBox($iBoitier)['Nom'] . " | " . checkAssignementBox($iBoitier)['Code_Arret'];
          ?>
          <span class="unset" data-stop-area-id="<?= checkAssignementBox($iBoitier)['ID_Arret'] ?>">Supprimer</span>
        <?php } ?>

      </td>
    </tr>

    <?php $iBoitier++ ?>
  <?php } ?>
</table>

<script type="text/javascript">
  $('.selectStopArea').change(function() {
    console.log('cahnge');
    $.ajax({
      url : 'index.php?action=setBoxToStopArea&idBox=' + $(this).data('box-id') + '&idStopArea=' + $(this).children("option:selected").val(),
      type: 'GET',
      success : function(result){

      }
    });
  });

  $('.unset').click(function() {
    $.ajax({
      url : 'index.php?action=unsetBoxToStopArea&idStopArea=' + $(this).data('stop-area-id'),
      type: 'GET',
      success : function(result){

      }
    });
  });
</script>

<?php $content = ob_get_clean(); ?>

<?php require('../application/view/template.php'); ?>
