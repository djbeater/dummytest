		<?php
			if(!isset($_POST['login'])){
		?>
		
			<h1>Lietotāja pieteikšanās</h1>
				<form id="login" class="form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="form-group">   
					<input type="text" class="form-control" name="username" placeholder="Lietotājvārds">
				</div>
				<div class="form-group">    
					<input type="password" class="form-control" name="password" placeholder="Parole">
				</div>
					<input type="hidden" name="login">
				<button type="submit" name="submit" class="btn btn-default">Pieteikties sistēmā</button>
				</form>
				
				<!-- The HTML login form -->
				<!-- <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
						Username: <input type="text" name="username" /><br />
						Password: <input type="password" name="password" /><br />
				
						<input type="submit" name="submit" value="Login" />
					</form> 
				-->
				<hr class="featurette-divider">
		
				<?php
					}else{
						require_once("config.php");
						require_once("class.db.php");
						$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
						# check connection
						if($mysqli->connect_errno){
							echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
							exit();
						}
						
						$username = $_POST['username'];
						$password = $_POST['password'];
						
						$sql = "SELECT * from lietotaji WHERE lietotajvards LIKE '{$username}' AND parole LIKE '{$password}' LIMIT 1";
						$lietotajs=db::query($sql);
						
						/*
						echo'<pre>';
						print_r($lietotajs);
						echo'</pre>';
						*/
						
						$result = $mysqli->query($sql);
						if(!$result->num_rows == 1){
							$res['error'] = '<h3>Nepareizs lietotājs un/vai parole!</h3>';
						}else{
							$id=$lietotajs[0]["id_lietotajs"];
							$res['ok'] = $id;
							//header("Location: vestules.php?lietotajs=$id");
							//echo "<h3>Esi veiksmīgi ielogojies!</h3>";      
						}
						
						echo json_encode($res);
					}
?>