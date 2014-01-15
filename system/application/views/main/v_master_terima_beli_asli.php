<?php
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: master_terima_beli View
	+ Description	: For record view
	+ Filename 		: v_master_terima_beli.php
 	+ Author  		:
 	+ Created on 20/Aug/2009 15:44:15

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
var master_terima_beli_DataStore;
var master_terima_beli_ColumnModel;
var master_terima_beliListEditorGrid;
var master_terima_beli_createForm;
var master_terima_beli_createWindow;
var master_terima_beli_searchForm;
var master_terima_beli_searchWindow;
var master_terima_beli_SelectedRow;
var master_terima_beli_ContextMenu;
//for detail data
var detail_terima_beli_DataStor;
var detail_terima_beliListEditorGrid;
var detail_terima_beli_ColumnModel;
var detail_terima_beli_proxy;
var detail_terima_beli_writer;
var detail_terima_beli_reader;
var editor_detail_terima_beli;

//declare konstant
var terimabeli_post2db = '';
var task = '';
var today=new Date().format('Y-m-d');
var msg = '';
var pageS=15;
var cetak=0;

/* declare variable here for Field*/
var terima_idField;
var terima_noField;
var terima_orderField;
var terima_gudangField;
var terima_supplierField;
var terima_surat_jalanField;
var terima_pengirimField;
var terima_tanggalField;
var terima_keteranganField;
var terima_idSearchField;
var terima_noSearchField;
var terima_orderSearchField;
var terima_gudangSearchField;
var terima_supplierSearchField;
var terima_surat_jalanSearchField;
var terima_pengirimSearchField;
var terima_tgl_awalSearchField;
var terima_keteranganSearchField;
var terima_statusSearchField;

