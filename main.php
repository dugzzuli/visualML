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
				  	<li role="presentation"><a href="#results" aria-controls="results" role="tab" data-toggle="tab">Results</a></li>
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
					        <p>[From wikipedia.com]</p>
				        	<p>
				        		In statistics, <b class="topic">simple linear regression</b> is the least squares estimator of a linear regression model with a single explanatory variable. In other words, simple linear regression fits a straight line through the set of n points in such a way that makes the sum of squared residuals of the model (that is, vertical distances between the points of the data set and the fitted line) as small as possible.
				        	</p>
				        	<img src="img/lr1.png" />
							<p>
								The adjective simple refers to the fact that this regression is one of the simplest in statistics. The slope of the fitted line is equal to the correlation between y and x corrected by the ratio of standard deviations of these variables. The intercept of the fitted line is such that it passes through the center of mass (x, y) of the data points.</p>
				        	</p>				        	
				      		<img src="img/lr2.png" />
				      		<p>Read More -- <a href="http://en.wikipedia.org/wiki/Simple_linear_regression" target="blank">Simple Linear Regression</a></p>
				      	</div>
					    <div role="tabpanel" class="tab-pane fade" id="dropdown4" aria-labelledBy="profile-tab" data-modal="modalRT">
					        <p>Regression Tree, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
					    </div>
					    <div role="tabpanel" class="tab-pane fade" id="dropdown5" aria-labelledBy="home-tab" data-modal="modalKM">
					        <p>[From Data Mining By Ian H. Witten & Eibe Frank]</p>
					        <p>The classic clustering technique is called <b class="topic">K-means</b>. First, you specify in advance
