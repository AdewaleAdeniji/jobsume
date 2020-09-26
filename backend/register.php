<?php
 	include 'functions.php';
 	if($_SERVER['REQUEST_METHOD'] === 'POST') {
 	$dat = '{"email":"dev@dev.com","username":"username","password":"password"}';
	$data = json_decode(file_get_contents('php://input')); ///Data sent from request body
	//$data = json_decode($dat); //decoding the string into JSON 
	if(checkup($data)){ //
		$email = parse($data->email);
		$username = parse($data->username);
		//pass the string for SQL injection with mysqli_real_escape_string;function parse() have been defined in my.php;
		$password = parse($data->password);
		$arr = [$email,$password,$username];
		//validates the request body for empty strings 
		$labels = ['Email Address','Password','Username'];
		for($i=0;$i<count($arr);$i++){
			if(empty($arr[$i])){
				$validationMessage = $labels[$i]." is empty";
				say(203,$validationMessage);
			}

		}
		$email = validateInput($email);
		if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
		  say(203,"Only letters  allowed in the username field");
		}
		if(strlen($password)<8){
			say(203,"Password should be more than 8 characters");
		}
		//at this stage the username,password and email have been validated and sanitized
		//we need to check if the email address already exist before making another insert
		//function emailExists have already been declared in functions.php to allow access by other files
		if(emailExists($email)){
			say(206,"Email Address have already been registered.You can login to your account or Forgot password if you forget your password");
			exit();
		}
		else {
			//email have been verified not to be existent in the database
			//now we can safely hash the password and save the data
			$newpassword = md5($password);
			include 'mailer.php'; //contains function for sending verification mail 
			$verificationToken = gen();// this function was defined in my.php,It's for generating random numbers 
			$link = '<a href="https://jobsume.netlify.app/verify#'.$verificationToken.'">Verify my account</a>';
			$body = "Thanks for signing up on Jobsume,For security purposes please click on this link to verify your email address".$link;
			mailme("Verify your Email Address:Chrony",$email,$username,$body);
			$userid = $email;
			$expiry = expiry();//this function returns the token expiry/session 
			$sql = query("INSERT INTO users(username,emailaddress,password,status) VALUES('$username','$email','$newpassword','0') ");
			//$verifysql = query("INSERT INTO tokens(token,userid,expiry) VALUES('$verificationToken','$userid','$expiry')");
			say(200,"Sign  Up success");
		}


	}	
	else {
		say(403,"Empty Request"); //sends  a JSON response back containing parameter 1(403) as status and parameter 2 as the reason for error/success
	}
	}

	

?>