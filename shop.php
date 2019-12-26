<?php


include ("public/isset_cookie.php"); // ייבוא בדיקת עוגיות
include ("public/classes.php"); // יבוא אובייקטים

$title = "חנות";

$mysqli = new database; // יצירת אובייקט דטבייס אשר יתחבר למסד

$player = new player;

$message = new message;

$id = $_COOKIE['login']; // יצירת משתנה שיכיל את הקוקי בצורה יותר נקייה

$username = $message->name_by_id($_COOKIE['login']);

include ("public/top.php"); // ייבוא חלק עליון של הדף

if (isset($_GET['tool'])){

$cost = $mysqli->arsenal($_GET['tool'])[0];
$upgrade = $mysqli->arsenal($_GET['tool'])[1];
$type = $mysqli->arsenal($_GET['tool'])[2];
$type_sql = $mysqli->arsenal($_GET['tool'])[3];
    
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
<h1 align="right">חנות</h1>

<p>קניית כלי זה ישפר את {$type} של החייל שלך בכ- {$upgrade}. העלות היא {$cost} לכלי</p>


<form action="" method="POST">

<table class="table table-bordered" id="message_table">
<thead>
              <tr>
			    <th>סמן</th>
                <th>שם</th>
                <th>התקפה</th>
                <th>דיוק</th>
                <th>נשק</th>
                <th>כוונת</th>
              </tr>
          </thead>
		  <tbody>

XYZ;

$select_called_up_soliders = $player->select_called_up_soliders($username);

while ($solider = $select_called_up_soliders->fetch_assoc()){
    
if ($solider['weapon'] === '0'){
    $solider_weapon = 'ללא';
    $upgrade_attack = 0;
    
}else{
    $solider_weapon = $solider['weapon'];
    $upgrade_attack = $mysqli->arsenal($solider_weapon)[1];
}
    
    
    
    

if ($solider['telescop'] === '0'){
    $solider_telescop = 'ללא';
    $upgrade_accuracy = 0;
    
}else{
    $solider_telescop = $solider['telescop'];
    $upgrade_accuracy = $mysqli->arsenal($solider_telescop)[1];
}
    


$total_solider_accuracy = $solider['accuracy'] + $upgrade_accuracy;
$total_solider_attack = $solider['attack'] + $upgrade_attack;
    
if ($total_solider_accuracy > 100){
    $total_solider_accuracy = 100;
}

    
print <<<XYZ

<tr>
	  <td><input type="checkbox" name="soliders[]" value="{$solider['id']}"/></td>
	  <td><a href="soliders.php?id={$solider['id']}">{$solider['name']}</a></td>
	  <td>({$solider['attack']}) {$total_solider_attack}</td>
      <td><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{$solider['accuracy']}" aria-valuemin="0" aria-valuemax="100" style="width:{$total_solider_accuracy}%">({$solider['accuracy']}){$total_solider_accuracy}% </div> </td>
      <td>{$solider_weapon}, +({$upgrade_attack})</td>
      <td>{$solider_telescop}, +({$upgrade_accuracy})</td>
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
                <th>נשק</th>
                <th>כוונת</th>
              </tr>
	  </tfoot>
	  </table>
	  <div align="left">
	  <input type="checkbox" onchange="checkAll(this)" name="soliders[]" /> בחר הכל <br>
	  </div>
	  <input type="submit" name="buy" value="קנה !" />
	  

</form>



</div>

XYZ;
    
    
}elseif (isset($_GET['telescops'])){
    
    print <<<XYZ
    <div class="col-sm-8"> 
      <h1 align="right">חנות</h1>
	  
      <div align="center">
      <a href="shop.php">נשקים</a> | <a href="shop.php?telescops=1">כוונות</a>  |  <a href="shop.php?defences=1">הגנות</a>  |  <a href="shop.php?houses=1">בתים</a>  |  <a href="shop?hide_place=1.php">מקומות מסתור</a>
      <br>
      <br>
      </div>
	 
	  
	  <div class="col-sm-4" align="right">
	     <img src="public/images/items/metal.png" width="150px" height="150px" />
	      <p>כוונת ברזל</p>
		 <p>+{$mysqli->arsenal('metal')[1]}% : אחוזי דיוק</p>
         <p>{$mysqli->arsenal('metal')[0]} : עלות</p>
		 
         <form action="shop.php?tool=metal" method="POST">
         <input type="submit" name="metal" value="קנה" class="btn btn-success"/>
         </form>
	  </div>
      
      <div class="col-sm-4" align="right">
	      <img src="public/images/items/mafro.png" width="150px" height="150px" />
	      <p>מפרו</p>
		 <p>+{$mysqli->arsenal('mafro')[1]}% : אחוזי דיוק</p>
         <p>{$mysqli->arsenal('mafro')[0]} : עלות</p>
         <form action="shop.php?tool=mafro" method="POST">
         <input type="submit" name="mafro" value="קנה" class="btn btn-success"/>
         </form>
	  </div>
	  
	  <div class="col-sm-4" align="right">
	      <img src="public/images/items/m5.png" width="150px" height="150px" />
	      <p>m5</p>
		 <p>+{$mysqli->arsenal('m5')[1]}% : אחוזי דיוק</p>
         <p>{$mysqli->arsenal('m5')[0]} : עלות</p>
         <form action="shop.php?tool=m5" method="POST">
         <input type="submit" name="m5" value="קנה" class="btn btn-success"/>
         </form>
	  </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/trij.png" width="150px" height="150px" />
	      <p>טריג'יקון</p>
		 <p>+{$mysqli->arsenal('trij')[1]}% : אחוזי דיוק</p>
         <p>{$mysqli->arsenal('trij')[0]} : עלות</p>
         <form action="shop.php?tool=trij" method="POST">
         <input type="submit" name="trij" value="קנה" class="btn btn-success"/>
         </form>
	  </div>
	  
	  
</div>
XYZ;
    
    
    
    
    
}elseif(isset($_GET['defences'])){
    
    print <<<XYZ
<div class="col-sm-8"> 
      <h1 align="right">חנות</h1>
	  
      <div align="center">
      <a href="shop.php">נשקים</a> | <a href="shop.php?telescops=1">כוונות</a>  |  <a href="shop.php?defences=1">הגנות</a>  |  <a href="shop.php?houses=1">בתים</a>  |  <a href="shop?hide_places=1.php">מקומות מסתור</a>
      <br>
      <br>
      </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/sand_bags.png" width="150px" height="150px" />
	      <p>שקי חול</p>
		 <p>+{$mysqli->places_and_defences('sand_bags')[1]} : הגנה</p>
         <p>{$mysqli->places_and_defences('sand_bags')[0]} : עלות</p>
		 
         <form action="shop.php?defences=1" method="POST">
         <input type="submit" name="board_of_wood" value="קנה" class="btn btn-success"/>
         <input type="hidden" name="cost" value="{$mysqli->places_and_defences('sand_bags')[0]}">
         <input type="hidden" name="defence_upgrade" value="{$mysqli->places_and_defences('sand_bags')[1]}">
         
         </form>
         <br>
	  </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/board_of_wood.png" width="150px" height="150px" />
	      <p>לוח עץ</p>
		 <p>+{$mysqli->places_and_defences('board_of_wood')[1]} : הגנה</p>
         <p>{$mysqli->places_and_defences('board_of_wood')[0]} : עלות</p>
		 
         <form action="shop.php?defences=1" method="POST">
         <input type="submit" name="board_of_wood" value="קנה" class="btn btn-success"/>
         <input type="hidden" name="cost" value="{$mysqli->places_and_defences('board_of_wood')[0]}">
         <input type="hidden" name="defence_upgrade" value="{$mysqli->places_and_defences('board_of_wood')[1]}">
         
         </form>
         <br>
	  </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/board_of_steel.png" width="150px" height="150px" />
	      <p>לוח פלדה</p>
		 <p>+{$mysqli->places_and_defences('board_of_steel')[1]} : הגנה</p>
         <p>{$mysqli->places_and_defences('board_of_steel')[0]} : עלות</p>
		 
         <form action="shop.php?defences=1" method="POST">
         <input type="submit" name="board_of_steel" value="קנה" class="btn btn-success"/>
         <input type="hidden" name="cost" value="{$mysqli->places_and_defences('board_of_steel')[0]}">
         <input type="hidden" name="defence_upgrade" value="{$mysqli->places_and_defences('board_of_steel')[1]}">
         
         </form>
         <br>
	  </div>
      
    
	  
</div>
XYZ;
    
    
    
}


else{



print <<<XYZ
<div class="col-sm-8"> 
      <h1 align="right">חנות</h1>
	  
      <div align="center">
      <a href="shop.php">נשקים</a> | <a href="shop.php?telescops=1">כוונות</a>  |  <a href="shop.php?defences=1">הגנות</a>  |  <a href="shop.php?houses=1">בתים</a>  |  <a href="shop?hide_places=1.php">מקומות מסתור</a>
      <br>
      <br>
      </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/knife.png" width="150px" height="150px" />
	      <p>סכין</p>
		 <p>+{$mysqli->arsenal('knife')[1]} : התקפה</p>
         <p>{$mysqli->arsenal('knife')[0]} : עלות</p>
		 
         <form action="shop.php?tool=knife" method="POST">
         <input type="submit" name="knife" value="קנה" class="btn btn-success"/>
         
         </form>
         <br>
	  </div>
      
      <div class="col-sm-4" align="right">
	      <img src="public/images/items/pistol.png" width="150px" height="150px" />
	      <p>אקדח</p>
		 <p>+{$mysqli->arsenal('pistol')[1]} : התקפה</p>
         <p>{$mysqli->arsenal('pistol')[0]} : עלות</p>
         <form action="shop.php?tool=pistol" method="POST">
         <input type="submit" name="pistol" value="קנה" class="btn btn-success"/>
         </form>
         <br>
	  </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/ak47.png" width="150px" height="150px" />
	      <p>קלצניקוב</p>
		 <p>+{$mysqli->arsenal('ak47')[1]} : התקפה</p>
         <p>{$mysqli->arsenal('ak47')[0]} : עלות</p>
         <form action="shop.php?tool=ak47" method="POST">
         <input type="submit" name="ak47" value="קנה" class="btn btn-success"/>
         
         </form>
         <br>
	  </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/m16.png" width="150px" height="150px" />
	      <p>M-16</p>
		 <p>+{$mysqli->arsenal('m16')[1]} : התקפה</p>
         <p>{$mysqli->arsenal('m16')[0]} : עלות</p>
         <form action="shop.php?tool=m16" method="POST">
         <input type="submit" name="m16" value="קנה" class="btn btn-success"/>
         <br>
         </form>
	  </div>
      
	  
	  <div class="col-sm-4" align="right">
	     <img src="public/images/items/rpg.png" width="150px" height="150px" />
	      <p>טיל כתף</p>
		 <p>+{$mysqli->arsenal('rpg')[1]} : התקפה</p>
         <p>{$mysqli->arsenal('rpg')[0]} : עלות</p>
		 
         <form action="shop.php?tool=rpg" method="POST">
         <input type="submit" name="rpg" value="קנה" class="btn btn-success"/>
         
         </form>
         <br>
	  </div>
      
      <div class="col-sm-4" align="right">
	     <img src="public/images/items/mag.png" width="150px" height="150px" />
	      <p>מאג</p>
		 <p>+{$mysqli->arsenal('mag')[1]} : התקפה</p>
         <p>{$mysqli->arsenal('mag')[0]} : עלות</p>
         <form action="shop.php?tool=mag" method="POST">
         <input type="submit" name="mag" value="קנה" class="btn btn-success"/>
         <br>
         </form>
	  </div>
	  
	   
	  
	  
	  
	  
</div>
XYZ;


}








include ("public/buttom.html"); // ייבוא חלק תחתון של הדף


if (isset($_POST['buy'])){
    
    $soliders_bought_tools_id_array = $_POST['soliders'];
    $tool = $_GET['tool'];
    
    $query = $player->buy_tools($soliders_bought_tools_id_array, $type_sql, $tool, $cost, $username);
    
    if ($query){
        echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('הקנייה הצליחה !');</script>";
	}else{
		echo "<script>alert('הקנייה נכשלה !');</script>";
	}
    
}

if (isset($_POST['board_of_steel'])  || isset($_POST['board_of_wood']) || isset($_POST['sand_bags'])){
    
    $upgrade = (int)$_POST['defence_upgrade'];
    $cost = (int)$_POST['cost'];
    $type = 'defence';
    
    $query = $player->buy_defences_and_places($username, $upgrade, $cost, $type);
    
    if ($query){
        echo("<meta http-equiv='refresh' content='0'>");
		echo "<script>alert('הקנייה הצליחה !');</script>";
	}else{
		echo "<script>alert('הקנייה נכשלה !');</script>";
	}
    
    var_dump($upgrade);
    var_dump($cost);
    var_dump($query);
    
}


$expression = new expression;
$expression->createCookie("login", $id, 2000);










?>