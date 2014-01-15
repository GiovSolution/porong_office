<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: master_retur_jual_produk Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_master_retur_jual_produk.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 14:53:25
	
*/

//class of master_retur_jual_produk
class C_master_retur_jual_produk extends Controller {

	//constructor
	function C_master_retur_jual_produk(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_retur_jual_produk', '', TRUE);

	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_retur_jual_produk');
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_retur_jual_produk->get_produk_list($query,$start,$end);
		echo $result;
	}
	
	function get_satuan_list(){
		//$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_public_function->get_satuan_list();
		echo $result;
	}
	
	
	function laporan(){
		$this->load->view('main/v_lap_retur_produk');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		$data["jenis"]='Retur Produk';
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
			
			//$tgl_awal_show = $tgl_awal;
			//$tgl_awal_show = date("d-m-Y", $tgl_awal);
			//$tgl_akhir_show = $tgl_akhir;
			//$tgl_akhir_show = date("d-m-Y", $tgl_akhir);
			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
		}
		
		/*$data["total_item"]=$this->m_master_retur_jual_produk->get_total_item($tgl_awal,$tgl_akhir,$periode,$opsi);
		$data["total_diskon"]=$this->m_master_retur_jual_produk->get_total_diskon($tgl_awal,$tgl_akhir,$periode,$opsi);
		$data["total_nilai"]=$this->m_master_retur_jual_produk->get_total_nilai($tgl_awal,$tgl_akhir,$periode,$opsi);*/
		$data["data_print"]=$this->m_master_retur_jual_produk->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group);
			
		if($opsi=='rekap'){
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_retur_jual_tanggal.php",$data,TRUE);break;
				case "No Faktur Jual": $print_view=$this->load->view("main/p_rekap_retur_jual_faktur_jual.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_retur_jual_customer.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_retur_jual.php",$data,TRUE);break;
			}
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_retur_jual_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_retur_jual_customer.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_retur_jual_produk.php",$data,TRUE);break;
				case "No Faktur Jual": $print_view=$this->load->view("main/p_detail_retur_jual_faktur_jual.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_retur_jual.php",$data,TRUE);break;
			}
		}
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_rproduk.html","w+");
		else
			$print_file=fopen("print/report_rproduk.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
		
	function get_jual_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_retur_jual_produk->get_jual_produk_list($query,$start,$end);
		echo $result;
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
	function  detail_detail_retur_jual_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_retur_jual_produk->detail_detail_retur_jual_produk_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_detail_retur_jual_produk_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_retur_jual_produk->detail_detail_retur_jual_produk_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_retur_jual_produk->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_detail_retur_jual_produk_insert(){
	//POST variable here
		$drproduk_id=trim(@$_POST["drproduk_id"]);
		$drproduk_master=trim(@$_POST["drproduk_master"]);
		$drproduk_produk=trim(@$_POST["drproduk_produk"]);
		$drproduk_satuan=trim(@$_POST["drproduk_satuan"]);
		$drproduk_jumlah=trim(@$_POST["drproduk_jumlah"]);
		$drproduk_harga=trim(@$_POST["drproduk_harga"]);
		$result=$this->m_master_retur_jual_produk->detail_detail_retur_jual_produk_insert($drproduk_id ,$drproduk_master ,$drproduk_produk ,$drproduk_satuan ,$drproduk_jumlah ,$drproduk_harga );
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_retur_jual_produk_list();
				break;
			case "UPDATE":
				$this->master_retur_jual_produk_update();
				break;
			case "CREATE":
				$this->master_retur_jual_produk_create();
				break;
			case "CEK":
				$this->master_retur_jual_produk_pengecekan();
				break;
			case "DELETE":
				$this->master_retur_jual_produk_delete();
				break;
			case "SEARCH":
				$this->master_retur_jual_produk_search();
				break;
			case "PRINT":
				$this->master_retur_jual_produk_print();
				break;
			case "EXCEL":
				$this->master_retur_jual_produk_export_excel();
				break;
			case "BATAL":
				$this->master_retur_jual_produk_batal();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_retur_jual_produk_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_retur_jual_produk->master_retur_jual_produk_list($query,$start,$end);
		echo $result;
	}

	// function utk melakukan pengecekan tanggal valid dokumen
	function master_retur_jual_produk_pengecekan(){
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	

	//function for update record
	function master_retur_jual_produk_update(){
		//POST variable here
		$rproduk_id=trim(@$_POST["rproduk_id"]);
		$rproduk_nobukti=trim(@$_POST["rproduk_nobukti"]);
		$rproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobukti);
		$rproduk_nobukti=str_replace(",", ",",$rproduk_nobukti);
		$rproduk_nobukti=str_replace("'", '"',$rproduk_nobukti);
		$rproduk_nobuktijual=trim(@$_POST["rproduk_nobuktijual"]);
		$rproduk_nobuktijual=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobuktijual);
		$rproduk_nobuktijual=str_replace(",", ",",$rproduk_nobuktijual);
		$rproduk_nobuktijual=str_replace("'", '"',$rproduk_nobuktijual);
		$rproduk_cust=trim(@$_POST["rproduk_cust"]);
		$rproduk_tanggal=trim(@$_POST["rproduk_tanggal"]);
		$rproduk_keterangan=trim(@$_POST["rproduk_keterangan"]);
		$rproduk_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_keterangan);
		$rproduk_keterangan=str_replace(",", ",",$rproduk_keterangan);
		$rproduk_keterangan=str_replace("'", '"',$rproduk_keterangan);
		
		$rproduk_stat_dok=trim(@$_POST["rproduk_stat_dok"]);
		$rproduk_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_stat_dok);
		$rproduk_stat_dok=str_replace(",", ",",$rproduk_stat_dok);
		$rproduk_stat_dok=str_replace("'", '"',$rproduk_stat_dok);
		
		
		$result = $this->m_master_retur_jual_produk->master_retur_jual_produk_update($rproduk_id ,$rproduk_nobukti ,$rproduk_nobuktijual ,$rproduk_cust ,$rproduk_tanggal ,$rproduk_keterangan, $rproduk_stat_dok     );
		echo $result;
	}
	
	//function for create new record
	function master_retur_jual_produk_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$rproduk_nobukti=trim(@$_POST["rproduk_nobukti"]);
		$rproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobukti);
		$rproduk_nobukti=str_replace("'", '"',$rproduk_nobukti);
		$rproduk_nobuktijual=trim(@$_POST["rproduk_nobuktijual"]);
		$rproduk_nobuktijual=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobuktijual);
		$rproduk_nobuktijual=str_replace("'", '"',$rproduk_nobuktijual);
		$rproduk_cust=trim(@$_POST["rproduk_cust"]);
		$rproduk_tanggal=trim(@$_POST["rproduk_tanggal"]);
		$rproduk_keterangan=trim(@$_POST["rproduk_keterangan"]);
		$rproduk_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_keterangan);
		$rproduk_keterangan=str_replace("'", '"',$rproduk_keterangan);
		
		$rproduk_stat_dok=trim(@$_POST["rproduk_stat_dok"]);
		$rproduk_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_stat_dok);
		$rproduk_stat_dok=str_replace("'", '"',$rproduk_stat_dok);
		
		$rproduk_kwitansi_nilai=trim(@$_POST["rproduk_kwitansi_nilai"]);
		$rproduk_kwitansi_keterangan=trim(@$_POST["rproduk_kwitansi_keterangan"]);
		$rproduk_kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_kwitansi_keterangan);
		$rproduk_kwitansi_keterangan=str_replace("'", '"',$rproduk_kwitansi_keterangan);
		$rproduk_voucher=trim(@$_POST["rproduk_voucher"]);
		$result=$this->m_master_retur_jual_produk->master_retur_jual_produk_create($rproduk_nobukti ,$rproduk_nobuktijual ,$rproduk_cust ,$rproduk_tanggal ,$rproduk_keterangan , $rproduk_stat_dok, $rproduk_kwitansi_nilai ,$rproduk_kwitansi_keterangan, $rproduk_voucher);
		echo $result;
	}

	//function for delete selected record
	function master_retur_jual_produk_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_retur_jual_produk->master_retur_jual_produk_delete($pkid);
		echo $result;
	}
	
	function master_retur_jual_produk_batal(){
		$rproduk_id=trim(@$_POST["rproduk_id"]);
		$result=$this->m_master_retur_jual_produk->master_retur_jual_produk_batal($rproduk_id);
		echo $result;
	}

	//function for advanced search
	function master_retur_jual_produk_search(){
		//POST varibale here
		$rproduk_nobukti=trim(@$_POST["rproduk_nobukti"]);
		$rproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobukti);
		$rproduk_nobukti=str_replace("'", '"',$rproduk_nobukti);
		$rproduk_nobuktijual=trim(@$_POST["rproduk_nobuktijual"]);
		$rproduk_nobuktijual=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobuktijual);
		$rproduk_nobuktijual=str_replace("'", '"',$rproduk_nobuktijual);
		$rproduk_cust=trim(@$_POST["rproduk_cust"]);
		$rproduk_tanggal=trim(@$_POST["rproduk_tanggal"]);
		$rproduk_tanggal_akhir=trim(@$_POST["rproduk_tanggal_akhir"]);
		$rproduk_keterangan=trim(@$_POST["rproduk_keterangan"]);
		$rproduk_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_keterangan);
		$rproduk_keterangan=str_replace("'", '"',$rproduk_keterangan);
		
		$rproduk_stat_dok=trim(@$_POST["rproduk_stat_dok"]);
		$rproduk_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_stat_dok);
		$rproduk_stat_dok=str_replace("'", '"',$rproduk_stat_dok);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_retur_jual_produk->master_retur_jual_produk_search($rproduk_nobukti ,$rproduk_nobuktijual ,$rproduk_cust ,$rproduk_tanggal, $rproduk_tanggal_akhir, $rproduk_keterangan , $rproduk_stat_dok, $start,$end);
		echo $result;
	}


	function master_retur_jual_produk_print(){
  		//POST varibale here
		$rproduk_nobukti=trim(@$_POST["rproduk_nobukti"]);
		$rproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobukti);
		$rproduk_nobukti=str_replace("'", '"',$rproduk_nobukti);
		$rproduk_nobuktijual=trim(@$_POST["rproduk_nobuktijual"]);
		$rproduk_nobuktijual=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobuktijual);
		$rproduk_nobuktijual=str_replace("'", '"',$rproduk_nobuktijual);
		$rproduk_cust=trim(@$_POST["rproduk_cust"]);
		$rproduk_tanggal=trim(@$_POST["rproduk_tanggal"]);
		$rproduk_tanggal_akhir=trim(@$_POST["rproduk_tanggal_akhir"]);
		$rproduk_keterangan=trim(@$_POST["rproduk_keterangan"]);
		$rproduk_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_keterangan);
		$rproduk_keterangan=str_replace("'", '"',$rproduk_keterangan);
		$rproduk_stat_dok=trim(@$_POST["rproduk_stat_dok"]);
		$rproduk_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_stat_dok);
		$rproduk_stat_dok=str_replace("'", '"',$rproduk_stat_dok);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_retur_jual_produk->master_retur_jual_produk_print($rproduk_nobukti
																								,$rproduk_nobuktijual
																								,$rproduk_cust
																								,$rproduk_tanggal
																								,$rproduk_tanggal_akhir
																								,$rproduk_keterangan
																								,$rproduk_stat_dok
																								,$option
																								,$filter);
		$print_view=$this->load->view("main/p_master_retur_jual_produk.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/master_retur_jual_produklist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_retur_jual_produk_export_excel(){
		//POST varibale here
		$this->load->plugin('to_excel');
		$rproduk_nobukti=trim(@$_POST["rproduk_nobukti"]);
		$rproduk_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobukti);
		$rproduk_nobukti=str_replace("'", '"',$rproduk_nobukti);
		$rproduk_nobuktijual=trim(@$_POST["rproduk_nobuktijual"]);
		$rproduk_nobuktijual=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_nobuktijual);
		$rproduk_nobuktijual=str_replace("'", '"',$rproduk_nobuktijual);
		$rproduk_cust=trim(@$_POST["rproduk_cust"]);
		$rproduk_tanggal=trim(@$_POST["rproduk_tanggal"]);
		$rproduk_tanggal_akhir=trim(@$_POST["rproduk_tanggal_akhir"]);
		$rproduk_keterangan=trim(@$_POST["rproduk_keterangan"]);
		$rproduk_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_keterangan);
		$rproduk_keterangan=str_replace("'", '"',$rproduk_keterangan);
		$rproduk_stat_dok=trim(@$_POST["rproduk_stat_dok"]);
		$rproduk_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$rproduk_stat_dok);
		$rproduk_stat_dok=str_replace("'", '"',$rproduk_stat_dok);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_retur_jual_produk->master_retur_jual_produk_export_excel($rproduk_nobukti
																						  ,$rproduk_nobuktijual
																						  ,$rproduk_cust
																						  ,$rproduk_tanggal
																						  ,$rproduk_tanggal_akhir
																						  ,$rproduk_keterangan
																						  ,$rproduk_stat_dok
																						  ,$option
																						  ,$filter);
		
		to_excel($query,"master_retur_jual_produk");
		echo '1';
			
	}
	
	function print_paper(){
  		//POST varibale here
		$kwitansi_ref=trim(@$_POST["kwitansi_ref"]);
		
		
		$result = $this->m_master_retur_jual_produk->print_paper($kwitansi_ref);
		$rs=$result->row();
		$result_cara_bayar = $this->m_master_retur_jual_produk->cara_bayar($kwitansi_ref);
		
		$data["kwitansi_no"]=$rs->kwitansi_no;
		$data["kwitansi_tanggal"]=$rs->kwitansi_date_create;
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