var terima_button_saveField;
var terima_button_saveprintField;

Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
}

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

	/*Function for pengecekan _dokumen untuk save n print */		
	function pengecekan_dokumen(){
		var terima_tanggal_create_date = "";
		if(terima_tanggalField.getValue()!== ""){terima_tanggal_create_date = terima_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_terima_beli&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: terima_tanggal_create_date	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak=1;
							master_terima_beli_create('print');
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penerimaan Barang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
						  // master_terima_beli_create('print')
						});
						//jproduk_btn_cancel();
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
	
	/*Function for pengecekan _dokumen untuk save*/
	function pengecekan_dokumen2(){
		var terima_tanggal_create_date = "";
		if(terima_tanggalField.getValue()!== ""){terima_tanggal_create_date = terima_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_terima_beli&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: terima_tanggal_create_date
		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
						case 1:
							master_terima_beli_create();
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penerimaan Barang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
						  // master_terima_beli_create('print')
						});
						//jproduk_btn_cancel();
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
		
  	/* Function for add data, open window create form */
	function master_terima_beli_create(opsi){
		if(is_master_terima_beli_form_valid() && detail_terima_beli_DataStore.getCount()>0){

		var terima_id_create_pk=null;
		var terima_no_create=null;
		var terima_order_create=null;
		var terima_order_id_create=null;
		var terima_gudang_create=null;
		var terima_supplier_create=null;
		var terima_surat_jalan_create=null;
		var terima_pengirim_create=null;
		var terima_total_qty_create	=null;
		var terima_total_rp_create	=null;
		var terima_tanggal_create_date="";
		var terima_keterangan_create=null;
		var terima_status_create=null;

		if(terima_idField.getValue()!== null){terima_id_create_pk = terima_idField.getValue();}else{terima_id_create_pk=get_pk_id();}
		if(terima_noField.getValue()!== null){terima_no_create = terima_noField.getValue();}
		if(terima_orderField.getValue()!== null){terima_order_create = terima_orderField.getValue();}
		if(terima_order_idField.getValue()!== null){terima_order_id_create = terima_order_idField.getValue();}
		if(terima_gudangField.getValue()!== null){terima_gudang_create = terima_gudangField.getValue();}
		if(terima_supplierField.getValue()!== null){terima_supplier_create = terima_supplier_idField.getValue();}
		if(terima_surat_jalanField.getValue()!== null){terima_surat_jalan_create = terima_surat_jalanField.getValue();}
		if(terima_pengirimField.getValue()!== null){terima_pengirim_create = terima_pengirimField.getValue();}
		if(terima_total_qtyField.getValue()!== null){terima_total_qty_create = terima_total_qtyField.getValue();}
		if(terima_total_rpField.getValue()!== null){terima_total_rp_create = terima_total_rpField.getValue();}
		if(terima_tanggalField.getValue()!== ""){terima_tanggal_create_date = terima_tanggalField.getValue().format('Y-m-d');}
		if(terima_keteranganField.getValue()!== null){terima_keterangan_create = terima_keteranganField.getValue();}
		if(terima_statusField.getValue()!== null){terima_status_create = terima_statusField.getValue();}

		var dterima_id = [];
        var dterima_produk = [];
        var dterima_satuan = [];
        var dterima_jumlah = [];
		var dterima_harga = [];
		var dterima_diskon = [];

        if(detail_terima_beli_DataStore.getCount()>0){
            for(i=0; i<detail_terima_beli_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_terima_beli_DataStore.getAt(i).data.dterima_produk))
				   && detail_terima_beli_DataStore.getAt(i).data.dterima_produk!==undefined
				   && detail_terima_beli_DataStore.getAt(i).data.dterima_produk!==''
				   && detail_terima_beli_DataStore.getAt(i).data.dterima_produk!==0
				   && detail_terima_beli_DataStore.getAt(i).data.dterima_satuan!==0
				   && detail_terima_beli_DataStore.getAt(i).data.dterima_jumlah>0){

					if(detail_terima_beli_DataStore.getAt(i).data.dterima_id==undefined ||
					   detail_terima_beli_DataStore.getAt(i).data.dterima_id==''){
						detail_terima_beli_DataStore.getAt(i).data.dterima_id=0;
					}

                  	dterima_id.push(detail_terima_beli_DataStore.getAt(i).data.dterima_id);
					dterima_produk.push(detail_terima_beli_DataStore.getAt(i).data.dterima_produk);
                   	dterima_satuan.push(detail_terima_beli_DataStore.getAt(i).data.dterima_satuan);
					dterima_jumlah.push(detail_terima_beli_DataStore.getAt(i).data.dterima_jumlah);
					dterima_harga.push(detail_terima_beli_DataStore.getAt(i).data.dterima_harga);
					dterima_diskon.push(detail_terima_beli_DataStore.getAt(i).data.dterima_diskon);

                }
            }

			var encoded_array_dterima_id = Ext.encode(dterima_id);
			var encoded_array_dterima_produk = Ext.encode(dterima_produk);
			var encoded_array_dterima_satuan = Ext.encode(dterima_satuan);
			var encoded_array_dterima_jumlah = Ext.encode(dterima_jumlah);
			var encoded_array_dterima_harga = Ext.encode(dterima_harga);
			var encoded_array_dterima_diskon = Ext.encode(dterima_diskon);


        }

        var dtbonus_id = [];
        var dtbonus_produk = [];
        var dtbonus_satuan = [];
        var dtbonus_jumlah = [];

        if(detail_terima_bonus_DataStore.getCount()>0){
            for(i=0; i<detail_terima_bonus_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_terima_bonus_DataStore.getAt(i).data.dtbonus_produk))
				   && detail_terima_bonus_DataStore.getAt(i).data.dtbonus_produk!==undefined
				   && detail_terima_bonus_DataStore.getAt(i).data.dtbonus_produk!==''
				   && detail_terima_bonus_DataStore.getAt(i).data.dtbonus_produk!==0
				   && detail_terima_bonus_DataStore.getAt(i).data.dtbonus_satuan!==0
				   && detail_terima_bonus_DataStore.getAt(i).data.dtbonus_jumlah>0){

                  	dtbonus_id.push(detail_terima_bonus_DataStore.getAt(i).data.dtbonus_id);
					dtbonus_produk.push(detail_terima_bonus_DataStore.getAt(i).data.dtbonus_produk);
                   	dtbonus_satuan.push(detail_terima_bonus_DataStore.getAt(i).data.dtbonus_satuan);
					dtbonus_jumlah.push(detail_terima_bonus_DataStore.getAt(i).data.dtbonus_jumlah);
                }
            }

			var encoded_array_dtbonus_id = Ext.encode(dtbonus_id);
			var encoded_array_dtbonus_produk = Ext.encode(dtbonus_produk);
			var encoded_array_dtbonus_satuan = Ext.encode(dtbonus_satuan);
			var encoded_array_dtbonus_jumlah = Ext.encode(dtbonus_jumlah);

       	}
		
		Ext.MessageBox.show({
			msg:   'Sedang memproses data, mohon tunggu hingga proses ini selesai agar keamanan data anda terjaga...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_terima_beli&m=get_action',
			params: {
				task				: terimabeli_post2db,
				terima_id			: terima_id_create_pk,
				terima_no			: terima_no_create,
				terima_order		: terima_order_create,
				terima_order_id		: terima_order_id_create,
				terima_supplier		: terima_supplier_create,
				terima_surat_jalan	: terima_surat_jalan_create,
				terima_pengirim		: terima_pengirim_create,
				terima_total_qty	: terima_total_qty_create,
				terima_total_rp		: terima_total_rp_create,
				terima_tanggal		: terima_tanggal_create_date,
				terima_keterangan	: terima_keterangan_create,
				terima_gudang		: terima_gudang_create,
				terima_status		: terima_status_create,
				cetak				: cetak,
				dterima_id			: encoded_array_dterima_id,
				dterima_produk		: encoded_array_dterima_produk,
				dterima_satuan		: encoded_array_dterima_satuan,
				dterima_jumlah		: encoded_array_dterima_jumlah,
				dterima_harga		: encoded_array_dterima_harga,
				dterima_diskon	: encoded_array_dterima_diskon,
				dtbonus_id		: encoded_array_dtbonus_id,
				dtbonus_produk	: encoded_array_dtbonus_produk,
				dtbonus_satuan	: encoded_array_dtbonus_satuan,
				dtbonus_jumlah	: encoded_array_dtbonus_jumlah
				
			},
			success: function(response){
				var result=eval(response.responseText);
				if(result=='-99'){
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'No OP tidak ditemukan.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
				}
				else if(result!==0){
						if(opsi=='print'){
							master_terima_beli_cetak_faktur(result);
						}
						master_terima_beli_DataStore.load();
						/*cbo_tbeli_orderbeli_DataSore.load({
						callback: function(r,opt,success){
							if(success==true){
						*/		Ext.MessageBox.hide();
								Ext.MessageBox.alert(terimabeli_post2db+' OK','Data Penerimaan Barang berhasil disimpan');
						/*	}
						}			
						});
						*/
						//cbo_terima_gudang_DataStore.reload();
						master_terima_beli_createWindow.hide();
				}
				else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penerimaan Barang tidak bisa disimpan.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
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
				msg: 'Isian belum sempurna!. Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING	
			});
		}
	}
 	/* End of Function */

  	/* Function for get PK field */
	function get_pk_id(){
		if(terimabeli_post2db=='UPDATE')
			return master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_id');
		else if(terimabeli_post2db=='CREATE')
			return terima_idField.getValue();
		else
			return 0;
	}
	/* End of Function  */

	/* Reset form before loading */
	function master_terima_beli_reset_form(){
		terima_idField.reset();
		terima_idField.setValue(null);
		terima_noField.reset();
		terima_noField.setValue('(Auto)');
		terima_orderField.reset();
		terima_orderField.setValue(null);
		terima_supplierField.reset();
		terima_supplierField.setValue(null);
		terima_surat_jalanField.reset();
		terima_surat_jalanField.setValue(null);
		terima_pengirimField.reset();
		terima_pengirimField.setValue(null);
		terima_tanggalField.setValue(today);
		terima_keteranganField.reset();
		terima_keteranganField.setValue(null);
		terima_statusField.reset();
		terima_statusField.setValue('Terbuka');
		terima_gudangField.reset();
		terima_gudangField.setValue('GUDANG BESAR (CABIN)');
		terima_idField.setDisabled(false);
		terima_noField.setDisabled(false);
		terima_orderField.setDisabled(false);
		terima_order_idField.setDisabled(false);
		terima_gudangField.setDisabled(false);
		terima_gudang_idField.setDisabled(false);
		terima_supplierField.setDisabled(false);
		terima_surat_jalanField.setDisabled(false);
		terima_supplier_idField.setDisabled(false);
		terima_pengirimField.setDisabled(false);
		terima_tanggalField.setDisabled(false);
		terima_keteranganField.setDisabled(false);
		terima_statusField.setDisabled(false);
		
		//combo_produk_terima.setDisabled(false);
		//combo_produk_satuan.setDisabled(false);
		dterima_jumlahField.setDisabled(false);

		cbo_satuan_produkDataStore.load();
		cbo_produk_detailDataStore.load();
		cbo_terima_gudang_DataStore.load();

		detail_terima_beli_DataStore.setBaseParam('master_id', -1);
		detail_terima_beli_DataStore.load();
		detail_terima_bonus_DataStore.setBaseParam('master_id', -1);
		detail_terima_bonus_DataStore.load();
		master_terima_beli_createForm.tbeli_savePrint.enable();
		master_terima_beli_createForm.pbPrintOnlyButton.disable();
	}
 	/* End of Function */

	/* setValue to EDIT */
	function master_terima_beli_set_form(){
		var loadAll=0;
		
		terima_idField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_id'));
		terima_noField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_no'));
		terima_orderField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_order'));
		terima_order_idField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_order_id'));
		terima_supplierField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_supplier'));
		terima_supplier_idField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_supplier_id'));
		terima_surat_jalanField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_surat_jalan'));
		terima_pengirimField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_pengirim'));
		terima_tanggalField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_tanggal'));
		terima_keteranganField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_keterangan'));
		terima_statusField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_status'));
		terima_gudangField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_gudang_nama'));
		terima_gudang_idField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_gudang_id'));
		//cbo_terima_gudang_DataStore.load();
		
		//LOAD DETAIL
		
		cbo_satuan_produkDataStore.setBaseParam('task','detail');
		cbo_satuan_produkDataStore.setBaseParam('master_id',get_pk_id());
		cbo_satuan_produkDataStore.load();

		terima_button_saveField.setDisabled(true);
		//terima_button_saveprintField.setDisabled(true);
								
		cbo_produk_detailDataStore.setBaseParam('master_id',get_pk_id());
		cbo_produk_detailDataStore.setBaseParam('task','detail');
		cbo_produk_detailDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_terima_beli_DataStore.setBaseParam('master_id', get_pk_id());
					detail_terima_beli_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								detail_terima_beli_total();
								loadAll++;
								if(loadAll==2){
									Ext.MessageBox.hide();
									terima_button_saveField.setDisabled(false);
									//terima_button_saveprintField.setDisabled(false);
								}
							}
						}
					});
				}
			}
		});

		cbo_produk_bonusDataStore.setBaseParam('master_id',get_pk_id());
		cbo_produk_bonusDataStore.setBaseParam('task','detail');
		cbo_produk_bonusDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_terima_bonus_DataStore.setBaseParam('master_id', get_pk_id());
					detail_terima_bonus_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								detail_terima_beli_total();
								loadAll++;
								if(loadAll==2){
									Ext.MessageBox.hide();
									terima_button_saveField.setDisabled(false);
									terima_button_saveprintField.setDisabled(false);
								}
							}
						}
					});
				}
			}
		});
		//END OF DETAIL

		if(terimabeli_post2db=="UPDATE" && master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_status')=="Terbuka"){
			terima_idField.setDisabled(false);
			terima_noField.setDisabled(false);
			terima_gudangField.setDisabled(false);
			terima_orderField.setDisabled(false);
			terima_order_idField.setDisabled(false);
			terima_supplierField.setDisabled(false);
			terima_surat_jalanField.setDisabled(false);
			terima_supplier_idField.setDisabled(false);
			terima_pengirimField.setDisabled(false);
			terima_tanggalField.setDisabled(false);
			terima_keteranganField.setDisabled(false);
			terima_statusField.setDisabled(false);
			//combo_produk_terima.setDisabled(false);
			//combo_produk_satuan.setDisabled(false);
			dterima_jumlahField.setDisabled(false);
			//master_terima_beli_createForm.tbeli_savePrint.enable();
			master_terima_beli_createForm.pbPrintOnlyButton.disable();
			terima_button_saveprintField.setDisabled(false);
		}
		if(terimabeli_post2db=="UPDATE" && master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_status')=="Tertutup"){
			terima_idField.setDisabled(true);
			terima_noField.setDisabled(true);
			terima_gudangField.setDisabled(true);
			terima_orderField.setDisabled(true);
			terima_order_idField.setDisabled(true);
			terima_supplierField.setDisabled(true);
			terima_surat_jalanField.setDisabled(true);
			terima_supplier_idField.setDisabled(true);
			terima_pengirimField.setDisabled(true);
			terima_tanggalField.setDisabled(true);
			terima_keteranganField.setDisabled(true);
			terima_statusField.setDisabled(false);
			master_terima_beli_createForm.pbPrintOnlyButton.enable();
			terima_button_saveprintField.setDisabled(true);
			//combo_produk_terima.setDisabled(true);
			//combo_produk_satuan.setDisabled(true);
			dterima_jumlahField.setDisabled(true);
			if(cetak==1){
					//jproduk_cetak(jproduk_id_for_cetak);
				cetak=0;
			}
			
		}
		if(terimabeli_post2db=="UPDATE" && master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_status')=="Batal"){
			terima_idField.setDisabled(true);
			terima_noField.setDisabled(true);
			terima_gudangField.setDisabled(true);
			terima_orderField.setDisabled(true);
			terima_order_idField.setDisabled(true);
			terima_supplierField.setDisabled(true);
			terima_surat_jalanField.setDisabled(true);
			terima_supplier_idField.setDisabled(true);
			terima_pengirimField.setDisabled(true);
			terima_tanggalField.setDisabled(true);
			terima_keteranganField.setDisabled(true);
			terima_statusField.setDisabled(true);
			master_terima_beli_createForm.pbPrintOnlyButton.enable();
			terima_button_saveprintField.setDisabled(true);
			//combo_produk_terima.setDisabled(true);
			//combo_produk_satuan.setDisabled(true);
			dterima_jumlahField.setDisabled(true);
			//master_terima_beli_createForm.tbeli_savePrint.disable();
		}
		
		
		terima_statusField.on("select",function(){
		var status_awal = master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_status');
		if(status_awal =='Terbuka' && terima_statusField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		terima_statusField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && terima_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		terima_statusField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && terima_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		terima_statusField.setValue('Tertutup');
		}
		
		else if(terima_statusField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', terima_status_batal);
		}
        
       else if(status_awal =='Tertutup' && terima_statusField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
			master_terima_beli_createForm.tbeli_savePrint.enable();
			<?php } ?>
        }
		
		});	
		

		
	}
	/* End setValue to EDIT*/

	function terima_status_batal(btn){
	if(btn=='yes')
	{
		terima_statusField.setValue('Batal');
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
        master_terima_beli_createForm.tbeli_savePrint.disable();
		<?php } ?>
	}  
	else
		terima_statusField.setValue(master_terima_beliListEditorGrid.getSelectionModel().getSelected().get('terima_status'));
	}
	
	/* Function for Check if the form is valid */
	function is_master_terima_beli_form_valid(){
		return (terima_orderField.isValid() && terima_gudangField.isValid());
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		cbo_terima_gudang_DataStore.load();
		if(!master_terima_beli_createWindow.isVisible()){
			terimabeli_post2db='CREATE';
			msg='created';
			master_terima_beli_reset_form();
			master_terima_beli_createWindow.show();
		} else {
			master_terima_beli_createWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function master_terima_beli_confirm_delete(){
		// only one master_terima_beli is selected here
		if(master_terima_beliListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', master_terima_beli_delete);
		} else if(master_terima_beliListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', master_terima_beli_delete);
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
  	/* End of Function */

	/*Function for Print Only */
	function pb_print_only(){
		if(terima_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur PB tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
			var terima_id = terima_idField.getValue();
			cetak=1;
			//master_terima_beli_create('print');
			
			master_terima_beli_cetak_faktur(terima_id);
			
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			
			master_terima_beli_createWindow.hide();
		}

		//jproduk_btn_cancel();
	}

	
	
	/* Function for Update Confirm */
	function master_terima_beli_confirm_update(){
		/* only one record is selected here */
		if(master_terima_beliListEditorGrid.selModel.getCount() == 1) {
			terimabeli_post2db='UPDATE';
			msg='updated';
			master_terima_beli_set_form();
			cbo_terima_gudang_DataStore.load();
			master_terima_beli_createWindow.show();
			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
			
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
	function master_terima_beli_delete(btn){
		if(btn=='yes'){
			var selections = master_terima_beliListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_terima_beliListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.terima_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_master_terima_beli&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_terima_beli_DataStore.reload();
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
	master_terima_beli_DataStore = new Ext.data.Store({
		id: 'master_terima_beli_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'terima_id'
		},[
			{name: 'terima_id', type: 'int', mapping: 'terima_id'},
			{name: 'terima_no', type: 'string', mapping: 'no_bukti'},
			{name: 'terima_order_id', type: 'int', mapping: 'terima_order'},
			{name: 'terima_order', type: 'string', mapping: 'order_no'},
			
			{name: 'terima_gudang_nama', type: 'string', mapping: 'terima_gudang_nama'},
			{name: 'terima_gudang_id', type: 'int', mapping: 'terima_gudang_id'},
			{name: 'terima_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'jumlah_barang', type: 'float', mapping: 'jumlah_barang'},
			{name: 'jumlah_barang_bonus', type: 'float', mapping: 'jumlah_barang_bonus'},
			{name: 'total_nilai', type: 'float', mapping: 'total_nilai'},
			{name: 'terima_supplier_id', type: 'int', mapping: 'supplier_id'},
			{name: 'terima_surat_jalan', type: 'string', mapping: 'terima_surat_jalan'},
			{name: 'terima_pengirim', type: 'string', mapping: 'terima_pengirim'},
			{name: 'terima_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'},
			{name: 'terima_keterangan', type: 'string', mapping: 'terima_keterangan'},
			{name: 'terima_status', type: 'string', mapping: 'terima_status'},
			{name: 'terima_gudang_nama', type: 'string', mapping: 'terima_gudang_nama'},
			{name: 'terima_creator', type: 'string', mapping: 'terima_creator'},
			{name: 'terima_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'terima_date_create'},
			{name: 'terima_update', type: 'string', mapping: 'terima_update'},
			{name: 'terima_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'terima_date_update'},
			{name: 'terima_revised', type: 'int', mapping: 'terima_revised'}
		]),
		sortInfo:{field: 'terima_id', direction: "DESC"}
	});
	/* End of Function */

	cbo_tbeli_orderbeli_DataSore = new Ext.data.Store({
		id: 'cbo_tbeli_orderbeli_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_order_beli_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_id'
		},[
			{name: 'tbeli_orderbeli_value', type: 'int', mapping: 'order_id'},
			{name: 'tbeli_orderbeli_nama', type: 'string', mapping: 'order_no'},
			{name: 'tbeli_orderbeli_tgl', type: 'date', dateFormat: 'Y-m-d', mapping: 'order_tanggal'},
			{name: 'tbeli_orderbeli_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'tbeli_orderbeli_supplier_id', type: 'int', mapping: 'supplier_id'}
		]),
		//sortInfo:{field: 'tbeli_orderbeli_nama', direction: "ASC"}
		sortInfo:{field: 'tbeli_orderbeli_tgl', direction: "DESC"}
	});

	cbo_terima_gudang_DataStore = new Ext.data.Store({
		id: 'cbo_terima_gudang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_terima_gudang_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'terima_gudang_display', type: 'string', mapping: 'gudang_nama'},
			{name: 'terima_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'terima_gudang_lokasi', type: 'string', mapping: 'gudang_lokasi'},
			{name: 'terima_gudang_keterangan', type: 'string', mapping: 'gudang_keterangan'},
		]),
		sortInfo:{field: 'terima_gudang_value', direction: "ASC"}
	});
	
	cbo_tbeli_orderbeli_search_DataSore = new Ext.data.Store({
		id: 'cbo_tbeli_orderbeli_search_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_order_beli_search_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_id'
		},[
			{name: 'tbeli_orderbeli_value', type: 'int', mapping: 'order_id'},
			{name: 'tbeli_orderbeli_nama', type: 'string', mapping: 'order_no'},
			{name: 'tbeli_orderbeli_tgl', type: 'date', dateFormat: 'Y-m-d', mapping: 'order_tanggal'},
			{name: 'tbeli_orderbeli_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'tbeli_orderbeli_supplier_id', type: 'int', mapping: 'supplier_id'}
		]),
		//sortInfo:{field: 'tbeli_orderbeli_nama', direction: "ASC"}
		sortInfo:{field: 'tbeli_orderbeli_tgl', direction: "DESC"}
	});

	cbo_supplier_search_DataSore = new Ext.data.Store({
		id: 'cbo_supplier_search_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_supplier_search_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'supplier_id'
		},[
			{name: 'supplier_notelp', type: 'string', mapping: 'supplier_notelp'},
			{name: 'supplier_nama', type: 'string', mapping: 'supplier_nama'},
			{name: 'supplier_alamat', type: 'string', mapping: 'supplier_alamat'},
			{name: 'supplier_id', type: 'int', mapping: 'supplier_id'}
		]),
		//sortInfo:{field: 'tbeli_orderbeli_nama', direction: "ASC"}
		sortInfo:{field: 'supplier_id', direction: "DESC"}
	});

	var tbeli_orderbeli_detail_DataStore=new Ext.data.Store({
		id: 'tbeli_orderbeli_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_order_beli_detail_by_order_id',
			method: 'POST'
		}),
		baseParams:{task: "LIST"},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_id'
		},[
			{name: 'dorder_master', type: 'int', mapping: 'order_id'},
			{name: 'dterima_produk', type: 'int', mapping: 'dorder_produk'},
			{name: 'dorder_produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'jumlah_sisa', type: 'float', mapping: 'jumlah_sisa'},
			{name: 'dterima_jumlah', type: 'float', mapping: 'dterima_jumlah'},
			{name: 'dterima_order', type: 'float', mapping: 'jumlah_order'},
			{name: 'dterima_satuan', type: 'int', mapping: 'dorder_satuan'},
			{name: 'dorder_produk_satuan', type: 'string', mapping: 'satuan_nama'},
			{name: 'dterima_harga', type: 'float', mapping: 'dterima_harga'},
			{name: 'dterima_diskon', type: 'float', mapping: 'dorder_diskon'},
			{name: 'dorder_produk_subtotal', type: 'float', mapping: 'subtotal'}
		]),
		sortInfo:{field: 'dterima_produk', direction: "ASC"}
	});

	var tbeli_orderbeli_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{tbeli_orderbeli_nama}</b><br /></span>',
            'Tgl-Order: {tbeli_orderbeli_tgl:date("M j, Y")}<br>',
			'Supplier: {tbeli_orderbeli_supplier}',
        '</div></tpl>'
    );
	
	var supplier_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{supplier_nama}</b><br /></span>',
			'Alamat: {supplier_alamat}<br>',
			'Telp: {supplier_notelp}',
        '</div></tpl>'
    );

	var tbeli_gudangbeli_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{terima_gudang_display}</b><br /></span>',
            'Lokasi: {terima_gudang_lokasi}<br>',
        '</div></tpl>'
    );
	
  	/* Function for Identify of Window Column Model */
	master_terima_beli_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'terima_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'terima_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No PB' + '</div>',
			dataIndex: 'terima_no',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No OP' + '</div>',
			dataIndex: 'terima_order',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Supplier' + '</div>',
			dataIndex: 'terima_supplier',
			width: 200,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Total Item' + '</div>',
			align: 'right',
			dataIndex: 'jumlah_barang',
			width: 80,	//150,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			//header: 'Jumlah Item Bonus',
			header: '<div align="center">' + 'Bonus',
			align: 'right',
			dataIndex: 'jumlah_barang_bonus',
			width: 60,	//150,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		<?php if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
		{
			//header: 'Jumlah Item Bonus',
			header: '<div align="center">' + 'Total Nilai',
			align: 'right',
			dataIndex: 'total_nilai',
			width: 80,	//150,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		<?php } ?>
		{
//			header: 'No.Surat Jalan',
			header: '<div align="center">' + 'No Surat Jalan' + '</div>',
			dataIndex: 'terima_surat_jalan',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Gudang' + '</div>',
			dataIndex: 'terima_gudang_nama',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Nama Pengirim' + '</div>',
			dataIndex: 'terima_pengirim',
			width: 120,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'terima_keterangan',
			sortable: true,
			width: 200
		},
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'terima_status',
			sortable: true,
			width: 80
		},
		{
			header: 'Creator',
			dataIndex: 'terima_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		},
		{
			header: 'Date Create',
			dataIndex: 'terima_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		},
		{
			header: 'Update',
			dataIndex: 'terima_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		},
		{
			header: 'Date Update',
			dataIndex: 'terima_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		},
		{
			header: 'Revised',
			dataIndex: 'terima_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);

	master_terima_beli_ColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	master_terima_beliListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_terima_beliListEditorGrid',
		el: 'fp_master_terima_beli',
		title: 'Daftar Penerimaan Barang',
		autoHeight: true,
		store: master_terima_beli_DataStore, // DataStore
		cm: master_terima_beli_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1305,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_terima_beli_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_terima_beli_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_terima_beli_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Pencarian detail',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: master_terima_beli_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_terima_beli_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No OP<br>- No PB<br>- Supplier<br>- No Surat Jalan<br>- Nama Pengirim'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_terima_beli_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_terima_beli_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_terima_beli_print
		}
		]
	});
	master_terima_beliListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	master_terima_beli_ContextMenu = new Ext.menu.Menu({
		id: 'master_terima_beli_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_terima_beli_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: master_terima_beli_confirm_delete
		},
		<?php } ?>
		'-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_terima_beli_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_terima_beli_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onmaster_terima_beli_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_terima_beli_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_terima_beli_SelectedRow=rowIndex;
		master_terima_beli_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function master_terima_beli_editContextMenu(){
		master_terima_beliListEditorGrid.startEditing(master_terima_beli_SelectedRow,1);
  	}
	/* End of Function */


	/* Identify  terima_id Field */
	terima_idField= new Ext.form.NumberField({
		id: 'terima_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: true,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  terima_no Field */
	terima_noField= new Ext.form.TextField({
		id: 'terima_noField',
		fieldLabel: 'No PB',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  terima_order Field */
	terima_orderField= new Ext.form.ComboBox({
		id: 'terima_orderField',
		fieldLabel: 'No OP',
		store: cbo_tbeli_orderbeli_DataSore,
		displayField:'tbeli_orderbeli_nama',
		mode : 'remote',
		valueField: 'tbeli_orderbeli_value',
        typeAhead: false,
		forceSelection: true,
        hideTrigger:false,
		allowBlank: false,
		tpl: tbeli_orderbeli_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	terima_order_idField= new Ext.form.NumberField();
	
	terima_gudangField= new Ext.form.ComboBox({
		id: 'terima_gudangField',
		fieldLabel: 'Gudang',
		index : 4,
		store:cbo_terima_gudang_DataStore,
		mode: 'remote',
		displayField: 'terima_gudang_display',
		valueField: 'terima_gudang_value',
		typeAhead: false,
        hideTrigger:false,
		tpl: tbeli_gudangbeli_tpl,
		//blankText : 'GUDANG BESAR (CABING)',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	terima_gudang_idField= new Ext.form.TextField();
	
	/* Identify  terima_supplier Field */
	terima_supplierField= new Ext.form.TextField({
		id: 'terima_supplierField',
		fieldLabel: 'Supplier',
		//maxLength: 30,
		readOnly: true,
		anchor: '95%'
	});

	terima_supplier_idField= new Ext.form.NumberField({
		id: 'terima_supplier_idField',
		allowNegatife : false,
		allowDecimals: true,
		readOnly: true,
		hidden: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  terima_surat_jalan Field */
	terima_surat_jalanField= new Ext.form.TextField({
		id: 'terima_surat_jalanField',
		fieldLabel: 'No Surat Jalan',
		maxLength: 30,
		anchor: '95%'
	});
	/* Identify  terima_pengirim Field */
	terima_pengirimField= new Ext.form.TextField({
		id: 'terima_pengirimField',
		fieldLabel: 'Nama Pengirim',
		maxLength: 30,
		anchor: '95%'
	});
	/* Identify  terima_tanggal Field */
	terima_tanggalField= new Ext.form.DateField({
		id: 'terima_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  terima_keterangan Field */
	terima_keteranganField= new Ext.form.TextArea({
		id: 'terima_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});

	/* Identify  order_bayar Field */
	terima_total_qtyField= new Ext.form.TextField({
		id: 'terima_total_qtyField',
		fieldLabel: 'Total Item',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '70%',
		maskRe: /([0-9]+)$/
	});

	terima_total_rpField= new Ext.form.TextField({
		id: 'terima_total_rpField',
		fieldLabel: 'Total Nilai (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '70%',
		maskRe: /([0-9]+)$/
	});

//sementara ditutup, karena sptnya tidak diperlukan. Hendri, 2012-09-07

/*	terima_itemField= new Ext.form.TextField({
		id: 'terima_itemField',
		fieldLabel: 'Jumlah Jenis Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '70%',
		maskRe: /([0-9]+)$/
	});
*/

	bonus_jumlahField= new Ext.form.TextField({
		id: 'bonus_jumlahField',
		fieldLabel: 'Jumlah Total Bonus',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '70%',
		maskRe: /([0-9]+)$/
	});

	bonus_itemField= new Ext.form.TextField({
		id: 'bonus_itemField',
		fieldLabel: 'Jumlah Jenis Bonus',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '70%',
		maskRe: /([0-9]+)$/
	});


	terima_statusField= new Ext.form.ComboBox({
		id: 'terima_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['terima_status_value', 'terima_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'terima_status_display',
		valueField: 'terima_status_value',
		anchor: '80%',
		allowBlank: false,
		triggerAction: 'all'
	});

	
	/* Identify Field Jumlah Pesanan*/
	var dterima_jumlahsisaField = new Ext.form.NumberField({
		id : 'dterima_jumlahsisaField',
		name : 'dterima_jumlahsisaField',
		allowDecimals: false,
		allowNegative: false,
		enableKeyEvents: true,
		//blankText: '0',
		maxLength: 11,
		readOnly : true,
		maskRe: /([0-9]+)$/
	});

	var dterima_jumlahField = new Ext.form.NumberField({
		id : 'djumlah_diskonField',
		name : 'djumlah_diskonField',
		enableKeyEvents: true,
		//readOnly : true,			
		allowDecimals: false,
		allowNegative: false,
		//blankText: '0',
		maxLength: 11,
		maskRe: /([0-9]+)$/
	});
	
	//events for field Jumlah 
	dterima_jumlahField.on('keyup', function(){
		/*var total_sisa = 0;
		var sisa_field = dterima_jumlahsisaField.getValue();
		var jumlah_field = dterima_jumlahField.getValue();
		total_sisa = (sisa_field - jumlah_field)
		dterima_jumlahsisaField.setValue(total_sisa);
		*/
		if(this.getRawValue()>dterima_jumlahsisaField.getValue()){
			this.setRawValue(dterima_jumlahsisaField.getValue());
		}
	});


	

  	/*Fieldset Master*/
	master_terima_beli_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [terima_noField, terima_orderField, terima_supplierField, terima_surat_jalanField, terima_gudangField]
			}
			,
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [terima_pengirimField, terima_tanggalField, terima_keteranganField,terima_statusField,terima_idField]
			}
			]

	});

	//master_terima_beli_FootGroup
	master_terima_beli_itemGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '100%',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 130,
				items: [terima_total_qtyField, terima_total_rpField]
			},
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 130,
				items: [/*terima_itemField*/]
			}
			]

	});

	master_terima_bonus_itemGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '100%',
		items:[
			{
				columnWidth: 0.5,
				cls: '.x-form-field-wrap',
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 130,
				items: [bonus_jumlahField]
			},
			{
				columnWidth: 0.5,
				cls: '.x-form-field-wrap',
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 130,
				items: [bonus_itemField]
			}
			]

	});


	/*Detail Declaration */

	// Function for json reader of detail
	var detail_terima_beli_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'dterima_id', type: 'int', mapping: 'dterima_id'},
			{name: 'dterima_master', type: 'int', mapping: 'dterima_master'},
			{name: 'dterima_produk', type: 'int', mapping: 'dterima_produk'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'dterima_satuan', type: 'int', mapping: 'dterima_satuan'},
			{name: 'dterima_jumlah', type: 'int', mapping: 'dterima_jumlah'},
			{name: 'jumlah_sisa', type: 'int', mapping: 'jumlah_sisa'},
			//{name: 'jumlah_sisa', type: 'int', mapping: 'jumlah_order'},
			{name: 'dterima_order', type: 'int', mapping: 'jumlah_order'},
			{name: 'dterima_harga', type: 'int', mapping: 'harga_satuan'},
			{name: 'dterima_diskon', type: 'int', mapping: 'diskon'}
	]);
	//eof

	//function for json writer of detail
	var detail_terima_beli_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof

	/* Function for Retrieve DataStore of detail*/
	detail_terima_beli_DataStore = new Ext.data.Store({
		id: 'detail_terima_beli_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=detail_detail_terima_beli_list',
			method: 'POST'
		}),
		reader: detail_terima_beli_reader,
		baseParams: {start: 0, limit: pageS},
		sortInfo:{field: 'dterima_id', direction: "ASC"}
	});
	/* End of Function */

	//function for editor of detail
	var editor_detail_terima_beli= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				detail_terima_beli_DataStore.commitChanges();
			}
		}
    });
	//eof

	/*=== cbo_produk_detailDataStore ==> mengambil "Detail Produk" dari detailList Modul Order Pembelian ===*/
	cbo_produk_detailDataStore = new Ext.data.Store({
		id: 'cbo_produk_detailDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_produk_list',
			method: 'POST'
		}),
		baseParams: {task: 'list', start:0,limit:pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_kategori_nama', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});
	/*======= END cbo_produk_detailDataStore =======*/

	var produk_detail_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
            'Kategori: {produk_kategori_nama}',
        '</div></tpl>'
    );

	var combo_produk_terima=new Ext.form.ComboBox({
			store: cbo_produk_detailDataStore,
			typeAhead: false,
			mode : 'remote',
			displayField: 'produk_nama',
			valueField: 'produk_id',
			lazyRender: false,
			disabled : true,
			pageSize: pageS,
			tpl: produk_detail_tpl,
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});


	cbo_satuan_produkDataStore = new Ext.data.Store({
		id: 'cbo_satuan_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_satuan_list',
			method: 'POST'
		}),
		baseParams: {start:0,limit:pageS, task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_value'
		},[
			{name: 'satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'satuan_nama', direction: "ASC"}
	});

	var combo_produk_satuan=new Ext.form.ComboBox({
			store: cbo_satuan_produkDataStore,
			mode: 'local',
			typeAhead: true,
			disabled : true,
			displayField: 'satuan_nama',
			valueField: 'satuan_value',
			triggerAction: 'all',
			lazyRender:true
	});


	//declaration of detail coloumn model
	detail_terima_beli_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">ID</div>',
			dataIndex: 'dterima_id',
			width: 80,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: '<div align="center">Nama Produk</div>',
			dataIndex: 'dterima_produk',
			width: 300,
			sortable: true,
			disabled : true,
			editor: combo_produk_terima,
			renderer: Ext.util.Format.comboRenderer(combo_produk_terima)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'dterima_satuan',
			width: 100,
			disabled : true,
			sortable: true,
			editor: combo_produk_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_produk_satuan)
		},
		{
			header: '<div align="center">Jml</div>',
			align: 'right',
			dataIndex: 'dterima_jumlah',
			width: 100,
			sortable: true,
			editor: dterima_jumlahField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},{
			header: '<div align="center">Jml Pesan</div>',
			align: 'right',
			dataIndex: 'dterima_order',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Sisa</div>',
			align: 'right',
			dataIndex: 'jumlah_sisa',
			width: 100,
			sortable: true,
			editor : dterima_jumlahsisaField,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		}
		<? if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
		,{
			header: '<div align="center">Harga</div>',
			align: 'right',
			dataIndex: 'dterima_harga',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},{
			header: '<div align="center">Diskon (%)</div>',
			align: 'right',
			dataIndex: 'dterima_diskon',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},{
			header: '<div align="center">Sub Total</div>',
			align: 'right',
			dataIndex: 'dterima_order',
			width: 100,
			sortable: true,
			renderer: function(v, params, record){
					subtotal=Ext.util.Format.number((record.data.dterima_harga * record.data.dterima_jumlah*(100-record.data.dterima_diskon)/100),"0,000");
                    return '<span>' + subtotal+ '</span>';
            },
			readOnly: true
		}
		<?php } ?>
		]
	);
	//eof

	//declaration of detail list editor grid
	detail_terima_beliListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_terima_beliListEditorGrid',
		el: 'fp_detail_terima_beli',
		height: 250,
		width: 920,
		autoScroll: true,
		store: detail_terima_beli_DataStore, // DataStore
		colModel: detail_terima_beli_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_terima_beli],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			disabled : true,
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_terima_beli_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			disabled : true,
			iconCls:'icon-delete',
			handler: detail_terima_beli_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof


	//function of detail add
	function detail_terima_beli_add(){
		var edit_detail_terima_beli= new detail_terima_beliListEditorGrid.store.recordType({
			dterima_id		: 0,
			dterima_master	:'',
			dterima_produk	: 0,
			dterima_satuan	: 0,
			dterima_jumlah	: 0,
			dterima_order	: 0,
			dterima_harga	: 0,
			dterima_diskon	: 0
		});
		editor_detail_terima_beli.stopEditing();
		detail_terima_beli_DataStore.insert(0, edit_detail_terima_beli);
		detail_terima_beliListEditorGrid.getView().refresh();
		detail_terima_beliListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_terima_beli.startEditing(0);
	}

	//function for refresh detail
	function refresh_detail_terima_beli(){
		detail_terima_beli_DataStore.commitChanges();
		detail_terima_beliListEditorGrid.getView().refresh();
	}
	//eof



	/* Function for Delete Confirm of detail */
	function detail_terima_beli_confirm_delete(){
		// only one record is selected here
		if(detail_terima_beliListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_terima_beli_delete);
		} else if(detail_terima_beliListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_terima_beli_delete);
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
	function detail_terima_beli_delete(btn){
		if(btn=='yes'){
			var s = detail_terima_beliListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_terima_beli_DataStore.remove(r);
				detail_terima_beli_DataStore.commitChanges();
				detail_terima_beli_total();
			}
		}
	}
	//eof


	// Function for json reader of detail
	var detail_terima_bonus_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dtbonus_id'
	},[
			{name: 'dtbonus_id', type: 'int', mapping: 'dtbonus_id'},
			{name: 'dtbonus_master', type: 'int', mapping: 'dtbonus_master'},
			{name: 'dtbonus_produk', type: 'int', mapping: 'dtbonus_produk'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'dtbonus_satuan', type: 'int', mapping: 'dtbonus_satuan'},
			{name: 'dtbonus_jumlah', type: 'int', mapping: 'dtbonus_jumlah'}
	]);
	//eof

	//function for json writer of detail
	var detail_terima_bonus_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof

	/* Function for Retrieve DataStore of detail*/
	detail_terima_bonus_DataStore = new Ext.data.Store({
		id: 'detail_terima_bonus_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=detail_detail_terima_bonus_list',
			method: 'POST'
		}),
		reader: detail_terima_bonus_reader,
		baseParams: {master_id: get_pk_id(), start: 0, limit: pageS},
		sortInfo:{field: 'dtbonus_id', direction: "ASC"}
	});
	/* End of Function */

	//function for editor of detail
	var editor_detail_terima_bonus= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				detail_terima_bonus_DataStore.commitChanges();
			}
		}
    });
	//eof

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}

	cbo_produk_bonusDataStore = new Ext.data.Store({
		id: 'cbo_produk_bonusDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_terima_beli&m=get_bonus_list',
			method: 'POST'
		}),
		baseParams: {task: 'list', start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_kategori_nama', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});
	/*======= END cbo_produk_detailDataStore =======*/

	var produk_detail_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
            'Kategori: {produk_kategori_nama}',
        '</div></tpl>'
    );

	var combo_bonus_terima=new Ext.form.ComboBox({
			store: cbo_produk_bonusDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'produk_nama',
			valueField: 'produk_id',
			triggerAction: 'all',
			pageSize:pageS,
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			tpl: produk_detail_tpl,
			lazyRender: false,
			listClass: 'x-combo-list-small',

	});

	var combo_bonus_satuan=new Ext.form.ComboBox({
			store: cbo_satuan_produkDataStore,
			mode: 'local',
			typeAhead: true,
			displayField: 'satuan_nama',
			valueField: 'satuan_value',
			triggerAction: 'all',
			lazyRender:true

	});

	//declaration of detail coloumn model
	detail_terima_bonus_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">ID</div>',
			dataIndex: 'dtbonus_id',
			width: 80,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: '<div align="center">Nama Produk</div>',
			dataIndex: 'dtbonus_produk',
			width: 300,
			sortable: true,
			editor: combo_bonus_terima,
			renderer: Ext.util.Format.comboRenderer(combo_bonus_terima)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'dtbonus_satuan',
			width: 150,
			sortable: true,
			editor: combo_bonus_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_bonus_satuan)
		},
		{
			header: '<div align="center">Jumlah</div>',
			dataIndex: 'dtbonus_jumlah',
			align:'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			width: 100,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		}]
	);
	//eof


	//declaration of detail list editor grid
	detail_terima_bonusListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_terima_bonusListEditorGrid',
		el: 'fp_detail_terima_bonus',
		//title: 'Detail detail_terima_bonus',
		height: 250,
		width: 920,
		autoScroll: true,
		store: detail_terima_bonus_DataStore, // DataStore
		colModel: detail_terima_bonus_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_terima_bonus],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_terima_bonus_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_terima_bonus_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_terima_bonus_add(){
		var edit_detail_terima_bonus= new detail_terima_bonusListEditorGrid.store.recordType({
			dtbonus_id		: 0,
			dtbonus_master	:'',
			dtbonus_produk	: 0,
			dtbonus_satuan	: 0,
			dtbonus_jumlah	: 0
		});
		editor_detail_terima_bonus.stopEditing();
		detail_terima_bonus_DataStore.insert(0, edit_detail_terima_bonus);
		detail_terima_bonusListEditorGrid.getView().refresh();
		detail_terima_bonusListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_terima_bonus.startEditing(0);
	}

	//function for refresh detail
	function refresh_detail_terima_bonus(){
		detail_terima_bonus_DataStore.commitChanges();
		detail_terima_bonusListEditorGrid.getView().refresh();
	}
	//eof


	/* Function for Delete Confirm of detail */
	function detail_terima_bonus_confirm_delete(){
		// only one record is selected here
		if(detail_terima_bonusListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_terima_bonus_delete);
		} else if(detail_terima_bonusListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_terima_bonus_delete);
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
	function detail_terima_bonus_delete(btn){
		if(btn=='yes'){
			var s = detail_terima_bonusListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_terima_bonus_DataStore.remove(r);
				detail_terima_bonus_DataStore.commitChanges();
				detail_terima_bonus_total();
			}
		}
	}
	//eof
	
	
	//event on update of detail data store
	detail_terima_bonus_DataStore.on('update', refresh_detail_terima_bonus);

	var detail_tab_terima = new Ext.TabPanel({
		//activeTab: 0,
		//items: [detail_terima_beliGroup, detail_terima_bonusListEditorGrid]
		plain:true,
		activeTab: 0,
		autoHeight: true,
		//defaults:{bodyStyle:'padding:10px'},
		items: [
				{
					title:'Detail Penerimaan Barang',
					layout:'form',
					border: false,
					frame: true,
					defaults: {width: 920},
					autoHeight: true,
					defaultType: 'textfield',
					items: [detail_terima_beliListEditorGrid,master_terima_beli_itemGroup]
				},
				{
					title:'Detail Penerimaan Barang Bonus',
					layout:'form',
					border: false,
					frame: true,
					defaults: {width: 920},
					autoHeight: true,
					defaultType: 'textfield',
					items: [detail_terima_bonusListEditorGrid,master_terima_bonus_itemGroup]
				}
				]
	});

	terima_button_saveprintField=new Ext.Button({
		text: 'Save and Print',
		ref: '../tbeli_savePrint',
		handler: pengecekan_dokumen
		//{cetak=1;}
	});
	
	terima_button_saveField=new Ext.Button({
		text: 'Save',
		handler: pengecekan_dokumen2
		//{ master_terima_beli_create('close'); }
	});
	
	/* Function for retrieve create Window Panel*/
	master_terima_beli_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 940,
		items: [master_terima_beli_masterGroup,detail_tab_terima],
		buttons: [
			{
				text: 'Print Only',
				ref:'../pbPrintOnlyButton',
				handler: pb_print_only
			},
			{
				xtype:'spacer',
				width: 350
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
			terima_button_saveprintField
			,terima_button_saveField
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_terima_beli_DataStore.reload();
					//cbo_tbeli_orderbeli_DataSore.reload();
					master_terima_beli_createWindow.hide();
					
				}
			}
		]
	});
	/* End  of Function*/

	/* Function for retrieve create Window Form */
	master_terima_beli_createWindow= new Ext.Window({
		id: 'master_terima_beli_createWindow',
		title: terimabeli_post2db+' Penerimaan Barang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_terima_beli_create',
		items: master_terima_beli_createForm
	});
	/* End Window */

	/* Function for action list search */
	function master_terima_beli_list_search(){
		// render according to a SQL date format.
		var terima_no_search=null;
		var terima_order_search=null;
		var terima_gudang_search=null;
		var terima_supplier_search=null;
		var terima_surat_jalan_search=null;
		var terima_pengirim_search=null;
		var terima_tgl_awal_search_date="";
		var terima_tgl_akhir_search_date="";
		var terima_keterangan_search=null;
		var terima_status_search=null;

		if(terima_noSearchField.getValue()!==null){terima_no_search=terima_noSearchField.getValue();}
		if(terima_orderSearchField.getValue()!==null){terima_order_search=terima_orderSearchField.getValue();}
		if(terima_supplierSearchField.getValue()!==null){terima_supplier_search=terima_supplierSearchField.getValue();}
		if(terima_gudangSearchField.getValue()!==null){terima_gudang_search=terima_gudangSearchField.getValue();}
		if(terima_surat_jalanSearchField.getValue()!==null){terima_surat_jalan_search=terima_surat_jalanSearchField.getValue();}
		if(terima_pengirimSearchField.getValue()!==null){terima_pengirim_search=terima_pengirimSearchField.getValue();}
		if(terima_tgl_awalSearchField.getValue()!==""){terima_tgl_awal_search_date=terima_tgl_awalSearchField.getValue().format('Y-m-d');}
		if(terima_tgl_akhirSearchField.getValue()!==""){terima_tgl_akhir_search_date=terima_tgl_akhirSearchField.getValue().format('Y-m-d');}
		if(terima_keteranganSearchField.getValue()!==null){terima_keterangan_search=terima_keteranganSearchField.getValue();}
		if(terima_statusSearchField.getValue()!==null){terima_status_search=terima_statusSearchField.getValue();}
		// change the store parameters
		master_terima_beli_DataStore.baseParams = {
			task				: 'SEARCH',
			terima_no			: terima_no_search,
			terima_order		: terima_order_search,
			terima_supplier	:	terima_supplier_search,
			terima_gudang	:	terima_gudang_search, 
			terima_surat_jalan	: terima_surat_jalan_search,
			terima_pengirim		: terima_pengirim_search,
			terima_tgl_awal		: terima_tgl_awal_search_date,
			terima_tgl_akhir	: terima_tgl_akhir_search_date,
			terima_keterangan	: terima_keterangan_search,
			terima_status		: terima_status_search
		};
		master_terima_beli_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function master_terima_beli_reset_search(){
		// reset the store parameters
		master_terima_beli_DataStore.baseParams = { task: 'LIST',start:0,limit:15  };
		master_terima_beli_DataStore.load({params: {start: 0, limit: 15}});
		cbo_terima_gudang_DataStore.reload();
		//master_terima_beli_searchWindow.close();
	};
	/* End of Fuction */

	function master_terima_beli_reset_SearchForm(){
		terima_noSearchField.reset();
		terima_orderSearchField.reset();
		terima_gudangSearchField.reset();
		terima_supplierSearchField.reset();
		terima_surat_jalanSearchField.reset();
		terima_pengirimSearchField.reset();
		terima_tgl_awalSearchField.reset();
		terima_keteranganSearchField.reset();
		terima_statusSearchField.reset();
	}


	/* Field for search */
	/* Identify  terima_id Search Field */
	terima_idSearchField= new Ext.form.NumberField({
		id: 'terima_idSearchField',
		fieldLabel: 'Terima Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
	/* Identify  terima_no Search Field */
	terima_noSearchField= new Ext.form.TextField({
		id: 'terima_noSearchField',
		fieldLabel: 'No PB',
		maxLength: 50,
		anchor: '95%'

	});
	/* Identify  terima_order Search Field */
	terima_orderSearchField= new Ext.form.ComboBox({
		id: 'terima_orderSearchField',
		fieldLabel: 'No OP',
		store: cbo_tbeli_orderbeli_search_DataSore,
		displayField:'tbeli_orderbeli_nama',
		mode : 'remote',
		valueField: 'tbeli_orderbeli_value',
        typeAhead: false,
        hideTrigger:false,
		tpl: tbeli_orderbeli_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	terima_gudangSearchField= new Ext.form.ComboBox({
		id: 'terima_gudangSearchField',
		fieldLabel: 'Gudang',
		store:cbo_terima_gudang_DataStore,
		mode: 'remote',
		displayField: 'terima_gudang_display',
		valueField: 'terima_gudang_value',
		typeAhead: false,
        hideTrigger:false,
		tpl: tbeli_gudangbeli_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  terima_supplier Search Field */
	terima_supplierSearchField= new Ext.form.ComboBox({
		id: 'terima_supplierSearchField',
		fieldLabel: 'Supplier',
		store: cbo_supplier_search_DataSore,
		displayField:'supplier_nama',
		mode : 'remote',
		valueField: 'supplier_id',
        typeAhead: false,
        hideTrigger:false,
		tpl: supplier_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  terima_surat_jalan Search Field */
	terima_surat_jalanSearchField= new Ext.form.TextField({
		id: 'terima_surat_jalanSearchField',
		fieldLabel: 'No Surat Jalan',
		maxLength: 30,
		anchor: '95%'

	});
	/* Identify  terima_pengirim Search Field */
	terima_pengirimSearchField= new Ext.form.TextField({
		id: 'terima_pengirimSearchField',
		fieldLabel: 'Nama Pengirim',
		maxLength: 30,
		anchor: '95%'

	});
	/* Identify  terima_tanggal Search Field */
	terima_tgl_awalSearchField= new Ext.form.DateField({
		id: 'terima_tgl_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',

	});
	/* Identify  terima_keterangan Search Field */
	terima_keteranganSearchField= new Ext.form.TextField({
		id: 'terima_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});

	terima_tgl_akhirSearchField= new Ext.form.DateField({
		id: 'terima_tgl_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	});

	terima_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });


	terima_tgl_awalSearchFieldSet=new Ext.form.FieldSet({
		id:'terima_tgl_awalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[terima_tgl_awalSearchField, terima_label_tanggalField, terima_tgl_akhirSearchField]
	});

	terima_statusSearchField= new Ext.form.ComboBox({
		id: 'terima_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'terima_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'terima_status',
		valueField: 'value',
		anchor: '80%',
		triggerAction: 'all'

	});



	/* Function for retrieve search Form Panel */
	master_terima_beli_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,
		labelWidth: 100,
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [terima_noSearchField, terima_orderSearchField, terima_supplierSearchField, terima_surat_jalanSearchField, terima_gudangSearchField, terima_pengirimSearchField,
						{
							layout: 'column',
							border: false,
							items:[{
								   		layout: 'form',
										border: false,
										columnWidth: 0.6,
										labelWidth: 100,
										items:[terima_tgl_awalSearchField]
								   },
								   {
								   		layout: 'form',
										border: false,
										columnWidth: 0.4,
										labelWidth: 20,
										items:[terima_tgl_akhirSearchField]
								   }
							]
						}, terima_keteranganSearchField, terima_statusSearchField]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_terima_beli_list_search
			},{
				text: 'Close',
				handler: function(){
					master_terima_beli_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	master_terima_beli_searchWindow = new Ext.Window({
		title: 'Pencarian Penerimaan Barang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_terima_beli_search',
		items: master_terima_beli_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_terima_beli_searchWindow.isVisible()){
			master_terima_beli_reset_SearchForm();
			master_terima_beli_searchWindow.show();
		} else {
			master_terima_beli_searchWindow.toFront();
		}
	}
  	/* End Function */

	function master_terima_beli_cetak_faktur(pkid){

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_terima_beli&m=print_faktur',
		params: {
			faktur	: pkid
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/terima_faktur.html','master_terima_faktur','height=800,width=600,resizable=1,scrollbars=1, menubar=1');
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


	
	/* Function for print List Grid */
	function master_terima_beli_print(){
		var searchquery = "";
		var terima_no_print=null;
		var terima_order_print=null;
		var terima_supplier_print=null;
		var terima_gudang_print=null;
		var terima_surat_jalan_print=null;
		var terima_pengirim_print=null;
		var terima_tgl_awal_print_date="";
		var terima_keterangan_print=null;
		var win;
		// check if we do have some search data...
		if(master_terima_beli_DataStore.baseParams.query!==null){searchquery = master_terima_beli_DataStore.baseParams.query;}
		if(master_terima_beli_DataStore.baseParams.terima_no!==null){terima_no_print = master_terima_beli_DataStore.baseParams.terima_no;}
		if(master_terima_beli_DataStore.baseParams.terima_gudang!==null){karyawan_cabang_print = master_terima_beli_DataStore.baseParams.terima_gudang;}
		if(master_terima_beli_DataStore.baseParams.terima_order!==null){terima_order_print = master_terima_beli_DataStore.baseParams.terima_order;}
		if(terima_supplierSearchField.getValue()!==null){terima_supplier_print=terima_supplierSearchField.getValue();}
		if(master_terima_beli_DataStore.baseParams.terima_surat_jalan!==null){terima_surat_jalan_print = master_terima_beli_DataStore.baseParams.terima_surat_jalan;}
		if(master_terima_beli_DataStore.baseParams.terima_pengirim!==null){terima_pengirim_print = master_terima_beli_DataStore.baseParams.terima_pengirim;}
		if(master_terima_beli_DataStore.baseParams.terima_tgl_awal_print!==""){terima_tgl_awal_print_date = master_terima_beli_DataStore.baseParams.terima_tgl_awal_print;}
		if(master_terima_beli_DataStore.baseParams.terima_tgl_akhir_print!==""){terima_tgl_akhir_print_date = master_terima_beli_DataStore.baseParams.terima_tgl_akhir_print;}
		if(master_terima_beli_DataStore.baseParams.terima_keterangan!==null){terima_keterangan_print = master_terima_beli_DataStore.baseParams.terima_keterangan;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_terima_beli&m=get_action',
		params: {
			task				: "PRINT",
		  	query				: searchquery,
			terima_no 			: terima_no_print,
			terima_order 		: terima_order_print,
			terima_gudang 		: terima_gudang_print,
			terima_supplier 	: terima_supplier_print,
			terima_surat_jalan 	: terima_surat_jalan_print,
			terima_pengirim 	: terima_pengirim_print,
		  	terima_tgl_awal		: terima_tgl_awal_print_date,
			terima_tgl_akhir	: terima_tgl_akhir_print_date,
			terima_keterangan 	: terima_keterangan_print,
		  	currentlisting		: master_terima_beli_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_terima_belilist.html','master_terima_belilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');

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
	function master_terima_beli_export_excel(){
		var searchquery = "";
		var terima_no_2excel=null;
		var terima_order_2excel=null;
		var terima_supplier_2excel=null;
		var terima_surat_jalan_2excel=null;
		var terima_pengirim_2excel=null;
		var terima_gudang_2excel=null;
		var terima_tgl_awal_2excel_date="";
		var terima_tgl_akhir_2excel_date="";
		var terima_keterangan_2excel=null;
		var win;
		// check if we do have some search data...
		if(master_terima_beli_DataStore.baseParams.query!==null){searchquery = master_terima_beli_DataStore.baseParams.query;}
		if(master_terima_beli_DataStore.baseParams.terima_no!==null){terima_no_2excel = master_terima_beli_DataStore.baseParams.terima_no;}
		if(master_terima_beli_DataStore.baseParams.terima_order!==null){terima_order_2excel = master_terima_beli_DataStore.baseParams.terima_order;}
		if(terima_supplierSearchField.getValue()!==null){terima_supplier_2excel=terima_supplierSearchField.getValue();}
		if(master_terima_beli_DataStore.baseParams.terima_surat_jalan!==null){terima_surat_jalan_2excel = master_terima_beli_DataStore.baseParams.terima_surat_jalan;}
		if(master_terima_beli_DataStore.baseParams.terima_pengirim!==null){terima_pengirim_2excel = master_terima_beli_DataStore.baseParams.terima_pengirim;}
		if(master_terima_beli_DataStore.baseParams.terima_tgl_awal!==""){terima_tgl_awal_2excel_date = master_terima_beli_DataStore.baseParams.terima_tgl_awal;}
		if(master_terima_beli_DataStore.baseParams.terima_tgl_akhir!==""){terima_tgl_akhir_2excel_date = master_terima_beli_DataStore.baseParams.terima_tgl_akhir;}
		if(master_terima_beli_DataStore.baseParams.terima_keterangan!==null){terima_keterangan_2excel = master_terima_beli_DataStore.baseParams.terima_keterangan;}
		if(master_terima_beli_DataStore.baseParams.terima_gudang!==null){terima_gudang_2excel = master_terima_beli_DataStore.baseParams.terima_gudang;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_terima_beli&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,
			terima_no 			: terima_no_2excel,
			terima_order 		: terima_order_2excel,
			terima_gudang 		: terima_gudang_2excel,
			terima_supplier 	: terima_supplier_2excel,
			terima_surat_jalan 	: terima_surat_jalan_2excel,
			terima_pengirim 	: terima_pengirim_2excel,
		  	terima_tgl_awal		: terima_tgl_awal_2excel_date,
			terima_tgl_akhir	: terima_tgl_akhir_2excel_date,
			terima_keterangan 	: terima_keterangan_2excel,
		  	currentlisting		: master_terima_beli_DataStore.baseParams.task // this tells us if we are searching or not
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

	function detail_terima_beli_total(){
		var jumlah_item	= 0;
		var total_rp	= 0;
		for(i=0;i<detail_terima_beli_DataStore.getCount();i++){
			detail_terima_beli_record=detail_terima_beli_DataStore.getAt(i);
			jumlah_item	= jumlah_item + detail_terima_beli_record.data.dterima_jumlah;
			total_rp	= total_rp + (detail_terima_beli_record.data.dterima_harga * detail_terima_beli_record.data.dterima_jumlah * 
							(100 - detail_terima_beli_record.data.dterima_diskon) / 100);			
		}
		terima_total_qtyField.setValue(CurrencyFormatted(jumlah_item));
		terima_total_rpField.setValue(CurrencyFormatted(total_rp));
		
		//sementara ditutup, karena sptnya tidak diperlukan. Hendri, 2012-09-07
		//terima_itemField.setValue(CurrencyFormatted(detail_terima_beli_DataStore.getCount()));
	}


	function detail_terima_bonus_total(){
		var jumlah_item=0;
		for(i=0;i<detail_terima_bonus_DataStore.getCount();i++){
			detail_terima_bonus_record=detail_terima_bonus_DataStore.getAt(i);
			jumlah_item=jumlah_item+detail_terima_bonus_record.data.dtbonus_jumlah;
		}
		bonus_jumlahField.setValue(CurrencyFormatted(jumlah_item));
		bonus_itemField.setValue(CurrencyFormatted(detail_terima_bonus_DataStore.getCount()));
	}

	//EVENTS

	master_terima_beliListEditorGrid.addListener('rowcontextmenu', onmaster_terima_beli_ListEditGridContextMenu);
	master_terima_beli_DataStore.load({params: {task: "LIST", start: 0, limit: pageS}});	// load DataStore

	detail_terima_beli_DataStore.on("load",detail_terima_beli_total);
	detail_terima_bonus_DataStore.on("load",detail_terima_bonus_total);

	combo_bonus_satuan.on("focus",function(){
		cbo_satuan_produkDataStore.setBaseParam('task','produk');
		cbo_satuan_produkDataStore.setBaseParam('selected_id',combo_bonus_terima.getValue());
		cbo_satuan_produkDataStore.load();
	});

	combo_produk_satuan.on("focus",function(){
		cbo_satuan_produkDataStore.setBaseParam('task','produk');
		cbo_satuan_produkDataStore.setBaseParam('selected_id',combo_produk_terima.getValue());
		cbo_satuan_produkDataStore.load();
	});

	detail_terima_beli_DataStore.on("update",function(){
		detail_terima_beli_DataStore.commitChanges();
		detail_terima_beli_total();
		var	query_selected="";
		var satuan_selected="";
		for(i=0;i<detail_terima_beli_DataStore.getCount();i++){
			detail_terima_beli_record=detail_terima_beli_DataStore.getAt(i);
			query_selected=query_selected+detail_terima_beli_record.data.dterima_produk+",";
		}
		

		for(i=0;i<detail_terima_beli_DataStore.getCount();i++){
			detail_terima_beli_record=detail_terima_beli_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_terima_beli_record.data.dterima_satuan+",";
		}

		for(i=0;i<detail_terima_bonus_DataStore.getCount();i++){
			detail_terima_beli_record=detail_terima_bonus_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_terima_beli_record.data.dtbonus_satuan+",";
		}

		//cbo_produk_detailDataStore.setBaseParam('query',null);
		//cbo_produk_detailDataStore.setBaseParam('task','selected');
		//cbo_produk_detailDataStore.setBaseParam('selected_id',query_selected);
		//cbo_produk_detailDataStore.load();
		
		//cbo_satuan_produkDataStore.setBaseParam('task','selected');
		//cbo_satuan_produkDataStore.setBaseParam('selected_id',satuan_selected);
		//cbo_satuan_produkDataStore.load();

	});

	detail_terima_bonus_DataStore.on("update",function(){
		detail_terima_bonus_DataStore.commitChanges();
		detail_terima_beli_total();
		var	query_selected="";
		var satuan_selected="";
		for(i=0;i<detail_terima_bonus_DataStore.getCount();i++){
			detail_terima_bonus_record=detail_terima_bonus_DataStore.getAt(i);
			query_selected=query_selected+detail_terima_bonus_record.data.dtbonus_produk+",";
		}
		cbo_produk_bonusDataStore.setBaseParam('query',null);
		cbo_produk_bonusDataStore.setBaseParam('task','selected');
		cbo_produk_bonusDataStore.setBaseParam('selected_id',query_selected);
		cbo_produk_bonusDataStore.load();


		for(i=0;i<detail_terima_bonus_DataStore.getCount();i++){
			detail_terima_beli_record=detail_terima_bonus_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_terima_beli_record.data.dtbonus_satuan+",";
		}

		for(i=0;i<detail_terima_beli_DataStore.getCount();i++){
			detail_terima_beli_record=detail_terima_beli_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_terima_beli_record.data.dterima_satuan+",";
		}

		cbo_satuan_produkDataStore.setBaseParam('task','selected');
		cbo_satuan_produkDataStore.setBaseParam('selected_id',satuan_selected);
		cbo_satuan_produkDataStore.load();
		detail_terima_bonus_total();

	});

	combo_produk_terima.on("focus",function(){
		var	query_selected="";
		cbo_produk_detailDataStore.setBaseParam('task','list');
		var selectedquery=detail_terima_beliListEditorGrid.getSelectionModel().getSelected().get('produk_nama');
		cbo_produk_detailDataStore.setBaseParam('query',selectedquery);
	});

	combo_bonus_terima.on("focus",function(){
		cbo_produk_bonusDataStore.setBaseParam('task','list');
		var selectedquery=detail_terima_bonusListEditorGrid.getSelectionModel().getSelected().get('produk_nama');
		cbo_produk_detailDataStore.setBaseParam('query',selectedquery);
	});

	terima_orderField.on("select",function(){
		var j=cbo_tbeli_orderbeli_DataSore.findExact('tbeli_orderbeli_value',terima_orderField.getValue());

		if(cbo_tbeli_orderbeli_DataSore.getCount()){
			terima_supplierField.setValue(cbo_tbeli_orderbeli_DataSore.getAt(j).data.tbeli_orderbeli_supplier);
			terima_supplier_idField.setValue(cbo_tbeli_orderbeli_DataSore.getAt(j).data.tbeli_orderbeli_supplier_id);
			terima_order_idField.setValue(cbo_tbeli_orderbeli_DataSore.getAt(j).data.tbeli_orderbeli_value);
			terima_gudang_idField.setValue(cbo_tbeli_orderbeli_DataSore.getAt(j).data.terima_gudang_value);
		}
		tbeli_orderbeli_detail_DataStore.load({
			params:{orderid: terima_orderField.getValue()},
			callback: function(r,opt,success){
				if(success==true){
					cbo_produk_detailDataStore.setBaseParam('task','order');
					cbo_produk_detailDataStore.setBaseParam('order_id',terima_orderField.getValue());
					cbo_produk_detailDataStore.load({
						callback: function(r,opt,success){
							if(success==true){

								detail_terima_beli_DataStore.removeAll();
								for(i=0;i<tbeli_orderbeli_detail_DataStore.getCount();i++){
										var detail_order_record=tbeli_orderbeli_detail_DataStore.getAt(i);
										detail_terima_beli_DataStore.insert(i,detail_order_record);
								}
								detail_terima_beli_total();
							}
							cbo_satuan_produkDataStore.setBaseParam('task','order');
							cbo_satuan_produkDataStore.setBaseParam('order_id',terima_orderField.getValue());
							cbo_satuan_produkDataStore.load();
							
							
						}
					});
				}
			}
		});
		detail_terima_beli_DataStore.commitChanges();
		detail_terima_beli_total();
	});

	
	terimabeli_post2db = '';
	task = '';
	
	
	
	
	
	
});

	</script>
</head>
<body>
<div>
	<div class="col">
        <div id="fp_master_terima_beli"></div>
         <div id="fp_detail_terima_beli"></div>
         <div id="fp_detail_terima_bonus"></div>
		<div id="elwindow_master_terima_beli_create"></div>
        <div id="elwindow_master_terima_beli_search"></div>
    </div>
</div>
</body>
</html>	