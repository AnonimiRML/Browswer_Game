<?php

if (isset($_GET['reload'])){
	
	$message = new message;
	$messages_not_view = $message->count_message_not_view($_GET['reload']); // כמות ההודעות שהמשתמש עדיין לא קרא;
	echo $messages_not_view;
	
	
};

include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "דף הבית";



$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$player = new player;

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$username = $message->name_by_id($_COOKIE['login']);


$expression = new expression;
$expression->createCookie("login", $id, 2000);


$data = $player->data($username); // יצירת שאילתה למסד השולף את כל המידע לפי הקוקי

include ("public/top.php"); // ייבוא חלק עליון של הדף

$soliders = $player->army($username); // ספירת כמות החיילים של השחקן שגויסו

print <<<XYZ

<script>

function image_editor() {
  var x = document.getElementById("image_editor");
  if (x.style.display === "none") {
x.style.display = "block";
  } else {
x.style.display = "none";
  }
}



</script>

<div class="col-sm-8"> 
      <h1 align="right">פרטי משתמש</h1>
	  <br>
	  <br>
	 
	  
	  <div class="col-sm-4" align="right">
	       <p>{$data['protection']} : חנויות דמי חסות </p>
		   <p>{$data['spies']} / {$data['max_spies']} : חפרפרות </p>
	  </div>
	  
	   <div class="col-sm-4" align="right">
	      <p>{$data['id']} : מספר אישי </p>
	      <p>{$username} : שם משתמש </p>
		   <p>{$money_view} : דולרים</p>
		   <p>{$soliders} / {$data['houses']} : חיילים</p>
		   {$data['scouting']}% : מערך סקאוטינג <div class="progress">  
               <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$data['scouting']}" aria-valuemin="0" aria-valuemax="100" style="width:{$data['scouting']}%">
                   {$data['scouting']}% 
               </div>
           </div>
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      <img src="{$data['image']}" width="150" height="150" />
		  <br>
		  <a href="javascript:void(0)" style="margin-right: 35px" onclick="image_editor()">ערוך תמונה</a>
		  <form action="" method="POST" enctype="multipart/form-data" id="image_editor" style="display:none;">
		  <input type="file" name="profile_image">
		  <input type="submit" name="profile_image_submit" value="עדכן תמונה">
		  </form>
	  </div>
	  
	  
</div>
XYZ;




include ("public/buttom.html"); // ייבוא חלק תחתון של הדף

if (isset($_POST['profile_image_submit'])){
	
	$image = $_FILES['profile_image'];
	
	$query = $player->upload_image($username, $image);
	
	if ($query){
		echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('ההעלאה הצליחה !')</script>";
	}else{
		echo "<script>alert('ההעלאה נכשלה !')</script>";
	}
	
}






?>