<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: usergroups Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_usergroups.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 17/Jul/2009 11:36:16
	
*/

//class of usergroups
class C_usergroups extends Controller {

	//constructor
	function C_usergroups(){
		session_start();
		parent::Controller();
		
		$this->load->model('m_usergroups', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_usergroups');
	}
	
	function permission_insert(){
		$menu_group = @$_POST['menu_group'];
		$menu_id = @$_POST['menu_id'];
		$menu_priv = @$_POST['menu_priv'];
		
		$menu_id = json_decode(stripslashes($menu_id));
		$menu_priv = json_decode(stripslashes($menu_priv));
		
		$result=$this->m_usergroups->permission_save($menu_group,$menu_id,$menu_priv);
		echo $result;
	}
		
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->usergroups_list();
				break;
			case "UPDATE":
				$this->usergroups_update();
				break;
			case "CREATE":
				$this->usergroups_create();
				break;
			case "DELETE":
				$this->usergroups_delete();
				break;
			case "SEARCH":
				$this->usergroups_search();
				break;
			case "PRINT":
				$this->usergroups_print();
				break;
			case "EXCEL":
				$this->usergroups_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
		
	
	//function fot list record
	function usergroups_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_usergroups->usergroups_list($query,$start,$end);
		echo $result;
	}

	function get_permission(){
		$group = (integer) (isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		$result=$this->m_usergroups->get_permission($group);
		echo $result;
	}
	
	//function for update record
	function usergroups_update(){
		//POST variable here
		$group_id=trim(@$_POST["group_id"]);
		$group_name=trim(@$_POST["group_name"]);
		$group_name=str_replace("/(<\/?)(p)([^>]*>)", "",$group_name);
		$group_name=str_replace("'", '"',$group_name);
		$group_desc=trim(@$_POST["group_desc"]);
		$group_desc=str_replace("/(<\/?)(p)([^>]*>)", "",$group_desc);
		$group_desc=str_replace("'", '"',$group_desc);
		$group_active=trim(@$_POST["group_active"]);
		$group_active=str_replace("/(<\/?)(p)([^>]*>)", "",$group_active);
		$group_active=str_replace("'", '"',$group_active);
		$result = $this->m_usergroups->usergroups_update($group_id ,$group_name ,$group_desc ,$group_active );
		echo $result;
	}
	
	//function for create new record
	function usergroups_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$group_name=trim(@$_POST["group_name"]);
		$group_name=str_replace("/(<\/?)(p)([^>]*>)", "",$group_name);
		$group_name=str_replace("'", '"',$group_name);
		$group_desc=trim(@$_POST["group_desc"]);
		$group_desc=str_replace("/(<\/?)(p)([^>]*>)", "",$group_desc);
		$group_desc=str_replace("'", '"',$group_desc);
		$group_active=trim(@$_POST["group_active"]);
		$group_active=str_replace("/(<\/?)(p)([^>]*>)", "",$group_active);
		$group_active=str_replace("'", '"',$group_active);
		$result=$this->m_usergroups->usergroups_create($group_name ,$group_desc ,$group_active );
		echo $result;
	}

	//function for delete selected record
	function usergroups_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_usergroups->usergroups_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function usergroups_search(){
		//POST varibale here
		$group_id=trim(@$_POST["group_id"]);
		$group_name=trim(@$_POST["group_name"]);
		$group_name=str_replace("/(<\/?)(p)([^>]*>)", "",$group_name);
		$group_name=str_replace("'", '"',$group_name);
		$group_desc=trim(@$_POST["group_desc"]);
		$group_desc=str_replace("/(<\/?)(p)([^>]*>)", "",$group_desc);
		$group_desc=str_replace("'", '"',$group_desc);
		$group_active=trim(@$_POST["group_active"]);
		$group_active=str_replace("/(<\/?)(p)([^>]*>)", "",$group_active);
		$group_active=str_replace("'", '"',$group_active);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_usergroups->usergroups_search($group_id ,$group_name ,$group_desc ,$group_active ,$start,$end);
		echo $result;
	}


	function usergroups_print(){
  		//POST varibale here
		$group_id=trim(@$_POST["group_id"]);
		$group_name=trim(@$_POST["group_name"]);
		$group_name=str_replace("/(<\/?)(p)([^>]*>)", "",$group_name);
		$group_name=str_replace("'", '"',$group_name);
		$group_desc=trim(@$_POST["group_desc"]);
		$group_desc=str_replace("/(<\/?)(p)([^>]*>)", "",$group_desc);
		$group_desc=str_replace("'", '"',$group_desc);
		$group_active=trim(@$_POST["group_active"]);
		$group_active=str_replace("/(<\/?)(p)([^>]*>)", "",$group_active);
		$group_active=str_replace("'", '"',$group_active);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_usergroups->usergroups_print($group_id ,$group_name ,$group_desc ,$group_active ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=3;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("usergroupslist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the User Groups s Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'>
			   <table summary='Usergroups List'>
			   <caption>Daftar User Group</caption>
			   	<thead>
					<tr>
						<th scope='col'>No</th>
						<th scope='col'>Nama Group</th>
						<th scope='col'>Keterangan</th>
						<th scope='col'>Aktif</th>
					</tr>
				</thead>
				<tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " user group</td></tr></tfoot><tbody>");
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
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_name']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_desc']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_active']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function usergroups_export_excel(){
		//POST varibale here
		$group_id=trim(@$_POST["group_id"]);
		$group_name=trim(@$_POST["group_name"]);
		$group_name=str_replace("/(<\/?)(p)([^>]*>)", "",$group_name);
		$group_name=str_replace("'", '"',$group_name);
		$group_desc=trim(@$_POST["group_desc"]);
		$group_desc=str_replace("/(<\/?)(p)([^>]*>)", "",$group_desc);
		$group_desc=str_replace("'", '"',$group_desc);
		$group_active=trim(@$_POST["group_active"]);
		$group_active=str_replace("/(<\/?)(p)([^>]*>)", "",$group_active);
		$group_active=str_replace("'", '"',$group_active);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_usergroups->usergroups_export_excel($group_id ,$group_name ,$group_desc ,$group_active ,$option,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"usergroups"); 
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