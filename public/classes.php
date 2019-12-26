<?php


class database {
    
   private $hostname = "localhost";
   private $username = "root";
   private $password = "6969778";
   private $database = "test";
   public $conn;
   protected $first_names = array("מוחמד","יוסף","אריאל","עומר","אדם","דודו","דניאל","לוי","איתן","אורי","ברוך","אבי","נדב");
   protected $last_names = array("כהן","לוי","מזרחי","פרץ","ביטון","דהן","פרידמן","מלכה","אזולאי","כץ","עמר","אוחיון");
   protected $cost = array(100, 200, 300, 400, 500, 600);
    
    
    
   public function arsenal($tool){
    
    if ($tool === '0'){
        return array(0,0);
    }
       
   // מחירים ושיפור התקפה של נשקים
   $knife = [200, 3, 'התקפה', 'weapon'];
   $pistol = [500, 4, 'התקפה', 'weapon'];
   $ak47 = [1000, 6, 'התקפה', 'weapon'];
   $m16 = [2000, 10, 'התקפה', 'weapon'];
   $rpg = [3500, 14, 'התקפה', 'weapon'];
   $mag = [6000, 25, 'התקפה', 'weapon'];
    
   // מחירים ושיפור אחוזי דיוק של כוונות
   $metal = [50, 5, 'דיוק', 'telescop'];
   $mafro_lite = [150, 13, 'דיוק', 'telescop'];
   $mafro = [350, 26, 'דיוק', 'telescop'];
   $m5 = [800, 50, 'דיוק', 'telescop'];
   $trij = [2000, 80, 'דיוק', 'telescop'];
       
   return $$tool;
       
   }
    
    

   public function places_and_defences($place){
       
       $sand_bags = [3000, 5 ,'הגנה', 'defence'];
       $board_of_wood = [12000, 23, 'הגנה', 'defence'];
       $board_of_steel = [55000, 100, 'הגנה', 'defence'];
       
       
       return $$place;
       
       
   }
   
   

   public function __construct(){
	 $this->conn = new mysqli ($this->hostname, $this->username, $this->password, $this->database); // עם קריאת הקלאס דטאבייס , יצירת התחברות למסד
	  return $this->conn; 
   }
    
    
	
	public function login($username, $password){ // ביצוע התחברות
		
		$query = "SELECT * FROM `users` WHERE (`username` = '". $username ."' or `email` = '". $username ."') and `password` = '". $password ."' limit 1"; // שאילתה אשר שולפת את הנתונים מהמשתמש שהוזן ובודקת אם הסיסמה תואמת
		$result = $this->conn->query($query); // ביצוע השאילתה
		
        $count_row = $result->num_rows; // בדיקה האם השאילתה נענתה בחיוב
		
		
		if ($count_row == 1){ // אם נענתה בחיוב 
		    $fetch = $result->fetch_assoc(); // הכנסת הנתונים למערך
			$id = $fetch['id']; // הכנסת הנתון איידי למשתנה
			$experssion = new expression; // קריאה לאקספריישן קלאס שיוצר ומסיר קוקיז
			ob_start();
			$experssion->createCookie("login", $id, "2000"); // יצירת קוקי
			ob_end_flush();

		    
			return True;
			
		}elseif($count_row == 0){ // אם נענתה בשלילה
			return False;
		}

	}
	
	public function generate_soliders($username, $scouting = 1 , $soliders = 10){ // פונקציית חישוב חיילים למשתמש 
		
		
		$first_names = $this->first_names; // מערך השמות פרטיים
		$last_names = $this->last_names; // מערך שמות המשפחה
		$cost_array = $this->cost;
		$image_number_array = array(1,2,3);
			
		for($i = 0;$i<$soliders;$i++){ // לולאה אשר פועלת לחישוב כמות החיילים עפ משתנה $soliders
		    $attack = rand(1,4) * $scouting; // רנדומלי מ 1-4
			$defence = rand(1,5) * $scouting; // רנדומלי מ 1-5
			$accuracy = rand(5,100);
			$name = $first_names[rand(0, count($first_names) - 1)] . " " . $last_names[rand(0, count($last_names) -1)];
			$cost = $cost_array[rand(0, count($cost_array) - 1)] * $scouting;
			$image = $image_number_array[rand(0, count($image_number_array) - 1)];
			$image = "public/images/soliders/" . $image . ".jpg";
			$this->conn->query("INSERT INTO `soliders` (`name`, `commander`, `image`,`cost`, `accuracy`, `attack`, `defence`, `call_up`, `weapon`, `telescop`) VALUES ('" . $name . "', '" . $username . "', '" . $image . "','" . $cost . "', '" . $accuracy . "', '" . $attack . "', '" . $defence . "', 0, 0, 0)");
		}
		
		return True;
		
	}
	
