<?php
	session_start(); //Start PHP session
	require_once('config.php');
	require_once('class.db.php');
	
	if(isset($_POST['add'])){
		db::query("INSERT INTO vestules 
				(id_lietotajs1, id_lietotajs2, tema, teksts, datums)
			VALUES(
				'".db::clean_sql($_POST['sutitajs'])."',
				'".db::clean_sql($_POST['sanemejs'])."',
				'".db::clean_sql($_POST['tema'])."',
				'".db::clean_sql($_POST['teksts'])."',
				'".db::clean_sql($_POST['datums'])."'
			)");
	}else{
		$html = '';
		/*
		SELECT l.vards,v.tema, v.teksts,v.datums 
		FROM maris_test.lietotaji AS l, maris_test.vestules AS v
		WHERE v.id_lietotajs1=l.id_lietotajs;
		*/
		$html = '<pre>';  
		if(isset($_SESSION['lietotajs'])){ // parbauda vai ir iesūtīta klase uz POST
			$lietotajs=$_SESSION['lietotajs'];
			$html .= 'Ir lietotājs! '.$lietotajs.'';
			$online=db::query(' SELECT vards, uzvards FROM lietotaji WHERE id_lietotajs='.$lietotajs.'');
			$html .= '<h3>';
			$html .=  ''.$online[0]['vards'].' '.$online[0]['uzvards'].'';
			$html .= '</h3>';
			$html .= '<a class="btn btn-danger logout">Iziet</a>';
		}else{
			$lietotajs=null;
			$html .= "Nav lietotāja!";
		}
		$html .= '</pre>';
		
		$sanemtas=db::query(' SELECT l.vards, l.uzvards, v.id_vestule, v.id_lietotajs1, v.id_lietotajs2, v.tema, v.teksts, v.datums, v.statuss
			FROM lietotaji AS l, vestules AS v
			WHERE v.id_lietotajs1=l.id_lietotajs AND v.id_lietotajs2='.$lietotajs.' ORDER BY v.datums DESC');
			
			$skaitas=db::query('SELECT COUNT(*)FROM vestules WHERE id_lietotajs2='.$lietotajs.''); 
			$sks=$skaitas[0]["COUNT(*)"];
			
		$html .= '<br>';
		$html .= '<center><h1>Saņemtās vēstules</h1></center>';
		
		$html .= '<div class="panel-group" id="accordion-inbox">';
		
		if($sanemtas!=NULL){
			for($i=0; $i<$sks; $i++){
				$a=$sanemtas[$i]["id_vestule"];
				
				if($sanemtas[$i]["statuss"]==0){
					$sbold = 'text-bold';
				}else{
					$sbold = '';
				}
				
				$html .= '
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion-inbox" href="#s'.$a.'" data-id="'.$a.'">
									<div class="row '.$sbold.'">
										<div class="col-md-4 text-center">
											'.$sanemtas[$i]['vards'].' '.$sanemtas[$i]['uzvards'].'
										</div>
										<div class="col-md-4 text-center">
											'.$sanemtas[$i]['tema'].' 
										</div>
										<div class="col-md-4 text-center">
											'.$sanemtas[$i]['datums'].'
										</div>
									</div>
								</a>
							</h4>
						</div>
						<div id="s'.$a.'" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="teksts">      
									'.$sanemtas[$i]['teksts'].'
								</div>
							</div>
						</div>
					</div>'; 
			}
			$html .= '</div>';
		}
		
		$html .= '<center><h1>Nosūtītās vēstules</h1></center>';
		
		$nosutitas=db::query(' SELECT l.vards, l.uzvards, v.id_vestule, v.id_lietotajs1, v.id_lietotajs2, v.tema, v.teksts, v.datums, v.statuss
			FROM lietotaji AS l, vestules AS v
			WHERE (v.id_lietotajs2=l.id_lietotajs) AND (v.id_lietotajs1='.$lietotajs.') ORDER BY v.datums DESC');
		$skaitan=db::query('SELECT COUNT(*)FROM vestules WHERE id_lietotajs1='.$lietotajs.'');
		$skn=$skaitan[0]["COUNT(*)"];
		if($nosutitas!=NULL){
		$html .= '<div class="panel-group" id="accordion-outbox">';
			for($i=0;$i<$skn;$i++){
				$a=$nosutitas[$i]["id_vestule"];
				//print_r($a);
				
				if($nosutitas[$i]["statuss"]==0){
					$nbold = 'text-bold';
				}else{
					$nbold = '';
				}
				
				$html .= '
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion-outbox" href="#s'.$a.'" data-id="'.$a.'">
									<div class="row '.$nbold.'">
										<div class="col-md-4 text-center">
											'.$nosutitas[$i]['vards'].' '.$nosutitas[$i]['uzvards'].'
										</div>
										<div class="col-md-4 text-center">
											'.$nosutitas[$i]['tema'].' 
										</div>
										<div class="col-md-4 text-center">
											'.$nosutitas[$i]['datums'].'
										</div>
									</div>
								</a>
							</h4>
						</div>
						<div id="s'.$a.'" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="teksts">      
									'.$sanemtas[$i]['teksts'].'
								</div>
							</div>
						</div>
					</div>'; 
			}
		$html .= '</div>';
		}   
		/*  
		$html .= '<pre>';
		print_r($nosutitas);
		$html .= '</pre>';
		*/
		$html .= '
				<br>
				<br>
				<br>
				<br>   
				<pre>
					<div class="col-lg-4">   
						<h2>Pievienot</h2>
						<p>Rakstīt jaunu vēstuli.</p>
						<p><a class="btn btn-default" data-toggle="modal" data-target="#pievienot">Rakstīt »</a></p>
					</div>
					
					<div class="col-lg-4"></div>
				</pre>';
				
		if(DEBUG){
			ini_set('display_errors', 'On');
			error_reporting(E_ALL | E_STRICT);
			$html .= '<pre>';
			$html .= 'GET<br/>';
			$html .= print_r($_GET, true);
			$html .= '<br/>POST<br/>';
			$html .= print_r($_POST, true);
			$html .= '<br/>SQL<br/>';
			$html .= db::get_debug();
			$html .= '</pre>';
		}
		
		$html .= '<!-- Modal Pievienot -->';
		$html .= '
		<div class="modal fade" id="pievienot" tabindex="-1" role="dialog" aria-labelledby="pievienotLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="pievienotLabel">Jauna vēstule</h4>
					</div>
					<div class="modal-body">';
					$datums = date('Y-m-d H:i:s');
					$html .= print_r($datums, true);
					isset($_GET['lietotajs']); // parbauda vai ir iesūtīta klase uz POST
					// $lietotajs=$_GET['lietotajs'];
					
		$html .='<br /><br />
						<form method="post">
						<input type="hidden" name="add">
						<p><input type="hidden" name="sutitajs" value="'.$lietotajs.'" /></p>
						<p><input type="text" name="sanemejs" placeholder="Adresāts" /></p>
						<p><input type="text" name="tema" placeholder="Tēma" /></p>
						<p><input type="text" name="teksts" placeholder="Teksts"/></p>
						<p><input type="hidden" name="datums" value="'.$datums.'" placeholder="'.$datums.'"/></p>
						<p><input type="submit" value="Nosūtīt" class="btn btn-primary"></p>        
						</form>
					</div>
				</div>
			</div>
		</div>';
						
		//echo $modal;
		//print_r($lietotajs);
		$html .= '<hr class="featurette-divider">';
		
	}
	
	$res['html'] = $html;
	echo json_encode($res);