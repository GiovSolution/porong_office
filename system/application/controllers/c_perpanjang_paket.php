<?php
/* 	
	+ Module  		: Perpanjangan Paket Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_perpanjang_paket.php
 	+ creator 		: Fred
	
*/

//class of member_setup
class C_perpanjang_paket extends Controller {

	//constructor
	function C_perpanjang_paket(){
		parent::Controller();
		session_start();
		$this->load->model('m_perpanjang_paket', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_perpanjang_paket');
	}
	

	function get_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_perpanjang_paket->get_paket_list($query,$start,$end);
		echo $result;
	}
	

	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->perpanjang_paket_list();
				break;
			case "CREATE":
				$this->perpanjang_paket_create();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function perpanjang_paket_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_perpanjang_paket->perpanjang_paket_list($query,$start,$end);
		echo $result;
	}
	
	//function for update record
	function perpanjang_paket_create(){
		//POST variable here
		$perpanjang_id=trim(@$_POST["perpanjang_id"]);
		$perpanjang_id=str_replace("/(<\/?)(p)([^>]*>)", "",$perpanjang_id);
		$perpanjang_id=str_replace("'", '"',$perpanjang_id);
		$perpanjang_djpaket_id=trim(@$_POST["perpanjang_djpaket_id"]);
		$perpanjang_hari=trim(@$_POST["perpanjang_hari"]);
		$cust_point=trim(@$_POST["cust_point"]);
		$perpanjang_tanggal=trim(@$_POST["perpanjang_tanggal"]);
		$perpanjang_keterangan=trim(@$_POST["perpanjang_keterangan"]);
		$perpanjang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$perpanjang_keterangan);
		$perpanjang_keterangan=str_replace("'", '"',$perpanjang_keterangan);
		$perpanjang_creator=trim(@$_POST["perpanjang_creator"]);
		$perpanjang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$perpanjang_creator);
		$perpanjang_creator=str_replace("'", '"',$perpanjang_creator);
		$perpanjang_date_create=trim(@$_POST["perpanjang_date_create"]);
		$perpanjang_update=trim(@$_POST["perpanjang_update"]);
		$perpanjang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$perpanjang_update);
		$perpanjang_update=str_replace("'", '"',$perpanjang_update);
		$perpanjang_date_update=trim(@$_POST["perpanjang_date_update"]);
		$perpanjang_revised=trim(@$_POST["perpanjang_revised"]);

		$result = $this->m_perpanjang_paket->perpanjang_paket_create($perpanjang_id, $perpanjang_djpaket_id, $perpanjang_hari, $cust_point, $perpanjang_tanggal, $perpanjang_keterangan, $perpanjang_creator, $perpanjang_date_create);
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