	public function sendmail(){}
	
	public function register($email, $username, $password){
		
		$query = "SELECT id FROM `users` WHERE `email` = '" . $email . "' OR `username` = '" . $username . "' limit 1"; // שאילתה לבדיקה האם הוא קיים כבר במערכת
		$result = $this->conn->query($query); // ביצוע השאילתה
		$count_row = $result->num_rows;
		if ($result->num_rows == 0) { // אם התוצאה אומרת שהוא לא במערכת
		    
			$generate_soliders = $this->generate_soliders($username); // חישוב החיילים של המשתמש והכנסם למערכת
			$image = "public/images/profiles/default.png";
			
			$query = "INSERT INTO `users` (email, username, password, image, money, last_refresh_soliders, houses, scouting, protection, spies, max_spies, defence) VALUES ('" . $email . "', '" . $username . "', '" . $password . "', '" . $image . "', 30000, '" . time() . "', 5, 1, 5, 10, 30, 30)"; // שאילתה להוספה למערכת
		    
           
            
            if ($this->conn->query($query) && $generate_soliders == True) { // אם השאילתה בוצעה בהצלחה
			    echo "<script>alert('נרשמת בהצלחה. אנא אשר הרשמת באימייל !')</script>"; // חלון קופץ אשר מבשר על ההצלחה
				$this->sendmail();
				return; // סיים
		    }else{ // אם השאילתה לא בוצעה בהצלחה
				echo "<script>alert('משהו השתבש. אנא נסה שנית !')</script>"; // חלון קופץ אשר מבשר על הכישלון
				return; // סיים
			}
		}else { // אם התוצאה אומרת שהוא במערכת
			echo "<script>alert('שם משתמש או האימייל כבר רשומים במערכת !')</script>"; // חלון קופץ אשר מבשר על שהמשתמש כבר במערכת
			return; // סיים
		}
		
		
		
	}
	
	
	public function players_table(){ // פונקצייה אשר שולפת את כל השחקנים מהטבלה
		
		$query = $this->conn->query("SELECT * FROM `users`"); // ביצוע השאילתה
		return $query; // החזר תוצאת שאילתה. סיים
	}
	
	
	
	// <-- פונקציות התראות מתחילות מפה --> //
	
	public function count_notifications_not_view($receiver){
		$query = $this->conn->query("SELECT COUNT(*) AS notification FROM `notification` WHERE `receiver` = '" . $receiver . "' AND `view` = 0")->fetch_assoc();
		
		return $query['notification'];
	}
	
	public function set_notifications_as_read($receiver){
		
		$query = $this->conn->query("UPDATE `notification` SET `view` = 1 WHERE `receiver` = '" . $receiver . "' AND `view` = 0");
		
	}
	
	public function send_notification($receiver, $body){
		
		$time = time() + 7200;
		
		$this->conn->query("INSERT INTO `notification` (`receiver`, `time`, `body`, `view`) VALUES ('" . $receiver . "', '" . $time . "', '" . $body . "', 0)");
		
	}
	
	public function select_notifications($receiver){
		
		$query = $this->conn->query("SELECT * FROM `notification` WHERE `receiver` = '" . $receiver . "' ORDER BY `time` DESC");
		return $query;
		
	}
		
	
	// <-- פונקציות התראות מסתיימות פה --> //
	
	
	
}


class message extends database{ // הודעות בין משתמשים באתר


