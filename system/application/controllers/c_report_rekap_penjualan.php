<?php
/* 
	+ Module  		: top Spender Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_report_top_spender.php
 	+ Author  		: Isaac
	Edited by 		: Fred 
	
*/

//class of tindakan
class C_report_rekap_penjualan extends Controller {

	//constructor
	function C_report_rekap_penjualan(){
		parent::Controller();
		$this->load->model('m_report_rekap_penjualan', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_report_rekap_penjualan');
	}
	
	function get_group_produk_list(){
		$result=$this->m_public_function->get_group_produk_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "SEARCH":
				$this->rekap_penjualan_search();
				break;
			case "SEARCH2":
				$this->rekap_penjualan_search2();
				break;
			case "SEARCH3":
				$this->rekap_penjualan_search3();
				break;
			case "PRINT":
				$this->tindakan_print();
				break;
			case "EXCEL":
				$this->tindakan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	

	//function for advanced search
	function rekap_penjualan_search(){
		//POST varibale here
		if(trim(@$_POST["rekap_penjualan_tglapp_start"])!="")
			$rekap_penjualan_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_start"])));
		else
			$rekap_penjualan_tglapp_start="";
		if(trim(@$_POST["rekap_penjualan_tglapp_end"])!="")
			$rekap_penjualan_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_end"])));
		else
			$rekap_penjualan_tglapp_end="";

		$rekap_penjualan_jenis=trim(@$_POST["rekap_penjualan_jenis"]);
		$rekap_penjualan_group=trim(@$_POST["rekap_penjualan_group"]);
		$rekap_penjualan_group_1=trim(@$_POST["rekap_penjualan_group_1"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$result = $this->m_report_top_spender->top_spender_search($trawat_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter ,$start,$end);
		$result = $this->m_report_rekap_penjualan->rekap_penjualan_search($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1, $start,$end);
		echo $result;
	}
	
	//function for advanced search
	function rekap_penjualan_search2(){
		//POST varibale here
		if(trim(@$_POST["rekap_penjualan_tglapp_start"])!="")
			$rekap_penjualan_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_start"])));
		else
			$rekap_penjualan_tglapp_start="";
		if(trim(@$_POST["rekap_penjualan_tglapp_end"])!="")
			$rekap_penjualan_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_end"])));
		else
			$rekap_penjualan_tglapp_end="";
			
		$rekap_penjualan_jenis=trim(@$_POST["rekap_penjualan_jenis"]);
		$rekap_penjualan_group=trim(@$_POST["rekap_penjualan_group"]);
		$rekap_penjualan_group_1=trim(@$_POST["rekap_penjualan_group_1"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$result = $this->m_report_top_spender->top_spender_search($trawat_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter ,$start,$end);
		$result = $this->m_report_rekap_penjualan->rekap_penjualan_search2($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1, $start,$end);
		echo $result;
	}
	
	//function for advanced search
	function rekap_penjualan_search3(){
		//POST varibale here
		if(trim(@$_POST["rekap_penjualan_tglapp_start"])!="")
			$rekap_penjualan_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_start"])));
		else
			$rekap_penjualan_tglapp_start="";
		if(trim(@$_POST["rekap_penjualan_tglapp_end"])!="")
			$rekap_penjualan_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_end"])));
		else
			$rekap_penjualan_tglapp_end="";
			
		$rekap_penjualan_jenis=trim(@$_POST["rekap_penjualan_jenis"]);
		$rekap_penjualan_group=trim(@$_POST["rekap_penjualan_group"]);
		$rekap_penjualan_group_1=trim(@$_POST["rekap_penjualan_group_1"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$result = $this->m_report_top_spender->top_spender_search($trawat_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter ,$start,$end);
		$result = $this->m_report_rekap_penjualan->rekap_penjualan_search3($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group,$rekap_penjualan_group_1, $start,$end);
		echo $result;
	}


	function tindakan_print(){
  		//POST varibale here
		
		if(trim(@$_POST["rekap_penjualan_tglapp_start"])!="")
			$rekap_penjualan_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_start"])));
		else
			$rekap_penjualan_tglapp_start="";
		if(trim(@$_POST["rekap_penjualan_tglapp_end"])!="")
			$rekap_penjualan_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["rekap_penjualan_tglapp_end"])));
		else
			$rekap_penjualan_tglapp_end="";
			
		$rekap_penjualan_jenis=trim(@$_POST["rekap_penjualan_jenis"]);
		$rekap_penjualan_group=trim(@$_POST["rekap_penjualan_group"]);
		$rekap_penjualan_group_1=trim(@$_POST["rekap_penjualan_group_1"]);
		
		//$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		//$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		/*
		$rekap_penjualan_tglapp_start=trim(@$_POST["rekap_penjualan_tglapp_start"]);
		$rekap_penjualan_tglapp_end=trim(@$_POST["rekap_penjualan_tglapp_end"]);
		$rekap_penjualan_jenis=trim(@$_POST["rekap_penjualan_jenis"]);
		$rekap_penjualan_group=trim(@$_POST["rekap_penjualan_group"]);
		*/
		
		
		$result = $this->m_report_rekap_penjualan->tindakan_print($rekap_penjualan_tglapp_start ,$rekap_penjualan_tglapp_end ,$rekap_penjualan_jenis, $rekap_penjualan_group, $rekap_penjualan_group_1);		
		$rs=$result->row();
		$jumlah_result=$result->result();
		
		if($rekap_penjualan_jenis == 'Perawatan' || $rekap_penjualan_jenis == 'Pengambilan_Paket'){
			if($rekap_penjualan_group == 2){
				$rekap_penjualan_group_label = 'Medis';
			}else if($rekap_penjualan_group == 3){
				$rekap_penjualan_group_label = 'Non Medis';
			}else if($rekap_penjualan_group == 4){
				$rekap_penjualan_group_label = 'Surgery';
			}else if($rekap_penjualan_group == 16){
				$rekap_penjualan_group_label = 'Anti Aging';
			}else
				$rekap_penjualan_group_label = 'Semua';
		}else{
			$rekap_penjualan_group_label = $rekap_penjualan_group;
		}
		
		if($rekap_penjualan_jenis == 'Pengambilan_Paket'){
			$rekap_penjualan_jenis = $rekap_penjualan_jenis;
		}else{
			$rekap_penjualan_jenis = 'Penjualan '.$rekap_penjualan_jenis;
		}
		
		$data['kode']=$rs->kode;
		$data['rekap_penjualan_jenis']=$rekap_penjualan_jenis;
		$data['rekap_penjualan_tglapp_start']=$rekap_penjualan_tglapp_start;
		$data['rekap_penjualan_tglapp_end']=$rekap_penjualan_tglapp_end;
		$data['rekap_penjualan_group_label']=$rekap_penjualan_group_label;
		$data['nama']=$rs->nama;
		$data['total_jumlah']=$rs->total_jumlah;
		$data['subtotal']=$rs->subtotal;
		$data['diskon_tambahan']=$rs->diskon_tambahan;
		$data['grand_total']=$rs->grand_total;
		$data['jum_retur']=$rs->jum_retur;
		$data['tot_retur']=$rs->tot_retur;
		$data['tot_jum_item']=$rs->tot_jum_item;
		$data['tot_net']=$rs->tot_net;
		$data['jumlah_result']=$jumlah_result;
		
		//$nbrows=$result->num_rows();
		$viewdata=$this->load->view("main/p_report_rekap",$data,TRUE);

		$file = fopen("print/report_rekap.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function tindakan_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_report_top_spender->tindakan_export_excel($trawat_id ,$trawat_dokter ,$option,$filter);
		
		to_excel($query,"tindakan"); 
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