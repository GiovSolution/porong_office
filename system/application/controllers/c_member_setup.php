<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: member_setup Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_member_setup.php
 	+ creator 		: 
 	+ Created on 06/Apr/2010 12:55:05
	
*/

//class of member_setup
class C_member_setup extends Controller {

	//constructor
	function C_member_setup(){
		parent::Controller();
		session_start();
		$this->load->model('m_member_setup', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_member_setup');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->member_setup_list();
				break;
			case "UPDATE":
				$this->member_setup_update();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function member_setup_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_member_setup->member_setup_list($query,$start,$end);
		echo $result;
	}
	
		
	
	//function for update record
	function member_setup_update(){
		//POST variable here
		$setmember_id=trim(@$_POST["setmember_id"]);
		$setmember_transhari=trim(@$_POST["setmember_transhari"]);
		$setmember_pointhari=trim(@$_POST["setmember_pointhari"]);
		$setmember_transbulan=trim(@$_POST["setmember_transbulan"]);
		$setmember_pointbulan=trim(@$_POST["setmember_pointbulan"]);
		$setmember_periodeaktif=trim(@$_POST["setmember_periodeaktif"]);
		$setmember_periodetenggang=trim(@$_POST["setmember_periodetenggang"]);
		$setmember_transtenggang=trim(@$_POST["setmember_transtenggang"]);
		$setmember_pointtenggang=trim(@$_POST["setmember_pointtenggang"]);
		$setmember_rp_perpoint=trim(@$_POST["setmember_rp_perpoint"]);
		$setmember_point_perrp=trim(@$_POST["setmember_point_perrp"]);		
		$setmember_mintransx=trim(@$_POST["setmember_mintransx"]);
		$setmember_mintransrp=trim(@$_POST["setmember_mintransrp"]);
		$setmember_waktu=trim(@$_POST["setmember_waktu"]);
		
		//$setmember_author="setmember_author";
		//$setmember_date_create="setmember_date_create";
		$setmember_update=@$_SESSION[SESSION_USERID];
		$setmember_date_update=date(LONG_FORMATDATE);
		//$setmember_revised="(revised+1)";
		$result = $this->m_member_setup->member_setup_update($setmember_id, $setmember_transhari, $setmember_pointhari ,$setmember_transbulan, 
															 $setmember_pointbulan ,$setmember_periodeaktif ,$setmember_periodetenggang ,
															 $setmember_transtenggang, $setmember_pointtenggang, $setmember_rp_perpoint, 
															 $setmember_point_perrp, $setmember_update, $setmember_date_update, $setmember_mintransx,
															 $setmember_mintransrp, $setmember_waktu);
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
	
	
}
?>