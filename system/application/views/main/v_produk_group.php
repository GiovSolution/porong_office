<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: produk_group View
	+ Description	: For record view
	+ Filename 		: v_produk_group.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 28/Jul/2009 10:10:08
	
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
<script>
/* declare function */		
var produk_group_DataStore;
var produk_group_ColumnModel;
var produk_groupListEditorGrid;
var produk_group_createForm;
var produk_group_createWindow;
var produk_group_searchForm;
var produk_group_searchWindow;
var produk_group_SelectedRow;
var produk_group_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var group_idField;
var group_kodeField;
var group_namaField;
var group_treatment_utamaField;
var group_duprodukField;
var group_dmprodukField;
var group_durawatField;
var group_dmrawatField;
var group_dupaketField;
var group_dmpaketField;
var group_kelompokField;
var group_keteranganField;
var group_aktifField;
var group_dultahField;
var group_dcardField;
var group_dkolegaField;
var group_dkeluargaField;
var group_downerField;
var group_dgroomingField;
var group_dwartawanField;
var group_dstaffdokterField;
var group_dstaffnondokterField;
var group_kredit_produkField;

var group_kodeSearchField;
var group_namaSearchField;
var group_duprodukSearchField;
var group_dmprodukSearchField;
var group_durawatSearchField;
var group_dmrawatSearchField;
var group_dupaketSearchField;
var group_dmpaketSearchField;
var group_keteranganSearchField;
var group_aktifSearchField;
var group_dultahSearchField;
var group_dcardSearchField;
var group_dkolegaSearchField;
var group_dkeluargaSearchField;
var group_downerSearchField;
var group_dgroomingSearchField;
var group_dkaryawanSearchField;
var group_dstaffdokterSearchField;
var group_dstaffnondokterSearchField;
var group_dpromoSearchField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function produk_group_update(oGrid_event){
		var group_id_update_pk="";
		var group_nama_update=null;
		var group_kode_update=null;
		var group_duproduk_update=null;
		var group_dmproduk_update=null;
		var group_durawat_update=null;
		var group_dmrawat_update=null;
		var group_dupaket_update=null;
		var group_dmpaket_update=null;
		var group_kelompok_update=null;
		var group_keterangan_update=null;
		var group_aktif_update=null;
	
	
		group_id_update_pk = oGrid_event.record.data.group_id;
		if(oGrid_event.record.data.group_nama!== null){group_nama_update = oGrid_event.record.data.group_nama;}
		if(oGrid_event.record.data.group_kode!== null){group_kode_update = oGrid_event.record.data.group_kode;}
		if(oGrid_event.record.data.group_duproduk!== null){group_duproduk_update = oGrid_event.record.data.group_duproduk;}
		if(oGrid_event.record.data.group_dmproduk!== null){group_dmproduk_update = oGrid_event.record.data.group_dmproduk;}
		if(oGrid_event.record.data.group_durawat!== null){group_durawat_update = oGrid_event.record.data.group_durawat;}
		if(oGrid_event.record.data.group_dmrawat!== null){group_dmrawat_update = oGrid_event.record.data.group_dmrawat;}
		if(oGrid_event.record.data.group_dupaket!== null){group_dupaket_update = oGrid_event.record.data.group_dupaket;}
		if(oGrid_event.record.data.group_dmpaket!== null){group_dmpaket_update = oGrid_event.record.data.group_dmpaket;}
		if(oGrid_event.record.data.group_kelompok!== null){group_kelompok_update = oGrid_event.record.data.group_kelompok;}
		if(oGrid_event.record.data.group_keterangan!== null){group_keterangan_update = oGrid_event.record.data.group_keterangan;}
		if(oGrid_event.record.data.group_aktif!== null){group_aktif_update = oGrid_event.record.data.group_aktif;}

			
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_produk_group&m=get_action',
			params: {
				task: "UPDATE",
				group_id		: group_id_update_pk,
				group_kode		:group_kode_update,	
				group_nama		:group_nama_update,		
				group_duproduk	:group_duproduk_update,		
				group_dmproduk	:group_dmproduk_update,		
				group_durawat	:group_durawat_update,		
				group_dmrawat	:group_dmrawat_update,		
				group_dupaket	:group_dupaket_update,		
				group_dmpaket	:group_dmpaket_update,
				group_kelompok	:group_kelompok_update,		
				group_keterangan	:group_keterangan_update,		
				group_aktif	:group_aktif_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						produk_group_DataStore.commitChanges();
						produk_group_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Group1 tidak bisa disimpan !.',
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
	function produk_group_create(btn){
		if(is_produk_group_form_valid()){
		
		var group_id_create_pk=null;
		var group_kode_create=null;
		var group_nama_create=null;
		var group_duproduk_create=null;
		var group_dmproduk_create=null;
		var group_durawat_create=null;
		var group_dmrawat_create=null;
		var group_dupaket_create=null;
		var group_dmpaket_create=null;
		var group_kelompok_create=null;
		var group_keterangan_create=null;
		var group_aktif_create=null;
		var group_kredit_create=null;
		var group_dultah_create=null;
		var group_dcard_create=null;
		var group_dkolega_create=null;
		var group_dkeluarga_create=null;
		var group_downer_create=null;
		var group_dgrooming_create=null;
		var group_dwartawan_create=null;
		var group_dstaffdokter_create=null;	
		var group_dstaffnondokter_create=null;
		var group_dpromo_create=null;
		

		group_id_create_pk=get_pk_id();
		if(group_kodeField.getValue()!== null){group_kode_create = group_kodeField.getValue();}
		if(group_namaField.getValue()!== null){group_nama_create = group_namaField.getValue();}
		if(group_duprodukField.getValue()!== null){group_duproduk_create = group_duprodukField.getValue();}
		if(group_dmprodukField.getValue()!== null){group_dmproduk_create = group_dmprodukField.getValue();}
		if(group_durawatField.getValue()!== null){group_durawat_create = group_durawatField.getValue();}
		if(group_dmrawatField.getValue()!== null){group_dmrawat_create = group_dmrawatField.getValue();}
		if(group_dupaketField.getValue()!== null){group_dupaket_create = group_dupaketField.getValue();}
		if(group_dmpaketField.getValue()!== null){group_dmpaket_create = group_dmpaketField.getValue();}
		if(group_kelompokField.getValue()!== null){group_kelompok_create = group_kelompokField.getValue();}
		if(group_keteranganField.getValue()!== null){group_keterangan_create = group_keteranganField.getValue();}
		if(group_aktifField.getValue()!== null){group_aktif_create = group_aktifField.getValue();}		
		if(group_kredit_produkField.getValue()!== null){group_kredit_create = group_kredit_produkField.getValue();}
		if(group_dultahField.getValue()!== null){group_dultah_create = group_dultahField.getValue();}
		if(group_dcardField.getValue()!== null){group_dcard_create = group_dcardField.getValue();}
		if(group_dkolegaField.getValue()!== null){group_dkolega_create = group_dkolegaField.getValue();}
		if(group_dkeluargaField.getValue()!== null){group_dkeluarga_create = group_dkeluargaField.getValue();}
		if(group_downerField.getValue()!== null){group_downer_create = group_downerField.getValue();}
		if(group_dgroomingField.getValue()!== null){group_dgrooming_create = group_dgroomingField.getValue();}
		if(group_dwartawanField.getValue()!== null){group_dwartawan_create = group_dwartawanField.getValue();}
		if(group_dstaffdokterField.getValue()!== null){group_dstaffdokter_create = group_dstaffdokterField.getValue();}
		if(group_dstaffnondokterField.getValue()!== null){group_dstaffnondokter_create = group_dstaffnondokterField.getValue();}
		if(group_dpromoField.getValue()!== null){group_dpromo_create = group_dpromoField.getValue();}
		
		
		
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_produk_group&m=get_action',
				params: {
					task			: post2db,
					group_id		: group_id_create_pk,
					group_kode		: group_kode_create,
					group_nama		: group_nama_create,
					group_treatment_utama	: group_treatment_utamaField.getValue(),
					group_duproduk	: group_duproduk_create,	
					group_dmproduk	: group_dmproduk_create,	
					group_durawat	: group_durawat_create,	
					group_dmrawat	: group_dmrawat_create,	
					group_dupaket	: group_dupaket_create,	
					group_dmpaket	: group_dmpaket_create,
					group_kelompok	: group_kelompok_create,	
					group_keterangan	: group_keterangan_create,	
					group_aktif	: group_aktif_create,
					group_kredit	: group_kredit_create,
					group_dultah	: group_dultah_create,
					group_dcard		: group_dcard_create,
					group_dkolega	: group_dkolega_create,
					group_dkeluarga	: group_dkeluarga_create,
					group_downer	: group_downer_create,
					group_dgrooming	: group_dgrooming_create,
					group_dwartawan	: group_dwartawan_create,
					group_dstaffdokter : group_dstaffdokter_create,
					group_dstaffnondokter	: group_dstaffnondokter_create,
					group_dpromo	: group_dpromo_create,
					group_opsi	: btn
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Group 1 berhasil disimpan.');
							produk_group_DataStore.reload();
							produk_group_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Group 1 tidak bisa disimpan !',
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
						   msg: 'Tidak bisa terhubung dengan database !',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Isian belum sempurna!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function produk_group_reset_form(){
		group_kodeField.reset();
		group_kodeField.setValue(null);
		group_namaField.reset();
		group_namaField.setValue(null);
		group_treatment_utamaField.reset();
		group_treatment_utamaField.setValue(null);
		group_duprodukField.reset();
		group_duprodukField.setValue(null);
		group_dmprodukField.reset();
		group_dmprodukField.setValue(null);
		group_durawatField.reset();
		group_durawatField.setValue(null);
		group_dmrawatField.reset();
		group_dmrawatField.setValue(null);
		group_dupaketField.reset();
		group_dupaketField.setValue(null);
		group_dmpaketField.reset();
		group_dmpaketField.setValue(null);
		group_kelompokField.reset();
		group_kelompokField.setValue(null);
		group_keteranganField.reset();
		group_keteranganField.setValue(null);
		group_aktifField.reset();
		group_aktifField.setValue(null);
		group_dultahField.reset();
		group_dultahField.setValue(null);
		group_dcardField.reset();
		group_dcardField.setValue(null);
		group_dkolegaField.reset();
		group_dkolegaField.setValue(null);
		group_dkeluargaField.reset();
		group_dkeluargaField.setValue(null);
		group_downerField.reset();
		group_downerField.setValue(null);
		group_dgroomingField.reset();
		group_dgroomingField.setValue(null);
		group_dwartawanField.reset();
		group_dwartawanField.setValue(null);
		group_dstaffdokterField.reset();
		group_dstaffdokterField.setValue(null);
		group_dstaffnondokterField.reset();
		group_dstaffnondokterField.setValue(null);
		group_kredit_produkField.reset();
		group_kredit_produkField.setValue(null);
		
		
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function produk_group_set_form(){
		group_kodeField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_kode'));
		group_namaField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_nama'));
		group_treatment_utamaField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_treatment_utama'));
		group_duprodukField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_duproduk'));
		group_dmprodukField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dmproduk'));
		group_durawatField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_durawat'));
		group_dmrawatField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dmrawat'));
		group_dupaketField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dupaket'));
		group_dmpaketField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dmpaket'));
		group_kelompokField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_kelompok'));
		group_keteranganField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_keterangan'));
		group_aktifField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_aktif'));
		group_kredit_produkField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_kredit'));
		group_dultahField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dultah'));
		group_dcardField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dcard'));
		group_dkolegaField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dkolega'));
		group_dkeluargaField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dkeluarga'));
		group_downerField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_downer'));
		group_dgroomingField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dgrooming'));
		group_dwartawanField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dwartawan'));
		group_dstaffdokterField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dstaffdokter'));
		group_dstaffnondokterField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dstaffnondokter'));
		group_dpromoField.setValue(produk_groupListEditorGrid.getSelectionModel().getSelected().get('group_dpromo'));
		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_produk_group_form_valid(){
		return (group_kodeField.isValid() && group_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!produk_group_createWindow.isVisible()){
			produk_group_reset_form();
			post2db='CREATE';
			msg='created';
			produk_group_createWindow.show();
		} else {
			produk_group_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function produk_group_confirm_delete(){
		// only one produk_group is selected here
		if(produk_groupListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut ?', produk_group_delete);
		} else if(produk_groupListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', produk_group_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function produk_group_confirm_update(){
		/* only one record is selected here */
		if(produk_groupListEditorGrid.selModel.getCount() == 1) {
			produk_group_set_form();
			post2db='UPDATE';
			msg='updated';
			produk_group_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function produk_group_delete(btn){
		if(btn=='yes'){
			var selections = produk_groupListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< produk_groupListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.group_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_produk_group&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							produk_group_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang dipilih',
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
					   msg: 'Tidak bisa terhubung dengan database server.',
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
	produk_group_DataStore = new Ext.data.Store({
		id: 'produk_group_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk_group&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
			{name: 'group_id', type: 'int', mapping: 'group_id'},
			{name: 'group_kode', type: 'string', mapping: 'group_kode'},
			{name: 'group_nama', type: 'string', mapping: 'group_nama'},
			{name: 'group_treatment_utama', type: 'int', mapping: 'group_treatment_utama'},
			{name: 'group_duproduk', type: 'int', mapping: 'group_duproduk'},
			{name: 'group_dmproduk', type: 'int', mapping: 'group_dmproduk'},
			{name: 'group_durawat', type: 'int', mapping: 'group_durawat'},
			{name: 'group_dmrawat', type: 'int', mapping: 'group_dmrawat'},
			{name: 'group_dupaket', type: 'int', mapping: 'group_dupaket'},
			{name: 'group_dmpaket', type: 'int', mapping: 'group_dmpaket'},
			{name: 'group_kelompok', type: 'string', mapping: 'kategori_nama'},
			{name: 'group_keterangan', type: 'string', mapping: 'group_keterangan'},
			{name: 'group_aktif', type: 'string', mapping: 'group_aktif'},
			{name: 'group_kredit', type: 'string', mapping: 'group_kredit'},
			{name: 'group_dultah', type: 'int', mapping: 'group_dultah'},
			{name: 'group_dcard', type: 'int', mapping: 'group_dcard'},
			{name: 'group_dkolega', type: 'int', mapping: 'group_dkolega'},
			{name: 'group_dkeluarga', type: 'int', mapping: 'group_dkeluarga'},
			{name: 'group_downer', type: 'int', mapping: 'group_downer'},
			{name: 'group_dgrooming', type: 'int', mapping: 'group_dgrooming'},
			{name: 'group_dwartawan', type: 'int', mapping: 'group_dwartawan'},
			{name: 'group_dstaffdokter', type: 'int', mapping: 'group_dstaffdokter'},
			{name: 'group_dstaffnondokter', type: 'int', mapping: 'group_dstaffnondokter'},
			{name: 'group_dpromo', type: 'int', mapping: 'group_dpromo'},
			{name: 'group_creator', type: 'string', mapping: 'group_creator'},
			{name: 'group_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'group_date_create'},
			{name: 'group_update', type: 'string', mapping: 'group_update'},
			{name: 'group_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'group_date_update'},
			{name: 'group_revised', type: 'int', mapping: 'group_revised'}
		]),
		sortInfo:{field: 'group_id', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_group_jenisDataStore = new Ext.data.Store({
		id: 'cbo_group_jenisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_produk_group&m=get_kategori_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori_id'
		},[
			{name: 'cbo_jenis_id', type: 'int', mapping: 'kategori_id'},
			{name: 'cbo_jenis_nama', type: 'string', mapping: 'kategori_nama'},
			{name: 'cbo_jenis_kelompok', type: 'string', mapping: 'kategori_jenis'}
		]),
		sortInfo:{field: 'cbo_jenis_nama', direction: "ASC"}
	});
    
  	/* Function for Identify of Window Column Model */
	produk_group_ColumnModel = new Ext.grid.ColumnModel(
		[/*{
			header: '#',
			readOnly: true,
			dataIndex: 'group_id',
			width: 50,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},*/
		{
			header: 'Nama',
			dataIndex: 'group_nama',
			width: 250,
			sortable: true,
			readOnly: true
		},
		{
			header: 'Kode',
			dataIndex: 'group_kode',
			width: 100,
			sortable: true,
			readOnly: true
		},
		{
			header: 'Kredit(%)',
			dataIndex: 'group_kredit',
			width: 100,
			sortable: true,
			readOnly: true
		},
		{
			header: 'DU Produk',
			dataIndex: 'group_duproduk',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'DM Produk',
			dataIndex: 'group_dmproduk',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'DU Perawatan',
			dataIndex: 'group_durawat',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'DM Perawatan',
			dataIndex: 'group_dmrawat',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'DU Paket',
			dataIndex: 'group_dupaket',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'DM Paket',
			dataIndex: 'group_dmpaket',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Ultah',
			dataIndex: 'group_dultah',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Card',
			dataIndex: 'group_dcard',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Kolega',
			dataIndex: 'group_dkolega',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Keluarga',
			dataIndex: 'group_dkeluarga',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Owner',
			dataIndex: 'group_downer',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Grooming',
			dataIndex: 'group_dgrooming',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Wartawan',
			dataIndex: 'group_dwartawan',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Staff Dokter',
			dataIndex: 'group_dstaffdokter',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Staff Non Dokter',
			dataIndex: 'group_dstaffnondokter',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Promo',
			dataIndex: 'group_dpromo',
			width: 80,
			sortable: true,
			renderer: function(val){
				return '<span>' + val + ' %</span>';
			},
			readOnly: true
		},
		{
			header: 'Jenis',
			dataIndex: 'group_kelompok',
			width: 125,
			sortable: true
			<? if(eregi('u',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				store: cbo_group_jenisDataStore,
				mode: 'remote',
				displayField:'cbo_jenis_nama',
				valueField: 'cbo_jenis_id',
		        typeAhead: false,
		        loadingText: 'Searching...',
		        //pageSize:10,
		        hideTrigger:false,
		        //tpl: jenis_group_tpl,
		        //applyTo: 'search',
		        //itemSelector: 'div.search-item',
				triggerAction: 'all',
				lazyRender:true,
				listClass: 'x-combo-list-small',
				anchor: '95%'
			})
			<? }?>
		},
		/*
		{
			header: 'Keterangan',
			dataIndex: 'group_keterangan',
			width: 150,
			sortable: true
			<? if(eregi('u',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<? } ?>
		},
		*/
		{
			header: 'Status',
			dataIndex: 'group_aktif',
			width: 125,
			sortable: true
			<? if(eregi('u',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['group_aktif_value', 'group_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'group_aktif_display',
               	valueField: 'group_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<? } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'group_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'group_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'group_update',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'group_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'group_revised',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	produk_group_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	produk_groupListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'produk_groupListEditorGrid',
		el: 'fp_produk_group',
		title: 'Daftar Group 1',
		autoHeight: true,
		store: produk_group_DataStore, // DataStore
		cm: produk_group_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: produk_group_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<? if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<? } ?>
		<? if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: produk_group_confirm_update   // Confirm before updating
		}, '-',
		<? } ?>
		<? if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: produk_group_confirm_delete   // Confirm before deleting
		}, '-', 
		<? } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: produk_group_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						produk_group_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama Produk Group<br>- Kode Produk Group'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: produk_group_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: produk_group_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produk_group_print  
		}
		]
	});
	produk_groupListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	produk_group_ContextMenu = new Ext.menu.Menu({
		id: 'produk_group_ListEditorGridContextMenu',
		items: [
		<? if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: produk_group_confirm_update 
		},
		<? } ?>
		<? if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: produk_group_confirm_delete 
		},
		<? } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produk_group_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: produk_group_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onproduk_group_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		produk_group_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		produk_group_SelectedRow=rowIndex;
		produk_group_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function produk_group_editContextMenu(){
      produk_groupListEditorGrid.startEditing(produk_group_SelectedRow,1);
  	}
	/* End of Function */
  	
	produk_groupListEditorGrid.addListener('rowcontextmenu', onproduk_group_ListEditGridContextMenu);
	produk_group_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	produk_groupListEditorGrid.on('afteredit', produk_group_update); // inLine Editing Record
	
	/* Identify  group_nama Field */
	group_kodeField= new Ext.form.TextField({
		id: 'group_kodeField',
		fieldLabel: 'Kode <span style="color: #ec0000">*</span>',
		allowBlank: false,
		maxLength: 5,
		width: 100,
		maskRe: /([a-zA-Z]+)$/
	});
	
	group_namaField= new Ext.form.TextField({
		id: 'group_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		allowBlank: false,
		maxLength: 250,
		anchor: '50%'
	});
	
	
	group_treatment_utamaField=new Ext.form.Checkbox({
		id : 'group_treatment_utamaField',
		boxLabel: 'Treatment Utama?',
		name: 'group_treatment_utama'
	});
	
	/* Identify  group_duproduk Field */
	
	group_duprodukField= new Ext.form.NumberField({
		id: 'group_duprodukField',
		fieldLabel: 'Produk',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dmproduk Field */
	group_dmprodukField= new Ext.form.NumberField({
		id: 'group_dmprodukField',
		fieldLabel: 'Produk',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_durawat Field */
	group_durawatField= new Ext.form.NumberField({
		id: 'group_durawatField',
		fieldLabel: 'Perawatan',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dmrawat Field */
	group_dmrawatField= new Ext.form.NumberField({
		id: 'group_dmrawatField',
		fieldLabel: 'Perawatan',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dupaket Field */
	group_dupaketField= new Ext.form.NumberField({
		id: 'group_dupaketField',
		fieldLabel: 'Paket',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dmpaket Field */
	group_dmpaketField= new Ext.form.NumberField({
		id: 'group_dmpaketField',
		fieldLabel: 'Paket',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_kelompok Field */
	group_kelompokField= new Ext.form.ComboBox({
		id: 'group_kelompokField',
		fieldLabel: 'Jenis',
		store: cbo_group_jenisDataStore,
		mode: 'remote',
		editable:false,
		displayField:'cbo_jenis_nama',
		valueField: 'cbo_jenis_id',
        typeAhead: false,
        loadingText: 'Searching...',
        //pageSize:10,
        hideTrigger:false,
        //tpl: jenis_group_tpl,
        //applyTo: 'search',
        //itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '50%'
	});
	/* Identify  group_keterangan Field */
	group_keteranganField= new Ext.form.TextArea({
		id: 'group_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '50%'
	});
	/* Identify  group_aktif Field */
	group_aktifField= new Ext.form.ComboBox({
		id: 'group_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['group_aktif_value', 'group_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'group_aktif_display',
		valueField: 'group_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Identify group_dultah Field*/
	group_dultahField= new Ext.form.NumberField({
		id: 'group_dultahField',
		fieldLabel: 'Ultah',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dcard Field*/
	group_dcardField= new Ext.form.NumberField({
		id: 'group_dcardField',
		fieldLabel: 'Credit Card',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dkolega Field*/
	group_dkolegaField= new Ext.form.NumberField({
		id: 'group_dkolegaField',
		fieldLabel: 'Kolega',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dkeluarga Field*/
	group_dkeluargaField= new Ext.form.NumberField({
		id: 'group_dkeluargaField',
		fieldLabel: 'Keluarga',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_downer Field*/
	group_downerField= new Ext.form.NumberField({
		id: 'group_downerField',
		fieldLabel: 'Owner',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dgrooming Field*/
	group_dgroomingField= new Ext.form.NumberField({
		id: 'group_dgroomingField',
		fieldLabel: 'Grooming',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dwartawan Field*/
	group_dwartawanField= new Ext.form.NumberField({
		id: 'group_dwartawanField',
		fieldLabel: 'Wartawan',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dstaffdokter Field*/
	group_dstaffdokterField= new Ext.form.NumberField({
		id: 'group_dstaffdokterField',
		fieldLabel: 'Staff Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dstaffnondokter Field*/
	group_dstaffnondokterField= new Ext.form.NumberField({
		id: 'group_dstaffnondokterField',
		fieldLabel: 'Staff Non Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dpromo Field*/
	group_dpromoField= new Ext.form.NumberField({
		id: 'group_dpromoField',
		fieldLabel: 'Promo',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
		
	group_kredit_produkField= new Ext.form.NumberField({
		id: 'group_kredit_produkField',
		fieldLabel: 'Produk',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	group_diskon_umumFielSet = new Ext.form.FieldSet({
		title: 'Diskon Umum (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_duprodukField,group_durawatField,group_dupaketField] 
			}
			]
	});
	
	group_diskon_memberFielSet = new Ext.form.FieldSet({
		title: 'Diskon Member (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dmprodukField,group_dmrawatField,group_dmpaketField] 
			}
			]
	});
	
	/* Group utk Diskon Ultah */
	group_diskon_ultahFieldset = new Ext.form.FieldSet({
		title: 'Ultah (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dultahField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Credit Card */
	group_diskon_cardFieldset = new Ext.form.FieldSet({
		title: 'Credit Card (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dcardField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Kolega */
	group_diskon_kolegaFieldset = new Ext.form.FieldSet({
		title: 'Kolega (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dkolegaField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Keluarga */
	group_diskon_keluargaFieldset = new Ext.form.FieldSet({
		title: 'Keluarga (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dkeluargaField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Owner */
	group_diskon_ownerFieldset = new Ext.form.FieldSet({
		title: 'Owner (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_downerField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Grooming */
	group_diskon_groomingFieldset = new Ext.form.FieldSet({
		title: 'Grooming (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dgroomingField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Wartawan */
	group_diskon_wartawanFieldset = new Ext.form.FieldSet({
		title: 'Wartawan (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dwartawanField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Staff Dokter */
	group_diskon_staffdokterFieldset = new Ext.form.FieldSet({
		title: 'Staff Dokter (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dstaffdokterField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Staff Non Dokter */
	group_diskon_staffnondokterFieldset = new Ext.form.FieldSet({
		title: 'Staff Non Dokter (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dstaffnondokterField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Promo */
	group_diskon_promoFieldset = new Ext.form.FieldSet({
		title: 'Promo (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dpromoField, {xtype: 'spacer',height:53}] 
			}
			]
	});

	group_kredit_FielSet = new Ext.form.FieldSet({
		title: 'Kredit (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		width : 10,
		layout:'column',
		anchor: '50%',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [group_kredit_produkField] 
			}
			]
	});
	
	/* Function for retrieve create Window Panel*/ 
	produk_group_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_kodeField,group_namaField, group_treatment_utamaField,
						{
							layout:'column',
							border:false,
							items:[
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_umumFielSet]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_memberFielSet]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_ultahFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_cardFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_kolegaFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_keluargaFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_ownerFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_groomingFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_wartawanFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_staffdokterFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_staffnondokterFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_promoFieldset]
								   }
								   ]
						}
						,group_kredit_FielSet,group_kelompokField,group_keteranganField, group_aktifField] 
			}
			
			]
		}]
		,
		buttons: [
			<? if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_GROUP1'))){ ?>
			{
				text: 'Save and Close',
				handler: function() {
					Ext.MessageBox.confirm('Konfirmasi','Apakah Anda yakin semua diskon pada Group ini akan diberlakukan pada semua Produk/Perawatan/Paket ?', produk_group_create);
				}
			}
			,
			<? } ?>
			{
				text: 'Cancel',
				handler: function(){
					produk_group_DataStore.reload();
					produk_group_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	produk_group_createWindow= new Ext.Window({
		id: 'produk_group_createWindow',
		title: post2db+' Group 1',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_produk_group_create',
		items: produk_group_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function produk_group_list_search(){
		// render according to a SQL date format.
		//var group_id_search=null;
		var group_kode_search=null;
		var group_nama_search=null;
		var group_duproduk_search=null;
		var group_dmproduk_search=null;
		var group_durawat_search=null;
		var group_dmrawat_search=null;
		var group_dupaket_search=null;
		var group_dmpaket_search=null;
		var group_keterangan_search=null;
		var group_aktif_search=null;
		var group_dultah_search=null;
		var group_dcard_search=null;
		var group_dkolega_search=null;
		var group_dkeluarga_search=null;
		var group_downer_search=null;
		var group_dgrooming_search=null;
		var group_kelompok_search=null;
		var group_dwartawan_search=null;
		var group_dstaffdokter_search=null;	
		var group_dstaffnondokter_search=null;
		var group_dpromo_search=null;
		var group_kredit_search=null;


		//if(group_idSearchField.getValue()!==null){group_id_search=group_idSearchField.getValue();}
		if(group_kodeSearchField.getValue()!==null){group_kode_search=group_kodeSearchField.getValue();}
		if(group_namaSearchField.getValue()!==null){group_nama_search=group_namaSearchField.getValue();}
		if(group_duprodukSearchField.getValue()!==null){group_duproduk_search=group_duprodukSearchField.getValue();}
		if(group_dmprodukSearchField.getValue()!==null){group_dmproduk_search=group_dmprodukSearchField.getValue();}
		if(group_durawatSearchField.getValue()!==null){group_durawat_search=group_durawatSearchField.getValue();}
		if(group_dmrawatSearchField.getValue()!==null){group_dmrawat_search=group_dmrawatSearchField.getValue();}
		if(group_dupaketSearchField.getValue()!==null){group_dupaket_search=group_dupaketSearchField.getValue();}
		if(group_dmpaketSearchField.getValue()!==null){group_dmpaket_search=group_dmpaketSearchField.getValue();}
		if(group_keteranganSearchField.getValue()!==null){group_keterangan_search=group_keteranganSearchField.getValue();}
		if(group_aktifSearchField.getValue()!==null){group_aktif_search=group_aktifSearchField.getValue();}
		if(group_kredit_produkSearchField.getValue()!==null){group_kredit_search=group_kredit_produkSearchField.getValue();}
		if(group_dultahSearchField.getValue()!==null){group_dultah_search=group_dultahSearchField.getValue();}
		if(group_dcardSearchField.getValue()!==null){group_dcard_search=group_dcardSearchField.getValue();}
		if(group_dkolegaSearchField.getValue()!==null){group_dkolega_search=group_dkolegaSearchField.getValue();}
		if(group_dkeluargaSearchField.getValue()!==null){group_dkeluarga_search=group_dkeluargaSearchField.getValue();}
		if(group_downerSearchField.getValue()!==null){group_downer_search=group_downerSearchField.getValue();}
		if(group_dgroomingSearchField.getValue()!==null){group_kelompok_search=group_dgroomingSearchField.getValue();}
		if(group_kelompokSearchField.getValue()!==null){group_kelompok_search=group_kelompokSearchField.getValue();}
		if(group_dwartawanSearchField.getValue()!== null){group_dwartawan_search = group_dwartawanSearchField.getValue();}
		if(group_dstaffdokterSearchField.getValue()!== null){group_dstaffdokter_search = group_dstaffdokterSearchField.getValue();}
		if(group_dstaffnondokterSearchField.getValue()!== null){group_dstaffnondokter_search = group_dstaffnondokterSearchField.getValue();}
		if(group_dpromoSearchField.getValue()!== null){group_dpromo_search = group_dpromoSearchField.getValue();}
		
		// change the store parameters
		produk_group_DataStore.baseParams = {
			task: 'SEARCH',
			start:0,
			limit:pageS,
			//variable here
			//group_id	:	group_id_search, 
			group_kode	:	group_kode_search, 
			group_nama	:	group_nama_search, 
			group_duproduk	:	group_duproduk_search, 
			group_dmproduk	:	group_dmproduk_search, 
			group_durawat	:	group_durawat_search, 
			group_dmrawat	:	group_dmrawat_search, 
			group_dupaket	:	group_dupaket_search, 
			group_dmpaket	:	group_dmpaket_search, 
			group_keterangan:	group_keterangan_search, 
			group_aktif		:	group_aktif_search,
			group_kredit	:	group_kredit_search,
			group_dultah	: group_dultah_search,
			group_dcard		: group_dcard_search,
			group_dkolega	: group_dkolega_search,
			group_dkeluarga	: group_dkeluarga_search,
			group_downer	: group_downer_search,
			group_dgrooming	: group_dgrooming_search,
			group_kelompok	:	group_kelompok_search,
			group_dwartawan	: group_dwartawan_search,
			group_dstaffdokter : group_dstaffdokter_search,
			group_dstaffnondokter	: group_dstaffnondokter_search,
			group_dpromo	: group_dpromo_search
		};
		// Cause the datastore to do another query : 
		produk_group_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function produk_group_reset_search(){
		// reset the store parameters
		produk_group_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		// Cause the datastore to do another query : 
		produk_group_DataStore.reload({params: {start: 0, limit: pageS}});
		produk_group_searchWindow.close();
	};
	/* End of Fuction */

	function produk_group_reset_SearchForm(){
		group_kodeSearchField.reset();
		group_namaSearchField.reset();
		group_duprodukSearchField.reset();
		group_dmprodukSearchField.reset();
		group_durawatSearchField.reset();
		group_dmrawatSearchField.reset();
		group_dupaketSearchField.reset();
		group_dmpaketSearchField.reset();
		group_keteranganSearchField.reset();
		group_aktifSearchField.reset();
		group_kelompokSearchField.reset();
		
		group_dultahSearchField.reset();
		group_dcardSearchField.reset();
		group_dkolegaSearchField.reset();
		group_dkeluargaSearchField.reset();
		group_downerSearchField.reset();
		group_dgroomingSearchField.reset();
		group_dwartawanSearchField.reset();
		group_dstaffdokterSearchField.reset();
		group_dstaffnondokterSearchField.reset();
		group_dpromoSearchField.reset();
		group_kredit_produkSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  group_nama Field */
	group_kodeSearchField= new Ext.form.TextField({
		id: 'group_kodeSearchField',
		fieldLabel: 'Kode',
		allowBlank: true,
		maxLength: 5,
		width: 100,
		maskRe: /([a-zA-Z]+)$/
	});
	
	group_namaSearchField= new Ext.form.TextField({
		id: 'group_namaSearchField',
		fieldLabel: 'Nama',
		allowBlank: true,
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  group_duproduk Field */
	group_duprodukSearchField= new Ext.form.NumberField({
		id: 'group_duprodukSearchField',
		fieldLabel: 'Produk',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dmproduk Field */
	group_dmprodukSearchField= new Ext.form.NumberField({
		id: 'group_dmprodukSearchField',
		fieldLabel: 'Produk',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_durawat Field */
	group_durawatSearchField= new Ext.form.NumberField({
		id: 'group_durawatSearchField',
		fieldLabel: 'Perawatan',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dmrawat Field */
	group_dmrawatSearchField= new Ext.form.NumberField({
		id: 'group_dmrawatSearchField',
		fieldLabel: 'Perawatan',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dupaket Field */
	group_dupaketSearchField= new Ext.form.NumberField({
		id: 'group_dupaketSearchField',
		fieldLabel: 'Paket',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_dmpaket Field */
	group_dmpaketSearchField= new Ext.form.NumberField({
		id: 'group_dmpaketSearchField',
		fieldLabel: 'Paket',
		allowNegatife : false,
		emptyText: '0',
		maxLength: 3,
		allowDecimals: false,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  group_kelompok Field */
	group_kelompokSearchField= new Ext.form.ComboBox({
		id: 'group_kelompokSearchField',
		fieldLabel: 'Jenis',
		store: cbo_group_jenisDataStore,
		mode: 'remote',
		displayField:'cbo_jenis_nama',
		valueField: 'cbo_jenis_id',
        typeAhead: false,
        loadingText: 'Searching...',
        //pageSize:10,
        hideTrigger:false,
        //tpl: jenis_group_tpl,
        //applyTo: 'search',
        //itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '50%'
	});
	/* Identify  group_keterangan Field */
	group_keteranganSearchField= new Ext.form.TextArea({
		id: 'group_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '50%'
	});
	/* Identify  group_aktif Field */
	group_aktifSearchField= new Ext.form.ComboBox({
		id: 'group_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['group_aktif_value', 'group_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		displayField: 'group_aktif_display',
		valueField: 'group_aktif_value',
		width: 90,
		triggerAction: 'all'	
	});
	
	/* Identify group_dultah Search Field*/
	group_dultahSearchField= new Ext.form.NumberField({
		id: 'group_dultahSearchField',
		fieldLabel: 'Ultah',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_kredit Search Field*/
	group_kredit_produkSearchField= new Ext.form.NumberField({
		id: 'group_kredit_produkSearchField',
		fieldLabel: 'Produk',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dcardSearchField Field*/
	group_dcardSearchField= new Ext.form.NumberField({
		id: 'group_dcardSearchField',
		fieldLabel: 'Credit Card',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dkolegaSearchField Field*/
	group_dkolegaSearchField= new Ext.form.NumberField({
		id: 'group_dkolegaSearchField',
		fieldLabel: 'Kolega',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dkeluargaSearchField Field*/
	group_dkeluargaSearchField= new Ext.form.NumberField({
		id: 'group_dkeluargaSearchField',
		fieldLabel: 'Keluarga',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_downerSearchField Field*/
	group_downerSearchField= new Ext.form.NumberField({
		id: 'group_downerSearchField',
		fieldLabel: 'Owner',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dgroomingSearchField Field*/
	group_dgroomingSearchField= new Ext.form.NumberField({
		id: 'group_dgroomingSearchField',
		fieldLabel: 'Grooming',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dwartawanSearchField Field*/
	group_dwartawanSearchField= new Ext.form.NumberField({
		id: 'group_dwartawanSearchField',
		fieldLabel: 'Wartawan',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dstaffdokterSearchField Field*/
	group_dstaffdokterSearchField= new Ext.form.NumberField({
		id: 'group_dstaffdokterSearchField',
		fieldLabel: 'Staff Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify group_dstaffnondokterSearchField Field*/
	group_dstaffnondokterSearchField= new Ext.form.NumberField({
		id: 'group_dstaffnondokterSearchField',
		fieldLabel: 'Staff Non Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
		
	/* Identify group_dpromoSearchField Field*/
	group_dpromoSearchField= new Ext.form.NumberField({
		id: 'group_dpromoSearchField',
		fieldLabel: 'Promo',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		maxLength: 3,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	
	group_diskon_umumSearchFielSet = new Ext.form.FieldSet({
		title: 'Diskon Umum (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_duprodukSearchField,group_durawatSearchField,group_dupaketSearchField] 
			}
			]
	});
	
	group_diskon_memberSearchFielSet = new Ext.form.FieldSet({
		title: 'Diskon Member (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dmprodukSearchField,group_dmrawatSearchField,group_dmpaketSearchField] 
			}
			]
	});
	
	
	/* Group utk Diskon Ultah Search */
	group_diskon_ultahSearchFieldset = new Ext.form.FieldSet({
		title: 'Ultah (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dultahSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	group_kredit_SearchFielSet = new Ext.form.FieldSet({
		title: 'Kredit (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		width : 10,
		layout:'column',
		anchor: '50%',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [group_kredit_produkSearchField] 
			}
			]
	});
	
	/* Group utk Diskon Credit Card Search*/
	group_diskon_cardSearchFieldset = new Ext.form.FieldSet({
		title: 'Credit Card (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dcardSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Kolega */
	group_diskon_kolegaSearchFieldset = new Ext.form.FieldSet({
		title: 'Kolega (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dkolegaSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Keluarga Search */
	group_diskon_keluargaSearchFieldset = new Ext.form.FieldSet({
		title: 'Keluarga (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dkeluargaSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Owner Search */
	group_diskon_ownerSearchFieldset = new Ext.form.FieldSet({
		title: 'Owner (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_downerSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Grooming Search */
	group_diskon_groomingSearchFieldset = new Ext.form.FieldSet({
		title: 'Grooming (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dgroomingSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});

	/* Group utk Diskon Grooming Search */
	group_diskon_wartawanSearchFieldset = new Ext.form.FieldSet({
		title: 'Wartawan (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dwartawanSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Grooming Search */
	group_diskon_staffdokterSearchFieldset = new Ext.form.FieldSet({
		title: 'Staff Dokter (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dstaffdokterSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Grooming Search */
	group_diskon_staffnondokterSearchFieldset = new Ext.form.FieldSet({
		title: 'Staff Non Dokter (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dstaffnondokterSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});
	
	/* Group utk Diskon Grooming Search */
	group_diskon_promoSearchFieldset = new Ext.form.FieldSet({
		title: 'Promo (%)',
		labelWidth: 90,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_dpromoSearchField, {xtype: 'spacer',height:53}] 
			}
			]
	});

	/* Function for retrieve search Form Panel */
	produk_group_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_kodeSearchField,group_namaSearchField, 
						{
							layout:'column',
							border:false,
							items:[
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_umumSearchFielSet]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_memberSearchFielSet]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_ultahSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_cardSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_kolegaSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_keluargaSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_ownerSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_groomingSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_wartawanSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_staffdokterSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_staffnondokterSearchFieldset]
								   },
								   {
									   columnWidth:0.25,
									   layout: 'form',
									   border:false,
									   items:[group_diskon_promoSearchFieldset]
								   }
								   
								   ]
						}
						,group_kredit_SearchFielSet,group_kelompokSearchField,group_keteranganSearchField, group_aktifSearchField] 
			}
			
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: produk_group_list_search
			},{
				text: 'Close',
				handler: function(){
					produk_group_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	produk_group_searchWindow = new Ext.Window({
		title: 'Pencarian Group 1',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_produk_group_search',
		items: produk_group_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!produk_group_searchWindow.isVisible()){
			produk_group_reset_SearchForm();
			produk_group_searchWindow.show();
		} else {
			produk_group_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function produk_group_print(){
		var searchquery = "";
		var group_kode_print=null;
		var group_nama_print=null;
		var group_duproduk_print=null;
		var group_dmproduk_print=null;
		var group_durawat_print=null;
		var group_dmrawat_print=null;
		var group_dupaket_print=null;
		var group_dmpaket_print=null;
		var group_keterangan_print=null;
		var group_aktif_print=null;
		var group_kredit_print=null;
		var group_dultah_print=null;
		var group_dcard_print=null;
		var group_dkolega_print=null;
		var group_dkeluarga_print=null;
		var group_downer_print=null;
		var group_dgrooming_print=null;
		var group_dwartawan_print=null;
		var group_dstaffdokter_print=null;	
		var group_dstaffnondokter_print=null;
		var group_dpromo_print=null;
		
		var win;              
		// check if we do have some search data...
		if(produk_group_DataStore.baseParams.query!==null){searchquery = produk_group_DataStore.baseParams.query;}
		if(produk_group_DataStore.baseParams.group_kode!==null){group_kode_print = produk_group_DataStore.baseParams.group_kode;}
		if(produk_group_DataStore.baseParams.group_nama!==null){group_nama_print = produk_group_DataStore.baseParams.group_nama;}
		if(produk_group_DataStore.baseParams.group_duproduk!==null){group_duproduk_print = produk_group_DataStore.baseParams.group_duproduk;}
		if(produk_group_DataStore.baseParams.group_dmproduk!==null){group_dmproduk_print = produk_group_DataStore.baseParams.group_dmproduk;}
		if(produk_group_DataStore.baseParams.group_durawat!==null){group_durawat_print = produk_group_DataStore.baseParams.group_durawat;}
		if(produk_group_DataStore.baseParams.group_dmrawat!==null){group_dmrawat_print = produk_group_DataStore.baseParams.group_dmrawat;}
		if(produk_group_DataStore.baseParams.group_dupaket!==null){group_dupaket_print = produk_group_DataStore.baseParams.group_dupaket;}
		if(produk_group_DataStore.baseParams.group_dmpaket!==null){group_dmpaket_print = produk_group_DataStore.baseParams.group_dmpaket;}
		if(produk_group_DataStore.baseParams.group_keterangan!==null){group_keterangan_print = produk_group_DataStore.baseParams.group_keterangan;}
		if(produk_group_DataStore.baseParams.group_aktif!==null){group_aktif_print = produk_group_DataStore.baseParams.group_aktif;}
		if(produk_group_DataStore.baseParams.group_dultah!==null){group_dultah_print = produk_group_DataStore.baseParams.group_dultah;}
		if(produk_group_DataStore.baseParams.group_dultah!==null){group_kredit_print = produk_group_DataStore.baseParams.group_kredit;}
		if(produk_group_DataStore.baseParams.group_dcard!==null){group_dcard_print = produk_group_DataStore.baseParams.group_dcard;}
		if(produk_group_DataStore.baseParams.group_dkolega!==null){group_dkolega_print = produk_group_DataStore.baseParams.group_dkolega;}
		if(produk_group_DataStore.baseParams.group_dkeluarga!==null){group_dkeluarga_print = produk_group_DataStore.baseParams.group_dkeluarga;}
		if(produk_group_DataStore.baseParams.group_downer!==null){group_downer_print = produk_group_DataStore.baseParams.group_downer;}
		if(produk_group_DataStore.baseParams.group_dgrooming!==null){group_dgrooming_print = produk_group_DataStore.baseParams.group_dgrooming;}
		
		if(produk_group_DataStore.baseParams.group_dwartawan!==null){group_dwartawan_print = produk_group_DataStore.baseParams.group_dwartawan;}
		if(produk_group_DataStore.baseParams.group_dstaffdokter!==null){group_dstaffdokter_print = produk_group_DataStore.baseParams.group_dstaffdokter;}
		if(produk_group_DataStore.baseParams.group_dstaffnondokter!==null){group_dstaffnondokter_print = produk_group_DataStore.baseParams.group_dstaffnondokter;}
		if(produk_group_DataStore.baseParams.group_dpromo!==null){group_dpromo_print = produk_group_DataStore.baseParams.group_dpromo;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_produk_group&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			group_kode 		: group_kode_print,
			group_nama 		: group_nama_print,
			group_duproduk 	: group_duproduk_print,
			group_dmproduk 	: group_dmproduk_print,
			group_durawat 	: group_durawat_print,
			group_dmrawat 	: group_dmrawat_print,
			group_dupaket 	: group_dupaket_print,
			group_dmpaket 	: group_dmpaket_print,
			group_keterangan: group_keterangan_print,
			group_aktif 	: group_aktif_print,
			group_kredit	: group_kredit_print,
			group_dultah	: group_dultah_print,
			group_dcard		: group_dcard_print,
			group_dkolega	: group_dkolega_print,
			group_dkeluarga	: group_dkeluarga_print,
			group_downer	: group_downer_print,
			group_dgrooming	: group_dgrooming_print,
			group_dwartawan	: group_dwartawan_print,
			group_dstaffdokter : group_dstaffdokter_print,
			group_dstaffnondokter	: group_dstaffnondokter_print,
			group_dpromo	: group_dpromo_print,
		  	currentlisting	: produk_group_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./produk_grouplist.html','produk_grouplist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data',
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
	function produk_group_export_excel(){
		var searchquery = "";
		var group_kode_2excel=null;
		var group_nama_2excel=null;
		var group_duproduk_2excel=null;
		var group_dmproduk_2excel=null;
		var group_durawat_2excel=null;
		var group_dmrawat_2excel=null;
		var group_dupaket_2excel=null;
		var group_dmpaket_2excel=null;
		var group_keterangan_2excel=null;
		var group_aktif_2excel=null;
		var group_kredit_2excel=null;
		var group_dultah_2excel=null;
		var group_dcard_2excel=null;
		var group_dkolega_2excel=null;
		var group_dkeluarga_2excel=null;
		var group_downer_2excel=null;
		var group_dgrooming_2excel=null;
		var group_dwartawan_2excel=null;
		var group_dstaffdokter_2excel=null;	
		var group_dstaffnondokter_2excel=null;
		var group_dpromo_2excel=null;
		var win;              
		// check if we do have some search data...
		if(produk_group_DataStore.baseParams.query!==null){searchquery = produk_group_DataStore.baseParams.query;}
		if(produk_group_DataStore.baseParams.group_kode!==null){group_kode_2excel = produk_group_DataStore.baseParams.group_kode;}
		if(produk_group_DataStore.baseParams.group_nama!==null){group_nama_2excel = produk_group_DataStore.baseParams.group_nama;}
		if(produk_group_DataStore.baseParams.group_duproduk!==null){group_duproduk_2excel = produk_group_DataStore.baseParams.group_duproduk;}
		if(produk_group_DataStore.baseParams.group_dmproduk!==null){group_dmproduk_2excel = produk_group_DataStore.baseParams.group_dmproduk;}
		if(produk_group_DataStore.baseParams.group_durawat!==null){group_durawat_2excel = produk_group_DataStore.baseParams.group_durawat;}
		if(produk_group_DataStore.baseParams.group_dmrawat!==null){group_dmrawat_2excel = produk_group_DataStore.baseParams.group_dmrawat;}
		if(produk_group_DataStore.baseParams.group_dupaket!==null){group_dupaket_2excel = produk_group_DataStore.baseParams.group_dupaket;}
		if(produk_group_DataStore.baseParams.group_dmpaket!==null){group_dmpaket_2excel = produk_group_DataStore.baseParams.group_dmpaket;}
		if(produk_group_DataStore.baseParams.group_keterangan!==null){group_keterangan_2excel = produk_group_DataStore.baseParams.group_keterangan;}
		if(produk_group_DataStore.baseParams.group_aktif!==null){group_aktif_2excel = produk_group_DataStore.baseParams.group_aktif;}
		if(produk_group_DataStore.baseParams.group_aktif!==null){group_kredit_2excel = produk_group_DataStore.baseParams.group_kredit;}		
		if(produk_group_DataStore.baseParams.group_dultah!==null){group_dultah_2excel = produk_group_DataStore.baseParams.group_dultah;}
		if(produk_group_DataStore.baseParams.group_dcard!==null){group_dcard_2excel = produk_group_DataStore.baseParams.group_dcard;}
		if(produk_group_DataStore.baseParams.group_dkolega!==null){group_dkolega_2excel = produk_group_DataStore.baseParams.group_dkolega;}
		if(produk_group_DataStore.baseParams.group_dkeluarga!==null){group_dkeluarga_2excel = produk_group_DataStore.baseParams.group_dkeluarga;}
		if(produk_group_DataStore.baseParams.group_downer!==null){group_downer_2excel = produk_group_DataStore.baseParams.group_downer;}
		if(produk_group_DataStore.baseParams.group_dgrooming!==null){group_dgrooming_2excel = produk_group_DataStore.baseParams.group_dgrooming;}

		if(produk_group_DataStore.baseParams.group_dwartawan!==null){group_dwartawan_2excel = produk_group_DataStore.baseParams.group_dwartawan;}
		if(produk_group_DataStore.baseParams.group_dstaffdokter!==null){group_dstaffdokter_2excel = produk_group_DataStore.baseParams.group_dstaffdokter;}
		if(produk_group_DataStore.baseParams.group_dstaffnondokter!==null){group_dstaffnondokter_2excel = produk_group_DataStore.baseParams.group_dstaffnondokter;}
		if(produk_group_DataStore.baseParams.group_dpromo!==null){group_dpromo_2excel = produk_group_DataStore.baseParams.group_dpromo;}
	
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_produk_group&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			group_kode : group_kode_2excel,
			group_nama : group_nama_2excel,
			group_duproduk : group_duproduk_2excel,
			group_dmproduk : group_dmproduk_2excel,
			group_durawat : group_durawat_2excel,
			group_dmrawat : group_dmrawat_2excel,
			group_dupaket : group_dupaket_2excel,
			group_dmpaket : group_dmpaket_2excel,
			group_keterangan : group_keterangan_2excel,
			group_aktif : group_aktif_2excel,
			group_kredit		: group_kredit_2excel,
			group_dultah	: group_dultah_2excel,
			group_dcard		: group_dcard_2excel,
			group_dkolega	: group_dkolega_2excel,
			group_dkeluarga	: group_dkeluarga_2excel,
			group_downer	: group_downer_2excel,
			group_dgrooming : group_dgrooming_2excel,
			group_dwartawan	: group_dwartawan_2excel,
			group_dstaffdokter : group_dstaffdokter_2excel,
			group_dstaffnondokter	: group_dstaffnondokter_2excel,
			group_dpromo	: group_dpromo_2excel,
		  	currentlisting: produk_group_DataStore.baseParams.task // this tells us if we are searching or not
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
					msg: 'Tidak bisa meng-export data ke dalam format excel',
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
	
	/* EVENTS by fred */
	group_duprodukField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dmprodukField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_durawatField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dmrawatField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dupaketField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dmpaketField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dultahField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dcardField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dkolegaField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dkeluargaField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_downerField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dgroomingField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dwartawanField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dstaffdokterField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	group_dstaffnondokterField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dpromoField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_kredit_produkField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	/*Event untuk search*/
	group_duprodukSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dmprodukSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_durawatSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dmrawatSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dupaketSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dmpaketSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});

	
	group_dultahSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dcardSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dkolegaSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dkeluargaSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_downerSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dgroomingSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dwartawanSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dstaffdokterSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dstaffnondokterSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_dpromoSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
	group_kredit_produkSearchField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
									  
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_produk_group"></div>
		<div id="elwindow_produk_group_create"></div>
        <div id="elwindow_produk_group_search"></div>
    </div>
</div>
</body>