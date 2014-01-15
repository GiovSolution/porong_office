<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: diagnosa Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_diagnosa.php
 	+ Author  		: 
 	+ Created on 03/Oct/2009 22:52:15
	
*/

//class of diagnosa
class C_diagnosa extends Controller {

	//constructor
	function C_diagnosa(){
		parent::Controller();
		$this->load->model('m_diagnosa', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->helper('asset');
		$this->load->view('main/v_diagnosa');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->diagnosa_list();
				break;
			case "UPDATE":
				$this->diagnosa_update();
				break;
			case "CREATE":
				$this->diagnosa_create();
				break;
			case "DELETE":
				$this->diagnosa_delete();
				break;
			case "SEARCH":
				$this->diagnosa_search();
				break;
			case "PRINT":
				$this->diagnosa_print();
				break;
			case "EXCEL":
				$this->diagnosa_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function diagnosa_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_diagnosa->diagnosa_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function diagnosa_update(){
		//POST variable here
		$diagnosa_id=trim(@$_POST["diagnosa_id"]);
		$diagnosa_kode=trim(@$_POST["diagnosa_kode"]);
		$diagnosa_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kode);
		$diagnosa_kode=str_replace(",", ",",$diagnosa_kode);
		$diagnosa_kode=str_replace("'", '"',$diagnosa_kode);
		$diagnosa_kategori=trim(@$_POST["diagnosa_kategori"]);
		$diagnosa_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kategori);
		$diagnosa_kategori=str_replace(",", ",",$diagnosa_kategori);
		$diagnosa_kategori=str_replace("'", '"',$diagnosa_kategori);
		$diagnosa_nama=trim(@$_POST["diagnosa_nama"]);
		$diagnosa_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_nama);
		$diagnosa_nama=str_replace(",", ",",$diagnosa_nama);
		$diagnosa_nama=str_replace("'", '"',$diagnosa_nama);
		$diagnosa_keterangan=trim(@$_POST["diagnosa_keterangan"]);
		$diagnosa_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_keterangan);
		$diagnosa_keterangan=str_replace(",", ",",$diagnosa_keterangan);
		$diagnosa_keterangan=str_replace("'", '"',$diagnosa_keterangan);
		$result = $this->m_diagnosa->diagnosa_update($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan );
		echo $result;
	}
	
	//function for create new record
	function diagnosa_create(){
		//POST varible here
		$diagnosa_id=trim(@$_POST["diagnosa_id"]);
		$diagnosa_kode=trim(@$_POST["diagnosa_kode"]);
		$diagnosa_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kode);
		$diagnosa_kode=str_replace("'", '"',$diagnosa_kode);
		$diagnosa_kategori=trim(@$_POST["diagnosa_kategori"]);
		$diagnosa_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kategori);
		$diagnosa_kategori=str_replace("'", '"',$diagnosa_kategori);
		$diagnosa_nama=trim(@$_POST["diagnosa_nama"]);
		$diagnosa_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_nama);
		$diagnosa_nama=str_replace("'", '"',$diagnosa_nama);
		$diagnosa_keterangan=trim(@$_POST["diagnosa_keterangan"]);
		$diagnosa_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_keterangan);
		$diagnosa_keterangan=str_replace("'", '"',$diagnosa_keterangan);
		$result=$this->m_diagnosa->diagnosa_create($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan);
		echo $result;
	}

	//function for delete selected record
	function diagnosa_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_diagnosa->diagnosa_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function diagnosa_search(){
		//POST varibale here
		$diagnosa_id=trim(@$_POST["diagnosa_id"]);
		$diagnosa_kode=trim(@$_POST["diagnosa_kode"]);
		$diagnosa_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kode);
		$diagnosa_kode=str_replace("'", '"',$diagnosa_kode);
		$diagnosa_kategori=trim(@$_POST["diagnosa_kategori"]);
		$diagnosa_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kategori);
		$diagnosa_kategori=str_replace("'", '"',$diagnosa_kategori);
		$diagnosa_nama=trim(@$_POST["diagnosa_nama"]);
		$diagnosa_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_nama);
		$diagnosa_nama=str_replace("'", '"',$diagnosa_nama);
		$diagnosa_keterangan=trim(@$_POST["diagnosa_keterangan"]);
		$diagnosa_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_keterangan);
		$diagnosa_keterangan=str_replace("'", '"',$diagnosa_keterangan);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_diagnosa->diagnosa_search($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan,$start,$end);
		echo $result;
	}


	function diagnosa_print(){
  		//POST varibale here
		$diagnosa_id=trim(@$_POST["diagnosa_id"]);
		$diagnosa_kode=trim(@$_POST["diagnosa_kode"]);
		$diagnosa_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kode);
		$diagnosa_kode=str_replace("'", '"',$diagnosa_kode);
		$diagnosa_kategori=trim(@$_POST["diagnosa_kategori"]);
		$diagnosa_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kategori);
		$diagnosa_kategori=str_replace("'", '"',$diagnosa_kategori);
		$diagnosa_nama=trim(@$_POST["diagnosa_nama"]);
		$diagnosa_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_nama);
		$diagnosa_nama=str_replace("'", '"',$diagnosa_nama);
		$diagnosa_keterangan=trim(@$_POST["diagnosa_keterangan"]);
		$diagnosa_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_keterangan);
		$diagnosa_keterangan=str_replace("'", '"',$diagnosa_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_diagnosa->diagnosa_print($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("diagnosalist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Diagnosa Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Diagnosa List'><caption>DIAGNOSA</caption><thead><tr><th scope='col'>Diagnosa Id</th><th scope='col'>Diagnosa Kode</th><th scope='col'>Diagnosa Kategori</th><th scope='col'>Diagnosa Nama</th><th scope='col'>Diagnosa Keterangan</th><th scope='col'>Diagnosa Author</th><th scope='col'>Diagnosa Date Create</th><th scope='col'>Diagnosa Update</th><th scope='col'>Diagnosa Date Update</th><th scope='col'>Diagnosa Revised</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Diagnosa</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['diagnosa_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['diagnosa_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['diagnosa_kategori']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['diagnosa_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['diagnosa_keterangan']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['diagnosa_author']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['diagnosa_date_create']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['diagnosa_update']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['diagnosa_date_update']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['diagnosa_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function diagnosa_export_excel(){
		//POST varibale here
		$diagnosa_id=trim(@$_POST["diagnosa_id"]);
		$diagnosa_kode=trim(@$_POST["diagnosa_kode"]);
		$diagnosa_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kode);
		$diagnosa_kode=str_replace("'", '"',$diagnosa_kode);
		$diagnosa_kategori=trim(@$_POST["diagnosa_kategori"]);
		$diagnosa_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_kategori);
		$diagnosa_kategori=str_replace("'", '"',$diagnosa_kategori);
		$diagnosa_nama=trim(@$_POST["diagnosa_nama"]);
		$diagnosa_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_nama);
		$diagnosa_nama=str_replace("'", '"',$diagnosa_nama);
		$diagnosa_keterangan=trim(@$_POST["diagnosa_keterangan"]);
		$diagnosa_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$diagnosa_keterangan);
		$diagnosa_keterangan=str_replace("'", '"',$diagnosa_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_diagnosa->diagnosa_export_excel($diagnosa_id ,$diagnosa_kode ,$diagnosa_kategori ,$diagnosa_nama ,$diagnosa_keterangan,$option,$filter);
		
		to_excel($query,"diagnosa"); 
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