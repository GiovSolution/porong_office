<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: kategori Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_kategori.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of kategori
class C_kategori extends Controller {

	//constructor
	function C_kategori(){
		parent::Controller();
		session_start();
		$this->load->model('m_kategori', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_kategori');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->kategori_list();
				break;
			case "UPDATE":
				$this->kategori_update();
				break;
			case "CREATE":
				$this->kategori_create();
				break;
			case "DELETE":
				$this->kategori_delete();
				break;
			case "SEARCH":
				$this->kategori_search();
				break;
			case "PRINT":
				$this->kategori_print();
				break;
			case "EXCEL":
				$this->kategori_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function kategori_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_kategori->kategori_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function kategori_update(){
		//POST variable here
		$kategori_id=trim(@$_POST["kategori_id"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);
		$kategori_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_nama);
		$kategori_nama=str_replace("'", '"',$kategori_nama);
		$kategori_jenis=trim(@$_POST["kategori_jenis"]);
		$kategori_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_jenis);
		$kategori_jenis=str_replace("'", '"',$kategori_jenis);
		$kategori_keterangan=trim(@$_POST["kategori_keterangan"]);
		$kategori_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_keterangan);
		$kategori_keterangan=str_replace("'", '"',$kategori_keterangan);
		$kategori_aktif=trim(@$_POST["kategori_aktif"]);
		$kategori_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_aktif);
		$kategori_aktif=str_replace("'", '"',$kategori_aktif);
		$kategori_creator=trim(@$_POST["kategori_creator"]);
		$kategori_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_creator);
		$kategori_creator=str_replace("'", '"',$kategori_creator);
		$kategori_date_create=trim(@$_POST["kategori_date_create"]);
		$kategori_update=trim(@$_POST["kategori_update"]);
		$kategori_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_update);
		$kategori_update=str_replace("'", '"',$kategori_update);
		$kategori_date_update=trim(@$_POST["kategori_date_update"]);
		$kategori_revised=trim(@$_POST["kategori_revised"]);
		$result = $this->m_kategori->kategori_update($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised );
		echo $result;
	}
	
	//function for create new record
	function kategori_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$kategori_nama=trim(@$_POST["kategori_nama"]);
		$kategori_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_nama);
		$kategori_nama=str_replace("'", '"',$kategori_nama);
		$kategori_jenis=trim(@$_POST["kategori_jenis"]);
		$kategori_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_jenis);
		$kategori_jenis=str_replace("'", '"',$kategori_jenis);
		$kategori_keterangan=trim(@$_POST["kategori_keterangan"]);
		$kategori_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_keterangan);
		$kategori_keterangan=str_replace("'", '"',$kategori_keterangan);
		$kategori_aktif=trim(@$_POST["kategori_aktif"]);
		$kategori_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_aktif);
		$kategori_aktif=str_replace("'", '"',$kategori_aktif);
		$kategori_creator=trim(@$_POST["kategori_creator"]);
		$kategori_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_creator);
		$kategori_creator=str_replace("'", '"',$kategori_creator);
		$kategori_date_create=trim(@$_POST["kategori_date_create"]);
		$kategori_update=trim(@$_POST["kategori_update"]);
		$kategori_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_update);
		$kategori_update=str_replace("'", '"',$kategori_update);
		$kategori_date_update=trim(@$_POST["kategori_date_update"]);
		$kategori_revised=trim(@$_POST["kategori_revised"]);
		$result=$this->m_kategori->kategori_create($kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised );
		echo $result;
	}

	//function for delete selected record
	function kategori_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_kategori->kategori_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function kategori_search(){
		//POST varibale here
		$kategori_id=trim(@$_POST["kategori_id"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);
		$kategori_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_nama);
		$kategori_nama=str_replace("'", '"',$kategori_nama);
		$kategori_jenis=trim(@$_POST["kategori_jenis"]);
		$kategori_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_jenis);
		$kategori_jenis=str_replace("'", '"',$kategori_jenis);
		$kategori_keterangan=trim(@$_POST["kategori_keterangan"]);
		$kategori_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_keterangan);
		$kategori_keterangan=str_replace("'", '"',$kategori_keterangan);
		$kategori_aktif=trim(@$_POST["kategori_aktif"]);
		$kategori_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_aktif);
		$kategori_aktif=str_replace("'", '"',$kategori_aktif);
		$kategori_creator=trim(@$_POST["kategori_creator"]);
		$kategori_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_creator);
		$kategori_creator=str_replace("'", '"',$kategori_creator);
		$kategori_date_create=trim(@$_POST["kategori_date_create"]);
		$kategori_update=trim(@$_POST["kategori_update"]);
		$kategori_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_update);
		$kategori_update=str_replace("'", '"',$kategori_update);
		$kategori_date_update=trim(@$_POST["kategori_date_update"]);
		$kategori_revised=trim(@$_POST["kategori_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_kategori->kategori_search($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ,$start,$end);
		echo $result;
	}


	function kategori_print(){
  		//POST varibale here
		$kategori_id=trim(@$_POST["kategori_id"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);
		$kategori_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_nama);
		$kategori_nama=str_replace("'", '"',$kategori_nama);
		$kategori_jenis=trim(@$_POST["kategori_jenis"]);
		$kategori_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_jenis);
		$kategori_jenis=str_replace("'", '"',$kategori_jenis);
		$kategori_keterangan=trim(@$_POST["kategori_keterangan"]);
		$kategori_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_keterangan);
		$kategori_keterangan=str_replace("'", '"',$kategori_keterangan);
		$kategori_aktif=trim(@$_POST["kategori_aktif"]);
		$kategori_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_aktif);
		$kategori_aktif=str_replace("'", '"',$kategori_aktif);
		$kategori_creator=trim(@$_POST["kategori_creator"]);
		$kategori_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_creator);
		$kategori_creator=str_replace("'", '"',$kategori_creator);
		$kategori_date_create=trim(@$_POST["kategori_date_create"]);
		$kategori_update=trim(@$_POST["kategori_update"]);
		$kategori_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_update);
		$kategori_update=str_replace("'", '"',$kategori_update);
		$kategori_date_update=trim(@$_POST["kategori_date_update"]);
		$kategori_revised=trim(@$_POST["kategori_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_kategori->kategori_print($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ,$option,$filter);
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
				fwrite($file, $data['kategori_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori_jenis']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function kategori_export_excel(){
		//POST varibale here
		$kategori_id=trim(@$_POST["kategori_id"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);
		$kategori_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_nama);
		$kategori_nama=str_replace("'", '"',$kategori_nama);
		$kategori_jenis=trim(@$_POST["kategori_jenis"]);
		$kategori_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_jenis);
		$kategori_jenis=str_replace("'", '"',$kategori_jenis);
		$kategori_keterangan=trim(@$_POST["kategori_keterangan"]);
		$kategori_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_keterangan);
		$kategori_keterangan=str_replace("'", '"',$kategori_keterangan);
		$kategori_aktif=trim(@$_POST["kategori_aktif"]);
		$kategori_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_aktif);
		$kategori_aktif=str_replace("'", '"',$kategori_aktif);
		$kategori_creator=trim(@$_POST["kategori_creator"]);
		$kategori_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_creator);
		$kategori_creator=str_replace("'", '"',$kategori_creator);
		$kategori_date_create=trim(@$_POST["kategori_date_create"]);
		$kategori_update=trim(@$_POST["kategori_update"]);
		$kategori_update=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori_update);
		$kategori_update=str_replace("'", '"',$kategori_update);
		$kategori_date_update=trim(@$_POST["kategori_date_update"]);
		$kategori_revised=trim(@$_POST["kategori_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_kategori->kategori_export_excel($kategori_id ,$kategori_nama ,$kategori_jenis ,$kategori_keterangan ,$kategori_aktif ,$kategori_creator ,$kategori_date_create ,$kategori_update ,$kategori_date_update ,$kategori_revised ,$option,$filter);
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