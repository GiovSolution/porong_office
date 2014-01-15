<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: bank Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_bank.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of bank
class C_bank extends Controller {

	//constructor
	function C_bank(){
		parent::Controller();
		session_start();
		$this->load->model('m_bank', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_bank');
	}
	
	function get_mbank_list(){
		$result=$this->m_public_function->get_mbank_list();
		echo $result;
	}
	
	function get_akun_list(){
		$result=$this->m_bank->get_akun_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->bank_list();
				break;
			case "UPDATE":
				$this->bank_update();
				break;
			case "CREATE":
				$this->bank_create();
				break;
			case "DELETE":
				$this->bank_delete();
				break;
			case "SEARCH":
				$this->bank_search();
				break;
			case "PRINT":
				$this->bank_print();
				break;
			case "EXCEL":
				$this->bank_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function bank_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_bank->bank_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function bank_update(){
		//POST variable here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$result = $this->m_bank->bank_update($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif );
		echo $result;
	}
	
	//function for create new record
	function bank_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		$result=$this->m_bank->bank_create($bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised );
		echo $result;
	}

	//function for delete selected record
	function bank_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_bank->bank_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function bank_search(){
		//POST varibale here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_bank->bank_search($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$start,$end);
		echo $result;
	}


	function bank_print(){
  		//POST varibale here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_bank->bank_print($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=13;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("banklist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Rekening Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Bank List'><caption>DAFTAR REKENING</caption><thead><tr><th scope='col'>No</th><th scope='col'>Kode</th><th scope='col'>Nama</th><th scope='col'>No.Rekening</th><th scope='col'>Atas Nama</th><th scope='col'>Saldo</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Bank</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['bank_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['mbank_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_norek']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_atasnama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_saldo']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_aktif']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_creator']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_date_create']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_update']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_date_update']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function bank_export_excel(){
		//POST varibale here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_bank->bank_export_excel($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter);
		
		to_excel($query,"bank"); 
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