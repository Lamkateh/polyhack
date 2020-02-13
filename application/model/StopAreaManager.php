<?php

namespace Bruno\Polyhack\Model;

class StopAreaManager extends Manager {

  public function getCode($stopId) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT Code_Arret FROM arret WHERE ID_Arret = ?');
    $req->execute(array($stopId));
    $stopArea = $req->fetch();

    return $stopArea['Code_Arret'];
  }

  public function getStopAreas() {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT * FROM arret');
    $req->execute();

    return $req;
  }

  public function updateWorks($id, $value) {
    $db = $this->dbConnect();
    $req = $db->prepare('UPDATE arret SET Travaux = ? WHERE ID_Arret = ?');
    $req->execute(array($value, $id));
    return $value;
  }

  public function getStopAreaName($code) {
    $jsonurl = "https://" . $this::token . "@api.navitia.io/v1/coverage/fr-ne/stop_areas/" . $code. "/";
    $json = file_get_contents($jsonurl);
    $json = json_decode($json, true);
    return $json['stop_areas'][0]['name'];
  }

  public function addStopArea($name, $code) {
    $db = $this->dbConnect();
    $req = $db->prepare('INSERT INTO arret(Nom, Code_Arret) VALUES(?,?)');
    $req->execute(array($name, $code));

    return $req;
  }

  public function deleteStopArea($id) {
    $db = $this->dbConnect();
    $req = $db->prepare('DELETE FROM arret WHERE ID_Arret = ?');
    $req->execute(array($id));
  }

  public function getLatitude($id) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT latitude FROM arret WHERE ID_Arret = ?');
    $req->execute(array($id));
    $stopArea = $req->fetch();

    return $stopArea['latitude'];
  }

  public function getLongitude($id) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT longitude FROM arret WHERE ID_Arret = ?');
    $req->execute(array($id));
    $stopArea = $req->fetch();

    return $stopArea['longitude'];
  }

  public function getFreeStopAreas() {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT * FROM arret WHERE ID_Boitier = 0');
    $req->execute();

    return $req;
  }

  public function countStopArea() {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT COUNT(*) AS count FROM arret');
    $req->execute();
    $stopArea = $req->fetch();

    return $stopArea['count'];
  }

  public function getStopAreaFromBox($idBox) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT ID_Arret, Nom, Code_Arret FROM `arret` WHERE ID_Boitier = ?');
    $req->execute(array($idBox));
    $stopArea = $req->fetch();

    return $stopArea;
  }

  public function setStopAreaToBox($idBox, $idStopArea) {
    $db = $this->dbConnect();
    $req = $db->prepare('UPDATE arret SET ID_Boitier = ? WHERE ID_Arret = ?');
    $req->execute(array($idBox, $idStopArea));
  }

  public function unsetStopAreaToBox($idStopArea) {
    $db = $this->dbConnect();
    $req = $db->prepare('UPDATE arret SET ID_Boitier = 0 WHERE ID_Arret = ?');
    $req->execute(array($idStopArea));
  }

}
