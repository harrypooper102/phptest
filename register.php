<?php
  require 'header.php'
?>
  <style scoped="true">
    body{
      background-image: url(images/loginback.jpg);
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
  <div id="registration_div">
    <form class="register" action="success.php" method="post">
      <p class="header">Register</p>
      <div class="info">
        <div class="col-6">
          <p>Shipping Address</p>
          <input type = "text" name="address" required>
          <p>Email</p>
          <input type = "email" name="email" required>
        </div>
        <div class="col-6">
          <p>Password</p>
          <input type="password" name="password" required>
          <p>Confirm Password</p>
          <input type="password" name="repassword" required>
        </div>
        <p>Name</p>
        <input type = "text" name="name" required><br>
        <button type="submit" class="registerbtn">Register</button><br>
        <small>Already registered? <a href="login.php">Log in here</a>
      </div>
    </form>
  </div>

<?php
  require_once 'footer.php';
?>
