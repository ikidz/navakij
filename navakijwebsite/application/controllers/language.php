<?php
class Language extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		redirect('language/change/en');
	}
	
	function change($setto='th'){
		$this->languagemodel->switch_language($setto);
		$redir_uri = $this->session->userdata('urisession');
		redirect($redir_uri['uri']);
	}
}
?>