<?php
	
	include 'functions.php';
//	$data = json_decode('{"email":"dev@dev.com","password":"password"}');
	$data = json_decode(file_get_contents('php://input'));
	if(checkup($data)){
		$email = parse($data->email);
		$password = parse($data->password);
		if(strlen($password)<8){
			say(203,"Password Length should be 8 characters or more");
		}
		if(validateInput($email)){
			if(emailExists($email)){
				$newpassword = md5($password);
				$sql = query("SELECT userid,password FROM users WHERE emailaddress='$email' AND password='$newpassword' ");
				if(check($sql)>0){
					$row = fetch($sql);
					$userid = $row['userid'];

					$token = gen();
					$expiry = expiry();
					$cleartokens = query("DELETE FROM tokens WHERE issuedto='$userid' ");
					$savetoken = query("INSERT INTO tokens(token,issuedto,timest) VALUES('$token','$userid','$expiry')");
					say(200,$token);
				}
				else {
					say(203,"Incorrect Email Address or Password");
				}
			}
			else {
				say(203,"Email Address have not been registered");
			}
		}
		else {
			say(203,"Invalid or Incorrect Email Address");
		}
	}
	else {
		say(403,"Invalid Request Body");
	}
	
?>