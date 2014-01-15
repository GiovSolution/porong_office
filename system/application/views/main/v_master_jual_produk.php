<?
/* 	
	GIOV Solution - Keep IT Simple
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
var master_jual_produk_DataStore;
var kwitansi_jual_produk_DataStore;
var card_jual_produk_DataStore;
var cek_jual_produk_DataStore;
var transfer_jual_produk_DataStore;
//
var master_jual_produk_ColumnModel;
var master_jual_produkListEditorGrid;
var master_jual_produk_createForm;
var master_jual_produk_createWindow;
var master_jual_produk_searchForm;
var master_jual_produk_searchWindow;
var master_jual_produk_SelectedRow;
var master_jual_produk_ContextMenu;
//for detail data
var detail_jual_produk_DataStore;
var detail_jual_produkListEditorGrid;
var detail_jual_produk_ColumnModel;
var detail_jual_produk_proxy;
var detail_jual_produk_writer;
var detail_jual_produk_reader;
var editor_detail_jual_produk;

//declare konstant
var jproduk_post2db = '';
var msg = '';
var pageS=15;
var today = new Date().format('d-m-Y');
var today_ultah = new Date().format('m-d');

var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],37); ?>";

/* declare variable here for Field*/
var jproduk_idField;
var jproduk_nobuktiField;
var jproduk_custField;
var jproduk_tanggalField;
//var jproduk_member_validField;
var jproduk_diskonField;
var jproduk_ket_diskField;
var jproduk_bayarField;
var jproduk_caraField;
var jproduk_cara2Field;
var jproduk_cara3Field;
var jproduk_keteranganField;
//tunai
var jproduk_tunai_nilaiField;
//tunai-2
var jproduk_tunai_nilai2Field;
//tunai-3
var jproduk_tunai_nilai3Field;
//voucher
var jproduk_voucher_noField;
var jproduk_voucher_cashbackField;
//voucher-2
var jproduk_voucher_no2Field;
var jproduk_voucher_cashback2Field;
//voucher-3
var jproduk_voucher_no3Field;
var jproduk_voucher_cashback3Field;

var jproduk_cashbackField;
var is_member=false;
//kwitansi
var jproduk_kwitansi_namaField;
var jproduk_kwitansi_nilaiField;
var jproduk_kwitansi_noField;
//kwitansi-2
var jproduk_kwitansi_nama2Field;
var jproduk_kwitansi_nilai2Field;
var jproduk_kwitansi_no2Field;
//kwitansi-3
var jproduk_kwitansi_nama3Field;
var jproduk_kwitansi_nilai3Field;
var jproduk_kwitansi_no3Field;

//card
var jproduk_card_namaField;
var jproduk_card_edcField;
var jproduk_card_noField;
var jproduk_card_nilaiField;
//card-2
var jproduk_card_nama2Field;
var jproduk_card_edc2Field;
var jproduk_card_no2Field;
var jproduk_card_nilai2Field;
//card-3
var jproduk_card_nama3Field;
var jproduk_card_edc3Field;
var jproduk_card_no3Field;
var jproduk_card_nilai3Field;

//cek
var jproduk_cek_namaField;
var jproduk_cek_noField;
var jproduk_cek_validField;
var jproduk_cek_bankField;
var jproduk_cek_nilaiField;
//cek-2
var jproduk_cek_nama2Field;
var jproduk_cek_no2Field;
var jproduk_cek_valid2Field;
var jproduk_cek_bank2Field;
var jproduk_cek_nilai2Field;
//cek-3
var jproduk_cek_nama3Field;
var jproduk_cek_no3Field;
var jproduk_cek_valid3Field;
var jproduk_cek_bank3Field;
var jproduk_cek_nilai3Field;

//transfer
var jproduk_transfer_bankField;
var jproduk_transfer_namaField;
var jproduk_transfer_nilaiField;
//transfer-2
var jproduk_transfer_bank2Field;
var jproduk_transfer_nama2Field;
var jproduk_transfer_nilai2Field;
//transfer-3
var jproduk_transfer_bank3Field;
var jproduk_transfer_nama3Field;
var jproduk_transfer_nilai3Field;

var jproduk_idSearchField;
var jproduk_nobuktiSearchField;
var jproduk_custSearchField;
var jproduk_tanggalSearchField;
var jproduk_tanggal_akhirSearchField;
var jproduk_diskonSearchField;
var jproduk_caraSearchField;
var jproduk_keteranganSearchField;
var jproduk_stat_dokSearchField;
var dt= new Date();

var cetak_jproduk=0;
var looping=0;

var temp_pajakField= new Ext.form.TextArea({
	id: 'temp_pajakField',
	maxLength: 5,
	anchor: '95%'
});

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	Ext.util.Format.comboRenderer = function(combo){
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}

