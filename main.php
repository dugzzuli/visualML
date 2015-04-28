<!doctype html>
<html>
	<head>
		<title> VisualML:main </title>
		<meta charset="utf-8"/>
		<link href='http://fonts.googleapis.com/css?family=Felipa' rel='stylesheet' type='text/css'> 
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/> 
		<link rel="stylesheet" href="css/style.css"/>
		<link rel="stylesheet" href="css/main_style.css"/> 
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/visualizePanel.css"/> 
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
				      <a class="navbar-brand active" href="index.php">VisualML</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      	<ul class="nav navbar-nav">
				        	<li><a href="about.php">About</a></li>
				        	<?php
				        	    if(!isset($_SESSION)) 
							    { 
							        session_start(); 
							    } 
								if(isset($_SESSION['username'])){
									print '<li><a href="main.php">Main Window</a></li>';
								}
							?>		        
				      	</ul>
				      	<ul class="nav navbar-nav navbar-right">
				      	<?php
							if(!isset($_SESSION)) 
						    { 
						        session_start(); 
						    } 
							$content = '';
							if(isset($_SESSION['username'])){
								$content.= '<li class="dropdown">';
								$content.= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$_SESSION['username'].'<span class="caret"></span></a>';
								$content.='<ul class="dropdown-menu" role="menu">
								            <li><a href="#">Edit Profile</a></li>
								            <li class="divider"></li>
								            <li><a href="Controllers/LogoutController.php">Logout</a></li>
								        </ul>';
								$content.='</li>';
							}
							else{
								header("Location: login.php");
								$content.='<li><a href="register.php">Sign Up</a></li>';
								$content.='<li><a href="login.php">Log in</a></li>';
							}
							print $content;
						?>					     					        

				      	</ul>
				    </div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			<div class="col-md-8 col-xs-12" id="board" >
				
			</div>
			<div class="col-md-4 col-xs-12" id="sidebar">
				<img src="img/VisualML.png" id="vmlLogo"/>
				<ul class="nav nav-tabs" role="tablist" id="myTab">
				  	<li role="presentation" class="dropdown">
				        <a href="#" id="myTabDrop1" class="dropdown-toggle in active" data-toggle="dropdown" aria-controls="myTabDrop1-contents">Classification<span class="caret"></span></a>
				        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
				          <li><a href="#dropdown1" class="dropdown-submenu" tabindex="-1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1" class="active" data-modal="modalDT">Decision Tree</a></li>
				          <li><a href="#dropdown2" class="dropdown-submenu" tabindex="-1" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2"  data-modal="modalNN">Neural Network</a></li>
				        </ul>
				  	</li>
				  	<li role="presentation" class="dropdown">
				        <a href="#" id="myTabDrop2" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop2-contents">Regression<span class="caret"></span></a>
				        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop2" id="myTabDrop2-contents">
				          <li><a href="#dropdown3" class="dropdown-submenu" tabindex="-1" role="tab" id="dropdown3-tab" data-toggle="tab" aria-controls="dropdown3"  data-modal="modalLR">Linear Regression</a></li>
				          <li><a href="#dropdown4" class="dropdown-submenu" tabindex="-1" role="tab" id="dropdown4-tab" data-toggle="tab" aria-controls="dropdown4"  data-modal="modalRT">Regression Tree</a></li>
				        </ul>
				  	</li>
				  	<li role="presentation" class="dropdown">
						<a href="#" id="myTabDrop3" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop3-contents">Clustering<span class="caret"></span></a>
				        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop3" id="myTabDrop3-contents">
				          <li><a href="#dropdown5" class="dropdown-submenu" tabindex="-1" role="tab" id="dropdown5-tab" data-toggle="tab" aria-controls="dropdown5"  data-modal="modalKM">K-means</a></li>
				          <li><a href="#dropdown6" class="dropdown-submenu" tabindex="-1" role="tab" id="dropdown6-tab" data-toggle="tab" aria-controls="dropdown6"  data-modal="modalDB">DBSCAN</a></li>
				        </ul>
				  	</li>
				</ul>

				<div class="tab-content">
			  		<div id="myTabContent" class="tab-content">
				      	<div role="tabpanel" class="tab-pane fade in active" id="dropdown1" aria-labelledBy="dropdown1-tab"  data-modal="modalDT">
				        	<p>[From wikipedia.com]</p>
				        	<p><b class="topic">Decision tree learning</b> is a method commonly used in data mining. The goal is to create a model that predicts the value of a target variable based on several input variables. Each interior node corresponds to one of the input variables; there are edges to children for each of the possible values of that input variable. Each leaf represents a value of the target variable given the values of the input variables represented by the path from the root to the leaf.</p>
				      		<img src="img/dt2.png" />
				      		<img src="img/dt1.png" />
				      		<p>Read More -- <a href="http://en.wikipedia.org/wiki/Decision_tree_learning" target="blank">Decision Tree Learning</a></p>
				      	</div>
				      	<div role="tabpanel" class="tab-pane fade" id="dropdown2" aria-labelledBy="dropdown2-tab"  data-modal="modalNN">
				        	<p>Neural Network, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
				      	</div>
				      	<div role="tabpanel" class="tab-pane fade" id="dropdown3" aria-labelledBy="home-tab" data-modal="modalLR">
					        <p>Linear Regression, probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
					    </div>
					    <div role="tabpanel" class="tab-pane fade" id="dropdown4" aria-labelledBy="profile-tab" data-modal="modalRT">
					        <p>Regression Tree, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
					    </div>
					    <div role="tabpanel" class="tab-pane fade" id="dropdown5" aria-labelledBy="home-tab" data-modal="modalKM">
					        <p>K-means, probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
					    </div>
					    <div role="tabpanel" class="tab-pane fade" id="dropdown6" aria-labelledBy="profile-tab" data-modal="modalDB">
					        <p>DBSCAN, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
					    </div>
				    </div>
				</div>
			</div>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
			  	<div class="modal-dialog">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button> -->
			        		<label class="modal-title modalDT mpara" id="myModalLabel">Decision Tree</label>
			        		<label class="modal-title modalNN mpara" id="myModalLabel">Neural Network</label>
			        		<label class="modal-title modalLR mpara" id="myModalLabel">Linear Regression</label>
			        		<label class="modal-title modalRT mpara" id="myModalLabel">Regression Tree</label>
			        		<label class="modal-title modalKM mpara" id="myModalLabel">K-means</label>
			        		<label class="modal-title modalDB mpara" id="myModalLabel">DBSCAN</label>
			      		</div>
				      	<div class="modal-body">
				      		<div class= "modalDT mpara">
				      			<h4 class="modalLabel">Minimum number of points for each leaf node</h4>
    							<input type="text" class="form-control" id="modalDT1" value="5" data-default="5">
    							<!-- <input type="text" class="form-control" id="modalDT2" value="12" data-default="12"> -->
     			      		</div>	
     			      		<div class= "modalNN mpara">
				      			<h4 class="modalLabel">Minimum number of points for each nn</h4>
    							<input type="text" class="form-control" id="modalNN1" value="10" data-default="10">
     			      		</div>				      		
				    	</div>
					    <div class="modal-footer">
					    	<button type="button" class="btn btn-info" id="setDefault">Set Default</button>
					        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Save changes</button>
					    </div>
			    	</div>			    	
			    </div>
			</div>
			<div class="col-xs-12" id="tooltab" >
				<div class="col-md-3">
					<div class="tool toolbutton pinbutton">
						<a><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span></a>
					</div>	
					<div class="tool toolbutton pencilbutton">
						<a><i class="fa fa-pencil"></i></a>
					</div>	
					<div class="tool toolbutton brushbutton">
						<a><i class="fa fa-paint-brush"></i></a>
					</div>		
					<div class="tool toolclear">
						<a><i class="fa fa-undo"></i></a>
					</div>
					<div class="tool toolclear clearbutton">
						<a><i class="fa fa-file-o"></i></a>
					</div>			
				</div>
				<div class="col-md-2" id="selectClass">
					Class:&nbsp;
					<div class="dropup">
					  	<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
					    	Select Class
					    	<span class="caret"></span>
					  	</button>
					  	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
						    <li role="presentation"><a class="aClass CA" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:red;"></i>&nbsp;A</a></li>
						    <li role="presentation"><a class="aClass CB" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:green;"></i>&nbsp;B</a></li>
						    <li role="presentation"><a class="aClass CC" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:blue;"></i>&nbsp;C</a></li>
						    <li role="presentation"><a class="aClass CD" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:orange;"></i>&nbsp;D</a></li>
						    <li role="presentation"><a class="aClass CE" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:purple;"></i>&nbsp;E</a></li>
						    <li role="presentation"><a class="aClass CU" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:grey;"></i>&nbsp;Unknown</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-1 pp">
                    <div class="input-group pinpoint">
					  	<span class="input-group-addon" id="px">X</span>
					  	<input type="text" class="form-control">
					</div>
				</div>
				<div class="col-md-1 pp">
					<div class="input-group pinpoint">
					  	<span class="input-group-addon" id="py">Y</span>
					  	<input type="text" class="form-control">
					</div>
				</div>
				<div class="col-md-1 pp">
					<button type="button" class="btn btn-success pinpoint">Place</button>
				</div>
				<div class="col-md-2" id="compute">
					<button type="button" class="btn btn-primary btn-block" id="classifyButton">Classify</button>
				</div>
				<div class="col-md-2" id="adjustParameter">
					<button type="button" class="btn btn-primary btn-block" id="adjustPara" data-toggle="modal" data-target="#myModal">Adjust Parameters</button>
				</div>
			</div>

		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="js/main_script.js"></script>
		<script src="js/d3.min.js"></script>
		<script src="js/visualizePanel.js"></script>
	</body>
</html>