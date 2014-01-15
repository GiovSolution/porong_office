<?php
/* 	
	+ Module  		: Crm Generator Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_crm_generator.php
 	+ creator 		: Fred
	
*/

//class of member_setup
class C_crm_generator extends Controller {

	//constructor
	function C_crm_generator(){
		parent::Controller();
		session_start();
		$this->load->model('m_crm_generator', '', TRUE);
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
		$result=$this->m_crm_generator->get_customer_list2($query,$start,$end);
		echo $result;
	}
	
	function set_cust_point(){
		$cust_id = (integer) (isset($_POST['cust_id']) ? $_POST['cust_id'] : $_GET['cust_id']);
		$result=$this->m_crm_generator->set_cust_point($cust_id);
		echo $result;
	}
	
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_crm_generator');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->crm_generator_list();
				break;
			case "CREATE":
				$this->crm_generator_create();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function crm_generator_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_crm_generator->crm_generator_list($query,$start,$end);
		echo $result;
	}
	
	//function for update record
	function crm_generator_create(){
		//POST variable here
		$crmvalue_id=trim(@$_POST["crmvalue_id"]);
		$crmvalue_id=str_replace("/(<\/?)(p)([^>]*>)", "",$crmvalue_id);
		$crmvalue_id=str_replace("'", '"',$crmvalue_id);
		$crmvalue_cust=trim(@$_POST["crmvalue_cust"]);
		$crmvalue_date=trim(@$_POST["crmvalue_date"]);
		$crmvalue_frequency=trim(@$_POST["crmvalue_frequency"]);
		$crmvalue_recency=trim(@$_POST["crmvalue_recency"]);
		$crmvalue_spending=trim(@$_POST["crmvalue_spending"]);
		$crmvalue_highmargin=trim(@$_POST["crmvalue_highmargin"]);
		$crmvalue_referal=trim(@$_POST["crmvalue_referal"]);
		$crmvalue_kerewelan=trim(@$_POST["crmvalue_kerewelan"]);
		$crmvalue_disiplin=trim(@$_POST["crmvalue_disiplin"]);
		$crmvalue_treatment=trim(@$_POST["crmvalue_treatment"]);
		
		
		$crmvalue_author=trim(@$_POST["crmvalue_author"]);
		$crmvalue_author=str_replace("/(<\/?)(p)([^>]*>)", "",$crmvalue_author);
		$crmvalue_author=str_replace("'", '"',$crmvalue_author);

		$query = isset($_POST['query']) ? $_POST['query'] : "";
		
		$result = $this->m_public_function->crm_generator_create($query, $crmvalue_id, $crmvalue_cust, $crmvalue_date, $crmvalue_frequency, $crmvalue_recency, $crmvalue_spending, $crmvalue_highmargin, $crmvalue_referal, $crmvalue_kerewelan, $crmvalue_disiplin, $crmvalue_treatment, $crmvalue_author);
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