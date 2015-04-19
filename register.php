<!doctype html>
<html>
	<head>
		<title> VisualML:register </title>
		<meta charset="utf-8"/>
		<link href='http://fonts.googleapis.com/css?family=Felipa' rel='stylesheet' type='text/css'> 
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/> 
		<link rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" href="css/register_style.css"/> 
	</head>
	<body>
		<div class="allContent">
			<?php include 'navbar.php'; ?>
			<div class="banner">	
				<img src="img/VisualML.png"/>
			</div>

			<form class="col-md-6 col-md-offset-3" action="controllers/RegisterController.php" method="post">
				<h1 class="text-center">Registration</h1>
				<?php
					session_start();
					if(isset($_SESSION['message'])&&count($_SESSION['message'])>0){
						foreach ($_SESSION['message'] as $message) {
							if($message["type"]=="error") print '<div class="alert alert-danger" role="alert">'.$message["content"].'</div>';
						}
						
					}
					unset($_SESSION['message']);
				?>
				<div class="form-group col-lg-12">
					<label>Email Address</label>
					<input type="text" name="email" class="form-control" id="" value="">
				</div>
				
				<div class="form-group col-lg-12">
					<label>Username</label>
					<input type="text" name="username" class="form-control" id="" value="">
				</div>
				
				<div class="form-group col-lg-6">
					<label>Password</label>
					<input type="password" name="password" class="form-control" id="" value="">
				</div>
				
				<div class="form-group col-lg-6">
					<label>confirm Password</label>
					<input type="password" name="confirm_password" class="form-control" id="" value="">
				</div>

				<!-- <div class="form-group col-lg-12">
					<label>Select profile picture</label>
					<input type="file" name="profile_picture">
				</div> -->	
				
				<div class="form-group col-lg-12" id="register_button">
					<button type="submit" value="submit" class="btn btn-block btn-success btn-lg">Register</button>
				</div>					
			</form>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>