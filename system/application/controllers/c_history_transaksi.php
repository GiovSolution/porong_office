<?php
/* 	
	+ Module  		: history_transaksi Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_history_transaksi.php
 	+ creator 		: Freddy

*/

//class of kartu_stok
class C_history_transaksi extends Controller {

	//constructor
	function C_history_transaksi(){
		parent::Controller();
		session_start();
		$this->load->model('m_history_transaksi', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_history_transaksi');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = isset($_POST['task'])?@$_POST['task']:@$_GET['task'];
		switch($task){
			case "LIST":
				$this->history_transaksi_list();
				break;
			/*case "SEARCH":
				$this->kartu_stok_search();
				break;*/
			case "PRINT":
				$this->kartu_stok_print();
				break;
			case "EXCEL":
				$this->kartu_stok_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function history_transaksi_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$cust_id = (integer) (isset($_POST['cust_id']) ? @$_POST['cust_id'] : @$_GET['cust_id']);
		$tanggal_start =(isset($_POST['tanggal_start']) ? @$_POST['tanggal_start'] : @$_GET['tanggal_start']);
		$tanggal_end = (isset($_POST['tanggal_end']) ? @$_POST['tanggal_end'] : @$_GET['tanggal_end']);
		$jenis = (isset($_POST['jenis']) ? @$_POST['jenis'] : @$_GET['jenis']);
		
		$result=$this->m_history_transaksi->history_transaksi_list($cust_id, $tanggal_start,$tanggal_end,$jenis,$query,$start,$end);
		echo $result;
	}

	
	function kartu_stok_print(){
  		//POST varibale here
		$produk_id=trim(@$_POST["produk_id"]);
		$produk_nama=trim(@$_POST["produk_nama"]);
		$produk_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$produk_nama);
		$produk_nama=str_replace("'", "'",$produk_nama);
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", "'",$satuan_nama);
		$stok_saldo=trim(@$_POST["stok_saldo"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_history_transaksi->kartu_stok_print($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter);
		$print_view=$this->load->view("main/p_kartu_stok.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/kartu_stok_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function kartu_stok_export_excel(){
		//POST varibale here
		$produk_id=trim(@$_POST["produk_id"]);
		$produk_nama=trim(@$_POST["produk_nama"]);
		$produk_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$produk_nama);
		$produk_nama=str_replace("'", "\'",$produk_nama);
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", "\'",$satuan_nama);
		$stok_saldo=trim(@$_POST["stok_saldo"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_history_transaksi->kartu_stok_export_excel($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter);
		
		to_excel($query,"kartu_stok"); 
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