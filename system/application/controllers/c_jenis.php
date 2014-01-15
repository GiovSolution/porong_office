<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#GIOV SOLUTION
	
	+ Module  		: jenis Controller
	+ Description	: For record Controller
	+ Filename 		: c_jenis.php
 	+ Author  		: Isaac & Freddy
	
*/

//class of kategori
class C_jenis extends Controller {

	//constructor
	function C_jenis(){
		parent::Controller();
		session_start();
		$this->load->model('m_jenis', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_jenis');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->jenis_list();
				break;
			case "UPDATE":
				$this->jenis_update();
				break;
			case "CREATE":
				$this->jenis_create();
				break;
			case "DELETE":
				$this->jenis_delete();
				break;
			case "SEARCH":
				$this->jenis_search();
				break;
			case "PRINT":
				$this->jenis_print();
				break;
			case "EXCEL":
				$this->jenis_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function jenis_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_jenis->jenis_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function jenis_update(){
		//POST variable here
		$jenis_id=trim(@$_POST["jenis_id"]);
		$jenis_nama=trim(@$_POST["jenis_nama"]);
		$jenis_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_nama);
		$jenis_nama=str_replace("'", '"',$jenis_nama);
		$jenis_jenis=trim(@$_POST["jenis_jenis"]);
		$jenis_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_jenis);
		$jenis_jenis=str_replace("'", '"',$jenis_jenis);
		$jenis_keterangan=trim(@$_POST["jenis_keterangan"]);
		$jenis_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_keterangan);
		$jenis_keterangan=str_replace("'", '"',$jenis_keterangan);
		$jenis_aktif=trim(@$_POST["jenis_aktif"]);
		$jenis_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_aktif);
		$jenis_aktif=str_replace("'", '"',$jenis_aktif);
		$jenis_creator=trim(@$_POST["jenis_creator"]);
		$jenis_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_creator);
		$jenis_creator=str_replace("'", '"',$jenis_creator);
		$jenis_date_create=trim(@$_POST["jenis_date_create"]);
		$jenis_update=trim(@$_POST["jenis_update"]);
		$jenis_update=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_update);
		$jenis_update=str_replace("'", '"',$jenis_update);
		$jenis_date_update=trim(@$_POST["jenis_date_update"]);
		$jenis_revised=trim(@$_POST["jenis_revised"]);
		$result = $this->m_jenis->jenis_update($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised );
		echo $result;
	}
	
	//function for create new record
	function jenis_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$jenis_nama=trim(@$_POST["jenis_nama"]);
		$jenis_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_nama);
		$jenis_nama=str_replace("'", '"',$jenis_nama);
		$jenis_jenis=trim(@$_POST["jenis_jenis"]);
		$jenis_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_jenis);
		$jenis_jenis=str_replace("'", '"',$jenis_jenis);
		$jenis_keterangan=trim(@$_POST["jenis_keterangan"]);
		$jenis_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_keterangan);
		$jenis_keterangan=str_replace("'", '"',$jenis_keterangan);
		$jenis_aktif=trim(@$_POST["jenis_aktif"]);
		$jenis_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_aktif);
		$jenis_aktif=str_replace("'", '"',$jenis_aktif);
		$jenis_creator=trim(@$_POST["jenis_creator"]);
		$jenis_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_creator);
		$jenis_creator=str_replace("'", '"',$jenis_creator);
		$jenis_date_create=trim(@$_POST["jenis_date_create"]);
		$jenis_update=trim(@$_POST["jenis_update"]);
		$jenis_update=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_update);
		$jenis_update=str_replace("'", '"',$jenis_update);
		$jenis_date_update=trim(@$_POST["jenis_date_update"]);
		$jenis_revised=trim(@$_POST["jenis_revised"]);
		$result=$this->m_jenis->jenis_create($jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised );
		echo $result;
	}

	//function for delete selected record
	function jenis_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_jenis->jenis_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function jenis_search(){
		//POST varibale here
		$jenis_id=trim(@$_POST["jenis_id"]);
		$jenis_nama=trim(@$_POST["jenis_nama"]);
		$jenis_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_nama);
		$jenis_nama=str_replace("'", '"',$jenis_nama);
		$jenis_jenis=trim(@$_POST["jenis_jenis"]);
		$jenis_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_jenis);
		$jenis_jenis=str_replace("'", '"',$jenis_jenis);
		$jenis_keterangan=trim(@$_POST["jenis_keterangan"]);
		$jenis_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_keterangan);
		$jenis_keterangan=str_replace("'", '"',$jenis_keterangan);
		$jenis_aktif=trim(@$_POST["jenis_aktif"]);
		$jenis_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_aktif);
		$jenis_aktif=str_replace("'", '"',$jenis_aktif);
		$jenis_creator=trim(@$_POST["jenis_creator"]);
		$jenis_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_creator);
		$jenis_creator=str_replace("'", '"',$jenis_creator);
		$jenis_date_create=trim(@$_POST["jenis_date_create"]);
		$jenis_update=trim(@$_POST["jenis_update"]);
		$jenis_update=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_update);
		$jenis_update=str_replace("'", '"',$jenis_update);
		$jenis_date_update=trim(@$_POST["jenis_date_update"]);
		$jenis_revised=trim(@$_POST["jenis_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_jenis->jenis_search($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ,$start,$end);
		echo $result;
	}


	function jenis_print(){
  		//POST varibale here
		$jenis_id=trim(@$_POST["jenis_id"]);
		$jenis_nama=trim(@$_POST["jenis_nama"]);
		$jenis_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_nama);
		$jenis_nama=str_replace("'", '"',$jenis_nama);
		$jenis_jenis=trim(@$_POST["jenis_jenis"]);
		$jenis_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_jenis);
		$jenis_jenis=str_replace("'", '"',$jenis_jenis);
		$jenis_keterangan=trim(@$_POST["jenis_keterangan"]);
		$jenis_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_keterangan);
		$jenis_keterangan=str_replace("'", '"',$jenis_keterangan);
		$jenis_aktif=trim(@$_POST["jenis_aktif"]);
		$jenis_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_aktif);
		$jenis_aktif=str_replace("'", '"',$jenis_aktif);
		$jenis_creator=trim(@$_POST["jenis_creator"]);
		$jenis_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_creator);
		$jenis_creator=str_replace("'", '"',$jenis_creator);
		$jenis_date_create=trim(@$_POST["jenis_date_create"]);
		$jenis_update=trim(@$_POST["jenis_update"]);
		$jenis_update=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_update);
		$jenis_update=str_replace("'", '"',$jenis_update);
		$jenis_date_update=trim(@$_POST["jenis_date_update"]);
		$jenis_revised=trim(@$_POST["jenis_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_jenis->jenis_print($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("kategorilist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing Daftar Jenis</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Kategori List'><caption>DAFTAR JENIS</caption><thead><tr><th scope='col'>Id</th><th scope='col'>Nama</th><th scope='col'>Jenis</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, "  Jenis</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['jenis_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['jenis_jenis']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['jenis_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['jenis_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function jenis_export_excel(){
		//POST varibale here
		$jenis_id=trim(@$_POST["jenis_id"]);
		$jenis_nama=trim(@$_POST["jenis_nama"]);
		$jenis_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_nama);
		$jenis_nama=str_replace("'", '"',$jenis_nama);
		$jenis_jenis=trim(@$_POST["jenis_jenis"]);
		$jenis_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_jenis);
		$jenis_jenis=str_replace("'", '"',$jenis_jenis);
		$jenis_keterangan=trim(@$_POST["jenis_keterangan"]);
		$jenis_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_keterangan);
		$jenis_keterangan=str_replace("'", '"',$jenis_keterangan);
		$jenis_aktif=trim(@$_POST["jenis_aktif"]);
		$jenis_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_aktif);
		$jenis_aktif=str_replace("'", '"',$jenis_aktif);
		$jenis_creator=trim(@$_POST["jenis_creator"]);
		$jenis_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_creator);
		$jenis_creator=str_replace("'", '"',$jenis_creator);
		$jenis_date_create=trim(@$_POST["jenis_date_create"]);
		$jenis_update=trim(@$_POST["jenis_update"]);
		$jenis_update=str_replace("/(<\/?)(p)([^>]*>)", "",$jenis_update);
		$jenis_update=str_replace("'", '"',$jenis_update);
		$jenis_date_update=trim(@$_POST["jenis_date_update"]);
		$jenis_revised=trim(@$_POST["jenis_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_jenis->jenis_export_excel($jenis_id ,$jenis_nama ,$jenis_jenis ,$jenis_keterangan ,$jenis_aktif ,$jenis_creator ,$jenis_date_create ,$jenis_update ,$jenis_date_update ,$jenis_revised ,$option,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"jenis"); 
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