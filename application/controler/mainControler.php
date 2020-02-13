<?php

require_once('../application/model/Manager.php');
require_once('../application/model/DeparturesManager.php');
require_once('../application/model/StopAreaManager.php');
require_once('../application/model/UsersManager.php');

function stopAreaInfos($stopId)
{
  $departuresManager = new Bruno\Polyhack\Model\DeparturesManager();

  $json = $departuresManager->getDepartures($stopId);
  $json = json_decode($json, true);
  $stopAreaName = $json['departures'][0]['stop_point']['stop_area']['label'];
  $departure = $json['departures'][0];
  date_default_timezone_set('Europe/Paris');
  $now = new DateTime();
  $nextArrivalTime = new DateTime($departure['stop_date_time']['arrival_date_time']);
  $baseArrivalTime = new DateTime($departure['stop_date_time']['base_arrival_date_time']);
  $interval = $nextArrivalTime->diff($now);
  if ($interval->s > 30) {
    $interval = $interval->h *60 + $interval->i +1;
  } else {
    $interval = $interval->h *60 + $interval->i;
  }

  require('../application/view/stopAreaInfosView.php');
}

function isLate($next, $base)
{
  $lateInterval = $next->diff($base);
  if (($lateInterval->i * 60 + $lateInterval->s) > 0) {
    $late = true;
  } else {
    $late = false;
  }

  return $late;
}

function formatDate($dateISO)
{
  $d = new DateTime($dateISO);
  $hour = $d->format('H:i');
  return $hour;
}

function physicalModeToIcon($physicalMode)
{
  if ($physicalMode == 'Tramway') {
    return 'Tramway.svg';
  } elseif ($physicalMode == 'Bus') {
    return 'Bus.svg';
  }
}

function getCode($id)
{
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $stopAreaCode = $stopAreaManager->getCode($id);
  echo $stopAreaCode;
}

function getCoords($id)
{
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $latitude = $stopAreaManager->getLatitude($id);
  $longitude = $stopAreaManager->getLongitude($id);

  echo $latitude . '!' .$longitude;
}

function connectionPage()
{
  require('../application/view/connectionView.php');
}

function connectionProcess($username, $password) {
  $usersManager = new Bruno\Polyhack\Model\UsersManager();

  $user = $usersManager->getPasswordHash($username);

  if (password_verify($password, $user['password'])) {
    $_SESSION['id'] =$user['user_id'];
    header('Location: index.php?action=configuration');
  } else {
    header('Location: index.php?action=connection&passwordIncorrect=true');
  }
}

function configuration() {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $stopAreas = $stopAreaManager->getStopAreas();

  require('../application/view/configurationView.php');
}

function boxConfiguration() {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();

  $freeStopAreasReq = $stopAreaManager->getFreeStopAreas();
  $countStopAreas = $stopAreaManager->countStopArea();

  foreach ($freeStopAreasReq as $row) {
    $freeStopAreas[] = $row;
  }

  require('../application/view/boxConfigurationView.php');
}

function updateWorks($stopId, $worksValue) {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  if ($worksValue == 'true') {
    $worksValue = true;
  } else {
    $worksValue = false;
  }
  $update = $stopAreaManager->updateWorks($stopId, $worksValue);
  var_dump($worksValue);
}

function addStopArea($code) {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $stopAreaName = $stopAreaManager->getStopAreaName($code);
  echo $stopAreaName;
  $add = $stopAreaManager->addStopArea($stopAreaName, $code);
  echo $stopAreaName . " " . $code;

  header('Location: index.php?action=configuration');
}

function deleteStopArea($stopId) {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $delete = $stopAreaManager->deleteStopArea($stopId);
}

function checkAssignementBox($idBox) {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $assignement = $stopAreaManager->getStopAreaFromBox($idBox);

  return $assignement;
}

function setBoxToStopArea($idBox, $idStopArea) {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $assignement = $stopAreaManager->setStopAreaToBox($idBox, $idStopArea);
}

function unsetBoxToStopArea($idStopArea) {
  $stopAreaManager = new Bruno\Polyhack\Model\StopAreaManager();
  $assignement = $stopAreaManager->unsetStopAreaToBox($idStopArea);
}
