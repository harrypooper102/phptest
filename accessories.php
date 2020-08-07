<?php
  session_start();
  if (isset($_SESSION["admin"])) {
    require_once 'header_admin.php';
  }
  elseif (isset($_SESSION['email'])) {
    require_once 'header_loggedin.php';
  }
  else {
    require_once 'header.php';
  }
  require_once 'config.php';
  print_top();
?>
      <div class="container">
        <div class="page_header">
          <h2>Accessories</h2>
        </div><br>
        <?php

          try {
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            if (isset($_SESSION["admin"])) {
              if (isset($_POST["accessory_name"]) && isset($_POST["accessory_price"]) && isset($_POST["accessory_image"]) && isset($_POST["accessory_stock"])) {
                $sth = $dbh->prepare("INSERT INTO accessory (name, price, image, stock) VALUES (:accessory_name, :accessory_price, :accessory_image, :accessory_stock)");
                $sth->bindValue(':accessory_name', $_POST['accessory_name']);
                $sth->bindValue(':accessory_price', $_POST['accessory_price']);
                $sth->bindValue(':accessory_image', $_POST['accessory_image']);
                $sth->bindValue(':accessory_stock', $_POST['accessory_stock']);
                $sth->execute();
              }
              elseif (isset($_POST["remove_acc"])) {
                $sth = $dbh->prepare("SELECT * FROM accessory WHERE id = :id");
                $sth->bindValue(":id", $_POST["remove_acc"]);
                $sth->execute();
                $remove = $sth->fetch();
                $sth = $dbh->prepare("DELETE FROM accessory WHERE id = :id");
                $sth->bindValue(":id", $remove["id"]);
                $sth->execute();
              }
              else {
                header("Location:admin.php?id=1");
              }
            }
            $sth = $dbh->prepare("SELECT * FROM accessory");
            $sth->execute();
            $accessories = $sth->fetchAll();
            foreach ($accessories as $accessory) {
              echo "<div class=\"items\"><a href='accessory.php?id={$accessory["id"]}'><div class=\"within\"><img src=\"{$accessory["image"]}\"><div class=\"text\"><p>{$accessory["name"]}</p><p>\${$accessory["price"]}</p></div></div></a></div>";
            }

          }
          catch (PDOException $e) {
              echo "<p>Error: {$e->getMessage()}</p>";
          }
        ?>
      </div>
<?php
  require_once 'footer.php';
?>