how many clusters are being sought: this is the parameter k. Then k points are
chosen at random as cluster centers. All instances are assigned to their closest
cluster center according to the ordinary Euclidean distance metric. Next the centroid,
or mean, of the instances in each cluster is calculated—this is the “means”
part. These centroids are taken to be new center values for their respective clusters.
Finally, the whole process is repeated with the new cluster centers. Iteration
continues until the same points are assigned to each cluster in consecutive
rounds, at which stage the cluster centers have stabilized and will remain the
same forever.</p>
							<img src="img/km1.png" />
							<p>Read More -- <a href="en.wikipedia.org/wiki/K-means_clustering" target="blank">K-means Clustering</a></p>
					    </div>
					    <div role="tabpanel" class="tab-pane fade" id="dropdown6" aria-labelledBy="profile-tab" data-modal="modalDB">
					        <p>[From wikipedia.com]</p>
					        <p><b class="topic">Density-based spatial clustering of applications with noise (DBSCAN)</b> is a data clustering algorithm proposed by Martin Ester, Hans-Peter Kriegel, Jorg Sander and Xiaowei Xu in 1996. It is a density-based clustering algorithm: given a set of points in some space, it groups together points that are closely packed together (points with many nearby neighbors), marking as outliers points that lie alone in low-density regions (whose nearest neighbors are too far away). DBSCAN is one of the most common clustering algorithms and also most cited in scientific literature.</p>
					    	<img src="img/db1.png" />
					    	<p>DBSCAN requires two parameters: ε (eps) and the minimum number of points required to form a dense region(minPts). It starts with an arbitrary starting point that has not been visited. This point's ε-neighborhood is retrieved, and if it contains sufficiently many points, a cluster is started. Otherwise, the point is labeled as noise. Note that this point might later be found in a sufficiently sized ε-environment of a different point and hence be made part of a cluster.</p>
							<p>If a point is found to be a dense part of a cluster, its ε-neighborhood is also part of that cluster. Hence, all points that are found within the ε-neighborhood are added, as is their own ε-neighborhood when they are also dense. This process continues until the density-connected cluster is completely found. Then, a new unvisited point is retrieved and processed, leading to the discovery of a further cluster or noise</p>
					    	<p>Read More -- <a href="http://en.wikipedia.org/wiki/DBSCAN" target="blank">DBSCAN</a></p>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="results">No results</div>
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
    							<input type="text" class="form-control" id="modalDT1" value="5">
    							<!-- <input type="text" class="form-control" id="modalDT2" value="12" data-default="12"> -->
     			      		</div>	
     			      		<div class= "modalNN mpara">
				      			<h4 class="modalLabel">Minimum number of points for each nn</h4>
    							<input type="text" class="form-control" id="modalNN1" value="10">
     			      		</div>	
     			      		<div class= "modalKM mpara">
				      			<h4 class="modalLabel">Number of clusters (less than 10)</h4>
    							<input type="text" class="form-control" id="modalKM1" value="5">
     			      		</div>	
     			      		<div class= "modalDB mpara">
				      			<h4 class="modalLabel">EPS (Epsilon)</h4>
    							<input type="text" class="form-control" id="modalDB1" value="20">
    							<h4 class="modalLabel">MinPts (Minimum Points)</h4>
    							<input type="text" class="form-control" id="modalDB2" value="3">
     			      		</div>	
     			      		<div class= "modalLR mpara">
				      			<h4 class="modalLabel">No Parameters</h4>
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
					<div class="tool toolclear undobutton">
						<a><i class="fa fa-undo"></i></a>
					</div>
					<div class="tool toolclear clearbutton">
						<a><i class="fa fa-file-o"></i></a>
					</div>			
				</div>
				<div class="col-md-2" id="selectClass">
					<div id="selectClassPanel">
						Class:&nbsp;
						<div class="dropup">
						  	<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
						    	<i class="fa fa-circle" style="color:red;"></i>&nbsp;A</a>
						    	<span class="caret"></span>
						  	</button>
						  	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2" id="selectClassMenu">
							    <li role="presentation"><a class="aClass CA" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:red;"></i>&nbsp;A</a></li>
							    <li role="presentation"><a class="aClass CB" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:green;"></i>&nbsp;B</a></li>
							    <li role="presentation"><a class="aClass CC" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:blue;"></i>&nbsp;C</a></li>
							    <li role="presentation"><a class="aClass CD" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:orange;"></i>&nbsp;D</a></li>
							    <li role="presentation"><a class="aClass CE" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:purple;"></i>&nbsp;E</a></li>
							    <li role="presentation"><a class="aClass CU" role="menuitem" tabindex="-1" href="#"><i class="fa fa-circle" style="color:grey;"></i>&nbsp;Unknown</a></li>
							</ul>
						</div>
					</div>					
				</div>
				<div class="col-md-1 pp">
                    <div class="input-group pinpoint">
					  	<span class="input-group-addon" id="px">X</span>
					  	<input type="text" name="px" id="tpx" class="form-control">
					</div>
				</div>
				<div class="col-md-1 pp">
					<div class="input-group pinpoint">
					  	<span class="input-group-addon" id="py">Y</span>
					  	<input type="text" name="py" id="tpy" class="form-control">
					</div>
				</div>
				<div class="col-md-1 pp">
					<div class="pinpoint">
						<button type="button" class="btn btn-default" id="addPoint">
							<i class="fa fa-plus"></i>
						</button>
						<button type="button" class="btn btn-success" id="placePoint">Place</button>
					</div>					
				</div>
				<div class="col-md-2" id="compute">
					<button type="button" class="btn btn-primary btn-block" id="classifyButton">Run</button>
				</div>
				<div class="col-md-2" id="adjustParameter">
					<button type="button" class="btn btn-primary btn-block" id="adjustPara" data-toggle="modal" data-target="#myModal">Adjust Parameters</button>
				</div>
			</div>

		</div>
		<div class="loader"></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="js/main_script.js"></script>
		<script src="js/d3.min.js"></script>
		<script src="js/visualizePanel.js"></script>
		<script src="js/visualizeResult.js"></script>
	</body>
</html>