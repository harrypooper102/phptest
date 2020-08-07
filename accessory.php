<?php
      session_start();
      $_SESSION['accessory_id'] = $_GET['id'];
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
        $sth = $dbh->prepare("SELECT * FROM accessory WHERE id = :id");
        $sth->bindValue(":id", $_GET["id"]);
        $sth->execute();
        $accessories = $sth->fetch();
        echo "<div class='eachdino'><img src='{$accessories['image']}'><p>Item: {$accessories['name']}</p><p>Price: $ {$accessories['price']}</p><p>Units in stock: {$accessories['stock']}</p><form action=\"buy.php\" method='post'><input type='hidden' value='{$accessories["id"]}' name='accessory'><input type=\"submit\" value=\"Buy Now!\"></form></div>";
      }
      catch (PDOException $e) {
          echo "<p>Error: {$e->getMessage()}</p>";
      }
        //use this session variable in buy.php to know which item to take stock from
     ?>
<?php
    require_once 'footer.php';
?>
