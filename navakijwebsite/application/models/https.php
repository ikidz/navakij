<?php
class Https extends CI_Model{
	public function __construct()
	{
		if(!@$_SERVER["HTTPS"] && @$_SERVER['REMOTE_ADDR']){
			$url = current_url();
			$url = str_replace("http://","https://",$url);
			redirect($url);
		}
	}
}