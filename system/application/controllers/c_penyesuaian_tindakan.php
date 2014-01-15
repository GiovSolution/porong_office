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
class C_penyesuaian_tindakan extends Controller {

	//constructor
	function C_penyesuaian_tindakan(){
		parent::Controller();
		$this->load->model('m_penyesuaian_tindakan', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	/*function get_karyawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_public_function->get_user_karyawan_nolist($query,$start,$end);
		echo $result;
	}*/
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_penyesuaian_tindakan');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->penyesuaian_list();
				break;
			case "UPDATE":
				$this->penyesuaian_update();
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
	function penyesuaian_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_penyesuaian_tindakan->penyesuaian_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function penyesuaian_update(){
		//POST variable here
		$adj_id=trim(@$_POST["adj_id"]);
		$adj_count=trim(@$_POST["adj_count"]);
		$result = $this->m_penyesuaian_tindakan->penyesuaian_update($adj_id, $adj_count);
		echo $result;
	}


	/*function users_print(){
  		//POST varibale here
		$user_id=trim(@$_POST["user_id"]);
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
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_users->users_print($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=7;
   		/* We now have our array, let's build our HTML file 
		$file = fopen("userslist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Users Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body><table summary='Users List'><caption>USERS</caption><thead><tr><th scope='col'>User Id</th><th scope='col'>User Name</th><th scope='col'>User Passwd</th><th scope='col'>User Karyawan</th><th scope='col'>User Log</th><th scope='col'>User Groups</th><th scope='col'>User Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Users</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['user_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['user_name']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['user_passwd']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['user_karyawan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['user_log']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['user_groups']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['user_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}*/
	/* End Of Function */

	/* Function to Export Excel document */
	/*function users_export_excel(){
		//POST varibale here
		$user_id=trim(@$_POST["user_id"]);
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
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_users->users_export_excel($user_id ,$user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter);
		
		to_excel($query,"users"); 
		echo '1';	
	}*/
	
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