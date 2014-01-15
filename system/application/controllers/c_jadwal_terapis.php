<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: users Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_users.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 15:35:27
	
*/

//class of users
class C_jadwal_terapis extends Controller {

	//constructor
	function C_jadwal_terapis(){
		parent::Controller();
		$this->load->model('m_jadwal_terapis', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_jadwal_terapis');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->jadwal_terapis_list();
				break;
			case "UPDATE":
				$this->penyesuaian_update();
				break;
			case "SEARCH":
				$this->jadwal_terapis_search();
				break;
			/*case "CREATE":
				$this->users_create();
				break;
			case "DELETE":
				$this->users_delete();
				break;
			case "SEARCH":
				$this->users_search();
				break;
			case "PRINT":
				$this->users_print();
				break;
			case "EXCEL":
				$this->users_export_excel();
				break;*/
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function jadwal_terapis_list(){
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_jadwal_terapis->jadwal_terapis_list($query,$start,$end,$tgl_app);
		echo $result;
	}

	//function for update record
	function penyesuaian_update(){
		//POST variable here
		$adj_id=trim(@$_POST["adj_id"]);
		$adj_count=trim(@$_POST["adj_count"]);
		$result = $this->m_jadwal_terapis->penyesuaian_update($adj_id, $adj_count);
		echo $result;
	}
	
	
	function jadwal_terapis_search(){
		//POST varibale here
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";

		//$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_jadwal_terapis->jadwal_terapis_search($lap_kunjungan_id ,$trawat_tglapp_start ,$start,$end);
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