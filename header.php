<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>P2: Dinosaur Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/yee.jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <nav>
      <div class="logodiv">
        <a href="index.php" class="logo">
          <img src="images/chromedino.png" alt="logo">
        </a>
      </div>
      <div class="uldiv">
        <ul class="nav_ul">
          <li><a href="index.php">Most Popular</a></li>
          <li><a href="dinosaurs.php">Dinosaurs</a></li>
          <li><a href="accessories.php">Accessories</a></li>
          <li class="login"><a href="login.php">Log In</a></li>
        </ul>
      </div>
    </nav>
    <?php
      function print_top()
      {
        echo "<div class=\"top\">
          <div class=\"background\">
            <p class=\"title\">Dino & Co.</p>
            <p class=\"subtitle\">Where Your Dinosaur Dreams Come true</p>
          </div>
        </div>";
      }
    ?>
