<?php


include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "קזינו"; // כותרת הדף

$bets = new bets; // קריאה לאובייקט המטפל בהימורים

$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

include ("public/top.php"); // ייבוא חלק עליון של הדף

print <<<XYZ
<div class="col-sm-8 text-left"> 
      <h1 align="right">קזינו</h1>
	  <br />
	  <br />
	  <h2 align="right">רולטה</h2>
	 
	
	  <div align="center">
	  
	 <form action="" method="POST">
	 
     <input type="radio" name="color" value="black"> שחור 1:1<br>
     <input type="radio" name="color" value="red"> אדום 1:1<br>
     <input type="radio" name="color" value="green"> ירוק 1:36<br>  
	 
	 
     <input type="number" id="roulette_amount" name="amount_roulette_input" min="0" max="{$money}" value="0" /><br>
	 <input type="submit" name="submit_roulette">
     </form>
	  </div>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
XYZ;

$expression = new expression;
$expression->createCookie("login", $id, 2000);

include ("public/buttom.html"); // ייבוא חלק תחתון של הדף



if (isset($_POST['color']) && isset($_POST['amount_roulette_input']) && isset($_POST['submit_roulette'])){
	
	$color = $_POST['color'];
	$money_amount = $_POST['amount_roulette_input'];
	
	if ($bets->reverse_format_number($money) < $money_amount){
		var_dump($money);
		echo "<script>alert('אין לך מספיק כסף כדי לבצע את ההימור !')</script>";
		return;
	}
	
	$roulette = $bets->roulette($color, $money_amount, $username); // הפעלת הפונקצית רולטה , אשר מייצרת רולטה על בסיס ההימור
	
	if ($roulette[0] == True){ // אם ההימור הצילח
		
		echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('ההימור שלך הצליח !. זכית ב {$roulette[1]}')</script>";
		
		
		
	}else{
		
		echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('ההימור שלך נכשל !. הפסדת {$roulette[1]}')</script>";

	}
	
	
}






?>