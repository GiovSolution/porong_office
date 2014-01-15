<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: alat Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_alat.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of alat
class C_alat extends Controller {

	//constructor
	function C_alat(){
		parent::Controller();
		session_start();
		$this->load->model('m_alat', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_alat');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->alat_list();
				break;
			case "UPDATE":
				$this->alat_update();
				break;
			case "CREATE":
				$this->alat_create();
				break;
			case "DELETE":
				$this->alat_delete();
				break;
			case "SEARCH":
				$this->alat_search();
				break;
			case "PRINT":
				$this->alat_print();
				break;
			case "EXCEL":
				$this->alat_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function alat_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_alat->alat_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function alat_update(){
		//POST variable here
		$alat_id=trim(@$_POST["alat_id"]);
		$alat_nama=trim(@$_POST["alat_nama"]);
		$alat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_nama);
		$alat_nama=str_replace("'", '"',$alat_nama);
		$alat_jumlah=trim(@$_POST["alat_jumlah"]);
		$alat_aktif=trim(@$_POST["alat_aktif"]);
		$alat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_aktif);
		$alat_aktif=str_replace("'", '"',$alat_aktif);
		$alat_creator=trim(@$_POST["alat_creator"]);
		$alat_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_creator);
		$alat_creator=str_replace("'", '"',$alat_creator);
		$alat_date_create=trim(@$_POST["alat_date_create"]);
		$alat_update=trim(@$_POST["alat_update"]);
		$alat_update=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_update);
		$alat_update=str_replace("'", '"',$alat_update);
		$alat_date_update=trim(@$_POST["alat_date_update"]);
		$alat_revised=trim(@$_POST["alat_revised"]);
		$result = $this->m_alat->alat_update($alat_id ,$alat_nama ,$alat_jumlah,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised );
		echo $result;
	}
	
	//function for create new record
	function alat_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$alat_nama=trim(@$_POST["alat_nama"]);
		$alat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_nama);
		$alat_nama=str_replace("'", '"',$alat_nama);
		$alat_jumlah=trim(@$_POST["alat_jumlah"]);
		$alat_aktif=trim(@$_POST["alat_aktif"]);
		$alat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_aktif);
		$alat_aktif=str_replace("'", '"',$alat_aktif);
		$alat_creator=trim(@$_POST["alat_creator"]);
		$alat_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_creator);
		$alat_creator=str_replace("'", '"',$alat_creator);
		$alat_date_create=trim(@$_POST["alat_date_create"]);
		$alat_update=trim(@$_POST["alat_update"]);
		$alat_update=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_update);
		$alat_update=str_replace("'", '"',$alat_update);
		$alat_date_update=trim(@$_POST["alat_date_update"]);
		$alat_revised=trim(@$_POST["alat_revised"]);
		$result=$this->m_alat->alat_create($alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised );
		echo $result;
	}

	//function for delete selected record
	function alat_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_alat->alat_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function alat_search(){
		//POST varibale here
		$alat_id=trim(@$_POST["alat_id"]);
		$alat_nama=trim(@$_POST["alat_nama"]);
		$alat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_nama);
		$alat_nama=str_replace("'", '"',$alat_nama);
		$alat_jumlah=trim(@$_POST["alat_jumlah"]);
		$alat_aktif=trim(@$_POST["alat_aktif"]);
		$alat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_aktif);
		$alat_aktif=str_replace("'", '"',$alat_aktif);
		$alat_creator=trim(@$_POST["alat_creator"]);
		$alat_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_creator);
		$alat_creator=str_replace("'", '"',$alat_creator);
		$alat_date_create=trim(@$_POST["alat_date_create"]);
		$alat_update=trim(@$_POST["alat_update"]);
		$alat_update=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_update);
		$alat_update=str_replace("'", '"',$alat_update);
		$alat_date_update=trim(@$_POST["alat_date_update"]);
		$alat_revised=trim(@$_POST["alat_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_alat->alat_search($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ,$start,$end);
		echo $result;
	}


	function alat_print(){
  		//POST varibale here
		$alat_id=trim(@$_POST["alat_id"]);
		$alat_nama=trim(@$_POST["alat_nama"]);
		$alat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_nama);
		$alat_nama=str_replace("'", '"',$alat_nama);
		$alat_jumlah=trim(@$_POST["alat_jumlah"]);
		$alat_aktif=trim(@$_POST["alat_aktif"]);
		$alat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_aktif);
		$alat_aktif=str_replace("'", '"',$alat_aktif);
		$alat_creator=trim(@$_POST["alat_creator"]);
		$alat_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_creator);
		$alat_creator=str_replace("'", '"',$alat_creator);
		$alat_date_create=trim(@$_POST["alat_date_create"]);
		$alat_update=trim(@$_POST["alat_update"]);
		$alat_update=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_update);
		$alat_update=str_replace("'", '"',$alat_update);
		$alat_date_update=trim(@$_POST["alat_date_update"]);
		$alat_revised=trim(@$_POST["alat_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_alat->alat_print($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("alatlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Peralatan Medis Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Alat List'><caption>DAFTAR PERALATAN MEDIS</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Jumlah</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Alat</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				$i++;
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $i);
				fwrite($file,"</th><td>");
				fwrite($file, $data['alat_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['alat_jumlah']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['alat_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function alat_export_excel(){
		//POST varibale here
		$alat_id=trim(@$_POST["alat_id"]);
		$alat_nama=trim(@$_POST["alat_nama"]);
		$alat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_nama);
		$alat_nama=str_replace("'", '"',$alat_nama);
		$alat_jumlah=trim(@$_POST["alat_jumlah"]);
		$alat_aktif=trim(@$_POST["alat_aktif"]);
		$alat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_aktif);
		$alat_aktif=str_replace("'", '"',$alat_aktif);
		$alat_creator=trim(@$_POST["alat_creator"]);
		$alat_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_creator);
		$alat_creator=str_replace("'", '"',$alat_creator);
		$alat_date_create=trim(@$_POST["alat_date_create"]);
		$alat_update=trim(@$_POST["alat_update"]);
		$alat_update=str_replace("/(<\/?)(p)([^>]*>)", "",$alat_update);
		$alat_update=str_replace("'", '"',$alat_update);
		$alat_date_update=trim(@$_POST["alat_date_update"]);
		$alat_revised=trim(@$_POST["alat_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_alat->alat_export_excel($alat_id ,$alat_nama ,$alat_jumlah ,$alat_aktif ,$alat_creator ,$alat_date_create ,$alat_update ,$alat_date_update ,$alat_revised ,$option,$filter);
		
		to_excel($query,"alat"); 
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