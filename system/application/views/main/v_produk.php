<?
/* 	
	GIOV Solution
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<style type="text/css">
        p { width:650px; }
		.search-item {
			font:normal 11px tahoma, arial, helvetica, sans-serif;
			padding:3px 10px 3px 10px;
			border:1px solid #fff;
			border-bottom:1px solid #eeeeee;
			white-space:normal;
			color:#555;
		}
		.search-item h3 {
			display:block;
			font:inherit;
			font-weight:bold;
			color:#222;
		}
		
		.search-item h3 span {
			float: right;
			font-weight:normal;
			margin:0 0 5px 5px;
			width:100px;
			display:block;
			clear:none;
		}
    </style>
<script><!--
/* declare function */		
var produk_DataStore;
var produk_ColumnModel;
var produkListEditorGrid;
var produk_createForm;
var produk_createWindow;
var produk_searchForm;
var produk_searchWindow;
var produk_SelectedRow;
var produk_ContextMenu;
//for detail data
var satuan_konversi_DataStore;
var satuan_konversiListEditorGrid;
var satuan_konversi_ColumnModel;
var satuan_konversi_proxy;
var satuan_konversi_writer;
var satuan_konversi_reader;
var editor_satuan_konversi;
var editor_satuan_konversi_cancel;
var produk_racikan_DataStore;
var produk_racikanListEditorGrid;
var produk_racikan_ColumnModel;
var produk_racikan_reader;
var produk_awal_jumlah;
var produk_awal_nilai;
//declare konstant
var produk_post2db = '';
var msg = '';
var produk_pageS=15;
var temp_satuan_add=0;
var dt = new Date(); 

/* declare variable here for Field*/
var produk_idField;
var produk_kodeField;
var produk_kodelamaField;
var produk_groupField;
var produk_kategoriField;
var produk_kategoritxtField;
var produk_racikanField;
var produk_edit_hargaField;
var produk_kontribusiField;
var produk_jenisField;
var produk_namaField;
var produk_satuanField;
var produk_duField;
var produk_dmField;
var produk_dultahField;
var produk_dcardField;
var produk_dkolegaField;
var produk_dkeluargaField;
var produk_downerField;
var produk_dgroomingField;
var produk_dwartawanField;
var produk_dstaffdokterField;
var produk_dstaffnondokterField;
var produk_dpromoField;
var produk_pointField;
var produk_kreditField
var produk_volumeField;
var produk_hargaField;
var produk_harga_kiField;
var produk_harga_hrField;
var produk_harga_tpField;
var produk_harga_dpsField;
var produk_harga_jktField;
var produk_harga_mtaField;
var produk_harga_blpnField;
var produk_harga_kutaField;
var produk_harga_corpField;
var produk_harga_mdnField;
var produk_harga_mndField;
var produk_harga_ygkField;
var produk_harga_btmField;
var produk_harga_smgField;
var produk_harga_mksField;
var produk_harga_mlgField;
var produk_keteranganField;
var produk_aktifField;
var produk_tipeField;
var produk_aktifGroup;
var produk_hargaGroup;

var produk_awal_jumlahField;
var produk_awal_nilaiField;
var produk_tanggal_awal_nilaiField;

var produk_idSearchField;
var produk_kodeSearchField;
var produk_kodelamaSearchField;
var produk_groupSearchField;
var produk_kategoriSearchField;
var produk_kontribusiField;
var produk_jenisSearchField;
var produk_namaSearchField;
var produk_satuanSearchField;
var produk_duSearchField;
var produk_dmSearchField;
var produk_dultahSearchField;
var produk_dcardSearchField;
var produk_dkolegaSearchField;
var produk_dkeluargaSearchField;
var produk_downerSearchField;
var produk_dgroomingSearchField;
var produk_pointSearchField;
var produk_kreditSearchField;
var produk_volumeSearchField;
var produk_hargaSearchField;
var produk_keteranganSearchField;
var produk_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function produk_update(oGrid_event){
		var produk_id_update_pk="";
		var produk_kode_update=null;
		var produk_kodelama_update=null;
		var produk_group_update=null;
		var produk_kategori_update=null;
		var produk_kontribusi_update=null;
		var produk_jenis_update=null;
		var produk_nama_update=null;
		var produk_satuan_update=null;
		var produk_du_update=null;
		var produk_dm_update=null;
		var produk_point_update=null;
		var produk_kredit_update=null;
		var produk_volume_update=null;
		var produk_harga_update=null;
		var produk_keterangan_update=null;
		var produk_aktif_update=null;

		produk_id_update_pk = oGrid_event.record.data.produk_id;
		if(oGrid_event.record.data.produk_kode!== null){produk_kode_update = oGrid_event.record.data.produk_kode;}
		if(oGrid_event.record.data.produk_kodelama!== null){produk_kodelama_update = oGrid_event.record.data.produk_kodelama;}
		if(oGrid_event.record.data.produk_group!== null){produk_group_update = oGrid_event.record.data.produk_group;}
		if(oGrid_event.record.data.produk_kategori!== null){produk_kategori_update = oGrid_event.record.data.produk_kategori;}
		if(oGrid_event.record.data.produk_kontribusi!== null){produk_kontribusi_update = oGrid_event.record.data.produk_kontribusi;}
		if(oGrid_event.record.data.produk_jenis!== null){produk_jenis_update = oGrid_event.record.data.produk_jenis;}
		if(oGrid_event.record.data.produk_nama!== null){produk_nama_update = oGrid_event.record.data.produk_nama;}
		if(oGrid_event.record.data.produk_satuan!== null){produk_satuan_update = oGrid_event.record.data.produk_satuan;}
		if(oGrid_event.record.data.produk_du!== null){produk_du_update = oGrid_event.record.data.produk_du;}
		if(oGrid_event.record.data.produk_dm!== null){produk_dm_update = oGrid_event.record.data.produk_dm;}
		if(oGrid_event.record.data.produk_point!== null){produk_point_update = oGrid_event.record.data.produk_point;}
		if(oGrid_event.record.data.produk_kredit!== null){produk_kredit_update = oGrid_event.record.data.produk_kredit;}
		if(oGrid_event.record.data.produk_volume!== null){produk_volume_update = oGrid_event.record.data.produk_volume;}
		if(oGrid_event.record.data.produk_harga!== null){produk_harga_update = oGrid_event.record.data.produk_harga;}
		if(oGrid_event.record.data.produk_keterangan!== null){produk_keterangan_update = oGrid_event.record.data.produk_keterangan;}
		if(oGrid_event.record.data.produk_aktif!== null){produk_aktif_update = oGrid_event.record.data.produk_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_produk&m=get_action',
			params: {
				task: "UPDATE",
				produk_id	: produk_id_update_pk, 
				produk_kode	:produk_kode_update,  
				produk_kodelama	:produk_kodelama_update,  
				produk_group	:produk_group_update,  
				produk_kategori	:produk_kategori_update, 
				produk_kontribusi	:produk_kontribusi_update,  
				produk_jenis	:produk_jenis_update,  
				produk_nama	:produk_nama_update,  
				produk_satuan	:produk_satuan_update,  
				produk_du	:produk_du_update,  
				produk_dm	:produk_dm_update,  
				produk_point	:produk_point_update,  
				produk_kredit	:produk_kredit_update, 
				produk_volume	:produk_volume_update,  
				produk_harga	:produk_harga_update,  
				produk_keterangan	:produk_keterangan_update,  
				produk_aktif	:produk_aktif_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						produk_DataStore.commitChanges();
						produk_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Produk tidak bisa disimpan',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
				   title: 'Error',
				   msg: 'Tidak bisa terhubung dengan database server',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  	/* End of Function */
  
  	/* Function for add data, open window create form */
	function produk_create(){
	
		if(is_produk_form_valid()){	
		var produk_id_create_pk=null; 
		var produk_kode_create=null; 
		var produk_kodelama_create=null; 
		var produk_group_create=null; 
		var produk_kategori_create=null; 
		var produk_kontribusi_create=null; 
		var produk_jenis_create=null; 
		var produk_nama_create=null; 
		var produk_satuan_create=null; 
		var produk_du_create=null; 
		var produk_dm_create=null;
		var produk_dultah_create=null;
		var produk_dcard_create=null;
		var produk_dkolega_create=null;
		var produk_dkeluarga_create=null;
		var produk_downer_create=null;
		var produk_dgrooming_create=null;
		var produk_dwartawan_create=null;
		var produk_dstaffdokter_create=null;
		var produk_dstaffnondokter_create=null;
		var produk_dpromo_create=null;
		var produk_point_create=null; 
		var produk_kredit_create=null;
		var produk_volume_create=null; 
		var produk_harga_create=null; 
		var produk_keterangan_create=null; 
		var produk_bpom_create=null; 
		var produk_aktif_create=null; 
		var produk_tipe_create=null; 
		var produk_awal_jumlah_create=null;
		var produk_awal_nilai_create=null;
		var produk_harga_createki=null;
		var produk_harga_createmta=null;
		var produk_harga_createmdn=null;
		var produk_harga_createmnd=null;
		var produk_harga_createygk=null;
		var produk_harga_createlbk=null;
		var produk_harga_createhr=null;
		var produk_harga_createtp=null;
		var produk_harga_createdps=null;
		var produk_harga_createblpn=null;
		var produk_harga_createkuta=null;
		var produk_harga_createcorp=null;
		var produk_harga_createbtm=null;
		var produk_harga_createjkt=null;
		var produk_harga_createsmg=null;
		var produk_harga_createmks=null;
		var produk_harga_createmlg=null;
		var produk_tgl_awal_nilai_create=null;
		
		if(produk_idField.getValue()!== null){produk_id_create_pk = produk_idField.getValue();}else{produk_id_create_pk=get_pk_id();} 
		if(produk_kodeField.getValue()!== null){produk_kode_create = produk_kodeField.getValue();} 
		if(produk_kodelamaField.getValue()!== null){produk_kodelama_create = produk_kodelamaField.getValue();} 
		if(produk_groupField.getValue()!== null){produk_group_create = produk_groupField.getValue();} 
		if(produk_kategoriField.getValue()!== null){produk_kategori_create = produk_kategoriField.getValue();} 
		if(produk_kontribusiField.getValue()!== null){produk_kontribusi_create = produk_kontribusiField.getValue();} 
		if(produk_jenisField.getValue()!== null){produk_jenis_create = produk_jenisField.getValue();} 
		if(produk_namaField.getValue()!== null){produk_nama_create = produk_namaField.getValue();} 
		if(produk_satuanField.getValue()!== null){produk_satuan_create = produk_satuanField.getValue();} 
		if(produk_duField.getValue()!== null){produk_du_create = produk_duField.getValue();} 
		if(produk_dmField.getValue()!== null){produk_dm_create = produk_dmField.getValue();}
		if(produk_dultahField.getValue()!== null){produk_dultah_create = produk_dultahField.getValue();}
		if(produk_dcardField.getValue()!== null){produk_dcard_create = produk_dcardField.getValue();}
		if(produk_dkolegaField.getValue()!== null){produk_dkolega_create = produk_dkolegaField.getValue();}
		if(produk_dkeluargaField.getValue()!== null){produk_dkeluarga_create = produk_dkeluargaField.getValue();}
		if(produk_downerField.getValue()!== null){produk_downer_create = produk_downerField.getValue();}
		if(produk_dgroomingField.getValue()!== null){produk_dgrooming_create = produk_dgroomingField.getValue();}
		if(produk_dwartawanField.getValue()!== null){produk_dwartawan_create = produk_dwartawanField.getValue();}
		if(produk_dstaffdokterField.getValue()!== null){produk_dstaffdokter_create = produk_dstaffdokterField.getValue();}
		if(produk_dstaffnondokterField.getValue()!== null){produk_dstaffnondokter_create = produk_dstaffnondokterField.getValue();}
		if(produk_dpromoField.getValue()!== null){produk_dpromo_create = produk_dpromoField.getValue();}
		if(produk_pointField.getValue()!== null){produk_point_create = produk_pointField.getValue();} 
		if(produk_kreditField.getValue()!== null){produk_kredit_create = produk_kreditField.getValue();} 
		if(produk_volumeField.getValue()!== null){produk_volume_create = produk_volumeField.getValue();} 
		
		if(produk_hargaField.getValue()!== null){produk_harga_create = convertToNumber(produk_hargaField.getValue());} 
		/*
		if(produk_harga_kiField.getValue()!== null){produk_harga_createki = convertToNumber(produk_harga_kiField.getValue());}
		if(produk_harga_hrField.getValue()!== null){produk_harga_createhr = convertToNumber(produk_harga_hrField.getValue());}
		if(produk_harga_tpField.getValue()!== null){produk_harga_createtp = convertToNumber(produk_harga_tpField.getValue());}
		if(produk_harga_dpsField.getValue()!== null){produk_harga_createdps = convertToNumber(produk_harga_dpsField.getValue());}
		if(produk_harga_jktField.getValue()!== null){produk_harga_createjkt = convertToNumber(produk_harga_jktField.getValue());}
		if(produk_harga_mtaField.getValue()!== null){produk_harga_createmta = convertToNumber(produk_harga_mtaField.getValue());}
		if(produk_harga_blpnField.getValue()!== null){produk_harga_createblpn = convertToNumber(produk_harga_blpnField.getValue());}
		if(produk_harga_kutaField.getValue()!== null){produk_harga_createkuta = convertToNumber(produk_harga_kutaField.getValue());}
		if(produk_harga_corpField.getValue()!== null){produk_harga_createcorp = convertToNumber(produk_harga_corpField.getValue());}
		if(produk_harga_mdnField.getValue()!== null){produk_harga_createmdn = convertToNumber(produk_harga_mdnField.getValue());}
		if(produk_harga_lbkField.getValue()!== null){produk_harga_createlbk = convertToNumber(produk_harga_lbkField.getValue());}
		if(produk_harga_mndField.getValue()!== null){produk_harga_createmnd = convertToNumber(produk_harga_mndField.getValue());}		
		if(produk_harga_ygkField.getValue()!== null){produk_harga_createygk = convertToNumber(produk_harga_ygkField.getValue());}		
		if(produk_harga_btmField.getValue()!== null){produk_harga_createbtm = convertToNumber(produk_harga_btmField.getValue());}
		if(produk_harga_smgField.getValue()!== null){produk_harga_createsmg = convertToNumber(produk_harga_smgField.getValue());}		
		if(produk_harga_mksField.getValue()!== null){produk_harga_createmks = convertToNumber(produk_harga_mksField.getValue());}		
		if(produk_harga_mlgField.getValue()!== null){produk_harga_createmlg = convertToNumber(produk_harga_mlgField.getValue());}		
		*/
		if(produk_keteranganField.getValue()!== null){produk_keterangan_create = produk_keteranganField.getValue();} 
		if(produk_bpomField.getValue()!== null){produk_bpom_create = produk_bpomField.getValue();}
		if(produk_aktifField.getValue()!== null){produk_aktif_create = produk_aktifField.getValue();} 
		if(produk_tipeField.getValue()!== null){produk_tipe_create = produk_tipeField.getValue();} 
		/*
		if(produk_awal_jumlahField.getValue()!== null){produk_awal_jumlah_create = convertToNumber(produk_awal_jumlahField.getValue());} 
		if(produk_awal_nilaiField.getValue()!== null){produk_awal_nilai_create = convertToNumber(produk_awal_nilaiField.getValue());} 
		*/
		if(produk_tanggal_awal_nilaiField.getValue()!== ""){produk_tgl_awal_nilai_create = produk_tanggal_awal_nilaiField.getValue().format('Y-m-d');} 
		
		
		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_produk&m=get_action',
			params: {
				task: produk_post2db,
				produk_id	: produk_id_create_pk, 
				produk_kode	: produk_kode_create, 
				produk_kodelama	: produk_kodelama_create, 
				produk_jenis	: produk_group_create, 	// ini jenis
				//produk_kategori		: produk_kategori_create,
				produk_racikan 		: produk_racikanField.getValue(),
				produk_edit_harga	: produk_edit_hargaField.getValue(),
				produk_kontribusi	: produk_kontribusi_create,
				produk_kategori		: produk_jenis_create, // ini kategori
				produk_nama	: produk_nama_create, 
				produk_satuan	: produk_satuan_create, 
				produk_du	: produk_du_create, 
				produk_dm	: produk_dm_create,
				produk_dultah	: produk_dultah_create,
				produk_dcard	: produk_dcard_create,
				produk_dkolega	: produk_dkolega_create,
				produk_dkeluarga: produk_dkeluarga_create,
				produk_downer	: produk_downer_create,
				produk_dgrooming: produk_dgrooming_create,
				produk_dwartawan: produk_dwartawan_create,
				produk_dstaffdokter	: produk_dstaffdokter_create,
				produk_dstaffnondokter	: produk_dstaffnondokter_create,
				produk_dpromo	: produk_dpromo_create,
				produk_point	: produk_point_create,
				produk_kredit	: produk_kredit_create,
				produk_volume	: produk_volume_create, 
				produk_harga	: produk_harga_create, 
				produk_keterangan	: produk_keterangan_create, 
				produk_bpom : produk_bpom_create,
				produk_aktif	: produk_aktif_create, 
				produk_tipe 	: produk_tipe_create, 
				/*
				produk_harga_mta : produk_harga_createmta,
				produk_harga_ki : produk_harga_createki,
				produk_harga_mdn : produk_harga_createmdn,
				produk_harga_mnd : produk_harga_createmnd,
				produk_harga_ygk : produk_harga_createygk,
				produk_harga_lbk : produk_harga_createlbk,
				produk_harga_hr  : produk_harga_createhr,
				produk_harga_tp	 : produk_harga_createtp,
				produk_harga_dps	: produk_harga_createdps,
				produk_harga_blpn	: produk_harga_createblpn,
				produk_harga_kuta	: produk_harga_createkuta,
				produk_harga_btm	: produk_harga_createbtm,
				produk_harga_corp  : produk_harga_createcorp,
				produk_harga_jkt	: produk_harga_createjkt,
				produk_harga_smg	: produk_harga_createsmg,
				produk_harga_mks	: produk_harga_createmks,
				produk_harga_mlg	: produk_harga_createmlg,
				*/
				produk_aktif_th : produk_aktif_thField.getValue(),
				produk_aktif_ki : produk_aktif_kiField.getValue(),
				produk_aktif_hr : produk_aktif_hrField.getValue(),
				produk_aktif_corp : produk_aktif_corpField.getValue(),
				produk_aktif_tp : produk_aktif_tpField.getValue(),
				produk_aktif_dps : produk_aktif_dpsField.getValue(),
				produk_aktif_jkt : produk_aktif_jktField.getValue(),
				produk_aktif_mta : produk_aktif_mtaField.getValue(),
				produk_aktif_blpn : produk_aktif_blpnField.getValue(),
				produk_aktif_kuta : produk_aktif_kutaField.getValue(),
				produk_aktif_btm : produk_aktif_btmField.getValue(),
				produk_aktif_mks : produk_aktif_mksField.getValue(),
				produk_aktif_mdn : produk_aktif_mdnField.getValue(),
				produk_aktif_lbk : produk_aktif_lbkField.getValue(),
				produk_aktif_mnd : produk_aktif_mndField.getValue(),
				produk_aktif_ygk : produk_aktif_ygkField.getValue(),
				produk_aktif_mlg : produk_aktif_mlgField.getValue(),
				produk_aktif_smg : produk_aktif_smgField.getValue(),
				/*
				produk_awal_jumlah : produk_awal_jumlah_create,
				produk_awal_nilai : produk_awal_nilai_create,
				*/
				produk_tgl_awal_nilai : produk_tgl_awal_nilai_create
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						satuan_konversi_purge();
						//produk_racikan_purge();
						produk_DataStore.reload();
						produk_createWindow.hide();
						Ext.MessageBox.alert('OK','Data produk berhasil disimpan');
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data produk tidak bisa disimpan',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}        
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
				});	
			}                      
		});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
	
	function satuan_konversi_confirm_add(){
		combo_produk_satuan.setDisabled(false);
		combo_produk_nilai.setDisabled(false);
		temp_satuan_add = 1;
		satuan_konversi_add();
	}
	
	/* Function utk mengset field Satuan dan Nilai menjadi Disabled, ketika tombol update ditekan*/ 
	function satuan_konversi_change_disabled(){
		combo_produk_satuan.setDisabled(true);
		combo_produk_nilai.setDisabled(true);
		temp_satuan_add = 0;
	}
	
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(produk_post2db=='UPDATE')
			return produkListEditorGrid.getSelectionModel().getSelected().get('produk_id');
		else if(produk_post2db=='CREATE')
			return produk_idField.getValue();
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function produk_reset_form(){
		produk_idField.reset();
		produk_idField.setValue(null);
		produk_kodeField.reset();
		produk_kodeField.setValue(null);
		produk_kodelamaField.reset();
		produk_kodelamaField.setValue(null);
		produk_groupField.reset();
		produk_groupField.setValue(null);
		produk_kategoriField.reset();
		produk_kategoriField.setValue(null);
		produk_racikanField.reset();
		produk_racikanField.setValue(null);
		produk_edit_hargaField.reset();
		produk_edit_hargaField.setValue(null);
		produk_kontribusiField.reset();
		produk_kontribusiField.setValue(null);
		produk_jenisField.reset();
		produk_jenisField.setValue(null);
		produk_namaField.reset();
		produk_namaField.setValue(null);
		produk_satuanField.reset();
		produk_satuanField.setValue(null);
		produk_duField.reset();
		produk_duField.setValue(null);
		produk_dmField.reset();
		produk_dmField.setValue(null);
		produk_dultahField.reset();
		produk_dultahField.setValue(null);
		produk_dcardField.reset();
		produk_dcardField.setValue(null);
		produk_dkolegaField.reset();
		produk_dkolegaField.setValue(null);
		produk_dkeluargaField.reset();
		produk_dkeluargaField.setValue(null);
		produk_downerField.reset();
		produk_downerField.setValue(null);
		produk_dgroomingField.reset();
		produk_dgroomingField.setValue(null);
		produk_dwartawanField.reset();
		produk_dwartawanField.setValue(null);
		produk_dstaffdokterField.reset();
		produk_dstaffdokterField.setValue(null);
		produk_dstaffnondokterField.reset();
		produk_dstaffnondokterField.setValue(null);
		produk_dpromoField.reset();
		produk_dpromoField.setValue(null);
		produk_pointField.reset();
		produk_pointField.setValue(null);
		produk_kreditField.reset();
		produk_kreditField.setValue(null);
		produk_volumeField.reset();
		produk_volumeField.setValue(null);
		produk_hargaField.reset();
		produk_hargaField.setValue(null);
		produk_keteranganField.reset();
		produk_keteranganField.setValue(null);
		produk_aktifField.reset();
		produk_aktifField.setValue(null);
		produk_tipeField.reset();
		produk_tipeField.setValue(null);
		produk_racikanListEditorGrid.setDisabled(true);
		produk_bpomField.reset();
		produk_bpomField.setValue(true);
		
		produk_harga_thField.reset();
		produk_harga_thField.setValue(null);
		produk_harga_kiField.reset();
		produk_harga_kiField.setValue(null);
		produk_harga_hrField.reset();
		produk_harga_hrField.setValue(null);
		produk_harga_tpField.reset();
		produk_harga_tpField.setValue(null);
		produk_harga_dpsField.reset();
		produk_harga_dpsField.setValue(null);
		produk_harga_jktField.reset();
		produk_harga_jktField.setValue(null);
		produk_harga_mtaField.reset();
		produk_harga_mtaField.setValue(null);
		produk_harga_blpnField.reset();
		produk_harga_blpnField.setValue(null);
		produk_harga_kutaField.reset();
		produk_harga_kutaField.setValue(null);
		produk_harga_corpField.reset();
		produk_harga_corpField.setValue(null);
		produk_harga_mksField.reset();
		produk_harga_mksField.setValue(null);
		produk_harga_mdnField.reset();
		produk_harga_mdnField.setValue(null);
		produk_harga_lbkField.reset();
		produk_harga_lbkField.setValue(null);
		produk_harga_mndField.reset();
		produk_harga_mndField.setValue(null);
		produk_harga_ygkField.reset();
		produk_harga_ygkField.setValue(null);		
		produk_harga_mlgField.reset();
		produk_harga_mlgField.setValue(null);		
		produk_harga_btmField.reset();
		produk_harga_btmField.setValue(null);
		produk_harga_smgField.reset();
		produk_harga_smgField.setValue(null);
		
		produk_hargaField.setValue(0);
		produk_harga_thField.setValue(0);
		produk_harga_kiField.setValue(0);
		produk_harga_hrField.setValue(0);
		produk_harga_tpField.setValue(0);
		produk_harga_dpsField.setValue(0);
		produk_harga_jktField.setValue(0);
		produk_harga_mtaField.setValue(0);
		produk_harga_blpnField.setValue(0);
		produk_harga_kutaField.setValue(0);
		produk_harga_corpField.setValue(0);
		produk_harga_mksField.setValue(0);
		produk_harga_mdnField.setValue(0);
		produk_harga_lbkField.setValue(0);
		produk_harga_mndField.setValue(0);		
		produk_harga_ygkField.setValue(0);
		produk_harga_mlgField.setValue(0);		
		produk_harga_btmField.setValue(0);
		produk_harga_smgField.setValue(0);		
		produk_harga_checkField.reset();
		produk_harga_checkField.setValue(false);
		
		produk_aktif_thField.reset();
		produk_aktif_thField.setValue(false);
		produk_aktif_kiField.reset();
		produk_aktif_kiField.setValue(false);
		produk_aktif_hrField.reset();
		produk_aktif_hrField.setValue(false);
		produk_aktif_tpField.reset();
		produk_aktif_tpField.setValue(false);
		produk_aktif_dpsField.reset();
		produk_aktif_dpsField.setValue(false);
		produk_aktif_jktField.reset();
		produk_aktif_jktField.setValue(false);
		produk_aktif_mtaField.reset();
		produk_aktif_mtaField.setValue(false);
		produk_aktif_blpnField.reset();
		produk_aktif_blpnField.setValue(false);
		produk_aktif_kutaField.reset();
		produk_aktif_kutaField.setValue(false);
		produk_aktif_corpField.reset();
		produk_aktif_corpField.setValue(false);	
		produk_aktif_mksField.reset();
		produk_aktif_mksField.setValue(false);
		produk_aktif_mdnField.reset();
		produk_aktif_mdnField.setValue(false);
		produk_aktif_lbkField.reset();
		produk_aktif_lbkField.setValue(false);
		produk_aktif_mndField.reset();
		produk_aktif_mndField.setValue(false);
		produk_aktif_ygkField.reset();
		produk_aktif_ygkField.setValue(false);
		produk_aktif_mlgField.reset();
		produk_aktif_mlgField.setValue(false);
		produk_aktif_btmField.reset();
		produk_aktif_btmField.setValue(false);	
		produk_aktif_smgField.reset();
		produk_aktif_smgField.setValue(false);
		produk_aktif_checkField.reset();
		produk_aktif_checkField.setValue(false);
		
		combo_produk_satuan.setDisabled(false);
		combo_produk_nilai.setDisabled(false);		
		produk_awal_jumlahField.reset();
		produk_awal_jumlahField.setValue('0');
		produk_awal_nilaiField.reset();
		produk_awal_nilaiField.setValue('0');
		produk_tanggal_awal_nilaiField.setValue(null);
		produk_tanggal_awal_nilaiField.setDisabled(false);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function produk_set_form(){
		produk_idField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_id'));
		produk_kodeField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_kode'));
		produk_kodelamaField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_kodelama'));
		produk_groupField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_jenis'));
		produk_kategoriField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_kategori_id'));
		produk_kategoritxtField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_jenis'));
		produk_racikanField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_racikan'));
		produk_edit_hargaField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_edit_harga'));
		produk_kontribusiField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_kontribusi'));
		produk_jenisField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_kategori_nama'));
		produk_namaField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_nama'));
		produk_satuanField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_satuan'));
		produk_duField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_du'));
		produk_dmField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dm'));
		produk_dultahField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dultah'));
		produk_dcardField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dcard'));
		produk_dkolegaField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dkolega'));
		produk_dkeluargaField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dkeluarga'));
		produk_downerField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_downer'));
		produk_dgroomingField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dgrooming'));
		produk_dwartawanField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dwartawan'));
		produk_dstaffdokterField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dstaffdokter'));
		produk_dstaffnondokterField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dstaffnondokter'));
		produk_dpromoField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_dpromo'));
		produk_pointField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_point'));
		produk_kreditField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_kredit'));
		produk_volumeField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_volume'));
		produk_keteranganField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_keterangan'));
		produk_aktifField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif'));
		produk_tipeField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_tipe'));
		produk_hargaField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga')));
		produk_harga_thField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga')));		
		produk_harga_kiField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_ki')));
		produk_harga_hrField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_hr')));
		produk_harga_tpField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_tp')));
		produk_harga_dpsField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_dps')));
		produk_harga_jktField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_jkt')));
		produk_harga_mtaField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_mta')));
		produk_harga_blpnField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_blpn')));
		produk_harga_kutaField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_kuta')));
		produk_harga_corpField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_corp')));
		produk_harga_mdnField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_mdn')));
		produk_harga_lbkField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_lbk')));
		produk_harga_mndField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_mnd')));
		produk_harga_ygkField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_ygk')));
		produk_harga_btmField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_btm')));		
		produk_harga_smgField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_smg')));
		produk_harga_mksField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_mks')));
		produk_harga_mlgField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_harga_mlg')));
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_bpom')=="1")	
			produk_bpomField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_bpom')=="0")
			produk_bpomField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(0)=="1")	
			produk_aktif_thField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(0)=="0")
			produk_aktif_thField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(1)=="1")	
			produk_aktif_kiField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(1)=="0")
			produk_aktif_kiField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(2)=="1")	
			produk_aktif_hrField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(2)=="0")
			produk_aktif_hrField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(3)=="1")
			produk_aktif_tpField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(3)=="0")
			produk_aktif_tpField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(4)=="1")	
			produk_aktif_dpsField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(4)=="0")
			produk_aktif_dpsField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(5)=="1")	
			produk_aktif_jktField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(5)=="0")
			produk_aktif_jktField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(6)=="1")	
			produk_aktif_mtaField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(6)=="0")
			produk_aktif_mtaField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(7)=="1")	
			produk_aktif_blpnField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(7)=="0")
			produk_aktif_blpnField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(8)=="1")	
			produk_aktif_kutaField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(8)=="0")
			produk_aktif_kutaField.setValue(false);
			
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(9)=="1")	
			produk_aktif_corpField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(9)=="0")
			produk_aktif_corpField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(10)=="1")	
			produk_aktif_mksField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(10)=="0")
			produk_aktif_mksField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(11)=="1")	
			produk_aktif_mdnField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(11)=="0")
			produk_aktif_mdnField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(12)=="1")	
			produk_aktif_lbkField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(12)=="0")
			produk_aktif_lbkField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(13)=="1")
			produk_aktif_mndField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(13)=="0")
			produk_aktif_mndField.setValue(false);
		
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(14)=="1")	
			produk_aktif_ygkField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(14)=="0")
			produk_aktif_ygkField.setValue(false);
			
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(15)=="1")	
			produk_aktif_mlgField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(15)=="0")
			produk_aktif_mlgField.setValue(false);
			
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(16)=="1")	
			produk_aktif_btmField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(16)=="0")
			produk_aktif_btmField.setValue(false);
			
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(20)=="1")	
			produk_aktif_smgField.setValue(true);	
		if(produkListEditorGrid.getSelectionModel().getSelected().get('produk_aktif_cabang').charAt(20)=="0")
			produk_aktif_smgField.setValue(false);
			
		produk_awal_jumlahField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_saldo_awal')));
		produk_awal_nilaiField.setValue(CurrencyFormatted(produkListEditorGrid.getSelectionModel().getSelected().get('produk_nilai_saldo_awal')));
		produk_tanggal_awal_nilaiField.setValue(produkListEditorGrid.getSelectionModel().getSelected().get('produk_tgl_nilai_saldo_awal'));
		
	}
	/* End setValue to EDIT*/
  
	/*Function untuk disabled satuan dan nilai ketika klik Edit */
	function produk_set_updating(){
		if(produk_post2db=="UPDATE"){
			combo_produk_satuan.setDisabled(true);
			combo_produk_nilai.setDisabled(true);
			//produk_tanggal_awal_nilaiField.setDisabled(true);
		}
	}
    
	/* Function for Check if the form is valid */
	function is_produk_form_valid(){
		return (produk_kodeField.isValid() && produk_groupField.isValid() && produk_namaField.isValid() &&  produk_hargaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		satuan_konversi_DataStore.load({
			params: {master_id: get_pk_id(), start:0, limit:15},
			callback : function(opts, success, response){
				produk_racikan_DataStore.load({params: {master_id: get_pk_id(), start:0, limit:15}});
				}
		});
	
		if(!produk_createWindow.isVisible()){
			produk_reset_form();
			produk_post2db='CREATE';
			msg='created';
			satuan_konversi_DataStore.load({
			params: {master_id: get_pk_id(), start:0, limit:15},
			callback : function(opts, success, response){
				produk_racikan_DataStore.load({params: {master_id: get_pk_id(), start:0, limit:15}});
				}
			});
			/*satuan_konversi_DataStore.load({params: {master_id: 0, start:0, limit:15}});
			produk_racikan_DataStore.load({params: {master_id: 0, start:0, limit:15}});
			*/
			produk_createWindow.show();
		} else {
			produk_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function produk_confirm_delete(){
		// only one produk is selected here
		if(produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', produk_delete);
		} else if(produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', produk_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function produk_confirm_update(){
		/* only one record is selected here */
		if(produkListEditorGrid.selModel.getCount() == 1) {
			produk_set_form();
			produk_post2db='UPDATE';
			produk_set_updating();
			cbo_produk_racik_satuanDataStore.load();
			satuan_konversi_DataStore.load({
			params: {master_id: get_pk_id(), start:0, limit:15},
			callback : function(opts, success, response){
				produk_racikan_DataStore.load({params: {master_id: get_pk_id(), start:0, limit:15}});
				}
			});
			/*satuan_konversi_DataStore.load({params : {master_id : get_pk_id(), start:0, limit:15}});
			produk_racikan_DataStore.load({params : {master_id : get_pk_id(), start:0, limit:15}});
			*/
			msg='updated';
			produk_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function produk_delete(btn){
		if(btn=='yes'){
			var selections = produkListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< produkListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.produk_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_produk&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							produk_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang diplih',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							break;
					}
				},
				failure: function(response){
					var result=response.responseText;
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});	
				}
			});
		}  
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	produk_DataStore = new Ext.data.Store({
		id: 'produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:10}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
		/* dataIndex => insert intoproduk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'produk_id', type: 'int', mapping: 'produk_id'}, 
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'}, 
			{name: 'produk_kodelama', type: 'string', mapping: 'produk_kodelama'}, 
			{name: 'produk_group', type: 'string', mapping: 'group_nama'}, 
			{name: 'produk_kategori_nama', type: 'string', mapping: 'kategori_nama'}, 
			{name: 'produk_racikan', type: 'int', mapping: 'produk_racikan'},
			{name: 'produk_edit_harga', type: 'int', mapping: 'produk_edit_harga'},
			{name: 'produk_kategori_id', type: 'int', mapping: 'kategori_id'}, 
			{name: 'produk_kontribusi', type: 'string', mapping: 'kategori2_nama'}, 
			{name: 'produk_jenis', type: 'string', mapping: 'jenis_nama'}, 
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'}, 
			{name: 'produk_du', type: 'int', mapping: 'produk_du'}, 
			{name: 'produk_dm', type: 'int', mapping: 'produk_dm'}, 
			{name: 'produk_dultah', type: 'int', mapping: 'produk_dultah'}, 
			{name: 'produk_dcard', type: 'int', mapping: 'produk_dcard'},
			{name: 'produk_dkolega', type: 'int', mapping: 'produk_dkolega'},
			{name: 'produk_dkeluarga', type: 'int', mapping: 'produk_dkeluarga'},
			{name: 'produk_downer', type: 'int', mapping: 'produk_downer'},
			{name: 'produk_dgrooming', type: 'int', mapping: 'produk_dgrooming'},
			{name: 'produk_dwartawan', type: 'int', mapping: 'produk_dwartawan'},
			{name: 'produk_dstaffdokter', type: 'int', mapping: 'produk_dstaffdokter'},
			{name: 'produk_dstaffnondokter', type: 'int', mapping: 'produk_dstaffnondokter'},
			{name: 'produk_dpromo', type: 'int', mapping: 'produk_dpromo'},
			{name: 'produk_point', type: 'int', mapping: 'produk_point'}, 
			{name: 'produk_kredit', type: 'int', mapping: 'produk_kredit'}, 
			{name: 'produk_volume', type: 'int', mapping: 'produk_volume'}, 
			{name: 'produk_harga', type: 'float', mapping: 'produk_harga'}, 
			{name: 'produk_keterangan', type: 'string', mapping: 'produk_keterangan'}, 
			{name: 'produk_bpom', type: 'string', mapping: 'produk_bpom'},
			{name: 'produk_aktif', type: 'string', mapping: 'produk_aktif'}, 
			{name: 'produk_creator', type: 'string', mapping: 'produk_creator'}, 
			{name: 'produk_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'produk_date_create'}, 
			{name: 'produk_update', type: 'string', mapping: 'produk_update'}, 
			{name: 'produk_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'produk_date_update'}, 
			{name: 'produk_revised', type: 'int', mapping: 'produk_revised'},
			{name: 'produk_aktif_cabang', type: 'string', mapping: 'produk_aktif_cabang'},
			{name: 'produk_saldo_awal', type: 'float', mapping: 'produk_saldo_awal'},
			{name: 'produk_nilai_saldo_awal', type: 'float', mapping: 'produk_nilai_saldo_awal'},
			{name: 'produk_tgl_nilai_saldo_awal', type: 'date', dateFormat: 'Y-m-d', mapping: 'produk_tgl_nilai_saldo_awal'}, 			
			{name: 'produk_harga_ki', type: 'float', mapping: 'produk_harga_ki'},
			{name: 'produk_harga_hr', type: 'float', mapping: 'produk_harga_hr'},
			{name: 'produk_harga_tp', type: 'float', mapping: 'produk_harga_tp'},
			{name: 'produk_harga_dps', type: 'float', mapping: 'produk_harga_dps'},
			{name: 'produk_harga_jkt', type: 'float', mapping: 'produk_harga_jkt'},
			{name: 'produk_harga_mta', type: 'float', mapping: 'produk_harga_mta'},
			{name: 'produk_harga_blpn', type: 'float', mapping: 'produk_harga_blpn'},
			{name: 'produk_harga_kuta', type: 'float', mapping: 'produk_harga_kuta'},
			{name: 'produk_harga_corp', type: 'float', mapping: 'produk_harga_corp'},
			{name: 'produk_harga_mdn', type: 'float', mapping: 'produk_harga_mdn'},
			{name: 'produk_harga_lbk', type: 'float', mapping: 'produk_harga_lbk'},	
			{name: 'produk_harga_mnd', type: 'float', mapping: 'produk_harga_mnd'},					
			{name: 'produk_harga_ygk', type: 'float', mapping: 'produk_harga_ygk'},
			{name: 'produk_harga_mlg', type: 'float', mapping: 'produk_harga_mlg'},			
			{name: 'produk_harga_btm', type: 'float', mapping: 'produk_harga_btm'},			
			{name: 'produk_harga_smg', type: 'float', mapping: 'produk_harga_smg'},
			{name: 'produk_harga_mks', type: 'float', mapping: 'produk_harga_mks'},
			{name: 'produk_harga_mlg', type: 'float', mapping: 'produk_harga_mlg'}
		]),
		sortInfo:{field: 'produk_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_produk_groupDataStore = new Ext.data.Store({
		id: 'cbo_produk_groupDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_group_produk_list', 
			method: 'POST'
		}),
		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jenis_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'produk_group_value', type: 'int', mapping: 'jenis_id'},
			{name: 'produk_group_display', type: 'string', mapping: 'jenis_nama'},
			/*{name: 'produk_group_duproduk', type: 'int', mapping: 'group_duproduk'},
			{name: 'produk_group_dmproduk', type: 'int', mapping: 'group_dmproduk'},
			{name: 'produk_group_dultah', type: 'int', mapping: 'group_dultah'},
			{name: 'produk_group_dcard', type: 'int', mapping: 'group_dcard'},
			{name: 'produk_group_dkolega', type: 'int', mapping: 'group_dkolega'},
			{name: 'produk_group_dkeluarga', type: 'int', mapping: 'group_dkeluarga'},
			{name: 'produk_group_downer', type: 'int', mapping: 'group_downer'},
			{name: 'produk_group_dgrooming', type: 'int', mapping: 'group_dgrooming'},
			{name: 'produk_group_kelompok', type: 'string', mapping: 'kategori_nama'},
			{name: 'produk_group_kelompok_id', type: 'int', mapping: 'kategori_id'}
			*/
		]),
		sortInfo:{field: 'produk_group_display', direction: "ASC"}
	});
	
	cbo_produk_kategori_jenisDataStore = new Ext.data.Store({
		id: 'cbo_produk_kategori_jenisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_kategori_jenis_produk_list', 
			method: 'POST'
		}),
		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'produk_kategori_jenis_value', type: 'int', mapping: 'kategori_id'},
			{name: 'produk_kategori_jenis_display', type: 'string', mapping: 'kategori_nama'},
			{name: 'produk_kategori_jenis', type: 'int', mapping: 'kategori_jenis'}
		]),
		sortInfo:{field: 'produk_kategori_jenis_display', direction: "ASC"}
	});
	
