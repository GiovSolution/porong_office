<?php
/* 
	GIOV Solution - Keep IT Simple
*/

//class of master_order_beli
class C_master_minta_beli extends Controller {

	//constructor
	function C_master_minta_beli(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_minta_beli', '', TRUE);	
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_minta_beli');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_order');
	}
	
	function print_faktur(){
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_minta_beli->get_laporan("","","",$opsi,"",$faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->no_bukti;
        $data['tanggal'] = $master->tanggal;
        $data['supplier_nama'] = $master->supplier_nama;
		$print_view=$this->load->view("main/p_faktur_pesanan_pembelian.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/order_faktur.html","w+");
		
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
		
		$data["data_print"]=$this->m_master_minta_beli->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur);
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_order_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_rekap_order_supplier.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_order.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_order_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_detail_order_supplier.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_order_produk.php",$data,TRUE);break;
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
	function  detail_detail_minta_beli_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		if($task=='detail')
			$result=$this->m_master_minta_beli->detail_detail_minta_beli_list($master_id,$query,$start,$end);

		echo $result;
	}
	//end of handler
	
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_minta_beli->get_master_id();
		echo $result;
	}
	//
	
	function get_gudang_list(){
		$result=$this->m_master_minta_beli->get_gudang_list();
		echo $result;
	}
	
	//get master id, note: not done yet
	function get_supplier_list(){
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$query=isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$result=$this->m_public_function->get_supplier_list($query, $start,$end);
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
		$supplier_id = isset($_POST['supplier_id']) ? @$_POST['supplier_id'] : @$_GET['supplier_id'];
		if($task=='detail')
			$result=$this->m_master_minta_beli->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_minta_beli->get_produk_all_list($query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_master_minta_beli->get_produk_selected_list($master_id,$selected_id,$query,$start,$end);
		elseif($task=='op_last_price')
			$result=$this->m_master_minta_beli->get_pp_last_price($supplier_id);
		echo $result;
	}
	//
	
	//get master id, note: not done yet
	function get_pp_last_price(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$supplier_id = isset($_POST['supplier_id']) ? @$_POST['supplier_id'] : @$_GET['supplier_id'];
		$produk_id = isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id'];
		$minta_tanggal = isset($_POST['minta_tanggal']) ? @$_POST['minta_tanggal'] : @$_GET['minta_tanggal'];
		if($task=='detail')
			$result=$this->m_master_minta_beli->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='op_last_price')
			$result=$this->m_master_minta_beli->get_pp_last_price($supplier_id, $produk_id, $minta_tanggal);
		echo $result;
	}
	//
	
	
	function get_satuan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		
		if($task=='detail')
			$result=$this->m_master_minta_beli->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_minta_beli->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_minta_beli->get_satuan_selected_list($selected_id);
			
		echo $result;
	}
	
	/*Function untuk melakukan Save Harga */
	function detail_save_harga_insert(){
		$dminta_id = $_POST['dminta_id']; // Get our array back and translate it :
		$array_dminta_id = json_decode(stripslashes($dminta_id));
		
		$dminta_harga = $_POST['dminta_harga']; // Get our array back and translate it :
		$array_dminta_harga = json_decode(stripslashes($dminta_harga));
		
		$dminta_produk = $_POST['dminta_produk']; 
		$array_dminta_produk = json_decode(stripslashes($dminta_produk));
		
		$result=$this->m_master_minta_beli->detail_save_harga_insert($array_dminta_id, $array_dminta_harga, $array_dminta_produk);
		echo $result;
	}
	
	//add detail
	function detail_detail_minta_beli_insert($master_id){
        $dminta_id = $_POST['dminta_id']; 
        $dminta_master=$master_id;
        $dminta_produk = $_POST['dminta_produk']; 
		$dminta_satuan = $_POST['dminta_satuan']; 
		$dminta_jumlah = $_POST['dminta_jumlah'];
		$dminta_harga = $_POST['dminta_harga']; 
		$dminta_diskon = $_POST['dminta_diskon']; 
		$dminta_keterangan = $_POST['dminta_keterangan']; 
		
		$array_dminta_id = json_decode(stripslashes($dminta_id));
		$array_dminta_produk = json_decode(stripslashes($dminta_produk));
		$array_dminta_satuan = json_decode(stripslashes($dminta_satuan));
		$array_dminta_jumlah = json_decode(stripslashes($dminta_jumlah));
		$array_dminta_harga = json_decode(stripslashes($dminta_harga));
		$array_dminta_diskon = json_decode(stripslashes($dminta_diskon));
		$array_dminta_keterangan = json_decode(stripslashes($dminta_keterangan));
		
        $result=$this->m_master_minta_beli->detail_detail_minta_beli_insert($array_dminta_id
                                                                            ,$dminta_master
                                                                            ,$array_dminta_produk
                                                                            ,$array_dminta_satuan
                                                                            ,$array_dminta_jumlah
                                                                            ,$array_dminta_harga
                                                                            ,$array_dminta_diskon
                                                                            ,$array_dminta_keterangan );
        echo $result;
        
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_minta_beli_list();
				break;
			case "UPDATE":
				$this->master_minta_beli_update();
				break;
			case "CREATE":
				$this->master_minta_beli_create();
				break;
			case "CEK":
				$this->master_minta_beli_pengecekan();
				break;
			case "DELETE":
				$this->master_minta_beli_delete();
				break;
			case "SEARCH":
				$this->master_minta_beli_search();
				break;
			case "PRINT":
				$this->master_minta_beli_print();
				break;
			case "EXCEL":
				$this->master_minta_beli_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_minta_beli_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$result=$this->m_master_minta_beli->master_minta_beli_list($query,$start,$end);
		echo $result;
	}

	function master_minta_beli_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function master_minta_beli_update(){
		//POST variable here
		$minta_id=trim(@$_POST["minta_id"]);
		$minta_no=trim(@$_POST["minta_no"]);
		$minta_no=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_no);
		$minta_supplier=trim(@$_POST["minta_supplier"]);
		$minta_gudang=trim(@$_POST["minta_gudang"]);
		$minta_tanggal=trim(@$_POST["minta_tanggal"]);
		$order_carabayar=trim(@$_POST["order_carabayar"]);
		$order_carabayar=str_replace("/(<\/?)(p)([^>]*>)", "",$order_carabayar);
		$order_cashback=trim(@$_POST["order_cashback"]);
		$order_diskon=trim(@$_POST["order_diskon"]);
		$order_biaya=trim(@$_POST["order_biaya"]);
		$order_bayar=trim(@$_POST["order_bayar"]);
		$minta_keterangan=trim(@$_POST["minta_keterangan"]);
		$minta_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_keterangan);
		$minta_keterangan=stripslashes($minta_keterangan);
		$minta_status=trim(@$_POST["minta_status"]);
		$minta_status=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_status);
		$minta_status_acc=trim(@$_POST["minta_status_acc"]);
		$minta_status_acc=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_status_acc);
		$cetak_minta = trim(@$_POST["cetak_minta"]);
		$minta_jenis = trim(@$_POST["minta_jenis"]);
		
		$result = $this->m_master_minta_beli->master_minta_beli_update($minta_id, $minta_no, $minta_supplier, $minta_gudang, $minta_tanggal, $order_carabayar, 
																	   $order_diskon, $order_cashback, $order_biaya, $order_bayar, $minta_keterangan,
																	   $minta_status, $minta_status_acc, $cetak_minta, $minta_jenis);
		echo $this->detail_detail_minta_beli_insert($result);
	}
	
	//function for create new record
	function master_minta_beli_create(){
		//POST varible here
		$minta_no=trim(@$_POST["minta_no"]);
		$minta_no=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_no);
		$minta_supplier=trim(@$_POST["minta_supplier"]);
		$minta_gudang=trim(@$_POST["minta_gudang"]);
		$minta_tanggal=trim(@$_POST["minta_tanggal"]);
		$order_carabayar=trim(@$_POST["order_carabayar"]);
		$order_carabayar=str_replace("/(<\/?)(p)([^>]*>)", "",$order_carabayar);
		$order_cashback=trim(@$_POST["order_cashback"]);
		$order_diskon=trim(@$_POST["order_diskon"]);
		$order_biaya=trim(@$_POST["order_biaya"]);
		$order_bayar=trim(@$_POST["order_bayar"]);
		$minta_keterangan=trim(@$_POST["minta_keterangan"]);
		$minta_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_keterangan);
		$minta_keterangan=stripslashes($minta_keterangan);
		$minta_status=trim(@$_POST["minta_status"]);
		$minta_status=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_status);
		$minta_status_acc=trim(@$_POST["minta_status_acc"]);
		$minta_status_acc=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_status_acc);
		$cetak_minta = trim(@$_POST["cetak_minta"]);
		$minta_jenis = trim(@$_POST["minta_jenis"]);
		
		$result=$this->m_master_minta_beli->master_minta_beli_create($minta_no, $minta_supplier, $minta_gudang, $minta_tanggal, $order_carabayar, $order_diskon, 
																	 $order_cashback, $order_biaya, $order_bayar, $minta_keterangan, $minta_status, 
																	 $minta_status_acc,$cetak_minta, $minta_jenis);
		echo $this->detail_detail_minta_beli_insert($result);
	}

	function get_permission_op(){
		//$group = (integer) (isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		$id = (integer) (isset($_POST['id']) ? $_POST['id'] : $_GET['id']);
		$result=$this->m_master_minta_beli->get_permission_op($id);
		echo $result;
	}
	
	//function for delete selected record
	function master_minta_beli_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_minta_beli->master_minta_beli_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function master_minta_beli_search(){
		//POST varibale here
		$minta_id="";
		$minta_no=trim(@$_POST["minta_no"]);
		$minta_no=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_no);
		$minta_no=str_replace("'", '"',$minta_no);
		$minta_supplier=trim(@$_POST["minta_supplier"]);
		$order_tgl_awal=trim(@$_POST["order_tgl_awal"]);
		$order_tgl_akhir=trim(@$_POST["order_tgl_akhir"]);
		$order_carabayar=trim(@$_POST["order_carabayar"]);
		$order_carabayar=str_replace("/(<\/?)(p)([^>]*>)", "",$order_carabayar);
		$order_carabayar=str_replace("'", '"',$order_carabayar);
		$minta_keterangan=trim(@$_POST["minta_keterangan"]);
		$minta_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_keterangan);
		$minta_keterangan=str_replace("'", '"',$minta_keterangan);
		$minta_status=trim(@$_POST["minta_status"]);
		$minta_status_acc=trim(@$_POST["minta_status_acc"]);
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_minta_beli->master_minta_beli_search($minta_id,$minta_no ,$minta_supplier ,$order_tgl_awal, $order_tgl_akhir,
																	   $order_carabayar,$minta_keterangan, $minta_status, $minta_status_acc,
																	   $start,$end);
		echo $result;
	}


	function master_minta_beli_print(){
  		//POST varibale here
		$minta_id="";
		$minta_no=trim(@$_POST["minta_no"]);
		$minta_no=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_no);
		$minta_no=str_replace("'", '"',$minta_no);
		$minta_supplier=trim(@$_POST["minta_supplier"]);
		$order_tgl_awal=trim(@$_POST["order_tgl_awal"]);
		$order_tgl_akhir=trim(@$_POST["order_tgl_akhir"]);
		$order_carabayar=trim(@$_POST["order_carabayar"]);
		$order_carabayar=str_replace("/(<\/?)(p)([^>]*>)", "",$order_carabayar);
		$order_carabayar=str_replace("'", '"',$order_carabayar);
		$minta_keterangan=trim(@$_POST["minta_keterangan"]);
		$minta_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_keterangan);
		$minta_keterangan=str_replace("'", '"',$minta_keterangan);
		$minta_status=trim(@$_POST["minta_status"]);
		$minta_status_acc=trim(@$_POST["minta_status_acc"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"]  = $this->m_master_minta_beli->master_minta_beli_print($minta_id,$minta_no ,$minta_supplier ,$order_tgl_awal, 
																				   $order_tgl_akhir,$order_carabayar,$minta_keterangan, 
																				   $minta_status, $minta_status_acc,$option,$filter);
		$print_view=$this->load->view("main/p_list_order.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_order_belilist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';            
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_minta_beli_export_excel(){
		       
		//POST varibale here
		$minta_id="";
		$minta_no=trim(@$_POST["minta_no"]);
		$minta_no=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_no);
		$minta_no=str_replace("'", '"',$minta_no);
		$minta_supplier=trim(@$_POST["minta_supplier"]);
		$order_tgl_awal=trim(@$_POST["order_tgl_awal"]);
		$order_tgl_akhir=trim(@$_POST["order_tgl_akhir"]);
		$order_carabayar=trim(@$_POST["order_carabayar"]);
		$order_carabayar=str_replace("/(<\/?)(p)([^>]*>)", "",$order_carabayar);
		$order_carabayar=str_replace("'", '"',$order_carabayar);
		$minta_keterangan=trim(@$_POST["minta_keterangan"]);
		$minta_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$minta_keterangan);
		$minta_keterangan=str_replace("'", '"',$minta_keterangan);
		$minta_status=trim(@$_POST["minta_status"]);
		$minta_status_acc=trim(@$_POST["minta_status_acc"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_minta_beli->master_minta_beli_export_excel($minta_id,$minta_no ,$minta_supplier ,$order_tgl_awal, 
																		   $order_tgl_akhir,$order_carabayar,$minta_keterangan, 
																		   $minta_status, $minta_status_acc,$option,$filter);
		
		$this->load->plugin('to_excel');
		
		to_excel($query,"master_order_beli"); 
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