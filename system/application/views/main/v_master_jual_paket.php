<?
/* 	
	Miracle IT Team
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
var master_jual_paket_DataStore;
var kwitansi_jual_paket_DataStore;
var card_jual_paket_DataStore;
var cek_jual_paket_DataStore;
var transfer_jual_paket_DataStore;
//
var master_jual_paket_ColumnModel;
var master_jual_paketListEditorGrid;
var master_jual_paket_createForm;
var master_jual_paket_createWindow;
var master_jual_paket_searchForm;
var master_jual_paket_searchWindow;
var master_jual_paket_SelectedRow;
var master_jual_paket_ContextMenu;
//for detail data
var detail_jual_paket_DataStore;
var detail_jual_paketListEditorGrid;
var detail_jual_paket_ColumnModel;
var detail_jual_paket_proxy;
var detail_jual_paket_writer;
var detail_jual_paket_reader;
var editor_detail_jual_paket;
//declare konstant
var jpaket_post2db = '';
var msg = '';
var jpaket_pageS=15;
var today=new Date().format('d-m-Y');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],39); ?>";
/* declare variable here for Field*/
var jpaket_idField;
var jpaket_nobuktiField;
var jpaket_custField;
var jpaket_tanggalField;
var jpaket_diskonField;
var jpaket_bayarField;
var jpaket_caraField;
var jpaket_cara2Field;
var jpaket_cara3Field;
var jpaket_keteranganField;
var jpaket_ket_diskField;
var jpaket_ket_disk_medisField;
//tunai
var jpaket_tunai_nilaiField;
//tunai-2
var jpaket_tunai_nilai2Field;
//tunai-3
var jpaket_tunai_nilai3Field;
//voucher
var jpaket_voucher_noField;
var jpaket_voucher_cashbackField;
//voucher-2
var jpaket_voucher_no2Field;
var jpaket_voucher_cashback2Field;
//voucher-3
var jpaket_voucher_no3Field;
var jpaket_voucher_cashback3Field;
var jpaket_cashbackField;
var is_member=false;

