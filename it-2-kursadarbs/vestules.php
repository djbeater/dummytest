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

  <title>VJZSkola</title>

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
    

    
<?php
require_once('config.php');
require_once('class.db.php');
  /*
  SELECT l.vards,v.tema, v.teksts,v.datums 
FROM maris_test.lietotaji AS l, maris_test.vestules AS v
WHERE v.id_lietotajs1=l.id_lietotajs;
  */
  echo'<pre>';  
  if(isset($_GET['lietotajs'])){ // parbauda vai ir iesūtīta klase uz POST
    $lietotajs=$_GET['lietotajs'];
    echo"Ir lietotājs! $lietotajs";
    $online=db::query(' SELECT vards, uzvards FROM lietotaji WHERE id_lietotajs='.$lietotajs.'');
    echo'<h3>';
    echo "       ".$online[0]["vards"]. " " .$online[0]["uzvards"];
    echo'</h3>';
  }else{
    $lietotajs=null;
    echo"Nav lietotāja!";
  }
  echo'</pre>';
  
 $sanemtas=db::query(' SELECT l.vards, l.uzvards, v.id_vestule, v.id_lietotajs1, v.id_lietotajs2, v.tema, v.teksts, v.datums, v.statuss
FROM lietotaji AS l, vestules AS v
WHERE v.id_lietotajs1=l.id_lietotajs AND v.id_lietotajs2='.$lietotajs.' ORDER BY v.datums DESC');
  
  
  
   $skaitas=db::query('SELECT COUNT(*)FROM vestules WHERE id_lietotajs2='.$lietotajs.''); 

  $sks=$skaitas[0]["COUNT(*)"];

  echo'<br>';  
  echo'<center><h1>Saņemtās vēstules</h1></center>'; 

  if($sanemtas!=NULL){  
      for($i=0;$i<$sks;$i++){
        
    $a=$sanemtas[$i]["id_vestule"];;   
        
echo'<div class="panel-group" id="accordion">';
  echo'<div class="panel panel-default">';
    echo'<div class="panel-heading">';
      echo'<h4 class="panel-title">';
        echo'<a data-toggle="collapse" data-parent="#accordion" href="#s'.$a.'">';
        if($sanemtas[$i]["statuss"]==0){ 
        echo'<b>';
          echo'<div class="row">';
           echo'<div class="col-md-4 text-center">';
           echo $sanemtas[$i]["vards"]. " " .$sanemtas[$i]["uzvards"];
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $sanemtas[$i]["tema"]; 
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $sanemtas[$i]["datums"];
           echo'</div>';
           echo'</div>';
        echo'</b>';
      }else{
      echo'<div class="row">';
           echo'<div class="col-md-4 text-center">';
           echo $sanemtas[$i]["vards"]. " " .$sanemtas[$i]["uzvards"];
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $sanemtas[$i]["tema"]; 
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $sanemtas[$i]["datums"];
           echo'</div>';
           echo'</div>';
      }
        echo'</a>';
      echo'</h4>';
    echo'</div>';
    echo'<div id="s'.$a.'" class="panel-collapse collapse">';
      echo'<div class="panel-body">';
        echo'<div class="teksts">';       
        echo $sanemtas[$i]["teksts"];
        echo'</div>';
      echo'</div>';
    echo'</div>';
echo'</div>'; 
   }
   }
 
  
 echo'<center><h1>Nosūtītās vēstules</h1></center>';  

   $nosutitas=db::query(' SELECT l.vards, l.uzvards, v.id_vestule, v.id_lietotajs1, v.id_lietotajs2, v.tema, v.teksts, v.datums, v.statuss
FROM lietotaji AS l, vestules AS v
WHERE (v.id_lietotajs2=l.id_lietotajs) AND (v.id_lietotajs1='.$lietotajs.') ORDER BY v.datums DESC');
    $skaitan=db::query('SELECT COUNT(*)FROM vestules WHERE id_lietotajs1='.$lietotajs.''); 
  $skn=$skaitan[0]["COUNT(*)"];
    if($nosutitas!=NULL){  
      for($i=0;$i<$skn;$i++){        
        
     $a=$nosutitas[$i]["id_vestule"];   
        //  print_r($a);
echo'<div class="panel-group" id="accordion">';
  echo'<div class="panel panel-default">';
    echo'<div class="panel-heading">';
      echo'<h4 class="panel-title">';
        echo'<a data-toggle="collapse" data-parent="#accordion" href="#n'.$a.'">';
        if($nosutitas[$i]["statuss"]==0){ 
        echo'<b>';
          echo'<div class="row">';
           echo'<div class="col-md-4 text-center">';
           echo $nosutitas[$i]["vards"]. " " .$nosutitas[$i]["uzvards"];
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $nosutitas[$i]["tema"]; 
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $nosutitas[$i]["datums"];
           echo'</div>';
           echo'</div>';
        echo'</b>';
      }else{
      echo'<div class="row">';
           echo'<div class="col-md-4 text-center">';
           echo $nosutitas[$i]["vards"]. " " .$nosutitas[$i]["uzvards"];
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $nosutitas[$i]["tema"]; 
           echo'</div>';
           echo'<div class="col-md-4 text-center">';
           echo $nosutitas[$i]["datums"];
           echo'</div>';
           echo'</div>';
      }
        echo'</a>';
      echo'</h4>';
    echo'</div>';
    echo'<div id="n'.$a.'" class="panel-collapse collapse">';
      echo'<div class="panel-body">';
        echo'<div class="teksts">';       
        echo $nosutitas[$i]["teksts"];
        echo'</div>';
      echo'</div>';
    echo'</div>';
echo'</div>'; 
      }
  }   
  /*  echo'<pre>';
  print_r($nosutitas);
  echo'</pre>';  */
?>  
    <br>
    <br>
    <br>
    <br>   
    <!-- ========================================================================================================= -->
  <pre> 
  <!-- /.col-lg-4 -->
    <div class="col-lg-4">   
    <h2>Pievienot</h2>
    <p>Rakstīt jaunu vēstuli.</p>
    <p>
      <a class="btn btn-default" data-toggle="modal" data-target="#pievienot">Rakstīt »</a>
    </p>
    </div>
    
    <!-- /.col-lg-4 -->
    <div class="col-lg-4">
    </div>
    <!-- /.col-lg-4 -->
  </div>
  <!-- /.row -->
 </pre>
  
  
  <!-- Modal Pievienot -->
  <div class="modal fade" id="pievienot" tabindex="-1" role="dialog" aria-labelledby="pievienotLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title" id="pievienotLabel">Jauna vēstule</h4>
      </div>
      <div class="modal-body">
      <?php
           require_once('config.php');
        require_once('class.db.php');
           if(DEBUG){
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
    
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
  }
    $datums = date('Y-m-d H:i:s');
    print_r($datums);
     isset($_GET['lietotajs']); // parbauda vai ir iesūtīta klase uz POST
  //   $lietotajs=$_GET['lietotajs'];
  
  echo'<br /><br /><form method="post">
           
    
           <input type="hidden" name="add">
           <p><input type="hidden" name="sutitajs" value="'.$lietotajs.'" /></p>
           <p><input type="text" name="sanemejs" placeholder="Adresāts" /></p>
           <p><input type="text" name="tema" placeholder="Tēma" /></p>
           <p><input type="text" name="teksts" placeholder="Teksts"/></p>
           <p><input type="hidden" name="datums" value="'.$datums.'" placeholder="'.$datums.'"/></p>
           <p><input type="submit" value="Nosūtīt" class="btn btn-primary"></p>        
           </form>';
      
      print_r($lietotajs);
  
  
           if(isset($_POST['add'])){
        db::query("
           INSERT INTO vestules 
               (id_lietotajs1,id_lietotajs2,tema,teksts,datums) 
          VALUES(
               '".db::clean_sql($_POST['sutitajs'])."',
               '".db::clean_sql($_POST['sanemejs'])."',
               '".db::clean_sql($_POST['tema'])."',
               '".db::clean_sql($_POST['teksts'])."',
               '".db::clean_sql($_POST['datums'])."'
           )");             
        }
           if(DEBUG){
             db::get_debug();
        }
      ?>   
    
    
    <!-- ========================================================================================================= -->
    
<hr class="featurette-divider">

  <?php
  if(DEBUG){
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
    echo '<pre>';
	echo 'GET<br/>';
	print_r($_GET);
	echo '<br/>POST<br/>';
    print_r($_POST);
    echo '</pre>';
  }

  ?> 
  
  </div><!-- /.container -->     
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>