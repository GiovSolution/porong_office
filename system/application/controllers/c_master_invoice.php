<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: master_invoice Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_master_invoice.php
 	+ Author  		: 
 	+ Created on 13/Oct/2009 15:51:36
	
*/

//class of master_invoice
class C_master_invoice extends Controller {

	//constructor
	function C_master_invoice(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_invoice', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_invoice');
	}
	
	function print_faktur(){
		
		$faktur=(isset($_POST['faktur']) ? @$_POST['faktur'] : @$_GET['faktur']);
		$opsi="faktur";
        $result = $this->m_master_invoice->get_laporan("","","",$opsi,"",$faktur);
		$info = $this->m_public_function->get_info();
		$master=$result->row();
		$data['data_print'] = $result->result();
		$data['info_nama'] = $info->info_nama;
		$data['no_bukti'] = $master->no_bukti;
		$data['no_bukti_auto'] = $master->no_bukti_auto;
		$data['terima_no'] = $master->terima_no;
        $data['tanggal'] = $master->tanggal;
        $data['supplier_nama'] = $master->supplier_nama;
		$print_view=$this->load->view("main/p_faktur_tagihan.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		$print_file=fopen("print/tagihan_faktur.html","w+");
		
		fwrite($print_file, $print_view);
		echo '1'; 
		
	}
	
	function laporan(){
		$this->load->view('main/v_lap_invoice');
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
		
		$data["data_print"]=$this->m_master_invoice->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,"");
		if($opsi=='rekap'){
				
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_invoice_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_rekap_invoice_supplier.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_invoice.php",$data,TRUE);break;
			}
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_invoice_tanggal.php",$data,TRUE);break;
				case "Supplier": $print_view=$this->load->view("main/p_detail_invoice_supplier.php",$data,TRUE);break;
				case "Produk": $print_view=$this->load->view("main/p_detail_invoice_produk.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_invoice.php",$data,TRUE);break;
			}
		}
		
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_invoice.html","w+");
		else
			$print_file=fopen("print/report_invoice.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function get_satuan_list(){
		$result=$this->m_public_function->get_satuan_list();
		echo $result;
	}
	
	
	function get_invoice_order(){
		$terima_id = (integer) (isset($_POST['terima_id']) ? @$_POST['terima_id'] : @$_GET['terima_id']);
		$result=$this->m_master_invoice->get_invoice_order($terima_id);
		echo $result;
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$terima_id = (integer) (isset($_POST['terima_id']) ? @$_POST['terima_id'] : @$_GET['terima_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		if($task=="detail")
			$result=$this->m_master_invoice->get_produk_invoice_list($master_id,$query,$start,$end);
		elseif($task=="terima")
			$result=$this->m_master_invoice->get_produk_terima_list($terima_id,$query,$start,$end);
		echo $result;
	}
	
	function get_tbeli_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		
		$result=$this->m_master_invoice->get_tbeli_list($query,$start, $end);
		echo $result;
	}
	
	function get_dtbeli_list(){
		$dterima_master = (integer) (isset($_POST['master']) ? $_POST['master'] : $_GET['master']);
		$result=$this->m_master_invoice->get_dtbeli_list($dterima_master);
		echo $result;
	}
	
	
	
	//for detail action
	//list detail handler action
	function  detail_detail_invoice_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_invoice->detail_detail_invoice_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_invoice_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_invoice->detail_detail_invoice_purge($master_id);
		echo $result;
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_invoice->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_detail_invoice_insert(){
	//POST variable here
		
		$dinvoice_id = @$_POST['dinvoice_id']; 
        $dinvoice_master=trim(@$_POST["dinvoice_master"]);
        $dinvoice_produk = @$_POST['dinvoice_produk']; 
		$dinvoice_satuan = @$_POST['dinvoice_satuan']; 
		$dinvoice_jumlah = @$_POST['dinvoice_jumlah'];
		$dinvoice_harga = @$_POST['dinvoice_harga']; 
		$dinvoice_diskon = @$_POST['dinvoice_diskon']; 
		
		$array_dinvoice_id = json_decode(stripslashes($dinvoice_id));
		$array_dinvoice_produk = json_decode(stripslashes($dinvoice_produk));
		$array_dinvoice_satuan = json_decode(stripslashes($dinvoice_satuan));
		$array_dinvoice_jumlah = json_decode(stripslashes($dinvoice_jumlah));
		$array_dinvoice_harga = json_decode(stripslashes($dinvoice_harga));
		$array_dinvoice_diskon = json_decode(stripslashes($dinvoice_diskon));
		
		$result=$this->m_master_invoice->detail_detail_invoice_insert($array_dinvoice_id ,$dinvoice_master ,$array_dinvoice_produk ,
																	  $array_dinvoice_satuan ,$array_dinvoice_jumlah ,$array_dinvoice_harga ,
																	  $array_dinvoice_diskon );
		
		echo $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_invoice_list();
				break;
			case "UPDATE":
				$this->master_invoice_update();
				break;
			case "CREATE":
				$this->master_invoice_create();
				break;
			case "DELETE":
				$this->master_invoice_delete();
				break;
			case "SEARCH":
				$this->master_invoice_search();
				break;
			case "PRINT":
				$this->master_invoice_print();
				break;
			case "EXCEL":
				$this->master_invoice_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_invoice_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_invoice->master_invoice_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function master_invoice_update(){
		//POST variable here
		$invoice_id=trim(@$_POST["invoice_id"]);
		$invoice_no=trim(@$_POST["invoice_no"]);
		$invoice_no=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no);
		$invoice_no=str_replace(",", ",",$invoice_no);
		$invoice_no=str_replace("'", '"',$invoice_no);
		
		$invoice_no_auto=trim(@$_POST["invoice_no_auto"]);
		$invoice_no_auto=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no_auto);
		$invoice_no_auto=str_replace(",", ",",$invoice_no_auto);
		$invoice_no_auto=str_replace("'", '"',$invoice_no_auto);
		$invoice_supplier=trim(@$_POST["invoice_supplier"]);
		$invoice_noterima=trim(@$_POST["invoice_noterima"]);
		$invoice_tanggal=trim(@$_POST["invoice_tanggal"]);
		$invoice_diskon=trim(@$_POST["invoice_diskon"]);
		$invoice_cashback=trim(@$_POST["invoice_cashback"]);
		$invoice_uangmuka=trim(@$_POST["invoice_uangmuka"]);
		$invoice_biaya=trim(@$_POST["invoice_biaya"]);
		$invoice_jatuhtempo=trim(@$_POST["invoice_jatuhtempo"]);
		$invoice_penagih=trim(@$_POST["invoice_penagih"]);
		$invoice_penagih=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_penagih);
		$invoice_penagih=str_replace(",", ",",$invoice_penagih);
		$invoice_penagih=str_replace("'", '"',$invoice_penagih);
		$invoice_keterangan=trim(@$_POST["invoice_keterangan"]);
		$invoice_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_keterangan);
		$invoice_keterangan=str_replace(",", ",",$invoice_keterangan);
		$invoice_keterangan=str_replace("'", '"',$invoice_keterangan);
		$invoice_status=trim(@$_POST["invoice_status"]);
		
		
		$result = $this->m_master_invoice->master_invoice_update($invoice_id ,$invoice_no ,$invoice_no_auto, $invoice_supplier ,$invoice_noterima ,
																 $invoice_tanggal ,$invoice_diskon, $invoice_cashback, $invoice_uangmuka, 
																 $invoice_biaya ,$invoice_jatuhtempo ,$invoice_penagih, $invoice_keterangan, 
																 $invoice_status);
		echo $result;
	}
	
	//function for create new record
	function master_invoice_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$invoice_no=trim(@$_POST["invoice_no"]);
		$invoice_no=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no);
		$invoice_no=str_replace("'", '"',$invoice_no);
		$invoice_no_auto=trim(@$_POST["invoice_no_auto"]);
		$invoice_no_auto=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no_auto);
		$invoice_no_auto=str_replace("'", '"',$invoice_no_auto);
		$invoice_supplier=trim(@$_POST["invoice_supplier"]);
		$invoice_noterima=trim(@$_POST["invoice_noterima"]);
		$invoice_tanggal=trim(@$_POST["invoice_tanggal"]);
		$invoice_diskon=trim(@$_POST["invoice_diskon"]);
		$invoice_cashback=trim(@$_POST["invoice_cashback"]);
		$invoice_uangmuka=trim(@$_POST["invoice_uangmuka"]);
		$invoice_biaya=trim(@$_POST["invoice_biaya"]);
		$invoice_jatuhtempo=trim(@$_POST["invoice_jatuhtempo"]);
		$invoice_penagih=trim(@$_POST["invoice_penagih"]);
		$invoice_penagih=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_penagih);
		$invoice_penagih=str_replace("'", '"',$invoice_penagih);
		$invoice_keterangan=trim(@$_POST["invoice_keterangan"]);
		$invoice_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_keterangan);
		$invoice_keterangan=str_replace("'", '"',$invoice_keterangan);
		$invoice_status=trim(@$_POST["invoice_status"]);

		$result=$this->m_master_invoice->master_invoice_create($invoice_no ,$invoice_no_auto, $invoice_supplier ,$invoice_noterima ,$invoice_tanggal 
															   ,$invoice_diskon, $invoice_cashback, $invoice_uangmuka, $invoice_biaya, 
															   $invoice_jatuhtempo ,$invoice_penagih, $invoice_keterangan, $invoice_status);
		echo $result;
	}

	//function for delete selected record
	function master_invoice_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_invoice->master_invoice_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function master_invoice_search(){
		//POST varibale here
		$invoice_id="";
		$invoice_no=trim(@$_POST["invoice_no"]);
		$invoice_no=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no);
		$invoice_no=str_replace("'", '"',$invoice_no);
		
		$invoice_no_auto=trim(@$_POST["invoice_no_auto"]);
		$invoice_no_auto=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no_auto);
		$invoice_no_auto=str_replace("'", '"',$invoice_no_auto);
		$invoice_supplier=trim(@$_POST["invoice_supplier"]);
		$invoice_noterima=trim(@$_POST["invoice_noterima"]);
		$invoice_tgl_awal=trim(@$_POST["invoice_tgl_awal"]);
		$invoice_tgl_akhir=trim(@$_POST["invoice_tgl_akhir"]);
		$invoice_nilai=trim(@$_POST["invoice_nilai"]);

		$invoice_jatuhtempo=trim(@$_POST["invoice_jatuhtempo"]);
		$invoice_penagih=trim(@$_POST["invoice_penagih"]);
		$invoice_penagih=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_penagih);
		$invoice_penagih=str_replace("'", '"',$invoice_penagih);
		
		$invoice_keterangan=trim(@$_POST["invoice_keterangan"]);
		$invoice_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_keterangan);
		$invoice_keterangan=str_replace("'", '"',$invoice_keterangan);
		$invoice_status=trim(@$_POST["invoice_status"]);
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_invoice->master_invoice_search($invoice_id ,$invoice_no ,$invoice_no_auto, $invoice_supplier ,$invoice_noterima ,
																  $invoice_tgl_awal, $invoice_tgl_akhir ,$invoice_nilai,$invoice_jatuhtempo ,
																  $invoice_penagih, $invoice_keterangan, $invoice_status, $start,$end);
		echo $result;
	}


	function master_invoice_print(){
  		//POST varibale here
		$invoice_id="";
		$invoice_no=trim(@$_POST["invoice_no"]);
		$invoice_no=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no);
		$invoice_no=str_replace("'", '"',$invoice_no);
		
		$invoice_no_auto=trim(@$_POST["invoice_no_auto"]);
		$invoice_no_auto=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no_auto);
		$invoice_no_auto=str_replace("'", '"',$invoice_no_auto);
		$invoice_supplier=trim(@$_POST["invoice_supplier"]);
		$invoice_noterima=trim(@$_POST["invoice_noterima"]);
		$invoice_tgl_awal=trim(@$_POST["invoice_tgl_awal"]);
		$invoice_tgl_akhir=trim(@$_POST["invoice_tgl_akhir"]);
		$invoice_nilai=trim(@$_POST["invoice_nilai"]);

		$invoice_jatuhtempo=trim(@$_POST["invoice_jatuhtempo"]);
		$invoice_penagih=trim(@$_POST["invoice_penagih"]);
		$invoice_penagih=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_penagih);
		$invoice_penagih=str_replace("'", '"',$invoice_penagih);
		
		$invoice_keterangan=trim(@$_POST["invoice_keterangan"]);
		$invoice_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_keterangan);
		$invoice_keterangan=str_replace("'", '"',$invoice_keterangan);
		$invoice_status=trim(@$_POST["invoice_status"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_invoice->master_invoice_print($invoice_id ,$invoice_no ,$invoice_no_auto, $invoice_supplier ,
																			$invoice_noterima , $invoice_tgl_awal,$invoice_tgl_akhir,$invoice_nilai, 
																			$invoice_jatuhtempo ,$invoice_penagih, $invoice_keterangan, 
																			$invoice_status, $option,$filter);
		
		$print_view=$this->load->view("main/p_list_tagihan.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}

		$print_file=fopen("print/print_tagihanlist.html","w+");	
		fwrite($print_file, $print_view);
		echo '1';  
		
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_invoice_export_excel(){
		//POST varibale here
		$invoice_id="";
		$invoice_no=trim(@$_POST["invoice_no"]);
		$invoice_no=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no);
		$invoice_no=str_replace("'", '"',$invoice_no);
		
		$invoice_no_auto=trim(@$_POST["invoice_no_auto"]);
		$invoice_no_auto=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_no_auto);
		$invoice_no_auto=str_replace("'", '"',$invoice_no_auto);
		$invoice_supplier=trim(@$_POST["invoice_supplier"]);
		$invoice_noterima=trim(@$_POST["invoice_noterima"]);
		$invoice_tgl_awal=trim(@$_POST["invoice_tgl_awal"]);
		$invoice_tgl_akhir=trim(@$_POST["invoice_tgl_akhir"]);
		$invoice_nilai=trim(@$_POST["invoice_nilai"]);

		$invoice_jatuhtempo=trim(@$_POST["invoice_jatuhtempo"]);
		$invoice_penagih=trim(@$_POST["invoice_penagih"]);
		$invoice_penagih=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_penagih);
		$invoice_penagih=str_replace("'", '"',$invoice_penagih);
		
		$invoice_keterangan=trim(@$_POST["invoice_keterangan"]);
		$invoice_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$invoice_keterangan);
		$invoice_keterangan=str_replace("'", '"',$invoice_keterangan);
		$invoice_status=trim(@$_POST["invoice_status"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_invoice->master_invoice_export_excel($invoice_id ,$invoice_no ,$invoice_no_auto, $invoice_supplier ,
																		$invoice_noterima , $invoice_tgl_awal, $invoice_tgl_akhir,$invoice_nilai, 
																		$invoice_jatuhtempo ,$invoice_penagih, $invoice_keterangan, 
																		$invoice_status,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"master_invoice"); 
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