<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: gudang Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_gudang.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of gudang
class C_gudang extends Controller {

	//constructor
	function C_gudang(){
		parent::Controller();
		session_start();
		$this->load->model('m_gudang', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_gudang');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->gudang_list();
				break;
			case "UPDATE":
				$this->gudang_update();
				break;
			case "CREATE":
				$this->gudang_create();
				break;
			case "DELETE":
				$this->gudang_delete();
				break;
			case "SEARCH":
				$this->gudang_search();
				break;
			case "PRINT":
				$this->gudang_print();
				break;
			case "EXCEL":
				$this->gudang_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function gudang_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_gudang->gudang_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function gudang_update(){
		//POST variable here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$result = $this->m_gudang->gudang_update($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised );
		echo $result;
	}
	
	//function for create new record
	function gudang_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$result=$this->m_gudang->gudang_create($gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised );
		echo $result;
	}

	//function for delete selected record
	function gudang_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_gudang->gudang_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function gudang_search(){
		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_gudang->gudang_search($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$start,$end);
		echo $result;
	}


	function gudang_print(){
  		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_gudang->gudang_print($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("gudanglist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Gudang Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Gudang List'><caption>DAFTAR GUDANG</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Lokasi</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Gudang</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['gudang_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_lokasi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function gudang_export_excel(){
		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_gudang->gudang_export_excel($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter);
		
		to_excel($query,"gudang"); 
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