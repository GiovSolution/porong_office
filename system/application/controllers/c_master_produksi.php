<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of Master Produksi
class C_master_produksi extends Controller {

	//constructor
	function C_master_produksi(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_produksi', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_produksi');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_kuitansi');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			if($group=="Sisa Kuitansi (Akumulatif)"){
				$data["periode"]="Periode : Awal s/d ".get_ina_month_name($bulan,'long')." ".$tahun; 
				$data["jenis"]='Sisa Kuitansi (Akumulatif)';
			} else {
				$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
				$data["jenis"]='No. Kuitansi';
			}
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			$date_akhir = substr($tgl_akhir,8,2);
			$month_akhir = substr($tgl_akhir,5,2);
			$year_akhir = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date_akhir.'-'.$month_akhir.'-'.$year_akhir;
			
			if($group=="Sisa Kuitansi (Akumulatif)"){
				$data["periode"]="Periode : Awal s/d ".$tgl_akhir_show."";
				$data["jenis"]='Sisa Kuitansi (Akumulatif)';
			} else {
				$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
				$data["jenis"]='No. Kuitansi';
			}
		}
		
		
		$data["data_print"]=$this->m_master_produksi->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$bulan,$tahun);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		if($opsi=='rekap'){
			
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_kuitansi_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_kuitansi_customer.php",$data,TRUE);break;
				case "Sisa Kuitansi (Akumulatif)": $print_view=$this->load->view("main/p_rekap_kuitansi.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_kuitansi.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_kuitansi.html","w");
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_kuitansi_tanggal.php",$data,TRUE);break;
				case "Tanggal (Adjustment)": $print_view=$this->load->view("main/p_detail_kuitansi_tanggal_adj.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_kuitansi_customer.php",$data,TRUE);break;
				case "No Faktur": $print_view=$this->load->view("main/p_detail_kuitansi_faktur.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_kuitansi.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_kuitansi.html","w");

		}
		
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function get_bank_list(){
		$result=$this->m_public_function->get_bank_list();
		echo $result;
	}

	function get_gudang_tujuan_list(){
		$result=$this->m_master_produksi->get_gudang_tujuan_list();
		echo $result;
	}

	function get_gudang_asal_list(){
		$result=$this->m_master_produksi->get_gudang_asal_list();
		echo $result;
	}
	
	function get_supplier_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_supplier_list($query,$start,$end);
		echo $result;
	}
	
	function get_cek_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_cek_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_card_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_card_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_transfer_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_transfer_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_tunai_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_tunai_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	// get produk bahan list
	function get_produk_bahan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$result = $this->m_master_produksi->get_produk_bahan_list($query,$start,$end,$aktif);
		echo $result;
	}

	// get produk jadi list
	function get_produk_jadi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$result = $this->m_master_produksi->get_produk_jadi_list($query,$start,$end,$aktif);
		echo $result;
	}

	//get satuan automatis ketika di klik event combo bahan jadi
	function get_satuan_bybahan_jadi_list(){
		$query = (integer) (isset($_POST['query']) ? $_POST['query'] : 0);
		$produk_id = (integer) (isset($_POST['produk_id']) ? $_POST['produk_id'] : 0);
		$result = $this->m_master_produksi->get_satuan_bybahan_jadi_list($query,$produk_id);
		echo $result;
	}

	//get satuan automatis ketika di klik event combo produk jadi
	function get_satuan_byproduksi_jadi_list(){
		$query = (integer) (isset($_POST['query']) ? $_POST['query'] : 0);
		$produk_id = (integer) (isset($_POST['produk_id']) ? $_POST['produk_id'] : 0);
		$result = $this->m_master_produksi->get_satuan_byproduksi_jadi_list($query,$produk_id);
		echo $result;
	}
	
	// ini store ketika event di klik, tampil di columnmodel bagian depannya
	function list_history_bahan_produksi(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_produksi->detail_bahan_jadi_produksi_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	// ini store ketika di klik Edit
	function detail_bahan_jadi_produksi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_produksi->detail_bahan_jadi_produksi_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//ini store ketika event di klik , tampil di columnmodel bagian depannya
	function detail_produksi_jadi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_produksi->detail_produksi_jadi_list($master_id,$query,$start,$end);
		echo $result;
	}

	//ini store ketika di klik Edit
	function list_history_produksi_jadi(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_produksi->detail_produksi_jadi_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//purge all detail
	function detail_jual_kwitansi_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_produksi->detail_jual_kwitansi_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_produksi->get_master_id();
		echo $result;
	}
	//
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->produksi_list();
				break;
			case "UPDATE":
				$this->produksi_update();
				break;
			case "BATAL":
				$this->produksi_batal();
				break;
			case "CREATE":
				$this->produksi_create();
				break;
			case "CEK":
				$this->produksi_pengecekan();
				break;
			case "DELETE":
				$this->produksi_delete();
				break;
			case "SEARCH":
				$this->produksi_search();
				break;
			case "DDELETE":
				$this->detail_lcl_delete();
				break;
			case "DDELETE_FSTATUS":
				$this->detail_final_status_delete();
				break;
			case "PRINT":
				$this->produksi_print();
				break;
			case "EXCEL":
				$this->produksi_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function produksi_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_produksi->produksi_list($query,$start,$end);
		echo $result;
	}

	
	function produksi_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function produksi_update(){
		//POST variable here
		$produksi_id=trim(@$_POST["produksi_id"]);
		$produksi_no=trim(@$_POST["produksi_no"]);
		$produksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$produksi_no);
		$produksi_no=str_replace("'", "''",$produksi_no);
		$produksi_tanggal=trim(@$_POST["produksi_tanggal"]);
		$produksi_gudang_asal=trim(@$_POST["produksi_gudang_asal"]);
		$produksi_gudang_tujuan=trim(@$_POST["produksi_gudang_tujuan"]);
		$produksi_keterangan=trim(@$_POST["produksi_keterangan"]);
		$produksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$produksi_keterangan);
		$produksi_keterangan=str_replace("'", "''",$produksi_keterangan);
		$produksi_status=trim(@$_POST["produksi_status"]);

		// detail Bahan Produksi List
		$dbahan_id = $_POST['dbahan_id'];
		$array_dbahan_id = json_decode(stripslashes($dbahan_id));
		$dlcl_master=trim(@$_POST["dlcl_master"]);
		$dbahan_produk = $_POST['dbahan_produk'];
		$array_dbahan_produk = json_decode(stripslashes($dbahan_produk));
		$dbahan_satuan = $_POST['dbahan_satuan'];
		$array_dbahan_satuan = json_decode(stripslashes($dbahan_satuan));
		$dbahan_jumlah = $_POST['dbahan_jumlah'];
		$array_dbahan_jumlah = json_decode(stripslashes($dbahan_jumlah));
		$dbahan_keterangan = $_POST['dbahan_keterangan'];
		$array_dbahan_keterangan = json_decode(stripslashes($dbahan_keterangan));
		//
		
		//detail Produksi Jadi List
		$djadi_id = $_POST['djadi_id'];
		$array_djadi_id = json_decode(stripslashes($djadi_id));
		$dlcl_fs_master=trim(@$_POST["dlcl_fs_master"]);
		$djadi_produk = $_POST['djadi_produk'];
		$array_djadi_produk = json_decode(stripslashes($djadi_produk));
		$djadi_satuan = $_POST['djadi_satuan'];
		$array_djadi_satuan = json_decode(stripslashes($djadi_satuan));
		$djadi_jumlah = $_POST['djadi_jumlah'];
		$array_djadi_jumlah = json_decode(stripslashes($djadi_jumlah));
		$djadi_keterangan = $_POST['djadi_keterangan'];
		$array_djadi_keterangan = json_decode(stripslashes($djadi_keterangan));

		
		$cetak = trim($_POST["cetak"]);	
		$kwitansi_creator=$_SESSION[SESSION_USERID];
		$kwitansi_update=$_SESSION[SESSION_USERID];
		
		$result = $this->m_master_produksi->produksi_update($produksi_id, $produksi_no, $produksi_gudang_asal, $produksi_gudang_tujuan, $produksi_tanggal, $produksi_keterangan, $produksi_status,
			$array_dbahan_id, $dlcl_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $dlcl_fs_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak);
		echo $result;
	}
	
	function produksi_batal(){
		//POST variable here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		$fcl_status=trim(@$_POST["fcl_status"]);
		$fcl_status=str_replace("/(<\/?)(p)([^>]*>)", "",$fcl_status);
		
		$kwitansi_update=$_SESSION[SESSION_USERID];
		$result = $this->m_master_produksi->produksi_batal($kwitansi_id ,$fcl_status ,$kwitansi_update );
		echo $result;
	}
	
	//function for create new record
	function produksi_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$produksi_no=trim(@$_POST["produksi_no"]);
		$produksi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$produksi_no);
		$produksi_no=str_replace("'", "''",$produksi_no);
		$produksi_tanggal=trim(@$_POST["produksi_tanggal"]);
		$produksi_gudang_asal=trim(@$_POST["produksi_gudang_asal"]);
		$produksi_gudang_tujuan=trim(@$_POST["produksi_gudang_tujuan"]);

		$produksi_keterangan=trim(@$_POST["produksi_keterangan"]);
		$produksi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$produksi_keterangan);
		$produksi_keterangan=str_replace("'", "''",$produksi_keterangan);
		$produksi_status=trim(@$_POST["produksi_status"]);
		
		// detail Bahan Produksi List
		$dbahan_id = $_POST['dbahan_id'];
		$array_dbahan_id = json_decode(stripslashes($dbahan_id));

		$dbahan_master=trim(@$_POST["dbahan_master"]);
		
		$dbahan_produk = $_POST['dbahan_produk'];
		$array_dbahan_produk = json_decode(stripslashes($dbahan_produk));
		$dbahan_satuan = $_POST['dbahan_satuan'];
		$array_dbahan_satuan = json_decode(stripslashes($dbahan_satuan));
		$dbahan_jumlah = $_POST['dbahan_jumlah'];
		$array_dbahan_jumlah = json_decode(stripslashes($dbahan_jumlah));
		$dbahan_keterangan = $_POST['dbahan_keterangan'];
		$array_dbahan_keterangan = json_decode(stripslashes($dbahan_keterangan));
		//
		
		//detail Produksi Jadi List
		$djadi_id = $_POST['djadi_id'];
		$array_djadi_id = json_decode(stripslashes($djadi_id));
		
		$djadi_master=trim(@$_POST["djadi_master"]);
		
		$djadi_produk = $_POST['djadi_produk'];
		$array_djadi_produk = json_decode(stripslashes($djadi_produk));
		$djadi_satuan = $_POST['djadi_satuan'];
		$array_djadi_satuan = json_decode(stripslashes($djadi_satuan));
		$djadi_jumlah = $_POST['djadi_jumlah'];
		$array_djadi_jumlah = json_decode(stripslashes($djadi_jumlah));
		$djadi_keterangan = $_POST['djadi_keterangan'];
		$array_djadi_keterangan = json_decode(stripslashes($djadi_keterangan));
		//
		
		$cetak = trim($_POST["cetak"]);	
		$kwitansi_creator=$_SESSION[SESSION_USERID];
		
		$result=$this->m_master_produksi->produksi_create($produksi_no, $produksi_gudang_asal, $produksi_gudang_tujuan, $produksi_tanggal, $produksi_keterangan, $produksi_status,
			$array_dbahan_id, $dbahan_master, $array_dbahan_produk, $array_dbahan_satuan, $array_dbahan_jumlah, $array_dbahan_keterangan,
			$array_djadi_id, $djadi_master, $array_djadi_produk, $array_djadi_satuan, $array_djadi_jumlah, $array_djadi_keterangan,$cetak);
		echo $result;
	}
	
	
	//function for delete selected record
	function produksi_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_produksi->produksi_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function produksi_search(){
		//POST varibale here
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_tanggal_start=trim(@$_POST["kwitansi_tanggal_start"]);
		$kwitansi_tanggal_end=trim(@$_POST["kwitansi_tanggal_end"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		$dfcl_status=trim(@$_POST["dfcl_status"]);
		$dfcl_status=str_replace("/(<\/?)(p)([^>]*>)", "",$dfcl_status);
		$dfcl_status=str_replace("'", "''",$dfcl_status);
		$final_status=trim(@$_POST["final_status"]);
		$final_status=str_replace("/(<\/?)(p)([^>]*>)", "",$final_status);
		$final_status=str_replace("'", "''",$final_status);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_produksi->produksi_search($kwitansi_no ,$kwitansi_cust , $kwitansi_tanggal_start, $kwitansi_tanggal_end,$kwitansi_keterangan ,$kwitansi_status , $dfcl_status, $final_status, $start,$end);
		echo $result;
	}

	function detail_lcl_delete(){
        $dfcl_id = trim(@$_POST["dfcl_id"]); // Get our array back and translate it :
		$result=$this->m_master_produksi->detail_lcl_delete($dfcl_id);
		echo $result;
    }

	function detail_final_status_delete(){
        $fs_id = trim(@$_POST["fs_id"]); // Get our array back and translate it :
		$result=$this->m_master_produksi->detail_final_status_delete($fs_id);
		echo $result;
    }


	function produksi_print(){
  		//POST varibale here
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_produksi->produksi_print($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter);
		$print_view=$this->load->view("main/p_cetak_kwitansi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/cetak_kwitansilist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */
	
	function print_paper(){
  		//POST varibale here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		
		$result = $this->m_master_produksi->print_paper($kwitansi_id);
		$rs=$result->row();
		$result_cara_bayar = $this->m_master_produksi->cara_bayar($kwitansi_id);
		
		$data["kwitansi_no"]=$rs->kwitansi_no;
		$data["kwitansi_tanggal"]=$rs->kwitansi_tanggal;
		$data["kwitansi_customer"]=$rs->cust_no."-".$rs->cust_nama;
		$data["kwitansi_nilai"]="Rp. ".ubah_rupiah($rs->kwitansi_nilai);
		$data["kwitansi_terbilang"]=strtoupper(terbilang($rs->kwitansi_nilai))." RUPIAH";
		$data["kwitansi_keterangan"]=$rs->kwitansi_keterangan;
		$data["kwitansi_cara"]=$rs->kwitansi_cara;
		
		$viewdata=$this->load->view("main/kwitansi_formcetak",$data,TRUE);
		$file = fopen("kwitansi_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_only(){
  		//POST varibale here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		
		$result = $this->m_master_produksi->print_paper($kwitansi_id);
		$rs=$result->row();
		$result_cara_bayar = $this->m_master_produksi->cara_bayar($kwitansi_id);
		
		$data["kwitansi_no"]=$rs->kwitansi_no;
		$data["kwitansi_tanggal"]=$rs->kwitansi_tanggal;
		$data["kwitansi_customer"]=$rs->cust_no."-".$rs->cust_nama;
		$data["kwitansi_nilai"]="Rp. ".ubah_rupiah($rs->kwitansi_nilai);
		$data["kwitansi_terbilang"]=strtoupper(terbilang($rs->kwitansi_nilai))." RUPIAH";
		$data["kwitansi_keterangan"]=$rs->kwitansi_keterangan;
		$data["kwitansi_cara"]=$rs->kwitansi_cara;
		
		$viewdata=$this->load->view("main/kwitansi_formcetak_printonly",$data,TRUE);
		$file = fopen("kwitansi_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}

	/* Function to Export Excel document */
	function produksi_export_excel(){
		//POST varibale here
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_produksi->produksi_export_excel($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter);
		
		to_excel($query,"cetak_kwitansi"); 
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