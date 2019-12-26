<?php


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

$cost_scout_improve = ($data['scouting'] * 1000) + ($data['scouting'] * 1000) * $data['scouting'];

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
           <p>נקודות הגנה של המוצב : {$data['defence']}</p>
		   <p>{$soliders} / {$data['houses']} : חיילים</p>
		   {$data['scouting']}% : מערך סקאוטינג <div class="progress">  
               <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$data['scouting']}" aria-valuemin="0" aria-valuemax="100" style="width:{$data['scouting']}%">
                   {$data['scouting']}% 
               </div>
           </div>
           <form action="home.php" method="POST">
           <input type="submit" name="improve_scout_abillity" value="שפר מערכת סקאוטינג" class="btn btn-success"/> עלות : {$cost_scout_improve}
           </form>
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

if (isset($_POST['improve_scout_abillity'])){
    
    
    $query = $player->scout_system_improve($username , $cost_scout_improve);
    if ($query){
        echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('השדרוג הצליח !')</script>";
        var_dump($query);
    }else{
		echo "<script>alert('משהו השתבש !')</script>";
    }
    
}

var_dump($cost_scout_improve);




?>