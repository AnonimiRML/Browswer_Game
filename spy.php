<?php

include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "ריגול";

$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$player = new player;

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

include ("public/top.php"); // ייבוא חלק עליון של הדף

$data = $player->data($username); // יצירת שאילתה למסד השולף את כל המידע לפי הקוקי

if (isset($_GET['name'])){
	
$defender = $_GET['name'];
print <<<XYZ
<div class="col-sm-8"> 
    <h1 align="right">ריגול</h1>
	<br>
	<br>
	
	<div class="col-sm-4" align="right">
	      
	  </div>
	  
	   <div class="col-sm-4" align="right">
	   <form action="" method="POST">
	      <p>{$defender} : הינך מנסה לרגל אחר </p>
		  <br/>
	      <input type="number" name="spies" min="1" max="{$data['spies']}" /> : כמות חפרפרות לשלוח
		  <br>
		  <br>
		  <p>{$data['spies']} : כמות החפרפרות שיש לך</p>
		  
		  <input type="submit" name="submit_spies" value="רגל !" />
		  </form>
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      
	  </div>
	
	
</div>

XYZ;
}

include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


$expression = new expression;
$expression->createCookie("login", $id, 2000);

if (isset($_POST['submit_spies']) && isset($_POST['spies'])){
	
	$spies = $_POST['spies'];
	
	$spying = $player->spying($username, $defender, $spies);
	
	if ($spying[0] == True){
		echo "<script>alert('הריגול הצליח. הדוח מחכה לך בהתראות!')</script>";
	}else{
	echo "<script>alert('הריגול נכשל. נהרגו לך חפרפרות!')</script>";
	echo "<script>alert('{$spying[1]}')</script>";
	}
}









?>