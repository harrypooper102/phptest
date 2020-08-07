<?php
      session_start();
      $_SESSION['dino_id'] = $_GET['id'];
      if (isset($_SESSION["admin"])) {
        require_once 'header_admin.php';
      }
      elseif (isset($_SESSION['email'])) {
        require_once 'header_loggedin.php';
      }
      else {
        require_once 'header.php';
      }
      require 'config.php';
      try {
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $sth = $dbh->prepare("SELECT * FROM dino WHERE id = :id");
        $sth->bindValue(":id", $_GET["id"]);
        $sth->execute();
        $dino = $sth->fetch();
        echo "<div class='eachdino'><img src='{$dino['image']}'><p>Species: {$dino["species"]}</p><p>Info: {$dino["info"]}</p><p>Price: \${$dino['price']}</p><p>Units in stock: {$dino['stock']}</p><form action=\"buy.php\" method='post'><input type='hidden' value='{$_GET["id"]}' name='dino'><input type=\"submit\" class=\"buynow\" value=\"Add to Cart\"></form></div>";
      }
        catch (PDOException $e) {
            echo "<p>Error: {$e->getMessage()}</p>";
        }
        //use this session variable in buy.php to know which item to take stock from
     ?>

<?php
  require_once 'footer.php';
?>
