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
	<link href="css/style.css" rel="stylesheet">
	
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
				setTimeout(function(){
					iegutURL("login.php", "GET", "", "json");
				}, 1000);
			}else if(data.ok){
				$("#ajax-data").html('<div class="alert alert-success">'+data.ok+'</div>');
				iegutURL("vestules.php", "GET", "", "json");
			}else{
				$("#ajax-data").html(data.html);
			}
		}
		
		function mainitStatusu(msg_id){
			iegutURL("statuss.php", "POST", {msg_id: msg_id}, "json");
		}
		
		$(document).ready(function(){
			
			iegutURL("login.php", "GET", "", "json");
			
			$(document).on("submit", "#login", function(event){
				//console.debug("submits!");
				
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
			
			
			$(document).on("click", ".panel-title a", function(event){
				var msg_id = $(this).data("id");
				$(this).find(".row").removeClass("text-bold");
				mainitStatusu(msg_id);
			});
			
			$(document).on("click", "a.logout", function(event){
				iegutURL("logout.php", "GET", "", "json");
				setTimeout(function(){
					iegutURL("login.php", "GET", "", "json");
				}, 1000);
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