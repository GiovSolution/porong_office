<?php
/* 	
	GIOV Solution - Keep IT Simple
*/

//class of master_lunas_piutang
class C_master_lunas_piutang extends Controller {

	//constructor
	function C_master_lunas_piutang(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_lunas_piutang', '', TRUE);	
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_lunas_piutang');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_piutang');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		//$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		$customer=(isset($_POST['customer']) ? @$_POST['customer'] : @$_GET['customer']);
		$lunas=(isset($_POST['lunas']) ? @$_POST['lunas'] : @$_GET['lunas']);
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			$date_akhir = substr($tgl_akhir,8,2);
			$month_akhir = substr($tgl_akhir,5,2);
			$year_akhir = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date_akhir.'-'.$month_akhir.'-'.$year_akhir;
			
			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
		}
		
		if($lunas=='1'){
			$data["pelunasan"]="(Lunas)";
		}else{
			$data["pelunasan"]="(Belum Lunas)";
		}
		
		$data["data_print"]=$this->m_master_lunas_piutang->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$customer,$lunas);
		
		if($opsi=='rekap'){
			$print_view=$this->load->view("main/p_rekap_piutang_customer.php",$data,TRUE);
			/*switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_piutang_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_piutang_customer.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_piutang.php",$data,TRUE);break;
			}*/
			//$print_view=$this->load->view("main/p_rekap_piutang_customer.php",$data,TRUE);
			
		}else{
			$print_view=$this->load->view("main/p_detail_piutang_customer.php",$data,TRUE);
			/*switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_piutang_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_piutang_customer.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_piutang.php",$data,TRUE);break;
			}*/
			//$print_view=$this->load->view("main/p_detail_piutang_customer.php",$data,TRUE);
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/report_piutang.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_fpiutang_bylp_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$fpiutang_nobukti = isset($_POST['fpiutang_nobukti']) ? @$_POST['fpiutang_nobukti'] : "";
		$result=$this->m_master_lunas_piutang->detail_fpiutang_bylp_list($fpiutang_nobukti,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_detail_lunas_piutang_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$result=$this->m_master_lunas_piutang->detail_detail_lunas_piutang_purge($master_id);
		echo $result;
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_lunas_piutang->get_master_id();
		echo $result;
	}
	//
	
	//get master id, note: not done yet
	function get_piutang_cust_list(){
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$query=isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$result=$this->m_public_function->get_piutang_cust_list($query, $start,$end);
		echo $result;
	}
	//
	
	//get master id, note: not done yet
	function get_fjual_bycust_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$fpiutang_id = (integer) (isset($_POST['fpiutang_id']) ? @$_POST['fpiutang_id'] : @$_GET['fpiutang_id']);
		$cust_id = isset($_POST['cust_id']) ? @$_POST['cust_id'] : "";
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		if($task=='detail')
			$result=$this->m_master_lunas_piutang->get_faktur_piutang_detail_list($cust_id,$query,$start,$end);
		/*elseif($task=='list')
			$result=$this->m_master_lunas_piutang->get_faktur_piutang_all_list($cust_id,$query,$start,$end);*/
		elseif($task=='selected')
			$result=$this->m_master_lunas_piutang->get_faktur_piutang_selected_list($fpiutang_id,$query,$start,$end);
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_lunas_piutang_list();
				break;
			case "UPDATE":
				$this->master_lunas_piutang_update();
				break;
			case "CREATE":
				$this->master_lunas_piutang_create();
				break;
			case "CEK":
				$this->master_lunas_piutang_pengecekan();
				break;
			case "DELETE":
				$this->master_lunas_piutang_delete();
				break;
			case "SEARCH":
				$this->master_lunas_piutang_search();
				break;
			case "PRINT":
				$this->master_lunas_piutang_print();
				break;
			case "EXCEL":
				$this->master_lunas_piutang_export_excel();
				break;
			case "BATAL":
				$this->master_lunas_piutang_batal();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function get_kwitansi_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_kwitansi_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_cek_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_cek_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_card_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_card_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_transfer_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_transfer_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_tunai_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_tunai_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function  get_kwitansi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		//$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$start=0;
		$end=10;
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$result=$this->m_public_function->get_kwitansi_list($query,$start,$end,$kwitansi_cust);
		echo $result;
	}
	
	//function fot list record
	function master_lunas_piutang_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$result=$this->m_master_lunas_piutang->master_lunas_piutang_list($query,$start,$end);
		echo $result;
	}

	function master_lunas_piutang_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	//function for update record
	function master_lunas_piutang_update(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$fpiutang_id=trim(@$_POST["fpiutang_id"]);
		$fpiutang_no=trim(@$_POST["fpiutang_no"]);
		$fpiutang_no=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_no);
		$fpiutang_no=str_replace("'", '"',$fpiutang_no);
		$fpiutang_cust=trim(@$_POST["fpiutang_cust"]);
		$fpiutang_tanggal=trim(@$_POST["fpiutang_tanggal"]);
		$fpiutang_keterangan=trim(@$_POST["fpiutang_keterangan"]);
		$fpiutang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_keterangan);
		$fpiutang_keterangan=str_replace("'", '"',$fpiutang_keterangan);
		$fpiutang_status=trim(@$_POST["fpiutang_status"]);
		$fpiutang_status=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_status);
		$fpiutang_status=str_replace("'", '"',$fpiutang_status);
		$fpiutang_cara=trim(@$_POST["fpiutang_cara"]);
		$fpiutang_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_cara);
		$fpiutang_cara=str_replace("'", '"',$fpiutang_cara);
		$fpiutang_bayar=trim(@$_POST["fpiutang_bayar"]);
		
		//kwitansi
		$fpiutang_kwitansi_no=trim($_POST["fpiutang_kwitansi_no"]);
		$fpiutang_kwitansi_nama=trim(@$_POST["fpiutang_kwitansi_nama"]);
		$fpiutang_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_kwitansi_nama);
		$fpiutang_kwitansi_nama=str_replace("'", '"',$fpiutang_kwitansi_nama);
		//card
		$fpiutang_card_nama=trim($_POST["fpiutang_card_nama"]);
		$fpiutang_card_edc=trim($_POST["fpiutang_card_edc"]);
		$fpiutang_card_no=trim($_POST["fpiutang_card_no"]);
		//cek
		$fpiutang_cek_nama=trim($_POST["fpiutang_cek_nama"]);
		$fpiutang_cek_no=trim($_POST["fpiutang_cek_no"]);
		$fpiutang_cek_valid=trim($_POST["fpiutang_cek_valid"]);
		$fpiutang_cek_bank=trim($_POST["fpiutang_cek_bank"]);
		//transfer
		$fpiutang_transfer_bank=trim($_POST["fpiutang_transfer_bank"]);
		$fpiutang_transfer_nama=trim($_POST["fpiutang_transfer_nama"]);
		
		//DATA DETAIL
		$dpiutang_id = $_POST['dpiutang_id']; // Get our array back and translate it :
		$array_dpiutang_id = json_decode(stripslashes($dpiutang_id));
		
		$lpiutang_id = $_POST['lpiutang_id']; // Get our array back and translate it :
		$array_lpiutang_id = json_decode(stripslashes($lpiutang_id));
		
		$dpiutang_nilai = $_POST['dpiutang_nilai']; // Get our array back and translate it :
		$array_dpiutang_nilai = json_decode(stripslashes($dpiutang_nilai));
		
		$dpiutang_keterangan = $_POST['dpiutang_keterangan']; // Get our array back and translate it :
		$array_dpiutang_keterangan = json_decode(stripslashes($dpiutang_keterangan));
		
		$cetak_lp = trim(@$_POST["cetak_lp"]);
		$result = $this->m_master_lunas_piutang->master_lunas_piutang_update($fpiutang_id ,$fpiutang_no ,$fpiutang_cust ,$fpiutang_tanggal, $fpiutang_keterangan ,$fpiutang_status
										,$fpiutang_cara ,$fpiutang_bayar
										,$fpiutang_kwitansi_no ,$fpiutang_kwitansi_nama
										,$fpiutang_card_nama ,$fpiutang_card_edc ,$fpiutang_card_no
										,$fpiutang_cek_nama ,$fpiutang_cek_no ,$fpiutang_cek_valid ,$fpiutang_cek_bank
										,$fpiutang_transfer_bank ,$fpiutang_transfer_nama
										,$array_dpiutang_id ,$array_lpiutang_id ,$array_dpiutang_nilai ,$array_dpiutang_keterangan
										,$cetak_lp);
		echo $result;
	}
	
	//function for create new record
	function master_lunas_piutang_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$fpiutang_no=trim(@$_POST["fpiutang_no"]);
		$fpiutang_no=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_no);
		$fpiutang_no=str_replace("'", '"',$fpiutang_no);
		$fpiutang_cust=trim(@$_POST["fpiutang_cust"]);
		$fpiutang_tanggal=trim(@$_POST["fpiutang_tanggal"]);
		$fpiutang_keterangan=trim(@$_POST["fpiutang_keterangan"]);
		$fpiutang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_keterangan);
		$fpiutang_keterangan=str_replace("'", '"',$fpiutang_keterangan);
		$fpiutang_status=trim(@$_POST["fpiutang_status"]);
		$fpiutang_status=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_status);
		$fpiutang_status=str_replace("'", '"',$fpiutang_status);
		$fpiutang_cara=trim(@$_POST["fpiutang_cara"]);
		$fpiutang_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_cara);
		$fpiutang_cara=str_replace("'", '"',$fpiutang_cara);
		$fpiutang_bayar=trim(@$_POST["fpiutang_bayar"]);
		
		//kwitansi
		$fpiutang_kwitansi_no=trim($_POST["fpiutang_kwitansi_no"]);
		$fpiutang_kwitansi_nama=trim(@$_POST["fpiutang_kwitansi_nama"]);
		$fpiutang_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_kwitansi_nama);
		$fpiutang_kwitansi_nama=str_replace("'", '"',$fpiutang_kwitansi_nama);
		//card
		$fpiutang_card_nama=trim($_POST["fpiutang_card_nama"]);
		$fpiutang_card_edc=trim($_POST["fpiutang_card_edc"]);
		$fpiutang_card_no=trim($_POST["fpiutang_card_no"]);
		//cek
		$fpiutang_cek_nama=trim($_POST["fpiutang_cek_nama"]);
		$fpiutang_cek_no=trim($_POST["fpiutang_cek_no"]);
		$fpiutang_cek_valid=trim($_POST["fpiutang_cek_valid"]);
		$fpiutang_cek_bank=trim($_POST["fpiutang_cek_bank"]);
		//transfer
		$fpiutang_transfer_bank=trim($_POST["fpiutang_transfer_bank"]);
		$fpiutang_transfer_nama=trim($_POST["fpiutang_transfer_nama"]);
		
		//DATA DETAIL
		$dpiutang_id = $_POST['dpiutang_id']; // Get our array back and translate it :
		$array_dpiutang_id = json_decode(stripslashes($dpiutang_id));
		
		$lpiutang_id = $_POST['lpiutang_id']; // Get our array back and translate it :
		$array_lpiutang_id = json_decode(stripslashes($lpiutang_id));
		
		$dpiutang_nilai = $_POST['dpiutang_nilai']; // Get our array back and translate it :
		$array_dpiutang_nilai = json_decode(stripslashes($dpiutang_nilai));
		
		$dpiutang_keterangan = $_POST['dpiutang_keterangan']; // Get our array back and translate it :
		$array_dpiutang_keterangan = json_decode(stripslashes($dpiutang_keterangan));
		
		$cetak_lp = trim(@$_POST["cetak_lp"]);
		$result=$this->m_master_lunas_piutang->master_lunas_piutang_create($fpiutang_cust ,$fpiutang_tanggal, $fpiutang_keterangan ,$fpiutang_status
										,$fpiutang_cara ,$fpiutang_bayar
										,$fpiutang_kwitansi_no ,$fpiutang_kwitansi_nama
										,$fpiutang_card_nama ,$fpiutang_card_edc ,$fpiutang_card_no
										,$fpiutang_cek_nama ,$fpiutang_cek_no ,$fpiutang_cek_valid ,$fpiutang_cek_bank
										,$fpiutang_transfer_bank ,$fpiutang_transfer_nama
										,$array_dpiutang_id ,$array_lpiutang_id ,$array_dpiutang_nilai ,$array_dpiutang_keterangan
										,$cetak_lp);
		echo $result;
	}

	//function for advanced search
	function master_lunas_piutang_search(){
		//POST varibale here
		$fpiutang_no=trim(@$_POST["fpiutang_no"]);
		$fpiutang_no=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_no);
		$fpiutang_no=str_replace("'", '"',$fpiutang_no);
		//$jproduk_cust=trim(@$_POST["jproduk_cust"]);
		$fpiutang_tgl_awal=trim(@$_POST["fpiutang_tgl_awal"]);
		$fpiutang_tgl_akhir=trim(@$_POST["fpiutang_tgl_akhir"]);
		//$jproduk_diskon=trim(@$_POST["jproduk_diskon"]);
		$fpiutang_carabayar=trim(@$_POST["fpiutang_carabayar"]);
		$fpiutang_carabayar=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_carabayar);
		$fpiutang_carabayar=str_replace("'", '"',$fpiutang_carabayar);
		$fpiutang_keterangan=trim(@$_POST["fpiutang_keterangan"]);
		$fpiutang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_keterangan);
		$fpiutang_keterangan=str_replace("'", '"',$fpiutang_keterangan);
		$fpiutang_status=trim(@$_POST["fpiutang_status"]);
		$fpiutang_status=str_replace("/(<\/?)(p)([^>]*>)", "",$fpiutang_status);
		$fpiutang_status=str_replace("'", '"',$fpiutang_status);
			
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_lunas_piutang->master_lunas_piutang_search($fpiutang_no, $fpiutang_tgl_awal, $fpiutang_tgl_akhir, $fpiutang_carabayar, $fpiutang_keterangan, $fpiutang_status, $start, $end);
		echo $result;
	}
	
	
	//function for delete selected record
	function master_lunas_piutang_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_lunas_piutang->master_lunas_piutang_delete($pkid);
		echo $result;
	}
	
	function print_paper(){
  		//POST varibale here
		$fpiutang_id=trim(@$_POST["fpiutang_id"]);
		
		$result = $this->m_master_lunas_piutang->print_paper($fpiutang_id);
		$rs=$result->row();
		$detail_fpiutang=$result->result();
		
		$cara_bayar=$this->m_master_lunas_piutang->cara_bayar($fpiutang_id);
		
		$data['fpiutang_nobukti']=$rs->fpiutang_nobukti;
		$data['fpiutang_tanggal']=date('d-m-Y', strtotime($rs->fpiutang_tanggal));
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['detail_fpiutang']=$detail_fpiutang;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->fpiutang_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		$viewdata=$this->load->view("main/fpiutang_formcetak",$data,TRUE);
		$file = fopen("fpiutang_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function master_lunas_piutang_batal(){
		$fpiutang_id=trim($_POST["fpiutang_id"]);
		$fpiutang_tanggal=trim(@$_POST["fpiutang_tanggal"]);
		$result=$this->m_master_lunas_piutang->master_lunas_piutang_batal($fpiutang_id, $fpiutang_tanggal);
		echo $result;
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