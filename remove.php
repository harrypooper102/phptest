<?php
  session_start();
  require_once 'config.php';
  try {
    var_dump($_POST["itemtoremove"]);
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    if (!(isset($_POST))) {
      // header("Location:buy.php");
      // exit;
    }
    elseif ($_POST["itemtoremove"] == '') {
      // header("Location:buy.php");
      // exit;
    }
    elseif (isset($_POST["itemtoremove"])) {
      $sth = $dbh->prepare("SELECT * FROM cart WHERE id = :id");
      $sth->bindValue(":id", $_POST["itemtoremove"]);
      $sth->execute();
      $sth = $dbh->prepare("DELETE FROM cart WHERE id = :id");
      $sth->bindValue(":id", $_POST["itemtoremove"]);
      $sth->execute();

      header("Location:buy.php?remove=1");
      exit;
    }
  }
  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }
?>
