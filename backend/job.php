<?php

	include 'functions.php';

	if(auth()){
		$posterid = auth();
		$dat = '{"company":"Google","title":"Software Engineer","desc":"React,Angular","tag":"FRONTEND","link":"https://devferanmi.netlify.app","location":"Remote","pay":"N/A"}';
		$data = json_decode(file_get_contents('php://input'));
		$data = json_decode($dat);

		$company = parse($data->company);
		$title = parse($data->title);
		$desc = parse($data->desc);
		$tag = parse($data->tag);
		$link = parse($data->link);
		$location = parse($data->location);
		$pay = parse($data->pay);
		$roledate = now();
		$sql = query("INSERT INTO roles(roletitle,roledate,rolelink,roletag,roledesc,pay,skills,location) VALUES('$title','$roledate','$link','$tag','$desc','$pay','$company','$location')");
		if(!$sql){
			say(203,'Request Failed');
		}
		else {
			say(200,"Job saved successfully");
		}
	}
	else {
		say(404,"You need to be logged in to post a job");
	}
?>