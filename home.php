<!doctype html>
<html>
	<head>
		<title> VisualML:home </title>
		<meta charset="utf-8"/>
		<link href='http://fonts.googleapis.com/css?family=Felipa' rel='stylesheet' type='text/css'> 
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/> 
		<link rel="stylesheet" href="css/style.css"/> 
		<link rel="stylesheet" href="css/home_style.css"/> 

	</head>
	<body>
		<div class="allContent">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand active" href="#">VisualML</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      	<ul class="nav navbar-nav">
				        	<li><a href="#">About</a></li>
				        	<?php
								session_start();
								if(isset($_SESSION['username'])){
									print '<li><a href="#">Main Window</a></li>';
								}
							?>		        
				      	</ul>
				      	<ul class="nav navbar-nav navbar-right">
				      	<?php
							session_start();
							$content = '';
							if(isset($_SESSION['username'])){
								$content.= '<li class="dropdown">';
								$content.= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$_SESSION['username'].'<span class="caret"></span></a>';
								$content.='<ul class="dropdown-menu" role="menu">
								            <li><a href="#">Edit Profile</a></li>
								            <li class="divider"></li>
								            <li><a href="#">Logout</a></li>
								        </ul>';
								$content.='</li>';
							}
							else{
								$content.='<li><a href="#">Sign Up</a></li>';
								$content.='<li><a href="#">Log in</a></li>';
							}
							print $content;
						?>					     					        

				      	</ul>
				    </div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			<div class="banner">	
				<img src="img/VisualML.png"/>		
				<h1>Introducing VisualML</h1>
				<h2>Machine’s learning you; you’re learning too</h2>
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