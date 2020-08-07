<?php
    //check if email and password are in the db
    session_start();
    require 'config.php';
      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
      try {
        $sth = $dbh->prepare("SELECT * FROM user WHERE :email = email");
        $sth->bindValue(':email', $_SESSION['email']);
        $sth->execute();
        $account = $sth->fetch();
        if(isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["new_password"])) {
          if (password_verify($_POST['password'], $account["password"])) {
            $sth = $dbh->prepare("UPDATE user SET password =:newPassword WHERE email = :email");
            $sth->bindValue(':newPassword', password_hash($_POST['new_password'], PASSWORD_DEFAULT));
            $sth->bindValue(':email', $_SESSION['email']);
            $sth->execute();
            //invalid parameter? thats ther error im getting
            //same
            header("Location:login.php?success=1");
            exit;
          }
          else {
            header("Location:account.php?invalid=1");
            exit;
          }
        }
        if (isset($_POST["address"]) && isset($_POST["new_address"])) {
          if ($_POST["address"] == $account["address"]) {
            $sth = $dbh->prepare("UPDATE user SET address = :address WHERE email = :email");
            $sth->bindValue(":address", $_POST["new_address"]);
            $sth->bindValue(":email", $_SESSION["email"]);
            $sth->execute();
            header("Location:account.php?success=1");
            exit;
          }
          else {
            header("Location:account.php?invalid=2");
            exit;
          }
        }
      }

      catch (PDOException $e) {
        echo"<p>bruh momentus</p>";
      }
 ?>
  </body>
</html>
