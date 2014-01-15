<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: member_temp Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_member_temp.php
 	+ creator 		: 
 	+ Created on 22/Apr/2010 10:01:41
	
*/

//class of member_temp
class C_member_temp extends Controller {

	//constructor
	function C_member_temp(){
		parent::Controller();
		$this->load->model('m_member_temp', '', TRUE);
		session_start();
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_member_temp');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->member_temp_list();
				break;
			case "UPDATE":
				$this->member_temp_update();
				break;
			case "CREATE":
				$this->member_temp_create();
				break;
			case "DELETE":
				$this->member_temp_delete();
				break;
			case "SEARCH":
				$this->member_temp_search();
				break;
			case "PRINT":
				$this->member_temp_print();
				break;
			case "PRINT_MEMBER":
				$this->member_temp_print_member();
				break;
			case "EXCEL":
				$this->member_temp_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function member_temp_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_member_temp->member_temp_list($query,$start,$end);
		echo $result;
	}
	
	//function for update record
	function member_temp_update(){
		//POST variable here
		$membert_id=trim(@$_POST["membert_id"]);
		$membert_cust=trim(@$_POST["membert_cust"]);
		$membert_no=trim(@$_POST["membert_no"]);
		$membert_no=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_no);
		$membert_no=str_replace("'", "''",$membert_no);
		$membert_register=trim(@$_POST["membert_register"]);
		$membert_valid=trim(@$_POST["membert_valid"]);
		$membert_jenis=trim(@$_POST["membert_jenis"]);
		$membert_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_jenis);
		$membert_jenis=str_replace("'", "''",$membert_jenis);
		$membert_status=trim(@$_POST["membert_status"]);
		$membert_status=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_status);
		$membert_status=str_replace("'", "''",$membert_status);
		$membert_check_daftar=trim(@$_POST["membert_check_daftar"]);
		$result = $this->m_member_temp->member_temp_update($membert_id,$membert_cust,$membert_no,$membert_register,$membert_valid,$membert_jenis,$membert_status, $membert_check_daftar);
		echo $result;
	}
	
	//function for delete selected record
	function member_temp_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_member_temp->member_temp_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function member_temp_search(){
		//POST varibale here
		$membert_id=trim(@$_POST["membert_id"]);
		$membert_cust=trim(@$_POST["membert_cust"]);
		$membert_no=trim(@$_POST["membert_no"]);
		$membert_no=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_no);
		$membert_no=str_replace("'", "''",$membert_no);
		$membert_register=trim(@$_POST["membert_register"]);
		$membert_valid=trim(@$_POST["membert_valid"]);
		$membert_jenis=trim(@$_POST["membert_jenis"]);
		$membert_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_jenis);
		$membert_jenis=str_replace("'", "''",$membert_jenis);
		$membert_status=trim(@$_POST["membert_status"]);
		$membert_status=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_status);
		$membert_status=str_replace("'", "''",$membert_status);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_member_temp->member_temp_search($membert_id ,$membert_cust ,$membert_no ,$membert_register ,$membert_valid ,$membert_jenis ,$membert_status ,$start,$end);
		echo $result;
	}


	function member_temp_print_member(){
  		//POST varibale here
		$membert_cust=trim(@$_POST["membert_cust"]);
		//$option=$_POST['currentlisting'];
		//$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_member_temp->member_temp_print_member($membert_cust);
		
		$info_kota = $this->m_member_temp->get_info();
		$data["cabang_kota"] = $info_kota->cabang_kota;
		
		$print_view=$this->load->view("main/p_member_temp.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/member_temp_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */
	
	function member_temp_print(){
  		//POST varibale here
		$membert_id=trim(@$_POST["membert_id"]);
		$membert_cust=trim(@$_POST["membert_cust"]);
		$membert_no=trim(@$_POST["membert_no"]);
		$membert_no=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_no);
		$membert_no=str_replace("'", "'",$membert_no);
		$membert_register=trim(@$_POST["membert_register"]);
		$membert_valid=trim(@$_POST["membert_valid"]);
		$membert_jenis=trim(@$_POST["membert_jenis"]);
		$membert_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_jenis);
		$membert_jenis=str_replace("'", "'",$membert_jenis);
		$membert_status=trim(@$_POST["membert_status"]);
		$membert_status=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_status);
		$membert_status=str_replace("'", "'",$membert_status);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_member_temp->member_temp_print($membert_id ,$membert_cust ,$membert_no ,$membert_register ,$membert_valid ,$membert_jenis ,$membert_status ,$option,$filter);
		
		//$data["cabang"] = $this->m_member_temp->get_cabang();
		$print_view=$this->load->view("main/p_member_temp.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/member_temp_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function member_temp_export_excel(){
		//POST varibale here
		$membert_id=trim(@$_POST["membert_id"]);
		$membert_cust=trim(@$_POST["membert_cust"]);
		$membert_no=trim(@$_POST["membert_no"]);
		$membert_no=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_no);
		$membert_no=str_replace("'", "\'",$membert_no);
		$membert_register=trim(@$_POST["membert_register"]);
		$membert_valid=trim(@$_POST["membert_valid"]);
		$membert_jenis=trim(@$_POST["membert_jenis"]);
		$membert_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_jenis);
		$membert_jenis=str_replace("'", "\'",$membert_jenis);
		$membert_status=trim(@$_POST["membert_status"]);
		$membert_status=str_replace("/(<\/?)(p)([^>]*>)", "",$membert_status);
		$membert_status=str_replace("'", "\'",$membert_status);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_member_temp->member_temp_export_excel($membert_id ,$membert_cust ,$membert_no ,$membert_register ,$membert_valid ,$membert_jenis ,$membert_status ,$option,$filter);
		
		to_excel($query,"member_temp"); 
		echo '1';
			
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