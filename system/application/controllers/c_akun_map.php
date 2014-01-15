<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: akun_map Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_akun_map.php
 	+ creator 		: 
 	+ Created on 06/Oct/2010 10:15:56
	
*/

//class of akun_map
class C_akun_map extends Controller {

	//constructor
	function C_akun_map(){
		parent::Controller();
		session_start();
		$this->load->model('m_akun_map', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->view('main/v_akun_map');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->akun_map_list();
				break;
			case "UPDATE":
				$this->akun_map_update();
				break;
			case "CREATE":
				$this->akun_map_create();
				break;
			case "DELETE":
				$this->akun_map_delete();
				break;
			case "SEARCH":
				$this->akun_map_search();
				break;
			case "PRINT":
				$this->akun_map_print();
				break;
			case "EXCEL":
				$this->akun_map_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function get_map_kategori_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_akun_map->get_map_kategori_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function akun_map_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_akun_map->akun_map_list($query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function akun_map_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$map_kategori=trim(@$_POST["map_kategori"]);
		$map_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$map_kategori);
		$map_kategori=str_replace("'", "''",$map_kategori);
		$map_nama=trim(@$_POST["map_nama"]);
		$map_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$map_nama);
		$map_nama=str_replace("'", "''",$map_nama);
		$map_akun=trim(@$_POST["map_akun"]);
		$map_akun_kode=trim(@$_POST["map_akun_kode"]);
		$map_aktif=trim(@$_POST["map_aktif"]);
		$map_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$map_aktif);
		$map_aktif=str_replace("'", "''",$map_aktif);
		$map_author=@$_SESSION[SESSION_USERID];
		$map_date_create=date(LONG_FORMATDATE);
		//$map_update=NULL;
		//$map_date_update=NULL;
		//$map_revised=0;
		$result=$this->m_akun_map->akun_map_create($map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create );
		echo $result;
	}
	
	
	//function for update record
	function akun_map_update(){
		//POST variable here
		$map_id=trim(@$_POST["map_id"]);
		$map_kategori=trim(@$_POST["map_kategori"]);
		$map_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$map_kategori);
		$map_kategori=str_replace("'", "''",$map_kategori);
		$map_nama=trim(@$_POST["map_nama"]);
		$map_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$map_nama);
		$map_nama=str_replace("'", "''",$map_nama);
		$map_akun=trim(@$_POST["map_akun"]);
		$map_akun_kode=trim(@$_POST["map_akun_kode"]);
		$map_aktif=trim(@$_POST["map_aktif"]);
		$map_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$map_aktif);
		$map_aktif=str_replace("'", "''",$map_aktif);
		//$map_author="map_author";
		//$map_date_create="map_date_create";
		$map_update=@$_SESSION[SESSION_USERID];
		$map_date_update=date(LONG_FORMATDATE);
		//$map_revised="(revised+1)";
		$result = $this->m_akun_map->akun_map_update($map_id,$map_kategori,$map_nama,$map_akun,$map_akun_kode,$map_aktif,$map_update,$map_date_update);
		echo $result;
	}
	
	//function for delete selected record
	function akun_map_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_akun_map->akun_map_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function akun_map_search(){
		//POST varibale here
		$map_id=trim(@$_POST["map_id"]);
		$map_kategori=trim(@$_POST["map_kategori"]);
		$map_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$map_kategori);
		$map_kategori=str_replace("'", "''",$map_kategori);
		$map_nama=trim(@$_POST["map_nama"]);
		$map_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$map_nama);
		$map_nama=str_replace("'", "''",$map_nama);
		$map_akun=trim(@$_POST["map_akun"]);
		$map_akun_kode=trim(@$_POST["map_akun_kode"]);
		$map_aktif=trim(@$_POST["map_aktif"]);
		$map_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$map_aktif);
		$map_aktif=str_replace("'", "''",$map_aktif);
		$map_author=trim(@$_POST["map_author"]);
		$map_author=str_replace("/(<\/?)(p)([^>]*>)", "",$map_author);
		$map_author=str_replace("'", "''",$map_author);
		$map_date_create=trim(@$_POST["map_date_create"]);
		$map_update=trim(@$_POST["map_update"]);
		$map_update=str_replace("/(<\/?)(p)([^>]*>)", "",$map_update);
		$map_update=str_replace("'", "''",$map_update);
		$map_date_update=trim(@$_POST["map_date_update"]);
		$map_revised=trim(@$_POST["map_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_akun_map->akun_map_search($map_id ,$map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ,$map_update ,$map_date_update ,$map_revised ,$start,$end);
		echo $result;
	}


	function akun_map_print(){
  		//POST varibale here
		$map_id=trim(@$_POST["map_id"]);
		$map_kategori=trim(@$_POST["map_kategori"]);
		$map_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$map_kategori);
		$map_kategori=str_replace("'", "'",$map_kategori);
		$map_nama=trim(@$_POST["map_nama"]);
		$map_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$map_nama);
		$map_nama=str_replace("'", "'",$map_nama);
		$map_akun=trim(@$_POST["map_akun"]);
		$map_akun_kode=trim(@$_POST["map_akun_kode"]);
		$map_aktif=trim(@$_POST["map_aktif"]);
		$map_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$map_aktif);
		$map_aktif=str_replace("'", "'",$map_aktif);
		$map_author=trim(@$_POST["map_author"]);
		$map_author=str_replace("/(<\/?)(p)([^>]*>)", "",$map_author);
		$map_author=str_replace("'", "'",$map_author);
		$map_date_create=trim(@$_POST["map_date_create"]);
		$map_update=trim(@$_POST["map_update"]);
		$map_update=str_replace("/(<\/?)(p)([^>]*>)", "",$map_update);
		$map_update=str_replace("'", "'",$map_update);
		$map_date_update=trim(@$_POST["map_date_update"]);
		$map_revised=trim(@$_POST["map_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_akun_map->akun_map_print($map_id ,$map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ,$map_update ,$map_date_update ,$map_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_akun_map.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/akun_map_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function akun_map_export_excel(){
		//POST varibale here
		$map_id=trim(@$_POST["map_id"]);
		$map_kategori=trim(@$_POST["map_kategori"]);
		$map_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$map_kategori);
		$map_kategori=str_replace("'", "\'",$map_kategori);
		$map_nama=trim(@$_POST["map_nama"]);
		$map_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$map_nama);
		$map_nama=str_replace("'", "\'",$map_nama);
		$map_akun=trim(@$_POST["map_akun"]);
		$map_akun_kode=trim(@$_POST["map_akun_kode"]);
		$map_aktif=trim(@$_POST["map_aktif"]);
		$map_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$map_aktif);
		$map_aktif=str_replace("'", "\'",$map_aktif);
		$map_author=trim(@$_POST["map_author"]);
		$map_author=str_replace("/(<\/?)(p)([^>]*>)", "",$map_author);
		$map_author=str_replace("'", "\'",$map_author);
		$map_date_create=trim(@$_POST["map_date_create"]);
		$map_update=trim(@$_POST["map_update"]);
		$map_update=str_replace("/(<\/?)(p)([^>]*>)", "",$map_update);
		$map_update=str_replace("'", "\'",$map_update);
		$map_date_update=trim(@$_POST["map_date_update"]);
		$map_revised=trim(@$_POST["map_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_akun_map->akun_map_export_excel($map_id ,$map_kategori ,$map_nama ,$map_akun ,$map_akun_kode ,$map_aktif ,$map_author ,$map_date_create ,$map_update ,$map_date_update ,$map_revised ,$option,$filter);
		
		to_excel($query,"akun_map"); 
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