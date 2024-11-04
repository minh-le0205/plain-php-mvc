<?php

class Product
{

  public function getData(): array
  {
    $dsn = "mysql:host=localhost;dbname=php-mvc;charset=utf8mb4;port=3306";

    $pdo = new PDO($dsn, "root", "", [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->query("SELECT * FROM product");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