   // <-- פונקציות לשליחת הודעות --> //
	
	public function name_by_id($id){ // הכנסת איידי של משתמש וקבלת השם שלו
		$name_by_id = $this->conn->query("SELECT `username` from `users` WHERE `id` = '" . $id . "' limit 1"); // שאילתה למסד אשר מקבלת שם שמתאים לאיידי
		$name_by_id = $name_by_id->fetch_assoc(); // הכנסת הנתונים מערך
		return $name_by_id['username']; // החזרת הנתון
	}
	
	public function sender($name){ // פונקצייה לשליפת הודעות שנשלחו בידי המשתמש
		
		$query = $this->conn->query("SELECT * FROM `message` WHERE sender = '" . $name . "' ORDER BY `time` DESC"); // שאילתה למסד לשלוף את כל ההודעות שהמשתמש שלח
		return $query; // החזר תוצאת שאילתה. סיים
		
	}
	
	public function receiver($name){ // פונצקייה לשליפת הודעות שקיבל המשתמש
		
		$query = $this->conn->query("SELECT * FROM `message` WHERE receiver = '" . $name . "' ORDER BY `time` DESC"); // שאילתה למסד לשלוף את כל ההודעות שהמשתמש קיבל
		return $query; // החזר תוצאת שאילתה. סיים
		
	}
	
	public function send_message($sender, $receiver, $body, $time){ // פונקצייה לשליחת הודעה
	    $time = $time + 7200; // שעתיים קדימה , לכוון לאזור זמן ישראל
		
		$query = $this->conn->query("SELECT `username` FROM `users` WHERE `username` = '" . $receiver . "' limit 1"); // שאילתה אשר בודקת האם המשתמש שליו נשלחה ההודעה קיים
		
		if ($query->num_rows == 0) { // שאילתה אשר בודקת האם המשתמש שאליו נשלחה ההודעה קיים. אם לא קיים עשה את זה
			echo "<script>alert('המשתמש שאליו שלחת הודעה אינו קיים !')</script>"; //  חלון קופץ אשר מבשר על כישלון
			return; // סיים
		}
		$query = $this->conn->query("INSERT INTO `message` (`sender`, `receiver`, `body`, `time`, `view`) VALUES ('" . $sender . "', '" . $receiver . "' , '" . $body . "' , '" . $time . "', 0)"); // הכנס את ההודעה למסד הנתונים עפ הפרטים שנשלחו
		if ($query){ // אם השאילתה הצליחה
			echo "<script>alert('ההודעה נשלחה בהצלחה!')</script>"; // חלון קופץ אשר מבשר על הצלחה
		}else{ // אם לא
			echo "<script>alert('משהו השתבש. אנא נסה שנית !')</script>"; // חלון קופץ אשר מבשר על הכישלון
		}
	}
	
	public function count_message_not_view($receiver){ // קבלת כמות ההודעות שלא נקראו
		
		$query = $this->conn->query("SELECT `view` FROM `message` WHERE `receiver` = '" . $receiver . "' AND `view` = 0"); // ביצוע שאילתה אשר שולפת את ההודעות שנשלחו למשתמש ושלא נקראו
		return $query->num_rows; // החזר את מס ההודעות שהמשתמש קיבל ולא קרא. סיים
		
		
	}
	
	public function set_messages_as_read($receiver){ // פונקצייה אשר מעדכנת הודעות שלא נקראו בידי המשתמש , לנקראו
		$query = $this->conn->query("UPDATE `message` SET `view` = 1 WHERE `view` = 0 AND `receiver` = '" . $receiver . "'");
	}
	
	public function delete_messages($messages_array){
		
		for($i = 0;$i < count($messages_array);$i++){
			$query = $this->conn->query("DELETE FROM `message` WHERE `id` = '" . $messages_array[$i] . "' limit 1");
			if ($query){
				
			}else{
				return False;
			}
		}
		return True;
		
	}
	
	// <-- פונקציות הודעות מסתיימות פה --> //
	
	
}



class expression{
	
