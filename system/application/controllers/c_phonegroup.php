<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: phonegroup Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_phonegroup.php
 	+ creator  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

//class of phonegroup
class C_phonegroup extends Controller {

	//constructor
	function C_phonegroup(){
		parent::Controller();
		session_start();
		$this->load->model('m_phonegroup', '', TRUE);
	}
	
	//set index
	function index(){
		
		$this->load->helper('asset');
		$this->load->view('main/v_phonegroup');
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
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->phonegroup_list();
				break;
			case "UPDATE":
				$this->phonegroup_update();
				break;
			case "CREATE":
				$this->phonegroup_create();
				break;
			case "LIST2":
				$this->phonegrouped_list();
				break;
			case "DELETE":
				$this->phonegroup_delete();
				break;
			case "DELETEDETAIL":
				$this->detail_phonegroup_delete();
				break;
			case "SEARCH":
				$this->phonegroup_search();
				break;
			case "PRINT":
				$this->phonegroup_print();
				break;
			case "EXCEL":
				$this->phonegroup_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function get_available(){
		$id=isset($_POST['id']) ? @$_POST['id'] : "";
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		// SEARCH
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$umur = isset($_POST['umur']) ? @$_POST['umur'] : @$_GET['umur'];
		$agama = isset($_POST['agama']) ? @$_POST['agama'] : @$_GET['agama'];
		$kota = isset($_POST['kota']) ? @$_POST['kota'] : @$_GET['kota'];
		$propinsi = isset($_POST['propinsi']) ? @$_POST['propinsi'] : @$_GET['propinsi'];
		$pendidikan = isset($_POST['pendidikan']) ? @$_POST['pendidikan'] : @$_GET['pendidikan'];
		$kelamin = isset($_POST['kelamin']) ? @$_POST['kelamin'] : @$_GET['kelamin'];
		$profesi = isset($_POST['profesi']) ? @$_POST['profesi'] : @$_GET['profesi'];
		$hobi = isset($_POST['hobi']) ? @$_POST['hobi'] : @$_GET['hobi'];
		$stsnikah = isset($_POST['stsnikah']) ? @$_POST['stsnikah'] : @$_GET['stsnikah'];
		$priority = isset($_POST['priority']) ? @$_POST['priority'] : @$_GET['priority'];
		$unit = isset($_POST['unit']) ? @$_POST['unit'] : @$_GET['unit'];
		$aktif = isset($_POST['aktif']) ? @$_POST['aktif'] : @$_GET['aktif'];
		$no = isset($_POST['no']) ? @$_POST['no'] : @$_GET['no'];
		$nama = isset($_POST['nama']) ? @$_POST['nama'] : @$_GET['nama'];
		$group_id = isset($_POST['group_id']) ? @$_POST['group_id'] : @$_GET['group_id'];
		
		if($task=='search')
			$result=$this->m_phonegroup->get_cust_available($umur, $agama, $kota, $propinsi, $pendidikan, $kelamin, $profesi, $hobi, $stsnikah, 
															$priority, $unit, $aktif, $no, $nama, $group_id, $query,$start,$end);
		else
			$result=$this->m_phonegroup->get_available($query,$start,$end);
		echo $result;
	}
	
	
	function get_phonegrouped(){
		$id=isset($_POST['id']) ? @$_POST['id'] : "";
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_phonegroup->get_phonegrouped($id,$query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function phonegroup_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_phonegroup->phonegroup_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function phonegrouped_list(){
		
		//$query = isset($_POST['phonegrouped_group']) ? @$_POST['phonegrouped_group'] : "";
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_id=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_id);
		$phonegroup_id=str_replace("'", "''",$phonegroup_id);
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_phonegroup->phonegrouped_list($phonegroup_id,$query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function phonegroup_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$phonegroup_nama=trim(@$_POST["phonegroup_nama"]);
		$phonegroup_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_nama);
		$phonegroup_nama=str_replace("'", "''",$phonegroup_nama);
		$phonegroup_detail=trim(@$_POST["phonegroup_detail"]);
		$phonegroup_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_detail);
		$phonegroup_detail=str_replace("'", "''",$phonegroup_detail);
		$phonegroup_aktif=trim(@$_POST["phonegroup_aktif"]);
		$phonegroup_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_aktif);
		$phonegroup_aktif=str_replace("'", "''",$phonegroup_aktif);
		$phonegroup_creator=@$_SESSION[SESSION_USERID];
		$phonegroup_date_create=date('m/d/Y');
		//$phonegroup_update=NULL;
		//$phonegroup_date_update=NULL;
		//$phonegroup_revised=0;
		$phonegroup_data=@$_POST["phonegroup_data"];
		$result=$this->m_phonegroup->phonegroup_create($phonegroup_nama ,$phonegroup_detail , $phonegroup_aktif,$phonegroup_creator ,$phonegroup_date_create,
													   $phonegroup_data );
		echo $result;
	}
	
