<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('canvas_url'))
{
	function canvas_url($uri = '')
	{
		$CI =& get_instance();
		$facebook_api = $CI->config->item('facebook_api');
		if(strpos($_SERVER['HTTP_USER_AGENT'],"iPad") !== false || strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") !== false || strpos($_SERVER['HTTP_USER_AGENT'],"Android") !== false){
			$canvas = base_url(); 
		}else{
			$canvas_url = "https://apps.facebook.com/";
			if(isset($_SERVER["HTTPS"])){
				$canvas = $canvas_url . $facebook_api['app_namespace'];
			}else{
				$canvas = $canvas_url . $facebook_api['app_namespace'];	
			}
		}
		
		
		if(substr($uri,0,1) != "/"){
			$canvas .= "/" . $uri;
		}else{
			$canvas .= $uri;
		}
		return $canvas;
	}
}
if ( ! function_exists('force_canvas_url'))
{
	function force_canvas_url($uri = '')
	{
		$CI =& get_instance();
		$facebook_api = $CI->config->item('facebook_api');

		$canvas_url = "https://apps.facebook.com/";
		if(isset($_SERVER["HTTPS"])){
			$canvas = $canvas_url . $facebook_api['app_namespace'];
		}else{
			$canvas = $canvas_url . $facebook_api['app_namespace'];	
		}
		
		
		
		if(substr($uri,0,1) != "/"){
			$canvas .= "/" . $uri;
		}else{
			$canvas .= $uri;
		}
		return $canvas;
	}
}
if ( ! function_exists('page_url'))
{
	function page_url()
	{
		$CI =& get_instance();
		$facebook_api = $CI->config->item('facebook_api');
		if(isset($_SERVER["HTTPS"])){
			$page_url = "https://www.facebook.com/" . $facebook_api['page_username'];
		}else{
			$page_url = "http://www.facebook.com/" . $facebook_api['page_username'];	
		}
		return $page_url;
	}
}
if ( ! function_exists('tab_url'))
{
	function tab_url($app_data="")
	{
		$CI =& get_instance();
		$facebook_api = $CI->config->item('facebook_api');
		if(strpos($_SERVER['HTTP_USER_AGENT'],"iPad") !== false || strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") !== false || strpos($_SERVER['HTTP_USER_AGENT'],"Android") !== false){
			$tab_url = base_url("portal") . "/"; 
			if($app_data != ""){
				$tab_url .= $app_data;
			}
		}else{
			if(isset($_SERVER["HTTPS"])){
				$tab_url = "https://www.facebook.com/" . $facebook_api['page_username'] . "/app_"  . $facebook_api['app_id'];;
			}else{
				$tab_url = "http://www.facebook.com/" . $facebook_api['page_username'] . "/app_"  . $facebook_api['app_id'];;
			}
			if($app_data != ""){
				$tab_url .= "?app_data=" . $app_data;
			}
		}
	
		
		return $tab_url;
	}
}
if ( ! function_exists('canvas_redirect'))
{
	function canvas_redirect($uri = '',$alert_message = '')
	{
		$CI =& get_instance();
		$facebook_api = $CI->config->item('facebook_api');
		if(strpos($_SERVER['HTTP_USER_AGENT'],"iPad") !== false || strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") !== false || strpos($_SERVER['HTTP_USER_AGENT'],"Android") !== false){
			$canvas = base_url("game") . "/"; 
		}else{
			if(isset($_SERVER["HTTPS"])){
				$canvas = "https://apps.facebook.com/" . $facebook_api['app_namespace'];
			}else{
				$canvas = "http://apps.facebook.com/" . $facebook_api['app_namespace'];	
			}
			if(substr($uri,0,1) != "/"){
				$canvas .= "/" . $uri;
			}else{
				$canvas .= $uri;
			}
		}
		$redirect_message = ($alert_message <> "")?$alert_message:"กำลังเปลี่ยนหน้า";
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Untitled Document</title>
				<style type="text/css">
					body {
						background-color: #fff;
						margin: 40px;
						font: 13px/20px normal Helvetica, Arial, sans-serif;
						color: #4F5155;
					}
				
					a {
						color: #003399;
						background-color: transparent;
						font-weight: normal;
					}
				
					h1 {
						color: #444;
						background-color: transparent;
						border-bottom: 1px solid #D0D0D0;
						font-size: 19px;
						font-weight: normal;
						margin: 0 0 14px 0;
						padding: 14px 15px 10px 15px;
					}

					p{
						color: #444;
						background-color: transparent;
						font-size: 14px;	
					}
					#body{
						margin: 0 15px 0 15px;
					}

					#container{
						margin: 10px;
						border: 1px solid #D0D0D0;
						-webkit-box-shadow: 0 0 8px #D0D0D0;
					}
				</style>
				</head>
				
				<body>
					<div id="container">
						<h1>'.$redirect_message.'.</h1>
						<div id="body">
							<p>หากไม่มีการตอบสนอง กรุณา<a href="'.$canvas.'" target="_top">คลิกที่นี่.</a></p>
							<script type="text/javascript">
							var alert_message = "'.$alert_message.'";
							if(alert_message){
								alert(alert_message);	
							}
							top.location="'.$canvas.'";
							</script>
						</div>
					</div>
				</body>
				</html>';
		exit;
	}
}

if ( ! function_exists('frame_redirect'))
{
	function frame_redirect($canvas = '')
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Untitled Document</title>
				<style type="text/css">
					body {
						background-color: #fff;
						margin: 40px;
						font: 13px/20px normal Helvetica, Arial, sans-serif;
						color: #4F5155;
					}
				
					a {
						color: #003399;
						background-color: transparent;
						font-weight: normal;
					}
				
					h1 {
						color: #444;
						background-color: transparent;
						border-bottom: 1px solid #D0D0D0;
						font-size: 19px;
						font-weight: normal;
						margin: 0 0 14px 0;
						padding: 14px 15px 10px 15px;
					}

					p{
						color: #444;
						background-color: transparent;
						font-size: 14px;	
					}
					#body{
						margin: 0 15px 0 15px;
					}

					#container{
						margin: 10px;
						border: 1px solid #D0D0D0;
						-webkit-box-shadow: 0 0 8px #D0D0D0;
					}
				</style>
				</head>
				
				<body>
					<div id="container">
						<h1>กำลังเปลี่ยนหน้า.</h1>
						<div id="body">
							<p>หากไม่มีการตอบสนอง กรุณา<a href="'.$canvas.'" target="_top">คลิกที่นี่.</a></p>
							<script type="text/javascript">
							top.location="'.$canvas.'";
							</script>
						</div>
					</div>
				</body>
				</html>';
		exit;
	}
}
?>