	public function createCookie($name, $value, $time, $path = "/"){ // פונקצייה ליצירת קוקי
		echo '<script>document.cookie = "' . $name . '=' . $value . '; expires=' . $time . '; path=' . $path . '"</script>';
	}
	
	public function unsetCookie($name){ // פונקציה להסרת הקוקי
		setcookie($name, "", "99999", "/"); // הסרת הקוקי
	}
	
}


class player extends database {
	
	public function send_money($player_sender, $player_receiver, $money){
		
		$query = $this->conn->query("SELECT `money` FROM `users` WHERE `username` = '" . $player_sender . "'")->fetch_assoc(); // כמות הכסף שיש לשולח
		if ($query['money'] < $money){ // אם כמות הכסף שיש לשולח קטן מהכסף שהוא מנסה לשלוח
			return False;
		}
		
		if ($player_sender == $player_receiver){ // אם השולח מנסה לשלוח כסף לעצמו
			
			return False;
		}
		
		$change_receiver_money_amount = $this->conn->query("UPDATE `users` SET `money` = `money` + '" . $money . "' WHERE `username` = '" . $player_receiver . "'"); // שאילתה לשינוי כמות הכסף של המקבל
		$change_sender_money_amount = $this->conn->query("UPDATE `users` SET `money` = `money` - '" . $money . "' WHERE `username` = '" . $player_sender . "'"); // שאילתה לשינוי כמות הכסף של השולח
		if ($change_receiver_money_amount && $change_sender_money_amount){ // אם השאילתות הצליחו
		    
			$body = "השחקן : " . $player_sender .
			        "<br> שלח לך : " . $money;
			
		    $this->send_notification($player_receiver, $body);
			return True; // החזר ערך אמת
		}else{
			return False; // החזר ערך שקר
		}
		
	}
    
    public function scout_system_improve($username, $cost_scout_improve){
        
        $query = $this->conn->query("UPDATE `users` SET `money` = `money` - '" . $cost_scout_improve . "' WHERE `username` = '" . $username . "' limit 1 ");
        $query2 = $this->conn->query("UPDATE `users` SET `scouting` = `scouting` + 1 WHERE `username` = '" . $username . "' limit 1");
    
        if ($query && $query2){
            return True;
        }
    }
    
    public function calc_soliders_features_with_upgrades($solider_id){
        
        $solider = $this->conn->query("SELECT `attack`,`accuracy`,`weapon`,`telescop` FROM `soliders` WHERE `id` = '" . $solider_id . "'")->fetch_assoc();
        
        if ($solider['weapon'] === '0'){
            $solider_weapon = 'ללא';
            $upgrade_attack = 0;
    
        }else{
            $solider_weapon = $solider['weapon'];
            $upgrade_attack = $this->arsenal($solider_weapon)[1];
        }
    

        if ($solider['telescop'] === '0'){
            $solider_telescop = 'ללא';
            $upgrade_accuracy = 0;
    
        }else{
            $solider_telescop = $solider['telescop'];
            $upgrade_accuracy = $this->arsenal($solider_telescop)[1];
        }
    


        $total_solider_accuracy = $solider['accuracy'] + $upgrade_accuracy;
        $total_solider_attack = $solider['attack'] + $upgrade_attack;
    
        if ($total_solider_accuracy > 100){
            $total_solider_accuracy = 100;
        }
        
        
        
        return array($total_solider_accuracy, $total_solider_attack);
        
    }
    
    public function buy_tools($soliders_bought_tools_id_array, $type, $tool, $cost, $username){
        
        
        for ($i = 0; $i < count($soliders_bought_tools_id_array); $i++) {
		
		    $add_tool_to_solider = $this->conn->query("UPDATE `soliders` SET ".$type." = '" . $tool . "' WHERE `id` = '" . $soliders_bought_tools_id_array[$i] . "'");
            
		}
        
        
        
        $remove_money_from_the_buyer = $this->conn->query("UPDATE `users` SET `money` = `money` - '" . $cost * count($soliders_bought_tools_id_array) . "' WHERE `username` = '" . $username . "' limit 1");
        
        return $remove_money_from_the_buyer;
        
        
    }
    
