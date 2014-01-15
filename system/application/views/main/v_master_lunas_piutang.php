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
var master_lunas_piutang_DataStore;
var master_lunas_piutang_ColumnModel;
var master_lunas_piutangListEditorGrid;
var master_lunas_piutang_createForm;
var master_lunas_piutang_createWindow;
var master_lunas_piutang_searchForm;
var master_lunas_piutang_searchWindow;
var master_lunas_piutang_SelectedRow;
var master_lunas_piutang_ContextMenu;
//for detail data
var detail_fpiutang_bylp_DataStore;
var detail_fpiutangListEditorGrid;
var detail_fpiutang_ColumnModel;
var detail_fpiutang_proxy;
var detail_fpiutang_writer;
var detail_fpiutang_reader;
var editor_detail_fpiutang;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';
//declare konstant
var fpiutang_post2db = '';
var msg = '';
var fpiutang_pageS=15;
var cetak_lp=0;
var acc_group=<?=$_SESSION[SESSION_GROUPID];?>;
var stat='ADD';
/* declare variable here for Field*/
var fpiutang_idField;
var fpiutang_nobuktiField;
var fpiutang_customerField;
var fpiutang_tanggalField;
var fpiutang_keteranganField;
var fpiutang_idSearchField;
var fpiutang_noSearchField;
var fpiutang_tanggalSearchField;
var fpiutang_tanggal_akhirSearchField;
var fpiutang_carabayarSearchField;
var fpiutang_keteranganSearchField;
var fpiutang_statusSearchField;
var detail_fpiutang_bylp_DataStore;

var fpiutang_cek_bankField;
var fpiutang_transfer_bankField;

