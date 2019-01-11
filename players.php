<?php


include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים




$title = "טבלת שחקנים"; // כותרת הדף

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה


$expression = new expression; // יצירת אובייקט המטפל בעוגיות
$expression->createCookie("login", $id, 2000); // יצירת עוגייה


include ("public/top.php"); // ייבוא חלק עליון של הדף

$mysqli = new database;
$players_table_query = $mysqli->players_table();

print <<<XYZ
<div class="col-sm-8 text-left"> 
      <h1 align="right">טבלת שחקנים</h1>
	  <div align="center">
	  <table class="table table-striped table-bordered" id="message_table">
	      <thead>
              <tr>
                <th>שחקן</th>
                <th>מוניטין</th>
                <th>פעולה</th>
              </tr>
          </thead>
		  <tbody>
XYZ;


while ($row = $players_table_query->fetch_assoc()){

print <<<XYZ
	  <tr>
	  <td><a href="profile.php?name={$row['username']}">{$row['username']}</a></td>
	  <td>0</td>
	  <td><a href="message.php?name={$row['username']}">שלח הודעה</a> , <a href="spy.php?name={$row['username']}">רגל</a></td>
	  </tr>
XYZ;

}

print <<<XYZ
          </tbody>
     </table>
	  </div>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
XYZ;






include ("public/buttom.html"); // ייבוא חלק תחתון של הדף










?>