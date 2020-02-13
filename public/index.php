<?php
session_start();

require_once('../application/controler/mainControler.php');

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'stopAreaInfos') {
    if (isset($_GET['stopId'])) {
      stopAreaInfos($_GET['stopId']);
    } else {
      echo 'Aucun arrêt spécifié';
    }
  } elseif ($_GET['action'] == 'api') {
    if (isset($_GET['ask'])) {
      if ($_GET['ask'] == 'code') {
        if (isset($_GET['id'])) {
          getCode($_GET['id']);
        }
      } elseif ($_GET['ask'] == 'coords') {
        if (isset($_GET['id'])) {
          getCoords($_GET['id']);
        }
      }
    }
  } elseif ($_GET['action'] == 'configuration') {
    if (isset($_SESSION['id'])) {
      configuration();
    } else {
      echo "Accès non autorisé";
    }
  } elseif ($_GET['action'] == 'boxConfiguration') {
    boxConfiguration();
  } elseif ($_GET['action'] == 'connection') {
    connectionPage();
  } elseif ($_GET['action'] == 'connectionProcess') {
    connectionProcess($_POST['username'], $_POST['password']);
  } elseif ($_GET['action'] == 'updateWorks') {
    if (isset($_SESSION['id'])) {
      updateWorks($_GET['stopId'], $_GET['worksValue']);
    } else {
      echo "Accès non autorisé";
    }
  } elseif ($_GET['action'] == 'addStopArea') {
    if (isset($_SESSION['id'])) {
      addStopArea($_POST['code']);
    } else {
      echo "Accès non autorisé";
    }
  } elseif ($_GET['action'] == 'deleteStopArea') {
    if (isset($_SESSION['id'])) {
      deleteStopArea($_GET['code']);
    } else {
      echo "Accès non autorisé";
    }
  } elseif ($_GET['action'] == 'setBoxToStopArea') {
    setBoxToStopArea($_GET['idBox'], $_GET['idStopArea']);
  } elseif ($_GET['action'] == 'unsetBoxToStopArea') {
    unsetBoxToStopArea($_GET['idStopArea']);
  }
} else {
  //errorPage();
}
