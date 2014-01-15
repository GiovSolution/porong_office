<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: master_retur_jual_paket View
	+ Description	: For record view
	+ Filename 		: v_master_retur_jual_paket.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 14:53:56
	
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
var master_retur_jual_paket_DataStore;
var master_retur_jual_paket_ColumnModel;
var master_retur_jual_paketListEditorGrid;
var master_retur_jual_paket_createForm;
var master_retur_jual_paket_createWindow;
var master_retur_jual_paket_searchForm;
var master_retur_jual_paket_searchWindow;
var master_retur_jual_paket_SelectedRow;
var master_retur_jual_paket_ContextMenu;
//for detail data
var detail_retur_paket_rawat_DataStor;
var drpaketListEditorGrid;
var drpaket_tokwitansiColumnModel;
var detail_retur_paket_rawat_proxy;
var detail_retur_paket_tokwitansi_writer;
var drpaket_reader;
var editor_detail_retur_paket_tokwitansi;

var dt= new Date();

//declare konstant
var rpaket_post2db = '';
var msg = '';
var rpaket_pageS=15;
var today=new Date().format('d-m-Y');

/* declare variable here for Field*/
var rpaket_idField;
var rpaket_nobuktiField;
var rpaket_nobuktijualField;
var rpaket_custField;
var rpaket_tanggalField;
var rpaket_keteranganField;
var rpaket_stat_dokField;
var rpaket_idSearchField;
var rpaket_nobuktiSearchField;
var rpaket_nobuktijualSearchField;
var rpaket_custSearchField;
var rpaket_tanggalSearchField;
var rpaket_tanggal_akhirSearchField;
var rpaket_keteranganSearchField;
var rpaket_stat_dokSearchField;

var rpaket_cetak_kuitansi = 0;

