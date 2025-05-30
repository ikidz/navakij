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
  <link href="assets/css/style_metro.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link href="assets/css/mycools.css" rel="stylesheet" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
  <!-- BEGIN LOGO -->
  <div id="logo" class="center">
	<?php
		$info = $this->admin_model->get_companyinfo();
		if( $info['company_logo']!='' && is_file( UPLOAD_PATH.'/system_company_logo/'.$info['company_logo'] ) ):
			?>
			<img src="<?php echo site_url( 'public/core/uploaded/system_company_logo/'.$info['company_logo'] ); ?>" alt="logo" class="center" /> 
			<?php
		endif;
	?>
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
    
    <form id="loginform" class="form-vertical no-padding no-margin" action="<?php echo admin_url("login?next=".$this->input->get('next')); ?>" method="post">
    	
      	<p class="center">Enter your username and password.</p>
       
      <div class="control-group">
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-user"></i></span><input id="input-username" type="text" placeholder="Username" name="username" required autofocus  />
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span><input id="input-password" type="password" placeholder="Password" name="password" required />             
          </div>
          <div class="block-hint pull-right">
            <a href="javascript:;" class="" id="forget-password">Forgot Password?</a>
          </div>
          <div class="clearfix space5"></div>
        </div>
      </div>
      <input type="submit" id="loginnow-btn" class="btn btn-block btn-inverse" value="Login" />
    </form>
    <!-- END LOGIN FORM -->        
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form id="forgotform" class="form-vertical no-padding no-margin hide" action="<?php echo $admin_url; ?>/login/forgotpass?next=<?php echo @$request['next']; ?>" method="post">
     
      	<p class="center">Enter your e-mail address below to reset your password.</p>
      <div class="control-group">
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-envelope"></i></span><input id="input-email" type="email" name="user_email" placeholder="Email" required />
          </div>
          <div class="block-hint pull-right">
            <a href="<?php echo current_url(); ?>" class="" id="force-login">Ready to login?</a>
          </div>
        </div>
        <div class="space10"></div>
      </div>
      <input type="submit" id="forgetpass-btn" class="btn btn-block btn-inverse" value="Submit" />
    </form>
    <!-- END FORGOT PASSWORD FORM -->
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div id="login-copyright">
    <a href="https://www.tedinnovation.co.th" target="_blank">Powered by TED Innovation Co., Ltd.</a>
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.2.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.blockui.js"></script>
  <script src="assets/js/app.js"></script>
  
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
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
		<?php if(@$forgotpassfocus=="yes"){ ?>
	  	$("a#forget-password").click();
	 	<?php } ?>
    });
  </script>
  
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>