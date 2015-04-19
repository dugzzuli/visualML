<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand active" href="/">VisualML</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      	<ul class="nav navbar-nav">
				        	<li><a href="about.php">About</a></li>
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
								$content.='<li><a href="register.php">Sign Up</a></li>';
								$content.='<li><a href="login.php">Log in</a></li>';
							}
							print $content;
						?>					     					        

				      	</ul>
				    </div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>