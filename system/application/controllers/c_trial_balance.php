<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: trial_balance Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_trial_balance.php
 	+ creator 		: 
 	+ Created on 27/May/2010 16:40:49
	
*/

//class of trial_balance
class C_trial_balance extends Controller {

	//constructor
	function C_trial_balance(){
		parent::Controller();
		session_start();
		$this->load->model('m_trial_balance', '', TRUE);
	}
	
	//set index
	function index(){

		$this->load->view('main/v_trial_balance');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "SEARCH":
				$this->trial_balance_search();
				break;
			case "PRINT":
				$this->trial_balance_print();
				break;
			case "EXCEL":
				$this->trial_balance_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function trial_balance_generate(){
		
		$balance_tgl_awal=trim(@$_POST["balance_tgl_awal"]);
		$balance_tgl_akhir=trim(@$_POST["balance_tgl_akhir"]);
		$result=$this->m_trial_balance->trial_balance_generate($balance_tgl_awal, $balance_tgl_akhir);
		echo $result;
	}
	
	//function fot list record
	function trial_balance_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_trial_balance->trial_balance_list($query,$start,$end);
		echo $result;
	}
		
	
	//function for advanced search
	function trial_balance_search(){
		
		$balance_tgl_awal=trim(@$_POST["balance_tgl_awal"]);
		$balance_tgl_akhir=trim(@$_POST["balance_tgl_akhir"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_trial_balance->trial_balance_search($balance_tgl_awal, $balance_tgl_akhir,$start,$end);
		echo $result;
	}


	function trial_balance_print(){
  		//POST varibale here
		$balance_tgl_awal=trim(@$_POST["balance_tgl_awal"]);
		$balance_tgl_akhir=trim(@$_POST["balance_tgl_akhir"]);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
	    
		//$this->firephp->log($balance_tgl_awal);
		
		$data["periode"]="";
		if($balance_tgl_awal!=="")
			$data["periode"].="Tanggal ".$balance_tgl_awal;
		
		if($balance_tgl_akhir!=="")
			$data["periode"].=" s/d ".$balance_tgl_akhir;
			
		$data["data_print"] = $this->m_trial_balance->trial_balance_print($balance_tgl_awal, $balance_tgl_akhir,$start,$end );
		
		$print_view=$this->load->view("main/p_trial_balance.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/trial_balance_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function trial_balance_export_excel(){
		$balance_tgl_awal=trim(@$_POST["balance_tgl_awal"]);
		$balance_tgl_akhir=trim(@$_POST["balance_tgl_akhir"]);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$data["data_print"] = $this->m_trial_balance->trial_balance_print($balance_tgl_awal, $balance_tgl_akhir,$start,$end );
		$data["type"]="excel";
		$print_view=$this->load->view("main/p_trial_balance.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/trial_balance_printlist.xls","w+");
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
	
	function convertDate ($date) {
		  $tab = explode ("-", $date);
		  $r = $tab[1]."/".$tab[2]."/".$tab[0];
		  return $r;
	}
	
	
}
?>