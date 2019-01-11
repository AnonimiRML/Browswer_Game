<?php

include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "גיוס חיילים";

$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$player = new player;

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$expression = new expression;
$expression->createCookie("login", $id, 2000);

$username = $message->name_by_id($_COOKIE['login']);

$data = $player->data($username); // יצירת שאילתה למסד השולף את כל המידע לפי הקוקי

$last_refresh_soliders = $data['last_refresh_soliders'];


include ("public/top.php"); // ייבוא חלק עליון של הדף

print <<<XYZ

<script>

var countDownDate = {$data['last_refresh_soliders']} + 150 + "000";

var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "";
	document.getElementById("refresh_soliders").style.visibility = "visible";
	
	
	
  }
}, 1000);

</script>


XYZ;


if (isset($_GET['id'])){ // דף החיילים שהשחקן יכול לגייס


$solider_data = $player->solider_data($_GET['id'])->fetch_assoc(); // שליפת מידע על חייל ספציפי על פי האיידי שלו

if ($solider_data['commander'] == $username){
	

	

if ($solider_data['call_up'] == 0){

$name = $solider_data['name']; // שם החייל

print <<<XYZ

<div class="col-sm-8"> 
      <h1 align="right">פרטי חייל</h1>
	  <br>
	  <br>
	 
	  
	  <div class="col-sm-4" align="right">
	       
	  </div>
	  
	   <div class="col-sm-4" align="right">
	      <p>{$solider_data['id']} : מספר אישי</p>
		  <p>{$solider_data['name']} : שם החייל </p>
		  <p>{$solider_data['attack']} : התקפה </p>
		  <p>{$solider_data['defence']} : הגנה </p>
		  {$solider_data['accuracy']}% : דיוק <div class="progress">  
               <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$solider_data['accuracy']}" aria-valuemin="0" aria-valuemax="100" style="width:{$solider_data['accuracy']}%">
                   {$solider_data['accuracy']}% 
               </div>
           </div>
		  
		  
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      <img src="{$solider_data['image']}" width="150" height="150" />
		  <br>
		  <br>
		  <form action="soliders.php" method="POST">
		  <input style="margin-right: 35px" type="submit" name="call_up" value="צרף לארגון" class="btn btn-success"/>
		  <input type="hidden" value="{$solider_data['id']}" name="id" />
		  <input type="hidden" name="cost" value="{$solider_data['cost']}">
		  </form>
		  
	  </div>
	  
	  
</div>
XYZ;


}else{
	
	
$name = $solider_data['name']; // שם החייל

print <<<XYZ
<div class="col-sm-8"> 
      <h1 align="right">פרטי חייל</h1>
	  <br>
	  <br>
	  
	  <div class="col-sm-4" align="right">
	       
	  </div>
	  
	   <div class="col-sm-4" align="right">
	      <p>{$solider_data['id']} : מספר אישי</p>
		  <p>{$solider_data['name']} : שם החייל </p>
		  <p>{$solider_data['attack']} : התקפה </p>
		  <p>{$solider_data['defence']} : הגנה </p>
		  {$solider_data['accuracy']}% : דיוק <div class="progress">  
               <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$solider_data['accuracy']}" aria-valuemin="0" aria-valuemax="100" style="width:{$solider_data['accuracy']}%">
                   {$solider_data['accuracy']}% 
               </div>
           </div>
		  
		  
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      <img src="{$solider_data['image']}" width="150" height="150" />
		  <br>
		  <br>
		  
	  </div>
	  
	  
</div>
XYZ;

	
	
	
	
}

}

}