//	cbo_produk_kategori_DataSore = new Ext.data.Store({
//		id: 'cbo_produk_kategori_DataSore',
//		proxy: new Ext.data.HttpProxy({
//			url: 'index.php?c=c_produk&m=get_kategori_produk_list', 
//			method: 'POST'
//		}),
//		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
//		reader: new Ext.data.JsonReader({
//			root: 'results',
//			totalProperty: 'total',
//			id: 'kategori_id'
//		},[
//		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
//			{name: 'produk_kategori_value', type: 'int', mapping: 'kategori_id'},
//			{name: 'produk_kategori_display', type: 'string', mapping: 'kategori_nama'}
//		]),
//		sortInfo:{field: 'produk_kategori_display', direction: "ASC"}
//	});
	
	cbo_produk_kontribusi_DataSore = new Ext.data.Store({
		id: 'cbo_produk_kontribusi_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_kontribusi_produk_list', 
			method: 'POST'
		}),
		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori2_id'
		},[
			{name: 'produk_kontribusi_value', type: 'string', mapping: 'kategori2_nama'},
			{name: 'produk_kontribusi_display', type: 'string', mapping: 'kategori2_nama'}
		]),
		sortInfo:{field: 'produk_kontribusi_display', direction: "ASC"}
	});
	
	
	cbo_produk_jenis_DataStore = new Ext.data.Store({
		id: 'cbo_produk_jenis_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_jenis_produk_list', 
			method: 'POST'
		}),
		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'produk_jenis_value', type: 'int', mapping: 'kategori_id'},
			{name: 'produk_jenis_display', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'produk_jenis_display', direction: "ASC"}
	});
	
	cbo_produk_satuanDataStore = new Ext.data.Store({
		id: 'cbo_produk_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_satuan_list', 
			method: 'POST'
		}),
		//baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'produk_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'produk_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'produk_satuan_display', type: 'string', mapping: 'satuan_kode'}
		]),
		sortInfo:{field: 'produk_satuan_display', direction: "ASC"}
	});
    
	cbo_produk_racik_satuanDataStore = new Ext.data.Store({
		id: 'cbo_produk_racik_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_satuan_by_produk_racik_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'djproduk_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'djproduk_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'djproduk_satuan_nilai', type: 'float', mapping: 'konversi_nilai'},
			{name: 'djproduk_satuan_display', type: 'string', mapping: 'satuan_kode'},
			{name: 'djproduk_satuan_default', type: 'string', mapping: 'konversi_default'},
			{name: 'djproduk_satuan_harga', type: 'float', mapping: 'produk_harga'}
		]),
		sortInfo:{field: 'djproduk_satuan_default', direction: "DESC"}
	});
	
	
	
	
  	/* Function for Identify of Window Column Model */
	produk_ColumnModel = new Ext.grid.ColumnModel(
		[/*{
			header: '#',
			readOnly: true,
			dataIndex: 'produk_id',
			width: 60,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},*/
		/*
		{
			header: '<div align="center">' + 'Kode Lama' + '</div>',
			dataIndex: 'produk_kodelama',
			width: 120,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		},
		*/
		{
			header: '<div align="center">' + 'Kode' + '</div>',
			dataIndex: 'produk_kode',
			width: 70,	//150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Nama' + '</div>',
			dataIndex: 'produk_nama',
			width: 220,	//250,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			/*,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 250
          	})*/
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Jenis' + '</div>',
			dataIndex: 'produk_jenis',
			width: 100, //150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			/*,
			editor: new Ext.form.ComboBox({
				store: cbo_produk_groupDataStore,
				mode: 'remote',
				displayField: 'produk_group_display',
				valueField: 'produk_group_value',
				triggerAction: 'all'
			})*/
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Kategori' + '</div>',
			dataIndex: 'produk_kategori_nama',
			width: 100,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			/*,
			editor: new Ext.form.ComboBox({
				store: cbo_produk_jenis_DataStore,
				mode: 'remote',
				displayField: 'produk_jenis_display',
				valueField: 'produk_jenis_value',
				triggerAction: 'all'
			})*/
			<?php } ?>
		},
		/*
		{
			header: '<div align="center">' + 'Jenis' + '</div>',
			dataIndex: 'produk_kategori_nama',
			width: 70,	//150,
			sortable: true,
			readOnly: true
		},
		*/
				{
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'produk_harga',
			width: 80,	//150,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			/*,
			editor: new Ext.form.NumberField({
				allowBlank: false,
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 22,
				maskRe: /([0-9]+)$/
			})*/
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'produk_aktif',
			width: 60,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		},
		/*
		{
			header: '<div align="center">' + 'Umum' + '</div>',
			align: 'right',
			dataIndex: 'produk_du',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Member' + '</div>',
			align: 'right',
			dataIndex: 'produk_dm',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Ultah' + '</div>',
			align: 'right',
			dataIndex: 'produk_dultah',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Card' + '</div>',
			align: 'right',
			dataIndex: 'produk_dcard',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Kolega' + '</div>',
			align: 'right',
			dataIndex: 'produk_dkolega',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Klrg' + '</div>',
			align: 'right',
			dataIndex: 'produk_dkeluarga',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Owner' + '</div>',
			align: 'right',
			dataIndex: 'produk_downer',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Groom' + '</div>',
			align: 'right',
			dataIndex: 'produk_dgrooming',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Wrtwn' + '</div>',
			align: 'right',
			dataIndex: 'produk_dwartawan',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Staf Dr' + '</div>',
			align: 'right',
			dataIndex: 'produk_dstaffdokter',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Staf Non Dr' + '</div>',
			align: 'right',
			dataIndex: 'produk_dstaffnondokter',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Promo' + '</div>',
			align: 'right',
			dataIndex: 'produk_dpromo',
			width: 45,	//100,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			},
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Poin' + '</div>',
			align: 'right',
			dataIndex: 'produk_point',
			width: 40,	//100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			/*,
			editor: new Ext.form.NumberField({
				allowBlank: false,
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})*/
			<?php } ?>
		//},
		/*
		{
			header: '<div align="center">' + 'Vol' + '</div>',
			align: 'right',
			dataIndex: 'produk_volume',
			width: 60,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			<?php } ?>
		},
		*/
		{
			header: 'Creator',
			dataIndex: 'produk_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Create on',
			dataIndex: 'produk_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'produk_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'produk_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'produk_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	produk_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	produkListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'produkListEditorGrid',
		el: 'fp_produk',
		title: 'Daftar Produk',
		autoHeight: true,
		store: produk_DataStore, // DataStore
		cm: produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,
		bbar: new Ext.PagingToolbar({
			pageSize: 15,
			store: produk_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>	   
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: produk_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: produk_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: produk_DataStore,
			params: {task: 'LIST',start: 0, limit: produk_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						produk_DataStore.baseParams={task:'LIST',start: 0, limit: produk_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Simple search:'});
				Ext.get(this.id).set({qtip:'- (Aktif only)<br>- Kode Baru<br>- Nama<br>- Jenis<br>- Kategori<br>- Jenis'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: produk_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: produk_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produk_print  
		}
		]
	});
	produkListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	produk_ContextMenu = new Ext.menu.Menu({
		id: 'produk_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: produk_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: produk_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produk_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: produk_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onproduk_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		produk_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		produk_SelectedRow=rowIndex;
		produk_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function produk_editContextMenu(){
		produkListEditorGrid.startEditing(produk_SelectedRow,1);
  	}
	/* End of Function */
  	
	produkListEditorGrid.addListener('rowcontextmenu', onproduk_ListEditGridContextMenu);
	produk_DataStore.load({params: {start: 0, limit: 15}});	// load DataStore
	produkListEditorGrid.on('afteredit', produk_update); // inLine Editing Record
	
	/* Identify  produk_id Field */
	produk_idField= new Ext.form.NumberField({
		id: 'produk_idField',
		fieldLabel: 'ID',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		hideLabel: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_kode Field */
	produk_kodeField= new Ext.form.TextField({
		id: 'produk_kodeField',
		fieldLabel: 'Kode Baru',
		maxLength: 20,
		allowBlank: true,
		readOnly: true,
		emptyText: '(auto)',
		width: 100
	});
	/* Identify  produk_kodelama Field */
	produk_kodelamaField= new Ext.form.TextField({
		id: 'produk_kodelamaField',
		fieldLabel: 'Kode Lama',
		maxLength: 20,
		allowBlank: true,
		width: 100
	});
	
	
	/* Identify harga produk*/
	produk_harga_allField=new Ext.form.TextField({
		id : 'produk_harga_allField',
		fieldLabel: '(Rp.)',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_thField=new Ext.form.TextField({
		id : 'produk_harga_thField',
		fieldLabel: 'Thamrin',
		maxLength: 20,
		allowBlank: true,
		disabled : true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_kiField=new Ext.form.TextField({
		id : 'produk_harga_kiField',
		fieldLabel: 'Kertajaya Indah',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_hrField=new Ext.form.TextField({
		id : 'produk_harga_hrField',
		fieldLabel: 'HR.Muhammad',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_corpField=new Ext.form.TextField({
		id : 'produk_harga_corpField',
		fieldLabel: 'Corporate',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_tpField=new Ext.form.TextField({
		id : 'produk_harga_tpField',
		fieldLabel: 'TP',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_dpsField=new Ext.form.TextField({
		id : 'produk_harga_dpsField',
		fieldLabel: 'DPS',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_jktField=new Ext.form.TextField({
		id : 'produk_harga_jktField',
		fieldLabel: 'JKT',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_mtaField=new Ext.form.TextField({
		id : 'produk_harga_mtaField',
		fieldLabel: 'Mall Taman Anggrek',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	
	produk_harga_blpnField=new Ext.form.TextField({
		id : 'produk_harga_blpnField',
		fieldLabel: 'BLPN',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_kutaField=new Ext.form.TextField({
		id : 'produk_harga_kutaField',
		fieldLabel: 'KUTA',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_btmField=new Ext.form.TextField({
		id : 'produk_harga_btmField',
		fieldLabel: 'BTM',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_mksField=new Ext.form.TextField({
		id : 'produk_harga_mksField',
		fieldLabel: 'MKS',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_mdnField=new Ext.form.TextField({
		id : 'produk_harga_mdnField',
		fieldLabel: 'Medan',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_lbkField=new Ext.form.TextField({
		id : 'produk_harga_lbkField',
		fieldLabel: 'Lombok',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_mndField=new Ext.form.TextField({
		id : 'produk_harga_mndField',
		fieldLabel: 'Manado',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_ygkField=new Ext.form.TextField({
		id : 'produk_harga_ygkField',
		fieldLabel: 'Yogyakarta',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_mlgField=new Ext.form.TextField({
		id : 'produk_harga_mlgField',
		fieldLabel: 'MLG',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_smgField=new Ext.form.TextField({
		id : 'produk_harga_smgField',
		fieldLabel: 'SMG',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	produk_harga_checkField=new Ext.form.Checkbox({
		id : '',
		boxLabel: 'Semua cabang sama',
		width: 150,
		handler: function(node,checked){
			if (checked) {
				produk_harga_thField.setValue(produk_hargaField.getValue());
				produk_harga_kiField.setValue(produk_hargaField.getValue());
				produk_harga_hrField.setValue(produk_hargaField.getValue());
				produk_harga_corpField.setValue(produk_hargaField.getValue());
				produk_harga_tpField.setValue(produk_hargaField.getValue());
				produk_harga_dpsField.setValue(produk_hargaField.getValue());
				produk_harga_jktField.setValue(produk_hargaField.getValue());
				produk_harga_mtaField.setValue(produk_hargaField.getValue());
				produk_harga_blpnField.setValue(produk_hargaField.getValue());
				produk_harga_kutaField.setValue(produk_hargaField.getValue());
				produk_harga_btmField.setValue(produk_hargaField.getValue());
				produk_harga_mksField.setValue(produk_hargaField.getValue());
				produk_harga_mdnField.setValue(produk_hargaField.getValue());
				produk_harga_lbkField.setValue(produk_hargaField.getValue());
				produk_harga_mndField.setValue(produk_hargaField.getValue());
				produk_harga_ygkField.setValue(produk_hargaField.getValue());
				produk_harga_mlgField.setValue(produk_hargaField.getValue());
				produk_harga_smgField.setValue(produk_hargaField.getValue());
				
			}
		}
	});
	
	//untuk panel harga
	produk_hargaGroup = new Ext.form.FieldSet({
		title: 'Harga Cabang (Rp)',
		layout:'column',
		width:350,
		autoHeight: true,
		mode: 'remote',
		//collapsed: true,
		collapsible: true,
		items:[
			{
				columnWidth:0.7,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [produk_harga_thField, produk_harga_kiField, produk_harga_hrField, produk_harga_tpField, produk_harga_dpsField,produk_harga_mtaField, produk_harga_blpnField, produk_harga_kutaField, produk_harga_mdnField, produk_harga_lbkField, produk_harga_mndField, produk_harga_ygkField, produk_harga_corpField, produk_harga_btmField, produk_harga_jktField, produk_harga_smgField, produk_harga_mksField, produk_harga_mlgField]
			}
		]
	});
	

	/* Identify  produk_group Field */
	produk_groupField= new Ext.form.ComboBox({
		id: 'produk_groupField',
		fieldLabel: 'Jenis <span style="color: #ec0000">*</span>',
		store: cbo_produk_groupDataStore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'produk_group_display',
		valueField: 'produk_group_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_kategori Field */
	produk_kategoriField=new Ext.form.NumberField();
	produk_kategoritxtField= new Ext.form.TextField({
		id: 'produk_kategoritxtField',
		fieldLabel: 'Jenis',
		maxLength: 20,
		disabled: true,
		width: 120
	});
	
	/* Identify produk_edit_harga Field*/
	produk_edit_hargaField=new Ext.form.Checkbox({
		id : 'produk_edit_hargaField',
		boxLabel: 'Editable Harga?',
		name: 'produk_edit_harga'
	});
	
	produk_racikanField=new Ext.form.Checkbox({
		id : 'produk_racikanField',
		boxLabel: 'Racikan?',
		name: 'produk_racikan',
		handler: function(node,checked){
			if (checked) {
				produk_racikanListEditorGrid.setDisabled(false);
				//Ext.Msg.alert('Status', 'Changes saved successfully.');
			}
			else {
				produk_racikanListEditorGrid.setDisabled(true);
				produk_racikan_DataStore.remove();
			}
		}
	});
	
	var combo_satuan_produk_racik=new Ext.form.ComboBox({
		store: cbo_produk_racik_satuanDataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'djproduk_satuan_display',
		valueField: 'djproduk_satuan_value',
		triggerAction: 'all',
		anchor: '95%'
	});
	
	
	/* Identify  produk_kategori Field */
	produk_kontribusiField= new Ext.form.ComboBox({
		id: 'produk_kontribusiField',
		fieldLabel: 'Contribution Category',
		store: cbo_produk_kontribusi_DataSore,
		mode: 'remote',
		editable:false,
		displayField: 'produk_kontribusi_display',
		valueField: 'produk_kontribusi_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_jenis Field */
	produk_jenisField= new Ext.form.ComboBox({
		id: 'produk_jenisField',
		fieldLabel: 'Kategori <span style="color: #ec0000">*</span>',
		store: cbo_produk_jenis_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'produk_jenis_display',
		valueField: 'produk_jenis_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_nama Field */
	produk_namaField= new Ext.form.TextField({
		id: 'produk_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  produk_satuan Field */
	produk_satuanField= new Ext.form.ComboBox({
		id: 'produk_satuanField',
		fieldLabel: 'Satuan',
		store: cbo_produk_satuanDataStore,
		mode: 'remote',
		displayField: 'produk_satuan_display',
		valueField: 'produk_satuan_value',
		anchor: '50%',
		triggerAction: 'all'
	});
	/* Identify  produk_du Field */
	produk_duField= new Ext.form.NumberField({
		id: 'produk_duField',
		name: 'produk_duField',
		fieldLabel: 'Umum',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dm Field */
	produk_dmField= new Ext.form.NumberField({
		id: 'produk_dmField',
		name: 'produk_dmField',
		fieldLabel: 'Member',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dultah Field */
	produk_dultahField= new Ext.form.NumberField({
		id: 'produk_dultahField',
		name: 'produk_dultahField',
		fieldLabel: 'Ultah',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dcard Field */
	produk_dcardField= new Ext.form.NumberField({
		id: 'produk_dcardField',
		name: 'produk_dcardField',
		fieldLabel: 'Card',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dkolegaField */
	produk_dkolegaField= new Ext.form.NumberField({
		id: 'produk_dkolegaField',
		name: 'produk_dkolegaField',
		fieldLabel: 'Kolega',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dkeluargaField */
	produk_dkeluargaField= new Ext.form.NumberField({
		id: 'produk_dkeluargaField',
		name: 'produk_dkeluargaField',
		fieldLabel: 'Keluarga',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_downer Field */
	produk_downerField= new Ext.form.NumberField({
		id: 'produk_downerField',
		name: 'produk_downerField',
		fieldLabel: 'Owner',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dgrooming Field */
	produk_dgroomingField= new Ext.form.NumberField({
		id: 'produk_dgroomingField',
		name: 'produk_dgroomingField',
		fieldLabel: 'Grooming',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dwartawan Field */
	produk_dwartawanField= new Ext.form.NumberField({
		id: 'produk_dwartawanField',
		name: 'produk_dwartawanField',
		fieldLabel: 'Wartawan',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dstaffdokter Field */
	produk_dstaffdokterField= new Ext.form.NumberField({
		id: 'produk_dstaffdokterField',
		name: 'produk_dstaffdokterField',
		fieldLabel: 'Staf Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dstaffnondokter Field */
	produk_dstaffnondokterField= new Ext.form.NumberField({
		id: 'produk_dstaffnondokterField',
		name: 'produk_dstaffnondokterField',
		fieldLabel: 'Staf Non Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produk_dpromo Field */
	produk_dpromoField= new Ext.form.NumberField({
		id: 'produk_dpromoField',
		name: 'produk_dpromoField',
		fieldLabel: 'Promo',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produk_point Field */
	produk_pointField= new Ext.form.NumberField({
		id: 'produk_pointField',
		name: 'produk_pointField',
		fieldLabel: 'Poin (x)',
		allowNegatife : false,
		emptyText: '1',
		allowBlank: true,
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produk_kredit Field */
	produk_kreditField= new Ext.form.NumberField({
		id: 'produk_kreditField',
		name: 'produk_kreditField',
		fieldLabel: 'Kredit (%)',
		allowNegatife : false,
		emptyText: '0',
		allowBlank: true,
		allowDecimals: false,
		enableKeyEvents : true,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produk_volume Field */
	produk_volumeField= new Ext.form.TextField({
		id: 'produk_volumeField',
		fieldLabel: 'Volume',
		maxLength: 250
	});
	/* Identify  produk_harga Field */
	produk_hargaField= new Ext.form.TextField({
		id: 'produk_hargaField',
		name: 'produk_hargaField',
		fieldLabel: 'Harga Jual (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: true,
		width: 150,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produk_harga Field */
	produk_awal_jumlahField= new Ext.form.TextField({
		id: 'produk_awal_jumlahField',
		name: 'produk_awal_jumlahField',
		fieldLabel: 'Saldo Awal',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: true,
		width: 150,
		maskRe: /([0-9]+)$/,
		hidden: false
	});
	
	produk_awal_nilaiField= new Ext.form.TextField({
		id: 'produk_awal_nilaiField',
		name: 'produk_awal_nilaiField',
		fieldLabel: 'Nilai Pers. Awal (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: true,
		width: 150,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produk_tanggal Field */
	produk_tanggal_awal_nilaiField= new Ext.form.DateField({
		id: 'produk_tanggal_awal_nilaiField',
		fieldLabel: 'Tanggal Nilai Pers. Awal',
		format : 'd-m-Y'
	});
	
	/* Identify  produk_keterangan Field */
	produk_keteranganField= new Ext.form.TextArea({
		id: 'produk_keteranganField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify BPOM Aktif*/
	produk_bpomField=new Ext.form.Checkbox({
		id : 'produk_bpomField',
		fieldLabel: 'BPOM',
		maxLength: 250,
		name: 'produk_bpom'
	});
	
	/* Identify Cabang Aktif*/
	produk_aktif_thField=new Ext.form.Checkbox({
		id : 'produk_aktif_thField',
		boxLabel: 'Aktif',
		maxLength: 250,
		name: 'produk_aktif_th',
		handler: function(node,checked){
			if (checked) {
				produk_aktifField.setValue('Aktif');
				//Ext.Msg.alert('Status', 'Changes saved successfully.');
			}
			else {
				produk_aktifField.setValue('Tidak Aktif');
			}
		}
	});
	
	produk_aktif_kiField=new Ext.form.Checkbox({
		id : 'produk_aktif_kiField',
		boxLabel: 'KI',
		maxLength: 250,
		name: 'produk_aktif_ki'
	});
	
	produk_aktif_hrField=new Ext.form.Checkbox({
		id : 'produk_aktif_hrField',
		boxLabel: 'HR',
		maxLength: 250,
		name: 'produk_aktif_hr'
	});
	
	produk_aktif_tpField=new Ext.form.Checkbox({
		id : 'produk_aktif_tpField',
		boxLabel: 'TP',
		maxLength: 250,
		name: 'produk_aktif_tp'
	});
	
	produk_aktif_dpsField=new Ext.form.Checkbox({
		id : 'produk_aktif_dpsField',
		boxLabel: 'DPS',
		maxLength: 250,
		name: 'produk_aktif_dps'
	});
	
	produk_aktif_jktField=new Ext.form.Checkbox({
		id : 'produk_aktif_jktField',
		boxLabel: 'JKT',
		maxLength: 250,
		name: 'produk_aktif_jkt'
	});
	
	produk_aktif_mtaField=new Ext.form.Checkbox({
		id : 'produk_aktif_mtaField',
		boxLabel: 'MTA',
		maxLength: 250,
		name: 'produk_aktif_mta'
	});
	
	produk_aktif_blpnField=new Ext.form.Checkbox({
		id : 'produk_aktif_blpnField',
		boxLabel: 'BLPN',
		maxLength: 250,
		name: 'produk_aktif_blpn'
	});
	
	produk_aktif_kutaField=new Ext.form.Checkbox({
		id : 'produk_aktif_kutaField',
		boxLabel: 'KUTA',
		maxLength: 250,
		name: 'produk_aktif_kuta'
	});
	
	produk_aktif_btmField=new Ext.form.Checkbox({
		id : 'produk_aktif_btmField',
		boxLabel: 'BTM',
		maxLength: 250,
		name: 'produk_aktif_btm'
	});
	
	produk_aktif_mksField=new Ext.form.Checkbox({
		id : 'produk_aktif_mksField',
		boxLabel: 'MKS',
		maxLength: 250,
		name: 'produk_aktif_mks'
	});
	
	produk_aktif_mdnField=new Ext.form.Checkbox({
		id : 'produk_aktif_mdnField',
		boxLabel: 'MDN',
		maxLength: 250,
		name: 'produk_aktif_mdn'
	});
	
	produk_aktif_lbkField=new Ext.form.Checkbox({
		id : 'produk_aktif_lbkField',
		boxLabel: 'LBK',
		maxLength: 250,
		name: 'produk_aktif_lbk'
	});
	
	produk_aktif_mndField=new Ext.form.Checkbox({
		id : 'produk_aktif_mndField',
		boxLabel: 'MND',
		maxLength: 250,
		name: 'produk_aktif_mnd'
	});
	
	produk_aktif_ygkField=new Ext.form.Checkbox({
		id : 'produk_aktif_ygkField',
		boxLabel: 'YGK',
		maxLength: 250,
		name: 'produk_aktif_ygk'
	});
	
	produk_aktif_corpField=new Ext.form.Checkbox({
		id : 'produk_aktif_corpField',
		boxLabel: 'CORP',
		maxLength: 250,
		name: 'produk_aktif_corp'
	});
	
	produk_aktif_mlgField=new Ext.form.Checkbox({
		id : 'produk_aktif_mlgField',
		boxLabel: 'MLG',
		maxLength: 250,
		name: 'produk_aktif_mlg'
	});
	
	produk_aktif_smgField=new Ext.form.Checkbox({
		id : 'produk_aktif_smgField',
		boxLabel: 'SMG',
		maxLength: 250,
		name: 'produk_aktif_smg'
	});
	
	produk_checkallField= new Ext.form.Checkbox({
		id: 'produk_checkallField',
		fieldLabel: 'Check All',
		maxLength: 250,
		anchor: '95%'
	});
	
	produk_aktif_checkField=new Ext.form.Checkbox({
		id : '',
		boxLabel: 'Check All',
		maxLength: 250,
		handler: function(node,checked){
			if (checked) {
				produk_aktif_thField.setValue(true);
				produk_aktif_kiField.setValue(true);
				produk_aktif_hrField.setValue(true);
				produk_aktif_tpField.setValue(true);
				produk_aktif_dpsField.setValue(true);
				produk_aktif_jktField.setValue(true);
				produk_aktif_mtaField.setValue(true);
				produk_aktif_blpnField.setValue(true);
				produk_aktif_kutaField.setValue(true);
				produk_aktif_btmField.setValue(true);
				produk_aktif_mksField.setValue(true);
				produk_aktif_mdnField.setValue(true);
				produk_aktif_lbkField.setValue(true);
				produk_aktif_mndField.setValue(true);
				produk_aktif_ygkField.setValue(true);
				produk_aktif_corpField.setValue(true);
				produk_aktif_mlgField.setValue(true);
				produk_aktif_smgField.setValue(true);
			}
			else {
				produk_aktif_thField.setValue(false);
				produk_aktif_kiField.setValue(false);
				produk_aktif_hrField.setValue(false);
				produk_aktif_tpField.setValue(false);
				produk_aktif_dpsField.setValue(false);
				produk_aktif_jktField.setValue(false);
				produk_aktif_mtaField.setValue(false);
				produk_aktif_blpnField.setValue(false);
				produk_aktif_kutaField.setValue(false);
				produk_aktif_btmField.setValue(false);
				produk_aktif_mksField.setValue(false);
				produk_aktif_mdnField.setValue(false);
				produk_aktif_lbkField.setValue(false);
				produk_aktif_mndField.setValue(false);
				produk_aktif_ygkField.setValue(false);
				produk_aktif_corpField.setValue(false);
				produk_aktif_mlgField.setValue(false);
				produk_aktif_smgField.setValue(false);
			}
		}
	});
	
	produk_aktifGroup = new Ext.form.FieldSet({
		title: 'Produk Aktif',
		layout:'column',
		autoHeight: true,
		collapsed: false,
		mode: 'remote',
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [ produk_aktif_thField /*, produk_aktif_kiField, produk_aktif_hrField, produk_aktif_tpField, produk_aktif_mlgField, produk_aktif_dpsField, produk_aktif_jktField, produk_aktif_mtaField, produk_aktif_blpnField */]
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[/*produk_aktif_kutaField, produk_aktif_btmField, produk_aktif_mksField, produk_aktif_mdnField, produk_aktif_lbkField, produk_aktif_mndField, produk_aktif_ygkField, produk_aktif_corpField, produk_aktif_jktField, produk_aktif_smgField */]
			   }
		]
	});
	
	//untuk Panel Diskon 
	produk_diskonGroup = new Ext.form.FieldSet({
		title: 'Jenis Diskon (%)',
		layout:'column',
		autoHeight: true,
		mode: 'remote',
		collapsed: true,
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [produk_duField, produk_dmField, produk_dultahField, produk_dcardField,produk_dwartawanField,produk_dpromoField]
			},
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [produk_dkolegaField, produk_dkeluargaField, produk_downerField, produk_dgroomingField, produk_dstaffdokterField, produk_dstaffnondokterField]
			}
		]
	});
	
	
	/* Identify  produk_aktif Field */
	produk_aktifField= new Ext.form.ComboBox({
		id: 'produk_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['produk_aktif_value', 'produk_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'produk_aktif_display',
		valueField: 'produk_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});

	/* Identify produk_tipe Field */
	produk_tipeField= new Ext.form.ComboBox({
		id: 'produk_tipeField',
		fieldLabel: 'Group',
		store:new Ext.data.SimpleStore({
			fields:['produk_tipe_value', 'produk_tipe_display'],
			data:[['Cabang','Cabang'],['Franchise','Franchise']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'produk_tipe_display',
		valueField: 'produk_tipe_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	produk_groupField.on('select', function(){
		var record=cbo_produk_groupDataStore.findExact('produk_group_value', produk_groupField.getValue(),0);
		if(cbo_produk_groupDataStore.getCount()){
			produk_duField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_duproduk);
			produk_dmField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dmproduk);
			produk_dultahField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dultah);
			produk_dcardField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dcard);
			produk_dkolegaField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dkolega);
			produk_dkeluargaField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dkeluarga);
			produk_downerField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_downer);
			produk_dgroomingField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dgrooming);
			produk_dwartawanField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dwartawan);
			produk_dstaffdokterField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dstaffdokter);
			produk_dstaffnondokterField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dstaffnondokter);produk_dpromoField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_dpromo);
			produk_kategoritxtField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_kelompok);
			produk_kategoriField.setValue(cbo_produk_groupDataStore.getAt(record).data.produk_group_kelompok_id);
		}
	});
	
  	/*Fieldset Master*/
	produk_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		labelWidth:120,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [/*produk_kodelamaField, */ produk_kodeField, produk_groupField, produk_jenisField, produk_tipeField, /*produk_kategoritxtField, */ produk_namaField, /*produk_racikanField, produk_edit_hargaField, */ produk_hargaField, /* produk_harga_checkField, produk_hargaGroup */] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [/* produk_awal_jumlahField, produk_awal_nilaiField, produk_tanggal_awal_nilaiField, produk_pointField,  produk_kreditField, produk_volumeField,  produk_kontribusiField, */ produk_keteranganField,/* produk_bpomField , */produk_idField,  produk_aktifGroup /*,  produk_diskonGroup*/] 
			}
			]
	
	});
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var produk_racikan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'pracikan_id', type: 'int', mapping: 'pracikan_id'}, 
			{name: 'pracikan_master', type: 'int', mapping: 'pracikan_master'}, 
			{name: 'pracikan_produk', type: 'int', mapping: 'pracikan_produk'}, 
			{name: 'pracikan_satuan', type: 'int', mapping: 'pracikan_satuan'}, 
			{name: 'pracikan_jumlah', type: 'float', mapping: 'pracikan_jumlah'} 
	]);
	//eof	
		
		
	// Function for json reader of detail
	var satuan_konversi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'konversi_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'konversi_id', type: 'int', mapping: 'konversi_id'}, 
			{name: 'konversi_produk', type: 'int', mapping: 'konversi_produk'}, 
			{name: 'konversi_satuan', type: 'int', mapping: 'konversi_satuan'}, 
			{name: 'konversi_nilai', type: 'float', mapping: 'konversi_nilai'},
			{name: 'konversi_default', type: 'string', mapping: 'konversi_default'}
	]);
	//eof
	
	//function for json writer of detail
	var satuan_konversi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	satuan_konversi_DataStore = new Ext.data.Store({
		id: 'satuan_konversi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=detail_satuan_konversi_list', 
			method: 'POST'
		}),
		reader: satuan_konversi_reader,
		baseParams:{master_id: get_pk_id()},
		sortInfo:{field: 'konversi_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_satuan_konversi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	//function for editor of detail
	var editor_satuan_konversi_cancel= new Ext.ux.grid.RowEditor({
        saveText: 'Cancel'
    });
	//eof
	
	//function for editor of detail
	var editor_produk_racikan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
	});
	
	
	
	Ext.util.Format.comboRenderer = function(combo){
		cbo_produk_satuanDataStore.load();
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	cbo_rawat_produkDataStore = new Ext.data.Store({
		id: 'cbo_rawat_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=get_produk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 50 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'rawat_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'rawat_produk_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'rawat_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'rawat_produk_kodelama', type: 'string', mapping: 'produk_kodelama'},
			{name: 'rawat_produk_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'rawat_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'rawat_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'rawat_produk_du', type: 'float', mapping: 'produk_du'},
			{name: 'rawat_produk_dm', type: 'float', mapping: 'produk_dm'},
			{name: 'rawat_produk_dultah', type: 'float', mapping: 'produk_dultah'},
			{name: 'rawat_produk_dcard', type: 'float', mapping: 'produk_dcard'},
			{name: 'rawat_produk_dkolega', type: 'float', mapping: 'produk_dkolega'},
			{name: 'rawat_produk_dkeluarga', type: 'float', mapping: 'produk_dkeluarga'},
			{name: 'rawat_produk_downer', type: 'float', mapping: 'produk_downer'},
			{name: 'rawat_produk_dgrooming', type: 'float', mapping: 'produk_dgrooming'},
			{name: 'rawat_produk_dwartawan', type: 'float', mapping: 'produk_dwartawan'},
			{name: 'rawat_produk_dstaffdokter', type: 'float', mapping: 'produk_dstaffdokter'},
			{name: 'rawat_produk_dstaffnondokter', type: 'float', mapping: 'produk_dstaffnondokter'},
			{name: 'rawat_produk_dpromo', type: 'float', mapping: 'produk_dpromo'},
			{name: 'rawat_produk_display', type: 'string', mapping: 'produk_nama'}
		]),
		sortInfo:{field: 'rawat_produk_display', direction: "ASC"}
	});
	
	var rawat_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{rawat_produk_display}<br/>Lama:{rawat_produk_kodelama}| Baru:<b>{rawat_produk_kode}</b> <br/>Jenis: {rawat_produk_group}, ',
			'Kategori: {rawat_produk_kategori}</span>',
		'</div></tpl>'
    );
	
	/* Function for Retrieve DataStore of detail*/
	produk_racikan_DataStore = new Ext.data.Store({
		id: 'produk_racikan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk&m=detail_produk_racikan_list', 
			method: 'POST'
		}),
		reader: produk_racikan_reader,
		baseParams:{master_id: get_pk_id(), start: 0, limit: produk_pageS},
		sortInfo:{field: 'pracikan_id', direction: "ASC"}
	});
	/* End of Function */
	
	
	
//	cbo_produk_satuanDataStore = new Ext.data.Store({
//		id: 'cbo_produk_satuanDataStore',
//		proxy: new Ext.data.HttpProxy({
//			url: 'index.php?c=c_produk&m=get_satuan_list', 
//			method: 'POST'
//		}),
//			reader: new Ext.data.JsonReader({
//			root: 'results',
//			totalProperty: 'total',
//			id: 'satuan_id'
//		},[
//		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
//			{name: 'produk_satuan_value', type: 'int', mapping: 'satuan_id'},
//			{name: 'produk_satuan_nama', type: 'string', mapping: 'satuan_nama'},
//			{name: 'produk_satuan_display', type: 'string', mapping: 'satuan_kode'}
//		]),
//		sortInfo:{field: 'produk_satuan_value', direction: "ASC"}
//	});
	
	var combo_produk_nilai = new Ext.form.NumberField({
				allowBlank: false,
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
	});
	
	
	var combo_produk_satuan=new Ext.form.ComboBox({
			store: cbo_produk_satuanDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'produk_satuan_display',
			valueField: 'produk_satuan_value',
			triggerAction: 'all',
			lazyRender:true
	});
	
	var combo_rawat_produk=new Ext.form.ComboBox({
			store: cbo_rawat_produkDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'rawat_produk_display',
			valueField: 'rawat_produk_value',
			triggerAction: 'all',
			loadingText: 'Searching...',
			pageSize:produk_pageS,
			hideTrigger:false,
			tpl: rawat_produk_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'

	});
	
	
	
	//declaration of detail coloumn model
	satuan_konversi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Satuan',
			dataIndex: 'konversi_satuan',
			width: 295,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			editor: combo_produk_satuan,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_produk_satuan)
		},
		{
			header: 'Nilai',
			dataIndex: 'konversi_nilai',
			width: 295,
			sortable: false,
			editor: combo_produk_nilai
		},
		{
			xtype: 'booleancolumn',
			header: 'Setting Default<br>(<span style="color:#F00">pilih hanya satu</span>)',
			dataIndex: 'konversi_default',
			width: 100,
			align: 'center',
			trueText: 'Yes',
			falseText: 'No',
			editor: {xtype: 'checkbox'}
		}]
	);
	satuan_konversi_ColumnModel.defaultSortable= true;
	//eof
	
	//declaration of detail coloumn model
	produk_racikan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Produk</div>',
			dataIndex: 'pracikan_produk',
			width: 300,
			sortable: true,
			editor: combo_rawat_produk,
			renderer: Ext.util.Format.comboRenderer(combo_rawat_produk)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'pracikan_satuan',
			width: 60,
			sortable: true,
			editor: combo_satuan_produk_racik,
			renderer: Ext.util.Format.comboRenderer(combo_satuan_produk_racik)
			/*readOnly: true,
			renderer: function(v, params, record){
				j=cbo_rawat_produkDataStore.findExact('rawat_produk_value',record.data.pracikan_produk,0);
				if(j>-1)
					return cbo_rawat_produkDataStore.getAt(j).data.rawat_produk_satuan;
			}*/
		},
		{
			header: '<div align="center">Jumlah</div>',
			dataIndex: 'pracikan_jumlah',
			align: 'right',
			width: 40,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				emptyText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		}]
	);
	produk_racikan_ColumnModel.defaultSortable= true;
	//eof
	
	
	//declaration of detail list editor grid
	satuan_konversiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'satuan_konversiListEditorGrid',
		el: 'fp_satuan_konversi',
		title: 'Satuan Konversi',
		height: 250,
		width: 690,
		autoScroll: true,
		store: satuan_konversi_DataStore, // DataStore
		colModel: satuan_konversi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_satuan_konversi],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: satuan_konversi_confirm_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: satuan_konversi_confirm_delete
		}, '-', 
		'<span style="color:white;">Warning: <b>Field Satuan dan Nilai tidak dapat di Edit lagi, pastikan terinput dengan benar.</b></span>'
		]
		<?php } ?>
	});
	//eof
	
	//declaration of detail list editor grid
	produk_racikanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'produk_racikanListEditorGrid',
		el: 'fp_produk_racikan',
		title: 'Detail Standard Bahan',
		height: 250,
		width: 690,
		autoScroll: true,
		store: produk_racikan_DataStore, // DataStore
		colModel: produk_racikan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_produk_racikan],
		frame: true,
		hidden: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		bbar: new Ext.PagingToolbar({
			pageSize: produk_pageS,
			store: produk_racikan_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: produk_racikan_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete'
			//handler: perawatan_konsumsi_confirm_delete
		}
		]
	});
	//eof
	
	//function of detail add
	function produk_racikan_add(){
		var edit_produk_racikan= new produk_racikanListEditorGrid.store.recordType({
			pracikan_id	:'',		
			pracikan_master	:'',		
			pracikan_produk	:'',		
			pracikan_satuan	:'',		
			pracikan_jumlah	:''		
		});
		editor_produk_racikan.stopEditing();
		produk_racikan_DataStore.insert(0, edit_produk_racikan);
		//produk_racikanListEditorGrid.getView().refresh();
		produk_racikanListEditorGrid.getSelectionModel().selectRow(0);
		editor_produk_racikan.startEditing(0);
	}
	
	
	
	
	//function of detail add
	function satuan_konversi_add(){
		/*
		if(temp_satuan_add==1)
		{
		combo_produk_satuan.setDisabled(false);
		combo_produk_nilai.setDisabled(false);
		}
		*/
		var edit_satuan_konversi= new satuan_konversiListEditorGrid.store.recordType({
			konversi_id	:'',		
			konversi_produk	:'',		
			konversi_satuan	:'',		
			konversi_nilai	:'',
			konversi_default :false
		});
		editor_satuan_konversi.stopEditing();
		//editor_satuan_konversi_cancel.stopEditing();
		satuan_konversi_DataStore.insert(0, edit_satuan_konversi);
		satuan_konversiListEditorGrid.getView().refresh();
		satuan_konversiListEditorGrid.getSelectionModel().selectRow(0);
		editor_satuan_konversi.startEditing(0);
		//editor_satuan_konversi_cancel.startEditing();

	}
	
	//function for refresh detail
	function refresh_satuan_konversi(){
		satuan_konversi_DataStore.commitChanges();
		satuan_konversiListEditorGrid.getView().refresh();
		satuan_konversi_change_disabled();
	}
	//eof
	
	//function for refresh detail
	function refresh_produk_racikan(){
		produk_racikan_DataStore.commitChanges();
		produk_racikanListEditorGrid.getView().refresh();
	}
	//eof
	
	function check_konversi_default(){
	//alert ("masuk");
		$count_default=0;
		for ($i = 0; $i < satuan_konversi_DataStore.getCount(); $i++) {
			satuan_konversi_default=satuan_konversi_DataStore.getAt($i);
			if(satuan_konversi_default.data.konversi_default==true || satuan_konversi_default.data.konversi_default=='true')
				$count_default+=1;
		}
		if($count_default==1)
			master_detail_insert();
		else {
			Ext.MessageBox.alert('Warning','Setting Default harus hanya satu...');
		}
	}
	
	function satuan_konversi_insert(){
		for(i=0;i<satuan_konversi_DataStore.getCount();i++){
			satuan_konversi_record=satuan_konversi_DataStore.getAt(i);
			if(satuan_konversi_record.data.konversi_satuan!=="" && satuan_konversi_record.data.konversi_satuan!==null){
				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_produk&m=detail_satuan_konversi_insert',
					params:{
					konversi_id	: satuan_konversi_record.data.konversi_id, 
					konversi_produk	: get_pk_id(), 
					konversi_satuan	: satuan_konversi_record.data.konversi_satuan, 
					konversi_nilai	: satuan_konversi_record.data.konversi_nilai,
					konversi_default	: satuan_konversi_record.data.konversi_default
					}
				});
			}
		}
	}
	
	function produk_racikan_insert(){
		for(i=0;i<produk_racikan_DataStore.getCount();i++){
			produk_racikan_record=produk_racikan_DataStore.getAt(i);
			//if(produk_racikan_record.data.pracikan_produk!=="" && produk_racikan_record.data.pracikan_produk!==null){
			if(produk_racikanField.getValue()==true){
				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_produk&m=detail_produk_racikan_insert',
					params:{
					pracikan_id	: produk_racikan_record.data.pracikan_id, 
					pracikan_master	: get_pk_id(), 
					pracikan_produk	: produk_racikan_record.data.pracikan_produk, 
					pracikan_satuan	: produk_racikan_record.data.pracikan_satuan, 
					pracikan_jumlah	: produk_racikan_record.data.pracikan_jumlah
					}
				});
			}
		}
	}
	
	
	
	
	//function for insert detail
	function master_detail_insert(){
		var check_konversi_nilai=0;
		for(j=0;j<satuan_konversi_DataStore.getCount();j++){
			check_konversi_record=satuan_konversi_DataStore.getAt(j);
			if(check_konversi_record.data.konversi_nilai==1){
				check_konversi_nilai+=1;
				produk_satuanField.setValue(check_konversi_record.data.konversi_satuan);
			}
		}
		switch(check_konversi_nilai){
			case 1:
				produk_create(); 
				
				break;
			default:
				Ext.MessageBox.show({
				   title: 'Warning',
				   msg: 'Baris Detail dengan Konversi Nilai = 1 <br>harus hanya terdapat satu data.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'save',
				   minWidth: 250,
				   icon: Ext.MessageBox.WARNING
				});
				break;
		}
	}
	//eof
	
	//function for purge detail
	function satuan_konversi_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_produk&m=detail_satuan_konversi_purge',
			params:{ master_id: eval(produk_idField.getValue()) },
			timeout : 5000,
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						satuan_konversi_insert();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Produk.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}        
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
				});	
			}
			
		});
	}
	//eof
	
	//function for purge detail
	function produk_racikan_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_produk&m=detail_produk_racikan_purge',
			params:{ master_id: eval(produk_idField.getValue()) },
			timeout : 5000,
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						produk_racikan_insert();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Produk.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}        
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
				});	
			}
			
		});
	}
	//eof
	
	
	
	/* Function for Delete Confirm of detail */
	function satuan_konversi_confirm_delete(){
		// only one record is selected here
		if(satuan_konversiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', satuan_konversi_delete);
		} else if(satuan_konversiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', satuan_konversi_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function satuan_konversi_delete(btn){
		if(btn=='yes'){
			var s = satuan_konversiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				satuan_konversi_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	satuan_konversi_DataStore.on('update', refresh_satuan_konversi);
	produk_racikan_DataStore.on('update', refresh_produk_racikan);
	
	var detail_tab_produk = new Ext.TabPanel({
		activeTab: 0,
		items: [satuan_konversiListEditorGrid,produk_racikanListEditorGrid]
	});
	
	
	/* Function for retrieve create Window Panel*/ 
	produk_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,        
		items: [produk_masterGroup,detail_tab_produk]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUK'))){ ?>
			{
				text: 'Save and Close',
				handler: check_konversi_default
				//handler: master_detail_insert
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					produk_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	produk_createWindow= new Ext.Window({
		id: 'produk_createWindow',
		title: produk_post2db+'Produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_produk_create',
		items: produk_createForm
	});
	/* End Window */
	
	
	
	/* Function for action list search */
	function produk_list_search(){
		// render according to a SQL date format.
		var produk_id_search=null;
		var produk_kode_search=null;
		var produk_kodelama_search=null;
		var produk_group_search=null;
		var produk_kategori_search=null;
		var produk_jenis_search=null;
		var produk_nama_search=null;
		var produk_satuan_search=null;
		var produk_du_search=null;
		var produk_dm_search=null;
		var produk_dultah_search=null;
		var produk_dcard_search=null;
		var produk_dkolega_search=null;
		var produk_dkeluarga_search=null;
		var produk_downer_search=null;
		var produk_dgrooming_search=null;
		var produk_point_search=null;
		var produk_kredit_search=null;
		var produk_volume_search=null;
		var produk_kontribusi_search=null;
		var produk_harga_search=null;
		var produk_keterangan_search=null;
		var produk_aktif_search=null;

		if(produk_idSearchField.getValue()!==null){produk_id_search=produk_idSearchField.getValue();}
		if(produk_kodeSearchField.getValue()!==null){produk_kode_search=produk_kodeSearchField.getValue();}
		if(produk_kodelamaSearchField.getValue()!==null){produk_kodelama_search=produk_kodelamaSearchField.getValue();}
		if(produk_groupSearchField.getValue()!==null){produk_group_search=produk_groupSearchField.getValue();}
		if(produk_kategoriSearchField.getValue()!==null){produk_kategori_search=produk_kategoriSearchField.getValue();}
		if(produk_jenisSearchField.getValue()!==null){produk_jenis_search=produk_jenisSearchField.getValue();}
		if(produk_namaSearchField.getValue()!==null){produk_nama_search=produk_namaSearchField.getValue();}
		if(produk_satuanSearchField.getValue()!==null){produk_satuan_search=produk_satuanSearchField.getValue();}
		if(produk_duSearchField.getValue()!==null){produk_du_search=produk_duSearchField.getValue();}
		if(produk_dmSearchField.getValue()!==null){produk_dm_search=produk_dmSearchField.getValue();}
		if(produk_dultahSearchField.getValue()!==null){produk_dultah_search=produk_dultahSearchField.getValue();}
		if(produk_dcardSearchField.getValue()!==null){produk_dcard_search=produk_dcardSearchField.getValue();}
		if(produk_dkolegaSearchField.getValue()!==null){produk_dkolega_search=produk_dkolegaSearchField.getValue();}
		if(produk_dkeluargaSearchField.getValue()!==null){produk_dkeluarga_search=produk_dkeluargaSearchField.getValue();}
		if(produk_downerSearchField.getValue()!==null){produk_downer_search=produk_downerSearchField.getValue();}
		if(produk_dgroomingSearchField.getValue()!==null){produk_dgrooming_search=produk_dgroomingSearchField.getValue();}
		if(produk_pointSearchField.getValue()!==null){produk_point_search=produk_pointSearchField.getValue();}
		if(produk_kreditSearchField.getValue()!==null){produk_kredit_search=produk_kreditSearchField.getValue();}
		if(produk_kontribusiSearchField.getValue()!==null){produk_kontribusi_search=produk_kontribusiSearchField.getValue();}
		if(produk_volumeSearchField.getValue()!==null){produk_volume_search=produk_volumeSearchField.getValue();}
		if(produk_hargaSearchField.getValue()!==null){produk_harga_search=produk_hargaSearchField.getValue();}
		if(produk_keteranganSearchField.getValue()!==null){produk_keterangan_search=produk_keteranganSearchField.getValue();}
		if(produk_aktifSearchField.getValue()!==null){produk_aktif_search=produk_aktifSearchField.getValue();}
		
		// change the store parameters
		produk_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: produk_pageS,
			//variable here
			produk_id	:	produk_id_search, 
			produk_kode	:	produk_kode_search, 
			produk_kodelama	:	produk_kodelama_search, 
			produk_group	:	produk_group_search, 
			produk_kategori	:	produk_kategori_search, 
			produk_jenis	:	produk_jenis_search, 
			produk_nama	:	produk_nama_search, 
			produk_satuan	:	produk_satuan_search, 
			produk_du	:	produk_du_search, 
			produk_dm	:	produk_dm_search, 
			produk_dultah	: produk_dultah_search,
			produk_dcard	: produk_dcard_search,
			produk_dkolega	: produk_dkolega_search,
			produk_dkeluarga: produk_dkeluarga_search,
			produk_downer	: produk_downer_search,
			produk_dgrooming: produk_dgrooming_search,
			produk_point	:	produk_point_search, 
			produk_kredit	:	produk_kredit_search, 
			kategori2_nama	:	produk_kontribusi_search,
			produk_volume	:	produk_volume_search,
			produk_harga	:	produk_harga_search, 
			produk_keterangan	:	produk_keterangan_search, 
			produk_aktif	:	produk_aktif_search, 
		};
		// Cause the datastore to do another query : 
		produk_DataStore.reload({params: {start: 0, limit: 15}});
	}
		
	/* Function for reset search result */
	function produk_reset_search(){
		// reset the store parameters
		produk_DataStore.baseParams = { task: 'LIST',start:0,limit:15 };
		// Cause the datastore to do another query : 
		produk_DataStore.reload({params: {start: 0, limit: 15}});
		//produk_searchWindow.close();
	};
	/* End of Fuction */
	
	function produk_reset_SearchForm(){
		produk_idSearchField.reset();
		produk_idSearchField.setValue(null);
		produk_kodeSearchField.reset();
		produk_kodeSearchField.setValue(null);
		produk_kodelamaSearchField.reset();
		produk_kodelamaSearchField.setValue(null);
		produk_groupSearchField.reset();
		produk_groupSearchField.setValue(null);
		produk_kategoriSearchField.reset();
		produk_kategoriSearchField.setValue(null);
		produk_jenisSearchField.reset();
		produk_jenisSearchField.setValue(null);
		produk_namaSearchField.reset();
		produk_namaSearchField.setValue(null);
		produk_satuanSearchField.reset();
		produk_satuanSearchField.setValue(null);
		produk_duSearchField.reset();
		produk_duSearchField.setValue(null);
		produk_dmSearchField.reset();
		produk_dmSearchField.setValue(null);
		produk_dultahSearchField.reset();
		produk_dultahSearchField.setValue(null);
		produk_dcardSearchField.reset();
		produk_dcardSearchField.setValue(null);
		produk_dkolegaSearchField.reset();
		produk_dkolegaSearchField.setValue(null);
		produk_dkeluargaSearchField.reset();
		produk_dkeluargaSearchField.setValue(null);
		produk_downerSearchField.reset();
		produk_downerSearchField.setValue(null);
		produk_dgroomingSearchField.reset();
		produk_dgroomingSearchField.setValue(null);
		produk_pointSearchField.reset();
		produk_pointSearchField.setValue(null);
		produk_kreditSearchField.reset();
		produk_kreditSearchField.setValue(null);
		produk_kontribusiSearchField.reset();
		produk_kontribusiSearchField.setValue(null);
		produk_volumeSearchField.reset();
		produk_volumeSearchField.setValue(null);
		produk_hargaSearchField.reset();
		produk_hargaSearchField.setValue(null);
		produk_keteranganSearchField.reset();
		produk_keteranganSearchField.setValue(null);
		produk_aktifSearchField.reset();
		produk_aktifSearchField.setValue('Aktif');
		
	}
	
	/* Field for search */
	/* Identify  produk_id Field */
	produk_idSearchField= new Ext.form.NumberField({
		id: 'produk_idSearchField',
		fieldLabel: 'ID',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		hidden: true,
		hideLabel: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_kode Field */
	produk_kodeSearchField= new Ext.form.TextField({
		id: 'produk_kodeSearchField',
		fieldLabel: 'Kode Baru',
		maxLength: 20,
		emptyText: '(auto)',
		width: 100
	});
	/* Identify  produk_kodelama Field */
	produk_kodelamaSearchField= new Ext.form.TextField({
		id: 'produk_kodelamaSearchField',
		fieldLabel: 'Kode Lama',
		maxLength: 20,
		width: 100
	});
	/* Identify  produk_group Field */
	produk_groupSearchField= new Ext.form.ComboBox({
		id: 'produk_groupSearchField',
		fieldLabel: 'Jenis',
		store: cbo_produk_groupDataStore,
		mode: 'remote',
		displayField: 'produk_group_display',
		valueField: 'produk_group_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_kategori Field */
	produk_kategoriSearchField= new Ext.form.ComboBox({
		id: 'produk_kategoriSearchField',
		fieldLabel: 'Jenis',
		store: cbo_produk_kategori_jenisDataStore,
		mode: 'remote',
		displayField: 'produk_kategori_jenis_display',
		valueField: 'produk_kategori_jenis_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_kategori Field */
	produk_kontribusiSearchField= new Ext.form.ComboBox({
		id: 'produk_kontribusiSearchField',
		fieldLabel: 'Contribution Category',
		store: cbo_produk_kontribusi_DataSore,
		mode: 'remote',
		displayField: 'produk_kontribusi_display',
		valueField: 'produk_kontribusi_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_jenis Field */
	produk_jenisSearchField= new Ext.form.ComboBox({
		id: 'produk_jenisSearchField',
		fieldLabel: 'Kategori',
		store: cbo_produk_jenis_DataStore,
		mode: 'remote',
		displayField: 'produk_jenis_display',
		valueField: 'produk_jenis_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  produk_nama Field */
	produk_namaSearchField= new Ext.form.TextField({
		id: 'produk_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  produk_satuan Field */
	produk_satuanSearchField= new Ext.form.ComboBox({
		id: 'produk_satuanSearchField',
		fieldLabel: 'Satuan',
		store: cbo_produk_satuanDataStore,
		mode: 'remote',
		displayField: 'produk_satuan_display',
		valueField: 'produk_satuan_value',
		anchor: '50%',
		triggerAction: 'all'
	});
	/* Identify  produk_du Field */
	produk_duSearchField= new Ext.form.NumberField({
		id: 'produk_duSearchField',
		name: 'produk_duField',
		fieldLabel: 'Diskon Umum (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dm Field */
	produk_dmSearchField= new Ext.form.NumberField({
		id: 'produk_dmSearchField',
		name: 'produk_dmField',
		fieldLabel: 'Diskon Member (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dultah Field */
	produk_dultahSearchField= new Ext.form.NumberField({
		id: 'produk_dultahSearchField',
		name: 'produk_dultahField',
		fieldLabel: 'Diskon Ultah (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dcard Field */
	produk_dcardSearchField= new Ext.form.NumberField({
		id: 'produk_dcardSearchField',
		name: 'produk_dcardField',
		fieldLabel: 'Diskon Card (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dkolega Field */
	produk_dkolegaSearchField= new Ext.form.NumberField({
		id: 'produk_dkolegaSearchField',
		name: 'produk_dkolegaField',
		fieldLabel: 'Diskon Kolega (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dkeluarga Field */
	produk_dkeluargaSearchField= new Ext.form.NumberField({
		id: 'produk_dkeluargaSearchField',
		name: 'produk_dkeluargaField',
		fieldLabel: 'Diskon Keluarga (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_downer Field */
	produk_downerSearchField= new Ext.form.NumberField({
		id: 'produk_downerSearchField',
		name: 'produk_downerField',
		fieldLabel: 'Diskon Owner (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_dgrooming Field */
	produk_dgroomingSearchField= new Ext.form.NumberField({
		id: 'produk_dgroomingSearchField',
		name: 'produk_dgroomingField',
		fieldLabel: 'Diskon Grooming (%)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_point Field */
	produk_pointSearchField= new Ext.form.NumberField({
		id: 'produk_pointSearchField',
		name: 'produk_pointField',
		fieldLabel: 'Poin (x)',
		allowNegatife : false,
		emptyText: '1',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_kredit Field */
	produk_kreditSearchField= new Ext.form.NumberField({
		id: 'produk_kreditSearchField',
		name: 'produk_kreditField',
		fieldLabel: 'Kredit (x)',
		allowNegatife : false,
		emptyText: '1',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_volume Field */
	produk_volumeSearchField= new Ext.form.TextField({
		id: 'produk_volumeSearchField',
		fieldLabel: 'Volume',
		maxLength: 250
	});
	/* Identify  produk_harga Field */
	produk_hargaSearchField= new Ext.form.NumberField({
		id: 'produk_hargaSearchField',
		name: 'produk_hargaSearchField',
		fieldLabel: 'Harga Jual (Rp)',
		width: 100,
		maskRe: /([0-9]+)$/
	});
	/* Identify  produk_keterangan Field */
	produk_keteranganSearchField= new Ext.form.TextArea({
		id: 'produk_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  produk_aktif Field */
	produk_aktifSearchField= new Ext.form.ComboBox({
		id: 'produk_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['produk_aktif_value', 'produk_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		displayField: 'produk_aktif_display',
		valueField: 'produk_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
    
	/* Function for retrieve search Form Panel */
	produk_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth:120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 600,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [/*produk_kodelamaSearchField, */ produk_kodeSearchField, produk_groupSearchField, produk_jenisSearchField, /* produk_kategoriSearchField, */ produk_namaSearchField, produk_hargaSearchField/* produk_duSearchField, produk_dmSearchField, produk_dultahSearchField, produk_dcardSearchField, produk_dkolegaSearchField, produk_dkeluargaSearchField, produk_downerSearchField, produk_dgroomingSearchField*/] 
			}
 
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [/*produk_pointSearchField, produk_kreditSearchField, produk_volumeSearchField, produk_kontribusiSearchField,*/ produk_keteranganSearchField, produk_aktifSearchField, produk_idSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: produk_list_search
			},{
				text: 'Close',
				handler: function(){
					produk_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	produk_searchWindow = new Ext.Window({
		title: 'Pencarian produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_produk_search',
		items: produk_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!produk_searchWindow.isVisible()){
			produk_reset_SearchForm();
			produk_searchWindow.show();
		} else {
			produk_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function produk_print(){
		var searchquery = "";
		var produk_kode_print=null;
		var produk_kodelama_print=null;
		var produk_group_print=null;
		var produk_kategori_print=null;
		var produk_jenis_print=null;
		var produk_nama_print=null;
		var produk_satuan_print=null;
		var produk_du_print=null;
		var produk_dm_print=null;
		var produk_dultah_print=null;
		var produk_dcard_print=null;
		var produk_dkolega_print=null;
		var produk_dkeluarga_print=null;
		var produk_downer_print=null;
		var produk_dgrooming_print=null;
		var produk_point_print=null;
		var produk_kredit_print=null;
		var produk_volume_print=null;
		var produk_harga_print=null;
		var produk_keterangan_print=null;
		var produk_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(produk_DataStore.baseParams.query!==null){searchquery = produk_DataStore.baseParams.query;}
		if(produk_DataStore.baseParams.produk_kode!==null){produk_kode_print = produk_DataStore.baseParams.produk_kode;}
		if(produk_DataStore.baseParams.produk_kodelama!==null){produk_kodelama_print = produk_DataStore.baseParams.produk_kodelama;}
		if(produk_DataStore.baseParams.produk_group!==null){produk_group_print = produk_DataStore.baseParams.produk_group;}
		if(produk_DataStore.baseParams.produk_kategori!==null){produk_kategori_print = produk_DataStore.baseParams.produk_kategori;}
		if(produk_DataStore.baseParams.produk_jenis!==null){produk_jenis_print = produk_DataStore.baseParams.produk_jenis;}
		if(produk_DataStore.baseParams.produk_nama!==null){produk_nama_print = produk_DataStore.baseParams.produk_nama;}
		if(produk_DataStore.baseParams.produk_satuan!==null){produk_satuan_print = produk_DataStore.baseParams.produk_satuan;}
		if(produk_DataStore.baseParams.produk_du!==null){produk_du_print = produk_DataStore.baseParams.produk_du;}
		if(produk_DataStore.baseParams.produk_dm!==null){produk_dm_print = produk_DataStore.baseParams.produk_dm;}
		if(produk_DataStore.baseParams.produk_dultah!==null){produk_dultah_print = produk_DataStore.baseParams.produk_dultah;}
		if(produk_DataStore.baseParams.produk_dcard!==null){produk_dcard_print = produk_DataStore.baseParams.produk_dcard;}
		if(produk_DataStore.baseParams.produk_dkolega!==null){produk_dkolega_print = produk_DataStore.baseParams.produk_dkolega;}
		if(produk_DataStore.baseParams.produk_dkeluarga!==null){produk_dkeluarga_print = produk_DataStore.baseParams.produk_dkeluarga;}
		if(produk_DataStore.baseParams.produk_downer!==null){produk_downer_print = produk_DataStore.baseParams.produk_downer;}
		if(produk_DataStore.baseParams.produk_dgrooming!==null){produk_dgrooming_print = produk_DataStore.baseParams.produk_dgrooming;}
		if(produk_DataStore.baseParams.produk_point!==null){produk_point_print = produk_DataStore.baseParams.produk_point;}
		if(produk_DataStore.baseParams.produk_kredit!==null){produk_kredit_print = produk_DataStore.baseParams.produk_kredit;}
		if(produk_DataStore.baseParams.produk_volume!==null){produk_volume_print = produk_DataStore.baseParams.produk_volume;}
		if(produk_DataStore.baseParams.produk_harga!==null){produk_harga_print = produk_DataStore.baseParams.produk_harga;}
		if(produk_DataStore.baseParams.produk_keterangan!==null){produk_keterangan_print = produk_DataStore.baseParams.produk_keterangan;}
		if(produk_DataStore.baseParams.produk_aktif!==null){produk_aktif_print = produk_DataStore.baseParams.produk_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_produk&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			produk_kode : produk_kode_print,
			produk_kodelama : produk_kodelama_print,
			produk_group : produk_group_print,
			produk_kategori : produk_kategori_print,
			produk_jenis : produk_jenis_print,
			produk_nama : produk_nama_print,
			produk_satuan : produk_satuan_print,
			produk_du : produk_du_print,
			produk_dm : produk_dm_print,
			produk_dultah	: produk_dultah_print,
			produk_dcard	: produk_dcard_print,
			produk_dkolega	: produk_dkolega_print,
			produk_dkeluarga: produk_dkeluarga_print,
			produk_downer	: produk_downer_print,
			produk_dgrooming: produk_dgrooming_print,
			produk_point : produk_point_print,
			produk_kredit : produk_kredit_print,
			produk_volume : produk_volume_print,
			produk_harga : produk_harga_print,
			produk_keterangan : produk_keterangan_print,
			produk_aktif : produk_aktif_print,
		  	currentlisting: produk_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./produklist.html','produklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function produk_export_excel(){
		var searchquery = "";
		var produk_kode_2excel=null;
		var produk_kodelama_2excel=null;
		var produk_group_2excel=null;
		var produk_kategori_2excel=null;
		var produk_jenis_2excel=null;
		var produk_nama_2excel=null;
		var produk_satuan_2excel=null;
		var produk_du_2excel=null;
		var produk_dm_2excel=null;
		var produk_dultah_2excel=null;
		var produk_dcard_2excel=null;
		var produk_dkolega_2excel=null;
		var produk_dkeluarga_2excel=null;
		var produk_downer_2excel=null;
		var produk_dgrooming_2excel=null;
		var produk_point_2excel=null;
		var produk_kredit_2excel=null;
		var produk_volume_2excel=null;
		var produk_harga_2excel=null;
		var produk_keterangan_2excel=null;
		var produk_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(produk_DataStore.baseParams.query!==null){searchquery = produk_DataStore.baseParams.query;}
		if(produk_DataStore.baseParams.produk_kode!==null){produk_kode_2excel = produk_DataStore.baseParams.produk_kode;}
		if(produk_DataStore.baseParams.produk_kodelama!==null){produk_kodelama_2excel = produk_DataStore.baseParams.produk_kodelama;}
		if(produk_DataStore.baseParams.produk_group!==null){produk_group_2excel = produk_DataStore.baseParams.produk_group;}
		if(produk_DataStore.baseParams.produk_kategori!==null){produk_kategori_2excel = produk_DataStore.baseParams.produk_kategori;}
		if(produk_DataStore.baseParams.produk_jenis!==null){produk_jenis_2excel = produk_DataStore.baseParams.produk_jenis;}
		if(produk_DataStore.baseParams.produk_nama!==null){produk_nama_2excel = produk_DataStore.baseParams.produk_nama;}
		if(produk_DataStore.baseParams.produk_satuan!==null){produk_satuan_2excel = produk_DataStore.baseParams.produk_satuan;}
		if(produk_DataStore.baseParams.produk_du!==null){produk_du_2excel = produk_DataStore.baseParams.produk_du;}
		if(produk_DataStore.baseParams.produk_dm!==null){produk_dm_2excel = produk_DataStore.baseParams.produk_dm;}
		if(produk_DataStore.baseParams.produk_dultah!==null){produk_dultah_2excel = produk_DataStore.baseParams.produk_dultah;}
		if(produk_DataStore.baseParams.produk_dcard!==null){produk_dcard_2excel = produk_DataStore.baseParams.produk_dcard;}
		if(produk_DataStore.baseParams.produk_dkolega!==null){produk_dkolega_2excel = produk_DataStore.baseParams.produk_dkolega;}
		if(produk_DataStore.baseParams.produk_dkeluarga!==null){produk_dkeluarga_2excel = produk_DataStore.baseParams.produk_dkeluarga;}
		if(produk_DataStore.baseParams.produk_downer!==null){produk_downer_2excel = produk_DataStore.baseParams.produk_downer;}
		if(produk_DataStore.baseParams.produk_dgrooming!==null){produk_dgrooming_2excel = produk_DataStore.baseParams.produk_dgrooming;}
		if(produk_DataStore.baseParams.produk_point!==null){produk_point_2excel = produk_DataStore.baseParams.produk_point;}
		if(produk_DataStore.baseParams.produk_kredit!==null){produk_kredit_2excel = produk_DataStore.baseParams.produk_kredit;}
		if(produk_DataStore.baseParams.produk_volume!==null){produk_volume_2excel = produk_DataStore.baseParams.produk_volume;}
		if(produk_DataStore.baseParams.produk_harga!==null){produk_harga_2excel = produk_DataStore.baseParams.produk_harga;}
		if(produk_DataStore.baseParams.produk_keterangan!==null){produk_keterangan_2excel = produk_DataStore.baseParams.produk_keterangan;}
		if(produk_DataStore.baseParams.produk_aktif!==null){produk_aktif_2excel = produk_DataStore.baseParams.produk_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_produk&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			produk_kode : produk_kode_2excel,
			produk_kodelama : produk_kodelama_2excel,
			produk_group : produk_group_2excel,
			produk_kategori : produk_kategori_2excel,
			produk_jenis : produk_jenis_2excel,
			produk_nama : produk_nama_2excel,
			produk_satuan : produk_satuan_2excel,
			produk_du : produk_du_2excel,
			produk_dm : produk_dm_2excel,
			produk_dultah	: produk_dultah_2excel,
			produk_dcard	: produk_dcard_2excel,
			produk_dkolega	: produk_dkolega_2excel,
			produk_dkeluarga: produk_dkeluarga_2excel,
			produk_downer	: produk_downer_2excel,
			produk_dgrooming: produk_dgrooming_2excel,
			produk_point : produk_point_2excel,
			produk_kredit : produk_kredit_2excel,
			produk_volume : produk_volume_2excel,
			produk_harga : produk_harga_2excel,
			produk_keterangan : produk_keterangan_2excel,
			produk_aktif : produk_aktif_2excel,
		  	currentlisting: produk_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.location=('./export2excel.php');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa meng-export data ke dalam format excel!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */
	
	
	dproduk_idField=new Ext.form.NumberField();
	
	combo_rawat_produk.on('select',function(){
		var j=cbo_rawat_produkDataStore.findExact('rawat_produk_value',combo_rawat_produk.getValue(),0);
		if(cbo_rawat_produkDataStore.getCount()){
            //Untuk me-lock screen sementara, menunggu data selesai di-load ==> setelah selesai di-load, hide Ext.MessageBox.show() di bawah ini
            //master_jual_produk_createForm.setDisabled(true);
            
            dproduk_idField.setValue(cbo_rawat_produkDataStore.getAt(j).data.rawat_produk_value);
			//dharga_defaultField.setValue(cbo_rawat_produkDataStore.getAt(j).data.dproduk_produk_harga);
			//var djumlah_diskon = 0;
			
			
			cbo_produk_racik_satuanDataStore.load({
				params: {produk_id:dproduk_idField.getValue()},
				callback: function(opts, success, response){
					if(success){
                       // djumlah_beli_produkField.setValue(1);
                        var nilai_default=0;
                        var st=cbo_produk_racik_satuanDataStore.findExact('djproduk_satuan_default','true',0);
                        if(cbo_produk_racik_satuanDataStore.getCount()>=0){
                            nilai_default=cbo_produk_racik_satuanDataStore.getAt(st).data.djproduk_satuan_nilai;
                            if(nilai_default===1){
                                //temp_konv_nilai.setValue(nilai_default);
                                //dharga_konversiField.setValue(nilai_default*dharga_defaultField.getValue());
                               // dsub_totalField.setValue(djumlah_beli_produkField.getValue()*(nilai_default*dharga_defaultField.getValue()));
                               // dsub_total_netField.setValue(((100-djumlah_diskon)/100)*djumlah_beli_produkField.getValue()*(nilai_default*dharga_defaultField.getValue()));
                               // master_jual_produk_createForm.setDisabled(false);
                            }else if(nilai_default!==1){
                                //temp_konv_nilai.setValue(nilai_default*(1/nilai_default));
                               // dharga_konversiField.setValue((nilai_default*(1/nilai_default))*dharga_defaultField.getValue());
                               // dsub_totalField.setValue(djumlah_beli_produkField.getValue()*((nilai_default*(1/nilai_default))*dharga_defaultField.getValue()));
                                //dsub_total_netField.setValue(((100-djumlah_diskon)/100)*djumlah_beli_produkField.getValue()*((nilai_default*(1/nilai_default))*dharga_defaultField.getValue()));
                               // master_jual_produk_createForm.setDisabled(false);
                            }else{
                                //master_jual_produk_createForm.setDisabled(false);
                            }
                            combo_satuan_produk_racik.setValue(cbo_produk_racik_satuanDataStore.getAt(st).data.djproduk_satuan_value);
                        }else{
                            //master_jual_produk_createForm.setDisabled(false);
                        }
					}else{
                        //master_jual_produk_createForm.setDisabled(false);
                    }
				}
			});
			
		}
	});
	
	
	produk_hargaField.on('focus',function(){ produk_hargaField.setValue(convertToNumber(produk_hargaField.getValue())); });
	produk_hargaField.on('blur',function(){ produk_hargaField.setValue(CurrencyFormatted(produk_hargaField.getValue())); });
	
	produk_harga_kiField.on('focus',function(){ produk_harga_kiField.setValue(convertToNumber(produk_harga_kiField.getValue())); });
	produk_harga_kiField.on('blur',function(){ produk_harga_kiField.setValue(CurrencyFormatted(produk_harga_kiField.getValue())); });
	produk_harga_mndField.on('focus',function(){ produk_harga_mndField.setValue(convertToNumber(produk_harga_mndField.getValue())); });
	produk_harga_mndField.on('blur',function(){ produk_harga_mndField.setValue(CurrencyFormatted(produk_harga_mndField.getValue())); });
	produk_harga_mdnField.on('focus',function(){ produk_harga_mdnField.setValue(convertToNumber(produk_harga_mdnField.getValue())); });
	produk_harga_mdnField.on('blur',function(){ produk_harga_mdnField.setValue(CurrencyFormatted(produk_harga_mdnField.getValue())); });
	produk_harga_ygkField.on('focus',function(){ produk_harga_ygkField.setValue(convertToNumber(produk_harga_ygkField.getValue())); });
	produk_harga_ygkField.on('blur',function(){ produk_harga_ygkField.setValue(CurrencyFormatted(produk_harga_ygkField.getValue())); });
	produk_harga_mtaField.on('focus',function(){ produk_harga_mtaField.setValue(convertToNumber(produk_harga_mtaField.getValue())); });
	produk_harga_mtaField.on('blur',function(){ produk_harga_mtaField.setValue(CurrencyFormatted(produk_harga_mtaField.getValue())); });
	
	produk_harga_lbkField.on('focus',function(){ produk_harga_lbkField.setValue(convertToNumber(produk_harga_lbkField.getValue())); });
	produk_harga_lbkField.on('blur',function(){ produk_harga_lbkField.setValue(CurrencyFormatted(produk_harga_lbkField.getValue())); });
	
	produk_harga_hrField.on('focus',function(){ produk_harga_hrField.setValue(convertToNumber(produk_harga_hrField.getValue())); });
	produk_harga_hrField.on('blur',function(){ produk_harga_hrField.setValue(CurrencyFormatted(produk_harga_hrField.getValue())); });
	
	produk_harga_tpField.on('focus',function(){ produk_harga_tpField.setValue(convertToNumber(produk_harga_tpField.getValue())); });
	produk_harga_tpField.on('blur',function(){ produk_harga_tpField.setValue(CurrencyFormatted(produk_harga_tpField.getValue())); });
	
	produk_harga_dpsField.on('focus',function(){ produk_harga_dpsField.setValue(convertToNumber(produk_harga_dpsField.getValue())); });
	produk_harga_dpsField.on('blur',function(){ produk_harga_dpsField.setValue(CurrencyFormatted(produk_harga_dpsField.getValue())); });
	
	produk_harga_jktField.on('focus',function(){ produk_harga_jktField.setValue(convertToNumber(produk_harga_jktField.getValue())); });
	produk_harga_jktField.on('blur',function(){ produk_harga_jktField.setValue(CurrencyFormatted(produk_harga_jktField.getValue())); });
	
	produk_harga_blpnField.on('focus',function(){ produk_harga_blpnField.setValue(convertToNumber(produk_harga_blpnField.getValue())); });
	produk_harga_blpnField.on('blur',function(){ produk_harga_blpnField.setValue(CurrencyFormatted(produk_harga_blpnField.getValue())); });
	
	produk_harga_kutaField.on('focus',function(){ produk_harga_kutaField.setValue(convertToNumber(produk_harga_kutaField.getValue())); });
	produk_harga_kutaField.on('blur',function(){ produk_harga_kutaField.setValue(CurrencyFormatted(produk_harga_kutaField.getValue())); });
	
	produk_harga_corpField.on('focus',function(){ produk_harga_corpField.setValue(convertToNumber(produk_harga_corpField.getValue())); });
	produk_harga_corpField.on('blur',function(){ produk_harga_corpField.setValue(CurrencyFormatted(produk_harga_corpField.getValue())); });
	
	produk_harga_btmField.on('focus',function(){ produk_harga_btmField.setValue(convertToNumber(produk_harga_btmField.getValue())); });
	produk_harga_btmField.on('blur',function(){ produk_harga_btmField.setValue(CurrencyFormatted(produk_harga_btmField.getValue())); });	
	
	produk_harga_smgField.on('focus',function(){ produk_harga_smgField.setValue(convertToNumber(produk_harga_smgField.getValue())); });
	produk_harga_smgField.on('blur',function(){ produk_harga_smgField.setValue(CurrencyFormatted(produk_harga_smgField.getValue())); });
	
	produk_harga_mksField.on('focus',function(){ produk_harga_mksField.setValue(convertToNumber(produk_harga_mksField.getValue())); });
	produk_harga_mksField.on('blur',function(){ produk_harga_mksField.setValue(CurrencyFormatted(produk_harga_mksField.getValue())); });
	
	produk_harga_mlgField.on('focus',function(){ produk_harga_mlgField.setValue(convertToNumber(produk_harga_mlgField.getValue())); });
	produk_harga_mlgField.on('blur',function(){ produk_harga_mlgField.setValue(CurrencyFormatted(produk_harga_mlgField.getValue())); });
	
	produk_awal_jumlahField.on('focus',function(){ produk_awal_jumlahField.setValue(convertToNumber(produk_awal_jumlahField.getValue())); });
	produk_awal_jumlahField.on('blur',function(){ produk_awal_jumlahField.setValue(CurrencyFormatted(produk_awal_jumlahField.getValue())); });
	
	produk_awal_nilaiField.on('focus',function(){ produk_awal_nilaiField.setValue(convertToNumber(produk_awal_nilaiField.getValue())); });
	produk_awal_nilaiField.on('blur',function(){ produk_awal_nilaiField.setValue(CurrencyFormatted(produk_awal_nilaiField.getValue())); });
	
	combo_satuan_produk_racik.on('focus', function(){
		cbo_produk_racik_satuanDataStore.setBaseParam('produk_id',combo_rawat_produk.getValue());
		cbo_produk_racik_satuanDataStore.load();
	});
	
	
	//Events for diskon
	produk_duField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dmField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dultahField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dcardField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dkolegaField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dkeluargaField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_downerField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dgroomingField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dwartawanField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dstaffdokterField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dstaffnondokterField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_dpromoField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	produk_pointField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
});
	--></script>
<body>
<div>
	<div class="col">
        <div id="fp_produk"></div>
         <div id="fp_satuan_konversi"></div>
		 <div id="fp_produk_racikan"></div>
		<div id="elwindow_produk_create"></div>
        <div id="elwindow_produk_search"></div>
    </div>
</div>
</body>