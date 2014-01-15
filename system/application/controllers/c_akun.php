<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: akun Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_akun.php
 	+ creator 		: 
 	+ Created on 12/Mar/2010 10:42:59
	
*/

//class of akun
class C_akun extends Controller {

	//constructor
	function C_akun(){
		parent::Controller();
		session_start();
		$this->load->model('m_akun', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_akun');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->akun_list();
				break;
			case "UPDATE":
				$this->akun_update();
				break;
			case "CREATE":
				$this->akun_create();
				break;
			case "DELETE":
				$this->akun_delete();
				break;
			case "SEARCH":
				$this->akun_search();
				break;
			case "PRINT":
				$this->akun_print();
				break;
			case "EXCEL":
				$this->akun_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function akun_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_akun->akun_list($query,$start,$end);
		echo $result;
	}
	
	
	function get_akun_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_akun->get_akun_list($query,$start,$end);
		echo $result;
	}
	
	function get_akun_departemen_list(){
		$result=$this->m_akun->get_akun_departemen_list();
		echo $result;
	}
	
	//function for create new record
	function akun_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$akun_kode=trim(@$_POST["akun_kode"]);
		$akun_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_kode);
		$akun_jenis=trim(@$_POST["akun_jenis"]);
		$akun_parent=trim(@$_POST["akun_parent"]);
		$akun_nama=trim(@$_POST["akun_nama"]);
		$akun_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_nama);
		$akun_debet=trim(@$_POST["akun_debet"]);
		$akun_kredit=trim(@$_POST["akun_kredit"]);
		$akun_saldo=trim(@$_POST["akun_saldo"]);
		$akun_aktif=trim(@$_POST["akun_aktif"]);
		$akun_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_aktif);
		$akun_aktif=str_replace("'", "''",$akun_aktif);
		$akun_creator=@$_SESSION[SESSION_USERID];
		$akun_date_create=date(LONG_FORMATDATE);
		$akun_departemen=trim(@$_POST["akun_departemen"]);
		$akun_level="";
		//$akun_update=NULL;
		//$akun_date_update=NULL;
		//$akun_revised=0;
		$result=$this->m_akun->akun_create($akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,$akun_aktif ,$akun_creator ,$akun_date_create,$akun_departemen );
		echo $result;
	}
	
	
	//function for update record
	function akun_update(){
		//POST variable here
		$akun_id=trim(@$_POST["akun_id"]);
		$akun_kode=trim(@$_POST["akun_kode"]);
		$akun_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_kode);
		$akun_kode=str_replace("'", "''",$akun_kode);
		$akun_jenis=trim(@$_POST["akun_jenis"]);
		$akun_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_jenis);
		$akun_jenis=str_replace("'", "''",$akun_jenis);
		$akun_parent=trim(@$_POST["akun_parent"]);
		$akun_level=trim(@$_POST["akun_level"]);
		$akun_nama=trim(@$_POST["akun_nama"]);
		$akun_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_nama);
		$akun_nama=str_replace("'", "''",$akun_nama);
		$akun_debet=trim(@$_POST["akun_debet"]);
		$akun_kredit=trim(@$_POST["akun_kredit"]);
		$akun_periode_awal =trim(@$_POST["akun_periode_awal"]);
		$akun_saldo=trim(@$_POST["akun_saldo"]);
		$akun_aktif=trim(@$_POST["akun_aktif"]);
		$akun_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_aktif);
		$akun_aktif=str_replace("'", "''",$akun_aktif);
		$akun_departemen=trim(@$_POST["akun_departemen"]);
		//$akun_creator="akun_creator";
		//$akun_date_create="akun_date_create";
		$akun_update=@$_SESSION[SESSION_USERID];
		$akun_date_update=date(LONG_FORMATDATE);
		//$akun_revised="(revised+1)";
		$result = $this->m_akun->akun_update($akun_id,$akun_kode,$akun_jenis,$akun_parent,$akun_level,$akun_nama,$akun_debet,$akun_kredit,$akun_saldo,$akun_aktif,$akun_update,$akun_date_update,$akun_departemen, $akun_periode_awal);
		echo $result;
	}
	
	//function for delete selected record
	function akun_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_akun->akun_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function akun_search(){
		//POST varibale here
		$akun_id=trim(@$_POST["akun_id"]);
		$akun_kode=trim(@$_POST["akun_kode"]);
		$akun_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_kode);
		$akun_kode=str_replace("'", "''",$akun_kode);
		$akun_jenis=trim(@$_POST["akun_jenis"]);
		$akun_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_jenis);
		$akun_jenis=str_replace("'", "''",$akun_jenis);
		$akun_parent=trim(@$_POST["akun_parent"]);
		$akun_level=trim(@$_POST["akun_level"]);
		$akun_nama=trim(@$_POST["akun_nama"]);
		$akun_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_nama);
		$akun_nama=str_replace("'", "''",$akun_nama);
		$akun_debet=trim(@$_POST["akun_debet"]);
		$akun_kredit=trim(@$_POST["akun_kredit"]);
		$akun_saldo=trim(@$_POST["akun_saldo"]);
		$akun_aktif=trim(@$_POST["akun_aktif"]);
		$akun_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_aktif);
		$akun_aktif=str_replace("'", "''",$akun_aktif);
		$akun_creator=trim(@$_POST["akun_creator"]);
		$akun_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_creator);
		$akun_creator=str_replace("'", "''",$akun_creator);
		$akun_date_create=trim(@$_POST["akun_date_create"]);
		$akun_update=trim(@$_POST["akun_update"]);
		$akun_update=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_update);
		$akun_update=str_replace("'", "''",$akun_update);
		$akun_date_update=trim(@$_POST["akun_date_update"]);
		$akun_revised=trim(@$_POST["akun_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_akun->akun_search($akun_id ,$akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,$akun_aktif ,$akun_creator ,$akun_date_create ,$akun_update ,$akun_date_update ,$akun_revised ,$start,$end);
		echo $result;
	}


	function akun_print(){
  		//POST varibale here
		$akun_id=trim(@$_POST["akun_id"]);
		$akun_kode=trim(@$_POST["akun_kode"]);
		$akun_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_kode);
		$akun_kode=str_replace("'", "'",$akun_kode);
		$akun_jenis=trim(@$_POST["akun_jenis"]);
		$akun_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_jenis);
		$akun_jenis=str_replace("'", "'",$akun_jenis);
		$akun_parent=trim(@$_POST["akun_parent"]);
		$akun_level=trim(@$_POST["akun_level"]);
		$akun_nama=trim(@$_POST["akun_nama"]);
		$akun_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_nama);
		$akun_nama=str_replace("'", "'",$akun_nama);
		$akun_debet=trim(@$_POST["akun_debet"]);
		$akun_kredit=trim(@$_POST["akun_kredit"]);
		$akun_saldo=trim(@$_POST["akun_saldo"]);
		$akun_aktif=trim(@$_POST["akun_aktif"]);
		$akun_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_aktif);
		$akun_aktif=str_replace("'", "'",$akun_aktif);
		$akun_creator=trim(@$_POST["akun_creator"]);
		$akun_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_creator);
		$akun_creator=str_replace("'", "'",$akun_creator);
		$akun_date_create=trim(@$_POST["akun_date_create"]);
		$akun_update=trim(@$_POST["akun_update"]);
		$akun_update=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_update);
		$akun_update=str_replace("'", "'",$akun_update);
		$akun_date_update=trim(@$_POST["akun_date_update"]);
		$akun_revised=trim(@$_POST["akun_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_akun->akun_print($akun_id ,$akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,$akun_aktif ,$akun_creator ,$akun_date_create ,$akun_update ,$akun_date_update ,$akun_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_akun.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/akun_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function akun_export_excel(){
	$this->load->plugin('to_excel');
		//POST varibale here
		$akun_id=trim(@$_POST["akun_id"]);
		$akun_kode=trim(@$_POST["akun_kode"]);
		$akun_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_kode);
		$akun_kode=str_replace("'", "\'",$akun_kode);
		$akun_jenis=trim(@$_POST["akun_jenis"]);
		$akun_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_jenis);
		$akun_jenis=str_replace("'", "\'",$akun_jenis);
		$akun_parent=trim(@$_POST["akun_parent"]);
		$akun_level=trim(@$_POST["akun_level"]);
		$akun_nama=trim(@$_POST["akun_nama"]);
		$akun_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_nama);
		$akun_nama=str_replace("'", "\'",$akun_nama);
		$akun_debet=trim(@$_POST["akun_debet"]);
		$akun_kredit=trim(@$_POST["akun_kredit"]);
		$akun_saldo=trim(@$_POST["akun_saldo"]);
		$akun_aktif=trim(@$_POST["akun_aktif"]);
		$akun_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_aktif);
		$akun_aktif=str_replace("'", "\'",$akun_aktif);
		$akun_creator=trim(@$_POST["akun_creator"]);
		$akun_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_creator);
		$akun_creator=str_replace("'", "\'",$akun_creator);
		$akun_date_create=trim(@$_POST["akun_date_create"]);
		$akun_update=trim(@$_POST["akun_update"]);
		$akun_update=str_replace("/(<\/?)(p)([^>]*>)", "",$akun_update);
		$akun_update=str_replace("'", "\'",$akun_update);
		$akun_date_update=trim(@$_POST["akun_date_update"]);
		$akun_revised=trim(@$_POST["akun_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_akun->akun_export_excel($akun_id ,$akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,$akun_aktif ,$akun_creator ,$akun_date_create ,$akun_update ,$akun_date_update ,$akun_revised ,$option,$filter);
		//echo $query;
		to_excel($query,"akun"); 
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