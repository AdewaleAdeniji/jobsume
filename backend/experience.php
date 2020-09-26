<?php
	include 'functions.php';

	//job experience code 
	try {
	$method = $_SERVER['REQUEST_METHOD'];
	if($method==="POST"){
		//save experience
		auth();
		$dat = '{"token":"testy","company":"Google","description":"I worked on the premium menting","jobtitle":"Software Engineer","duration":"23rd October - Now "}';
		$data = json_decode(file_get_contents('php://input'));
		//$data = json_decode($dat);
		if(checkup($data)){
			$company =  parse($data->company);
			$desc = parse($data->description);
			$jobtitle = parse($data->jobtitle);
			$duration = parse($data->duration);
			if(empty($company)||empty($desc)||empty($jobtitle)||empty($duration)){
				say(203,"Empty Form Field");
			}	
			else {
				if(auth()){
					$userid = auth();
					$sql = query("SELECT * FROM jobs WHERE company='$company' AND userid='$userid' ");
					$see = check($sql);
					if($see>0){
						say(203,"Company have already been saved");
					}
					else {
						$savesql = query("INSERT INTO jobs(company,descr,jobtitle,duration,userid) VALUES('$company','$desc','$jobtitle','$duration','$userid')");
						//echo "INSERT INTO jobs(company,desc,jobtitle,duration,userid) VALUES('$company','$desc','$jobtitle','$duration','$userid')";
						if(!$savesql){
							say(203,"Request Failed");
						}
						else {
							say(200,$company." saved successfully");
						}
					}
				}
			}
		}
		else {
			say(403,"Invalid Request Body");
		}
	}
	else if($method=="GET"){
		
	}
	else if($method=="DELETE"){
		if(auth()){
			$dat = '{"token":"testy","uniquekey":"1"}';
			$data = json_decode(file_get_contents('php://input'));
			//$data = json_decode($dat);
			if(checkup($data)){
				if(isset($data->uniquekey)){
					$uniquekey = parse($data->uniquekey);
					$sql = query("SELECT * FROM jobs WHERE jobid='$uniquekey' ");
					$c = check($sql);
					if($c<1){
						say(203,"Job Not found or already deleted");
					}
					else {
						$r = query("DELETE FROM jobs WHERE jobid='$uniquekey' ");
						if(!$r){
							say(203,"Failed to delete");
						}
						else {
							say(200,"Deleted Successfully");
						}
					}
				}
				else {
					say(203,"Parameters Missing");
				}
			}
			else {
				say(403,"Empty Request Body");
			}
		}
	}

}
catch(Exception $err){
	logerror($err->getmessage());
	say(403,"Error Occured While processing your request");
}
?>