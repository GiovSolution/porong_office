<?php
/* 	
	+ Module  		: summary_report_setup Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_summary_report_setup.php
 	+ creator 		: Fred
	
*/

//class of member_setup
class C_summary_report_setup extends Controller {

	//constructor
	function C_summary_report_setup(){
		parent::Controller();
		session_start();
		$this->load->model('m_summary_report_setup', '', TRUE);
	}
	
	function get_tahun_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_summary_report_setup->get_tahun_list($query);
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
		$result=$this->m_summary_report_setup->get_customer_list2($query,$start,$end);
		echo $result;
	}
	
	function set_cust_point(){
		$cust_id = (integer) (isset($_POST['cust_id']) ? $_POST['cust_id'] : $_GET['cust_id']);
		$result=$this->m_summary_report_setup->set_cust_point($cust_id);
		echo $result;
	}
	
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_summary_report_setup');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->sr_setup_list();
				break;
			case "CREATE":
				$this->sr_setup_create();
				break;
			case "UPDATE":
				$this->sr_setup_update();
				break;	
		
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function sr_setup_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tahun = isset($_POST['tahun']) ? $_POST['tahun'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_summary_report_setup->sr_setup_list($query,$start,$end,$tahun);
		echo $result;
	}
	
	//function for update record
	function sr_setup_create(){
		//POST variable here
		$setsr_id=trim(@$_POST["setsr_id"]);
		$setsr_id=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_id);
		$setsr_id=str_replace("'", '"',$setsr_id);
		$setsr_cabang=trim(@$_POST["setsr_cabang"]);
		$setsr_tahun=trim(@$_POST["setsr_tahun"]);
		$setsr_jenis=trim(@$_POST["setsr_jenis"]);
		$setsr_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_jenis);
		$setsr_jenis=str_replace("'", '"',$setsr_jenis);
		
		$setsr_jan=trim(@$_POST["setsr_jan"]);
		$setsr_feb=trim(@$_POST["setsr_feb"]);
		$setsr_mar=trim(@$_POST["setsr_mar"]);
		$setsr_apr=trim(@$_POST["setsr_apr"]);
		$setsr_may=trim(@$_POST["setsr_may"]);
		$setsr_jun=trim(@$_POST["setsr_jun"]);
		$setsr_jul=trim(@$_POST["setsr_jul"]);
		$setsr_aug=trim(@$_POST["setsr_aug"]);
		$setsr_sep=trim(@$_POST["setsr_sep"]);
		$setsr_oct=trim(@$_POST["setsr_oct"]);
		$setsr_nov=trim(@$_POST["setsr_nov"]);
		$setsr_dec=trim(@$_POST["setsr_dec"]);

		$setsr_author=trim(@$_POST["setsr_author"]);
		$setsr_author=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_author);
		$setsr_author=str_replace("'", '"',$setsr_author);
		$setsr_date_create=trim(@$_POST["setsr_date_create"]);
		$setsr_update=trim(@$_POST["setsr_update"]);
		$setsr_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_update);
		$setsr_update=str_replace("'", '"',$setsr_update);
		$setsr_date_update=trim(@$_POST["setsr_date_update"]);
		$setsr_revised=trim(@$_POST["setsr_revised"]);

		$result = $this->m_summary_report_setup->sr_setup_create($setsr_id, $setsr_cabang, $setsr_tahun, $setsr_jenis, $setsr_jan, $setsr_feb, $setsr_mar, $setsr_apr, $setsr_may, $setsr_jun, $setsr_jul, $setsr_aug, $setsr_sep, $setsr_oct, $setsr_nov, $setsr_dec, $setsr_author, $setsr_date_create, $setsr_update, $setsr_date_update, $setsr_revised);
		echo $result;
	}


	function sr_setup_update(){
		//POST variable here
		$setsr_id=trim(@$_POST["setsr_id"]);
		$setsr_id=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_id);
		$setsr_id=str_replace("'", '"',$setsr_id);
		
		$setsr_jan=trim(@$_POST["setsr_jan"]);
		$setsr_feb=trim(@$_POST["setsr_feb"]);
		$setsr_mar=trim(@$_POST["setsr_mar"]);
		$setsr_apr=trim(@$_POST["setsr_apr"]);
		$setsr_may=trim(@$_POST["setsr_may"]);
		$setsr_jun=trim(@$_POST["setsr_jun"]);
		$setsr_jul=trim(@$_POST["setsr_jul"]);
		$setsr_aug=trim(@$_POST["setsr_aug"]);
		$setsr_sep=trim(@$_POST["setsr_sep"]);
		$setsr_oct=trim(@$_POST["setsr_oct"]);
		$setsr_nov=trim(@$_POST["setsr_nov"]);
		$setsr_dec=trim(@$_POST["setsr_dec"]);

		$setsr_update=trim(@$_POST["setsr_update"]);
		$setsr_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setsr_update);
		$setsr_update=str_replace("'", '"',$setsr_update);
		$setsr_date_update=trim(@$_POST["setsr_date_update"]);
		$setsr_revised=trim(@$_POST["setsr_revised"]);
		
		$result = $this->m_summary_report_setup->sr_setup_update($setsr_id, $setsr_jan, $setsr_feb, $setsr_mar, $setsr_apr, $setsr_may, $setsr_jun, $setsr_jul, $setsr_aug, $setsr_sep, $setsr_oct, $setsr_nov, $setsr_dec, $setsr_update, $setsr_date_update, $setsr_revised);
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