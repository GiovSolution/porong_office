<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: customer_note Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_customer_note.php
 	+ Author  		: zainal. mukhlison
 	+ Created on 12/Aug/2009 11:16:45
	
*/

//class of customer_note
class C_customer_note extends Controller {

	//constructor
	function C_customer_note(){
		parent::Controller();
		session_start();
		$this->load->model('m_customer_note', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_customer_note');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->customer_note_list();
				break;
			case "UPDATE":
				$this->customer_note_update();
				break;
			case "CREATE":
				$this->customer_note_create();
				break;
			case "DELETE":
				$this->customer_note_delete();
				break;
			case "SEARCH":
				$this->customer_note_search();
				break;
			case "PRINT":
				$this->customer_note_print();
				break;
			case "EXCEL":
				$this->customer_note_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function customer_note_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_customer_note->customer_note_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function customer_note_update(){
		//POST variable here
		$note_id=trim(@$_POST["note_id"]);
		$note_customer=trim(@$_POST["note_customer"]);
		$note_tanggal=trim(@$_POST["note_tanggal"]);
		$note_detail=trim(@$_POST["note_detail"]);
		$note_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$note_detail);
		$note_detail=str_replace(",", ",",$note_detail);
		$note_detail=str_replace("'", '"',$note_detail);
		$note_aktif=trim(@$_POST["note_aktif"]);
		$note_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$note_aktif);
		$note_aktif=str_replace("'", '"',$note_aktif);
		$note_creator=trim(@$_POST["note_creator"]);
		$note_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$note_creator);
		$note_creator=str_replace(",", ",",$note_creator);
		$note_creator=str_replace("'", '"',$note_creator);
		$note_date_create=trim(@$_POST["note_date_create"]);
		$note_update=trim(@$_POST["note_update"]);
		$note_update=str_replace("/(<\/?)(p)([^>]*>)", "",$note_update);
		$note_update=str_replace(",", ",",$note_update);
		$note_update=str_replace("'", '"',$note_update);
		$note_date_update=trim(@$_POST["note_date_update"]);
		$note_revised=trim(@$_POST["note_revised"]);
		$result = $this->m_customer_note->customer_note_update($note_id ,$note_customer ,$note_tanggal ,$note_detail ,$note_aktif, $note_creator ,$note_date_create ,$note_update ,$note_date_update ,$note_revised );
		echo $result;
	}
	
	//function for create new record
	function customer_note_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$note_customer=trim(@$_POST["note_customer"]);
		$note_tanggal=trim(@$_POST["note_tanggal"]);
		$note_detail=trim(@$_POST["note_detail"]);
		$note_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$note_detail);
		$note_detail=str_replace("'", '"',$note_detail);
		$note_aktif=trim(@$_POST["note_aktif"]);
		$note_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$note_aktif);
		$note_aktif=str_replace("'", '"',$note_aktif);
		$note_creator=trim(@$_POST["note_creator"]);
		$note_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$note_creator);
		$note_creator=str_replace("'", '"',$note_creator);
		$note_date_create=trim(@$_POST["note_date_create"]);
		$note_update=trim(@$_POST["note_update"]);
		$note_update=str_replace("/(<\/?)(p)([^>]*>)", "",$note_update);
		$note_update=str_replace("'", '"',$note_update);
		$note_date_update=trim(@$_POST["note_date_update"]);
		$note_revised=trim(@$_POST["note_revised"]);
		$result=$this->m_customer_note->customer_note_create($note_customer ,$note_tanggal ,$note_detail ,$note_aktif, $note_creator ,$note_date_create ,$note_update ,$note_date_update ,$note_revised );
		echo $result;
	}

	//function for delete selected record
	function customer_note_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_customer_note->customer_note_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function customer_note_search(){
		//POST varibale here
		$note_id=trim(@$_POST["note_id"]);
		$note_customer=trim(@$_POST["note_customer"]);
		$note_tanggal=trim(@$_POST["note_tanggal"]);
		$note_detail=trim(@$_POST["note_detail"]);
		$note_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$note_detail);
		$note_detail=str_replace("'", '"',$note_detail);
		$note_aktif=trim(@$_POST["note_aktif"]);
		$note_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$note_aktif);
		$note_aktif=str_replace("'", '"',$note_aktif);
		$note_creator=trim(@$_POST["note_creator"]);
		$note_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$note_creator);
		$note_creator=str_replace("'", '"',$note_creator);
		$note_date_create=trim(@$_POST["note_date_create"]);
		$note_update=trim(@$_POST["note_update"]);
		$note_update=str_replace("/(<\/?)(p)([^>]*>)", "",$note_update);
		$note_update=str_replace("'", '"',$note_update);
		$note_date_update=trim(@$_POST["note_date_update"]);
		$note_revised=trim(@$_POST["note_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_customer_note->customer_note_search($note_id ,$note_customer ,$note_tanggal ,$note_detail ,$note_aktif, $note_creator ,$note_date_create ,$note_update ,$note_date_update ,$note_revised ,$start,$end);
		echo $result;
	}


	function customer_note_print(){
  		//POST varibale here
		$note_id=trim(@$_POST["note_id"]);
		$note_customer=trim(@$_POST["note_customer"]);
		$note_tanggal=trim(@$_POST["note_tanggal"]);
		$note_detail=trim(@$_POST["note_detail"]);
		$note_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$note_detail);
		$note_detail=str_replace("'", '"',$note_detail);
		$note_creator=trim(@$_POST["note_creator"]);
		$note_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$note_creator);
		$note_creator=str_replace("'", '"',$note_creator);
		$note_date_create=trim(@$_POST["note_date_create"]);
		$note_update=trim(@$_POST["note_update"]);
		$note_update=str_replace("/(<\/?)(p)([^>]*>)", "",$note_update);
		$note_update=str_replace("'", '"',$note_update);
		$note_date_update=trim(@$_POST["note_date_update"]);
		$note_revised=trim(@$_POST["note_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_customer_note->customer_note_print($note_id ,$note_customer ,$note_tanggal ,$note_detail ,$note_creator ,$note_date_create ,$note_update ,$note_date_update ,$note_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=3;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("customer_notelist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Customer_note Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'>
			   		<table summary='Customer_note List'>
					<caption>CUSTOMER_NOTE</caption>
					<thead>
						<tr>
							<th scope='col'>Tanggal dan Jam</th>
							<th scope='col'>No Cust</th>
							<th scope='col'>Customer</th>
							<th scope='col'>Detail Catatan</th>
						</tr>
					</thead>
					<tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Total</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, ">");
				fwrite($file,"<td>");
				fwrite($file, $data['note_tanggal']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cust_no']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cust_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['note_detail']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function customer_note_export_excel(){
		//POST varibale here
		$note_id=trim(@$_POST["note_id"]);
		$note_customer=trim(@$_POST["note_customer"]);
		$note_tanggal=trim(@$_POST["note_tanggal"]);
		$note_detail=trim(@$_POST["note_detail"]);
		$note_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$note_detail);
		$note_detail=str_replace("'", '"',$note_detail);
		$note_creator=trim(@$_POST["note_creator"]);
		$note_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$note_creator);
		$note_creator=str_replace("'", '"',$note_creator);
		$note_date_create=trim(@$_POST["note_date_create"]);
		$note_update=trim(@$_POST["note_update"]);
		$note_update=str_replace("/(<\/?)(p)([^>]*>)", "",$note_update);
		$note_update=str_replace("'", '"',$note_update);
		$note_date_update=trim(@$_POST["note_date_update"]);
		$note_revised=trim(@$_POST["note_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_customer_note->customer_note_export_excel($note_id ,$note_customer ,$note_tanggal ,$note_detail ,$note_creator ,$note_date_create ,$note_update ,$note_date_update ,$note_revised ,$option,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"customer_note"); 
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