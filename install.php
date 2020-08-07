<html>
  <head>
    <title>Install DINO DB</title>
  </head>
  <body>
    <?php
      require_once "config.php";
      try {
          $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
          $query = file_get_contents('dino.sql');
          var_dump($query);
          $dbh->exec($query);
          echo "<p>Successfully installed databases</p>";
      }
      catch (PDOException $e) {
          echo "<p>Error: {$e->getMessage()}</p>";
      }
    ?>
  </body>
</html>