	function get_detail_phonegroup(){

		$phonegrouped_group = isset($_POST['phonegrouped_group']) ? $_POST['phonegrouped_group'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_phonegroup->get_detail_phonegroup($phonegrouped_group,$start,$end);
		echo $result;
	}
	
	//function for update record
	function phonegroup_update(){
		//POST variable here
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_nama=trim(@$_POST["phonegroup_nama"]);
		$phonegroup_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_nama);
		$phonegroup_nama=str_replace("'", "''",$phonegroup_nama);
		$phonegroup_detail=trim(@$_POST["phonegroup_detail"]);
		$phonegroup_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_detail);
		$phonegroup_detail=str_replace("'", "''",$phonegroup_detail);
		$phonegroup_aktif=trim(@$_POST["phonegroup_aktif"]);
		$phonegroup_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_aktif);
		$phonegroup_aktif=str_replace("'", "''",$phonegroup_aktif);
		//$phonegroup_creator="phonegroup_creator";
		//$phonegroup_date_create="phonegroup_date_create";
		$phonegroup_update=@$_SESSION[SESSION_USERID];
		$phonegroup_date_update=date('Y/m/d');
		//$phonegroup_revised="(revised+1)";
		$phonegroup_data=@$_POST["phonegroup_data"];
		$result = $this->m_phonegroup->phonegroup_update($phonegroup_id,$phonegroup_nama,$phonegroup_detail,$phonegroup_aktif,$phonegroup_update,
														 $phonegroup_date_update,$phonegroup_data);
		echo $result;
	}
	
	//function for delete selected record
	function phonegroup_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_phonegroup->phonegroup_delete($pkid);
		echo $result;
	}
	
	//function for delete selected record
	function detail_phonegroup_delete(){
		$ids2 = @$_POST['ids2']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids2));
		$result=$this->m_phonegroup->detail_phonegroup_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function phonegroup_search(){
		//POST varibale here
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_nama=trim(@$_POST["phonegroup_nama"]);
		$phonegroup_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_nama);
		$phonegroup_nama=str_replace("'", "''",$phonegroup_nama);
		$phonegroup_detail=trim(@$_POST["phonegroup_detail"]);
		$phonegroup_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_detail);
		$phonegroup_detail=str_replace("'", "''",$phonegroup_detail);
		$phonegroup_aktif=trim(@$_POST["phonegroup_aktif"]);
		$phonegroup_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_aktif);
		$phonegroup_aktif=str_replace("'", "''",$phonegroup_aktif);
		$phonegroup_creator=trim(@$_POST["phonegroup_creator"]);
		$phonegroup_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_creator);
		$phonegroup_creator=str_replace("'", "''",$phonegroup_creator);
		$phonegroup_date_create=trim(@$_POST["phonegroup_date_create"]);
		$phonegroup_update=trim(@$_POST["phonegroup_update"]);
		$phonegroup_update=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_update);
		$phonegroup_update=str_replace("'", "''",$phonegroup_update);
		$phonegroup_date_update=trim(@$_POST["phonegroup_date_update"]);
		$phonegroup_revised=trim(@$_POST["phonegroup_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_phonegroup->phonegroup_search($phonegroup_id ,$phonegroup_nama ,$phonegroup_detail ,$phonegroup_aktif,$phonegroup_creator ,
														 $phonegroup_date_create ,$phonegroup_update ,$phonegroup_date_update ,$phonegroup_revised ,
														 $start,$end);
		echo $result;
	}


	function phonegroup_print(){
  		//POST varibale here
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_nama=trim(@$_POST["phonegroup_nama"]);
		$phonegroup_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_nama);
		$phonegroup_nama=str_replace("'", "'",$phonegroup_nama);
		$phonegroup_detail=trim(@$_POST["phonegroup_detail"]);
		$phonegroup_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_detail);
		$phonegroup_detail=str_replace("'", "'",$phonegroup_detail);
		$phonegroup_aktif=trim(@$_POST["phonegroup_aktif"]);
		$phonegroup_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_aktif);
		$phonegroup_aktif=str_replace("'", "''",$phonegroup_aktif);
		$phonegroup_creator=trim(@$_POST["phonegroup_creator"]);
		$phonegroup_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_creator);
		$phonegroup_creator=str_replace("'", "'",$phonegroup_creator);
		$phonegroup_date_create=trim(@$_POST["phonegroup_date_create"]);
		$phonegroup_update=trim(@$_POST["phonegroup_update"]);
		$phonegroup_update=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_update);
		$phonegroup_update=str_replace("'", "'",$phonegroup_update);
		$phonegroup_date_update=trim(@$_POST["phonegroup_date_update"]);
		$phonegroup_revised=trim(@$_POST["phonegroup_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_phonegroup->phonegroup_print($phonegroup_id ,$phonegroup_nama ,$phonegroup_detail , $phonegroup_aktif,$phonegroup_creator ,
																	$phonegroup_date_create ,$phonegroup_update ,$phonegroup_date_update ,$phonegroup_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_phonegroup.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/phonegroup_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function phonegroup_export_excel(){
		//POST varibale here
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_nama=trim(@$_POST["phonegroup_nama"]);
		$phonegroup_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_nama);
		$phonegroup_nama=str_replace("'", "''",$phonegroup_nama);
		$phonegroup_detail=trim(@$_POST["phonegroup_detail"]);
		$phonegroup_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_detail);
		$phonegroup_detail=str_replace("'", "''",$phonegroup_detail);
		$phonegroup_aktif=trim(@$_POST["phonegroup_aktif"]);
		$phonegroup_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_aktif);
		$phonegroup_aktif=str_replace("'", "''",$phonegroup_aktif);
		$phonegroup_creator=trim(@$_POST["phonegroup_creator"]);
		$phonegroup_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_creator);
		$phonegroup_creator=str_replace("'", "''",$phonegroup_creator);
		$phonegroup_date_create=trim(@$_POST["phonegroup_date_create"]);
		$phonegroup_update=trim(@$_POST["phonegroup_update"]);
		$phonegroup_update=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_update);
		$phonegroup_update=str_replace("'", "''",$phonegroup_update);
		$phonegroup_date_update=trim(@$_POST["phonegroup_date_update"]);
		$phonegroup_revised=trim(@$_POST["phonegroup_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_phonegroup->phonegroup_export_excel($phonegroup_id ,$phonegroup_nama ,$phonegroup_detail ,$phonegroup_aktif,$phonegroup_creator ,
															  $phonegroup_date_create ,$phonegroup_update ,$phonegroup_date_update 
															  ,$phonegroup_revised ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"phonegroup"); 
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