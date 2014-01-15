<?php

class Desktop extends Controller {

	function Desktop()
	{
		parent::Controller();
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->helper('asset');
		$this->load->view('v_desktop');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */