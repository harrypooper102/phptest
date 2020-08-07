<?php
  require_once 'header.php';
  echo "<style scoped=\"true\">body{background-image: url(images/loginback.jpg);}</style>";
  require_once 'config.php';
  try{
    echo "<div id=\"registration_div\"><div class=\"register\"><p class=\"header\"></p><div class=\"info\">";//right here. so you can put it anywhere
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD); //ok
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $address = $_POST["address"];
    //SQL insert into the table the users information


    //making sure one email can only have one account
    $sth = $dbh->prepare("SELECT email FROM user WHERE email = :email");
    $sth->bindValue(':email', $_POST['email']);
    $sth->execute();
    $emails = $sth->fetchAll();
    //if the email is already registered, we can check if the $emails array has anything
    //if it has anything, the email is registered and we should not put another account in the db

    // //if the password and repassword dont match link back to the registration
    if ($_POST['password'] == $_POST['repassword'] && filter_var($email, FILTER_VALIDATE_EMAIL) &&
    $name != "" && $password != "" && count($emails) == 0) {
      //validate registration information
      //it works now I think
      $sth = $dbh->prepare("INSERT INTO user (`name`, `password`, `email`, `address`) VALUES (:name, :password, :email, :address)");
      $sth->bindValue(':name', $name);
      $sth->bindValue(':password', $password);
      $sth->bindValue(':email', $email);
      $sth->bindValue(':address', $address);
      $sth->execute();
      echo "You have registered<form action=\"login.php\"><button class=\"registerbtn\">Log In</button></form>";

    }
    else {
      echo "<p>Invalid info, or this email already has an account.</p>";
      echo "<form action=\"register.php\"><button class=\"registerbtn\">Re-enter your info</button></form>";
    }
    echo "</div></form></div>";
  }
  catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
  }
  require_once 'footer.php';
?>
