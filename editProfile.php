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
			<form class="col-md-4 col-md-offset-4" action="controllers/LoginController.php" method="post">
				<h1 class="text-center">Edit Profile</h1>
				<?php
					if(!isset($_SESSION)) 
				    { 
				        session_start(); 
				    } 
				   	if(!isset($_SESSION['username'])){
						header("Location: login.php");
					}
					if(isset($_SESSION['message'])&&count($_SESSION['message'])>0){
						foreach ($_SESSION['message'] as $message) {
							if($message["type"]=="error") print '<div class="alert alert-danger" role="alert">'.$message["content"].'</div>';
						}
						
					}
					unset($_SESSION['message']);

					if(!isset($_GET['user_data'])) 
				    { 
				        header("Location: controllers/editProfile_getData.php");
				    } 
				?>

				<div class="form-group col-lg-12">
					<label>Username</label>
					<input type="text" name="username" class="form-control" id="" value="<?php $_GET[]?>">
				</div>

				<div class="form-group col-lg-12">
					<label>Email</label>
					<input type="text" name="username" class="form-control" id="" value="">
				</div>

				<div class="form-group col-lg-12">
					<label>New Password</label>
					<input type="password" name="password" class="form-control" id="" value="">
				</div>

				<div class="form-group col-lg-12">
					<label>Confirm New Password</label>
					<input type="password" name="password" class="form-control" id="" value="">
				</div>
				
				<div class="form-group col-lg-12">
					<label>Password</label>
					<input type="password" name="password" class="form-control" id="" value="">
				</div>
				
				<div class="form-group col-lg-12" id="register_button">
					<button type="submit" value="submit" class="btn btn-block btn-success btn-lg">Login</button>
				</div>					
			</form>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>