<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: master_permintaan_mutasi Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_master_permintaan_mutasi.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 15:43:12
*/

//class of master_minta_mutasi
class C_master_permintaan_mutasi extends Controller {

	//constructor
	function C_master_permintaan_mutasi(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_permintaan_mutasi', '', TRUE);	
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_permintaan_mutasi');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_permintaan_mutasi');
	}
	
	function get_gudang_list(){
		$result=$this->m_master_permintaan_mutasi->get_gudang_list();
		echo $result;
	}
	
	/*Store utk menampilkan semua Gudang */
	function get_gudang_all_list(){
		$result=$this->m_master_permintaan_mutasi->get_gudang_all_list();
		echo $result;
	}
	
	function print_faktur(){
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_permintaan_mutasi->get_laporan("","","",$opsi,"",$faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->no_bukti;
        $data['tanggal'] = $master->tanggal;
		$data['gudang_asal_nama'] = $master->gudang_asal_nama;
		$data['gudang_tujuan_nama'] = $master->gudang_tujuan_nama;
		$print_view=$this->load->view("main/p_faktur_order_mutasi.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/minta_mutasi_faktur.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
		
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		$faktur="";
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode ".$tgl_awal." s/d ".$tgl_akhir;
		}
		
		$data["data_print"]=$this->m_master_permintaan_mutasi->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur);
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_minta_mutasi_tanggal.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_order.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_minta_mutasi_tanggal.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_minta_mutasi_produk.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_order.php",$data,TRUE);break;
			}
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_order.html","w+");
		else if($opsi=='detail')
			$print_file=fopen("print/report_order.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	//for detail action
	//list detail handler action
	function  detail_detail_minta_mutasi_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_master_permintaan_mutasi->detail_detail_minta_mutasi_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_permintaan_mutasi->get_master_id();
		echo $result;
	}
	//
	
	//get master id, note: not done yet
	function get_produk_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		if($task=='detail')
			$result=$this->m_master_permintaan_mutasi->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_permintaan_mutasi->get_produk_all_list($query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_master_permintaan_mutasi->get_produk_selected_list($master_id,$selected_id,$query,$start,$end);
		echo $result;
	}
	//
	
	function get_satuan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		
		if($task=='detail')
			$result=$this->m_master_permintaan_mutasi->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_permintaan_mutasi->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_permintaan_mutasi->get_satuan_selected_list($selected_id);
			
		echo $result;
	}
	
	//add detail
	function detail_detail_minta_mutasi_insert($master_id){
        $domutasi_id = $_POST['domutasi_id']; 
        $domutasi_master=$master_id;
        $domutasi_produk = $_POST['domutasi_produk']; 
		$domutasi_satuan = $_POST['domutasi_satuan']; 
		$domutasi_jumlah = $_POST['domutasi_jumlah'];
		
		$array_dminta_mutasi_id = json_decode(stripslashes($domutasi_id));
		$array_dminta_mutasi_produk = json_decode(stripslashes($domutasi_produk));
		$array_dminta_mutasi_satuan = json_decode(stripslashes($domutasi_satuan));
		$array_dminta_mutasi_jumlah = json_decode(stripslashes($domutasi_jumlah));
		
        $result=$this->m_master_permintaan_mutasi->detail_detail_minta_mutasi_insert($array_dminta_mutasi_id
                                                                            ,$domutasi_master
                                                                            ,$array_dminta_mutasi_produk
                                                                            ,$array_dminta_mutasi_satuan
                                                                            ,$array_dminta_mutasi_jumlah );
        echo $result;
        
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_minta_mutasi_list();
				break;
			case "UPDATE":
				$this->master_minta_mutasi_update();
				break;
			case "CREATE":
				$this->master_minta_mutasi_create();
				break;
			case "CEK":
				$this->master_minta_mutasi_pengecekan();
				break;
			case "DELETE":
				$this->master_minta_mutasi_delete();
				break;
			case "SEARCH":
				$this->master_minta_mutasi_search();
				break;
			case "PRINT":
				$this->master_minta_mutasi_print();
				break;
			case "EXCEL":
				$this->master_minta_mutasi_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_minta_mutasi_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$result=$this->m_master_permintaan_mutasi->master_minta_mutasi_list($query,$start,$end);
		echo $result;
	}

	function master_minta_mutasi_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function master_minta_mutasi_update(){
		//POST variable here
		$omutasi_id=trim(@$_POST["omutasi_id"]);
		$omutasi_no=trim(@$_POST["omutasi_no"]);
		$omutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_no);
		$omutasi_asal=trim(@$_POST["omutasi_asal"]);
		$omutasi_tujuan=trim(@$_POST["omutasi_tujuan"]);
		$omutasi_tanggal=trim(@$_POST["omutasi_tanggal"]);
		$omutasi_keterangan=trim(@$_POST["omutasi_keterangan"]);
		$omutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_keterangan);
		$omutasi_keterangan=stripslashes($omutasi_keterangan);
		$omutasi_status=trim(@$_POST["omutasi_status"]);
		$omutasi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_status);
		$cetak_order = trim(@$_POST["cetak_order"]);
		
		$result = $this->m_master_permintaan_mutasi->master_minta_mutasi_update($omutasi_id, $omutasi_no, $omutasi_asal ,$omutasi_tujuan ,$omutasi_tanggal, $omutasi_keterangan,
																	   $omutasi_status, $cetak_order);
		echo $this->detail_detail_minta_mutasi_insert($result);
	}
	
	//function for create new record
	function master_minta_mutasi_create(){
		//POST varible here
		$omutasi_no=trim(@$_POST["omutasi_no"]);
		$omutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_no);
		$omutasi_asal=trim(@$_POST["omutasi_asal"]);
		$omutasi_tujuan=trim(@$_POST["omutasi_tujuan"]);
		$omutasi_tanggal=trim(@$_POST["omutasi_tanggal"]);
		$omutasi_keterangan=trim(@$_POST["omutasi_keterangan"]);
		$omutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_keterangan);
		$omutasi_keterangan=stripslashes($omutasi_keterangan);
		$omutasi_status=trim(@$_POST["omutasi_status"]);
		$omutasi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_status);
		$cetak_order = trim(@$_POST["cetak_order"]);
		
		$result=$this->m_master_permintaan_mutasi->master_minta_mutasi_create($omutasi_no, $omutasi_asal ,$omutasi_tujuan ,$omutasi_tanggal, $omutasi_keterangan, $omutasi_status, $cetak_order);
		echo $this->detail_detail_minta_mutasi_insert($result);
	}

	function get_permission_op(){
		//$group = (integer) (isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		$id = (integer) (isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
		$result=$this->m_master_permintaan_mutasi->get_permission_op($id);
		echo $result;
	}
	
	//function for delete selected record
	function master_minta_mutasi_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_permintaan_mutasi->master_minta_mutasi_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function master_minta_mutasi_search(){
		//POST varibale here
		$omutasi_id="";
		$omutasi_no=trim(@$_POST["omutasi_no"]);
		$omutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_no);
		$omutasi_no=str_replace("'", '"',$omutasi_no);
		$minta_mutasi_tgl_awal=trim(@$_POST["minta_mutasi_tgl_awal"]);
		$minta_mutasi_tgl_akhir=trim(@$_POST["minta_mutasi_tgl_akhir"]);
		$omutasi_keterangan=trim(@$_POST["omutasi_keterangan"]);
		$omutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_keterangan);
		$omutasi_keterangan=str_replace("'", '"',$omutasi_keterangan);
		$omutasi_status=trim(@$_POST["omutasi_status"]);
		$minta_mutasi_status_acc=trim(@$_POST["minta_mutasi_status_acc"]);
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_permintaan_mutasi->master_minta_mutasi_search($omutasi_id,$omutasi_no ,$minta_mutasi_tgl_awal, $minta_mutasi_tgl_akhir, $omutasi_keterangan, $omutasi_status, 
																	   $start,$end);
		echo $result;
	}


	function master_minta_mutasi_print(){
  		//POST varibale here
		$omutasi_id="";
		$omutasi_no=trim(@$_POST["omutasi_no"]);
		$omutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_no);
		$omutasi_no=str_replace("'", '"',$omutasi_no);
		$minta_mutasi_tgl_awal=trim(@$_POST["minta_mutasi_tgl_awal"]);
		$minta_mutasi_tgl_akhir=trim(@$_POST["minta_mutasi_tgl_akhir"]);
		$omutasi_keterangan=trim(@$_POST["omutasi_keterangan"]);
		$omutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_keterangan);
		$omutasi_keterangan=str_replace("'", '"',$omutasi_keterangan);
		$omutasi_status=trim(@$_POST["omutasi_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"]  = $this->m_master_permintaan_mutasi->master_minta_mutasi_print($omutasi_id,$omutasi_no ,$minta_mutasi_tgl_awal, $minta_mutasi_tgl_akhir,$omutasi_keterangan, $omutasi_status, $option,$filter);
		$print_view=$this->load->view("main/p_list_order_mutasi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_minta_mutasilist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';            
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_minta_mutasi_export_excel(){
		       
		//POST varibale here
		$omutasi_id="";
		$omutasi_no=trim(@$_POST["omutasi_no"]);
		$omutasi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_no);
		$omutasi_no=str_replace("'", '"',$omutasi_no);
		$minta_mutasi_tgl_awal=trim(@$_POST["minta_mutasi_tgl_awal"]);
		$minta_mutasi_tgl_akhir=trim(@$_POST["minta_mutasi_tgl_akhir"]);
		$omutasi_keterangan=trim(@$_POST["omutasi_keterangan"]);
		$omutasi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$omutasi_keterangan);
		$omutasi_keterangan=str_replace("'", '"',$omutasi_keterangan);
		$omutasi_status=trim(@$_POST["omutasi_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_permintaan_mutasi->master_minta_mutasi_export_excel($omutasi_id,$omutasi_no,$minta_mutasi_tgl_awal, 
																		   $minta_mutasi_tgl_akhir,$omutasi_keterangan, 
																		   $omutasi_status,$option,$filter);
		
		$this->load->plugin('to_excel');
		
		to_excel($query,"master_minta_mutasi"); 
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