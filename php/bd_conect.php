<?php
try {
  $dns = "mysql:dbname=transfast;host=localhost";
  $user = "root";
  $pass = "";
  $pdo  = new PDO($dns, $user, $pass);
} catch (PDOException $e) {
  echo "Falha: " . $e->getMessage();
}

?>
