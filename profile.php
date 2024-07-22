<?php
require __DIR__ . '/init.php';

if(isset($_SESSION['LinkedInAccessToken'])) { 

	$linkedinAccessToken = $_SESSION['LinkedInAccessToken']; //Get Token

	$getProfileInfo = $linkedin->getProfileInfo();


	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>LinkedIn Profile</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel="icon" type="image/svg" href="https://content.linkedin.com/content/dam/me/business/en-us/amp/brand-site/v2/bg/LI-Bug.svg.original.svg"/>
		<style type="text/css">
			.bg-linkedin {
				background-color: #0a66c2;
			}
		</style>
	</head>
	<body>
		
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-dark bg-linkedin pt-0 pb-0">
			<div class="container">
				<a class="navbar-brand" href="">
					Linked <i class="fa fa-linkedin" aria-hidden="true"></i>
				</a>
				
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        	<img src="<?php echo $getProfileInfo->picture?>" class="img-fluid" style="height: 45px;border-radius: 100%;">
				        	<?=$getProfileInfo->given_name?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				          <a class="dropdown-item" href="logout.php">Çıkış Yap</a>
				        </div>
				    </li>
				</ul>
			</div>
			</nav>
			<div class="jumbotron">
				<h1 class="display-4 mb-2">Hoşgeldin <?=$getProfileInfo->given_name?>!</h1>
				<p class="d-none">
					<label>Access Token: </label>
					<input type="text" name="" value="<?php echo $linkedin->getToken();?>" class="form-control">
				</p>
				<p class="lead my-4">Merhaba, <?=$getProfileInfo->given_name.' '.$getProfileInfo->family_name?> sisteme linkedin ile giriş yaptın. </p>
				<hr class="my-4">
				<p>
					<strong>E-Posta Adresin: </strong> <?=$getProfileInfo->email?> 
					<?=($getProfileInfo->email_verified==true ? '<i class="fa fa-check-circle" aria-hidden="true"></i>' : '<span class="text-muted">(Hesap güvenliğiniz için lütfen e-postanızı doğrulayın.)</span>')?>
				</p>

				<form method="POST" action="" class="mb-4">
					<div class="card">
						<div class="card-header">
							<div class="">
								<label>Gönderinizi kimler görebilir?</label>
								<select class="form-control" name="visibility">
									<option value="PUBLIC"> 
										Herkes
									</option>
									<option value="CONNECTIONS">
										Yalnızca bağlantılar
									</option>
								</select>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>Gönderi detayı:</label>
								<textarea name="post_message" class="form-control" rows="3" cols="6" placeholder="Ne düşünüyorsunuz?" required></textarea>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" name="post" class="btn btn-primary bg-linkedin"> Gönder </button>
						</div>
					</div>
					
					
				</form>

				<?php 
					if (isset($_POST['post'])) {
						$personel_id = $getProfileInfo->sub;
						$post_message = strip_tags($_POST['post_message']);
						$visibility = strip_tags($_POST['visibility']);
						if ( strlen($post_message) >= 10 ) {
							$posted = $linkedin->linkedInTextPost($linkedin->getToken(), $personel_id, $post_message, $visibility);
							if ( isset($posted["id"]) ) {
								echo '<div class="alert alert-success">Gönderiniz başarılı bir şekilde oluşturuldu.</div>';
							} else {
								if ( isset($posted["errorDetailType"]) ) {
									echo '<div class="alert alert-danger">Hata! '.$posted["errorDetails"]["inputErrors"][0]['description'].'</div>';
								}
							}
						} else {
							echo '<div class="alert alert-danger">Çok kısa! Lütfen daha açıklayıcı bir gönderi metni girin.</div>';
						}
					}
				?>

			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
	</html>
<?php 
} else {
	header("Location: index.php");
}
?>