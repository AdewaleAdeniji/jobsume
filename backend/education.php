<?php
	include 'functions.php';
	$method = $_SERVER['REQUEST_METHOD'];
	if($_SERVER['REQUEST_METHOD']==='POST'){
		$dat = '{"token":"testy","school":"Lautech","course":"Biotech","duration":"duration"}';
		$data = json_decode(file_get_contents('php://input'));
	//	$data = json_decode($dat);
		if(checkup($data)){
			if(auth()){
				$userid = auth();
				$school = parse($data->school);
				$course = parse($data->course);
				$duration = parse($data->duration);
				if(empty($school)||empty($course)||empty($duration)){
					say(203,"Empty Form Field");
				}
				else {
					$j = query("SELECT * FROM education WHERE school='$school' ");
					if(check($j)>0){
						say(200,"Data saved successfully");
					}
					$sql = query("INSERT INTO education(school,course,userid,duration) VALUES('$school','$course','$userid','$duration')");
					if(!$sql){
						say(203,"Data failed to save");
					}
					else {
						say(200,"Data saved successfully");
					}
				}
			}
			else {
				say(205,"Login Again");
			}
		}
		else {
			say(403,"Empty Request Body");
		}

	}
	else if($method==='GET'){
		//$dat = '{"token":"testy"}';
		
	}
	else if($method==="DELETE"){
		$dat = '{"token":"testy","eduid":"1"}';
		$data = json_decode(file_get_contents('php://input'));
		//$data = json_decode($dat);
		if(checkup($data)){
			if(auth()){
				$userid = auth();
				$eduid = parse($data->eduid);
				$sql = query("SELECT * FROM education WHERE eduid='$eduid' ");
				$c = check($sql);
				if($c==0){
					say(203,"Education does not exist");
				}
				else {
					$delsql = query("DELETE FROM education WHERE eduid='$eduid' ");
					if(!$delsql){
						say(203,"Delete Failed");
					}
					else {
						say(200,"Deleted Successfully");
					}
				}
			}
		}	
		else {
			say(403,"Empty Request Body");
		}
	}
	else if($method==="PATCH"){
		
		$dat = '{"token":"testy","eduid":"2","school":"University of the people","course":"Biotechnology","duration":"duration"}';
		$data = json_decode(file_get_contents('php://input'));
		//$data = json_decode($dat);
		if(checkup($data)){
			if(auth()){
				$userid = auth();
				$school = parse($data->school);
				$course = parse($data->course);
				$duration = parse($data->duration);
				$eduid = parse($data->eduid);
				if(empty($school)||empty($course)||empty($duration)||empty($eduid)){
					say(203,"Empty Form Field");
				}
				else {
					$eduxist = query("SELECT * FROM education WHERE eduid='$eduid' ");
					$co = check($eduxist);
					if($co<1){
						say(203,"Education does not exist");
					}
					else {
						$sql = query("UPDATE education SET school='$school',course='$course',duration='$duration' ");
						if(!$sql){
							say(203,"Request Failed");
						}
						else {
							say(200,"Education Updated successfully");
						}
					}
				}
			}
			else {
				say(205,"Login Again");
			}
		}
		else {
			say(403,"Empty Request Body");
		}
	}	
	else {
		say(203,"none");
	}
?>