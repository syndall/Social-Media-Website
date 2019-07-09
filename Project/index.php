<?php
include("insert_user.php");


?>


<html>
 
   <head>
   	<link rel="shortcut icon" href="./images/logo_rb.png" />
   	<title>UATweetBook</title>
   	
   <link href="./css/style.css" rel="stylesheet" type="text/css" media="all"/>  
   <link href="./css/formstyle.css" rel="stylesheet" type="text/css" media="all"/> 

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script>
   jQuery(document).ready(function($) {
	tab = $('.tabs h3 a');
	tab.on('click', function(event) {
		event.preventDefault();
		tab.removeClass('active');
		$(this).addClass('active');

		tab_content = $(this).attr('href');
		$('div[id$="tab-content"]').removeClass('active');
		$(tab_content).addClass('active');
	});
});

   </script>
   
   
   
  </head>   
  
  
  <body>
      
      <div class="nav"> 
      <center> <img  class="logo" width= "30px" height="30px" src="./images/logo_rb.png"></img></center>
      </div>
      
   
      
      <center>
         <div class="banner"><img width= "80%" height="10%" src="./images/UATWEETBOOK.png"></img></div>
          &nbsp; 
          
          <div class="form-wrap">
           <center> <?php echo $wrong?></center> 	
		<div class="tabs">
			<h3 class="signup-tab"><a class="active" href="#signup-tab-content">Sign Up</a></h3>
			<h3 class="login-tab"><a href="#login-tab-content">Login</a></h3>
		</div><!--.tabs-->

		<div class="tabs-content">
			<div id="signup-tab-content" class="active">
				<form class="signup-form" action="./index.php" method="post">
					<input type="email" name="txtemail" class="input" id="user_email" autocomplete="off" placeholder="<?php echo $emailerr?>">
					<input type="text" name="txtname" class="input" id="user_name" autocomplete="off" placeholder="<?php echo $usernerr?>">
					<input type="password" name="txtpass"  class="input" id="user_pass" autocomplete="off" placeholder="<?php echo $passwerr?>">
					<input type="submit" name="signup-submit" class="button" value="Sign Up">
				</form><!--.login-form-->
				<div class="help-text">
					<p>By signing up, you agree to our</p>
					<p><a href="#">Terms of service</a></p>
				</div><!--.help-text-->
			</div><!--.signup-tab-content-->

			<div id="login-tab-content">
				<form class="login-form" action="./index.php" method="post">
					<input type="text" name="uname" class="input" id="user_login" autocomplete="off" placeholder="<?php echo $uerr?>">
					<input type="password" name="upass" class="input" id="user_pass" autocomplete="off" placeholder="<?php echo $perr?>">
					<input type="checkbox" class="checkbox" id="remember_me">
					<label for="remember_me">Remember me</label>

					<input type="submit" name="signin-submit" class="button" value="Login">
				</form><!--.login-form-->
				<div class="help-text">
					<p><a href="#">Forget your password?</a></p>
				</div><!--.help-text-->
			</div><!--.login-tab-content-->
		</div><!--.tabs-content-->
	</div><!--.form-wrap-->
        
       </center>
     
     
  </body>  
    
    
</html>