    public function buy_defences_and_places($username, $upgrade, $cost, $type){
        
        $query = $this->conn->query("UPDATE `users` SET ".$type." = ".$type." + '" . $upgrade . "' WHERE `username` = '" . $username . "'");
        $query2 = $this->conn->query("UPDATE `users` SET `money` = `money` - '" . $cost . "' WHERE `username` = '" . $username . "'");
        
        if ($query && $query2){
            return True;
        }else{
            return False;
        }
        
    }
	
	public function army($username){ // מתודה לחישוב כמות החיילים של המשתמש
		
		$query = $this->conn->query("SELECT COUNT(*) AS `soliders` FROM `soliders` WHERE `commander` = '" . $username . "' AND `call_up` = 1")->fetch_assoc();
		return $query['soliders'];
		
	}
	
	public function select_soliders_option($username){ // שליפת חיילים שעדיין לא גויסו
		
		$query = $this->conn->query("SELECT * FROM `soliders` WHERE `commander` = '" . $username . "' AND `call_up` = 0");
		return $query;
		
		
	}
	
	public function data($username){ // מתודה לשליפת מידע על המשתמש
		
		$query = $this->conn->query("SELECT `id`, `username`, `money`, `last_refresh_soliders`, `image`, `scouting`, `houses`, `protection`, `spies`, `max_spies`, `defence` FROM `users` WHERE `username` = '" . $username . "' limit 1")->fetch_assoc();
		return $query;
		
	}
	
	public function solider_data($id) { // שליפת נתונים של חייל ספציפי לפי איידי
		
		$query = $this->conn->query("SELECT * FROM soliders WHERE `id` = '" . $id . "' limit 1");
		return $query;
		
	}
	
	public function call_up_solider($username, $id, $cost){ // גיוס שחקן שעדיין לא גויס
		
		$query = $this->conn->query("UPDATE `soliders` SET `call_up` = 1 WHERE `id` = '" . $id . "' limit 1"); // עדכן שהחייל גויס באמת גויס
		$query2 = $this->conn->query("UPDATE `users` SET `money` = `money` - '" . $cost . "' WHERE `username` = '" . $username . "' limit 1"); // משוך כסף מהשחקן
		if($query && $query2){ // אם שתי השאילתות הצליחו
		return True; // החזר תוצאה חיובית
		}else{ // אם לא
			return False; // החזר תוצאה שלילית
		}
	}
	
	public function select_called_up_soliders($username){ // מתודה לשליפת חיילים שגוסיו
		
		$query = $this->conn->query("SELECT * FROM `soliders` WHERE `commander` = '" . $username . "' AND `call_up` = 1");
		return $query; // החזר תוצאה
		
        
	}
    
    public function fire_solider($username, $id, $cost){
        
        $query = $this->conn->query("UPDATE `soliders` SET `call_up` = 0 WHERE `id` = '" . $id . "' limit 1");
        $query2 = $this->conn->query("UPDATE `users` SET `money` = `money` + '" . $cost / 2 . "' WHERE `username` = '" . $username . "' limit 1");
        
        if($query && $query2){ // אם שתי השאילתות הצליחו
		return True; // החזר תוצאה חיובית
		}else{ // אם לא
			return False; // החזר תוצאה שלילית
		}
    }
	
