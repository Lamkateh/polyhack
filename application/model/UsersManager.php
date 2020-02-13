<?php

namespace Bruno\Polyhack\Model;

class UsersManager extends Manager {

  public function getPasswordHash($username) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT user_id, password FROM users WHERE username = ?');
    $req->execute(array($username));
    $user = $req->fetch();

    return $user;
  }
}
