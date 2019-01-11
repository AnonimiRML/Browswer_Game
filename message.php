<?php


include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות

include ("public/classes.php"); // יבוא אובייקטים

$expression = new expression; // קריאה לאובייקט המטפל בעוגיות

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$username = $message->name_by_id($id);

$message->set_messages_as_read($username);

$expression->createCookie("login", $id, 2000); // יצירת עוגיה

$title = "הודעות"; // קביעת כותרת לדף


if(isset($_GET['name'])){ // אם התקבל שם משתמש שצריך לשלוח אליו הודעה
    if ($_GET['name'] == $username){
		header ("Location: home.php");
		exit();
	}
	$send_to = $_GET['name']; // קביעת משתנה שיכיל אותו בצורה נקייה
}
else{ // אם לא התקבל
	$send_to = ""; // משתנה שלא מכיל כלום
}



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





<div class="col-sm-8 text-left"> 
      <h1 align="right">הודעות</h1>
	  <div align="center">
	  <a href="message.php?sender=1">הודעות שנשלחו</a> | <a href="message.php">הודעות שהתקבלו</a>
	  <form action="" method="POST">
	  <table class="table table-striped table-bordered" id="message_table">
	      <thead>
              <tr>
			    <th>פעולה</th>
                <th>From</th>
                <th>To</th>
                <th>Message</th>
				<th>Date</th>
              </tr>
          </thead>
		  <tbody>
XYZ;

$sender = $message->sender($username); // קריאה למתודה אשר מבצעת שליפה מהמסד של הודעות שנשלחו
$receiver = $message->receiver($username); // קריאה למתודה אשר מבצעת שליפה מהמסד של הודעות שהתקבלו

if (isset($_GET['sender'])){ // אם התקבל המשתנה בפורמט גט 
while($row = $sender->fetch_assoc()){ // בצע לולאה על תוצאת השליפה של ההודעות שנשלחו

$time = date("m/d/Y H:i:s", $row['time']); // הפיכת השניות לתאריך

print <<<XYZ
      <tr>
	  <td><input type="checkbox" name="messages[]" value="{$row['id']}"/></td>
	  <td>{$row['sender']}</td>
	  <td>{$row['receiver']}</td>
	  <td>{$row['body']}</td>
	  <td>{$time}</td>
	  </tr>
XYZ;
}
}else{ // אם לא התקבל המשתנה
	
	while($row = $receiver->fetch_assoc()){ // בצע לולאה על תוצאות השליפה של ההודעות שהתקבלו
	$time = date("m/d/Y H:i:s", $row['time']); // הפיכת השניות לתאריך
print <<<XYZ
      <tr>
	  <td><input type="checkbox" name="messages[]" value="{$row['id']}" /></td>
	  <td>{$row['sender']}</td>
	  <td>{$row['receiver']}</td>
	  <td>{$row['body']}</td>
	  <td>{$time}</td>
	  </tr>
XYZ;
}
	
	
}
print <<<XYZ
	  </tbody>
	  <tfoot>
	   <tr>
	            <th>פעולה</th>
                <th>From</th>
                <th>To</th>
                <th>Message</th>
				<th>Date</th>
              </tr>
	  </tfoot>
	  </table>
	  
	  </div>
	  <input type="checkbox" onchange="checkAll(this)" name="messages[]" /> בחר הכל <br>
	  <input type="submit" name="delete_messages" value="מחק" />
	 
	  
	  </form>
      <hr>
	  <div align="center">
	  <form action="" method="POST">
      <input type="text" value="{$send_to}" name="send_to">
	  <br>
	  <br>
	  <textarea rows="10" cols="75" name="body"></textarea>
	  <input type="hidden" value="{$username}" name="send_from">
	  <br>
	  <input type="submit" name="send_message" value="שלח">
	  
      <p>Lorem ipsum...</p>
	  </form>
	  </div>
	 </div>
XYZ;


include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


if (isset($_POST['send_to']) && isset($_POST['body']) && isset($_POST['send_from']) && isset($_POST['send_message'])){ // אם הודעה נשלחה
	
	$sender = $_POST['send_from'];
	$receiver = $_POST['send_to'];
	$body = $_POST['body'];
	$time = time();
	
	$message->send_message($sender, $receiver, $body, $time); // הפעל פונקציה המטפלת בשליחת הודעות
	
}


if (isset($_POST['delete_messages'])){
	
	
	$messages_array = $_POST['messages'];
	$query = $message->delete_messages($messages_array);
	if ($query){
		echo "<script>alert('כל ההודעות נמחקו !')</script>";
		echo("<meta http-equiv='refresh' content='0'>");
	}else{
		echo "<script>alert('משהו השתבש. אנא נסה שנית !')</script>";
	}
} 



?>