/*Function utk ReadOnly */
Ext.override(Ext.form.Field, {
    setReadOnly: function(readOnly) {
        if (readOnly == this.readOnly) {
            return;
        }
        this.readOnly = readOnly;
        if (readOnly) {
            this.el.dom.setAttribute('readOnly', true);
        } else {
            this.el.dom.removeAttribute('readOnly');
        }
    }
});	
	
	/*Data Store khusus utk menampung welcome mesage */
	jproduk_welcome_msgDataStore = new Ext.data.Store({
		id: 'jproduk_welcome_msgDataStore ',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_welcome_msg&m=get_welcome_message', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results'
		},[
			{name: 'welcome_id', type: 'int', mapping: 'welcome_id'},
			{name: 'welcome_msg', type: 'string', mapping: 'welcome_msg'},
			{name: 'welcome_title', type: 'string', mapping: 'welcome_title'},
			{name: 'welcome_icon', type: 'string', mapping: 'welcome_icon'}
		]),
		sortInfo:{field: 'welcome_id', direction: "ASC"}
	});

	/*
	jproduk_welcome_msgDataStore.load({
		params: {task : "LIST", menu_id : 37},
			callback: function(opts, success, response)  {
				if (success) {					
					if(jproduk_welcome_msgDataStore.getCount()){
						if (jproduk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'INFO') {
							var jproduk_icon = Ext.MessageBox.INFO;
						} else if (jproduk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'WARNING'){
							var jproduk_icon = Ext.MessageBox.WARNING;
						} else if (jproduk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'QUESTION'){
							var jproduk_icon = Ext.MessageBox.QUESTION;
						} else if (jproduk_welcome_msgDataStore.getAt(0).data.welcome_icon == 'ERROR'){
							var jproduk_icon = Ext.MessageBox.ERROR;
						}
						Ext.MessageBox.show({
							title: jproduk_welcome_msgDataStore.getAt(0).data.welcome_title,
							msg: jproduk_welcome_msgDataStore.getAt(0).data.welcome_msg,
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: jproduk_icon
						});
					}
				}
			}
	});
*/
	
	function jproduk_cetak(master_id){ 
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_produk&m=print_paper',
			params: { jproduk_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					jproduk_btn_cancel();
					Ext.MessageBox.hide();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
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
	
	function jproduk_cetak2(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_produk&m=print_paper2',
			params: { jproduk_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper2.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					jproduk_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
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
	
	function jproduk_cetak_print_only(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_produk&m=print_only',
			params: { jproduk_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					jproduk_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
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
	
	function jproduk_cetak_print_only2(master_id){ 
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_produk&m=print_only2',
			params: { jproduk_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jproduk_paper2.html','Cetak Penjualan Produk','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
					jproduk_btn_cancel();
					break;
				default:
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Unable to print the grid!',
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
  
	/*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var jproduk_tanggal_create_date = "";
		if(jproduk_tanggalField.getValue()!== ""){jproduk_tanggal_create_date = jproduk_tanggalField.getValue().format('Y-m-d');} 
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_jual_produk&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: jproduk_tanggal_create_date
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						if (jproduk_diskonField.getValue()!=0 && jproduk_cashback_cfField.getValue()!=0){
							Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Diskon tambahan dan Voucher hanya bisa diisi salah satu',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARNING
						});
						} 
						else
						{
							master_jual_produk_create();
						}
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penjualan Produk tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
  
  	/* Function for add data, open window create form */
	function master_jual_produk_create(){
		var dproduk_produk_id="";
		for(i=0; i<detail_jual_produk_DataStore.getCount(); i++){
			detail_jual_produk_record=detail_jual_produk_DataStore.getAt(i);
			if(/^\d+$/.test(detail_jual_produk_record.data.dproduk_produk)){
				dproduk_produk_id="ada";
			}
		}
		
		var jproduk_id_for_cetak = 0;
		if(jproduk_idField.getValue()!== null){
			jproduk_id_for_cetak = jproduk_idField.getValue();
		}
        
		if(jproduk_bayarField.getValue()>=0 && jproduk_bayarField.getValue()<=jproduk_totalField.getValue()){
			if(is_master_jual_produk_form_valid()
			   && dproduk_produk_id=="ada"
			   && ((/^\d+$/.test(jproduk_custField.getValue()) && jproduk_post2db=="CREATE") || jproduk_post2db=="UPDATE")
			   && jproduk_stat_dokField.getValue()=='Terbuka'){
				var jproduk_id_create_pk=null; 
				var jproduk_nobukti_create=null; 
				var jproduk_grooming_create=0; 
				var jproduk_cust_create=null; 
				var jproduk_tanggal_create_date=""; 
				var jproduk_diskon_create=null; 
				var jproduk_cara_create=null; 
				var jproduk_cara2_create=null; 
				var jproduk_cara3_create=null; 
				var jproduk_statdok_create=null;
				var jproduk_keterangan_create=null; 
				var jproduk_ket_disk_create=null; 
				//tunai
				var jproduk_tunai_nilai_create=null;
				//tunai-2
				var jproduk_tunai_nilai2_create=null;
				//tunai-3
				var jproduk_tunai_nilai3_create=null;
				//voucher
				var jproduk_voucher_no_create="";
				var jproduk_voucher_cashback_create=null;
				//voucher-2
				var jproduk_voucher_no2_create="";
				var jproduk_voucher_cashback2_create=null;
				//voucher-3
				var jproduk_voucher_no3_create="";
				var jproduk_voucher_cashback3_create=null;
				
				var jproduk_cashback_create=null;
				//bayar
				var jproduk_subtotal_create=null;
				var jproduk_total_create=null;
				var jproduk_bayar_create=null;
				var jproduk_hutang_create=null;
				//kwitansi
				var jproduk_kwitansi_nama_create="";
				var jproduk_kwitansi_nomor_create="";
				var jproduk_kwitansi_nilai_create=null;
				//kwitansi-2
				var jproduk_kwitansi_nama2_create="";
				var jproduk_kwitansi_nomor2_create="";
				var jproduk_kwitansi_nilai2_create=null;
				//kwitansi-3
				var jproduk_kwitansi_nama3_create="";
				var jproduk_kwitansi_nomor3_create="";
				var jproduk_kwitansi_nilai3_create=null;
				//card
				var jproduk_card_nama_create="";
				var jproduk_card_edc_create="";
				var jproduk_card_no_create="";
				var jproduk_card_nilai_create=null;
				//card-2
				var jproduk_card_nama2_create="";
				var jproduk_card_edc2_create="";
				var jproduk_card_no2_create="";
				var jproduk_card_nilai2_create=null;
				//card-3
				var jproduk_card_nama3_create="";
				var jproduk_card_edc3_create="";
				var jproduk_card_no3_create="";
				var jproduk_card_nilai3_create=null;
				//cek
				var jproduk_cek_nama_create="";
				var jproduk_cek_nomor_create="";
				var jproduk_cek_valid_create="";
				var jproduk_cek_bank_create="";
				var jproduk_cek_nilai_create=null;
				//cek-2
				var jproduk_cek_nama2_create="";
				var jproduk_cek_nomor2_create="";
				var jproduk_cek_valid2_create="";
				var jproduk_cek_bank2_create="";
				var jproduk_cek_nilai2_create=null;
				//cek-3
				var jproduk_cek_nama3_create="";
				var jproduk_cek_nomor3_create="";
				var jproduk_cek_valid3_create="";
				var jproduk_cek_bank3_create="";
				var jproduk_cek_nilai3_create=null;
				//transfer
				var jproduk_transfer_bank_create="";
				var jproduk_transfer_nama_create="";
				var jproduk_transfer_nilai_create=null;
				//transfer-2
				var jproduk_transfer_bank2_create="";
				var jproduk_transfer_nama2_create="";
				var jproduk_transfer_nilai2_create=null;
				//transfer-3
				var jproduk_transfer_bank3_create="";
				var jproduk_transfer_nama3_create="";
				var jproduk_transfer_nilai3_create=null;
				
				if(jproduk_idField.getValue()!== null){jproduk_id_create_pk = jproduk_idField.getValue();}else{jproduk_id_create_pk=get_jproduk_pk();} 
				if(jproduk_nobuktiField.getValue()!== null){jproduk_nobukti_create = jproduk_nobuktiField.getValue();}
				if(jproduk_karyawanField.getValue()!== null){jproduk_grooming_create = jproduk_karyawanField.getValue();}				
				if((jproduk_post2db=="CREATE") && (jproduk_custField.getValue()!== null)){
					jproduk_cust_create = jproduk_custField.getValue();
				}else if(jproduk_post2db=="UPDATE"){
					jproduk_cust_create = jproduk_cust_idField.getValue();
				}
				if(jproduk_tanggalField.getValue()!== ""){jproduk_tanggal_create_date = jproduk_tanggalField.getValue().format('Y-m-d');} 
				if(jproduk_diskonField.getValue()!== null){jproduk_diskon_create = jproduk_diskonField.getValue();} 
				if(jproduk_caraField.getValue()!== null){jproduk_cara_create = jproduk_caraField.getValue();} 
				if(jproduk_cara2Field.getValue()!== null){jproduk_cara2_create = jproduk_cara2Field.getValue();} 
				if(jproduk_cara3Field.getValue()!== null){jproduk_cara3_create = jproduk_cara3Field.getValue();} 
				if(jproduk_stat_dokField.getValue()!== null){jproduk_statdok_create = jproduk_stat_dokField.getValue();} 
				if(jproduk_keteranganField.getValue()!== null){jproduk_keterangan_create = jproduk_keteranganField.getValue();}
				if(jproduk_ket_diskField.getValue()!== null){jproduk_ket_disk_create = jproduk_ket_diskField.getValue();} 				
				//tunai
				if(jproduk_tunai_nilaiField.getValue()!== null){jproduk_tunai_nilai_create = jproduk_tunai_nilaiField.getValue();}
				//tunai-2
				if(jproduk_tunai_nilai2Field.getValue()!== null){jproduk_tunai_nilai2_create = jproduk_tunai_nilai2Field.getValue();}
				//tunai-3
				if(jproduk_tunai_nilai3Field.getValue()!== null){jproduk_tunai_nilai3_create = jproduk_tunai_nilai3Field.getValue();}
				//voucher
				if(jproduk_voucher_noField.getValue()!== ""){jproduk_voucher_no_create = jproduk_voucher_noField.getValue();}
				if(jproduk_voucher_cashbackField.getValue()!== null){jproduk_voucher_cashback_create = jproduk_voucher_cashbackField.getValue();} 
				//voucher-2
				if(jproduk_voucher_no2Field.getValue()!== ""){jproduk_voucher_no2_create = jproduk_voucher_no2Field.getValue();} 
				if(jproduk_voucher_cashback2Field.getValue()!== null){jproduk_voucher_cashback2_create = jproduk_voucher_cashback2Field.getValue();} 
				//voucher-3
				if(jproduk_voucher_no3Field.getValue()!== ""){jproduk_voucher_no3_create = jproduk_voucher_no3Field.getValue();} 
				if(jproduk_voucher_cashback3Field.getValue()!== null){jproduk_voucher_cashback3_create = jproduk_voucher_cashback3Field.getValue();} 
				
				if(jproduk_cashbackField.getValue()!== null){jproduk_cashback_create = jproduk_cashbackField.getValue();} 
				//bayar
				if(jproduk_bayarField.getValue()!== null){jproduk_bayar_create = jproduk_bayarField.getValue();}
				if(jproduk_subTotalField.getValue()!== null){jproduk_subtotal_create = jproduk_subTotalField.getValue();} 
				if(jproduk_totalField.getValue()!== null){jproduk_total_create = jproduk_totalField.getValue();} 
				if(jproduk_hutangField.getValue()!== null){jproduk_hutang_create = jproduk_hutangField.getValue();} 
				//kwitansi value
				if(jproduk_kwitansi_namaField.getValue()!== ""){jproduk_kwitansi_nama_create = jproduk_kwitansi_namaField.getValue();} 
				if(jproduk_kwitansi_nilaiField.getValue()!== null){jproduk_kwitansi_nilai_create = jproduk_kwitansi_nilaiField.getValue();} 
				if(jproduk_kwitansi_nama2Field.getValue()!== ""){jproduk_kwitansi_nama2_create = jproduk_kwitansi_nama2Field.getValue();} 
				if(jproduk_kwitansi_nilai2Field.getValue()!== null){jproduk_kwitansi_nilai2_create = jproduk_kwitansi_nilai2Field.getValue();} 
				/*
				if((jproduk_kwitansi_noField.getValue()!=="") && (jproduk_post2db=='CREATE')){
					jproduk_kwitansi_nomor_create = jproduk_kwitansi_noField.getValue();
				}else if(jproduk_post2db=='UPDATE'){
					jproduk_kwitansi_nomor_create = jproduk_kwitansi_noField.getValue();
					//jproduk_kwitansi_nomor_create = jproduk_kwitansi_idField.getValue();
				}
				//kwitansi-2 value
				if((jproduk_kwitansi_no2Field.getValue()!=="") && (jproduk_post2db=='CREATE')){
					jproduk_kwitansi_nomor2_create = jproduk_kwitansi_no2Field.getValue();
				}else if(jproduk_post2db=='UPDATE'){
					jproduk_kwitansi_nomor2_create = jproduk_kwitansi_id2Field.getValue();
				}
				//kwitansi-3 value
				if((jproduk_kwitansi_no3Field.getValue()!=="") && (jproduk_post2db=='CREATE')){
					jproduk_kwitansi_nomor3_create = jproduk_kwitansi_no3Field.getValue();
				}else if(jproduk_post2db=='UPDATE'){
					jproduk_kwitansi_nomor3_create = jproduk_kwitansi_id3Field.getValue();
				}
				*/
				if(jproduk_kwitansi_nama3Field.getValue()!== ""){jproduk_kwitansi_nama3_create = jproduk_kwitansi_nama3Field.getValue();} 
				if(jproduk_kwitansi_nilai3Field.getValue()!== null){jproduk_kwitansi_nilai3_create = jproduk_kwitansi_nilai3Field.getValue();} 
				//card value
				if(jproduk_card_namaField.getValue()!== ""){jproduk_card_nama_create = jproduk_card_namaField.getValue();} 
				if(jproduk_card_edcField.getValue()!==""){jproduk_card_edc_create = jproduk_card_edcField.getValue();} 
				if(jproduk_card_noField.getValue()!==""){jproduk_card_no_create = jproduk_card_noField.getValue();}
				if(jproduk_card_nilaiField.getValue()!==null){jproduk_card_nilai_create = jproduk_card_nilaiField.getValue();} 
				//card-2 value
				if(jproduk_card_nama2Field.getValue()!== ""){jproduk_card_nama2_create = jproduk_card_nama2Field.getValue();} 
				if(jproduk_card_edc2Field.getValue()!==""){jproduk_card_edc2_create = jproduk_card_edc2Field.getValue();} 
				if(jproduk_card_no2Field.getValue()!==""){jproduk_card_no2_create = jproduk_card_no2Field.getValue();}
				if(jproduk_card_nilai2Field.getValue()!==null){jproduk_card_nilai2_create = jproduk_card_nilai2Field.getValue();} 
				//card-3 value
				if(jproduk_card_nama3Field.getValue()!== ""){jproduk_card_nama3_create = jproduk_card_nama3Field.getValue();} 
				if(jproduk_card_edc3Field.getValue()!==""){jproduk_card_edc3_create = jproduk_card_edc3Field.getValue();} 
				if(jproduk_card_no3Field.getValue()!==""){jproduk_card_no3_create = jproduk_card_no3Field.getValue();}
				if(jproduk_card_nilai3Field.getValue()!==null){jproduk_card_nilai3_create = jproduk_card_nilai3Field.getValue();} 
				//cek value
				if(jproduk_cek_namaField.getValue()!== ""){jproduk_cek_nama_create = jproduk_cek_namaField.getValue();} 
				if(jproduk_cek_noField.getValue()!== ""){jproduk_cek_nomor_create = jproduk_cek_noField.getValue();} 
				if(jproduk_cek_validField.getValue()!== ""){jproduk_cek_valid_create = jproduk_cek_validField.getValue().format('Y-m-d');} 
				if(jproduk_cek_bankField.getValue()!== ""){jproduk_cek_bank_create = jproduk_cek_bankField.getValue();} 
				if(jproduk_cek_nilaiField.getValue()!== null){jproduk_cek_nilai_create = jproduk_cek_nilaiField.getValue();} 
				//cek-2 value
				if(jproduk_cek_nama2Field.getValue()!== ""){jproduk_cek_nama2_create = jproduk_cek_nama2Field.getValue();} 
				if(jproduk_cek_no2Field.getValue()!== ""){jproduk_cek_nomor2_create = jproduk_cek_no2Field.getValue();} 
				if(jproduk_cek_valid2Field.getValue()!== ""){jproduk_cek_valid2_create = jproduk_cek_valid2Field.getValue().format('Y-m-d');} 
				if(jproduk_cek_bank2Field.getValue()!== ""){jproduk_cek_bank2_create = jproduk_cek_bank2Field.getValue();} 
				if(jproduk_cek_nilai2Field.getValue()!== null){jproduk_cek_nilai2_create = jproduk_cek_nilai2Field.getValue();} 
				//cek-3 value
				if(jproduk_cek_nama3Field.getValue()!== ""){jproduk_cek_nama3_create = jproduk_cek_nama3Field.getValue();} 
				if(jproduk_cek_no3Field.getValue()!== ""){jproduk_cek_nomor3_create = jproduk_cek_no3Field.getValue();} 
				if(jproduk_cek_valid3Field.getValue()!== ""){jproduk_cek_valid3_create = jproduk_cek_valid3Field.getValue().format('Y-m-d');} 
				if(jproduk_cek_bank3Field.getValue()!== ""){jproduk_cek_bank3_create = jproduk_cek_bank3Field.getValue();} 
				if(jproduk_cek_nilai3Field.getValue()!== null){jproduk_cek_nilai3_create = jproduk_cek_nilai3Field.getValue();} 
				//transfer value
				if(jproduk_transfer_bankField.getValue()!== ""){jproduk_transfer_bank_create = jproduk_transfer_bankField.getValue();} 
				if(jproduk_transfer_namaField.getValue()!== ""){jproduk_transfer_nama_create = jproduk_transfer_namaField.getValue();}
				if(jproduk_transfer_nilaiField.getValue()!== null){jproduk_transfer_nilai_create = jproduk_transfer_nilaiField.getValue();} 
				//transfer-2 value
				if(jproduk_transfer_bank2Field.getValue()!== ""){jproduk_transfer_bank2_create = jproduk_transfer_bank2Field.getValue();} 
				if(jproduk_transfer_nama2Field.getValue()!== ""){jproduk_transfer_nama2_create = jproduk_transfer_nama2Field.getValue();}
				if(jproduk_transfer_nilai2Field.getValue()!== null){jproduk_transfer_nilai2_create = jproduk_transfer_nilai2Field.getValue();} 
				//transfer-3 value
				if(jproduk_transfer_bank3Field.getValue()!== ""){jproduk_transfer_bank3_create = jproduk_transfer_bank3Field.getValue();} 
				if(jproduk_transfer_nama3Field.getValue()!== ""){jproduk_transfer_nama3_create = jproduk_transfer_nama3Field.getValue();}
				if(jproduk_transfer_nilai3Field.getValue()!== null){jproduk_transfer_nilai3_create = jproduk_transfer_nilai3Field.getValue();}
				
				var cetak_jproduk = this.cetak_jproduk;
				var dproduk_id=[];
				var dproduk_produk=[];
				var dproduk_karyawan=[];
				var dproduk_satuan=[];
				var dproduk_jumlah=[];
				var dproduk_harga=[];
				var dproduk_diskon=[];
				var dproduk_diskon_jenis=[];
				var dcount = detail_jual_produk_DataStore.getCount() - 1;
				
				if(detail_jual_produk_DataStore.getCount()>0){
					for(i=0; i<detail_jual_produk_DataStore.getCount();i++){
						if((/^\d+$/.test(detail_jual_produk_DataStore.getAt(i).data.dproduk_produk))
						   && detail_jual_produk_DataStore.getAt(i).data.dproduk_produk!==undefined
						   && detail_jual_produk_DataStore.getAt(i).data.dproduk_produk!==''
						   && detail_jual_produk_DataStore.getAt(i).data.dproduk_produk!==0){
							
							dproduk_id.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_id);
							dproduk_produk.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_produk);
							
							if((detail_jual_produk_DataStore.getAt(i).data.dproduk_satuan==undefined)
							   || (detail_jual_produk_DataStore.getAt(i).data.dproduk_satuan=='')){
								dproduk_satuan.push(0);
							}else{
								dproduk_satuan.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_satuan);
							}
							
							if(detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah==undefined){
								dproduk_jumlah.push(0);
							}else{
								dproduk_jumlah.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah);
							}
							
							if(detail_jual_produk_DataStore.getAt(i).data.dproduk_harga==undefined){
								dproduk_harga.push(0);
							}else{
								dproduk_harga.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_harga);
							}
							
							if(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon_jenis==undefined){
								dproduk_diskon_jenis.push('');
							}else{
								dproduk_diskon_jenis.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon_jenis);
							}
							
							if((detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon==undefined)
							   || (detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon=='')){
								dproduk_diskon.push(0);
							}else{
								dproduk_diskon.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon);
							}
							
							if((detail_jual_produk_DataStore.getAt(i).data.dproduk_karyawan==undefined)
							   || (detail_jual_produk_DataStore.getAt(i).data.dproduk_karyawan=='')){
								dproduk_karyawan.push(0);
							}else{
								dproduk_karyawan.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_karyawan);
							}
						}
						
						if(i==dcount){
							var encoded_array_dproduk_id = Ext.encode(dproduk_id);
							var encoded_array_dproduk_produk = Ext.encode(dproduk_produk);
							var encoded_array_dproduk_satuan = Ext.encode(dproduk_satuan);
							var encoded_array_dproduk_jumlah = Ext.encode(dproduk_jumlah);
							var encoded_array_dproduk_harga = Ext.encode(dproduk_harga);
							var encoded_array_dproduk_diskon_jenis = Ext.encode(dproduk_diskon_jenis);
							var encoded_array_dproduk_diskon = Ext.encode(dproduk_diskon);
							var encoded_array_dproduk_karyawan = Ext.encode(dproduk_karyawan);
							
							Ext.Ajax.request({
								waitMsg: 'Mohon tunggu...',
								url: 'index.php?c=c_master_jual_produk&m=get_action',
								params: {
									task: jproduk_post2db,
									cetak_jproduk:cetak_jproduk,
									jproduk_id			: 	jproduk_id_create_pk, 
									jproduk_grooming	:	jproduk_grooming_create,
									jproduk_nobukti		: 	jproduk_nobukti_create, 
									jproduk_cust		: 	jproduk_cust_create, 
									jproduk_tanggal		: 	jproduk_tanggal_create_date, 
									jproduk_diskon		: 	jproduk_diskon_create, 
									jproduk_cara		: 	jproduk_cara_create, 
									jproduk_cara2		: 	jproduk_cara2_create, 
									jproduk_cara3		: 	jproduk_cara3_create, 
									jproduk_stat_dok	:	jproduk_statdok_create,
									jproduk_keterangan	: 	jproduk_keterangan_create, 
									jproduk_ket_disk	: 	jproduk_ket_disk_create, 
									jproduk_cashback	: 	jproduk_cashback_create,
									//tunai
									jproduk_tunai_nilai	:	jproduk_tunai_nilai_create,
									//tunai-2
									jproduk_tunai_nilai2	:	jproduk_tunai_nilai2_create,
									//tunai-3
									jproduk_tunai_nilai3	:	jproduk_tunai_nilai3_create,
									//voucher
									jproduk_voucher_no	:	jproduk_voucher_no_create,
									jproduk_voucher_cashback	:	jproduk_voucher_cashback_create,
									//voucher-2
									jproduk_voucher_no2	:	jproduk_voucher_no2_create,
									jproduk_voucher_cashback2	:	jproduk_voucher_cashback2_create,
									//voucher-3
									jproduk_voucher_no3	:	jproduk_voucher_no3_create,
									jproduk_voucher_cashback3	:	jproduk_voucher_cashback3_create,
									
									//bayar
									jproduk_bayar			: 	jproduk_bayar_create,
									jproduk_subtotal			: 	jproduk_subtotal_create,
									jproduk_total			: 	jproduk_total_create,
									jproduk_hutang		: 	jproduk_hutang_create,
									//kwitansi posting
									jual_kwitansi_id			: 	jproduk_jual_kwitansi_idField1.getValue(),
									jproduk_kwitansi_no			:	jproduk_kwitansi_noField.getValue(),
									jproduk_kwitansi_nama		:	jproduk_kwitansi_nama_create,
									jproduk_kwitansi_nilai		:	jproduk_kwitansi_nilai_create,
									//kwitansi-2 posting
									jual_kwitansi_id2			: 	jproduk_jual_kwitansi_idField2.getValue(),
									jproduk_kwitansi_no2		:	jproduk_kwitansi_no2Field.getValue(),
									jproduk_kwitansi_nama2		:	jproduk_kwitansi_nama2_create,
									jproduk_kwitansi_nilai2		:	jproduk_kwitansi_nilai2_create,
									//kwitansi-3 posting
									jual_kwitansi_id3			: 	jproduk_jual_kwitansi_idField3.getValue(),
									jproduk_kwitansi_no3		:	jproduk_kwitansi_no3Field.getValue(),
									jproduk_kwitansi_nama3		:	jproduk_kwitansi_nama3_create,
									jproduk_kwitansi_nilai3		:	jproduk_kwitansi_nilai3_create,
									//card posting
									jproduk_card_nama	: 	jproduk_card_nama_create,
									jproduk_card_edc	:	jproduk_card_edc_create,
									jproduk_card_no		:	jproduk_card_no_create,
									jproduk_card_nilai	:	jproduk_card_nilai_create,
									//card-2 posting
									jproduk_card_nama2	: 	jproduk_card_nama2_create,
									jproduk_card_edc2	:	jproduk_card_edc2_create,
									jproduk_card_no2	:	jproduk_card_no2_create,
									jproduk_card_nilai2	:	jproduk_card_nilai2_create,
									//card-3 posting
									jproduk_card_nama3	: 	jproduk_card_nama3_create,
									jproduk_card_edc3	:	jproduk_card_edc3_create,
									jproduk_card_no3	:	jproduk_card_no3_create,
									jproduk_card_nilai3	:	jproduk_card_nilai3_create,
									//cek posting
									jproduk_cek_nama	: 	jproduk_cek_nama_create,
									jproduk_cek_no		:	jproduk_cek_nomor_create,
									jproduk_cek_valid	: 	jproduk_cek_valid_create,
									jproduk_cek_bank	:	jproduk_cek_bank_create,
									jproduk_cek_nilai	:	jproduk_cek_nilai_create,
									//cek-2 posting
									jproduk_cek_nama2	: 	jproduk_cek_nama2_create,
									jproduk_cek_no2		:	jproduk_cek_nomor2_create,
									jproduk_cek_valid2	: 	jproduk_cek_valid2_create,
									jproduk_cek_bank2	:	jproduk_cek_bank2_create,
									jproduk_cek_nilai2	:	jproduk_cek_nilai2_create,
									//cek-3 posting
									jproduk_cek_nama3	: 	jproduk_cek_nama3_create,
									jproduk_cek_no3		:	jproduk_cek_nomor3_create,
									jproduk_cek_valid3	: 	jproduk_cek_valid3_create,
									jproduk_cek_bank3	:	jproduk_cek_bank3_create,
									jproduk_cek_nilai3	:	jproduk_cek_nilai3_create,
									//transfer posting
									jproduk_transfer_bank	:	jproduk_transfer_bank_create,
									jproduk_transfer_nama	:	jproduk_transfer_nama_create,
									jproduk_transfer_nilai	:	jproduk_transfer_nilai_create,
									//transfer-2 posting
									jproduk_transfer_bank2	:	jproduk_transfer_bank2_create,
									jproduk_transfer_nama2	:	jproduk_transfer_nama2_create,
									jproduk_transfer_nilai2	:	jproduk_transfer_nilai2_create,
									//transfer-3 posting
									jproduk_transfer_bank3	:	jproduk_transfer_bank3_create,
									jproduk_transfer_nama3	:	jproduk_transfer_nama3_create,
									jproduk_transfer_nilai3	:	jproduk_transfer_nilai3_create,
									
									//Data Detail Penjualan Produk
									dproduk_id	: encoded_array_dproduk_id,
									dproduk_produk	: encoded_array_dproduk_produk,
									dproduk_satuan	: encoded_array_dproduk_satuan,
									dproduk_jumlah	: encoded_array_dproduk_jumlah,
									dproduk_harga	: encoded_array_dproduk_harga,
									dproduk_diskon_jenis	: encoded_array_dproduk_diskon_jenis,
									dproduk_diskon	: encoded_array_dproduk_diskon,
									dproduk_karyawan: encoded_array_dproduk_karyawan
								}, 
								success: function(response){
									Ext.MessageBox.hide();
									var result=eval(response.responseText);
									if(result==0){
										jproduk_btn_cancel();
										Ext.MessageBox.alert(jproduk_post2db+' OK','Data penjualan produk berhasil disimpan');
										master_jual_produk_createWindow.hide();
									}else if(result>0 && cetak_jproduk == 2){
										jproduk_cetak2(result);
										jproduk_btn_cancel();
									}else if(result>0){
										jproduk_cetak(result);
										jproduk_btn_cancel();
									}else{
										jproduk_btn_cancel();
										Ext.MessageBox.show({
										   title: 'Warning',
										   msg: 'Data penjualan produk tidak bisa disimpan',
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
										   msg: 'Could not connect to the database. retry later.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'database',
										   icon: Ext.MessageBox.ERROR
									});
									jproduk_btn_cancel();
								}                      
							});
						}
					}
				}
				
			}else if(jproduk_post2db=='UPDATE' && jproduk_stat_dokField.getValue()=='Tertutup'){
				if(cetak_jproduk==1){
					jproduk_cetak(jproduk_id_for_cetak);
					cetak_jproduk=0;
				}else if(cetak_jproduk==2){
					jproduk_cetak2(jproduk_id_for_cetak);
					cetak_jproduk=0;
				}
				jproduk_btn_cancel();
			}else if(jproduk_post2db=='UPDATE' && jproduk_stat_dokField.getValue()=='Batal'){
				Ext.Ajax.request({  
					waitMsg: 'Mohon  Tunggu...',
					url: 'index.php?c=c_master_jual_produk&m=get_action',
					params: {
						task: 'BATAL',
						jproduk_id	: jproduk_idField.getValue(),
						jproduk_tanggal : jproduk_tanggalField.getValue().format('Y-m-d')
					}, 
					success: function(response){             
						var result=eval(response.responseText);
						if(result==1){
							jproduk_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Dokumen Penjualan Produk telah dibatalkan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.OK
							});
							jproduk_btn_cancel();
						}else{
							jproduk_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 400,
							   msg: 'Dokumen Penjualan Produk tidak bisa dibatalkan, <br/>karena yang boleh dibatalkan adalah Dokumen yang terbit hari ini saja.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							jproduk_btn_cancel();
						}
					},
					failure: function(response){
						jproduk_post2db='CREATE';
						var result=response.responseText;
						Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
						});
						jproduk_btn_cancel();
					}                      
				});
			}else {
				if(dproduk_produk_id!="ada"){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Detail penjualan produk tidak boleh kosong',
						buttons: Ext.MessageBox.OK,
						minWidth: 250,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
				}else {
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Form anda belum lengkap',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
				}
			}
		}else{
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, kelebihan jumlah bayar.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
	
	function save_andPrint(){
		cetak_jproduk=1;
		pengecekan_dokumen();
		jproduk_pesanLabel.setText('');
		jproduk_lunasLabel.setText('');
		jproduk_cust_priorityLabel.setText('');
	}
	
	function save_andPrint2(){
		cetak_jproduk=2;
		pengecekan_dokumen();
		jproduk_pesanLabel.setText('');
		jproduk_lunasLabel.setText('');
		jproduk_cust_priorityLabel.setText('');
	}
	
	function save_button(){
		cetak_jproduk=0;
		pengecekan_dokumen();
	}
	
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function print_only(){
		if(jproduk_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		cetak_jproduk=1;		
		var jproduk_id_for_cetak = 0;
		if(jproduk_idField.getValue()!== null){
			jproduk_id_for_cetak = jproduk_idField.getValue();
		}
		if(cetak_jproduk==1){
			jproduk_cetak_print_only(jproduk_id_for_cetak);
			cetak_jproduk=0;
		}
		}
	}
	
	function print_only2(){
		if(jproduk_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		cetak_jproduk=2;		
		var jproduk_id_for_cetak = 0;
		if(jproduk_idField.getValue()!== null){
			jproduk_id_for_cetak = jproduk_idField.getValue();
		}
		if(cetak_jproduk==2){
			jproduk_cetak_print_only2(jproduk_id_for_cetak);
			cetak_jproduk=0;
		}
		}
	}
  
  	/* Function for get PK field */
	function get_jproduk_pk(){
		if(jproduk_post2db=='UPDATE')
			return master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_id');
		else 
			return 0;
	}
	/* End of Function  */
	
    /* Function for get PK field */
	function get_stat_dok(){
		if(jproduk_post2db=='UPDATE')
			return master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok');
		else 
			return 'Terbuka';
	}
	/* End of Function  */
	
	// Reset kwitansi option
	function kwitansi_jual_produk_reset_form(){
		jproduk_kwitansi_namaField.reset();
		jproduk_kwitansi_nilaiField.reset();
		jproduk_kwitansi_nilai_cfField.reset();
		jproduk_kwitansi_noField.reset();
		jproduk_kwitansi_sisaField.reset();
		jproduk_kwitansi_namaField.setValue("");
		jproduk_kwitansi_nilaiField.setValue(null);
		jproduk_kwitansi_nilai_cfField.setValue(null);
		jproduk_kwitansi_noField.setValue("");
		jproduk_kwitansi_sisaField.setValue(null);
		jproduk_jual_kwitansi_idField1.reset();
		jproduk_jual_kwitansi_idField1.setValue(null);
	}
	// Reset kwitansi-2 option
	function kwitansi2_jual_produk_reset_form(){
		jproduk_kwitansi_nama2Field.reset();
		jproduk_kwitansi_nilai2Field.reset();
		jproduk_kwitansi_nilai2_cfField.reset();
		jproduk_kwitansi_no2Field.reset();
		jproduk_kwitansi_sisa2Field.reset();
		jproduk_kwitansi_nama2Field.setValue("");
		jproduk_kwitansi_nilai2Field.setValue(null);
		jproduk_kwitansi_nilai2_cfField.setValue(null);
		jproduk_kwitansi_no2Field.setValue("");
		jproduk_kwitansi_sisa2Field.setValue(null);
		jproduk_jual_kwitansi_idField2.reset();
		jproduk_jual_kwitansi_idField2.setValue(null);
	}
	// Reset kwitansi-3 option
	function kwitansi3_jual_produk_reset_form(){
		jproduk_kwitansi_nama3Field.reset();
		jproduk_kwitansi_nilai3Field.reset();
		jproduk_kwitansi_nilai3_cfField.reset();
		jproduk_kwitansi_no3Field.reset();
		jproduk_kwitansi_sisa3Field.reset();
		jproduk_kwitansi_nama3Field.setValue("");
		jproduk_kwitansi_nilai3Field.setValue(null);
		jproduk_kwitansi_nilai3_cfField.setValue(null);
		jproduk_kwitansi_no3Field.setValue("");
		jproduk_kwitansi_sisa3Field.setValue(null);
		jproduk_jual_kwitansi_idField3.reset();
		jproduk_jual_kwitansi_idField3.setValue(null);
	}
	
	// Reset card option
	function card_jual_produk_reset_form(){
		jproduk_card_namaField.reset();
		jproduk_card_edcField.reset();
		jproduk_card_noField.reset();
		jproduk_card_nilaiField.reset();
		jproduk_card_nilai_cfField.reset();
		jproduk_card_namaField.setValue("");
		jproduk_card_edcField.setValue("");
		jproduk_card_noField.setValue("");
		jproduk_card_nilaiField.setValue(null);
		jproduk_card_nilai_cfField.setValue(null);
	}
	// Reset card-2 option
	function card2_jual_produk_reset_form(){
		jproduk_card_nama2Field.reset();
		jproduk_card_edc2Field.reset();
		jproduk_card_no2Field.reset();
		jproduk_card_nilai2Field.reset();
		jproduk_card_nilai2_cfField.reset();
		jproduk_card_nama2Field.setValue("");
		jproduk_card_edc2Field.setValue("");
		jproduk_card_no2Field.setValue("");
		jproduk_card_nilai2Field.setValue(null);
		jproduk_card_nilai2_cfField.setValue(null);
	}
	// Reset card-3 option
	function card3_jual_produk_reset_form(){
		jproduk_card_nama3Field.reset();
		jproduk_card_edc3Field.reset();
		jproduk_card_no3Field.reset();
		jproduk_card_nilai3Field.reset();
		jproduk_card_nilai3_cfField.reset();
		jproduk_card_nama3Field.setValue("");
		jproduk_card_edc3Field.setValue("");
		jproduk_card_no3Field.setValue("");
		jproduk_card_nilai3Field.setValue(null);
		jproduk_card_nilai3_cfField.setValue(null);
	}
	
	// Reset cek option
	function cek_jual_produk_reset_form(){
		jproduk_cek_namaField.reset();
		jproduk_cek_noField.reset();
		jproduk_cek_validField.reset();
		jproduk_cek_bankField.reset();
		jproduk_cek_nilaiField.reset();
		jproduk_cek_nilai_cfField.reset();
		jproduk_cek_namaField.setValue(null);
		jproduk_cek_noField.setValue("");
		jproduk_cek_validField.setValue("");
		jproduk_cek_bankField.setValue("");
		jproduk_cek_nilaiField.setValue(null);
		jproduk_cek_nilai_cfField.setValue(null);
	}
	// Reset cek-2 option
	function cek2_jual_produk_reset_form(){
		jproduk_cek_nama2Field.reset();
		jproduk_cek_no2Field.reset();
		jproduk_cek_valid2Field.reset();
		jproduk_cek_bank2Field.reset();
		jproduk_cek_nilai2Field.reset();
		jproduk_cek_nilai2_cfField.reset();
		jproduk_cek_nama2Field.setValue(null);
		jproduk_cek_no2Field.setValue("");
		jproduk_cek_valid2Field.setValue("");
		jproduk_cek_bank2Field.setValue("");
		jproduk_cek_nilai2Field.setValue(null);
		jproduk_cek_nilai2_cfField.setValue(null);
	}
	// Reset cek-3 option
	function cek3_jual_produk_reset_form(){
		jproduk_cek_nama3Field.reset();
		jproduk_cek_no3Field.reset();
		jproduk_cek_valid3Field.reset();
		jproduk_cek_bank3Field.reset();
		jproduk_cek_nilai3Field.reset();
		jproduk_cek_nilai3_cfField.reset();
		jproduk_cek_nama3Field.setValue(null);
		jproduk_cek_no3Field.setValue("");
		jproduk_cek_valid3Field.setValue("");
		jproduk_cek_bank3Field.setValue("");
		jproduk_cek_nilai3Field.setValue(null);
		jproduk_cek_nilai3_cfField.setValue(null);
	}
	
	// Reset transfer option
	function transfer_jual_produk_reset_form(){
		jproduk_transfer_bankField.reset();
		jproduk_transfer_namaField.reset();
		jproduk_transfer_nilaiField.reset();
		jproduk_transfer_nilai_cfField.reset();
		jproduk_transfer_bankField.setValue("");
		jproduk_transfer_namaField.setValue(null);
		jproduk_transfer_nilaiField.setValue(null);
		jproduk_transfer_nilai_cfField.setValue(null);
	}
	// Reset transfer-2 option
	function transfer2_jual_produk_reset_form(){
		jproduk_transfer_bank2Field.reset();
		jproduk_transfer_nama2Field.reset();
		jproduk_transfer_nilai2Field.reset();
		jproduk_transfer_nilai2_cfField.reset();
		jproduk_transfer_bank2Field.setValue("");
		jproduk_transfer_nama2Field.setValue(null);
		jproduk_transfer_nilai2Field.setValue(null);
		jproduk_transfer_nilai2_cfField.setValue(null);
	}
	// Reset transfer-3 option
	function transfer3_jual_produk_reset_form(){
		jproduk_transfer_bank3Field.reset();
		jproduk_transfer_nama3Field.reset();
		jproduk_transfer_nilai3Field.reset();
		jproduk_transfer_nilai3_cfField.reset();
		jproduk_transfer_bank3Field.setValue("");
		jproduk_transfer_nama3Field.setValue(null);
		jproduk_transfer_nilai3Field.setValue(null);
		jproduk_transfer_nilai3_cfField.setValue(null);
	}

	// Reset tunai option
	function tunai_jual_produk_reset_form(){
		jproduk_tunai_nilaiField.reset();
		jproduk_tunai_nilaiField.setValue(null);
		jproduk_tunai_nilai_cfField.reset();
		jproduk_tunai_nilai_cfField.setValue(null);
	}
	// Reset tunai-2 option
	function tunai2_jual_produk_reset_form(){
		jproduk_tunai_nilai2Field.reset();
		jproduk_tunai_nilai2Field.setValue(null);
		jproduk_tunai_nilai2_cfField.reset();
		jproduk_tunai_nilai2_cfField.setValue(null);
	}
	// Reset tunai-3 option
	function tunai3_jual_produk_reset_form(){
		jproduk_tunai_nilai3Field.reset();
		jproduk_tunai_nilai3Field.setValue(null);
		jproduk_tunai_nilai3_cfField.reset();
		jproduk_tunai_nilai3_cfField.setValue(null);
	}

	//Reset voucher option
	function voucher_jual_produk_reset_form(){
		jproduk_voucher_noField.reset();
		jproduk_voucher_cashbackField.reset();
		jproduk_voucher_cashback_cfField.reset();
		jproduk_voucher_noField.setValue("");
		jproduk_voucher_cashbackField.setValue(null);
		jproduk_voucher_cashback_cfField.setValue(null);
	}
	//Reset voucher-2 option
	function voucher2_jual_produk_reset_form(){
		jproduk_voucher_no2Field.reset();
		jproduk_voucher_cashback2Field.reset();
		jproduk_voucher_cashback2_cfField.reset();
		jproduk_voucher_no2Field.setValue("");
		jproduk_voucher_cashback2Field.setValue(null);
		jproduk_voucher_cashback2_cfField.setValue(null);
	}
	//Reset voucher-3 option
	function voucher3_jual_produk_reset_form(){
		jproduk_voucher_no3Field.reset();
		jproduk_voucher_cashback3Field.reset();
		jproduk_voucher_cashback3_cfField.reset();
		jproduk_voucher_no3Field.setValue("");
		jproduk_voucher_cashback3Field.setValue(null);
		jproduk_voucher_cashback3_cfField.setValue(null);
	}
	
	/* Reset form before loading */
	function master_jual_produk_reset_form(){
		jproduk_idField.reset();
		jproduk_idField.setValue(null);
		jproduk_karyawanField.reset();
		jproduk_karyawanField.setValue(null);
		jproduk_nikkaryawanField.reset();
		jproduk_nikkaryawanField.setValue(null);
		jproduk_nobuktiField.reset();
		jproduk_nobuktiField.setValue(null);
		jproduk_custField.reset();
		jproduk_custField.setValue(null);
		jproduk_cust_nomemberField.reset();
		jproduk_cust_nomemberField.setValue(null);
		jproduk_valid_memberField.setValue("");
		jproduk_cust_ultahField.setValue("");
		jproduk_tanggalField.setValue(dt.format('Y-m-d'));
		jproduk_diskonField.reset();
		jproduk_diskonField.setValue(null);
		jproduk_stat_dokField.reset();
		jproduk_stat_dokField.setValue('Terbuka');
		jproduk_caraField.reset();
		jproduk_caraField.setValue(null);
		jproduk_cara2Field.reset();
		jproduk_cara2Field.setValue(null);
		jproduk_cara3Field.reset();
		jproduk_cara3Field.setValue(null);
		
		jproduk_cashbackField.reset();
		jproduk_cashbackField.setValue(null);
		jproduk_cashback_cfField.reset();
		jproduk_cashback_cfField.setValue(null);
		
		jproduk_ket_diskField.reset();
		jproduk_ket_diskField.setValue(null);
		
		jproduk_keteranganField.reset();
		jproduk_keteranganField.setValue(null);

		jproduk_subTotalField.reset();
		jproduk_subTotalField.setValue(null);
		jproduk_subTotal_cfField.reset();
		jproduk_subTotal_cfField.setValue(null);
		jproduk_subTotalLabel.reset();
		jproduk_subTotalLabel.setValue(null);

		jproduk_totalField.reset();
		jproduk_totalField.setValue(null);
		jproduk_total_cfField.reset();
		jproduk_total_cfField.setValue(null);
		jproduk_TotalLabel.reset();
		jproduk_TotalLabel.setValue(null);

		jproduk_hutangField.reset();
		jproduk_hutangField.setValue(null);
		jproduk_hutang_cfField.reset();
		jproduk_hutang_cfField.setValue(null);
		jproduk_HutangLabel.reset();
		jproduk_HutangLabel.setValue(null);

		jproduk_jumlahField.reset();
		jproduk_jumlahField.setValue(null);
		jproduk_jumlahLabel.reset();
		jproduk_jumlahLabel.setValue(null);
		
		jproduk_pesanLabel.setText("");

		tunai_jual_produk_reset_form();
		tunai2_jual_produk_reset_form();
		tunai3_jual_produk_reset_form();

		kwitansi_jual_produk_reset_form();
		kwitansi2_jual_produk_reset_form();
		kwitansi3_jual_produk_reset_form();

		card_jual_produk_reset_form();
		card2_jual_produk_reset_form();
		card3_jual_produk_reset_form();

		cek_jual_produk_reset_form();
		cek2_jual_produk_reset_form();
		cek3_jual_produk_reset_form();

		transfer_jual_produk_reset_form();
		transfer2_jual_produk_reset_form();
		transfer3_jual_produk_reset_form();

		voucher_jual_produk_reset_form();
		voucher2_jual_produk_reset_form();
		voucher3_jual_produk_reset_form();

		update_group_carabayar_jual_produk();
		update_group_carabayar2_jual_produk();
		update_group_carabayar3_jual_produk();

		jproduk_bayarField.reset();
		jproduk_bayarField.setValue(null);
		jproduk_bayar_cfField.reset();
		jproduk_bayar_cfField.setValue(null);
		jproduk_TotalBayarLabel.reset();
		jproduk_TotalBayarLabel.setValue(null);
		
		/* Enable if jpaket_post2db="CREATE" */
		jproduk_custField.setDisabled(false);
		jproduk_tanggalField.setDisabled(false);
		jproduk_karyawanField.setDisabled(false);
		jproduk_nikkaryawanField.setDisabled(false);
		jproduk_tanggalField.setDisabled(false);
		jproduk_keteranganField.setDisabled(false);
		master_cara_bayarTabPanel.setDisabled(false);
		detail_jual_produkListEditorGrid.setDisabled(false);
		jproduk_diskonField.setDisabled(false);
		jproduk_cashback_cfField.setDisabled(false);
		jproduk_ket_diskField.setDisabled(false);
		jproduk_stat_dokField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
		detail_jual_produkListEditorGrid.djproduk_add.enable();
        detail_jual_produkListEditorGrid.djproduk_delete.enable();
		<?php } ?>
		
		jproduk_caraField.setDisabled(false);
		master_jual_produk_tunaiGroup.setDisabled(false);
		master_jual_produk_cardGroup.setDisabled(false);
		master_jual_produk_cekGroup.setDisabled(false);
		master_jual_produk_kwitansiGroup.setDisabled(false);
		master_jual_produk_transferGroup.setDisabled(false);
		master_jual_produk_voucherGroup.setDisabled(false);
		
		jproduk_cara2Field.setDisabled(false);
		master_jual_produk_tunai2Group.setDisabled(false);
		master_jual_produk_card2Group.setDisabled(false);
		master_jual_produk_cek2Group.setDisabled(false);
		master_jual_produk_kwitansi2Group.setDisabled(false);
		master_jual_produk_transfer2Group.setDisabled(false);
		master_jual_produk_voucher2Group.setDisabled(false);
		
		jproduk_cara3Field.setDisabled(false);
		master_jual_produk_tunai3Group.setDisabled(false);
		master_jual_produk_card3Group.setDisabled(false);
		master_jual_produk_cek3Group.setDisabled(false);
		master_jual_produk_kwitansi3Group.setDisabled(false);
		master_jual_produk_transfer3Group.setDisabled(false);
		master_jual_produk_voucher3Group.setDisabled(false);
		
		combo_jual_produk.setDisabled(false);
		combo_satuan_produk.setDisabled(false);
		djumlah_beli_produkField.setDisabled(false);
		dharga_konversiField.setDisabled(false);
		dsub_totalField.setDisabled(false);
		djenis_diskonField.setDisabled(false);
		djumlah_diskonField.setDisabled(false);
		dsub_total_netField.setDisabled(false);
		combo_reveral.setDisabled(false);
		dharga_defaultField.setDisabled(false);
				
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
		master_jual_produk_createForm.jproduk_savePrint.enable();
		// master_jual_produk_createForm.jproduk_savePrint2.enable();
		master_jual_produk_createForm.PrintOnlyButton.disable();
		// master_jual_produk_createForm.PrintOnlyButton2.disable();
		<?php } ?>
	}
 	/* End of Function */
    
	/* setValue to EDIT */
	function master_jual_produk_set_form(){
		var hutang_temp=0;
		var subtotal_field=0;
		var dproduk_jumlah_field=0;
		var total_field=0;
		var hutang_field=0;
		var diskon_field=0;
		var cashback_field=0;
				
		jproduk_idField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_id'));
		jproduk_nobuktiField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_nobukti'));
		jproduk_karyawanField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('karyawan_nama'));
		jproduk_karyawan_idField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('karyawan_id'));
		jproduk_nikkaryawanField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('karyawan_no'));
		jproduk_custField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cust_edit'));
		jproduk_cust_idField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cust_id'));
		jproduk_tanggalField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_tanggal'));
		jproduk_caraField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cara'));
		jproduk_stat_dokField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok'));
		jproduk_cara2Field.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cara2'));
		jproduk_cara3Field.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cara3'));
		jproduk_diskonField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_diskon'));
		jproduk_cashbackField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cashback'));
		jproduk_ket_diskField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_ket_disk'));
		jproduk_cashback_cfField.setValue(CurrencyFormatted(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_cashback')));
		jproduk_bayarField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_bayar'));
		jproduk_bayar_cfField.setValue(CurrencyFormatted(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_bayar')));
		jproduk_TotalBayarLabel.setValue(CurrencyFormatted(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_bayar')));
		jproduk_keteranganField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_keterangan'));
		
		for(i=0;i<detail_jual_produk_DataStore.getCount();i++){
			subtotal_field+=detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah * detail_jual_produk_DataStore.getAt(i).data.dproduk_harga * ((100 - detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon)/100);
			dproduk_jumlah_field+=detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah;
		}
		if(jproduk_diskonField.getValue()!==""){
			diskon_field=jproduk_diskonField.getValue();
		}
		
		if(jproduk_cashbackField.getValue()!==""){
			cashback_field=jproduk_cashbackField.getValue();
		}
		total_field=subtotal_field*(100-diskon_field)/100-cashback_field;
		
		jproduk_jumlahField.setValue(dproduk_jumlah_field);
		jproduk_jumlahLabel.setValue(dproduk_jumlah_field);
		jproduk_subTotalField.setValue(subtotal_field);
		jproduk_subTotal_cfField.setValue(CurrencyFormatted(subtotal_field));
		jproduk_subTotalLabel.setValue(CurrencyFormatted(subtotal_field));
		
		jproduk_totalField.setValue(total_field);
		jproduk_total_cfField.setValue(CurrencyFormatted(total_field));
		jproduk_TotalLabel.setValue(CurrencyFormatted(total_field));
		
		hutang_temp=total_field-jproduk_bayarField.getValue();
		jproduk_hutangField.setValue(hutang_temp);
		jproduk_hutang_cfField.setValue(CurrencyFormatted(hutang_temp));
		jproduk_HutangLabel.setValue(CurrencyFormatted(hutang_temp));
		
		load_membership();
		load_karyawan();
		update_group_carabayar_jual_produk();
		update_group_carabayar2_jual_produk();
		update_group_carabayar3_jual_produk();
		
		switch(jproduk_caraField.getValue()){
			case 'kwitansi':
				kwitansi_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_produk_DataStore.getCount()){
								jproduk_kwitansi_record=kwitansi_jual_produk_DataStore.getAt(0).data;
								jproduk_kwitansi_idField.setValue(jproduk_kwitansi_record.kwitansi_id);
								jproduk_kwitansi_noField.setValue(jproduk_kwitansi_record.kwitansi_no);
								jproduk_kwitansi_namaField.setValue(jproduk_kwitansi_record.cust_nama);
								jproduk_kwitansi_sisaField.setValue(jproduk_kwitansi_record.kwitansi_sisa);
								jproduk_kwitansi_nilaiField.setValue(jproduk_kwitansi_record.jkwitansi_nilai);
								jproduk_kwitansi_nilai_cfField.setValue(CurrencyFormatted(jproduk_kwitansi_record.jkwitansi_nilai));
								jproduk_jual_kwitansi_idField1.setValue(jproduk_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							if(card_jual_produk_DataStore.getCount()){
								jproduk_card_record=card_jual_produk_DataStore.getAt(0).data;
								jproduk_card_namaField.setValue(jproduk_card_record.jcard_nama);
								jproduk_card_edcField.setValue(jproduk_card_record.jcard_edc);
								jproduk_card_noField.setValue(jproduk_card_record.jcard_no);
								jproduk_card_nilaiField.setValue(jproduk_card_record.jcard_nilai);
								jproduk_card_nilai_cfField.setValue(CurrencyFormatted(jproduk_card_record.jcard_nilai));
							}
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_produk_DataStore.getCount()){
									jproduk_cek_record=cek_jual_produk_DataStore.getAt(0).data;
									jproduk_cek_namaField.setValue(jproduk_cek_record.jcek_nama);
									jproduk_cek_noField.setValue(jproduk_cek_record.jcek_no);
									jproduk_cek_validField.setValue(jproduk_cek_record.jcek_valid);
									jproduk_cek_bankField.setValue(jproduk_cek_record.jcek_bank);
									jproduk_cek_nilaiField.setValue(jproduk_cek_record.jcek_nilai);
									jproduk_cek_nilai_cfField.setValue(CurrencyFormatted(jproduk_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(transfer_jual_produk_DataStore.getCount()){
										jproduk_transfer_record=transfer_jual_produk_DataStore.getAt(0);
										jproduk_transfer_bankField.setValue(jproduk_transfer_record.data.jtransfer_bank);
										jproduk_transfer_namaField.setValue(jproduk_transfer_record.data.jtransfer_nama);
										jproduk_transfer_nilaiField.setValue(jproduk_transfer_record.data.jtransfer_nilai);
										jproduk_transfer_nilai_cfField.setValue(CurrencyFormatted(jproduk_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_produk_DataStore.getCount()){
										jproduk_tunai_record=tunai_jual_produk_DataStore.getAt(0);
										jproduk_tunai_nilaiField.setValue(jproduk_tunai_record.data.jtunai_nilai);
										jproduk_tunai_nilai_cfField.setValue(CurrencyFormatted(jproduk_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_produk_DataStore.getCount()){
										jproduk_voucher_record=voucher_jual_produk_DataStore.getAt(0);
										jproduk_voucher_noField.setValue(jproduk_voucher_record.data.tvoucher_novoucher);
										jproduk_voucher_cashbackField.setValue(jproduk_voucher_record.data.tvoucher_nilai);
										jproduk_voucher_cashback_cfField.setValue(CurrencyFormatted(jproduk_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}

		switch(jproduk_cara2Field.getValue()){
			case 'kwitansi':
				kwitansi_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_produk_DataStore.getCount()){
								jproduk_kwitansi_record=kwitansi_jual_produk_DataStore.getAt(0).data;
								jproduk_kwitansi_id2Field.setValue(jproduk_kwitansi_record.kwitansi_id);
								jproduk_kwitansi_no2Field.setValue(jproduk_kwitansi_record.kwitansi_no);
								jproduk_kwitansi_nama2Field.setValue(jproduk_kwitansi_record.cust_nama);
								jproduk_kwitansi_nilai2Field.setValue(jproduk_kwitansi_record.jkwitansi_nilai);
								jproduk_kwitansi_nilai2_cfField.setValue(CurrencyFormatted(jproduk_kwitansi_record.jkwitansi_nilai));
								jproduk_jual_kwitansi_idField2.setValue(jproduk_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_jual_produk_DataStore.getCount()){
								 jproduk_card_record=card_jual_produk_DataStore.getAt(0).data;
								 jproduk_card_nama2Field.setValue(jproduk_card_record.jcard_nama);
								 jproduk_card_edc2Field.setValue(jproduk_card_record.jcard_edc);
								 jproduk_card_no2Field.setValue(jproduk_card_record.jcard_no);
								 jproduk_card_nilai2Field.setValue(jproduk_card_record.jcard_nilai);
								 jproduk_card_nilai2_cfField.setValue(CurrencyFormatted(jproduk_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_produk_DataStore.getCount()){
									jproduk_cek_record=cek_jual_produk_DataStore.getAt(0).data;
									jproduk_cek_nama2Field.setValue(jproduk_cek_record.jcek_nama);
									jproduk_cek_no2Field.setValue(jproduk_cek_record.jcek_no);
									jproduk_cek_valid2Field.setValue(jproduk_cek_record.jcek_valid);
									jproduk_cek_bank2Field.setValue(jproduk_cek_record.jcek_bank);
									jproduk_cek_nilai2Field.setValue(jproduk_cek_record.jcek_nilai);
									jproduk_cek_nilai2_cfField.setValue(CurrencyFormatted(jproduk_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								jproduk_transfer_record=transfer_jual_produk_DataStore.getAt(0);
									if(transfer_jual_produk_DataStore.getCount()){
										jproduk_transfer_record=transfer_jual_produk_DataStore.getAt(0);
										jproduk_transfer_bank2Field.setValue(jproduk_transfer_record.data.jtransfer_bank);
										jproduk_transfer_nama2Field.setValue(jproduk_transfer_record.data.jtransfer_nama);
										jproduk_transfer_nilai2Field.setValue(jproduk_transfer_record.data.jtransfer_nilai);
										jproduk_transfer_nilai2_cfField.setValue(CurrencyFormatted(jproduk_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_produk_DataStore.getCount()){
										jproduk_tunai_record=tunai_jual_produk_DataStore.getAt(0);
										jproduk_tunai_nilai2Field.setValue(jproduk_tunai_record.data.jtunai_nilai);
										jproduk_tunai_nilai2_cfField.setValue(CurrencyFormatted(jproduk_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_produk_DataStore.getCount()){
										jproduk_voucher_record=voucher_jual_produk_DataStore.getAt(0);
										jproduk_voucher_no2Field.setValue(jproduk_voucher_record.data.tvoucher_novoucher);
										jproduk_voucher_cashback2Field.setValue(jproduk_voucher_record.data.tvoucher_nilai);
										jproduk_voucher_cashback2_cfField.setValue(CurrencyFormatted(jproduk_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}

		switch(jproduk_cara3Field.getValue()){
			case 'kwitansi':
				kwitansi_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_produk_DataStore.getCount()){
								jproduk_kwitansi_record=kwitansi_jual_produk_DataStore.getAt(0).data;
								jproduk_kwitansi_id3Field.setValue(jproduk_kwitansi_record.kwitansi_id);
								jproduk_kwitansi_no3Field.setValue(jproduk_kwitansi_record.kwitansi_no);
								jproduk_kwitansi_nama3Field.setValue(jproduk_kwitansi_record.cust_nama);
								jproduk_kwitansi_nilai3Field.setValue(jproduk_kwitansi_record.jkwitansi_nilai);
								jproduk_kwitansi_nilai3_cfField.setValue(CurrencyFormatted(jproduk_kwitansi_record.jkwitansi_nilai));
								jproduk_jual_kwitansi_idField3.setValue(jproduk_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_jual_produk_DataStore.getCount()){
								 jproduk_card_record=card_jual_produk_DataStore.getAt(0).data;
								 jproduk_card_nama3Field.setValue(jproduk_card_record.jcard_nama);
								 jproduk_card_edc3Field.setValue(jproduk_card_record.jcard_edc);
								 jproduk_card_no3Field.setValue(jproduk_card_record.jcard_no);
								 jproduk_card_nilai3Field.setValue(jproduk_card_record.jcard_nilai);
								 jproduk_card_nilai3_cfField.setValue(CurrencyFormatted(jproduk_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_produk_DataStore.load({
					params : {
						no_faktur: jproduk_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_produk_DataStore.getCount()){
									jproduk_cek_record=cek_jual_produk_DataStore.getAt(0).data;
									jproduk_cek_nama3Field.setValue(jproduk_cek_record.jcek_nama);
									jproduk_cek_no3Field.setValue(jproduk_cek_record.jcek_no);
									jproduk_cek_valid3Field.setValue(jproduk_cek_record.jcek_valid);
									jproduk_cek_bank3Field.setValue(jproduk_cek_record.jcek_bank);
									jproduk_cek_nilai3Field.setValue(jproduk_cek_record.jcek_nilai);
									jproduk_cek_nilai3_cfField.setValue(CurrencyFormatted(jproduk_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								jproduk_transfer_record=transfer_jual_produk_DataStore.getAt(0);
									if(transfer_jual_produk_DataStore.getCount()){
										jproduk_transfer_record=transfer_jual_produk_DataStore.getAt(0);
										jproduk_transfer_bank3Field.setValue(jproduk_transfer_record.data.jtransfer_bank);
										jproduk_transfer_nama3Field.setValue(jproduk_transfer_record.data.jtransfer_nama);
										jproduk_transfer_nilai3Field.setValue(jproduk_transfer_record.data.jtransfer_nilai);
										jproduk_transfer_nilai3_cfField.setValue(CurrencyFormatted(jproduk_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_produk_DataStore.getCount()){
										jproduk_tunai_record=tunai_jual_produk_DataStore.getAt(0);
										jproduk_tunai_nilai3Field.setValue(jproduk_tunai_record.data.jtunai_nilai);
										jproduk_tunai_nilai3_cfField.setValue(CurrencyFormatted(jproduk_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_produk_DataStore.load({
						params : {
							no_faktur: jproduk_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_produk_DataStore.getCount()){
										jproduk_voucher_record=voucher_jual_produk_DataStore.getAt(0);
										jproduk_voucher_no3Field.setValue(jproduk_voucher_record.data.tvoucher_novoucher);
										jproduk_voucher_cashback3Field.setValue(jproduk_voucher_record.data.tvoucher_nilai);
										jproduk_voucher_cashback3_cfField.setValue(CurrencyFormatted(jproduk_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
        
        //Jika jproduk_post2db='UPDATE' dan jproduk_stat_dok='Tertutup' ==> detail_jual_produkListEditorGrid.djproduk_add di-disable
        if(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok')=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			detail_jual_produkListEditorGrid.djproduk_add.disable();
            detail_jual_produkListEditorGrid.djproduk_delete.disable();
			<?php } ?>
        }else if(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok')=='Terbuka'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			detail_jual_produkListEditorGrid.djproduk_add.enable();
            detail_jual_produkListEditorGrid.djproduk_delete.enable();
			<?php } ?>
        }
		
		jproduk_stat_dokField.on("select",function(){
		var status_awal = master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok');
		if(status_awal =='Terbuka' && jproduk_stat_dokField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jproduk_stat_dokField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && jproduk_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jproduk_stat_dokField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && jproduk_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jproduk_stat_dokField.setValue('Tertutup');
		}
		
		else if(jproduk_stat_dokField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', jproduk_status_batal);
		}
        
        else if(status_awal =='Tertutup' && jproduk_stat_dokField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			master_jual_produk_createForm.jproduk_savePrint.enable();
			// master_jual_produk_createForm.jproduk_savePrint2.enable();
			master_jual_produk_createForm.PrintOnlyButton.disable();
			// master_jual_produk_createForm.PrintOnlyButton2.disable();
			<?php } ?>
        }
		});		
	}
	/* End setValue to EDIT*/
	
	function jproduk_status_batal(btn){
	if(btn=='yes')
	{
		jproduk_stat_dokField.setValue('Batal');
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
        master_jual_produk_createForm.jproduk_savePrint.disable();
		// master_jual_produk_createForm.jproduk_savePrint2.disable();
		master_jual_produk_createForm.PrintOnlyButton.enable();
		// master_jual_produk_createForm.PrintOnlyButton2.enable();
		<?php } ?>
	}  
	else
		jproduk_stat_dokField.setValue(master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok'));
	}

	function master_jual_produk_set_updating(){
		if(jproduk_post2db=="UPDATE" && master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok')=="Terbuka"){
			jproduk_custField.setDisabled(true);
			jproduk_tanggalField.setDisabled(true);
			jproduk_keteranganField.setDisabled(false);
			jproduk_karyawanField.setDisabled(true);
			jproduk_nikkaryawanField.setDisabled(false);
			jproduk_caraField.setDisabled(false);
			master_jual_produk_tunaiGroup.setDisabled(false);
			master_jual_produk_cardGroup.setDisabled(false);
			master_jual_produk_cekGroup.setDisabled(false);
			master_jual_produk_kwitansiGroup.setDisabled(false);
			master_jual_produk_transferGroup.setDisabled(false);
			master_jual_produk_voucherGroup.setDisabled(false);
			
			jproduk_cara2Field.setDisabled(false);
			master_jual_produk_tunai2Group.setDisabled(false);
			master_jual_produk_card2Group.setDisabled(false);
			master_jual_produk_cek2Group.setDisabled(false);
			master_jual_produk_kwitansi2Group.setDisabled(false);
			master_jual_produk_transfer2Group.setDisabled(false);
			master_jual_produk_voucher2Group.setDisabled(false);
			
			jproduk_cara3Field.setDisabled(false);
			master_jual_produk_tunai3Group.setDisabled(false);
			master_jual_produk_card3Group.setDisabled(false);
			master_jual_produk_cek3Group.setDisabled(false);
			master_jual_produk_kwitansi3Group.setDisabled(false);
			master_jual_produk_transfer3Group.setDisabled(false);
			master_jual_produk_voucher3Group.setDisabled(false);
			
			master_jual_produk_createForm.jproduk_savePrint.enable();
			// master_jual_produk_createForm.jproduk_savePrint2.enable();
			master_jual_produk_createForm.PrintOnlyButton.disable();
			// master_jual_produk_createForm.PrintOnlyButton2.disable();
			
			combo_jual_produk.setDisabled(false);
			combo_satuan_produk.setDisabled(false);
			djumlah_beli_produkField.setDisabled(false);
			dsub_totalField.setDisabled(false);
			djenis_diskonField.setDisabled(false);
			dsub_total_netField.setDisabled(false);
			combo_reveral.setDisabled(false);
			dharga_defaultField.setDisabled(false);
            jproduk_diskonField.setDisabled(false);
            jproduk_cashback_cfField.setDisabled(false);
			jproduk_ket_diskField.setDisabled(false);
            jproduk_stat_dokField.setDisabled(false);
			
			// djumlah_diskonField.setDisabled(true);
			dharga_konversiField.setDisabled(true);
		}
		if(jproduk_post2db=="UPDATE" && master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok')=="Tertutup"){
			jproduk_custField.setDisabled(true);
			jproduk_tanggalField.setDisabled(true);
			jproduk_keteranganField.setDisabled(true);
			jproduk_karyawanField.setDisabled(true);
			jproduk_nikkaryawanField.setDisabled(true);
			jproduk_caraField.setDisabled(true);
			master_jual_produk_tunaiGroup.setDisabled(true);
			master_jual_produk_cardGroup.setDisabled(true);
			master_jual_produk_cekGroup.setDisabled(true);
			master_jual_produk_kwitansiGroup.setDisabled(true);
			master_jual_produk_transferGroup.setDisabled(true);
			master_jual_produk_voucherGroup.setDisabled(true);
			
			jproduk_cara2Field.setDisabled(true);
			master_jual_produk_tunai2Group.setDisabled(true);
			master_jual_produk_card2Group.setDisabled(true);
			master_jual_produk_cek2Group.setDisabled(true);
			master_jual_produk_kwitansi2Group.setDisabled(true);
			master_jual_produk_transfer2Group.setDisabled(true);
			master_jual_produk_voucher2Group.setDisabled(true);
			
			jproduk_cara3Field.setDisabled(true);
			master_jual_produk_tunai3Group.setDisabled(true);
			master_jual_produk_card3Group.setDisabled(true);
			master_jual_produk_cek3Group.setDisabled(true);
			master_jual_produk_kwitansi3Group.setDisabled(true);
			master_jual_produk_transfer3Group.setDisabled(true);
			master_jual_produk_voucher3Group.setDisabled(true);
			
			master_jual_produk_createForm.jproduk_savePrint.disable();
			// master_jual_produk_createForm.jproduk_savePrint2.disable();
			master_jual_produk_createForm.PrintOnlyButton.enable();
			// master_jual_produk_createForm.PrintOnlyButton2.enable();
			
			combo_jual_produk.setDisabled(true);
			combo_satuan_produk.setDisabled(true);
			djumlah_beli_produkField.setDisabled(true);
			dharga_konversiField.setDisabled(true);
			dsub_totalField.setDisabled(true);
			djenis_diskonField.setDisabled(true);
			djumlah_diskonField.setDisabled(true);
			dsub_total_netField.setDisabled(true);
			combo_reveral.setDisabled(true);
			dharga_defaultField.setDisabled(true);
			jproduk_diskonField.setDisabled(true);
			jproduk_cashback_cfField.setDisabled(true);
			jproduk_ket_diskField.setDisabled(true);
			jproduk_stat_dokField.setDisabled(false);
		}
		if(jproduk_post2db=="UPDATE" && master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_stat_dok')=="Batal"){
			jproduk_custField.setDisabled(true);
			jproduk_tanggalField.setDisabled(true);
			jproduk_keteranganField.setDisabled(true);
			jproduk_stat_dokField.setDisabled(true);
			jproduk_caraField.setDisabled(true);
			jproduk_karyawanField.setDisabled(true);
			jproduk_nikkaryawanField.setDisabled(true);
			master_jual_produk_tunaiGroup.setDisabled(true);
			master_jual_produk_cardGroup.setDisabled(true);
			master_jual_produk_cekGroup.setDisabled(true);
			master_jual_produk_kwitansiGroup.setDisabled(true);
			master_jual_produk_transferGroup.setDisabled(true);
			master_jual_produk_voucherGroup.setDisabled(true);
			
			jproduk_cara2Field.setDisabled(true);
			master_jual_produk_tunai2Group.setDisabled(true);
			master_jual_produk_card2Group.setDisabled(true);
			master_jual_produk_cek2Group.setDisabled(true);
			master_jual_produk_kwitansi2Group.setDisabled(true);
			master_jual_produk_transfer2Group.setDisabled(true);
			master_jual_produk_voucher2Group.setDisabled(true);
			
			jproduk_cara3Field.setDisabled(true);
			master_jual_produk_tunai3Group.setDisabled(true);
			master_jual_produk_card3Group.setDisabled(true);
			master_jual_produk_cek3Group.setDisabled(true);
			master_jual_produk_kwitansi3Group.setDisabled(true);
			master_jual_produk_transfer3Group.setDisabled(true);
			master_jual_produk_voucher3Group.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			detail_jual_produkListEditorGrid.djproduk_add.disable();
			detail_jual_produkListEditorGrid.djproduk_delete.disable();
			<?php } ?>
			combo_jual_produk.setDisabled(true);
			combo_satuan_produk.setDisabled(true);
			djumlah_beli_produkField.setDisabled(true);
			dharga_konversiField.setDisabled(true);
			dsub_totalField.setDisabled(true);
			djenis_diskonField.setDisabled(true);
			djumlah_diskonField.setDisabled(true);
			dsub_total_netField.setDisabled(true);
			combo_reveral.setDisabled(true);
			dharga_defaultField.setDisabled(true);
			jproduk_diskonField.setDisabled(true);
			jproduk_cashback_cfField.setDisabled(true);
			jproduk_ket_diskField.setDisabled(true);

			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			master_jual_produk_createForm.jproduk_savePrint.disable();
			// master_jual_produk_createForm.jproduk_savePrint2.disable();
			master_jual_produk_createForm.PrintOnlyButton.enable();
		// master_jual_produk_createForm.PrintOnlyButton2.enable();
			<?php } ?>
		}
	}
  
    function load_membership(){
		var cust_id=0;
		if(jproduk_post2db=="CREATE"){
			cust_id=jproduk_custField.getValue();
		}else if(jproduk_post2db=="UPDATE"){
			cust_id=jproduk_cust_idField.getValue();
		}
		
		if(jproduk_custField.getValue()!=''){
			memberDataStore.load({
					params : { member_cust: cust_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(memberDataStore.getCount()){
								jproduk_member_record=memberDataStore.getAt(0).data;
								jproduk_cust_nomemberField.setValue(jproduk_member_record.member_no);
								jproduk_valid_memberField.setValue(jproduk_member_record.member_valid);
								jproduk_cust_ultahField.setValue(jproduk_member_record.cust_tgllahir);
								jproduk_cust_priorityField.setValue(jproduk_member_record.cust_priority_star);
									if (jproduk_cust_priorityField.getValue()=='*') {
										jproduk_cust_priorityLabel.setText("*");
									}
									else {
										jproduk_cust_priorityLabel.setText("");
									}	
								
							}
						}
					}
			}); 
		}
	}
	
	function load_karyawan(){
		var karyawan_id=0;
		if(jproduk_post2db=="CREATE"){
			karyawan_id=jproduk_karyawanField.getValue();
		}else if(jproduk_post2db=="UPDATE"){
			karyawan_id=jproduk_karyawan_idField.getValue();
		}
		
		if(jproduk_karyawanField.getValue()!=''){
			karyawanDataStore.load({
					params : { karyawan_id: karyawan_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(karyawanDataStore.getCount()){
								jproduk_karyawan_record=karyawanDataStore.getAt(0).data;
								jproduk_nikkaryawanField.setValue(jproduk_karyawan_record.karyawan_no);
							}
						}
					}
			}); 
		}
	}
	/* Function for Check if the form is valid */
	function is_master_jual_produk_form_valid(){
		return (jproduk_diskonField.isValid() && jproduk_karyawanField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){	
		master_jual_produk_reset_form();
		detail_jual_produk_DataStore.load({params: {master_id:-1}});
		jproduk_caraField.setValue("card");
		master_jual_produk_cardGroup.setVisible(true);
		master_cara_bayarTabPanel.setActiveTab(0);
		jproduk_post2db="CREATE";
		jproduk_diskonField.setValue(0);
		jproduk_cashbackField.setValue(0);
		jproduk_diskonField.allowBlank=true;
		jproduk_pesanLabel.setText('');
		jproduk_lunasLabel.setText('');
		jproduk_cust_priorityLabel.setText('');
		master_jual_produk_createWindow.hide();
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_jual_produk_confirm_delete(){
		// only one master_jual_produk is selected here
		if(master_jual_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_jual_produk_delete);
		} else if(master_jual_produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_jual_produk_delete);
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
	function master_jual_produk_confirm_update(){
		master_jual_produk_reset_form();
		jproduk_karyawanDataStore.load();
		/* only one record is selected here */
		if(master_jual_produkListEditorGrid.selModel.getCount() == 1) {
			cbo_dproduk_produkDataStore.load({
				params: {
					query: master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
					cbo_dproduk_satuanDataStore.setBaseParam('produk_id', 0);
					cbo_dproduk_satuanDataStore.setBaseParam('query', master_jual_produkListEditorGrid.getSelectionModel().getSelected().get('jproduk_id'));
					cbo_dproduk_satuanDataStore.load({
						callback: function(opts, success, response){
							cbo_dproduk_reveralDataStore.load({
								callback: function(opts, success, response){
									detail_jual_produk_DataStore.load({
										params : {master_id : eval(get_jproduk_pk()), start:0, limit:50},
										callback: function(opts, success, response){
											if(success){
												master_jual_produk_set_form();
												master_jual_produk_set_updating();
											}
										}
									});
								}
							});
						}
					});
				}
			});
			jproduk_post2db='UPDATE';
			master_cara_bayarTabPanel.setActiveTab(2);
			master_cara_bayarTabPanel.setActiveTab(1);
			master_cara_bayarTabPanel.setActiveTab(0);
			msg='updated';
			master_jual_produk_createWindow.hide();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_jual_produk_delete(btn){
		if(btn=='yes'){
			var selections = master_jual_produkListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_jual_produkListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.jproduk_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_jual_produk&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_jual_produk_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Could not delete the entire selection',
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
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	master_jual_produk_DataStore = new Ext.data.Store({
		id: 'master_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jproduk_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jproduk_id', type: 'int', mapping: 'jproduk_id'}, 
			{name: 'jproduk_nobukti', type: 'string', mapping: 'jproduk_nobukti'}, 
			{name: 'jproduk_nobukti_pajak', type: 'string', mapping: 'jproduk_nobukti_pajak'}, 
			{name: 'jproduk_grooming', type: 'int', mapping: 'jproduk_grooming'},
			{name: 'jproduk_grooming_id', type: 'int', mapping: 'jproduk_grooming'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'jproduk_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'jproduk_cust_edit', type: 'string', mapping: 'cust_nama_edit'}, 
			{name: 'jproduk_cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'jproduk_cust_member', type: 'string', mapping: 'cust_member'}, 
			{name: 'jproduk_cust_member_no', type: 'string', mapping: 'member_no'}, 
			{name: 'cust_priority_star', type: 'string', mapping: 'cust_priority_star'},
			{name: 'jproduk_cust_id', type: 'int', mapping: 'jproduk_cust'}, 
			{name: 'jproduk_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'jproduk_tanggal'}, 
			{name: 'jproduk_diskon', type: 'int', mapping: 'jproduk_diskon'}, 
			{name: 'jproduk_cashback', type: 'float', mapping: 'jproduk_cashback'},
			{name: 'jproduk_cara', type: 'string', mapping: 'jproduk_cara'}, 
			{name: 'jproduk_cara2', type: 'string', mapping: 'jproduk_cara2'}, 
			{name: 'jproduk_cara3', type: 'string', mapping: 'jproduk_cara3'}, 
			{name: 'jproduk_bayar', type: 'float', mapping: 'jproduk_bayar'}, 
			{name: 'jproduk_total', type: 'float', mapping: 'jproduk_totalbiaya'}, 
			{name: 'jproduk_keterangan', type: 'string', mapping: 'jproduk_keterangan'},
			{name: 'jproduk_ket_disk', type: 'string', mapping: 'jproduk_ket_disk'},
			{name: 'jproduk_stat_dok', type: 'string', mapping: 'jproduk_stat_dok'}, 			
			{name: 'jproduk_creator', type: 'string', mapping: 'jproduk_creator'}, 
			{name: 'jproduk_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jproduk_date_create'}, 
			{name: 'jproduk_update', type: 'string', mapping: 'jproduk_update'}, 
			{name: 'jproduk_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jproduk_date_update'}, 
			{name: 'jproduk_revised', type: 'int', mapping: 'jproduk_revised'} 
		]),
		sortInfo:{field: 'jproduk_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_voucher_jual_produkDataStore = new Ext.data.Store({
		id: 'cbo_voucher_jual_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_voucher_list', 
			method: 'POST'
		}),baseParams: {start:0, limit: 10},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'voucher_nomor'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'voucher_nomor', type: 'string', mapping: 'kvoucher_nomor'},
			{name: 'voucher_jenis', type: 'string', mapping: 'voucher_jenis'},
			{name: 'voucher_nama', type: 'string', mapping: 'voucher_nama'}, 
			{name: 'voucher_point', type: 'int', mapping: 'voucher_point'}, 
			{name: 'voucher_kadaluarsa', type: 'date', dateFormat: 'Y-m-d', mapping: 'voucher_kadaluarsa'}, 
			{name: 'voucher_cashback', type: 'float', mapping: 'voucher_cashback'}, 
			{name: 'voucher_mincash', type: 'float', mapping: 'voucher_mincash'}, 
			{name: 'voucher_diskon', type: 'int', mapping: 'voucher_diskon'}, 
			{name: 'voucher_promo', type: 'int', mapping: 'voucher_promo'}, 
			{name: 'voucher_allproduk', type: 'string', mapping: 'voucher_allproduk'}, 
			{name: 'voucher_allrawat', type: 'string', mapping: 'voucher_allrawat'}
		]),
		sortInfo:{field: 'voucher_nomor', direction: "ASC"}
	});
	
	/* Function for Retrieve DataStore */
	cbo_cust_jual_produk_DataStore = new Ext.data.Store({
		id: 'cbo_cust_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	
	jproduk_karyawanDataStore = new Ext.data.Store({
		id: 'jproduk_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_allkaryawan_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'}
			//{name: 'karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'},
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	
	var karyawan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{karyawan_display}</b> | {karyawan_no}</span>',
        '</div></tpl>'
    );
	
	/* Function for Retrieve Combo Kwitansi DataStore */
	cbo_kwitansi_jual_produk_DataStore = new Ext.data.Store({
		id: 'cbo_kwitansi_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_kwitansi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kwitansi_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'ckwitansi_id', type: 'int', mapping: 'kwitansi_id'},
			{name: 'ckwitansi_no', type: 'string', mapping: 'kwitansi_no'},
			{name: 'ckwitansi_cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'ckwitansi_cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'ckwitansi_cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'kwitansi_keterangan', type: 'string', mapping: 'kwitansi_keterangan'},
			{name: 'total_sisa', type: 'int', mapping: 'total_sisa'}
		]),
		sortInfo:{field: 'ckwitansi_no', direction: "ASC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	kwitansi_jual_produk_DataStore = new Ext.data.Store({
		id: 'kwitansi_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_kwitansi_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jkwitansi_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jkwitansi_id', type: 'int', mapping: 'jkwitansi_id'},
			{name: 'kwitansi_no', type: 'string', mapping: 'kwitansi_no'},
			{name: 'jkwitansi_nilai', type: 'float', mapping: 'jkwitansi_nilai'},
			{name: 'kwitansi_sisa', type: 'float', mapping: 'kwitansi_sisa'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'}
		]),
		sortInfo:{field: 'jkwitansi_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	card_jual_produk_DataStore = new Ext.data.Store({
		id: 'card_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_card_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcard_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jcard_id', type: 'int', mapping: 'jcard_id'}, 
			{name: 'jcard_no', type: 'string', mapping: 'jcard_no'},
			{name: 'jcard_nama', type: 'string', mapping: 'jcard_nama'},
			{name: 'jcard_edc', type: 'string', mapping: 'jcard_edc'},
			{name: 'jcard_nilai', type: 'float', mapping: 'jcard_nilai'}
		]),
		sortInfo:{field: 'jcard_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	cek_jual_produk_DataStore = new Ext.data.Store({
		id: 'cek_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_cek_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcek_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jcek_id', type: 'int', mapping: 'jcek_id'}, 
			{name: 'jcek_nama', type: 'string', mapping: 'jcek_nama'},
			{name: 'jcek_no', type: 'string', mapping: 'jcek_no'},
			{name: 'jcek_valid', type: 'string', mapping: 'jcek_valid'}, 
			{name: 'jcek_bank', type: 'string', mapping: 'jcek_bank'},
			{name: 'jcek_nilai', type: 'double', mapping: 'jcek_nilai'}
		]),
		sortInfo:{field: 'jcek_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Transfer DataStore */
	transfer_jual_produk_DataStore = new Ext.data.Store({
		id: 'transfer_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_transfer_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtransfer_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jtransfer_id', type: 'int', mapping: 'jtransfer_id'}, 
			{name: 'jtransfer_bank', type: 'int', mapping: 'jtransfer_bank'},
			{name: 'jtransfer_nama', type: 'string', mapping: 'jtransfer_nama'},
			{name: 'jtransfer_nilai', type: 'float', mapping: 'jtransfer_nilai'}
		]),
		sortInfo:{field: 'jtransfer_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Tunai DataStore */
	tunai_jual_produk_DataStore = new Ext.data.Store({
		id: 'tunai_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_tunai_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtunai_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jtunai_id', type: 'int', mapping: 'jtunai_id'}, 
			{name: 'jtunai_nilai', type: 'float', mapping: 'jtunai_nilai'}
		]),
		sortInfo:{field: 'jtunai_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* GET Bank-List.Store */
	jproduk_bankDataStore = new Ext.data.Store({
		id:'jproduk_bankDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_bank_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jproduk_bank_value', type: 'int', mapping: 'mbank_id'}, 
			{name: 'jproduk_bank_display', type: 'string', mapping: 'mbank_nama'}
		]),
		sortInfo:{field: 'jproduk_bank_display', direction: "DESC"}
		});
	/* END GET Bank-List.Store */
	
	/* GET Voucher-Terima-List.Store */
	voucher_jual_produk_DataStore = new Ext.data.Store({
		id: 'voucher_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_voucher_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'tvoucher_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'tvoucher_id', type: 'int', mapping: 'tvoucher_id'}, 
			{name: 'tvoucher_novoucher', type: 'string', mapping: 'tvoucher_novoucher'}, 
			{name: 'tvoucher_nilai', type: 'float', mapping: 'tvoucher_nilai'}
		]),
		sortInfo:{field: 'tvoucher_id', direction: "DESC"}
	});
	/* End of GET Voucher-Terima-List.Store */
	
	/* GET Voucher-Terima-List.Store */
	jproduk_diskon_promoDataStore = new Ext.data.Store({
		id: 'jproduk_diskon_promoDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_promo_onerow',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'tvoucher_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'tvoucher_id', type: 'int', mapping: 'tvoucher_id'}, 
			{name: 'tvoucher_novoucher', type: 'string', mapping: 'tvoucher_novoucher'}, 
			{name: 'tvoucher_nilai', type: 'float', mapping: 'tvoucher_nilai'}
		]),
		sortInfo:{field: 'tvoucher_id', direction: "DESC"}
	});
	/* End of GET Voucher-Terima-List.Store */
	
  	/* Function for Identify of Window Column Model */
	master_jual_produk_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'jproduk_id',
			width: 5,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'jproduk_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'jproduk_nobukti',
			width: 80,	//150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
		}, 
		/*
		{
			header: '<div align="center">' + 'Faktur Pajak' + '</div>',
			dataIndex: 'jproduk_nobukti_pajak',
			width: 100,	//82,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
			})
		 }, 
		 */
		{
			header: '<div align="center">' + 'No Tenant' + '</div>',
			dataIndex: 'jproduk_cust_no',
			width: 80,	//185,
			sortable: true,
			readOnly: true
		},
		/*
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: 'cust_priority_star',
			width: 10,
			align: 'right',
			sortable: false,
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.cust_priority_star == '*'){
					return '<span style="color:red;"><font size="3"">' + value + '</font></span>';
				}				
				return value;
			}
		}, 
		*/
		{
			header: '<div align="center">' + 'Tenant' + '</div>',
			dataIndex: 'jproduk_cust',
			width: 200,	//185,
			sortable: true,
			readOnly: true
		}, 
		/*
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'jproduk_cust_member_no',
			width: 100,	//185,
			sortable: true,
			readOnly: true
		}, 
		*/
		{
			header: '<div align="center">' + 'Total (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jproduk_total',
			width: 80,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Tot Bayar (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jproduk_bayar',
			width: 80,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'jproduk_keterangan',
			width: 180,	//150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'jproduk_stat_dok',
			width: 60,	//150,
			sortable: true
		}, 	
		{
			header: 'Creator',
			dataIndex: 'jproduk_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Create',
			dataIndex: 'jproduk_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Update',
			dataIndex: 'jproduk_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Update',
			dataIndex: 'jproduk_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'jproduk_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	master_jual_produk_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_jual_produkListEditorGrid =  new Ext.grid.GridPanel({
		id: 'master_jual_produkListEditorGrid',
		el: 'fp_master_jual_produk',
		title: 'Daftar Penjualan Produk',
		autoHeight: true,
		store: master_jual_produk_DataStore, // DataStore
		cm: master_jual_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		trackMouseOver: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_jual_produk_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			id : 'Add_detail',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_jual_produk_confirm_update   // Confirm before updating
		}, '-',/*{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: master_jual_produk_confirm_delete   // Confirm before deleting
		}, '-', */{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_jual_produk_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_jual_produk_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Tenant<br>- Nama Tenant<br>- No Faktur'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_jual_produk_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_jual_produk_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_jual_produk_print  
		}
		]
	});
	/* End of DataStore */
	 
	/* Create Context Menu */
	master_jual_produk_ContextMenu = new Ext.menu.Menu({
		id: 'master_jual_produk_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_jual_produk_editContextMenu 
		},
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_jual_produk_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_jual_produk_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_jual_produk_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_jual_produk_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_jual_produk_SelectedRow=rowIndex;
		master_jual_produk_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_jual_produk_editContextMenu(){
		//master_jual_produkListEditorGrid.startEditing(master_jual_produk_SelectedRow,1);
		master_jual_produk_confirm_update();
  	}
	/* End of Function */
  	
	master_jual_produkListEditorGrid.addListener('rowcontextmenu', onmaster_jual_produk_ListEditGridContextMenu);
	
	// Custom rendering Template
    var customer_jual_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br /></span>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br/>',
            'Alamat: {cust_alamat}<br/>',
			'Telp Rumah: {cust_telprumah}<br>',			
        '</div></tpl>'
    );
	var voucher_jual_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{voucher_nomor}</b>| {voucher_nama}<br/></span>',
			'Jenis: {voucher_jenis}&nbsp;&nbsp;&nbsp;[Nilai: {voucher_cashback}]',
		'</div></tpl>'
    );
	var kwitansi_jual_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{ckwitansi_no}</b> <br/>',
			'a/n {ckwitansi_cust_nama} [ {ckwitansi_cust_no} ]<br/>',
			'{ckwitansi_cust_alamat}, <br>Sisa: <b>Rp. {total_sisa}</b>, <br>Ket : {kwitansi_keterangan} </span>',
		'</div></tpl>'
    );
	var produk_jual_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dproduk_produk_kode}| <b>{dproduk_produk_display}</b>',
		'</div></tpl>'
    );
		
	/* Identify  jproduk_id Field */
	jproduk_idField= new Ext.form.NumberField({
		id: 'jproduk_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jproduk_nobukti Field */
	jproduk_nobuktiField= new Ext.form.TextField({
		id: 'jproduk_nobuktiField',
		fieldLabel: 'No Faktur',
		emptyText : '(Auto)',
		readOnly:true,
		disabled : true,
		maxLength: 30
	});
	/* Identify  jproduk_cust Field */
	jproduk_custField= new Ext.form.ComboBox({
		id: 'jproduk_custField',
		fieldLabel: 'Tenant',
		store: cbo_cust_jual_produk_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_produk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	jproduk_cust_idField= new Ext.form.NumberField();
	jproduk_karyawan_idField = new Ext.form.NumberField();
	
	/*Untuk ngecek value, apakah nilai nya * , jika iya, maka akan menampilkan / mengaktifkan label Priortiy */
	jproduk_cust_priorityField= new Ext.form.TextField({
		id: 'jproduk_cust_priorityField',
		readOnly: true
	});
	
	// Label ini jika aktif, akan menampilkan bintang (*) besar , dimana tujuan label ini adlh menunjukkan bahwa Customer tersebut adalah Customer High Priority
	jproduk_cust_priorityLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '35px',
			//color: '#006600',
			color: '#CC0000'
		}
	});
	
	jproduk_cust_nomemberLabel=new Ext.form.Label({ html: 'No Member: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	jproduk_cust_nomemberField= new Ext.form.TextField({
		id: 'jproduk_cust_nomemberField',
		//fieldLabel: 'No Member',
		emptyText : '(Auto)',
		disabled : true,
		readOnly: true
	});
	
	jproduk_valid_memberLabel=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Member Valid: &nbsp;&nbsp;'});	
	
	jproduk_valid_memberField= new Ext.form.DateField({
		id: 'jproduk_valid_memberField',
		//fieldLabel: 'Member Valid',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y'
	});
	
	jproduk_cust_ultahLabel=new Ext.form.Label({ html: 'Tanggal Ultah : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	jproduk_cust_ultahField= new Ext.form.DateField({
		id: 'jproduk_cust_ultahField',
		fieldLabel: 'Tanggal Ultah',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y'
	});
	
	/* Identify  jproduk_cust Field */
	jproduk_karyawanField= new Ext.form.ComboBox({
		id: 'jproduk_karyawanField',
		fieldLabel: 'Karyawan',
		store: jproduk_karyawanDataStore,
		mode: 'remote',
		displayField:'karyawan_display',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
		allowBlank : false,
        hideTrigger:false,
        tpl: karyawan_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	jproduk_nikkaryawanField= new Ext.form.TextField({
		id: 'jproduk_nikkaryawanField',
		fieldLabel: 'NIK',
		emptyText : '(Auto)',
		readOnly: true,
		renderer: function(value, cell, record){
				return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
			}
	});
	
	jproduk_groomingGroup = new Ext.form.FieldSet({
		id : 'jproduk_groomingGroup',
		title: 'Grooming',
		checkboxToggle:false,
		autoHeight: true,
		layout:'column',
		collapsible: true,
		collapsed : true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jproduk_karyawanField, jproduk_nikkaryawanField] 
			}]
	
	});
	
	/* Identify  jproduk_tanggal Field */
	jproduk_tanggalField= new Ext.form.DateField({
		id: 'jproduk_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  jproduk_diskon Field */
	jproduk_diskonField= new Ext.form.NumberField({
		id: 'jproduk_diskonField',
		fieldLabel: 'Disk Tambahan (%)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		allowDecimals: true,
		enableKeyEvents: true,
		width: 120,
		maxLength: 3,
		maskRe: /([0-9]+)$/
	});
	
	jproduk_ket_diskField= new Ext.form.TextField({
		id: 'jproduk_ket_disk',
		fieldLabel: 'No Voucher',
		itemCls : 'rata_kanan',
		width: 120
	});

	jproduk_cashback_cfField= new Ext.form.TextField({
		id: 'jproduk_cashback_cfField',
		fieldLabel: 'Voucher/Potongan (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rata_kanan',
		width: 120,
		maskRe: /([0-9]+)$/
	});
	jproduk_cashbackField= new Ext.form.NumberField({
		id: 'jproduk_cashbackField',
		fieldLabel: 'Diskon (Rp)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		readOnly : true,
		allowDecimals: false,
		width: 120,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  jproduk_cara Field */
	jproduk_caraField= new Ext.form.ComboBox({
		id: 'jproduk_caraField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_cara_value', 'jproduk_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kuitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jproduk_cara_display',
		valueField: 'jproduk_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jproduk_cara2 Field */
	jproduk_cara2Field= new Ext.form.ComboBox({
		id: 'jproduk_cara2Field',
		fieldLabel: 'Cara Bayar 2',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_cara_value', 'jproduk_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kuitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jproduk_cara_display',
		valueField: 'jproduk_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jproduk_cara3 Field */
	jproduk_cara3Field= new Ext.form.ComboBox({
		id: 'jproduk_cara3Field',
		fieldLabel: 'Cara Bayar 3',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_cara_value', 'jproduk_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kuitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jproduk_cara_display',
		valueField: 'jproduk_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	
	jproduk_stat_dokField= new Ext.form.ComboBox({
		id: 'jproduk_stat_dokField',
		fieldLabel: 'Status Dokumen',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_stat_dok_value', 'jproduk_stat_dok_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'jproduk_stat_dok_display',
		valueField: 'jproduk_stat_dok_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	
	/* Identify  jproduk_keterangan Field */
	jproduk_keteranganField= new Ext.form.TextArea({
		id: 'jproduk_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
	jproduk_voucher_noField= new Ext.form.TextField({
		id: 'jproduk_voucher_noField',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});

	jproduk_voucher_cashback_cfField= new Ext.form.TextField({
		id: 'jproduk_voucher_cashback_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_voucher_cashbackField= new Ext.form.NumberField({
		id: 'jproduk_voucher_cashbackField',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_voucherGroup= new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_voucher_noField,jproduk_voucher_cashback_cfField] 
			}
		]
	
	});
	// END Field Voucher
	
	// START Field Voucher-2
	jproduk_voucher_no2Field=new Ext.form.TextField({
		id: 'jproduk_voucher_no2Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	
	jproduk_voucher_cashback2_cfField= new Ext.form.TextField({
		id: 'jproduk_voucher_cashback2_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_voucher_cashback2Field= new Ext.form.NumberField({
		id: 'jproduk_voucher_cashback2Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_voucher2Group= new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_voucher_no2Field,jproduk_voucher_cashback2_cfField] 
			}
		]
	
	});
	// END Field Voucher-2
	
	// START Field Voucher-3
	jproduk_voucher_no3Field=new Ext.form.TextField({
		id: 'jproduk_voucher_no3Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	
	jproduk_voucher_cashback3_cfField= new Ext.form.TextField({
		id: 'jproduk_voucher_cashback3_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_voucher_cashback3Field= new Ext.form.NumberField({
		id: 'jproduk_voucher_cashback3Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_voucher3Group= new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_voucher_no3Field,jproduk_voucher_cashback3_cfField] 
			}
		]
	
	});
	// END Field Voucher-3
	
	// START Field Card
	jproduk_card_namaField= new Ext.form.ComboBox({
		id: 'jproduk_card_namaField',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_value', 'jproduk_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_display',
		valueField: 'jproduk_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	jproduk_card_edcField= new Ext.form.ComboBox({
		id: 'jproduk_card_edcField',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_edc_value', 'jproduk_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_edc_display',
		valueField: 'jproduk_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jproduk_card_noField= new Ext.form.TextField({
		id: 'jproduk_card_noField',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	jproduk_card_nilai_cfField= new Ext.form.TextField({
		id: 'jproduk_card_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		allowDecimals : true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		//maskRe: /([0-9]+)$/,
		decimalSeparator : '.',
		decimalPrecision : 2
	});
	jproduk_card_nilaiField= new Ext.form.NumberField({
		id: 'jproduk_card_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		allowDecimals : true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/,
		decimalSeparator : '.',
		decimalPrecision : 2
	});
	
	master_jual_produk_cardGroup= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_card_namaField,jproduk_card_edcField,jproduk_card_noField,jproduk_card_nilai_cfField] 
			}
		]
	
	});
	// END Field Card
	// START Field Card-2
	jproduk_card_nama2Field= new Ext.form.ComboBox({
		id: 'jproduk_card_nama2Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_value', 'jproduk_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_display',
		valueField: 'jproduk_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	jproduk_card_edc2Field= new Ext.form.ComboBox({
		id: 'jproduk_card_edc2Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_edc_value', 'jproduk_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_edc_display',
		valueField: 'jproduk_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jproduk_card_no2Field= new Ext.form.TextField({
		id: 'jproduk_card_no2Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	jproduk_card_nilai2_cfField= new Ext.form.TextField({
		id: 'jproduk_card_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_card_nilai2Field= new Ext.form.NumberField({
		id: 'jproduk_card_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_card2Group= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_card_nama2Field,jproduk_card_edc2Field,jproduk_card_no2Field,jproduk_card_nilai2_cfField] 
			}
		]
	
	});
	// END Field Card-2
	// START Field Card-3
	jproduk_card_nama3Field= new Ext.form.ComboBox({
		id: 'jproduk_card_nama3Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_value', 'jproduk_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_display',
		valueField: 'jproduk_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	jproduk_card_edc3Field= new Ext.form.ComboBox({
		id: 'jproduk_card_edc3Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_card_edc_value', 'jproduk_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jproduk_card_edc_display',
		valueField: 'jproduk_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jproduk_card_no3Field= new Ext.form.TextField({
		id: 'jproduk_card_no3Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	jproduk_card_nilai3_cfField= new Ext.form.TextField({
		id: 'jproduk_card_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_card_nilai3Field= new Ext.form.NumberField({
		id: 'jproduk_card_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_card3Group= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_card_nama3Field,jproduk_card_edc3Field,jproduk_card_no3Field,jproduk_card_nilai3_cfField] 
			}
		]
	
	});
	// END Field Card-3
	
	// StART Field Cek
	jproduk_cek_namaField= new Ext.form.TextField({
		id: 'jproduk_cek_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	jproduk_cek_noField= new Ext.form.TextField({
		id: 'jproduk_cek_noField',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jproduk_cek_validField= new Ext.form.DateField({
		id: 'jproduk_cek_validField',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	jproduk_cek_bankField= new Ext.form.ComboBox({
		id: 'jproduk_cek_bankField',
		fieldLabel: 'Bank',
		store: jproduk_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jproduk_cek_bankField)
	});
	
	jproduk_cek_nilai_cfField= new Ext.form.TextField({
		id: 'jproduk_cek_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_cek_nilaiField= new Ext.form.NumberField({
		id: 'jproduk_cek_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_cekGroup = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_cek_namaField,jproduk_cek_noField,jproduk_cek_validField,jproduk_cek_bankField,jproduk_cek_nilai_cfField] 
			}
		]
	
	});
	// END Field Cek
	// StART Field Cek-2
	jproduk_cek_nama2Field= new Ext.form.TextField({
		id: 'jproduk_cek_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	jproduk_cek_no2Field= new Ext.form.TextField({
		id: 'jproduk_cek_no2Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jproduk_cek_valid2Field= new Ext.form.DateField({
		id: 'jproduk_cek_valid2Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	jproduk_cek_bank2Field= new Ext.form.ComboBox({
		id: 'jproduk_cek_bank2Field',
		fieldLabel: 'Bank',
		store: jproduk_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jproduk_cek_bankField)
	});
	
	jproduk_cek_nilai2_cfField= new Ext.form.TextField({
		id: 'jproduk_cek_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_cek_nilai2Field= new Ext.form.NumberField({
		id: 'jproduk_cek_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_cek2Group = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_cek_nama2Field,jproduk_cek_no2Field,jproduk_cek_valid2Field,jproduk_cek_bank2Field,jproduk_cek_nilai2_cfField] 
			}
		]
	
	});
	// END Field Cek-2
	// StART Field Cek-3
	jproduk_cek_nama3Field= new Ext.form.TextField({
		id: 'jproduk_cek_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	jproduk_cek_no3Field= new Ext.form.TextField({
		id: 'jproduk_cek_no3Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jproduk_cek_valid3Field= new Ext.form.DateField({
		id: 'jproduk_cek_valid3Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	jproduk_cek_bank3Field= new Ext.form.ComboBox({
		id: 'jproduk_cek_bank3Field',
		fieldLabel: 'Bank',
		store: jproduk_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jproduk_cek_bankField)
	});
	
	jproduk_cek_nilai3_cfField= new Ext.form.TextField({
		id: 'jproduk_cek_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_cek_nilai3Field= new Ext.form.NumberField({
		id: 'jproduk_cek_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_cek3Group = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_cek_nama3Field,jproduk_cek_no3Field,jproduk_cek_valid3Field,jproduk_cek_bank3Field,jproduk_cek_nilai3_cfField] 
			}
		]
	
	});
	// END Field Cek-3
	
	// START Field Transfer
	jproduk_transfer_bankField= new Ext.form.ComboBox({
		id: 'jproduk_transfer_bankField',
		fieldLabel: 'Bank',
		store: jproduk_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jproduk_transfer_bankField)
	});

	jproduk_transfer_namaField= new Ext.form.TextField({
		id: 'jproduk_transfer_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jproduk_transfer_nilai_cfField= new Ext.form.TextField({
		id: 'jproduk_transfer_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_transfer_nilaiField= new Ext.form.NumberField({
		id: 'jproduk_transfer_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_transferGroup= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_transfer_bankField,jproduk_transfer_namaField,jproduk_transfer_nilai_cfField] 
			}
		]
	
	});
	// END Field Transfer
	// START Field Transfer-2
	jproduk_transfer_bank2Field= new Ext.form.ComboBox({
		id: 'jproduk_transfer_bank2Field',
		fieldLabel: 'Bank',
		store: jproduk_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jproduk_transfer_nama2Field= new Ext.form.TextField({
		id: 'jproduk_transfer_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jproduk_transfer_nilai2_cfField= new Ext.form.TextField({
		id: 'jproduk_transfer_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_transfer_nilai2Field= new Ext.form.NumberField({
		id: 'jproduk_transfer_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_transfer2Group= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_transfer_bank2Field,jproduk_transfer_nama2Field,jproduk_transfer_nilai2_cfField] 
			}
		]
	
	});
	// END Field Transfer-2
	// START Field Transfer-3
	jproduk_transfer_bank3Field= new Ext.form.ComboBox({
		id: 'jproduk_transfer_bank3Field',
		fieldLabel: 'Bank',
		store: jproduk_bankDataStore,
		mode: 'remote',
		displayField: 'jproduk_bank_display',
		valueField: 'jproduk_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jproduk_transfer_nama3Field= new Ext.form.TextField({
		id: 'jproduk_transfer_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jproduk_transfer_nilai3_cfField= new Ext.form.TextField({
		id: 'jproduk_transfer_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_transfer_nilai3Field= new Ext.form.NumberField({
		id: 'jproduk_transfer_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_produk_transfer3Group= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_transfer_bank3Field,jproduk_transfer_nama3Field,jproduk_transfer_nilai3_cfField] 
			}
		]
	
	});
	// END Field Transfer-3
	
	//START Field Tunai-1
	jproduk_tunai_nilai_cfField= new Ext.form.TextField({
		id: 'jproduk_tunai_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_tunai_nilaiField= new Ext.form.NumberField({
		id: 'jproduk_tunai_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_jual_produk_tunaiGroup = new Ext.form.FieldSet({
		title: 'Tunai',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_tunai_nilai_cfField] 
			}
		]
	
	});
	// END Tunai-1
	
	//START Field Tunai-2
	jproduk_tunai_nilai2_cfField= new Ext.form.TextField({
		id: 'jproduk_tunai_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_tunai_nilai2Field= new Ext.form.NumberField({
		id: 'jproduk_tunai_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_jual_produk_tunai2Group = new Ext.form.FieldSet({
		title: 'Tunai',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_tunai_nilai2_cfField] 
			}
		]
	
	});
	// END Tunai-2
	
	//START Field Tunai-3
	jproduk_tunai_nilai3_cfField= new Ext.form.TextField({
		id: 'jproduk_tunai_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_tunai_nilai3Field= new Ext.form.NumberField({
		id: 'jproduk_tunai_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_jual_produk_tunai3Group = new Ext.form.FieldSet({
		title: 'Tunai',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_tunai_nilai3_cfField] 
			}
		]
	
	});
	// END Tunai-3
	
	//START Field Kwitansi-1
	jproduk_kwitansi_namaField= new Ext.form.TextField({
		id: 'jproduk_kwitansi_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	jproduk_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'jproduk_kwitansi_nilai_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'jproduk_kwitansi_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/*Field ini dipakai untuk menyimpan ID dari tabel jual_kwitansi, dimana ID ini berperan untuk mengetahui apakah kwitansi tersebut akan di Insert atau di Update */
	jproduk_jual_kwitansi_idField1= new Ext.form.NumberField();
	jproduk_jual_kwitansi_idField2= new Ext.form.NumberField();
	jproduk_jual_kwitansi_idField3= new Ext.form.NumberField();
	
	jproduk_kwitansi_idField= new Ext.form.NumberField();
	jproduk_kwitansi_noField= new Ext.form.ComboBox({
		id: 'jproduk_kwitansi_noField',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_jual_produk_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_produk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		//queryDelay:720,
		anchor: '95%'
		
	});
	
	jproduk_kwitansi_sisaField= new Ext.form.NumberField({
		id: 'jproduk_kwitansi_sisaField',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	jproduk_kwitansi_noField.on("select",function(){
			j=cbo_kwitansi_jual_produk_DataStore.findExact('ckwitansi_id',jproduk_kwitansi_noField.getValue(),0);
			if(j>-1){
				jproduk_kwitansi_namaField.setValue(cbo_kwitansi_jual_produk_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jproduk_kwitansi_sisaField.setValue(cbo_kwitansi_jual_produk_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-1
	
	//START Field Kwitansi-2
	jproduk_kwitansi_nama2Field= new Ext.form.TextField({
		id: 'jproduk_kwitansi_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	jproduk_kwitansi_nilai2_cfField= new Ext.form.TextField({
		id: 'jproduk_kwitansi_nilai2_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_kwitansi_nilai2Field= new Ext.form.NumberField({
		id: 'jproduk_kwitansi_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	jproduk_kwitansi_id2Field= new Ext.form.NumberField();
	jproduk_kwitansi_no2Field= new Ext.form.ComboBox({
		id: 'jproduk_kwitansi_no2Field',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_jual_produk_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_produk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		queryDelay:720,
		anchor: '95%'
	});
	
	jproduk_kwitansi_sisa2Field= new Ext.form.NumberField({
		id: 'jproduk_kwitansi_sisa2Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	jproduk_kwitansi_no2Field.on("select",function(){
			j=cbo_kwitansi_jual_produk_DataStore.findExact('ckwitansi_id',jproduk_kwitansi_no2Field.getValue(),0);
			if(j>-1){
				jproduk_kwitansi_nama2Field.setValue(cbo_kwitansi_jual_produk_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jproduk_kwitansi_sisa2Field.setValue(cbo_kwitansi_jual_produk_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-2
	
	//START Field Kwitansi-3
	jproduk_kwitansi_nama3Field= new Ext.form.TextField({
		id: 'jproduk_kwitansi_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	jproduk_kwitansi_nilai3_cfField= new Ext.form.TextField({
		id: 'jproduk_kwitansi_nilai3_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jproduk_kwitansi_nilai3Field= new Ext.form.NumberField({
		id: 'jproduk_kwitansi_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	jproduk_kwitansi_id3Field= new Ext.form.NumberField();
	jproduk_kwitansi_no3Field= new Ext.form.ComboBox({
		id: 'jproduk_kwitansi_no3Field',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_jual_produk_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_produk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		queryDelay:720,
		anchor: '95%'
	});
	
	jproduk_kwitansi_sisa3Field= new Ext.form.NumberField({
		id: 'jproduk_kwitansi_sisa3Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	jproduk_kwitansi_no3Field.on("select",function(){
			j=cbo_kwitansi_jual_produk_DataStore.findExact('ckwitansi_id',jproduk_kwitansi_no3Field.getValue(),0);
			if(j>-1){
				jproduk_kwitansi_nama3Field.setValue(cbo_kwitansi_jual_produk_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jproduk_kwitansi_sisa3Field.setValue(cbo_kwitansi_jual_produk_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-3
	
	master_jual_produk_kwitansiGroup = new Ext.form.FieldSet({
		title: 'Kwitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_kwitansi_noField,jproduk_kwitansi_namaField,jproduk_kwitansi_sisaField,jproduk_kwitansi_nilai_cfField] 
			}
		]
	
	});
	
	master_jual_produk_kwitansi2Group = new Ext.form.FieldSet({
		title: 'Kwitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_kwitansi_no2Field,jproduk_kwitansi_nama2Field,jproduk_kwitansi_sisa2Field,jproduk_kwitansi_nilai2_cfField] 
			}
		]
	
	});
	
	master_jual_produk_kwitansi3Group = new Ext.form.FieldSet({
		title: 'Kwitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_kwitansi_no3Field,jproduk_kwitansi_nama3Field,jproduk_kwitansi_sisa3Field,jproduk_kwitansi_nilai3_cfField] 
			}
		]
	
	});
	
	//* Bayar
	jproduk_jumlahLabel= new Ext.form.DisplayField({
		fieldLabel : 'Jumlah',
		itemCls : 'rata_kanan'
	});
	jproduk_subTotalLabel= new Ext.form.DisplayField({
		fieldLabel : 'Sub Total (Rp)',
		itemCls : 'rata_kanan'
		//itemCls : 'rmoney2'
	});
	jproduk_TotalLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total (Rp)</span>',
		itemCls : 'rmoney2'
	});
	
	jproduk_TotalBayarLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total Bayar (Rp)</span>',
		itemCls : 'rmoney2'
	});
	
	jproduk_HutangLabel= new Ext.form.DisplayField({
		id: 'jproduk_HutangLabel',
		fieldLabel : '<font color=black size=2>Hutang (Rp)<font>',
		itemCls : 'rmoney_hutang'
	});
	
	jproduk_jumlahField= new Ext.form.NumberField({
		id: 'jproduk_jumlahField',
		fieldLabel: 'Jumlah Item',
		allowBlank: true,
		readOnly: true,
		allowDecimals: false,
		width: 40,
		maxLength: 50,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	jproduk_subTotal_cfField= new Ext.form.TextField({
		id: 'jproduk_subTotal_cfField',
		fieldLabel: 'Sub Total (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	
	jproduk_subTotalField= new Ext.form.NumberField({
		id: 'jproduk_subTotalField',
		enableKeyEvents: true,
		fieldLabel: 'Sub Total (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	//SUB TOTAL DPP
	jproduk_dpp_Field= new Ext.form.NumberField({
		id: 'jproduk_dpp_Field',
		fieldLabel: 'Sub Total DPP (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120
	});
	jproduk_dpp_cfField= new Ext.form.TextField({
		id: 'jproduk_dpp_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});

	jproduk_total_cfField= new Ext.form.TextField({
		id: 'jproduk_total_cfField',
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	jproduk_totalField= new Ext.form.NumberField({
		id: 'jproduk_totalField',
		enableKeyEvents: true,
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	jproduk_bayar_cfField= new Ext.form.TextField({
		id: 'jproduk_bayar_cfField',
		fieldLabel: 'Total Bayar (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	jproduk_bayarField= new Ext.form.NumberField({
		id: 'jproduk_bayarField',
		enableKeyEvents: true,
		fieldLabel: 'Total Bayar (Rp)',
		allowDecimals : false,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	jproduk_hutang_cfField= new Ext.form.TextField({
		id: 'jproduk_hutang_cfField',
		fieldLabel: 'Hutang (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	jproduk_hutangField= new Ext.form.NumberField({
		id: 'jproduk_hutangField',
		enableKeyEvents: true,
		fieldLabel: 'Hutang (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	jproduk_pesanLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '14px',
			color: '#CC0000'
		}
	});
	jproduk_lunasLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '14px',
			color: '#006600'
		}
	});
	
	master_cara_bayarTabPanel = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		frame: true,
		height: 232,
		width: 500,
		defaults:{bodyStyle:'padding:10px'},
		items:[{
                title:'Cara Bayar 1',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [jproduk_caraField,master_jual_produk_tunaiGroup,master_jual_produk_cardGroup,master_jual_produk_cekGroup,master_jual_produk_kwitansiGroup,master_jual_produk_transferGroup,master_jual_produk_voucherGroup]
            },{
                title:'Cara Bayar 2',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [jproduk_cara2Field, master_jual_produk_tunai2Group, master_jual_produk_kwitansi2Group ,master_jual_produk_card2Group, master_jual_produk_cek2Group, master_jual_produk_transfer2Group, master_jual_produk_voucher2Group]
            }
            /*,{
                title:'Cara Bayar 3',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [jproduk_cara3Field, master_jual_produk_tunai3Group, master_jual_produk_kwitansi3Group, master_jual_produk_card3Group, master_jual_produk_cek3Group, master_jual_produk_transfer3Group, master_jual_produk_voucher3Group]
            }
            */]
	});
	
	master_jual_produk_bayarGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		width: 1200,
		collapsible: true,
		layout:'column',
		frame: true,
		items:[
			   {
				columnWidth:0.6,
				layout: 'form',
				border:false,
				items: [master_cara_bayarTabPanel] 
			}
			,{
				columnWidth:0.3,
				labelWidth: 180,
				layout: 'form',
    			labelPad: 0,
				baseCls: 'x-plain',
				border:false,
				labelAlign: 'left',
				items: [/*jproduk_jumlahField*/jproduk_jumlahLabel, /*jproduk_subTotal_cfField*/ jproduk_subTotalLabel, jproduk_cashback_cfField,
			  jproduk_ket_diskField, {xtype: 'spacer',height:10},/*jproduk_total_cfField,*/jproduk_TotalLabel, /*jproduk_bayar_cfField*/ jproduk_TotalBayarLabel, /*jproduk_hutang_cfField,*/jproduk_HutangLabel, jproduk_pesanLabel, jproduk_lunasLabel] 
			}
			]
	});
	
	/*Fieldset Master*/
	master_jual_produk_masterGroup = new Ext.form.FieldSet({
		// title: 'Master',
		autoHeight: true,
		// collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jproduk_nobuktiField, jproduk_custField, 
						/*
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[jproduk_cust_nomemberLabel, jproduk_cust_nomemberField,jproduk_valid_memberLabel, jproduk_valid_memberField]
						}, {xtype: 'spacer',height:5},
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[jproduk_cust_ultahLabel, jproduk_cust_ultahField,jproduk_cust_priorityLabel]
						}
						*/
						] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jproduk_tanggalField, jproduk_keteranganField, jproduk_stat_dokField] 
			}
			]
	});
	
	/*Detail Declaration */
		
	// Function for json reader of detail
	var detail_jual_produk_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intopeprodukan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'dproduk_id', type: 'int', mapping: 'dproduk_id'}, 
			{name: 'dproduk_master', type: 'int', mapping: 'dproduk_master'}, 
			{name: 'dproduk_produk', type: 'int', mapping: 'dproduk_produk'}, 
			{name: 'dproduk_satuan', type: 'int', mapping: 'dproduk_satuan'}, 
			{name: 'dproduk_jumlah', type: 'int', mapping: 'dproduk_jumlah'}, 
			{name: 'dproduk_harga', type: 'float', mapping: 'dproduk_harga'}, 
			{name: 'dproduk_diskon', type: 'float', mapping: 'dproduk_diskon'},
			{name: 'dproduk_sales', type: 'string', mapping: 'dproduk_sales'},
			{name: 'dproduk_diskon_jenis', type: 'string', mapping: 'dproduk_diskon_jenis'},
			{name: 'nama_karyawan', type: 'string', mapping: 'karyawan_username'},
			{name: 'dproduk_karyawan', type: 'int', mapping: 'dproduk_karyawan'},
			{name: 'dproduk_subtotal', type: 'float', mapping: 'dproduk_subtotal'},
			{name: 'dproduk_subtotal_net', type: 'float', mapping: 'dproduk_subtotal_net'},
			{name: 'jproduk_bayar', type: 'float', mapping: 'jproduk_bayar'},
			{name: 'jproduk_diskon', type: 'int', mapping: 'jproduk_diskon'},
			{name: 'jproduk_cashback', type: 'float', mapping: 'jproduk_cashback'},
			{name: 'produk_harga_default', type: 'float', mapping: 'produk_harga_default'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_jual_produk_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_jual_produk_DataStore = new Ext.data.Store({
		id: 'detail_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=detail_detail_jual_produk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: pageS},
		reader: detail_jual_produk_reader,
		sortInfo:{field: 'dproduk_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_jual_produk= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_dproduk_produkDataStore = new Ext.data.Store({
		id: 'cbo_dproduk_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_produk_list', 
			method: 'POST'
		}),baseParams: {aktif: 'yes', start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'dproduk_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'dproduk_produk_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'dproduk_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'dproduk_produk_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'dproduk_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'dproduk_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'dproduk_produk_du', type: 'float', mapping: 'produk_du'},
			{name: 'dproduk_produk_dm', type: 'float', mapping: 'produk_dm'},
			{name: 'dproduk_produk_dultah', type: 'float', mapping: 'produk_dultah'},
			{name: 'dproduk_produk_dcard', type: 'float', mapping: 'produk_dcard'},
			{name: 'dproduk_produk_dkolega', type: 'float', mapping: 'produk_dkolega'},
			{name: 'dproduk_produk_dkeluarga', type: 'float', mapping: 'produk_dkeluarga'},
			{name: 'dproduk_produk_downer', type: 'float', mapping: 'produk_downer'},
			{name: 'dproduk_produk_dgrooming', type: 'float', mapping: 'produk_dgrooming'},
			{name: 'dproduk_produk_dwartawan', type: 'float', mapping: 'produk_dwartawan'},
			{name: 'dproduk_produk_dstaffdokter', type: 'float', mapping: 'produk_dstaffdokter'},
			{name: 'dproduk_produk_dstaffnondokter', type: 'float', mapping: 'produk_dstaffnondokter'},
			{name: 'dproduk_produk_dpromo', type: 'float', mapping: 'produk_dpromo'},
			{name: 'dproduk_produk_display', type: 'string', mapping: 'produk_nama'},
			{name: 'dproduk_edit_harga', type: 'float', mapping: 'produk_edit_harga'}
		]),
		sortInfo:{field: 'dproduk_produk_display', direction: "ASC"}
	});
	
	cbo_dproduk_reveralDataStore = new Ext.data.Store({
		id: 'cbo_dproduk_reveralDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_reveral_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 100 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'}
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	var reveral_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{karyawan_display}</b> | {karyawan_no}</span>',
        '</div></tpl>'
    );
	
	cbo_dproduk_satuanDataStore = new Ext.data.Store({
		id: 'cbo_dproduk_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_satuan_bydjproduk_list', 
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
	
	memberDataStore = new Ext.data.Store({
		id: 'memberDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_member_by_cust', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'member_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'member_id', type: 'int', mapping: 'member_id'},
			{name: 'member_no', type: 'string', mapping: 'member_no'},
			{name: 'member_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_valid'}, 
			{name: 'member_point' , type: 'int', mapping: 'member_point'},
			{name: 'member_jenis' , type: 'string', mapping: 'member_jenis'},
			{name: 'member_aktif' , type: 'string', mapping: 'member_aktif'},
			{name: 'cust_tgllahir' , type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_priority_star' , type: 'string', mapping: 'cust_priority_star'}
		]),
		sortInfo:{field: 'member_id', direction: "ASC"}
	});
	
	karyawanDataStore = new Ext.data.Store({
		id: 'karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_produk&m=get_nik', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'}
		]),
		sortInfo:{field: 'karyawan_id', direction: "ASC"}
	});
	
	var combo_jual_produk=new Ext.form.ComboBox({
		store: cbo_dproduk_produkDataStore,
		mode: 'remote',
		displayField: 'dproduk_produk_display',
		valueField: 'dproduk_produk_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:pageS,
		hideTrigger:false,
		tpl: produk_jual_produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var combo_reveral=new Ext.form.ComboBox({
		store: cbo_dproduk_reveralDataStore,
		mode: 'remote',
		displayField: 'karyawan_display',
		valueField: 'karyawan_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:pageS,
		hideTrigger:false,
		tpl: reveral_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var combo_satuan_produk=new Ext.form.ComboBox({
		store: cbo_dproduk_satuanDataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'djproduk_satuan_display',
		valueField: 'djproduk_satuan_value',
		triggerAction: 'all',
		allowBlank : false,
		anchor: '95%'
	});
	
	dproduk_idField=new Ext.form.NumberField();
	djproduk_satuan_nilaiField=new Ext.form.NumberField();	

	combo_jual_produk.on('select',function(){
		var editable_harga_produk = 0;
		var j=cbo_dproduk_produkDataStore.findExact('dproduk_produk_value',combo_jual_produk.getValue(),0);
		var today_s = new Date().format('d-m-Y');

		/*Di cek, apakah produk_edit_harga dari produk ini 0 / 1, jika 1 maka bisa di edit2 harganya, jika 0, maka ga bisa di edit2 harganya */
		editable_harga_produk = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_edit_harga;
		if(editable_harga_produk == 1){
			dharga_konversiField.setDisabled(false);
			dharga_konversiField.setReadOnly(false);
		}
		else if(editable_harga_produk == 0){
			dharga_konversiField.setDisabled(true);
			dharga_konversiField.setReadOnly(true);	
		}
		
            //Untuk me-lock screen sementara, menunggu data selesai di-load ==> setelah selesai di-load, hide Ext.MessageBox.show() di bawah ini
			detail_jual_produkListEditorGrid.setDisabled(true);
			editor_detail_jual_produk.disable();
			
            dproduk_idField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_value);
			dharga_defaultField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_harga);
			var djumlah_diskon = 0;
			
			//(jproduk_cust_ultahField.getValue()!== null) || (jproduk_cust_ultahField.getValue() !=="") || (jproduk_cust_ultahField.getValue().format('Y-m-d')!=='0000-00-00') || (jproduk_cust_ultahField.getValue().format('Y-m-d')!=="")
			
			if(jproduk_cust_ultahField.getValue()!==""){
			//alert(jproduk_cust_ultahField.getValue().format('Y-m-d'));
			var post_ultah = jproduk_cust_ultahField.getValue().add(Date.DAY, +7).format('m-d');
			var pre_ultah = jproduk_cust_ultahField.getValue().add(Date.DAY, -7).format('m-d');
			}

			//* Check no_member JIKA <>"" ==> jenis-diskon=DM /
			
			if((jproduk_cust_nomemberField.getValue()!=="") && (jproduk_valid_memberField.getValue().format('d-m-Y') >= today_s)){
				alert(today_s);
				if(pre_ultah <= today_ultah && post_ultah >= today_ultah){
					djenis_diskonField.setValue('Ultah');
					djumlah_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dultah;
					djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dultah);
					// djumlah_diskonField.setDisabled(true);
				}
				else{
					djenis_diskonField.setValue('Member');
					djumlah_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dm;
					djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dm);
					// djumlah_diskonField.setDisabled(true);
				}
			}else{
					
					djenis_diskonField.setValue('Umum');
					djumlah_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_du;
					djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_du);
					// djumlah_diskonField.setDisabled(true);
			}
			
			cbo_dproduk_satuanDataStore.load({
				params: {produk_id:dproduk_idField.getValue()},
				callback: function(opts, success, response){
					if(success){
                        djumlah_beli_produkField.setValue(1);
						var nilai_default=0;
						var dtotal_konversi_field = 0;
						var dsub_total_field = 0;
						var dtotal_net_field = 0;
                        var st=cbo_dproduk_satuanDataStore.findExact('djproduk_satuan_default','true',0);
                        if(cbo_dproduk_satuanDataStore.getCount()>=0){
                            nilai_default=cbo_dproduk_satuanDataStore.getAt(st).data.djproduk_satuan_nilai;
                            if(nilai_default===1){
								dtotal_konversi_field = nilai_default*dharga_defaultField.getValue();
								dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
                                dharga_konversiField.setValue(dtotal_konversi_field);
								
								dsub_total_field = djumlah_beli_produkField.getValue()*dtotal_konversi_field;
								dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
                                dsub_totalField.setValue(dsub_total_field);
								
								dtotal_net_field = ((100-djumlah_diskon)/100)*djumlah_beli_produkField.getValue()*(nilai_default*dharga_defaultField.getValue());
								dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
                                dsub_total_netField.setValue(dtotal_net_field);
								detail_jual_produkListEditorGrid.setDisabled(false);
								editor_detail_jual_produk.enable();
								
                            }else if(nilai_default!==1){
								dtotal_konversi_field = (nilai_default*(1/nilai_default))*dharga_defaultField.getValue();
								dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
                                dharga_konversiField.setValue(dtotal_konversi_field);
								
								dsub_total_field = djumlah_beli_produkField.getValue()*dtotal_konversi_field;
								dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
                                dsub_totalField.setValue(dsub_total_field);
								
								dtotal_net_field = ((100-djumlah_diskon)/100)*djumlah_beli_produkField.getValue()*((nilai_default*(1/nilai_default))*dharga_defaultField.getValue());
                                dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
								dsub_total_netField.setValue(dtotal_net_field);
								detail_jual_produkListEditorGrid.setDisabled(false);
								editor_detail_jual_produk.enable();
                            }else{
								detail_jual_produkListEditorGrid.setDisabled(false);
								editor_detail_jual_produk.enable();
                            }
                            combo_satuan_produk.setValue(cbo_dproduk_satuanDataStore.getAt(st).data.djproduk_satuan_value);
                        }else{
							detail_jual_produkListEditorGrid.setDisabled(false);
							editor_detail_jual_produk.enable();
                        }
					}else{
						detail_jual_produkListEditorGrid.setDisabled(false);
						editor_detail_jual_produk.enable();
                    }
				}
			});	
		window.refresh(); //Fungsi ini adalah memancing error, dimana tujuannya agar harga dan satuan pada detail muncul. Setelah muncul error ini, maka akan ada console.clear() agar tidak membingungkan user.. 
	});

	temp_konv_nilai=new Ext.form.NumberField({
		readOnly: true,
		allowDecimals: true,
		decimalPrecision: 9
	});

	combo_satuan_produk.on('focus', function(){
		cbo_dproduk_satuanDataStore.setBaseParam('produk_id',combo_jual_produk.getValue());
		cbo_dproduk_satuanDataStore.load();
	});
	combo_satuan_produk.on('select', function(){
		var j=cbo_dproduk_satuanDataStore.findExact('djproduk_satuan_value',combo_satuan_produk.getValue(),0);
		var jt=cbo_dproduk_satuanDataStore.findExact('djproduk_satuan_default','true',0);
		var nilai_terpilih=0;
		var nilai_default=0;
		var dtotal_konversi_field = 0;
		var dsub_total_field = 0;
		var dtotal_net_field = 0;
		
		if(cbo_dproduk_satuanDataStore.getCount()>=0){
			if(cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_default=="true"){
				//Harga_Produk=harga yg tercantum di Master Produk tanpa proses bagi/kali
				djproduk_satuan_nilaiField.setValue(1);
				
				dtotal_konversi_field = 1*dharga_defaultField.getValue();
				dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
				dharga_konversiField.setValue(dtotal_konversi_field);
				
				dsub_total_field = djumlah_beli_produkField.getValue()*(1*dharga_defaultField.getValue());
				dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
				dsub_totalField.setValue();
				
				dtotal_net_field = ((100-djumlah_diskonField.getValue())/100)*djumlah_beli_produkField.getValue()*(1*dharga_defaultField.getValue());
				dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
				dsub_total_netField.setValue(dtotal_net_field);
			}else if(cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_default=="false"){
				//ambil satuan_nilai dr satuan_id yg terpilih, ambil satuan_nilai dr satuan_default=true
				//jika [satuan_nilai dr satuan_default=true] === 1 => Harga_Produk=[satuan_nilai dr satuan_id yg terpilih]*data.djproduk_satuan_harga
				//jika [satuan_nilai dr satuan_default=true] !== 1 AND [satuan_nilai dr satuan_default=true] < [satuan_nilai dr satuan_id yg terpilih] => Harga_Produk=([satuan_nilai dr satuan_id yg terpilih]/[satuan_nilai dr satuan_default=true])*data.djproduk_satuan_harga 
				//jika [satuan_nilai dr satuan_default=true] !== 1 AND [satuan_nilai dr satuan_default=true] > [satuan_nilai dr satuan_id yg terpilih] => Harga_Produk=data.djproduk_satuan_harga/[satuan_nilai dr satuan_default=true]
				nilai_terpilih=cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_nilai;
				nilai_default=cbo_dproduk_satuanDataStore.getAt(jt).data.djproduk_satuan_nilai;
				if(nilai_default===1){
					djproduk_satuan_nilaiField.setValue(cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_nilai);
					
					dtotal_konversi_field = cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_nilai*dharga_defaultField.getValue();
					dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
					dharga_konversiField.setValue(dtotal_konversi_field);
					
					dsub_total_field = djumlah_beli_produkField.getValue()*(cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_nilai*dharga_defaultField.getValue());
					dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
					dsub_totalField.setValue(dsub_total_field);
					
					dtotal_net_field = ((100-djumlah_diskonField.getValue())/100)*djumlah_beli_produkField.getValue()*(cbo_dproduk_satuanDataStore.getAt(j).data.djproduk_satuan_nilai*dharga_defaultField.getValue());
					dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
					dsub_total_netField.setValue(dtotal_net_field);
				}else if(nilai_default!==1 && nilai_default<nilai_terpilih){
					djproduk_satuan_nilaiField.setValue(nilai_terpilih/nilai_default);
					
					dtotal_konversi_field = (nilai_terpilih/nilai_default)*dharga_defaultField.getValue();
					dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
					dharga_konversiField.setValue(dtotal_konversi_field);
					
					dsub_total_field = djumlah_beli_produkField.getValue()*((nilai_terpilih/nilai_default)*dharga_defaultField.getValue());
					dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
					dsub_totalField.setValue(dsub_total_field);
					
					dtotal_net_field = ((100-djumlah_diskonField.getValue())/100)*djumlah_beli_produkField.getValue()*((nilai_terpilih/nilai_default)*dharga_defaultField.getValue());
					dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
					dsub_total_netField.setValue(dtotal_net_field);
				}else if(nilai_default!==1 && nilai_default>nilai_terpilih){
					djproduk_satuan_nilaiField.setValue(1/nilai_default);
					
					dtotal_konversi_field = (1/nilai_default)*dharga_defaultField.getValue();
					dtotal_konversi_field = (dtotal_konversi_field>0?Math.round(dtotal_konversi_field):0);
					dharga_konversiField.setValue(dtotal_konversi_field);
					
					dsub_total_field = djumlah_beli_produkField.getValue()*((1/nilai_default)*dharga_defaultField.getValue());
					dsub_total_field = (dsub_total_field>0?Math.round(dsub_total_field):0);
					dsub_totalField.setValue(dsub_total_field);
					
					dtotal_net_field = ((100-djumlah_diskonField.getValue())/100)*djumlah_beli_produkField.getValue()*((1/nilai_default)*dharga_defaultField.getValue());
					dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
					dsub_total_netField.setValue(dtotal_net_field);
				}
			}
		}
	});
	
	var djenis_diskonField = new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['diskon_jenis_value'],
			data:[['Tanpa Diskon'],['Umum'],['Member'],['Ultah'],['Card'],['Kolega'],['Owner'],['Grooming'],['Staff'],['Promo']]
		}),
		mode: 'local',
		displayField: 'diskon_jenis_value',
		valueField: 'diskon_jenis_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	djenis_diskonField.on('select', function(){
		var dtotal_net_field = 0;
		var djumlah_beli_produk = djumlah_beli_produkField.getValue();
		var j=cbo_dproduk_produkDataStore.findExact('dproduk_produk_value',combo_jual_produk.getValue(),0);
		var djenis_diskon = 0;
		if(djenis_diskonField.getValue()=='Umum'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_du;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_du);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Member'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dm;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dm);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Ultah'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dultah;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dultah);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Card'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dcard;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dcard);
			//djumlah_diskonField.setReadOnly(false);
			// djumlah_diskonField.setDisabled(false);
		}else if(djenis_diskonField.getValue()=='Kolega'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dkolega;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dkolega);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Keluarga'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dkeluarga;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dkeluarga);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Owner'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_downer;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_downer);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Grooming'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dgrooming;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dgrooming);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Wartawan'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dwartawan;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dwartawan);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Staff'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dstaffdokter;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dstaffdokter);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Staf Non Dokter'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dstaffnondokter;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dstaffnondokter);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}else if(djenis_diskonField.getValue()=='Promo'){
			djenis_diskon = cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dpromo;
			djumlah_diskonField.setValue(cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_dpromo);
			// djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true); //default
			/*untuk YESS*///djumlah_diskonField.setDisabled(false); /*eof YESS*/ 
		}
		else{
			djumlah_diskonField.setValue(0);
			//djumlah_diskonField.setReadOnly(true);
			// djumlah_diskonField.setDisabled(true);
		}
		dtotal_net_field = ((100-djenis_diskon)/100) * (djumlah_beli_produk*cbo_dproduk_produkDataStore.getAt(j).data.dproduk_produk_harga);
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		dsub_total_netField.setValue(dtotal_net_field);
	});
	
	var djumlah_diskonField = new Ext.form.NumberField({
		id : 'djumlah_diskonField',
		name : 'djumlah_diskonField',
		allowDecimals: true,
		allowNegative: false,
		maxLength: 5,
		enableKeyEvents: true,
		readOnly : false,
		maskRe: /([0-9]+)$/
	});
	djumlah_diskonField.on('keyup', function(){
		var sub_total_net = ((100-djumlah_diskonField.getValue())/100)*dsub_totalField.getValue();
		sub_total_net = (sub_total_net>0?Math.round(sub_total_net):0);
		dsub_total_netField.setValue(sub_total_net);
		if(this.getRawValue()>15 && djenis_diskonField.getValue()=='Card'){
			this.setRawValue(15);
		}/*untuk YESS*/else if(this.getRawValue()>20 && djenis_diskonField.getValue()=='Promo'){
			this.setRawValue(20);
		}/*eof YESS*/
	});
	
	var djumlah_beli_produkField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	djumlah_beli_produkField.on('keyup', function(){
		var dtotal_net_field = 0;
		var sub_total = djumlah_beli_produkField.getValue()*dharga_konversiField.getValue();
		dsub_totalField.setValue(sub_total);
		dtotal_net_field = ((100-djumlah_diskonField.getValue())/100)*sub_total;
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		dsub_total_netField.setValue(dtotal_net_field);
	});
	
	var dharga_konversiField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dharga_defaultField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dsub_totalField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var dsub_total_netField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});

	dpp_Field=new Ext.form.NumberField();
	subtot_dpp_Field=new Ext.form.NumberField();
	
	//declaration of detail coloumn model
	detail_jual_produk_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'dproduk_id',
            hidden: true
		},
        {
			align : 'Left',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'dproduk_produk',
			width: 270,
			sortable: false,
			allowBlank: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: combo_jual_produk,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_jual_produk)
		},
		{
			align :'Left',
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'dproduk_satuan',
			width: 80,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: combo_satuan_produk,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_satuan_produk)
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'dproduk_jumlah',
			width: 60,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000')
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			,
			editor: djumlah_beli_produkField
			<?php } ?>
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			dataIndex: 'dproduk_harga',
			width: 120,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: dharga_konversiField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		/*
		{
			align: 'Right',
			header: '<div align="center">' + 'DPP (Rp)' + '</div>',
			dataIndex: 'dproduk_harga',
			width: 80,
			sortable: true,
			renderer: function(v, params, record){
				var record_dpp = record.data.dproduk_harga/1.1;
				record_dpp = (record_dpp>0?Math.round(record_dpp):0);
				return Ext.util.Format.number(record_dpp,'0,000');
			}
		},
		*/
		{
			align : 'Right',
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			dataIndex: 'dproduk_subtotal',
			width: 120,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: dsub_totalField,
			<?php } ?>
			renderer: function(v, params, record){
				return Ext.util.Format.number(record.data.dproduk_jumlah*record.data.dproduk_harga,'0,000');
            }
		},
		/*
		{
			align : 'Left',
			header: '<div align="center">' + 'Jns Disk' + '</div>',
			dataIndex: 'dproduk_diskon_jenis',
			width: 70,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			,
			editor: djenis_diskonField
			<?php } ?>
		},
		*/
		{
			align : 'Right',
			header: '<div align="center">' + 'Disk (%)' + '</div>',
			dataIndex: 'dproduk_diskon',
			width: 80,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: djumlah_diskonField
			<?php } ?>
		},
		{
			align :'Right',
			header: '<div align="center">' + 'Sub Tot Net (Rp)' + '</div>',
			dataIndex: 'dproduk_subtotal_net',
			width: 120,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: dsub_total_netField,
			<?php } ?>
			renderer: function(v, params, record){
				var record_dtotal_net = record.data.dproduk_jumlah*record.data.dproduk_harga*((100-record.data.dproduk_diskon)/100);
				record_dtotal_net = (record_dtotal_net>0?Math.round(record_dtotal_net):0);
				return Ext.util.Format.number(record_dtotal_net,'0,000');
            }
		},
		/*
		{
			align: 'Right',
			header: '<div align="center">' + 'Sub Tot Net DPP (Rp)' + '</div>',
			dataIndex: 'dproduk_subtotal_net',
			width: 120,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: subtot_dpp_Field,
			<?php } ?>
			renderer: function(v, params, record){
				var record_subtot_dpp = (record.data.dproduk_jumlah*record.data.dproduk_harga*((100-record.data.dproduk_diskon)/100))/1.1;
				record_subtot_dpp = (record_subtot_dpp>0?Math.round(record_subtot_dpp):0);
				return Ext.util.Format.number(record_subtot_dpp,'0,000');
			}
		},
		*/
		{
			align : 'Left',
			header: '<div align="center">' + 'Sales' + '</div>',
			dataIndex: 'dproduk_karyawan',
			width: 110,
			sortable: false,
			allowBlank: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: combo_reveral,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_reveral)
		},
		{
			//field ini HARUS dimunculkan, utk penghitungan harga
			align : 'Right',
			header: '<div align="center">' + 'Harga Default' + '</div>',
			dataIndex: 'produk_harga_default',
			width: 100,
			sortable: false,
			hidden: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			editor: dharga_defaultField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		}
		]
	);
	detail_jual_produk_ColumnModel.defaultSortable= true;
	//eof

	//declaration of detail list editor grid
	detail_jual_produkListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_jual_produkListEditorGrid',
		el: 'fp_detail_jual_produk',
		title: 'Detail Penjualan Produk',
		height: 250,
		width: 1200,	//918,
		autoScroll: true,
		store: detail_jual_produk_DataStore, // DataStore
		colModel: detail_jual_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
		plugins: [editor_detail_jual_produk],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		/*
		bbar: new Ext.PagingToolbar({
			store: detail_jual_produk_DataStore,
			displayInfo: true
		})
		*/
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
		
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djproduk_add',
			handler: detail_jual_produk_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djproduk_delete',
			handler: detail_jual_produk_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_jual_produk_add(){
		//djumlah_diskonField.setReadOnly(true);
		// djumlah_diskonField.setDisabled(true);
		dharga_konversiField.setDisabled(true);
		//jika detail sudah ada 1, maka referal akan mengikuti row sebelumnya
		if(detail_jual_produkListEditorGrid.selModel.getCount() == 1)
		{
			// temp ini berfungsi utk menyimpan ID dari referal yang terakhir kali diinput. Jika program di Refresh / Cancel, maka akan kembali ke kondisi semula
			var temp_produk = combo_reveral.getValue(1);
			var edit_detail_jual_produk= new detail_jual_produkListEditorGrid.store.recordType({
				dproduk_id	:0,
				dproduk_produk	:'',
				dproduk_satuan	:'',
				dproduk_jumlah	:1,
				dproduk_harga	:0,
				dproduk_subtotal:0,
				dproduk_diskon_jenis: '',
				dproduk_diskon	:0,
				dproduk_subtotal_net:0,
				dproduk_karyawan:temp_produk,
				produk_harga_default:0
			});
			editor_detail_jual_produk.stopEditing();
			detail_jual_produk_DataStore.insert(0, edit_detail_jual_produk);
			detail_jual_produkListEditorGrid.getSelectionModel().selectRow(0);
			editor_detail_jual_produk.startEditing(0);
		}else
		{
			var edit_detail_jual_produk= new detail_jual_produkListEditorGrid.store.recordType({
				dproduk_id	:0,
				dproduk_produk	:'',
				dproduk_satuan	:'',
				dproduk_jumlah	:1,
				dproduk_harga	:0,
				dproduk_subtotal:0,
				dproduk_diskon_jenis: '',
				dproduk_diskon	:0,
				dproduk_subtotal_net:0,
				dproduk_karyawan:'',
				produk_harga_default:0
			});
			editor_detail_jual_produk.stopEditing();
			detail_jual_produk_DataStore.insert(0, edit_detail_jual_produk);
			detail_jual_produkListEditorGrid.getSelectionModel().selectRow(0);
			editor_detail_jual_produk.startEditing(0);
		}
	}

	//function for insert detail
	function detail_jual_produk_insert(){
		var dproduk_id=[];
		var dproduk_produk=[];
		var dproduk_karyawan=[];
		var dproduk_satuan=[];
		var dproduk_jumlah=[];
		var dproduk_harga=[];
		var dproduk_subtotal_net=[];
		var dproduk_diskon=[];
		var dproduk_diskon_jenis=[];
		var dproduk_sales=[];
		var dcount = detail_jual_produk_DataStore.getCount() - 1;
		
		if(detail_jual_produk_DataStore.getCount()>0){
			for(i=0; i<detail_jual_produk_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_jual_produk_DataStore.getAt(i).data.dproduk_produk))
				   && detail_jual_produk_DataStore.getAt(i).data.dproduk_produk!==undefined
				   && detail_jual_produk_DataStore.getAt(i).data.dproduk_produk!==''
				   && detail_jual_produk_DataStore.getAt(i).data.dproduk_produk!==0){
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_id==undefined){
						dproduk_id.push('');
					}else{
						dproduk_id.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_id);
					}
					
					dproduk_produk.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_produk);
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_karyawan==undefined){
						dproduk_karyawan.push('');
					}else{
						dproduk_karyawan.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_karyawan);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_satuan==undefined){
						dproduk_satuan.push('');
					}else{
						dproduk_satuan.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_satuan);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah==undefined){
						dproduk_jumlah.push('');
					}else{
						dproduk_jumlah.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_harga==undefined){
						dproduk_harga.push('');
					}else{
						dproduk_harga.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_harga);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_subtotal_net==undefined){
						dproduk_subtotal_net.push('');
					}else{
						dproduk_subtotal_net.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_subtotal_net);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon==undefined){
						dproduk_diskon.push('');
					}else{
						dproduk_diskon.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon_jenis==undefined){
						dproduk_diskon_jenis.push('');
					}else{
						dproduk_diskon_jenis.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon_jenis);
					}
					
					if(detail_jual_produk_DataStore.getAt(i).data.dproduk_sales==undefined){
						dproduk_sales.push('');
					}else{
						dproduk_sales.push(detail_jual_produk_DataStore.getAt(i).data.dproduk_sales);
					}
				}
				
				if(i==dcount){
					var encoded_array_dproduk_id = Ext.encode(dproduk_id);
					var encoded_array_dproduk_produk = Ext.encode(dproduk_produk);
					var encoded_array_dproduk_karyawan = Ext.encode(dproduk_karyawan);
					var encoded_array_dproduk_satuan = Ext.encode(dproduk_satuan);
					var encoded_array_dproduk_jumlah = Ext.encode(dproduk_jumlah);
					var encoded_array_dproduk_harga = Ext.encode(dproduk_harga);
					var encoded_array_dproduk_subtotal_net = Ext.encode(dproduk_subtotal_net);
					var encoded_array_dproduk_diskon = Ext.encode(dproduk_diskon);
					var encoded_array_dproduk_diskon_jenis = Ext.encode(dproduk_diskon_jenis);
					var encoded_array_dproduk_sales = Ext.encode(dproduk_sales);
					Ext.Ajax.request({
						waitMsg: 'Mohon tunggu...',
						url: 'index.php?c=c_master_jual_produk&m=detail_detail_jual_produk_insert',
						params:{
							cetak_jproduk	: cetak_jproduk,
							dproduk_id	: encoded_array_dproduk_id,
							dproduk_master	: eval(get_jproduk_pk()),
							dproduk_produk	: encoded_array_dproduk_produk,
							dproduk_karyawan: encoded_array_dproduk_karyawan,
							dproduk_satuan	: encoded_array_dproduk_satuan,
							dproduk_jumlah	: encoded_array_dproduk_jumlah,
							dproduk_harga	: encoded_array_dproduk_harga,
							dproduk_subtotal_net	: encoded_array_dproduk_subtotal_net,
							dproduk_diskon	: encoded_array_dproduk_diskon,
							dproduk_diskon_jenis	: encoded_array_dproduk_diskon_jenis,
							dproduk_sales			: encoded_array_dproduk_sales
						},
						timeout: 60000,
						success: function(response){
							var result=eval(response.responseText);
							if(result==0){
								detail_jual_produk_DataStore.load({params: {master_id:-1}});
								Ext.MessageBox.alert(jproduk_post2db+' OK','Data penjualan produk berhasil disimpan');
								jproduk_post2db="CREATE";
							}else if(result==-1){
								detail_jual_produk_DataStore.load({params: {master_id:-1}});
								jproduk_post2db="CREATE";
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Data penjualan produk tidak bisa disimpan',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.WARNING
								});
							}else if(result>0){
								detail_jual_produk_DataStore.load({params: {master_id:-1}});
								jproduk_cetak(result);
								cetak_jproduk=0;
								jproduk_post2db="CREATE";
							}
							jproduk_btn_cancel();
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
							jproduk_btn_cancel();
						}		
					});
				}
			}
		}
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_jual_produk_confirm_delete(){
		if(detail_jual_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_jual_produk_delete);
		}else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_jual_produk_delete(btn){
		if(btn=='yes'){
            var selections = detail_jual_produkListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dproduk_id==''){
                    detail_jual_produk_DataStore.remove(record);
					load_dstore_jproduk();
                }else if((/^\d+$/.test(record.data.dproduk_id))){
                    //Delete dari db.detail_jual_produk
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_jual_produk_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_jual_produk&m=get_action', 
                        params: { task: "DDELETE", dproduk_id:  record.data.dproduk_id }, 
                        success: function(response){
                            var result=eval(response.responseText);
                            switch(result){
                                case 1:  // Success : simply reload
									load_dstore_jproduk();
                                    Ext.MessageBox.hide();
                                    break;
                                default:
                                    Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
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
			}
		} 
	}
	//eof
	
	
	function update_group_carabayar_jual_produk(){
		var value=jproduk_caraField.getValue();
		master_jual_produk_tunaiGroup.setVisible(false);
		master_jual_produk_cardGroup.setVisible(false);
		master_jual_produk_cekGroup.setVisible(false);
		master_jual_produk_transferGroup.setVisible(false);
		master_jual_produk_kwitansiGroup.setVisible(false);
		master_jual_produk_voucherGroup.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jproduk_tunai_nilaiField.reset();
		jproduk_tunai_nilai_cfField.reset();
		jproduk_card_nilaiField.reset();
		jproduk_card_nilai_cfField.reset();
		jproduk_cek_nilaiField.reset();
		jproduk_cek_nilai_cfField.reset();
		jproduk_transfer_nilaiField.reset();
		jproduk_transfer_nilai_cfField.reset();
		jproduk_kwitansi_nilaiField.reset();
		jproduk_kwitansi_nilai_cfField.reset();
		jproduk_voucher_cashbackField.reset();
		
		if(value=='card'){
			master_jual_produk_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_produk_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			master_jual_produk_transferGroup.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_produk_kwitansiGroup.setVisible(true);
		}else if(value=='voucher'){
			master_jual_produk_voucherGroup.setVisible(true);
		}else if(value=='tunai'){
			master_jual_produk_tunaiGroup.setVisible(true);
		}
	}
	
	function update_group_carabayar2_jual_produk(){
		var value=jproduk_cara2Field.getValue();
		master_jual_produk_tunai2Group.setVisible(false);
		master_jual_produk_card2Group.setVisible(false);
		master_jual_produk_cek2Group.setVisible(false);
		master_jual_produk_transfer2Group.setVisible(false);
		master_jual_produk_kwitansi2Group.setVisible(false);
		master_jual_produk_voucher2Group.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jproduk_tunai_nilai2Field.reset();
		jproduk_tunai_nilai2_cfField.reset();
		jproduk_card_nilai2Field.reset();
		jproduk_card_nilai2_cfField.reset();
		jproduk_cek_nilai2Field.reset();
		jproduk_cek_nilai2_cfField.reset();
		jproduk_transfer_nilai2Field.reset();
		jproduk_transfer_nilai2_cfField.reset();
		jproduk_kwitansi_nilai2Field.reset();
		jproduk_kwitansi_nilai2_cfField.reset();
		jproduk_voucher_cashback2Field.reset();
		
		if(value=='card'){
			master_jual_produk_card2Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_produk_cek2Group.setVisible(true);
		}else if(value=='transfer'){
			master_jual_produk_transfer2Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_produk_kwitansi2Group.setVisible(true);
		}else if(value=='voucher'){
			master_jual_produk_voucher2Group.setVisible(true);
		}else if(value=='tunai'){
			master_jual_produk_tunai2Group.setVisible(true);
		}
	}
	
	function update_group_carabayar3_jual_produk(){
		var value=jproduk_cara3Field.getValue();
		master_jual_produk_tunai3Group.setVisible(false);
		master_jual_produk_card3Group.setVisible(false);
		master_jual_produk_cek3Group.setVisible(false);
		master_jual_produk_transfer3Group.setVisible(false);
		master_jual_produk_kwitansi3Group.setVisible(false);
		master_jual_produk_voucher3Group.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jproduk_tunai_nilai3Field.reset();
		jproduk_tunai_nilai3_cfField.reset();
		jproduk_card_nilai3Field.reset();
		jproduk_card_nilai3_cfField.reset();
		jproduk_cek_nilai3Field.reset();
		jproduk_cek_nilai3_cfField.reset();
		jproduk_transfer_nilai3Field.reset();
		jproduk_transfer_nilai3_cfField.reset();
		jproduk_kwitansi_nilai3Field.reset();
		jproduk_kwitansi_nilai3_cfField.reset();
		jproduk_voucher_cashback3Field.reset();
		
		if(value=='card'){
			master_jual_produk_card3Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_produk_cek3Group.setVisible(true);
		}else if(value=='transfer'){
			master_jual_produk_transfer3Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_produk_kwitansi3Group.setVisible(true);
		}else if(value=='voucher'){
			master_jual_produk_voucher3Group.setVisible(true);
		}else if(value=='tunai'){
			master_jual_produk_tunai3Group.setVisible(true);
		}
	}
	
	function load_total_bayar_updating(){
		var update_total_field=0;
		var update_hutang_field=0;
		var jproduk_bayar_temp=jproduk_bayarField.getValue();
		var total_bayar=0;

		var transfer_nilai=0;
		var transfer_nilai2=0;
		var transfer_nilai3=0;
		var kwitansi_nilai=0;
		var kwitansi_nilai2=0;
		var kwitansi_nilai3=0;
		var card_nilai=0;
		var card_nilai2=0;
		var card_nilai3=0;
		var cek_nilai=0;
		var cek_nilai2=0;
		var cek_nilai3=0;
		var voucher_nilai=0;
		var voucher_nilai2=0;
		var voucher_nilai3=0;
		
		transfer_nilai=jproduk_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=jproduk_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;

		transfer_nilai2=jproduk_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=jproduk_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		
		transfer_nilai3=jproduk_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=jproduk_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		
		kwitansi_nilai=jproduk_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=jproduk_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		
		kwitansi_nilai2=jproduk_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=jproduk_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		
		kwitansi_nilai3=jproduk_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=jproduk_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		
		card_nilai=jproduk_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=jproduk_card_nilaiField.getValue();
		else
			card_nilai=0;
		
		card_nilai2=jproduk_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=jproduk_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		
		card_nilai3=jproduk_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=jproduk_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		
		cek_nilai=jproduk_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=jproduk_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		
		cek_nilai2=jproduk_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=jproduk_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		
		cek_nilai3=jproduk_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=jproduk_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		
		voucher_nilai=jproduk_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=jproduk_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		
		voucher_nilai2=jproduk_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=jproduk_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		
		voucher_nilai3=jproduk_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=jproduk_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;

		tunai_nilai=jproduk_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=jproduk_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;

		tunai_nilai2=jproduk_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=jproduk_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;

		tunai_nilai3=jproduk_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=jproduk_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;

		total_bayar=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		
		update_total_field=jproduk_subTotalField.getValue()*((100-jproduk_diskonField.getValue())/100)-jproduk_cashbackField.getValue();
		jproduk_totalField.setValue(update_total_field);
		jproduk_total_cfField.setValue(CurrencyFormatted(update_total_field));
		jproduk_TotalLabel.setValue(CurrencyFormatted(update_total_field));

		jproduk_bayarField.setValue(total_bayar);
		jproduk_bayar_cfField.setValue(CurrencyFormatted(total_bayar));
		jproduk_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar));
		
		update_hutang_field=update_total_field-total_bayar;
		jproduk_hutangField.setValue(update_hutang_field);
		jproduk_hutang_cfField.setValue(CurrencyFormatted(update_hutang_field));
		jproduk_HutangLabel.setValue(CurrencyFormatted(update_hutang_field));

		jproduk_diskonField.setValue(jproduk_diskonField.getValue());
		jproduk_cashbackField.setValue(jproduk_cashbackField.getValue());
		jproduk_cashback_cfField.setValue(CurrencyFormatted(jproduk_cashbackField.getValue()));
		
		if(total_bayar>update_total_field){
			jproduk_pesanLabel.setText("Kelebihan Jumlah Bayar");
		}else if(total_bayar<update_total_field || total_bayar==update_total_field){
			jproduk_pesanLabel.setText("");
		}
		if(total_bayar==update_total_field){
			jproduk_lunasLabel.setText("LUNAS");
		}else if(total_bayar!==update_total_field){
			jproduk_lunasLabel.setText("");
		}
	}
	
	function load_dstore_jproduk(){
		/*
		 * yang terlibat adalah:
		 * 1. Grid Detail Pembelian
		 * 2. Sub Total Biaya
		 * 3. Disk Tambahan (%)
		 * 4. Voucher (Rp)
		 * 5. Total Biaya
		 * 6. Total Bayar
		 * 7. Total Hutang
		*/
		dharga_konversiField.setDisabled(true);
		dharga_konversiField.setReadOnly(true);
		
		var disk_tambahan_field = jproduk_diskonField.getValue();
		if(disk_tambahan_field==''){
			disk_tambahan_field = 0;
		}
		
		var voucher_rp_field = jproduk_cashbackField.getValue();
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		
		var total_bayar_field = jproduk_bayarField.getValue();
		var jumlah_item = 0;
		var sub_total_field = 0;
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		
		for(i=0;i<detail_jual_produk_DataStore.getCount();i++){
			jumlah_item+=detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah;
			sub_total_field+=detail_jual_produk_DataStore.getAt(i).data.dproduk_jumlah * detail_jual_produk_DataStore.getAt(i).data.dproduk_harga * ((100 - detail_jual_produk_DataStore.getAt(i).data.dproduk_diskon)/100);
		}
		jproduk_jumlahField.setValue(jumlah_item);
		jproduk_jumlahLabel.setValue(jumlah_item);
		jproduk_subTotalField.setValue(sub_total_field);
		jproduk_subTotal_cfField.setValue(CurrencyFormatted(sub_total_field));
		jproduk_subTotalLabel.setValue(CurrencyFormatted(sub_total_field));
		
		total_biaya_field = sub_total_field * ((100 - disk_tambahan_field)/100) - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		jproduk_totalField.setValue(total_biaya_field);
		jproduk_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		jproduk_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		
		total_hutang_field = total_biaya_field - total_bayar_field;
		jproduk_hutangField.setValue(total_hutang_field);
		jproduk_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jproduk_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
		console.clear(); // mengclear console, agar tidak membingungkan user ketika terjadi error pada firebug yg disebabkan "enter" keypress saat input detail
	}
	
	function load_total_biaya(){
		/*
		 * Field-field yang terlibat adalah:
		 * 1. Sub Total Biaya
		 * 2. Disk Tambahan (%)
		 * 3. Voucher (Rp)
		 * 4. Total Biaya
		 * 5. Total Bayar
		 * 6. Total Hutang
		 * 7. Notifikasi Kelebihan Bayar
		*/
		var sub_total_biaya_field = jproduk_subTotalField.getValue();
		var disk_tambahan_field = jproduk_diskonField.getValue();
		var voucher_rp_field = jproduk_cashbackField.getValue();
		var total_bayar_field = jproduk_bayarField.getValue();
		
		if(disk_tambahan_field==''){
			disk_tambahan_field = 0;
		}
		
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		
		total_biaya_field += sub_total_biaya_field * ((100 - disk_tambahan_field)/100) - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		jproduk_totalField.setValue(total_biaya_field);
		jproduk_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		jproduk_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		
		total_hutang_field = total_biaya_field - total_bayar_field;
		jproduk_hutangField.setValue(total_hutang_field);
		jproduk_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jproduk_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
	}
	
	function load_total_bayar(){
		/*
		 * Field-field yang terlibat adalah:
		 * 1. Cara Bayar
		 * 2. Total Biaya
		 * 3. Total Bayar
		 * 4. Total Hutang
		*/
		var total_hutang_field = 0;
		var total_bayar_field = 0;
		var total_biaya_field = jproduk_totalField.getValue();
		var transfer_nilai=0;
		var transfer_nilai2=0;
		var transfer_nilai3=0;
		var kwitansi_nilai=0;
		var kwitansi_nilai2=0;
		var kwitansi_nilai3=0;
		var card_nilai=0;
		var card_nilai2=0;
		var card_nilai3=0;
		var cek_nilai=0;
		var cek_nilai2=0;
		var cek_nilai3=0;
		var voucher_nilai=0;
		var voucher_nilai2=0;
		var voucher_nilai3=0;
		
		transfer_nilai=jproduk_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=jproduk_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;
		
		transfer_nilai2=jproduk_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=jproduk_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		
		transfer_nilai3=jproduk_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=jproduk_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		
		kwitansi_nilai=jproduk_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=jproduk_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		
		kwitansi_nilai2=jproduk_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=jproduk_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		
		kwitansi_nilai3=jproduk_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=jproduk_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		
		card_nilai=jproduk_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=jproduk_card_nilaiField.getValue();
		else
			card_nilai=0;
		
		card_nilai2=jproduk_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=jproduk_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		
		card_nilai3=jproduk_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=jproduk_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		
		cek_nilai=jproduk_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=jproduk_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		
		cek_nilai2=jproduk_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=jproduk_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		
		cek_nilai3=jproduk_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=jproduk_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		
		voucher_nilai=jproduk_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=jproduk_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		
		voucher_nilai2=jproduk_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=jproduk_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		
		voucher_nilai3=jproduk_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=jproduk_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;

		tunai_nilai=jproduk_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=jproduk_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;

		tunai_nilai2=jproduk_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=jproduk_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;

		tunai_nilai3=jproduk_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=jproduk_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;
			
		total_bayar_field=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		total_bayar_field=(total_bayar_field>0?Math.round(total_bayar_field):0);
		jproduk_bayarField.setValue(total_bayar_field);
		jproduk_bayar_cfField.setValue(CurrencyFormatted(total_bayar_field));
		jproduk_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar_field));

		total_hutang_field=total_biaya_field-total_bayar_field;
		total_hutang_field=(total_hutang_field>0?Math.round(total_hutang_field):0);
		jproduk_hutangField.setValue(total_hutang_field);
		jproduk_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jproduk_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
		
		if(total_bayar_field>total_biaya_field){
			jproduk_pesanLabel.setText("Kelebihan Jumlah Bayar");
		}else if(total_bayar_field<total_biaya_field || total_bayar_field==total_biaya_field){
			jproduk_pesanLabel.setText("");
		}
		if(total_bayar_field==total_biaya_field){
			jproduk_lunasLabel.setText("LUNAS");
		}else if(total_bayar_field!==total_biaya_field){
			jproduk_lunasLabel.setText("");
		}
	}
	
	//event on update of detail data store
	detail_jual_produk_DataStore.on("update",load_dstore_jproduk);
	jproduk_diskonField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
		load_total_biaya();
	});
	jproduk_cashback_cfField.on("keyup",function(){
		var cf_value = jproduk_cashback_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_cashbackField.setValue(cf_tonumber);
		load_total_biaya();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//kwitansi
	jproduk_kwitansi_nilai_cfField.on("keyup",function(){
		var cf_value = jproduk_kwitansi_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>jproduk_kwitansi_sisaField.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = jproduk_kwitansi_sisaField.getValue();
			jproduk_kwitansi_nilaiField.setValue(cf_tonumber);
			load_total_bayar();
			
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			jproduk_kwitansi_nilaiField.setValue(cf_tonumber);
			load_total_bayar();
			
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	jproduk_kwitansi_nilai2_cfField.on("keyup",function(){
		var cf_value = jproduk_kwitansi_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>jproduk_kwitansi_sisa2Field.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = jproduk_kwitansi_sisa2Field.getValue();
			jproduk_kwitansi_nilai2Field.setValue(cf_tonumber);
			load_total_bayar();
			
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			jproduk_kwitansi_nilai2Field.setValue(cf_tonumber);
			load_total_bayar();
			
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	jproduk_kwitansi_nilai3_cfField.on("keyup",function(){
		var cf_value = jproduk_kwitansi_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>jproduk_kwitansi_sisa3Field.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = jproduk_kwitansi_sisa3Field.getValue();
			jproduk_kwitansi_nilai3Field.setValue(cf_tonumber);
			load_total_bayar();
			
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			jproduk_kwitansi_nilai3Field.setValue(cf_tonumber);
			load_total_bayar();
			
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	//card
	jproduk_card_nilai_cfField.on("keyup",function(){
		var cf_value = jproduk_card_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_card_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_card_nilai2_cfField.on("keyup",function(){
		var cf_value = jproduk_card_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_card_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_card_nilai3_cfField.on("keyup",function(){
		var cf_value = jproduk_card_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_card_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//cek/giro
	jproduk_cek_nilai_cfField.on("keyup",function(){
		var cf_value = jproduk_cek_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_cek_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_cek_nilai2_cfField.on("keyup",function(){
		var cf_value = jproduk_cek_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_cek_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_cek_nilai3_cfField.on("keyup",function(){
		var cf_value = jproduk_cek_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_cek_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//transfer
	jproduk_transfer_nilai_cfField.on("keyup",function(){
		var cf_value = jproduk_transfer_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_transfer_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_transfer_nilai2_cfField.on("keyup",function(){
		var cf_value = jproduk_transfer_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_transfer_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_transfer_nilai3_cfField.on("keyup",function(){
		var cf_value = jproduk_transfer_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_transfer_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//voucher
	jproduk_voucher_cashbackField.on("keyup",function(){if(jproduk_post2db=="CREATE"){load_total_bayar();}else if(jproduk_post2db=="UPDATE"){load_total_bayar_updating();}});
	jproduk_voucher_cashback2Field.on("keyup",function(){if(jproduk_post2db=="CREATE"){load_total_bayar();}else if(jproduk_post2db=="UPDATE"){load_total_bayar_updating();}});
	jproduk_voucher_cashback3Field.on("keyup",function(){if(jproduk_post2db=="CREATE"){load_total_bayar();}else if(jproduk_post2db=="UPDATE"){load_total_bayar_updating();}});
	//tunai
	jproduk_tunai_nilai_cfField.on("keyup",function(){
		var cf_value = jproduk_tunai_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_tunai_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_tunai_nilai2_cfField.on("keyup",function(){
		var cf_value = jproduk_tunai_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_tunai_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_tunai_nilai3_cfField.on("keyup",function(){
		var cf_value = jproduk_tunai_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_tunai_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	
	jproduk_voucher_cashback_cfField.on("keyup",function(){
		var cf_value = jproduk_voucher_cashback_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_voucher_cashbackField.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_voucher_cashback2_cfField.on("keyup",function(){
		var cf_value = jproduk_voucher_cashback2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_voucher_cashback2Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jproduk_voucher_cashback3_cfField.on("keyup",function(){
		var cf_value = jproduk_voucher_cashback3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jproduk_voucher_cashback3Field.setValue(cf_tonumber);
		load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	
	//jproduk_caraField.on("select",update_group_carabayar_jual_produk);
	//jproduk_cara2Field.on("select",update_group_carabayar2_jual_produk);
	//jproduk_cara3Field.on("select",update_group_carabayar3_jual_produk);
	/*Sistem baru, dimana setiap kali user mengganti cara bayar, maka akan meng-reset ulang total perhitungan, hal ini dilakukan agar tidak terjadi bug(cara bayar sudah diisi nominal,lalu diganti ke cara bayar lain, lalu sudah mengurangi total biaya dan mengisi total bayar, sehingga ketika di save / print maka total bayar / total biaya sudah terakumulasi, namun cara bayarnya masih 0 (ditabel jual2 masih 0). Coba nyalakan comment diatas utk membuktikan bug tersebut */
	jproduk_caraField.on("select",function(){
		update_group_carabayar_jual_produk();
		load_total_biaya();
		load_total_bayar();
		load_dstore_jproduk();
	});
	jproduk_cara2Field.on("select",function(){
		update_group_carabayar2_jual_produk();
		load_total_biaya();
		load_total_bayar();
		load_dstore_jproduk();
	});
	jproduk_cara3Field.on("select",function(){
		update_group_carabayar3_jual_produk();
		load_total_biaya();
		load_total_bayar();
		load_dstore_jproduk();
	});
	
	jproduk_karyawanField.on("select",function(){
		var karyawan_id=jproduk_karyawanField.getValue();		
		if(karyawan_id!==0){
			karyawanDataStore.load({
					params : { karyawan_id: karyawan_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(karyawanDataStore.getCount()){
								jproduk_karyawan_record=karyawanDataStore.getAt(0).data;
								jproduk_nikkaryawanField.setValue(jproduk_karyawan_record.karyawan_no);
							}else{
								jproduk_cust_nomemberField.setValue("");
							}
						}
					}
			}); }
	});
	
	jproduk_custField.on("select",function(){
		var cust_id=jproduk_custField.getValue();
		if(cust_id!==0){
			memberDataStore.load({
					params : { member_cust: cust_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(memberDataStore.getCount()){
								jproduk_member_record=memberDataStore.getAt(0).data;
								jproduk_cust_nomemberField.setValue(jproduk_member_record.member_no);
								jproduk_valid_memberField.setValue(jproduk_member_record.member_valid);
								jproduk_cust_ultahField.setValue(jproduk_member_record.cust_tgllahir);
								jproduk_cust_priorityField.setValue(jproduk_member_record.cust_priority_star);
								if (cust_id== '9'){
									jproduk_karyawanField.setDisabled(false);
									jproduk_cust_priorityLabel.setText("");
								}
								else if (cust_id !== '9' && jproduk_cust_priorityField.getValue()=='*') {
									jproduk_cust_priorityLabel.setText("*");
									jproduk_karyawanField.setDisabled(true);
								}
								else {
									jproduk_karyawanField.setDisabled(true);
									jproduk_karyawanField.setValue(null);
									jproduk_nikkaryawanField.setValue(null);
									jproduk_cust_priorityLabel.setText("");
								}
							}else{
								jproduk_cust_nomemberField.setValue("");
								jproduk_valid_memberField.setValue("");
								jproduk_cust_ultahField.setValue("");
								jproduk_cust_priorityLabel.setText("");
							}
						}
					}
			}); 
		}
		
		cbo_cust=cbo_cust_jual_produk_DataStore.findExact('cust_id',jproduk_custField.getValue(),0);
		if(cbo_cust>-1){
			//cbo_kwitansi_jual_produk_DataStore.load({params: {kwitansi_cust: cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_id}});
			jproduk_cek_namaField.setValue(cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_nama);
			jproduk_cek_nama2Field.setValue(cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_nama);
			jproduk_cek_nama3Field.setValue(cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_nama);
			jproduk_transfer_namaField.setValue(cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_nama);
			jproduk_transfer_nama2Field.setValue(cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_nama);
			jproduk_transfer_nama3Field.setValue(cbo_cust_jual_produk_DataStore.getAt(cbo_cust).data.cust_nama);
		}
		
		
	});
	
	function show_windowGrid(){
		master_jual_produk_DataStore.load({
			params: {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if(success){
					master_jual_produk_createWindow.show();
				}
			}
		});	// load DataStore
	}
	
	/* Function for retrieve create Window Panel*/ 
	master_jual_produk_createForm = new Ext.FormPanel({
		title: 'Penjualan Produk',
		labelAlign: 'left',
		el: 'form_produk_addEdit',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 	1220,	//940,
		frame: true,
		items: [master_jual_produk_masterGroup /*,jproduk_groomingGroup*/, detail_jual_produkListEditorGrid,master_jual_produk_bayarGroup]
		,
		buttons: [
			{
				text: '<span style="font-weight:bold">Lihat Daftar</span>',
				handler: show_windowGrid
			},
			/*
			{
				text: 'Print Only2',
				ref: '../PrintOnlyButton2',
				handler: print_only2
			},
			*/
			{
				text: 'Print Only',
				ref: '../PrintOnlyButton',
				handler: print_only
			},
			{
				xtype:'spacer',
				width:710
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPRODUK'))){ ?>
			,
			/*
			{
				text: 'Save and Print 2',
				ref: '../jproduk_savePrint2',
				handler: save_andPrint2
			},
			*/
			{
				text: 'Save and Print',
				ref: '../jproduk_savePrint',
				handler: save_andPrint
			},
			{
				text: 'Save',
				handler: save_button
			},
			{
				text: 'Cancel',
				handler: jproduk_btn_cancel
			}
			<?php } ?>
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_jual_produk_createWindow= new Ext.Window({
		id: 'master_jual_produk_createWindow',
		title: 'Daftar Penjualan Produk',
		closable:true,
		closeAction: 'hide',
		width: 1220,	//810,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_jual_produk_create',
		items: master_jual_produkListEditorGrid
	});
	/* End Window */
	
	/* Function for action list search */
	function master_jual_produk_list_search(){
		var jproduk_nobukti_search=null;
		var jproduk_cust_search=null;
		var jproduk_tanggal_search_date="";
		var jproduk_tanggal_akhir_search_date="";
		var jproduk_diskon_search=null;
		var jproduk_cara_search=null;
		var jproduk_keterangan_search=null;

		if(jproduk_nobuktiSearchField.getValue()!==null){jproduk_nobukti_search=jproduk_nobuktiSearchField.getValue();}
		if(jproduk_custSearchField.getValue()!==null){jproduk_cust_search=jproduk_custSearchField.getValue();}
		if(jproduk_tanggalSearchField.getValue()!==""){jproduk_tanggal_search_date=jproduk_tanggalSearchField.getValue().format('Y-m-d');}
		if(jproduk_tanggal_akhirSearchField.getValue()!==""){jproduk_tanggal_akhir_search_date=jproduk_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(jproduk_diskonSearchField.getValue()!==null){jproduk_diskon_search=jproduk_diskonSearchField.getValue();}
		if(jproduk_caraSearchField.getValue()!==null){jproduk_cara_search=jproduk_caraSearchField.getValue();}
		if(jproduk_keteranganSearchField.getValue()!==null){jproduk_keterangan_search=jproduk_keteranganSearchField.getValue();}
		if(jproduk_stat_dokSearchField.getValue()!==null){jproduk_stat_dok_search=jproduk_stat_dokSearchField.getValue();}
		// change the store parameters
		master_jual_produk_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			jproduk_nobukti	:	jproduk_nobukti_search, 
			jproduk_cust	:	jproduk_cust_search, 
			jproduk_tanggal	:	jproduk_tanggal_search_date, 
			jproduk_tanggal_akhir	:	jproduk_tanggal_akhir_search_date, 
			jproduk_diskon	:	jproduk_diskon_search, 
			jproduk_cara	:	jproduk_cara_search, 
			jproduk_keterangan	:	jproduk_keterangan_search, 
			jproduk_stat_dok	:	jproduk_stat_dok_search
		};
		master_jual_produk_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function master_jual_produk_reset_search(){
		master_jual_produk_DataStore.baseParams = { task: 'LIST' };
		master_jual_produk_DataStore.reload({params: {start: 0, limit: pageS}});
	};
	/* End of Fuction */

	function master_jual_produk_reset_SearchForm(){
		jproduk_nobuktiSearchField.reset();
		jproduk_custSearchField.reset();
		jproduk_tanggalSearchField.reset();
		jproduk_tanggal_akhirSearchField.reset();
		jproduk_tanggal_akhirSearchField.setValue(today);
		jproduk_diskonSearchField.reset();
		jproduk_caraSearchField.reset();
		jproduk_keteranganSearchField.reset();
		jproduk_stat_dokSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  jproduk_id Search Field */
	jproduk_idSearchField= new Ext.form.NumberField({
		id: 'jproduk_idSearchField',
		fieldLabel: 'Jproduk Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jproduk_nobukti Search Field */
	jproduk_nobuktiSearchField= new Ext.form.TextField({
		id: 'jproduk_nobuktiSearchField',
		fieldLabel: 'No Faktur',
		maxLength: 30
	});
	/* Identify  jproduk_cust Search Field */
	jproduk_custSearchField= new Ext.form.ComboBox({
		id: 'jproduk_custSearchField',
		fieldLabel: 'Tenant',
		store: cbo_cust_jual_produk_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_produk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});
	/* Identify  jproduk_tanggal Search Field */
	jproduk_tanggalSearchField= new Ext.form.DateField({
		id: 'jproduk_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE
	});
	jproduk_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'jproduk_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE
	});
	/* Identify  jproduk_diskon Search Field */
	jproduk_diskonSearchField= new Ext.form.NumberField({
		id: 'jproduk_diskonSearchField',
		fieldLabel: 'Diskon',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jproduk_cara Search Field */
	jproduk_caraSearchField= new Ext.form.ComboBox({
		id: 'jproduk_caraSearchField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jproduk_cara'],
			data:[['tunai','Tunai'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jproduk_cara',
		valueField: 'value',
		width: 96,
		triggerAction: 'all'	 
	});
	/* Identify  jproduk_keterangan Search Field */
	jproduk_keteranganSearchField= new Ext.form.TextArea({
		id: 'jproduk_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'	
	});
	jproduk_stat_dokSearchField= new Ext.form.ComboBox({
		id: 'jproduk_stat_dokSearchField',
		fieldLabel: 'Status Dokumen',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jproduk_stat_dok'],
			data:[['Terbuka','Terbuka'], ['Tertutup','Tertutup'], ['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'jproduk_stat_dok',
		valueField: 'value',
		width: 96,
		triggerAction: 'all'
	});

	/* Function for retrieve search Form Panel */
	master_jual_produk_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jproduk_nobuktiSearchField, jproduk_custSearchField, 
					{
						layout:'column',
						border:false,
						items:[
						{
							columnWidth:0.45,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [						
								jproduk_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								jproduk_tanggal_akhirSearchField
							]
						}						
				        ]
					},
				jproduk_caraSearchField, 
				jproduk_keteranganSearchField,
				jproduk_stat_dokSearchField 
				] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_jual_produk_list_search
			},{
				text: 'Close',
				handler: function(){
					master_jual_produk_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_jual_produk_searchWindow = new Ext.Window({
		title: 'Pencarian Penjualan Produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_jual_produk_search',
		items: master_jual_produk_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_jual_produk_searchWindow.isVisible()){
			master_jual_produk_reset_SearchForm();
			master_jual_produk_searchWindow.show();
		} else {
			master_jual_produk_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function master_jual_produk_print(){
		var searchquery = "";
		var jproduk_nobukti_print=null;
		var jproduk_cust_print=null;
		var jproduk_tanggal_print_date="";
		var jproduk_tanggal_akhir_print_date="";
		var jproduk_diskon_print=null;
		var jproduk_cara_print=null;
		var jproduk_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(master_jual_produk_DataStore.baseParams.query!==null){searchquery = master_jual_produk_DataStore.baseParams.query;}
		if(master_jual_produk_DataStore.baseParams.jproduk_nobukti!==null){jproduk_nobukti_print = master_jual_produk_DataStore.baseParams.jproduk_nobukti;}
		if(master_jual_produk_DataStore.baseParams.jproduk_cust!==null){jproduk_cust_print = master_jual_produk_DataStore.baseParams.jproduk_cust;}
		if(master_jual_produk_DataStore.baseParams.jproduk_tanggal!==""){jproduk_tanggal_print_date = master_jual_produk_DataStore.baseParams.jproduk_tanggal;}
		if(master_jual_produk_DataStore.baseParams.jproduk_tanggal_akhir!==""){jproduk_tanggal_akhir_print_date = master_jual_produk_DataStore.baseParams.jproduk_tanggal_akhir;}
		if(master_jual_produk_DataStore.baseParams.jproduk_diskon!==null){jproduk_diskon_print = master_jual_produk_DataStore.baseParams.jproduk_diskon;}
		if(master_jual_produk_DataStore.baseParams.jproduk_cara!==null){jproduk_cara_print = master_jual_produk_DataStore.baseParams.jproduk_cara;}
		if(master_jual_produk_DataStore.baseParams.jproduk_keterangan!==null){jproduk_keterangan_print = master_jual_produk_DataStore.baseParams.jproduk_keterangan;}
		if(master_jual_produk_DataStore.baseParams.jproduk_stat_dok!==null){jproduk_stat_dok_print = master_jual_produk_DataStore.baseParams.jproduk_stat_dok;}

		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_jual_produk&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			jproduk_nobukti	:	jproduk_nobukti_print, 
			jproduk_cust	:	jproduk_cust_print, 
			jproduk_tanggal	:	jproduk_tanggal_print_date, 
			jproduk_tanggal_akhir	:	jproduk_tanggal_akhir_print_date, 
			jproduk_diskon	:	jproduk_diskon_print, 
			jproduk_cara	:	jproduk_cara_print, 
			jproduk_keterangan	:	jproduk_keterangan_print, 
			jproduk_stat_dok	:	jproduk_stat_dok_print,
		  	currentlisting: master_jual_produk_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/master_jual_produklist.html','master_jual_produklist','height=400,width=900,resizable=1,scrollbars=1, menubar=1');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Unable to print the grid!',
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
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function master_jual_produk_export_excel(){
		var searchquery = "";
		var jproduk_nobukti_2excel=null;
		var jproduk_cust_2excel=null;
		var jproduk_tanggal_2excel_date="";
		var jproduk_tanggal_akhir_2excel_date="";
		var jproduk_diskon_2excel=null;
		var jproduk_cara_2excel=null;
		var jproduk_keterangan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(master_jual_produk_DataStore.baseParams.query!==null){searchquery = master_jual_produk_DataStore.baseParams.query;}
		if(master_jual_produk_DataStore.baseParams.jproduk_nobukti!==null){jproduk_nobukti_2excel = master_jual_produk_DataStore.baseParams.jproduk_nobukti;}
		if(master_jual_produk_DataStore.baseParams.jproduk_cust!==null){jproduk_cust_2excel = master_jual_produk_DataStore.baseParams.jproduk_cust;}
		if(master_jual_produk_DataStore.baseParams.jproduk_tanggal!==""){jproduk_tanggal_2excel_date = master_jual_produk_DataStore.baseParams.jproduk_tanggal;}
		if(master_jual_produk_DataStore.baseParams.jproduk_tanggal_akhir!==""){jproduk_tanggal_akhir_2excel_date = master_jual_produk_DataStore.baseParams.jproduk_tanggal_akhir;}
		if(master_jual_produk_DataStore.baseParams.jproduk_diskon!==null){jproduk_diskon_2excel = master_jual_produk_DataStore.baseParams.jproduk_diskon;}
		if(master_jual_produk_DataStore.baseParams.jproduk_cara!==null){jproduk_cara_2excel = master_jual_produk_DataStore.baseParams.jproduk_cara;}
		if(master_jual_produk_DataStore.baseParams.jproduk_keterangan!==null){jproduk_keterangan_2excel = master_jual_produk_DataStore.baseParams.jproduk_keterangan;}
		if(master_jual_produk_DataStore.baseParams.jproduk_stat_dok!==null){jproduk_stat_dok_2excel = master_jual_produk_DataStore.baseParams.jproduk_stat_dok;}
		
		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_jual_produk&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			jproduk_nobukti	:	jproduk_nobukti_2excel, 
			jproduk_cust	:	jproduk_cust_2excel, 
			jproduk_tanggal	:	jproduk_tanggal_2excel_date, 
			jproduk_tanggal_akhir	:	jproduk_tanggal_akhir_2excel_date, 
			jproduk_diskon	:	jproduk_diskon_2excel, 
			jproduk_cara	:	jproduk_cara_2excel, 
			jproduk_keterangan	:	jproduk_keterangan_2excel, 
			jproduk_stat_dok	:	jproduk_stat_dok_2excel,
		  	currentlisting: master_jual_produk_DataStore.baseParams.task // this tells us if we are searching or not
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
					msg: 'Unable to convert excel the grid!',
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
	/*End of Function */
	function jproduk_btn_cancel(){
		master_jual_produk_reset_form();
		detail_jual_produk_DataStore.load({params: {master_id:-1}});
		jproduk_caraField.setValue("card");
		master_jual_produk_cardGroup.setVisible(true);
		master_cara_bayarTabPanel.setActiveTab(0);
		jproduk_post2db="CREATE";
		jproduk_diskonField.setValue(0);
		jproduk_cashbackField.setValue(0);
		jproduk_diskonField.allowBlank=true;
		jproduk_pesanLabel.setText('');
		jproduk_lunasLabel.setText('');
		jproduk_cust_priorityLabel.setText('');
	}
	
	function pertamax(){
		jproduk_post2db="CREATE";
		jproduk_stat_dokField.setValue('Terbuka');
		jproduk_tanggalField.setValue(dt.format('Y-m-d'));
		master_jual_produk_createForm.render();
		jproduk_caraField.setValue('card');
		master_jual_produk_cardGroup.setVisible(true);
		jproduk_cashbackField.setValue(0);
		jproduk_diskonField.setValue(0);
		jproduk_diskonField.allowBlank=true;
		jproduk_karyawanField.setDisabled(true);
	}
	pertamax();
	
/*
	Ext.Ajax.request({
		url: 'index.php?c=c_master_jual_produk&m=get_info_pajak',
		timeout: 60000,
		success: function(response){
			var result=eval(response.responseText);
		switch(result){
		case 1 :
			// kondisi pajak
			temp_pajakField.setValue('1');
			master_jual_produk_createForm.jproduk_savePrint.hide();
			master_jual_produk_createForm.jproduk_savePrint2.show();
			master_jual_produk_createForm.PrintOnlyButton.hide();
			master_jual_produk_createForm.PrintOnlyButton2.show();
			master_jual_produk_createForm.PrintOnlyButton.disable();
			master_jual_produk_createForm.PrintOnlyButton2.disable();
			master_jual_produk_ColumnModel.setHidden(3, false);
			detail_jual_produk_ColumnModel.setHidden(5, false);
			detail_jual_produk_ColumnModel.setHidden(10, false);
			break;
		default :
			// kondisi non pajak
			temp_pajakField.setValue('0');
			master_jual_produk_createForm.jproduk_savePrint.show();
			master_jual_produk_createForm.jproduk_savePrint2.hide();			
			master_jual_produk_createForm.PrintOnlyButton2.hide();
			master_jual_produk_createForm.PrintOnlyButton.show();
			master_jual_produk_createForm.PrintOnlyButton.disable();
			master_jual_produk_createForm.PrintOnlyButton2.disable();
			master_jual_produk_ColumnModel.setHidden(3, true);
			detail_jual_produk_ColumnModel.setHidden(5, true);
			detail_jual_produk_ColumnModel.setHidden(10, true);
		};
		}
	});
*/
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_jual_produk"></div>
         <div id="fp_detail_jual_produk"></div>
		<div id="elwindow_master_jual_produk_create"></div>
        <div id="elwindow_master_jual_produk_search"></div>
        <div id="form_produk_addEdit"></div>
    </div>
</div>
</body>