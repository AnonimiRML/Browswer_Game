<?php

include("public/classes.php");

if (isset($_GET['reload'])){
	
	
	$message = new message;
	$messages_not_view = $message->count_message_not_view($_GET['reload']); // כמות ההודעות שהמשתמש עדיין לא קרא;
	echo $messages_not_view;
	
	
}

if (isset($_GET[''])){
	
	$player = new player;
	
	$image = $_FILES['profile_image'];
	
	$query = $player->upload_image($username, $image);
	
}









?>