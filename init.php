<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);

	session_start();

	require "LinkedIn.class.php";

	use myPHPNotes\LinkedIn;
	
	$app_id = "05438952931"; //Your App Id
	$app_secret = "mAhMuTyUkSeLmErT"; //Your App Secret
	$app_callback = "callback.php"; //Your Domain Callback url
	$app_scopes = "openid,profile,email,w_member_social"; 
	$ssl = true;

	$linkedin = new LinkedIn($app_id, $app_secret, $app_callback, $app_scopes, $ssl);
?>