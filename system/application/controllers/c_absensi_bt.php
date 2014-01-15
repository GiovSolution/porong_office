<?php
/* 	
	+ Module  		: summary_report_setup Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_absensi_bt.php
 	+ creator 		: Isaac	
*/

//class of member_setup
class C_absensi_bt extends Controller {

	//constructor
	function C_absensi_bt(){
		parent::Controller();
		session_start();
		$this->load->model('m_absensi_bt', '', TRUE);
	}
	
	function get_tahun_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_absensi_bt->get_tahun_list($query);
		echo $result;
	}
	
	
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_customer_list2(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_absensi_bt->get_customer_list2($query,$start,$end);
		echo $result;
	}
	
	function set_cust_point(){
		$cust_id = (integer) (isset($_POST['cust_id']) ? $_POST['cust_id'] : $_GET['cust_id']);
		$result=$this->m_absensi_bt->set_cust_point($cust_id);
		echo $result;
	}
	
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_absensi_bt');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->absensi_bt_list();
				break;
			case "CREATE":
				$this->absensi_bt_create();
				break;
			case "UPDATE":
				$this->absensi_bt_update();
				break;	
		
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function absensi_bt_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : "";
		$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_absensi_bt->absensi_bt_list($query,$start,$end,$tahun,$bulan);
		echo $result;
	}
	
	//function for update record
	function absensi_bt_create(){
		//POST variable here
		$setsr_id=trim(@$_POST["setsr_id"]);
		$setsr_id=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_id);
		$setsr_id=str_replace("'", '"',$setsr_id);

		$absensi_bt_bulan=trim(@$_POST["absensi_bt_bulan"]);
		$absensi_bt_tahun=trim(@$_POST["absensi_bt_tahun"]);
		
		$setsr_author=trim(@$_POST["setsr_author"]);
		$setsr_author=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_author);
		$setsr_author=str_replace("'", '"',$setsr_author);
		$setsr_date_create=trim(@$_POST["setsr_date_create"]);
		$setsr_update=trim(@$_POST["setsr_update"]);
		$setsr_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_update);
		$setsr_update=str_replace("'", '"',$setsr_update);
		$setsr_date_update=trim(@$_POST["setsr_date_update"]);
		$setsr_revised=trim(@$_POST["setsr_revised"]);

		$result = $this->m_absensi_bt->absensi_bt_create($absensi_bt_bulan, $absensi_bt_tahun);
		echo $result;
	}


	function absensi_bt_update(){
		//POST variable here
		$absensi_id=trim(@$_POST["absensi_id"]);
		$absensi_id=str_replace("/(<\/?)(p)([^>]*>)", "",$absensi_id);
		$absensi_id=str_replace("'", '"',$absensi_id);
		
		$absensi_shift_1=trim(@$_POST["absensi_shift_1"]);
		$absensi_shift_2=trim(@$_POST["absensi_shift_2"]);
		$absensi_shift_3=trim(@$_POST["absensi_shift_3"]);
		$absensi_shift_4=trim(@$_POST["absensi_shift_4"]);
		$absensi_shift_5=trim(@$_POST["absensi_shift_5"]);
		$absensi_shift_6=trim(@$_POST["absensi_shift_6"]);
		$absensi_shift_7=trim(@$_POST["absensi_shift_7"]);
		$absensi_shift_8=trim(@$_POST["absensi_shift_8"]);
		$absensi_shift_9=trim(@$_POST["absensi_shift_9"]);
		$absensi_shift_10=trim(@$_POST["absensi_shift_10"]);
		$absensi_shift_11=trim(@$_POST["absensi_shift_11"]);
		$absensi_shift_12=trim(@$_POST["absensi_shift_12"]);
		$absensi_shift_13=trim(@$_POST["absensi_shift_13"]);
		$absensi_shift_14=trim(@$_POST["absensi_shift_14"]);
		$absensi_shift_15=trim(@$_POST["absensi_shift_15"]);
		$absensi_shift_16=trim(@$_POST["absensi_shift_16"]);
		$absensi_shift_17=trim(@$_POST["absensi_shift_17"]);
		$absensi_shift_18=trim(@$_POST["absensi_shift_18"]);
		$absensi_shift_19=trim(@$_POST["absensi_shift_19"]);
		$absensi_shift_20=trim(@$_POST["absensi_shift_20"]);
		$absensi_shift_21=trim(@$_POST["absensi_shift_21"]);
		$absensi_shift_22=trim(@$_POST["absensi_shift_22"]);
		$absensi_shift_23=trim(@$_POST["absensi_shift_23"]);
		$absensi_shift_24=trim(@$_POST["absensi_shift_24"]);
		$absensi_shift_25=trim(@$_POST["absensi_shift_25"]);
		$absensi_shift_26=trim(@$_POST["absensi_shift_26"]);
		$absensi_shift_27=trim(@$_POST["absensi_shift_27"]);
		$absensi_shift_28=trim(@$_POST["absensi_shift_28"]);
		$absensi_shift_29=trim(@$_POST["absensi_shift_29"]);
		$absensi_shift_30=trim(@$_POST["absensi_shift_30"]);
		$absensi_shift_31=trim(@$_POST["absensi_shift_31"]);

		//$setsr_update=trim(@$_POST["setsr_update"]);
		//$setsr_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_update);
		//$setsr_update=str_replace("'", '"',$setsr_update);
		//$setsr_date_update=trim(@$_POST["setsr_date_update"]);
		//$setsr_revised=trim(@$_POST["setsr_revised"]);
		
		$result = $this->m_absensi_bt->absensi_bt_update($absensi_id, $absensi_shift_1,$absensi_shift_2,$absensi_shift_3,$absensi_shift_4,$absensi_shift_5,$absensi_shift_6,$absensi_shift_7,$absensi_shift_8,$absensi_shift_9,$absensi_shift_10,$absensi_shift_11,$absensi_shift_12,$absensi_shift_13,$absensi_shift_14,$absensi_shift_15,$absensi_shift_16,$absensi_shift_17,$absensi_shift_18,$absensi_shift_19,$absensi_shift_20,$absensi_shift_21,$absensi_shift_22,$absensi_shift_23,$absensi_shift_24,$absensi_shift_25,$absensi_shift_26,$absensi_shift_27,$absensi_shift_28,$absensi_shift_29,$absensi_shift_30,$absensi_shift_31);
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