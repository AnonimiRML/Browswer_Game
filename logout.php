<?php



if(isset($_GET['logout'])){
	
	include ("public/classes.php");
	$expression = new expression;
	$expression->unsetCookie('login');
	header ("Location: login.php");
	exit();
	
}


?>