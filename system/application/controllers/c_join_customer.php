<?php
/* 	
	+ Module  		: join_customer Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_join_customer.php
 	+ creator 		: Fred
	
*/

//class of member_setup
class C_join_customer extends Controller {

	//constructor
	function C_join_customer(){
		parent::Controller();
		session_start();
		$this->load->model('m_join_customer', '', TRUE);
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
		$result=$this->m_join_customer->get_customer_list2($query,$start,$end);
		echo $result;
	}
	
	function set_cust_point(){
		$cust_id = (integer) (isset($_POST['cust_id']) ? $_POST['cust_id'] : $_GET['cust_id']);
		$result=$this->m_join_customer->set_cust_point($cust_id);
		echo $result;
	}
	
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_join_customer');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->join_customer_list();
				break;
			case "CREATE":
				$this->join_customer_create();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function join_customer_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_join_customer->join_customer_list($query,$start,$end);
		echo $result;
	}
	
	//function for update record
	function join_customer_create(){
		//POST variable here
		$join_id=trim(@$_POST["join_id"]);
		$join_id=str_replace("/(<\/?)(p)([^>]*>)", "",$join_id);
		$join_id=str_replace("'", '"',$join_id);
		$cust_asal_id=trim(@$_POST["cust_asal_id"]);
		$cust_tujuan_id=trim(@$_POST["cust_tujuan_id"]);
		$cust_point=trim(@$_POST["cust_point"]);
		$join_tanggal=trim(@$_POST["join_tanggal"]);
		$join_keterangan=trim(@$_POST["join_keterangan"]);
		$join_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$join_keterangan);
		$join_keterangan=str_replace("'", '"',$join_keterangan);
		$join_creator=trim(@$_POST["join_creator"]);
		$join_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$join_creator);
		$join_creator=str_replace("'", '"',$join_creator);
		$join_date_create=trim(@$_POST["join_date_create"]);
		$join_update=trim(@$_POST["join_update"]);
		$join_update=str_replace("/(<\/?)(p)([^>]*>)", "",$join_update);
		$join_update=str_replace("'", '"',$join_update);
		$join_date_update=trim(@$_POST["join_date_update"]);
		$join_revised=trim(@$_POST["join_revised"]);

		$result = $this->m_join_customer->join_customer_create($join_id, $cust_asal_id, $cust_tujuan_id, $cust_point, $join_tanggal, $join_keterangan, $join_creator, $join_date_create);
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