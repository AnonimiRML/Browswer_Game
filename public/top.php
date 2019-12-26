<?php

if(isset($_COOKIE['login'])){
	
	if (!isset($message)){
	$message = new message; // קריאה לאובייקט המטפל בהודעות בין שחקנים
	}
	if (!isset($username)){
	$username = $message->name_by_id($_COOKIE['login']); // שליפת שם המשתמש באמצעות הקוקי
	}
	if (!isset($messages_not_view)){
	$messages_not_view = $message->count_message_not_view($username); // כמות ההודעות שהמשתמש עדיין לא קרא
	}
	if (!isset($mysqli)){
		$mysqli = new database;
	}
	if (!isset($money)){
		$query = $mysqli->conn->query("SELECT `money` FROM `users` WHERE `username` = '" . $username . "'")->fetch_assoc();
		$money_view = number_format($query['money']);
		$money = $query['money'];
		
	}
	
	function new_messages_alert(){
		echo '<div class="alert alert-success">קיימות הודעות חדשות !.</div>';
	}
	
	$count_notifications_not_view = $message->count_notifications_not_view($username);
	
	
	
}else{
	$messages_not_view = "";
	$money = "";
	$money_view = "";
	$username = "";
	$count_notifications_not_view = "";
	
	
}


$top = <<< XYZ

<!DOCTYPE html>
<html>
<head>


  <title>{$title}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
  
  
  
  
</head>
<body>



<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul id="categories" class="nav navbar-nav">
        <li><a href="home.php">Home</a></li>
		<li id="notifications"><a href="notifications.php"><i class="fas fa-bell"></i> {$count_notifications_not_view}</a></li>
        <li id="messages"><a href="message.php"><i class="fas fa-envelope-open"></i> {$messages_not_view}</a></li>
        <li><a href="#" id="money">{$money_view}</a></li>
        <li><a href="#">{$username}</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php?logout=1"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p id="player_table"><a href="players.php">טבלת שחקנים</a></p>
      <p><a href="casino.php">קזינו</a></p>
	  <p><a href="soliders.php">חיילים</a></p>
	  <p><a href="shop.php">חנות</a></p>
	  <div id="messages_alert_new_message" class="alert alert-success alert-dismissible" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  קיימות הודעות חדשות !.
	  </div>
	  
	  
    </div>
    
    
    <script>

if ({$messages_not_view} != 0){
    document.getElementById("messages").innerHTML = '<a href="message.php"><i class="fas fa-envelope" style="color:orange;"></i> {$messages_not_view}</a>';
    
}

if ({$count_notifications_not_view} != 0){
    document.getElementById("notifications").innerHTML = '<a href="notifications"><i class="fas fa-bell" style="color:orange;"></i> {$count_notifications_not_view}</a>';
    
}



</script>
	
XYZ;

echo $top;




