<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class controller_lib {
	var $_data = array();
	var $ci ;
	public function __construct()
	{
		$this->ci = get_instance();
	}
	public function controller_list()
	{
		$controllers = array();
		/*
foreach(glob(APPPATH . 'controllers_config/*') as $controller) {
			$inf = pathinfo($controller);
			if(@$inf['extension']=="json"){
				$controllers[$inf['filename']] = @json_decode($this->ci->load->file($controller,true),true);
			}
		}
*/
		//var_dump($controllers);
		return $controllers;
	}
}