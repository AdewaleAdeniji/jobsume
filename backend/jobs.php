<?php
	
	include 'functions.php';

	$sql = query("SELECT * FROM roles ORDER BY roleid DESC");
	$jobs= [];
	while($row=fetch($sql)){
		$msg = new stdclass;
		$msg->title = $row['roletitle'];
		$msg->company = $row['skills'];
		$msg->roledate = $row['roledate'];
		$msg->rolelink = $row['rolelink'];
		$msg->tag = $row['roletag'];
		$msg->desc = $row['roledesc'];
		$msg->location = $row['location'];
		$msg->pay = $row['pay'];
		$msg->roleid = $row['roleid'];
		array_push($jobs,$msg);
	}
	say(200,$jobs);
?>