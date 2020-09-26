<?php
	//general information editing 
	include 'functions.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
	//receive detials
	$dat = '{"token":"rceswjyv5dpotk047x2nufi9bg3zq81lh6ma","username":"usernamedevddd","country":"nigeria","phoneno":"+2348107034667","portfolio":"feranmi.dev","tagline":"Software Engineer","bio":"I am a software Engineer passionate about building world class softwares with javascript","skills":"javascript-@-php","address":"","sex":"male"}';
	$data = json_decode(file_get_contents('php://input')); ///Data sent from request body
	//$data = json_decode($dat); //decoding the string into JSON 
	
	if(auth()){
		if(checkup($data)){
			foreach ($data as $key => $value) {
				# code...
				$error = false;
				if($value==""||empty($value)){
					$error = true;
					say(203,"Empty ".$key);
				}
				else {
					if(!$error){
					$userid = auth();
					if($key!="token"){
					$sql = query("UPDATE users SET $key='$value' WHERE userid='$userid' ");
					if(!$sql){
						say(203,$key."Failed to be updated");
					}
					else {

						//say(200,"success");
					}

					}
				}
				}

			}
			say(200,"Success");
		}
		else {
			say(203,"Empty Request Body");
		}
	}
	else {
		say(403,"Invalid Token");
	}
	}
	else {
		//process sending user details 
		if($_SERVER['REQUEST_METHOD'] === 'GET') {
			//send 
		
		}

	}
?>