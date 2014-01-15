<?php
/* 	
	
*/

//class of tbl_cr
class C_welcome_msg extends Controller {

	//constructor
	function C_welcome_msg(){
		parent::Controller();
		session_start();
		$this->load->model('m_welcome_msg', '', TRUE);
	}
	
	//set index
	/*
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_about');
		
	}
	*/
	
	 function get_welcome_message(){	 
		$task = $_POST['task'];
		$menu_id = $_POST['menu_id'];
		$result=$this->m_welcome_msg->get_welcome_message($task, $menu_id);
		echo $result;
	 }
	
	

	// Encodes a SQL array into a JSON formated string
	function JEncode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->encode($arr);  //encode the data in json format
		} else {
			$data = json_encode($arr);  //encode the data in json format
		}
		return $data;
	}
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>