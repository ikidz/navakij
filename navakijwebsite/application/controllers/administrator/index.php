<?php
class Index extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		admin_redirect("dashboard");
	}
}