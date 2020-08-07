<?php
  session_start();
  if (isset($_SESSION["admin"])) {
    require_once 'header_admin.php';
  }
  else if(isset($_SESSION["email"])){
    require_once 'header_loggedin.php';
  }
  else {
    header("Location:login.php");
    exit;
  }
  require_once 'config.php';
  if (isset($_GET["success"])) {
    if ($_GET["success"] == 1) {
      echo "<div class='success'><p>You have changed your address</p></div>";
    }
    if ($_GET["success"] == 2) {
      echo "<div class='success'><p>Purchase successful!</p></div>";
    }
  }
  if (isset($_GET["invalid"])) {
    if ($_GET["invalid"] == 1) {
      echo "<div class='error'><p>You must enter a valid password</p></div>";
    }
    if ($_GET["invalid"] == 2) {
      echo "<div class='error'><p>You must enter a valid address</p></div>";
    }
  }
?>
  <div id="account_div">
    <?php
      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
      $sth = $dbh->prepare("SELECT * FROM user WHERE email = :email");
      $sth->bindValue(":email", $_SESSION["email"]);
      $sth->execute();
      $account = $sth->fetch();
      echo "<div class='change'><h2>Your info:</h2><div class='info'><p>Name: {$account["name"]}</p><p>Email: {$account["email"]}</p><p>Shipping Address: {$account["address"]}</p></div></div>";
    ?>
    <!--self submitting form to change user passwords -->
    <style scoped="true">
      body{
        background-image: url(images/accountback.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
      }
    </style>
    <div class="change">
      <p class="header">Order History</p>
      <div class="info">
        <?php
          // on the admin header the dinosaurs link sends you to admin.php?id=1 instead of the dinosaurs page
          $sth = $dbh->prepare("SELECT * FROM user WHERE email = :currentEmail");
          $sth->bindValue(":currentEmail", $_SESSION["email"]);
          $sth->execute();
          $userInfo = $sth->fetch();

          //$sth = $dbh->prepare("SELECT * FROM cart");
          $sth = $dbh->prepare("SELECT dino.species, purchase.id, dino.price FROM cart INNER JOIN purchase ON cart.purchase_id = purchase.id INNER JOIN dino ON cart.dino_id = dino.id /*INNER JOIN accessory ON cart.accessory_id = accessory.id*/ WHERE purchase.user_id = :id ORDER BY purchase.id ASC");
          $sth->bindValue(":id", $userInfo["id"]);
          $sth->execute();
          $dino_purchases = $sth->fetchAll();

          $sth = $dbh->prepare("SELECT accessory.name, purchase.id, accessory.price FROM cart INNER JOIN purchase ON cart.purchase_id = purchase.id /*INNER JOIN dino ON cart.dino_id = dino.id*/ INNER JOIN accessory ON cart.accessory_id = accessory.id WHERE purchase.user_id = :id ORDER BY purchase.id ASC");
          $sth->bindValue(":id", $userInfo["id"]);
          $sth->execute();
          $accessory_purchases = $sth->fetchAll();
          if (count($accessory_purchases) == 0 && count($dino_purchases) == 0) {
            echo "<p>You have no orders</p>";
          }
          else {
            echo "<div class='purchases'><table><table><tr><th>Order #</th><th>Item</th><th>Price</th></tr>";
            foreach ($dino_purchases as $dino) {
              echo "<tr><td>{$dino["id"]}</td><td>{$dino["species"]}</td><td>\${$dino["price"]}</td></tr>";
            }
            foreach ($accessory_purchases as $accessory) {
              echo "<tr><td>{$accessory["id"]}</td><td>{$accessory["name"]}</td><td>\${$accessory["price"]}</td></tr>";
            }
            echo "</table></div>";
          }
          // $sth = $dbh->prepare("SELECT dino.species, dino.price, user.address FROM purchase INNER JOIN user ON purchase.user_id = user.id INNER JOIN dino ON purchase.dino_id = dino.id  WHERE user.email = :email ORDER BY purchase.id");
          // $sth->bindValue(":email", $_SESSION["email"]);
          // $sth->execute();
          // $dino_purchases = $sth->fetchAll();
          // //select the dinos in the first sth, then select the accessories so we don't get null values
          // $sth = $dbh->prepare("SELECT accessory.name, accessory.price, user.address FROM purchase INNER JOIN user ON purchase.user_id = user.id INNER JOIN accessory ON purchase.accessory_id = accessory.id WHERE user.email = :email ORDER BY purchase.id");
          // $sth->bindValue(":email", $_SESSION["email"]);
          // $sth->execute();
          // $accessory_purchases = $sth->fetchAll();
          // echo "<div class='purchases'><table><table><tr><th>Item</th><th>Price</th></tr>";
          // //isnt this a 2d array already. ya cause its a fetchall. thats why we use foreach
          // foreach ($dino_purchases as $dino) {
          //   echo "<tr><td>{$dino["species"]}</td><td>\${$dino["price"]}</td></tr>";
          // }
          // foreach ($accessory_purchases as $accessory) {
          //   echo "<tr><td>{$accessory["name"]}</td><td>\${$accessory["price"]}</td></tr>";
          // }
          // echo "</table></div>";
          //testing, viewing the purchase table
        ?>
      </div>
    </div>
    <form class="change" action="change_password.php" method="post">
      <p class="header">Change Your Password</p>
      <div class="info">
          <p>Current Email</p>
          <input type = "email" name="email" required>
          <p>Current Password</p>
          <input type="password" name="password" required>
          <p>New Password</p>
          <input type="password" name="new_password" required><br>
        <button type="submit" class="adminbtn">Change password</button><br>
        <small>Finished? <a href="login.php">Log in here</a>
      </div>
    </form>
  </div>
  <form class="change" action='change_password.php' method='post'>
    <p class="header">Change your shipping address</p>
    <div class="info">
      <p>Current Shipping Address</p>
      <input type='text' name='address'>
      <p>New Shipping Address</p>
      <input type='text' name='new_address'>
      <button type="submit" class="adminbtn">Change address</button><br>
    </div>
  </form><br>
<?php
  require_once 'footer.php';
?>
