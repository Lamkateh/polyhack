<?php

namespace Bruno\Polyhack\Model;

class DeparturesManager extends Manager {

  public function getDepartures($stopId) {
    $jsonurl = "https://" . $this::token . "@api.navitia.io/v1/coverage/fr-ne/stop_areas/" . $stopId . "/departures?count=3";
    $json = file_get_contents($jsonurl);
    return $json;
  }
}
