<?php

namespace Bruno\Polyhack\Model;

class Manager {
  const token = 'e1280723-4a73-4a27-ac2a-f65965479e8b';

  function dbConnect()
  {
    $db = new \PDO('mysql:host=localhost;dbname=polyhack;charset=utf8', 'root', '');
    return $db;
  }
}
