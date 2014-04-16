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
	
	<script>
		
		function iegutURL(url, method, data, dataType){
			
			$.ajax({
				url: url,
				data: data,
				success: success,
				type: method,
				dataType: dataType
			});
			
			/*
			$.get(url, function(data, status){
				$("#ajax-data").html(data);
				console.debug(data);
			});
			*/
		}
		
		function success(data){
			if(data.error){
				$("#ajax-data").html('<div class="alert alert-danger">'+data.error+'</div>');
			}else if(data.ok){
				$("#ajax-data").html('<div class="alert alert-success">'+data.ok+'</div>');
				iegutURL("vestules.php", "GET", "", "html");
			}else{
				$("#ajax-data").html(data);
			}
		}
		
		
		$(document).ready(function(){
			
			iegutURL("login.php", "GET", "", "html");
			
			$(document).on("submit", "#login", function(event){
				console.debug("submits!");
				
				var data = $('#login').serialize();
				
				iegutURL("login.php", "POST", data, "json");
				
				/*
				if ( $( "input:first" ).val() === "correct" ) {
					$( "span" ).text( "Validated..." ).show();
					return;
				}
			
				$( "span" ).text( "Not valid!" ).show().fadeOut( 1000 );
				event.preventDefault();
				*/
				
				return false;
				
			});
			
		});
	</script>
	
	</head>
	<!-- NAVBAR
	================================================== -->
	<body>
	<div class="container marketing">
		<div id="ajax-data">