<?php
/* 
	+ Module  		: Welcome Message Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_report_welcome_msg.php
 	+ Author  		: Isaac 
	
*/

//class of tindakan
class C_report_welcome_msg extends Controller {

	//constructor
	function C_report_welcome_msg(){
		parent::Controller();
		session_start();
		$this->load->model('m_report_welcome_msg', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_report_welcome_msg');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->welcome_msg_search();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	

	//function for advanced search
	function welcome_msg_search(){
		//POST varibale here
		$result = $this->m_report_welcome_msg->welcome_msg_search();
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
	
	// Decode a SQL array into a JSON formated string
	function JDecode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->decode($arr);  //decode the data in json format
		} else {
			$data = json_decode($arr);  //decode the data in json format
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