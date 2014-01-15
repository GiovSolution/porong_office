<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: satuan Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_satuan.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of satuan
class C_satuan extends Controller {

	//constructor
	function C_satuan(){
		parent::Controller();
		session_start();
		$this->load->model('m_satuan', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_satuan');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->satuan_list();
				break;
			case "UPDATE":
				$this->satuan_update();
				break;
			case "CREATE":
				$this->satuan_create();
				break;
			case "DELETE":
				$this->satuan_delete();
				break;
			case "SEARCH":
				$this->satuan_search();
				break;
			case "PRINT":
				$this->satuan_print();
				break;
			case "EXCEL":
				$this->satuan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function satuan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_satuan->satuan_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function satuan_update(){
		//POST variable here
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_kode=trim(@$_POST["satuan_kode"]);
		$satuan_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_kode);
		$satuan_kode=str_replace("'", '"',$satuan_kode);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", '"',$satuan_nama);
		$satuan_aktif=trim(@$_POST["satuan_aktif"]);
		$satuan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_aktif);
		$satuan_aktif=str_replace("'", '"',$satuan_aktif);
		$satuan_creator=trim(@$_POST["satuan_creator"]);
		$satuan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_creator);
		$satuan_creator=str_replace("'", '"',$satuan_creator);
		$satuan_date_create=trim(@$_POST["satuan_date_create"]);
		$satuan_update=trim(@$_POST["satuan_update"]);
		$satuan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_update);
		$satuan_update=str_replace("'", '"',$satuan_update);
		$satuan_date_update=trim(@$_POST["satuan_date_update"]);
		$satuan_revised=trim(@$_POST["satuan_revised"]);
		$result = $this->m_satuan->satuan_update($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised );
		echo $result;
	}
	
	//function for create new record
	function satuan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$satuan_kode=trim(@$_POST["satuan_kode"]);
		$satuan_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_kode);
		$satuan_kode=str_replace("'", '"',$satuan_kode);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", '"',$satuan_nama);
		$satuan_aktif=trim(@$_POST["satuan_aktif"]);
		$satuan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_aktif);
		$satuan_aktif=str_replace("'", '"',$satuan_aktif);
		$satuan_creator=trim(@$_POST["satuan_creator"]);
		$satuan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_creator);
		$satuan_creator=str_replace("'", '"',$satuan_creator);
		$satuan_date_create=trim(@$_POST["satuan_date_create"]);
		$satuan_update=trim(@$_POST["satuan_update"]);
		$satuan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_update);
		$satuan_update=str_replace("'", '"',$satuan_update);
		$satuan_date_update=trim(@$_POST["satuan_date_update"]);
		$satuan_revised=trim(@$_POST["satuan_revised"]);
		$result=$this->m_satuan->satuan_create($satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised );
		echo $result;
	}

	//function for delete selected record
	function satuan_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_satuan->satuan_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function satuan_search(){
		//POST varibale here
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_kode=trim(@$_POST["satuan_kode"]);
		$satuan_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_kode);
		$satuan_kode=str_replace("'", '"',$satuan_kode);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", '"',$satuan_nama);
		$satuan_aktif=trim(@$_POST["satuan_aktif"]);
		$satuan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_aktif);
		$satuan_aktif=str_replace("'", '"',$satuan_aktif);
		$satuan_creator=trim(@$_POST["satuan_creator"]);
		$satuan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_creator);
		$satuan_creator=str_replace("'", '"',$satuan_creator);
		$satuan_date_create=trim(@$_POST["satuan_date_create"]);
		$satuan_update=trim(@$_POST["satuan_update"]);
		$satuan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_update);
		$satuan_update=str_replace("'", '"',$satuan_update);
		$satuan_date_update=trim(@$_POST["satuan_date_update"]);
		$satuan_revised=trim(@$_POST["satuan_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_satuan->satuan_search($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ,$start,$end);
		echo $result;
	}


	function satuan_print(){
  		//POST varibale here
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_kode=trim(@$_POST["satuan_kode"]);
		$satuan_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_kode);
		$satuan_kode=str_replace("'", '"',$satuan_kode);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", '"',$satuan_nama);
		$satuan_aktif=trim(@$_POST["satuan_aktif"]);
		$satuan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_aktif);
		$satuan_aktif=str_replace("'", '"',$satuan_aktif);
		$satuan_creator=trim(@$_POST["satuan_creator"]);
		$satuan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_creator);
		$satuan_creator=str_replace("'", '"',$satuan_creator);
		$satuan_date_create=trim(@$_POST["satuan_date_create"]);
		$satuan_update=trim(@$_POST["satuan_update"]);
		$satuan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_update);
		$satuan_update=str_replace("'", '"',$satuan_update);
		$satuan_date_update=trim(@$_POST["satuan_date_update"]);
		$satuan_revised=trim(@$_POST["satuan_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_satuan->satuan_print($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=9;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("satuanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Satuan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Satuan List'><caption>DAFTAR SATUAN</caption><thead><tr><th scope='col'>Id</th><th scope='col'>Kode</th><th scope='col'>Nama</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Satuan</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['satuan_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['satuan_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['satuan_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function satuan_export_excel(){
		//POST varibale here
		$satuan_id=trim(@$_POST["satuan_id"]);
		$satuan_kode=trim(@$_POST["satuan_kode"]);
		$satuan_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_kode);
		$satuan_kode=str_replace("'", '"',$satuan_kode);
		$satuan_nama=trim(@$_POST["satuan_nama"]);
		$satuan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_nama);
		$satuan_nama=str_replace("'", '"',$satuan_nama);
		$satuan_aktif=trim(@$_POST["satuan_aktif"]);
		$satuan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_aktif);
		$satuan_aktif=str_replace("'", '"',$satuan_aktif);
		$satuan_creator=trim(@$_POST["satuan_creator"]);
		$satuan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_creator);
		$satuan_creator=str_replace("'", '"',$satuan_creator);
		$satuan_date_create=trim(@$_POST["satuan_date_create"]);
		$satuan_update=trim(@$_POST["satuan_update"]);
		$satuan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$satuan_update);
		$satuan_update=str_replace("'", '"',$satuan_update);
		$satuan_date_update=trim(@$_POST["satuan_date_update"]);
		$satuan_revised=trim(@$_POST["satuan_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_satuan->satuan_export_excel($satuan_id ,$satuan_kode ,$satuan_nama ,$satuan_aktif ,$satuan_creator ,$satuan_date_create ,$satuan_update ,$satuan_date_update ,$satuan_revised ,$option,$filter);
		
		to_excel($query,"satuan"); 
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