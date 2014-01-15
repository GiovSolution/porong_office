<?php
/* 	
	+ Module  		: resep dokter Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_resep_dokter.php
 	+ Author  		: Fred

	
*/

//class of resep dokter
class C_resep_dokter extends Controller {

	//constructor
	function C_resep_dokter(){
		parent::Controller();
		$this->load->model('m_resep_dokter', '', TRUE);
		//session_start();
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_resep_dokter');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_auto_karyawan_sip(){
		$karyawan_id = (integer) (isset($_POST['karyawan_id']) ? $_POST['karyawan_id'] : $_GET['karyawan_id']);
		$result=$this->m_public_function->get_auto_karyawan_sip($karyawan_id);
		echo $result;
	}
	
	function get_auto_cust_no(){
		$cust_id = (integer) (isset($_POST['cust_id']) ? $_POST['cust_id'] : $_GET['cust_id']);
		$result=$this->m_public_function->get_auto_cust_no($cust_id);
		echo $result;
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Dokter");
		echo $result;
	}
	
	function get_terapis_list(){
		//ID dokter pada tabel departemen adalah 9
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Therapist");
		echo $result;
	}
	

	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_resep_dokter->get_master_id();
		echo $result;
	}
	
	function get_produk_list(){
	
		/*$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$paket_id = isset($_POST['paket_id']) ? @$_POST['paket_id'] : @$_GET['paket_id'];
		$result = $this->m_resep_dokter->get_produk_list($query,$start,$end);
		echo $result;*/
	
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$produk_id = isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id'];
		if($task=='detail')
			$result=$this->m_resep_dokter->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_resep_dokter->get_produk_list($query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_resep_dokter->get_produk_selected_list($master_id, $selected_id,$query,$start,$end);
		elseif($task=='racikan')
			$result=$this->m_resep_dokter->get_produk_racikan_list_by_produk_id($produk_id,$query,$start,$end);
		echo $result;
	
	
	}
	
	function get_produk_racikan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$produk_id = isset($_POST['produk_id']) ? @$_POST['produk_id'] : @$_GET['produk_id'];
		$result = $this->m_resep_dokter->get_produk_racikan_list($query,$start,$end);
		echo $result;
	}
	
	
	
	function get_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_resep_dokter->get_paket_list($query,$start,$end);
		echo $result;
	}
	
	
	function get_satuan_bydrl_list(){
		$query = (integer) (isset($_POST['query']) ? $_POST['query'] : 0);
		$produk_id = (integer) (isset($_POST['produk_id']) ? $_POST['produk_id'] : 0);
		$result = $this->m_resep_dokter->get_satuan_bydrl_list($query,$produk_id);
		echo $result;
	}
	
	
	
	function detail_resepdokter_lepasan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->detail_resepdokter_lepasan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	
	function master_kombinasi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->master_kombinasi_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	
	function detail_resepdokter_kombinasi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->detail_resepdokter_kombinasi_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	function detail_resepdokter_tambahan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->detail_resepdokter_tambahan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	
	function resepdokter_detail_lepasan_insert(){
		$dresepl_id=trim(@$_POST["dresepl_id"]);
		$dresepl_master=trim(@$_POST["dresepl_master"]);
		$dresepl_produk=trim(@$_POST["dresepl_produk"]);
		$dresepl_tambahan=trim(@$_POST["dresepl_tambahan"]);
		$dresepl_satuan=trim(@$_POST["dresepl_satuan"]);
		$dresepl_jumlah=trim(@$_POST["dresepl_jumlah"]);
		$cetak=trim(@$_POST['cetak']);
		$count=trim(@$_POST['count']);
		$dcount=trim(@$_POST['dcount']);

		$result=$this->m_resep_dokter->resepdokter_detail_lepasan_insert($dresepl_id ,$dresepl_master ,$dresepl_produk, $dresepl_tambahan, $dresepl_satuan, $dresepl_jumlah, $cetak, $count, $dcount);
		echo $result;
	}
	
	
	
	function resepdokter_master_kombinasi_insert(){
		$rkombinasi_id=trim(@$_POST["rkombinasi_id"]);
		$rkombinasi_master=trim(@$_POST["rkombinasi_master"]);
		$rkombinasi_produk=trim(@$_POST["rkombinasi_produk"]);
		$rkombinasi_keterangan=trim(@$_POST["rkombinasi_keterangan"]);
		$cetak=trim(@$_POST['cetak']);
		$count=trim(@$_POST['count']);
		$dcount=trim(@$_POST['dcount']);

		$result=$this->m_resep_dokter->resepdokter_master_kombinasi_insert($rkombinasi_id ,$rkombinasi_master ,$rkombinasi_produk, $rkombinasi_keterangan, $cetak, $count, $dcount);
		echo $result;
	}
	
	
	
	function resepdokter_detail_kombinasi_insert(){
		$dresepk_id=trim(@$_POST["dresepk_id"]);
		$dresepk_master=trim(@$_POST["dresepk_master"]);
		$dresepk_resepmaster=trim(@$_POST["dresepk_resepmaster"]);
		$dresepk_produk=trim(@$_POST["dresepk_produk"]);
		$dresepk_satuan=trim(@$_POST["dresepk_satuan"]);
		$dresepk_jumlah=trim(@$_POST["dresepk_jumlah"]);
		$cetak=trim(@$_POST['cetak']);
		$count=trim(@$_POST['count']);
		$dcount=trim(@$_POST['dcount']);
		
		$array_dresepk_id = json_decode(stripslashes($dresepk_id));
		$array_dresepk_produk = json_decode(stripslashes($dresepk_produk));
		$array_dresepk_satuan = json_decode(stripslashes($dresepk_satuan));
		$array_dresepk_jumlah = json_decode(stripslashes($dresepk_jumlah));
		

		$result=$this->m_resep_dokter->resepdokter_detail_kombinasi_insert($dresepk_id ,$dresepk_master , $dresepk_resepmaster, $dresepk_produk, $dresepk_satuan, $dresepk_jumlah, $cetak, $count, $dcount);
		echo $result;
	}
	
	
	function resepdokter_detail_tambahan_insert(){
		$dresept_id=trim(@$_POST["dresept_id"]);
		$dresept_master=trim(@$_POST["dresept_master"]);
		//$dresepl_produk=trim(@$_POST["dresepl_produk"]);
		$dresept_tambahan=trim(@$_POST["dresept_tambahan"]);
		$dresept_tambahan=str_replace("/(<\/?)(p)([^>]*>)", "",$dresept_tambahan);
		$dresept_tambahan=str_replace("\\", "",$dresept_tambahan);
		$dresept_satuan=trim(@$_POST["dresept_satuan"]);
		$dresept_jumlah=trim(@$_POST["dresept_jumlah"]);
		$cetak_tambahan=trim(@$_POST['cetak_tambahan']);
		$count_tambahan=trim(@$_POST['count_tambahan']);
		$dcount_tambahan=trim(@$_POST['dcount_tambahan']);

		$result=$this->m_resep_dokter->resepdokter_detail_tambahan_insert($dresept_id ,$dresept_master ,$dresept_tambahan, $dresept_satuan, $dresept_jumlah, $cetak_tambahan, $count_tambahan, $dcount_tambahan);
		echo $result;
	}
	

	function detail_resepdokter_lepasan_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->detail_resepdokter_lepasan_purge($master_id);
	}
	
	function master_resepdokter_kombinasi_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->master_resepdokter_kombinasi_purge($master_id);
	}
	
	
	function detail_resepdokter_kombinasi_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->detail_resepdokter_kombinasi_purge($master_id);
	}
	
	function detail_resepdokter_tambahan_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_resep_dokter->detail_resepdokter_tambahan_purge($master_id);
	}
	
	function get_detail_racikan_by_produk_id(){
		$id_racikan = isset($_POST['id_racikan']) ? @$_POST['id_racikan'] : "";
		$result=$this->m_resep_dokter->get_detail_racikan_by_produk_id($id_racikan);
		echo $result;
	}
	
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->resep_dokter_list();
				break;
			case "UPDATE":
				$this->resep_dokter_update();
				break;
			case "CREATE":
				$this->resep_dokter_create();
				break;
			case "DELETE":
				$this->resep_dokter_delete();
				break;
			case "DELETE_KOMBINASI":
				$this->master_kombinasi_delete();
				break;	
			case "SEARCH":
				$this->resep_dokter_search();
				break;
			case "PRINT":
				$this->resep_dokter_print();
				break;
			case "EXCEL":
				$this->resep_dokter_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function resep_dokter_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_resep_dokter->resep_dokter_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function resep_dokter_update(){
		//POST variable here
		$resep_id=trim(@$_POST["resep_id"]);
		$resep_nofaktur=trim(@$_POST["resep_nofaktur"]);
		$resep_custid=trim(@$_POST["resep_custid"]);
		$resep_cust_manual=trim(@$_POST["resep_cust_manual"]);
		$resep_tanggal=trim(@$_POST["resep_tanggal"]);
		$resep_dokterid=trim(@$_POST["resep_dokterid"]);
		$mode_edit=trim(@$_POST["mode_edit"]);
		$result = $this->m_resep_dokter->resep_dokter_update($resep_id, $resep_nofaktur, $resep_custid, $resep_cust_manual, $resep_tanggal, $resep_dokterid, $mode_edit);
		echo $result;
	}
	
	//function for create new record
	function resep_dokter_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$resep_custid=trim(@$_POST["resep_custid"]);
		$resep_cust_manual=trim(@$_POST["resep_cust_manual"]);
		$resep_dokterid=trim(@$_POST["resep_dokterid"]);
		$resep_no=trim(@$_POST["resep_no"]);
		$resep_no=str_replace("/(<\/?)(p)([^>]*>)", "",$resep_no);
		$resep_no=str_replace("'", "''",$resep_no);
		
		$resep_nofaktur=trim(@$_POST["resep_nofaktur"]);
		$resep_nofaktur=str_replace("/(<\/?)(p)([^>]*>)", "",$resep_nofaktur);
		$resep_nofaktur=str_replace("'", "''",$resep_nofaktur);
		$resep_tanggal=trim(@$_POST["resep_tanggal"]);
		$resep_keterangan=trim(@$_POST["resep_keterangan"]);
		$resep_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$resep_keterangan);
		$resep_keterangan=str_replace("'", "''",$resep_keterangan);
		
		$result=$this->m_resep_dokter->resep_dokter_create($resep_custid, $resep_cust_manual, $resep_dokterid, $resep_no, $resep_nofaktur, $resep_tanggal, $resep_keterangan);
		echo $result;
	}

	//function for delete selected record
	function resep_dokter_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_resep_dokter->resep_dokter_delete($pkid);
		echo $result;
	}
	
	//function for delete master dan detail kombinasi on selected record
	function master_kombinasi_delete(){
		
		$rkombinasi_produk = $_POST['rkombinasi_produk'];
		$pkid_rmaster_kombinasi = json_decode(stripslashes($rkombinasi_produk));
		
		$ids_kombinasi = $_POST['ids_kombinasi']; // Get our array back and translate it :
		$pkid_kombinasi = json_decode(stripslashes($ids_kombinasi));
		$result=$this->m_resep_dokter->master_kombinasi_delete($pkid_kombinasi, $pkid_rmaster_kombinasi);
		echo $result;
	}
	
	

	//function for advanced search
	function resep_dokter_search(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_resep_dokter->resep_dokter_search($trawat_id ,$card_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_dokter ,$trawat_status ,$start,$end);
		echo $result;
	}


	function resep_dokter_print(){
  		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		$card_keterangan=trim(@$_POST["card_keterangan"]);
		$card_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$card_keterangan);
		$card_keterangan=str_replace("'", "''",$card_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_resep_dokter->resep_dokter_print($trawat_id ,$card_cust ,$card_keterangan ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=8;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("tindakanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Tindakan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body><table summary='Tindakan List'><caption>TINDAKAN</caption><thead><tr><th scope='col'>Trawat Id</th><th scope='col'>Trawat Cust</th><th scope='col'>Trawat Keterangan</th><th scope='col'>Trawat Creator</th><th scope='col'>Trawat Date Create</th><th scope='col'>Trawat Update</th><th scope='col'>Trawat Date Update</th><th scope='col'>Trawat Revised</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Tindakan</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['trawat_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['card_cust']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['card_keterangan']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_creator']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_date_create']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_update']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_date_update']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function resep_dokter_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		$card_keterangan=trim(@$_POST["card_keterangan"]);
		$card_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$card_keterangan);
		$card_keterangan=str_replace("'", "''",$card_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_resep_dokter->resep_dokter_export_excel($trawat_id ,$card_cust ,$card_keterangan ,$option,$filter);
		
		to_excel($query,"tindakan"); 
		echo '1';
			
	}
	
	
	function print_paper(){
  		//POST varibale here
		$resep_id=trim(@$_POST["resep_id"]);

		$result = $this->m_resep_dokter->print_paper($resep_id);
		$result2 = $this->m_resep_dokter->print_paper2($resep_id);
		$result_racikan = $this->m_resep_dokter->print_paper_racikan($resep_id);
		$result_data = $this->m_resep_dokter->print_paper_data($resep_id);
		
		//$iklan = $this->m_resep_dokter->iklan();
		$rs_data = $result_data->row();
		if ($result->row() != null)
			$rs=$result->row();
		if ($result2->row() != null)
			$rs2=$result2->row();
		if ($result_racikan->row() != null)
			$rs_racikan = $result_racikan->row();

		//$rsiklan=$iklan->row();

		$detail_resepdokter=$result->result();
		$detail_resepdokter_tambahan=$result2->result();
		$detail_resepdokter_racikan=$result_racikan->result();
		$detail_resepdokter_data=$result_data->result();
		
		$data['karyawan_nama']=$rs_data->karyawan_nama;
		$data['karyawan_sip']=$rs_data->karyawan_sip;
		$data['cust_no']=$rs_data->cust_no;
		$data['cust_nama']=$rs_data->cust_nama;
		$data['cust_alamat']=$rs_data->cust_alamat;
		$data['resep_tanggal']=date("d-m-Y",strtotime($rs_data->resep_tanggal));
		$data['resep_no']=$rs_data->resep_no;
		$data['resep_cust_manual']=$rs_data->resep_cust_manual;
		
		if ($result->row() != null) {
			$data['produk_nama']=$rs->produk_nama;
			$data['satuan_nama']=$rs->satuan_nama;
			$data['dresepl_jumlah']=$rs->dresepl_jumlah;
		}
		
		if ($result2->row() != null) {
			$data['dresept_tambahan']=$rs2->dresept_tambahan;
			$data['dresept_satuan']=$rs2->dresept_satuan;
			$data['dresept_jumlah']=$rs2->dresept_jumlah;
		}
		
		if ($result_racikan->row() != null) {
			$data['rkombinasi_keterangan']=$rs_racikan->rkombinasi_keterangan;
		}
		

		$data['detail_resepdokter']=$detail_resepdokter;
		$data['detail_resepdokter_tambahan']=$detail_resepdokter_tambahan;
		$data['detail_resepdokter_racikan']=$detail_resepdokter_racikan;
		$data['detail_resepdokter_data']=$detail_resepdokter_data;
		$viewdata=$this->load->view("main/resepdokter_formcetak",$data,TRUE);
		
		$file = fopen("resepdokter_paper.html",'w');
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