<?php
		include 'functions.php';
		if(auth()){
			$userid = auth();
			$sql= query("SELECT school,course,duration,eduid AS id FROM education WHERE userid='$userid' ");
			$check = check($sql);
			if($check==0){
				say(201,"No prior Education Saved");
			}
			else {
				$arr = [];
				while($row = fetch($sql)){
					$a = new stdclass;
					$a->school = $row['school'];
					$a->course = $row['course'];
					$a->duration = $row['duration'];
					$a->id = $row['id'];
					array_push($arr,$a);
				}
				say(200,$arr);
				
			}
		}
		else {
			say(403,"Empty Request Body");
		}

?>