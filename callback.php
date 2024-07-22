<?php
	
	require 'init.php';

	if ($_GET['state'] != $_SESSION['linkedincsrf']) {
		die("INVALIL REQUEST");
	} 

	$accessToken = $linkedin->getAccessToken($_GET['code']);
	if (!$accessToken) {
		if ( isset($_GET['error']) && !empty($_GET['error']) ) {
			echo $_GET['error_description'];
			exit;
		}
		exit;
	}

	$linkedin->setToken($accessToken);

	header("Location: profile.php");