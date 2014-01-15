<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: permissions Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_permissions.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of permissions
class C_permissions extends Controller {

	//constructor
	function C_permissions(){
		parent::Controller();
		$this->load->model('m_permissions', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_permissions');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->permissions_list();
				break;
			case "UPDATE":
				$this->permissions_update();
				break;
			case "CREATE":
				$this->permissions_create();
				break;
			case "DELETE":
				$this->permissions_delete();
				break;
			case "SEARCH":
				$this->permissions_search();
				break;
			case "PRINT":
				$this->permissions_print();
				break;
			case "EXCEL":
				$this->permissions_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function permissions_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_permissions->permissions_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function permissions_update(){
		//POST variable here
		$perm_group=trim(@$_POST["perm_group"]);
		$perm_menu=trim(@$_POST["perm_menu"]);
		$perm_priv=trim(@$_POST["perm_priv"]);
		$perm_priv=str_replace("/(<\/?)(p)([^>]*>)", "",$perm_priv);
		$perm_priv=str_replace("'", '"',$perm_priv);
		$result = $this->m_permissions->permissions_update($perm_group ,$perm_menu ,$perm_priv );
		echo $result;
	}
	
	//function for create new record
	function permissions_create(){
		//POST varible here
		$perm_group=trim(@$_POST["perm_group"]);
		$perm_menu=trim(@$_POST["perm_menu"]);
		$perm_priv=trim(@$_POST["perm_priv"]);
		$perm_priv=str_replace("/(<\/?)(p)([^>]*>)", "",$perm_priv);
		$perm_priv=str_replace("'", '"',$perm_priv);
		$result=$this->m_permissions->permissions_create($perm_group ,$perm_menu ,$perm_priv );
		echo $result;
	}

	//function for delete selected record
	function permissions_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_permissions->permissions_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function permissions_search(){
		//POST varibale here
		$perm_group=trim(@$_POST["perm_group"]);
		$perm_menu=trim(@$_POST["perm_menu"]);
		$perm_priv=trim(@$_POST["perm_priv"]);
		$perm_priv=str_replace("/(<\/?)(p)([^>]*>)", "",$perm_priv);
		$perm_priv=str_replace("'", '"',$perm_priv);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_permissions->permissions_search($perm_group ,$perm_menu ,$perm_priv ,$start,$end);
		echo $result;
	}


	function permissions_print(){
  		//POST varibale here
		$perm_group=trim(@$_POST["perm_group"]);
		$perm_menu=trim(@$_POST["perm_menu"]);
		$perm_priv=trim(@$_POST["perm_priv"]);
		$perm_priv=str_replace("/(<\/?)(p)([^>]*>)", "",$perm_priv);
		$perm_priv=str_replace("'", '"',$perm_priv);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_permissions->permissions_print($perm_group ,$perm_menu ,$perm_priv ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=3;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("permissionslist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Permissions Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Permissions List'><caption>PERMISSIONS</caption><thead><tr><th scope='col'>Perm Group</th><th scope='col'>Perm Menu</th><th scope='col'>Perm Priv</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Permissions</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['perm_group']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['perm_menu']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['perm_priv']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function permissions_export_excel(){
		//POST varibale here
		$perm_group=trim(@$_POST["perm_group"]);
		$perm_menu=trim(@$_POST["perm_menu"]);
		$perm_priv=trim(@$_POST["perm_priv"]);
		$perm_priv=str_replace("/(<\/?)(p)([^>]*>)", "",$perm_priv);
		$perm_priv=str_replace("'", '"',$perm_priv);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_permissions->permissions_export_excel($perm_group ,$perm_menu ,$perm_priv ,$option,$filter);
		
		to_excel($query,"permissions"); 
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