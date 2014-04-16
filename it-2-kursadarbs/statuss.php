<?php
	session_start(); //Start PHP session
	require_once('config.php');
	require_once('class.db.php');
	
	if(isset($_SESSION['lietotajs'])){ // parbauda vai ir autorizējies
		if(isset($_POST['msg_id'])){
			//UPDATE `maris_test`.`vestules` SET `statuss` = \'1\' WHERE `vestules`.`id_vestule` = 1;
			db::query("UPDATE vestules SET statuss = '1' WHERE id_vestule = '".db::clean_sql($_POST['msg_id'])."'");
			db::get_debug();
		}
	}
