<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: departemen Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_departemen.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 06/Aug/2009 15:46:36
	
*/

//class of departemen
class C_departemen extends Controller {

	//constructor
	function C_departemen(){
		parent::Controller();
		session_start();
		$this->load->model('m_departemen', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_departemen');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->departemen_list();
				break;
			case "UPDATE":
				$this->departemen_update();
				break;
			case "CREATE":
				$this->departemen_create();
				break;
			case "DELETE":
				$this->departemen_delete();
				break;
			case "SEARCH":
				$this->departemen_search();
				break;
			case "PRINT":
				$this->departemen_print();
				break;
			case "EXCEL":
				$this->departemen_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function departemen_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_departemen->departemen_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function departemen_update(){
		//POST variable here
		$departemen_id=trim(@$_POST["departemen_id"]);
		$departemen_nama=trim(@$_POST["departemen_nama"]);
		$departemen_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_nama);
		$departemen_nama=str_replace(",", ",",$departemen_nama);
		$departemen_kode_akun=trim(@$_POST["departemen_kode_akun"]);
		$departemen_kode_akun=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_kode_akun);
		$departemen_kode_akun=str_replace(",", ",",$departemen_kode_akun);
		$departemen_kode_akun=str_replace("'", '"',$departemen_kode_akun);
		$departemen_keterangan=trim(@$_POST["departemen_keterangan"]);
		$departemen_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_keterangan);
		$departemen_keterangan=str_replace(",", ",",$departemen_keterangan);
		$departemen_keterangan=str_replace("'", '"',$departemen_keterangan);
		$departemen_aktif=trim(@$_POST["departemen_aktif"]);
		$departemen_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_aktif);
		$departemen_aktif=str_replace(",", ",",$departemen_aktif);
		$departemen_aktif=str_replace("'", '"',$departemen_aktif);
		$result = $this->m_departemen->departemen_update($departemen_id ,$departemen_nama ,$departemen_kode_akun,$departemen_keterangan ,$departemen_aktif );
		echo $result;
	}
	
	//function for create new record
	function departemen_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$departemen_nama=trim(@$_POST["departemen_nama"]);
		$departemen_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_nama);
		$departemen_nama=str_replace("'", '"',$departemen_nama);
		$departemen_kode_akun=trim(@$_POST["departemen_kode_akun"]);
		$departemen_kode_akun=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_kode_akun);
		$departemen_kode_akun=str_replace("'", '"',$departemen_kode_akun);
		$departemen_keterangan=trim(@$_POST["departemen_keterangan"]);
		$departemen_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_keterangan);
		$departemen_keterangan=str_replace("'", '"',$departemen_keterangan);
		$departemen_aktif=trim(@$_POST["departemen_aktif"]);
		$departemen_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_aktif);
		$departemen_aktif=str_replace("'", '"',$departemen_aktif);
		$result=$this->m_departemen->departemen_create($departemen_nama ,$departemen_kode_akun ,$departemen_keterangan ,$departemen_aktif );
		echo $result;
	}

	//function for delete selected record
	function departemen_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_departemen->departemen_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function departemen_search(){
		//POST varibale here
		$departemen_id=trim(@$_POST["departemen_id"]);
		$departemen_nama=trim(@$_POST["departemen_nama"]);
		$departemen_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_nama);
		$departemen_nama=str_replace("'", '"',$departemen_nama);
		$departemen_keterangan=trim(@$_POST["departemen_keterangan"]);
		$departemen_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_keterangan);
		$departemen_keterangan=str_replace("'", '"',$departemen_keterangan);
		$departemen_aktif=trim(@$_POST["departemen_aktif"]);
		$departemen_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_aktif);
		$departemen_aktif=str_replace("'", '"',$departemen_aktif);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_departemen->departemen_search($departemen_id ,$departemen_nama ,$departemen_keterangan ,$departemen_aktif ,$start,$end);
		echo $result;
	}


	function departemen_print(){
  		//POST varibale here
		$departemen_id=trim(@$_POST["departemen_id"]);
		$departemen_nama=trim(@$_POST["departemen_nama"]);
		$departemen_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_nama);
		$departemen_nama=str_replace("'", '"',$departemen_nama);
		$departemen_keterangan=trim(@$_POST["departemen_keterangan"]);
		$departemen_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_keterangan);
		$departemen_keterangan=str_replace("'", '"',$departemen_keterangan);
		$departemen_aktif=trim(@$_POST["departemen_aktif"]);
		$departemen_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_aktif);
		$departemen_aktif=str_replace("'", '"',$departemen_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_departemen->departemen_print($departemen_id ,$departemen_nama ,$departemen_keterangan ,$departemen_aktif ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=9;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("departemenlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Departemen Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Departemen List'><caption>DAFTAR DEPARTEMEN</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Departemen</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['departemen_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['departemen_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['departemen_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function departemen_export_excel(){
		//POST varibale here
		$departemen_id=trim(@$_POST["departemen_id"]);
		$departemen_nama=trim(@$_POST["departemen_nama"]);
		$departemen_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_nama);
		$departemen_nama=str_replace("'", '"',$departemen_nama);
		$departemen_keterangan=trim(@$_POST["departemen_keterangan"]);
		$departemen_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_keterangan);
		$departemen_keterangan=str_replace("'", '"',$departemen_keterangan);
		$departemen_aktif=trim(@$_POST["departemen_aktif"]);
		$departemen_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$departemen_aktif);
		$departemen_aktif=str_replace("'", '"',$departemen_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_departemen->departemen_export_excel($departemen_id ,$departemen_nama ,$departemen_keterangan ,$departemen_aktif ,$option,$filter);
		
		to_excel($query,"departemen"); 
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