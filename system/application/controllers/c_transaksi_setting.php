<?php
/* 	
	+ Module  		: transaksi_setting Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_transaksi_setting.php
 	+ creator 		:  Fred

	
*/

//class of member_setup
class C_transaksi_setting extends Controller {

	//constructor
	function C_transaksi_setting(){
		parent::Controller();
		session_start();
		$this->load->model('m_transaksi_setting', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_transaksi_setting');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->transaksi_setting_list();
				break;
			case "UPDATE":
				$this->transaksi_setting_update();
				break;
			case "CREATE":
				$this->transaksi_setting_create();
				break;

			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function transaksi_setting_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_transaksi_setting->transaksi_setting_list($query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function transaksi_setting_create(){
		//POST varible here
		
		
		$trans_author=@$_SESSION[SESSION_USERID];
		$trans_date_create=date(LONG_FORMATDATE);
		
		$result=$this->m_transaksi_setting->transaksi_setting_create($trans_op_days, $trans_update, $trans_date_update);
		echo $result;
	}
	
	
	//function for update record
	function transaksi_setting_update(){
		//POST variable here
			
		$trans_op_days=trim(@$_POST["trans_op_days"]);
		$mb_days=trim(@$_POST["mb_days"]);
		$kembali_poin_days=trim(@$_POST["kembali_poin_days"]);
		$trans_update=@$_SESSION[SESSION_USERID];
		$trans_date_update=date(LONG_FORMATDATE);
		$result = $this->m_transaksi_setting->transaksi_setting_update($trans_op_days, $mb_days, $kembali_poin_days, $trans_update, $trans_date_update);
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