<?php
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

function check_signature($params_array, $secret) {
	ksort($params_array);

	$str = '';
	foreach ($params_array as $k=>$v) {
		if($k != 'sig') {
			$str .= "$k=$v";
		}
	}
	$str .= $secret;
	$signature = md5($str);

	return ($params_array['sig'] == $signature);
}

 // check that the request comes from Fortumo server
if(!in_array($_SERVER['REMOTE_ADDR'],
	array('1.2.3.4', '2.3.4.5'))) {
	header("HTTP/1.0 403 Forbidden");
die("Error: Unknown IP");
}

  // check the signature
  $secret = ''; // insert your secret between ''
  if(empty($secret)||!check_signature($_GET, $secret)) {
  	header("HTTP/1.0 404 Not Found");
  	die("Error: Invalid signature");
  }

  $sender = $_GET['sender'];//phone num.
  $amount = $_GET['amount'];//credit
  $cuid = $_GET['cuid'];//resource i.e. user
  $payment_id = $_GET['payment_id'];//unique id
  $test = $_GET['test']; // this parameter is present only when the payment is a test payment, it's value is either 'ok' or 'fail'

  //hint: find or create payment by payment_id
  //additional parameters: operator, price, user_share, country

  if(preg_match("/completed/i", $_GET['status'])) {

  	$db->query("UPDATE users SET credits=credits+".$amount." WHERE id='".$cuid."'");
  }

  // print out the reply
  if($test){
  	echo('TEST OK');
  }
  else {
  	echo('OK');
  }
