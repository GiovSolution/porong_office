<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: menus Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_menus.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of menus
class C_menus extends Controller {

	//constructor
	function C_menus(){
		parent::Controller();
		$this->load->model('m_menus', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_menus');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->menus_list();
				break;
			case "UPDATE":
				$this->menus_update();
				break;
			case "CREATE":
				$this->menus_create();
				break;
			case "DELETE":
				$this->menus_delete();
				break;
			case "SEARCH":
				$this->menus_search();
				break;
			case "PRINT":
				$this->menus_print();
				break;
			case "EXCEL":
				$this->menus_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function menus_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_menus->menus_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function menus_update(){
		//POST variable here
		$menu_id=trim(@$_POST["menu_id"]);
		$menu_parent=trim(@$_POST["menu_parent"]);
		$menu_position=trim(@$_POST["menu_position"]);
		$menu_title=trim(@$_POST["menu_title"]);
		$menu_title=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_title);
		$menu_title=str_replace("'", '"',$menu_title);
		$menu_link=trim(@$_POST["menu_link"]);
		$menu_link=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_link);
		$menu_link=str_replace("'", '"',$menu_link);
		$menu_cat=trim(@$_POST["menu_cat"]);
		$menu_cat=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_cat);
		$menu_cat=str_replace("'", '"',$menu_cat);
		$menu_confirm=trim(@$_POST["menu_confirm"]);
		$menu_confirm=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_confirm);
		$menu_confirm=str_replace("'", '"',$menu_confirm);
		$menu_leftpanel=trim(@$_POST["menu_leftpanel"]);
		$menu_leftpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_leftpanel);
		$menu_leftpanel=str_replace("'", '"',$menu_leftpanel);
		$menu_iconpanel=trim(@$_POST["menu_iconpanel"]);
		$menu_iconpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconpanel);
		$menu_iconpanel=str_replace("'", '"',$menu_iconpanel);
		$menu_iconmenu=trim(@$_POST["menu_iconmenu"]);
		$menu_iconmenu=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconmenu);
		$menu_iconmenu=str_replace("'", '"',$menu_iconmenu);
		$result = $this->m_menus->menus_update($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu );
		echo $result;
	}
	
	//function for create new record
	function menus_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$menu_parent=trim(@$_POST["menu_parent"]);
		$menu_position=trim(@$_POST["menu_position"]);
		$menu_title=trim(@$_POST["menu_title"]);
		$menu_title=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_title);
		$menu_title=str_replace("'", '"',$menu_title);
		$menu_link=trim(@$_POST["menu_link"]);
		$menu_link=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_link);
		$menu_link=str_replace("'", '"',$menu_link);
		$menu_cat=trim(@$_POST["menu_cat"]);
		$menu_cat=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_cat);
		$menu_cat=str_replace("'", '"',$menu_cat);
		$menu_confirm=trim(@$_POST["menu_confirm"]);
		$menu_confirm=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_confirm);
		$menu_confirm=str_replace("'", '"',$menu_confirm);
		$menu_leftpanel=trim(@$_POST["menu_leftpanel"]);
		$menu_leftpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_leftpanel);
		$menu_leftpanel=str_replace("'", '"',$menu_leftpanel);
		$menu_iconpanel=trim(@$_POST["menu_iconpanel"]);
		$menu_iconpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconpanel);
		$menu_iconpanel=str_replace("'", '"',$menu_iconpanel);
		$menu_iconmenu=trim(@$_POST["menu_iconmenu"]);
		$menu_iconmenu=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconmenu);
		$menu_iconmenu=str_replace("'", '"',$menu_iconmenu);
		$result=$this->m_menus->menus_create($menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu );
		echo $result;
	}

	//function for delete selected record
	function menus_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_menus->menus_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function menus_search(){
		//POST varibale here
		$menu_id=trim(@$_POST["menu_id"]);
		$menu_parent=trim(@$_POST["menu_parent"]);
		$menu_position=trim(@$_POST["menu_position"]);
		$menu_title=trim(@$_POST["menu_title"]);
		$menu_title=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_title);
		$menu_title=str_replace("'", '"',$menu_title);
		$menu_link=trim(@$_POST["menu_link"]);
		$menu_link=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_link);
		$menu_link=str_replace("'", '"',$menu_link);
		$menu_cat=trim(@$_POST["menu_cat"]);
		$menu_cat=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_cat);
		$menu_cat=str_replace("'", '"',$menu_cat);
		$menu_confirm=trim(@$_POST["menu_confirm"]);
		$menu_confirm=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_confirm);
		$menu_confirm=str_replace("'", '"',$menu_confirm);
		$menu_leftpanel=trim(@$_POST["menu_leftpanel"]);
		$menu_leftpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_leftpanel);
		$menu_leftpanel=str_replace("'", '"',$menu_leftpanel);
		$menu_iconpanel=trim(@$_POST["menu_iconpanel"]);
		$menu_iconpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconpanel);
		$menu_iconpanel=str_replace("'", '"',$menu_iconpanel);
		$menu_iconmenu=trim(@$_POST["menu_iconmenu"]);
		$menu_iconmenu=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconmenu);
		$menu_iconmenu=str_replace("'", '"',$menu_iconmenu);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_menus->menus_search($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ,$start,$end);
		echo $result;
	}


	function menus_print(){
  		//POST varibale here
		$menu_id=trim(@$_POST["menu_id"]);
		$menu_parent=trim(@$_POST["menu_parent"]);
		$menu_position=trim(@$_POST["menu_position"]);
		$menu_title=trim(@$_POST["menu_title"]);
		$menu_title=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_title);
		$menu_title=str_replace("'", '"',$menu_title);
		$menu_link=trim(@$_POST["menu_link"]);
		$menu_link=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_link);
		$menu_link=str_replace("'", '"',$menu_link);
		$menu_cat=trim(@$_POST["menu_cat"]);
		$menu_cat=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_cat);
		$menu_cat=str_replace("'", '"',$menu_cat);
		$menu_confirm=trim(@$_POST["menu_confirm"]);
		$menu_confirm=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_confirm);
		$menu_confirm=str_replace("'", '"',$menu_confirm);
		$menu_leftpanel=trim(@$_POST["menu_leftpanel"]);
		$menu_leftpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_leftpanel);
		$menu_leftpanel=str_replace("'", '"',$menu_leftpanel);
		$menu_iconpanel=trim(@$_POST["menu_iconpanel"]);
		$menu_iconpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconpanel);
		$menu_iconpanel=str_replace("'", '"',$menu_iconpanel);
		$menu_iconmenu=trim(@$_POST["menu_iconmenu"]);
		$menu_iconmenu=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconmenu);
		$menu_iconmenu=str_replace("'", '"',$menu_iconmenu);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_menus->menus_print($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("menuslist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Menus Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Menus List'><caption>MENUS</caption><thead><tr><th scope='col'>Menu Id</th><th scope='col'>Menu Parent</th><th scope='col'>Menu Position</th><th scope='col'>Menu Title</th><th scope='col'>Menu Link</th><th scope='col'>Menu Cat</th><th scope='col'>Menu Confirm</th><th scope='col'>Menu Leftpanel</th><th scope='col'>Menu Iconpanel</th><th scope='col'>Menu Iconmenu</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Menus</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['menu_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['menu_parent']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_position']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_title']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_link']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_cat']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_confirm']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_leftpanel']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_iconpanel']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['menu_iconmenu']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function menus_export_excel(){
		//POST varibale here
		$menu_id=trim(@$_POST["menu_id"]);
		$menu_parent=trim(@$_POST["menu_parent"]);
		$menu_position=trim(@$_POST["menu_position"]);
		$menu_title=trim(@$_POST["menu_title"]);
		$menu_title=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_title);
		$menu_title=str_replace("'", '"',$menu_title);
		$menu_link=trim(@$_POST["menu_link"]);
		$menu_link=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_link);
		$menu_link=str_replace("'", '"',$menu_link);
		$menu_cat=trim(@$_POST["menu_cat"]);
		$menu_cat=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_cat);
		$menu_cat=str_replace("'", '"',$menu_cat);
		$menu_confirm=trim(@$_POST["menu_confirm"]);
		$menu_confirm=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_confirm);
		$menu_confirm=str_replace("'", '"',$menu_confirm);
		$menu_leftpanel=trim(@$_POST["menu_leftpanel"]);
		$menu_leftpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_leftpanel);
		$menu_leftpanel=str_replace("'", '"',$menu_leftpanel);
		$menu_iconpanel=trim(@$_POST["menu_iconpanel"]);
		$menu_iconpanel=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconpanel);
		$menu_iconpanel=str_replace("'", '"',$menu_iconpanel);
		$menu_iconmenu=trim(@$_POST["menu_iconmenu"]);
		$menu_iconmenu=str_replace("/(<\/?)(p)([^>]*>)", "",$menu_iconmenu);
		$menu_iconmenu=str_replace("'", '"',$menu_iconmenu);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_menus->menus_export_excel($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ,$option,$filter);
		
		to_excel($query,"menus"); 
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