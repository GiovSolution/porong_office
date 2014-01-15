<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: neraca Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_neraca.php
 	+ creator 		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/

//class of neraca
class C_neraca extends Controller {

	//constructor
	function C_neraca(){
		parent::Controller();
		session_start();
		$this->load->model('m_neraca', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_neraca');
	}
	
		
	//event handler action
	function get_action(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		switch($task){
			case "LIST":
				$this->neraca_list();
				break;
			case "SEARCH":
				$this->neraca_search();
				break;
			case "PRINT":
				$this->neraca_print();
				break;
			case "EXCEL":
				$this->neraca_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function neraca_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_neraca->neraca_list($query,$start,$end);
		echo $result;
	}

	
	//function for advanced search
	function neraca_search(){
		//POST varibale here
		$neraca_periode=trim(@$_POST["neraca_periode"]);
		$neraca_tglawal=trim(@$_POST["neraca_tglawal"]);
		$neraca_tglakhir=trim(@$_POST["neraca_tglakhir"]);
		$neraca_bulan=trim(@$_POST["neraca_bulan"]);
		$neraca_tahun=trim(@$_POST["neraca_tahun"]);
		$neraca_akun=trim(@$_POST["neraca_akun"]);
		$neraca_jenis=trim(@$_POST["neraca_jenis"]);
		
		$start = 0;
		$end = 0;
		
		$result = $this->m_neraca->neraca_search($neraca_periode, $neraca_tglawal, 
													$neraca_tglakhir, $neraca_bulan, 
													$neraca_tahun, $neraca_akun, $start,$end, 
													$neraca_jenis);
		echo $result;
	}


	function neraca_print(){
  		//POST varibale here
		$neraca_periode=trim(@$_POST["neraca_periode"]);
		$neraca_tglawal=trim(@$_POST["neraca_tglawal"]);
		$neraca_tglakhir=trim(@$_POST["neraca_tglakhir"]);
		$neraca_bulan=trim(@$_POST["neraca_bulan"]);
		$neraca_tahun=trim(@$_POST["neraca_tahun"]);
		$neraca_akun=trim(@$_POST["neraca_akun"]);
		
		$start = 0;
		$end = 0;
		
		$data["neraca_aktiva"]= $this->m_neraca->neraca_print($neraca_periode, $neraca_tglawal, 
															$neraca_tglakhir, $neraca_bulan, 
															$neraca_tahun, $neraca_akun, 
															$start,$end, "Aktiva");
		$data["neraca_pasiva"]= $this->m_neraca->neraca_print($neraca_periode, $neraca_tglawal, 
															$neraca_tglakhir, $neraca_bulan, 
															$neraca_tahun, $neraca_akun, 
															$start,$end, "Pasiva");
															
		$print_view=$this->load->view("main/p_neraca.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/lap_neraca.html","w+");
		fwrite($print_file, $print_view);
		
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function neraca_export_excel(){
	//POST varibale here
		$neraca_periode=trim(@$_POST["neraca_periode"]);
		$neraca_tglawal=trim(@$_POST["neraca_tglawal"]);
		$neraca_tglakhir=trim(@$_POST["neraca_tglakhir"]);
		$neraca_bulan=trim(@$_POST["neraca_bulan"]);
		$neraca_tahun=trim(@$_POST["neraca_tahun"]);
		$neraca_akun=trim(@$_POST["neraca_akun"]);
		
		$start = 0;
		$end = 0;
		
		$data["data_print"]= $this->m_neraca->neraca_print($neraca_periode, $neraca_tglawal, 
															$neraca_tglakhir, $neraca_bulan, 
															$neraca_tahun, $neraca_akun, $start,$end);
		$data["type"]="excel";
		$print_view=$this->load->view("main/p_neraca.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/lap_neraca.xls","w+");
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
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
	
}
?>