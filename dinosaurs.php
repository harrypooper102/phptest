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
          <h2>Dinosaurs</h2>
        </div>
        <?php //temporary fix
          try {

            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            // seeing if the email and password are in database
            if (isset($_SESSION["admin"])) {

              if (isset($_POST["species"]) && isset($_POST["info"]) &&
              isset($_POST["price"]) && isset($_POST["image"]) &&
              isset($_POST["stock"]) && filter_var($_POST["price"], FILTER_VALIDATE_INT)) {
                $sth = $dbh->prepare("INSERT INTO `dino` (`species`, `info`, `price`, `image`, `stock`) VALUES (:species, :info, :price, :image, :stock)");
                $sth->bindValue(":species", $_POST["species"]);
                $sth->bindValue(":info", $_POST["info"]);
                $sth->bindValue(":price", $_POST["price"]);
                $sth->bindValue(":image", $_POST["image"]);
                $sth->bindValue(":stock", $_POST["stock"]);
                $sth->execute();
              }
              else if (isset($_POST["remove_dino"])) {
                $sth = $dbh->prepare("SELECT * FROM dino WHERE id = :id");
                $sth->bindValue(":id", $_POST["remove_dino"]);
                $sth->execute();
                $remove = $sth->fetch();
                $sth = $dbh->prepare("DELETE FROM dino WHERE id = :remove_id");
                $sth->bindValue(":remove_id", $remove['id']);
                $sth->execute();
              }
              else {
                header("Location:admin.php?id=1");
                exit;
              }
            }
            $sth = $dbh->prepare("SELECT * FROM dino");
            $sth->execute();
            $dinos = $sth->fetchAll();
            foreach ($dinos as $dino) {
              echo "<div class=\"items\"><a href='dino.php?id={$dino["id"]}'><div class=\"within\"><img src=\"{$dino["image"]}\"><div class=\"text\"><p>{$dino["species"]}</p><p>\${$dino["price"]}</p></div></div></a></div>";
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
