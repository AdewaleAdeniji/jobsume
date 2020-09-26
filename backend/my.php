<?php
header("Access-Control-Allow-Origin:*");
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
    include('dbh.php');

$timezone_string = 'Africa/Lagos';
date_default_timezone_set($timezone_string);
   // ini_set("display_errors",0);
function parse($el){
    include('dbh.php');
    return mysqli_real_escape_string($conn,$el);
}
function logerror($error){
    //this is a function for logging errors   
    $date = now();
    $sql = query("INSERT INTO logs(log,timest) VALUES('$error','$date')");
}

function i($d,$e){
    return parse($d->$e);
}

function post($el){
    return parse($_POST[$el]);
}
function get($el){
    return $_GET[$el];

}
function gen(){
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $jwt = substr(str_shuffle($permitted_chars), 0, 50);
            return $jwt;
}
function now(){
  $exp = date('H');
  $date = date('i-d/m/yy');
  $r = $exp.":".$date;
  return $r;
}
function expiry(){
    $exp = date('H')+1;
  $date = date('i-d/m/yy');
  $r = $exp.":".$date;
  return $r;
}
function query($el){
    include('dbh.php');
    return mysqli_query($conn,$el);

}
function fetch($el){
    return mysqli_fetch_assoc($el);
}
function check($el){
    return mysqli_num_rows($el);
}

 function say($code,$msg){
        $m = new stdclass;
        $m->code = $code;
        $m->text = $msg;
        $m->date = now();
        echo json_encode($m);
        die();
        return false;
        exit();
     }
?>