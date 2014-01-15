<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: info Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_info.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of info
class C_info extends Controller {

	//constructor
	function C_info(){
		parent::Controller();
		session_start();
		$this->load->model('m_info', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_info');
	}
	
	function get_auto_cabang(){
		$cabang_id = (integer) (isset($_POST['cabang_id']) ? $_POST['cabang_id'] : $_GET['cabang_id']);
		$result=$this->m_info->get_auto_cabang($cabang_id);
		echo $result;
	}
	
	function get_detail_info(){
		$result=$this->m_info->get_detail_info();
		echo $result;
	}
	function get_cabang_list(){
		//ID dokter pada tabel departemen adalah 8
		//$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_cabang_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->info_list();
				break;
			case "UPDATE":
				$this->info_update();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function info_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_info->info_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function info_update(){
		//POST variable here
		$info_id=trim(@$_POST["info_id"]);
		$info_nama=trim(@$_POST["info_nama"]);
		$info_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$info_nama);
		$info_nama=str_replace("'", '"',$info_nama);
		$info_alamat=trim(@$_POST["info_alamat"]);
		$info_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$info_alamat);
		$info_alamat=str_replace("'", '"',$info_alamat);
		$info_notelp=trim(@$_POST["info_notelp"]);
		$info_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$info_notelp);
		$info_notelp=str_replace("'", '"',$info_notelp);
		$info_nofax=trim(@$_POST["info_nofax"]);
		$info_nofax=str_replace("/(<\/?)(p)([^>]*>)", "",$info_nofax);
		$info_nofax=str_replace("'", '"',$info_nofax);
		$info_email=trim(@$_POST["info_email"]);
		$info_email=str_replace("/(<\/?)(p)([^>]*>)", "",$info_email);
		$info_email=str_replace("'", '"',$info_email);
		$info_website=trim(@$_POST["info_website"]);
		$info_website=str_replace("/(<\/?)(p)([^>]*>)", "",$info_website);
		$info_website=str_replace("'", '"',$info_website);
		$info_slogan=trim(@$_POST["info_slogan"]);
		$info_slogan=str_replace("/(<\/?)(p)([^>]*>)", "",$info_slogan);
		$info_slogan=str_replace("'", '"',$info_slogan);
		$info_cabang=trim(@$_POST["info_cabang"]);
		$result = $this->m_info->info_update($info_id ,$info_nama ,$info_alamat ,$info_notelp ,$info_nofax ,$info_email ,$info_website ,
											 $info_slogan, $info_cabang);
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
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>