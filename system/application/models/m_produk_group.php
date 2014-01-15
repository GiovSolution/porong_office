<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: produk_group Model
	+ Description	: For record model process back-end
	+ Filename 		: c_produk_group.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 28/Jul/2009 10:10:08
	
*/

class M_produk_group extends Model{
		
		//constructor
		function M_produk_group() {
			parent::Model();
		}
		
		//function for get list record
		function produk_group_list($filter,$start,$end){
			$query = "SELECT * FROM produk_group LEFT JOIN kategori ON group_kelompok=kategori_id";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (group_kode LIKE '%".addslashes($filter)."%' OR group_nama LIKE '%".addslashes($filter)."%' )";
			}
			
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .= " (group_aktif = 'Aktif' )";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for update record
		function produk_group_update($group_id ,$group_kode, $group_nama , $group_treatment_utama, $group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,
									 $group_dupaket ,$group_dmpaket ,$group_kelompok ,$group_keterangan ,$group_aktif ,$group_kredit,
									 $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dwartawan, $group_dstaffdokter, $group_dstaffnondokter,$group_dpromo,
									 $group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised, $group_opsi ){
		if ($group_aktif=="")
			$group_aktif = "Aktif";
			$data = array(
				"group_id"=>$group_id,
				"group_kode"=>$group_kode,	
				"group_nama"=>$group_nama,			
				"group_duproduk"=>$group_duproduk,			
				"group_dmproduk"=>$group_dmproduk,			
				"group_durawat"=>$group_durawat,			
				"group_dmrawat"=>$group_dmrawat,			
				"group_dupaket"=>$group_dupaket,			
				"group_dmpaket"=>$group_dmpaket,
				//"group_kelompok"=>$group_kelompok,
				"group_keterangan"=>$group_keterangan,			
				"group_aktif"=>$group_aktif,	
				"group_kredit"=>$group_kredit,	
				"group_dultah"=>$group_dultah,
				"group_dcard"=>$group_dcard,
				"group_dkolega"=>$group_dkolega,
				"group_dkeluarga"=>$group_dkeluarga,
				"group_downer"=>$group_downer,
				"group_dgrooming"=>$group_dgrooming,
				"group_dwartawan"=>$group_dwartawan,
				"group_dstaffdokter"=>$group_dstaffdokter,
				"group_dstaffnondokter"=>$group_dstaffnondokter,
				"group_dpromo"=>$group_dpromo,
				// "group_creator"=>$group_creator,			
				// "group_date_create"=>$group_date_create,			
				"group_update"=>$_SESSION[SESSION_USERID],			
				"group_date_update"=>date('Y-m-d H:i:s')			
			);
			
			if($group_treatment_utama=='true')
				$data["group_treatment_utama"]=1;
			if($group_treatment_utama=='false')
				$data["group_treatment_utama"]=0;
			
			$sql="SELECT kategori_id FROM kategori WHERE kategori_id='$group_kelompok'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())	$data["group_kelompok"]=$group_kelompok;
			
			$this->db->where('group_id', $group_id);
			$this->db->update('produk_group', $data);
			
			//log
			if($this->db->affected_rows()){
				$sql="UPDATE produk_group set group_revised=(group_revised+1) WHERE group_id='".$group_id."'";
				$this->db->query($sql);
			}
			
			if($group_opsi=='yes'){
				//UPDATE PRODUK
				$sql="UPDATE produk SET produk_du='".$group_duproduk."', produk_dm='".$group_dmproduk."', produk_dultah='".$group_dultah."', produk_dcard='".$group_dcard."', produk_dkolega='".$group_dkolega."', produk_dkeluarga='".$group_dkeluarga."', produk_downer='".$group_downer."', produk_dgrooming='".$group_dgrooming."', produk_dwartawan = '".$group_dwartawan."' , produk_dstaffdokter = '".$group_dstaffdokter."' , produk_dstaffnondokter = '".$group_dstaffnondokter."', produk_dpromo = '".$group_dpromo."', produk_kredit = '".$group_kredit."'
					WHERE produk_group='".$group_id."'";
				$this->db->query($sql);
				//UPDATE PERAWATAN
				$sql="UPDATE perawatan SET rawat_du='".$group_durawat."', rawat_dm='".$group_dmrawat."', rawat_dultah='".$group_dultah."', rawat_dcard='".$group_dcard."', rawat_dkolega='".$group_dkolega."', rawat_dkeluarga='".$group_dkeluarga."', rawat_downer='".$group_downer."', rawat_dgrooming='".$group_dgrooming."', rawat_dwartawan = '".$group_dwartawan."' , rawat_dstaffdokter = '".$group_dstaffdokter."' , rawat_dstaffnondokter = '".$group_dstaffnondokter."', rawat_dpromo = '".$group_dpromo."'
					WHERE rawat_group='".$group_id."'";
				$this->db->query($sql);
				//UPDATE PAKET
				$sql="UPDATE paket SET paket_du='".$group_dupaket."', paket_dm='".$group_dmpaket."', paket_dultah='".$group_dultah."', paket_dcard='".$group_dcard."', paket_dkolega='".$group_dkolega."', paket_dkeluarga='".$group_dkeluarga."', paket_downer='".$group_downer."', paket_dgrooming='".$group_dgrooming."', paket_dwartawan = '".$group_dwartawan."' , paket_dstaffdokter = '".$group_dstaffdokter."' , paket_dstaffnondokter = '".$group_dstaffnondokter."', paket_dpromo = '".$group_dpromo."'
					WHERE paket_group='".$group_id."'";
				$this->db->query($sql);
				
			}
			
			return '1';
		}
		
