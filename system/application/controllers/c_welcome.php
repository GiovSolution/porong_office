<?php
class C_welcome extends Controller {

	function c_welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('v_welcome');
	}
}
?>