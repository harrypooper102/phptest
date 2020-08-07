<?php
  session_start();
  if (isset($_GET["remove"])) {
    if ($_GET["remove"] == 1) {
      echo "<div class='success'><p>You have removed an item</p></div>";
    }
  }
  if (isset($_SESSION["admin"])) {
    require_once 'header_admin.php';
  }
  elseif(isset($_SESSION["email"])){
    require_once 'header_loggedin.php';
  }
  else {
    header("Location:login.php");
    exit;
  }
  require_once 'config.php';
?>
<style scoped="true">
  body{
    background-image: url(images/cartback.jpg);
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>
<div class="cart">
  <h1>Your cart</h1>
  <div class="info">
  <?php
    try {
      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

      $sth = $dbh->prepare("SELECT * FROM user WHERE email = :email");
      $sth->bindValue(":email", $_SESSION["email"]);
      $sth->execute();
      $user = $sth->fetch();
      if (isset($_POST["dino"])) {
        $sth = $dbh->prepare("INSERT INTO `cart` (`dino_id`, `user_id`) VALUES (:dino_id, :user_id)");
        $sth->bindValue(":dino_id", $_POST["dino"]);
        $sth->bindValue(":user_id", $user["id"]);
        $sth->execute();
      }
      $sth = $dbh->prepare("SELECT dino.species, dino.id, dino.price, dino.stock FROM cart INNER JOIN user ON cart.user_id = user.id INNER JOIN dino ON cart.dino_id = dino.id WHERE user.id = :user_id AND purchase_id IS NULL ORDER BY cart.id");
      $sth->bindValue(":user_id", $user["id"]);
      $sth->execute();
      $selected_dino = $sth->fetchAll();
      //select the dinos in the first sth, then select the accessories so we don't get null values
      if (isset($_POST["accessory"])) {
        $sth = $dbh->prepare("INSERT INTO `cart` (`accessory_id`, `user_id`) VALUES (:accessory_id, :user_id)");
        $sth->bindValue(":accessory_id", $_POST["accessory"]);
        $sth->bindValue(":user_id", $user["id"]);
        $sth->execute();
      }
      $sth = $dbh->prepare("SELECT accessory.name, accessory.price, accessory.stock, user.address FROM cart INNER JOIN user ON cart.user_id = user.id INNER JOIN accessory ON cart.accessory_id = accessory.id AND purchase_id IS NULL WHERE user.id = :user_id ORDER BY cart.id");
      $sth->bindValue(":user_id", $user["id"]);
      $sth->execute();
      $selected_accessory = $sth->fetchAll();

      $sth = $dbh->prepare("SELECT * FROM cart WHERE user_id = :id AND purchase_id IS NULL ORDER BY id ASC");
      $sth->bindValue(":id", $user["id"]);
      $sth->execute();
      $cart_items = $sth->fetchAll();
      //var_dump($cart_items);


      // if (isset($_GET['dino_id'])) {
      //   $_SESSION['dino_id'] = $_GET['dino_id'];
      // }
      // if (isset($_GET['accessory_id'])) {
      //   $_SESSION['accessory_id'] = $_GET['accessory_id'];
      // }
      // if (isset($_SESSION['dino_id'])) {
      //   $sth = $dbh->prepare("SELECT * FROM dino WHERE id = :dino_id");
      //   $sth->bindValue(":dino_id", $_SESSION["dino_id"]);
      //   $sth->execute();
      //   $selected_dino = $sth->fetch();
      // }
      // if (isset($_SESSION['accessory_id'])) {
      //   $sth = $dbh->prepare("SELECT * FROM accessory WHERE id = :accessory_id");
      //   $sth->bindValue(":accessory_id", $_SESSION["accessory_id"]);
      //   $sth->execute();
      //   $selected_accessory = $sth->fetch();
      // }
      // //output
      // //so no session?

      if (count($selected_dino) == 0 && count($selected_accessory) == 0) {
          echo "<p>Your cart is empty.</p>";
      }
      else{
        echo "<table><tr><th>Item #</th><th>Item</th><th>Price</th><th>Stock</th></tr>";
        $counter = 0;
        if (isset($selected_dino)) {
          foreach ($selected_dino as $dino) {
            $counter += 1;
            echo "<tr>";
            echo "<td>{$counter}</td>";
            echo "<td>";
            echo $dino['species'];
            echo "</td>";

            echo "<td>";
            echo $dino['price'];
            echo "</td>";

            echo "<td>";
            echo $dino['stock'];
            echo "</td>";
            echo "</tr>";
          }
        }

        elseif(isset($selected_accessory)) {
          foreach ($selected_accessory as $accessory) {
            $counter += 1;
            echo "<tr>";
            echo "<td>{$counter}</td>";
            echo "<td>";
            echo $accessory['name'];
            echo "</td>";

            echo "<td>";
            echo $accessory['price'];
            echo "</td>";

            echo "<td>";
            echo $accessory['stock'];
            echo "</td>";
            echo "</tr>";
          }
        }
        echo "</tr></table>";
      // echo "<table><tr>";
      // if (isset($selected_accessory)) {
      //   foreach ($selected_accessory as $accessory) {
      //     echo "<tr>";
      //     echo "<td>";
      //     echo $accessory['name'];
      //     echo "</td>";
      //
      //     echo "<td>";
      //     echo $accessory['price'];
      //     echo "</td>";
      //
      //     echo "<td>";
      //     echo $accessory['stock'];
      //     echo "</td>";
      //     echo "</tr>";
      //   }
      // }
      // echo "</tr></table>";
      // if (isset($_POST["dino"]) && isset($_POST["accessory"])) {
      //   echo "<table><tr><th>Item</th><th>Price</th><th>Stock</th></tr>";
      //   echo "<tr><td>{$selected_dino['species']}</td><td>\${$selected_dino['price']}</td><td>{$selected_dino['stock']}</td></tr>";
      //   echo "<tr><td>{$selected_accessory['name']}</td><td>\${$selected_accessory['price']}</td><td>{$selected_accessory['stock']}</td></tr>";
      //   echo "</table>";
      // }
      // elseif (isset($_POST['dino']) && !(isset($_POST['accessory']))) {
      //   echo "<table><tr><th>Item</th><th>Price</th><th>Stock</th></tr>";
      //   echo "<tr><td>{$selected_dino['species']}</td><td>\${$selected_dino['price']}</td><td>{$selected_dino['stock']}</td></tr>";
      //   echo "</table>";
      // }
      // elseif (isset($_POST["dino"]) && !(isset($_POST["accessory"]))) {
      //   echo "<table><tr><th>Item</th><th>Price</th><th>Stock</th></tr>";
      //   echo "<tr><td>{$selected_accessory['name']}</td><td>\${$selected_accessory['price']}</td><td>{$selected_accessory['stock']}</td></tr>";
      //   echo "</table>";
      // }
      //
      //
        echo "<form action='purchase.php' method='post'><input class='loginbtn' type='submit' value='Purchase'></form><br>";
        echo "<div class='cartdouble'><form action='buy.php' method='post'><p>Change your shipping address (Will update your account information):</p><input type='text' name='new_address' required><br><input id='addressbtn' type='submit' value='Change Address'></form>";
        if(isset($_POST["new_address"])){
          $sth = $dbh->prepare("UPDATE user SET address = :address WHERE email = :email");
          $sth->bindValue(":address", $_POST["new_address"]);
          $sth->bindValue(":email", $_SESSION["email"]);
          $sth->execute();
          echo "You have changed your shipping address to {$_POST["new_address"]}";
        }
        echo "</div><br><div class='cartdouble'><p>Remove from cart:</p>";
        echo "<form action='remove.php' method='post'><select name='itemtoremove' id='itemtoremove' required>";
        echo "<option value=''>Select</option>";
        $counter2 = 0;
        foreach ($cart_items as $cart) {
          $counter2++;
          echo "<option value='{$cart['id']}'>{$counter2}</option>";
        }
        echo "</select>";
        echo "<br><input class='loginbtn' type='submit' value='Remove'>";
        echo "</form></div>";
      }

    }
    catch (PDOException $e) {
        echo "<p>Error: {$e->getMessage()}</p>";
    }
  ?>
  </div>
</div>
<?php require_once 'footer.php'; ?>
