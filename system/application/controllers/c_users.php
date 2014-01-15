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
class C_users extends Controller {

	//constructor
	function C_users(){
		parent::Controller();
		session_start();
		$this->load->model('m_users', '', TRUE);
	}
	
	function get_usergroups_list(){
		$result = $this->m_public_function->get_usergroups_list();
		echo $result;
	}
	
	function get_group_list(){
		$result = $this->m_public_function->get_group_list();
		echo $result;
	}
	
	function get_karyawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_public_function->get_user_karyawan_nolist($query,$start,$end);
		echo $result;
	}
	
	function get_user_karyawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_public_function->get_user_karyawan_list($query,$start,$end);
		echo $result;
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_users');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->users_list();
				break;
			case "UPDATE":
				$this->users_update();
				break;
			case "CREATE":
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
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function users_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);

		$result=$this->m_users->users_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function users_update(){
		//POST variable here
		$user_id=trim(@$_POST["user_id"]);
		$user_name=trim(@$_POST["user_name"]);
		$user_name=str_replace("/(<\/?)(p)([^>]*>)", "",$user_name);
		$user_name=str_replace("'", '"',$user_name);
		$user_passwd=trim(@$_POST["user_passwd"]);
		$user_passwd=str_replace("/(<\/?)(p)([^>]*>)", "",$user_passwd);
		$user_passwd=str_replace("'", '"',$user_passwd);
		$user_karyawan=trim(@$_POST["user_karyawan"]);
		//$user_log=trim(@$_POST["user_log"]);
		$user_groups=trim(@$_POST["user_groups"]);
		$user_aktif=trim(@$_POST["user_aktif"]);
		$user_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$user_aktif);
		$user_aktif=str_replace("'", '"',$user_aktif);
		//$result = $this->m_users->users_update($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif );
		$result = $this->m_users->users_update($user_id, $user_name, $user_passwd, $user_karyawan, $user_groups, $user_aktif );
		echo $result;
	}
	
	//function for create new record
	function users_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$user_name=trim(@$_POST["user_name"]);
		$user_name=str_replace("/(<\/?)(p)([^>]*>)", "",$user_name);
		$user_name=str_replace("'", '"',$user_name);
		$user_passwd=trim(@$_POST["user_passwd"]);
		$user_passwd=str_replace("/(<\/?)(p)([^>]*>)", "",$user_passwd);
		$user_passwd=str_replace("'", '"',$user_passwd);
		$user_karyawan=trim(@$_POST["user_karyawan"]);
		$user_log=trim(@$_POST["user_log"]);
		$user_groups=trim(@$_POST["user_groups"]);
		$user_aktif=trim(@$_POST["user_aktif"]);
		$user_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$user_aktif);
		$user_aktif=str_replace("'", '"',$user_aktif);
		$result=$this->m_users->users_create($user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif );
		echo $result;
	}

	//function for delete selected record
	function users_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_users->users_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function users_search(){
		//POST varibale here
		$user_id=trim(@$_POST["user_id"]);
		$user_name=trim(@$_POST["user_name"]);
		$user_name=str_replace("/(<\/?)(p)([^>]*>)", "",$user_name);
		$user_name=str_replace("'", '"',$user_name);
		$user_karyawan=trim(@$_POST["user_karyawan"]);
		$user_log=trim(@$_POST["user_log"]);
		$user_groups=trim(@$_POST["user_groups"]);
		$user_aktif=trim(@$_POST["user_aktif"]);
		$user_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$user_aktif);
		$user_aktif=str_replace("'", '"',$user_aktif);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_users->users_search($user_id ,$user_name ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$start,$end);
		echo $result;
	}


	function users_print(){
  		//POST varibale here
		$user_id=trim(@$_POST["user_id"]);
		$user_name=trim(@$_POST["user_name"]);
		$user_name=str_replace("/(<\/?)(p)([^>]*>)", "",$user_name);
		$user_name=str_replace("'", '"',$user_name);
		$user_karyawan=trim(@$_POST["user_karyawan"]);
		$user_log=trim(@$_POST["user_log"]);
		$user_groups=trim(@$_POST["user_groups"]);
		$user_aktif=trim(@$_POST["user_aktif"]);
		$user_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$user_aktif);
		$user_aktif=str_replace("'", '"',$user_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_users->users_print($user_id ,$user_name ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=4;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("userslist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Users Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'>
					   <table summary='Users List'>
					   <caption>Daftar User</caption>
					   	<thead>
							<tr>
								<th scope='col'>No</th>
								<th scope='col'>Username</th>
								<th scope='col'>Nama Karyawan</th>
								<th scope='col'>Group</th>
								<th scope='col'>Aktif</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th scope='row'>Total</th>
								<td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " User</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				$i++;
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
				
				fwrite($file, "><td>");
				fwrite($file, $i);
				fwrite($file, "</td><td>");
				fwrite($file, $data['user_name']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_name']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['user_aktif']);
				fwrite($file, "</td></tr>");
				
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function users_export_excel(){
		//POST varibale here
		$user_id=trim(@$_POST["user_id"]);
		$user_name=trim(@$_POST["user_name"]);
		$user_name=str_replace("/(<\/?)(p)([^>]*>)", "",$user_name);
		$user_name=str_replace("'", '"',$user_name);
		$user_karyawan=trim(@$_POST["user_karyawan"]);
		$user_log=trim(@$_POST["user_log"]);
		$user_groups=trim(@$_POST["user_groups"]);
		$user_aktif=trim(@$_POST["user_aktif"]);
		$user_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$user_aktif);
		$user_aktif=str_replace("'", '"',$user_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_users->users_export_excel($user_id ,$user_name ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"users"); 
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
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>