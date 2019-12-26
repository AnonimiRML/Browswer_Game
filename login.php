<?php

include( 'public/classes.php' );

$title = "התחברות";

include( 'public/top.php' );


print <<<XYZ
<div class="col-sm-8 text-left"> 
      <h1 align="right">התחברות</h1>
	  <div align="center">
	  <form action="" method="POST">
      <input type="text" name="username" value="שם משתמש" />
	  <br />
	  <br />
	  <input type="password" name="password" value="סיסמה" />
	  <br />
	  <br />
	  <input type="submit" name="login" value="שלח!" />
	  </form>
	  </div>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
XYZ;

	
	


include( $_SERVER['DOCUMENT_ROOT'] . '/OOP/public/buttom.html' );


$mysqli = new database;

if(isset($_POST["login"])) {
	
	if(empty($_POST["username"]) || empty($_POST["password"])) {
		
		echo "<script>alert('שכחת שם משתמש או סיסמה !')</script>";
	}else{
	    
		$query = $mysqli->login($_POST['username'], $_POST['password']);
	    
		if ($query == True){
			
			echo '<script>window.location.href = "home.php"</script>';
			exit();
		}else{
			echo "<script>alert(' שם משתמש או סיסמה שגויים !')</script>";
		}
		
		exit();
	
	}
}
	
	


?>








 