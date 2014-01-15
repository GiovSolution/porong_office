<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: lap_poin_hangus Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_lap_poin_hangus.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 06:40:41
	
*/

//class of lap_poin_hangus
class C_lap_poin_hangus extends Controller {

	//constructor
	function C_lap_poin_hangus(){
		parent::Controller();
		$this->load->model('m_lap_poin_hangus', '', TRUE);
		session_start();
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_poin_hangus');
	}
	
function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_poin_hangus->get_member_no($query,$start,$end);
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lap_poin_hangus_list();
				break;
			case "DELETE":
				$this->lap_poin_hangus_delete();
				break;
			case "SEARCH":
				$this->lap_poin_hangus_search();
				break;
			case "PRINT":
				$this->lap_poin_hangus_print();
				break;
			case "EXCEL":
				$this->lap_poin_hangus_export_excel();
				break;
			case "POIN_RETURN":
				$this->lap_poin_return();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lap_poin_hangus_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_lap_poin_hangus->lap_poin_hangus_list($query,$start,$end);
		echo $result;
	}

	
	//function for delete selected record
	function lap_poin_hangus_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_lap_poin_hangus->lap_poin_hangus_delete($pkid);
		echo $result;
	}

	//function for mengembalikan poin hangus
	function lap_poin_return(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$tgl_poin = $_POST['tgl_poin'];
		$cust_id = $_POST['cust_id'];
		$pkid = json_decode(stripslashes($ids));
		$tgl_id = json_decode(stripslashes($tgl_poin));
		$cust_id = json_decode(stripslashes($cust_id));
		
		$keterangan=trim(@$_POST["keterangan"]);
		$keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$keterangan);
		
		$result=$this->m_lap_poin_hangus->lap_poin_return($pkid, $tgl_id, $keterangan, $cust_id);
		echo $result;
	}
	
	//function for advanced search
	function lap_poin_hangus_search(){
		//POST varibale here
		$log_id=trim(@$_POST["log_id"]);
		$log_id=str_replace("/(<\/?)(p)([^>]*>)", "",$log_id);
		$lap_poin_hangus_nmcust=trim(@$_POST["lap_poin_hangus_nmcust"]);
		$lap_poin_hangus_nmcust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_nmcust);
		//$log_poin=trim(@$_POST["log_poin"]);
		//$log_poin=str_replace("/(<\/?)(p)([^>]*>)", "",$log_poin);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		//$log_cust=trim(@$_POST["log_cust"]);
		//$log_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$log_cust);
		//$cust_nama=trim(@$_POST["cust_nama"]);
		//$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		//$log_creator=trim(@$_POST["log_creator"]);
		//$log_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$log_creator);
		//$lap_poin_hangus_point=trim(@$_POST["lap_poin_hangus_point"]);
		$lap_poin_hangus_tanggal_start =(isset($_POST['lap_poin_hangus_tanggal_start']) ? @$_POST['lap_poin_hangus_tanggal_start'] : @$_GET['lap_poin_hangus_tanggal_start']);
		$lap_poin_hangus_tanggal_end =(isset($_POST['lap_poin_hangus_tanggal_end']) ? @$_POST['lap_poin_hangus_tanggal_end'] : @$_GET['lap_poin_hangus_tanggal_end']);
		//$log_date_create=trim(@$_POST["log_date_create"]);
		//$log_creator=trim(@$_POST["log_creator"]);
		
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_lap_poin_hangus->lap_poin_hangus_search($log_id, $lap_poin_hangus_nmcust, $lap_poin_hangus_tanggal_start, $lap_poin_hangus_tanggal_end,$start,$end);
		echo $result;
	}


	function lap_poin_hangus_print(){
  		//POST varibale here
		$lap_poin_hangus_nama=trim(@$_POST["lap_poin_hangus_nama"]);
		$lap_poin_hangus_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_nama);
		$lap_poin_hangus_no=trim(@$_POST["lap_poin_hangus_no"]);
		$lap_poin_hangus_no=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_no);
		$lap_poin_hangus_cust=trim(@$_POST["lap_poin_hangus_cust"]);
		$lap_poin_hangus_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_cust);
		$lap_poin_hangus_point=trim(@$_POST["lap_poin_hangus_point"]);
		$lap_poin_hangus_kadaluarsa=trim(@$_POST["lap_poin_hangus_kadaluarsa"]);
		$lap_poin_hangus_cashback=trim(@$_POST["lap_poin_hangus_cashback"]);
		$option=@$_POST['currentlisting'];
		$filter=@$_POST["query"];
		
		$data["data_print"] = $this->m_lap_poin_hangus->lap_poin_hangus_print($lap_poin_hangus_no,$lap_poin_hangus_nama , $lap_poin_hangus_cust, $lap_poin_hangus_point ,$lap_poin_hangus_kadaluarsa ,
															  $lap_poin_hangus_cashback , $option,$filter);

		$print_view=$this->load->view("main/p_lap_poin_hangus.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_lap_poin_hanguslist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function lap_poin_hangus_export_excel(){
		//POST varibale here
		$lap_poin_hangus_nama=trim(@$_POST["lap_poin_hangus_nama"]);
		$lap_poin_hangus_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_nama);
		$lap_poin_hangus_no=trim(@$_POST["lap_poin_hangus_no"]);
		$lap_poin_hangus_no=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_no);
		$lap_poin_hangus_cust=trim(@$_POST["lap_poin_hangus_cust"]);
		$lap_poin_hangus_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_poin_hangus_cust);
		$lap_poin_hangus_point=trim(@$_POST["lap_poin_hangus_point"]);
		$lap_poin_hangus_kadaluarsa=trim(@$_POST["lap_poin_hangus_kadaluarsa"]);
		$lap_poin_hangus_cashback=trim(@$_POST["lap_poin_hangus_cashback"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_lap_poin_hangus->lap_poin_hangus_export_excel($lap_poin_hangus_no,$lap_poin_hangus_nama , $lap_poin_hangus_cust, $lap_poin_hangus_point ,$lap_poin_hangus_kadaluarsa ,
														$lap_poin_hangus_cashback, $option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"lap_poin_hangus"); 
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