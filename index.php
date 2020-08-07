<?php
  session_start();
  require_once 'config.php';
  if (isset($_GET["error"])) {
    if ($_GET["error"] == 1) {
      echo "<div class=\"error\"><p>You have already logged in</p></div>";
    }
  }
  try {
      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
      if (isset($_SESSION["admin"])) {
        require_once 'header_admin.php';
        print_top();
      }
      elseif (isset($_SESSION["email"])) {
        require_once 'header_loggedin.php';
        print_top();
      }
      elseif (!(isset($_POST["email"])) || !(isset($_POST["password"]))) {
        echo "<div class=\"error\"><p>You have not <a href=\"login.php\">logged in.</a></p><p>You must sign in to purchase any items</p></div>";
        require_once 'header.php';
        print_top();
      }
      elseif (isset($_POST["email"]) && isset($_POST["password"])) {
        // seeing if the email and password are in database
        $sth = $dbh->prepare("SELECT email, password FROM user WHERE email = :email");
        $sth->bindValue(":email", $_POST["email"]);
        $sth->execute();
        $email_pass = $sth->fetch();
        $sth = $dbh->prepare("SELECT email, password FROM user WHERE id=1");
        $sth->execute();
        $admin = $sth->fetch();
        if ($_POST["email"] == $admin["email"] && $_POST["password"] == $admin["password"]){
          $_SESSION["admin"] = "admin";
          require_once 'header_admin.php';
          print_top();
        }
        else {
          //var dumping to see if these two match
          //this part works
          if ($email_pass["email"] == $_POST['email']) {
            if (password_verify($_POST["password"], $email_pass["password"])) {
              $_SESSION['email'] = $_POST["email"];
              require_once 'header_loggedin.php';
              print_top();
            }
            //its dis include_on
            else {
              header("Location:login.php?error=2");
              exit;
            }
          }
          else {
            header("Location:login.php?error=3");
            exit;
          }
        }
      }
      else {
        require_once 'header.php';
        print_top();
      }
  }
  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }
?>
      <div class="container">
        <div class="page_header">
          <h2>Most Popular</h2>
        </div><br>
        <?php //temporary fix
          try {
            // seeing if the email and password are in database
            $sth = $dbh->prepare("SELECT * FROM dino ORDER BY RAND() LIMIT 6");
            $sth->execute();
            $dinos = $sth->fetchAll();
            echo "<br>";
            foreach ($dinos as $dino) {
              echo "<div class=\"items\"><a href='dino.php?id={$dino["id"]}'><div class=\"within\"><img src=\"{$dino["image"]}\"><div class=\"text\"><p>{$dino["species"]}</p><p>\${$dino["price"]}</p></div></div></a></div>";
            }
            $sth = $dbh->prepare("SELECT * FROM accessory ORDER BY RAND() LIMIT 6");
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
