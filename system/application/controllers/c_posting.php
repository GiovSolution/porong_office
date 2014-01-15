<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: posting Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_posting.php
 	+ Author  		: Zainal, Anam
 	+ Created on 12/Mar/2010 10:45:40
	
*/

//class of posting
class C_posting extends Controller {

	//constructor
	function C_posting(){
		parent::Controller();
		session_start();
		$this->load->model('m_posting', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_posting');
	}
	
	function post_transaksi(){
		$tgl_awal=isset($_POST['tgl_awal'])?@$_POST['tgl_awal']:@$_GET['tgl_awal'];
		$tgl_akhir=isset($_POST['tgl_akhir'])?@$_POST['tgl_akhir']:@$_GET['tgl_akhir'];
		$bulan=isset($_POST['bulan'])?@$_POST['bulan']:@$_GET['bulan'];
		$tahun=isset($_POST['tahun'])?@$_POST['tahun']:@$_GET['tahun'];
		$periode=isset($_POST['periode'])?@$_POST['periode']:@$_GET['periode'];
		$result=$this->m_posting->post_transaksi($tgl_awal,$tgl_akhir,$bulan,$tahun,$periode);
		echo $result;
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