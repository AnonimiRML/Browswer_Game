<?php



include( 'public/classes.php' );

$title = "הרשמה";

include( 'public/top.php' );


print <<<XYZ
<div class="col-sm-8 text-left"> 
      <h1 align="right">הרשמה</h1>
	  <div align="center">
	  <form action="" method="POST">
      <input type="text" name="email" value="אימייל" />
	  <br />
	  <br />
	  <input type="text" name="username" value="שם משתמש" />
	   <br />
	  <br />
	  <input type="password" name="password" value="סיסמה" />
	  <br />
	  <br />
	  <input type="submit" name="register" value="שלח!" />
	  </form>
	  </div>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
XYZ;

	
	


include( $_SERVER['DOCUMENT_ROOT'] . '/OOP/public/buttom.html' );



if (isset($_POST['register'])) {
	
	if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])) {
		echo "<script>alert('שכחת למלא אחת מהאפשרויות. אנא נסה שנית !')</script>";
		return;
	}else{
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$mysqli = new database;
		$mysqli->register($email, $username, $password);
	}
	
	
}



	



















?>