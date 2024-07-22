<?php
require __DIR__ . '/init.php';
if(isset($_SESSION['LinkedInAccessToken'])) { 
	header("Location: profile.php");
} else {
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>LinkedIn Login</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<style type="text/css">
			body {
                font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
                -webkit-font-smoothing: antialiased;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
            }
			.btn-linkedin {
			    background: #0E76A8;
			    border-radius: 0;
			    color: #fff;
			    border-width: 1px;
			    border-style: solid;
			    border-color: #084461;
			    border: 0;
			}
			.btn-linkedin:link, .btn-linkedin:visited {
			    color: #fff;
			}
			.btn-linkedin:active, .btn-linkedin:hover {
			    background: #084461;
			    color: #fff;
			}
		</style>
	</head>
	<body>
		<div class="text-center">
			<a href="<?=$linkedin->getAuthUrl()?>" title="LinkedIn" class="btn btn-linkedin btn-lg">
			  <i class="fa fa-linkedin fa-fw"></i> Sigin in with LinkedIn
			</a>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
	</html>
<?php
}
?>