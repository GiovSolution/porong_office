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
class C_voucher extends Controller {

	//constructor
	function C_voucher(){
		parent::Controller();
		$this->load->model('m_voucher', '', TRUE);
		session_start();
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_voucher');
	}
	
function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_voucher->get_member_no($query,$start,$end);
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->voucher_list();
				break;
			case "DELETE":
				$this->voucher_delete();
				break;
			case "SEARCH":
				$this->voucher_search();
				break;
			case "PRINT":
				$this->voucher_print();
				break;
			case "EXCEL":
				$this->voucher_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function voucher_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_voucher->voucher_list($query,$start,$end);
		echo $result;
	}

	
	//function for delete selected record
	function voucher_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_voucher->voucher_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function voucher_search(){
		//POST varibale here
		$voucher_nama=trim(@$_POST["voucher_nama"]);
		$voucher_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_nama);
		$voucher_member_no=trim(@$_POST["voucher_member_no"]);
		//$voucher_member_no=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_member_no);
		$voucher_no=trim(@$_POST["voucher_no"]);
		$voucher_no=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_no);
		$voucher_cust=trim(@$_POST["voucher_cust"]);
		$voucher_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_cust);
		$voucher_point=trim(@$_POST["voucher_point"]);
		$voucher_tanggal_start =(isset($_POST['voucher_tanggal_start']) ? @$_POST['voucher_tanggal_start'] : @$_GET['voucher_tanggal_start']);
		$voucher_tanggal_end =(isset($_POST['voucher_tanggal_end']) ? @$_POST['voucher_tanggal_end'] : @$_GET['voucher_tanggal_end']);
		$voucher_kadaluarsa=trim(@$_POST["voucher_kadaluarsa"]);
		$voucher_cashback=trim(@$_POST["voucher_cashback"]);
		
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_voucher->voucher_search($voucher_no ,$voucher_nama , $voucher_member_no, $voucher_cust, $voucher_point , $voucher_tanggal_start, $voucher_tanggal_end, $voucher_kadaluarsa ,
												   $voucher_cashback ,$start,$end);
		echo $result;
	}


	function voucher_print(){
  		//POST varibale here
		$voucher_nama=trim(@$_POST["voucher_nama"]);
		$voucher_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_nama);
		$voucher_no=trim(@$_POST["voucher_no"]);
		$voucher_no=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_no);
		$voucher_cust=trim(@$_POST["voucher_cust"]);
		$voucher_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_cust);
		$voucher_point=trim(@$_POST["voucher_point"]);
		$voucher_kadaluarsa=trim(@$_POST["voucher_kadaluarsa"]);
		$voucher_cashback=trim(@$_POST["voucher_cashback"]);
		$option=@$_POST['currentlisting'];
		$filter=@$_POST["query"];
		
		$data["data_print"] = $this->m_voucher->voucher_print($voucher_no,$voucher_nama , $voucher_cust, $voucher_point ,$voucher_kadaluarsa ,
															  $voucher_cashback , $option,$filter);

		$print_view=$this->load->view("main/p_voucher.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_voucherlist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function voucher_export_excel(){
		//POST varibale here
		$voucher_nama=trim(@$_POST["voucher_nama"]);
		$voucher_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_nama);
		$voucher_no=trim(@$_POST["voucher_no"]);
		$voucher_no=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_no);
		$voucher_cust=trim(@$_POST["voucher_cust"]);
		$voucher_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$voucher_cust);
		$voucher_point=trim(@$_POST["voucher_point"]);
		$voucher_kadaluarsa=trim(@$_POST["voucher_kadaluarsa"]);
		$voucher_cashback=trim(@$_POST["voucher_cashback"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_voucher->voucher_export_excel($voucher_no,$voucher_nama , $voucher_cust, $voucher_point ,$voucher_kadaluarsa ,
														$voucher_cashback, $option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"voucher"); 
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