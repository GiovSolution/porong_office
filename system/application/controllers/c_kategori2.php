<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: kategori2 Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_kategori2.php
 	+ Author  		: 
 	+ Created on 22/Oct/2009 16:24:37
	
*/

//class of kategori2
class C_kategori2 extends Controller {

	//constructor
	function C_kategori2(){
		parent::Controller();
		session_start();
		$this->load->model('m_kategori2', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_kategori2');
	}
	
	function get_kategori_list(){
		$result=$this->m_public_function->get_kategori_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->kategori2_list();
				break;
			case "UPDATE":
				$this->kategori2_update();
				break;
			case "CREATE":
				$this->kategori2_create();
				break;
			case "DELETE":
				$this->kategori2_delete();
				break;
			case "SEARCH":
				$this->kategori2_search();
				break;
			case "PRINT":
				$this->kategori2_print();
				break;
			case "EXCEL":
				$this->kategori2_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function kategori2_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_kategori2->kategori2_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function kategori2_update(){
		//POST variable here
		$kategori2_id=trim(@$_POST["kategori2_id"]);
		$kategori2_nama=trim(@$_POST["kategori2_nama"]);
		$kategori2_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_nama);
		$kategori2_nama=str_replace(",", ",",$kategori2_nama);
		$kategori2_nama=str_replace("'", "''",$kategori2_nama);
		$kategori2_jenis=trim(@$_POST["kategori2_jenis"]);
		$kategori2_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_jenis);
		$kategori2_jenis=str_replace(",", ",",$kategori2_jenis);
		$kategori2_jenis=str_replace("'", "''",$kategori2_jenis);
		$kategori2_keterangan=trim(@$_POST["kategori2_keterangan"]);
		$kategori2_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_keterangan);
		$kategori2_keterangan=str_replace(",", ",",$kategori2_keterangan);
		$kategori2_keterangan=str_replace("'", "''",$kategori2_keterangan);
		$kategori2_aktif=trim(@$_POST["kategori2_aktif"]);
		$kategori2_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_aktif);
		$kategori2_aktif=str_replace(",", ",",$kategori2_aktif);
		$kategori2_aktif=str_replace("'", "''",$kategori2_aktif);
		$result = $this->m_kategori2->kategori2_update($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif      );
		echo $result;
	}
	
	//function for create new record
	function kategori2_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$kategori2_nama=trim(@$_POST["kategori2_nama"]);
		$kategori2_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_nama);
		$kategori2_nama=str_replace("'", "''",$kategori2_nama);
		$kategori2_jenis=trim(@$_POST["kategori2_jenis"]);
		$kategori2_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_jenis);
		$kategori2_jenis=str_replace("'", "''",$kategori2_jenis);
		$kategori2_keterangan=trim(@$_POST["kategori2_keterangan"]);
		$kategori2_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_keterangan);
		$kategori2_keterangan=str_replace("'", "''",$kategori2_keterangan);
		$kategori2_aktif=trim(@$_POST["kategori2_aktif"]);
		$kategori2_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_aktif);
		$kategori2_aktif=str_replace("'", "''",$kategori2_aktif);
		$result=$this->m_kategori2->kategori2_create($kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif );
		echo $result;
	}

	//function for delete selected record
	function kategori2_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_kategori2->kategori2_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function kategori2_search(){
		//POST varibale here
		$kategori2_id=trim(@$_POST["kategori2_id"]);
		$kategori2_nama=trim(@$_POST["kategori2_nama"]);
		$kategori2_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_nama);
		$kategori2_nama=str_replace("'", "''",$kategori2_nama);
		$kategori2_jenis=trim(@$_POST["kategori2_jenis"]);
		$kategori2_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_jenis);
		$kategori2_jenis=str_replace("'", "''",$kategori2_jenis);
		$kategori2_keterangan=trim(@$_POST["kategori2_keterangan"]);
		$kategori2_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_keterangan);
		$kategori2_keterangan=str_replace("'", "''",$kategori2_keterangan);
		$kategori2_aktif=trim(@$_POST["kategori2_aktif"]);
		$kategori2_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_aktif);
		$kategori2_aktif=str_replace("'", "''",$kategori2_aktif);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_kategori2->kategori2_search($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ,$start,$end);
		echo $result;
	}


	function kategori2_print(){
  		//POST varibale here
		$kategori2_id=trim(@$_POST["kategori2_id"]);
		$kategori2_nama=trim(@$_POST["kategori2_nama"]);
		$kategori2_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_nama);
		$kategori2_nama=str_replace("'", "''",$kategori2_nama);
		$kategori2_jenis=trim(@$_POST["kategori2_jenis"]);
		$kategori2_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_jenis);
		$kategori2_jenis=str_replace("'", "''",$kategori2_jenis);
		$kategori2_keterangan=trim(@$_POST["kategori2_keterangan"]);
		$kategori2_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_keterangan);
		$kategori2_keterangan=str_replace("'", "''",$kategori2_keterangan);
		$kategori2_aktif=trim(@$_POST["kategori2_aktif"]);
		$kategori2_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_aktif);
		$kategori2_aktif=str_replace("'", "''",$kategori2_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_kategori2->kategori2_print($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("kategori2list.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Contribution Category Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='kategori2 List'><caption>Daftar Contribution Category</caption><thead><tr><th scope='col'>Id</th><th scope='col'>Nama</th><th scope='col'>Jenis</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Contribution Category</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['kategori2_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori2_jenis']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori2_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori2_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function kategori2_export_excel(){
		//POST varibale here
		$kategori2_id=trim(@$_POST["kategori2_id"]);
		$kategori2_nama=trim(@$_POST["kategori2_nama"]);
		$kategori2_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_nama);
		$kategori2_nama=str_replace("'", "''",$kategori2_nama);
		$kategori2_jenis=trim(@$_POST["kategori2_jenis"]);
		$kategori2_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_jenis);
		$kategori2_jenis=str_replace("'", "''",$kategori2_jenis);
		$kategori2_keterangan=trim(@$_POST["kategori2_keterangan"]);
		$kategori2_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_keterangan);
		$kategori2_keterangan=str_replace("'", "''",$kategori2_keterangan);
		$kategori2_aktif=trim(@$_POST["kategori2_aktif"]);
		$kategori2_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$kategori2_aktif);
		$kategori2_aktif=str_replace("'", "''",$kategori2_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_kategori2->kategori2_export_excel($kategori2_id ,$kategori2_nama ,$kategori2_jenis ,$kategori2_keterangan ,$kategori2_aktif ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"contribution_category"); 
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