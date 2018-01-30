<?php

function getpost_ifset($test_vars)
{
	if (!is_array($test_vars)) {
		$test_vars = array($test_vars);
	}
	foreach($test_vars as $test_var) { 
		if (isset($_POST[$test_var])) { 
			global $$test_var;
			$$test_var = $_POST[$test_var]; 
		} elseif (isset($_GET[$test_var])) {
			global $$test_var; 
			$$test_var = $_GET[$test_var];
		}
	}
}

function randNum($min, $max){
        srand((double)microtime()*1000000);
        $tmp = rand($min,$max);
    return $tmp;
}

function getConfDate() {
   $date = getDate();
   foreach($date as $item=>$value) {
       if ($value < 10)
           $date[$item] = "0".$value;
   }
   return $date['year']."-".$date['mon']."-".$date['mday']." ".$date['hours'].":".$date['minutes'].":00";
}


function arraytostring ($array) {
	$arraystring = "";
	foreach ($array as $item=>$value) {
		$arraystring .= "$value";
	}
return ($arraystring);
}

function strtoflags ($temp) {
	
}
function  checkEmail($email) {
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
		return TRUE;
	}
	return FALSE;
}

class userSec {

	function authenticate($user,$password){
		switch (AUTH_TYPE) {
			case "adLDAP":
                		$adldap = new adLDAP();

		                if ($adldap -> authenticate($user,$password)){
               		         	$expires = time() + AUTH_TIMEOUT*3600;
                       		 	$_SESSION['userid']=$user;
                        		$_SESSION['auth']="true";
                        		$_SESSION['privilege']="User";
                        		$_SESSION['lifetime']=$expires;
					 if ($adldap -> user_ingroup($user, ADMIN_GROUP)){
                                        	 $_SESSION['privilege']="Admin";
                                        }

				}
			break;

			case "sqldb":
		                if ($uid = authsql($user,$password))
				{
               		         	$expires = time() + AUTH_TIMEOUT*3600;
                       		 	$_SESSION['userid']=$user;
                        		$_SESSION['auth']="true";
                        		$_SESSION['lifetime']=$expires;
                        		$_SESSION['clientid']=$uid;
				}
			break;
		}


        }



        function isAdmin($user){
                switch (AUTH_TYPE) {
                        case "adLDAP":
			break;

		}
        }

}

function use24h(){
        if ((!defined('USE_24H'))
	    || (USE_24H != "YES")) {
                return 0;
	}
	else {
                return 1;
	}
}

function litteral_day($day)
{
	switch($day) {
	  	case 'Monday': $litteral_day = _("Monday"); break;
	  	case 'Tuesday': $litteral_day = _("Tuesday"); break;
	  	case 'Wednesday': $litteral_day = _("Wednesday"); break;
	  	case 'Thursday': $litteral_day = _("Thursday"); break;
	  	case 'Friday': $litteral_day = _("Friday"); break;
	  	case 'Saturday': $litteral_day = _("Saturday"); break;
	  	case 'Sunday': $litteral_day = _("Sunday"); break; }
	return $litteral_day;
}
?>
