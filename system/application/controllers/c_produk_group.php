<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: produk_group Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_produk_group.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 28/Jul/2009 10:10:08
	
*/

//class of produk_group
class C_produk_group extends Controller {

	//constructor
	function C_produk_group(){
		parent::Controller();
		session_start();
		$this->load->model('m_produk_group', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_produk_group');
	}
	
	function get_kategori_list(){
		$result=$this->m_public_function->get_kategori_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->produk_group_list();
				break;
			case "UPDATE":
				$this->produk_group_update();
				break;
			case "CREATE":
				$this->produk_group_create();
				break;
			case "DELETE":
				$this->produk_group_delete();
				break;
			case "SEARCH":
				$this->produk_group_search();
				break;
			case "PRINT":
				$this->produk_group_print();
				break;
			case "EXCEL":
				$this->produk_group_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function produk_group_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_produk_group->produk_group_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function produk_group_update(){
		//POST variable here
		$group_id=trim(@$_POST["group_id"]);
		$group_nama=trim(@$_POST["group_nama"]);
		$group_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$group_nama);
		$group_nama=str_replace("\\", "",$group_nama);
		$group_nama=str_replace("'", '"',$group_nama);
		$group_treatment_utama=trim(@$_POST["group_treatment_utama"]);
		$group_kode=trim(@$_POST["group_kode"]);
		$group_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kode);
		$group_kode=str_replace("\\", "",$group_kode);
		$group_kode=str_replace("'", '"',$group_kode);
		$group_duproduk=trim(@$_POST["group_duproduk"]);
		$group_dmproduk=trim(@$_POST["group_dmproduk"]);
		$group_durawat=trim(@$_POST["group_durawat"]);
		$group_dmrawat=trim(@$_POST["group_dmrawat"]);
		$group_dupaket=trim(@$_POST["group_dupaket"]);
		$group_dmpaket=trim(@$_POST["group_dmpaket"]);
		$group_kelompok=trim(@$_POST["group_kelompok"]);
		$group_kelompok=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kelompok);
		$group_kelompok=str_replace("'", '"',$group_kelompok);
		$group_keterangan=trim(@$_POST["group_keterangan"]);
		$group_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$group_keterangan);
		$group_keterangan=str_replace("'", '"',$group_keterangan);
		$group_aktif=trim(@$_POST["group_aktif"]);
		$group_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$group_aktif);
		$group_aktif=str_replace("'", '"',$group_aktif);
		$group_kredit=trim(@$_POST["group_kredit"]);
		$group_dultah=trim(@$_POST["group_dultah"]);
		$group_dcard=trim(@$_POST["group_dcard"]);
		$group_dkolega=trim(@$_POST["group_dkolega"]);
		$group_dkeluarga=trim(@$_POST["group_dkeluarga"]);
		$group_downer=trim(@$_POST["group_downer"]);
		$group_dgrooming=trim(@$_POST["group_dgrooming"]);
		$group_dwartawan=trim(@$_POST["group_dwartawan"]);
		$group_dstaffdokter=trim(@$_POST["group_dstaffdokter"]);
		$group_dstaffnondokter=trim(@$_POST["group_dstaffnondokter"]);
		$group_dpromo=trim(@$_POST["group_dpromo"]);
		$group_creator="";
		$group_date_create="";
		$group_update="";
		$group_date_update="";
		$group_revised="";
		$group_opsi=@$_POST["group_opsi"];
		
		
		$result = $this->m_produk_group->produk_group_update($group_id , $group_kode, $group_nama , $group_treatment_utama, $group_duproduk ,$group_dmproduk ,$group_durawat,
															 $group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_kelompok ,$group_keterangan ,
															 $group_aktif , $group_kredit,$group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dwartawan, $group_dstaffdokter, $group_dstaffnondokter,$group_dpromo,
															 $group_creator ,$group_date_create ,$group_update ,$group_date_update ,
															 $group_revised, $group_opsi );
		echo $result;
	}
	
	//function for create new record
	function produk_group_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$group_kode=trim(@$_POST["group_kode"]);
		$group_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kode);
		$group_kode=str_replace("'", '"',$group_kode);
		$group_nama=trim(@$_POST["group_nama"]);
		$group_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$group_nama);
		$group_nama=str_replace("'", '"',$group_nama);
		$group_treatment_utama=trim(@$_POST["group_treatment_utama"]);
		$group_duproduk=trim(@$_POST["group_duproduk"]);
		$group_dmproduk=trim(@$_POST["group_dmproduk"]);
		$group_durawat=trim(@$_POST["group_durawat"]);
		$group_dmrawat=trim(@$_POST["group_dmrawat"]);
		$group_dupaket=trim(@$_POST["group_dupaket"]);
		$group_dmpaket=trim(@$_POST["group_dmpaket"]);
		$group_kelompok=trim(@$_POST["group_kelompok"]);
		$group_kelompok=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kelompok);
		$group_kelompok=str_replace("'", '"',$group_kelompok);
		$group_keterangan=trim(@$_POST["group_keterangan"]);
		$group_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$group_keterangan);
		$group_keterangan=str_replace("'", '"',$group_keterangan);
		$group_aktif=trim(@$_POST["group_aktif"]);
		$group_kredit=trim(@$_POST["group_kredit"]);
		$group_dultah=trim(@$_POST["group_dultah"]);
		$group_dcard=trim(@$_POST["group_dcard"]);
		$group_dkolega=trim(@$_POST["group_dkolega"]);
		$group_dkeluarga=trim(@$_POST["group_dkeluarga"]);
		$group_downer=trim(@$_POST["group_downer"]);
		$group_dgrooming=trim(@$_POST["group_dgrooming"]);
		$group_dwartawan=trim(@$_POST["group_dwartawan"]);
		$group_dstaffdokter=trim(@$_POST["group_dstaffdokter"]);
		$group_dstaffnondokter=trim(@$_POST["group_dstaffnondokter"]);
		$group_dpromo=trim(@$_POST["group_dpromo"]);
		$group_creator="";
		$group_date_create="";
		$group_update="";
		$group_date_update="";
		$group_revised="";
		$group_opsi=@$_POST["group_opsi"];
		
		$result=$this->m_produk_group->produk_group_create($group_kode, $group_nama , $group_treatment_utama, $group_duproduk ,$group_dmproduk ,$group_durawat ,
														   $group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_kelompok ,$group_keterangan ,
														   $group_aktif ,$group_kredit, $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dwartawan, $group_dstaffdokter, $group_dstaffnondokter,$group_dpromo,
														   $group_creator ,$group_date_create ,$group_update ,$group_date_update ,
														   $group_revised, $group_opsi);
		echo $result;
	}

	//function for delete selected record
	function produk_group_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_produk_group->produk_group_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function produk_group_search(){
		//POST varibale here
		$group_id=trim(@$_POST["group_id"]);
		$group_kode=trim(@$_POST["group_kode"]);
		$group_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kode);
		$group_kode=str_replace("'", '"',$group_kode);
		$group_nama=trim(@$_POST["group_nama"]);
		$group_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$group_nama);
		$group_nama=str_replace("'", '"',$group_nama);
		$group_duproduk=trim(@$_POST["group_duproduk"]);
		$group_dmproduk=trim(@$_POST["group_dmproduk"]);
		$group_durawat=trim(@$_POST["group_durawat"]);
		$group_dmrawat=trim(@$_POST["group_dmrawat"]);
		$group_dupaket=trim(@$_POST["group_dupaket"]);
		$group_dmpaket=trim(@$_POST["group_dmpaket"]);
		$group_keterangan=trim(@$_POST["group_keterangan"]);
		$group_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$group_keterangan);
		$group_keterangan=str_replace("'", '"',$group_keterangan);
		$group_kelompok=trim(@$_POST["group_kelompok"]);
		$group_aktif=trim(@$_POST["group_aktif"]);
		$group_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$group_aktif);
		$group_aktif=str_replace("'", '"',$group_aktif);
		$group_kredit=trim(@$_POST["group_kredit"]);
		$group_dultah=trim(@$_POST["group_dultah"]);
		$group_dcard=trim(@$_POST["group_dcard"]);
		$group_dkolega=trim(@$_POST["group_dkolega"]);
		$group_dkeluarga=trim(@$_POST["group_dkeluarga"]);
		$group_downer=trim(@$_POST["group_downer"]);
		$group_dgrooming=trim(@$_POST["group_dgrooming"]);
		$group_dkaryawan=trim(@$_POST["group_dkaryawan"]);
		$group_dstaffdokter=trim(@$_POST["group_dstaffdokter"]);
		$group_dstaffnondokter=trim(@$_POST["group_dstaffnondokter"]);
		$group_dpromo=trim(@$_POST["group_dpromo"]);
		$group_creator=trim(@$_POST["group_creator"]);
		$group_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$group_creator);
		$group_creator=str_replace("'", '"',$group_creator);
		$group_date_create=trim(@$_POST["group_date_create"]);
		$group_update=trim(@$_POST["group_update"]);
		$group_update=str_replace("/(<\/?)(p)([^>]*>)", "",$group_update);
		$group_update=str_replace("'", '"',$group_update);
		$group_date_update=trim(@$_POST["group_date_update"]);
		$group_revised=trim(@$_POST["group_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_produk_group->produk_group_search($group_id, $group_kode ,$group_nama ,$group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_keterangan ,$group_kelompok, $group_aktif,$group_kredit, $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dkaryawan,$group_dstaffdokter,$group_dstaffnondokter,$group_dpromo,$group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised ,$start,$end);
		echo $result;
	}


	function produk_group_print(){
  		//POST varibale here
		$group_id=trim(@$_POST["group_id"]);
		$group_kode=trim(@$_POST["group_kode"]);
		$group_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kode);
		$group_kode=str_replace("'", '"',$group_kode);
		$group_nama=trim(@$_POST["group_nama"]);
		$group_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$group_nama);
		$group_nama=str_replace("'", '"',$group_nama);
		$group_duproduk=trim(@$_POST["group_duproduk"]);
		$group_dmproduk=trim(@$_POST["group_dmproduk"]);
		$group_durawat=trim(@$_POST["group_durawat"]);
		$group_dmrawat=trim(@$_POST["group_dmrawat"]);
		$group_dupaket=trim(@$_POST["group_dupaket"]);
		$group_dmpaket=trim(@$_POST["group_dmpaket"]);
		$group_keterangan=trim(@$_POST["group_keterangan"]);
		$group_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$group_keterangan);
		$group_keterangan=str_replace("'", '"',$group_keterangan);
		$group_aktif=trim(@$_POST["group_aktif"]);
		$group_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$group_aktif);
		$group_aktif=str_replace("'", '"',$group_aktif);
		$group_kredit=trim(@$_POST["group_kredit"]);
		$group_dultah=trim(@$_POST["group_dultah"]);
		$group_dcard=trim(@$_POST["group_dcard"]);
		$group_dkolega=trim(@$_POST["group_dkolega"]);
		$group_dkeluarga=trim(@$_POST["group_dkeluarga"]);
		$group_downer=trim(@$_POST["group_downer"]);
		$group_dgrooming=trim(@$_POST["group_dgrooming"]);
		$group_dkaryawan=trim(@$_POST["group_dkaryawan"]);
		$group_dstaffdokter=trim(@$_POST["group_dstaffdokter"]);
		$group_dstaffnondokter=trim(@$_POST["group_dstaffnondokter"]);
		$group_dpromo=trim(@$_POST["group_dpromo"]);
		$group_creator=trim(@$_POST["group_creator"]);
		$group_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$group_creator);
		$group_creator=str_replace("'", '"',$group_creator);
		$group_date_create=trim(@$_POST["group_date_create"]);
		$group_update=trim(@$_POST["group_update"]);
		$group_update=str_replace("/(<\/?)(p)([^>]*>)", "",$group_update);
		$group_update=str_replace("'", '"',$group_update);
		$group_date_update=trim(@$_POST["group_date_update"]);
		$group_revised=trim(@$_POST["group_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_produk_group->produk_group_print($group_id, $group_kode ,$group_nama ,$group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_keterangan ,$group_aktif ,$group_kredit,
															$group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dkaryawan,$group_dstaffdokter,$group_dstaffnondokter,$group_dpromo,$group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=20;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("produk_grouplist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Produk_group Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Produk_group List'><caption>DAFTAR GROUP 1</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Kredit(%)</th><th scope='col'>DU Produk</th><th scope='col'>DM Produk</th><th scope='col'>DU Rawat</th><th scope='col'>DM Rawat</th><th scope='col'>DU Paket</th><th scope='col'>DM Paket</th><th scope='col'>Ultah</th><th scope='col'>Card</th><th scope='col'>Kolega</th><th scope='col'>Keluarga</th><th scope='col'>Owner</th><th scope='col'>Grooming</th><th scope='col'>Wartawan</th><th scope='col'>Staff Dokter</th><th scope='col'>Staff Non Dokter</th><th scope='col'>Promo</th><th scope='col'>Keterangan</th><th scope='col'>Group Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " </td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
			$i++;
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $i);
				fwrite($file,"</th><td>");
				fwrite($file, $data['group_nama']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_kredit']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_duproduk']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dmproduk']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_durawat']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dmrawat']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dupaket']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dmpaket']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dultah']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dcard']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dkolega']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dkeluarga']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_downer']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dgrooming']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dwartawan']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dstaffdokter']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dstaffnondokter']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['group_dpromo']);
				fwrite($file,"</td><td>");


				fwrite($file, $data['group_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function produk_group_export_excel(){
		//POST varibale here
		$group_id=trim(@$_POST["group_id"]);
		$group_kode=trim(@$_POST["group_kode"]);
		$group_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$group_kode);
		$group_kode=str_replace("'", '"',$group_kode);
		$group_nama=trim(@$_POST["group_nama"]);
		$group_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$group_nama);
		$group_nama=str_replace("'", '"',$group_nama);
		$group_duproduk=trim(@$_POST["group_duproduk"]);
		$group_dmproduk=trim(@$_POST["group_dmproduk"]);
		$group_durawat=trim(@$_POST["group_durawat"]);
		$group_dmrawat=trim(@$_POST["group_dmrawat"]);
		$group_dupaket=trim(@$_POST["group_dupaket"]);
		$group_dmpaket=trim(@$_POST["group_dmpaket"]);
		$group_keterangan=trim(@$_POST["group_keterangan"]);
		$group_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$group_keterangan);
		$group_keterangan=str_replace("'", '"',$group_keterangan);
		$group_aktif=trim(@$_POST["group_aktif"]);
		$group_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$group_aktif);
		$group_aktif=str_replace("'", '"',$group_aktif);
		$group_kredit=trim(@$_POST["group_kredit"]);
		$group_dultah=trim(@$_POST["group_dultah"]);
		$group_dcard=trim(@$_POST["group_dcard"]);
		$group_dkolega=trim(@$_POST["group_dkolega"]);
		$group_dkeluarga=trim(@$_POST["group_dkeluarga"]);
		$group_downer=trim(@$_POST["group_downer"]);
		$group_dgrooming=trim(@$_POST["group_dgrooming"]);
		$group_dkaryawan=trim(@$_POST["group_dkaryawan"]);
		$group_dstaffdokter=trim(@$_POST["group_dstaffdokter"]);
		$group_dstaffnondokter=trim(@$_POST["group_dstaffnondokter"]);
		$group_dpromo=trim(@$_POST["group_dpromo"]);
		$group_creator=trim(@$_POST["group_creator"]);
		$group_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$group_creator);
		$group_creator=str_replace("'", '"',$group_creator);
		$group_date_create=trim(@$_POST["group_date_create"]);
		$group_update=trim(@$_POST["group_update"]);
		$group_update=str_replace("/(<\/?)(p)([^>]*>)", "",$group_update);
		$group_update=str_replace("'", '"',$group_update);
		$group_date_update=trim(@$_POST["group_date_update"]);
		$group_revised=trim(@$_POST["group_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_produk_group->produk_group_export_excel($group_id, $group_kode, $group_nama ,$group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_keterangan ,$group_aktif ,$group_kredit,
																	$group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dkaryawan,$group_dstaffdokter,$group_dstaffnondokter,$group_dpromo,$group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised ,$option,$filter);
		
		to_excel($query,"produk_group"); 
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