	public function spying($attacker, $defender, $attacker_spies){ // מתודה לריגול בין משתמשים
		
		$defender_spies = $this->conn->query("SELECT `spies` FROM `users` WHERE `username` = '" . $defender . "' limit 1")->fetch_assoc()['spies']; // שליפת כמות החפרפרות של המגן
		if ($attacker_spies > $defender_spies){ // אם כמות החפרפרות של התוקף גדול משל המגן
			
			$defender_data = $this->conn->query("SELECT `id` , `username` , `money`, `houses`, `scouting` , `protection`, `spies`, `max_spies` FROM `users` WHERE `username` = '" . $defender . "'")->fetch_assoc();
			
			$body = $defender_data['id'] . " : מס אישי <br>" .
			        $defender_data['username'] . " : שם משתמש <br>" .
					$defender_data['money'] . " : דולרים <br>" .
					$defender_data['houses'] . " : בתים <br>" .
					$defender_data['scouting'] . " : מערך סקאוטינג <br>" .
					$defender_data['protection'] . " : חנויות דמי חסות <br>" .
					$defender_data['spies'] . " : חפרפרות <br>";
					
			$defender_soliders = $this->conn->query("SELECT * FROM `soliders` WHERE `commander` = '" . $defender . "' AND `call_up` = 1");
			while ($row = $defender_soliders->fetch_assoc()){
				
				$body .= "התקפה : " . $row['attack'] . " הגנה : " . $row['defence'] . " עלות : " . $row['cost'] .  " " . $row['name'] . " <br>";
				
			}
            
            var_dump($body);
			
			$this->send_notification($attacker, $body);
			
			return array(True);
		}
		
		else if($attacker_spies < $defender_spies){
			$spies_attacker_dead = round($defender_spies / $attacker_spies);
			if ($spies_attacker_dead > $attacker_spies){
				$spies_attacker_dead = $attacker_spies;
			}
			
			$set_attacker_spies_dead = $this->conn->query("UPDATE `users` SET `spies` = `spies` - '" . $spies_attacker_dead . "' WHERE `username` = '" . $attacker . "'");
			
			return array(False, $spies_attacker_dead);
		}
		
		
		
	}
	
	
	public function attacking($attacker , $defender , $attacker_soliders_id_array){
		
		$attacker_attack = 0;
		$attacker_accuracy = 0;
		$attacker_number_of_soliders = count($attacker_soliders_id_array) - 1;
		
		
		for ($i = 0; $i < count($attacker_soliders_id_array) - 1; $i++) {
		
		    $attacker_solider = $this->conn->query("SELECT `attack`, `accuracy`, `weapon`, `telescop` FROM `soliders` WHERE `id` = '" . $attacker_soliders_id_array[$i] . "'")->fetch_assoc();

			
			$attacker_attack += $attacker_solider['attack']; // הוספת נזק למתקפה עקב כוח התקיפה של החייל
            
            
            
            $attacker_attack += $this->arsenal($attacker_solider['weapon'])[1]; // הוספת נזק למתקפה עקב שימוש בנשק החייל
            
            
    
            
            
			$total_attacker_solider_accuracy = intval($attacker_solider['accuracy']) + $this->arsenal($attacker_solider['telescop'])[1];
            
            
            if ($total_attacker_solider_accuracy > 100){
                $total_attacker_solider_accuracy = 100;
            }
            
            $attacker_accuracy += $total_attacker_solider_accuracy;
            
		
		}
		
		$defender_defence = 0;
		$defender_accuracy = 0;
		$defender_number_of_soliders = $this->conn->query("SELECT COUNT(*) AS soliders FROM `soliders` WHERE `commander` = '" . $defender . "' AND `call_up` = 1")->fetch_assoc()['soliders'];
		
		
		$query = $this->conn->query("SELECT `defence`, `accuracy` FROM `soliders` WHERE `commander` = '" . $defender . "' AND `call_up` = 1");
		while($defender_solider = $query->fetch_assoc()){
			
			$defender_defence += $defender_solider['defence'];
			$defender_accuracy += $defender_solider['accuracy'];
			
		}
		
		$defender_luck = rand(8.5 , 11.5) / 10;
		$attacker_luck = rand(8.5, 11.5) / 10;
		
		
		$attacker_total = ($attacker_attack * ($attacker_accuracy / $attacker_number_of_soliders / 100)) / $attacker_luck;
        var_dump($attacker_accuracy);
		var_dump($attacker_total);
        var_dump($attacker_attack);
		$defender_total = ($defender_defence * (($defender_accuracy / $defender_number_of_soliders) / 100)) / $defender_luck;
		var_dump($defender_total);
		
		if ($attacker_total > $defender_total){
			
			$ratio = $attacker_total / $defender_total;
			
			
			return True;
		}else{
			return False;
		}
		
		
		
	}
	
	
	public function upload_image($username, $image){
		
		$target_dir = "public/images/profiles/";
		$target_file = $target_dir . basename($username) . ".png";
		$upload_image = move_uploaded_file($image["tmp_name"], $target_file);
		$query = $this->conn->query("UPDATE `users` SET `image` = '" . $target_file . "' WHERE `username` = '" . $username . "' limit 1");
		if ($upload_image && $query){
			return True;
		}else{
			return False;
		}
		
		
	}
	
	
	
