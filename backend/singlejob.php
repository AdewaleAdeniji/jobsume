<?php
	include 'functions.php';

	$dat = '{"jobid":"1"}';
	$data = json_decode(file_get_contents('php://input'));
	$data = json_decode($dat);

	$jobid = parse($data->jobid);
	$sql = query("SELECT * FROM roles WHERE roleid='$jobid' ");
	$row = fetch($sql);
	say(200,$row);
?>