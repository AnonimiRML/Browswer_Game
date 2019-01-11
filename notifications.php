<?php

include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "התראות";

$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$player = new player;

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$username = $message->name_by_id($_COOKIE['login']);


$expression = new expression;
$expression->createCookie("login", $id, 2000);

$data = $player->data($username); // יצירת שאילתה למסד השולף את כל המידע לפי הקוקי

$set_notifications_as_read = $mysqli->set_notifications_as_read($username);

include ("public/top.php"); // ייבוא חלק עליון של הדף

print <<<XYZ
<div class="col-sm-8 text-left"> 
      <h1 align="right">התראות</h1>
	  <div align="center">
	  <table class="table table-striped table-bordered" id="message_table">
	      <thead>
              <tr>
                <th>notification</th>
				<th>Date</th>
              </tr>
          </thead>
		  <tbody>


XYZ;

$receiver = $mysqli->select_notifications($username);

while($row = $receiver->fetch_assoc()){
	
$time = date("m/d/Y H:i:s", $row['time']); // הפיכת השניות לתאריך
	
print <<<XYZ
      <tr>
	  <td>{$row['body']}</td>
	  <td>{$time}</td>
	  </tr>
XYZ;
	
	
}

print <<<XYZ
	  </tbody>
	  <tfoot>
	   <tr>
                <th>notification</th>
				<th>Date</th>
              </tr>
	  </tfoot>
	  </table>
	  </div>
</div>
XYZ;

include ("public/buttom.html"); // ייבוא חלק תחתון של הדף





?>