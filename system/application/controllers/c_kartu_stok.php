<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: kartu_stok Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_kartu_stok.php
 	+ creator 		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/

//class of kartu_stok
class C_kartu_stok extends Controller {

	//constructor
	function C_kartu_stok(){
		parent::Controller();
		session_start();
		$this->load->model('m_kartu_stok', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_kartu_stok');
	}
	
	//event handler action
	function get_action(){
		$task = isset($_POST['task'])?@$_POST['task']:@$_GET['task'];
		switch($task){
			case "LIST":
				$this->kartu_stok_list();
				break;
			case "SEARCH":
				$this->kartu_stok_search();
				break;
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
	function generate_kartu_stok(){
		$query = isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$produk_id = (integer) (isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id']);
		$tanggal_start =(isset($_POST['tanggal_start']) ? @$_POST['tanggal_start'] : @$_GET['tanggal_start']);
		$tanggal_end = (isset($_POST['tanggal_end']) ? @$_POST['tanggal_end'] : @$_GET['tanggal_end']);
		$opsi_satuan = (isset($_POST['opsi_satuan']) ? @$_POST['opsi_satuan'] : @$_GET['opsi_satuan']);
		$gudang = (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		//$tgl_awal=$tahun."-".$bulan;
		
		$result=$this->m_kartu_stok->generate_kartu_stok($bulan, $tahun, $periode, $gudang, $produk_id, $opsi_satuan, $tanggal_start, $tanggal_end);
		echo '1';
	
	}
	
	function kartu_stok_search(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$produk_id = (integer) (isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id']);
		$tanggal_start =(isset($_POST['tanggal_start']) ? @$_POST['tanggal_start'] : @$_GET['tanggal_start']);
		$tanggal_end = (isset($_POST['tanggal_end']) ? @$_POST['tanggal_end'] : @$_GET['tanggal_end']);
		$opsi_satuan = (isset($_POST['opsi_satuan']) ? @$_POST['opsi_satuan'] : @$_GET['opsi_satuan']);
		$gudang = (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		$result=$this->m_kartu_stok->kartu_stok_list($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$query,$start,$end);
		echo $result;
	}
	
	function kartu_stok_awal(){
		$query = isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$produk_id = (integer) (isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id']);
		$tanggal_start =(isset($_POST['tanggal_start']) ? @$_POST['tanggal_start'] : @$_GET['tanggal_start']);
		$tanggal_end = (isset($_POST['tanggal_end']) ? @$_POST['tanggal_end'] : @$_GET['tanggal_end']);
		$opsi_satuan = (isset($_POST['opsi_satuan']) ? @$_POST['opsi_satuan'] : @$_GET['opsi_satuan']);
		$gudang = (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		$result=$this->m_kartu_stok->kartu_stok_awal($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$query,$start,$end);
		echo $result;
	}
	
	function stok_resume(){
		
		$produk_id = (integer) (isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id']);
		$tanggal_start =(isset($_POST['tanggal_start']) ? @$_POST['tanggal_start'] : @$_GET['tanggal_start']);
		$tanggal_end = (isset($_POST['tanggal_end']) ? @$_POST['tanggal_end'] : @$_GET['tanggal_end']);
		$opsi_satuan = (isset($_POST['opsi_satuan']) ? @$_POST['opsi_satuan'] : @$_GET['opsi_satuan']);
		$gudang = (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		$result = $this->m_kartu_stok->stok_resume($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end);
		echo $result;
		
	}
	
	
	function kartu_stok_print(){
		
  		$produk_id = (integer) (isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id']);
		$tanggal_start =(isset($_POST['tanggal_start']) ? @$_POST['tanggal_start'] : @$_GET['tanggal_start']);
		$tanggal_end = (isset($_POST['tanggal_end']) ? @$_POST['tanggal_end'] : @$_GET['tanggal_end']);
		$opsi_satuan = (isset($_POST['opsi_satuan']) ? @$_POST['opsi_satuan'] : @$_GET['opsi_satuan']);
		$gudang = (isset($_POST['gudang']) ? @$_POST['gudang'] : @$_GET['gudang']);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$tgl_awal=$tahun."-".$bulan;
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$data["data_print"] = $this->m_kartu_stok->kartu_stok_print($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$option,$filter);
		$data["gudang_nama"] = $this->m_public_function->get_gudang_nama($gudang);
		$data["produk_nama"] = $this->m_public_function->get_produk_nama($produk_id);
		$data["periode"]= $tanggal_start." s/d ".$tanggal_end;
		$data["saldo_awal"] = $this->m_kartu_stok->kartu_stok_awal_print($tgl_awal,$periode,$gudang, $produk_id, $opsi_satuan, $tanggal_start,$tanggal_end,$filter,$start,$end);
		
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
		$tanggal_start=trim(@$_POST["tanggal_start"]);
		$tanggal_end=trim(@$_POST["tanggal_end"]);
		$opsi_satuan=trim(@$_POST["opsi_satuan"]);
		$gudang=trim(@$_POST["gudang"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		
		$query = $this->m_kartu_stok->kartu_stok_export_excel($tgl_awal,$periode,$produk_id ,$tanggal_start ,$tanggal_end ,$opsi_satuan ,$gudang ,$option,$filter);
		$this->load->plugin('to_excel');
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