

function set_number_of_messages(){
if ({$count_notifications_not_view} > 0){
	
	document.getElementById("notifications").innerHTML = '<a href="notifications.php"><i class="fas fa-bell" style="color:orange;"></i> {$count_notifications_not_view}</a>';
	
	
}
}

function reload_messages(username) {
      
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp = new XMLHttpRequest();

        }
xmlhttp.onreadystatechange = function() {
	
	
            if (this.readyState == 4 && this.status == 200) {
			

if (this.response > 0){
    alert(this.response);
	document.getElementById("messages").innerHTML = '<a href="message.php"><i class="fas fa-envelope" style="color:orange;"></i> ' +  this.response + '</a>';
	
}else{
	alert(this.response);
	document.getElementById("messages").innerHTML = '<a href="message.php"><i class="fas fa-envelope-open"></i> 0</a>';
}



     }
};

xmlhttp.open("GET","ajax_reload.php?reload={username}" ,true);

xmlhttp.send();
    }








