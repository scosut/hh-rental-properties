<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= SITE_NAME; ?><?= empty($page_name) ? '' : ' | ' . $page_name; ?></title>
	<link rel="stylesheet" href="/public/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/public/css/lightbox.min.css" />
  <link rel="stylesheet" href="/public/css/jquery-ui.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed&family=Sriracha&display=swap" rel="stylesheet">	
	<link rel="stylesheet" href="/public/css/styles.css" />	
	<link rel="icon" type="image/png" href="/public/img/favicon.png">
</head>
<body>	
	<div class="loading-overlay">
		<div class="loading-overlay-spinner"></div>
	</div>
	<header class="header">
		<div class="container header-container">
			<div class="header-item">
				<i class="fa fa-phone"></i> <a href="tel:6059406695">(605) 940-6696</a>
			</div>
			<div class="header-item">
				<i class="fa fa-envelope"></i> <a href="mailto:info@handhrentalproperties.com">info@handhrentalproperties.com</a>
			</div>
		</div>
	</header>
	
	<?php require APP_ROOT."/views/inc/nav.php"; ?>