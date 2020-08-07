<?php
  session_start();
  if (!(isset($_SESSION["email"]))) {
    header("Location: login.php?error=1");
    exit;
  }
  try {
    require_once "config.php";
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $sth = $dbh->prepare("SELECT * FROM user WHERE email = :currentEmail");
    $sth->bindValue(":currentEmail", $_SESSION["email"]);
    $sth->execute();
    $userInfo = $sth->fetch();

    $sth = $dbh->prepare("INSERT INTO `purchase` (`complete`, `user_id`) VALUES ('true', :id)");
    $sth->bindValue(":id", $userInfo["id"]);
    $sth->execute();

    $sth = $dbh->prepare("SELECT * FROM purchase WHERE user_id = :id ORDER BY id DESC");
    $sth->bindValue(":id", $userInfo["id"]);
    $sth->execute();
    $purchase = $sth->fetch();
    var_dump($purchase);

    echo "<br>";
    var_dump($purchase["id"]);
    $sth = $dbh->prepare("UPDATE cart SET purchase_id = :purchase_id WHERE purchase_id IS NULL AND user_id = :id");
    $sth->bindValue(":purchase_id", $purchase["id"]);
    $sth->bindValue(":id", $userInfo["id"]);
    $sth->execute();

    $sth = $dbh->prepare("SELECT * FROM cart WHERE user_id = :id");
    $sth->bindValue(":id", $userInfo["id"]);
    $sth->execute();
    $cart_items = $sth->fetchAll();

    $sth = $dbh->prepare("SELECT * FROM purchase INNER JOIN cart ON cart.purchase_id = purchase.id INNER JOIN dino ON cart.dino_id = dino.id INNER JOIN accessory ON cart.accessory_id = accessory.id WHERE cart.user_id = :id");
    $sth->bindValue(":id", $userInfo["id"]);
    $sth->execute();
    $all_purchases = $sth->fetchAll();


    echo "<a href='index.php'>go home</a>";

    // if (isset($_SESSION["dino_id"]) && isset($_SESSION["accessory_id"])) {
    //   $sth = $dbh->prepare("INSERT INTO `purchase` (`user_id`, `dino_id`, `accessory_id`) VALUES (:currentUser, :selected_dino, :selected_accessory)");
    //   $sth->bindValue(":currentUser", $userInfo["id"]);
    //   $sth->bindValue(":selected_dino", $_SESSION["dino_id"]);
    //   $sth->bindValue(":selected_accessory", $_SESSION["accessory_id"]);
    //   $sth->execute();
    // }
    // else if (isset($_SESSION["dino_id"]) && !(isset($_SESSION["accessory_id"]))) {
    //   $sth = $dbh->prepare("INSERT INTO `purchase` (`user_id`, `dino_id`) VALUES (:currentUser, :selected_dino)");
    //   $sth->bindValue(":currentUser", $userInfo["id"]);
    //   $sth->bindValue(":selected_dino", $_SESSION["dino_id"]);
    //   $sth->execute();
    // }
    // else if (isset($_SESSION["accessory_id"]) && !(isset($_SESSION["dino_id"]))) {
    //   $sth = $dbh->prepare("INSERT INTO `purchase` (`user_id`, `accessory_id`) VALUES (:currentUser, :selected_accessory)");
    //   $sth->bindValue(":currentUser", $userInfo["id"]);
    //   $sth->bindValue(":selected_accessory", $_SESSION["accessory_id"]);
    //   $sth->execute();
    // }
    //
    // unset($_SESSION["dino_id"]);
    // unset($_SESSION["accessory_id"]);
    header("Location: account.php?success=2");
    exit;
  }
  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }


?>
