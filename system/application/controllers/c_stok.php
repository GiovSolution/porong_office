<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: stok Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_stok.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of stok
class C_stok extends Controller {

	//constructor
	function C_stok(){
		parent::Controller();
		$this->load->model('m_stok', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_stok');
	}
	
	//event handler action
	function get_action(){
		$task = isset($_POST['task'])?@$_POST['task']:@$_GET['task'];
		switch($task){
			case "LIST":
				$this->stok_list();
				break;
			case "UPDATE":
				$this->stok_update();
				break;
			case "CREATE":
				$this->stok_create();
				break;
			case "DELETE":
				$this->stok_delete();
				break;
			case "SEARCH":
				$this->stok_search();
				break;
			case "PRINT":
				$this->stok_print();
				break;
			case "EXCEL":
				$this->stok_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function stok_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_stok->stok_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function stok_update(){
		//POST variable here
		$stok_id=trim(@$_POST["stok_id"]);
		$stok_produk=trim(@$_POST["stok_produk"]);
		$stok_gudang=trim(@$_POST["stok_gudang"]);
		$stok_jumlah=trim(@$_POST["stok_jumlah"]);
		$stok_date_update=trim(@$_POST["stok_date_update"]);
		$result = $this->m_stok->stok_update($stok_id ,$stok_produk ,$stok_gudang ,$stok_jumlah ,$stok_date_update );
		echo $result;
	}
	
	//function for create new record
	function stok_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$stok_produk=trim(@$_POST["stok_produk"]);
		$stok_gudang=trim(@$_POST["stok_gudang"]);
		$stok_jumlah=trim(@$_POST["stok_jumlah"]);
		$stok_date_update=trim(@$_POST["stok_date_update"]);
		$result=$this->m_stok->stok_create($stok_produk ,$stok_gudang ,$stok_jumlah ,$stok_date_update );
		echo $result;
	}

	//function for delete selected record
	function stok_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_stok->stok_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function stok_search(){
		//POST varibale here
		$stok_id=trim(@$_POST["stok_id"]);
		$stok_produk=trim(@$_POST["stok_produk"]);
		$stok_gudang=trim(@$_POST["stok_gudang"]);
		$stok_jumlah=trim(@$_POST["stok_jumlah"]);
		$stok_date_update=trim(@$_POST["stok_date_update"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_stok->stok_search($stok_id ,$stok_produk ,$stok_gudang ,$stok_jumlah ,$stok_date_update ,$start,$end);
		echo $result;
	}


	function stok_print(){
  		//POST varibale here
		$stok_id=trim(@$_POST["stok_id"]);
		$stok_produk=trim(@$_POST["stok_produk"]);
		$stok_gudang=trim(@$_POST["stok_gudang"]);
		$stok_jumlah=trim(@$_POST["stok_jumlah"]);
		$stok_date_update=trim(@$_POST["stok_date_update"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_stok->stok_print($stok_id ,$stok_produk ,$stok_gudang ,$stok_jumlah ,$stok_date_update ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=5;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("stoklist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Stok Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Stok List'><caption>STOK</caption><thead><tr><th scope='col'>Stok Id</th><th scope='col'>Stok Produk</th><th scope='col'>Stok Gudang</th><th scope='col'>Stok Jumlah</th><th scope='col'>Stok Date Update</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Stok</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['stok_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['stok_produk']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['stok_gudang']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['stok_jumlah']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['stok_date_update']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function stok_export_excel(){
		//POST varibale here
		$stok_id=trim(@$_POST["stok_id"]);
		$stok_produk=trim(@$_POST["stok_produk"]);
		$stok_gudang=trim(@$_POST["stok_gudang"]);
		$stok_jumlah=trim(@$_POST["stok_jumlah"]);
		$stok_date_update=trim(@$_POST["stok_date_update"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_stok->stok_export_excel($stok_id ,$stok_produk ,$stok_gudang ,$stok_jumlah ,$stok_date_update ,$option,$filter);
		
		to_excel($query,"stok"); 
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