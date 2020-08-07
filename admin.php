<?php
  session_start();
  if (isset($_SESSION["admin"])) {
    require_once 'header_admin.php';
  }
  else {
    header("Location: index.php");
    exit;
  }
  if (isset($_GET["id"])) {
    if ($_GET["id"] == 1) {
      echo "<div class=\"error\"><p>You must fill out all text fields</p></div>";
    }
  }
?>
<style scoped="true">
  body{
    background-image: url(images/loginback.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
  }
</style>
<div id="admin_div">
  <form action="dinosaurs.php" method="post">
    <p class="header">Add a dinosaur</p>
    <div class="info">
      <p>Species</p>
      <input type = "text" name="species" required>
      <p>Info</p>
      <textarea name="info" rows="5" cols="50"></textarea>
      <p>Price</p>
      <input type = "number" name="price" required>
      <p>Image (link required)</p>
      <input type = "text" name="image" required>
      <p>Stock</p>
      <input type = "number" name="stock" required><br>
      <button type="submit" class= "adminbtn">Add dinosaur</button>
    </div><br><br>
  </form>
  <form action="accessories.php" method="post">
    <p class="header">Add an accessory</p>
    <div class="info">
      <p>Name</p>
      <input type="text" name="accessory_name" required>
      <p>Price</p>
      <input type="number" name="accessory_price" required>
      <p>Image hotlink</p>
      <input type="text" name="accessory_image" required>
      <p>Stock</p>
      <input type="number" name="accessory_stock" required><br>
      <button type="submit" class= "adminbtn">Add accessory</button>
    </div>
  </form>
  <form action="dinosaurs.php" method="post">
    <p class="header">Remove a dinosaur</p>
    <div class="info">
      <select name="remove_dino" required>
        <?php
          require_once "config.php";
          try {
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $sth = $dbh->prepare("SELECT * FROM dino ORDER BY id ASC");
            $sth->execute();
            $dinos = $sth->fetchAll();
            foreach ($dinos as $dino) {
              echo "<option value='{$dino["id"]}'>{$dino["species"]}</option>";
            }
          }
          catch (PDOException $e) {
              echo "<p>Error: {$e->getMessage()}</p>";
          }
        ?>
      </select>
      <br><button type="submit" class="loginbtn">Remove</button>
    </div>
  </form>
  <form action="accessories.php" method="post">
    <p class="header">Remove an accessory</p>
    <div class="info">
      <select name="remove_acc" required>
        <?php
          try {
            $sth = $dbh->prepare("SELECT * FROM accessory ORDER BY id ASC");
            $sth->execute();
            $accessories = $sth->fetchAll();
            foreach ($accessories as $accessory) {
              echo "<option value='{$accessory["id"]}'>{$accessory["name"]}</option>";
            }
          }
          catch (PDOException $e) {
              echo "<p>Error: {$e->getMessage()}</p>";
          }
        ?>
      </select>
      <br><button type="submit" class="loginbtn">Remove</button>
    </div>
  </form></br>
</div>