	public function refresh_soliders ($username, $scouting){
		
		$delete_dont_called_soliders = $this->conn->query("DELETE FROM `soliders` WHERE `commander` = '" . $username . "' AND `call_up` = 0 limit 10");
		$generate_soliders = $this->generate_soliders($username, $scouting);
		$set_new_last_refresh_soldiers = $this->conn->query("UPDATE `users` SET `last_refresh_soliders` = '" . time() . "' WHERE `username` = '" . $username . "' limit 1 ");
		
		if ($generate_soliders && $delete_dont_called_soliders && $set_new_last_refresh_soldiers){
			return True;
		}else{
			return False;
		}
		
	}
	

	
	
}
	

class bets extends database { // אובייקט ההימורים באתר

    public function reverse_format_number($num){
		
		return preg_replace("[^0-9]", "", $num); 
		
	}
	
	public function encode_commas($num){
		
		return preg_replace('/\,/', '&#44;', $num); 
	}
	
	public function roulette($color, $bet, $username){ // פונקציית רולטה
		
		$num = rand(1, 38); // הגרלת מספר בין 1 ל 38
		
		if($num==1 || $num==3 || $num==5 || $num==7 || $num==9 || $num==12 || $num==14 || $num==16 || $num==18 || $num==19 || $num==21 || $num==23 || $num==25 || $num==27 || $num==30 || $num==32 || $num==34 || $num==36){ // תוצאת צבע אדום. סיכויים של 1 : 2
		
		$winning_color = "red"; // המרת התוצאה לצבע
		
		}else if($num==37 || $num==38){ // אם הצבע יצא ירוק. סיכויים של 1:18
			
			$winning_color = "green"; // המרת התוצאה לצבע
			
		}else{ // אם הצבע יצא שחור. סיכויים של 1:2
            
            $winning_color = "black"; // המרת התוצאה לצבע
        }
		
		if ($color == $winning_color){ // אם הצבע שהומר זכה
			if ($winning_color == 'red' || $winning_color == 'black'){ // אם הצבע שהומר וניצח הוא ירוק או שחור
				
				$result = array(True, $bet); // הכנסת התוצאה למערך. התא הראשון הוא האם ההימור הצליח , והתא השני הוא כמות הזכייה
				
				$query = $this->conn->query("UPDATE `users` SET `money` = `money` + '" . $bet . "' WHERE `username` = '" . $username ."'"); // שינוי כמות הכסף של המשתמש בעקבות הזכייה
				
			    return $result; // החזר מערך המכיל את התוצאות
			}else if ($winning_color == 'green'){ // אם הצבע שהומר וניצח הוא ירוק
				$result = array(True, $bet * 36); // הכנסת התוצאה למערך. התא הראשון הוא האם ההימור הצליח , והשני הוא כמות הזכייה
				
				$query = $this->conn->query("UPDATE `users` SET `money` = `money` + '" . $bet * 36 . "' WHERE `username` = '" . $username ."'"); // שינוי כמות הכסף של המשתמש בעקבות הזכייה
				
			    return $result; // החזר מערך המכיל את התוצאות
			}
		    }else{ // אם המשתמש המר על צבע לא נכון
			    $result = array(False, $bet); // הכנסת התוצאה למערך. התא הראשון הוא האם ההימור הצליח , והתא השני הוא כמות הזכייה
				
				$query = $this->conn->query("UPDATE `users` SET `money` = `money` - '" . $bet . "' WHERE `username` = '" . $username ."'"); // שינוי כמות הכסף של המשתמש בעקבות הכישלון
				
			    return $result; // החזר תוצאה
		}
		
		
		
	}
	
}
	
	



?>