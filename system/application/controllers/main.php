<?php
class Main extends Controller {

	function main()
	{
		parent::Controller();
		$this->load->model('m_main', '', TRUE);
		session_start();
 		if (!isset($_SESSION[SESSION_USERID])){
			redirect('','location',301);
		}	
	}
	
	function index()
	{
		$data["id"]="Test";
		$data["menus"]=$this->m_main->get_menus();
		$data["submenus"]=$this->m_main->get_shortcuts();
		$data["background"]=$this->m_main->get_background();
		$this->load->vars($data);
		$this->load->view('v_dekstop');
	}
	

}
?>