if(isset($_GET['call_up'])){



	
print <<<HTML


<div class="col-sm-8"> 
<br>
<div align="center">
<a href="soliders.php">חיילים שגויסו</a> | <a href="soliders.php?call_up=1">גייס חיילים</a>
<br>
<br>
<p id="demo"></p>
<form action="" method="POST">
<input type="submit" name="refresh_soliders" id="refresh_soliders" style="visibility:hidden" value="רענן חיילים !" />
</form>
</div>
HTML;

$soliders_option = $player->select_soliders_option($username); // שליפת השחקנים שהשחקן יכול לגייס

while ($solider = $soliders_option->fetch_assoc()){
print <<<HTML
<div class="col-sm-3">
<div class="card">
  <img class="card-img-top" src="{$solider['image']}" width="150px" height="150px" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">{$solider['name']}</h5>
    <p class="card-text">
	{$solider['cost']} : עלות <br>
	{$solider['accuracy']} : דיוק <br>
	{$solider['attack']} : התקפה <br>
	{$solider['defence']} : הגנה <br>
	
	
	</p>
	<form action="" method="POST">
    <a href="soliders.php?id={$solider['id']}" class="btn btn-primary">צפה בפרופיל</a>
	<input type="submit" name="call_up" value="צרף לארגון" class="btn btn-success"/>
	<input type="hidden" name="id" value="{$solider['id']}">
	<input type="hidden" name="cost" value="{$solider['cost']}">
	
	</form>
	
  </div>
  <br>
</div>


</div>

HTML;
}

print <<<HTML

</div>

HTML;

	


}

if(empty($_GET)){ // אם לא הוזן גט.. הראה חיילים שגויסו



	
print <<<HTML
	


<div class="col-sm-8"> 
<br>
<div align="center">
<a href="soliders.php">חיילים שגויסו</a> | <a href="soliders.php?call_up=1">גייס חיילים</a>
<br>
<br>
<p id="demo"></p>
<form action="" method="POST">
<input type="submit" name="refresh_soliders" id="refresh_soliders" style="visibility:hidden" value="רענן חיילים !" />
</form>
</div>
HTML;

$soliders_option = $player->select_called_up_soliders($username); // שליפת חיילים שהשחקן גייס כבר

while ($solider = $soliders_option->fetch_assoc()){
print <<<HTML
<div class="col-sm-3">
<div class="card">
  <img class="card-img-top" src="{$solider['image']}" width="150px" height="150px" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">{$solider['name']}</h5>
    <p class="card-text">
	{$solider['cost']} : עלות <br>
	{$solider['accuracy']} : דיוק <br>
	{$solider['attack']} : התקפה <br>
	{$solider['defence']} : הגנה <br>
	
	
	</p>

    <a href="soliders.php?id={$solider['id']}" class="btn btn-primary">צפה בפרופיל</a>

	
  </div>
  <br>
</div>


</div>

HTML;
}

print <<<HTML

</div>

HTML;
	
	

}

include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


if (isset($_POST['call_up']) && isset($_POST['id']) && isset($_POST['cost'])){
	
	$houses = $data['houses']; // שליפת כמות הבתים של השחקן

	$soliders = $player->army($username); // ספירת כמות החיילים של השחקן שגויסו
	
	if ($soliders <= $houses - 1  && $_POST['cost'] <= $money) { // אם כמות החיילים של השחקן קטן או שווה והמחיר של החייל קטן או שווה לכסף של החייל עשה את זה
	
	    $query = $player->call_up_solider($username, $_POST['id'], $_POST['cost']);
	    if($query){
	        echo("<meta http-equiv='refresh' content='0'>");
	        echo "<script>alert('החייל גויס !')</script>";
			
	    }else{
		    echo "<script>alert('משהו השתבש !')</script>";
	    }
	}else{
		 echo "<script>alert('אין לך מספיק דולרים או בתים !')</script>";
	}
}


if (isset($_POST['refresh_soliders'])){
	
	$scouting = $data['scouting'];
	$refresh_soliders = $player->refresh_soliders($username, $scouting);
	
	if ($refresh_soliders){
		echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('מערכת הסקאוטינג שלך הצליחה לאתר חיילים חדשים !')</script>";
	}else{
		echo "<script>alert('משהו השתבש. אנא נסה שנית !')</script>";
	}
	
	
}















?>