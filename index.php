<!doctype html>
<html>
	<head>
		<title> VisualML:home </title>
		<meta charset="utf-8"/>
		<link href='http://fonts.googleapis.com/css?family=Felipa' rel='stylesheet' type='text/css'> 
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/> 
		<link rel="stylesheet" href="css/style.css"/> 
		<link rel="stylesheet" href="css/home_style.css"/> 

	</head>
	<body>
		<div class="allContent">
			<?php include 'navbar.php'; ?>
			<div class="banner">	
				<img src="img/VisualML.png"/>	
				<!-- <h1>Introducing VisualML</h1> -->
				<h1>Machine’s learning you; you’re learning too</h1>
			</div>
			<div class="icon greenFade">
				<a href="about.php">
					<div class="logo">
						<!-- <img src="img/overview-green.png"/> -->
						<i class="fa fa-info-circle"></i>
						<span class="logoLabel">About</span>
					</div>
				</a>
<!-- 				<a href="#function">
					<div class="logo"> -->
						<!-- <img src="img/function-green.png"/> -->						
						<?php
							if(isset($_SESSION['username'])){
								print '<a href="#function">
										<div class="logo">';
								print '<i class="fa fa-play-circle"></i>';
								print '<span class="logoLabel">Start</span>';	
								print '</div>
										</a>';							
							}
							else{
								print '<a href="login.php">
										<div class="logo">';
								print '<i class="fa fa-user"></i>';
								print '<span class="logoLabel">Login</span>';
								print '</div>
										</a>';
							}							
						?>								
			</div>
		</div>
		<footer>
			กลุ่ม CU.Tweet<br/>
			นายปิยวัฒน์ เลิศวิทยากำจร (5431022721)<br/>
			นางสาวพนิดา นิ่มนวล (5431025621)<br/>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>