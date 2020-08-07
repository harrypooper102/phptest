<?php
  if (isset($_SESSION["email"]) || isset($_SESSION["admin"])) {
    header("Location: index.php?error=1");
    exit;
  }
  else {
    require_once 'header.php';
  }
  if (isset($_GET["error"])) {
    if ($_GET["error"] == 1) {
      echo "<div class=\"error\"><p>You must enter your login credentials</p></div>";
    }
    if ($_GET["error"] == 2) {
      echo "<div class=\"error\"><p>You entered the incorrect password</p></div>";
    }
    if ($_GET["error"] == 3) {
      echo "<div class=\"error\"><p>You entered the incorrect email</p></div>";
    }
  }
  if (isset($_GET["success"])) {
    if ($_GET["success"] == 1) {
      echo "<div class='success'><p>You have changed your password. Please login again</p></div>";
    }
  }
?>
  <style scoped="true">
    body{
      background-image: url(images/loginback.jpg);
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
  <div id="login_div">
  <!-- Should probably change the form action to a new page for validating logins -->
    <form action="index.php" method="post">
      <p class="header">Log In</p>
      <div class="info">
        <p>Email</p>
        <input type = "email" name="email" required>
        <p>Password</p>
        <input type="password" name="password" required><br>
        <small>Haven't registered? <a href="register.php">Register here</a><br>
        <button type="submit" class= "loginbtn">Log In</button>
      </div>
    </form>
  </div>
<?php
  require_once 'footer.php';
?>
