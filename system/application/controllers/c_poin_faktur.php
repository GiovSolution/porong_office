<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: voucher Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_voucher.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	
*/

//class of voucher
class C_poin_faktur extends Controller {

	//constructor
	function C_poin_faktur(){
		parent::Controller();
		$this->load->model('m_poin_faktur', '', TRUE);
		session_start();
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_poin_faktur');
	}
	

	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->poin_faktur_list();
				break;
			case "SEARCH":
				$this->poin_faktur_search();
				break;
			case "PRINT":
				$this->poin_faktur_print();
				break;
			case "EXCEL":
				$this->poin_faktur_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function poin_faktur_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_poin_faktur->poin_faktur_list($query,$start,$end);
		echo $result;
	}

	//function for advanced search
	function poin_faktur_search(){
		//POST varibale here
		$poin_faktur_jenis=trim(@$_POST["poin_faktur_jenis"]);
		$poin_faktur_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_jenis);
		$poin_faktur_no=trim(@$_POST["poin_faktur_no"]);
		$poin_faktur_no=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_no);
		$poin_faktur_cust=trim(@$_POST["poin_faktur_cust"]);
		$poin_faktur_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_cust);
		$poin_faktur_tanggal=trim(@$_POST["poin_faktur_tanggal"]);
		$poin_tanggal_start =(isset($_POST['poin_tanggal_start']) ? @$_POST['poin_tanggal_start'] : @$_GET['poin_tanggal_start']);
		$poin_tanggal_end =(isset($_POST['poin_tanggal_end']) ? @$_POST['poin_tanggal_end'] : @$_GET['poin_tanggal_end']);
		
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_poin_faktur->poin_faktur_search($poin_faktur_no ,$poin_faktur_jenis , $poin_faktur_cust, $poin_faktur_tanggal , $poin_tanggal_start, $poin_tanggal_end, $start,$end);
		echo $result;
	}


	function poin_faktur_print(){
  		//POST varibale here
		$poin_faktur_jenis=trim(@$_POST["poin_faktur_jenis"]);
		$poin_faktur_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_jenis);
		$poin_faktur_no=trim(@$_POST["poin_faktur_no"]);
		$poin_faktur_no=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_no);
		$poin_faktur_cust=trim(@$_POST["poin_faktur_cust"]);
		$poin_faktur_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_cust);
		$poin_faktur_tanggal=trim(@$_POST["poin_faktur_tanggal"]);

		$option=@$_POST['currentlisting'];
		$filter=@$_POST["query"];
		
		$data["data_print"] = $this->m_poin_faktur->poin_faktur_print($poin_faktur_no,$poin_faktur_jenis , $poin_faktur_cust, $poin_faktur_tanggal ,
															   			$option,$filter);

		$print_view=$this->load->view("main/p_poin_faktur.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_poin_fakturlist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function poin_faktur_export_excel(){
		//POST varibale here
		$poin_faktur_jenis=trim(@$_POST["poin_faktur_jenis"]);
		$poin_faktur_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_jenis);
		$poin_faktur_no=trim(@$_POST["poin_faktur_no"]);
		$poin_faktur_no=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_no);
		$poin_faktur_cust=trim(@$_POST["poin_faktur_cust"]);
		$poin_faktur_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$poin_faktur_cust);
		$poin_faktur_tanggal=trim(@$_POST["poin_faktur_tanggal"]);

		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_poin_faktur->poin_faktur_export_excel($poin_faktur_no,$poin_faktur_jenis , $poin_faktur_cust, $poin_faktur_tanggal ,
																$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"point_faktur"); 
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