var jpaket_cashback_num;
var jpaket_cashback_medis_num;
//kwitansi
var jpaket_kwitansi_namaField;
var jpaket_kwitansi_nilaiField;
var jpaket_kwitansi_noField;
//kwitansi-2
var jpaket_kwitansi_nama2Field;
var jpaket_kwitansi_nilai2Field;
var jpaket_kwitansi_no2Field;
//kwitansi-3
var jpaket_kwitansi_nama3Field;
var jpaket_kwitansi_nilai3Field;
var jpaket_kwitansi_no3Field;
//card
var jpaket_card_namaField;
var jpaket_card_edcField;
var jpaket_card_noField;
var jpaket_card_nilaiField;
//card-2
var jpaket_card_nama2Field;
var jpaket_card_edc2Field;
var jpaket_card_no2Field;
var jpaket_card_nilai2Field;
//card-3
var jpaket_card_nama3Field;
var jpaket_card_edc3Field;
var jpaket_card_no3Field;
var jpaket_card_nilai3Field;
//cek
var jpaket_cek_namaField;
var jpaket_cek_noField;
var jpaket_cek_validField;
var jpaket_cek_bankField;
var jpaket_cek_nilaiField;
//cek-2
var jpaket_cek_nama2Field;
var jpaket_cek_no2Field;
var jpaket_cek_valid2Field;
var jpaket_cek_bank2Field;
var jpaket_cek_nilai2Field;
//cek-3
var jpaket_cek_nama3Field;
var jpaket_cek_no3Field;
var jpaket_cek_valid3Field;
var jpaket_cek_bank3Field;
var jpaket_cek_nilai3Field;
//transfer
var jpaket_transfer_bankField;
var jpaket_transfer_namaField;
var jpaket_transfer_nilaiField;
//transfer-2
var jpaket_transfer_bank2Field;
var jpaket_transfer_nama2Field;
var jpaket_transfer_nilai2Field;
//transfer-3
var jpaket_transfer_bank3Field;
var jpaket_transfer_nama3Field;
var jpaket_transfer_nilai3Field;
var jpaket_idSearchField;
var jpaket_nobuktiSearchField;
var jpaket_custSearchField;
var jpaket_tanggalSearchField;
var jpaket_tanggal_akhirSearchField;
var jpaket_diskonSearchField;
var jpaket_caraSearchField;
var jpaket_keteranganSearchField;
var jpaket_stat_dokSearchField;
var dt= new Date();
var dt_ymd = dt.format('Y-m-d');
var cetak_jpaket=0;
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	Ext.util.Format.comboRenderer = function(combo){
  		//jpaket_bankDataStore.load();
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
	
	function jpaket_cetak(master_id){
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_paket&m=print_paper',
			params: { jpaket_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					Ext.MessageBox.hide();
					win = window.open('./jpaket_paper.html','Cetak Penjualan Paket','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
					jpaket_btn_cancel();
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
	/*function utk print_paper utk Faktur Pajak */
	function jpaket_cetak2(master_id){
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_paket&m=print_paper2',
			params: { jpaket_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					Ext.MessageBox.hide();
					win = window.open('./jpaket_paper2.html','Cetak Penjualan Paket','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
					jpaket_btn_cancel();
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
	
	function jpaket_cetak_print_only(master_id){
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_paket&m=print_only',
			params: { jpaket_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jpaket_paper.html','Cetak Penjualan Paket','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
					jpaket_btn_cancel();
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
	/*Fungsi utk mencetak print Only khusus utk faktur pajak */
	function jpaket_cetak_print_only2(master_id){
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_paket&m=print_only2',
			params: { jpaket_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./jpaket_paper2.html','Cetak Penjualan Paket','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
					jpaket_btn_cancel();
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
		var jpaket_tanggal_create_date = "";
		if(jpaket_tanggalField.getValue()!== ""){jpaket_tanggal_create_date = jpaket_tanggalField.getValue().format('Y-m-d');} 
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_jual_paket&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: jpaket_tanggal_create_date
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							master_jual_paket_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penjualan Paket tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
	function master_jual_paket_batal(){
		Ext.Ajax.request({  
			waitMsg: 'Mohon  Tunggu...',
			url: 'index.php?c=c_master_jual_paket&m=get_action',
			params: {
				task: 'BATAL',
				jpaket_id	: jpaket_idField.getValue(),
				jpaket_tanggal : jpaket_tanggalField.getValue().format('Y-m-d')
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.Msg.alert('OK', 'Pembatalan sudah dilakukan.');
						break;
					case 0:
						Ext.MessageBox.show({
						   title: 'Warning',
						   width: 400,
						   msg: 'Pembatalan tidak bisa dilakukan, <br/>karena Paket pada Faktur ini sudah pernah diambil.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   width: 450,
						   msg: 'Pembatalan tidak bisa dilakukan, <br/>karena Pembatalan hanya boleh dilakukan pada Faktur yang terbit hari ini.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						break;
				}
				detail_jual_paket_DataStore.load({params: {master_id:0}});
				master_jual_paket_reset_form();
				jpaket_caraField.setValue("card");
				master_jual_paket_cardGroup.setVisible(true);
				master_cara_bayarTabPanel.setActiveTab(0);
				jpaket_post2db="CREATE";
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
	function master_jual_paket_create(){
		var dpaket_paket_id="";
		for(i=0; i<detail_jual_paket_DataStore.getCount(); i++){
			detail_jual_paket_record=detail_jual_paket_DataStore.getAt(i);
			if(/^\d+$/.test(detail_jual_paket_record.data.dpaket_paket)){
				dpaket_paket_id="ada";
			}
		}
		var jpaket_id_for_cetak = 0;
		if(jpaket_idField.getValue()!== null){
			jpaket_id_for_cetak = jpaket_idField.getValue();
		}
		if((jpaket_bayarField.getValue()>=0) && (jpaket_bayarField.getValue()<=jpaket_totalField.getValue())){
			if(is_master_jual_paket_form_valid() && dpaket_paket_id=="ada"
			   && ((/^\d+$/.test(jpaket_custField.getValue()) && jpaket_post2db=="CREATE") || jpaket_post2db=="UPDATE")
			   && jpaket_stat_dokField.getValue()=='Terbuka'){
				var jpaket_id_create_pk=null; 
				var jpaket_nobukti_create=null; 
				var jpaket_cust_create=null; 
				var jpaket_tanggal_create_date=""; 
				var jpaket_diskon_create=null; 
				var jpaket_cara_create=null; 
				var jpaket_cara2_create=null; 
				var jpaket_cara3_create=null; 
				var jpaket_keterangan_create=null;
				var jpaket_ket_disk_create=null;
				var jpaket_ket_disk_medis_create=null;
				var jpaket_statdok_create=null;
				//tunai
				var jpaket_tunai_nilai_create=null;
				//tunai-2
				var jpaket_tunai_nilai2_create=null;
				//tunai-3
				var jpaket_tunai_nilai3_create=null;
				//voucher
				var jpaket_voucher_no_create=null;
				var jpaket_voucher_cashback_create=null;
				//voucher-2
				var jpaket_voucher_no2_create=null;
				var jpaket_voucher_cashback2_create=null;
				//voucher-3
				var jpaket_voucher_no3_create=null;
				var jpaket_voucher_cashback3_create=null;
				var jpaket_cashback_create=null;				
				var jpaket_cashback_medis_create=null;
				//bayar
				var jpaket_subtotal_create=null;
				var jpaket_total_create=null;
				var jpaket_bayar_create=null;
				var jpaket_hutang_create=null;
				//kwitansi
				var jpaket_kwitansi_nama_create="";
				var jpaket_kwitansi_nomor_create="";
				var jpaket_kwitansi_nilai_create=null;
				//kwitansi-2
				var jpaket_kwitansi_nama2_create="";
				var jpaket_kwitansi_nomor2_create="";
				var jpaket_kwitansi_nilai2_create=null;
				//kwitansi-3
				var jpaket_kwitansi_nama3_create="";
				var jpaket_kwitansi_nomor3_create="";
				var jpaket_kwitansi_nilai3_create=null;
				//card
				var jpaket_card_nama_create=null;
				var jpaket_card_edc_create=null;
				var jpaket_card_no_create=null;
				var jpaket_card_nilai_create=null;
				//card-2
				var jpaket_card_nama2_create=null;
				var jpaket_card_edc2_create=null;
				var jpaket_card_no2_create=null;
				var jpaket_card_nilai2_create=null;
				//card-3
				var jpaket_card_nama3_create=null;
				var jpaket_card_edc3_create=null;
				var jpaket_card_no3_create=null;
				var jpaket_card_nilai3_create=null;
				//cek
				var jpaket_cek_nama_create='';
				var jpaket_cek_nomor_create='';
				var jpaket_cek_valid_create='';
				var jpaket_cek_bank_create='';
				var jpaket_cek_nilai_create=null;
				//cek-2
				var jpaket_cek_nama2_create='';
				var jpaket_cek_nomor2_create='';
				var jpaket_cek_valid2_create='';
				var jpaket_cek_bank2_create='';
				var jpaket_cek_nilai2_create=null;
				//cek-3
				var jpaket_cek_nama3_create='';
				var jpaket_cek_nomor3_create='';
				var jpaket_cek_valid3_create='';
				var jpaket_cek_bank3_create='';
				var jpaket_cek_nilai3_create=null;
				//transfer
				var jpaket_transfer_bank_create='';
				var jpaket_transfer_nama_create='';
				var jpaket_transfer_nilai_create=null;
				//transfer-2
				var jpaket_transfer_bank2_create='';
				var jpaket_transfer_nama2_create='';
				var jpaket_transfer_nilai2_create=null;
				//transfer-3
				var jpaket_transfer_bank3_create='';
				var jpaket_transfer_nama3_create='';
				var jpaket_transfer_nilai3_create=null;
				if(jpaket_idField.getValue()!== null){jpaket_id_create_pk = jpaket_idField.getValue();}else{jpaket_id_create_pk=get_pk_id();} 
				if(jpaket_nobuktiField.getValue()!== null){jpaket_nobukti_create = jpaket_nobuktiField.getValue();} 
				if((jpaket_post2db=="CREATE") && (jpaket_custField.getValue()!== null)){
					jpaket_cust_create = jpaket_custField.getValue();
				}else if(jpaket_post2db=="UPDATE"){
					jpaket_cust_create = jpaket_cust_idField.getValue();
				}
				if(jpaket_tanggalField.getValue()!== ""){jpaket_tanggal_create_date = jpaket_tanggalField.getValue().format('Y-m-d');} 
				//if(jpaket_diskonField.getValue()!== null){jpaket_diskon_create = jpaket_diskonField.getValue();} 
				if(jpaket_caraField.getValue()!== null){jpaket_cara_create = jpaket_caraField.getValue();} 
				if(jpaket_cara2Field.getValue()!== null){jpaket_cara2_create = jpaket_cara2Field.getValue();} 
				if(jpaket_cara3Field.getValue()!== null){jpaket_cara3_create = jpaket_cara3Field.getValue();} 
				if(jpaket_keteranganField.getValue()!== null){jpaket_keterangan_create = jpaket_keteranganField.getValue();}
				if(jpaket_ket_diskField.getValue()!== null){jpaket_ket_disk_create = jpaket_ket_diskField.getValue();}
				if(jpaket_ket_disk_medisField.getValue()!== null){jpaket_ket_disk_medis_create = jpaket_ket_disk_medisField.getValue();}
				
				if(jpaket_stat_dokField.getValue()!== null){jpaket_statdok_create = jpaket_stat_dokField.getValue();} 
				//tunai
				if(jpaket_tunai_nilaiField.getValue()!== null){jpaket_tunai_nilai_create = jpaket_tunai_nilaiField.getValue();}
				//tunai-2
				if(jpaket_tunai_nilai2Field.getValue()!== null){jpaket_tunai_nilai2_create = jpaket_tunai_nilai2Field.getValue();}
				//tunai-3
				if(jpaket_tunai_nilai3Field.getValue()!== null){jpaket_tunai_nilai3_create = jpaket_tunai_nilai3Field.getValue();}
				//voucher
				if(jpaket_voucher_noField.getValue()!== null){jpaket_voucher_no_create = jpaket_voucher_noField.getValue();} 
				if(jpaket_voucher_cashbackField.getValue()!== null){jpaket_voucher_cashback_create = jpaket_voucher_cashbackField.getValue();} 
				//voucher-2
				if(jpaket_voucher_no2Field.getValue()!== null){jpaket_voucher_no2_create = jpaket_voucher_no2Field.getValue();} 
				if(jpaket_voucher_cashback2Field.getValue()!== null){jpaket_voucher_cashback2_create = jpaket_voucher_cashback2Field.getValue();} 
				//voucher-3
				if(jpaket_voucher_no3Field.getValue()!== null){jpaket_voucher_no3_create = jpaket_voucher_no3Field.getValue();} 				
				if(jpaket_voucher_cashback3Field.getValue()!== null){jpaket_voucher_cashback3_create = jpaket_voucher_cashback3Field.getValue();} 
				
				//if(jpaket_cashbackField.getValue()!== null){jpaket_cashback_create = jpaket_cashbackField.getValue();} 
				
				if(jpaket_cashback_num.getValue()!== null){jpaket_cashback_create = jpaket_cashback_num.getValue();} 
				if(jpaket_cashback_medis_num.getValue()!== null){jpaket_cashback_medis_create = jpaket_cashback_medis_num.getValue();}
				
				//bayar
				if(jpaket_bayarField.getValue()!== null){jpaket_bayar_create = jpaket_bayarField.getValue();}
				if(jpaket_subTotalField.getValue()!== null){jpaket_subtotal_create = jpaket_subTotalField.getValue();} 
				if(jpaket_totalField.getValue()!== null){jpaket_total_create = jpaket_totalField.getValue();} 
				if(jpaket_hutangField.getValue()!== null){jpaket_hutang_create = jpaket_hutangField.getValue();} 
				//kwitansi value
				/*
				if((jpaket_kwitansi_noField.getValue()!=="") && (jpaket_post2db=='CREATE')){
					jpaket_kwitansi_nomor_create = jpaket_kwitansi_noField.getValue();
				}else if(jpaket_post2db=='UPDATE'){
					jpaket_kwitansi_nomor_create = jpaket_kwitansi_noField.getValue();
					//jpaket_kwitansi_nomor_create = jpaket_kwitansi_idField.getValue();
				}
				*/
				if(jpaket_kwitansi_namaField.getValue()!==""){jpaket_kwitansi_nama_create = jpaket_kwitansi_namaField.getValue();} 
				if(jpaket_kwitansi_nilaiField.getValue()!== null){jpaket_kwitansi_nilai_create = jpaket_kwitansi_nilaiField.getValue();} 
				//kwitansi-2 value
				/*
				if((jpaket_kwitansi_no2Field.getValue()!=="") && (jpaket_post2db=='CREATE')){
					jpaket_kwitansi_nomor2_create = jpaket_kwitansi_no2Field.getValue();
				}else if(jpaket_post2db=='UPDATE'){
					jpaket_kwitansi_nomor2_create = jpaket_kwitansi_id2Field.getValue();
				}
				*/
				if(jpaket_kwitansi_nama2Field.getValue()!==""){jpaket_kwitansi_nama2_create = jpaket_kwitansi_nama2Field.getValue();} 
				if(jpaket_kwitansi_nilai2Field.getValue()!== null){jpaket_kwitansi_nilai2_create = jpaket_kwitansi_nilai2Field.getValue();} 
				//kwitansi-3 value
				/*
				if((jpaket_kwitansi_no3Field.getValue()!=="") && (jpaket_post2db=='CREATE')){
					jpaket_kwitansi_nomor3_create = jpaket_kwitansi_no3Field.getValue();
				}else if(jpaket_post2db=='UPDATE'){
					jpaket_kwitansi_nomor3_create = jpaket_kwitansi_id3Field.getValue();
				}
				*/
				if(jpaket_kwitansi_nama3Field.getValue()!==""){jpaket_kwitansi_nama3_create = jpaket_kwitansi_nama3Field.getValue();} 
				if(jpaket_kwitansi_nilai3Field.getValue()!== null){jpaket_kwitansi_nilai3_create = jpaket_kwitansi_nilai3Field.getValue();} 
				//card value
				if(jpaket_card_namaField.getValue()!== null){jpaket_card_nama_create = jpaket_card_namaField.getValue();} 
				if(jpaket_card_edcField.getValue()!==null){jpaket_card_edc_create = jpaket_card_edcField.getValue();} 
				if(jpaket_card_noField.getValue()!==null){jpaket_card_no_create = jpaket_card_noField.getValue();}
				if(jpaket_card_nilaiField.getValue()!==null){jpaket_card_nilai_create = jpaket_card_nilaiField.getValue();} 
				//card-2 value
				if(jpaket_card_nama2Field.getValue()!== null){jpaket_card_nama2_create = jpaket_card_nama2Field.getValue();} 
				if(jpaket_card_edc2Field.getValue()!==null){jpaket_card_edc2_create = jpaket_card_edc2Field.getValue();} 
				if(jpaket_card_no2Field.getValue()!==null){jpaket_card_no2_create = jpaket_card_no2Field.getValue();}
				if(jpaket_card_nilai2Field.getValue()!==null){jpaket_card_nilai2_create = jpaket_card_nilai2Field.getValue();} 
				//card-3 value
				if(jpaket_card_nama3Field.getValue()!== null){jpaket_card_nama3_create = jpaket_card_nama3Field.getValue();} 
				if(jpaket_card_edc3Field.getValue()!==null){jpaket_card_edc3_create = jpaket_card_edc3Field.getValue();} 
				if(jpaket_card_no3Field.getValue()!==null){jpaket_card_no3_create = jpaket_card_no3Field.getValue();}
				if(jpaket_card_nilai3Field.getValue()!==null){jpaket_card_nilai3_create = jpaket_card_nilai3Field.getValue();} 
				//cek value
				if(jpaket_cek_namaField.getValue()!== null){jpaket_cek_nama_create = jpaket_cek_namaField.getValue();} 
				if(jpaket_cek_noField.getValue()!== null){jpaket_cek_nomor_create = jpaket_cek_noField.getValue();} 
				if(jpaket_cek_validField.getValue()!== ""){jpaket_cek_valid_create = jpaket_cek_validField.getValue().format('Y-m-d');} 
				if(jpaket_cek_bankField.getValue()!== null){jpaket_cek_bank_create = jpaket_cek_bankField.getValue();} 
				if(jpaket_cek_nilaiField.getValue()!== null){jpaket_cek_nilai_create = jpaket_cek_nilaiField.getValue();} 
				//cek-2 value
				if(jpaket_cek_nama2Field.getValue()!== null){jpaket_cek_nama2_create = jpaket_cek_nama2Field.getValue();} 
				if(jpaket_cek_no2Field.getValue()!== null){jpaket_cek_nomor2_create = jpaket_cek_no2Field.getValue();} 
				if(jpaket_cek_valid2Field.getValue()!== ""){jpaket_cek_valid2_create = jpaket_cek_valid2Field.getValue().format('Y-m-d');} 
				if(jpaket_cek_bank2Field.getValue()!== null){jpaket_cek_bank2_create = jpaket_cek_bank2Field.getValue();} 
				if(jpaket_cek_nilai2Field.getValue()!== null){jpaket_cek_nilai2_create = jpaket_cek_nilai2Field.getValue();}
				//cek-3 value
				if(jpaket_cek_nama3Field.getValue()!== null){jpaket_cek_nama3_create = jpaket_cek_nama3Field.getValue();} 
				if(jpaket_cek_no3Field.getValue()!== null){jpaket_cek_nomor3_create = jpaket_cek_no3Field.getValue();} 
				if(jpaket_cek_valid3Field.getValue()!== ""){jpaket_cek_valid3_create = jpaket_cek_valid3Field.getValue().format('Y-m-d');} 
				if(jpaket_cek_bank3Field.getValue()!== null){jpaket_cek_bank3_create = jpaket_cek_bank3Field.getValue();} 
				if(jpaket_cek_nilai3Field.getValue()!== null){jpaket_cek_nilai3_create = jpaket_cek_nilai3Field.getValue();} 
				//transfer value
				if(jpaket_transfer_bankField.getValue()!== null){jpaket_transfer_bank_create = jpaket_transfer_bankField.getValue();} 
				if(jpaket_transfer_namaField.getValue()!== null){jpaket_transfer_nama_create = jpaket_transfer_namaField.getValue();}
				if(jpaket_transfer_nilaiField.getValue()!== null){jpaket_transfer_nilai_create = jpaket_transfer_nilaiField.getValue();} 
				//transfer-2 value
				if(jpaket_transfer_bank2Field.getValue()!== null){jpaket_transfer_bank2_create = jpaket_transfer_bank2Field.getValue();} 
				if(jpaket_transfer_nama2Field.getValue()!== null){jpaket_transfer_nama2_create = jpaket_transfer_nama2Field.getValue();}
				if(jpaket_transfer_nilai2Field.getValue()!== null){jpaket_transfer_nilai2_create = jpaket_transfer_nilai2Field.getValue();} 
				//transfer-3 value
				if(jpaket_transfer_bank3Field.getValue()!== null){jpaket_transfer_bank3_create = jpaket_transfer_bank3Field.getValue();} 
				if(jpaket_transfer_nama3Field.getValue()!== null){jpaket_transfer_nama3_create = jpaket_transfer_nama3Field.getValue();}
				if(jpaket_transfer_nilai3Field.getValue()!== null){jpaket_transfer_nilai3_create = jpaket_transfer_nilai3Field.getValue();}
				var jpaket_cetak_value = this.cetak_jpaket;
				Ext.Ajax.request({  
					waitMsg: 'Mohon  Tunggu...',
					url: 'index.php?c=c_master_jual_paket&m=get_action',
					params: {
						task					: 	jpaket_post2db,
						cetak					: 	jpaket_cetak_value,
						jpaket_id				: 	jpaket_id_create_pk, 
						jpaket_nobukti			: 	jpaket_nobukti_create, 
						jpaket_cust				: 	jpaket_cust_create, 
						jpaket_tanggal			: 	jpaket_tanggal_create_date, 
						//jpaket_diskon				: 	jpaket_diskon_create, 
						jpaket_cara				: 	jpaket_cara_create, 
						jpaket_cara2			: 	jpaket_cara2_create, 
						jpaket_cara3			: 	jpaket_cara3_create, 
						jpaket_keterangan		: 	jpaket_keterangan_create,
						jpaket_ket_disk			: 	jpaket_ket_disk_create,
						jpaket_ket_disk_medis 	: 	jpaket_ket_disk_medis_create,
						jpaket_stat_dok			:	jpaket_statdok_create,
						jpaket_cashback			: 	jpaket_cashback_create,
						jpaket_cashback_medis	: 	jpaket_cashback_medis_create,
						//tunai
						jpaket_tunai_nilai		:	jpaket_tunai_nilai_create,
						//tunai-2
						jpaket_tunai_nilai2		:	jpaket_tunai_nilai2_create,
						//tunai-3
						jpaket_tunai_nilai3		:	jpaket_tunai_nilai3_create,
						//voucher
						jpaket_voucher_no		:	jpaket_voucher_no_create,
						jpaket_voucher_cashback	:	jpaket_voucher_cashback_create,
						//voucher-2
						jpaket_voucher_no2		:	jpaket_voucher_no2_create,
						jpaket_voucher_cashback2:	jpaket_voucher_cashback2_create,
						//voucher-3
						jpaket_voucher_no3		:	jpaket_voucher_no3_create,
						jpaket_voucher_cashback3:	jpaket_voucher_cashback3_create,
						jpaket_voucher_cashback	:	jpaket_voucher_cashback_create,
						//bayar
						jpaket_bayar			: 	jpaket_bayar_create,
						jpaket_subtotal			: 	jpaket_subtotal_create,
						jpaket_total			: 	jpaket_total_create,
						jpaket_hutang			: 	jpaket_hutang_create,
						//kwitansi posting
						jual_kwitansi_id		:	jpaket_jual_kwitansi_idField1.getValue(),
						jpaket_kwitansi_no		:	jpaket_kwitansi_noField.getValue(),
						jpaket_kwitansi_nama	:	jpaket_kwitansi_nama_create,
						jpaket_kwitansi_nilai	:	jpaket_kwitansi_nilai_create,
						//kwitansi-2 posting
						jual_kwitansi_id2		:	jpaket_jual_kwitansi_idField2.getValue(),
						jpaket_kwitansi_no2		:	jpaket_kwitansi_no2Field.getValue(),
						jpaket_kwitansi_nama2	:	jpaket_kwitansi_nama2_create,
						jpaket_kwitansi_nilai2	:	jpaket_kwitansi_nilai2_create,
						//kwitansi-3 posting
						jual_kwitansi_id3		:	jpaket_jual_kwitansi_idField3.getValue(),
						jpaket_kwitansi_no3		:	jpaket_kwitansi_no3Field.getValue(),
						jpaket_kwitansi_nama3	:	jpaket_kwitansi_nama3_create,
						jpaket_kwitansi_nilai3	:	jpaket_kwitansi_nilai3_create,
						//card posting
						jpaket_card_nama		: 	jpaket_card_nama_create,
						jpaket_card_edc			:	jpaket_card_edc_create,
						jpaket_card_no			:	jpaket_card_no_create,
						jpaket_card_nilai		:	jpaket_card_nilai_create,
						//card-2 posting
						jpaket_card_nama2		: 	jpaket_card_nama2_create,
						jpaket_card_edc2		:	jpaket_card_edc2_create,
						jpaket_card_no2			:	jpaket_card_no2_create,
						jpaket_card_nilai2		:	jpaket_card_nilai2_create,
						//card-3 posting
						jpaket_card_nama3		: 	jpaket_card_nama3_create,
						jpaket_card_edc3		:	jpaket_card_edc3_create,
						jpaket_card_no3			:	jpaket_card_no3_create,
						jpaket_card_nilai3		:	jpaket_card_nilai3_create,
						//cek posting
						jpaket_cek_nama			: 	jpaket_cek_nama_create,
						jpaket_cek_no			:	jpaket_cek_nomor_create,
						jpaket_cek_valid		: 	jpaket_cek_valid_create,
						jpaket_cek_bank			:	jpaket_cek_bank_create,
						jpaket_cek_nilai		:	jpaket_cek_nilai_create,
						//cek-2 posting
						jpaket_cek_nama2		: 	jpaket_cek_nama2_create,
						jpaket_cek_no2			:	jpaket_cek_nomor2_create,
						jpaket_cek_valid2		: 	jpaket_cek_valid2_create,
						jpaket_cek_bank2		:	jpaket_cek_bank2_create,
						jpaket_cek_nilai2		:	jpaket_cek_nilai2_create,
						//cek-3 posting
						jpaket_cek_nama3		: 	jpaket_cek_nama3_create,
						jpaket_cek_no3			:	jpaket_cek_nomor3_create,
						jpaket_cek_valid3		: 	jpaket_cek_valid3_create,
						jpaket_cek_bank3		:	jpaket_cek_bank3_create,
						jpaket_cek_nilai3		:	jpaket_cek_nilai3_create,
						//transfer posting
						jpaket_transfer_bank	:	jpaket_transfer_bank_create,
						jpaket_transfer_nama	:	jpaket_transfer_nama_create,
						jpaket_transfer_nilai	:	jpaket_transfer_nilai_create,
						//transfer-2 posting
						jpaket_transfer_bank2	:	jpaket_transfer_bank2_create,
						jpaket_transfer_nama2	:	jpaket_transfer_nama2_create,
						jpaket_transfer_nilai2	:	jpaket_transfer_nilai2_create,
						//transfer-3 posting
						jpaket_transfer_bank3	:	jpaket_transfer_bank3_create,
						jpaket_transfer_nama3	:	jpaket_transfer_nama3_create,
						jpaket_transfer_nilai3	:	jpaket_transfer_nilai3_create
					}, 
					success: function(response){             
						var result=eval(response.responseText);
						switch(result){
							case 1:
								detail_jual_paket_insert();
								detail_pengguna_paket_insert();
								master_jual_paket_createWindow.hide();
								break;
							default:
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Data penjualan paket tidak bisa disimpan',
								   buttons: Ext.MessageBox.OK,
								   animEl: 'save',
								   icon: Ext.MessageBox.WARNING
								});
								jpaket_btn_cancel();
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
						jpaket_btn_cancel();
					}                      
				});
			}else if(jpaket_post2db=='UPDATE' && jpaket_stat_dokField.getValue()=='Tertutup'){
				if(cetak_jpaket==1){
					jpaket_cetak(jpaket_id_for_cetak);
					cetak_jpaket=0;
				}
				else if(cetak_jpaket==2){
					jpaket_cetak2(jpaket_id_for_cetak);
					cetak_jpaket=0;
				}
				detail_pengguna_paket_insert();
			}else if(jpaket_post2db=="UPDATE" && jpaket_stat_dokField.getValue()=='Batal'){
				Ext.Ajax.request({  
					waitMsg: 'Mohon  Tunggu...',
					url: 'index.php?c=c_master_jual_paket&m=get_action',
					params: {
						task: 'BATAL',
						jpaket_id	: jpaket_idField.getValue()
					}, 
					success: function(response){             
						var result=eval(response.responseText);
						if(result==1){
							jpaket_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'INFO',
							   msg: 'Dokumen Penjualan Paket telah dibatalkan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.INFO
							});
							jpaket_btn_cancel();
						}else{
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 400,
							   msg: 'Dokumen Penjualan Paket tidak bisa dibatalkan, <br/>karena paket pada Faktur ini sudah pernah diambil.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							jpaket_btn_cancel();
						}
					},
					failure: function(response){
						jpaket_post2db='CREATE';
						var result=response.responseText;
						Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
						});
						jpaket_btn_cancel();
					}                      
				});
			}else{
				if(dpaket_paket_id!="ada"){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Detail penjualan paket tidak boleh kosong',
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
		cetak_jpaket=1;
		pengecekan_dokumen();
		jpaket_pesanLabel.setText('');
		jpaket_lunasLabel.setText('');
		jpaket_cust_priorityLabel.setText('');
	}
	
	function save_andPrint2(){
		cetak_jpaket=2;
		pengecekan_dokumen();
		jpaket_pesanLabel.setText('');
		jpaket_lunasLabel.setText('');
		jpaket_cust_priorityLabel.setText('');
	}
	
	function save_paket(){
		cetak_jpaket=0;
		pengecekan_dokumen();
	}
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function print_only(){
		if(jpaket_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		cetak_jpaket=1;		
		var jpaket_id_for_cetak = 0;
		if(jpaket_idField.getValue()!== null){
			jpaket_id_for_cetak = jpaket_idField.getValue();
		}
		if(cetak_jpaket==1){
			jpaket_cetak_print_only(jpaket_id_for_cetak);
			cetak_jpaket=0;
		}
		}
	}
	
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen..  Print Only utk Faktur Pajak
	function print_only2(){
		if(jpaket_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		cetak_jpaket=2;		
		var jpaket_id_for_cetak = 0;
		if(jpaket_idField.getValue()!== null){
			jpaket_id_for_cetak = jpaket_idField.getValue();
		}
		if(cetak_jpaket==2){
			jpaket_cetak_print_only2(jpaket_id_for_cetak);
			cetak_jpaket=0;
		}
		}
	}
	
  	/* Function for get PK field */
	function get_pk_id(){
		if(jpaket_post2db=='UPDATE'){
			return master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_id');
		}else 
			return 0;
	}
	/* End of Function  */
	function get_stat_dok(){
		if(jpaket_post2db=='UPDATE')
			return master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok');
		else 
			return 'Terbuka';
	}
	// Reset kwitansi option
	function kwitansi_jual_paket_reset_form(){
		jpaket_kwitansi_namaField.reset();
		jpaket_kwitansi_nilaiField.reset();
		jpaket_kwitansi_nilai_cfField.reset();
		jpaket_kwitansi_noField.reset();
		jpaket_kwitansi_sisaField.reset();
		jpaket_kwitansi_namaField.setValue("");
		jpaket_kwitansi_nilaiField.setValue(null);
		jpaket_kwitansi_nilai_cfField.setValue(null);
		jpaket_kwitansi_noField.setValue("");
		jpaket_kwitansi_sisaField.setValue(null);
		jpaket_jual_kwitansi_idField1.reset();
		jpaket_jual_kwitansi_idField1.setValue(null);
	}
	// Reset kwitansi-2 option
	function kwitansi2_jual_paket_reset_form(){
		jpaket_kwitansi_nama2Field.reset();
		jpaket_kwitansi_nilai2Field.reset();
		jpaket_kwitansi_nilai2_cfField.reset();
		jpaket_kwitansi_no2Field.reset();
		jpaket_kwitansi_sisa2Field.reset();
		jpaket_kwitansi_nama2Field.setValue("");
		jpaket_kwitansi_nilai2Field.setValue(null);
		jpaket_kwitansi_nilai2_cfField.setValue(null);
		jpaket_kwitansi_no2Field.setValue("");
		jpaket_kwitansi_sisa2Field.setValue(null);
		jpaket_jual_kwitansi_idField2.reset();
		jpaket_jual_kwitansi_idField2.setValue(null);
	}
	// Reset kwitansi-3 option
	function kwitansi3_jual_paket_reset_form(){
		jpaket_kwitansi_nama3Field.reset();
		jpaket_kwitansi_nilai3Field.reset();
		jpaket_kwitansi_nilai3_cfField.reset();
		jpaket_kwitansi_no3Field.reset();
		jpaket_kwitansi_sisaField.reset();
		jpaket_kwitansi_nama3Field.setValue("");
		jpaket_kwitansi_nilai3Field.setValue(null);
		jpaket_kwitansi_nilai3_cfField.setValue(null);
		jpaket_kwitansi_no3Field.setValue("");
		jpaket_kwitansi_sisaField.setValue(null);
		jpaket_jual_kwitansi_idField3.reset();
		jpaket_jual_kwitansi_idField3.setValue(null);
	}
	// Reset card option
	function card_jual_paket_reset_form(){
		jpaket_card_namaField.reset();
		jpaket_card_edcField.reset();
		jpaket_card_noField.reset();
		jpaket_card_nilaiField.reset();
		jpaket_card_nilai_cfField.reset();
		jpaket_card_namaField.setValue("");
		jpaket_card_edcField.setValue("");
		jpaket_card_noField.setValue("");
		jpaket_card_nilaiField.setValue(null);
		jpaket_card_nilai_cfField.setValue(null);
	}
	// Reset card-2 option
	function card2_jual_paket_reset_form(){
		jpaket_card_nama2Field.reset();
		jpaket_card_edc2Field.reset();
		jpaket_card_no2Field.reset();
		jpaket_card_nilai2Field.reset();
		jpaket_card_nilai2_cfField.reset();
		jpaket_card_nama2Field.setValue("");
		jpaket_card_edc2Field.setValue("");
		jpaket_card_no2Field.setValue("");
		jpaket_card_nilai2Field.setValue(null);
		jpaket_card_nilai2_cfField.setValue(null);
	}
	// Reset card-3 option
	function card3_jual_paket_reset_form(){
		jpaket_card_nama3Field.reset();
		jpaket_card_edc3Field.reset();
		jpaket_card_no3Field.reset();
		jpaket_card_nilai3Field.reset();
		jpaket_card_nilai3_cfField.reset();
		jpaket_card_nama3Field.setValue("");
		jpaket_card_edc3Field.setValue("");
		jpaket_card_no3Field.setValue("");
		jpaket_card_nilai3Field.setValue(null);
		jpaket_card_nilai3_cfField.setValue(null);
	}
	// Reset cek option
	function cek_jual_paket_reset_form(){
		jpaket_cek_namaField.reset();
		jpaket_cek_noField.reset();
		jpaket_cek_validField.reset();
		jpaket_cek_bankField.reset();
		jpaket_cek_nilaiField.reset();
		jpaket_cek_nilai_cfField.reset();
		jpaket_cek_namaField.setValue(null);
		jpaket_cek_noField.setValue("");
		jpaket_cek_validField.setValue("");
		jpaket_cek_bankField.setValue("");
		jpaket_cek_nilaiField.setValue(null);
		jpaket_cek_nilai_cfField.setValue(null);
	}
	// Reset cek-2 option
	function cek2_jual_paket_reset_form(){
		jpaket_cek_nama2Field.reset();
		jpaket_cek_no2Field.reset();
		jpaket_cek_valid2Field.reset();
		jpaket_cek_bank2Field.reset();
		jpaket_cek_nilai2Field.reset();
		jpaket_cek_nilai2_cfField.reset();
		jpaket_cek_nama2Field.setValue(null);
		jpaket_cek_no2Field.setValue("");
		jpaket_cek_valid2Field.setValue("");
		jpaket_cek_bank2Field.setValue("");
		jpaket_cek_nilai2Field.setValue(null);
		jpaket_cek_nilai2_cfField.setValue(null);
	}
	// Reset cek-3 option
	function cek3_jual_paket_reset_form(){
		jpaket_cek_nama3Field.reset();
		jpaket_cek_no3Field.reset();
		jpaket_cek_valid3Field.reset();
		jpaket_cek_bank3Field.reset();
		jpaket_cek_nilai3Field.reset();
		jpaket_cek_nilai3_cfField.reset();
		jpaket_cek_nama3Field.setValue(null);
		jpaket_cek_no3Field.setValue("");
		jpaket_cek_valid3Field.setValue("");
		jpaket_cek_bank3Field.setValue("");
		jpaket_cek_nilai3Field.setValue(null);
		jpaket_cek_nilai3_cfField.setValue(null);
	}
	// Reset transfer option
	function transfer_jual_paket_reset_form(){
		jpaket_transfer_bankField.reset();
		jpaket_transfer_namaField.reset();
		jpaket_transfer_nilaiField.reset();
		jpaket_transfer_nilai_cfField.reset();
		jpaket_transfer_bankField.setValue("");
		jpaket_transfer_namaField.setValue(null);
		jpaket_transfer_nilaiField.setValue(null);
		jpaket_transfer_nilai_cfField.setValue(null);
	}
	// Reset transfer-2 option
	function transfer2_jual_paket_reset_form(){
		jpaket_transfer_bank2Field.reset();
		jpaket_transfer_nama2Field.reset();
		jpaket_transfer_nilai2Field.reset();
		jpaket_transfer_nilai2_cfField.reset();
		jpaket_transfer_bank2Field.setValue("");
		jpaket_transfer_nama2Field.setValue(null);
		jpaket_transfer_nilai2Field.setValue(null);
		jpaket_transfer_nilai2_cfField.setValue(null);
	}
	// Reset transfer-3 option
	function transfer3_jual_paket_reset_form(){
		jpaket_transfer_bank3Field.reset();
		jpaket_transfer_nama3Field.reset();
		jpaket_transfer_nilai3Field.reset();
		jpaket_transfer_nilai3_cfField.reset();
		jpaket_transfer_bank3Field.setValue("");
		jpaket_transfer_nama3Field.setValue(null);
		jpaket_transfer_nilai3Field.setValue(null);
		jpaket_transfer_nilai3_cfField.setValue(null);
	}
	// Reset tunai option
	function tunai_jual_paket_reset_form(){
		jpaket_tunai_nilaiField.reset();
		jpaket_tunai_nilaiField.setValue(null);
		jpaket_tunai_nilai_cfField.reset();
		jpaket_tunai_nilai_cfField.setValue(null);
	}
	// Reset tunai-2 option
	function tunai2_jual_paket_reset_form(){
		jpaket_tunai_nilai2Field.reset();
		jpaket_tunai_nilai2Field.setValue(null);
		jpaket_tunai_nilai2_cfField.reset();
		jpaket_tunai_nilai2_cfField.setValue(null);
	}
	// Reset tunai-3 option
	function tunai3_jual_paket_reset_form(){
		jpaket_tunai_nilai3Field.reset();
		jpaket_tunai_nilai3Field.setValue(null);
		jpaket_tunai_nilai3_cfField.reset();
		jpaket_tunai_nilai3_cfField.setValue(null);
	}
	//Reset voucher option
	function voucher_jual_paket_reset_form(){
		jpaket_voucher_noField.reset();
		jpaket_voucher_cashbackField.reset();
		jpaket_voucher_cashback_cfField.reset();
		jpaket_voucher_noField.setValue("");
		jpaket_voucher_cashbackField.setValue(null);
		jpaket_voucher_cashback_cfField.setValue(null);
	}
	//Reset voucher-2 option
	function voucher2_jual_paket_reset_form(){
		jpaket_voucher_no2Field.reset();
		jpaket_voucher_cashback2Field.reset();
		jpaket_voucher_cashback2_cfField.reset();
		jpaket_voucher_no2Field.setValue("");
		jpaket_voucher_cashback2Field.setValue(null);
		jpaket_voucher_cashback2_cfField.setValue(null);
	}
	//Reset voucher-3 option
	function voucher3_jual_paket_reset_form(){
		jpaket_voucher_no3Field.reset();
		jpaket_voucher_cashback3Field.reset();
		jpaket_voucher_cashback3_cfField.reset();
		jpaket_voucher_no3Field.setValue("");
		jpaket_voucher_cashback3Field.setValue(null);
		jpaket_voucher_cashback3_cfField.setValue(null);
	}
	/* Reset form before loading */
	function master_jual_paket_reset_form(){
		jpaket_post2db="CREATE";
		detail_jual_paket_DataStore.load({params: {master_id:-1}});
		detail_pengguna_paket_DataStore.load({params: {master_id:-1}});
		jpaket_idField.reset();
		jpaket_idField.setValue(null);
		jpaket_nobuktiField.reset();
		jpaket_nobuktiField.setValue(null);
		jpaket_custField.reset();
		jpaket_custField.setValue(null);
		jpaket_cust_nomemberField.reset();
		jpaket_cust_nomemberField.setValue(null);
		jpaket_valid_memberField.setValue("");
		jpaket_cust_ultahField.setValue("");
		jpaket_tanggalField.setValue(dt.format('Y-m-d'));
		//jpaket_diskonField.reset();
		//jpaket_diskonField.setValue(null);
		jpaket_caraField.reset();
		jpaket_caraField.setValue(null);
		jpaket_cara2Field.reset();
		jpaket_cara2Field.setValue(null);
		jpaket_cara3Field.reset();
		jpaket_cara3Field.setValue(null);
		//jpaket_cashbackField.reset();
		//jpaket_cashbackField.setValue(null);
		jpaket_cashback_cfField.reset();
		jpaket_cashback_cfField.setValue(null);
		
		jpaket_cashback_num.reset();
		jpaket_cashback_num.setValue(null);
		
		jpaket_cashback_medis_num.reset();
		jpaket_cashback_medis_num.setValue(null);
		jpaket_cashback_cf_medisField.reset();
		jpaket_cashback_cf_medisField.setValue(null);
		jpaket_ket_diskField.setDisabled(false);
		jpaket_ket_disk_medisField.setDisabled(false);
		
		jpaket_keteranganField.reset();
		jpaket_keteranganField.setValue(null);
		jpaket_ket_diskField.reset();
		jpaket_ket_diskField.setValue(null);
		jpaket_ket_disk_medisField.reset();
		jpaket_ket_disk_medisField.setValue(null);
		jpaket_stat_dokField.reset();
		jpaket_stat_dokField.setValue('Terbuka');
		jpaket_subTotalField.reset();
		jpaket_subTotalField.setValue(null);
		jpaket_subTotal_cfField.reset();
		jpaket_subTotal_cfField.setValue(null);
		jpaket_subTotalLabel.reset();
		jpaket_subTotalLabel.setValue(null);
		jpaket_totalField.reset();
		jpaket_totalField.setValue(null);
		jpaket_total_cfField.reset();
		jpaket_total_cfField.setValue(null);
		jpaket_TotalLabel.reset();
		jpaket_TotalLabel.setValue(null);
		jpaket_hutangField.reset();
		jpaket_hutangField.setValue(null);
		jpaket_hutang_cfField.reset();
		jpaket_hutang_cfField.setValue(null);
		jpaket_HutangLabel.reset();
		jpaket_HutangLabel.setValue(null);
		jpaket_jumlahField.reset();
		jpaket_jumlahField.setValue(null);
		jpaket_jumlahLabel.reset();
		jpaket_jumlahLabel.setValue(null);
		jpaket_pesanLabel.setText('');
		jpaket_cust_priorityLabel.setText('');
		tunai_jual_paket_reset_form();
		tunai2_jual_paket_reset_form();
		tunai3_jual_paket_reset_form();
		kwitansi_jual_paket_reset_form();
		kwitansi2_jual_paket_reset_form();
		kwitansi3_jual_paket_reset_form();
		card_jual_paket_reset_form();
		card2_jual_paket_reset_form();
		card3_jual_paket_reset_form();
		cek_jual_paket_reset_form();
		cek2_jual_paket_reset_form();
		cek3_jual_paket_reset_form();
		transfer_jual_paket_reset_form();
		transfer2_jual_paket_reset_form();
		transfer3_jual_paket_reset_form();
		voucher_jual_paket_reset_form();
		voucher2_jual_paket_reset_form();
		voucher3_jual_paket_reset_form();
		update_group_carabayar_jual_paket();
		update_group_carabayar2_jual_paket();
		update_group_carabayar3_jual_paket();
		jpaket_bayarField.reset();
		jpaket_bayarField.setValue(null);
		jpaket_bayar_cfField.reset();
		jpaket_bayar_cfField.setValue(null);
		jpaket_TotalBayarLabel.reset();
		jpaket_TotalBayarLabel.setValue(null);
		/* Enable if jpaket_post2db="CREATE" */
		jpaket_custField.setDisabled(false);
		jpaket_tanggalField.setDisabled(false);
		jpaket_custField.setDisabled(false);
		jpaket_custField.setDisabled(false);
		jpaket_tanggalField.setDisabled(false);
		jpaket_keteranganField.setDisabled(false);
		jpaket_ket_diskField.setDisabled(false);
		jpaket_ket_disk_medisField.setDisabled(false);
		master_cara_bayarTabPanel.setDisabled(false);
		jpaket_stat_dokField.setDisabled(false);
		
		jpaket_caraField.setDisabled(false);
		master_jual_paket_tunaiGroup.setDisabled(false);
		master_jual_paket_cardGroup.setDisabled(false);
		master_jual_paket_cekGroup.setDisabled(false);
		master_jual_paket_kwitansiGroup.setDisabled(false);
		master_jual_paket_transferGroup.setDisabled(false);
		master_jual_paket_voucherGroup.setDisabled(false);
		
		jpaket_cara2Field.setDisabled(false);
		master_jual_paket_tunai2Group.setDisabled(false);
		master_jual_paket_card2Group.setDisabled(false);
		master_jual_paket_cek2Group.setDisabled(false);
		master_jual_paket_kwitansi2Group.setDisabled(false);
		master_jual_paket_transfer2Group.setDisabled(false);
		master_jual_paket_voucher2Group.setDisabled(false);
		
		jpaket_cara3Field.setDisabled(false);
		master_jual_paket_tunai3Group.setDisabled(false);
		master_jual_paket_card3Group.setDisabled(false);
		master_jual_paket_cek3Group.setDisabled(false);
		master_jual_paket_kwitansi3Group.setDisabled(false);
		master_jual_paket_transfer3Group.setDisabled(false);
		master_jual_paket_voucher3Group.setDisabled(false);
			
		detail_jual_paketListEditorGrid.setDisabled(false);
		detail_pengguna_paketListEditorGrid.setDisabled(false);
		//jpaket_diskonField.setDisabled(false);
		jpaket_cashback_cfField.setDisabled(false);
		jpaket_cashback_cf_medisField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
		detail_jual_paketListEditorGrid.djpaket_add.enable();
        detail_jual_paketListEditorGrid.djpaket_delete.enable();
		master_jual_paket_createForm.jpaketSavePrintButton.enable();
		master_jual_paket_createForm.jpaketsavePrintButton2.enable();
		master_jual_paket_createForm.jpaket_printonly.disable();
		master_jual_paket_createForm.jpaket_printonly2.disable();
		<?php } ?>
		combo_jual_paket.setDisabled(false);
		dpaket_jumlahField.setDisabled(false);
		dpaket_kadaluarsaField.setDisabled(false);
		dpaket_hargaField.setDisabled(false);
		dpaket_subtotalField.setDisabled(false);
		dpaket_jenisdiskonField.setDisabled(false);
		dpaket_jumlahdiskonField.setDisabled(false);
		dpaket_subtotalnetField.setDisabled(false);
		combo_reveral_paket.setDisabled(false);
	}
 	/* End of Function */
	/* setValue to EDIT */
	function master_jual_paket_set_form(){
		var hutang_temp=0;
		var subtotal_field=0;
		var dpaket_jumlah_field=0;
		var total_field=0;
		var hutang_field=0;
		var diskon_field=0;
		var cashback_field=0;
		var cashback_field_medis=0;
		jpaket_idField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_id'));
		jpaket_nobuktiField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_nobukti'));
		jpaket_cust_idField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cust_id'));
		jpaket_custField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cust_edit'));
		jpaket_tanggalField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_tanggal'));
		//jpaket_diskonField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_diskon'));
		jpaket_cashback_num.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cashback'));
		jpaket_cashback_cfField.setValue(CurrencyFormatted(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cashback')));
		jpaket_cashback_medis_num.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cashback_medis'));
		jpaket_cashback_cf_medisField.setValue(CurrencyFormatted(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cashback_medis')));
		jpaket_ket_diskField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_ket_disk'));
		jpaket_ket_disk_medisField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_ket_disk_medis'));	
		jpaket_caraField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cara'));
		jpaket_cara2Field.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cara2'));
		jpaket_cara3Field.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_cara3'));
		jpaket_bayarField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_bayar'));
		jpaket_bayar_cfField.setValue(CurrencyFormatted(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_bayar')));
		jpaket_TotalBayarLabel.setValue(CurrencyFormatted(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_bayar')));
		jpaket_keteranganField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_keterangan'));
		jpaket_stat_dokField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok'));
		for(i=0;i<detail_jual_paket_DataStore.getCount();i++){
			subtotal_field+=detail_jual_paket_DataStore.getAt(i).data.dpaket_subtotal_net;
			dpaket_jumlah_field+=detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah;
		}
		/*if(jpaket_diskonField.getValue()!==""){
			diskon_field=jpaket_diskonField.getValue();
		}*/
		if(jpaket_cashback_num.getValue()!==""){
			cashback_field=jpaket_cashback_num.getValue();
		}
		if(jpaket_cashback_medis_num.getValue()!==""){
			cashback_field_medis=jpaket_cashback_medis_num.getValue();
		}
		total_field=subtotal_field-cashback_field_medis-cashback_field;
		jpaket_jumlahField.setValue(dpaket_jumlah_field);
		jpaket_jumlahLabel.setValue(dpaket_jumlah_field);
		jpaket_subTotalField.setValue(subtotal_field);
		jpaket_subTotal_cfField.setValue(CurrencyFormatted(subtotal_field));
		jpaket_subTotalLabel.setValue(CurrencyFormatted(subtotal_field));
		
		jpaket_totalField.setValue(total_field);
		jpaket_total_cfField.setValue(CurrencyFormatted(total_field));
		jpaket_TotalLabel.setValue(CurrencyFormatted(total_field));
		hutang_temp=total_field-jpaket_bayarField.getValue();
		jpaket_hutangField.setValue(hutang_temp);
		jpaket_hutang_cfField.setValue(CurrencyFormatted(hutang_temp));
		jpaket_HutangLabel.setValue(CurrencyFormatted(hutang_temp));
	
		load_membership();
		update_group_carabayar_jual_paket();
		update_group_carabayar2_jual_paket();
		update_group_carabayar3_jual_paket();
		switch(jpaket_caraField.getValue()){
			case 'kwitansi':
				kwitansi_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_paket_DataStore.getCount()){
								jpaket_kwitansi_record=kwitansi_jual_paket_DataStore.getAt(0).data;
								jpaket_kwitansi_idField.setValue(jpaket_kwitansi_record.kwitansi_id);
								jpaket_kwitansi_noField.setValue(jpaket_kwitansi_record.kwitansi_no);
								jpaket_kwitansi_namaField.setValue(jpaket_kwitansi_record.cust_nama);
								jpaket_kwitansi_nilaiField.setValue(jpaket_kwitansi_record.jkwitansi_nilai);
								jpaket_kwitansi_sisaField.setValue(jpaket_kwitansi_record.kwitansi_sisa);
								jpaket_kwitansi_nilai_cfField.setValue(CurrencyFormatted(jpaket_kwitansi_record.jkwitansi_nilai));
								jpaket_jual_kwitansi_idField1.setValue(jpaket_kwitansi_record.jkwitansi_id);
								
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							if(card_jual_paket_DataStore.getCount()){
								jpaket_card_record=card_jual_paket_DataStore.getAt(0).data;
								jpaket_card_namaField.setValue(jpaket_card_record.jcard_nama);
								jpaket_card_edcField.setValue(jpaket_card_record.jcard_edc);
								jpaket_card_noField.setValue(jpaket_card_record.jcard_no);
								jpaket_card_nilaiField.setValue(jpaket_card_record.jcard_nilai);
								jpaket_card_nilai_cfField.setValue(CurrencyFormatted(jpaket_card_record.jcard_nilai));
							}
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_paket_DataStore.getCount()){
									jpaket_cek_record=cek_jual_paket_DataStore.getAt(0).data;
									jpaket_cek_namaField.setValue(jpaket_cek_record.jcek_nama);
									jpaket_cek_noField.setValue(jpaket_cek_record.jcek_no);
									jpaket_cek_validField.setValue(jpaket_cek_record.jcek_valid);
									jpaket_cek_bankField.setValue(jpaket_cek_record.jcek_bank);
									jpaket_cek_nilaiField.setValue(jpaket_cek_record.jcek_nilai);
									jpaket_cek_nilai_cfField.setValue(CurrencyFormatted(jpaket_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(transfer_jual_paket_DataStore.getCount()){
										jpaket_transfer_record=transfer_jual_paket_DataStore.getAt(0);
										jpaket_transfer_bankField.setValue(jpaket_transfer_record.data.jtransfer_bank);
										jpaket_transfer_namaField.setValue(jpaket_transfer_record.data.jtransfer_nama);
										jpaket_transfer_nilaiField.setValue(jpaket_transfer_record.data.jtransfer_nilai);
										jpaket_transfer_nilai_cfField.setValue(CurrencyFormatted(jpaket_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_paket_DataStore.getCount()){
										jpaket_tunai_record=tunai_jual_paket_DataStore.getAt(0);
										jpaket_tunai_nilaiField.setValue(jpaket_tunai_record.data.jtunai_nilai);
										jpaket_tunai_nilai_cfField.setValue(CurrencyFormatted(jpaket_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_paket_DataStore.getCount()){
										jpaket_voucher_record=voucher_jual_paket_DataStore.getAt(0);
										jpaket_voucher_noField.setValue(jpaket_voucher_record.data.tvoucher_novoucher);
										jpaket_voucher_cashbackField.setValue(jpaket_voucher_record.data.tvoucher_nilai);
										jpaket_voucher_cashback_cfField.setValue(CurrencyFormatted(jpaket_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
		switch(jpaket_cara2Field.getValue()){
			case 'kwitansi':
				kwitansi_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_paket_DataStore.getCount()){
								jpaket_kwitansi_record=kwitansi_jual_paket_DataStore.getAt(0).data;
								jpaket_kwitansi_id2Field.setValue(jpaket_kwitansi_record.kwitansi_id);
								jpaket_kwitansi_no2Field.setValue(jpaket_kwitansi_record.kwitansi_no);
								jpaket_kwitansi_nama2Field.setValue(jpaket_kwitansi_record.cust_nama);
								jpaket_kwitansi_nilai2Field.setValue(jpaket_kwitansi_record.jkwitansi_nilai);
								jpaket_kwitansi_sisa2Field.setValue(jpaket_kwitansi_record.kwitansi_sisa);
								jpaket_kwitansi_nilai2_cfField.setValue(CurrencyFormatted(jpaket_kwitansi_record.jkwitansi_nilai));
								jpaket_jual_kwitansi_idField2.setValue(jpaket_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_jual_paket_DataStore.getCount()){
								 jpaket_card_record=card_jual_paket_DataStore.getAt(0).data;
								 jpaket_card_nama2Field.setValue(jpaket_card_record.jcard_nama);
								 jpaket_card_edc2Field.setValue(jpaket_card_record.jcard_edc);
								 jpaket_card_no2Field.setValue(jpaket_card_record.jcard_no);
								 jpaket_card_nilai2Field.setValue(jpaket_card_record.jcard_nilai);
								 jpaket_card_nilai2_cfField.setValue(CurrencyFormatted(jpaket_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_paket_DataStore.getCount()){
									jpaket_cek_record=cek_jual_paket_DataStore.getAt(0).data;
									jpaket_cek_nama2Field.setValue(jpaket_cek_record.jcek_nama);
									jpaket_cek_no2Field.setValue(jpaket_cek_record.jcek_no);
									jpaket_cek_valid2Field.setValue(jpaket_cek_record.jcek_valid);
									jpaket_cek_bank2Field.setValue(jpaket_cek_record.jcek_bank);
									jpaket_cek_nilai2Field.setValue(jpaket_cek_record.jcek_nilai);
									jpaket_cek_nilai2_cfField.setValue(CurrencyFormatted(jpaket_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								jpaket_transfer_record=transfer_jual_paket_DataStore.getAt(0);
									if(transfer_jual_paket_DataStore.getCount()){
										jpaket_transfer_record=transfer_jual_paket_DataStore.getAt(0);
										jpaket_transfer_bank2Field.setValue(jpaket_transfer_record.data.jtransfer_bank);
										jpaket_transfer_nama2Field.setValue(jpaket_transfer_record.data.jtransfer_nama);
										jpaket_transfer_nilai2Field.setValue(jpaket_transfer_record.data.jtransfer_nilai);
										jpaket_transfer_nilai2_cfField.setValue(CurrencyFormatted(jpaket_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_paket_DataStore.getCount()){
										jpaket_tunai_record=tunai_jual_paket_DataStore.getAt(0);
										jpaket_tunai_nilai2Field.setValue(jpaket_tunai_record.data.jtunai_nilai);
										jpaket_tunai_nilai2_cfField.setValue(CurrencyFormatted(jpaket_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_paket_DataStore.getCount()){
										jpaket_voucher_record=voucher_jual_paket_DataStore.getAt(0);
										jpaket_voucher_no2Field.setValue(jpaket_voucher_record.data.tvoucher_novoucher);
										jpaket_voucher_cashback2Field.setValue(jpaket_voucher_record.data.tvoucher_nilai);
										jpaket_voucher_cashback2_cfField.setValue(CurrencyFormatted(jpaket_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
		switch(jpaket_cara3Field.getValue()){
			case 'kwitansi':
				kwitansi_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_paket_DataStore.getCount()){
								jpaket_kwitansi_record=kwitansi_jual_paket_DataStore.getAt(0).data;
								jpaket_kwitansi_id3Field.setValue(jpaket_kwitansi_record.kwitansi_id);
								jpaket_kwitansi_no3Field.setValue(jpaket_kwitansi_record.kwitansi_no);
								jpaket_kwitansi_nama3Field.setValue(jpaket_kwitansi_record.cust_nama);
								jpaket_kwitansi_nilai3Field.setValue(jpaket_kwitansi_record.jkwitansi_nilai);
								jpaket_kwitansi_sisa3Field.setValue(jpaket_kwitansi_record.kwitansi_sisa);
								jpaket_kwitansi_nilai3_cfField.setValue(CurrencyFormatted(jpaket_kwitansi_record.jkwitansi_nilai));
								jpaket_jual_kwitansi_idField3.setValue(jpaket_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_jual_paket_DataStore.getCount()){
								 jpaket_card_record=card_jual_paket_DataStore.getAt(0).data;
								 jpaket_card_nama3Field.setValue(jpaket_card_record.jcard_nama);
								 jpaket_card_edc3Field.setValue(jpaket_card_record.jcard_edc);
								 jpaket_card_no3Field.setValue(jpaket_card_record.jcard_no);
								 jpaket_card_nilai3Field.setValue(jpaket_card_record.jcard_nilai);
								 jpaket_card_nilai3_cfField.setValue(CurrencyFormatted(jpaket_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_paket_DataStore.load({
					params : {
						no_faktur: jpaket_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_paket_DataStore.getCount()){
									jpaket_cek_record=cek_jual_paket_DataStore.getAt(0).data;
									jpaket_cek_nama3Field.setValue(jpaket_cek_record.jcek_nama);
									jpaket_cek_no3Field.setValue(jpaket_cek_record.jcek_no);
									jpaket_cek_valid3Field.setValue(jpaket_cek_record.jcek_valid);
									jpaket_cek_bank3Field.setValue(jpaket_cek_record.jcek_bank);
									jpaket_cek_nilai3Field.setValue(jpaket_cek_record.jcek_nilai);
									jpaket_cek_nilai3_cfField.setValue(CurrencyFormatted(jpaket_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								jpaket_transfer_record=transfer_jual_paket_DataStore.getAt(0);
									if(transfer_jual_paket_DataStore.getCount()){
										jpaket_transfer_record=transfer_jual_paket_DataStore.getAt(0);
										jpaket_transfer_bank3Field.setValue(jpaket_transfer_record.data.jtransfer_bank);
										jpaket_transfer_nama3Field.setValue(jpaket_transfer_record.data.jtransfer_nama);
										jpaket_transfer_nilai3Field.setValue(jpaket_transfer_record.data.jtransfer_nilai);
										jpaket_transfer_nilai3_cfField.setValue(CurrencyFormatted(jpaket_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_paket_DataStore.getCount()){
										jpaket_tunai_record=tunai_jual_paket_DataStore.getAt(0);
										jpaket_tunai_nilai3Field.setValue(jpaket_tunai_record.data.jtunai_nilai);
										jpaket_tunai_nilai3_cfField.setValue(CurrencyFormatted(jpaket_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_paket_DataStore.load({
						params : {
							no_faktur: jpaket_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_paket_DataStore.getCount()){
										jpaket_voucher_record=voucher_jual_paket_DataStore.getAt(0);
										jpaket_voucher_no3Field.setValue(jpaket_voucher_record.data.tvoucher_novoucher);
										jpaket_voucher_cashback3Field.setValue(jpaket_voucher_record.data.tvoucher_nilai);
										jpaket_voucher_cashback3_cfField.setValue(CurrencyFormatted(jpaket_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
		jpaket_stat_dokField.on("select",function(){
		var status_awal = master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok');
		if(status_awal =='Terbuka' && jpaket_stat_dokField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jpaket_stat_dokField.setValue('Terbuka');
		}
		else if(status_awal =='Tertutup' && jpaket_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jpaket_stat_dokField.setValue('Tertutup');
		}
		else if(status_awal =='Batal' && jpaket_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jpaket_stat_dokField.setValue('Tertutup');
		}
		else if(jpaket_stat_dokField.getValue()=='Batal')
		{
				Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', jpaket_status_batal);
		}
        else if(status_awal =='Tertutup' && jpaket_stat_dokField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			master_jual_paket_createForm.jpaketSavePrintButton.enable();
			master_jual_paket_createForm.jpaketsavePrintButton2.enable();
			master_jual_paket_createForm.jpaket_printonly.disable();
			master_jual_paket_createForm.jpaket_printonly2.disable();
			<?php } ?>
        }
		});	
	}
	/* End setValue to EDIT*/
	function jpaket_status_batal(btn){
	if(btn=='yes')
	{
		jpaket_stat_dokField.setValue('Batal');
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
        master_jual_paket_createForm.jpaketSavePrintButton.disable();
		master_jual_paket_createForm.jpaketsavePrintButton2.disable();
		master_jual_paket_createForm.jpaket_printonly.enable();
		master_jual_paket_createForm.jpaket_printonly2.enable();
		<?php } ?>
	}  
	else
		jpaket_stat_dokField.setValue(master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok'));
	}
	/*Function utk mengnon-aktifkan beberapa field ketika status dok diganti Tertutup*/
	function master_jual_paket_set_updating(){
		if(jpaket_post2db=="UPDATE" && master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok')=="Terbuka"){
			jpaket_custField.setDisabled(false);
			jpaket_tanggalField.setDisabled(false);
			jpaket_keteranganField.setDisabled(false);
			jpaket_ket_diskField.setDisabled(false);
			jpaket_ket_disk_medisField.setDisabled(false);
			
			jpaket_caraField.setDisabled(false);
			master_jual_paket_tunaiGroup.setDisabled(false);
			master_jual_paket_cardGroup.setDisabled(false);
			master_jual_paket_cekGroup.setDisabled(false);
			master_jual_paket_kwitansiGroup.setDisabled(false);
			master_jual_paket_transferGroup.setDisabled(false);
			master_jual_paket_voucherGroup.setDisabled(false);
			
			jpaket_cara2Field.setDisabled(false);
			master_jual_paket_tunai2Group.setDisabled(false);
			master_jual_paket_card2Group.setDisabled(false);
			master_jual_paket_cek2Group.setDisabled(false);
			master_jual_paket_kwitansi2Group.setDisabled(false);
			master_jual_paket_transfer2Group.setDisabled(false);
			master_jual_paket_voucher2Group.setDisabled(false);
			
			jpaket_cara3Field.setDisabled(false);
			master_jual_paket_tunai3Group.setDisabled(false);
			master_jual_paket_card3Group.setDisabled(false);
			master_jual_paket_cek3Group.setDisabled(false);
			master_jual_paket_kwitansi3Group.setDisabled(false);
			master_jual_paket_transfer3Group.setDisabled(false);
			master_jual_paket_voucher3Group.setDisabled(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			detail_jual_paketListEditorGrid.djpaket_add.enable();
			detail_jual_paketListEditorGrid.djpaket_delete.enable();
			<?php } ?>
			master_jual_paket_createForm.jpaketSavePrintButton.enable();
			master_jual_paket_createForm.jpaketsavePrintButton2.enable();
			master_jual_paket_createForm.jpaket_printonly.disable();
			master_jual_paket_createForm.jpaket_printonly2.disable();
			combo_jual_paket.setDisabled(false);
			dpaket_jumlahField.setDisabled(false);
			dpaket_kadaluarsaField.setDisabled(false);
			dpaket_hargaField.setDisabled(true);
			dpaket_subtotalField.setDisabled(false);
			dpaket_jenisdiskonField.setDisabled(false);
			dpaket_jumlahdiskonField.setDisabled(false);
			dpaket_subtotalnetField.setDisabled(false);
			combo_reveral_paket.setDisabled(false);
			detail_pengguna_paketListEditorGrid.setDisabled(false);
			//jpaket_diskonField.setDisabled(false);
			jpaket_cashback_cfField.setDisabled(false);
			jpaket_cashback_cf_medisField.setDisabled(false);
		}
		if(jpaket_post2db=="UPDATE" && master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok')=="Tertutup"){
			jpaket_custField.setDisabled(true);
			jpaket_tanggalField.setDisabled(true);
			jpaket_keteranganField.setDisabled(true);
			jpaket_ket_diskField.setDisabled(true);
			jpaket_ket_disk_medisField.setDisabled(true);
			
			jpaket_caraField.setDisabled(true);
			master_jual_paket_tunaiGroup.setDisabled(true);
			master_jual_paket_cardGroup.setDisabled(true);
			master_jual_paket_cekGroup.setDisabled(true);
			master_jual_paket_kwitansiGroup.setDisabled(true);
			master_jual_paket_transferGroup.setDisabled(true);
			master_jual_paket_voucherGroup.setDisabled(true);
			
			jpaket_cara2Field.setDisabled(true);
			master_jual_paket_tunai2Group.setDisabled(true);
			master_jual_paket_card2Group.setDisabled(true);
			master_jual_paket_cek2Group.setDisabled(true);
			master_jual_paket_kwitansi2Group.setDisabled(true);
			master_jual_paket_transfer2Group.setDisabled(true);
			master_jual_paket_voucher2Group.setDisabled(true);
			
			jpaket_cara3Field.setDisabled(true);
			master_jual_paket_tunai3Group.setDisabled(true);
			master_jual_paket_card3Group.setDisabled(true);
			master_jual_paket_cek3Group.setDisabled(true);
			master_jual_paket_kwitansi3Group.setDisabled(true);
			master_jual_paket_transfer3Group.setDisabled(true);
			master_jual_paket_voucher3Group.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			detail_jual_paketListEditorGrid.djpaket_add.disable();
			detail_jual_paketListEditorGrid.djpaket_delete.disable();
			<?php } ?>
			master_jual_paket_createForm.jpaketSavePrintButton.disable();
			master_jual_paket_createForm.jpaketsavePrintButton2.disable();
			master_jual_paket_createForm.jpaket_printonly.enable();
			master_jual_paket_createForm.jpaket_printonly2.enable();
			combo_jual_paket.setDisabled(true);
			dpaket_jumlahField.setDisabled(true);
			dpaket_kadaluarsaField.setDisabled(true);
			dpaket_hargaField.setDisabled(true);
			dpaket_subtotalField.setDisabled(true);
			dpaket_jenisdiskonField.setDisabled(true);
			dpaket_jumlahdiskonField.setDisabled(true);
			dpaket_subtotalnetField.setDisabled(true);
			combo_reveral_paket.setDisabled(true);
			//jpaket_diskonField.setDisabled(true);
			jpaket_cashback_cfField.setDisabled(true);
			jpaket_cashback_cf_medisField.setDisabled(true);
		}
		if(jpaket_post2db=="UPDATE" && master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_stat_dok')=="Batal"){
			jpaket_custField.setDisabled(true);
			jpaket_tanggalField.setDisabled(true);
			jpaket_keteranganField.setDisabled(true);
			jpaket_ket_diskField.setDisabled(true);
			jpaket_ket_disk_medisField.setDisabled(true);
			
			jpaket_caraField.setDisabled(true);
			master_jual_paket_tunaiGroup.setDisabled(true);
			master_jual_paket_cardGroup.setDisabled(true);
			master_jual_paket_cekGroup.setDisabled(true);
			master_jual_paket_kwitansiGroup.setDisabled(true);
			master_jual_paket_transferGroup.setDisabled(true);
			master_jual_paket_voucherGroup.setDisabled(true);
			
			jpaket_cara2Field.setDisabled(true);
			master_jual_paket_tunai2Group.setDisabled(true);
			master_jual_paket_card2Group.setDisabled(true);
			master_jual_paket_cek2Group.setDisabled(true);
			master_jual_paket_kwitansi2Group.setDisabled(true);
			master_jual_paket_transfer2Group.setDisabled(true);
			master_jual_paket_voucher2Group.setDisabled(true);
			
			jpaket_cara3Field.setDisabled(true);
			master_jual_paket_tunai3Group.setDisabled(true);
			master_jual_paket_card3Group.setDisabled(true);
			master_jual_paket_cek3Group.setDisabled(true);
			master_jual_paket_kwitansi3Group.setDisabled(true);
			master_jual_paket_transfer3Group.setDisabled(true);
			master_jual_paket_voucher3Group.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			detail_jual_paketListEditorGrid.djpaket_add.disable();
			detail_jual_paketListEditorGrid.djpaket_delete.disable();
			<?php } ?>
			combo_jual_paket.setDisabled(true);
			dpaket_jumlahField.setDisabled(true);
			dpaket_kadaluarsaField.setDisabled(true);
			dpaket_hargaField.setDisabled(true);
			dpaket_subtotalField.setDisabled(true);
			dpaket_jenisdiskonField.setDisabled(true);
			dpaket_jumlahdiskonField.setDisabled(true);
			dpaket_subtotalnetField.setDisabled(true);
			combo_reveral_paket.setDisabled(true);
			detail_pengguna_paketListEditorGrid.setDisabled(true);
			//jpaket_diskonField.setDisabled(true);
			jpaket_cashback_cfField.setDisabled(true);
			jpaket_cashback_cf_medisField.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			master_jual_paket_createForm.jpaketSavePrintButton.disable();
			master_jual_paket_createForm.jpaketsavePrintButton2.disable();
			master_jual_paket_createForm.jpaket_printonly.enable();
			master_jual_paket_createForm.jpaket_printonly2.enable();
			<?php } ?>
		}
	}
    function load_membership(){
		var cust_id=0;
		if(jpaket_post2db=="CREATE"){
			cust_id=jpaket_custField.getValue();
		}else if(jpaket_post2db=="UPDATE"){
			cust_id=jpaket_cust_idField.getValue();
		}
		if(jpaket_custField.getValue()!=''){
			memberDataStore.load({
					params : { member_cust: cust_id },
					callback: function(opts, success, response)  {
						 if (success) {
							if(memberDataStore.getCount()){
								jpaket_member_record=memberDataStore.getAt(0).data;
								jpaket_cust_nomemberField.setValue(jpaket_member_record.member_no);
								jpaket_valid_memberField.setValue(jpaket_member_record.member_valid);
								jpaket_cust_ultahField.setValue(jpaket_member_record.cust_tgllahir);
								jpaket_cust_priorityField.setValue(jpaket_member_record.cust_priority_star);
									if (jpaket_cust_priorityField.getValue()=='*') {
										jpaket_cust_priorityLabel.setText("*");
									}
									else {
										jpaket_cust_priorityLabel.setText("");
									}	
							}
						}
					}
			}); 
		}
	}
	
	/* Function for Displaying  create Window Form */
	function display_form_window(){
		master_jual_paket_reset_form();
		jpaket_caraField.setValue("card");
		master_jual_paket_cardGroup.setVisible(true);
		master_cara_bayarTabPanel.setActiveTab(0);
		//jpaket_diskonField.setValue(0);
		//jpaket_cashbackField.setValue(0);
		jpaket_pesanLabel.setText('');
		jpaket_lunasLabel.setText('');
		jpaket_cust_priorityLabel.setText('');
		//master_jual_paket_createForm.show();
		//master_jual_paket_createForm.render();
		master_jual_paket_createWindow.hide();
		//master_jual_paket_createForm.activate;
	}
  	/* End of Function */
	
	/* Function for Check if the form is valid */
	function is_master_jual_paket_form_valid(){
		return (true);
	}
  	/* End of Function */
	/* Function for Update Confirm */
	function master_jual_paket_confirm_update(){
		/* only one record is selected here */
		if(master_jual_paketListEditorGrid.selModel.getCount() == 1) {
			cbo_cust_pengguna_paket_DataStore.load({
				params:{
					jpaket_id:master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_id'),
					query:''
				}
			});
			master_cara_bayarTabPanel.setActiveTab(0);
			jpaket_post2db='UPDATE';
			cbo_dpaket_paketDataStore.load({
				params:{
					query:master_jual_paketListEditorGrid.getSelectionModel().getSelected().get('jpaket_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
					if(success){
						detail_jual_paket_DataStore.load({
							params : {master_id : eval(get_pk_id()), start:0, limit:jpaket_pageS},
							callback: function(opts, success, response){
								if(success){
									master_jual_paket_set_form();
									master_jual_paket_set_updating();
								}
							}
						});
					}
				}
			});
			detail_pengguna_paket_DataStore.load({params:{master_id : eval(get_pk_id())}});
			msg='updated';
			master_jual_paket_createWindow.hide();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diedit?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
	/* Function for Retrieve DataStore */
	master_jual_paket_DataStore = new Ext.data.Store({
		id: 'master_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jpaket_id'
		},[
			{name: 'jpaket_id', type: 'int', mapping: 'jpaket_id'}, 
			{name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'}, 
			{name: 'jpaket_nobukti_pajak', type: 'string', mapping: 'jpaket_nobukti_pajak'},
			{name: 'jpaket_cust_edit', type: 'string', mapping: 'cust_nama_edit'},
			{name: 'jpaket_cust', type: 'string', mapping: 'cust_nama'},			
			{name: 'jpaket_cust_id', type: 'int', mapping: 'jpaket_cust'},
			{name: 'jpaket_cust_no', type: 'string', mapping: 'cust_no'},		//additional by hendri
			{name: 'jpaket_cust_member', type: 'string', mapping: 'cust_member'},		//additional by hendri
			{name: 'jpaket_cust_member_no', type: 'string', mapping: 'member_no'},
			{name: 'cust_priority_star', type: 'string', mapping: 'cust_priority_star'}, 
			{name: 'jpaket_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'jpaket_tanggal'}, 
			{name: 'jpaket_diskon', type: 'int', mapping: 'jpaket_diskon'}, 
			{name: 'jpaket_cashback', type: 'float', mapping: 'jpaket_cashback'},
			{name: 'jpaket_cashback_medis', type: 'float', mapping: 'jpaket_cashback_medis'},
			{name: 'jpaket_cara', type: 'string', mapping: 'jpaket_cara'}, 
			{name: 'jpaket_cara2', type: 'string', mapping: 'jpaket_cara2'}, 
			{name: 'jpaket_cara3', type: 'string', mapping: 'jpaket_cara3'}, 
			{name: 'jpaket_total', type: 'float', mapping: 'jpaket_totalbiaya'}, 	//additional by hendri
			{name: 'jpaket_bayar', type: 'float', mapping: 'jpaket_bayar'}, 
			{name: 'jpaket_keterangan', type: 'string', mapping: 'jpaket_keterangan'},
			{name: 'jpaket_ket_disk', type: 'string', mapping: 'jpaket_ket_disk'},	//additional by isaac
			{name: 'jpaket_ket_disk_medis', type: 'string', mapping: 'jpaket_ket_disk_medis'},
			{name: 'jpaket_stat_dok', type: 'string', mapping: 'jpaket_stat_dok'}, 			
			{name: 'jpaket_creator', type: 'string', mapping: 'jpaket_creator'}, 
			{name: 'jpaket_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jpaket_date_create'}, 
			{name: 'jpaket_update', type: 'string', mapping: 'jpaket_update'}, 
			{name: 'jpaket_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jpaket_date_update'}, 
			{name: 'jpaket_revised', type: 'int', mapping: 'jpaket_revised'} 
		]),
		sortInfo:{field: 'jpaket_id', direction: "DESC"}
	});
	/* End of Function */
	cbo_voucher_jual_paketDataStore = new Ext.data.Store({
		id: 'cbo_voucher_jual_paketDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_voucher_list', 
			method: 'POST'
		}),baseParams: {start:0, limit: 10},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'voucher_nomor'
		},[
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
	cbo_cust_jual_paket_DataStore = new Ext.data.Store({
		id: 'cbo_cust_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
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
	/* Function for Retrieve Combo Kwitansi DataStore */
	cbo_kwitansi_jual_paket_DataStore = new Ext.data.Store({
		id: 'cbo_kwitansi_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_kwitansi_list', 
			method: 'POST'
		}),
		baseParams: {start:0, limit:jpaket_pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kwitansi_id'
		},[
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
	kwitansi_jual_paket_DataStore = new Ext.data.Store({
		id: 'kwitansi_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_kwitansi_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jkwitansi_id'
		},[
			{name: 'jkwitansi_id', type: 'int', mapping: 'jkwitansi_id'},
			{name: 'kwitansi_no', type: 'string', mapping: 'kwitansi_no'},
			{name: 'jkwitansi_nilai', type: 'float', mapping: 'jkwitansi_nilai'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'kwitansi_sisa', type: 'float', mapping: 'kwitansi_sisa'},
			{name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'}
		]),
		sortInfo:{field: 'jkwitansi_id', direction: "DESC"}
	});
	/* End of Function */
	/* Function for Retrieve Kwitansi DataStore */
	card_jual_paket_DataStore = new Ext.data.Store({
		id: 'card_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_card_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcard_id'
		},[
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
	cek_jual_paket_DataStore = new Ext.data.Store({
		id: 'cek_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_cek_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcek_id'
		},[
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
	transfer_jual_paket_DataStore = new Ext.data.Store({
		id: 'transfer_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_transfer_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtransfer_id'
		},[
			{name: 'jtransfer_id', type: 'int', mapping: 'jtransfer_id'}, 
			{name: 'jtransfer_bank', type: 'int', mapping: 'jtransfer_bank'},
			{name: 'jtransfer_nama', type: 'string', mapping: 'jtransfer_nama'},
			{name: 'jtransfer_nilai', type: 'float', mapping: 'jtransfer_nilai'}
		]),
		sortInfo:{field: 'jtransfer_id', direction: "DESC"}
	});
	/* End of Function */
	/* Function for Retrieve Tunai DataStore */
	tunai_jual_paket_DataStore = new Ext.data.Store({
		id: 'tunai_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_tunai_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtunai_id'
		},[
			{name: 'jtunai_id', type: 'int', mapping: 'jtunai_id'}, 
			{name: 'jtunai_nilai', type: 'float', mapping: 'jtunai_nilai'}
		]),
		sortInfo:{field: 'jtunai_id', direction: "DESC"}
	});
	/* End of Function */
	/* GET Bank-List.Store */
	jpaket_bankDataStore = new Ext.data.Store({
		id:'jpaket_bankDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_bank_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
			{name: 'jpaket_bank_value', type: 'int', mapping: 'mbank_id'}, 
			{name: 'jpaket_bank_display', type: 'string', mapping: 'mbank_nama'}
		]),
		sortInfo:{field: 'jpaket_bank_display', direction: "DESC"}
		});
	/* END GET Bank-List.Store */
	/* GET Voucher-Terima-List.Store */
	voucher_jual_paket_DataStore = new Ext.data.Store({
		id: 'voucher_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_voucher_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'tvoucher_id'
		},[
			{name: 'tvoucher_id', type: 'int', mapping: 'tvoucher_id'}, 
			{name: 'tvoucher_novoucher', type: 'string', mapping: 'tvoucher_novoucher'}, 
			{name: 'tvoucher_nilai', type: 'float', mapping: 'tvoucher_nilai'}
		]),
		sortInfo:{field: 'tvoucher_id', direction: "DESC"}
	});
	/* End of GET Voucher-Terima-List.Store */
	cbo_cust_pengguna_paket_DataStore = new Ext.data.Store({
		id: 'cbo_cust_pengguna_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_customer_pengguna_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
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
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'},
			{name: 'cust_display', type: 'string', mapping: 'cust_display'},
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
  	/* Function for Identify of Window Column Model */
	master_jual_paket_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'jpaket_id',
			width: 5,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'jpaket_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'jpaket_nobukti',
			width: 80,	//150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
		}, 
		{
			header: '<div align="center">' + 'Faktur Pajak' + '</div>',
			dataIndex: 'jpaket_nobukti_pajak',
			width: 100,	//82,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'jpaket_cust_no',
			width: 80,	//185,
			sortable: true,
			readOnly: true
		}, 
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
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'jpaket_cust',
			width: 200,	//185,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'jpaket_cust_member_no',
			width: 90,	//185,
			sortable: true,
			readOnly: true,
			renderer: function(value, cell, record){
				return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
			}
		}, 
		{
			header: '<div align="center">' + 'Total (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jpaket_total',
			width: 100,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Total Bayar (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jpaket_bayar',
			width: 100,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'jpaket_keterangan',
			width: 130,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		{
			header: '<div align="center">' + 'No Voucher' + '</div>',
			dataIndex: 'jpaket_ket_disk',
			width: 130,
			hidden: true,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		{
			header: '<div align="center">' + 'No Voucher Medis' + '</div>',
			dataIndex: 'jpaket_ket_disk_medis',
			width: 130,
			hidden: true,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		},
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'jpaket_stat_dok',
			width: 80,	//150,
			sortable: true
		}, 
		{
			header: 'Creator',
			dataIndex: 'jpaket_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Create',
			dataIndex: 'jpaket_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Update',
			dataIndex: 'jpaket_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Update',
			dataIndex: 'jpaket_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'jpaket_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	master_jual_paket_ColumnModel.defaultSortable= true;
	/* End of Function */
	/* Declare DataStore and  show datagrid list */
	master_jual_paketListEditorGrid =  new Ext.grid.GridPanel({
		id: 'master_jual_paketListEditorGrid',
		el: 'fp_master_jual_paket',
		title: 'Daftar Penjualan Paket',
		autoHeight: true,
		store: master_jual_paket_DataStore, // DataStore
		cm: master_jual_paket_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		trackMouseOver: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: jpaket_pageS,
			store: master_jual_paket_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_jual_paket_confirm_update   // Confirm before updating
		}, '-', {
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_jual_paket_DataStore,
			params: {task: 'LIST',start: 0, limit: jpaket_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_jual_paket_DataStore.baseParams={task:'LIST',start: 0, limit: jpaket_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Faktur<br>- Nama Customer<br>- No Cust'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_jual_paket_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_jual_paket_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_jual_paket_print  
		}
		]
	});
	/* End of DataStore */
	/* Create Context Menu */
	master_jual_paket_ContextMenu = new Ext.menu.Menu({
		id: 'master_jual_paket_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_jual_paket_editContextMenu 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_jual_paket_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_jual_paket_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	/* Event while selected row via context menu */
	function onmaster_jual_paket_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_jual_paket_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_jual_paket_SelectedRow=rowIndex;
		master_jual_paket_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	/* function for editing row via context menu */
	function master_jual_paket_editContextMenu(){
		master_jual_paket_confirm_update();
  	}
	/* End of Function */
	master_jual_paketListEditorGrid.addListener('rowcontextmenu', onmaster_jual_paket_ListEditGridContextMenu);
	//master_jual_paket_DataStore.load({params: {start: 0, limit: jpaket_pageS}});	// load DataStore
	// Custom rendering Template
    var customer_jual_paket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br /></span>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br/>',
            'Alamat: {cust_alamat}<br/>',
			'Telp Rumah: {cust_telprumah}<br>',			
        '</div></tpl>'
    );
	var voucher_jual_paket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{voucher_nomor}</b>| {voucher_nama}<br/></span>',
			'Jenis: {voucher_jenis}&nbsp;&nbsp;&nbsp;[Nilai: {voucher_cashback}]',
		'</div></tpl>'
    );
	var kwitansi_jual_paket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{ckwitansi_no}</b> <br/>',
			'a/n {ckwitansi_cust_nama} [ {ckwitansi_cust_no} ]<br/>',
			'{ckwitansi_cust_alamat}, <br>Sisa: <b>Rp. {total_sisa}</b>,<br>Ket : {kwitansi_keterangan} </span>',
		'</div></tpl>'
    );
	var paket_jual_paket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dpaket_paket_kode} | <b>{dpaket_paket_display}</b></span>',
		'</div></tpl>'
    );
	
	/*Untuk ngecek value, apakah nilai nya * , jika iya, maka akan menampilkan / mengaktifkan label Priortiy */
	jpaket_cust_priorityField= new Ext.form.TextField({
		id: 'jpaket_cust_priorityField',
		readOnly: true
	});
	
	// Label ini jika aktif, akan menampilkan bintang (*) besar , dimana tujuan label ini adlh menunjukkan bahwa Customer tersebut adalah Customer High Priority
	jpaket_cust_priorityLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '35px',
			//color: '#006600',
			color: '#CC0000'
		}
	});
	
	/* Identify  jpaket_id Field */
	jpaket_idField= new Ext.form.NumberField({
		id: 'jpaket_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jpaket_nobukti Field */
	jpaket_nobuktiField= new Ext.form.TextField({
		id: 'jpaket_nobuktiField',
		fieldLabel: 'No Faktur',
		readOnly:true,	//sementara, utk input manual
		emptyText : '(Auto)',
		disabled : true,
		maxLength: 30
	});
	/* Identify  jpaket_cust Field */
	jpaket_custField= new Ext.form.ComboBox({
		id: 'jpaket_custField',
		fieldLabel: 'Customer',
		store: cbo_cust_jual_paket_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_paket_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	jpaket_cust_idField= new Ext.form.NumberField();
	
	jpaket_cust_nomemberLabel=new Ext.form.Label({ html: 'No Member: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	jpaket_cust_nomemberField= new Ext.form.TextField({
		id: 'jpaket_cust_nomemberField',
		//fieldLabel: 'No Member',
		emptyText : '(Auto)',
		disabled : true,
		readOnly: true
	});
	
	jpaket_valid_memberLabel=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Member Valid: &nbsp;&nbsp;'});
	
	jpaket_valid_memberField= new Ext.form.DateField({
		id: 'jpaket_valid_memberField',
		//fieldLabel: 'Valid Member',
		emptyText : '(Auto)',
		disabled : true,
		readOnly: true,
		format : 'd-m-Y'
	});
	
	jpaket_cust_ultahLabel=new Ext.form.Label({ html: 'Tanggal Ultah : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	jpaket_cust_ultahField= new Ext.form.DateField({
		id: 'jpaket_cust_ultahField',
		fieldLabel: 'Tanggal Ultah',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y'
	});
	
	/* Identify  jpaket_tanggal Field */
	jpaket_tanggalField= new Ext.form.DateField({
		id: 'jpaket_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  jpaket_diskon Field */
	/*jpaket_diskonField= new Ext.form.NumberField({
		id: 'jpaket_diskonField',
		fieldLabel: 'Disk Tambahan (%)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		width: 120,
		maxLength: 3,
		maskRe: /([0-9]+)$/
	});
	jpaket_cashbackField= new Ext.form.NumberField({
		id: 'jpaket_cashbackField',
		fieldLabel: 'Diskon (Rp)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		readOnly : true,
		allowDecimals: false,
		width: 100,
		maskRe: /([0-9]+)$/
	});
	*/
		///////////SPLIT VOUCHER//////////
	/*untuk nomor voucher nonmedis*/
	jpaket_ket_diskField= new Ext.form.TextField({
		id: 'jpaket_ket_diskField',
		fieldLabel: 'No Voucher',
		itemCls : 'rata_kanan',
		//fieldLabel: 'No Voucher Non',
		width: 120,
	});
	/*untuk rupiah voucher nonmedis*/
	jpaket_cashback_cfField= new Ext.form.TextField({
		id: 'jpaket_cashback_cfField',
		//fieldLabel: '(Rp)', --> Nanti di comment semua aja fieldLabelnya.. 
		fieldLabel : 'Voucher (Rp)',
		allowNegatife : false,
		readOnly : false,
		enableKeyEvents: true,
		itemCls : 'rata_kanan',
		width: 120,
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jpaket_cashback_num.setValue(cf_tonumber);
				load_total_biaya();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/
	});
	
	jpaket_cashback_num= new Ext.form.NumberField({
		id: 'jpaket_cashback_num',
		allowNegatife : false,
		readOnly : true,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		allowDecimals: false,
		width: 100,
		maskRe: /([0-9]+)$/
	});
	
	/*untuk nommor voucher medis*/
	jpaket_ket_disk_medisField= new Ext.form.TextField({
		id: 'jpaket_ket_disk_medis',
		//fieldLabel: 'No Voucher Medis',
		width: 120,
	});
	/*untuk rupiah voucher medis*/
	jpaket_cashback_cf_medisField= new Ext.form.TextField({
		id: 'jpaket_cashback_cf_medisField',
		//fieldLabel: '(Rp)',
		allowNegatife : false,
		readOnly : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jpaket_cashback_medis_num.setValue(cf_tonumber);
				load_total_biaya();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/
	});
	
	jpaket_cashback_medis_num= new Ext.form.NumberField({
		id: 'jpaket_cashback_medis_num',
		allowNegatife : false,
		readOnly : true,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		allowDecimals: false,
		width: 100,
		maskRe: /([0-9]+)$/
	});
	
	label_medis=new Ext.form.Label({ html:  ' No Voucher Medis &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '});
	label_nonmedis=new Ext.form.Label({ html:  ' No Voucher Non Medis &nbsp; '});
	
	label_rp1=new Ext.form.Label({ html:  ' &nbsp; (Rp) &nbsp; '});
	label_rp2=new Ext.form.Label({ html:  ' &nbsp; (Rp) &nbsp; '});
	label_enter1=new Ext.form.Label({ html: '&nbsp;<br> <br>'});
	
	master_jual_paket_voucher_group = new Ext.form.FieldSet({
		title: 'Voucher',
		autoHeight: true,
		collapsible: false,
		layout:'form',
		anchor: '97%',
		items:[
			{
			//	columnWidth:0.5,
				layout: 'column',
				border:false,
				items: [label_medis,jpaket_ket_disk_medisField,label_rp1,jpaket_cashback_cf_medisField,label_enter1]			
			},
			{
			//	columnWidth:0.5,
				layout: 'column',
				border:false,
				items: [ label_nonmedis,jpaket_ket_diskField,label_rp2,jpaket_cashback_cfField] 
			}
			]
	
	});
	///////////EndOff SPLIT VOUCHER//////////
	
/*jpaket_ket_diskField= new Ext.form.TextField({
		id: 'jpaket_ket_diskField',
		fieldLabel: 'No Voucher',
		maxLength: 250,
		width: 120,
	});
	jpaket_cashback_cfField= new Ext.form.TextField({
		id: 'jpaket_cashback_cfField',
		fieldLabel: 'Voucher (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		readOnly : false,
		itemCls: 'rmoney',
		width: 120,
		maskRe: /([0-9]+)$/
	});*/

	/* Identify  jpaket_cara Field */
	jpaket_caraField= new Ext.form.ComboBox({
		id: 'jpaket_caraField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_cara_value', 'jpaket_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jpaket_cara_display',
		valueField: 'jpaket_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jpaket_cara2 Field */
	jpaket_cara2Field= new Ext.form.ComboBox({
		id: 'jpaket_cara2Field',
		fieldLabel: 'Cara Bayar 2',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_cara_value', 'jpaket_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jpaket_cara_display',
		valueField: 'jpaket_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jpaket_cara3 Field */
	jpaket_cara3Field= new Ext.form.ComboBox({
		id: 'jpaket_cara3Field',
		fieldLabel: 'Cara Bayar 3',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_cara_value', 'jpaket_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jpaket_cara_display',
		valueField: 'jpaket_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	jpaket_stat_dokField= new Ext.form.ComboBox({
		id: 'jpaket_stat_dokField',
		fieldLabel: 'Status Dokumen',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_stat_dok_value', 'jpaket_stat_dok_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'jpaket_stat_dok_display',
		valueField: 'jpaket_stat_dok_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jpaket_keterangan Field */
	jpaket_keteranganField= new Ext.form.TextArea({
		id: 'jpaket_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});

	jpaket_voucher_noField= new Ext.form.TextField({
		id: 'jpaket_voucher_noField',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	jpaket_voucher_cashback_cfField= new Ext.form.TextField({
		id: 'jpaket_voucher_cashback_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_voucher_cashbackField= new Ext.form.NumberField({
		id: 'jpaket_voucher_cashbackField',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_voucherGroup= new Ext.form.FieldSet({
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
				items: [jpaket_voucher_noField,jpaket_voucher_cashback_cfField] 
			}
		]
	
	});
	jpaket_voucher_no2Field= new Ext.form.TextField({
		id: 'jpaket_voucher_no2Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	jpaket_voucher_cashback2_cfField= new Ext.form.TextField({
		id: 'jpaket_voucher_cashback2_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_voucher_cashback2Field= new Ext.form.NumberField({
		id: 'jpaket_voucher_cashback2Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_voucher2Group= new Ext.form.FieldSet({
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
				items: [jpaket_voucher_no2Field,jpaket_voucher_cashback2_cfField] 
			}
		]
	
	});
	jpaket_voucher_no3Field= new Ext.form.TextField({
		id: 'jpaket_voucher_no3Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	jpaket_voucher_cashback3_cfField= new Ext.form.TextField({
		id: 'jpaket_voucher_cashback3_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_voucher_cashback3Field= new Ext.form.NumberField({
		id: 'jpaket_voucher_cashback3Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_voucher3Group= new Ext.form.FieldSet({
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
				items: [jpaket_voucher_no3Field,jpaket_voucher_cashback3_cfField] 
			}
		]
	
	});
	// END Field Voucher-3
	// START Field Card
	jpaket_card_namaField= new Ext.form.ComboBox({
		id: 'jpaket_card_namaField',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_card_value', 'jpaket_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jpaket_card_display',
		valueField: 'jpaket_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_card_edcField= new Ext.form.ComboBox({
		id: 'jpaket_card_edcField',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_card_edc_value', 'jpaket_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jpaket_card_edc_display',
		valueField: 'jpaket_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_card_noField= new Ext.form.TextField({
		id: 'jpaket_card_noField',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	jpaket_card_nilai_cfField= new Ext.form.TextField({
		id: 'jpaket_card_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_card_nilaiField= new Ext.form.NumberField({
		id: 'jpaket_card_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_cardGroup= new Ext.form.FieldSet({
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
				items: [jpaket_card_namaField,jpaket_card_edcField,jpaket_card_noField,jpaket_card_nilai_cfField] 
			}
		]
	
	});
	// END Field Card
	// START Field Card-2
	jpaket_card_nama2Field= new Ext.form.ComboBox({
		id: 'jpaket_card_nama2Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_card_value', 'jpaket_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jpaket_card_display',
		valueField: 'jpaket_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_card_edc2Field= new Ext.form.ComboBox({
		id: 'jpaket_card_edc2Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_card_edc_value', 'jpaket_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jpaket_card_edc_display',
		valueField: 'jpaket_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_card_no2Field= new Ext.form.TextField({
		id: 'jpaket_card_no2Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	jpaket_card_nilai2_cfField= new Ext.form.TextField({
		id: 'jpaket_card_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_card_nilai2Field= new Ext.form.NumberField({
		id: 'jpaket_card_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_card2Group= new Ext.form.FieldSet({
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
				items: [jpaket_card_nama2Field,jpaket_card_edc2Field,jpaket_card_no2Field,jpaket_card_nilai2_cfField] 
			}
		]
	});
	// END Field Card-2
	// START Field Card-3
	jpaket_card_nama3Field= new Ext.form.ComboBox({
		id: 'jpaket_card_nama3Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_card_value', 'jpaket_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jpaket_card_display',
		valueField: 'jpaket_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_card_edc3Field= new Ext.form.ComboBox({
		id: 'jpaket_card_edc3Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jpaket_card_edc_value', 'jpaket_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jpaket_card_edc_display',
		valueField: 'jpaket_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_card_no3Field= new Ext.form.TextField({
		id: 'jpaket_card_no3Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	jpaket_card_nilai3_cfField= new Ext.form.TextField({
		id: 'jpaket_card_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_card_nilai3Field= new Ext.form.NumberField({
		id: 'jpaket_card_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_card3Group= new Ext.form.FieldSet({
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
				items: [jpaket_card_nama3Field,jpaket_card_edc3Field,jpaket_card_no3Field,jpaket_card_nilai3_cfField] 
			}
		]
	
	});
	// END Field Card-3
	// StART Field Cek
	jpaket_cek_namaField= new Ext.form.TextField({
		id: 'jpaket_cek_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	jpaket_cek_noField= new Ext.form.TextField({
		id: 'jpaket_cek_noField',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	jpaket_cek_validField= new Ext.form.DateField({
		id: 'jpaket_cek_validField',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	jpaket_cek_bankField= new Ext.form.ComboBox({
		id: 'jpaket_cek_bankField',
		fieldLabel: 'Bank',
		store: jpaket_bankDataStore,
		mode: 'remote',
		displayField: 'jpaket_bank_display',
		valueField: 'jpaket_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jpaket_cek_bankField)
	});
	jpaket_cek_nilai_cfField= new Ext.form.TextField({
		id: 'jpaket_cek_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_cek_nilaiField= new Ext.form.NumberField({
		id: 'jpaket_cek_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_cekGroup = new Ext.form.FieldSet({
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
				items: [jpaket_cek_namaField,jpaket_cek_noField,jpaket_cek_validField,jpaket_cek_bankField,jpaket_cek_nilai_cfField] 
			}
		]
	});
	// END Field Cek
	// StART Field Cek-2
	jpaket_cek_nama2Field= new Ext.form.TextField({
		id: 'jpaket_cek_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	jpaket_cek_no2Field= new Ext.form.TextField({
		id: 'jpaket_cek_no2Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	jpaket_cek_valid2Field= new Ext.form.DateField({
		id: 'jpaket_cek_valid2Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	jpaket_cek_bank2Field= new Ext.form.ComboBox({
		id: 'jpaket_cek_bank2Field',
		fieldLabel: 'Bank',
		store: jpaket_bankDataStore,
		mode: 'remote',
		displayField: 'jpaket_bank_display',
		valueField: 'jpaket_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jpaket_cek_bankField)
	});
	jpaket_cek_nilai2_cfField= new Ext.form.TextField({
		id: 'jpaket_cek_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_cek_nilai2Field= new Ext.form.NumberField({
		id: 'jpaket_cek_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_cek2Group = new Ext.form.FieldSet({
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
				items: [jpaket_cek_nama2Field,jpaket_cek_no2Field,jpaket_cek_valid2Field,jpaket_cek_bank2Field,jpaket_cek_nilai2_cfField] 
			}
		]
	});
	// END Field Cek-2
	// StART Field Cek-3
	jpaket_cek_nama3Field= new Ext.form.TextField({
		id: 'jpaket_cek_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	jpaket_cek_no3Field= new Ext.form.TextField({
		id: 'jpaket_cek_no3Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	jpaket_cek_valid3Field= new Ext.form.DateField({
		id: 'jpaket_cek_valid3Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	jpaket_cek_bank3Field= new Ext.form.ComboBox({
		id: 'jpaket_cek_bank3Field',
		fieldLabel: 'Bank',
		store: jpaket_bankDataStore,
		mode: 'remote',
		displayField: 'jpaket_bank_display',
		valueField: 'jpaket_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jpaket_cek_bankField)
	});
	jpaket_cek_nilai3_cfField= new Ext.form.TextField({
		id: 'jpaket_cek_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_cek_nilai3Field= new Ext.form.NumberField({
		id: 'jpaket_cek_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_cek3Group = new Ext.form.FieldSet({
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
				items: [jpaket_cek_nama3Field,jpaket_cek_no3Field,jpaket_cek_valid3Field,jpaket_cek_bank3Field,jpaket_cek_nilai3_cfField] 
			}
		]
	});
	// END Field Cek-3
	// START Field Transfer
	jpaket_transfer_bankField= new Ext.form.ComboBox({
		id: 'jpaket_transfer_bankField',
		fieldLabel: 'Bank',
		store: jpaket_bankDataStore,
		mode: 'remote',
		displayField: 'jpaket_bank_display',
		valueField: 'jpaket_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jpaket_transfer_bankField)
	});
	jpaket_transfer_namaField= new Ext.form.TextField({
		id: 'jpaket_transfer_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	jpaket_transfer_nilai_cfField= new Ext.form.TextField({
		id: 'jpaket_transfer_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_transfer_nilaiField= new Ext.form.NumberField({
		id: 'jpaket_transfer_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_transferGroup= new Ext.form.FieldSet({
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
				items: [jpaket_transfer_bankField,jpaket_transfer_namaField,jpaket_transfer_nilai_cfField] 
			}
		]
	});
	// END Field Transfer
	// START Field Transfer-2
	jpaket_transfer_bank2Field= new Ext.form.ComboBox({
		id: 'jpaket_transfer_bank2Field',
		fieldLabel: 'Bank',
		store: jpaket_bankDataStore,
		mode: 'remote',
		displayField: 'jpaket_bank_display',
		valueField: 'jpaket_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_transfer_nama2Field= new Ext.form.TextField({
		id: 'jpaket_transfer_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	jpaket_transfer_nilai2_cfField= new Ext.form.TextField({
		id: 'jpaket_transfer_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_transfer_nilai2Field= new Ext.form.NumberField({
		id: 'jpaket_transfer_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_transfer2Group= new Ext.form.FieldSet({
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
				items: [jpaket_transfer_bank2Field,jpaket_transfer_nama2Field,jpaket_transfer_nilai2_cfField] 
			}
		]
	});
	// END Field Transfer-2
	// START Field Transfer-3
	jpaket_transfer_bank3Field= new Ext.form.ComboBox({
		id: 'jpaket_transfer_bank3Field',
		fieldLabel: 'Bank',
		store: jpaket_bankDataStore,
		mode: 'remote',
		displayField: 'jpaket_bank_display',
		valueField: 'jpaket_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	jpaket_transfer_nama3Field= new Ext.form.TextField({
		id: 'jpaket_transfer_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	jpaket_transfer_nilai3_cfField= new Ext.form.TextField({
		id: 'jpaket_transfer_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_transfer_nilai3Field= new Ext.form.NumberField({
		id: 'jpaket_transfer_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_transfer3Group= new Ext.form.FieldSet({
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
				items: [jpaket_transfer_bank3Field,jpaket_transfer_nama3Field,jpaket_transfer_nilai3_cfField] 
			}
		]
	});
	// END Field Transfer-3
	//START Field Tunai-1
	jpaket_tunai_nilai_cfField= new Ext.form.TextField({
		id: 'jpaket_tunai_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_tunai_nilaiField= new Ext.form.NumberField({
		id: 'jpaket_tunai_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_tunaiGroup = new Ext.form.FieldSet({
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
				items: [jpaket_tunai_nilai_cfField] 
			}
		]
	});
	// END Tunai-1
	//START Field Tunai-2
	jpaket_tunai_nilai2_cfField= new Ext.form.TextField({
		id: 'jpaket_tunai_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_tunai_nilai2Field= new Ext.form.NumberField({
		id: 'jpaket_tunai_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_tunai2Group = new Ext.form.FieldSet({
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
				items: [jpaket_tunai_nilai2_cfField] 
			}
		]
	});
	// END Tunai-2
	//START Field Tunai-3
	jpaket_tunai_nilai3_cfField= new Ext.form.TextField({
		id: 'jpaket_tunai_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_tunai_nilai3Field= new Ext.form.NumberField({
		id: 'jpaket_tunai_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	master_jual_paket_tunai3Group = new Ext.form.FieldSet({
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
				items: [jpaket_tunai_nilai3_cfField] 
			}
		]
	});
	// END Tunai-3
	//START Field Kwitansi-1
	jpaket_kwitansi_namaField= new Ext.form.TextField({
		id: 'jpaket_kwitansi_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	jpaket_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nilai_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'jpaket_kwitansi_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/*Field ini dipakai untuk menyimpan ID dari tabel jual_kwitansi, dimana ID ini berperan untuk mengetahui apakah kwitansi tersebut akan di Insert atau di Update */
	jpaket_jual_kwitansi_idField1= new Ext.form.NumberField();
	jpaket_jual_kwitansi_idField2= new Ext.form.NumberField();
	jpaket_jual_kwitansi_idField3= new Ext.form.NumberField();
	
	jpaket_kwitansi_idField= new Ext.form.NumberField();
	jpaket_kwitansi_noField= new Ext.form.ComboBox({
		id: 'jpaket_kwitansi_noField',
		fieldLabel: 'Nomor Kwitansi',
		store: cbo_kwitansi_jual_paket_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_paket_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	jpaket_kwitansi_sisaField= new Ext.form.NumberField({
		id: 'jpaket_kwitansi_sisaField',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	jpaket_kwitansi_noField.on("select",function(){
			j=cbo_kwitansi_jual_paket_DataStore.findExact('ckwitansi_id',jpaket_kwitansi_noField.getValue(),0);
			if(j>-1){
				jpaket_kwitansi_namaField.setValue(cbo_kwitansi_jual_paket_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jpaket_kwitansi_sisaField.setValue(cbo_kwitansi_jual_paket_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-1
	//START Field Kwitansi-2
	jpaket_kwitansi_nama2Field= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	jpaket_kwitansi_nilai2_cfField= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nilai2_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_kwitansi_nilai2_cfField= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nilai2_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_kwitansi_nilai2Field= new Ext.form.NumberField({
		id: 'jpaket_kwitansi_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	jpaket_kwitansi_id2Field= new Ext.form.NumberField();
	jpaket_kwitansi_no2Field= new Ext.form.ComboBox({
		id: 'jpaket_kwitansi_no2Field',
		fieldLabel: 'Nomor Kwitansi',
		store: cbo_kwitansi_jual_paket_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_paket_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	jpaket_kwitansi_sisa2Field= new Ext.form.NumberField({
		id: 'jpaket_kwitansi_sisa2Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	jpaket_kwitansi_no2Field.on("select",function(){
			j=cbo_kwitansi_jual_paket_DataStore.findExact('ckwitansi_id',jpaket_kwitansi_no2Field.getValue(),0);
			if(j>-1){
				jpaket_kwitansi_nama2Field.setValue(cbo_kwitansi_jual_paket_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jpaket_kwitansi_sisa2Field.setValue(cbo_kwitansi_jual_paket_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-2
	//START Field Kwitansi-3
	jpaket_kwitansi_nama3Field= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	jpaket_kwitansi_nilai3_cfField= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nilai3_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_kwitansi_nilai3_cfField= new Ext.form.TextField({
		id: 'jpaket_kwitansi_nilai3_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jpaket_kwitansi_nilai3Field= new Ext.form.NumberField({
		id: 'jpaket_kwitansi_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	jpaket_kwitansi_id3Field= new Ext.form.NumberField();
	jpaket_kwitansi_no3Field= new Ext.form.ComboBox({
		id: 'jpaket_kwitansi_no3Field',
		fieldLabel: 'Nomor Kwitansi',
		store: cbo_kwitansi_jual_paket_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_paket_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	jpaket_kwitansi_sisa3Field= new Ext.form.NumberField({
		id: 'jpaket_kwitansi_sisa3Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	jpaket_kwitansi_no3Field.on("select",function(){
			j=cbo_kwitansi_jual_paket_DataStore.findExact('ckwitansi_id',jpaket_kwitansi_no3Field.getValue(),0);
			if(j>-1){
				jpaket_kwitansi_nama3Field.setValue(cbo_kwitansi_jual_paket_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jpaket_kwitansi_sisa3Field.setValue(cbo_kwitansi_jual_paket_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-3
	master_jual_paket_kwitansiGroup = new Ext.form.FieldSet({
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
				items: [jpaket_kwitansi_noField,jpaket_kwitansi_namaField,jpaket_kwitansi_sisaField,jpaket_kwitansi_nilai_cfField] 
			}
		]
	});
	master_jual_paket_kwitansi2Group = new Ext.form.FieldSet({
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
				items: [jpaket_kwitansi_no2Field,jpaket_kwitansi_nama2Field,jpaket_kwitansi_sisa2Field,jpaket_kwitansi_nilai2_cfField] 
			}
		]
	});
	master_jual_paket_kwitansi3Group = new Ext.form.FieldSet({
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
				items: [jpaket_kwitansi_no3Field,jpaket_kwitansi_nama3Field,jpaket_kwitansi_sisa3Field,jpaket_kwitansi_nilai3_cfField] 
			}
		]
	});
	//* Bayar
	
	jpaket_jumlahLabel= new Ext.form.DisplayField({
		fieldLabel : 'Jumlah',
		itemCls : 'rata_kanan'
	});
	jpaket_subTotalLabel= new Ext.form.DisplayField({
		fieldLabel : 'Sub Total (Rp)',
		itemCls : 'rata_kanan'
		//itemCls : 'rmoney2'
	});
	jpaket_TotalLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total (Rp)</span>',
		itemCls : 'rmoney2'
	});
	
	jpaket_TotalBayarLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total Bayar (Rp)</span>',
		itemCls : 'rmoney2'
	});
	
	jpaket_HutangLabel= new Ext.form.DisplayField({
		id: 'jpaket_HutangLabel',
		fieldLabel : '<font color=black size=2>Hutang (Rp)<font>',
		itemCls : 'rmoney_hutang'
	});
	
	jpaket_jumlahField= new Ext.form.NumberField({
		id: 'jpaket_jumlahField',
		fieldLabel: 'Jumlah Item',
		allowBlank: true,
		readOnly: true,
		allowDecimals: false,
		width: 40,
		maxLength: 50,
		maskRe: /([0-9]+)$/
	});
	
	jpaket_subTotalField= new Ext.form.NumberField({
		id: 'jpaket_subTotalField',
		fieldLabel: 'Sub Total (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		itemCls: 'rmoney',
		width: 120
	});
	jpaket_subTotal_cfField= new Ext.form.TextField({
		id: 'jpaket_subTotal_cfField',
		fieldLabel: 'Sub Total (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	jpaket_totalField= new Ext.form.NumberField({
		id: 'jpaket_totalField',
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		//valueRenderer: 'numberToCurrency',
		readOnly: true,
		//itemCls: 'rmoney_b',
		width: 120,
		enableKeyEvents: true,
		allowBlank: true,
		//anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	jpaket_total_cfField= new Ext.form.TextField({
		id: 'jpaket_total_cfField',
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});

	/*
	jproduk_totalField= new Ext.form.NumberField({
		id: 'jproduk_totalField',
		enableKeyEvents: true,
		fieldLabel: '<span style="font-weight:bold">Total (Rp)</span>',
		allowBlank: true,
		anchor: '95%',
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
	*/
		
	jpaket_bayarField= new Ext.form.NumberField({
		id: 'jpaket_bayarField',
		fieldLabel: 'Total Bayar (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		itemCls: 'rmoney',
		width: 120
	});
	jpaket_bayar_cfField= new Ext.form.TextField({
		id: 'jpaket_bayar_cfField',
		fieldLabel: 'Total Bayar (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	jpaket_hutangField= new Ext.form.NumberField({
		id: 'jpaket_hutangField',
		fieldLabel: 'Hutang (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		itemCls: 'rmoney',
		width: 120
	});
	jpaket_hutang_cfField= new Ext.form.TextField({
		id: 'jpaket_hutang_cfField',
		fieldLabel: 'Hutang (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	jpaket_pesanLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '14px',
			color: '#CC0000'
		}
	});
	jpaket_lunasLabel= new Ext.form.Label({
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
                items: [jpaket_caraField,master_jual_paket_tunaiGroup,master_jual_paket_cardGroup,master_jual_paket_cekGroup,master_jual_paket_kwitansiGroup,master_jual_paket_transferGroup,master_jual_paket_voucherGroup]
            },{
                title:'Cara Bayar 2',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [jpaket_cara2Field, master_jual_paket_tunai2Group, master_jual_paket_kwitansi2Group ,master_jual_paket_card2Group, master_jual_paket_cek2Group, master_jual_paket_transfer2Group, master_jual_paket_voucher2Group]
            },{
                title:'Cara Bayar 3',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [jpaket_cara3Field, master_jual_paket_tunai3Group, master_jual_paket_kwitansi3Group, master_jual_paket_card3Group, master_jual_paket_cek3Group, master_jual_paket_transfer3Group, master_jual_paket_voucher3Group]
            }]
	});
	master_jual_paket_bayarGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		frame: true,
		items:[
			   {
				//columnWidth:0.5,
				columnWidth:0.6,
				layout: 'form',
				border:false,
				items: [master_cara_bayarTabPanel] 
			}
			,{
				//columnWidth:0.5,
				columnWidth:0.3,
				labelWidth: 180,
				layout: 'form',
    			labelPad: 0,
				baseCls: 'x-plain',
				border:false,
				labelAlign: 'left',
				items: [/*jpaket_jumlahField,*/jpaket_jumlahLabel, jpaket_subTotalLabel, jpaket_cashback_cfField, jpaket_ket_diskField, /*master_jual_paket_voucher_group,*/ {xtype: 'spacer',height:10},jpaket_TotalLabel, jpaket_TotalBayarLabel,jpaket_HutangLabel ,jpaket_pesanLabel ,jpaket_lunasLabel] 
			}
			]
	});
	/*Fieldset Master*/
	master_jual_paket_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jpaket_nobuktiField, jpaket_custField,
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[jpaket_cust_nomemberLabel, jpaket_cust_nomemberField,jpaket_valid_memberLabel,jpaket_valid_memberField]
						}, {xtype: 'spacer',height:5},
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[jpaket_cust_ultahLabel, jpaket_cust_ultahField,jpaket_cust_priorityLabel]
						}
						] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jpaket_tanggalField, jpaket_keteranganField, jpaket_stat_dokField] 
			}
			]
	});
	/*Detail Declaration */
	// Function for json reader of detail
	var detail_jual_paket_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'dpaket_id', type: 'int', mapping: 'dpaket_id'}, 
			{name: 'dpaket_master', type: 'int', mapping: 'dpaket_master'}, 
			{name: 'dpaket_paket', type: 'int', mapping: 'dpaket_paket'},
			{name: 'dpaket_karyawan', type: 'int', mapping: 'dpaket_karyawan'},
			{name: 'dpaket_kadaluarsa', type: 'date', dateFormat: 'Y-m-d', mapping: 'dpaket_kadaluarsa'}, 
			{name: 'dpaket_jumlah', type: 'int', mapping: 'dpaket_jumlah'}, 
			{name: 'dpaket_harga', type: 'float', mapping: 'dpaket_harga'}, 
			{name: 'dpaket_diskon', type: 'int', mapping: 'dpaket_diskon'}, 
			{name: 'dpaket_diskon_jenis', type: 'string', mapping: 'dpaket_diskon_jenis'}, 
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'}, 
			{name: 'dpaket_sales', type: 'string', mapping: 'dpaket_sales'},
			{name: 'dpaket_subtotal', type: 'float', mapping: 'dpaket_subtotal'},
			{name: 'dpaket_subtotal_net', type: 'int', mapping: 'dpaket_subtotal_net'},
			{name: 'jpaket_bayar', type: 'float', mapping: 'jpaket_bayar'},
			{name: 'jpaket_diskon', type: 'int', mapping: 'jpaket_diskon'},
			{name: 'jpaket_cashback', type: 'float', mapping: 'jpaket_cashback'},
			{name: 'paket_point', type: 'int', mapping: 'paket_point'}
	]);
	//eof
	//function for json writer of detail
	var detail_jual_paket_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	/* Function for Retrieve DataStore of detail*/
	detail_jual_paket_DataStore = new Ext.data.Store({
		id: 'detail_jual_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=detail_detail_jual_paket_list', 
			method: 'POST'
		}),baseParams: {master_id: jpaket_idField.getValue(), start: 0, limit: jpaket_pageS},
		reader: detail_jual_paket_reader,
		sortInfo:{field: 'dpaket_id', direction: "ASC"}
	});
	/* End of Function */
	//function for editor of detail
	var editor_detail_jual_paket= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	cbo_dpaket_paketDataStore = new Ext.data.Store({
		id: 'cbo_dpaket_paketDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_paket_list', 
			method: 'POST'
		}),baseParams: {aktif: 'yes', start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'paket_id'
		},[
			{name: 'dpaket_paket_value', type: 'int', mapping: 'paket_id'},
			{name: 'dpaket_paket_harga', type: 'float', mapping: 'paket_harga'},
			{name: 'dpaket_paket_kode', type: 'string', mapping: 'paket_kode'},
			{name: 'dpaket_paket_du', type: 'float', mapping: 'paket_du'},
			{name: 'dpaket_paket_dm', type: 'float', mapping: 'paket_dm'},
			{name: 'dpaket_paket_dultah', type: 'float', mapping: 'paket_dultah'},
			{name: 'dpaket_paket_dcard', type: 'float', mapping: 'paket_dcard'},
			{name: 'dpaket_paket_dkolega', type: 'float', mapping: 'paket_dkolega'},
			{name: 'dpaket_paket_dkeluarga', type: 'float', mapping: 'paket_dkeluarga'},
			{name: 'dpaket_paket_downer', type: 'float', mapping: 'paket_downer'},
			{name: 'dpaket_paket_dgrooming', type: 'float', mapping: 'paket_dgrooming'},
			{name: 'dpaket_paket_dwartawan', type: 'float', mapping: 'paket_dwartawan'},
			{name: 'dpaket_paket_dstaffdokter', type: 'float', mapping: 'paket_dstaffdokter'},
			{name: 'dpaket_paket_dstaffnondokter', type: 'float', mapping: 'paket_dstaffnondokter'},
			{name: 'dpaket_paket_dpromo', type: 'float', mapping: 'paket_dpromo'},
			{name: 'dpaket_paket_display', type: 'string', mapping: 'paket_nama'},
			{name: 'dpaket_paket_expired', type: 'int', mapping: 'paket_expired'},
			{name: 'dpaket_edit_harga', type: 'int', mapping: 'paket_edit_harga'},
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'dpaket_paket_display', direction: "ASC"}
	});
	cbo_dpaket_reveralDataStore = new Ext.data.Store({
		id: 'cbo_dpaket_reveralDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_reveral_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 100 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'nama_karyawan', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'}
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	var reveral_paket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{nama_karyawan}</b> | {karyawan_display}</span>',
        '</div></tpl>'
    );
	memberDataStore = new Ext.data.Store({
		id: 'memberDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=get_member_by_cust', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'member_id'
		},[
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
	var combo_jual_paket=new Ext.form.ComboBox({
		store: cbo_dpaket_paketDataStore,
		mode: 'remote',
		displayField: 'dpaket_paket_display',
		valueField: 'dpaket_paket_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:jpaket_pageS,
		hideTrigger:false,
		tpl: paket_jual_paket_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	dpaket_idField=new Ext.form.NumberField();
	dpaket_kategori_field=new Ext.form.TextField(); //Kategori Medis atau NonMedis
	
	
	combo_jual_paket.on('select',function(){
		var editable_harga_paket = 0;
		var j=cbo_dpaket_paketDataStore.findExact('dpaket_paket_value',combo_jual_paket.getValue(),0);
		
		/*Di cek, apakah produk_edit_harga dari produk ini 0 / 1, jika 1 maka bisa di edit2 harganya, jika 0, maka ga bisa di edit2 harganya */
		editable_harga_paket = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_edit_harga;
		if(editable_harga_paket == 1){
			dpaket_hargaField.setDisabled(false);
			dpaket_hargaField.setReadOnly(false);
		}
		else if(editable_harga_paket == 0){
			dpaket_hargaField.setDisabled(true);
			dpaket_hargaField.setReadOnly(true);	
		}
		
		
		if(cbo_dpaket_paketDataStore.getCount()){
			var dtotal_net_field = 0;
			dpaket_idField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_value);
			dpaket_jumlahField.setValue(1);
			var dpaket_jumlah_diskon = 0;
			//* Check no_member JIKA <>"" ==> jenis-diskon=DM /
			if(jpaket_cust_nomemberField.getValue()!=="" && jpaket_valid_memberField.getValue().format('d-m-Y') >= today){
					dpaket_jenisdiskonField.setValue('Member');
					dpaket_jumlah_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dm;
					dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dm);
					dpaket_jumlahdiskonField.setDisabled(true); 
			}else{
					dpaket_jenisdiskonField.setValue('Umum');
					dpaket_jumlah_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_du;
					dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_du);
					dpaket_jumlahdiskonField.setDisabled(true);
			}
			var DayLength=1*24*60*60*1000;
			var Days=cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_expired;
			var dt_kadaluarsa=new Date(jpaket_tanggalField.getValue()*1+DayLength*Days);
			dpaket_kadaluarsaField.setValue(dt_kadaluarsa);
			dpaket_hargaField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_harga);
			dpaket_subtotalField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_harga);
			dtotal_net_field = ((100-dpaket_jumlah_diskon)/100)*cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_harga;
			dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
			dpaket_subtotalnetField.setValue(dtotal_net_field);
			dpaket_kategori_field.setValue(cbo_dpaket_paketDataStore.getAt(j).data.kategori_nama);

		}
		window.refresh();
	});
	var combo_reveral_paket=new Ext.form.ComboBox({
		store: cbo_dpaket_reveralDataStore,
		mode: 'remote',
		displayField: 'karyawan_display',
		valueField: 'karyawan_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:jpaket_pageS,
		hideTrigger:false,
		tpl: reveral_paket_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	var dpaket_kadaluarsaField= new Ext.form.DateField({
		id: 'dpaket_kadaluarsaField',
		readOnly: true,
		disabled: true,
		format : 'd-m-Y',
	});
	var dpaket_hargaField= new Ext.form.NumberField({
		id: 'dpaket_hargaField',
		allowNegatife : false,
		allowDecimals: false,
		disabled: true,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	var dpaket_subtotalField= new Ext.form.NumberField({
		id: 'dpaket_subtotalField',
		allowNegatife : false,
		allowDecimals: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	var dpaket_subtotalnetField= new Ext.form.NumberField({
		id: 'dpaket_subtotalnetField',
		allowNegatife : false,
		allowDecimals: false,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	var dpaket_jumlahField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	dpaket_jumlahField.on('keyup', function(){
		var dtotal_net_field = 0;
		var sub_total = dpaket_jumlahField.getValue()*dpaket_hargaField.getValue();
		dpaket_subtotalField.setValue(sub_total);
		dtotal_net_field = ((100-dpaket_jumlahdiskonField.getValue())/100) * sub_total;
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		dpaket_subtotalnetField.setValue(dtotal_net_field);
	});
	var dpaket_jenisdiskonField= new Ext.form.ComboBox({
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
	dpaket_jenisdiskonField.on('select', function(){
		var dtotal_net_field = 0;
		var djumlah_beli_paket = dpaket_jumlahField.getValue();
		var j=cbo_dpaket_paketDataStore.findExact('dpaket_paket_value',combo_jual_paket.getValue(),0);
		var dpaket_jenis_diskon = 0;
		if(dpaket_jenisdiskonField.getValue()=='Umum'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_du;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_du);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Member'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dm;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dm);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Ultah'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dultah;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dultah);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Card'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dcard;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dcard);
			//dpaket_jumlahdiskonField.setReadOnly(false);
			dpaket_jumlahdiskonField.setDisabled(false);
		}else if(dpaket_jenisdiskonField.getValue()=='Kolega'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dkolega;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dkolega);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Keluarga'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dkeluarga;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dkeluarga);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Owner'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_downer;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_downer);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Grooming'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dgrooming;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dgrooming);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Wartawan'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dwartawan;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dwartawan);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Staff'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dstaffdokter;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dstaffdokter);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Staf Non Dokter'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dstaffnondokter;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dstaffnondokter);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}else if(dpaket_jenisdiskonField.getValue()=='Promo'){
			dpaket_jenis_diskon = cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dpromo;
			dpaket_jumlahdiskonField.setValue(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dpromo);
			//dpaket_jumlahdiskonField.setReadOnly(true);
			dpaket_jumlahdiskonField.setDisabled(true);
		}
		else{
			dpaket_jumlahdiskonField.setValue(0);
			dpaket_jumlahdiskonField.setReadOnly(true);
		}
		dtotal_net_field = ((100-dpaket_jenis_diskon)/100) * (djumlah_beli_paket*cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_harga);
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		dpaket_subtotalnetField.setValue(dtotal_net_field);
	});
	var dpaket_jumlahdiskonField= new Ext.form.NumberField({
		id : 'dpaket_jumlahdiskonField',
		name : 'dpaket_jumlahdiskonField',
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		readOnly : true,
		maskRe: /([0-9]+)$/
	});

	dpaket_jumlahdiskonField.on('keyup', function(){
		var sub_total_net = ((100-dpaket_jumlahdiskonField.getValue())/100)*dpaket_subtotalField.getValue();
		sub_total_net = (sub_total_net>0?Math.round(sub_total_net):0);
		dpaket_subtotalnetField.setValue(sub_total_net);
		if(this.getRawValue()>15 && dpaket_jenisdiskonField.getValue()=='Card'){
			this.setRawValue(15);
		}
	});
	//declaration of detail coloumn model
	detail_jual_paket_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'dpaket_id',
            hidden: true
		},
		{	align : 'Left',
			header: '<div align="center">' + 'Paket' + '</div>',
			dataIndex: 'dpaket_paket',
			width: 230,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: combo_jual_paket,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_jual_paket)
		},
		{
			header: '<div align="center">' + 'Jns' + '</div>',
			dataIndex: 'kategori_nama',
			editor: dpaket_kategori_field,
			width: 60
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jumlah' + '</div>',
			dataIndex: 'dpaket_jumlah',
			width: 60,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000')
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>,
			editor: dpaket_jumlahField
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Kadaluarsa' + '</div>',
			dataIndex: 'dpaket_kadaluarsa',
			width: 80,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: dpaket_kadaluarsaField,
			<?php } ?>
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			dataIndex: 'dpaket_harga',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: dpaket_hargaField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'DPP (Rp)' + '</div>',
			dataIndex: 'dpaket_harga',
			width: 80,
			sortable: true,
			renderer: function(v, params, record){
				var record_dpp = record.data.dpaket_harga/1.1;
				record_dpp = (record_dpp>0?Math.round(record_dpp):0);
				return Ext.util.Format.number(record_dpp,'0,000');
			}
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			dataIndex: 'dpaket_subtotal',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: dpaket_subtotalField,
			<?php } ?>
			renderer: function(v, params, record){
				return Ext.util.Format.number(record.data.dpaket_jumlah * record.data.dpaket_harga,'0,000');
            }
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jenis Diskon' + '</div>',
			dataIndex: 'dpaket_diskon_jenis',
			width: 80,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>,
			editor: dpaket_jenisdiskonField
			<?php } ?>
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Diskon (%)' + '</div>',
			dataIndex: 'dpaket_diskon',
			width: 80,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: dpaket_jumlahdiskonField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},{
			align : 'Right',
			header: '<div align="center">' + 'Sub Tot Net (Rp)' + '</div>',
			dataIndex: 'dpaket_subtotal_net',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: dpaket_subtotalnetField,
			<?php } ?>
			renderer: function(v, params, record){
				var record_dtotal_net = record.data.dpaket_jumlah*record.data.dpaket_harga*((100-record.data.dpaket_diskon)/100);
				record_dtotal_net = (record_dtotal_net>0?Math.round(record_dtotal_net):0);
				return Ext.util.Format.number(record_dtotal_net,'0,000');
            }
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Sub Tot Net DPP (Rp)' + '</div>',
			dataIndex: 'dpaket_subtotal_net',
			width: 120,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			//editor: subtot_dpp_Field,
			<?php } ?>
			renderer: function(v, params, record){
				var record_subtot_dpp = (record.data.dpaket_jumlah*record.data.dpaket_harga*((100-record.data.dpaket_diskon)/100))/1.1;
				record_subtot_dpp = (record_subtot_dpp>0?Math.round(record_subtot_dpp):0);
				return Ext.util.Format.number(record_subtot_dpp,'0,000');
			}
		},
		
		{
			align : 'Left',
			header: '<div align="center">' + 'Referal' + '</div>',
			dataIndex: 'dpaket_karyawan',
			width: 150,
			sortable: false,
			allowBlank: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: combo_reveral_paket,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_reveral_paket)
		}]
	);
	detail_jual_paket_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_jual_paketListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_jual_paketListEditorGrid',
		el: 'fp_detail_jual_paket',
		title: 'Detail Penjualan Paket',
		height: 250,
		width: 938,
		autoScroll: true,
		store: detail_jual_paket_DataStore, // DataStore
		colModel: detail_jual_paket_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
		plugins: [editor_detail_jual_paket],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: jpaket_pageS,
			store: detail_jual_paket_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_jual_paket_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_jual_paket_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	//function of detail add
	function detail_jual_paket_add(){
		dpaket_jumlahdiskonField.setReadOnly(true);
	
		//jika detail sudah ada 1, maka referal akan mengikuti row sebelumnya
		if(detail_jual_paketListEditorGrid.selModel.getCount() == 1)
		{
		// temp ini berfungsi utk menyimpan ID dari referal yang terakhir kali diinput. Jika program di Refresh / Cancel, maka akan kembali ke kondisi semula
		var temp_paket = combo_reveral_paket.getValue(1);
		var edit_detail_jual_paket= new detail_jual_paketListEditorGrid.store.recordType({
			dpaket_id	:0,		
			dpaket_paket	:'',
			dpaket_jumlah	:1,
			dpaket_kadaluarsa	:null,
			dpaket_harga	:0,
			dpaket_subtotal	:0,
			dpaket_diskon_jenis:'',
			dpaket_diskon	:0,
			dpaket_subtotal_net	:0,
			dpaket_karyawan :temp_paket
		});
		editor_detail_jual_paket.stopEditing();
		detail_jual_paket_DataStore.insert(0, edit_detail_jual_paket);
		detail_jual_paketListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_jual_paket.startEditing(0);
		}
		else
		{
		
		var edit_detail_jual_paket= new detail_jual_paketListEditorGrid.store.recordType({
			dpaket_id	:0,		
			dpaket_paket	:'',
			dpaket_jumlah	:1,
			dpaket_kadaluarsa	:null,
			dpaket_harga	:0,
			dpaket_subtotal	:0,
			dpaket_diskon_jenis:'',
			dpaket_diskon	:0,
			dpaket_subtotal_net	:0,
			dpaket_karyawan :''
		});
		editor_detail_jual_paket.stopEditing();
		detail_jual_paket_DataStore.insert(0, edit_detail_jual_paket);
		detail_jual_paketListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_jual_paket.startEditing(0);
		
		}
		
		
	}
	//function for insert detail
	function detail_jual_paket_insert(){
		var dpaket_id=[];
		var dpaket_paket=[];
		var dpaket_karyawan=[];
		var dpaket_jumlah=[];
		var dpaket_kadaluarsa=[];
		var dpaket_harga=[];
		var dpaket_diskon=[];
		var dpaket_diskon_jenis=[];
		var dpaket_sales=[];
		var dcount = detail_jual_paket_DataStore.getCount() - 1;
		if(detail_jual_paket_DataStore.getCount()>0){
			for(i=0; i<detail_jual_paket_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				if(i==dcount){
					var encoded_array_dpaket_id = Ext.encode(dpaket_id);
					var encoded_array_dpaket_paket = Ext.encode(dpaket_paket);
					var encoded_array_dpaket_karyawan = Ext.encode(dpaket_karyawan);
					var encoded_array_dpaket_jumlah = Ext.encode(dpaket_jumlah);
					var encoded_array_dpaket_kadaluarsa = Ext.encode(dpaket_kadaluarsa);
					var encoded_array_dpaket_harga = Ext.encode(dpaket_harga);
					var encoded_array_dpaket_diskon = Ext.encode(dpaket_diskon);
					var encoded_array_dpaket_diskon_jenis = Ext.encode(dpaket_diskon_jenis);
					var encoded_array_dpaket_sales = Ext.encode(dpaket_sales);
					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_master_jual_paket&m=detail_detail_jual_paket_insert',
						params:{
							cetak	: cetak_jpaket,
							dpaket_id	: encoded_array_dpaket_id, 
							dpaket_master	: eval(get_pk_id()),
							dpaket_paket	: encoded_array_dpaket_paket,
							dpaket_karyawan : encoded_array_dpaket_karyawan,
							dpaket_jumlah	: encoded_array_dpaket_jumlah,
							dpaket_kadaluarsa	: encoded_array_dpaket_kadaluarsa,
							dpaket_harga	: encoded_array_dpaket_harga,
							dpaket_diskon	: encoded_array_dpaket_diskon,
							dpaket_diskon_jenis	: encoded_array_dpaket_diskon_jenis,
							dpaket_sales	: encoded_array_dpaket_sales
						},
						timeout: 60000,
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}
							else if(result>0 && cetak_jpaket==2){
								jpaket_cetak2(result);
								cetak_jpaket=0;
							}
							else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}
							else{
								jpaket_btn_cancel();
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
							jpaket_btn_cancel();
						}
					});
				}
			}
		}
	}
	//eof
	/* Function for Delete Confirm of detail */
	function detail_jual_paket_confirm_delete(){
		if(detail_jual_paketListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_jual_paket_delete);
		} else if(detail_jual_paketListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_jual_paket_delete);
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
	//eof
	//function for Delete of detail
	function detail_jual_paket_delete(btn){
		if(btn=='yes'){
            var selections = detail_jual_paketListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dpaket_id==''){
                    detail_jual_paket_DataStore.remove(record);
					load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.dpaket_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_jual_paket_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_jual_paket&m=get_action', 
                        params: { task: "DDELETE", dpaket_id:  record.data.dpaket_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									break;
								case 0:
									Ext.MessageBox.show({
									   title: 'Warning',
									   width: 400,
									   msg: 'Penghapusan tidak bisa dilakukan, <br/>karena sudah pernah dilakukan pengambilan perawatan dalam Paket ini.',
									   buttons: Ext.MessageBox.OK,
									   animEl: 'save',
									   icon: Ext.MessageBox.WARNING
									});
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
	/* START Detail Pengguna Paket */
	/*Detail Declaration */
	// Function for json reader of detail
	var detail_pengguna_paket_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'ppaket_id', type: 'int', mapping: 'ppaket_id'}, 
			{name: 'ppaket_master', type: 'int', mapping: 'ppaket_master'}, 
			{name: 'ppaket_cust', type: 'int', mapping: 'ppaket_cust'}
	]);
	//eof
	//function for json writer of detail
	var detail_pengguna_paket_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	/* Function for Retrieve DataStore of detail*/
	detail_pengguna_paket_DataStore = new Ext.data.Store({
		id: 'detail_pengguna_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_paket&m=detail_pengguna_paket_list', 
			method: 'POST'
		}),baseParams: {master_id: jpaket_idField.getValue(), start: 0, limit: jpaket_pageS},
		reader: detail_pengguna_paket_reader,
		sortInfo:{field: 'ppaket_id', direction: "ASC"}
	});
	/* End of Function */
	//function for editor of detail
	var editor_detail_pengguna_paket= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	var combo_pengguna_paket=new Ext.form.ComboBox({
		store: cbo_cust_pengguna_paket_DataStore,
		mode: 'remote',
		displayField:'cust_display',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_paket_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small'
	});
	//declaration of detail coloumn model
	detail_pengguna_paket_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Customer Lain',
			dataIndex: 'ppaket_cust',
			width: 298,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			editor: combo_pengguna_paket,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_pengguna_paket)
		}]
	);
	detail_pengguna_paket_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_pengguna_paketListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_pengguna_paketListEditorGrid',
		el: 'fp_detail_pengguna_paket',
		title: 'Daftar Pemakai Paket',
		height: 250,
		width: 940,	//938,
		autoScroll: true,
		store: detail_pengguna_paket_DataStore, // DataStore
		colModel: detail_pengguna_paket_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
		plugins: [editor_detail_pengguna_paket],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		bbar: new Ext.PagingToolbar({
			pageSize: jpaket_pageS,
			store: detail_pengguna_paket_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_pengguna_paket_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_pengguna_paket_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	//function of detail add
	function detail_pengguna_paket_add(){
		var edit_detail_pengguna_paket= new detail_pengguna_paketListEditorGrid.store.recordType({
			ppaket_id	:0,
			ppaket_cust	:''
		});
		editor_detail_pengguna_paket.stopEditing();
		detail_pengguna_paket_DataStore.insert(0, edit_detail_pengguna_paket);
		detail_pengguna_paketListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_pengguna_paket.startEditing(0);
	}
	//function for insert detail
	function detail_pengguna_paket_insert(){
		var ppaket_id=[];
		var ppaket_cust=[];
		var dcount = detail_pengguna_paket_DataStore.getCount() - 1;
		if(detail_pengguna_paket_DataStore.getCount()>0){
			for(i=0; i<detail_pengguna_paket_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_pengguna_paket_DataStore.getAt(i).data.ppaket_cust))
				   && detail_pengguna_paket_DataStore.getAt(i).data.ppaket_cust!==undefined
				   && detail_pengguna_paket_DataStore.getAt(i).data.ppaket_cust!==''
				   && detail_pengguna_paket_DataStore.getAt(i).data.ppaket_cust!==0){
					if(detail_pengguna_paket_DataStore.getAt(i).data.ppaket_id==undefined){
						ppaket_id.push('');
					}else{
						ppaket_id.push(detail_pengguna_paket_DataStore.getAt(i).data.ppaket_id);
					}
					if(detail_pengguna_paket_DataStore.getAt(i).data.ppaket_cust==undefined){
						ppaket_cust.push('');
					}else{
						ppaket_cust.push(detail_pengguna_paket_DataStore.getAt(i).data.ppaket_cust);
					}
				}
				if(i==dcount){
					var encoded_array_ppaket_id = Ext.encode(ppaket_id);
					var encoded_array_ppaket_cust = Ext.encode(ppaket_cust);
					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_master_jual_paket&m=detail_pengguna_paket_insert',
						params:{
							ppaket_id	: encoded_array_ppaket_id,
							ppaket_master	: eval(get_pk_id()), 
							ppaket_cust	: encoded_array_ppaket_cust
						},
						timeout: 60000,
						success: function(response){							
							var result=eval(response.responseText);
							jpaket_btn_cancel();
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
							jpaket_btn_cancel();
						}		
					});
				}
			}
		}
	}
	//eof
	/* Function for Delete Confirm of detail */
	function detail_pengguna_paket_confirm_delete(){
		if(detail_pengguna_paketListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_pengguna_paket_delete);
		} else if(detail_pengguna_paketListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_pengguna_paket_delete);
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
	//eof
	//function for Delete of detail
	function detail_pengguna_paket_delete(btn){
		if(btn=='yes'){
			var selection = detail_pengguna_paketListEditorGrid.getSelectionModel().getSelections();
				if(selection[0].data.ppaket_id==0){
					detail_pengguna_paket_DataStore.remove(selection[0]);
				}else{
					var r = selection[0];
					Ext.Ajax.request({
						waitMsg: 'Please Wait',
						url: 'index.php?c=c_master_jual_paket&m=get_action', 
						params: {
							task: "PENGGUNADELETE",
							ppaket_master:  r.data.ppaket_master,
							ppaket_cust: r.data.ppaket_cust
						},
						success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:  // Success : simply reload
									detail_pengguna_paket_DataStore.remove(selection[0]);
									break;
								default:
									Ext.MessageBox.show({
										title: 'Warning',
										msg: 'Pengguna Paket tidak dapat dihapus, karena sudah melakukan pengambilan paket di Faktur Paket ini.',
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
		detail_pengguna_paket_DataStore.commitChanges();
	}
	//eof
	/* END Detail Pengguna Paket*/
	function update_group_carabayar_jual_paket(){
		var value=jpaket_caraField.getValue();
		master_jual_paket_tunaiGroup.setVisible(false);
		master_jual_paket_cardGroup.setVisible(false);
		master_jual_paket_cekGroup.setVisible(false);
		master_jual_paket_transferGroup.setVisible(false);
		master_jual_paket_kwitansiGroup.setVisible(false);
		master_jual_paket_voucherGroup.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jpaket_tunai_nilaiField.reset();
		jpaket_tunai_nilai_cfField.reset();
		jpaket_card_nilaiField.reset();
		jpaket_card_nilai_cfField.reset();
		jpaket_cek_nilaiField.reset();
		jpaket_cek_nilai_cfField.reset();
		jpaket_transfer_nilaiField.reset();
		jpaket_transfer_nilai_cfField.reset();
		jpaket_kwitansi_nilaiField.reset();
		jpaket_kwitansi_nilai_cfField.reset();
		jpaket_voucher_cashbackField.reset();
		if(value=='card'){
			master_jual_paket_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_paket_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			master_jual_paket_transferGroup.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_paket_kwitansiGroup.setVisible(true);
		}else if(value=='voucher'){
			master_jual_paket_voucherGroup.setVisible(true);
		}else if(value=='tunai'){
			master_jual_paket_tunaiGroup.setVisible(true);
		}
	}
	function update_group_carabayar2_jual_paket(){
		var value=jpaket_cara2Field.getValue();
		master_jual_paket_tunai2Group.setVisible(false);
		master_jual_paket_card2Group.setVisible(false);
		master_jual_paket_cek2Group.setVisible(false);
		master_jual_paket_transfer2Group.setVisible(false);
		master_jual_paket_kwitansi2Group.setVisible(false);
		master_jual_paket_voucher2Group.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jpaket_tunai_nilai2Field.reset();
		jpaket_tunai_nilai2_cfField.reset();
		jpaket_card_nilai2Field.reset();
		jpaket_card_nilai2_cfField.reset();
		jpaket_cek_nilai2Field.reset();
		jpaket_cek_nilai2_cfField.reset();
		jpaket_transfer_nilai2Field.reset();
		jpaket_transfer_nilai2_cfField.reset();
		jpaket_kwitansi_nilai2Field.reset();
		jpaket_kwitansi_nilai2_cfField.reset();
		jpaket_voucher_cashback2Field.reset();
		if(value=='card'){
			master_jual_paket_card2Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_paket_cek2Group.setVisible(true);
		}else if(value=='transfer'){
			master_jual_paket_transfer2Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_paket_kwitansi2Group.setVisible(true);
		}else if(value=='voucher'){
			master_jual_paket_voucher2Group.setVisible(true);
		}else if(value=='tunai'){
			master_jual_paket_tunai2Group.setVisible(true);
		}
	}
	function update_group_carabayar3_jual_paket(){
		var value=jpaket_cara3Field.getValue();
		master_jual_paket_tunai3Group.setVisible(false);
		master_jual_paket_card3Group.setVisible(false);
		master_jual_paket_cek3Group.setVisible(false);
		master_jual_paket_transfer3Group.setVisible(false);
		master_jual_paket_kwitansi3Group.setVisible(false);
		master_jual_paket_voucher3Group.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jpaket_tunai_nilai3Field.reset();
		jpaket_tunai_nilai3_cfField.reset();
		jpaket_card_nilai3Field.reset();
		jpaket_card_nilai3_cfField.reset();
		jpaket_cek_nilai3Field.reset();
		jpaket_cek_nilai3_cfField.reset();
		jpaket_transfer_nilai3Field.reset();
		jpaket_transfer_nilai3_cfField.reset();
		jpaket_kwitansi_nilai3Field.reset();
		jpaket_kwitansi_nilai3_cfField.reset();
		jpaket_voucher_cashback3Field.reset();
		if(value=='card'){
			master_jual_paket_card3Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_paket_cek3Group.setVisible(true);
		}else if(value=='transfer'){
			master_jual_paket_transfer3Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_paket_kwitansi3Group.setVisible(true);
		}else if(value=='voucher'){
			master_jual_paket_voucher3Group.setVisible(true);
		}else if(value=='tunai'){
			master_jual_paket_tunai3Group.setVisible(true);
		}
	}
	function load_detail_jual_paket(){
		var detail_jual_paket_record;
		for(i=0;i<detail_jual_paket_DataStore.getCount();i++){
			detail_jual_paket_record=detail_jual_paket_DataStore.getAt(i);
			var j=cbo_dpaket_paketDataStore.findExact('dpaket_paket_value',detail_jual_paket_record.data.dpaket_paket,0);
			if(j>-1){
				detail_jual_paket_record.data.dpaket_harga=cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_harga;
				if(detail_jual_paket_record.data.dpaket_diskon==""){
					if(jpaket_cust_nomemberField.getValue()!=""){
						if(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dm!==0){
							detail_jual_paket_record.data.dpaket_diskon=cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_dm;
							detail_jual_paket_record.data.dpaket_diskon_jenis='Member';
						}
					}else{
						if(cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_du!==0){
							detail_jual_paket_record.data.dpaket_diskon=cbo_dpaket_paketDataStore.getAt(j).data.dpaket_paket_du;
							detail_jual_paket_record.data.dpaket_diskon_jenis='Umum';
						}
					}
				}
			}
		}
	}
	/* START LOAD TOTAL BAYAR */
	function load_total_bayar_updating(){
		var update_total_field=0;
		var update_hutang_field=0;
		var jpaket_bayar_temp=jpaket_bayarField.getValue();
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
		transfer_nilai=jpaket_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=jpaket_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;
		transfer_nilai2=jpaket_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=jpaket_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		transfer_nilai3=jpaket_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=jpaket_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		kwitansi_nilai=jpaket_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=jpaket_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		kwitansi_nilai2=jpaket_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=jpaket_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		kwitansi_nilai3=jpaket_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=jpaket_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		card_nilai=jpaket_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=jpaket_card_nilaiField.getValue();
		else
			card_nilai=0;
		card_nilai2=jpaket_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=jpaket_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		card_nilai3=jpaket_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=jpaket_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		cek_nilai=jpaket_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=jpaket_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		cek_nilai2=jpaket_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=jpaket_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		cek_nilai3=jpaket_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=jpaket_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		voucher_nilai=jpaket_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=jpaket_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		voucher_nilai2=jpaket_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=jpaket_voucher_cashback3Field.getValue();
		else
			voucher_nilai2=0;
		voucher_nilai3=jpaket_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=jpaket_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;
		tunai_nilai=jpaket_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=jpaket_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;
		tunai_nilai2=jpaket_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=jpaket_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;
		tunai_nilai3=jpaket_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=jpaket_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;
		total_bayar=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		update_total_field=jpaket_subTotalField.getValue()-jpaket_cashback_num_medis.getValue()-jpaket_cashback_num.getValue();
		jpaket_totalField.setValue(update_total_field);
		jpaket_total_cfField.setValue(CurrencyFormatted(update_total_field));
		jpaket_TotalLabel.setValue(CurrencyFormatted(update_total_field));

		jpaket_bayarField.setValue(total_bayar);
		jpaket_bayar_cfField.setValue(CurrencyFormatted(total_bayar));
		jpaket_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar));
		
		update_hutang_field=update_total_field-total_bayar;
		jpaket_hutangField.setValue(update_hutang_field);
		jpaket_hutang_cfField.setValue(CurrencyFormatted(update_hutang_field));
		jpaket_HutangLabel.setValue(CurrencyFormatted(update_hutang_field));
		
		jpaket_diskonField.setValue(jpaket_diskonField.getValue());
		jpaket_cashbackField.setValue(jpaket_cashback_num.getValue());
		jpaket_cashback_cfField.setValue(CurrencyFormatted(jpaket_cashback_num.getValue()));
		if(total_bayar>update_total_field){
			jpaket_pesanLabel.setText("Kelebihan Jumlah Bayar");
		}else if(total_bayar<update_total_field || total_bayar==update_total_field){
			jpaket_pesanLabel.setText("");
		}
		if(total_bayar==update_total_field){
			jpaket_lunasLabel.setText("LUNAS");
		}else if(total_bayar!==update_total_field){
			jpaket_lunasLabel.setText("");
		}
	}
	/* END LOAD TOTAL BAYAR */
	function load_dstore_jpaket(){
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
		/*var disk_tambahan_field = jpaket_diskonField.getValue();
		if(disk_tambahan_field==''){
			disk_tambahan_field = 0;
		}*/
		var voucher_rp_field = jpaket_cashback_num.getValue();
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		var voucher_rp_medis_field = jpaket_cashback_medis_num.getValue();
		if(voucher_rp_medis_field==''){
			voucher_rp_medis_field = 0;
		}
		
		var total_bayar_field = jpaket_bayarField.getValue();
		var jumlah_item = 0;
		var sub_total_field = 0;
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		for(i=0;i<detail_jual_paket_DataStore.getCount();i++){
			jumlah_item+=detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah;
			sub_total_field+=detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah * detail_jual_paket_DataStore.getAt(i).data.dpaket_harga * ((100 - detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon)/100);
		}
		jpaket_jumlahField.setValue(jumlah_item);
		jpaket_jumlahLabel.setValue(jumlah_item);
		jpaket_subTotalField.setValue(sub_total_field);
		jpaket_subTotal_cfField.setValue(CurrencyFormatted(sub_total_field));
		jpaket_subTotalLabel.setValue(CurrencyFormatted(sub_total_field));
		total_biaya_field = sub_total_field - voucher_rp_medis_field - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		jpaket_totalField.setValue(total_biaya_field);
		jpaket_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		jpaket_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		total_hutang_field = total_biaya_field - total_bayar_field;
		jpaket_hutangField.setValue(total_hutang_field);
		jpaket_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jpaket_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
		
		console.clear();
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
		var sub_total_biaya_field = jpaket_subTotalField.getValue();
		//var disk_tambahan_field = jpaket_diskonField.getValue();
		var total_bayar_field = jpaket_bayarField.getValue();
		/*if(disk_tambahan_field==''){
			disk_tambahan_field = 0;
		}*/
		var voucher_rp_field = jpaket_cashback_num.getValue();
		var voucher_rp_medis_field = jpaket_cashback_medis_num.getValue();
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		if(voucher_rp_medis_field==''){
			voucher_rp_medis_field = 0;
		}
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		total_biaya_field += sub_total_biaya_field - voucher_rp_medis_field - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		jpaket_totalField.setValue(total_biaya_field);
		jpaket_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		jpaket_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		total_hutang_field = total_biaya_field - total_bayar_field;
		jpaket_hutangField.setValue(total_hutang_field);
		jpaket_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jpaket_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
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
		var total_biaya_field = jpaket_totalField.getValue();
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
		transfer_nilai=jpaket_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=jpaket_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;
		transfer_nilai2=jpaket_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=jpaket_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		transfer_nilai3=jpaket_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=jpaket_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		kwitansi_nilai=jpaket_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=jpaket_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		kwitansi_nilai2=jpaket_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=jpaket_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		kwitansi_nilai3=jpaket_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=jpaket_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		card_nilai=jpaket_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=jpaket_card_nilaiField.getValue();
		else
			card_nilai=0;
		card_nilai2=jpaket_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=jpaket_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		card_nilai3=jpaket_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=jpaket_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		cek_nilai=jpaket_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=jpaket_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		cek_nilai2=jpaket_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=jpaket_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		cek_nilai3=jpaket_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=jpaket_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		voucher_nilai=jpaket_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=jpaket_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		voucher_nilai2=jpaket_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=jpaket_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		voucher_nilai3=jpaket_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=jpaket_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;
		tunai_nilai=jpaket_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=jpaket_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;
		tunai_nilai2=jpaket_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=jpaket_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;
		tunai_nilai3=jpaket_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=jpaket_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;
		total_bayar_field=(transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2
					 +card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2
					 +tunai_nilai3);
		total_bayar_field=(total_bayar_field>0?Math.round(total_bayar_field):0);
		jpaket_bayarField.setValue(total_bayar_field);
		jpaket_bayar_cfField.setValue(CurrencyFormatted(total_bayar_field));
		jpaket_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar_field));
		
		total_hutang_field=total_biaya_field-total_bayar_field;
		total_hutang_field=(total_hutang_field>0?Math.round(total_hutang_field):0);
		jpaket_hutangField.setValue(total_hutang_field);
		jpaket_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jpaket_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
		if(total_bayar_field>total_biaya_field){
			jpaket_pesanLabel.setText("Kelebihan Jumlah Bayar");
		}else if(total_bayar_field<total_biaya_field || total_bayar_field==total_biaya_field){
			jpaket_pesanLabel.setText("");
		}
		if(total_bayar_field==total_biaya_field){
			jpaket_lunasLabel.setText("LUNAS");
		}else if(total_bayar_field!==total_biaya_field){
			jpaket_lunasLabel.setText("");
		}
	}
	//event on update of detail data store
	detail_jual_paket_DataStore.on("update",function(){
		var dcount = detail_jual_paket_DataStore.getCount() - 1;
		for(i=0; i<detail_jual_paket_DataStore.getCount();i++){
			if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket)==false)
			   || detail_jual_paket_DataStore.getAt(i).data.dpaket_paket==undefined
			   || detail_jual_paket_DataStore.getAt(i).data.dpaket_paket==''
			   || detail_jual_paket_DataStore.getAt(i).data.dpaket_paket==0){
				var grid_record = detail_jual_paket_DataStore.getAt(i);
				detail_jual_paket_DataStore.remove(grid_record);
			}
			if(i==dcount){
				load_dstore_jpaket();
			}
		}
	});
	/*jpaket_diskonField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
		load_total_biaya();
	});*/
	jpaket_cashback_cfField.on("keyup",function(){
		var cf_value = jpaket_cashback_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		//jpaket_cashbackField.setValue(cf_tonumber);
		load_total_biaya();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//kwitansi
	jpaket_kwitansi_nilai_cfField.on("keyup",function(){
		var cf_value = jpaket_kwitansi_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>jpaket_kwitansi_sisaField.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = jpaket_kwitansi_sisaField.getValue();
			jpaket_kwitansi_nilaiField.setValue(cf_tonumber);
			load_total_bayar();
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			jpaket_kwitansi_nilaiField.setValue(cf_tonumber);
			load_total_bayar();
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	jpaket_kwitansi_nilai2_cfField.on("keyup",function(){
		var cf_value = jpaket_kwitansi_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>jpaket_kwitansi_sisa2Field.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = jpaket_kwitansi_sisa2Field.getValue();
			jpaket_kwitansi_nilai2Field.setValue(cf_tonumber);
			load_total_bayar();
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			jpaket_kwitansi_nilai2Field.setValue(cf_tonumber);
			load_total_bayar();
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	jpaket_kwitansi_nilai3_cfField.on("keyup",function(){
		var cf_value = jpaket_kwitansi_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		if(cf_tonumber>jpaket_kwitansi_sisa3Field.getValue()){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			cf_tonumber = jpaket_kwitansi_sisa3Field.getValue();
			jpaket_kwitansi_nilai3Field.setValue(cf_tonumber);
			load_total_bayar();
			var number_tocf = CurrencyFormatted(cf_tonumber);
			this.setRawValue(number_tocf);
		}else{
			jpaket_kwitansi_nilai3Field.setValue(cf_tonumber);
			load_total_bayar();
			var number_tocf = CurrencyFormatted(cf_value);
			this.setRawValue(number_tocf);
		}
	});
	//card
	jpaket_card_nilai_cfField.on("keyup",function(){
		var cf_value = jpaket_card_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_card_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_card_nilai2_cfField.on("keyup",function(){
		var cf_value = jpaket_card_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_card_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_card_nilai3_cfField.on("keyup",function(){
		var cf_value = jpaket_card_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_card_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//cek/giro
	jpaket_cek_nilai_cfField.on("keyup",function(){
		var cf_value = jpaket_cek_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_cek_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_cek_nilai2_cfField.on("keyup",function(){
		var cf_value = jpaket_cek_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_cek_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_cek_nilai3_cfField.on("keyup",function(){
		var cf_value = jpaket_cek_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_cek_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//transfer
	jpaket_transfer_nilai_cfField.on("keyup",function(){
		var cf_value = jpaket_transfer_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_transfer_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_transfer_nilai2_cfField.on("keyup",function(){
		var cf_value = jpaket_transfer_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_transfer_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_transfer_nilai3_cfField.on("keyup",function(){
		var cf_value = jpaket_transfer_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_transfer_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	//voucher
	jpaket_voucher_cashbackField.on("keyup",function(){if(jpaket_post2db=="CREATE"){load_total_bayar();}else if(jpaket_post2db=="UPDATE"){load_total_bayar_updating();}});
	jpaket_voucher_cashback2Field.on("keyup",function(){if(jpaket_post2db=="CREATE"){load_total_bayar();}else if(jpaket_post2db=="UPDATE"){load_total_bayar_updating();}});
	jpaket_voucher_cashback3Field.on("keyup",function(){if(jpaket_post2db=="CREATE"){load_total_bayar();}else if(jpaket_post2db=="UPDATE"){load_total_bayar_updating();}});
	//tunai
	jpaket_tunai_nilai_cfField.on("keyup",function(){
		var cf_value = jpaket_tunai_nilai_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_tunai_nilaiField.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_tunai_nilai2_cfField.on("keyup",function(){
		var cf_value = jpaket_tunai_nilai2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_tunai_nilai2Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_tunai_nilai3_cfField.on("keyup",function(){
		var cf_value = jpaket_tunai_nilai3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_tunai_nilai3Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_voucher_cashback_cfField.on("keyup",function(){
		var cf_value = jpaket_voucher_cashback_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_voucher_cashbackField.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_voucher_cashback2_cfField.on("keyup",function(){
		var cf_value = jpaket_voucher_cashback2_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_voucher_cashback2Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	jpaket_voucher_cashback3_cfField.on("keyup",function(){
		var cf_value = jpaket_voucher_cashback3_cfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		jpaket_voucher_cashback3Field.setValue(cf_tonumber);
		load_total_bayar();
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
	});
	
	//jpaket_caraField.on("select",update_group_carabayar_jual_paket);
	//jpaket_cara2Field.on("select",update_group_carabayar2_jual_paket);
	//jpaket_cara3Field.on("select",update_group_carabayar3_jual_paket);
	
	/*Sistem baru, dimana setiap kali user mengganti cara bayar, maka akan meng-reset ulang total perhitungan, hal ini dilakukan agar tidak terjadi bug(cara bayar sudah diisi nominal,lalu diganti ke cara bayar lain, lalu sudah mengurangi total biaya dan mengisi total bayar, sehingga ketika di save / print maka total bayar / total biaya sudah terakumulasi, namun cara bayarnya masih 0 (ditabel jual2 masih 0). Coba nyalakan comment diatas utk membuktikan bug tersebut */
	jpaket_caraField.on("select",function(){
		update_group_carabayar_jual_paket();
		load_total_biaya();
		load_total_bayar();
		load_dstore_jpaket();
	});
	jpaket_cara2Field.on("select",function(){
		update_group_carabayar2_jual_paket();
		load_total_biaya();
		load_total_bayar();
		load_dstore_jpaket();
	});
	jpaket_cara3Field.on("select",function(){
		update_group_carabayar3_jual_paket();
		load_total_biaya();
		load_total_bayar();
		load_dstore_jpaket();
	});
	
	jpaket_custField.on("select",function(){
		load_membership();
		j=memberDataStore.findExact('member_cust',jpaket_custField.getValue(),0);
		if(j>-1){
			jpaket_cust_nomemberField.setValue(memberDataStore.getAt(j).member_no);
			jpaket_valid_memberField.setValue(memberDataStore.getAt(j).member_valid);
			jpaket_cust_ultahField.setValue(memberDataStore.getAt(j).cust_tgllahir);
			
		}
		else{
			jpaket_cust_nomemberField.setValue("");
			jpaket_valid_memberField.setValue("");
			jpaket_cust_ultahField.setValue("");
		}
		cbo_cust=cbo_cust_jual_paket_DataStore.findExact('cust_id',jpaket_custField.getValue(),0);
		if(cbo_cust>-1){
			cbo_kwitansi_jual_paket_DataStore.load({params: {kwitansi_cust: cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_id}});
			jpaket_cek_namaField.setValue(cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_nama);
			jpaket_cek_nama2Field.setValue(cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_nama);
			jpaket_cek_nama3Field.setValue(cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_nama);
			jpaket_transfer_namaField.setValue(cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_nama);
			jpaket_transfer_nama2Field.setValue(cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_nama);
			jpaket_transfer_nama3Field.setValue(cbo_cust_jual_paket_DataStore.getAt(cbo_cust).data.cust_nama);
		}
	});
	function show_windowGrid(){
		master_jual_paket_DataStore.load({
			params: {start: 0, limit: jpaket_pageS},
			callback: function(opts, success, response){
				if(success){
					master_jual_paket_createWindow.show();
				}
			}
		});	// load DataStore
	}
	var detail_tab_jual_paket = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [detail_jual_paketListEditorGrid,detail_pengguna_paketListEditorGrid]
	});
	/* Function for retrieve create Window Panel*/ 
	master_jual_paket_createForm = new Ext.FormPanel({
		title: 'Penjualan Paket',
		labelAlign: 'left',
		el: 'form_paket_addEdit',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1220,	//940,	//950,
		frame:true,
		layout: 'fit',
		items: [master_jual_paket_masterGroup,detail_tab_jual_paket,master_jual_paket_bayarGroup],
		buttons: [
			{
				text: '<span style="font-weight:bold">Lihat Daftar</span>',
				handler: show_windowGrid
			},
			{
				text: 'Print Only',
				ref: '../jpaket_printonly',
				handler: print_only
			},
			{
				text: 'Print Only 2',
				ref: '../jpaket_printonly2',
				handler: print_only2
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			,
			{
				id: 'jpaket_save_pemakai',
				text: 'Save Pemakai',
				handler: function(){
					detail_pengguna_paket_insert();
					Ext.MessageBox.alert('OK','Nama Pemakai Paket berhasil disimpan');
				}
			}
			<?php } ?>
			,
			{
				xtype:'spacer',
				width: 500
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALPAKET'))){ ?>
			,
			{
				text: 'Save and Print 2',
				ref: '../jpaketsavePrintButton2',
				handler: save_andPrint2
			},
			{
				text: 'Save and Print',
				ref: '../jpaketSavePrintButton',
				handler: save_andPrint
			},
			{
				text: 'Save',
				handler: save_paket
			},
			{
				id: 'jpaket_cancelBtn',
				text: 'Cancel',
				handler: jpaket_btn_cancel
			}
			<?php } ?>
		]
	});
	/* End  of Function*/
	/* Function for retrieve create Window Form */
	master_jual_paket_createWindow= new Ext.Window({
		id: 'master_jual_paket_createWindow',
		title: 'Daftar Penjualan Paket',
		closable:true,
		closeAction: 'hide',
		width: 1200,	//810,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_jual_paket_create',
		items: master_jual_paketListEditorGrid
	});
	/* End Window */
	/* Function for action list search */
	function master_jual_paket_list_search(){
		var jpaket_nobukti_search=null;
		var jpaket_cust_search=null;
		var jpaket_tanggal_search_date="";
		var jpaket_tanggal_akhir_search_date="";
		var jpaket_diskon_search=null;
		var jpaket_cara_search=null;
		var jpaket_keterangan_search=null;
		var jpaket_stat_dok_search=null;
		if(jpaket_nobuktiSearchField.getValue()!==null){jpaket_nobukti_search=jpaket_nobuktiSearchField.getValue();}
		if(jpaket_custSearchField.getValue()!==null){jpaket_cust_search=jpaket_custSearchField.getValue();}
		if(jpaket_tanggalSearchField.getValue()!==""){jpaket_tanggal_search_date=jpaket_tanggalSearchField.getValue().format('Y-m-d');}
		if(jpaket_tanggal_akhirSearchField.getValue()!==""){jpaket_tanggal_akhir_search_date=jpaket_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(jpaket_diskonSearchField.getValue()!==null){jpaket_diskon_search=jpaket_diskonSearchField.getValue();}
		if(jpaket_caraSearchField.getValue()!==null){jpaket_cara_search=jpaket_caraSearchField.getValue();}
		if(jpaket_keteranganSearchField.getValue()!==null){jpaket_keterangan_search=jpaket_keteranganSearchField.getValue();}
		if(jpaket_stat_dokSearchField.getValue()!==null){jpaket_stat_dok_search=jpaket_stat_dokSearchField.getValue();}
		master_jual_paket_DataStore.baseParams = {
			task: 'SEARCH',
			jpaket_nobukti	:	jpaket_nobukti_search,
			jpaket_cust	:	jpaket_cust_search,
			jpaket_tanggal	:	jpaket_tanggal_search_date,
			jpaket_tanggal_akhir	:	jpaket_tanggal_akhir_search_date,
			jpaket_diskon	:	jpaket_diskon_search,
			jpaket_cara	:	jpaket_cara_search,
			jpaket_keterangan	:	jpaket_keterangan_search,
			jpaket_stat_dok	:	jpaket_stat_dok_search,
		};
		master_jual_paket_DataStore.reload({params: {start: 0, limit: jpaket_pageS}});
	}
	/* Function for reset search result */
	function master_jual_paket_reset_search(){
		master_jual_paket_DataStore.baseParams = { task: 'LIST' };
		master_jual_paket_DataStore.reload({params: {start: 0, limit: jpaket_pageS}});
		//master_jual_paket_searchWindow.close();
	};
	/* End of Fuction */
	function master_jual_paket_reset_SearchForm(){
		jpaket_nobuktiSearchField.reset();
		jpaket_custSearchField.reset();
		jpaket_tanggalSearchField.reset();
		jpaket_tanggal_akhirSearchField.reset();
		jpaket_tanggal_akhirSearchField.setValue(today);
		jpaket_diskonSearchField.reset();
		jpaket_caraSearchField.reset();
		jpaket_keteranganSearchField.reset();
		jpaket_stat_dokSearchField.reset();
	}
	/* Field for search */
	/* Identify  jpaket_id Search Field */
	jpaket_idSearchField= new Ext.form.NumberField({
		id: 'jpaket_idSearchField',
		fieldLabel: 'Jpaket Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jpaket_nobukti Search Field */
	jpaket_nobuktiSearchField= new Ext.form.TextField({
		id: 'jpaket_nobuktiSearchField',
		fieldLabel: 'No Faktur',
		maxLength: 30,
	});
	/* Identify  jpaket_cust Search Field */
	jpaket_custSearchField= new Ext.form.ComboBox({
		id: 'jpaket_custSearchField',
		fieldLabel: 'Customer',
		store: cbo_cust_jual_paket_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_paket_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  jpaket_tanggal Search Field */
	jpaket_tanggalSearchField= new Ext.form.DateField({
		id: 'jpaket_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE
	});
	jpaket_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'jpaket_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE	
	});
	/* Identify  jpaket_diskon Search Field */
	jpaket_diskonSearchField= new Ext.form.NumberField({
		id: 'jpaket_diskonSearchField',
		fieldLabel: 'Diskon',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jpaket_cara Search Field */
	jpaket_caraSearchField= new Ext.form.ComboBox({
		id: 'jpaket_caraSearchField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jpaket_cara'],
			data:[['tunai','Tunai'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jpaket_cara',
		valueField: 'value',
		anchor: '45%',
		triggerAction: 'all'	 
	});
	/* Identify  jpaket_keterangan Search Field */
	jpaket_keteranganSearchField= new Ext.form.TextArea({
		id: 'jpaket_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	jpaket_stat_dokSearchField= new Ext.form.ComboBox({
		id: 'jpaket_stat_dokSearchField',
		fieldLabel: 'Status Dokumen',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jpaket_stat_dok'],
			data:[['Terbuka','Terbuka'], ['Tertutup','Tertutup'], ['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'jpaket_stat_dok',
		valueField: 'value',
		width: 96,
		triggerAction: 'all'	 	
	});
	/* Function for retrieve search Form Panel */
	master_jual_paket_searchForm = new Ext.FormPanel({
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
				items: [jpaket_nobuktiSearchField, jpaket_custSearchField, 
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
								jpaket_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								jpaket_tanggal_akhirSearchField
							]
						}							
				        ]
					},	
				jpaket_caraSearchField, jpaket_keteranganSearchField, jpaket_stat_dokSearchField] 
			}
			]
		}],
		buttons: [{
				text: 'Search',
				handler: master_jual_paket_list_search
			},{
				text: 'Close',
				handler: function(){
					master_jual_paket_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_jual_paket_searchWindow = new Ext.Window({
		title: 'Pencarian Penjualan Paket',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_jual_paket_search',
		items: master_jual_paket_searchForm
	});
    /* End of Function */ 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_jual_paket_searchWindow.isVisible()){
			master_jual_paket_reset_SearchForm();
			master_jual_paket_searchWindow.show();
		} else {
			master_jual_paket_searchWindow.toFront();
		}
	}
  	/* End Function */
	/* Function for print List Grid */
	function master_jual_paket_print(){
		var searchquery = "";
		var jpaket_nobukti_print=null;
		var jpaket_cust_print=null;
		var jpaket_tanggal_print_date="";
		var jpaket_tanggal_akhir_print_date="";
		var jpaket_diskon_print=null;
		var jpaket_cara_print=null;
		var jpaket_keterangan_print=null;
		var jpaket_stat_dok_print=null;
		var win;              
		if(master_jual_paket_DataStore.baseParams.query!==null){searchquery = master_jual_paket_DataStore.baseParams.query;}
		if(master_jual_paket_DataStore.baseParams.jpaket_nobukti!==null){jpaket_nobukti_print = master_jual_paket_DataStore.baseParams.jpaket_nobukti;}
		if(master_jual_paket_DataStore.baseParams.jpaket_cust!==null){jpaket_cust_print = master_jual_paket_DataStore.baseParams.jpaket_cust;}
		if(master_jual_paket_DataStore.baseParams.jpaket_tanggal!==""){jpaket_tanggal_print_date = master_jual_paket_DataStore.baseParams.jpaket_tanggal;}
		if(master_jual_paket_DataStore.baseParams.jpaket_tanggal_akhir!==""){jpaket_tanggal_akhir_print_date = master_jual_paket_DataStore.baseParams.jpaket_tanggal_akhir;}
		if(master_jual_paket_DataStore.baseParams.jpaket_diskon!==null){jpaket_diskon_print = master_jual_paket_DataStore.baseParams.jpaket_diskon;}
		if(master_jual_paket_DataStore.baseParams.jpaket_cara!==null){jpaket_cara_print = master_jual_paket_DataStore.baseParams.jpaket_cara;}
		if(master_jual_paket_DataStore.baseParams.jpaket_keterangan!==null){jpaket_keterangan_print = master_jual_paket_DataStore.baseParams.jpaket_keterangan;}
		if(master_jual_paket_DataStore.baseParams.jpaket_stat_dok!==null){jpaket_stat_dok_print = master_jual_paket_DataStore.baseParams.jpaket_stat_dok;}
		Ext.Ajax.request({   
		waitMsg: 'Mohon  Tunggu...',
		url: 'index.php?c=c_master_jual_paket&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			jpaket_nobukti	:	jpaket_nobukti_print,
			jpaket_cust	:	jpaket_cust_print,
			jpaket_tanggal	:	jpaket_tanggal_print_date,
			jpaket_tanggal_akhir	:	jpaket_tanggal_akhir_print_date,
			jpaket_diskon	:	jpaket_diskon_print,
			jpaket_cara	:	jpaket_cara_print,
			jpaket_keterangan	:	jpaket_keterangan_print,
			jpaket_stat_dok	:	jpaket_stat_dok_print,
		  	currentlisting: master_jual_paket_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/master_jual_paketlist.html','master_jual_paketlist','height=400,width=900,resizable=1,scrollbars=1, menubar=1');
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
	function master_jual_paket_export_excel(){
		var searchquery = "";
		var jpaket_nobukti_2excel=null;
		var jpaket_cust_2excel=null;
		var jpaket_tanggal_2excel_date="";
		var jpaket_tanggal_akhir_2excel_date="";
		var jpaket_diskon_2excel=null;
		var jpaket_cara_2excel=null;
		var jpaket_keterangan_2excel=null;
		var jpaket_stat_dok_2excel=null;
		var win;              
		if(master_jual_paket_DataStore.baseParams.query!==null){searchquery = master_jual_paket_DataStore.baseParams.query;}
		if(master_jual_paket_DataStore.baseParams.jpaket_nobukti!==null){jpaket_nobukti_2excel = master_jual_paket_DataStore.baseParams.jpaket_nobukti;}
		if(master_jual_paket_DataStore.baseParams.jpaket_cust!==null){jpaket_cust_2excel = master_jual_paket_DataStore.baseParams.jpaket_cust;}
		if(master_jual_paket_DataStore.baseParams.jpaket_tanggal!==""){jpaket_tanggal_2excel_date = master_jual_paket_DataStore.baseParams.jpaket_tanggal;}
		if(master_jual_paket_DataStore.baseParams.jpaket_tanggal_akhir!==""){jpaket_tanggal_akhir_2excel_date = master_jual_paket_DataStore.baseParams.jpaket_tanggal_akhir;}
		if(master_jual_paket_DataStore.baseParams.jpaket_diskon!==null){jpaket_diskon_2excel = master_jual_paket_DataStore.baseParams.jpaket_diskon;}
		if(master_jual_paket_DataStore.baseParams.jpaket_cara!==null){jpaket_cara_2excel = master_jual_paket_DataStore.baseParams.jpaket_cara;}
		if(master_jual_paket_DataStore.baseParams.jpaket_keterangan!==null){jpaket_keterangan_2excel = master_jual_paket_DataStore.baseParams.jpaket_keterangan;}
		if(master_jual_paket_DataStore.baseParams.jpaket_stat_dok!==null){jpaket_stat_dok_2excel = master_jual_paket_DataStore.baseParams.jpaket_stat_dok;}
		Ext.Ajax.request({   
		waitMsg: 'Mohon  Tunggu...',
		url: 'index.php?c=c_master_jual_paket&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			jpaket_nobukti	:	jpaket_nobukti_2excel,
			jpaket_cust	:	jpaket_cust_2excel,
			jpaket_tanggal	:	jpaket_tanggal_2excel_date,
			jpaket_tanggal_akhir	:	jpaket_tanggal_akhir_2excel_date,
			jpaket_diskon	:	jpaket_diskon_2excel,
			jpaket_cara	:	jpaket_cara_2excel,
			jpaket_keterangan	:	jpaket_keterangan_2excel,
			jpaket_stat_dok	:	jpaket_stat_dok_2excel,
		  	currentlisting: master_jual_paket_DataStore.baseParams.task // this tells us if we are searching or not
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
	function jpaket_btn_cancel(){
		master_jual_paket_reset_form();
		jpaket_caraField.setValue("card");
		master_jual_paket_cardGroup.setVisible(true);
		master_cara_bayarTabPanel.setActiveTab(0);
		//jpaket_diskonField.setValue(0);
		//jpaket_cashbackField.setValue(0);
		jpaket_pesanLabel.setText('');
		jpaket_lunasLabel.setText('');
		jpaket_cust_priorityLabel.setText('');
	}
	function pertamax(){
		jpaket_post2db="CREATE";
		jpaket_tanggalField.setValue(dt.format('Y-m-d'));
		jpaket_stat_dokField.setValue('Terbuka');
		master_jual_paket_createForm.render();
		jpaket_caraField.setValue('card');
		master_jual_paket_cardGroup.setVisible(true);
	}
	pertamax();
	
	Ext.Ajax.request({
			url: 'index.php?c=c_master_jual_paket&m=get_info_pajak',
			timeout: 60000,
			success: function(response){
				var result=eval(response.responseText);
			switch(result){
			case 1 :
				// kondisi pajak
				master_jual_paket_createForm.jpaketsavePrintButton2.show();
				master_jual_paket_createForm.jpaket_printonly2.show();
				master_jual_paket_createForm.jpaketSavePrintButton.hide();
				master_jual_paket_createForm.jpaket_printonly.hide();
				master_jual_paket_createForm.jpaket_printonly.disable();
				detail_jual_paket_ColumnModel.setHidden(6, false);
				detail_jual_paket_ColumnModel.setHidden(11, false);
				master_jual_paket_ColumnModel.setHidden(3, false);
				break;
			default :
				// kondisi non pajak
				master_jual_paket_createForm.jpaketsavePrintButton2.hide();
				master_jual_paket_createForm.jpaket_printonly2.hide();
				master_jual_paket_createForm.jpaketSavePrintButton.show();
				master_jual_paket_createForm.jpaket_printonly.show();
				master_jual_paket_createForm.jpaket_printonly.disable();
				detail_jual_paket_ColumnModel.setHidden(6, true);
				detail_jual_paket_ColumnModel.setHidden(11, true);
				master_jual_paket_ColumnModel.setHidden(3, true);
				break;
			};
			}
		});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_jual_paket"></div>
        <div id="fp_detail_jual_paket"></div>
		<div id="fp_detail_pengguna_paket"></div>
		<div id="elwindow_master_jual_paket_create"></div>
        <div id="elwindow_master_jual_paket_search"></div>
        <div id="form_paket_addEdit"></div>
    </div>
</div>
</body>