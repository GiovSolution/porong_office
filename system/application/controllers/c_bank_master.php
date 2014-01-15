<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: bank_master Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_bank_master.php
 	+ Author  		: 
 	+ Created on 13/Oct/2009 10:17:38
	
*/

//class of bank_master
class C_bank_master extends Controller {

	//constructor
	function C_bank_master(){
		parent::Controller();
		session_start();
		$this->load->model('m_bank_master', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_bank_master');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->bank_master_list();
				break;
			case "UPDATE":
				$this->bank_master_update();
				break;
			case "CREATE":
				$this->bank_master_create();
				break;
			case "DELETE":
				$this->bank_master_delete();
				break;
			case "SEARCH":
				$this->bank_master_search();
				break;
			case "PRINT":
				$this->bank_master_print();
				break;
			case "EXCEL":
				$this->bank_master_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function bank_master_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_bank_master->bank_master_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function bank_master_update(){
		//POST variable here
		$mbank_id=trim(@$_POST["mbank_id"]);
		$mbank_nama=trim(@$_POST["mbank_nama"]);
		$mbank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_nama);
		$mbank_nama=str_replace(",", ",",$mbank_nama);
		$mbank_nama=str_replace("'", '"',$mbank_nama);
		$mbank_keterangan=trim(@$_POST["mbank_keterangan"]);
		$mbank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_keterangan);
		$mbank_keterangan=str_replace(",", ",",$mbank_keterangan);
		$mbank_keterangan=str_replace("'", '"',$mbank_keterangan);
		$mbank_aktif=trim(@$_POST["mbank_aktif"]);
		$mbank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_aktif);
		$mbank_aktif=str_replace(",", ",",$mbank_aktif);
		$mbank_aktif=str_replace("'", '"',$mbank_aktif);
		$result = $this->m_bank_master->bank_master_update($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif      );
		echo $result;
	}
	
	//function for create new record
	function bank_master_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$mbank_nama=trim(@$_POST["mbank_nama"]);
		$mbank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_nama);
		$mbank_nama=str_replace("'", '"',$mbank_nama);
		$mbank_keterangan=trim(@$_POST["mbank_keterangan"]);
		$mbank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_keterangan);
		$mbank_keterangan=str_replace("'", '"',$mbank_keterangan);
		$mbank_aktif=trim(@$_POST["mbank_aktif"]);
		$mbank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_aktif);
		$mbank_aktif=str_replace("'", '"',$mbank_aktif);
		$result=$this->m_bank_master->bank_master_create($mbank_nama ,$mbank_keterangan ,$mbank_aktif );
		echo $result;
	}

	//function for delete selected record
	function bank_master_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_bank_master->bank_master_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function bank_master_search(){
		//POST varibale here
		$mbank_id=trim(@$_POST["mbank_id"]);
		$mbank_nama=trim(@$_POST["mbank_nama"]);
		$mbank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_nama);
		$mbank_nama=str_replace("'", '"',$mbank_nama);
		$mbank_keterangan=trim(@$_POST["mbank_keterangan"]);
		$mbank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_keterangan);
		$mbank_keterangan=str_replace("'", '"',$mbank_keterangan);
		$mbank_aktif=trim(@$_POST["mbank_aktif"]);
		$mbank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_aktif);
		$mbank_aktif=str_replace("'", '"',$mbank_aktif);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_bank_master->bank_master_search($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ,$start,$end);
		echo $result;
	}


	function bank_master_print(){
  		//POST varibale here
		$mbank_id=trim(@$_POST["mbank_id"]);
		$mbank_nama=trim(@$_POST["mbank_nama"]);
		$mbank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_nama);
		$mbank_nama=str_replace("'", '"',$mbank_nama);
		$mbank_keterangan=trim(@$_POST["mbank_keterangan"]);
		$mbank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_keterangan);
		$mbank_keterangan=str_replace("'", '"',$mbank_keterangan);
		$mbank_aktif=trim(@$_POST["mbank_aktif"]);
		$mbank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_aktif);
		$mbank_aktif=str_replace("'", '"',$mbank_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_bank_master->bank_master_print($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=9;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("bank_masterlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Bank Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Bank_master List'><caption>DAFTAR BANK</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Bank_master</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['mbank_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['mbank_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['mbank_aktif']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['mbank_creator']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['mbank_date_create']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['mbank_update']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['mbank_date_update']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['mbank_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function bank_master_export_excel(){
		//POST varibale here
		$mbank_id=trim(@$_POST["mbank_id"]);
		$mbank_nama=trim(@$_POST["mbank_nama"]);
		$mbank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_nama);
		$mbank_nama=str_replace("'", '"',$mbank_nama);
		$mbank_keterangan=trim(@$_POST["mbank_keterangan"]);
		$mbank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_keterangan);
		$mbank_keterangan=str_replace("'", '"',$mbank_keterangan);
		$mbank_aktif=trim(@$_POST["mbank_aktif"]);
		$mbank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$mbank_aktif);
		$mbank_aktif=str_replace("'", '"',$mbank_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_bank_master->bank_master_export_excel($mbank_id ,$mbank_nama ,$mbank_keterangan ,$mbank_aktif ,$option,$filter);
		$this->load->plugin('to_excel');
		
		to_excel($query,"bank_master"); 
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