var dt = new Date();
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	function fpiutang_cetak(master_id){
		Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_lunas_piutang&m=print_paper',
			params: { fpiutang_id : master_id}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./fpiutang_paper.html','Cetak Pelunasan Piutang','height=480,width=1340,resizable=1,scrollbars=0, menubar=0');
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
		var fpiutang_tanggal_create_date = "";
		if(fpiutang_tanggalField.getValue()!== ""){
			fpiutang_tanggal_create_date = fpiutang_tanggalField.getValue().format('Y-m-d');
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_master_lunas_piutang&m=get_action',
				params: {
					task: "CEK",
					tanggal_pengecekan	: fpiutang_tanggal_create_date
				}, 
				success: function(response){							
					var result=eval(response.responseText);
					switch(result){
						case 1:
							cetak_lp=1;
							master_lunas_piutang_create('print');
						break;
						default:
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Data Pelunasan Piutang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARNING,
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
		}else{
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal tidak boleh kosong.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	
	/*Function for pengecekan _dokumen untuk save */
	function pengecekan_dokumen2(){
		var fpiutang_tanggal_create_date = "";
		if(fpiutang_tanggalField.getValue()!== ""){
			fpiutang_tanggal_create_date = fpiutang_tanggalField.getValue().format('Y-m-d');
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_master_lunas_piutang&m=get_action',
				params: {
					task: "CEK",
					tanggal_pengecekan	: fpiutang_tanggal_create_date
				}, 
				success: function(response){							
					var result=eval(response.responseText);
					switch(result){
						case 1:
							master_lunas_piutang_create();
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Pelunasan Piutang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
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
		}else{
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal tidak boleh kosong.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}  
	}
	
  
  	/* Function for add data, open window create form */
	function master_lunas_piutang_create(opsi){
		
		if(fpiutang_customerField.getValue()==0){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Customer belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			
		}else if(detail_fpiutang_bylp_DataStore.getCount()<1){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		} else if(is_master_lunas_piutang_form_valid()){
			if(((/^\d+$/.test(fpiutang_customerField.getValue()) && fpiutang_post2db=="CREATE") || fpiutang_post2db=="UPDATE")
			   && (fpiutang_stat_dokField.getValue()=='Terbuka')){
				
				/*
				 * DATA-DATA MASTER
				*/
				var fpiutang_id_create_pk=0;
				var fpiutang_no_create='';
				var fpiutang_cust_create='';
				var fpiutang_tanggal_create_date='';
				var fpiutang_keterangan_create='';
				var fpiutang_status_create='';
				var fpiutang_cara_create='';
				
				//bayar
				var fpiutang_bayar_create=0;
				
				//kwitansi
				var fpiutang_kwitansi_nama_create="";
				var fpiutang_kwitansi_nomor_create="";
				//card
				var fpiutang_card_nama_create="";
				var fpiutang_card_edc_create="";
				var fpiutang_card_no_create="";
				//cek
				var fpiutang_cek_nama_create="";
				var fpiutang_cek_nomor_create="";
				var fpiutang_cek_valid_create="";
				var fpiutang_cek_bank_create="";
				//transfer
				var fpiutang_transfer_bank_create="";
				var fpiutang_transfer_nama_create="";
				
				if((fpiutang_idField.getValue()!==null) && (fpiutang_idField.getValue()!==0) && (fpiutang_idField.getValue()!=='')){fpiutang_id_create_pk = fpiutang_idField.getValue();}else{fpiutang_id_create_pk=get_pk_id();} 
				if((fpiutang_nobuktiField.getValue()!==null) && (fpiutang_nobuktiField.getValue()!=='')){fpiutang_no_create = fpiutang_nobuktiField.getValue();}
				if((fpiutang_customerField.getValue()!==null) && (fpiutang_customerField.getValue()!=='') && (fpiutang_post2db=="CREATE")){
					fpiutang_cust_create = fpiutang_customerField.getValue();
				}else if(fpiutang_post2db=="UPDATE"){
					fpiutang_cust_create = fpiutang_customer_idField.getValue();
				}
				if((fpiutang_tanggalField.getValue()!==null) && (fpiutang_tanggalField.getValue()!=='')){fpiutang_tanggal_create_date = fpiutang_tanggalField.getValue().format('Y-m-d');} 
				if((fpiutang_keteranganField.getValue()!==null) && (fpiutang_keteranganField.getValue()!=='')){fpiutang_keterangan_create = fpiutang_keteranganField.getValue();} 
				if((fpiutang_stat_dokField.getValue()!==null) && (fpiutang_stat_dokField.getValue()!=='')){fpiutang_status_create = fpiutang_stat_dokField.getValue();}
				if((fpiutang_caraField.getValue()!==null) && (fpiutang_caraField.getValue()!=='')){fpiutang_cara_create = fpiutang_caraField.getValue();}
				
				//bayar
				if((fpiutang_bayarField.getValue()!==null) && (fpiutang_bayarField.getValue()!==0) && (fpiutang_bayarField.getValue()!=='')){fpiutang_bayar_create = fpiutang_bayarField.getValue();}
				//kwitansi value
				if((fpiutang_kwitansi_noField.getValue()!=="") && (fpiutang_post2db=='CREATE')){
					fpiutang_kwitansi_nomor_create = fpiutang_kwitansi_noField.getValue();
				}else if(fpiutang_post2db=='UPDATE'){
					fpiutang_kwitansi_nomor_create = fpiutang_kwitansi_idField.getValue();
				}
				if(fpiutang_kwitansi_namaField.getValue()!== ""){fpiutang_kwitansi_nama_create = fpiutang_kwitansi_namaField.getValue();} 
				//card value
				if(fpiutang_card_namaField.getValue()!== ""){fpiutang_card_nama_create = fpiutang_card_namaField.getValue();} 
				if(fpiutang_card_edcField.getValue()!==""){fpiutang_card_edc_create = fpiutang_card_edcField.getValue();} 
				if(fpiutang_card_noField.getValue()!==""){fpiutang_card_no_create = fpiutang_card_noField.getValue();}
				//cek value
				if(fpiutang_cek_namaField.getValue()!== ""){fpiutang_cek_nama_create = fpiutang_cek_namaField.getValue();} 
				if(fpiutang_cek_noField.getValue()!== ""){fpiutang_cek_nomor_create = fpiutang_cek_noField.getValue();} 
				if(fpiutang_cek_validField.getValue()!== ""){fpiutang_cek_valid_create = fpiutang_cek_validField.getValue().format('Y-m-d');} 
				if(fpiutang_cek_bankField.getValue()!== ""){fpiutang_cek_bank_create = fpiutang_cek_bankField.getValue();} 
				//transfer value
				if(fpiutang_transfer_bankField.getValue()!== ""){fpiutang_transfer_bank_create = fpiutang_transfer_bankField.getValue();} 
				if(fpiutang_transfer_namaField.getValue()!== ""){fpiutang_transfer_nama_create = fpiutang_transfer_namaField.getValue();}
				
				/*
				 * DATA-DATA DETAIL
				*/
				var dpiutang_id = [];
				var lpiutang_id = [];
				var dpiutang_nilai = [];
				var dpiutang_keterangan = [];
				
				var dcount = detail_fpiutang_bylp_DataStore.getCount() - 1;
				
				for(i=0; i<detail_fpiutang_bylp_DataStore.getCount(); i++){
					if((/^\d+$/.test(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_id))
					   && detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_id!==undefined
					   && detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_id!==''
					   && detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_id!==0){
						
						dpiutang_id.push(detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_id);
						
						lpiutang_id.push(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_id);
						
						if((detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_nilai==undefined)
						   || (detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_nilai=='')){
							dpiutang_nilai.push(0);
						}else{
							dpiutang_nilai.push(detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_nilai);
						}
						
						if((detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_keterangan==undefined)){
							dpiutang_keterangan.push('');
						}else{
							dpiutang_keterangan.push(detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_keterangan);
						}
					}
					
					if(i==dcount){
						var encoded_array_dpiutang_id = Ext.encode(dpiutang_id);
						var encoded_array_lpiutang_id = Ext.encode(lpiutang_id);
						var encoded_array_dpiutang_nilai = Ext.encode(dpiutang_nilai);
						var encoded_array_dpiutang_keterangan = Ext.encode(dpiutang_keterangan);
						
						Ext.Ajax.request({  
							waitMsg: 'Mohon tunggu...',
							url: 'index.php?c=c_master_lunas_piutang&m=get_action',
							params: {
								task				: fpiutang_post2db,
								fpiutang_id			: fpiutang_id_create_pk, 
								fpiutang_no			: fpiutang_no_create,
								fpiutang_cust		: fpiutang_cust_create,
								fpiutang_tanggal	: fpiutang_tanggal_create_date,
								fpiutang_keterangan	: fpiutang_keterangan_create,
								fpiutang_status		: fpiutang_status_create,
								fpiutang_cara		: fpiutang_cara_create, 
								fpiutang_bayar		: fpiutang_bayar_create,
								//kwitansi posting
								fpiutang_kwitansi_no		:	fpiutang_kwitansi_nomor_create,
								fpiutang_kwitansi_nama		:	fpiutang_kwitansi_nama_create,
								//card posting
								fpiutang_card_nama	: 	fpiutang_card_nama_create,
								fpiutang_card_edc	:	fpiutang_card_edc_create,
								fpiutang_card_no		:	fpiutang_card_no_create,
								//cek posting
								fpiutang_cek_nama	: 	fpiutang_cek_nama_create,
								fpiutang_cek_no		:	fpiutang_cek_nomor_create,
								fpiutang_cek_valid	: 	fpiutang_cek_valid_create,
								fpiutang_cek_bank	:	fpiutang_cek_bank_create,
								//transfer posting
								fpiutang_transfer_bank	:	fpiutang_transfer_bank_create,
								fpiutang_transfer_nama	:	fpiutang_transfer_nama_create,
								cetak_lp 	: cetak_lp,
								
								//DATA DETAIL
								dpiutang_id: encoded_array_dpiutang_id,
								lpiutang_id: encoded_array_lpiutang_id,
								dpiutang_nilai: encoded_array_dpiutang_nilai,
								dpiutang_keterangan: encoded_array_dpiutang_keterangan
							}, 
							success: function(response){
								var result=eval(response.responseText);
								if(result==0){
									Ext.MessageBox.alert(fpiutang_post2db+' OK','Data Pelunasan Piutang berhasil disimpan');
									master_lunas_piutang_createWindow.hide();
									master_lunas_piutang_DataStore.reload();
									fpiutang_btn_cancel();
								}else if(result>0){
									fpiutang_cetak(result);
									Ext.MessageBox.alert(fpiutang_post2db+' OK','Data Pelunasan Piutang berhasil disimpan');
									master_lunas_piutang_createWindow.hide();
									master_lunas_piutang_DataStore.reload();
									fpiutang_btn_cancel();
								}else{
									Ext.MessageBox.show({
									   title: 'Warning',
									   msg: 'Data Pelunasan Piutang tidak bisa disimpan',
									   buttons: Ext.MessageBox.OK,
									   animEl: 'save',
									   icon: Ext.MessageBox.WARNING
									});
									master_lunas_piutang_DataStore.reload();
									fpiutang_btn_cancel();
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
								master_lunas_piutang_DataStore.reload();
								fpiutang_btn_cancel();
							}                      
						});
					}
				}
			}else if(fpiutang_post2db=='UPDATE' && fpiutang_stat_dokField.getValue()=='Tertutup'){
				if(cetak_lp==1){
					fpiutang_cetak(get_pk_id());
					cetak_lp=0;
				}
				fpiutang_btn_cancel();
			}else if(fpiutang_post2db=='UPDATE' && fpiutang_stat_dokField.getValue()=='Batal'){
				Ext.Ajax.request({  
					waitMsg: 'Mohon  Tunggu...',
					url: 'index.php?c=c_master_lunas_piutang&m=get_action',
					params: {
						task: 'BATAL',
						fpiutang_id	: fpiutang_idField.getValue(),
						fpiutang_tanggal : fpiutang_tanggalField.getValue().format('Y-m-d')
					}, 
					success: function(response){             
						var result=eval(response.responseText);
						if(result==1){
							fpiutang_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Dokumen Pelunasan Piutang telah dibatalkan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.OK
							});
							master_lunas_piutang_createWindow.hide();
							master_lunas_piutang_DataStore.reload();
							fpiutang_btn_cancel();
						}else{
							fpiutang_post2db='CREATE';
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 400,
							   msg: 'Dokumen Pelunasan Piutang tidak bisa dibatalkan, <br/>karena yang boleh dibatalkan adalah Dokumen yang terbit hari ini saja.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							master_lunas_piutang_createWindow.hide();
							master_lunas_piutang_DataStore.reload();
							fpiutang_btn_cancel();
						}
					},
					failure: function(response){
						fpiutang_post2db='CREATE';
						var result=response.responseText;
						Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
						});
						master_lunas_piutang_createWindow.hide();
						master_lunas_piutang_DataStore.reload();
						fpiutang_btn_cancel();
					}                      
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
		if(fpiutang_post2db=='UPDATE')
			return master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_id');
		else if(fpiutang_post2db=='CREATE')
			return fpiutang_idField.getValue();
		else 
			return -1;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function master_lunas_piutang_reset_form(){
		fpiutang_idField.reset();
		fpiutang_idField.setValue(null);
		fpiutang_nobuktiField.reset();
		fpiutang_nobuktiField.setValue(null);
		fpiutang_customerField.reset();
		fpiutang_customerField.setValue(null);
		fpiutang_tanggalField.setValue(today);
		fpiutang_keteranganField.reset();
		fpiutang_keteranganField.setValue(null);
		fpiutang_stat_dokField.reset();
		fpiutang_stat_dokField.setValue('Terbuka');
		fpiutang_totalField.reset();
		fpiutang_totalField.setValue(0);
		fpiutang_total_cfField.reset();
		fpiutang_total_cfField.setValue(0);
		fpiutang_bayarField.reset();
		fpiutang_bayarField.setValue(0);
		fpiutang_bayar_cfField.reset();
		fpiutang_bayar_cfField.setValue(0);
		fpiutang_sisaField.reset();
		fpiutang_sisaField.setValue(0);
		fpiutang_sisa_cfField.reset();
		fpiutang_sisa_cfField.setValue(0);
		fpiutang_nocustField.reset();
		fpiutang_nocustField.setValue(null);
		
		detail_fpiutang_bAdd.setDisabled(false);
		detail_fpiutang_bDel.setDisabled(false);
		
		kwitansi_fpiutang_reset_form();
		card_fpiutang_reset_form();
		cek_fpiutang_reset_form();
		transfer_fpiutang_reset_form();
		
		fpiutang_caraField.setDisabled(false);
		master_lunas_piutang_tunaiGroup.setDisabled(false);
		master_lunas_piutang_cardGroup.setDisabled(false);
		master_lunas_piutang_cekGroup.setDisabled(false);
		master_lunas_piutang_kwitansiGroup.setDisabled(false);
		master_lunas_piutang_transferGroup.setDisabled(false);
		
		fpiutang_idField.setDisabled(false);
		fpiutang_nobuktiField.setDisabled(false);
		fpiutang_customerField.setDisabled(false);
		fpiutang_tanggalField.setDisabled(false);
		fpiutang_keteranganField.setDisabled(false);
		fpiutang_stat_dokField.setDisabled(false);
		detail_fpiutang_bylp_DataStore.load({params: {fpiutang_nobukti:-1}});
		master_lunas_piutang_createForm.fpiutang_savePrint.enable();
		
		dcbo_fjual_piutang.setDisabled(false);
		dfpiutang_sisaField.setDisabled(false);
		dfpiutang_bayarField.setDisabled(false);
		dfpiutang_ketField.setDisabled(false);
	}
 	/* End of Function */
	
	// Reset kwitansi option
	function kwitansi_fpiutang_reset_form(){
		fpiutang_kwitansi_namaField.reset();
		fpiutang_kwitansi_noField.reset();
		fpiutang_kwitansi_sisaField.reset();
		fpiutang_kwitansi_namaField.setValue("");
		fpiutang_kwitansi_noField.setValue("");
		fpiutang_kwitansi_sisaField.setValue(null);
	}
	
	// Reset card option
	function card_fpiutang_reset_form(){
		fpiutang_card_namaField.reset();
		fpiutang_card_edcField.reset();
		fpiutang_card_noField.reset();
		fpiutang_card_namaField.setValue("");
		fpiutang_card_edcField.setValue("");
		fpiutang_card_noField.setValue("");
	}
	
	// Reset cek option
	function cek_fpiutang_reset_form(){
		fpiutang_cek_namaField.reset();
		fpiutang_cek_noField.reset();
		fpiutang_cek_validField.reset();
		fpiutang_cek_bankField.reset();
		fpiutang_cek_namaField.setValue(null);
		fpiutang_cek_noField.setValue("");
		fpiutang_cek_validField.setValue("");
		fpiutang_cek_bankField.setValue("");
	}
	
	// Reset transfer option
	function transfer_fpiutang_reset_form(){
		fpiutang_transfer_bankField.reset();
		fpiutang_transfer_namaField.reset();
		fpiutang_transfer_bankField.setValue("");
		fpiutang_transfer_namaField.setValue(null);
	}
  
	/* setValue to EDIT */
	function master_lunas_piutang_set_form(){
		var total_bayar = 0;
		var total_piutang = master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('lpiutang_total');
		var sisa_piutang = 0;
		
		fpiutang_idField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_id'));
		fpiutang_nobuktiField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_nobukti'));
		fpiutang_customerField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('cust_nama'));
		fpiutang_customer_idField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_cust'));
		fpiutang_nocustField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('cust_no'));
		fpiutang_tanggalField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_tanggal'));
		fpiutang_keteranganField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_keterangan'));
		fpiutang_stat_dokField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok'));
		fpiutang_caraField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_cara'));
		fpiutang_total_cfField.setValue(CurrencyFormatted(total_piutang));
		fpiutang_totalField.setValue(total_piutang);
		
		for(i=0; i<detail_fpiutang_bylp_DataStore.getCount(); i++){
			total_bayar+=detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_nilai;
		}
		sisa_piutang = (total_piutang - total_bayar);
		
		fpiutang_bayar_cfField.setValue(CurrencyFormatted(total_bayar));
		fpiutang_bayarField.setValue(total_bayar);
		
		fpiutang_sisa_cfField.setValue(CurrencyFormatted(sisa_piutang));
		fpiutang_sisaField.setValue(sisa_piutang);
		
		if(fpiutang_post2db=="UPDATE" && master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok')=="Terbuka"){
			fpiutang_idField.setDisabled(false);
			fpiutang_nobuktiField.setDisabled(false);
			fpiutang_customerField.setDisabled(false);
			fpiutang_tanggalField.setDisabled(false);
			fpiutang_keteranganField.setDisabled(false);
			fpiutang_stat_dokField.setDisabled(false);
			master_lunas_piutang_createForm.fpiutang_savePrint.enable();
		}
		if(fpiutang_post2db=="UPDATE" && master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok')=="Tertutup"){
			fpiutang_idField.setDisabled(true);
			fpiutang_nobuktiField.setDisabled(true);
			fpiutang_customerField.setDisabled(true);
			fpiutang_tanggalField.setDisabled(true);
			fpiutang_keteranganField.setDisabled(true);
			fpiutang_stat_dokField.setDisabled(false);
			if(cetak_lp==1){
				cetak_lp=0;
			}
			master_lunas_piutang_createForm.fpiutang_savePrint.disable();
		}
		if(fpiutang_post2db=="UPDATE" && master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok')=="Batal"){
			fpiutang_idField.setDisabled(true);
			fpiutang_nobuktiField.setDisabled(true);
			fpiutang_customerField.setDisabled(true);
			fpiutang_tanggalField.setDisabled(true);
			fpiutang_keteranganField.setDisabled(true);
			fpiutang_stat_dokField.setDisabled(true);
			master_lunas_piutang_createForm.fpiutang_savePrint.disable();
		}
		
		update_group_carabayar_lunas_piutang();
		
		switch(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_cara')){
			case 'kwitansi':
				kwitansi_fpiutang_DataStore.load({
					params : {
						no_faktur: fpiutang_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_fpiutang_DataStore.getCount()){
								fpiutang_kwitansi_record=kwitansi_fpiutang_DataStore.getAt(0).data;
								fpiutang_kwitansi_idField.setValue(fpiutang_kwitansi_record.kwitansi_id);
								fpiutang_kwitansi_noField.setValue(fpiutang_kwitansi_record.kwitansi_no);
								fpiutang_kwitansi_namaField.setValue(fpiutang_kwitansi_record.cust_nama);
								fpiutang_kwitansi_sisaField.setValue(fpiutang_kwitansi_record.kwitansi_sisa);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_fpiutang_DataStore.load({
					params : {
						no_faktur: fpiutang_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							if(card_fpiutang_DataStore.getCount()){
								fpiutang_card_record=card_fpiutang_DataStore.getAt(0).data;
								fpiutang_card_namaField.setValue(fpiutang_card_record.jcard_nama);
								fpiutang_card_edcField.setValue(fpiutang_card_record.jcard_edc);
								fpiutang_card_noField.setValue(fpiutang_card_record.jcard_no);
							}
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_fpiutang_DataStore.load({
					params : {
						no_faktur: fpiutang_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_fpiutang_DataStore.getCount()){
									fpiutang_cek_record=cek_fpiutang_DataStore.getAt(0).data;
									fpiutang_cek_namaField.setValue(fpiutang_cek_record.jcek_nama);
									fpiutang_cek_noField.setValue(fpiutang_cek_record.jcek_no);
									fpiutang_cek_validField.setValue(fpiutang_cek_record.jcek_valid);
									fpiutang_cek_bankField.setValue(fpiutang_cek_record.jcek_bank);
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_fpiutang_DataStore.load({
						params : {
							no_faktur: fpiutang_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(transfer_fpiutang_DataStore.getCount()){
										fpiutang_transfer_record=transfer_fpiutang_DataStore.getAt(0);
										fpiutang_transfer_bankField.setValue(fpiutang_transfer_record.data.jtransfer_bank);
										fpiutang_transfer_namaField.setValue(fpiutang_transfer_record.data.jtransfer_nama);
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_fpiutang_DataStore.load({
					params : {
						no_faktur: fpiutang_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						if (success) {
							if(tunai_fpiutang_DataStore.getCount()){
								fpiutang_tunai_record=tunai_fpiutang_DataStore.getAt(0);
							}
						}
					}
				});
				break;
		}
		
		fpiutang_stat_dokField.on("select",function(){
		var status_awal = master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok');
		if(status_awal =='Terbuka' && fpiutang_stat_dokField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		fpiutang_stat_dokField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && fpiutang_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		fpiutang_stat_dokField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && fpiutang_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		fpiutang_stat_dokField.setValue('Tertutup');
		}
		
		else if(fpiutang_stat_dokField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', fpiutang_status_batal);
		}
        
       else if(status_awal =='Tertutup' && fpiutang_stat_dokField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
			master_lunas_piutang_createForm.fpiutang_savePrint.enable();
			<?php } ?>
        }
		
		});
		
	}
	/* End setValue to EDIT*/
  
	function fpiutang_status_batal(btn){
		if(btn=='yes')
		{
			fpiutang_stat_dokField.setValue('Batal');
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
			master_lunas_piutang_createForm.fpiutang_savePrint.disable();
			<?php } ?>
		}  
		else
			fpiutang_stat_dokField.setValue(master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok'));
	}
	
	function master_lunas_piutang_set_updating(){
		if(fpiutang_post2db=="UPDATE" && master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok')=="Terbuka"){
			fpiutang_customerField.setDisabled(true);
			fpiutang_tanggalField.setDisabled(true);
			fpiutang_keteranganField.setDisabled(false);
			fpiutang_caraField.setDisabled(false);
			master_lunas_piutang_tunaiGroup.setDisabled(false);
			master_lunas_piutang_cardGroup.setDisabled(false);
			master_lunas_piutang_cekGroup.setDisabled(false);
			master_lunas_piutang_kwitansiGroup.setDisabled(false);
			master_lunas_piutang_transferGroup.setDisabled(false);
			
            fpiutang_stat_dokField.setDisabled(false);
			//Enable Add detail
			detail_fpiutang_bAdd.setDisabled(false);
			detail_fpiutang_bDel.setDisabled(false);
			
			dcbo_fjual_piutang.setDisabled(false);
			dfpiutang_sisaField.setDisabled(false);
			dfpiutang_bayarField.setDisabled(false);
			dfpiutang_ketField.setDisabled(false);
		}
		if(fpiutang_post2db=="UPDATE" && master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok')=="Tertutup"){
			fpiutang_customerField.setDisabled(true);
			fpiutang_tanggalField.setDisabled(true);
			fpiutang_keteranganField.setDisabled(true);
			fpiutang_caraField.setDisabled(true);
			master_lunas_piutang_tunaiGroup.setDisabled(true);
			master_lunas_piutang_cardGroup.setDisabled(true);
			master_lunas_piutang_cekGroup.setDisabled(true);
			master_lunas_piutang_kwitansiGroup.setDisabled(true);
			master_lunas_piutang_transferGroup.setDisabled(true);
			
			fpiutang_stat_dokField.setDisabled(false);
			//Disable Add detail
			detail_fpiutang_bAdd.setDisabled(true);
			detail_fpiutang_bDel.setDisabled(true);
			
			dcbo_fjual_piutang.setDisabled(true);
			dfpiutang_sisaField.setDisabled(true);
			dfpiutang_bayarField.setDisabled(true);
			dfpiutang_ketField.setDisabled(true);
		}
		if(fpiutang_post2db=="UPDATE" && master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_stat_dok')=="Batal"){
			fpiutang_customerField.setDisabled(true);
			fpiutang_tanggalField.setDisabled(true);
			fpiutang_keteranganField.setDisabled(true);
			fpiutang_stat_dokField.setDisabled(true);
			fpiutang_caraField.setDisabled(true);
			master_lunas_piutang_tunaiGroup.setDisabled(true);
			master_lunas_piutang_cardGroup.setDisabled(true);
			master_lunas_piutang_cekGroup.setDisabled(true);
			master_lunas_piutang_kwitansiGroup.setDisabled(true);
			master_lunas_piutang_transferGroup.setDisabled(true);
			
			//Disable Add detail
			detail_fpiutang_bAdd.setDisabled(true);
			detail_fpiutang_bDel.setDisabled(true);
			
			dcbo_fjual_piutang.setDisabled(true);
			dfpiutang_sisaField.setDisabled(true);
			dfpiutang_bayarField.setDisabled(true);
			dfpiutang_ketField.setDisabled(true);
			
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
			master_lunas_piutang_createForm.fpiutang_savePrint.disable();
			<?php } ?>
		}
	}
  
  
	/* Function for Check if the form is valid */
	function is_master_lunas_piutang_form_valid(){
		return (fpiutang_customerField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_lunas_piutang_createWindow.isVisible()){
			fpiutang_post2db='CREATE';
			msg='created';
			master_lunas_piutang_reset_form();
			master_lunas_piutang_createWindow.show();
		} else {
			master_lunas_piutang_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_lunas_piutang_confirm_delete(){
		// only one master_lunas_piutang is selected here
		if(master_lunas_piutangListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_lunas_piutang_delete);
		} else if(master_lunas_piutangListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_lunas_piutang_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'Tidak ada yang dipilih untuk dihapus',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
	
	/* Function for Update Confirm */
	function master_lunas_piutang_confirm_update(){
		/* only one record is selected here */
		if(master_lunas_piutangListEditorGrid.selModel.getCount() == 1) {
			fpiutang_post2db='UPDATE';
			msg='updated';
			cbo_fjual_piutangDataStore.setBaseParam('fpiutang_id',master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_id'));
			cbo_fjual_piutangDataStore.setBaseParam('task','selected');
			cbo_fjual_piutangDataStore.load({
				callback: function(opts, success, response){
					if(success){
						detail_fpiutang_bylp_DataStore.setBaseParam('fpiutang_nobukti',master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_nobukti'));
						detail_fpiutang_bylp_DataStore.load({
							callback: function(opts, success, response){
								if(success){
									master_lunas_piutang_set_form();
									master_lunas_piutang_set_updating();
								}
							}
						});
					}
				}
			});
			master_lunas_piutang_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'Tidak ada data yang dipilih untuk diedit',
				msg: 'Anda belum memilih data yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_lunas_piutang_delete(btn){
		if(btn=='yes'){
			var selections = master_lunas_piutangListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_lunas_piutangListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.fpiutang_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_master_lunas_piutang&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_lunas_piutang_DataStore.reload();
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
	master_lunas_piutang_DataStore = new Ext.data.Store({
		id: 'master_lunas_piutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: fpiutang_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'fpiutang_id'
		},[
			{name: 'fpiutang_id', type: 'int', mapping: 'fpiutang_id'}, 
			{name: 'fpiutang_nobukti', type: 'string', mapping: 'fpiutang_nobukti'},
			{name: 'fpiutang_cust', type: 'int', mapping: 'fpiutang_cust'}, 
			{name: 'fpiutang_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'fpiutang_tanggal'}, 
			{name: 'fpiutang_cara', type: 'string', mapping: 'fpiutang_cara'},
			{name: 'fpiutang_bayar', type: 'float', mapping: 'fpiutang_bayar'}, 
			{name: 'fpiutang_stat_dok', type: 'string', mapping: 'fpiutang_stat_dok'},
			{name: 'fpiutang_keterangan', type: 'string', mapping: 'fpiutang_keterangan'},
			{name: 'cust_id', type: 'int', mapping: 'cust_id'}, 
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'}, 
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'lpiutang_total', type: 'float', mapping: 'lpiutang_total'},
			{name: 'lpiutang_sisa', type: 'float', mapping: 'lpiutang_sisa'}
		]),
		sortInfo:{field: 'fpiutang_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Supplier DataStore */
	var cbo_fjual_piutangDataStore = new Ext.data.Store({
		id: 'cbo_fjual_piutangDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_fjual_bycust_list', 
			method: 'POST'
		}),
		baseParams:{task: "detail",start:0,limit:fpiutang_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'lpiutang_id'
		},[
			{name: 'lpiutang_id', type: 'int', mapping: 'lpiutang_id'},
			{name: 'lpiutang_faktur', type: 'string', mapping: 'lpiutang_faktur'},
			{name: 'lpiutang_cust', type: 'int', mapping: 'lpiutang_cust'},
			{name: 'lpiutang_faktur_tanggal', type: 'string', mapping: 'lpiutang_faktur_tanggal'},
			{name: 'lpiutang_total', type: 'float', mapping: 'lpiutang_total'},
			{name: 'lpiutang_sisa', type: 'float', mapping: 'lpiutang_sisa'},
			{name: 'lpiutang_stat_dok', type: 'string', mapping: 'lpiutang_stat_dok'}
		]),
		sortInfo:{field: 'lpiutang_faktur', direction: "ASC"}
	});
	var cbo_fjual_piutang_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{lpiutang_faktur}, Tgl: {lpiutang_faktur_tanggal}</b><br /></span>',
            'Jumlah Piutang: {lpiutang_total} | Sisa Piutang: Rp. {lpiutang_sisa}',
        '</div></tpl>'
    );
	
	/* Function for Retrieve Supplier DataStore */
	var cbo_fpiutang_customerDataStore = new Ext.data.Store({
		id: 'cbo_fpiutang_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_piutang_cust_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:10}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'lpiutang_id'
		},[
			{name: 'lpiutang_id', type: 'int', mapping: 'lpiutang_id'},
			{name: 'lpiutang_cust', type: 'int', mapping: 'lpiutang_cust'},
			{name: 'cust_nama', type: 'string',  mapping: 'cust_nama'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'lpiutang_total', type: 'float', mapping: 'lpiutang_total'},
			{name: 'lpiutang_sisa', type: 'float', mapping: 'lpiutang_sisa'}
		]),
		sortInfo:{field: 'lpiutang_id', direction: "ASC"}
	});
	
	// Custom rendering Template
    var fpiutang_customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            'Sisa Piutang: Rp. {lpiutang_sisa}',
        '</div></tpl>'
    );
	
	/* Function for Retrieve Kwitansi DataStore */
	kwitansi_fpiutang_DataStore = new Ext.data.Store({
		id: 'kwitansi_fpiutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_kwitansi_by_ref', 
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
	card_fpiutang_DataStore = new Ext.data.Store({
		id: 'card_fpiutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_card_by_ref', 
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
	cek_fpiutang_DataStore = new Ext.data.Store({
		id: 'cek_fpiutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_cek_by_ref', 
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
	transfer_fpiutang_DataStore = new Ext.data.Store({
		id: 'transfer_fpiutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_transfer_by_ref', 
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
	tunai_fpiutang_DataStore = new Ext.data.Store({
		id: 'tunai_fpiutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_tunai_by_ref', 
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
	
  	/* Function for Identify of Window Column Model */
	master_lunas_piutang_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'ID' + '</div>',
			dataIndex: 'fpiutang_id',
			width: 70,
			sortable: false,
			hidden: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'fpiutang_tanggal',
			width: 60,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No LP' + '</div>',
			dataIndex: 'fpiutang_nobukti',
			width: 80,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No. Cust' + '</div>',
			dataIndex: 'cust_no',
			width: 60,
			sortable: false,
			readOnly: true,
		},
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'cust_nama',
			width: 150,
			sortable: false,
			readOnly: true,
		},
		{
			header: '<div align="center">' + 'Cara Bayar' + '</div>',
			align: 'right',
			dataIndex: 'fpiutang_cara',
			width: 60,
			sortable: false,
			readOnly: true,
		},
		{
			header: '<div align="center">' + 'Tot Bayar (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'fpiutang_bayar',
			width: 80,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'fpiutang_keterangan',
			width: 200,
			sortable: false,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'fpiutang_stat_dok',
			width: 60
		}	]);
	
	//master_lunas_piutang_ColumnModel.defaultSortable= true;
	/* End of Function */
    var master_fpiutang_paging_toolbar=new Ext.PagingToolbar({
			pageSize: fpiutang_pageS,
			store: master_lunas_piutang_DataStore,
			displayInfo: true
		});
	/* Declare DataStore and  show datagrid list */
	master_lunas_piutangListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_lunas_piutangListEditorGrid',
		el: 'fp_master_lunas_piutang',
		title: 'Daftar Pelunasan Piutang',
		autoHeight: true,
		store: master_lunas_piutang_DataStore, // DataStore
		cm: master_lunas_piutang_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//900,
		bbar: master_fpiutang_paging_toolbar,
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_lunas_piutang_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: master_lunas_piutang_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Pencarian detail',
			iconCls:'icon-search',
			//disabled: true,
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_lunas_piutang_DataStore,
			params: {start: 0, limit: fpiutang_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_lunas_piutang_DataStore.baseParams={task:'LIST',start: 0, limit: fpiutang_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No LP<br>- Customer'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_lunas_piutang_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled: true//,
			//handler: master_lunas_piutang_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled: true//,
			//handler: master_lunas_piutang_print  
		}
		]
	});
	master_lunas_piutangListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_lunas_piutang_ContextMenu = new Ext.menu.Menu({
		id: 'master_lunas_piutang_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_lunas_piutang_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: master_lunas_piutang_confirm_delete 
		}
		<?php } ?>
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_lunas_piutang_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_lunas_piutang_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_lunas_piutang_SelectedRow=rowIndex;
		master_lunas_piutang_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_lunas_piutang_editContextMenu(){
		master_lunas_piutangListEditorGrid.startEditing(master_lunas_piutang_SelectedRow,1);
  	}
	/* End of Function */

	
	/* Identify  fpiutang_id Field */
	fpiutang_idField= new Ext.form.NumberField({
		id: 'fpiutang_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  fpiutang_no Field */
	fpiutang_nobuktiField= new Ext.form.TextField({
		id: 'fpiutang_nobuktiField',
		//fieldLabel: 'No Order',
		fieldLabel: 'No LP',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  fpiutang_customer Field */
	fpiutang_customer_idField= new Ext.form.NumberField();
	fpiutang_customerField= new Ext.form.ComboBox({
		id: 'fpiutang_customerField',
		fieldLabel: 'Customer',
		store: cbo_fpiutang_customerDataStore,
		displayField:'cust_nama',
		mode : 'remote',
		valueField: 'lpiutang_cust',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
		//allowBlank: false,
        tpl: fpiutang_customer_tpl,
		forceSelection: true,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		enableKeyEvents: true,
		anchor: '95%',
		listeners:{
			render: function(c){
				Ext.get(this.id).set({qtitle:'Field ini memunculkan daftar Customer yang memiliki piutang saja'});
				Ext.get(this.id).set({qtip:'(Search by: No. Cust, Nama Cust)'});
			}
		}
	});

	// Event ketika Customer dipilih
	fpiutang_customerField.on('select', function(){
		var j=cbo_fpiutang_customerDataStore.findExact('lpiutang_cust',fpiutang_customerField.getValue(),0);
		cbo_fjual_piutangDataStore.setBaseParam('cust_id', fpiutang_customerField.getValue());
		cbo_fjual_piutangDataStore.load({
			params:{
				task:'detail'
			}
		});
		if(cbo_fpiutang_customerDataStore.getCount()>0){
			fpiutang_total_cfField.setValue(CurrencyFormatted(cbo_fpiutang_customerDataStore.getAt(j).data.lpiutang_sisa));
			fpiutang_totalField.setValue(cbo_fpiutang_customerDataStore.getAt(j).data.lpiutang_sisa);
			fpiutang_nocustField.setValue(cbo_fpiutang_customerDataStore.getAt(j).data.cust_no)
		}
	});
	
	
	fpiutang_nocustField= new Ext.form.TextField({
		id: 'fpiutang_nocustField',
		fieldLabel: 'No. Cust',
		emptyText : '(Auto)',
		readOnly: true
	});
	
	/* Identify  fpiutang_tanggal Field */
	fpiutang_tanggalField= new Ext.form.DateField({
		id: 'fpiutang_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	fpiutang_stat_dokField= new Ext.form.ComboBox({
		id: 'fpiutang_stat_dokField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['fpiutang_status_value', 'fpiutang_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'fpiutang_status_display',
		valueField: 'fpiutang_status_value',
		anchor: '60%',
		allowBlank: false,
		editable: false,
		triggerAction: 'all'	
	});
	
	/* START Field master_lunas_piutang_bayarGroup */
	fpiutang_subtotalField= new Ext.form.TextField({
		id: 'fpiutang_subtotalField',
		fieldLabel: 'Sub Total (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* END Field master_lunas_piutang_bayarGroup */
	
	/* Identify  fpiutang_keterangan Field */
	fpiutang_keteranganField= new Ext.form.TextArea({
		id: 'fpiutang_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
  	/*Fieldset Master*/
	
	master_lunas_piutang_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [fpiutang_nobuktiField, fpiutang_customerField, fpiutang_nocustField, fpiutang_tanggalField] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [fpiutang_keteranganField, fpiutang_stat_dokField, fpiutang_idField] 
				
			}
			]
	});
	
	function update_group_carabayar_lunas_piutang(){
		var value=fpiutang_caraField.getValue();
		master_lunas_piutang_tunaiGroup.setVisible(false);
		master_lunas_piutang_cardGroup.setVisible(false);
		master_lunas_piutang_cekGroup.setVisible(false);
		master_lunas_piutang_transferGroup.setVisible(false);
		master_lunas_piutang_kwitansiGroup.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		//lpiutang_tunai_nilaiField.reset();
		//lpiutang_tunai_nilai_cfField.reset();
		//lpiutang_card_nilaiField.reset();
		//lpiutang_card_nilai_cfField.reset();
		//lpiutang_cek_nilaiField.reset();
		//lpiutang_cek_nilai_cfField.reset();
		//lpiutang_transfer_nilaiField.reset();
		//lpiutang_transfer_nilai_cfField.reset();
		//lpiutang_kwitansi_nilaiField.reset();
		//lpiutang_kwitansi_nilai_cfField.reset();
		
		if(value=='card'){
			master_lunas_piutang_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			master_lunas_piutang_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			master_lunas_piutang_transferGroup.setVisible(true);
		}else if(value=='kwitansi'){
			master_lunas_piutang_kwitansiGroup.setVisible(true);
		}else if(value=='tunai'){
			master_lunas_piutang_tunaiGroup.setVisible(true);
		}
	}
	
	/* Identify  jproduk_cara Field */
	fpiutang_caraField= new Ext.form.ComboBox({
		id: 'fpiutang_caraField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['jproduk_cara_value', 'jproduk_cara_display'],
			data:[['tunai','Tunai'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
			//,['voucher','Voucher']]
		}),
		mode: 'local',
		displayField: 'jproduk_cara_display',
		valueField: 'jproduk_cara_value',
		editable: false,
		//anchor: '95%',
		width: 100,
		triggerAction: 'all'	
	});
	fpiutang_caraField.on('select', update_group_carabayar_lunas_piutang);
	
	/* GET Bank-List.Store */
	fpiutang_bankDataStore = new Ext.data.Store({
		id:'fpiutang_bankDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_bank_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'lpiutang_bank_value', type: 'int', mapping: 'mbank_id'}, 
			{name: 'lpiutang_bank_display', type: 'string', mapping: 'mbank_nama'}
		]),
		sortInfo:{field: 'lpiutang_bank_display', direction: "DESC"}
		});
	/* END GET Bank-List.Store */
	
	/* Function for Retrieve Combo Kwitansi DataStore */
	cbo_kwitansi_lunas_piutang_DataStore = new Ext.data.Store({
		id: 'cbo_kwitansi_lunas_piutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_kwitansi_list', 
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
			{name: 'total_sisa', type: 'int', mapping: 'total_sisa'}
		]),
		sortInfo:{field: 'ckwitansi_no', direction: "ASC"}
	});
	var kwitansi_lunas_piutang_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{ckwitansi_no}</b> <br/>',
			'a/n {ckwitansi_cust_nama} [ {ckwitansi_cust_no} ]<br/>',
			'{ckwitansi_cust_alamat}, <br>Sisa: <b>Rp. {total_sisa}</b> </span>',
		'</div></tpl>'
    );
	/* End of Function */
	
	//START Field Tunai-1
	/*lpiutang_tunai_nilai_cfField= new Ext.form.TextField({
		id: 'lpiutang_tunai_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	lpiutang_tunai_nilaiField= new Ext.form.NumberField({
		id: 'lpiutang_tunai_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/

	master_lunas_piutang_tunaiGroup = new Ext.form.FieldSet({
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
				items: [/*lpiutang_tunai_nilai_cfField*/] 
			}
		]
	});
	// END Tunai-1
	
	// START Field Card
	fpiutang_card_namaField= new Ext.form.ComboBox({
		id: 'fpiutang_card_namaField',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['lpiutang_card_value', 'lpiutang_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'lpiutang_card_display',
		valueField: 'lpiutang_card_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	fpiutang_card_edcField= new Ext.form.ComboBox({
		id: 'fpiutang_card_edcField',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['lpiutang_card_edc_value', 'lpiutang_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'lpiutang_card_edc_display',
		valueField: 'lpiutang_card_edc_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	fpiutang_card_noField= new Ext.form.TextField({
		id: 'fpiutang_card_noField',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	/*lpiutang_card_nilai_cfField= new Ext.form.TextField({
		id: 'lpiutang_card_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	lpiutang_card_nilaiField= new Ext.form.NumberField({
		id: 'lpiutang_card_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});*/
	
	master_lunas_piutang_cardGroup= new Ext.form.FieldSet({
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
				items: [fpiutang_card_namaField,fpiutang_card_edcField,fpiutang_card_noField/*,lpiutang_card_nilai_cfField*/] 
			}
		]
	});
	// END Field Card
	
	// StART Field Cek
	fpiutang_cek_namaField= new Ext.form.TextField({
		id: 'fpiutang_cek_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	fpiutang_cek_noField= new Ext.form.TextField({
		id: 'fpiutang_cek_noField',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	fpiutang_cek_validField= new Ext.form.DateField({
		id: 'fpiutang_cek_validField',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	fpiutang_cek_bankField= new Ext.form.ComboBox({
		id: 'fpiutang_cek_bankField',
		fieldLabel: 'Bank',
		store: fpiutang_bankDataStore,
		mode: 'remote',
		displayField: 'lpiutang_bank_display',
		valueField: 'lpiutang_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(fpiutang_cek_bankField)
	});
	
	/*lpiutang_cek_nilai_cfField= new Ext.form.TextField({
		id: 'lpiutang_cek_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	lpiutang_cek_nilaiField= new Ext.form.NumberField({
		id: 'lpiutang_cek_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});*/
	
	master_lunas_piutang_cekGroup = new Ext.form.FieldSet({
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
				items: [fpiutang_cek_namaField,fpiutang_cek_noField,fpiutang_cek_validField,fpiutang_cek_bankField/*,lpiutang_cek_nilai_cfField*/] 
			}
		]
	});
	// END Field Cek
	
	//START Kwitansi
	fpiutang_kwitansi_namaField= new Ext.form.TextField({
		id: 'fpiutang_kwitansi_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		readOnly: true,
		anchor: '95%'
	});
	
	/*lpiutang_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'lpiutang_kwitansi_nilai_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	lpiutang_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'lpiutang_kwitansi_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	fpiutang_kwitansi_idField= new Ext.form.NumberField();
	fpiutang_kwitansi_noField= new Ext.form.ComboBox({
		id: 'fpiutang_kwitansi_noField',
		fieldLabel: 'Nomor Kuitansi',
		store: cbo_kwitansi_lunas_piutang_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_lunas_piutang_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		//triggerAction: 'all',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		queryDelay:720,
		anchor: '95%'
	});
	
	fpiutang_kwitansi_sisaField= new Ext.form.NumberField({
		id: 'fpiutang_kwitansi_sisaField',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	
	fpiutang_kwitansi_noField.on("select",function(){
		j=cbo_kwitansi_lunas_piutang_DataStore.findExact('ckwitansi_id',fpiutang_kwitansi_noField.getValue(),0);
		if(j>-1){
			fpiutang_kwitansi_namaField.setValue(cbo_kwitansi_lunas_piutang_DataStore.getAt(j).data.ckwitansi_cust_nama);
			fpiutang_kwitansi_sisaField.setValue(cbo_kwitansi_lunas_piutang_DataStore.getAt(j).data.total_sisa);
		}
	});
	
	master_lunas_piutang_kwitansiGroup = new Ext.form.FieldSet({
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
				items: [fpiutang_kwitansi_noField,fpiutang_kwitansi_namaField,fpiutang_kwitansi_sisaField/*,lpiutang_kwitansi_nilai_cfField*/] 
			}
		]
	});
	//END Kwitansi
	
	// START Field Transfer
	fpiutang_transfer_bankField= new Ext.form.ComboBox({
		id: 'fpiutang_transfer_bankField',
		fieldLabel: 'Bank',
		store: fpiutang_bankDataStore,
		mode: 'remote',
		displayField: 'lpiutang_bank_display',
		valueField: 'lpiutang_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(fpiutang_transfer_bankField)
	});

	fpiutang_transfer_namaField= new Ext.form.TextField({
		id: 'fpiutang_transfer_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	/*lpiutang_transfer_nilai_cfField= new Ext.form.TextField({
		id: 'lpiutang_transfer_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	lpiutang_transfer_nilaiField= new Ext.form.NumberField({
		id: 'lpiutang_transfer_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	master_lunas_piutang_transferGroup= new Ext.form.FieldSet({
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
				items: [fpiutang_transfer_bankField,fpiutang_transfer_namaField/*,lpiutang_transfer_nilai_cfField*/] 
			}
		]
	
	});
	// END Field Transfer
	
	fpiutang_total_cfField= new Ext.form.TextField({
		id: 'fpiutang_total_cfField',
		fieldLabel: '<span style="font-weight:bold">Total Piutang Keseluruhan(Rp)</span>',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		readOnly: true,
		maskRe: /([0-9]+)$/ 
	});
	fpiutang_totalField= new Ext.form.NumberField({
		id: 'fpiutang_totalField',
		enableKeyEvents: true,
		fieldLabel: '<span style="font-weight:bold">Total Piutang Keseluruhan(Rp)</span>',
		allowBlank: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	fpiutang_bayar_cfField= new Ext.form.TextField({
		id: 'fpiutang_bayar_cfField',
		fieldLabel: 'Total Bayar (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		readOnly: true,
		maskRe: /([0-9]+)$/ 
	});
	fpiutang_bayarField= new Ext.form.NumberField({
		id: 'fpiutang_bayarField',
		enableKeyEvents: true,
		fieldLabel: 'Total Bayar (Rp)',
		allowBlank: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	fpiutang_sisa_cfField= new Ext.form.TextField({
		id: 'fpiutang_sisa_cfField',
		fieldLabel: 'Sisa Piutang (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		readOnly: true,
		maskRe: /([0-9]+)$/ 
	});
	fpiutang_sisaField= new Ext.form.NumberField({
		id: 'fpiutang_sisaField',
		enableKeyEvents: true,
		fieldLabel: 'Sisa Piutang (Rp)',
		allowBlank: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	master_cara_bayarTabPanel = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		//autoHeigth: true,
		frame: true,
		height: 232,
		width: 500,
		defaults:{bodyStyle:'padding:10px'},
		items:[{
                title:'Cara Bayar',
                layout:'form',
				frame: true,
                defaults: {width: 230},
                defaultType: 'textfield',
                items: [fpiutang_caraField,master_lunas_piutang_tunaiGroup,master_lunas_piutang_cardGroup,master_lunas_piutang_cekGroup,master_lunas_piutang_kwitansiGroup,master_lunas_piutang_transferGroup]
            }]
	});
	
	//master_lunas_piutang_FootGroup
	master_lunas_piutang_bayarGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.65,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 120,
				items: [master_cara_bayarTabPanel] 
			},{
				columnWidth:0.35,
				layout: 'form',
				labelAlign: 'left',
				labelWidth: 120,
				border:false,
				items: [fpiutang_total_cfField, fpiutang_bayar_cfField,fpiutang_sisa_cfField]
			}
			]
	});
		
	// Function for json reader of detail
	var detail_fpiutang_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'lpiutang_id'
	},[
			{name: 'lpiutang_id', type: 'int', mapping: 'lpiutang_id'}, 
			{name: 'lpiutang_faktur', type: 'string', mapping: 'lpiutang_faktur'}, 
			{name: 'lpiutang_faktur_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'lpiutang_faktur_tanggal'},
			{name: 'lpiutang_total', type: 'float', mapping: 'lpiutang_total'},
			{name: 'lpiutang_sisa', type: 'float', mapping: 'lpiutang_sisa'}, 
			{name: 'lpiutang_stat_dok', type: 'string', mapping: 'lpiutang_stat_dok'}, 
			{name: 'lpiutang_status', type: 'string', mapping: 'lpiutang_status'}, 
			{name: 'lpiutang_keterangan', type: 'string', mapping: 'lpiutang_keterangan'},
			{name: 'dpiutang_id', type: 'int', mapping: 'dpiutang_id'},
			{name: 'dpiutang_nilai', type: 'float', mapping: 'dpiutang_nilai'},
			{name: 'dpiutang_keterangan', type: 'string', mapping: 'dpiutang_keterangan'}
			
	]);
	//eof
	
	//function for json writer of detail
	var detail_fpiutang_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_fpiutang_bylp_DataStore = new Ext.data.Store({
		id: 'detail_fpiutang_bylp_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=detail_fpiutang_bylp_list', 
			method: 'POST'
		}),
		reader: detail_fpiutang_reader,
		baseParams:{start:0, limit:fpiutang_pageS, task: 'detail'},
		sortInfo:{field: 'lpiutang_id', direction: 'DESC'}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_fpiutang= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	var dcbo_fjual_piutang=new Ext.form.ComboBox({
		store: cbo_fjual_piutangDataStore,
		mode: 'local',
		typeAhead: false,
		displayField: 'lpiutang_faktur',
		valueField: 'lpiutang_id',
		triggerAction: 'all',
		lazyRender: false,
		//pageSize: fpiutang_pageS,
		enableKeyEvents: true,
		tpl: cbo_fjual_piutang_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	dcbo_fjual_piutang.on("select",function(){
		var j=cbo_fjual_piutangDataStore.findExact('lpiutang_id',dcbo_fjual_piutang.getValue(),0);
		if(cbo_fjual_piutangDataStore.getCount()>0){
			dlpiutang_tgl_fakturField.setValue(cbo_fjual_piutangDataStore.getAt(j).data.lpiutang_faktur_tanggal);
			dfpiutang_sisaField.setValue(cbo_fjual_piutangDataStore.getAt(j).data.lpiutang_sisa);
			dfpiutang_lpiutang_idField.setValue(cbo_fjual_piutangDataStore.getAt(j).data.lpiutang_id);
		}
	});
	dcbo_fjual_piutang.on("focus",function(){
		if(fpiutang_stat_dokField.getValue()=='Terbuka' && fpiutang_post2db=='UPDATE'){
			cbo_fjual_piutangDataStore.load({
				params:{
					cust_id: master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_cust'),
					task: 'detail'
				}
			});
		}else if((fpiutang_stat_dokField.getValue()!=='Terbuka') && (fpiutang_post2db=='UPDATE')){
			cbo_fjual_piutangDataStore.load({
				params:{
					fpiutang_id: master_lunas_piutangListEditorGrid.getSelectionModel().getSelected().get('fpiutang_id'),
					task: 'selected'
				}
			});
		}else{
			cbo_fjual_piutangDataStore.setBaseParam('cust_id', fpiutang_customerField.getValue());
			cbo_fjual_piutangDataStore.setBaseParam('task', 'detail');
			cbo_fjual_piutangDataStore.load();
		}
	});
	
	var dfpiutang_bayarField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: false,
		blankText: '0',
		maxLength: 22,
		maskRe: /([0-9]+)$/
	});
	
	var dlpiutang_tgl_fakturField= new Ext.form.TextField({
		id: 'dlpiutang_tgl_fakturField',
		readOnly: true,
		format: 'd-m-Y'
	});
	
	var dfpiutang_sisaField= new Ext.form.TextField({
		id: 'dfpiutang_sisaField',
		readOnly: true
	});
	
	var dfpiutang_ketField= new Ext.form.TextField({
		id: 'dfpiutang_ketField',
		readOnly: false,
		maxLength: 250
	});
	var dfpiutang_lpiutang_idField= new Ext.form.NumberField({
		id: 'dfpiutang_lpiutang_idField',
		readOnly: true
	});
	
	
	//declaration of detail coloumn model
	detail_fpiutang_ColumnModel = new Ext.grid.ColumnModel(
		[ 
		{
			header: '<div align="center">' + 'ID' + '</div>',
			dataIndex: 'dpiutang_id',
			hidden: true,
			width: 60,
			sortable: false
		},
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'lpiutang_id',
			width: 100,
			sortable: true,
			editor: dcbo_fjual_piutang,
			renderer: Ext.util.Format.comboRenderer(dcbo_fjual_piutang)
		},
		{
			header: '<div align="center">' + 'Piutang (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'lpiutang_total',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: dfpiutang_sisaField
		},
		{
			header: '<div align="center">' + 'Dilunasi (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'dpiutang_nilai',
			width: 100,
			editor:  dfpiutang_bayarField,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'right',
			dataIndex: 'dpiutang_keterangan',
			width: 200,
			sortable: true,
			editor: dfpiutang_ketField
		},
		//lpiutang_id sengaja dimunculkan, karena dipakai utk pengecekan
		{
			header: '<div align="center">' + 'lpiutang_id' + '</div>',
			dataIndex: 'lpiutang_id',
			hidden: false,
			width: 60,
			sortable: false,
			readonly: true,
			editor: dfpiutang_lpiutang_idField
		},
		]
	);
	detail_fpiutang_ColumnModel.defaultSortable= true;
	//eof
	var detail_fpiutang_bAdd=new Ext.Button({
		text: 'Add',
		tooltip: 'Add new detail record',
		iconCls:'icon-adds',    				// this is defined in our styles.css
		handler: detail_fpiutang_add
	});
	var detail_fpiutang_bDel=new Ext.Button({
		text: 'Delete',
		tooltip: 'Delete detail selected record',
		iconCls:'icon-delete',    				// this is defined in our styles.css
		handler: detail_fpiutang_confirm_delete
	});
	//declaration of detail list editor grid
	detail_fpiutangListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_fpiutangListEditorGrid',
		el: 'fp_detail_fpiutang',
		title: 'Detail Item',
		height: 250,
		width: 920,
		autoScroll: true,
		store: detail_fpiutang_bylp_DataStore, // DataStore
		colModel: detail_fpiutang_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_fpiutang],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
		,
		tbar: [detail_fpiutang_bAdd
		, '-',detail_fpiutang_bDel
		]
		<?php } ?>
	});
	//eof

	//function of detail add
	function detail_fpiutang_add(){
		var edit_detail_fpiutang= new detail_fpiutangListEditorGrid.store.recordType({
			dpiutang_id		:0,
			lpiutang_id		:0,
			lpiutang_total	:0,
			dpiutang_nilai	:0,
			dpiutang_keterangan: ''
		});
		editor_detail_fpiutang.stopEditing();
		detail_fpiutang_bylp_DataStore.insert(0, edit_detail_fpiutang);
		//detail_fpiutangListEditorGrid.getView().refresh();
		detail_fpiutangListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_fpiutang.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_detail_fpiutang(){
		detail_fpiutang_bylp_DataStore.commitChanges();
		detail_fpiutangListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function detail_fpiutang_insert(pkid,opsi){
        var dlpiutang_id = [];
        var dlpiutang_produk = [];
        var dlpiutang_satuan = [];
        var dlpiutang_jumlah = [];
        var dlpiutang_harga = [];
        
        var dcount = detail_fpiutang_bylp_DataStore.getCount() - 1;
        
        if(detail_fpiutang_bylp_DataStore.getCount()>0){
            for(i=0; i<detail_fpiutang_bylp_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_fpiutang_bylp_DataStore.getAt(i).data.dfpiutang_produk))
				   && detail_fpiutang_bylp_DataStore.getAt(i).data.dfpiutang_produk!==undefined
				   && detail_fpiutang_bylp_DataStore.getAt(i).data.dfpiutang_produk!==''
				   && detail_fpiutang_bylp_DataStore.getAt(i).data.dfpiutang_produk!==0
				   && detail_fpiutang_bylp_DataStore.getAt(i).data.dfpiutang_satuan!==0
				   && detail_fpiutang_bylp_DataStore.getAt(i).data.dfpiutang_jumlah>0){
                    
                  	lpiutang_id.push(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_id);
					lpiutang_produk.push(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_produk);
                   	lpiutang_satuan.push(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_satuan);
					lpiutang_jumlah.push(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_jumlah);
					lpiutang_harga.push(detail_fpiutang_bylp_DataStore.getAt(i).data.lpiutang_harga);
                }
            }
			
			var encoded_array_lpiutang_id = Ext.encode(lpiutang_id);
			var encoded_array_lpiutang_produk = Ext.encode(lpiutang_produk);
			var encoded_array_lpiutang_satuan = Ext.encode(lpiutang_satuan);
			var encoded_array_lpiutang_jumlah = Ext.encode(lpiutang_jumlah);
			var encoded_array_lpiutang_harga = Ext.encode(lpiutang_harga);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_lunas_piutang&m=detail_detail_fpiutang_insert',
				params:{
					lpiutang_id		: encoded_array_lpiutang_id,
					lpiutang_master	: pkid, 
					lpiutang_produk	: encoded_array_lpiutang_produk,
					lpiutang_satuan	: encoded_array_lpiutang_satuan,
					lpiutang_jumlah	: encoded_array_lpiutang_jumlah,
					lpiutang_harga	: encoded_array_lpiutang_harga
				},
				success:function(response){
					var result=eval(response.responseText);
					if(opsi=='print'){
						master_lunas_piutang_cetak_faktur(pkid);
					}
					master_lunas_piutang_DataStore.reload()
				},
				failure: function(response){
					Ext.MessageBox.hide();
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
	//eof
	
	
	//function for purge detail
	function detail_fpiutang_purge(pkid,opsi){
		Ext.Ajax.request({
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_lunas_piutang&m=detail_detail_fpiutang_purge',
			params:{ master_id: pkid },
			success:function(response){
				detail_fpiutang_insert(pkid,opsi); //by masongbee
				/*if(opsi=='print'){
					master_lunas_piutang_cetak_faktur();
				}
				master_lunas_piutang_DataStore.reload();*/ //by masongbee
			}
		});
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_fpiutang_confirm_delete(){
		// only one record is selected here
		if(detail_fpiutangListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_fpiutang_delete);
		} else if(detail_fpiutangListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_fpiutang_delete);
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
	function detail_fpiutang_delete(btn){
		if(btn=='yes'){
			var s = detail_fpiutangListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				if(r.data.dpiutang_id==0){
					detail_fpiutang_bylp_DataStore.remove(r);
					detail_fpiutang_bylp_DataStore.commitChanges();
					detail_pelunasan_total();
				}else{
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Detail Pelunasan Piutang tidak dapat dihapus.',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
				}
			}
		} 		
	}
	//eof
	
	/* Function for retrieve create Window Panel*/ 
	master_lunas_piutang_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,
		monitorValid: true,
		items: [master_lunas_piutang_masterGroup,detail_fpiutangListEditorGrid,master_lunas_piutang_bayarGroup],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_LUNASPIUTANG'))){ ?>
			{
				text: 'Save and Print',
				ref: '../fpiutang_savePrint',
				handler: pengecekan_dokumen
			},{
				text: 'Save',
				handler: pengecekan_dokumen2
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					fpiutang_btn_cancel();
					master_lunas_piutang_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	
	/* Function for retrieve create Window Form */
	master_lunas_piutang_createWindow= new Ext.Window({
		id: 'master_lunas_piutang_createWindow',
		title: fpiutang_post2db+'Pelunasan Piutang',
		closable:true,
		closeAction: 'hide',
		width: 940,
		//autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_lunas_piutang_create',
		items: master_lunas_piutang_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function master_lunas_piutang_list_search(){
		// render according to a SQL date format.
		var fpiutang_id_search=null;
		var fpiutang_no_search=null;
		var fpiutang_tanggal_search_date="";
		var fpiutang_tanggal_akhir_search_date="";
		var fpiutang_carabayar_search=null;
		var fpiutang_keterangan_search=null;
		var fpiutang_status_search=null;

		if(fpiutang_idSearchField.getValue()!==null){fpiutang_id_search=fpiutang_idSearchField.getValue();}
		if(fpiutang_noSearchField.getValue()!==null){fpiutang_no_search=fpiutang_noSearchField.getValue();}
		if(fpiutang_tanggalSearchField.getValue()!==""){fpiutang_tanggal_search_date=fpiutang_tanggalSearchField.getValue().format('Y-m-d');}
		if(fpiutang_tanggal_akhirSearchField.getValue()!==""){fpiutang_tanggal_akhir_search_date=fpiutang_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(fpiutang_carabayarSearchField.getValue()!==null){fpiutang_carabayar_search=fpiutang_carabayarSearchField.getValue();}
		if(fpiutang_keteranganSearchField.getValue()!==null){fpiutang_keterangan_search=fpiutang_keteranganSearchField.getValue();}
		if(fpiutang_statusSearchField.getValue()!==null){fpiutang_status_search=fpiutang_statusSearchField.getValue();}
		
		// change the store parameters
		master_lunas_piutang_DataStore.baseParams = {
			task				: 'SEARCH',
			fpiutang_id			:	fpiutang_id_search, 
			fpiutang_no			:	fpiutang_no_search, 
			fpiutang_tgl_awal		:	fpiutang_tanggal_search_date, 
			fpiutang_tgl_akhir		:	fpiutang_tanggal_akhir_search_date, 
			fpiutang_carabayar		:	fpiutang_carabayar_search,
			fpiutang_keterangan	:	fpiutang_keterangan_search,
			fpiutang_status		:	fpiutang_status_search
		};
		master_lunas_piutang_DataStore.reload({params: {start: 0, limit: fpiutang_pageS}});
	}
		
	/* Function for reset search result */
	function master_lunas_piutang_reset_search(){
		// reset the store parameters
		master_lunas_piutang_DataStore.baseParams = { task: 'LIST', start: 0, limit: fpiutang_pageS };
		master_lunas_piutang_DataStore.reload({params: {start: 0, limit: fpiutang_pageS}});
		//master_lunas_piutang_searchWindow.close();
	};
	/* End of Fuction */
	
	function master_lunas_piutang_cetak_faktur(pkid){
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_lunas_piutang&m=print_faktur',
		params: {
			faktur	: pkid
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/fpiutang_faktur.html','fpiutang_faktur','height=800,width=670,resizable=1,scrollbars=1, menubar=1');
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
	
	function master_lunas_piutang_reset_SearchForm(){
		fpiutang_noSearchField.reset();
		fpiutang_tanggalSearchField.reset();
		fpiutang_tanggal_akhirSearchField.reset();
		fpiutang_carabayarSearchField.reset();
		fpiutang_keteranganSearchField.reset();
		fpiutang_statusSearchField.reset();
	}
	/* Field for search */
	/* Identify  fpiutang_id Search Field */
	fpiutang_idSearchField= new Ext.form.NumberField({
		id: 'fpiutang_idSearchField',
		fieldLabel: 'Id Order',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  fpiutang_no Search Field */
	fpiutang_noSearchField= new Ext.form.TextField({
		id: 'fpiutang_noSearchField',
		//fieldLabel: 'No Order',
		fieldLabel: 'No.LP',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  fpiutang_tanggal Search Field */
	fpiutang_tanggalSearchField= new Ext.form.DateField({
		id: 'fpiutang_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
//		value: firstday
	
	});

	fpiutang_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'fpiutang_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
//		value: today	
	});
	
	fpiutang_label_tanggal_labelField=new Ext.form.Label({html: 'Tanggal :' });
	
	fpiutang_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });
	
	fpiutang_tanggalSearchFieldSet=new Ext.form.FieldSet({
		id:'fpiutang_tanggalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[fpiutang_tanggalSearchField, fpiutang_label_tanggalField, fpiutang_tanggal_akhirSearchField]
	});

	/* Identify  fpiutang_carabayar Search Field */
	fpiutang_carabayarSearchField= new Ext.form.ComboBox({
		id: 'fpiutang_carabayarSearchField',
		fieldLabel: 'Cara Pembayaran',
		store:new Ext.data.SimpleStore({
			fields:['value', 'fpiutang_carabayar'],
			data:[['Tunai','Tunai'],['Kredit','Kredit'],['Konsinyasi','Konsinyasi']]
		}),
		mode: 'local',
		displayField: 'fpiutang_carabayar',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'	 
	});

	/* Identify  fpiutang_keterangan Search Field */
	fpiutang_keteranganSearchField= new Ext.form.TextField({
		id: 'fpiutang_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	fpiutang_statusSearchField= new Ext.form.ComboBox({
		id: 'fpiutang_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'fpiutang_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'fpiutang_status',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'	 
	});

    
	/* Function for retrieve search Form Panel */
	master_lunas_piutang_searchForm = new Ext.FormPanel({
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
				items: [
					fpiutang_noSearchField, 
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
								fpiutang_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								fpiutang_tanggal_akhirSearchField
							]
						}						
				        ]
					},
					fpiutang_carabayarSearchField, 
					fpiutang_keteranganSearchField,
					fpiutang_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_lunas_piutang_list_search
			},{
				text: 'Close',
				handler: function(){
					master_lunas_piutang_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_lunas_piutang_searchWindow = new Ext.Window({
		title: 'Percarian Order Pembelian',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_lunas_piutang_search',
		items: master_lunas_piutang_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_lunas_piutang_searchWindow.isVisible()){
			master_lunas_piutang_reset_SearchForm();
			master_lunas_piutang_searchWindow.show();
		} else {
			master_lunas_piutang_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	//EVENTS
	
	function detail_pelunasan_total(){
		var jml_bayar_field = 0;
		var sisa_piutang_field = 0;
		for(i=0;i<detail_fpiutang_bylp_DataStore.getCount();i++){
			jml_bayar_field+=detail_fpiutang_bylp_DataStore.getAt(i).data.dpiutang_nilai;
		}
		fpiutang_bayar_cfField.setValue(CurrencyFormatted(jml_bayar_field));
		fpiutang_bayarField.setValue(jml_bayar_field);
		
		sisa_piutang_field = fpiutang_totalField.getValue()-jml_bayar_field;
		fpiutang_sisa_cfField.setValue(CurrencyFormatted(sisa_piutang_field));
		fpiutang_sisaField.setValue(sisa_piutang_field);
	}
	
	master_lunas_piutang_DataStore.load({params:{start:0, limit: fpiutang_pageS}});
	detail_fpiutang_bylp_DataStore.on("load",detail_pelunasan_total);
	
	master_lunas_piutangListEditorGrid.addListener('rowcontextmenu', onmaster_lunas_piutang_ListEditGridContextMenu);
	
	detail_fpiutang_bylp_DataStore.on("update",function(){
		detail_pelunasan_total();
		stat='EDIT';
	});
	
	detail_fpiutang_bylp_DataStore.on("load", function(){
		if(detail_fpiutang_bylp_DataStore.getCount()==fpiutang_pageS && detail_fpiutang_bylp_DataStore.getTotalCount()>fpiutang_pageS){
			detail_fpiutang_bAdd.disabled=true;
		}else{
			detail_fpiutang_bAdd.disabled=false;
		}
	});
	
	function fpiutang_btn_cancel(){
		master_lunas_piutang_reset_form();
		fpiutang_caraField.setValue("card");
		master_lunas_piutang_cardGroup.setVisible(true);
		fpiutang_post2db="CREATE";
		cbo_fpiutang_customerDataStore.reload();
	}
	
	function pertamax(){
		fpiutang_caraField.setValue('card');
		master_lunas_piutang_cardGroup.setVisible(true);
	}
	pertamax();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_lunas_piutang"></div>
         <div id="fp_detail_fpiutang"></div>
		<div id="elwindow_master_lunas_piutang_create"></div>
        <div id="elwindow_master_lunas_piutang_search"></div>
    </div>
</div>
</body>