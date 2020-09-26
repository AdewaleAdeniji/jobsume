<?php
	include 'my.php';
	function auth(){
		$data = json_decode('{"token":"testy"}');
		$data = json_decode(file_get_contents('php://input'));
		if(checkup($data)){
			if(isset($data->token)){
				$token = parse($data->token);
				$sql = query("SELECT * FROM tokens WHERE token='$token' ");
				$c = check($sql);
				//echo $c.'0';
				if($c>0){
					$row = fetch($sql);
					if($token=="testy"){
						$userid = $row['issuedto'];
						return $userid;	
					}
					else {
					 $hournow = date('H');
			 		 $daynow = date('d')*1;
			 		 $date = $row['timest'];
			 		 $hou = explode(':',$date);
			 		 $arr = explode('-', $date);
			 		 $sec = explode('/',$arr[1]);
			 		 $day = $sec[0];
			 		 if($day!=$daynow){
			 		 	say(205,'You need to login to authenticate: SESSION EXPIRED');
			 		 	exit();
			 		 }
			 		 $hour = $hou[0]*1;
			 		 $diff = abs($hournow-$hour);
			 		 if($diff>2){
			 		 	say(205,'You need to login to authenticate:Session  Expired');
			 		 	exit();
			 		 }
			 		 else {
						$userid = $row['issuedto'];
						return $userid;	
			 		 
			 		 }
			 		}
				}
				else {
					say(205,"Incorrect Authentication token");
				}
			}
			else {
				say(403,"Token Missing");
			}
		}
		else {
			say(403,"Invalid Request Header");
		}
	}
	function checkup($e){
		if(empty($e)||$e==""){
			return false;
		}
		else {
			return true;
		}
	}
	function emailExists($email){
		//this function checks if an email address already exist in the database
		$sql = query("SELECT * FROM users WHERE emailaddress='$email' ");
		//return $email.check($sql);
		//exit();
		if(check($sql)<1){
			return false;
		}
		else {
			return true;
		}	
	}
	function validateInput($email){ //this functions validates email address
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			return $email;
		}
		else {
			say(203,"Invalid Email Address");
		}
	} 
	//auth();
?>