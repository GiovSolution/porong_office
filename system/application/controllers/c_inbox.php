<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: inbox Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_inbox.php
 	+ creator  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

//class of inbox
class C_inbox extends Controller {

	//constructor
	function C_inbox(){
		parent::Controller();
		session_start();
		$this->load->model('m_inbox', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_inbox');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->inbox_list();
				break;
			case "UPDATE":
				$this->inbox_update();
				break;
			case "CREATE":
				$this->inbox_create();
				break;
			case "DELETE":
				$this->inbox_delete();
				break;
			case "SEARCH":
				$this->inbox_search();
				break;
			case "PRINT":
				$this->inbox_print();
				break;
			case "EXCEL":
				$this->inbox_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function inbox_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_inbox->inbox_list($query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function inbox_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$SenderNumber=trim(@$_POST["SenderNumber"]);
		$SenderNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$SenderNumber);
		$SenderNumber=str_replace("'", "''",$SenderNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$inbox_status=trim(@$_POST["inbox_status"]);
		$inbox_status=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_status);
		$inbox_status=str_replace("'", "''",$inbox_status);
		$inbox_date=trim(@$_POST["inbox_date"]);
		$inbox_creator=@$_SESSION[SESSION_USERID];
		$inbox_date_create=date('m/d/Y');
		//$inbox_update=NULL;
		//$inbox_date_update=NULL;
		//$inbox_revised=0;
		$result=$this->m_inbox->inbox_create($SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create,$inbox_status );
		echo $result;
	}
	
	function inbox_save(){
		$result=0;
		$inbox_pengirim 	= (isset($_POST['inbox_pengirim']) ? @$_POST['inbox_pengirim'] : @$_GET['inbox_pengirim']);
		$inbox_isi 		= (isset($_POST['inbox_isi']) ? @$_POST['inbox_isi'] : @$_GET['inbox_isi']);
		$inbox_task 	= (isset($_POST['inbox_task']) ? @$_POST['inbox_task'] : @$_GET['inbox_task']);
		$inbox_id=trim(@$_POST["inbox_id"]);
		
		$inbox_isi=htmlspecialchars($inbox_isi,ENT_QUOTES);
		
		$result=$this->m_inbox->inbox_save($inbox_pengirim,$inbox_isi,$inbox_task,$inbox_id);
		
		echo $result;
	}
	
	//function for update record
	function inbox_update(){
		//POST variable here
		$inbox_id=trim(@$_POST["inbox_id"]);
		$SenderNumber=trim(@$_POST["SenderNumber"]);
		$SenderNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$SenderNumber);
		$SenderNumber=str_replace("'", "''",$SenderNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$inbox_status=trim(@$_POST["inbox_status"]);
		$inbox_status=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_status);
		$inbox_status=str_replace("'", "''",$inbox_status);
		$inbox_date=trim(@$_POST["inbox_date"]);
		//$inbox_creator="inbox_creator";
		//$inbox_date_create="inbox_date_create";
		$inbox_update=@$_SESSION[SESSION_USERID];
		$inbox_date_update=date('m/d/Y');
		//$inbox_revised="(revised+1)";
		$result = $this->m_inbox->inbox_update($inbox_id,$SenderNumber,$TextDecoded,$inbox_date,$inbox_update,$inbox_date_update,$inbox_status);
		echo $result;
	}
	
	//function for delete selected record
	function inbox_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_inbox->inbox_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function inbox_search(){
		//POST varibale here
		$inbox_id=trim(@$_POST["inbox_id"]);
		$SenderNumber=trim(@$_POST["SenderNumber"]);
		$SenderNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$SenderNumber);
		$SenderNumber=str_replace("'", "''",$SenderNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$inbox_date=trim(@$_POST["inbox_date"]);
		$inbox_creator=trim(@$_POST["inbox_creator"]);
		$inbox_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_creator);
		$inbox_creator=str_replace("'", "''",$inbox_creator);
		$inbox_date_create=trim(@$_POST["inbox_date_create"]);
		$inbox_update=trim(@$_POST["inbox_update"]);
		$inbox_update=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_update);
		$inbox_update=str_replace("'", "''",$inbox_update);
		$inbox_date_update=trim(@$_POST["inbox_date_update"]);
		$inbox_revised=trim(@$_POST["inbox_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_inbox->inbox_search($inbox_id ,$SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create ,
											   $inbox_update ,$inbox_date_update ,$inbox_revised ,$start,$end);
		echo $result;
	}


	function inbox_print(){
  		//POST varibale here
		$inbox_id=trim(@$_POST["inbox_id"]);
		$SenderNumber=trim(@$_POST["SenderNumber"]);
		$SenderNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$SenderNumber);
		$SenderNumber=str_replace("'", "'",$SenderNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "'",$TextDecoded);
		$inbox_date=trim(@$_POST["inbox_date"]);
		$inbox_creator=trim(@$_POST["inbox_creator"]);
		$inbox_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_creator);
		$inbox_creator=str_replace("'", "'",$inbox_creator);
		$inbox_date_create=trim(@$_POST["inbox_date_create"]);
		$inbox_update=trim(@$_POST["inbox_update"]);
		$inbox_update=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_update);
		$inbox_update=str_replace("'", "'",$inbox_update);
		$inbox_date_update=trim(@$_POST["inbox_date_update"]);
		$inbox_revised=trim(@$_POST["inbox_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_inbox->inbox_print($inbox_id ,$SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create ,
														  $inbox_update ,$inbox_date_update ,$inbox_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_inbox.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/inbox_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function inbox_export_excel(){
		//POST varibale here
		$inbox_id=trim(@$_POST["inbox_id"]);
		$SenderNumber=trim(@$_POST["SenderNumber"]);
		$SenderNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$SenderNumber);
		$SenderNumber=str_replace("'", "''",$SenderNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$inbox_date=trim(@$_POST["inbox_date"]);
		$inbox_creator=trim(@$_POST["inbox_creator"]);
		$inbox_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_creator);
		$inbox_creator=str_replace("'", "''",$inbox_creator);
		$inbox_date_create=trim(@$_POST["inbox_date_create"]);
		$inbox_update=trim(@$_POST["inbox_update"]);
		$inbox_update=str_replace("/(<\/?)(p)([^>]*>)", "",$inbox_update);
		$inbox_update=str_replace("'", "''",$inbox_update);
		$inbox_date_update=trim(@$_POST["inbox_date_update"]);
		$inbox_revised=trim(@$_POST["inbox_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_inbox->inbox_export_excel($inbox_id ,$SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create ,
													$inbox_update ,$inbox_date_update ,$inbox_revised ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"inbox"); 
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