<?php

session_start();

require_once 'includes/config.php';

$qemail = new QuoteEmailClass();
$reg_user = new UserClass();
$random = new RandomKey();
$encrypt = new EncryptPass();

require_once 'includes/login_if.php';
require_once 'includes/forgot_if.php';
require_once 'includes/signup_if.php';
require_once 'includes/verify_if.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Dashboard">
	<meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

	<title>MyReminders.io - Sending you a email as a reminders</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<!--external css-->
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	
	<!-- Custom styles for this template -->
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/style-responsive.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>

  <body>

  	<div id="login-page">
  		<div class="container">
  			<form class="form-login" method="post">
  				<h2 class="form-login-heading">sign in now</h2>
  				<div class="login-wrap">
  					<?php include 'includes/alert_message.php' ?>
  					<input type="email" class="form-control" placeholder="Your email" name="email" autofocus>
  					<br>
  					<input type="password" class="form-control" placeholder="Your password" name="password">
  					<label class="checkbox">
  						<span class="pull-right">
  							<a data-toggle="modal" href="login.html#modalForgot"> Forgot Password?</a>
  						</span>
  					</label>
  					<button class="btn btn-theme btn-block" type="submit" name="login"><i class="fa fa-lock"></i> SIGN IN</button>
  					<hr>
  					
		            <!--<div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>-->
		            <div class="registration">
		            	Don't have an account yet?<br/>
		            	<a data-toggle="modal" href="login.html#modalCreate"> Create new account</a>
		            </div>
		            
		        </div>
		    </form>
		    <!-- Modal -->
		    <div aria-hidden="true" aria-labelledby="modalForgot" role="dialog" tabindex="-1" id="modalForgot" class="modal fade">
		    	<div class="modal-dialog">
		    		<div class="modal-content">
		    			<div class="modal-header">
		    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    				<h4 class="modal-title">Forgot Password ?</h4>
		    			</div>
		    			<div class="col-md-12">
		    			</div>
		    			<form class="form-signin" method="post">
		    				<div class="modal-body">
		    					<p>Enter your e-mail address below to reset your password. You will receive a link to create a new password via email</p>
		    					<input type="text" name="email" placeholder="Email" name="email" autocomplete="off" class="form-control placeholder-no-fix">
		    				</div>
		    				<div class="modal-footer">
		    					<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		    					<button class="btn btn-theme" type="submit" name="forgot">Submit</button>
		    				</div>
		    			</form>
		    		</div>
		    	</div>
		    </div>
		    <!-- modal -->

		    <!-- Modal -->
		    <div aria-hidden="true" aria-labelledby="modalCreate" role="dialog" tabindex="-1" id="modalCreate" class="modal fade">
		    	<div class="modal-dialog">
		    		<div class="modal-content">
		    			<div class="modal-header">
		    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    				<h4 class="modal-title">Create new account</h4>
		    			</div>
		    			<div class="col-md-12">
		    			</div>
		    			<form class="form-signin" method="post" autocomplete="off">
		    				<div class="modal-body">
		    					<input type="text" name="username" placeholder="Username" class="form-control placeholder-no-fix"><br/>
		    					<input type="email" name="email" placeholder="Email" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" class="form-control placeholder-no-fix"><br/>
		    					<?php include 'includes/select.php' ?>
		    					<br/>
		    					<input type="hidden" name="gtm" value="" id="gtm">
		    					<input type="password" name="password" placeholder="Password" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" class="form-control placeholder-no-fix"><br/>
		    					<input type="password" name="password_again" placeholder="Password again" class="form-control placeholder-no-fix">
		    				</div>
		    				<div class="modal-footer">
		    					<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		    					<button class="btn btn-theme" type="submit" name="signup">Submit</button>
		    				</div>
		    			</form>
		    		</div>
		    	</div>
		    </div>
		    <!-- modal -->
		    
		</form>	  	
		
	</div>
</div>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<!--BACKSTRETCH-->
<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
<script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">
$.backstretch("assets/img/login-bg.jpg", {speed: 800});
</script>
<script type="text/javascript">
	$(document).on('change','#timezone',function(){
		var valueTime = $('#timezone').find("option:selected").attr('value');
		var str = valueTime.substring(valueTime.indexOf("| ") + 2);
		$('#gtm').val(str).val();
});
</script>
</body>
</html>
