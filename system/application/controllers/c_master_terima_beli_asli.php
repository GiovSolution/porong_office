<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: master_terima_beli Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_master_terima_beli.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 15:44:15
	
*/

//class of master_terima_beli
class C_master_terima_beli extends Controller {

	//constructor
	function C_master_terima_beli(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_terima_beli', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_terima_beli');
		
	}
	
	function laporan(){
		$this->load->view('main/v_lap_terima_beli');
	}
	
	function print_faktur(){
		
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
	
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_terima_beli->get_laporan("","","",$opsi,"",$faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = @$info->info_nama;
		$data['no_bukti'] = @$master->no_bukti;
		$data['no_surat_jalan']=@$master->terima_surat_jalan;
        $data['tanggal'] = @$master->tanggal;
        $data['supplier_nama'] = @$master->supplier_nama;
		$data['order_no'] = @$master->order_no;
		$print_view=$this->load->view("main/p_faktur_terima_pembelian.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/terima_faktur.html","w+");
		
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
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode ".$tgl_awal." s/d ".$tgl_akhir;
		}
		
		$data["data_print"]=$this->m_master_terima_beli->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,"");
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_terima_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_rekap_terima_supplier.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_terima.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_terima_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_detail_terima_supplier.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_terima_produk.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_terima.php",$data,TRUE);break;
			}
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_terimabeli.html","w+");
		else
			$print_file=fopen("print/report_terimabeli.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	
	function get_order_beli_detail_by_order_id(){
		$orderid = isset($_POST['orderid']) ? @$_POST['orderid'] : "";
		$result=$this->m_public_function->get_order_beli_detail_by_order_id($orderid);
		echo $result;
	}
	

	function get_produk_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$order_id = isset($_POST['order_id']) ? @$_POST['order_id'] : @$_GET['order_id'];
		if($task=='detail')
			$result=$this->m_master_terima_beli->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_terima_beli->get_produk_all_list($query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_master_terima_beli->get_produk_selected_list($master_id, $selected_id,$query,$start,$end);
		elseif($task=='order')
			$result=$this->m_master_terima_beli->get_produk_order_list($order_id,$query,$start,$end);
		echo $result;
	}
	
	function get_satuan_list(){
		//$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$order_id = isset($_POST['order_id']) ? @$_POST['order_id'] : @$_GET['order_id'];
		
		if($task=='detail')
			$result=$this->m_master_terima_beli->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_master_terima_beli->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_master_terima_beli->get_satuan_selected_list($selected_id);
		elseif($task=='order')
			$result=$this->m_master_terima_beli->get_satuan_order_list($order_id);
			
		echo $result;
	}
	
	function get_bonus_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		if($task=='detail')
			$result=$this->m_master_terima_beli->get_bonus_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_master_terima_beli->get_produk_all_list($query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_master_terima_beli->get_produk_selected_list($master_id,$selected_id,$query,$start,$end);
		echo $result;
	}
	
	
	function get_order_beli_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_master_terima_beli->get_order_beli_list($query,$start, $end);
		echo $result;
	}
	
	function get_order_beli_search_list(){
		$result=$this->m_master_terima_beli->get_order_beli_search_list();
		echo $result;
	}
	
	function get_supplier_search_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_master_terima_beli->get_supplier_search_list($query);
		echo $result;
	}
	
	function get_terima_gudang_list(){
		$result=$this->m_master_terima_beli->get_terima_gudang_list();
		echo $result;
	}
	
	function get_produk_detail_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_master_terima_beli->get_produk_detail_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	function get_dorder_satuan_by_produkorder(){
		$dorder_master = trim(@$_POST["master_order_id"]);
		$dorder_produk = trim(@$_POST["dorder_produk_id"]);
		$result=$this->m_master_terima_beli->get_dorder_satuan_by_produkorder($dorder_master, $dorder_produk);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_detail_terima_bonus_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_master_terima_beli->detail_detail_terima_bonus_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	
	//add detail
	function detail_detail_terima_bonus_insert($master_id){
	//POST variable here
		$dtbonus_id = $_POST['dtbonus_id']; 
        $dtbonus_master=$master_id;
        $dtbonus_produk = $_POST['dtbonus_produk']; 
		$dtbonus_satuan = $_POST['dtbonus_satuan']; 
		$dtbonus_jumlah = $_POST['dtbonus_jumlah'];

		
		$array_dtbonus_id = json_decode(stripslashes($dtbonus_id));
		$array_dtbonus_produk = json_decode(stripslashes($dtbonus_produk));
		$array_dtbonus_satuan = json_decode(stripslashes($dtbonus_satuan));
		$array_dtbonus_jumlah = json_decode(stripslashes($dtbonus_jumlah));

		$result=$this->m_master_terima_beli->detail_detail_terima_bonus_insert($array_dtbonus_id ,$dtbonus_master ,
																			   $array_dtbonus_produk ,
																			   $array_dtbonus_satuan ,$array_dtbonus_jumlah );
		//echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_detail_terima_beli_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_master_terima_beli->detail_detail_terima_beli_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_terima_beli->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_detail_terima_beli_insert($master_id){
	//POST variable here
		$dterima_id = $_POST['dterima_id']; 
        $dterima_master=$master_id;
        $dterima_produk = $_POST['dterima_produk']; 
		$dterima_satuan = $_POST['dterima_satuan']; 
		$dterima_jumlah = $_POST['dterima_jumlah'];
		$dterima_harga = $_POST['dterima_harga'];
		$dterima_diskon = $_POST['dterima_diskon'];

		
		$array_dterima_id = json_decode(stripslashes($dterima_id));
		$array_dterima_produk = json_decode(stripslashes($dterima_produk));
		$array_dterima_satuan = json_decode(stripslashes($dterima_satuan));
		$array_dterima_jumlah = json_decode(stripslashes($dterima_jumlah));
		$array_dterima_harga = json_decode(stripslashes($dterima_harga));
		$array_dterima_diskon = json_decode(stripslashes($dterima_diskon));
		
		$result=$this->m_master_terima_beli->detail_detail_terima_beli_insert($array_dterima_id ,$dterima_master ,$array_dterima_produk ,
																			  $array_dterima_satuan ,$array_dterima_jumlah, $array_dterima_harga, $array_dterima_diskon);
		return $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = @$_POST['task'];
		switch($task){
			case "LIST":
				$this->master_terima_beli_list();
				break;
			case "UPDATE":
				$this->master_terima_beli_update();
				break;
			case "CREATE":
				$this->master_terima_beli_create();
				break;
			case "CEK":
				$this->master_terima_beli_pengecekan();
				break;	
			case "DELETE":
				$this->master_terima_beli_delete();
				break;
			case "SEARCH":
				$this->master_terima_beli_search();
				break;
			case "PRINT":
				$this->master_terima_beli_print();
				break;
			case "EXCEL":
				$this->master_terima_beli_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function check_all_order_done(){
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$this->m_master_terima_beli->check_all_order_done($master_id);
	}
	
	//function fot list record
	function master_terima_beli_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] :@$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_master_terima_beli->master_terima_beli_list($query,$start,$end);
		echo $result;
	}

	function master_terima_beli_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function master_terima_beli_update(){
		//POST variable here
		$terima_id=trim(@$_POST["terima_id"]);
		$terima_no=trim(@$_POST["terima_no"]);
		$terima_no=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_no);
		$terima_gudang=trim(@$_POST["terima_gudang"]);
		$terima_order=trim(@$_POST["terima_order"]);
		$terima_order_id=trim(@$_POST["terima_order_id"]);
		$terima_supplier=trim(@$_POST["terima_supplier"]);
		$terima_surat_jalan=trim(@$_POST["terima_surat_jalan"]);
		$terima_surat_jalan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_surat_jalan);
		$terima_pengirim=trim(@$_POST["terima_pengirim"]);
		$terima_pengirim=stripslashes($terima_pengirim);
		$terima_tanggal=trim(@$_POST["terima_tanggal"]);
		$terima_keterangan=trim(@$_POST["terima_keterangan"]);
		$terima_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_keterangan);
		$terima_keterangan=stripslashes($terima_keterangan);
		$terima_status=trim(@$_POST["terima_status"]);
		$cetak=trim(@$_POST["cetak"]);
		
		$result = $this->m_master_terima_beli->master_terima_beli_update($terima_id ,$terima_no ,$terima_order , $terima_order_id,$terima_supplier ,
																		 $terima_surat_jalan ,$terima_pengirim ,$terima_tanggal ,
																		 $terima_keterangan, $terima_status,$cetak, $terima_gudang  );
		$this->detail_detail_terima_bonus_insert($result);
		$result=$this->detail_detail_terima_beli_insert($result);
		echo $result;
	}
	
	//function for create new record
	function master_terima_beli_create(){
		//POST varible here
		$terima_no=trim(@$_POST["terima_no"]);
		$terima_no=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_no);
		$terima_gudang=trim(@$_POST["terima_gudang"]);
		$terima_order=trim(@$_POST["terima_order"]);
		$terima_order_id=trim(@$_POST["terima_order_id"]);
		$terima_supplier=trim(@$_POST["terima_supplier"]);
		$terima_surat_jalan=trim(@$_POST["terima_surat_jalan"]);
		$terima_surat_jalan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_surat_jalan);
		$terima_pengirim=trim(@$_POST["terima_pengirim"]);
		$terima_pengirim=stripslashes($terima_pengirim);
		$terima_tanggal=trim(@$_POST["terima_tanggal"]);
		$terima_keterangan=trim(@$_POST["terima_keterangan"]);
		$terima_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_keterangan);
		$terima_keterangan=stripslashes($terima_keterangan);
		$terima_status=trim(@$_POST["terima_status"]);
		$cetak=trim(@$_POST["cetak"]);
		
		$terima_total_qty 	= $_POST['terima_total_qty'];
		$terima_total_qty	= str_replace(",", '', $terima_total_qty);
		$terima_total_rp 	= $_POST['terima_total_rp'];
		$terima_total_rp	= str_replace(",", '', $terima_total_rp);
		
		$result=$this->m_master_terima_beli->master_terima_beli_create($terima_no ,$terima_order ,$terima_order_id, $terima_supplier ,$terima_surat_jalan ,
																	   $terima_pengirim ,$terima_tanggal ,$terima_keterangan, $terima_status, $cetak, $terima_gudang,
																	   $terima_total_qty, $terima_total_rp);
		$this->detail_detail_terima_bonus_insert($result);
		$result=$this->detail_detail_terima_beli_insert($result);
		echo $result;
	}

	//function for delete selected record
	function master_terima_beli_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_terima_beli->master_terima_beli_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function master_terima_beli_search(){
		//POST varibale here
		$terima_id=trim(@$_POST["terima_id"]);
		$terima_no=trim(@$_POST["terima_no"]);
		$terima_no=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_no);
		$terima_no=str_replace("'", '"',$terima_no);
		$terima_gudang=trim(@$_POST["terima_gudang"]);
		$terima_supplier=trim(@$_POST["terima_supplier"]);		
		$terima_order=trim(@$_POST["terima_order"]);
		$terima_supplier=trim(@$_POST["terima_supplier"]);
		$terima_surat_jalan=trim(@$_POST["terima_surat_jalan"]);
		$terima_surat_jalan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_surat_jalan);
		$terima_surat_jalan=str_replace("'", '"',$terima_surat_jalan);
		$terima_pengirim=trim(@$_POST["terima_pengirim"]);
		$terima_pengirim=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_pengirim);
		$terima_pengirim=str_replace("'", '"',$terima_pengirim);
		$terima_tgl_awal=trim(@$_POST["terima_tgl_awal"]);
		$terima_tgl_akhir=trim(@$_POST["terima_tgl_akhir"]);
		$terima_keterangan=trim(@$_POST["terima_keterangan"]);
		$terima_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_keterangan);
		$terima_keterangan=str_replace("'", '"',$terima_keterangan);
		$terima_status=trim(@$_POST["terima_status"]);
		
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result = $this->m_master_terima_beli->master_terima_beli_search($terima_id ,$terima_no ,$terima_order ,$terima_supplier ,
																		 $terima_surat_jalan ,$terima_pengirim ,$terima_tgl_awal, 
																		 $terima_tgl_akhir ,$terima_keterangan ,$terima_status, $start,$end, $terima_gudang,$terima_supplier);
		echo $result;
	}


	function master_terima_beli_print(){
  		//POST varibale here
		$terima_id=trim(@$_POST["terima_id"]);
		$terima_no=trim(@$_POST["terima_no"]);
		$terima_no=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_no);
		$terima_no=str_replace("'", '"',$terima_no);
		$terima_order=trim(@$_POST["terima_order"]);
		$terima_gudang=trim(@$_POST["terima_gudang"]);
		$terima_supplier=trim(@$_POST["terima_supplier"]);
		$terima_surat_jalan=trim(@$_POST["terima_surat_jalan"]);
		$terima_surat_jalan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_surat_jalan);
		$terima_surat_jalan=str_replace("'", '"',$terima_surat_jalan);
		$terima_pengirim=trim(@$_POST["terima_pengirim"]);
		$terima_pengirim=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_pengirim);
		$terima_pengirim=str_replace("'", '"',$terima_pengirim);
		$terima_tgl_awal=trim(@$_POST["terima_tgl_awal"]);
		$terima_tgl_akhir=trim(@$_POST["terima_tgl_akhir"]);
		$terima_keterangan=trim(@$_POST["terima_keterangan"]);
		$terima_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_keterangan);
		$terima_keterangan=str_replace("'", '"',$terima_keterangan);
		$terima_status=trim(@$_POST["terima_status"]);
		$option=@$_POST['currentlisting'];
		$filter=@$_POST["query"];
		
		$data["data_print"]  = $this->m_master_terima_beli->master_terima_beli_print($terima_id ,$terima_no ,$terima_order ,$terima_supplier ,
																		$terima_surat_jalan ,$terima_pengirim ,$terima_tgl_awal, 
																		$terima_tgl_akhir ,$terima_keterangan , $terima_status, $option,$filter,$terima_gudang);
		$print_view=$this->load->view("main/p_list_terima.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_terima_belilist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';            
		
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_terima_beli_export_excel(){
		//POST varibale here
		$terima_id=trim(@$_POST["terima_id"]);
		$terima_no=trim(@$_POST["terima_no"]);
		$terima_no=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_no);
		$terima_no=str_replace("'", '"',$terima_no);
		$terima_order=trim(@$_POST["terima_order"]);
		$terima_gudang=trim(@$_POST["terima_gudang"]);
		$terima_supplier=trim(@$_POST["terima_supplier"]);
		$terima_surat_jalan=trim(@$_POST["terima_surat_jalan"]);
		$terima_surat_jalan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_surat_jalan);
		$terima_surat_jalan=str_replace("'", '"',$terima_surat_jalan);
		$terima_pengirim=trim(@$_POST["terima_pengirim"]);
		$terima_pengirim=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_pengirim);
		$terima_pengirim=str_replace("'", '"',$terima_pengirim);
		$terima_tgl_awal=trim(@$_POST["terima_tgl_awal"]);
		$terima_tgl_akhir=trim(@$_POST["terima_tgl_akhir"]);
		$terima_keterangan=trim(@$_POST["terima_keterangan"]);
		$terima_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$terima_keterangan);
		$terima_keterangan=str_replace("'", '"',$terima_keterangan);
		$terima_status=trim(@$_POST["terima_status"]);
		$option=@$_POST['currentlisting'];
		$filter=@$_POST["query"];
		
		$query = $this->m_master_terima_beli->master_terima_beli_export_excel($terima_id ,$terima_no ,$terima_order ,$terima_supplier ,
																			  $terima_surat_jalan ,$terima_pengirim ,$terima_tgl_awal ,
																			  $terima_tgl_akhir, $terima_keterangan ,$terima_status,$option,$filter,$terima_gudang);
		
		$this->load->plugin('to_excel');
		to_excel($query,"master_terima_beli"); 
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