function retur_jpaket_cetak(kwitansi_ref){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_retur_jual_paket&m=print_paper',
		params: { kwitansi_ref : kwitansi_ref}, 
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Cetak Kwitansi Retur Produk','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
				//
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

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
	Ext.util.Format.comboRenderer = function(combo){
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
	
	// define a custom summary function
    Ext.ux.grid.GroupSummary.Calculations['totalCost'] = function(v, record, field){
        return v + (record.data.estimate * record.data.rate);
    };

	// utilize custom extension for Group Summary
    var summary = new Ext.ux.grid.GroupSummary();
  
 
	/*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var rpaket_tanggal_create_date = "";
	
		if(rpaket_tanggalField.getValue()!== ""){rpaket_tanggal_create_date = rpaket_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_jual_paket&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: rpaket_tanggal_create_date
		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							master_retur_jual_paket_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Retur Penjualan Paket tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
				   msg: 'Could not connect to the database. retry later.',
				   buttons: Ext.MessageBox.OK,
				   animEl: 'database',
				   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  

  	/* Function for Saving inLine Editing */
	function master_retur_jual_paket_update(oGrid_event){
		var rpaket_id_update_pk="";
		var rpaket_nobukti_update=null;
		var rpaket_nobuktijual_update=null;
		var rpaket_cust_update=null;
		var rpaket_tanggal_update_date="";
		var rpaket_keterangan_update=null;
		var rpaket_stat_dok_update=null;

		rpaket_id_update_pk = oGrid_event.record.data.rpaket_id;
		if(oGrid_event.record.data.rpaket_nobukti!== null){rpaket_nobukti_update = oGrid_event.record.data.rpaket_nobukti;}
		if(oGrid_event.record.data.rpaket_nobuktijual!== null){rpaket_nobuktijual_update = oGrid_event.record.data.rpaket_nobuktijual;}
		if(oGrid_event.record.data.rpaket_cust!== null){rpaket_cust_update = oGrid_event.record.data.rpaket_cust;}
	 	if(oGrid_event.record.data.rpaket_tanggal!== ""){rpaket_tanggal_update_date =oGrid_event.record.data.rpaket_tanggal.format('Y-m-d');}
		if(oGrid_event.record.data.rpaket_keterangan!== null){rpaket_keterangan_update = oGrid_event.record.data.rpaket_keterangan;}
		if(oGrid_event.record.data.rpaket_stat_dok!== null){rpaket_stat_dok_update = oGrid_event.record.data.rpaket_stat_dok;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_jual_paket&m=get_action',
			params: {
				task: "UPDATE",
				rpaket_id	: rpaket_id_update_pk, 
				rpaket_nobukti	:rpaket_nobukti_update,  
				rpaket_nobuktijual	:rpaket_nobuktijual_update,  
				rpaket_cust	:rpaket_cust_update,  
				rpaket_tanggal	: rpaket_tanggal_update_date, 
				rpaket_keterangan	:rpaket_keterangan_update, 
				rpaket_stat_dok		:rpaket_stat_dok_update,
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						master_retur_jual_paket_DataStore.commitChanges();
						master_retur_jual_paket_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Retur Penjualan Paket tidak bisa disimpan',
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
	function master_retur_jual_paket_create(){
	
		if(is_master_retur_jual_paket_form_valid()){
			if(rpaket_kwitansi_nilaiField.getValue()>10000){
				if(rpaket_post2db=='CREATE' && rpaket_stat_dokField.getValue()=='Terbuka'){
					var rpaket_id_create_pk=null; 
					var rpaket_nobukti_create=null; 
					var rpaket_nobuktijual_create=null; 
					var rpaket_cust_create=null; 
					var rpaket_tanggal_create_date=""; 
					var rpaket_keterangan_create=null; 
					var rpaket_stat_dok_create=null;
					var rpaket_kwitansi_nilai_create=null; 
					var rpaket_kwitansi_keterangan_create=null;
					var rpaket_voucher_nilai_create=null;
					
					
					if(rpaket_idField.getValue()!== null){rpaket_id_create_pk = rpaket_idField.getValue();}else{rpaket_id_create_pk=get_pk_id();} 
					if(rpaket_nobuktiField.getValue()!= null){rpaket_nobukti_create = rpaket_nobuktiField.getValue();} 
					if(rpaket_nobuktijualField.getValue()!= null){rpaket_nobuktijual_create = rpaket_nobuktijualField.getValue();} 
					if(rpaket_custField.getValue()!= null){rpaket_cust_create = rpaket_custidField.getValue();} 
					if(rpaket_tanggalField.getValue()!= ""){rpaket_tanggal_create_date = rpaket_tanggalField.getValue().format('Y-m-d');} 
					if(rpaket_keteranganField.getValue()!= null){rpaket_keterangan_create = rpaket_keteranganField.getValue();} 
					if(rpaket_kwitansi_nilaiField.getValue()!== null){rpaket_kwitansi_nilai_create = rpaket_kwitansi_nilaiField.getValue();} 
					if(rpaket_kwitansi_keteranganField.getValue()!== null){rpaket_kwitansi_keterangan_create = rpaket_kwitansi_keteranganField.getValue();} 
					if(rpaket_stat_dokField.getValue()!= null){rpaket_stat_dok_create = rpaket_stat_dokField.getValue();} 
					if(rpaket_voucher_nilaiField.getValue()!== null){rpaket_voucher_nilai_create = rpaket_voucher_nilaiField.getValue();} 
					
					Ext.MessageBox.show({
					   msg: 'Sedang menambahkan data, mohon tunggu...',
					   progressText: 'proses...',
					   width:350,
					   wait:true
					});
					
					Ext.Ajax.request({  
						waitMsg: 'Please wait...',
						url: 'index.php?c=c_master_retur_jual_paket&m=get_action',
						params: {
							task: rpaket_post2db,
							rpaket_id	: rpaket_id_create_pk, 
							rpaket_nobukti	: rpaket_nobukti_create, 
							rpaket_nobuktijual	: rpaket_nobuktijual_create, 
							rpaket_cust	: rpaket_cust_create, 
							rpaket_tanggal	: rpaket_tanggal_create_date, 
							rpaket_keterangan	: rpaket_keterangan_create,
							rpaket_stat_dok		: rpaket_stat_dok_create,
							rpaket_kwitansi_nilai	: rpaket_kwitansi_nilai_create, 
							rpaket_kwitansi_keterangan	: rpaket_kwitansi_keterangan_create,
							rpaket_voucher				: rpaket_voucher_nilai_create
						}, 
						success: function(response){             
							//var result=eval(response.responseText);
							var result=response.responseText;
							if(result=='0' || result=='1'){
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Data retur penjualan paket tidak bisa disimpan',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.WARNING
								});
							}else{
								retur_jpaket_cetak(result);
								detail_retur_paket_tokwitansi_insert();
								master_retur_jual_paket_DataStore.reload();
								master_retur_jual_paket_createWindow.hide();
								Ext.MessageBox.hide();
								//Ext.MessageBox.alert('Info','Retur Penjualan Paket Berhasil Disimpan');
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
				}else if(rpaket_post2db=='UPDATE' && rpaket_stat_dokField.getValue()=='Tertutup'){
					if(rpaket_cetak_kuitansi==1){
						retur_jpaket_cetak(rpaket_nobuktiField.getValue());
					}
					master_retur_jual_paket_createWindow.hide();
				}else if(rpaket_post2db=='UPDATE' && rpaket_stat_dokField.getValue()=='Batal'){
					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_master_retur_jual_paket&m=get_action',
						params: {
							task: 'BATAL',
							rpaket_id	: rpaket_idField.getValue()
						}, 
						success: function(response){             
							var result=eval(response.responseText);
							if(result==1){
								master_retur_jual_paket_DataStore.reload();
								master_retur_jual_paket_createWindow.hide();
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Dokumen Retur Paket telah di-Batalkan.',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.OK
								});
							}else{
								master_retur_jual_paket_createWindow.hide();
								Ext.MessageBox.show({
								   title: 'Warning',
								   width: 400,
								   msg: 'Dokumen Retur Paket tidak bisa dibatalkan.',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.WARNING
								});
							}
						},
						failure: function(response){
							var result=response.responseText;
							master_retur_jual_paket_createWindow.hide();
							Ext.MessageBox.show({
								   title: 'Error',
								   msg: 'Tidak bisa terhubung dengan database server',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'database',
								   icon: Ext.MessageBox.ERROR
							});
						}                      
					});
				}else{
					master_retur_jual_paket_createWindow.hide();
				}
			}else{
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Nilai Kuitansi yang di-Retur harus lebih dari Rp10.000,-.',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
			}
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
		if(rpaket_post2db=='UPDATE')
			return master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function master_retur_jual_paket_reset_form(){
		rpaket_idField.reset();
		rpaket_idField.setValue(null);
		rpaket_nobuktiField.reset();
		rpaket_nobuktiField.setValue(null);
		rpaket_nobuktiField.setValue('(Auto)');
		rpaket_nobuktijualField.reset();
		rpaket_nobuktijualField.setValue(null);
		rpaket_nobuktijualField.setDisabled(false);
		rpaket_custField.reset();
		rpaket_custField.setValue(null);
		rpaket_custField.setValue('(Auto)');
		rpaket_tanggalField.reset();
		rpaket_tanggalField.setValue(null);
		rpaket_tanggalField.setValue(dt.format('d-m-Y'));
		rpaket_keteranganField.reset();
		rpaket_keteranganField.setValue(null);
		rpaket_stat_dokField.reset();
		rpaket_stat_dokField.setValue('Terbuka');
		rpaket_kwitansi_nilaiField.reset();
		rpaket_kwitansi_nilaiField.setValue(null);
		rpaket_jpaket_total_bayarField.reset();
		rpaket_jpaket_total_bayarField.setValue(null);
		rpaket_kwitansi_nilai_cfField.reset();
		rpaket_kwitansi_nilai_cfField.setValue(null);
		rpaket_voucher_nilaicfField.reset();
		rpaket_voucher_nilaicfField.setValue(null);
		rpaket_voucher_nilaiField.reset();
		rpaket_voucher_nilaiField.setValue(null);
		cbo_dpaket_byJpaketDataStore.load({
			params: {jpaket_id: -1}
		});
		drpaketListDataStore.load({
			params: {
				master_id: -1, start:0, limit:rpaket_pageS
			}
		});
		
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		master_retur_jual_paket_createForm.save_btn.disable();
		master_retur_jual_paket_createForm.cetak_kuitansi_btn.enable();
		<?php } ?>
		drpaketListEditorGrid.setDisabled(false);
		rpaket_voucher_nilaicfField.setDisabled(false);
		//drpaketListEditorGrid.drpaket_add.enable();
		//drpaketListEditorGrid.drpaket_delete.enable();
		//combo_dpaket_byjpaket_retur.setDisabled(false);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function master_retur_jual_paket_set_form(){
		rpaket_idField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_id'));
		rpaket_nobuktiField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_nobukti'));
		rpaket_nobuktijualField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_nobuktijual'));
		rpaket_custField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_cust'));
		rpaket_custidField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_cust_id'));
		rpaket_tanggalField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_tanggal'));
		rpaket_keteranganField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_keterangan'));
		rpaket_stat_dokField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_stat_dok'));
		rpaket_voucher_nilaicfField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_voucher'));
		rpaket_kwitansi_nilaiField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
		rpaket_kwitansi_keteranganField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('kwitansi_keterangan'));
		rpaket_jpaket_total_bayarField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_bayar'));
		rpaket_nobuktijualField.setDisabled(true);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		master_retur_jual_paket_createForm.save_btn.enable();
		<?php } ?>
		
		if((master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_stat_dok')!=='Terbuka')){
			drpaketListEditorGrid.setDisabled(true);
			rpaket_voucher_nilaicfField.setDisabled(true);
			//drpaketListEditorGrid.drpaket_add.disable();
			//drpaketListEditorGrid.drpaket_delete.disable();
			//combo_dpaket_byjpaket_retur.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			master_retur_jual_paket_createForm.cetak_kuitansi_btn.disable();
			<?php } ?>
		}else{
			drpaketListEditorGrid.setDisabled(false);
			rpaket_voucher_nilaicfField.setDisabled(false);
			//drpaketListEditorGrid.drpaket_add.enable();
			//drpaketListEditorGrid.drpaket_delete.enable();
			//combo_dpaket_byjpaket_retur.setDisabled(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			master_retur_jual_paket_createForm.cetak_kuitansi_btn.enable();
			<?php } ?>
		}
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_master_retur_jual_paket_form_valid(){
		return (true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_retur_jual_paket_createWindow.isVisible()){
			rpaket_post2db='CREATE';
			master_retur_jual_paket_reset_form();
			
			msg='created';
			master_retur_jual_paket_createWindow.show();
		} else {
			master_retur_jual_paket_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_retur_jual_paket_confirm_delete(){
		// only one master_retur_jual_paket is selected here
		if(master_retur_jual_paketListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_retur_jual_paket_delete);
		} else if(master_retur_jual_paketListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_retur_jual_paket_delete);
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
	function master_retur_jual_paket_confirm_update(){
		/* only one record is selected here */
		if(master_retur_jual_paketListEditorGrid.selModel.getCount() == 1) {
			
			rpaket_post2db='UPDATE';
			master_retur_jual_paket_set_form();
			cbo_dpaket_byJpaketDataStore.load({
				params: {
					jpaket_id: master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_id'),
					mode: 'update'
				},
				callback: function(opts, success, response){
					if(success){
						drpaketListDataStore.load({
							params: {
								master_id:master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_id'), start:0, limit:rpaket_pageS
							},
							callback: function(opts, success, response){
								var total_retur_field = 0;
								for(i=0; i<drpaketListDataStore.getCount(); i++){
									total_retur_field += drpaketListDataStore.getAt(i).data.drpaket_rupiah_retur;
								}
								rpaket_kwitansi_nilai_cfField.setValue(CurrencyFormatted(total_retur_field));
								rpaket_kwitansi_nilaiField.setValue(total_retur_field);
							}
						});
					}
				}
			});
			
			msg='updated';
			master_retur_jual_paket_createWindow.show();
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
	function master_retur_jual_paket_delete(btn){
		if(btn=='yes'){
			var selections = master_retur_jual_paketListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_retur_jual_paketListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.rpaket_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_master_retur_jual_paket&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_retur_jual_paket_DataStore.reload();
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
	master_retur_jual_paket_DataStore = new Ext.data.Store({
		id: 'master_retur_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rpaket_id'
		},[
			{name: 'rpaket_id', type: 'int', mapping: 'rpaket_id'}, 
			{name: 'rpaket_nobukti', type: 'string', mapping: 'rpaket_nobukti'}, 
			{name: 'jpaket_id', type: 'int', mapping: 'jpaket_id'}, 
			{name: 'rpaket_nobuktijual', type: 'string', mapping: 'jpaket_nobukti'}, 
			{name: 'rpaket_cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'rpaket_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'rpaket_cust_id', type: 'int', mapping: 'cust_id'}, 
			{name: 'rpaket_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'rpaket_tanggal'}, 
			{name: 'rpaket_keterangan', type: 'string', mapping: 'rpaket_keterangan'}, 
			{name: 'rpaket_stat_dok', type: 'string', mapping: 'rpaket_stat_dok'}, 
			{name: 'rpaket_creator', type: 'string', mapping: 'rpaket_creator'}, 
			{name: 'rpaket_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rpaket_date_create'}, 
			{name: 'rpaket_update', type: 'string', mapping: 'rpaket_update'}, 
			{name: 'rpaket_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rpaket_date_update'}, 
			{name: 'rpaket_revised', type: 'int', mapping: 'rpaket_revised'},
			{name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'},
			{name: 'kwitansi_nilai', type: 'float', mapping: 'kwitansi_nilai'},
			{name: 'rpaket_voucher', type: 'float', mapping: 'rpaket_voucher'},
			{name: 'kwitansi_keterangan', type: 'string', mapping: 'kwitansi_keterangan'},
			{name: 'jpaket_bayar', type: 'float', mapping: 'jpaket_bayar'}
		]),
		sortInfo:{field: 'rpaket_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_retur_paket_DataStore = new Ext.data.Store({
		id: 'cbo_retur_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=get_jual_paket_list',
			method: 'POST'
		}),
		baseParams:{start: 0, limit: rpaket_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jpaket_id'
		},[
			{name: 'retur_paket_value', type: 'int', mapping: 'jpaket_id'},
			{name: 'retur_paket_display', type: 'string', mapping: 'jpaket_nobukti'},
			{name: 'retur_paket_nama_customer', type: 'string', mapping: 'cust_nama'},
			{name: 'retur_paket_customer_id', type: 'string', mapping: 'jpaket_cust'}
		]),
		sortInfo:{field: 'retur_paket_display', direction: "ASC"}
	});
	
	/*cbo_drpaketListDataStore = new Ext.data.Store({
		id: 'cbo_drpaketListDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=get_rawat_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'drpaket_rawat_value', type: 'int', mapping: 'rawat_id'},
			{name: 'drpaket_rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'drpaket_rawat_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'drpaket_rawat_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'drpaket_rawat_display', direction: "ASC"}
	});
	var rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{drpaket_rawat_kode}| <b>{drpaket_rawat_display}</b>',
		'</div></tpl>'
    );*/
	
	cbo_dpaket_byJpaketDataStore = new Ext.data.Store({
		id: 'cbo_dpaket_byJpaketDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=get_dpaket_byjpaket_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dpaket_id'
		},[
			{name: 'dpaket_id', type: 'int', mapping: 'dpaket_id'},
			{name: 'dpaket_paket', type: 'int', mapping: 'dpaket_paket'},
			{name: 'dpaket_paket_nama', type: 'string', mapping: 'paket_nama'},
			{name: 'dpaket_total_ambil', type: 'int', mapping: 'total_ambil_paket'},
			{name: 'dpaket_total_sisa', type: 'int', mapping: 'total_sisa_paket'},
			{name: 'dpaket_harga_per_satu', type: 'float', mapping: 'harga_per_satu'},
			{name: 'dpaket_rupiah_retur', type: 'float', mapping: 'rupiah_retur'},
			{name: 'voucher', type: 'float', mapping: 'voucher'}
		]),
		sortInfo:{field: 'dpaket_paket_nama', direction: "ASC"}
	});
	var dpaket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{dpaket_paket_nama}</b><br/>| Rupiah di-Retur: {dpaket_rupiah_retur}</span>',
		'</div></tpl>'
    );
	
	cbo_dretur_rawatDataStore = new Ext.data.Store({
		id: 'cbo_dretur_rawatDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=get_retur_rawat_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'dretur_rawat_value', type: 'int', mapping: 'rawat_id'},
			{name: 'dretur_rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'dretur_rawat_harga', type: 'string', mapping: 'rawat_harga'},
			{name: 'dretur_rawat_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'dretur_rawat_display', direction: "ASC"}
	});
	var retur_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dretur_rawat_kode}| <b>{dretur_rawat_display}</b> | Rp.{dretur_rawat_harga}',
		'</div></tpl>'
    );
	
	//ComboBox ambil data Customer
	cbo_rpaket_customerDataStore = new Ext.data.Store({
		id: 'cbo_rpaket_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:rpaket_pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var customer_rpaket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
    
  	/* Function for Identify of Window Column Model */
	master_retur_jual_paket_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'rpaket_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'rpaket_tanggal',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		}, 
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'rpaket_nobukti',
			width: 100,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'No Faktur Jual' + '</div>',
			dataIndex: 'rpaket_nobuktijual',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'rpaket_cust_no',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'rpaket_cust',
			width: 200,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Nilai Kuitansi (Rp)' + '</div>',
			dataIndex: 'kwitansi_nilai',
			align: 'right',
			width: 100,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span> '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'rpaket_keterangan',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		}, 
		
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'rpaket_stat_dok',
			width: 60
		}, 
		
		{
			header: 'Creator',
			dataIndex: 'rpaket_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'rpaket_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Lat Update by',
			dataIndex: 'rpaket_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'rpaket_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'rpaket_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	master_retur_jual_paket_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_retur_jual_paketListEditorGrid =  new Ext.grid.GridPanel({
		id: 'master_retur_jual_paketListEditorGrid',
		el: 'fp_master_retur_jual_paket',
		title: 'Daftar Retur Penjualan Paket',
		autoHeight: true,
		store: master_retur_jual_paket_DataStore, // DataStore
		cm: master_retur_jual_paket_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		trackMouseOver: false,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: rpaket_pageS,
			store: master_retur_jual_paket_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_retur_jual_paket_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_retur_jual_paket_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_retur_jual_paket_DataStore,
			params: {task: 'LIST',start: 0, limit: rpaket_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_retur_jual_paket_DataStore.baseParams={task:'LIST',start: 0, limit: rpaket_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Faktur<br>- No Faktur Jual<br>- Nama Customer<br>- No Customer'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_retur_jual_paket_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_retur_jual_paket_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_retur_jual_paket_print  
		}
		]
	});
	master_retur_jual_paketListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_retur_jual_paket_ContextMenu = new Ext.menu.Menu({
		id: 'master_retur_jual_paket_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_retur_jual_paket_editContextMenu 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled : true,
			handler: master_retur_jual_paket_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_retur_jual_paket_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_retur_jual_paket_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_retur_jual_paket_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_retur_jual_paket_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_retur_jual_paket_SelectedRow=rowIndex;
		master_retur_jual_paket_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_retur_jual_paket_editContextMenu(){
		master_retur_jual_paketListEditorGrid.startEditing(master_retur_jual_paket_SelectedRow,1);
  	}
	/* End of Function */
  	
	master_retur_jual_paketListEditorGrid.addListener('rowcontextmenu', onmaster_retur_jual_paket_ListEditGridContextMenu);
	master_retur_jual_paket_DataStore.load({params: {start: 0, limit: rpaket_pageS}});	// load DataStore
	master_retur_jual_paketListEditorGrid.on('afteredit', master_retur_jual_paket_update); // inLine Editing Record
	
	var retur_jual_paket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{retur_paket_display}</b> | Tgl-Retur:{retur_paket_tanggal:date("M j, Y")}<br /></span>',
            'Customer: {retur_paket_nama_customer}&nbsp;&nbsp;&nbsp;[Alamat: {retur_paket_alamat}]',
        '</div></tpl>'
    );
	
	/* Identify  rpaket_id Field */
	rpaket_idField= new Ext.form.NumberField({
		id: 'rpaket_idField',
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
	/* Identify  rpaket_nobukti Field */
	rpaket_nobuktiField= new Ext.form.TextField({
		id: 'rpaket_nobuktiField',
		fieldLabel: 'No. Faktur',
		maxLength: 100,
		readOnly: true,
		emptyText: '(Auto)',
		anchor: '95%'
	});
	/* Identify  rpaket_nobuktijual Field */
	rpaket_nobuktijualField= new Ext.form.ComboBox({
		id: 'rpaket_nobuktijualField',
		fieldLabel: 'No. Faktur Jual',
		store: cbo_retur_paket_DataStore,
		mode: 'remote',
		displayField:'retur_paket_display',
		valueField: 'retur_paket_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: retur_jual_paket_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		queryDelay:750,
		//listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  rpaket_cust Field */
	rpaket_custField= new Ext.form.TextField({
		id: 'rpaket_custField',
		fieldLabel: 'Customer',
		maxLength: 100,
		emptyText: '(Auto)',
		readOnly : true,
		anchor: '95%'
	});
	rpaket_custidField=new Ext.form.NumberField();
	/* Identify  rpaket_tanggal Field */
	rpaket_tanggalField= new Ext.form.DateField({
		id: 'rpaket_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
	});
	/* Identify  rpaket_keterangan Field */
	rpaket_keteranganField= new Ext.form.TextArea({
		id: 'rpaket_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
	
	/* Identify rpaket_stat_dok Field */
	rpaket_stat_dokField= new Ext.form.ComboBox({
		id: 'rpaket_stat_dokField',
		fieldLabel: 'Status Dok',
		store:new Ext.data.SimpleStore({
			fields:['rpaket_stat_dok_value', 'rpaket_stat_dok_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'rpaket_stat_dok_display',
		valueField: 'rpaket_stat_dok_value',
		width: 98,
		allowBlank: false,
		editable: false,
		triggerAction: 'all'	
	});
	rpaket_stat_dokField.on("select",function(){
		var status_awal = master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_stat_dok');
		if(status_awal =='Terbuka' && rpaket_stat_dokField.getValue()=='Tertutup'){
			Ext.MessageBox.show({
				msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			   //progressText: 'proses...',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			rpaket_stat_dokField.setValue('Terbuka');
		}else if(status_awal =='Tertutup' && rpaket_stat_dokField.getValue()=='Terbuka'){
			Ext.MessageBox.show({
				msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			rpaket_stat_dokField.setValue('Tertutup');
		}else if(status_awal =='Batal' && rpaket_stat_dokField.getValue()=='Terbuka'){
			Ext.MessageBox.show({
				msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			rpaket_stat_dokField.setValue('Tertutup');
		}else if(rpaket_stat_dokField.getValue()=='Batal'){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', rpaket_status_batal);
		}else if(status_awal =='Tertutup' && rpaket_stat_dokField.getValue()=='Tertutup'){
            //master_retur_jual_paket_createForm.jproduk_savePrint.enable();
        }
		
	});
	function rpaket_status_batal(btn){
		if(btn=='yes'){
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			master_retur_jual_paket_createForm.cetak_kuitansi_btn.disable();
			<?php } ?>
			rpaket_stat_dokField.setValue('Batal');
			//master_jual_produk_createForm.jproduk_savePrint.disable();
		}else{
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			master_retur_jual_paket_createForm.cetak_kuitansi_btn.enable();
			<?php } ?> 
			rpaket_stat_dokField.setValue(master_retur_jual_paketListEditorGrid.getSelectionModel().getSelected().get('rpaket_stat_dok'));
		}
	}
	
	rpaket_voucher_nilaicfField= new Ext.form.TextField({
		id: 'rpaket_voucher_nilaicfField',
		fieldLabel: 'Nilai Voucher (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		//readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	rpaket_voucher_nilaiField= new Ext.form.NumberField({
		id: 'rpaket_voucher_nilaiField',
		fieldLabel: 'Nilai Voucher (Rp)',
		//valueRenderer: 'numberToCurrency',
		//allowNegatife : false,
		//blankText: '0',
		//allowDecimals: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	rpaket_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'rpaket_kwitansi_nilai_cfField',
		fieldLabel: 'Nilai Kuitansi (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	rpaket_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'rpaket_kwitansi_nilaiField',
		fieldLabel: 'Nilai Kuitansi (Rp)',
		//valueRenderer: 'numberToCurrency',
		//allowNegatife : false,
		//blankText: '0',
		//allowDecimals: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	rpaket_kwitansi_keteranganField= new Ext.form.TextArea({
		id: 'rpaket_kwitansi_keteranganField',
		fieldLabel: 'Keterangan Kuitansi',
		maxLength: 250,
		anchor: '95%'
	});
	
	/*rpaket_jpaket_total_bayarField= new Ext.ux.form.CFTextField({
		id: 'rpaket_jpaket_total_bayarField',
		fieldLabel: 'No.Faktur Jual - Total Bayar',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		anchor: '95%'
	});*/
	rpaket_jpaket_total_bayarField= new Ext.form.NumberField({
		id: 'rpaket_jpaket_total_bayarField',
		fieldLabel: 'No.Faktur Jual - Total Bayar',
		//valueRenderer: 'numberToCurrency',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	rpaket_nobuktijualField.on('select', function(){
		var j=cbo_retur_paket_DataStore.findExact('retur_paket_value',rpaket_nobuktijualField.getValue());
		if(cbo_retur_paket_DataStore.getCount()){
			rpaket_custField.setValue(cbo_retur_paket_DataStore.getAt(j).data.retur_paket_nama_customer);
			rpaket_custidField.setValue(cbo_retur_paket_DataStore.getAt(j).data.retur_paket_customer_id);
			//rpaket_jpaket_total_bayarField.setValue(cbo_retur_paket_DataStore.getAt(j).data.jpaket_total_bayar);
			//rpaket_kwitansi_nilaiField.setValue(cbo_retur_paket_DataStore.getAt(j).data.jpaket_total_retur);
			//cbo_drpaketListDataStore.load({params:{query: rpaket_nobuktijualField.getValue()}});
			cbo_dpaket_byJpaketDataStore.reload({
				params: {
					jpaket_id: -1
				},
				callback: function(opts, success, response){
					if(success){
						drpaketListEditorGrid.getStore().removeAll();
						cbo_dpaket_byJpaketDataStore.reload({
							params: {
								jpaket_id: rpaket_nobuktijualField.getValue(),
								mode: 'create'
							}
						});
					}
				}
			});
		}
	});
	
  	/*Fieldset Master*/
	master_retur_jual_paket_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpaket_nobuktiField, rpaket_nobuktijualField, rpaket_custField/*, rpaket_jpaket_total_bayarField*/] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpaket_tanggalField, rpaket_keteranganField, rpaket_stat_dokField, rpaket_idField] 
			}
			]
	
	});
	
		
	/*Detail Declaration */
	/* START Detail Retur to Kwitansi */
	// Function for json reader of detail
	var drpaket_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'drpaket_dpaket'
	},[
		{name: 'drpaket_id', type: 'int', mapping: 'drpaket_id'},
		{name: 'drpaket_dpaket', type: 'int', mapping: 'drpaket_dpaket'},
		{name: 'drpaket_paket', type: 'int', mapping: 'drpaket_paket'},
		{name: 'drpaket_paket_nama', type: 'string', mapping: 'paket_nama'},
		{name: 'drpaket_jumlah_terambil', type: 'int', mapping: 'drpaket_jumlah_terambil'},
		{name: 'drpaket_jumlah_diretur', type: 'int', mapping: 'drpaket_jumlah_diretur'},
		{name: 'drpaket_harga_satu', type: 'float', mapping: 'drpaket_harga_satu'}, 
		{name: 'drpaket_rupiah_retur', type: 'float', mapping: 'drpaket_rupiah_retur'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_retur_paket_tokwitansi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	drpaketListDataStore = new Ext.data.Store({
		id: 'drpaketListDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_paket&m=drpaket_tokwitansi_list', 
			method: 'POST'
		}),
		reader: drpaket_reader,
		//baseParams:{master_id: rpaket_idField.getValue(), start:0, limit:rpaket_pageS},
		sortInfo:{field: 'drpaket_paket_nama', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_retur_paket_tokwitansi= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				var total_retur = 0;
				var voucher = rpaket_voucher_nilaiField.getValue();
				for(i=0; i<drpaketListEditorGrid.getStore().getCount(); i++){
					total_retur += drpaketListEditorGrid.getStore().getAt(i).data.drpaket_rupiah_retur;
				}
				rpaket_kwitansi_nilaiField.setValue(total_retur-voucher);
				rpaket_kwitansi_nilai_cfField.setValue(CurrencyFormatted(total_retur-voucher));
				
			}
		}
    });
	//eof
	
	var dpaket_total_ambilField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dpaket_total_sisaField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dpaket_paketField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dpaket_harga_per_satuField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dpaket_rupiah_returField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var combo_dpaket_byjpaket_retur=new Ext.form.ComboBox({
		store: cbo_dpaket_byJpaketDataStore,
		mode: 'local',
		displayField: 'dpaket_paket_nama',
		valueField: 'dpaket_id',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:rpaket_pageS,
		hideTrigger:false,
		tpl: dpaket_tpl,
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	combo_dpaket_byjpaket_retur.on('select', function(){
		var s = drpaketListEditorGrid.getSelectionModel().getSelections();
		var r = s[0];
		for(i=0; i<drpaketListDataStore.getCount(); i++){
			var drpaket_dpaket = drpaketListDataStore.getAt(i).data.drpaket_dpaket;
			if(combo_dpaket_byjpaket_retur.getValue()==drpaket_dpaket){
				drpaketListDataStore.remove(r);
			}
		}
		var j=cbo_dpaket_byJpaketDataStore.findExact('dpaket_id',combo_dpaket_byjpaket_retur.getValue(),0);
		if(cbo_dpaket_byJpaketDataStore.getCount()){
			dpaket_total_ambilField.setValue(cbo_dpaket_byJpaketDataStore.getAt(j).data.dpaket_total_ambil);
			dpaket_total_sisaField.setValue(cbo_dpaket_byJpaketDataStore.getAt(j).data.dpaket_total_sisa);
			dpaket_harga_per_satuField.setValue(cbo_dpaket_byJpaketDataStore.getAt(j).data.dpaket_harga_per_satu);
			dpaket_rupiah_returField.setValue(cbo_dpaket_byJpaketDataStore.getAt(j).data.dpaket_rupiah_retur);
			dpaket_paketField.setValue(cbo_dpaket_byJpaketDataStore.getAt(j).data.dpaket_paket);
			rpaket_voucher_nilaicfField.setValue(CurrencyFormatted(cbo_dpaket_byJpaketDataStore.getAt(j).data.voucher));
			rpaket_voucher_nilaiField.setValue(cbo_dpaket_byJpaketDataStore.getAt(j).data.voucher);
			
		}
	});
	
	//declaration of detail coloumn model
	drpaket_tokwitansiColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Paket' + '</div>',
			dataIndex: 'drpaket_dpaket',
			width: 335,
			sortable: false,
			editor: combo_dpaket_byjpaket_retur,
			renderer: Ext.util.Format.comboRenderer(combo_dpaket_byjpaket_retur)
		},
		{
			header: '<div align="center">' + 'Jml Diambil' + '</div>',
			dataIndex: 'drpaket_jumlah_terambil',
			align: 'Right',
			width: 80,
			sortable: false,
			editor: dpaket_total_ambilField
		},
		{
			header: '<div align="center">' + 'Harga Satuan' + '</div>',
			dataIndex: 'drpaket_harga_satu',
			align: 'Right',
			width: 140,
			sortable: false,
			editor: dpaket_harga_per_satuField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">' + 'Jml Diretur' + '</div>',
			dataIndex: 'drpaket_jumlah_diretur',
			align: 'Right',
			width: 80,
			sortable: false,
			hidden: false,
			editor: dpaket_total_sisaField
		},
		{
			header: '<div align="center">' + 'Rupiah Diretur' + '</div>',
			dataIndex: 'drpaket_rupiah_retur',
			align: 'Right',
			width: 140,
			sortable: false,
			editor: dpaket_rupiah_returField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: 'Paket ID',
			dataIndex: 'drpaket_paket',
			width: 80,
			sortable: false,
			hidden: false,
			editor: dpaket_paketField
		}]
	);
	drpaket_tokwitansiColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	drpaketListEditorGrid =  new Ext.grid.GridPanel({
		id: 'drpaketListEditorGrid',
		el: 'fp_drpaket',
		title: 'Detail Paket yang Diretur',
		height: 250,
		width: 790,
		autoScroll: false,
		store: drpaketListDataStore, // DataStore
		colModel: drpaket_tokwitansiColumnModel, // Nama-nama Columns
		enableColLock:true,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_retur_paket_tokwitansi],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		/*bbar: new Ext.PagingToolbar({
			pageSize: rpaket_pageS,
			store: drpaketListDataStore,
			displayInfo: true
		}),*/
		/* Add Control on ToolBar */
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref: '../drpaket_add',
			handler: detail_retur_paket_tokwitansi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref: '../drpaket_delete',
			handler: detail_retur_paket_tokwitansi_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function detail_retur_paket_tokwitansi_add(){
		var edit_detail_retur_paket_tokwitansi= new drpaketListEditorGrid.store.recordType({
			drpaket_id	:0,
			drpaket_dpaket	:'',
			drpaket_jumlah_terambil	:'',		
			drpaket_harga_satu	:'',
			drpaket_rupiah_retur	:'',
			drpaket_jumlah_diretur	:'',
			drpaket_paket	:''
		});
		editor_detail_retur_paket_tokwitansi.stopEditing();
		drpaketListDataStore.insert(0, edit_detail_retur_paket_tokwitansi);
		drpaketListEditorGrid.getView().refresh();
		drpaketListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_retur_paket_tokwitansi.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_detail_retur_paket_tokwitansi(){
		/*var sum_subtotal_detail=0;
		//drpaketListDataStore.commitChanges();
		drpaketListEditorGrid.getView().refresh();
		detail_retur_tokwitansi_record=drpaketListDataStore.getAt(0);
		if(drpaketListDataStore.getCount()>=0){
			var drtokwitansi = cbo_drpaketListDataStore.findExact('drpaket_rawat_value',detail_retur_tokwitansi_record.data.drpaket_rawat,0);
			if(drtokwitansi>=0){
				detail_retur_tokwitansi_record.data.drpaket_harga=cbo_drpaketListDataStore.getAt(drtokwitansi).data.drpaket_rawat_harga;
				
				for(i=0;i<drpaketListDataStore.getCount();i++){
					sum_subtotal_detail+=(drpaketListDataStore.getAt(i).data.drpaket_jumlah*cbo_drpaketListDataStore.getAt(drtokwitansi).data.drpaket_rawat_harga);
					rpaket_kwitansi_nilaiField.setValue(sum_subtotal_detail);
				}
			}
		}*/
		var sum_subtotal_detail=0;
		var total_nilai_kuitansi=0;
		if(drpaketListDataStore.getCount()>0){
			for(i=0;i<drpaketListDataStore.getCount();i++){
				sum_subtotal_detail += ((drpaketListDataStore.getAt(i).data.total_ambil_item)*(drpaketListDataStore.getAt(i).data.rawat_harga));
			}
			total_nilai_kuitansi = rpaket_jpaket_total_bayarField.getValue()-sum_subtotal_detail;
			rpaket_kwitansi_nilaiField.setValue(total_nilai_kuitansi);
		}
	}
	//eof
	
	//function for insert detail
	function detail_retur_paket_tokwitansi_insert(){
		/*Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_jual_paket&m=detail_retur_paket_tokwitansi_insert',
			params:{
				drpaket_master	: eval(rpaket_idField.getValue())
			}
		});*/
		var drpaket_id=[];
		var drpaket_dpaket=[];
		var drpaket_paket=[];
		var drpaket_jumlah_terambil=[];
		var drpaket_harga_satu=[];
		var drpaket_jumlah_diretur=[];
		var drpaket_rupiah_retur=[];
		
		var dcount = drpaketListDataStore.getCount() - 1;
		
		if(drpaketListDataStore.getCount()>0){
			for(i=0;i<drpaketListDataStore.getCount();i++){
				if((/^\d+$/.test(drpaketListDataStore.getAt(i).data.drpaket_dpaket))
				   && drpaketListDataStore.getAt(i).data.drpaket_dpaket!==undefined
				   && drpaketListDataStore.getAt(i).data.drpaket_dpaket!==''
				   && drpaketListDataStore.getAt(i).data.drpaket_dpaket!==0){
					drpaket_id.push(drpaketListDataStore.getAt(i).data.drpaket_id);
					
					drpaket_dpaket.push(drpaketListDataStore.getAt(i).data.drpaket_dpaket);
					if(drpaketListDataStore.getAt(i).data.drpaket_paket==undefined){
						drpaket_paket.push('');
					}else{
						drpaket_paket.push(drpaketListDataStore.getAt(i).data.drpaket_paket);
					}
					
					if(drpaketListDataStore.getAt(i).data.drpaket_jumlah_terambil==undefined){
						drpaket_jumlah_terambil.push('');
					}else{
						drpaket_jumlah_terambil.push(drpaketListDataStore.getAt(i).data.drpaket_jumlah_terambil);
					}
					
					if(drpaketListDataStore.getAt(i).data.drpaket_harga_satu==undefined){
						drpaket_harga_satu.push('');
					}else{
						drpaket_harga_satu.push(drpaketListDataStore.getAt(i).data.drpaket_harga_satu);
					}
					
					if(drpaketListDataStore.getAt(i).data.drpaket_jumlah_diretur==undefined){
						drpaket_jumlah_diretur.push('');
					}else{
						drpaket_jumlah_diretur.push(drpaketListDataStore.getAt(i).data.drpaket_jumlah_diretur);
					}
					
					if(drpaketListDataStore.getAt(i).data.drpaket_rupiah_retur==undefined){
						drpaket_rupiah_retur.push('');
					}else{
						drpaket_rupiah_retur.push(drpaketListDataStore.getAt(i).data.drpaket_rupiah_retur);
					}
				}
				
				if(i==dcount){
					var encoded_array_drpaket_id = Ext.encode(drpaket_id);
					var encoded_array_drpaket_dpaket = Ext.encode(drpaket_dpaket);
					var encoded_array_drpaket_paket = Ext.encode(drpaket_paket);
					var encoded_array_drpaket_jumlah_terambil = Ext.encode(drpaket_jumlah_terambil);
					var encoded_array_drpaket_harga_satu = Ext.encode(drpaket_harga_satu);
					var encoded_array_drpaket_jumlah_diretur = Ext.encode(drpaket_jumlah_diretur);
					var encoded_array_drpaket_rupiah_retur = Ext.encode(drpaket_rupiah_retur);
					
					Ext.Ajax.request({
						waitMsg: 'Please wait...',
						url: 'index.php?c=c_master_retur_jual_paket&m=detail_retur_paket_tokwitansi_insert',
						params:{
							drpaket_id 	: encoded_array_drpaket_id,
							drpaket_master 	: rpaket_idField.getValue(),
							drpaket_jpaket	: rpaket_nobuktijualField.getValue(),
							drpaket_cust 	: rpaket_custidField.getValue(),
							drpaket_dpaket  : encoded_array_drpaket_dpaket,
							drpaket_paket	: encoded_array_drpaket_paket,
							drpaket_jumlah_terambil	: encoded_array_drpaket_jumlah_terambil,
							drpaket_harga_satu	: encoded_array_drpaket_harga_satu,
							drpaket_jumlah_diretur	: encoded_array_drpaket_jumlah_diretur,
							drpaket_rupiah_retur	: encoded_array_drpaket_rupiah_retur,
							drpaket_tanggal	: rpaket_tanggalField.getValue().format('Y-m-d')
						}
					});
				}
			}
		}
	}
	//eof
	
	//function for purge detail
	function detail_retur_paket_tokwitansi_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_jual_paket&m=detail_retur_paket_tokwitansi_purge',
			params:{ master_id: eval(rpaket_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					detail_retur_paket_tokwitansi_insert();
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_retur_paket_tokwitansi_confirm_delete(){
		// only one record is selected here
		if(drpaketListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_retur_paket_tokwitansi_delete);
		} else if(drpaketListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_retur_paket_tokwitansi_delete);
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
	function detail_retur_paket_tokwitansi_delete(btn){
		if(btn=='yes'){
			var s = drpaketListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				drpaketListDataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	//drpaketListDataStore.on('update', refresh_detail_retur_paket_tokwitansi);
	//drpaketListDataStore.on('load', refresh_detail_retur_paket_tokwitansi);
	
	kwitansi_tercetakGroup = new Ext.form.FieldSet({
		title: 'Kuitansi Tercetak',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpaket_voucher_nilaicfField, rpaket_kwitansi_nilai_cfField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpaket_kwitansi_keteranganField] 
			}
			]
	
	});
	/* END Detail Retur to Kwitansi */
	
	/* Function for retrieve create Window Panel*/ 
	master_retur_jual_paket_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,        
		items: [master_retur_jual_paket_masterGroup,drpaketListEditorGrid,kwitansi_tercetakGroup]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPAKET'))){ ?>
			{
				text: 'Cetak Kuitansi',
				ref: '../cetak_kuitansi_btn',
				handler: rpaket_save_and_cetak
			},{
				text: 'Save',
				ref: '../save_btn',
				handler: rpaket_save
			},
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_retur_jual_paket_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_retur_jual_paket_createWindow= new Ext.Window({
		id: 'master_retur_jual_paket_createWindow',
		title: rpaket_post2db+'Retur Penjualan Paket',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_retur_jual_paket_create',
		items: master_retur_jual_paket_createForm
	});
	/* End Window */
	
	function rpaket_save_and_cetak(){
		rpaket_cetak_kuitansi = 1;
		master_retur_jual_paket_create();
	}
	
	function rpaket_save(){
		rpaket_cetak_kuitansi = 0;
		pengecekan_dokumen();
	}
	
	/* Function for action list search */
	function master_retur_jual_paket_list_search(){
		// render according to a SQL date format.
		var rpaket_nobukti_search=null;
		var rpaket_nobuktijual_search=null;
		var rpaket_cust_search=null;
		var rpaket_tanggal_search_date="";
		var rpaket_tanggal_akhir_search_date="";
		var rpaket_keterangan_search=null;
		var rpaket_stat_dok_search=null;

		if(rpaket_nobuktiSearchField.getValue()!==null){rpaket_nobukti_search=rpaket_nobuktiSearchField.getValue();}
		if(rpaket_nobuktijualSearchField.getValue()!==null){rpaket_nobuktijual_search=rpaket_nobuktijualSearchField.getValue();}
		if(rpaket_custSearchField.getValue()!==null){rpaket_cust_search=rpaket_custSearchField.getValue();}
		if(rpaket_tanggalSearchField.getValue()!==""){rpaket_tanggal_search_date=rpaket_tanggalSearchField.getValue().format('Y-m-d');}
		if(rpaket_tanggal_akhirSearchField.getValue()!==""){rpaket_tanggal_akhir_search_date=rpaket_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(rpaket_keteranganSearchField.getValue()!==null){rpaket_keterangan_search=rpaket_keteranganSearchField.getValue();}
		if(rpaket_stat_dokSearchField.getValue()!==null){rpaket_stat_dok_search=rpaket_stat_dokSearchField.getValue();}
		// change the store parameters
		master_retur_jual_paket_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			rpaket_nobukti	:	rpaket_nobukti_search, 
			rpaket_nobuktijual	:	rpaket_nobuktijual_search, 
			rpaket_cust	:	rpaket_cust_search, 
			rpaket_tanggal	:	rpaket_tanggal_search_date, 
			rpaket_tanggal_akhir : rpaket_tanggal_akhir_search_date,
			rpaket_keterangan	:	rpaket_keterangan_search,
			rpaket_stat_dok		:	rpaket_stat_dok_search
		};
		// Cause the datastore to do another query : 
		master_retur_jual_paket_DataStore.reload({params: {start: 0, limit: rpaket_pageS}});
	}
		
	/* Function for reset search result */
	function master_retur_jual_paket_reset_search(){
		// reset the store parameters
		master_retur_jual_paket_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		master_retur_jual_paket_DataStore.reload({params: {start: 0, limit: rpaket_pageS}});
		//master_retur_jual_paket_searchWindow.close();
	};
	/* End of Fuction */
	
	function master_retur_jual_paket_reset_SearchForm(){
		rpaket_nobuktiSearchField.reset();
		rpaket_nobuktijualSearchField.reset();
		rpaket_custSearchField.reset();
		rpaket_tanggalSearchField.reset();
		rpaket_tanggal_akhirSearchField.reset();
		rpaket_tanggal_akhirSearchField.setValue(today);
		rpaket_keteranganSearchField.reset();
		rpaket_stat_dokSearchField.reset();
	}
	
	
	/* Field for search */
	/* Identify  rpaket_id Search Field */
	rpaket_idSearchField= new Ext.form.NumberField({
		id: 'rpaket_idSearchField',
		fieldLabel: 'Rpaket Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  rpaket_nobukti Search Field */
	rpaket_nobuktiSearchField= new Ext.form.TextField({
		id: 'rpaket_nobuktiSearchField',
		fieldLabel: 'No. Faktur',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  rpaket_nobuktijual Search Field */
	rpaket_nobuktijualSearchField= new Ext.form.TextField({
		id: 'rpaket_nobuktijualSearchField',
		fieldLabel: 'No. Faktur Jual',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  rpaket_cust Search Field */
	rpaket_custSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_rpaket_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
		tpl: customer_rpaket_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '95%'
	});
	
	/* Identify  rpaket_tanggal Search Field */
	rpaket_tanggalSearchField= new Ext.form.DateField({
		id: 'rpaket_tanggalSearchField',
		fieldLabel: 'Rpaket Tanggal',
		format : 'Y-m-d',
	
	});
	/* Identify  rpaket_keterangan Search Field */
	rpaket_keteranganSearchField= new Ext.form.TextField({
		id: 'rpaket_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
    
	
	rpaket_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'rpaket_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	});
	
	rpaket_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });
    
	
	rpaket_tanggalSearchFieldSet=new Ext.form.FieldSet({
		id:'rpaket_tanggalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[rpaket_tanggalSearchField, rpaket_label_tanggalField, rpaket_tanggal_akhirSearchField]
	});
	
	
	rpaket_stat_dokSearchField= new Ext.form.ComboBox({
		id: 'rpaket_stat_dokSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'rpaket_stat_dok'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'rpaket_stat_dok',
		valueField: 'value',
		width: 98,
		triggerAction: 'all'	 
	
	});
	
	
	/* Function for retrieve search Form Panel */
	master_retur_jual_paket_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 100,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [rpaket_nobuktiSearchField, rpaket_nobuktijualSearchField, rpaket_custSearchField, rpaket_tanggalSearchFieldSet, rpaket_keteranganSearchField, rpaket_stat_dokSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_retur_jual_paket_list_search
			},{
				text: 'Close',
				handler: function(){
					master_retur_jual_paket_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_retur_jual_paket_searchWindow = new Ext.Window({
		title: 'Pencarian Retur Penjualan Paket',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_retur_jual_paket_search',
		items: master_retur_jual_paket_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_retur_jual_paket_searchWindow.isVisible()){
			master_retur_jual_paket_reset_SearchForm();
			master_retur_jual_paket_searchWindow.show();
		} else {
			master_retur_jual_paket_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function master_retur_jual_paket_print(){
		var searchquery = "";
		var rpaket_nobukti_print=null;
		var rpaket_nobuktijual_print=null;
		var rpaket_cust_print=null;
		var rpaket_tanggal_print_date="";
		var rpaket_tanggal_akhir_print_date="";
		var rpaket_keterangan_print=null;
		var rpaket_stat_dok_print=null;
		var win;              
		// check if we do have some search data...
		if(master_retur_jual_paket_DataStore.baseParams.query!==null){searchquery = master_retur_jual_paket_DataStore.baseParams.query;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_nobukti!==null){rpaket_nobukti_print = master_retur_jual_paket_DataStore.baseParams.rpaket_nobukti;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_nobuktijual!==null){rpaket_nobuktijual_print = master_retur_jual_paket_DataStore.baseParams.rpaket_nobuktijual;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_cust!==null){rpaket_cust_print = master_retur_jual_paket_DataStore.baseParams.rpaket_cust;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal!==""){rpaket_tanggal_print_date = master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal_akhir!==""){rpaket_tanggal_akhir_print_date = master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal_akhir;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_keterangan!==null){rpaket_keterangan_print = master_retur_jual_paket_DataStore.baseParams.rpaket_keterangan;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_stat_dok!==null){rpaket_stat_dok_print = master_retur_jual_paket_DataStore.baseParams.rpaket_stat_dok;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_retur_jual_paket&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			rpaket_nobukti	:	rpaket_nobukti_print, 
			rpaket_nobuktijual	:	rpaket_nobuktijual_print, 
			rpaket_cust	:	rpaket_cust_print, 
			rpaket_tanggal	:	rpaket_tanggal_print_date, 
			rpaket_tanggal_akhir : rpaket_tanggal_akhir_print_date,
			rpaket_keterangan	:	rpaket_keterangan_print,
			rpaket_stat_dok		:	rpaket_stat_dok_print,
		  	currentlisting: master_retur_jual_paket_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/master_retur_jual_paketlist.html','master_retur_jual_paketlist','height=400,width=900,resizable=1,scrollbars=1, menubar=1');
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
	function master_retur_jual_paket_export_excel(){
		var searchquery = "";
		var rpaket_nobukti_2excel=null;
		var rpaket_nobuktijual_2excel=null;
		var rpaket_cust_2excel=null;
		var rpaket_tanggal_2excel_date="";
		var rpaket_tanggal_akhir_2excel_date="";
		var rpaket_keterangan_2excel=null;
		var rpaket_stat_dok_2excel=null;
		var win;              
		// check if we do have some 2excel data...
		if(master_retur_jual_paket_DataStore.baseParams.query!==null){searchquery = master_retur_jual_paket_DataStore.baseParams.query;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_nobukti!==null){rpaket_nobukti_2excel = master_retur_jual_paket_DataStore.baseParams.rpaket_nobukti;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_nobuktijual!==null){rpaket_nobuktijual_2excel = master_retur_jual_paket_DataStore.baseParams.rpaket_nobuktijual;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_cust!==null){rpaket_cust_2excel = master_retur_jual_paket_DataStore.baseParams.rpaket_cust;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal!==""){rpaket_tanggal_2excel_date = master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal_akhir!==""){rpaket_tanggal_akhir_2excel_date = master_retur_jual_paket_DataStore.baseParams.rpaket_tanggal_akhir;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_keterangan!==null){rpaket_keterangan_2excel = master_retur_jual_paket_DataStore.baseParams.rpaket_keterangan;}
		if(master_retur_jual_paket_DataStore.baseParams.rpaket_stat_dok!==null){rpaket_stat_dok_2excel = master_retur_jual_paket_DataStore.baseParams.rpaket_stat_dok;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_retur_jual_paket&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			//if we are doing advanced 2excel, use this
			rpaket_nobukti	:	rpaket_nobukti_2excel, 
			rpaket_nobuktijual	:	rpaket_nobuktijual_2excel, 
			rpaket_cust	:	rpaket_cust_2excel, 
			rpaket_tanggal	:	rpaket_tanggal_2excel_date, 
			rpaket_tanggal_akhir : rpaket_tanggal_akhir_2excel_date,
			rpaket_keterangan	:	rpaket_keterangan_2excel,
			rpaket_stat_dok		:	rpaket_stat_dok_2excel,
		  	currentlisting: master_retur_jual_paket_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	rpaket_voucher_nilaicfField.on("keyup",function(){
		var cf_value = rpaket_voucher_nilaicfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		rpaket_voucher_nilaiField.setValue(cf_tonumber);
		//load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
		
		var total_retur = 0;
		var voucher = rpaket_voucher_nilaiField.getValue();
			for(i=0; i<drpaketListEditorGrid.getStore().getCount(); i++){
				total_retur += drpaketListEditorGrid.getStore().getAt(i).data.drpaket_rupiah_retur;
			}
			rpaket_kwitansi_nilaiField.setValue(total_retur-voucher);
			rpaket_kwitansi_nilai_cfField.setValue(CurrencyFormatted(total_retur-voucher));
		
	});
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_retur_jual_paket"></div>
         <div id="fp_drpaket"></div>
		<div id="elwindow_master_retur_jual_paket_create"></div>
        <div id="elwindow_master_retur_jual_paket_search"></div>
    </div>
</div>
</body>