<?php
	session_start(); //Start PHP session
	
	// Unset all of the session variables.
	$_SESSION = array();
	
	session_destroy();