<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: jurnal_harian Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_jurnal_harian.php
 	+ creator 		: 
 	+ Created on 01/Apr/2010 12:13:56
	
*/

//class of jurnal_harian
class C_jurnal_harian extends Controller {

	//constructor
	function C_jurnal_harian(){
		parent::Controller();
		session_start();
		$this->load->model('m_jurnal_harian', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->view('main/v_jurnal_harian');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->jurnal_harian_list();
				break;
			case "SEARCH":
				$this->jurnal_harian_search();
				break;
			case "PRINT":
				$this->jurnal_harian_print();
				break;
			case "EXCEL":
				$this->jurnal_harian_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function jurnal_harian_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_jurnal_harian->jurnal_harian_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function get_akun_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$master_id = (integer) isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_jurnal_harian->get_akun_list($task, $master_id, $selected_id,$query,$start,$end);
		echo $result;
	}
	
	//function for advanced search
	function jurnal_harian_search(){
		//POST varibale here
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_tgl_awal=trim(@$_POST["jurnal_tgl_awal"]);
		$jurnal_tgl_akhir=trim(@$_POST["jurnal_tgl_akhir"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_jurnal_harian->jurnal_harian_search($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir,$start,$end);
		echo $result;
	}


	function jurnal_harian_print(){
  		//POST varibale here
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_tgl_awal=trim(@$_POST["jurnal_tgl_awal"]);
		$jurnal_tgl_akhir=trim(@$_POST["jurnal_tgl_akhir"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["periode"]=$jurnal_tgl_awal." s/d ".$jurnal_tgl_akhir;
		$data["type"]="";
		$data["data_print"] = $this->m_jurnal_harian->jurnal_harian_print($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir,$option,$filter);
		$print_view=$this->load->view("main/p_jurnal_harian.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/jurnal_harian_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function jurnal_harian_export_excel(){
		$this->load->plugin('to_excel');
		$jurnal_no=trim(@$_POST["jurnal_no"]);
		$jurnal_tgl_awal=trim(@$_POST["jurnal_tgl_awal"]);
		$jurnal_tgl_akhir=trim(@$_POST["jurnal_tgl_akhir"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["periode"]=$jurnal_tgl_awal." s/d ".$jurnal_tgl_akhir;
		$data["type"]="excel";
		$data["data_print"] = $this->m_jurnal_harian->jurnal_harian_print($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir,$option,$filter);
		$print_view=$this->load->view("main/p_jurnal_harian.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/jurnal_harian_printlist.xls","w+");
		fwrite($print_file, $print_view);
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
	
	
}
?>