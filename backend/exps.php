<?php
	include 'functions.php';
	if(auth()){
			$userid = auth();
			$sql = query("SELECT * FROM jobs WHERE userid='$userid' ");
			if(check($sql)<1){
				say(201,"NO prior Job experience");
			}
			else {
				$arr = [];
				while($row=fetch($sql)){
					$msg = new stdclass;
					$msg->company = $row['company'];
					$msg->description = $row['descr'];
					$msg->jobtitle = $row['jobtitle'];
					$msg->duration = $row['duration'];
					$msg->uniquekey = $row['jobid'];
					array_push($arr,$msg);
				}
				say(200,$arr);
			}
		}
?>