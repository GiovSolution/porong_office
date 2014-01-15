<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: promo Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_promo.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 08:57:17
	
*/

//class of promo
class C_promo extends Controller {

	//constructor
	function C_promo(){
		parent::Controller();
		session_start();
		$this->load->model('m_promo', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_promo');
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_promo->get_produk_list($query, $start, $end);
		echo $result;
	}
	
	function get_rawat_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_promo->get_rawat_list($query,$start,$end);
		echo $result;
	}
	
	function detail_promo_perawatan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_promo->detail_promo_perawatan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	function detail_promo_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_promo->detail_promo_produk_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//for detail action
	
	
	//list detail handler action
	function  detail_promo_berlaku_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_promo->detail_promo_berlaku_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_promo_produk_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_promo->detail_promo_produk_purge($master_id);
	}
	
	function detail_promo_perawatan_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_promo->detail_promo_perawatan_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_promo->get_master_id();
		echo $result;
	}
	//
	function get_produk_rawat_list(){
		$result=$this->m_public_function->get_produk_rawat_list();
		echo $result;
	}
	
	//add detail
	function detail_promo_produk_insert(){
	//POST variable here
		$ipromo_id=trim(@$_POST["ipromo_id"]);
		$ipromo_master=trim(@$_POST["ipromo_master"]);
		$ipromo_produk=trim(@$_POST["ipromo_produk"]);
		
		$ipromo_id = json_decode(stripslashes($ipromo_id));
		$ipromo_produk = json_decode(stripslashes($ipromo_produk));
		
		$result=$this->m_promo->detail_promo_produk_insert($ipromo_id,$ipromo_master ,$ipromo_produk );
	}
	
	function detail_promo_perawatan_insert(){
	//POST variable here
		$rpromo_id=trim(@$_POST["rpromo_id"]);
		$rpromo_master=trim(@$_POST["rpromo_master"]);
		$rpromo_perawatan=trim(@$_POST["rpromo_perawatan"]);
		
		$rpromo_id = json_decode(stripslashes($rpromo_id));
		$rpromo_perawatan = json_decode(stripslashes($rpromo_perawatan));
		
		$result=$this->m_promo->detail_promo_perawatan_insert($rpromo_id,$rpromo_master ,$rpromo_perawatan );
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->promo_list();
				break;
			case "UPDATE":
				$this->promo_update();
				break;
			case "CREATE":
				$this->promo_create();
				break;
			case "DELETE":
				$this->promo_delete();
				break;
			case "SEARCH":
				$this->promo_search();
				break;
			case "PRINT":
				$this->promo_print();
				break;
			case "EXCEL":
				$this->promo_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function promo_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_promo->promo_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function promo_update(){
		//POST variable here
		$promo_id=trim(@$_POST["promo_id"]);
		$promo_acara=trim(@$_POST["promo_acara"]);
		$promo_acara=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_acara);
		$promo_tempat=trim(@$_POST["promo_tempat"]);
		$promo_tempat=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_tempat);
		$promo_keterangan=trim(@$_POST["promo_keterangan"]);
		$promo_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_keterangan);
		$promo_tglmulai=trim(@$_POST["promo_tglmulai"]);
		$promo_tglselesai=trim(@$_POST["promo_tglselesai"]);
		$promo_diskon=trim(@$_POST["promo_diskon"]);
		$promo_allproduk=trim(@$_POST["promo_allproduk"]);
		$promo_allrawat=trim(@$_POST["promo_allrawat"]);
		
		$promo_allproduk=($promo_allproduk=='true'?'Y':'T');
		$promo_allrawat=($promo_allrawat=='true'?'Y':'T');
		
		$result = $this->m_promo->promo_update($promo_id ,$promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,
											   $promo_tglselesai ,$promo_diskon ,$promo_allproduk ,$promo_allrawat      );
		echo $result;
	}
	
	//function for create new record
	function promo_create(){
		//POST varible here
		$promo_acara=trim(@$_POST["promo_acara"]);
		$promo_acara=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_acara);
		$promo_tempat=trim(@$_POST["promo_tempat"]);
		$promo_tempat=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_tempat);
		$promo_keterangan=trim(@$_POST["promo_keterangan"]);
		$promo_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_keterangan);
		$promo_tglmulai=trim(@$_POST["promo_tglmulai"]);
		$promo_tglselesai=trim(@$_POST["promo_tglselesai"]);
		$promo_diskon=trim(@$_POST["promo_diskon"]);
		$promo_allproduk=trim(@$_POST["promo_allproduk"]);
		$promo_allrawat=trim(@$_POST["promo_allrawat"]);
		
		$promo_allproduk=($promo_allproduk=='true'?'Y':'T');
		$promo_allrawat=($promo_allrawat=='true'?'Y':'T');
		
		$result=$this->m_promo->promo_create($promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,
											 $promo_tglselesai ,$promo_diskon ,$promo_allproduk ,$promo_allrawat );
		echo $result;
	}

	//function for delete selected record
	function promo_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_promo->promo_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function promo_search(){
		//POST varibale here
		$promo_acara=trim(@$_POST["promo_acara"]);
		$promo_acara=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_acara);
		$promo_tempat=trim(@$_POST["promo_tempat"]);
		$promo_tempat=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_tempat);
		$promo_keterangan=trim(@$_POST["promo_keterangan"]);
		$promo_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_keterangan);
		$promo_tglmulai=trim(@$_POST["promo_tglmulai"]);
		$promo_tglselesai=trim(@$_POST["promo_tglselesai"]);
		$promo_diskon=trim(@$_POST["promo_diskon"]);

		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_promo->promo_search($promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,
											   $promo_tglselesai ,$promo_diskon,$start,$end);
		echo $result;
	}


	function promo_print(){
  		//POST varibale here
		$promo_acara=trim(@$_POST["promo_acara"]);
		$promo_acara=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_acara);
		$promo_tempat=trim(@$_POST["promo_tempat"]);
		$promo_tempat=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_tempat);
		$promo_keterangan=trim(@$_POST["promo_keterangan"]);
		$promo_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_keterangan);
		$promo_tglmulai=trim(@$_POST["promo_tglmulai"]);
		$promo_tglselesai=trim(@$_POST["promo_tglselesai"]);
		$promo_diskon=trim(@$_POST["promo_diskon"]);

		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"]  = $this->m_promo->promo_print($promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,
											   $promo_tglselesai ,$promo_diskon,$option,$filter);
   		
		$print_view=$this->load->view("main/p_promo.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_promolist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';       
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function promo_export_excel(){
		//POST varibale here
		$promo_acara=trim(@$_POST["promo_acara"]);
		$promo_acara=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_acara);
		$promo_tempat=trim(@$_POST["promo_tempat"]);
		$promo_tempat=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_tempat);
		$promo_keterangan=trim(@$_POST["promo_keterangan"]);
		$promo_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$promo_keterangan);
		$promo_tglmulai=trim(@$_POST["promo_tglmulai"]);
		$promo_tglselesai=trim(@$_POST["promo_tglselesai"]);
		$promo_diskon=trim(@$_POST["promo_diskon"]);

		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_promo->promo_export_excel($promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,
													$promo_tglselesai ,$promo_diskon ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"promo"); 
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