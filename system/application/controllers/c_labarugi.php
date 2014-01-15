<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: labarugi Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_labarugi.php
 	+ creator 		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/

//class of labarugi
class C_labarugi extends Controller {

	//constructor
	function C_labarugi(){
		parent::Controller();
		session_start();
		$this->load->model('m_labarugi', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_labarugi');
	}
	
		
	//event handler action
	function get_action(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		switch($task){
			case "LIST":
				$this->labarugi_list();
				break;
			case "SEARCH":
				$this->labarugi_search();
				break;
			case "PRINT":
				$this->labarugi_print();
				break;
			case "EXCEL":
				$this->labarugi_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function labarugi_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_labarugi->labarugi_list($query,$start,$end);
		echo $result;
	}

	
	//function for advanced search
	function labarugi_search(){
		//POST varibale here
		$labarugi_periode=trim(@$_POST["labarugi_periode"]);
		$labarugi_tglawal=trim(@$_POST["labarugi_tglawal"]);
		$labarugi_tglakhir=trim(@$_POST["labarugi_tglakhir"]);
		$labarugi_bulan=trim(@$_POST["labarugi_bulan"]);
		$labarugi_tahun=trim(@$_POST["labarugi_tahun"]);
		$labarugi_akun=trim(@$_POST["labarugi_akun"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$result = $this->m_labarugi->labarugi_search($labarugi_periode, $labarugi_tglawal, $labarugi_tglakhir, $labarugi_bulan, $labarugi_tahun, $labarugi_akun, $start,$end);
		echo $result;
	}


	function labarugi_print(){
  		//POST varibale here
		$labarugi_periode=trim(@$_POST["labarugi_periode"]);
		$labarugi_tglawal=trim(@$_POST["labarugi_tglawal"]);
		$labarugi_tglakhir=trim(@$_POST["labarugi_tglakhir"]);
		$labarugi_bulan=trim(@$_POST["labarugi_bulan"]);
		$labarugi_tahun=trim(@$_POST["labarugi_tahun"]);
		$labarugi_akun=trim(@$_POST["labarugi_akun"]);
		
		//$data["footer"]=$this->m_labarugi->labarugi_footer();
		$data["data_print"] = $this->m_labarugi->labarugi_print($labarugi_periode, $labarugi_tglawal, $labarugi_tglakhir, $labarugi_bulan, $labarugi_tahun, $labarugi_akun, 0,30);
		//echo $data["data_print"];
		$print_view=$this->load->view("main/p_labarugi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/lap_labarugi.html","w+");
		fwrite($print_file, $print_view);
		echo '1';         
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function labarugi_export_excel(){
		//POST varibale here
		$labarugi_periode=trim(@$_POST["labarugi_periode"]);
		$labarugi_tglawal=trim(@$_POST["labarugi_tglawal"]);
		$labarugi_tglakhir=trim(@$_POST["labarugi_tglakhir"]);
		$labarugi_bulan=trim(@$_POST["labarugi_bulan"]);
		$labarugi_tahun=trim(@$_POST["labarugi_tahun"]);
		$labarugi_akun=trim(@$_POST["labarugi_akun"]);
		
		//$data["footer"]=$this->m_labarugi->labarugi_footer();
		$data["data_print"] = $this->m_labarugi->labarugi_print($labarugi_periode, $labarugi_tglawal, $labarugi_tglakhir, $labarugi_bulan, $labarugi_tahun, $labarugi_akun, 0,30);
		$data["type"]="excel";
		$print_view=$this->load->view("main/p_labarugi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/lap_labarugi.xls","w+");
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