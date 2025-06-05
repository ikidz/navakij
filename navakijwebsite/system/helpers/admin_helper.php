<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('admin_url'))
{
	function admin_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->site_url(ADMIN_PATH . $uri, false);
	}
}

if ( ! function_exists('admin_redirect'))
{
	function admin_redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = admin_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}
/* Location: ./system/helpers/admin_helper.php */