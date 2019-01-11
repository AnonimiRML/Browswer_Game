<?php


include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "חנות";

$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$player = new player;

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$username = $message->name_by_id($_COOKIE['login']);

include ("public/top.php"); // ייבוא חלק עליון של הדף

print <<<XYZ
<div class="col-sm-8"> 
      <h1 align="right">חנות</h1>
	  <br>
	  <br>
	 
	  
	  <div class="col-sm-4" align="right">
	     
	  </div>
	  
	   <div class="col-sm-4" align="right">
	     <p>אקדח</p>
		 <p>+ 1 : התקפה</p>
		 <p>+ 2 : הגנה</p>
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      <img src="public/images/items/1.png" width="150px" height="150px" />
	      
	  </div>
	  
	  
</div>
XYZ;


include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


$expression = new expression;
$expression->createCookie("login", $id, 2000);










?>