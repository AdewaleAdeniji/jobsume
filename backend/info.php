<?php
	include 'functions.php';
		if(auth()){
				$userid = auth();
				$sql = query("SELECT * FROM users WHERE userid='$userid' ");
				$row = fetch($sql);
				$count = 0;
				$obj = new stdclass;
				foreach ($row as $key => $value) {
					# code...
						
							if($key!="password"&&$key!="userid"){
								$obj->$key = $value;
								$count++;

							}
						
						
				}
				if($count==11){
					$level = $row['status'];
					if($level==0){
						$level = $level+1;
					}
					$newsql = query("UPDATE users SET status='$level' WHERE userid='$userid' ");
					if(!$sql){
						say(203,'Error Occured while processing your request');
					}
					else {
						say(200,$obj);
					}
				}
				else {
					say(200,$obj);
				}
			}
			else {
				say(205,"Wetin occur");
			}
?>