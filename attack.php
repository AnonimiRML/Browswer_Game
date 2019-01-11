<?php


include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות

include ("public/classes.php"); // יבוא אובייקטים

$expression = new expression; // קריאה לאובייקט המטפל בעוגיות

$message = new message;

$player = new player;



$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$username = $message->name_by_id($id);

$expression->createCookie("login", $id, 2000); // יצירת עוגיה

$title = "התקפה"; // קביעת כותרת לדף

if (!isset($_GET['name'])){
	header("Location: home.php");
}else{

$defender = $_GET['name'];

include ("public/top.php"); // ייבוא חלק עליון של הדף

print <<<XYZ


<script>
 function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }


</script>





<div class="col-sm-8 text-center"> 
<h1 align="right">התקפה</h1>

<form action="" method="POST">

<table class="table table-bordered" id="message_table">
<thead>
              <tr>
			    <th>סמן</th>
                <th>שם</th>
                <th>התקפה</th>
                <th>דיוק</th>
              </tr>
          </thead>
		  <tbody>

XYZ;

$select_called_up_soliders = $player->select_called_up_soliders($username);

while ($solider = $select_called_up_soliders->fetch_assoc()){
	
print <<<XYZ

<tr>
	  <td><input type="checkbox" name="soliders[]" value="{$solider['id']}"/></td>
	  <td>{$solider['name']}</td>
	  <td>{$solider['attack']}</td>
	  <td>
	  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$solider['accuracy']}" aria-valuemin="0" aria-valuemax="100" style="width:{$solider['accuracy']}%">
                   {$solider['accuracy']}% 
               </div> </td>
</tr>

XYZ;
	
}

print <<<XYZ

</tbody>
	  <tfoot>
	   <tr>
	            <th>סמן</th>
                <th>שם</th>
                <th>התקפה</th>
                <th>דיוק</th>
              </tr>
	  </tfoot>
	  </table>
	  <div align="left">
	  <input type="checkbox" onchange="checkAll(this)" name="soliders[]" /> בחר הכל <br>
	  </div>
	  <input type="submit" name="attack" value="תקוף !" />
	  

</form>



</div>

XYZ;

include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


}


if (isset($_POST['attack'])){
	
	$attacker = $username;
	$attacker_soliders_id_array = $_POST['soliders'];
	
	$query = $player->attacking($attacker, $defender, $attacker_soliders_id_array);
	
	if ($query){
		echo "<script>alert('התקיפה הצליחה !');</script>";
	}else{
		echo "<script>alert('התקיפה נכשלה !');</script>";
	}
	
	
}










?>