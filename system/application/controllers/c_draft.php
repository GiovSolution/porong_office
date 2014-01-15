<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: draft Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_draft.php
 	+ creator  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

//class of draft
class C_draft extends Controller {

	//constructor
	function C_draft(){
		parent::Controller();
		session_start();
		$this->load->model('m_draft', '', TRUE);
		$this->load->model('m_phonegroup', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_draft');
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
				$this->draft_list();
				break;
			case "UPDATE":
				$this->draft_update();
				break;
			case "CREATE":
				$this->draft_create();
				break;
			case "DELETE":
				$this->draft_delete();
				break;
			case "SEARCH":
				$this->draft_search();
				break;
			case "PRINT":
				$this->draft_print();
				break;
			case "EXCEL":
				$this->draft_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function draft_save(){
		$idraft_id = (isset($_POST['idraft_id']) ? @$_POST['idraft_id'] : @$_GET['idraft_id']);
		$idraft_dest = (isset($_POST['idraft_dest']) ? @$_POST['idraft_dest'] : @$_GET['idraft_dest']);
		$idraft_isi = (isset($_POST['idraft_isi']) ? @$_POST['idraft_isi'] : @$_GET['idraft_isi']);
		$idraft_opsi = (isset($_POST['idraft_opsi']) ? @$_POST['idraft_opsi'] : @$_GET['idraft_opsi']);
		$idraft_task = (isset($_POST['idraft_task']) ? @$_POST['idraft_task'] : @$_GET['idraft_task']);
		$idraft_jnsklm = (isset($_POST['idraft_jnsklm']) ? @$_POST['idraft_jnsklm'] : @$_GET['idraft_jnsklm']);
		$idraft_ultah = (isset($_POST['idraft_ultah']) ? @$_POST['idraft_ultah'] : @$_GET['idraft_ultah']);
		$idraft_crm = (isset($_POST['idraft_crm']) ? @$_POST['idraft_crm'] : @$_GET['idraft_crm']);
		if($idraft_task=="send"){
			$result=$this->m_phonegroup->sms_save($idraft_dest,$idraft_isi,$idraft_opsi,$idraft_task, $idraft_jnsklm, $idraft_ultah, $idraft_crm);
//			$result=$this->m_draft->draft_delete($idraft_id);
		}else{
			$draft_date=date('Y/m/d H:i:s');
			$draft_update=$_SESSION[SESSION_USERID];
			$draft_date_update=date("Y/m/d H:i:s");
			$result = $this->m_draft->draft_update($idraft_id,$idraft_dest,$idraft_isi,$idraft_opsi,$idraft_task,$draft_update,$draft_date_update);
		}
		echo $result;
	}
	
	//function fot list record
	function draft_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_draft->draft_list($query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function draft_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$draft_destination=trim(@$_POST["draft_destination"]);
		$draft_destination=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_destination);
		$draft_destination=str_replace("'", "''",$draft_destination);
		$draft_message=trim(@$_POST["draft_message"]);
		$draft_message=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_message);
		$draft_message=str_replace("'", "''",$draft_message);
		$draft_date=trim(@$_POST["draft_date"]);
		$draft_creator=@$_SESSION[SESSION_USERID];
		$draft_date_create=date('m/d/Y');
		//$draft_update=NULL;
		//$draft_date_update=NULL;
		//$draft_revised=0;
		$result=$this->m_draft->draft_create($draft_destination ,$draft_message ,$draft_date ,$draft_creator ,$draft_date_create );
		echo $result;
	}
	
	
	//function for update record
	function draft_update(){
		//POST variable here
		$draft_id=trim(@$_POST["draft_id"]);
		$draft_destination=trim(@$_POST["draft_destination"]);
		$draft_destination=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_destination);
		$draft_destination=str_replace("'", "''",$draft_destination);
		$draft_message=trim(@$_POST["draft_message"]);
		$draft_message=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_message);
		$draft_message=str_replace("'", "''",$draft_message);
		$draft_date=trim(@$_POST["draft_date"]);
		//$draft_creator="draft_creator";
		//$draft_date_create="draft_date_create";
		$draft_update=@$_SESSION[SESSION_USERID];
		$draft_date_update=date('m/d/Y');
		//$draft_revised="(revised+1)";
		$result = $this->m_draft->draft_update($draft_id,$draft_destination,$draft_message,$draft_date,$draft_update,$draft_date_update);
		echo $result;
	}
	
	//function for delete selected record
	function draft_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_draft->draft_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function draft_search(){
		//POST varibale here
		$draft_id=trim(@$_POST["draft_id"]);
		$draft_destnama=trim(@$_POST["draft_destnama"]);
		$draft_destnama=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_destnama);
		$draft_destnama=str_replace("'", "''",$draft_destnama);
		$draft_jenis=trim(@$_POST["draft_jenis"]);
		$draft_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_jenis);
		$draft_jenis=str_replace("'", "''",$draft_jenis);
		$draft_message=trim(@$_POST["draft_message"]);
		$draft_message=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_message);
		$draft_message=str_replace("'", "''",$draft_message);
		$draft_date=trim(@$_POST["draft_date"]);
		$draft_creator=trim(@$_POST["draft_creator"]);
		$draft_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_creator);
		$draft_creator=str_replace("'", "''",$draft_creator);
		$draft_date_create=trim(@$_POST["draft_date_create"]);
		$draft_update=trim(@$_POST["draft_update"]);
		$draft_update=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_update);
		$draft_update=str_replace("'", "''",$draft_update);
		$draft_date_update=trim(@$_POST["draft_date_update"]);
		$draft_revised=trim(@$_POST["draft_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$result = $this->m_draft->draft_search($draft_id ,$draft_destnama, $draft_jenis,$draft_message ,$draft_date ,$draft_creator ,
											   $draft_date_create ,$draft_update ,$draft_date_update ,$draft_revised ,$start,$end);
		echo $result;
	}


	function draft_print(){
  		//POST varibale here
		$draft_id=trim(@$_POST["draft_id"]);
		$draft_destnama=trim(@$_POST["draft_destnama"]);
		$draft_destnama=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_destnama);
		$draft_destnama=str_replace("'", "''",$draft_destnama);
		$draft_jenis=trim(@$_POST["draft_jenis"]);
		$draft_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_jenis);
		$draft_jenis=str_replace("'", "''",$draft_jenis);
		$draft_message=trim(@$_POST["draft_message"]);
		$draft_message=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_message);
		$draft_message=str_replace("'", "'",$draft_message);
		$draft_date=trim(@$_POST["draft_date"]);
		$draft_creator=trim(@$_POST["draft_creator"]);
		$draft_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_creator);
		$draft_creator=str_replace("'", "'",$draft_creator);
		$draft_date_create=trim(@$_POST["draft_date_create"]);
		$draft_update=trim(@$_POST["draft_update"]);
		$draft_update=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_update);
		$draft_update=str_replace("'", "'",$draft_update);
		$draft_date_update=trim(@$_POST["draft_date_update"]);
		$draft_revised=trim(@$_POST["draft_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_draft->draft_print($draft_id ,$draft_destnama, $draft_jenis ,$draft_message ,$draft_date ,$draft_creator ,
														  $draft_date_create ,$draft_update ,$draft_date_update ,$draft_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_draft.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/draft_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function draft_export_excel(){
		//POST varibale here
		$draft_id=trim(@$_POST["draft_id"]);
		$draft_destnama=trim(@$_POST["draft_destnama"]);
		$draft_destnama=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_destnama);
		$draft_destnama=str_replace("'", "''",$draft_destnama);
		$draft_jenis=trim(@$_POST["draft_jenis"]);
		$draft_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_jenis);
		$draft_jenis=str_replace("'", "''",$draft_jenis);
		$draft_message=trim(@$_POST["draft_message"]);
		$draft_message=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_message);
		$draft_message=str_replace("'", "''",$draft_message);
		$draft_date=trim(@$_POST["draft_date"]);
		$draft_creator=trim(@$_POST["draft_creator"]);
		$draft_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_creator);
		$draft_creator=str_replace("'", "''",$draft_creator);
		$draft_date_create=trim(@$_POST["draft_date_create"]);
		$draft_update=trim(@$_POST["draft_update"]);
		$draft_update=str_replace("/(<\/?)(p)([^>]*>)", "",$draft_update);
		$draft_update=str_replace("'", "''",$draft_update);
		$draft_date_update=trim(@$_POST["draft_date_update"]);
		$draft_revised=trim(@$_POST["draft_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_draft->draft_export_excel($draft_id ,$draft_destnama, $draft_jenis ,$draft_message ,$draft_date ,$draft_creator ,
													$draft_date_create ,$draft_update ,$draft_date_update ,$draft_revised ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"draft"); 
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