		//function for create new record
		function produk_group_create($group_kode, $group_nama , $group_treatment_utama, $group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,
									 $group_dmpaket ,$group_kelompok ,$group_keterangan ,$group_aktif ,$group_kredit,
									 $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dwartawan, $group_dstaffdokter, $group_dstaffnondokter, $group_dpromo,
									 $group_creator ,$group_date_create ,
									 $group_update ,$group_date_update ,$group_revised, $group_opsi ){
		if ($group_aktif=="")
			$group_aktif = "Aktif";
			$data = array(
				"group_kode"=>$group_kode,	
				"group_nama"=>$group_nama,	
				"group_duproduk"=>$group_duproduk,	
				"group_dmproduk"=>$group_dmproduk,	
				"group_durawat"=>$group_durawat,	
				"group_dmrawat"=>$group_dmrawat,	
				"group_dupaket"=>$group_dupaket,	
				"group_dmpaket"=>$group_dmpaket,
				"group_kelompok"=>$group_kelompok,	
				"group_keterangan"=>$group_keterangan,	
				"group_aktif"=>$group_aktif,
				"group_kredit"=>$group_kredit,
				"group_dultah"=>$group_dultah,
				"group_dcard"=>$group_dcard,
				"group_dkolega"=>$group_dkolega,
				"group_dkeluarga"=>$group_dkeluarga,
				"group_downer"=>$group_downer,
				"group_dgrooming"=>$group_dgrooming,
				"group_dwartawan"=>$group_dwartawan,
				"group_dstaffdokter"=>$group_dstaffdokter,
				"group_dstaffnondokter"=>$group_dstaffnondokter,
				"group_dpromo"=>$group_dpromo,
				"group_creator"=>$_SESSION[SESSION_USERID],	
				"group_date_create"=>date('Y-m-d H:i:s'),	
				"group_update"=>$group_update,	
				"group_date_update"=>$group_date_update,	
				"group_revised"=>$group_revised	
			);
			
			if($group_treatment_utama=='true')
				$data["group_treatment_utama"]=1;
			if($group_treatment_utama=='false')
				$data["group_treatment_utama"]=0;
			
			$this->db->insert('produk_group', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function produk_group_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the produk_groups at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM produk_group WHERE group_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM produk_group WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "group_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}     
				}
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function produk_group_search($group_id, $group_kode ,$group_nama ,$group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_keterangan ,$group_kelompok ,$group_aktif ,$group_kredit, $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming,  $group_dkaryawan,$group_dstaffdokter,$group_dstaffnondokter,$group_dpromo,$group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised ,$start,$end){
			//full query
			if($group_aktif=="%Aktif%")
				$group_aktif="Aktif";
			$query="SELECT * FROM produk_group LEFT JOIN kategori ON group_kelompok=kategori_id";
			
			if($group_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_id LIKE '%".$group_id."%'";
			};
			if($group_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_kode = '".$group_kode."'";
			};
			if($group_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_nama LIKE '%".$group_nama."%'";
			};
			if($group_duproduk!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_duproduk LIKE '%".$group_duproduk."%'";
			};
			if($group_dmproduk!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dmproduk LIKE '%".$group_dmproduk."%'";
			};
			if($group_durawat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_durawat LIKE '%".$group_durawat."%'";
			};
			if($group_dmrawat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dmrawat LIKE '%".$group_dmrawat."%'";
			};
			if($group_dupaket!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dupaket LIKE '%".$group_dupaket."%'";
			};
			if($group_dmpaket!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dmpaket LIKE '%".$group_dmpaket."%'";
			};
			if($group_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_keterangan LIKE '%".$group_keterangan."%'";
			};
			if($group_kelompok!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_kelompok='".$group_kelompok."'";
			};
			if($group_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_aktif like '".$group_aktif."'";
			};
			if($group_kredit!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_kredit = '".$group_kredit."'";
			};
			if($group_dultah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dultah='".$group_dultah."'";
			};
			if($group_dcard!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dcard='".$group_dcard."'";
			};
			if($group_dkolega!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dkolega='".$group_dkolega."'";
			};
			if($group_dkeluarga!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dkeluarga='".$group_dkeluarga."'";
			};
			if($group_downer!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_downer='".$group_downer."'";
			};
			if($group_dgrooming!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dgrooming='".$group_dgrooming."'";
			};
			if($group_dkaryawan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dkaryawan='".$group_dkaryawan."'";
			};
			if($group_dstaffdokter!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dstaffdokter='".$group_dstaffdokter."'";
			};
			if($group_dstaffnondokter!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dstaffnondokter='".$group_dstaffnondokter."'";
			};
			if($group_dpromo!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " group_dpromo='".$group_dpromo."'";
			};

			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);    
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for print record
		function produk_group_print($group_id, $group_kode ,$group_nama ,$group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_keterangan ,$group_aktif ,$group_kredit , $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming, $group_dkaryawan,$group_dstaffdokter,$group_dstaffnondokter,$group_dpromo,$group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised ,$option,$filter){
			//full query
			$query="SELECT * FROM produk_group LEFT JOIN kategori ON group_kelompok=kategori_id";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (group_id LIKE '%".addslashes($filter)."%' OR group_kode LIKE '%".addslashes($filter)."%' OR group_nama LIKE '%".addslashes($filter)."%' OR group_duproduk LIKE '%".addslashes($filter)."%' OR group_dmproduk LIKE '%".addslashes($filter)."%' OR group_durawat LIKE '%".addslashes($filter)."%' OR group_dmrawat LIKE '%".addslashes($filter)."%' OR group_dupaket LIKE '%".addslashes($filter)."%' OR group_dmpaket LIKE '%".addslashes($filter)."%' OR group_keterangan LIKE '%".addslashes($filter)."%' OR group_aktif LIKE '%".addslashes($filter)."%' OR group_creator LIKE '%".addslashes($filter)."%' OR group_date_create LIKE '%".addslashes($filter)."%' OR group_update LIKE '%".addslashes($filter)."%' OR group_date_update LIKE '%".addslashes($filter)."%' OR group_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($group_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_id LIKE '%".$group_id."%'";
				};
				if($group_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_kode LIKE '%".$group_kode."%'";
				};
				if($group_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_nama LIKE '%".$group_nama."%'";
				};
				if($group_duproduk!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_duproduk LIKE '%".$group_duproduk."%'";
				};
				if($group_dmproduk!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dmproduk LIKE '%".$group_dmproduk."%'";
				};
				if($group_durawat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_durawat LIKE '%".$group_durawat."%'";
				};
				if($group_dmrawat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dmrawat LIKE '%".$group_dmrawat."%'";
				};
				if($group_dupaket!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dupaket LIKE '%".$group_dupaket."%'";
				};
				if($group_dmpaket!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dmpaket LIKE '%".$group_dmpaket."%'";
				};
				if($group_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_keterangan LIKE '%".$group_keterangan."%'";
				};
				if($group_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_aktif LIKE '%".$group_aktif."%'";
				};
				if($group_kredit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_kredit='".$group_kredit."'";
				};
				if($group_dultah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dultah='".$group_dultah."'";
				};
				if($group_dcard!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dcard='".$group_dcard."'";
				};
				if($group_dkolega!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dkolega='".$group_dkolega."'";
				};
				if($group_dkeluarga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dkeluarga='".$group_dkeluarga."'";
				};
				if($group_downer!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_downer='".$group_downer."'";
				};
				if($group_dgrooming!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dgrooming='".$group_dgrooming."'";
				};	
				if($group_dkaryawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dkaryawan='".$group_dkaryawan."'";
				};
				if($group_dstaffdokter!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dstaffdokter='".$group_dstaffdokter."'";
				};
				if($group_dstaffnondokter!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dstaffnondokter='".$group_dstaffnondokter."'";
				};
				if($group_dpromo!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dpromo='".$group_dpromo."'";
				};
				if($group_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_creator LIKE '%".$group_creator."%'";
				};
				if($group_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_date_create LIKE '%".$group_date_create."%'";
				};
				if($group_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_update LIKE '%".$group_update."%'";
				};
				if($group_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_date_update LIKE '%".$group_date_update."%'";
				};
				if($group_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_revised LIKE '%".$group_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function produk_group_export_excel($group_id, $group_kode ,$group_nama ,$group_duproduk ,$group_dmproduk ,$group_durawat ,$group_dmrawat ,$group_dupaket ,$group_dmpaket ,$group_keterangan ,$group_aktif ,$group_kredit , $group_dultah, $group_dcard, $group_dkolega, $group_dkeluarga, $group_downer, $group_dgrooming,  $group_dkaryawan,$group_dstaffdokter,$group_dstaffnondokter,$group_dpromo,$group_creator ,$group_date_create ,$group_update ,$group_date_update ,$group_revised ,$option,$filter){
			//full query
			$query="select 
					group_kode AS kode,
					group_nama as nama,
					group_kredit as kredit,
					group_duproduk as dU_produk,
					group_dmproduk as dM_produk,
					group_durawat as dU_rawat,
					group_dmrawat as dM_rawat,
					group_dupaket as dU_paket,
					group_dmpaket as dM_paket,
					group_dultah as dultah,
					group_dcard as dcard,
					group_dkolega as dkolega,
					group_dkeluarga as dkeluarga,
					group_downer as downer,
					group_dgrooming as dgrooming,
					group_dwartawan as group_dwartawan,
					group_dstaffdokter as group_dstaffdokter,
					group_dstaffnondokter as group_dstaffnondokter,
					group_dpromo as group_dpromo,
					group_kelompok as kelompok,
					group_keterangan as keterangan,
					group_aktif as aktif
					from produk_group 
					LEFT JOIN kategori ON group_kelompok=kategori_id";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (group_id LIKE '%".addslashes($filter)."%' OR group_kode LIKE '%".addslashes($filter)."%' OR group_nama LIKE '%".addslashes($filter)."%' OR group_duproduk LIKE '%".addslashes($filter)."%' OR group_dmproduk LIKE '%".addslashes($filter)."%' OR group_durawat LIKE '%".addslashes($filter)."%' OR group_dmrawat LIKE '%".addslashes($filter)."%' OR group_dupaket LIKE '%".addslashes($filter)."%' OR group_dmpaket LIKE '%".addslashes($filter)."%' OR group_keterangan LIKE '%".addslashes($filter)."%' OR group_aktif LIKE '%".addslashes($filter)."%' OR group_creator LIKE '%".addslashes($filter)."%' OR group_date_create LIKE '%".addslashes($filter)."%' OR group_update LIKE '%".addslashes($filter)."%' OR group_date_update LIKE '%".addslashes($filter)."%' OR group_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($group_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_id LIKE '%".$group_id."%'";
				};
				if($group_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_kode LIKE '%".$group_kode."%'";
				};
				if($group_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_nama LIKE '%".$group_nama."%'";
				};
				if($group_duproduk!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_duproduk LIKE '%".$group_duproduk."%'";
				};
				if($group_dmproduk!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dmproduk LIKE '%".$group_dmproduk."%'";
				};
				if($group_durawat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_durawat LIKE '%".$group_durawat."%'";
				};
				if($group_dmrawat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dmrawat LIKE '%".$group_dmrawat."%'";
				};
				if($group_dupaket!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dupaket LIKE '%".$group_dupaket."%'";
				};
				if($group_dmpaket!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dmpaket LIKE '%".$group_dmpaket."%'";
				};
				if($group_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_keterangan LIKE '%".$group_keterangan."%'";
				};
				if($group_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_aktif LIKE '%".$group_aktif."%'";
				};
				if($group_kredit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_kredit='".$group_kredit."'";
				};
				if($group_dultah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dultah='".$group_dultah."'";
				};
				if($group_dcard!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dcard='".$group_dcard."'";
				};
				if($group_dkolega!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dkolega='".$group_dkolega."'";
				};
				if($group_dkeluarga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dkeluarga='".$group_dkeluarga."'";
				};
				if($group_downer!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_downer='".$group_downer."'";
				};
				if($group_dgrooming!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dgrooming='".$group_dgrooming."'";
				};	
				if($group_dkaryawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dkaryawan='".$group_dkaryawan."'";
				};
				if($group_dstaffdokter!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dstaffdokter='".$group_dstaffdokter."'";
				};
				if($group_dstaffnondokter!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dstaffnondokter='".$group_dstaffnondokter."'";
				};
				if($group_dpromo!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_dpromo='".$group_dpromo."'";
				};
				if($group_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_creator LIKE '%".$group_creator."%'";
				};
				if($group_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_date_create LIKE '%".$group_date_create."%'";
				};
				if($group_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_update LIKE '%".$group_update."%'";
				};
				if($group_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_date_update LIKE '%".$group_date_update."%'";
				};
				if($group_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " group_revised LIKE '%".$group_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>