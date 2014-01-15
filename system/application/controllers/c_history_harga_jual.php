<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: history_harga_jual Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_history_harga_jual.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of history_harga_jual
class C_history_harga_jual extends Controller {

	//constructor
	function C_history_harga_jual(){
		parent::Controller();
		$this->load->model('m_history_harga_jual', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_history_harga_jual');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->history_harga_jual_list();
				break;
			case "UPDATE":
				$this->history_harga_jual_update();
				break;
			case "CREATE":
				$this->history_harga_jual_create();
				break;
			case "DELETE":
				$this->history_harga_jual_delete();
				break;
			case "SEARCH":
				$this->history_harga_jual_search();
				break;
			case "PRINT":
				$this->history_harga_jual_print();
				break;
			case "EXCEL":
				$this->history_harga_jual_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function history_harga_jual_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_history_harga_jual->history_harga_jual_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function history_harga_jual_update(){
		//POST variable here
		$hjual_no=trim(@$_POST["hjual_no"]);
		$hjual_no=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_no);
		$hjual_no=str_replace("'", '"',$hjual_no);
		$hjual_tanggal=trim(@$_POST["hjual_tanggal"]);
		$hjual_harga=trim(@$_POST["hjual_harga"]);
		$hjual_jenis=trim(@$_POST["hjual_jenis"]);
		$hjual_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_jenis);
		$hjual_jenis=str_replace("'", '"',$hjual_jenis);
		$hjual_update=trim(@$_POST["hjual_update"]);
		$hjual_update=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_update);
		$hjual_update=str_replace("'", '"',$hjual_update);
		$hjual_date_update=trim(@$_POST["hjual_date_update"]);
		$hjual_revised=trim(@$_POST["hjual_revised"]);
		$result = $this->m_history_harga_jual->history_harga_jual_update($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised );
		echo $result;
	}
	
	//function for create new record
	function history_harga_jual_create(){
		//POST varible here
		$hjual_no=trim(@$_POST["hjual_no"]);
		$hjual_no=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_no);
		$hjual_no=str_replace("'", '"',$hjual_no);
		$hjual_tanggal=trim(@$_POST["hjual_tanggal"]);
		$hjual_harga=trim(@$_POST["hjual_harga"]);
		$hjual_jenis=trim(@$_POST["hjual_jenis"]);
		$hjual_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_jenis);
		$hjual_jenis=str_replace("'", '"',$hjual_jenis);
		$hjual_update=trim(@$_POST["hjual_update"]);
		$hjual_update=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_update);
		$hjual_update=str_replace("'", '"',$hjual_update);
		$hjual_date_update=trim(@$_POST["hjual_date_update"]);
		$hjual_revised=trim(@$_POST["hjual_revised"]);
		$result=$this->m_history_harga_jual->history_harga_jual_create($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised );
		echo $result;
	}

	//function for delete selected record
	function history_harga_jual_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_history_harga_jual->history_harga_jual_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function history_harga_jual_search(){
		//POST varibale here
		$hjual_no=trim(@$_POST["hjual_no"]);
		$hjual_no=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_no);
		$hjual_no=str_replace("'", '"',$hjual_no);
		$hjual_tanggal=trim(@$_POST["hjual_tanggal"]);
		$hjual_harga=trim(@$_POST["hjual_harga"]);
		$hjual_jenis=trim(@$_POST["hjual_jenis"]);
		$hjual_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_jenis);
		$hjual_jenis=str_replace("'", '"',$hjual_jenis);
		$hjual_update=trim(@$_POST["hjual_update"]);
		$hjual_update=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_update);
		$hjual_update=str_replace("'", '"',$hjual_update);
		$hjual_date_update=trim(@$_POST["hjual_date_update"]);
		$hjual_revised=trim(@$_POST["hjual_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_history_harga_jual->history_harga_jual_search($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ,$start,$end);
		echo $result;
	}


	function history_harga_jual_print(){
  		//POST varibale here
		$hjual_no=trim(@$_POST["hjual_no"]);
		$hjual_no=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_no);
		$hjual_no=str_replace("'", '"',$hjual_no);
		$hjual_tanggal=trim(@$_POST["hjual_tanggal"]);
		$hjual_harga=trim(@$_POST["hjual_harga"]);
		$hjual_jenis=trim(@$_POST["hjual_jenis"]);
		$hjual_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_jenis);
		$hjual_jenis=str_replace("'", '"',$hjual_jenis);
		$hjual_update=trim(@$_POST["hjual_update"]);
		$hjual_update=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_update);
		$hjual_update=str_replace("'", '"',$hjual_update);
		$hjual_date_update=trim(@$_POST["hjual_date_update"]);
		$hjual_revised=trim(@$_POST["hjual_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_history_harga_jual->history_harga_jual_print($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=7;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("history_harga_juallist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the History_harga_jual Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='History_harga_jual List'><caption>HISTORY_HARGA_JUAL</caption><thead><tr><th scope='col'>Hjual No</th><th scope='col'>Hjual Tanggal</th><th scope='col'>Hjual Harga</th><th scope='col'>Hjual Jenis</th><th scope='col'>Hjual Update</th><th scope='col'>Hjual Date Update</th><th scope='col'>Hjual Revised</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " History_harga_jual</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['hjual_no']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['hjual_tanggal']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['hjual_harga']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['hjual_jenis']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['hjual_update']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['hjual_date_update']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['hjual_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function history_harga_jual_export_excel(){
		//POST varibale here
		$hjual_no=trim(@$_POST["hjual_no"]);
		$hjual_no=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_no);
		$hjual_no=str_replace("'", '"',$hjual_no);
		$hjual_tanggal=trim(@$_POST["hjual_tanggal"]);
		$hjual_harga=trim(@$_POST["hjual_harga"]);
		$hjual_jenis=trim(@$_POST["hjual_jenis"]);
		$hjual_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_jenis);
		$hjual_jenis=str_replace("'", '"',$hjual_jenis);
		$hjual_update=trim(@$_POST["hjual_update"]);
		$hjual_update=str_replace("/(<\/?)(p)([^>]*>)", "",$hjual_update);
		$hjual_update=str_replace("'", '"',$hjual_update);
		$hjual_date_update=trim(@$_POST["hjual_date_update"]);
		$hjual_revised=trim(@$_POST["hjual_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_history_harga_jual->history_harga_jual_export_excel($hjual_no ,$hjual_tanggal ,$hjual_harga ,$hjual_jenis ,$hjual_update ,$hjual_date_update ,$hjual_revised ,$option,$filter);
		
		to_excel($query,"history_harga_jual"); 
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