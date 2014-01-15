<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: hpp Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_hpp.php
 	+ creator 		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/

//class of hpp
class C_hpp extends Controller {

	//constructor
	function C_hpp(){
		parent::Controller();
		session_start();
		$this->load->model('m_hpp', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_hpp');
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$satuan=(isset($_POST['satuan']) ? @$_POST['satuan'] : @$_GET['satuan']);
		$result=$this->m_hpp->get_produk_list($query,$start,$end,$satuan);
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		switch($task){
			case "LIST":
				$this->hpp_list();
				break;
			case "SEARCH":
				$this->hpp_search();
				break;
			case "PRINT":
				$this->hpp_print();
				break;
			case "EXCEL":
				$this->hpp_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function hpp_list(){
		
		/*$query 		= isset($_POST['query']) ? @$_POST['query'] : "";
		$start 		= (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end 		= (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		*/$produk_id 	= (integer) (isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id']);
		$tahun		= trim($_POST['tahun']);
		
		$result=$this->m_hpp->hpp_list($produk_id, $tahun/*, $query, $start, $end*/);
		echo $result;
	}
	
	
	//function for advanced search
	function hpp_search(){
		//POST varibale here
		$produk_id=trim(@$_POST["produk_id"]);
		$produk_nama=trim(@$_POST["produk_nama"]);
		$produk_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$produk_nama);
		$produk_nama=str_replace("'", "''",$produk_nama);
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", "''",$satuan_nama);
		$stok_saldo=trim(@$_POST["stok_saldo"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_hpp->hpp_search($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$start,$end);
		echo $result;
	}


	function hpp_print(){
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
		
		$data["data_print"] = $this->m_hpp->hpp_print($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter);
		$print_view=$this->load->view("main/p_hpp.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/hpp_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function hpp_export_excel(){
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
		
		$query = $this->m_hpp->hpp_export_excel($produk_id ,$produk_nama ,$satuan_id ,$satuan_nama ,$stok_saldo ,$option,$filter);
		
		to_excel($query,"hpp"); 
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