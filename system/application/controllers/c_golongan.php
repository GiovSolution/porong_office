<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: bank Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_golongan.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of bank
class C_golongan extends Controller {

	//constructor
	function C_golongan(){
		parent::Controller();
		session_start();
		$this->load->model('m_golongan', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_golongan');
	}
	
	function get_mbank_list(){
		$result=$this->m_public_function->get_mbank_list();
		echo $result;
	}
	
	function get_akun_list(){
		$result=$this->m_golongan->get_akun_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->golongan_list();
				break;
			case "UPDATE":
				$this->golongan_update();
				break;
			case "CREATE":
				$this->golongan_create();
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
	function golongan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_golongan->golongan_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function golongan_update(){
		//POST variable here
		$id_golongan=trim(@$_POST["id_golongan"]);
		$id_golongan=str_replace("/(<\/?)(p)([^>]*>)", "",$id_golongan);
		$id_golongan=str_replace("'", '"',$id_golongan);
		$nama_golongan=trim(@$_POST["nama_golongan"]);
		$nama_golongan=str_replace("/(<\/?)(p)([^>]*>)", "",$nama_golongan);
		$nama_golongan=str_replace("'", '"',$nama_golongan);
		$grooming_golongan=trim(@$_POST["grooming_golongan"]);
		$keterangan_golongan=trim(@$_POST["keterangan_golongan"]);
		$keterangan_golongan=str_replace("/(<\/?)(p)([^>]*>)", "",$keterangan_golongan);
		$keterangan_golongan=str_replace("'", '"',$keterangan_golongan);
		$golongan_creator=trim(@$_POST["golongan_creator"]);
		$golongan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$golongan_creator);
		$golongan_creator=str_replace("'", '"',$golongan_creator);
		$golongan_date_create=trim(@$_POST["golongan_date_create"]);
		$golongan_update=trim(@$_POST["golongan_update"]);
		$golongan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$golongan_update);
		$golongan_update=str_replace("'", '"',$golongan_update);
		$golongan_date_update=trim(@$_POST["golongan_date_update"]);
		$golongan_revised=trim(@$_POST["golongan_revised"]);
		$result = $this->m_golongan->golongan_update($id_golongan, $nama_golongan, $grooming_golongan, $keterangan_golongan, $golongan_creator ,$golongan_date_create ,$golongan_update ,$golongan_date_update ,$golongan_revised);
		echo $result;
	}
	
	//function for create new record
	function golongan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$id_golongan=trim(@$_POST["id_golongan"]);
		$id_golongan=str_replace("/(<\/?)(p)([^>]*>)", "",$id_golongan);
		$id_golongan=str_replace("'", '"',$id_golongan);
		$nama_golongan=trim(@$_POST["nama_golongan"]);
		$nama_golongan=str_replace("/(<\/?)(p)([^>]*>)", "",$nama_golongan);
		$nama_golongan=str_replace("'", '"',$nama_golongan);
		$grooming_golongan=trim(@$_POST["grooming_golongan"]);
		$keterangan_golongan=trim(@$_POST["keterangan_golongan"]);
		$keterangan_golongan=str_replace("/(<\/?)(p)([^>]*>)", "",$keterangan_golongan);
		$keterangan_golongan=str_replace("'", '"',$keterangan_golongan);
		$golongan_creator=trim(@$_POST["golongan_creator"]);
		$golongan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$golongan_creator);
		$golongan_creator=str_replace("'", '"',$golongan_creator);
		$golongan_date_create=trim(@$_POST["golongan_date_create"]);
		$golongan_update=trim(@$_POST["golongan_update"]);
		$golongan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$golongan_update);
		$golongan_update=str_replace("'", '"',$golongan_update);
		$golongan_date_update=trim(@$_POST["golongan_date_update"]);
		$golongan_revised=trim(@$_POST["golongan_revised"]);
		$result=$this->m_golongan->golongan_create($id_golongan, $nama_golongan, $grooming_golongan, $keterangan_golongan, $golongan_creator ,$golongan_date_create ,$golongan_update ,$golongan_date_update ,$golongan_revised);
		echo $result;
	}

	//function for delete selected record
	function bank_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_golongan->bank_delete($pkid);
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
		$result = $this->m_golongan->bank_search($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$start,$end);
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
		
		$result = $this->m_golongan->bank_print($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=13;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("banklist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Bank Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Bank List'><caption>BANK</caption><thead><tr><th scope='col'>Bank Id</th><th scope='col'>Bank Kode</th><th scope='col'>Bank Nama</th><th scope='col'>Bank Norek</th><th scope='col'>Bank Atasnama</th><th scope='col'>Bank Saldo</th><th scope='col'>Bank Keterangan</th><th scope='col'>Bank Aktif</th><th scope='col'>Bank Creator</th><th scope='col'>Bank Date Create</th><th scope='col'>Bank Update</th><th scope='col'>Bank Date Update</th><th scope='col'>Bank Revised</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Bank</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['bank_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['bank_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_nama']);
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
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_creator']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_date_create']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_update']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_date_update']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_revised']);
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
		
		$query = $this->m_golongan->bank_export_excel($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter);
		
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