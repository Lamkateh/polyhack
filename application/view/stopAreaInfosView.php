<?php $title = $stopAreaName; ?>

<?php ob_start(); ?>

  <div class="container">
    <h1><?= $stopAreaName ?></h1>
    <h2>Dans <?= $interval ?> min</h2>
    <div class="departure-container <?php if (isLate(new DateTime($departure['stop_date_time']['arrival_date_time']),new DateTime($departure['stop_date_time']['base_arrival_date_time']))) { echo "late"; } ?>">
      <div class="departure col-12">
        <div class="row">
          <div class="col-3 arrival-time">
            <?= formatDate($departure['stop_date_time']['arrival_date_time']) ?>
          </div>
          <div class="col-3 icons">
            <div class="code" style="background-color: #<?= $departure['display_informations']['color'] ?>">
              <?= $departure['display_informations']['code'] ?>
            </div>
            <img src="images/<?= physicalModeToIcon($departure['display_informations']['physical_mode']) ?>" alt="Mode de transport">
          </div>
          <div class="col-6 direction">
            <?= $departure['display_informations']['direction'] ?>
          </div>
        </div>
      </div>
      <div class="late-container">
        Retard
      </div>
    </div>

    <h2>Prochainement</h2>
    <?php for($i=1; $i < count($json['departures']); $i++) {
      ?>
      <div class="departure-container <?php if (isLate(new DateTime($json['departures'][$i]['stop_date_time']['arrival_date_time']),new DateTime($json['departures'][$i]['stop_date_time']['base_arrival_date_time']))) { echo "late"; } ?>">
        <div class="departure col-12">
          <div class="row">
            <div class="col-3 arrival-time">
              <?= formatDate($json['departures'][$i]['stop_date_time']['arrival_date_time']) ?>
            </div>
            <div class="col-3 icons">
              <div class="code" style="background-color: #<?= $json['departures'][$i]['display_informations']['color'] ?>">
                <?= $json['departures'][$i]['display_informations']['code'] ?>
              </div>
              <img src="images/<?= physicalModeToIcon($json['departures'][$i]['display_informations']['physical_mode']) ?>" alt="Mode de transport">
            </div>
            <div class="col-6 direction">
              <?= $json['departures'][$i]['display_informations']['direction'] ?>
            </div>
          </div>
        </div>
        <div class="late-container">
          Retard
        </div>
      </div>
    <?php } ?>
  </div>

<?php $content = ob_get_clean(); ?>

<?php require('../application/view/template.php'); ?>
