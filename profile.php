<?php

if (isset($_GET['name'])){

include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות

include ("public/classes.php"); // יבוא אובייקטים

$mysqli = new database;
$message = new message;
$player = new player;

$username = $message->name_by_id($_COOKIE['login']);

if ($username == $_GET['name']){ // אם השם שאליו המשתמש נכנס הוא שלו
	header ("Location: home.php");
}

$name = $_GET['name'];

$title = $name; // כותרת הדף

$data = $player->data($name); // מתודה לשליפת מידע על הפרופיל שהוזן

if ($data == False){ // אם המשתמש אינו קיים
	
	header ("Location: home.php"); // עבור לדף הבית
	exit(); // סיים
	
}

include ("public/top.php"); // ייבוא חלק עליון של הדף

print <<<XYZ

<div class="col-sm-8 text-left"> 

       <h1 align="right">פרטי משתמש</h1>
      <br>
      <br>
      <div class="col-sm-4" align="right">
	   <form action="" method="POST">
	  <input type="number" name="money" value="כמות" min="1" max="{$money}" />
	  <br>
	  <input type="submit" name="money_submit" value="שלח כסף !" />
	  </form>
	  </div>
	  
	   <div class="col-sm-4" align="right">
	      <p>{$data['id']} : מספר אישי </p>
	      <p>{$data['username']} : שם משתמש </p>
		
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      <img src="{$data['image']}" width="150" height="150" />
		  <br>
		  <br>
		  <a style="margin-right: 35px" href="message.php?name={$name}" class="btn btn-success btn-block">שלח הודעה</a>
		  <br>
		  <a style="margin-right: 35px" href="attack.php?name={$name}" class="btn btn-danger btn-block">תקוף</a>
		  <br>
		  <a style="margin-right: 35px" href="spy.php?name={$name}" class="btn btn-primary btn-block">רגל</a>
		  
	  </div>

	 
	 
</div>
XYZ;




include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


$expression = new expression;
$expression->createCookie("login", $_COOKIE['login'], 2000);


if (isset($_POST['money']) && isset($_POST['money_submit'])) { // אם שתי הפרמטרים האלו התקבלו
	
	$money = $_POST['money']; // כמות הכסף שנשלח
	$player_receiver = $data['username']; // המשתמש שיקבל את הכסף
	$player_sender = $username; // המשתמש ששולח את הכסף
	
	$player = new player;
	$result = $player->send_money($player_sender, $player_receiver, $money); // הפעלת הפונקצייה אשר מעבירה את הכסף
	if ($result == True){ // אם ההעברה הצליחה
	    echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('ההעברה הצליחה !')</script>"; // חלון קופץ אשר מבשר על הצלחה
	}else{ // אם לא
		echo "<script>alert('ההעברה נכשלה !')</script>"; // חלון קופץ אשר מבשר על כישלון
	}
	
}


}else{
	
	header ("Location: home.php");
	
}





?>