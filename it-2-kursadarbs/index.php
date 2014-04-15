<?php
session_start(); //Start PHP session
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="docs-assets/ico/favicon.ico">
  <title>VJZSk</title>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <!-- Custom styles for this template -->
  <link href="css/vestules.css" rel="stylesheet">
  </head>
<!-- NAVBAR
================================================== -->
  <body>
  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->
  <div class="container marketing">  
    

 <h1>Lietotāja pieteikšanās</h1>
<?php
if (!isset($_POST['submit'])){
?>
    
 <form class="form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="post">
  <div class="form-group">   
    <input type="text" class="form-control" name="username" placeholder="Lietotājvārds">
  </div>
  <div class="form-group">    
    <input type="password" class="form-control" name="password" placeholder="Parole">
  </div>
  <button type="submit" name="submit" class="btn btn-default">Pieteikties sistēmā</button>
</form>    
    
<!-- The HTML login form -->
<!--    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        Username: <input type="text" name="username" /><br />
        Password: <input type="password" name="password" /><br />
 
        <input type="submit" name="submit" value="Login" />
    </form> -->
<?php
} else {
    require_once("config.php");
    require_once("class.db.php");
  
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    # check connection
    if ($mysqli->connect_errno) {
        echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
        exit();
    }

  $username = $_POST['username'];
  $password = $_POST['password'];
  
    $sql = "SELECT * from lietotaji WHERE lietotajvards LIKE '{$username}' AND parole LIKE '{$password}' LIMIT 1";
  $lietotajs=db::query($sql);
  echo'<pre>';
  print_r($lietotajs);
  echo'</pre>';
  $result = $mysqli->query($sql);
    if (!$result->num_rows == 1) {
      echo "<h3>Nepareizs lietotājs un/vai parole!</h3>";      
    } else {
      $id=$lietotajs[0]["id_lietotajs"];
      header("Location: vestules.php?lietotajs='$id'");
      //echo "<h3>Esi veiksmīgi ielogojies!</h3>";      
    }
}
?>            
    
    <!-- ========================================================================================================= -->
    
<hr class="featurette-divider">
  </div><!-- /.container -->     
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>