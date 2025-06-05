<!DOCTYPE html>
<!--[if lte IE 8]><html lang="en" class="no-support"><![endif]-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if IE 10]> <html lang="en" class="ie10"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8" />
  <title><?php echo $title; ?></title>
  <base href="<?php echo $asset_url; ?>" />
  <meta content="width=device-width, initial-scale=1.0; maximum-scale=1.0; user-scalable=1;" name="viewport" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style_responsive.css" rel="stylesheet" />
  <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link href="assets/css/mycools.css" rel="stylesheet" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
  <!-- BEGIN LOGO -->
  <div id="logo" class="center">
    <img src="assets/img/logo.png" alt="logo" class="center" /> 
  </div>
  <!-- END LOGO -->
  <?php if(@$error_message!=NULL){ ?>
  <div class="alert alert-error login_alert "> 
    <button class="close" data-dismiss="alert">×</button>
    <strong>Error !</strong> <?php echo $error_message; ?>
  </div>
  <?php } ?>
 <?php if(@$success_message!=NULL){ ?>
  <div class="alert alert-success login_alert "> 
    <button class="close" data-dismiss="alert">×</button>
    <strong>Sucess !</strong> <?php echo $success_message; ?>
  </div>
  <?php } ?>
  <!-- BEGIN LOGIN -->
  <div id="login">
    <!-- BEGIN LOGIN FORM -->
    
    <form id="resetpass" class="form-vertical no-padding no-margin" action="<?php echo $admin_url; ?>/login/resetpassword/<?php echo $reset_key; ?>" method="post">
      <p class="center">Enter your new password.</p>
      <div class="control-group">
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span><input id="input-newpassword" type="password" placeholder="New Password" name="newpassword" required autofocus  />
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span><input id="input-password" type="password" placeholder="Re-Enter New Password Again" name="renewpassword" required />             
          </div>
          <div class="block-hint pull-right">
            <a href="{admin_url}/login" class="" id="back-to-login">back to login?</a>
          </div>
          <div class="clearfix space5"></div>
        </div>
      </div>
      <input type="submit" id="loginnow-btn" class="btn btn-block btn-inverse" value="Reset password" />
    </form>
    <!-- END LOGIN FORM -->        
    
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div id="login-copyright">
    2013 &copy; Mycools Inc.
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.2.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.blockui.js"></script>
  <script src="assets/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      
	  	$("form").submit(function(e) {
			
        	var required = $(this).find("*[required]");
			  for(i=0;i<required.length;i++){
					if(required.eq(i).val()=="" || required.eq(i).val() == required.eq(i).attr("placeholder")){
						required.eq(i).addClass("input-error");
						required.eq(i).focus();
						return false;	
					}
			  }
    	});
    });
  </script>
  
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>