<?
	//MIRACLE IT TEAM
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
var master_jual_rawat_DataStore;
var kwitansi_jual_rawat_DataStore;
var card_jual_rawat_DataStore;
var cek_jual_rawat_DataStore;
var transfer_jual_rawat_DataStore;
//
var master_jual_rawat_ColumnModel;
var master_jual_rawatListEditorGrid;
var master_jual_rawat_createForm;
var master_jual_rawat_createWindow;
var master_jual_rawat_searchForm;
var master_jual_rawat_searchWindow;
var master_jual_rawat_SelectedRow;
var master_jual_rawat_ContextMenu;
//for detail data
var detail_jual_rawat_DataStore;
var detail_jual_rawatListEditorGrid;
var detail_jual_rawat_ColumnModel;
var detail_jual_rawat_proxy;
var detail_jual_rawat_writer;
var detail_jual_rawat_reader;
var editor_detail_jual_rawat;

//declare konstant
var jrawat_post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('d-m-Y');
var MIN_CREATE_DATE="<?php echo $this->m_public_function->get_permission($_SESSION[SESSION_GROUPID],38); ?>";

/* declare variable here for Field*/
var jrawat_idField;
var jrawat_nobuktiField;
var jrawat_custField;
var jrawat_tanggalField;
var jrawat_diskonField;
var jrawat_bayarField;
var jrawat_caraField;
var jrawat_cara2Field;
var jrawat_cara3Field;
var jrawat_keteranganField;
var jrawat_ket_diskField;
var jrawat_ket_disk_medisField;
var jrawat_stat_dokField;
//tunai
var jrawat_tunai_nilaiField;
//tunai-2
var jrawat_tunai_nilai2Field;
//tunai-3
var jrawat_tunai_nilai3Field;
//voucher
var jrawat_voucher_noField;
var jrawat_voucher_cashbackField;
//voucher-2
var jrawat_voucher_no2Field;
var jrawat_voucher_cashback2Field;
//voucher-3
var jrawat_voucher_no3Field;
var jrawat_voucher_cashback3Field;

var jrawat_cashback_num;
var jrawat_cashback_medis_num;
var is_member=false;
//kwitansi
var jrawat_kwitansi_namaField;
var jrawat_kwitansi_nilaiField;
var jrawat_kwitansi_noField;
//kwitansi-2
var jrawat_kwitansi_nama2Field;
var jrawat_kwitansi_nilai2Field;
var jrawat_kwitansi_no2Field;
//kwitansi-3
var jrawat_kwitansi_nama3Field;
var jrawat_kwitansi_nilai3Field;
var jrawat_kwitansi_no3Field;

//card
var jrawat_card_namaField;
var jrawat_card_edcField;
var jrawat_card_noField;
var jrawat_card_nilaiField;
//card-2
var jrawat_card_nama2Field;
var jrawat_card_edc2Field;
var jrawat_card_no2Field;
var jrawat_card_nilai2Field;
//card-3
var jrawat_card_nama3Field;
var jrawat_card_edc3Field;
var jrawat_card_no3Field;
var jrawat_card_nilai3Field;

//cek
var jrawat_cek_namaField;
var jrawat_cek_noField;
var jrawat_cek_validField;
var jrawat_cek_bankField;
var jrawat_cek_nilaiField;
//cek-2
var jrawat_cek_nama2Field;
var jrawat_cek_no2Field;
var jrawat_cek_valid2Field;
var jrawat_cek_bank2Field;
var jrawat_cek_nilai2Field;
//cek-3
var jrawat_cek_nama3Field;
var jrawat_cek_no3Field;
var jrawat_cek_valid3Field;
var jrawat_cek_bank3Field;
var jrawat_cek_nilai3Field;

//transfer
var jrawat_transfer_bankField;
var jrawat_transfer_namaField;
var jrawat_transfer_nilaiField;
//transfer-2
var jrawat_transfer_bank2Field;
var jrawat_transfer_nama2Field;
var jrawat_transfer_nilai2Field;
//transfer-3
var jrawat_transfer_bank3Field;
var jrawat_transfer_nama3Field;
var jrawat_transfer_nilai3Field;

var jrawat_idSearchField;
var jrawat_nobuktiSearchField;
var jrawat_custSearchField;
var jrawat_diskonSearchField;
var jrawat_caraSearchField;
var jrawat_keteranganSearchField;
var temp_pajakField;
var dt= new Date();

var cetak_jrawat=0;

//untuk menampung nilai button save harga
	var temp_pajakField= new Ext.form.TextArea({
		id: 'temp_pajakField',
		maxLength: 5,
		anchor: '95%'
	});

function jrawat_cetak(cetak_jrawat_id,customer_id,tanggal){
	Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_jual_rawat&m=print_paper',
		params: { jrawat_id : cetak_jrawat_id ,jrawat_cust : customer_id ,jrawat_tanggal : tanggal},
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./jrawat_paper.html','Cetak Penjualan Perawatan','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function jrawat_cetak2(cetak_jrawat_id,customer_id,tanggal, jrawat_stat_dok_create){
	Ext.MessageBox.show({
		msg: 'Sedang memproses data untuk dicetak.. Mohon tunggu.. ',
		progressText: 'proses...',
		width:350,
		wait:true
	});
	
	Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		timeout: 72000,
		url: 'index.php?c=c_master_jual_rawat&m=print_paper2',
		params: { jrawat_id : cetak_jrawat_id ,jrawat_cust : customer_id ,jrawat_tanggal : tanggal, stat_dok : jrawat_stat_dok_create},
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				Ext.MessageBox.hide(); 
				win = window.open('./jrawat_paper2.html','Cetak Penjualan Perawatan Non Medis','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function jrawat_cetak_print_only(cetak_jrawat_id,customer_id,tanggal){
	Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_jual_rawat&m=print_only',
		params: { jrawat_id : cetak_jrawat_id ,jrawat_cust : customer_id ,jrawat_tanggal : tanggal},
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./jrawat_paper.html','Cetak Penjualan Perawatan','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function jrawat_cetak_print_only2(cetak_jrawat_id,customer_id,tanggal, jrawat_stat_dok_create){
	Ext.MessageBox.show({
		msg: 'Sedang memproses data untuk dicetak.. Mohon tunggu.. ',
		progressText: 'proses...',
		width:350,
		wait:true
	});
	
	Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_jual_rawat&m=print_only2',
		params: { jrawat_id : cetak_jrawat_id ,jrawat_cust : customer_id ,jrawat_tanggal : tanggal, stat_dok : jrawat_stat_dok_create},
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				Ext.MessageBox.hide(); 
				win = window.open('./jrawat_paper2.html','Cetak Penjualan Perawatan Non Medis','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function apaket_cetak(cust_id ,tanggal_ambil){
	//mencetak pengambilan paket saja dari customer di tanggal yang dipilih pada LIST
	Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_jual_rawat&m=print_paper_apaket',
		params: { dapaket_cust : cust_id, tanggal : tanggal_ambil},
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./apaket_paper.html','Cetak Pengambilan Paket','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
				master_jual_rawat_DataStore.reload();
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

function apaket_cetak2(cust_id ,tanggal_ambil, jrawat_nobukti_pajak, jrawat_nobukti_medis_create){
	//mencetak pengambilan paket saja dari customer di tanggal yang dipilih pada LIST

	Ext.MessageBox.show({
		msg: 'Sedang memproses data untuk dicetak.. Mohon tunggu.. ',
		progressText: 'proses...',
		width:350,
		wait:true
	});
	
	Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		timeout: 72000,
		url: 'index.php?c=c_master_jual_rawat&m=print_paper_apaket2',
		params: { dapaket_cust : cust_id, tanggal : tanggal_ambil, jrawat_nobukti_pajak : jrawat_nobukti_pajak, jrawat_nobukti_medis :jrawat_nobukti_medis_create},
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				Ext.MessageBox.hide(); 
				win = window.open('./apaket_paper2.html','Cetak Pengambilan Paket','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
				master_jual_rawat_DataStore.reload();
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

var var_jrawat_dstore = true;
var var_jrawat_dapaket_dstore = true;
var var_jrawat_perawatan_dstore = true;
var var_jrawat_drawat_dstore = true;
var var_jrawat_member_dstore = true;
var var_jrawat_card_dstore = true;
var var_jrawat_tunai_dstore = true;
var var_jrawat_cek_dstore = true;
var var_jrawat_transfer_dstore = true;
var var_jrawat_kwitansi_dstore = true;
var var_jrawat_kwitansi_byref_dstore = true;

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
	jrawat_welcome_msgDataStore = new Ext.data.Store({
		id: 'jrawat_welcome_msgDataStore ',
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
	jrawat_welcome_msgDataStore.load({
		params: {task : "LIST", menu_id : 38},
			callback: function(opts, success, response)  {
				if (success) {					
					if(jrawat_welcome_msgDataStore.getCount()){
						if (jrawat_welcome_msgDataStore.getAt(0).data.welcome_icon == 'INFO') {
							var jrawat_icon = Ext.MessageBox.INFO;
						} else if (jrawat_welcome_msgDataStore.getAt(0).data.welcome_icon == 'WARNING'){
							var jrawat_icon = Ext.MessageBox.WARNING;
						} else if (jrawat_welcome_msgDataStore.getAt(0).data.welcome_icon == 'QUESTION'){
							var jrawat_icon = Ext.MessageBox.QUESTION;
						} else if (jrawat_welcome_msgDataStore.getAt(0).data.welcome_icon == 'ERROR'){
							var jrawat_icon = Ext.MessageBox.ERROR;
						}
						Ext.MessageBox.show({
							title: jrawat_welcome_msgDataStore.getAt(0).data.welcome_title,
							msg: jrawat_welcome_msgDataStore.getAt(0).data.welcome_msg,
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: jrawat_icon
						});
					}
				}
			}
	});	
	
	/*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var jrawat_tanggal_create_date = "";
		if(jrawat_tanggalField.getValue()!== ""){jrawat_tanggal_create_date = jrawat_tanggalField.getValue().format('Y-m-d');} 
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			timeout: 72000,
			url: 'index.php?c=c_master_jual_rawat&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: jrawat_tanggal_create_date
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:		
							master_jual_rawat_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penjualan Perawatan tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
	function master_jual_rawat_create(){
		var drawat_count_create = detail_jual_rawatListEditorGrid.getStore().getCount();
		/*
		 * variable yang diperhatikan:
		 * 1. var jrawat_post2db
		 * 1.a. ==> JIKA ="CREATE" (create langsung dari Kasir Perawatan BUKAN dari Tindakan)
		 * 1.b. ==> JIKA ="UPDATE" (proses edit dari Tindakan)
		 * 2. var cetak_jrawat
		 * 2.a. ==> JIKA =1 (artinya: telah click tombol 'Save and Print')
		 * 2.b. ==> JIKA =0 (artinya: telah click tombol 'Save')
		 * 3. var jrawat_nobuktiField
		 * 3.a. ==> JIKA ='PR' (artinya: proses Editing yang berisi detail perawatan lepas dan/atau detail pengambilan paket)
		 * 3.b. ==> JIKA ='' (artinya: proses Editing yang berisi HANYA detail pengambilan paket)
		 * 4. var drawat_count
		 * 4.a. ==> JIKA >0 (artinya: ada detail perawatan lepas)
		 * 4.b. ==> JIKA =0 (artinya: tidak ada detail perawatan lepas)
		*/
		/* 
		 * KONDISI ==> JIKA jrawat_nobuktiField == '' (artinya: ambil dari List yang hanya pengambilan paket saja dan otomatis jrawat_post2db=="UPDATE")
		 * && drawat_count > 0, maka: ini artinya di Tindakan hanya melakukan pengambilan paket saja dan di Kasir Perawatan si Customer membeli
		 * perawatan non-medis. Untuk itu, yang harus dilakukan adalah:
		 * 1. CREATE db.master_jual_rawat (juga mengenerate No.Faktur)
		 * 2. INSERT db.detail_jual_rawat
		 * 
		*/
        if((jrawat_bayarField.getValue()!==null) && (jrawat_bayarField.getValue()!==undefined) && (jrawat_bayarField.getValue()!=='')
           && (jrawat_totalField.getValue()!==null) && (jrawat_totalField.getValue()!==undefined) && (jrawat_totalField.getValue()!=='')){
            var jrawat_tunai_nilai_create=0;
            var jrawat_tunai_nilai2_create=0;
            var jrawat_tunai_nilai3_create=0;
            var jrawat_voucher_cashback_create=0;
            var jrawat_voucher_cashback2_create=0;
            var jrawat_voucher_cashback3_create=0;
            var jrawat_kwitansi_nilai_create=0;
            var jrawat_kwitansi_nilai2_create=0;
            var jrawat_kwitansi_nilai3_create=0;
            var jrawat_card_nilai_create=0;
            var jrawat_card_nilai2_create=0;
            var jrawat_card_nilai3_create=0;
            var jrawat_cek_nilai_create=0;
            var jrawat_cek_nilai2_create=0;
            var jrawat_cek_nilai3_create=0;
            var jrawat_transfer_nilai_create=0;
            var jrawat_transfer_nilai2_create=0;
            var jrawat_transfer_nilai3_create=0;
            var total_nilai_bayar = 0;
            
            if((jrawat_tunai_nilaiField.getValue()!==null) && (jrawat_tunai_nilaiField.getValue()!==undefined) && (jrawat_tunai_nilaiField.getValue()!=='')
               && (jrawat_tunai_nilaiField.getValue()!==0)){
                jrawat_tunai_nilai_create = jrawat_tunai_nilaiField.getValue();
            }
            if((jrawat_tunai_nilai2Field.getValue()!==null) && (jrawat_tunai_nilai2Field.getValue()!==undefined) && (jrawat_tunai_nilai2Field.getValue()!=='')
               && (jrawat_tunai_nilai2Field.getValue()!==0)){
                jrawat_tunai_nilai2_create = jrawat_tunai_nilai2Field.getValue();
            }
            if((jrawat_tunai_nilai3Field.getValue()!==null) && (jrawat_tunai_nilai3Field.getValue()!==undefined) && (jrawat_tunai_nilai3Field.getValue()!=='')
               && (jrawat_tunai_nilai3Field.getValue()!==0)){
                jrawat_tunai_nilai3_create = jrawat_tunai_nilai3Field.getValue();
            }
            if((jrawat_voucher_cashbackField.getValue()!==null) && (jrawat_voucher_cashbackField.getValue()!==undefined) && (jrawat_voucher_cashbackField.getValue()!=='')
               && (jrawat_voucher_cashbackField.getValue()!==0)){
                jrawat_voucher_cashback_create = jrawat_voucher_cashbackField.getValue();
            }
            if((jrawat_voucher_cashback2Field.getValue()!==null) && (jrawat_voucher_cashback2Field.getValue()!==undefined) && (jrawat_voucher_cashback2Field.getValue()!=='')
               && (jrawat_voucher_cashback2Field.getValue()!==0)){
                jrawat_voucher_cashback2_create = jrawat_voucher_cashback2Field.getValue();
            }
            if((jrawat_voucher_cashback3Field.getValue()!==null) && (jrawat_voucher_cashback3Field.getValue()!==undefined) && (jrawat_voucher_cashback3Field.getValue()!=='')
               && (jrawat_voucher_cashback3Field.getValue()!==0)){
                jrawat_voucher_cashback3_create = jrawat_voucher_cashback3Field.getValue();
            }
            if((jrawat_kwitansi_nilaiField.getValue()!==null) && (jrawat_kwitansi_nilaiField.getValue()!==undefined) && (jrawat_kwitansi_nilaiField.getValue()!=='')
               && (jrawat_kwitansi_nilaiField.getValue()!==0)){
                jrawat_kwitansi_nilai_create = jrawat_kwitansi_nilaiField.getValue();
            }
            if((jrawat_kwitansi_nilai2Field.getValue()!==null) && (jrawat_kwitansi_nilai2Field.getValue()!==undefined) && (jrawat_kwitansi_nilai2Field.getValue()!=='')
               && (jrawat_kwitansi_nilai2Field.getValue()!==0)){
                jrawat_kwitansi_nilai2_create = jrawat_kwitansi_nilai2Field.getValue();
            }
            if((jrawat_kwitansi_nilai3Field.getValue()!==null) && (jrawat_kwitansi_nilai3Field.getValue()!==undefined) && (jrawat_kwitansi_nilai3Field.getValue()!=='')
               && (jrawat_kwitansi_nilai3Field.getValue()!==0)){
                jrawat_kwitansi_nilai3_create = jrawat_kwitansi_nilai3Field.getValue();
            }
            if((jrawat_card_nilaiField.getValue()!==null) && (jrawat_card_nilaiField.getValue()!==undefined) && (jrawat_card_nilaiField.getValue()!=='')
               && (jrawat_card_nilaiField.getValue()!==0)){
                jrawat_card_nilai_create = jrawat_card_nilaiField.getValue();
            }
            if((jrawat_card_nilai2Field.getValue()!==null) && (jrawat_card_nilai2Field.getValue()!==undefined) && (jrawat_card_nilai2Field.getValue()!=='')
               && (jrawat_card_nilai2Field.getValue()!==0)){
                jrawat_card_nilai2_create = jrawat_card_nilai2Field.getValue();
            }
            if((jrawat_card_nilai3Field.getValue()!==null) && (jrawat_card_nilai3Field.getValue()!==undefined) && (jrawat_card_nilai3Field.getValue()!=='')
               && (jrawat_card_nilai3Field.getValue()!==0)){
                jrawat_card_nilai3_create = jrawat_card_nilai3Field.getValue();
            }
            if((jrawat_cek_nilaiField.getValue()!==null) && (jrawat_cek_nilaiField.getValue()!==undefined) && (jrawat_cek_nilaiField.getValue()!=='')
               && (jrawat_cek_nilaiField.getValue()!==0)){
                jrawat_cek_nilai_create = jrawat_cek_nilaiField.getValue();
            }
            if((jrawat_cek_nilai2Field.getValue()!==null) && (jrawat_cek_nilai2Field.getValue()!==undefined) && (jrawat_cek_nilai2Field.getValue()!=='')
               && (jrawat_cek_nilai2Field.getValue()!==0)){
                jrawat_cek_nilai2_create = jrawat_cek_nilai2Field.getValue();
            }
            if((jrawat_cek_nilai3Field.getValue()!==null) && (jrawat_cek_nilai3Field.getValue()!==undefined) && (jrawat_cek_nilai3Field.getValue()!=='')
               && (jrawat_cek_nilai3Field.getValue()!==0)){
                jrawat_cek_nilai3_create = jrawat_cek_nilai3Field.getValue();
            }
            if((jrawat_transfer_nilaiField.getValue()!==null) && (jrawat_transfer_nilaiField.getValue()!==undefined) && (jrawat_transfer_nilaiField.getValue()!=='')
               && (jrawat_transfer_nilaiField.getValue()!==0)){
                jrawat_transfer_nilai_create = jrawat_transfer_nilaiField.getValue();
            }
            if((jrawat_transfer_nilai2Field.getValue()!==null) && (jrawat_transfer_nilai2Field.getValue()!==undefined) && (jrawat_transfer_nilai2Field.getValue()!=='')
               && (jrawat_transfer_nilai2Field.getValue()!==0)){
                jrawat_transfer_nilai2_create = jrawat_transfer_nilai2Field.getValue();
            }
            if((jrawat_transfer_nilai3Field.getValue()!==null) && (jrawat_transfer_nilai3Field.getValue()!==undefined) && (jrawat_transfer_nilai3Field.getValue()!=='')
               && (jrawat_transfer_nilai3Field.getValue()!==0)){
                jrawat_transfer_nilai3_create = jrawat_transfer_nilai3Field.getValue();
            }
            total_nilai_bayar = jrawat_tunai_nilai_create + jrawat_tunai_nilai2_create + jrawat_tunai_nilai3_create
            + jrawat_voucher_cashback_create + jrawat_voucher_cashback2_create + jrawat_voucher_cashback3_create
            + jrawat_kwitansi_nilai_create + jrawat_kwitansi_nilai2_create + jrawat_kwitansi_nilai3_create
            + jrawat_card_nilai_create + jrawat_card_nilai2_create + jrawat_card_nilai3_create
            + jrawat_cek_nilai_create + jrawat_cek_nilai2_create + jrawat_cek_nilai3_create
            + jrawat_transfer_nilai_create + jrawat_transfer_nilai2_create + jrawat_transfer_nilai3_create;
            
            if(((total_nilai_bayar>0) && (jrawat_bayarField.getValue()>0) && (jrawat_bayarField.getValue()<=jrawat_totalField.getValue()))
               || ((total_nilai_bayar==0) && (jrawat_bayarField.getValue()==0) && (jrawat_totalField.getValue()>=0))){
                if(is_master_jual_rawat_form_valid()
                   && ((/^\d+$/.test(jrawat_custField.getValue()) && jrawat_post2db=="CREATE") || jrawat_post2db=="UPDATE")
                   && jrawat_stat_dokField.getValue()=='Terbuka'){
                    var jrawat_id_create_pk=0; 
                    var jrawat_nobukti_create=''; 
					var jrawat_nobukti_medis_create=''; 
					var jrawat_nobukti_pajak_create=''; 
					var jrawat_total_medis_create = 0;
					var jrawat_total_nonmedis_create = 0;
                    var jrawat_cust_create=0; 
                    var jrawat_tanggal_create_date=""; 
                    var jrawat_diskon_create=0; 
                    var jrawat_cara_create=null; 
                    var jrawat_cara2_create=null; 
                    var jrawat_cara3_create=null; 
                    var jrawat_keterangan_create=''; 
                    var jrawat_ket_disk_create=''; 
					var jrawat_ket_disk_medis_create='';
                    var jrawat_stat_dok_create='';
                    var jrawat_grooming_create=0;
       
                    var jrawat_voucher_no_create='';
                    var jrawat_voucher_no2_create='';
                    var jrawat_voucher_no3_create='';
   
                    var jrawat_cashback_create=0;
					var jrawat_cashback_medis_create=0;
                    //bayar
                    var jrawat_subtotal_create=0;
                    var jrawat_total_create=0;
                    var jrawat_bayar_create=0;
                    var jrawat_hutang_create=0;
                    //kwitansi
                    var jrawat_kwitansi_nama_create='';
                    var jrawat_kwitansi_nomor_create='';
                    //kwitansi-2
                    var jrawat_kwitansi_nama2_create='';
                    var jrawat_kwitansi_nomor2_create='';
                    //kwitansi-3
                    var jrawat_kwitansi_nama3_create='';
                    var jrawat_kwitansi_nomor3_create='';
                    //card
                    var jrawat_card_nama_create='';
                    var jrawat_card_edc_create='';
                    var jrawat_card_no_create='';
                    //card-2
                    var jrawat_card_nama2_create='';
                    var jrawat_card_edc2_create='';
                    var jrawat_card_no2_create='';
                    //card-3
                    var jrawat_card_nama3_create='';
                    var jrawat_card_edc3_create='';
                    var jrawat_card_no3_create='';
                    //cek
                    var jrawat_cek_nama_create='';
                    var jrawat_cek_nomor_create='';
                    var jrawat_cek_valid_create="";
                    var jrawat_cek_bank_create='';
                    //cek-2
                    var jrawat_cek_nama2_create='';
                    var jrawat_cek_nomor2_create='';
                    var jrawat_cek_valid2_create="";
                    var jrawat_cek_bank2_create='';
                    //cek-3
                    var jrawat_cek_nama3_create='';
                    var jrawat_cek_nomor3_create='';
                    var jrawat_cek_valid3_create="";
                    var jrawat_cek_bank3_create='';
                    //transfer
                    var jrawat_transfer_bank_create='';
                    var jrawat_transfer_nama_create='';
                    //transfer-2
                    var jrawat_transfer_bank2_create='';
                    var jrawat_transfer_nama2_create='';
                    //transfer-3
                    var jrawat_transfer_bank3_create='';
                    var jrawat_transfer_nama3_create='';
                    
                    if(/^\d+$/.test(jrawat_custField.getValue())){
                        jrawat_cust_create = jrawat_custField.getValue();
                    }else{
                        jrawat_cust_create = jrawat_cust_idField.getValue();
                    }
                    if((jrawat_idField.getValue()!==null) && (jrawat_idField.getValue()!=='') && (jrawat_idField.getValue()!==0)){jrawat_id_create_pk = jrawat_idField.getValue();}else{jrawat_id_create_pk=get_pk_id();} 
                    if(jrawat_nobuktiField.getValue()!== null){jrawat_nobukti_create = jrawat_nobuktiField.getValue();} 
					if(jrawat_no_faktur_medisField.getValue()!== null){jrawat_nobukti_medis_create = jrawat_no_faktur_medisField.getValue();}
					if(jrawat_no_faktur_pajakField.getValue()!== null){jrawat_nobukti_pajak_create = jrawat_no_faktur_pajakField.getValue();}
                    if(jrawat_karyawanField.getValue()!== null){jrawat_grooming_create = jrawat_karyawanField.getValue();}				
                    if(jrawat_tanggalField.getValue()!== ""){jrawat_tanggal_create_date = jrawat_tanggalField.getValue().format('Y-m-d');} 
                    //if(jrawat_diskonField.getValue()!== null){jrawat_diskon_create = jrawat_diskonField.getValue();} 
                    if(jrawat_caraField.getValue()!== null){jrawat_cara_create = jrawat_caraField.getValue();} 
                    if(jrawat_cara2Field.getValue()!== null){jrawat_cara2_create = jrawat_cara2Field.getValue();} 
                    if(jrawat_cara3Field.getValue()!== null){jrawat_cara3_create = jrawat_cara3Field.getValue();} 
                    if(jrawat_keteranganField.getValue()!== null){jrawat_keterangan_create = jrawat_keteranganField.getValue();} 
                    if(jrawat_ket_diskField.getValue()!== null){jrawat_ket_disk_create = jrawat_ket_diskField.getValue();}
					if(jrawat_ket_disk_medisField.getValue()!== null){jrawat_ket_disk_medis_create = jrawat_ket_disk_medisField.getValue();}
					
                    if(jrawat_stat_dokField.getValue()!== null){jrawat_stat_dok_create = jrawat_stat_dokField.getValue();} 
                    //voucher
                    if(jrawat_voucher_noField.getValue()!== null){jrawat_voucher_no_create = jrawat_voucher_noField.getValue();} 
                    //if(jrawat_voucher_cashbackField.getValue()!== null){jrawat_voucher_cashback_create = jrawat_voucher_cashbackField.getValue();} 
                    //voucher-2
                    if(jrawat_voucher_no2Field.getValue()!== null){jrawat_voucher_no2_create = jrawat_voucher_no2Field.getValue();} 
                    //if(jrawat_voucher_cashback2Field.getValue()!== null){jrawat_voucher_cashback2_create = jrawat_voucher_cashback2Field.getValue();} 
                    //voucher-3
                    if(jrawat_voucher_no3Field.getValue()!== null){jrawat_voucher_no3_create = jrawat_voucher_no3Field.getValue();} 
                    //if(jrawat_voucher_cashback3Field.getValue()!== null){jrawat_voucher_cashback3_create = jrawat_voucher_cashback3Field.getValue();} 
                    if(jrawat_cashback_num.getValue()!== null){jrawat_cashback_create = jrawat_cashback_num.getValue();} 
					if(jrawat_cashback_medis_num.getValue()!== null){jrawat_cashback_medis_create = jrawat_cashback_medis_num.getValue();}
								
                    //bayar
                    if(jrawat_totalField.getValue()!== null){jrawat_total_create = jrawat_totalField.getValue();}
                    if(jrawat_bayarField.getValue()!== null){jrawat_bayar_create = jrawat_bayarField.getValue();}
                    if(jrawat_subTotalField.getValue()!== null){jrawat_subtotal_create = jrawat_subTotalField.getValue();} 
                    if(jrawat_hutangField.getValue()!== null){jrawat_hutang_create = jrawat_hutangField.getValue();} 
					if(jrawat_total_medisField.getValue()!== null){jrawat_total_medis_create = jrawat_total_medisField.getValue();}
					if(jrawat_total_nonmedisField.getValue()!== null){jrawat_total_nonmedis_create = jrawat_total_nonmedisField.getValue();}
                    //kwitansi value
					/*
                    if((jrawat_kwitansi_noField.getValue()!== null) && (jrawat_kwitansi_noField.getValue()!=='')){
                        if(/^\d+$/.test(jrawat_kwitansi_noField.getValue())){
                            jrawat_kwitansi_nomor_create = jrawat_kwitansi_noField.getValue();
                        }else{
                            jrawat_kwitansi_nomor_create = jrawat_kwitansi_noField.getValue();
							//jrawat_kwitansi_nomor_create = jrawat_kwitansi_no_idField.getValue();
                        }
                    }
                    */
                    if(jrawat_kwitansi_namaField.getValue()!== null){jrawat_kwitansi_nama_create = jrawat_kwitansi_namaField.getValue();} 
                    if((jrawat_kwitansi_nilaiField.getValue()!==null) && (jrawat_kwitansi_nilaiField.getValue()!=='') && (jrawat_kwitansi_nilaiField.getValue()!==0)){jrawat_kwitansi_nilai_create = jrawat_kwitansi_nilaiField.getValue();} 
                    //kwitansi-2 value
					/*
                    if((jrawat_kwitansi_no2Field.getValue()!== null) && (jrawat_kwitansi_no2Field.getValue()!=='')){
                        if(/^\d+$/.test(jrawat_kwitansi_no2Field.getValue())){
                            jrawat_kwitansi_nomor2_create = jrawat_kwitansi_no2Field.getValue();
                        }else{
                            jrawat_kwitansi_nomor2_create = jrawat_kwitansi_no2_idField.getValue();
                        }
                    }
					*/
                    if(jrawat_kwitansi_nama2Field.getValue()!== null){jrawat_kwitansi_nama2_create = jrawat_kwitansi_nama2Field.getValue();} 
                    if((jrawat_kwitansi_nilai2Field.getValue()!==null) && (jrawat_kwitansi_nilai2Field.getValue()!==null) && (jrawat_kwitansi_nilai2Field.getValue()!==0)){jrawat_kwitansi_nilai2_create = jrawat_kwitansi_nilai2Field.getValue();} 
                    //kwitansi-3 value
					/*
                    if((jrawat_kwitansi_no3Field.getValue()!== null) && (jrawat_kwitansi_no3Field.getValue()!=='')){
                        if(/^\d+$/.test(jrawat_kwitansi_no3Field.getValue())){
                            jrawat_kwitansi_nomor3_create = jrawat_kwitansi_no3Field.getValue();
                        }else{
                            jrawat_kwitansi_nomor3_create = jrawat_kwitansi_no3_idField.getValue();
                        }
                    }
					*/
                    if(jrawat_kwitansi_nama3Field.getValue()!== null){jrawat_kwitansi_nama3_create = jrawat_kwitansi_nama3Field.getValue();} 
                    if((jrawat_kwitansi_nilai3Field.getValue()!==null) && (jrawat_kwitansi_nilai3Field.getValue()!=='') && (jrawat_kwitansi_nilai3Field.getValue()!==0)){jrawat_kwitansi_nilai3_create = jrawat_kwitansi_nilai3Field.getValue();} 
                    //card value
                    if(jrawat_card_namaField.getValue()!== null){jrawat_card_nama_create = jrawat_card_namaField.getValue();} 
                    if(jrawat_card_edcField.getValue()!==null){jrawat_card_edc_create = jrawat_card_edcField.getValue();} 
                    if(jrawat_card_noField.getValue()!==null){jrawat_card_no_create = jrawat_card_noField.getValue();}
                    //if((jrawat_card_nilaiField.getValue()!==null) && (jrawat_card_nilaiField.getValue()!=='') && (jrawat_card_nilaiField.getValue()!==0)){jrawat_card_nilai_create = jrawat_card_nilaiField.getValue();} 
                    //card-2 value
                    if(jrawat_card_nama2Field.getValue()!== null){jrawat_card_nama2_create = jrawat_card_nama2Field.getValue();} 
                    if(jrawat_card_edc2Field.getValue()!==null){jrawat_card_edc2_create = jrawat_card_edc2Field.getValue();} 
                    if(jrawat_card_no2Field.getValue()!==null){jrawat_card_no2_create = jrawat_card_no2Field.getValue();}
                    //if((jrawat_card_nilai2Field.getValue()!==null) && (jrawat_card_nilai2Field.getValue()!=='') && (jrawat_card_nilai2Field.getValue()!==0)){jrawat_card_nilai2_create = jrawat_card_nilai2Field.getValue();} 
                    //card-3 value
                    if(jrawat_card_nama3Field.getValue()!== null){jrawat_card_nama3_create = jrawat_card_nama3Field.getValue();} 
                    if(jrawat_card_edc3Field.getValue()!==null){jrawat_card_edc3_create = jrawat_card_edc3Field.getValue();} 
                    if(jrawat_card_no3Field.getValue()!==null){jrawat_card_no3_create = jrawat_card_no3Field.getValue();}
                    //if((jrawat_card_nilai3Field.getValue()!==null) && (jrawat_card_nilai3Field.getValue()!=='') && (jrawat_card_nilai3Field.getValue()!==0)){jrawat_card_nilai3_create = jrawat_card_nilai3Field.getValue();} 
                    //cek value
                    if(jrawat_cek_namaField.getValue()!== null){jrawat_cek_nama_create = jrawat_cek_namaField.getValue();} 
                    if(jrawat_cek_noField.getValue()!== null){jrawat_cek_nomor_create = jrawat_cek_noField.getValue();} 
                    if(jrawat_cek_validField.getValue()!== ""){jrawat_cek_valid_create = jrawat_cek_validField.getValue().format('Y-m-d');} 
                    if(jrawat_cek_bankField.getValue()!== null){jrawat_cek_bank_create = jrawat_cek_bankField.getValue();} 
                    //if((jrawat_cek_nilaiField.getValue()!==null) && (jrawat_cek_nilaiField.getValue()!=='') && (jrawat_cek_nilaiField.getValue()!==0)){jrawat_cek_nilai_create = jrawat_cek_nilaiField.getValue();} 
                    //cek-2 value
                    if(jrawat_cek_nama2Field.getValue()!== null){jrawat_cek_nama2_create = jrawat_cek_nama2Field.getValue();} 
                    if(jrawat_cek_no2Field.getValue()!== null){jrawat_cek_nomor2_create = jrawat_cek_no2Field.getValue();} 
                    if(jrawat_cek_valid2Field.getValue()!== ""){jrawat_cek_valid2_create = jrawat_cek_valid2Field.getValue().format('Y-m-d');} 
                    if(jrawat_cek_bank2Field.getValue()!== null){jrawat_cek_bank2_create = jrawat_cek_bank2Field.getValue();} 
                    //if((jrawat_cek_nilai2Field.getValue()!==null) && (jrawat_cek_nilai2Field.getValue()!=='') && (jrawat_cek_nilai2Field.getValue()!==0)){jrawat_cek_nilai2_create = jrawat_cek_nilai2Field.getValue();} 
                    //cek-3 value
                    if(jrawat_cek_nama3Field.getValue()!== null){jrawat_cek_nama3_create = jrawat_cek_nama3Field.getValue();} 
                    if(jrawat_cek_no3Field.getValue()!== null){jrawat_cek_nomor3_create = jrawat_cek_no3Field.getValue();} 
                    if(jrawat_cek_valid3Field.getValue()!== ""){jrawat_cek_valid3_create = jrawat_cek_valid3Field.getValue().format('Y-m-d');} 
                    if(jrawat_cek_bank3Field.getValue()!== null){jrawat_cek_bank3_create = jrawat_cek_bank3Field.getValue();} 
                    //if((jrawat_cek_nilai3Field.getValue()!==null) && (jrawat_cek_nilai3Field.getValue()!=='') && (jrawat_cek_nilai3Field.getValue()!==0)){jrawat_cek_nilai3_create = jrawat_cek_nilai3Field.getValue();} 
                    //transfer value
                    if(jrawat_transfer_bankField.getValue()!== null){jrawat_transfer_bank_create = jrawat_transfer_bankField.getValue();} 
                    if(jrawat_transfer_namaField.getValue()!== null){jrawat_transfer_nama_create = jrawat_transfer_namaField.getValue();}
                    //if((jrawat_transfer_nilaiField.getValue()!==null) && (jrawat_transfer_nilaiField.getValue()!=='') && (jrawat_transfer_nilaiField.getValue()!==0)){jrawat_transfer_nilai_create = jrawat_transfer_nilaiField.getValue();} 
                    //transfer-2 value
                    if(jrawat_transfer_bank2Field.getValue()!== null){jrawat_transfer_bank2_create = jrawat_transfer_bank2Field.getValue();} 
                    if(jrawat_transfer_nama2Field.getValue()!== null){jrawat_transfer_nama2_create = jrawat_transfer_nama2Field.getValue();}
                    //if((jrawat_transfer_nilai2Field.getValue()!==null) && (jrawat_transfer_nilai2Field.getValue()!=='') && (jrawat_transfer_nilai2Field.getValue()!==0)){jrawat_transfer_nilai2_create = jrawat_transfer_nilai2Field.getValue();} 
                    //transfer-3 value
                    if(jrawat_transfer_bank3Field.getValue()!== null){jrawat_transfer_bank3_create = jrawat_transfer_bank3Field.getValue();} 
                    if(jrawat_transfer_nama3Field.getValue()!== null){jrawat_transfer_nama3_create = jrawat_transfer_nama3Field.getValue();}
                    //if((jrawat_transfer_nilai3Field.getValue()!==null) && (jrawat_transfer_nilai3Field.getValue()!=='') && (jrawat_transfer_nilai3Field.getValue()!==0)){jrawat_transfer_nilai3_create = jrawat_transfer_nilai3Field.getValue();}
                    
                    var dcount_drawat_id_create = 0;
                    for(i=0; i<detail_jual_rawat_DataStore.getCount();i++){
                        if(detail_jual_rawat_DataStore.getAt(i).data.drawat_id==0){
                            dcount_drawat_id_create = dcount_drawat_id_create+1;
                        }
                    }

				// Penambahan Detail Penjualan Perawatan
                    var drawat_id = [];
                    var drawat_dtrawat = [];
                    var drawat_rawat = [];
                    var drawat_jumlah = [];
                    var drawat_karyawan=[];
                    var drawat_harga = [];
                    var drawat_diskon = [];
                    var drawat_diskon_jenis = [];
                    var drawat_sales = [];
                    var dcount = detail_jual_rawat_DataStore.getCount() - 1;
                    
                    if(detail_jual_rawat_DataStore.getCount()>0){
                        for(i=0; i<detail_jual_rawat_DataStore.getCount();i++){
                            if((/^\d+$/.test(detail_jual_rawat_DataStore.getAt(i).data.drawat_rawat))
                               && detail_jual_rawat_DataStore.getAt(i).data.drawat_rawat!==undefined
                               && detail_jual_rawat_DataStore.getAt(i).data.drawat_rawat!==''
                               && detail_jual_rawat_DataStore.getAt(i).data.drawat_rawat!==0){
                                
                                drawat_id.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_id);
                                
                                if((detail_jual_rawat_DataStore.getAt(i).data.drawat_dtrawat==undefined) || (detail_jual_rawat_DataStore.getAt(i).data.drawat_dtrawat=='')){
                                    drawat_dtrawat.push(0);
                                }else{
                                    drawat_dtrawat.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_dtrawat);
                                }
                                
                                drawat_rawat.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_rawat);
                                
                                if((detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah==undefined) || (detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah=='') || (detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah==0)){
                                    drawat_jumlah.push(1);
                                }else{
                                    drawat_jumlah.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah);
                                }
                                
                                if(detail_jual_rawat_DataStore.getAt(i).data.drawat_harga==undefined){
                                    drawat_harga.push(0);
                                }else{
                                    drawat_harga.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_harga);
                                }
                                
                                if(detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon==undefined){
                                    drawat_diskon.push(0);
                                }else{
                                    drawat_diskon.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon);
                                }
                                
                                if(detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon_jenis==undefined){
                                    drawat_diskon_jenis.push('');
                                }else{
                                    drawat_diskon_jenis.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon_jenis);
                                }
                                
                                /* by fred*/
                                if((detail_jual_rawat_DataStore.getAt(i).data.drawat_sales==undefined) || (detail_jual_rawat_DataStore.getAt(i).data.drawat_sales=='')){
                                    drawat_sales.push(0);
                                }else{
                                    drawat_sales.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_sales);
                                }
                                
                                //drawat_sales.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_sales);
                                
                                if((detail_jual_rawat_DataStore.getAt(i).data.drawat_karyawan==undefined)
                                   || (detail_jual_rawat_DataStore.getAt(i).data.drawat_karyawan=='')){
                                    drawat_karyawan.push(0);
                                }else{
                                    drawat_karyawan.push(detail_jual_rawat_DataStore.getAt(i).data.drawat_karyawan);
                                }
                                
                            }
                        }
                    }
                    
                    var encoded_array_drawat_id = Ext.encode(drawat_id);
                    var encoded_array_drawat_dtrawat = Ext.encode(drawat_dtrawat);
                    var encoded_array_drawat_rawat = Ext.encode(drawat_rawat);
                    var encoded_array_drawat_jumlah = Ext.encode(drawat_jumlah);
                    var encoded_array_drawat_harga = Ext.encode(drawat_harga);
                    var encoded_array_drawat_diskon = Ext.encode(drawat_diskon);
                    var encoded_array_drawat_diskon_jenis = Ext.encode(drawat_diskon_jenis);
                    var encoded_array_drawat_sales = Ext.encode(drawat_sales);
                    var encoded_array_drawat_karyawan = Ext.encode(drawat_karyawan);
            
                    Ext.Ajax.request({  
                        waitMsg: 'Please wait...',
                        waitMsg: 'Mohon tunggu...',
						timeout: 72000,
                        url: 'index.php?c=c_master_jual_rawat&m=get_action',
                        params: {
                            task: jrawat_post2db,
                            cetak_jrawat:cetak_jrawat,
                            drawat_count: drawat_count_create,
                            dcount_drawat_id: dcount_drawat_id_create,
                            jrawat_id			: 	jrawat_id_create_pk, 
                            jrawat_grooming	:	jrawat_grooming_create,
                            jrawat_nobukti		: 	jrawat_nobukti_create, 
							jrawat_nobukti_medis		: 	jrawat_nobukti_medis_create,
							jrawat_nobukti_pajak		: 	jrawat_nobukti_pajak_create,
							jrawat_total_medis : jrawat_total_medis_create,
							jrawat_total_nonmedis : jrawat_total_nonmedis_create,
                            jrawat_cust		: 	jrawat_cust_create, 
                            jrawat_tanggal		: 	jrawat_tanggal_create_date, 
                           // jrawat_diskon		: 	jrawat_diskon_create, 
                            jrawat_cara		: 	jrawat_cara_create, 
                            jrawat_cara2		: 	jrawat_cara2_create, 
                            jrawat_cara3		: 	jrawat_cara3_create, 
                            jrawat_keterangan	: 	jrawat_keterangan_create,
                            jrawat_ket_disk		: 	jrawat_ket_disk_create,
							jrawat_ket_disk_medis : jrawat_ket_disk_medis_create,
                            jrawat_stat_dok		:	jrawat_stat_dok_create,
                            jrawat_cashback	: 	jrawat_cashback_create,
							jrawat_cashback_medis	: 	jrawat_cashback_medis_create,
                            //tunai
                            jrawat_tunai_nilai	:	jrawat_tunai_nilai_create,
                            //tunai-2
                            jrawat_tunai_nilai2	:	jrawat_tunai_nilai2_create,
                            //tunai-3
                            jrawat_tunai_nilai3	:	jrawat_tunai_nilai3_create,
                            //voucher
                            jrawat_voucher_no	:	jrawat_voucher_no_create,
                            jrawat_voucher_cashback	:	jrawat_voucher_cashback_create,
                            //voucher-2
                            jrawat_voucher_no2	:	jrawat_voucher_no2_create,
                            jrawat_voucher_cashback2	:	jrawat_voucher_cashback2_create,
                            //voucher-3
                            jrawat_voucher_no3	:	jrawat_voucher_no3_create,
                            jrawat_voucher_cashback3	:	jrawat_voucher_cashback3_create, 
                            jrawat_voucher_cashback	:	jrawat_voucher_cashback_create,
                            //bayar
                            jrawat_total			: 	jrawat_total_create,
                            jrawat_bayar			: 	jrawat_bayar_create,
                            jrawat_subtotal			: 	jrawat_subtotal_create,
                            jrawat_hutang		: 	jrawat_hutang_create,
                            //kwitansi posting
							jual_kwitansi_id			: 	jrawat_jual_kwitansi_idField1.getValue(),
                            jrawat_kwitansi_no			:	jrawat_kwitansi_noField.getValue(),
                            jrawat_kwitansi_nama		:	jrawat_kwitansi_nama_create,
                            jrawat_kwitansi_nilai		:	jrawat_kwitansi_nilai_create,
                            //kwitansi-2 posting
							jual_kwitansi_id2			: 	jrawat_jual_kwitansi_idField2.getValue(),
                            jrawat_kwitansi_no2			:	jrawat_kwitansi_no2Field.getValue(),
                            jrawat_kwitansi_nama2		:	jrawat_kwitansi_nama2_create,
                            jrawat_kwitansi_nilai2		:	jrawat_kwitansi_nilai2_create,
                            //kwitansi-3 posting
							jual_kwitansi_id3			: 	jrawat_jual_kwitansi_idField3.getValue(),
                            jrawat_kwitansi_no3			:	jrawat_kwitansi_no3Field.getValue(),
                            jrawat_kwitansi_nama3		:	jrawat_kwitansi_nama3_create,
                            jrawat_kwitansi_nilai3		:	jrawat_kwitansi_nilai3_create,
                            //card posting
                            jrawat_card_nama	: 	jrawat_card_nama_create,
                            jrawat_card_edc	:	jrawat_card_edc_create,
                            jrawat_card_no		:	jrawat_card_no_create,
                            jrawat_card_nilai	:	jrawat_card_nilai_create,
                            //card-2 posting
                            jrawat_card_nama2	: 	jrawat_card_nama2_create,
                            jrawat_card_edc2	:	jrawat_card_edc2_create,
                            jrawat_card_no2	:	jrawat_card_no2_create,
                            jrawat_card_nilai2	:	jrawat_card_nilai2_create,
                            //card-3 posting
                            jrawat_card_nama3	: 	jrawat_card_nama3_create,
                            jrawat_card_edc3	:	jrawat_card_edc3_create,
                            jrawat_card_no3	:	jrawat_card_no3_create,
                            jrawat_card_nilai3	:	jrawat_card_nilai3_create,
                            //cek posting
                            jrawat_cek_nama	: 	jrawat_cek_nama_create,
                            jrawat_cek_no		:	jrawat_cek_nomor_create,
                            jrawat_cek_valid	: 	jrawat_cek_valid_create,
                            jrawat_cek_bank	:	jrawat_cek_bank_create,
                            jrawat_cek_nilai	:	jrawat_cek_nilai_create,
                            //cek-2 posting
                            jrawat_cek_nama2	: 	jrawat_cek_nama2_create,
                            jrawat_cek_no2		:	jrawat_cek_nomor2_create,
                            jrawat_cek_valid2	: 	jrawat_cek_valid2_create,
                            jrawat_cek_bank2	:	jrawat_cek_bank2_create,
                            jrawat_cek_nilai2	:	jrawat_cek_nilai2_create,
                            //cek-3 posting
                            jrawat_cek_nama3	: 	jrawat_cek_nama3_create,
                            jrawat_cek_no3		:	jrawat_cek_nomor3_create,
                            jrawat_cek_valid3	: 	jrawat_cek_valid3_create,
                            jrawat_cek_bank3	:	jrawat_cek_bank3_create,
                            jrawat_cek_nilai3	:	jrawat_cek_nilai3_create,
                            //transfer posting
                            jrawat_transfer_bank	:	jrawat_transfer_bank_create,
                            jrawat_transfer_nama	:	jrawat_transfer_nama_create,
                            jrawat_transfer_nilai	:	jrawat_transfer_nilai_create,
                            //transfer-2 posting
                            jrawat_transfer_bank2	:	jrawat_transfer_bank2_create,
                            jrawat_transfer_nama2	:	jrawat_transfer_nama2_create,
                            jrawat_transfer_nilai2	:	jrawat_transfer_nilai2_create,
                            //transfer-3 posting
                            jrawat_transfer_bank3	:	jrawat_transfer_bank3_create,
                            jrawat_transfer_nama3	:	jrawat_transfer_nama3_create,
                            jrawat_transfer_nilai3	:	jrawat_transfer_nilai3_create,
                            //Penambahan Detail Penjualan Perawatan
                            drawat_id: encoded_array_drawat_id,
                            drawat_dtrawat: encoded_array_drawat_dtrawat,
                            drawat_rawat: encoded_array_drawat_rawat,
                            drawat_jumlah: encoded_array_drawat_jumlah,
                            drawat_harga: encoded_array_drawat_harga,
                            drawat_diskon: encoded_array_drawat_diskon,
                            drawat_diskon_jenis: encoded_array_drawat_diskon_jenis,
                            drawat_sales : encoded_array_drawat_sales,
                            drawat_karyawan: encoded_array_drawat_karyawan
                        },
                        callback: function(opts, success, response){
                            if(success){
								Ext.MessageBox.hide();
                                var result=eval(response.responseText);
                                if(result==0){
                                    //mode 'Save'
                                    Ext.MessageBox.alert(jrawat_post2db+' OK','Data penjualan perawatan berhasil disimpan');
                                    master_jual_rawat_DataStore.reload();
                                    master_jual_rawat_createWindow.hide();
                                }else if(result>0 && cetak_jrawat==2){                                    
                                    jrawat_cetak2(result,jrawat_cust_create,jrawat_tanggal_create_date, jrawat_stat_dok_create);
                                    master_jual_rawat_DataStore.reload();
                                    detail_jual_rawat_DataStore.load({params: {master_id:-1}});
                                    cbo_kwitansi_jual_rawat_DataStore.reload();
                                    master_jual_rawat_createWindow.hide();
                                }else if(result>0){
                                    //mode 'Save and Print' untuk perawatan non-paket, sekaligus pengambilan paket
                                    jrawat_cetak(result,jrawat_cust_create,jrawat_tanggal_create_date);
                                    master_jual_rawat_DataStore.reload();
                                    detail_jual_rawat_DataStore.load({params: {master_id:-1}});
                                    cbo_kwitansi_jual_rawat_DataStore.reload();
                                    master_jual_rawat_createWindow.hide();
                                }else if(result==-3 && cetak_jrawat==2){
                                    //mode 'Save and Print' untuk perawatan paket saja
                                    apaket_cetak2(jrawat_cust_create,jrawat_tanggal_create_date, jrawat_nobukti_pajak_create, jrawat_nobukti_medis_create); //parameter berisi cust_id dan tanggal_pengambilan_paket
                                    master_jual_rawat_DataStore.reload();
                                    detail_jual_rawat_DataStore.load({params: {master_id:-1}});
                                    master_jual_rawat_createWindow.hide();
                                }else if(result==-3){
                                    //mode 'Save and Print' untuk perawatan paket saja
									apaket_cetak(jrawat_cust_create,jrawat_tanggal_create_date); //parameter berisi cust_id dan tanggal_pengambilan_paket
                                    master_jual_rawat_DataStore.reload();
                                    detail_jual_rawat_DataStore.load({params: {master_id:-1}});
                                    master_jual_rawat_createWindow.hide();
                                }else if(result==-5){
                                    detail_jual_rawat_DataStore.load({params: {master_id:-1}});
                                    master_jual_rawat_DataStore.reload();
                                    master_jual_rawat_createWindow.hide();
                                }else if(result==-7){
                                    <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
                                    master_jual_rawat_createForm.savePrintButton.disable();
									master_jual_rawat_createForm.savePrintButton2.disable();
                                    master_jual_rawat_createForm.save_btn.disable();
                                    <?php } ?>
                                    Ext.MessageBox.show({
                                       title: 'Warning',
                                       msg: 'Detail Perawatan lepas tidak cocok dengan database. Silakan klik tombol Cancel terlebih dahulu, kemudian buka kembali data ini.',
                                       buttons: Ext.MessageBox.OK,
                                       animEl: 'save',
                                       icon: Ext.MessageBox.WARNING
                                    });
                                }else{
                                    Ext.MessageBox.show({
                                       title: 'Warning',
                                       msg: 'Error: '+result,
                                       buttons: Ext.MessageBox.OK,
                                       animEl: 'save',
                                       icon: Ext.MessageBox.WARNING
                                    });
                                    master_jual_rawat_createWindow.hide();
                                }
                            }else{
                                master_jual_rawat_DataStore.reload();
                                master_jual_rawat_createWindow.hide();
                                master_jual_rawat_reset_allForm();
                                master_cara_bayarTabPanel.setActiveTab(0);
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
                }else if(jrawat_post2db=='UPDATE' && jrawat_stat_dokField.getValue()=='Tertutup'){
                    //hanya diperbolehkan untuk proses cetak saja
                    var cetak_jrawat_id = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_id');
                    var cetak_customer_id = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cust_id');
                    var cetak_tanggal = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_tanggal').format('Y-m-d');
					var jrawat_stat_dok_create = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok');
					var jrawat_nobukti_pajak = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_pajak');
					var jrawat_nobukti_medis = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_medis');
                    
                    if(jrawat_nobuktiField.getValue()==''){
                        //proses cetak pengambilan paket saja
                        if(cetak_jrawat==1){
                             apaket_cetak(cetak_customer_id ,cetak_tanggal);
                        } else if(cetak_jrawat==2){
                            apaket_cetak2(cetak_customer_id ,cetak_tanggal,jrawat_nobukti_pajak, jrawat_nobukti_medis);
                        } 
                        master_jual_rawat_DataStore.reload();
                        detail_jual_rawat_DataStore.load({params: {master_id:0}});
                        master_jual_rawat_createWindow.hide();
                        master_jual_rawat_reset_allForm();
                        master_cara_bayarTabPanel.setActiveTab(0);
                    }else{
                        //proses cetak untuk perawatan satuan atau plus pengambilan paket
                        if(cetak_jrawat==1){
                            jrawat_cetak(cetak_jrawat_id ,cetak_customer_id ,cetak_tanggal);
                        } else if(cetak_jrawat==2){
                            jrawat_cetak2(cetak_jrawat_id ,cetak_customer_id ,cetak_tanggal, jrawat_stat_dok_create);
                        } 
                        master_jual_rawat_DataStore.reload();
                        detail_jual_rawat_DataStore.load({params: {master_id:0}});
                        master_jual_rawat_createWindow.hide();
                        master_jual_rawat_reset_allForm();
                        master_cara_bayarTabPanel.setActiveTab(0);
                    }
                }else if(jrawat_post2db=="UPDATE" && (jrawat_stat_dokField.getValue()=='Batal')){
                    var jrawat_nobukti_create='';
                    if(jrawat_nobuktiField.getValue()!== ''){
                        jrawat_nobukti_create = jrawat_nobuktiField.getValue(); 
                        Ext.Ajax.request({  
                            waitMsg: 'Please wait...',
                            waitMsg: 'Mohon tunggu...',
							timeout: 72000,
                            url: 'index.php?c=c_master_jual_rawat&m=get_action',
                            params: {
                                task: 'BATAL',
                                jrawat_nobukti	: 	jrawat_nobukti_create,
								jrawat_nobukti_medis	: 	jrawat_nobukti_medis_create,
								jrawat_nobukti_pajak	: 	jrawat_nobukti_pajak_create,
                                jrawat_tanggal : jrawat_tanggalField.getValue().format('Y-m-d')
                            },
                            callback: function(opts, success, response){
                                if(success){
                                    var result=eval(response.responseText);
                                    if(result==1){
                                        Ext.MessageBox.alert(' OK','Dokumen telah dibatalkan');
                                    }else if(result==0){
                                        Ext.MessageBox.show({
                                            title: 'Warning',
                                            msg: 'Dokumen yang boleh dibatalkan adalah yang tercetak hari ini.',
                                            buttons: Ext.MessageBox.OK,
                                            animEl: 'save',
                                            icon: Ext.MessageBox.WARNING
                                        });
                                    }
                                    master_jual_rawat_DataStore.reload();
                                    master_jual_rawat_createWindow.hide();
                                    master_jual_rawat_reset_allForm();
                                    master_cara_bayarTabPanel.setActiveTab(0);
                                }else{
                                    master_jual_rawat_DataStore.reload();
                                    master_jual_rawat_createWindow.hide();
                                    master_jual_rawat_reset_allForm();
                                    master_cara_bayarTabPanel.setActiveTab(0);
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
                        //* artinya: list yang dipilih adalah yang detailnya hanya berisi 'paket' ==> untuk membatalkan harus melalui Tindakan /
                        Ext.MessageBox.show({
                            title: 'Warning',
                            msg: 'Untuk membatalkan paket harus melalui Kasir Pengambilan Paket.',
                            buttons: Ext.MessageBox.OK,
                            animEl: 'save',
                            icon: Ext.MessageBox.WARNING
                        });
                    }
                }else {
                    Ext.MessageBox.show({
                        title: 'Warning',
                        msg: 'Form Anda belum lengkap',
                        buttons: Ext.MessageBox.OK,
                        animEl: 'save',
                        icon: Ext.MessageBox.WARNING
                    });
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
        }else{
			//message: "variabel bayar dan total transaksi tidak terdefinisi"
            Ext.MessageBox.show({
                title: 'Warning',
                msg: 'Variabel Total Bayar dan Total Transaksi tidak terdefinisi.',
                buttons: Ext.MessageBox.OK,
                animEl: 'save',
                icon: Ext.MessageBox.WARNING
            });
        }
	}
 	/* End of Function */
	
	function save_andPrint(){
		cetak_jrawat=1;
		pengecekan_dokumen();
	}
	
	function save_andPrint2(){
		cetak_jrawat=2;
		pengecekan_dokumen();
	}
  
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function print_only(){
		var jrawat_cust_create = null;
		var jrawat_tanggal_create_data = '';
		cetak_jrawat=1;		
		var jrawat_id_for_cetak = 0;
		
		if(/^\d+$/.test(jrawat_custField.getValue())){
             jrawat_cust_create = jrawat_custField.getValue();
		}else{
             jrawat_cust_create = jrawat_cust_idField.getValue();
        }
		if(jrawat_tanggalField.getValue()!== ""){jrawat_tanggal_create_date = jrawat_tanggalField.getValue().format('Y-m-d');} 
		if(jrawat_idField.getValue()!== null){jrawat_id_for_cetak = jrawat_idField.getValue();}
	
		if(jrawat_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
			if(cetak_jrawat==1 && detail_jual_rawat_DataStore.getCount()>0){ //ini artinya ada perawatan satuan, atau ada satuan dan paket, maka akan ngeprint semuanya
				jrawat_cetak_print_only(jrawat_id_for_cetak);
				cetak_jrawat=0;
			}
			else if(cetak_jrawat==1 && detail_ambil_paketDataStore.getCount()>0 && detail_jual_rawat_DataStore.getCount()<1) // ini artinya hanya ngeprint pengambilan paket saja.. yang dibuat patokan adalah cust_id dan tanggal faktur.. 
			{
				apaket_cetak(jrawat_cust_create,jrawat_tanggal_create_date);
				master_jual_rawat_DataStore.reload();
				detail_jual_rawat_DataStore.load({params: {master_id:-1}});
				master_jual_rawat_createWindow.hide();
			}
			else
			{
				alert('Data tidak valid. Segera menghubungi Admin.');
			}
		}
	}
	
	function print_only2(){
		var jrawat_cust_create = null;
		var jrawat_tanggal_create_data = '';
		cetak_jrawat=2;		
		var jrawat_id_for_cetak = 0;
		
		if(/^\d+$/.test(jrawat_custField.getValue())){
             jrawat_cust_create = jrawat_custField.getValue();
		}else{
             jrawat_cust_create = jrawat_cust_idField.getValue();
        }
		if(jrawat_tanggalField.getValue()!== ""){jrawat_tanggal_create_date = jrawat_tanggalField.getValue().format('Y-m-d');} 
		if(jrawat_idField.getValue()!== null){jrawat_id_for_cetak = jrawat_idField.getValue();}

		if(jrawat_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
			if(cetak_jrawat==2 && detail_jual_rawat_DataStore.getCount()>0){ //ini artinya ada perawatan satuan, atau ada satuan dan paket, maka akan ngeprint semuanya
				jrawat_cetak_print_only2(jrawat_id_for_cetak);
				cetak_jrawat=0;
			}
			else if(cetak_jrawat==2 && detail_ambil_paketDataStore.getCount()>0 && detail_jual_rawat_DataStore.getCount()<1) // ini artinya hanya ngeprint pengambilan paket saja.. yang dibuat patokan adalah cust_id dan tanggal faktur.. 
			{
				apaket_cetak(jrawat_cust_create,jrawat_tanggal_create_date);
				master_jual_rawat_DataStore.reload();
				detail_jual_rawat_DataStore.load({params: {master_id:-1}});
				master_jual_rawat_createWindow.hide();
			}
			else
			{
				alert('Data tidak valid. Segera menghubungi Admin.');
			}
		}
	}
	
	function save_button(){
		cetak_jrawat=0;
		pengecekan_dokumen();
	}
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(jrawat_post2db=='UPDATE')
			return master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	// Reset kwitansi option
	function kwitansi_jual_rawat_reset_form(){
		jrawat_kwitansi_namaField.reset();
		jrawat_kwitansi_nilaiField.reset();
		jrawat_kwitansi_nilai_cfField.reset();
		jrawat_kwitansi_noField.reset();
        jrawat_kwitansi_no_idField.reset();
		jrawat_kwitansi_sisaField.reset();
		jrawat_kwitansi_namaField.setValue("");
		jrawat_kwitansi_nilaiField.setValue(null);
		jrawat_kwitansi_nilai_cfField.setValue(null);
		jrawat_kwitansi_noField.setValue("");
        jrawat_kwitansi_no_idField.setValue(null);
		jrawat_kwitansi_sisaField.setValue(null);
		jrawat_jual_kwitansi_idField1.reset();
		jrawat_jual_kwitansi_idField1.setValue(null);
	}
	// Reset kwitansi-2 option
	function kwitansi2_jual_rawat_reset_form(){
		jrawat_kwitansi_nama2Field.reset();
		jrawat_kwitansi_nilai2Field.reset();
		jrawat_kwitansi_nilai2_cfField.reset();
		jrawat_kwitansi_no2Field.reset();
        jrawat_kwitansi_no2_idField.reset();
		jrawat_kwitansi_sisa2Field.reset();
		jrawat_kwitansi_nama2Field.setValue("");
		jrawat_kwitansi_nilai2Field.setValue(null);
		jrawat_kwitansi_nilai2_cfField.setValue(null);
		jrawat_kwitansi_no2Field.setValue("");
        jrawat_kwitansi_no2_idField.setValue(null);
		jrawat_kwitansi_sisa2Field.setValue(null);
		jrawat_jual_kwitansi_idField2.reset();
		jrawat_jual_kwitansi_idField2.setValue(null);
	}
	// Reset kwitansi-3 option
	function kwitansi3_jual_rawat_reset_form(){
		jrawat_kwitansi_nama3Field.reset();
		jrawat_kwitansi_nilai3Field.reset();
		jrawat_kwitansi_nilai3_cfField.reset();
		jrawat_kwitansi_no3Field.reset();
		jrawat_kwitansi_sisa3Field.reset();
		jrawat_kwitansi_nama3Field.setValue("");
		jrawat_kwitansi_nilai3Field.setValue(null);
		jrawat_kwitansi_nilai3_cfField.setValue(null);
		jrawat_kwitansi_no3Field.setValue("");
		jrawat_kwitansi_sisa3Field.setValue(null);
		jrawat_jual_kwitansi_idField3.reset();
		jrawat_jual_kwitansi_idField3.setValue(null);
	}
	// Reset card option
	function card_jual_rawat_reset_form(){
		jrawat_card_namaField.reset();
		jrawat_card_edcField.reset();
		jrawat_card_noField.reset();
		jrawat_card_nilaiField.reset();
		jrawat_card_nilai_cfField.reset();
		jrawat_card_namaField.setValue("");
		jrawat_card_edcField.setValue("");
		jrawat_card_noField.setValue("");
		jrawat_card_nilaiField.setValue(null);
		jrawat_card_nilai_cfField.setValue(null);
	}
	// Reset card-2 option
	function card2_jual_rawat_reset_form(){
		jrawat_card_nama2Field.reset();
		jrawat_card_edc2Field.reset();
		jrawat_card_no2Field.reset();
		jrawat_card_nilai2Field.reset();
		jrawat_card_nilai2_cfField.reset();
		jrawat_card_nama2Field.setValue("");
		jrawat_card_edc2Field.setValue("");
		jrawat_card_no2Field.setValue("");
		jrawat_card_nilai2Field.setValue(null);
		jrawat_card_nilai2_cfField.setValue(null);
	}
	// Reset card-3 option
	function card3_jual_rawat_reset_form(){
		jrawat_card_nama3Field.reset();
		jrawat_card_edc3Field.reset();
		jrawat_card_no3Field.reset();
		jrawat_card_nilai3Field.reset();
		jrawat_card_nilai3_cfField.reset();
		jrawat_card_nama3Field.setValue("");
		jrawat_card_edc3Field.setValue("");
		jrawat_card_no3Field.setValue("");
		jrawat_card_nilai3Field.setValue(null);
		jrawat_card_nilai3_cfField.setValue(null);
	}
	// Reset cek option
	function cek_jual_rawat_reset_form(){
		jrawat_cek_namaField.reset();
		jrawat_cek_noField.reset();
		jrawat_cek_validField.reset();
		jrawat_cek_bankField.reset();
		jrawat_cek_nilaiField.reset();
		jrawat_cek_nilai_cfField.reset();
		jrawat_cek_namaField.setValue("");
		jrawat_cek_noField.setValue("");
		jrawat_cek_validField.setValue("");
		jrawat_cek_bankField.setValue("");
		jrawat_cek_nilaiField.setValue(null);
		jrawat_cek_nilai_cfField.setValue(null);
	}
	// Reset cek-2 option
	function cek2_jual_rawat_reset_form(){
		jrawat_cek_nama2Field.reset();
		jrawat_cek_no2Field.reset();
		jrawat_cek_valid2Field.reset();
		jrawat_cek_bank2Field.reset();
		jrawat_cek_nilai2Field.reset();
		jrawat_cek_nilai2_cfField.reset();
		jrawat_cek_nama2Field.setValue("");
		jrawat_cek_no2Field.setValue("");
		jrawat_cek_valid2Field.setValue("");
		jrawat_cek_bank2Field.setValue("");
		jrawat_cek_nilai2Field.setValue(null);
		jrawat_cek_nilai2_cfField.setValue(null);
	}
	// Reset cek-3 option
	function cek3_jual_rawat_reset_form(){
		jrawat_cek_nama3Field.reset();
		jrawat_cek_no3Field.reset();
		jrawat_cek_valid3Field.reset();
		jrawat_cek_bank3Field.reset();
		jrawat_cek_nilai3Field.reset();
		jrawat_cek_nilai3_cfField.reset();
		jrawat_cek_nama3Field.setValue("");
		jrawat_cek_no3Field.setValue("");
		jrawat_cek_valid3Field.setValue("");
		jrawat_cek_bank3Field.setValue("");
		jrawat_cek_nilai3Field.setValue(null);
		jrawat_cek_nilai3_cfField.setValue(null);
	}
	// Reset transfer option
	function transfer_jual_rawat_reset_form(){
		jrawat_transfer_bankField.reset();
		jrawat_transfer_namaField.reset();
		jrawat_transfer_nilaiField.reset();
		jrawat_transfer_nilai_cfField.reset();
		jrawat_transfer_bankField.setValue("");
		jrawat_transfer_namaField.setValue("");
		jrawat_transfer_nilaiField.setValue(null);
		jrawat_transfer_nilai_cfField.setValue(null);
	}
	// Reset transfer-2 option
	function transfer2_jual_rawat_reset_form(){
		jrawat_transfer_bank2Field.reset();
		jrawat_transfer_nama2Field.reset();
		jrawat_transfer_nilai2Field.reset();
		jrawat_transfer_nilai2_cfField.reset();
		jrawat_transfer_bank2Field.setValue("");
		jrawat_transfer_nama2Field.setValue("");
		jrawat_transfer_nilai2Field.setValue(null);
		jrawat_transfer_nilai2_cfField.setValue(null);
	}
	// Reset transfer-3 option
	function transfer3_jual_rawat_reset_form(){
		jrawat_transfer_bank3Field.reset();
		jrawat_transfer_nama3Field.reset();
		jrawat_transfer_nilai3Field.reset();
		jrawat_transfer_nilai3_cfField.reset();
		jrawat_transfer_bank3Field.setValue("");
		jrawat_transfer_nama3Field.setValue("");
		jrawat_transfer_nilai3Field.setValue(null);
		jrawat_transfer_nilai3_cfField.setValue(null);
	}
	// Reset tunai option
	function tunai_jual_rawat_reset_form(){
		jrawat_tunai_nilaiField.reset();
		jrawat_tunai_nilaiField.setValue(null);
		jrawat_tunai_nilai_cfField.reset();
		jrawat_tunai_nilai_cfField.setValue(null);
	}
	// Reset tunai-2 option
	function tunai2_jual_rawat_reset_form(){
		jrawat_tunai_nilai2Field.reset();
		jrawat_tunai_nilai2Field.setValue(null);
		jrawat_tunai_nilai2_cfField.reset();
		jrawat_tunai_nilai2_cfField.setValue(null);
	}
	// Reset tunai-3 option
	function tunai3_jual_rawat_reset_form(){
		jrawat_tunai_nilai3Field.reset();
		jrawat_tunai_nilai3Field.setValue(null);
		jrawat_tunai_nilai3_cfField.reset();
		jrawat_tunai_nilai3_cfField.setValue(null);
	}
	//Reset voucher option
	function voucher_jual_rawat_reset_form(){
		jrawat_voucher_noField.reset();
		jrawat_voucher_cashbackField.reset();
		jrawat_voucher_cashback_cfField.reset();
		jrawat_voucher_noField.setValue("");
		jrawat_voucher_cashbackField.setValue(null);
		jrawat_voucher_cashback_cfField.setValue(null);
	}
	//Reset voucher-2 option
	function voucher2_jual_rawat_reset_form(){
		jrawat_voucher_no2Field.reset();
		jrawat_voucher_cashback2Field.reset();
		jrawat_voucher_cashback2_cfField.reset();
		jrawat_voucher_no2Field.setValue("");
		jrawat_voucher_cashback2Field.setValue(null);
		jrawat_voucher_cashback2_cfField.setValue(null);
	}
	//Reset voucher-3 option
	function voucher3_jual_rawat_reset_form(){
		jrawat_voucher_no3Field.reset();
		jrawat_voucher_cashback3Field.reset();
		jrawat_voucher_cashback3_cfField.reset();
		jrawat_voucher_no3Field.setValue("");
		jrawat_voucher_cashback3Field.setValue(null);
		jrawat_voucher_cashback3_cfField.setValue(null);
	}
	/* Reset form before loading */
	function master_jual_rawat_reset_form(){	
		jrawat_no_faktur_medisField.reset();
		jrawat_no_faktur_medisField.setValue(null);
		jrawat_no_faktur_pajakField.reset();
		jrawat_no_faktur_pajakField.setValue(null);
		jrawat_voucher_dppField.reset();
		jrawat_voucher_dppField.setValue(null);	
		
		jrawat_ppn_Field.reset();
		jrawat_ppn_Field.setValue(null);	
		jrawat_dpp_Field.reset();
		jrawat_dpp_Field.setValue(null);
		jrawat_subTotal_medisField.reset();
		jrawat_subTotal_medisField.setValue(null);
		jrawat_subTotal_nonmedisField.reset();
		jrawat_subTotal_nonmedisField.setValue(null);
		
		jrawat_total_medisField.reset();
		jrawat_total_medisField.setValue(null);
		jrawat_total_nonmedisField.reset();
		jrawat_total_nonmedisField.setValue(null);
		
		jrawat_voucher_totalField.reset();
		jrawat_voucher_totalField.setValue(null);
		
		jrawat_idField.reset();
		jrawat_idField.setValue(null);
		jrawat_karyawanField.reset();
		jrawat_karyawanField.setValue(null);
		jrawat_karyawan_idField.reset();
		jrawat_karyawan_idField.setValue(null);
		jrawat_nikkaryawanField.reset();
		jrawat_nikkaryawanField.setValue(null);
		jrawat_nobuktiField.reset();
		jrawat_nobuktiField.setValue(null);
		jrawat_custField.reset();
		jrawat_custField.setValue(null);
		jrawat_cust_idField.reset();
		jrawat_cust_idField.setValue(null);
		jrawat_tanggalField.setValue(dt.format('Y-m-d'));
		//jrawat_diskonField.reset();
		//jrawat_diskonField.setValue(null);
		jrawat_caraField.reset();
		jrawat_caraField.setValue(null);
		jrawat_cara2Field.reset();
		jrawat_cara2Field.setValue(null);
		jrawat_cara3Field.reset();
		jrawat_cara3Field.setValue(null);
		
		jrawat_keteranganField.reset();
		jrawat_keteranganField.setValue(null);	
		jrawat_ket_diskField.reset();
		jrawat_ket_diskField.setValue(null);
		jrawat_ket_disk_medisField.reset();
		jrawat_ket_disk_medisField.setValue(null);
		jrawat_stat_dokField.reset();
		jrawat_stat_dokField.setValue('Terbuka');
		jrawat_cust_nomemberField.reset();
		jrawat_cust_nomemberField.setValue(null);
		
		jrawat_valid_memberField.setValue("");
		jrawat_cust_ultahField.setValue("");
		
		jrawat_jumlahField.reset();
		jrawat_jumlahField.setValue(null);
		jrawat_jumlahLabel.reset();
		jrawat_jumlahLabel.setValue(null);
		//jrawat_cashbackField.reset();
		//jrawat_cashbackField.setValue(null);
		jrawat_cashback_num.reset();
		jrawat_cashback_num.setValue(null);
		jrawat_cashback_cfField.reset(); 
		jrawat_cashback_cfField.setValue(null);
		jrawat_cashback_medis_num.reset();
		jrawat_cashback_medis_num.setValue(null);
		jrawat_cashback_cf_medisField.reset();
		jrawat_cashback_cf_medisField.setValue(null);
		jrawat_ket_diskField.setDisabled(false);
		jrawat_ket_disk_medisField.setDisabled(false);
		
		jrawat_voucher_total_cfField.reset();
		jrawat_voucher_total_cfField.setValue(null);
		jrawat_voucher_totalField.reset(); 
		jrawat_voucher_totalField.setValue(null);
		jrawat_voucherTotalLabel.reset(); 
		jrawat_voucherTotalLabel.setValue(null);

		jrawat_subTotalField.reset();
		jrawat_subTotalField.setValue(null);
		jrawat_subTotal_cfField.reset();
		jrawat_subTotal_cfField.setValue(null);
		jrawat_subTotalLabel.reset();
		jrawat_subTotalLabel.setValue(null);
		
		jrawat_totalField.reset();
		jrawat_totalField.setValue(null);
		jrawat_total_cfField.reset();
		jrawat_total_cfField.setValue(null);
		jrawat_TotalLabel.reset();
		jrawat_TotalLabel.setValue(null);
		
		jrawat_bayarField.reset();
		jrawat_bayarField.setValue(null);
		jrawat_bayar_cfField.reset();
		jrawat_bayar_cfField.setValue(null);
		jrawat_TotalBayarLabel.reset();
		jrawat_TotalBayarLabel.setValue(null);
		
		jrawat_hutangField.reset();
		jrawat_hutangField.setValue(null);
		jrawat_hutang_cfField.reset();
		jrawat_hutang_cfField.setValue(null);
		jrawat_HutangLabel.reset();
		jrawat_HutangLabel.setValue(null);
		
		jrawat_pesanLabel.setText("");
		jrawat_lunasLabel.setText("");
		jrawat_cust_priorityLabel.setText("");

		tunai_jual_rawat_reset_form();
		tunai2_jual_rawat_reset_form();
		tunai3_jual_rawat_reset_form();

		kwitansi_jual_rawat_reset_form();
		kwitansi2_jual_rawat_reset_form();
		kwitansi3_jual_rawat_reset_form();

		card_jual_rawat_reset_form();
		card2_jual_rawat_reset_form();
		card3_jual_rawat_reset_form();

		cek_jual_rawat_reset_form();
		cek2_jual_rawat_reset_form();
		cek3_jual_rawat_reset_form();

		transfer_jual_rawat_reset_form();
		transfer2_jual_rawat_reset_form();
		transfer3_jual_rawat_reset_form();

		voucher_jual_rawat_reset_form();
		voucher2_jual_rawat_reset_form();
		voucher3_jual_rawat_reset_form();

		update_group_carabayar_jual_rawat();
		update_group_carabayar2_jual_rawat();
		update_group_carabayar3_jual_rawat();
		
		jrawat_custField.setDisabled(false);
		jrawat_karyawanField.setDisabled(true);
		jrawat_nikkaryawanField.setDisabled(false);
		jrawat_tanggalField.setDisabled(false);
		jrawat_tanggalField.setDisabled(false);
		jrawat_keteranganField.setDisabled(false);
		master_cara_bayarTabPanel.setDisabled(false);
		detail_jual_rawatListEditorGrid.setDisabled(false);
		jrawat_cashback_cfField.setDisabled(false);
		jrawat_cashback_cf_medisField.setDisabled(false);
		
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
		detail_jual_rawatListEditorGrid.djrawat_add.enable();
        //detail_jual_rawatListEditorGrid.djrawat_delete.enable();
		master_jual_rawat_createForm.savePrintButton.enable();
		master_jual_rawat_createForm.savePrintButton2.enable();
		master_jual_rawat_createForm.PrintOnlyButton.disable();
		master_jual_rawat_createForm.PrintOnlyButton2.disable();
		
		master_jual_rawat_createForm.save_btn.enable();
		<?php } ?>
		
		combo_jual_rawat.setDisabled(false);
		drawat_jumlahField.setDisabled(false);
		drawat_hargaField.setDisabled(false);
		drawat_subtotalField.setDisabled(false);
		drawat_jenis_diskonField.setDisabled(false);
		drawat_diskonField.setDisabled(false);
		drawat_subtotal_netField.setDisabled(false);
		
		jrawat_caraField.setDisabled(false);
		master_jual_rawat_tunaiGroup.setDisabled(false);
		master_jual_rawat_cardGroup.setDisabled(false);
		master_jual_rawat_cekGroup.setDisabled(false);
		master_jual_rawat_kwitansiGroup.setDisabled(false);
		master_jual_rawat_transferGroup.setDisabled(false);
		master_jual_rawat_voucherGroup.setDisabled(false);
		
		jrawat_cara2Field.setDisabled(false);
		master_jual_rawat_tunai2Group.setDisabled(false);
		master_jual_rawat_card2Group.setDisabled(false);
		master_jual_rawat_cek2Group.setDisabled(false);
		master_jual_rawat_kwitansi2Group.setDisabled(false);
		master_jual_rawat_transfer2Group.setDisabled(false);
		master_jual_rawat_voucher2Group.setDisabled(false);
		
		jrawat_cara3Field.setDisabled(false);
		master_jual_rawat_tunai3Group.setDisabled(false);
		master_jual_rawat_card3Group.setDisabled(false);
		master_jual_rawat_cek3Group.setDisabled(false);
		master_jual_rawat_kwitansi3Group.setDisabled(false);
		master_jual_rawat_transfer3Group.setDisabled(false);
		master_jual_rawat_voucher3Group.setDisabled(false);
		
	}
 	/* End of Function */
	
	function master_jual_rawat_reset_allForm(){
		master_jual_rawat_reset_form();
	}
    
	/* setValue to EDIT */
	function master_jual_rawat_set_form(){
		//master_jual_rawat_reset_form();
		var hutang_temp=0;
		var subtotal_field=0;
		var drawat_jumlah_field=0;
		var total_field=0;
		var hutang_field=0;
		var diskon_field=0;
		var cashback_field=0;
		var cashback_field_medis=0;
		var set_voucher_dpp_field=0;
		var subtotal_medis_field=0;
		var subtotal_nonmedis_field=0;
		var drawat_jumlah_field=0;
		var drawat_jumlah_medis_field=0;
		var drawat_jumlah_nonmedis_field=0;
		var voucher_non_medis_field=0; // ini vouchernya Non Medis
		var biaya_medis = 0;
		var biaya_nonmedis = 0;
		var subtotal_dpp= 0;
		var total_voucher_medis=0;
		var total_voucher_nonmedis=0;
		var total_voucher_field=0;
		var voucher_dpp=0;
		var ppn=0;
		var subtotal_dpp_field=0;
		var total_sub_total_nonmedis_field=0;
		var total_ppn_field=0;
		
		dpaket_idField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('dpaket_id'));
		jrawat_idField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_id'));
		jrawat_karyawanField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('karyawan_nama'));
		jrawat_karyawan_idField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('karyawan_id'));
		jrawat_nikkaryawanField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('karyawan_no'));
		if(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('keterangan_paket')!=='paket'){
			jrawat_nobuktiField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti'));
			jrawat_cashback_cf_medisField.setValue(CurrencyFormatted(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cashback_medis')));
			jrawat_cashback_cfField.setValue(CurrencyFormatted(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cashback'))); 
			jrawat_ket_diskField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_ket_disk'));
		}
		jrawat_custField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cust_edit'));
		jrawat_cust_idField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cust_id'));
		jrawat_tanggalField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_tanggal'));
		//jrawat_diskonField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_diskon'));
		jrawat_cashback_num.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cashback'));
		jrawat_cashback_cfField.setValue(CurrencyFormatted(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cashback')));
		jrawat_cashback_medis_num.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cashback_medis'));
		jrawat_cashback_cf_medisField.setValue(CurrencyFormatted(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cashback_medis')));
		jrawat_ket_diskField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_ket_disk'));
		jrawat_ket_disk_medisField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_ket_disk_medis'));
		if(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cara')==""){
			jrawat_caraField.setValue("card");
		}else{
			jrawat_caraField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cara'));
		}
		jrawat_cara2Field.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cara2'));
		jrawat_cara3Field.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cara3'));
		jrawat_bayarField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_bayar'));
		jrawat_bayar_cfField.setValue(CurrencyFormatted(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_bayar')));
		jrawat_TotalBayarLabel.setValue(CurrencyFormatted(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_bayar')));
		
		jrawat_keteranganField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_keterangan'));
		jrawat_stat_dokField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok'));
		jrawat_no_faktur_medisField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_medis'));
		jrawat_no_faktur_pajakField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_pajak'));
		
		for(i=0;i<detail_jual_rawat_DataStore.getCount();i++){
			subtotal_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net;
			drawat_jumlah_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah;
			if (detail_jual_rawat_DataStore.getAt(i).data.kategori_nama == 'Medis'){
				biaya_medis+= detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net;
				subtotal_medis_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net;
				drawat_jumlah_medis_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah;
			} else if (detail_jual_rawat_DataStore.getAt(i).data.kategori_nama == 'Non Medis'){
				biaya_nonmedis+= detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net;
				subtotal_nonmedis_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net;
				subtotal_dpp+=(detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net)/1.1; 
				drawat_jumlah_nonmedis_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah;
			}
		}
		/*if(jrawat_diskonField.getValue()!==""){
			diskon_field=jrawat_diskonField.getValue();
		}*/
		if(jrawat_cashback_num.getValue()!==""){
			cashback_field=jrawat_cashback_num.getValue();
		}
		if(jrawat_cashback_medis_num.getValue()!==""){
			cashback_field_medis=jrawat_cashback_medis_num.getValue();
		}
		jrawat_jumlahField.setValue(drawat_jumlah_field);
		////////////NAT VOUCHER
		if(jrawat_cashback_num.getValue()!==""){
			voucher_non_medis_field=jrawat_cashback_num.getValue();
		}
		jrawat_dpp_Field.setValue(subtotal_dpp);
		jrawat_dpp_cfField.setValue(CurrencyFormatted(subtotal_dpp));
		//total_field=subtotal_field*(100-diskon_field)/100-cashback_field-voucher_non_medis_field;
		total_field=subtotal_field-cashback_field-cashback_field_medis;
		/////////END NAT
		
		// Set Voucher DPP non Medis
		set_voucher_dpp_field=voucher_non_medis_field/1.1;
		set_voucher_dpp_field=(set_voucher_dpp_field>0?Math.round(set_voucher_dpp_field):0);
		jrawat_voucher_dppField.setValue(set_voucher_dpp_field);
		jrawat_voucher_dpp_cfField.setValue(CurrencyFormatted(set_voucher_dpp_field));
		
		jrawat_jumlahField.setValue(drawat_jumlah_medis_field + drawat_jumlah_nonmedis_field);
		jrawat_subTotalField.setValue(subtotal_field);
		jrawat_subTotal_cfField.setValue(CurrencyFormatted(subtotal_field));
		jrawat_subTotalLabel.setValue(CurrencyFormatted(subtotal_field));
		
		jrawat_subTotal_medisField.setValue(subtotal_medis_field);
		jrawat_subTotal_medis_cfField.setValue(CurrencyFormatted(subtotal_medis_field));
		
		// Set Sub Total non 
		total_sub_total_nonmedis_field=subtotal_dpp-set_voucher_dpp_field;
		jrawat_subTotal_nonmedisField.setValue(total_sub_total_nonmedis_field);
		jrawat_subtotal_nonmedis_cfField.setValue(CurrencyFormatted(total_sub_total_nonmedis_field));
		
		// Set PPN
		total_ppn_field=total_sub_total_nonmedis_field*0.1;
		total_ppn_field = (total_ppn_field>0?Math.round(total_ppn_field):0);
		jrawat_ppn_Field.setValue(total_ppn_field);
		jrawat_ppn_cfField.setValue(CurrencyFormatted(total_ppn_field));
		
		jrawat_totalField.setValue(total_field);
		jrawat_total_cfField.setValue(CurrencyFormatted(total_field));
		jrawat_TotalLabel.setValue(CurrencyFormatted(total_field));
		jrawat_total_medisField.setValue(biaya_medis);
		jrawat_total_medis_cfField.setValue(CurrencyFormatted(biaya_medis));
		jrawat_total_nonmedisField.setValue(biaya_nonmedis);
		jrawat_total_nonmedis_cfField.setValue(CurrencyFormatted(biaya_nonmedis));
		
		total_voucher_medis = jrawat_cashback_medis_num.getValue(); // Punyae Medis 
		total_voucher_nonmedis = jrawat_cashback_num.getValue();
		total_voucher_field = cashback_field_medis + cashback_field; //hitung total
		jrawat_voucher_total_cfField.setValue(CurrencyFormatted(total_voucher_field));
		jrawat_voucherTotalLabel.setValue(CurrencyFormatted(total_voucher_field));
		
		hutang_temp=total_field-master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_bayar');
		jrawat_hutangField.setValue(hutang_temp);
		jrawat_hutang_cfField.setValue(CurrencyFormatted(hutang_temp));
		jrawat_HutangLabel.setValue(CurrencyFormatted(hutang_temp));
		
		load_membership();
		load_karyawan();
		update_group_carabayar_jual_rawat();
		update_group_carabayar2_jual_rawat();
		update_group_carabayar3_jual_rawat();
		
		if(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti').substring(0,2)=='PR'){
		switch(jrawat_caraField.getValue()){
			case 'kwitansi':
				kwitansi_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_rawat_DataStore.getCount()){
								jrawat_kwitansi_record=kwitansi_jual_rawat_DataStore.getAt(0).data;
								jrawat_kwitansi_noField.setValue(jrawat_kwitansi_record.kwitansi_no);
                                jrawat_kwitansi_no_idField.setValue(jrawat_kwitansi_record.kwitansi_id);
								jrawat_kwitansi_namaField.setValue(jrawat_kwitansi_record.cust_nama);
								jrawat_kwitansi_sisaField.setValue(jrawat_kwitansi_record.kwitansi_sisa);
								jrawat_kwitansi_nilaiField.setValue(jrawat_kwitansi_record.jkwitansi_nilai);
								jrawat_kwitansi_nilai_cfField.setValue(CurrencyFormatted(jrawat_kwitansi_record.jkwitansi_nilai));
								jrawat_jual_kwitansi_idField1.setValue(jrawat_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							if(card_jual_rawat_DataStore.getCount()){
								jrawat_card_record=card_jual_rawat_DataStore.getAt(0).data;
								jrawat_card_namaField.setValue(jrawat_card_record.jcard_nama);
								jrawat_card_edcField.setValue(jrawat_card_record.jcard_edc);
								jrawat_card_noField.setValue(jrawat_card_record.jcard_no);
								jrawat_card_nilaiField.setValue(jrawat_card_record.jcard_nilai);
								jrawat_card_nilai_cfField.setValue(CurrencyFormatted(jrawat_card_record.jcard_nilai));
							}
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 1
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_rawat_DataStore.getCount()){
									jrawat_cek_record=cek_jual_rawat_DataStore.getAt(0).data;
									jrawat_cek_namaField.setValue(jrawat_cek_record.jcek_nama);
									jrawat_cek_noField.setValue(jrawat_cek_record.jcek_no);
									jrawat_cek_validField.setValue(jrawat_cek_record.jcek_valid);
									jrawat_cek_bankField.setValue(jrawat_cek_record.jcek_bank);
									jrawat_cek_nilaiField.setValue(jrawat_cek_record.jcek_nilai);
									jrawat_cek_nilai_cfField.setValue(CurrencyFormatted(jrawat_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;
			case 'transfer' :
				transfer_jual_rawat_DataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(transfer_jual_rawat_DataStore.getCount()){
										jrawat_transfer_record=transfer_jual_rawat_DataStore.getAt(0);
										jrawat_transfer_bankField.setValue(jrawat_transfer_record.data.jtransfer_bank);
										jrawat_transfer_namaField.setValue(jrawat_transfer_record.data.jtransfer_nama);
										jrawat_transfer_nilaiField.setValue(jrawat_transfer_record.data.jtransfer_nilai);
										jrawat_transfer_nilai_cfField.setValue(CurrencyFormatted(jrawat_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_rawat_DataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_rawat_DataStore.getCount()){
										jrawat_tunai_record=tunai_jual_rawat_DataStore.getAt(0);
										jrawat_tunai_nilaiField.setValue(jrawat_tunai_record.data.jtunai_nilai);
										jrawat_tunai_nilai_cfField.setValue(CurrencyFormatted(jrawat_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_rawatDataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 1
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_rawatDataStore.getCount()){
										jrawat_voucher_record=voucher_jual_rawatDataStore.getAt(0);
										jrawat_voucher_noField.setValue(jrawat_voucher_record.data.tvoucher_novoucher);
										jrawat_voucher_cashbackField.setValue(jrawat_voucher_record.data.tvoucher_nilai);
										jrawat_voucher_cashback_cfField.setValue(CurrencyFormatted(jrawat_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
		switch(jrawat_cara2Field.getValue()){
			case 'kwitansi':
				kwitansi_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_rawat_DataStore.getCount()){
								jrawat_kwitansi_record=kwitansi_jual_rawat_DataStore.getAt(0).data;
								jrawat_kwitansi_no2Field.setValue(jrawat_kwitansi_record.kwitansi_no);
                                jrawat_kwitansi_no2_idField.setValue(jrawat_kwitansi_record.kwitansi_id);
								jrawat_kwitansi_nama2Field.setValue(jrawat_kwitansi_record.cust_nama);
								jrawat_kwitansi_sisa2Field.setValue(jrawat_kwitansi_record.kwitansi_sisa);
								jrawat_kwitansi_nilai2Field.setValue(jrawat_kwitansi_record.jkwitansi_nilai);
								jrawat_kwitansi_nilai2_cfField.setValue(CurrencyFormatted(jrawat_kwitansi_record.jkwitansi_nilai));
								jrawat_jual_kwitansi_idField2.setValue(jrawat_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_jual_rawat_DataStore.getCount()){
								 jrawat_card_record=card_jual_rawat_DataStore.getAt(0).data;
								 jrawat_card_nama2Field.setValue(jrawat_card_record.jcard_nama);
								 jrawat_card_edc2Field.setValue(jrawat_card_record.jcard_edc);
								 jrawat_card_no2Field.setValue(jrawat_card_record.jcard_no);
								 jrawat_card_nilai2Field.setValue(jrawat_card_record.jcard_nilai);
								 jrawat_card_nilai2_cfField.setValue(CurrencyFormatted(jrawat_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 2
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_rawat_DataStore.getCount()){
									jrawat_cek_record=cek_jual_rawat_DataStore.getAt(0).data;
									jrawat_cek_nama2Field.setValue(jrawat_cek_record.jcek_nama);
									jrawat_cek_no2Field.setValue(jrawat_cek_record.jcek_no);
									jrawat_cek_valid2Field.setValue(jrawat_cek_record.jcek_valid);
									jrawat_cek_bank2Field.setValue(jrawat_cek_record.jcek_bank);
									jrawat_cek_nilai2Field.setValue(jrawat_cek_record.jcek_nilai);
									jrawat_cek_nilai2_cfField.setValue(CurrencyFormatted(jrawat_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_rawat_DataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								jrawat_transfer_record=transfer_jual_rawat_DataStore.getAt(0);
									if(transfer_jual_rawat_DataStore.getCount()){
										jrawat_transfer_record=transfer_jual_rawat_DataStore.getAt(0);
										jrawat_transfer_bank2Field.setValue(jrawat_transfer_record.data.jtransfer_bank);
										jrawat_transfer_nama2Field.setValue(jrawat_transfer_record.data.jtransfer_nama);
										jrawat_transfer_nilai2Field.setValue(jrawat_transfer_record.data.jtransfer_nilai);
										jrawat_transfer_nilai2_cfField.setValue(CurrencyFormatted(jrawat_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_rawat_DataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_rawat_DataStore.getCount()){
										jrawat_tunai_record=tunai_jual_rawat_DataStore.getAt(0);
										jrawat_tunai_nilai2Field.setValue(jrawat_tunai_record.data.jtunai_nilai);
										jrawat_tunai_nilai2_cfField.setValue(CurrencyFormatted(jrawat_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_rawatDataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 2
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_rawatDataStore.getCount()){
										jrawat_voucher_record=voucher_jual_rawatDataStore.getAt(0);
										jrawat_voucher_no2Field.setValue(jrawat_voucher_record.data.tvoucher_novoucher);
										jrawat_voucher_cashback2Field.setValue(jrawat_voucher_record.data.tvoucher_nilai);
										jrawat_voucher_cashback2_cfField.setValue(CurrencyFormatted(jrawat_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
		switch(jrawat_cara3Field.getValue()){
			case 'kwitansi':
				kwitansi_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						  if (success) {
							if(kwitansi_jual_rawat_DataStore.getCount()){
								jrawat_kwitansi_record=kwitansi_jual_rawat_DataStore.getAt(0).data;
								jrawat_kwitansi_no3Field.setValue(jrawat_kwitansi_record.kwitansi_no);
                                jrawat_kwitansi_no3_idField.setValue(jrawat_kwitansi_record.kwitansi_id);
								jrawat_kwitansi_nama3Field.setValue(jrawat_kwitansi_record.cust_nama);
								jrawat_kwitansi_nilai3Field.setValue(jrawat_kwitansi_record.jkwitansi_nilai);
								jrawat_kwitansi_nilai3_cfField.setValue(CurrencyFormatted(jrawat_kwitansi_record.jkwitansi_nilai));
								jrawat_jual_kwitansi_idField3.setValue(jrawat_kwitansi_record.jkwitansi_id);
							}
						  }
					  }
				});
				break;
			case 'card' :
				card_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
						 if (success) { 
							 if(card_jual_rawat_DataStore.getCount()){
								 jrawat_card_record=card_jual_rawat_DataStore.getAt(0).data;
								 jrawat_card_nama3Field.setValue(jrawat_card_record.jcard_nama);
								 jrawat_card_edc3Field.setValue(jrawat_card_record.jcard_edc);
								 jrawat_card_no3Field.setValue(jrawat_card_record.jcard_no);
								 jrawat_card_nilai3Field.setValue(jrawat_card_record.jcard_nilai);
								 jrawat_card_nilai3_cfField.setValue(CurrencyFormatted(jrawat_card_record.jcard_nilai));
							 }
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_rawat_DataStore.load({
					params : {
						no_faktur: jrawat_nobuktiField.getValue(),
						cara_bayar_ke: 3
					},
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_rawat_DataStore.getCount()){
									jrawat_cek_record=cek_jual_rawat_DataStore.getAt(0).data;
									jrawat_cek_nama3Field.setValue(jrawat_cek_record.jcek_nama);
									jrawat_cek_no3Field.setValue(jrawat_cek_record.jcek_no);
									jrawat_cek_valid3Field.setValue(jrawat_cek_record.jcek_valid);
									jrawat_cek_bank3Field.setValue(jrawat_cek_record.jcek_bank);
									jrawat_cek_nilai3Field.setValue(jrawat_cek_record.jcek_nilai);
									jrawat_cek_nilai3_cfField.setValue(CurrencyFormatted(jrawat_cek_record.jcek_nilai));
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_rawat_DataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
								jrawat_transfer_record=transfer_jual_rawat_DataStore.getAt(0);
									if(transfer_jual_rawat_DataStore.getCount()){
										jrawat_transfer_record=transfer_jual_rawat_DataStore.getAt(0);
										jrawat_transfer_bank3Field.setValue(jrawat_transfer_record.data.jtransfer_bank);
										jrawat_transfer_nama3Field.setValue(jrawat_transfer_record.data.jtransfer_nama);
										jrawat_transfer_nilai3Field.setValue(jrawat_transfer_record.data.jtransfer_nilai);
										jrawat_transfer_nilai3_cfField.setValue(CurrencyFormatted(jrawat_transfer_record.data.jtransfer_nilai));
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_rawat_DataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_rawat_DataStore.getCount()){
										jrawat_tunai_record=tunai_jual_rawat_DataStore.getAt(0);
										jrawat_tunai_nilai3Field.setValue(jrawat_tunai_record.data.jtunai_nilai);
										jrawat_tunai_nilai3_cfField.setValue(CurrencyFormatted(jrawat_tunai_record.data.jtunai_nilai));
									}
							}
					 	}
				  });
				break;
			case 'voucher' :
				voucher_jual_rawatDataStore.load({
						params : {
							no_faktur: jrawat_nobuktiField.getValue(),
							cara_bayar_ke: 3
						},
					  	callback: function(opts, success, response)  {
							if (success) {
									if(voucher_jual_rawatDataStore.getCount()){
										jrawat_voucher_record=voucher_jual_rawatDataStore.getAt(0);
										jrawat_voucher_no3Field.setValue(jrawat_voucher_record.data.tvoucher_novoucher);
										jrawat_voucher_cashback3Field.setValue(jrawat_voucher_record.data.tvoucher_nilai);
										jrawat_voucher_cashback3_cfField.setValue(CurrencyFormatted(jrawat_voucher_record.data.tvoucher_nilai));
									}
							}
					 	}
				  });
				break;
		}
		}
		
		jrawat_stat_dokField.on("select",function(){
		var status_awal = master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok');
		if(status_awal =='Terbuka' && jrawat_stat_dokField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
		   //progressText: 'proses...',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jrawat_stat_dokField.setValue('Terbuka');
		}
		else if(status_awal =='Tertutup' && jrawat_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jrawat_stat_dokField.setValue('Tertutup');
		}
		else if(status_awal =='Batal' && jrawat_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		jrawat_stat_dokField.setValue('Tertutup');
		}
		else if(jrawat_stat_dokField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', jrawat_status_delete);
		}
		});		
	}
	/* End setValue to EDIT*/
	
	function jrawat_status_delete(btn){
	if(btn=='yes')
	{
		jrawat_stat_dokField.setValue('Batal');
	}  
	else
		jrawat_stat_dokField.setValue(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok'));
	}
	
	function master_jual_rawat_set_updating(){
			if(jrawat_post2db=="UPDATE" && master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cust')=='STAFF MIRACLE'){
				jrawat_karyawanField.setDisabled(false);
			}else {
				jrawat_karyawanField.setDisabled(true);
				jrawat_karyawanField.setValue(null);
				jrawat_nikkaryawanField.setValue(null);
			}
            if(jrawat_post2db=="UPDATE" && master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Terbuka"){
                jrawat_custField.setDisabled(true);
                jrawat_tanggalField.setDisabled(true);
                jrawat_keteranganField.setDisabled(false);
				jrawat_ket_diskField.setDisabled(false);
				jrawat_ket_disk_medisField.setDisabled(false);
				jrawat_nikkaryawanField.setDisabled(false);
				
				jrawat_caraField.setDisabled(false);
				master_jual_rawat_tunaiGroup.setDisabled(false);
				master_jual_rawat_cardGroup.setDisabled(false);
				master_jual_rawat_cekGroup.setDisabled(false);
				master_jual_rawat_kwitansiGroup.setDisabled(false);
				master_jual_rawat_transferGroup.setDisabled(false);
				master_jual_rawat_voucherGroup.setDisabled(false);
				
				jrawat_cara2Field.setDisabled(false);
				master_jual_rawat_tunai2Group.setDisabled(false);
				master_jual_rawat_card2Group.setDisabled(false);
				master_jual_rawat_cek2Group.setDisabled(false);
				master_jual_rawat_kwitansi2Group.setDisabled(false);
				master_jual_rawat_transfer2Group.setDisabled(false);
				master_jual_rawat_voucher2Group.setDisabled(false);
				
				jrawat_cara3Field.setDisabled(false);
				master_jual_rawat_tunai3Group.setDisabled(false);
				master_jual_rawat_card3Group.setDisabled(false);
				master_jual_rawat_cek3Group.setDisabled(false);
				master_jual_rawat_kwitansi3Group.setDisabled(false);
				master_jual_rawat_transfer3Group.setDisabled(false);
				master_jual_rawat_voucher3Group.setDisabled(false);
				
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
				detail_jual_rawatListEditorGrid.djrawat_add.enable();
				<?php } ?>
				combo_jual_rawat.setDisabled(false);
				drawat_jumlahField.setDisabled(false);
				drawat_hargaField.setDisabled(true);
				drawat_subtotalField.setDisabled(false);
				drawat_jenis_diskonField.setDisabled(false);
				drawat_diskonField.setDisabled(true);
				drawat_subtotal_netField.setDisabled(false);
				
                jrawat_cashback_cfField.setDisabled(false);
				jrawat_cashback_cf_medisField.setDisabled(false);
                jrawat_stat_dokField.setDisabled(false);
            }
            if(jrawat_post2db=="UPDATE" && (master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Tertutup" || master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Batal")){
                jrawat_custField.setDisabled(true);
                jrawat_tanggalField.setDisabled(true);
                jrawat_keteranganField.setDisabled(true);
				jrawat_ket_diskField.setDisabled(true);
				jrawat_ket_disk_medisField.setDisabled(true);
				jrawat_karyawanField.setDisabled(true);
				jrawat_nikkaryawanField.setDisabled(true);
				
				jrawat_caraField.setDisabled(true);
				master_jual_rawat_tunaiGroup.setDisabled(true);
				master_jual_rawat_cardGroup.setDisabled(true);
				master_jual_rawat_cekGroup.setDisabled(true);
				master_jual_rawat_kwitansiGroup.setDisabled(true);
				master_jual_rawat_transferGroup.setDisabled(true);
				master_jual_rawat_voucherGroup.setDisabled(true);
				
				jrawat_cara2Field.setDisabled(true);
				master_jual_rawat_tunai2Group.setDisabled(true);
				master_jual_rawat_card2Group.setDisabled(true);
				master_jual_rawat_cek2Group.setDisabled(true);
				master_jual_rawat_kwitansi2Group.setDisabled(true);
				master_jual_rawat_transfer2Group.setDisabled(true);
				master_jual_rawat_voucher2Group.setDisabled(true);
				
				jrawat_cara3Field.setDisabled(true);
				master_jual_rawat_tunai3Group.setDisabled(true);
				master_jual_rawat_card3Group.setDisabled(true);
				master_jual_rawat_cek3Group.setDisabled(true);
				master_jual_rawat_kwitansi3Group.setDisabled(true);
				master_jual_rawat_transfer3Group.setDisabled(true);
				master_jual_rawat_voucher3Group.setDisabled(true);
				
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
				detail_jual_rawatListEditorGrid.djrawat_add.disable();
				<?php } ?>
				combo_jual_rawat.setDisabled(true);
				drawat_jumlahField.setDisabled(true);
				drawat_hargaField.setDisabled(true);
				drawat_subtotalField.setDisabled(true);
				drawat_jenis_diskonField.setDisabled(true);
				drawat_diskonField.setDisabled(true);
				drawat_subtotal_netField.setDisabled(true);
				
                jrawat_cashback_cfField.setDisabled(true);
				jrawat_cashback_cf_medisField.setDisabled(true);
                jrawat_stat_dokField.setDisabled(false);
            }
			
			if(jrawat_post2db=="UPDATE" && master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Batal"){
				jrawat_custField.setDisabled(true);
				jrawat_tanggalField.setDisabled(true);
				jrawat_keteranganField.setDisabled(true);
				jrawat_ket_diskField.setDisabled(true);
				jrawat_ket_disk_medisField.setDisabled(true);
				jrawat_stat_dokField.setDisabled(true);
				jrawat_karyawanField.setDisabled(true);
				jrawat_nikkaryawanField.setDisabled(true);

				jrawat_caraField.setDisabled(true);
				master_jual_rawat_tunaiGroup.setDisabled(true);
				master_jual_rawat_cardGroup.setDisabled(true);
				master_jual_rawat_cekGroup.setDisabled(true);
				master_jual_rawat_kwitansiGroup.setDisabled(true);
				master_jual_rawat_transferGroup.setDisabled(true);
				master_jual_rawat_voucherGroup.setDisabled(true);
				
				jrawat_cara2Field.setDisabled(true);
				master_jual_rawat_tunai2Group.setDisabled(true);
				master_jual_rawat_card2Group.setDisabled(true);
				master_jual_rawat_cek2Group.setDisabled(true);
				master_jual_rawat_kwitansi2Group.setDisabled(true);
				master_jual_rawat_transfer2Group.setDisabled(true);
				master_jual_rawat_voucher2Group.setDisabled(true);
				
				jrawat_cara3Field.setDisabled(true);
				master_jual_rawat_tunai3Group.setDisabled(true);
				master_jual_rawat_card3Group.setDisabled(true);
				master_jual_rawat_cek3Group.setDisabled(true);
				master_jual_rawat_kwitansi3Group.setDisabled(true);
				master_jual_rawat_transfer3Group.setDisabled(true);
				master_jual_rawat_voucher3Group.setDisabled(true);
				
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
				detail_jual_rawatListEditorGrid.djrawat_add.disable();
				<?php } ?>
				combo_jual_rawat.setDisabled(true);
				drawat_jumlahField.setDisabled(true);
				drawat_hargaField.setDisabled(true);
				drawat_subtotalField.setDisabled(true);
				drawat_jenis_diskonField.setDisabled(true);
				drawat_diskonField.setDisabled(true);
				drawat_subtotal_netField.setDisabled(true);
				jrawat_cashback_cfField.setDisabled(true);
				jrawat_cashback_cf_medisField.setDisabled(true);
		}	
	}
  
    function load_membership(){
		var cust_id=0;
		if(jrawat_post2db=="CREATE"){
			cust_id=jrawat_custField.getValue();
		}else if(jrawat_post2db=="UPDATE"){
			cust_id=jrawat_cust_idField.getValue();
		}
		if(cust_id!==''){
			memberDataStore.load({
				params : { member_cust: cust_id },
				callback: function(opts, success, response)  {
					 if (success) {
						if(memberDataStore.getCount()){
							jrawat_member_record=memberDataStore.getAt(0).data;
							jrawat_cust_nomemberField.setValue(jrawat_member_record.member_no);
							jrawat_valid_memberField.setValue(jrawat_member_record.member_valid);
							jrawat_cust_ultahField.setValue(jrawat_member_record.cust_tgllahir);
							jrawat_cust_priorityField.setValue(jrawat_member_record.cust_priority_star);
							if (jrawat_cust_priorityField.getValue()=='*') {
										jrawat_cust_priorityLabel.setText("*");
									}
									else {
										jrawat_cust_priorityLabel.setText("");
									}	
								
						}
					}
				}
			}); 
		}
	}
	
	function load_karyawan(){
		var karyawan_id=0;
		if(jrawat_post2db=="CREATE"){
			karyawan_id=jrawat_karyawanField.getValue();
		}else if(jrawat_post2db=="UPDATE"){
			karyawan_id=jrawat_karyawan_idField.getValue();
		}
		if(jrawat_karyawanField.getValue()!=''){
			karyawanDataStore.load({
					params : { karyawan_id: karyawan_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(karyawanDataStore.getCount()){
								jrawat_karyawan_record=karyawanDataStore.getAt(0).data;
								jrawat_nikkaryawanField.setValue(jrawat_karyawan_record.karyawan_no);
							}
						}
					}
			}); 
		}
	}
	
	/* Function for Check if the form is valid */
	function is_master_jual_rawat_form_valid(){
		return (/*jrawat_diskonField.isValid() &&*/ jrawat_karyawanField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_jual_rawat_createWindow.isVisible()){
			master_jual_rawat_reset_form();
			jrawat_caraField.setValue("card");
			master_jual_rawat_cardGroup.setVisible(true);
			detail_jual_rawat_DataStore.load({params: {master_id:0}});
			detail_ambil_paketDataStore.load({params: {master_id : 0, start:0, limit:pageS}});
			jrawat_post2db="CREATE";
			msg='created';
			master_cara_bayarTabPanel.setActiveTab(0);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			master_jual_rawat_createForm.savePrintButton.disable();
			master_jual_rawat_createForm.savePrintButton2.disable();
			<?php } ?>
            master_cara_bayarTabPanel.setDisabled(false);
			jrawat_karyawanField.setDisabled(true);
			master_jual_rawat_createWindow.show();
		} else {
			master_jual_rawat_createWindow.toFront();
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function master_jual_rawat_confirm_update(){
		master_jual_rawat_reset_form();
		jrawat_karyawanDataStore.load();
		/* only one record is selected here */
		if(master_jual_rawatListEditorGrid.selModel.getCount() == 1) {
			cbo_kwitansi_jual_rawat_DataStore.load();
			cbo_referalKasirDataStore.load();
			master_cara_bayarTabPanel.setActiveTab(0);
			jrawat_post2db='UPDATE';
			if(master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('keterangan_paket')!=="paket"){
				cbo_drawat_rawatDataStore.load({
					params: {
						query:master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_id'),
						aktif: 'yesno'
					},
					callback:function(opts, success, response){
						if(success){
							detail_jual_rawat_DataStore.load({
								params : {master_id : master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_id'), start:0, limit:pageS},
								callback:function(opts, success, response){
									if(success){
										detail_ambil_paketDataStore.load({
											params: {
												dpaket_id : master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('dpaket_id'),
												tanggal: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_tanggal').format('Y-m-d'),
												dapaket_cust: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cust_id'),
												dapaket_stat_dok: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok'),
												dapaket_nobukti_pajak: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_pajak'),
												dapaket_nobukti_medis: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_medis'),
												start:0,
												limit:pageS
											},
											callback:function(opts, success, response){
												if(success){
													master_jual_rawat_set_form();
													master_jual_rawat_set_updating();
													master_jual_rawat_createWindow.setDisabled(false);
												}
											}
										});
									}
								}
							});
						}
					}
				});
			}else{
				detail_jual_rawat_DataStore.load({
					params : {master_id : 0, start:0, limit:pageS},
					callback:function(opts, success, response){
						if(success){
							detail_ambil_paketDataStore.load({
								params: {
									dpaket_id : master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('dpaket_id'),
									tanggal: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_tanggal').format('Y-m-d'),
									dapaket_cust: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_cust_id'),
									dapaket_stat_dok: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok'),
									dapaket_nobukti_pajak: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_pajak'),
									dapaket_nobukti_medis: master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_nobukti_medis'),
									start:0,
									limit:pageS
								},
								callback:function(opts, success, response){
									if(success){
										master_jual_rawat_set_form();
										master_jual_rawat_set_updating();
										master_jual_rawat_createWindow.setDisabled(false);
									}
								}
							});
						}
					}
				});
			}
			msg='updated';
			if(jrawat_post2db=="UPDATE" && master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Terbuka"){
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
				master_jual_rawat_createForm.savePrintButton.enable();
				master_jual_rawat_createForm.savePrintButton2.enable();
				master_jual_rawat_createForm.PrintOnlyButton.disable();
				master_jual_rawat_createForm.PrintOnlyButton2.disable();
				<?php } ?>
			}
			if(jrawat_post2db=="UPDATE" && master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Tertutup"){
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
				master_jual_rawat_createForm.savePrintButton.disable();
				master_jual_rawat_createForm.savePrintButton2.enable();
				master_jual_rawat_createForm.PrintOnlyButton.enable();
				master_jual_rawat_createForm.PrintOnlyButton2.disable();
				<?php } ?>
			}
			if(jrawat_post2db=="UPDATE" && master_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('jrawat_stat_dok')=="Batal"){
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
				master_jual_rawat_createForm.savePrintButton.disable();
				master_jual_rawat_createForm.savePrintButton2.disable();
				master_jual_rawat_createForm.PrintOnlyButton.enable();
				master_jual_rawat_createForm.PrintOnlyButton2.enable();
				<?php } ?>
			}
            master_cara_bayarTabPanel.setDisabled(false);
			master_jual_rawat_createWindow.show();
		} else {
			master_jual_rawat_createWindow.setDisabled(false);
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
  
	/* Function for Retrieve DataStore */
	master_jual_rawat_DataStore = new Ext.data.Store({
		id: 'master_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jrawat_id', type: 'int', mapping: 'jrawat_id'}, 
			{name: 'jrawat_nobukti', type: 'string', mapping: 'jrawat_nobukti'}, 
			{name: 'jrawat_nobukti_medis', type: 'string', mapping: 'jrawat_nobukti_medis'}, 
			{name: 'jrawat_nobukti_pajak', type: 'string', mapping: 'jrawat_nobukti_pajak'}, 
			{name: 'jrawat_total_medis', type: 'float', mapping: 'jrawat_total_medis'}, 
			{name: 'jrawat_total_nonmedis', type: 'float', mapping: 'jrawat_total_nonmedis'}, 
			{name: 'jrawat_grooming', type: 'int', mapping: 'jrawat_grooming'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'jrawat_cust_edit', type: 'string', mapping: 'cust_nama_edit'}, 
			{name: 'jrawat_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'jrawat_cust_id', type: 'int', mapping: 'jrawat_cust'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_member', type: 'string', mapping: 'cust_member'},
			{name: 'cust_member_no', type: 'string', mapping: 'member_no'},
			{name: 'jrawat_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'jrawat_tanggal'}, 
			{name: 'jrawat_diskon', type: 'int', mapping: 'jrawat_diskon'}, 
			{name: 'jrawat_cashback', type: 'float', mapping: 'jrawat_cashback'},
			{name: 'jrawat_cashback_medis', type: 'float', mapping: 'jrawat_cashback_medis'},
			{name: 'jrawat_cara', type: 'string', mapping: 'jrawat_cara'}, 
			{name: 'jrawat_cara2', type: 'string', mapping: 'jrawat_cara2'}, 
			{name: 'jrawat_cara3', type: 'string', mapping: 'jrawat_cara3'}, 
			{name: 'jrawat_total', type: 'float', mapping: 'jrawat_totalbiaya'}, 
			{name: 'jrawat_bayar', type: 'float', mapping: 'jrawat_bayar'},
			{name: 'jrawat_keterangan', type: 'string', mapping: 'jrawat_keterangan'},
			{name: 'jrawat_ket_disk', type: 'string', mapping: 'jrawat_ket_disk'},
			{name: 'jrawat_ket_disk_medis', type: 'string', mapping: 'jrawat_ket_disk_medis'},
			{name: 'jrawat_stat_dok', type: 'string', mapping: 'jrawat_stat_dok'}, 				
			{name: 'jrawat_creator', type: 'string', mapping: 'jrawat_creator'}, 
			{name: 'jrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jrawat_date_create'}, 
			{name: 'jrawat_update', type: 'string', mapping: 'jrawat_update'}, 
			{name: 'jrawat_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jrawat_date_update'}, 
			{name: 'jrawat_revised', type: 'int', mapping: 'jrawat_revised'},
			{name: 'keterangan_paket', type: 'string', mapping: 'keterangan_paket'},
			{name: 'dpaket_id', type: 'int', mapping: 'dpaket_id'},
			{name: 'dapaket_harga', type: 'float', mapping: 'dapaket_harga'},
			{name: 'cust_priority_star', type: 'string', mapping: 'cust_priority_star'}
		]),
		sortInfo:{field: 'jrawat_nobukti', direction: "DESC"}
	});
	/* End of Function */
	
	jrawat_karyawanDataStore = new Ext.data.Store({
		id: 'jrawat_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_allkaryawan_list', 
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
	
	cbo_voucher_jual_rawatDataStore = new Ext.data.Store({
		id: 'cbo_voucher_jual_rawatDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_voucher_list', 
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
	
	voucher_jual_rawatDataStore = new Ext.data.Store({
		id: 'voucher_jual_rawatDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_voucher_by_ref', 
			method: 'POST'
		}),baseParams: {start:0, limit: 10},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'tvoucher_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'tvoucher_id', type: 'int', mapping: 'tvoucher_id'},
			{name: 'tvoucher_novoucher', type: 'string', mapping: 'tvoucher_novoucher'},
			{name: 'tvoucher_nilai', type: 'float', mapping: 'tvoucher_nilai'}
		]),
		sortInfo:{field: 'tvoucher_novoucher', direction: "ASC"}
	});
	
	/* Function for Retrieve DataStore */
	cbo_cust_jual_rawat_DataStore = new Ext.data.Store({
		id: 'cbo_cust_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_customer_list', 
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
	// Customer rendering Template
    var customer_jual_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br /></span>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br/>',
            'Alamat: {cust_alamat}<br/>',
			'Telp Rumah: {cust_telprumah}<br>',
        '</div></tpl>'
    );
	
	/* Function for Retrieve Combo Kwitansi DataStore */
	cbo_kwitansi_jual_rawat_DataStore = new Ext.data.Store({
		id: 'cbo_kwitansi_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_kwitansi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kwitansi_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
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

	var kwitansi_jual_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{ckwitansi_no}</b> <br/>',
			'a/n {ckwitansi_cust_nama} [ {ckwitansi_cust_no} ]<br/></span>',
			'{ckwitansi_cust_alamat}, <br>Sisa: <b>Rp. {total_sisa}</b>,<br>Ket : {kwitansi_keterangan} </span>',
		'</div></tpl>'
    );
	
	/* Function for Retrieve Kwitansi DataStore */
	kwitansi_jual_rawat_DataStore = new Ext.data.Store({
		id: 'kwitansi_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_kwitansi_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jkwitansi_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jkwitansi_id', type: 'int', mapping: 'jkwitansi_id'},
			{name: 'kwitansi_no', type: 'string', mapping: 'kwitansi_no'},
            {name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'},
			{name: 'kwitansi_sisa', type: 'float', mapping: 'kwitansi_sisa'},
			{name: 'jkwitansi_nilai', type: 'float', mapping: 'jkwitansi_nilai'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'}
		]),
		sortInfo:{field: 'jkwitansi_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Kwitansi DataStore */
	card_jual_rawat_DataStore = new Ext.data.Store({
		id: 'card_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_card_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcard_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
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
	cek_jual_rawat_DataStore = new Ext.data.Store({
		id: 'cek_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_cek_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jcek_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jcek_id', type: 'int', mapping: 'jcek_id'}, 
			{name: 'jcek_nama', type: 'string', mapping: 'jcek_nama'},
			{name: 'jcek_no', type: 'string', mapping: 'jcek_no'},
			{name: 'jcek_valid', type: 'string', mapping: 'jcek_valid'}, 
			{name: 'jcek_bank', type: 'string', mapping: 'jcek_bank'},
			{name: 'jcek_nilai', type: 'float', mapping: 'jcek_nilai'}
		]),
		sortInfo:{field: 'jcek_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Transfer DataStore */
	transfer_jual_rawat_DataStore = new Ext.data.Store({
		id: 'transfer_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_transfer_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtransfer_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jtransfer_id', type: 'int', mapping: 'jtransfer_id'}, 
			{name: 'jtransfer_bank', type: 'int', mapping: 'jtransfer_bank'},
			{name: 'jtransfer_nama', type: 'string', mapping: 'jtransfer_nama'},
			{name: 'jtransfer_nilai', type: 'float', mapping: 'jtransfer_nilai'}
		]),
		sortInfo:{field: 'jtransfer_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve Tunai DataStore */
	tunai_jual_rawat_DataStore = new Ext.data.Store({
		id: 'tunai_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_tunai_by_ref', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jtunai_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jtunai_id', type: 'int', mapping: 'jtunai_id'}, 
			{name: 'jtunai_nilai', type: 'float', mapping: 'jtunai_nilai'}
		]),
		sortInfo:{field: 'jtunai_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* GET Bank-List.Store */
	jrawat_bankDataStore = new Ext.data.Store({
		id:'jrawat_bankDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_bank_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
		/* dataIndex => insert intomaster_jual_rawat_ColumnModel, Mapping => for initiate table column */ 
			{name: 'jrawat_bank_value', type: 'int', mapping: 'mbank_id'}, 
			{name: 'jrawat_bank_display', type: 'string', mapping: 'mbank_nama'}
		]),
		sortInfo:{field: 'jrawat_bank_display', direction: "DESC"}
		});
	/* END GET Bank-List.Store */
	
	cbo_drawat_rawatDataStore = new Ext.data.Store({
		id: 'cbo_drawat_rawatDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_rawat_list', 
			method: 'POST'
		}),baseParams: {aktif: 'yes', start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'drawat_rawat_value', type: 'int', mapping: 'rawat_id'},
			{name: 'drawat_rawat_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'drawat_rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'drawat_rawat_group', type: 'string', mapping: 'group_nama'},
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'},
			{name: 'drawat_rawat_du', type: 'float', mapping: 'rawat_du'},
			{name: 'drawat_rawat_dm', type: 'float', mapping: 'rawat_dm'},
			{name: 'drawat_rawat_dultah', type: 'float', mapping: 'rawat_dultah'},
			{name: 'drawat_rawat_dcard', type: 'float', mapping: 'rawat_dcard'},
			{name: 'drawat_rawat_dkolega', type: 'float', mapping: 'rawat_dkolega'},
			{name: 'drawat_rawat_dkeluarga', type: 'float', mapping: 'rawat_dkeluarga'},
			{name: 'drawat_rawat_downer', type: 'float', mapping: 'rawat_downer'},
			{name: 'drawat_rawat_dgrooming', type: 'float', mapping: 'rawat_dgrooming'},
			{name: 'drawat_rawat_dwartawan', type: 'float', mapping: 'rawat_dwartawan'},
			{name: 'drawat_rawat_dstaffdokter', type: 'float', mapping: 'rawat_dstaffdokter'},
			{name: 'drawat_rawat_dpromo', type: 'float', mapping: 'rawat_dpromo'},
			{name: 'drawat_rawat_dstaffnondokter', type: 'float', mapping: 'rawat_dstaffnondokter'},
			{name: 'drawat_rawat_display', type: 'string', mapping: 'rawat_nama'},
			{name: 'drawat_edit_harga', type: 'int', mapping: 'rawat_edit_harga'}
		]),
		sortInfo:{field: 'drawat_rawat_display', direction: "ASC"}
	});

	var rawat_jual_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{drawat_rawat_kode}| <b>{drawat_rawat_display}</b>',
		'</div></tpl>'
    );
	
  	/* Function for Identify of Window Column Model */
	master_jual_rawat_ColumnModel = new Ext.grid.ColumnModel(
		[/*{
			header: '#',
			readOnly: true,
			dataIndex: 'jrawat_id',
			width: 5,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},*/
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'jrawat_tanggal',
			width: 100,	//78,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'jrawat_nobukti',
			width: 80,	//82,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
		}, 
		{
			header: '<div align="center">' + 'Faktur Pajak' + '</div>',
			dataIndex: 'jrawat_nobukti_pajak',
			width: 80,	//82,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'cust_no',
			width: 80,
			sortable: false,
			readOnly: true
		},
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: 'cust_priority_star',
			width: 20,
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
			dataIndex: 'jrawat_cust',
			width: 200,	//185,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'cust_member_no',
			width: 150,
			sortable: false,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Total (Rp)' + '</div>',
			dataIndex: 'jrawat_total',
			align: 'right',
			width: 80,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span> '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Tot Bayar (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jrawat_bayar',
			width: 80,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span> '+Ext.util.Format.number(val,'0,000')+'</span>';
			}	
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'jrawat_keterangan',
			width: 220,	//190,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		/*
		{
			header: '<div align="center">' + 'No Voucher' + '</div>',
			dataIndex: 'jrawat_ket_disk',
			width: 100,	//190,
			sortable: true,
			hidden: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		
		{
			header: '<div align="center">' + 'No Voucher Medis' + '</div>',
			dataIndex: 'jrawat_ket_disk_medis',
			width: 100,	//190,
			sortable: true,
			hidden: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		*/
		
		{
			header: '<div align="center">' + 'Paket' + '</div>',
			dataIndex: 'keterangan_paket',
			width: 60
		}, 
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'jrawat_stat_dok',
			width: 60
		}, 
		{
			header: 'Creator',
			dataIndex: 'jrawat_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Create',
			dataIndex: 'jrawat_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Update',
			dataIndex: 'jrawat_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Update',
			dataIndex: 'jrawat_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}
		/*, 
		{
			header: 'Revised',
			dataIndex: 'jrawat_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}*/	
		]);
	
	master_jual_rawat_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_jual_rawatListEditorGrid =  new Ext.grid.GridPanel({
		id: 'master_jual_rawatListEditorGrid',
		el: 'fp_master_jual_rawat',
		title: 'Daftar Penjualan Perawatan',
		autoHeight: true,
		store: master_jual_rawat_DataStore, // DataStore
		cm: master_jual_rawat_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		trackMouseOver: false,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		//viewConfig: { forceFit:true },
	  	width: 1220,	//940,
		bbar: new Ext.PagingToolbar({
			pageSize: 1000,
			store: master_jual_rawat_DataStore,
			displayInfo: true
		}),
		
		
		

		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		{
			id: 'jrawat_updateBtn',
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_jual_rawat_confirm_update   // Confirm before updating
		}, '-', {
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_jual_rawat_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_jual_rawat_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Faktur<br>- No Cust<br>- Nama Customer<br>- No Member'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_jual_rawat_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_jual_rawat_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_jual_rawat_print  
		}
		]
	});
	/* End of DataStore */
	 
	/* Create Context Menu */
	master_jual_rawat_ContextMenu = new Ext.menu.Menu({
		id: 'master_jual_rawat_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_jual_rawat_editContextMenu 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_jual_rawat_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_jual_rawat_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_jual_rawat_SelectedRow=rowIndex;
		master_jual_rawat_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_jual_rawat_editContextMenu(){
		//master_jual_rawatListEditorGrid.startEditing(master_jual_rawat_SelectedRow,1);
		master_jual_rawat_confirm_update();
  	}
	/* End of Function */
  	
	master_jual_rawatListEditorGrid.addListener('rowcontextmenu', onmaster_jual_rawat_ListEditGridContextMenu);
	master_jual_rawat_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	var voucher_jual_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{voucher_nomor}</b>| {voucher_nama}<br/></span>',
			'Jenis: {voucher_jenis}&nbsp;&nbsp;&nbsp;[Nilai: {voucher_cashback}]',
		'</div></tpl>'
    );
		
	/* Identify  jrawat_id Field */
	jrawat_idField= new Ext.form.NumberField({
		id: 'jrawat_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jrawat_nobukti Field */
	jrawat_nobuktiField= new Ext.form.TextField({
		id: 'jrawat_nobuktiField',
		fieldLabel: 'No Faktur',
		emptyText : '(Auto)',
		disabled : true,
		readOnly:true
	});
	/* Identify  jrawat_cust Field */
	jrawat_custField= new Ext.form.ComboBox({
		id: 'jrawat_custField',
		fieldLabel: 'Customer',
		store: cbo_cust_jual_rawat_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_rawat_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	jrawat_cust_idField= new Ext.form.NumberField();
	jrawat_karyawan_idField = new Ext.form.NumberField();
	
	jrawat_cust_nomemberLabel=new Ext.form.Label({ html: 'No Member: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	/*Untuk ngecek value, apakah nilai nya * , jika iya, maka akan menampilkan / mengaktifkan label Priortiy */
	jrawat_cust_priorityField= new Ext.form.TextField({
		id: 'jrawat_cust_priorityField',
		readOnly: true
	});
	
	// Label ini jika aktif, akan menampilkan bintang (*) besar , dimana tujuan label ini adlh menunjukkan bahwa Customer tersebut adalah Customer High Priority
	jrawat_cust_priorityLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '35px',
			//color: '#006600',
			color: '#CC0000'
		}
	});
	
	jrawat_cust_nomemberField= new Ext.form.TextField({
		id: 'jrawat_cust_nomemberField',
		//fieldLabel: 'No Member',
		emptyText : '(Auto)',
		disabled : true,
		readOnly: true
	});
	
	jrawat_valid_memberLabel=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Member Valid: &nbsp;&nbsp;'});
	
	jrawat_valid_memberField= new Ext.form.DateField({
		id: 'jrawat_valid_memberField',
		//fieldLabel: 'Member Valid',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y'
	});
	
	jrawat_cust_ultahField= new Ext.form.DateField({
		id: 'jrawat_cust_ultahField',
		fieldLabel: 'Tanggal Ultah',
		emptyText : '(Auto)',
		readOnly: true,
		disabled : true,
		format : 'd-m-Y'
	});
	
	jrawat_cust_ultahLabel=new Ext.form.Label({ html: 'Tanggal Ultah : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	
	/* Identify  jrawat_cust Field */
	jrawat_karyawanField= new Ext.form.ComboBox({
		id: 'jrawat_karyawanField',
		fieldLabel: 'Karyawan',
		store: jrawat_karyawanDataStore,
		mode: 'remote',
		displayField:'karyawan_display',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
		allowBlank : false,
        hideTrigger:false,
        tpl: karyawan_tpl,
		disabled : true,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	jrawat_nikkaryawanField= new Ext.form.TextField({
		id: 'jrawat_nikkaryawanField',
		fieldLabel: 'NIK',
		emptyText : '(Auto)',
		readOnly: true,
		renderer: function(value, cell, record){
				return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
			}
	});
	
	jrawat_groomingGroup = new Ext.form.FieldSet({
		id : 'jrawat_groomingGroup',
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
				items: [jrawat_karyawanField, jrawat_nikkaryawanField] 
			}]
	});
	
	/* Identify  jrawat_tanggal Field */
	jrawat_tanggalField= new Ext.form.DateField({
		id: 'jrawat_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  jrawat_diskon Field */
	/*jrawat_diskonField= new Ext.form.NumberField({
		id: 'jrawat_diskonField',
		fieldLabel: 'Disk Tambahan (%)',
		allowNegatife : false,
		blankText: '0',
		emptyText: '0',
		allowDecimals: false,
		enableKeyEvents: true,
		width: 120,
		maxLength: 3,
		maskRe: /([0-9]+)$/
	});*/
	
	///////////SPLIT VOUCHER//////////
	/*untuk nommor voucher nonmedis*/
	jrawat_ket_diskField= new Ext.form.TextField({
		id: 'jrawat_ket_disk',
		fieldLabel: 'No Voucher',
		width: 95,
	});
	/*untuk rupiah voucher nonmedis*/
	jrawat_cashback_cfField= new Ext.form.TextField({
		id: 'jrawat_cashback_cfField',
		fieldLabel: 'Voucher (Rp)',
		allowNegatife : false,
		readOnly : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 95,
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_cashback_num.setValue(cf_tonumber);
				load_total_biaya();
				load_total_bayar();
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/
	});
	
	jrawat_cashback_num= new Ext.form.NumberField({
		id: 'jrawat_cashback_num',
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
	jrawat_ket_disk_medisField= new Ext.form.TextField({
		id: 'jrawat_ket_disk_medis',
		fieldLabel: 'No Voucher',
		width: 95,
	});
	/*untuk rupiah voucher medis*/
	jrawat_cashback_cf_medisField= new Ext.form.TextField({
		id: 'jrawat_cashback_cf_medisField',
		fieldLabel: 'Voucher (Rp)',
		allowNegatife : false,
		readOnly : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 95,
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_cashback_medis_num.setValue(cf_tonumber);
				load_total_biaya();
				load_total_bayar();
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/
	});
	
	jrawat_cashback_medis_num= new Ext.form.NumberField({
		id: 'jrawat_cashback_medis_num',
		allowNegatife : false,
		readOnly : true,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		allowDecimals: false,
		width: 100,
		maskRe: /([0-9]+)$/
	});
	jrawat_voucher_dppField= new Ext.form.NumberField({
		id: 'jrawat_voucher_dppField',
		fieldLabel: 'Voucher DPP (Rp)',
		allowBlank: true,
		anchor: '95%',
		readOnly: true,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney_b',
		width: 120,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	jrawat_voucher_dpp_cfField= new Ext.form.TextField({
		id: 'jrawat_voucher_dpp_cfField',
		fieldLabel: 'Voucher DPP (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	jrawat_subTotal_nonmedisField= new Ext.form.NumberField({
		id: 'jrawat_subTotal_nonmedisField',
		fieldLabel: 'Sub Total non(Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120
	});
	jrawat_subtotal_nonmedis_cfField= new Ext.form.TextField({
		id: 'jrawat_subtotal_nonmedis_cfField',
		fieldLabel: 'Sub Total non(Rp))',
		allowNegatife : false,
		enableKeyEvents: true,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	
	//TOTAL NONMEDIS
	jrawat_total_nonmedisField= new Ext.form.NumberField({
		id: 'jrawat_total_nonmedisField',
		fieldLabel: '<font color="grey">Total (Rp)</font>',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney_b',
		width: 120
	});
	jrawat_total_nonmedis_cfField= new Ext.form.TextField({
		id: 'jrawat_total_nonmedis_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	//SUB TOTAL DPP
	jrawat_dpp_Field= new Ext.form.NumberField({
		id: 'jrawat_dpp_Field',
		fieldLabel: 'Sub Total DPP (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120
	});
	jrawat_dpp_cfField= new Ext.form.TextField({
		id: 'jrawat_dpp_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	//PPN
	jrawat_ppn_Field = new Ext.form.NumberField({
		id: 'jrawat_ppn_Field',
		fieldLabel: 'PPN (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney_b',
		width: 120
	});
	jrawat_ppn_cfField= new Ext.form.TextField({
		id: 'jrawat_ppn_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	jrawat_ppn_cfField= new Ext.form.TextField({
		id: 'jrawat_ppn_cfField',
		fieldLabel: 'PPN(Rp) ',
		allowNegatife : false,
		enableKeyEvents: true,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	
		//TOTAL NONMEDIS
	jrawat_total_nonmedisField= new Ext.form.NumberField({
		id: 'jrawat_total_nonmedisField',
		fieldLabel: '<font color="grey">Total (Rp)</font>',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney_b',
		width: 120
	});
	jrawat_total_nonmedis_cfField= new Ext.form.TextField({
		id: 'jrawat_total_nonmedis_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	//TOTAL MEDIS
	jrawat_total_medisField = new Ext.form.NumberField({
		id: 'jrawat_total_medisField',
		fieldLabel:' <font color="grey">Total (Rp)</font>',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney_b',
		width: 120
	});
	jrawat_total_medis_cfField= new Ext.form.TextField({
		id: 'jrawat_total_medis_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	//SUB TOTAL MEDIS
	jrawat_subTotal_medisField= new Ext.form.NumberField({
		id: 'jrawat_subTotal_medisField',
		fieldLabel: 'Sub Total med(Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120
	});
	jrawat_subTotal_medis_cfField= new Ext.form.TextField({
		id: 'jrawat_subTotal_medis_cfField',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	master_jual_rawat_nonmedisGroup = new Ext.form.FieldSet({
		title: 'Non Medis',
		autoHeight: true,
		collapsible: false,
		layout:'column',
		anchor: '95%',
		items:[
			{
				layout: 'form',
				border:false,
				items: [/*jrawat_no_faktur_pajakField, */ {xtype: 'spacer',height:28}, /*jrawat_jumlah_nonmedisField, */ /*jrawat_dpp_Field, */ /*jrawat_diskon_nonmedisField, */ jrawat_ket_diskField, jrawat_cashback_cfField  /*, jrawat_voucher_dppField, jrawat_subTotal_nonmedisField,jrawat_ppn_Field, jrawat_um_nonmedisField*/,{xtype: 'spacer',height:28}/*, jrawat_total_nonmedisField */]
			}
			]
	});
	
	master_jual_rawat_medisGroup = new Ext.form.FieldSet({
		title: 'Medis',
		autoHeight: true,
		collapsible: false,
		layout:'column',
		anchor: '95%',
		items:[
			{
				layout: 'form',
				border:false,
				items: [/*jrawat_no_faktur_medisField,  */ {xtype: 'spacer',height:28}, /*jrawat_jumlah_medisField, jrawat_subTotal_medisField, jrawat_diskon_medisField, */ jrawat_ket_disk_medisField, jrawat_cashback_cf_medisField /*, {xtype: 'spacer',height:80}, jrawat_um_medisField*/,{xtype: 'spacer',height:28}/*, jrawat_total_medisField */] 
			}
			]
	});
	
	//NONMEDIS
	jrawat_no_faktur_pajakField= new Ext.form.TextField({
		id: 'jrawat_no_faktur_pajakField',
		fieldLabel: 'No Faktur Pajak',
		emptyText : '(Auto)',
		readOnly:true,
		width: 120,
	});
	///////////EndOff SPLIT VOUCHER/////////
	/*jrawat_cashbackField= new Ext.form.NumberField({
		id: 'jrawat_cashbackField',
		fieldLabel: 'Diskon (Rp)',
		allowNegatife : false,
		readOnly : true,
		blankText: '0',
		emptyText: '0',
		enableKeyEvents: true,
		allowDecimals: false,
		width: 100,
		maskRe: /([0-9]+)$/
	});*/
	/* Identify  jrawat_cara Field */
	jrawat_caraField= new Ext.form.ComboBox({
		id: 'jrawat_caraField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_cara_value', 'jrawat_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kuitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jrawat_cara_display',
		valueField: 'jrawat_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jrawat_cara2 Field */
	jrawat_cara2Field= new Ext.form.ComboBox({
		id: 'jrawat_cara2Field',
		fieldLabel: 'Cara Bayar 2',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_cara_value', 'jrawat_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kuitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jrawat_cara_display',
		valueField: 'jrawat_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  jrawat_cara3 Field */
	jrawat_cara3Field= new Ext.form.ComboBox({
		id: 'jrawat_cara3Field',
		fieldLabel: 'Cara Bayar 3',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_cara_value', 'jrawat_cara_display'],
			data:[['tunai','Tunai'],['kwitansi','Kuitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer']]
		}),
		mode: 'local',
		displayField: 'jrawat_cara_display',
		valueField: 'jrawat_cara_value',
		editable: false,
		width: 100,
		triggerAction: 'all'	
	});
	
	jrawat_stat_dokField= new Ext.form.ComboBox({
		id: 'jrawat_stat_dokField',
		fieldLabel: 'Status Dokumen',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_stat_dok_value', 'jrawat_stat_dok_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		emptyText: 'Terbuka',
		displayField: 'jrawat_stat_dok_display',
		valueField: 'jrawat_stat_dok_value',
		editable: false,
		//anchor: '95%',
		width: 100,
		triggerAction: 'all'	
	});
	jrawat_stat_dokField.on('select', function(){
        if(jrawat_stat_dokField.getValue()=='Batal'){
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
            master_jual_rawat_createForm.savePrintButton.disable();
			master_jual_rawat_createForm.savePrintButton2.disable();
			master_jual_rawat_createForm.PrintOnlyButton.enable();
			master_jual_rawat_createForm.PrintOnlyButton2.enable();
			<?php } ?>
        }else{
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
            master_jual_rawat_createForm.savePrintButton.enable();
			master_jual_rawat_createForm.savePrintButton2.enable();
			master_jual_rawat_createForm.PrintOnlyButton.disable();
			master_jual_rawat_createForm.PrintOnlyButton2.disable();
			<?php } ?>
        }
    });
	
	/* Identify  jrawat_keterangan Field */
	jrawat_keteranganField= new Ext.form.TextArea({
		id: 'jrawat_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
	jrawat_voucher_noField= new Ext.form.TextField({
		id: 'jrawat_voucher_noField',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});
	jrawat_voucher_cashback_cfField= new Ext.form.TextField({
		id: 'jrawat_voucher_cashback_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jrawat_voucher_cashbackField= new Ext.form.NumberField({
		id: 'jrawat_voucher_cashbackField',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	dpaket_idField= new Ext.form.NumberField();
	
	master_jual_rawat_voucherGroup= new Ext.form.FieldSet({
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
				items: [jrawat_voucher_noField,jrawat_voucher_cashback_cfField] 
			}
		]
	
	});
	// END Field Voucher

	jrawat_voucher_no2Field= new Ext.form.TextField({
		id: 'jrawat_voucher_no2Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});

	jrawat_voucher_cashback2_cfField= new Ext.form.TextField({
		id: 'jrawat_voucher_cashback2_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jrawat_voucher_cashback2Field= new Ext.form.NumberField({
		id: 'jrawat_voucher_cashback2Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_voucher2Group= new Ext.form.FieldSet({
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
				items: [jrawat_voucher_no2Field,jrawat_voucher_cashback2_cfField] 
			}
		]
	
	});
	// END Field Voucher-2
	
	// START Field Voucher-3
	jrawat_voucher_no3Field= new Ext.form.TextField({
		id: 'jrawat_voucher_no3Field',
		fieldLabel: 'Nomor Voucher',
		maxLength: 10,
		anchor: '95%'
	});

	jrawat_voucher_cashback3_cfField= new Ext.form.TextField({
		id: 'jrawat_voucher_cashback3_cfField',
		fieldLabel: 'Nilai Cashback',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	jrawat_voucher_cashback3Field= new Ext.form.NumberField({
		id: 'jrawat_voucher_cashback3Field',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Cashback',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_voucher3Group= new Ext.form.FieldSet({
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
				items: [jrawat_voucher_no3Field,jrawat_voucher_cashback3_cfField] 
			}
		]
	
	});
	// END Field Voucher-3
	
	// START Field Card
	jrawat_card_namaField= new Ext.form.ComboBox({
		id: 'jrawat_card_namaField',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_card_value', 'jrawat_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jrawat_card_display',
		valueField: 'jrawat_card_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	jrawat_card_edcField= new Ext.form.ComboBox({
		id: 'jrawat_card_edcField',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_card_edc_value', 'jrawat_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jrawat_card_edc_display',
		valueField: 'jrawat_card_edc_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jrawat_card_noField= new Ext.form.TextField({
		id: 'jrawat_card_noField',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	jrawat_card_nilai_cfField= new Ext.form.TextField({
		id: 'jrawat_card_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_card_nilaiField.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_card_nilaiField= new Ext.form.NumberField({
		id: 'jrawat_card_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_cardGroup= new Ext.form.FieldSet({
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
				items: [jrawat_card_namaField,jrawat_card_edcField,jrawat_card_noField,jrawat_card_nilai_cfField] 
			}
		]
	
	});
	// END Field Card
	// START Field Card-2
	jrawat_card_nama2Field= new Ext.form.ComboBox({
		id: 'jrawat_card_nama2Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_card_value', 'jrawat_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jrawat_card_display',
		valueField: 'jrawat_card_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	jrawat_card_edc2Field= new Ext.form.ComboBox({
		id: 'jrawat_card_edc2Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_card_edc_value', 'jrawat_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jrawat_card_edc_display',
		valueField: 'jrawat_card_edc_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jrawat_card_no2Field= new Ext.form.TextField({
		id: 'jrawat_card_no2Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	jrawat_card_nilai2_cfField= new Ext.form.TextField({
		id: 'jrawat_card_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_card_nilai2Field.setValue(cf_tonumber);
				load_total_bayar();
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_card_nilai2Field= new Ext.form.NumberField({
		id: 'jrawat_card_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_card2Group= new Ext.form.FieldSet({
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
				items: [jrawat_card_nama2Field,jrawat_card_edc2Field,jrawat_card_no2Field,jrawat_card_nilai2_cfField] 
			}
		]
	
	});
	// END Field Card-2
	// START Field Card-3
	jrawat_card_nama3Field= new Ext.form.ComboBox({
		id: 'jrawat_card_nama3Field',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_card_value', 'jrawat_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'jrawat_card_display',
		valueField: 'jrawat_card_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	jrawat_card_edc3Field= new Ext.form.ComboBox({
		id: 'jrawat_card_edc3Field',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['jrawat_card_edc_value', 'jrawat_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'jrawat_card_edc_display',
		valueField: 'jrawat_card_edc_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jrawat_card_no3Field= new Ext.form.TextField({
		id: 'jrawat_card_no3Field',
		fieldLabel: 'No Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	jrawat_card_nilai3_cfField= new Ext.form.TextField({
		id: 'jrawat_card_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_card_nilai3Field.setValue(cf_tonumber);
				load_total_bayar();
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_card_nilai3Field= new Ext.form.NumberField({
		id: 'jrawat_card_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_card3Group= new Ext.form.FieldSet({
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
				items: [jrawat_card_nama3Field,jrawat_card_edc3Field,jrawat_card_no3Field,jrawat_card_nilai3_cfField] 
			}
		]
	
	});
	// END Field Card-3
	
	// StART Field Cek
	jrawat_cek_namaField= new Ext.form.TextField({
		id: 'jrawat_cek_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	jrawat_cek_noField= new Ext.form.TextField({
		id: 'jrawat_cek_noField',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jrawat_cek_validField= new Ext.form.DateField({
		id: 'jrawat_cek_validField',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	jrawat_cek_bankField= new Ext.form.ComboBox({
		id: 'jrawat_cek_bankField',
		fieldLabel: 'Bank',
		store: jrawat_bankDataStore,
		mode: 'remote',
		displayField: 'jrawat_bank_display',
		valueField: 'jrawat_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jrawat_cek_bankField)
	});
	
	jrawat_cek_nilai_cfField= new Ext.form.TextField({
		id: 'jrawat_cek_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_cek_nilaiField.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_cek_nilaiField= new Ext.form.NumberField({
		id: 'jrawat_cek_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_cekGroup = new Ext.form.FieldSet({
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
				items: [jrawat_cek_namaField,jrawat_cek_noField,jrawat_cek_validField,jrawat_cek_bankField,jrawat_cek_nilai_cfField] 
			}
		]
	
	});
	// END Field Cek
	// StART Field Cek-2
	jrawat_cek_nama2Field= new Ext.form.TextField({
		id: 'jrawat_cek_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	jrawat_cek_no2Field= new Ext.form.TextField({
		id: 'jrawat_cek_no2Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jrawat_cek_valid2Field= new Ext.form.DateField({
		id: 'jrawat_cek_valid2Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	jrawat_cek_bank2Field= new Ext.form.ComboBox({
		id: 'jrawat_cek_bank2Field',
		fieldLabel: 'Bank',
		store: jrawat_bankDataStore,
		mode: 'remote',
		displayField: 'jrawat_bank_display',
		valueField: 'jrawat_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jrawat_cek_bankField)
	});
	
	jrawat_cek_nilai2_cfField= new Ext.form.TextField({
		id: 'jrawat_cek_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_cek_nilai2Field.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_cek_nilai2Field= new Ext.form.NumberField({
		id: 'jrawat_cek_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_cek2Group = new Ext.form.FieldSet({
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
				items: [jrawat_cek_nama2Field,jrawat_cek_no2Field,jrawat_cek_valid2Field,jrawat_cek_bank2Field,jrawat_cek_nilai2_cfField] 
			}
		]
	
	});
	// END Field Cek-2
	// StART Field Cek-3
	jrawat_cek_nama3Field= new Ext.form.TextField({
		id: 'jrawat_cek_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	jrawat_cek_no3Field= new Ext.form.TextField({
		id: 'jrawat_cek_no3Field',
		fieldLabel: 'No Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jrawat_cek_valid3Field= new Ext.form.DateField({
		id: 'jrawat_cek_valid3Field',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	jrawat_cek_bank3Field= new Ext.form.ComboBox({
		id: 'jrawat_cek_bank3Field',
		fieldLabel: 'Bank',
		store: jrawat_bankDataStore,
		mode: 'remote',
		displayField: 'jrawat_bank_display',
		valueField: 'jrawat_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jrawat_cek_bankField)
	});
	
	jrawat_cek_nilai3_cfField= new Ext.form.TextField({
		id: 'jrawat_cek_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_cek_nilai3Field.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_cek_nilai3Field= new Ext.form.NumberField({
		id: 'jrawat_cek_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_cek3Group = new Ext.form.FieldSet({
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
				items: [jrawat_cek_nama3Field,jrawat_cek_no3Field,jrawat_cek_valid3Field,jrawat_cek_bank3Field,jrawat_cek_nilai3_cfField] 
			}
		]
	
	});
	// END Field Cek-3
	
	// START Field Transfer
	jrawat_transfer_bankField= new Ext.form.ComboBox({
		id: 'jrawat_transfer_bankField',
		fieldLabel: 'Bank',
		store: jrawat_bankDataStore,
		mode: 'remote',
		displayField: 'jrawat_bank_display',
		valueField: 'jrawat_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true,
		renderer: Ext.util.Format.comboRenderer(jrawat_transfer_bankField)
	});

	jrawat_transfer_namaField= new Ext.form.TextField({
		id: 'jrawat_transfer_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jrawat_transfer_nilai_cfField= new Ext.form.TextField({
		id: 'jrawat_transfer_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_transfer_nilaiField.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_transfer_nilaiField= new Ext.form.NumberField({
		id: 'jrawat_transfer_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_transferGroup= new Ext.form.FieldSet({
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
				items: [jrawat_transfer_bankField,jrawat_transfer_namaField,jrawat_transfer_nilai_cfField] 
			}
		]
	
	});
	// END Field Transfer
	// START Field Transfer-2
	jrawat_transfer_bank2Field= new Ext.form.ComboBox({
		id: 'jrawat_transfer_bank2Field',
		fieldLabel: 'Bank',
		store: jrawat_bankDataStore,
		mode: 'remote',
		displayField: 'jrawat_bank_display',
		valueField: 'jrawat_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jrawat_transfer_nama2Field= new Ext.form.TextField({
		id: 'jrawat_transfer_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jrawat_transfer_nilai2_cfField= new Ext.form.TextField({
		id: 'jrawat_transfer_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_transfer_nilai2Field.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_transfer_nilai2Field= new Ext.form.NumberField({
		id: 'jrawat_transfer_nilai2Field',
		fieldLabel: 'Jumlah (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_transfer2Group= new Ext.form.FieldSet({
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
				items: [jrawat_transfer_bank2Field,jrawat_transfer_nama2Field,jrawat_transfer_nilai2_cfField] 
			}
		]
	
	});
	// END Field Transfer-2
	// START Field Transfer-3
	jrawat_transfer_bank3Field= new Ext.form.ComboBox({
		id: 'jrawat_transfer_bank3Field',
		fieldLabel: 'Bank',
		store: jrawat_bankDataStore,
		mode: 'remote',
		displayField: 'jrawat_bank_display',
		valueField: 'jrawat_bank_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	jrawat_transfer_nama3Field= new Ext.form.TextField({
		id: 'jrawat_transfer_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	jrawat_transfer_nilai3_cfField= new Ext.form.TextField({
		id: 'jrawat_transfer_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_transfer_nilai3Field.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_transfer_nilai3Field= new Ext.form.NumberField({
		id: 'jrawat_transfer_nilai3Field',
		fieldLabel: 'Jumlah (Rp)',
		enableKeyEvents: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	master_jual_rawat_transfer3Group= new Ext.form.FieldSet({
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
				items: [jrawat_transfer_bank3Field,jrawat_transfer_nama3Field,jrawat_transfer_nilai3_cfField] 
			}
		]
	
	});
	// END Field Transfer-3
	
	//START Field Tunai-1
	jrawat_tunai_nilai_cfField= new Ext.form.TextField({
		id: 'jrawat_tunai_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_tunai_nilaiField.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_tunai_nilaiField= new Ext.form.NumberField({
		id: 'jrawat_tunai_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_jual_rawat_tunaiGroup = new Ext.form.FieldSet({
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
				items: [jrawat_tunai_nilai_cfField] 
			}
		]
	
	});
	// END Tunai-1
	
	//START Field Tunai-2
	jrawat_tunai_nilai2_cfField= new Ext.form.TextField({
		id: 'jrawat_tunai_nilai2_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_tunai_nilai2Field.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_tunai_nilai2Field= new Ext.form.NumberField({
		id: 'jrawat_tunai_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_jual_rawat_tunai2Group = new Ext.form.FieldSet({
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
				items: [jrawat_tunai_nilai2_cfField] 
			}
		]
	
	});
	// END Tunai-2
	
	//START Field Tunai-3
	jrawat_tunai_nilai3_cfField= new Ext.form.TextField({
		id: 'jrawat_tunai_nilai3_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_tunai_nilai3Field.setValue(cf_tonumber);
				load_total_bayar();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_tunai_nilai3Field= new Ext.form.NumberField({
		id: 'jrawat_tunai_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	master_jual_rawat_tunai3Group = new Ext.form.FieldSet({
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
				items: [jrawat_tunai_nilai3_cfField] 
			}
		]
	
	});
	// END Tunai-3
	
	//START Field Kwitansi-1
	jrawat_kwitansi_namaField= new Ext.form.TextField({
		id: 'jrawat_kwitansi_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		disabled:true,
		anchor: '95%'
	});
	
	jrawat_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'jrawat_kwitansi_nilai_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_value = jrawat_kwitansi_nilai_cfField.getValue();
				var cf_tonumber = convertToNumber(cf_value);
				if(cf_tonumber>jrawat_kwitansi_sisaField.getValue()){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					cf_tonumber = jrawat_kwitansi_sisaField.getValue();
					jrawat_kwitansi_nilaiField.setValue(cf_tonumber);
					load_total_bayar();
					var number_tocf = CurrencyFormatted(cf_tonumber);
					this.setRawValue(number_tocf);
				}else{
					jrawat_kwitansi_nilaiField.setValue(cf_tonumber);
					load_total_bayar();
					var number_tocf = CurrencyFormatted(cf_value);
					this.setRawValue(number_tocf);
				}
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'jrawat_kwitansi_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/*Field ini dipakai untuk menyimpan ID dari tabel jual_kwitansi, dimana ID ini berperan untuk mengetahui apakah kwitansi tersebut akan di Insert atau di Update */
	jrawat_jual_kwitansi_idField1= new Ext.form.NumberField();
	jrawat_jual_kwitansi_idField2= new Ext.form.NumberField();
	jrawat_jual_kwitansi_idField3= new Ext.form.NumberField();
	
	jrawat_kwitansi_noField= new Ext.form.ComboBox({
		id: 'jrawat_kwitansi_noField',
		fieldLabel: 'No Kuitansi',
		store: cbo_kwitansi_jual_rawat_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_rawat_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		listeners:{
			render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Cust<br>- Nama Customer<br>- Alamat Customer<br>- No Kuitansi'});
			}
		}
	});
    jrawat_kwitansi_no_idField= new Ext.form.NumberField({
		maskRe: /([0-9]+)$/
	});
	jrawat_kwitansi_sisaField= new Ext.form.NumberField({
		id: 'jrawat_kwitansi_sisaField',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	jrawat_kwitansi_noField.on("select",function(){
			j=cbo_kwitansi_jual_rawat_DataStore.findExact('ckwitansi_id',jrawat_kwitansi_noField.getValue(),0);
			if(j>-1){
				jrawat_kwitansi_namaField.setValue(cbo_kwitansi_jual_rawat_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jrawat_kwitansi_sisaField.setValue(cbo_kwitansi_jual_rawat_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-1
	
	//START Field Kwitansi-2
	jrawat_kwitansi_nama2Field= new Ext.form.TextField({
		id: 'jrawat_kwitansi_nama2Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		disabled:true,
		anchor: '95%'
	});
	
	jrawat_kwitansi_nilai2_cfField= new Ext.form.TextField({
		id: 'jrawat_kwitansi_nilai2_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_value = jrawat_kwitansi_nilai2_cfField.getValue();
				var cf_tonumber = convertToNumber(cf_value);
				if(cf_tonumber>jrawat_kwitansi_sisa2Field.getValue()){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					cf_tonumber = jrawat_kwitansi_sisa2Field.getValue();
					jrawat_kwitansi_nilai2Field.setValue(cf_tonumber);
					load_total_bayar();
					var number_tocf = CurrencyFormatted(cf_tonumber);
					this.setRawValue(number_tocf);
				}else{
					jrawat_kwitansi_nilai2Field.setValue(cf_tonumber);
					load_total_bayar();
					var number_tocf = CurrencyFormatted(cf_value);
					this.setRawValue(number_tocf);
				}
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_kwitansi_nilai2Field= new Ext.form.NumberField({
		id: 'jrawat_kwitansi_nilai2Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	jrawat_kwitansi_no2Field= new Ext.form.ComboBox({
		id: 'jrawat_kwitansi_no2Field',
		fieldLabel: 'No Kuitansi',
		store: cbo_kwitansi_jual_rawat_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_rawat_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
    jrawat_kwitansi_no2_idField= new Ext.form.NumberField({
		maskRe: /([0-9]+)$/
	});
	jrawat_kwitansi_sisa2Field= new Ext.form.NumberField({
		id: 'jrawat_kwitansi_sisa2Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	jrawat_kwitansi_no2Field.on("select",function(){
			j=cbo_kwitansi_jual_rawat_DataStore.findExact('ckwitansi_id',jrawat_kwitansi_no2Field.getValue(),0);
			if(j>-1){
				jrawat_kwitansi_nama2Field.setValue(cbo_kwitansi_jual_rawat_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jrawat_kwitansi_sisa2Field.setValue(cbo_kwitansi_jual_rawat_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-2
	
	//START Field Kwitansi-3
	jrawat_kwitansi_nama3Field= new Ext.form.TextField({
		id: 'jrawat_kwitansi_nama3Field',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		disabled:true,
		anchor: '95%'
	});
	jrawat_kwitansi_nilai3_cfField= new Ext.form.TextField({
		id: 'jrawat_kwitansi_nilai3_cfField',
		fieldLabel: 'Diambil (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_value = jrawat_kwitansi_nilai3_cfField.getValue();
				var cf_tonumber = convertToNumber(cf_value);
				if(cf_tonumber>jrawat_kwitansi_sisa3Field.getValue()){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Maaf, Jumlah yang Anda ambil melebihi dari Sisa Kuitansi.',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					cf_tonumber = jrawat_kwitansi_sisa3Field.getValue();
					jrawat_kwitansi_nilai3Field.setValue(cf_tonumber);
					load_total_bayar();
					var number_tocf = CurrencyFormatted(cf_tonumber);
					this.setRawValue(number_tocf);
				}else{
					jrawat_kwitansi_nilai3Field.setValue(cf_tonumber);
					load_total_bayar();	
					var number_tocf = CurrencyFormatted(cf_value);
					this.setRawValue(number_tocf);
				}	
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	jrawat_kwitansi_nilai3Field= new Ext.form.NumberField({
		id: 'jrawat_kwitansi_nilai3Field',
		enableKeyEvents: true,
		fieldLabel: 'Diambil (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	jrawat_kwitansi_no3Field= new Ext.form.ComboBox({
		id: 'jrawat_kwitansi_no3Field',
		fieldLabel: 'No Kuitansi',
		store: cbo_kwitansi_jual_rawat_DataStore,
		mode: 'remote',
		displayField:'ckwitansi_no',
		valueField: 'ckwitansi_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: kwitansi_jual_rawat_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
    jrawat_kwitansi_no3_idField= new Ext.form.NumberField({
		maskRe: /([0-9]+)$/
	});
	jrawat_kwitansi_sisa3Field= new Ext.form.NumberField({
		id: 'jrawat_kwitansi_sisa3Field',
		fieldLabel: 'Sisa (Rp)',
		readOnly: true,
		anchor: '95%'
	});
	jrawat_kwitansi_no3Field.on("select",function(){
			j=cbo_kwitansi_jual_rawat_DataStore.findExact('ckwitansi_id',jrawat_kwitansi_no3Field.getValue(),0);
			if(j>-1){
				jrawat_kwitansi_nama3Field.setValue(cbo_kwitansi_jual_rawat_DataStore.getAt(j).data.ckwitansi_cust_nama);
				jrawat_kwitansi_sisa3Field.setValue(cbo_kwitansi_jual_rawat_DataStore.getAt(j).data.total_sisa);
			}
		});
	// END Kwitansi-3
	
	master_jual_rawat_kwitansiGroup = new Ext.form.FieldSet({
		title: 'Kuitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jrawat_kwitansi_noField,jrawat_kwitansi_namaField,jrawat_kwitansi_sisaField,jrawat_kwitansi_nilai_cfField] 
			}
		]
	});
	
	master_jual_rawat_kwitansi2Group = new Ext.form.FieldSet({
		title: 'Kuitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jrawat_kwitansi_no2Field,jrawat_kwitansi_nama2Field,jrawat_kwitansi_sisa2Field,jrawat_kwitansi_nilai2_cfField] 
			}
		]
	});
	
	master_jual_rawat_kwitansi3Group = new Ext.form.FieldSet({
		title: 'Kuitansi',
		collapsible: true,
		layout:'column',
		anchor: '95%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jrawat_kwitansi_no3Field,jrawat_kwitansi_nama3Field,jrawat_kwitansi_sisa3Field,jrawat_kwitansi_nilai3_cfField] 
			}
		]
	});
	
	jrawat_no_faktur_medisField= new Ext.form.TextField({
		id: 'jrawat_no_faktur_medisField',
		fieldLabel: 'No Faktur Medis',
		emptyText : '(Auto)',
		readOnly:true,
		width: 120,
	});
	
	/*Label*/
	jrawat_jumlahLabel= new Ext.form.DisplayField({
		fieldLabel : 'Jumlah',
		itemCls : 'rata_kanan'
	});
	jrawat_subTotalLabel= new Ext.form.DisplayField({
		fieldLabel : 'Sub Total (Rp)',
		itemCls : 'rata_kanan'
	});
	jrawat_voucherTotalLabel= new Ext.form.DisplayField({
		fieldLabel : 'Voucher (Rp)',
		itemCls : 'rata_kanan'
	});
	jrawat_TotalLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total (Rp)</span>',
		itemCls : 'rmoney2'
	});
	jrawat_TotalBayarLabel= new Ext.form.DisplayField({
		fieldLabel : '<span style="font-weight:bold"><font size=4>Total Bayar (Rp)</span>',
		itemCls : 'rmoney2'
	});
	jrawat_HutangLabel= new Ext.form.DisplayField({
		id: 'jrawat_HutangLabel',
		fieldLabel : '<font color=black size=2>Hutang (Rp)<font>',
		itemCls : 'rmoney_hutang'
	});
	/*End of Label*/
	
	//* Bayar
	jrawat_jumlahField= new Ext.form.NumberField({
		id: 'jrawat_jumlahField',
		fieldLabel: '<font color="grey"">Jumlah Item</font>',
		allowBlank: true,
		readOnly: true,
		allowDecimals: false,
		disabled:true,
		width: 40,
		maxLength: 50,
		maskRe: /([0-9]+)$/
	});
	jrawat_subTotal_cfField= new Ext.form.TextField({
		id: 'jrawat_subTotal_cfField',
		fieldLabel: 'Sub Total (Rp)',		
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	jrawat_subTotalField= new Ext.form.NumberField({
		id: 'jrawat_subTotalField',
		fieldLabel: '<font color="grey"">Sub Total (Rp)</font>',
		disabled:true,
		readOnly: true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120
	});
	jrawat_totalField= new Ext.form.NumberField({
		id: 'jrawat_totalField',
		fieldLabel: '<span style="font-weight:bold" color="grey">Total (Rp)</span>',		
		readOnly: true,
		disabled : true,
		enableKeyEvents: true,
		itemCls: 'rmoney_b',
		width: 120,
		allowBlank: true
	});
	jrawat_total_cfField= new Ext.form.TextField({
		id: 'jrawat_total_cfField',
		fieldLabel: 'Total (Rp)',
		disabled:true,
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,		
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	jrawat_bayarField= new Ext.form.NumberField({
		id: 'jrawat_bayarField',
		fieldLabel: 'Total Bayar (Rp)',
		allowBlank: true,
		anchor: '95%',
		itemCls: 'rmoney',
		enableKeyEvents: true,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	jrawat_bayar_cfField= new Ext.form.TextField({
		id: 'jrawat_bayar_cfField',
		fieldLabel: '<font style="font-weight:bold">Total Bayar (Rp)</font>',
		disabled:true,
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney_b',
		readOnly: true,
		width: 120,
		maskRe: /([0-9]+)$/ 
	});
	jrawat_hutangField= new Ext.form.NumberField({
		id: 'jrawat_hutangField',
		fieldLabel: '<font color="grey"">Hutang (Rp)</font>',
		valueRenderer: 'numberToCurrency',
		disabled:true,
		allowNegatife: true,
		readOnly: true,
		itemCls: 'rmoney',
		width: 120
	});
	jrawat_hutang_cfField= new Ext.form.TextField({
		id: 'jrawat_hutang_cfField',
		fieldLabel: 'Hutang (Rp)',		
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	jrawat_pesanLabel= new Ext.form.Label({
		style: {
			marginLeft: '100px',
			fontSize: '14px',
			color: '#CC0000'
		}
	});
	jrawat_lunasLabel= new Ext.form.Label({
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
		height: 230,
		width: 380,
		defaults:{bodyStyle:'padding:10px'},
		items:[{
                title:'Cara Bayar 1',
                layout:'form',
				frame: true,
                defaults: {width: 165},
                defaultType: 'textfield',
                items: [jrawat_caraField,master_jual_rawat_tunaiGroup,master_jual_rawat_cardGroup,master_jual_rawat_cekGroup,master_jual_rawat_kwitansiGroup,master_jual_rawat_transferGroup,master_jual_rawat_voucherGroup]
            },{
                title:'Cara Bayar 2',
                layout:'form',
				frame: true,
                defaults: {width: 165},
                defaultType: 'textfield',
                items: [jrawat_cara2Field, master_jual_rawat_tunai2Group, master_jual_rawat_kwitansi2Group ,master_jual_rawat_card2Group, master_jual_rawat_cek2Group, master_jual_rawat_transfer2Group, master_jual_rawat_voucher2Group]
            },{
                title:'Cara Bayar 3',
                layout:'form',
				frame: true,
                defaults: {width: 165},
                defaultType: 'textfield',
                items: [jrawat_cara3Field, master_jual_rawat_tunai3Group, master_jual_rawat_kwitansi3Group, master_jual_rawat_card3Group, master_jual_rawat_cek3Group, master_jual_rawat_transfer3Group, master_jual_rawat_voucher3Group]
            }]
	});
	
	//Untuk Total Voucher (Medis + Non Medis) --> tab Total
	jrawat_voucher_totalField= new Ext.form.NumberField({
		id: 'jrawat_voucher_totalField',
		fieldLabel: 'Voucher (Rp)',
		allowBlank: true,
		anchor: '95%',	
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	jrawat_voucher_total_cfField= new Ext.form.TextField({
		id: 'jrawat_voucher_total_cfField',
		fieldLabel: '<font color="grey"">Voucher (Rp)</font>',
		allowNegatife : false,
		readOnly : true,
		disabled :true,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		width: 120,
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				jrawat_cashback_cfField.setValue(cf_tonumber);
				jrawat_cashback_cf_medisField.setValue(cf_tonumber);
				load_total_biaya();
				load_total_bayar();				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/
	});
	//End Of Untuk Total Voucher (Medis + Non Medis) --> tab Total
	
	master_jual_rawat_allGroup = new Ext.form.FieldSet({
		title: 'Total',
		autoHeight: true,
		collapsible: false,
		layout:'column',
		anchor: '97%',
		items:[
			{
				layout: 'form',
				border:false,
				items: [ /*{xtype: 'spacer',height:50}, */jrawat_jumlahField,jrawat_subTotalField,jrawat_voucher_total_cfField, /*jrawat_ket_diskField, */{xtype: 'spacer',height:28},jrawat_totalField, jrawat_bayar_cfField,jrawat_hutangField,jrawat_pesanLabel,jrawat_lunasLabel] 
			}
			]
	});
		master_jual_rawat_bayarGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		frame: true,
		items:[
			   {
				columnWidth:0.33,
				layout: 'form',
				border:false,
				items: [master_cara_bayarTabPanel] 
			},
			{
				columnWidth:0.18,
				labelWidth: 65,
				layout: 'form',
    			labelPad: 0,
				baseCls: 'x-plain',
				border:true,
				items: [master_jual_rawat_nonmedisGroup/*jrawat_jumlah_medisField, jrawat_total_medisField,jrawat_diskon_medisField,jrawat_cashback_cf_medisField,jrawat_ket_disk_medisField*/] 
			},
			{
				columnWidth:0.18,
				labelWidth: 65,
				layout: 'form',
    			labelPad: 0,
				baseCls: 'x-plain',
				border:true,
				items: [master_jual_rawat_medisGroup/*jrawat_jumlah_nonmedisField, jrawat_total_nonmedisField,jrawat_diskon_nonmedisField, jrawat_cashback_cf_nonmedisField,jrawat_ket_disk_nonmedisField*/] 
			},
			{
				columnWidth:0.25,
				labelWidth: 120,
				layout: 'form',
    			labelPad: 0,
				baseCls: 'x-plain',
				border:true,
				items: [jrawat_jumlahLabel, jrawat_subTotalLabel,jrawat_voucherTotalLabel, jrawat_TotalLabel, jrawat_TotalBayarLabel, jrawat_HutangLabel,jrawat_pesanLabel,jrawat_lunasLabel/*jrawat_jumlahField, jrawat_subTotalField, jrawat_diskonField, jrawat_voucher_total_cfField, jrawat_ket_diskField, {xtype: 'spacer',height:10},jrawat_totalField, jrawat_bayar_cfField,jrawat_hutangField,jrawat_pesanLabel,jrawat_lunasLabel*/] 
			}
			]
	});
	
	/*Fieldset Master*/
	master_jual_rawat_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jrawat_nobuktiField, jrawat_custField,
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[jrawat_cust_nomemberLabel, jrawat_cust_nomemberField,jrawat_valid_memberLabel, jrawat_valid_memberField]
						}, {xtype: 'spacer',height:5},
						{
							columnWidth:0.5,
							layout: 'column',
							border:false,
							items:[jrawat_cust_ultahLabel, jrawat_cust_ultahField,jrawat_cust_priorityLabel]
						}

						//jrawat_cust_ultahField
						] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [jrawat_tanggalField, jrawat_keteranganField, jrawat_stat_dokField] 
			}
			]
	});
	
	// Function for json reader of detail
	var detail_jual_rawat_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intopeprodukan_ColumnModel, Mapping => for initiate table column */ 
            {name: 'drawat_id', type: 'int', mapping: 'drawat_id'}, 
            {name: 'drawat_master', type: 'int', mapping: 'drawat_master'}, 
            {name: 'drawat_rawat', type: 'int', mapping: 'drawat_rawat'}, 
            {name: 'drawat_jumlah', type: 'int', mapping: 'drawat_jumlah'}, 
            {name: 'drawat_harga', type: 'float', mapping: 'drawat_harga'}, 
            {name: 'drawat_diskon', type: 'int', mapping: 'drawat_diskon'},
            {name: 'drawat_sales', type: 'string', mapping: 'drawat_sales'},
            {name: 'drawat_diskon_jenis', type: 'string', mapping: 'drawat_diskon_jenis'},
			{name: 'nama_karyawan', type: 'string', mapping: 'karyawan_username'},
			{name: 'drawat_karyawan', type: 'int', mapping: 'drawat_karyawan'},
            {name: 'drawat_subtotal', type: 'float', mapping: 'drawat_subtotal'},
            {name: 'drawat_subtotal_net', type: 'int', mapping: 'drawat_subtotal_net'},
            {name: 'dtrawat_keterangan', type: 'string', mapping: 'dtrawat_keterangan'},
            {name: 'referal', type: 'string', mapping: 'referal'},
            {name: 'drawat_dtrawat', type: 'int', mapping: 'drawat_dtrawat'},
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_jual_rawat_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_jual_rawat_DataStore = new Ext.data.Store({
		id: 'detail_jual_rawat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=detail_detail_jual_rawat_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: pageS},
		reader: detail_jual_rawat_reader,
		sortInfo:{field: 'drawat_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_jual_rawat= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	/* Store utk referal Kasir*/ 
	cbo_referalKasirDataStore = new Ext.data.Store({
		id: 'cbo_referalKasirDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_referal_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'}
		]),
		sortInfo:{field: 'karyawan_username', direction: "ASC"}
	});
	var cbo_referal_kasir_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
			'<span>{karyawan_username}',
        '</div></tpl>'
    );
	
	memberDataStore = new Ext.data.Store({
		id: 'memberDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=get_member_by_cust', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
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
			url: 'index.php?c=c_master_jual_rawat&m=get_nik', 
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
	
	/* Combo box utk Referal Kasir*/
	var combo_referal_kasir= new Ext.form.ComboBox({
		store: cbo_referalKasirDataStore,
		mode: 'remote',
		tpl: cbo_referal_kasir_tpl,
		displayField: 'karyawan_username',
		valueField: 'karyawan_id',
		loadingText: 'Searching...',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		anchor: '95%'
	});
	var combo_jual_rawat=new Ext.form.ComboBox({
		store: cbo_drawat_rawatDataStore,
		mode: 'remote',
		displayField: 'drawat_rawat_display',
		valueField: 'drawat_rawat_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:pageS,
		hideTrigger:false,
		tpl: rawat_jual_rawat_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:false,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	drawat_idField=new Ext.form.NumberField();
	kategori_field=new Ext.form.TextField();
	dpp_Field=new Ext.form.NumberField();
	subtot_dpp_Field=new Ext.form.NumberField();
	
	combo_jual_rawat.on('select',function(){
		var editable_harga = 0;
		drawat_jumlahField.setValue(1);
		var j=cbo_drawat_rawatDataStore.findExact('drawat_rawat_value',combo_jual_rawat.getValue(),0);
		/*Di cek, apakah rawat_edit_harga dari produk ini 0 / 1, jika 1 maka bisa di edit2 harganya, jika 0, maka ga bisa di edit2 harganya */
		editable_harga = cbo_drawat_rawatDataStore.getAt(j).data.drawat_edit_harga;
		if(editable_harga == 1){
			drawat_hargaField.setDisabled(false);
			drawat_hargaField.setReadOnly(false);
		}
		else if(editable_harga == 0){
			drawat_hargaField.setDisabled(true);
			drawat_hargaField.setReadOnly(true);	
		}
		
		if(cbo_drawat_rawatDataStore.getCount()){
			//* Check no_member JIKA <>"" ==> jenis-diskon=DM /
			var drawat_diskon = 0;
			var dtotal_net_field = 0;
			if(jrawat_cust_nomemberField.getValue()!=="" && jrawat_valid_memberField.getValue().format('d-m-Y') >= today){
				drawat_jenis_diskonField.setValue('Member');
				drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dm;
				drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dm);
				drawat_diskonField.setDisabled(true);
			}else{
				drawat_jenis_diskonField.setValue('Umum');
				drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_du;
				drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_du);
				drawat_diskonField.setDisabled(true);
			}
			drawat_idField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_value);
			drawat_hargaField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_harga);
			drawat_subtotalField.setValue(1*cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_harga);
			kategori_field.setValue(cbo_drawat_rawatDataStore.getAt(j).data.kategori_nama);
			dtotal_net_field = ((100-drawat_diskon)/100) * (1*cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_harga);
			dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
			drawat_subtotal_netField.setValue(dtotal_net_field);
		}
		window.refresh();
	});
	
	var drawat_jumlahField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		blankText: '0',
		maxLength: 2,
		readOnly: false,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	drawat_jumlahField.on('keyup', function(){
		var sub_total = drawat_jumlahField.getValue() * drawat_hargaField.getValue();
		var sub_total_net = sub_total * ((100 - drawat_diskonField.getValue())/100);
		drawat_subtotalField.setValue(sub_total);
		sub_total_net = (sub_total_net>0?Math.round(sub_total_net):0);
		drawat_subtotal_netField.setValue(sub_total_net);
	});
	
	var drawat_hargaField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		disabled: true,
		blankText: '0',
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	var drawat_subtotalField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		blankText: '0',
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	var drawat_jenis_diskonField= new Ext.form.ComboBox({
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
	drawat_jenis_diskonField.on('select', function(){
		var djumlah_beli_rawat = drawat_jumlahField.getValue();
		var j=cbo_drawat_rawatDataStore.findExact('drawat_rawat_value',combo_jual_rawat.getValue(),0);
		var drawat_diskon = 0;
		var dtotal_net_field = 0;
		
		if(drawat_jenis_diskonField.getValue()=='Umum'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_du;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_du);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Member'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dm;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dm);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Ultah'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dultah;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dultah);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Card'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dcard;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dcard);
			//drawat_diskonField.setReadOnly(false);
			drawat_diskonField.setDisabled(false);
		}else if(drawat_jenis_diskonField.getValue()=='Kolega'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dkolega;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dkolega);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Keluarga'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dkeluarga;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dkeluarga);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Owner'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_downer;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_downer);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Grooming'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dgrooming;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dgrooming);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Wartawan'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dwartawan;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dwartawan);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Staff'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dstaffdokter;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dstaffdokter);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Staf Non Dokter'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dstaffnondokter;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dstaffnondokter);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}else if(drawat_jenis_diskonField.getValue()=='Promo'){
			drawat_diskon = cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dpromo;
			drawat_diskonField.setValue(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dpromo);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}
		else{
			drawat_diskonField.setValue(0);
			//drawat_diskonField.setReadOnly(true);
			drawat_diskonField.setDisabled(true);
		}
		dtotal_net_field = ((100-drawat_diskon)/100) * (djumlah_beli_rawat*cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_harga);
		dtotal_net_field = (dtotal_net_field>0?Math.round(dtotal_net_field):0);
		drawat_subtotal_netField.setValue(dtotal_net_field);
	});
	
	var drawat_subtotal_netField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		blankText: '0',
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	var drawat_diskonField= new Ext.form.NumberField({
		id : 'drawat_diskonField',
		name : 'drawat_diskonField',
		allowDecimals: false,
		allowNegative: false,
		disabled: true,
		blankText: '0',
		maxLength: 3,
		enableKeyEvents: true,
		readOnly : true,
		maskRe: /([0-9]+)$/
	});
	drawat_diskonField.on('keyup', function(){
		var sub_total_net = ((100-drawat_diskonField.getValue())/100)*drawat_subtotalField.getValue();
		sub_total_net = (sub_total_net>0?Math.round(sub_total_net):0);
		drawat_subtotal_netField.setValue(sub_total_net);
		if(this.getRawValue()>15 && drawat_jenis_diskonField.getValue()=='Card'){
			this.setRawValue(15);
		}
	});
	
	//declaration of detail coloumn model
	detail_jual_rawat_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'drawat_id',
            hidden: true
		},
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'drawat_rawat',
			width: 250,
			sortable: true,
			allowBlank: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: combo_jual_rawat,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_jual_rawat)
		},
		{
			header: '<div align="center">' + 'Jns' + '</div>',
			dataIndex: 'kategori_nama',
			editor: kategori_field,
			width: 40
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'drawat_jumlah',
			width: 40,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: drawat_jumlahField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000'),
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			dataIndex: 'drawat_harga',
			width: 70,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: drawat_hargaField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'DPP (Rp)' + '</div>',
			dataIndex: 'drawat_harga',
			width: 70,
			sortable: true,
			renderer: function(v, params, record){
				var record_dpp = record.data.drawat_harga/1.1;
				record_dpp = (record_dpp>0?Math.round(record_dpp):0);
				return Ext.util.Format.number(record_dpp,'0,000');
			}
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			dataIndex: 'drawat_subtotal',
			width: 80,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: drawat_subtotalField,
			<?php } ?>
			renderer: function(v, params, record){
				return Ext.util.Format.number(record.data.drawat_jumlah*record.data.drawat_harga,'0,000');
			}
		},
		{
			header: '<div align="center">' + 'Jns Diskon' + '</div>',
			dataIndex: 'drawat_diskon_jenis',
			width: 60,
			sortable: true
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			,
			editor: drawat_jenis_diskonField
			<?php } ?>
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Disk (%)' + '</div>',
			dataIndex: 'drawat_diskon',
			width: 50,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: drawat_diskonField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Sub Tot Net (Rp)' + '</div>',
			dataIndex: 'drawat_subtotal_net',
			width: 100,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: drawat_subtotal_netField,
			<?php } ?>
			renderer: function(v, params, record){
				var record_dtotal_net = record.data.drawat_jumlah*record.data.drawat_harga*((100-record.data.drawat_diskon)/100);
				record_dtotal_net = (record_dtotal_net>0?Math.round(record_dtotal_net):0);
				return Ext.util.Format.number(record_dtotal_net,'0,000');
			}
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Sub Tot Net DPP (Rp)' + '</div>',
			dataIndex: 'drawat_subtotal_net',
			width: 110,
			sortable: true,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			editor: subtot_dpp_Field,
			<?php } ?>
			renderer: function(v, params, record){
				var record_subtot_dpp = (record.data.drawat_jumlah*record.data.drawat_harga*((100-record.data.drawat_diskon)/100))/1.1;
				record_subtot_dpp = (record_subtot_dpp>0?Math.round(record_subtot_dpp):0);
				return Ext.util.Format.number(record_subtot_dpp,'0,000');
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dtrawat_keterangan',
			width: 100,
			sortable: false
		},
		{
			header: '<div align="center">' + 'Referal (Tindakan)' + '</div>',
			dataIndex: 'referal',
			width: 100,
			sortable: false
		},
		{
			header: '<div align="center">' + 'Referal (Kasir)' + '</div>',
			dataIndex: 'drawat_sales',
			width: 100,
			sortable: true,
			editor: combo_referal_kasir,
			renderer: Ext.util.Format.comboRenderer(combo_referal_kasir)
		}
		]
	);
	detail_jual_rawat_ColumnModel.defaultSortable= true;
	//eof
	
	function get_harga_rawat(id_produk){
		var harga_produk=0;
		Ext.Ajax.request({
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_jual_rawat&m=get_harga_rawat',
			params:{ produk_id	: id_produk },
			success: function(response){							
				var result=response.responseText;
				harga_produk=result;
			}
		});
		return harga_produk;
	}
	
	//declaration of detail list editor grid
	detail_jual_rawatListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_jual_rawatListEditorGrid',
		el: 'fp_detail_jual_rawat',
		title: 'Detail Penjualan Perawatan',
		height: 225,
		width: 1180,
		autoScroll: true,
		store: detail_jual_rawat_DataStore,
		colModel: detail_jual_rawat_ColumnModel,
		enableColLock:false,
		region: 'center',
		margins: '0 5 5 5',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
		plugins: [editor_detail_jual_rawat],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			store: detail_jual_rawat_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djrawat_add',
			handler: detail_jual_rawat_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djrawat_delete',
			disabled: true,
			handler: detail_jual_rawat_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	detail_jual_rawatListEditorGrid.on('rowclick', function(){
		var var_drawat_dtrawat = 0;
		var rowindex = detail_jual_rawatListEditorGrid.getStore().indexOf(detail_jual_rawatListEditorGrid.getSelectionModel().getSelected());
		if(detail_jual_rawat_DataStore.getAt(rowindex).data.drawat_dtrawat>0){
			combo_jual_rawat.setDisabled(true);
			drawat_jumlahField.setDisabled(true);
		}else{
			combo_jual_rawat.setDisabled(false);
			drawat_jumlahField.setDisabled(false);
		}
	});
	
	//function of detail add
	function detail_jual_rawat_add(){
		combo_jual_rawat.setDisabled(false);
		drawat_jumlahField.setDisabled(false);
		drawat_diskonField.setReadOnly(true);
		drawat_hargaField.setDisabled(true);
		master_jual_rawat_createForm.savePrintButton.disable();
		master_jual_rawat_createForm.savePrintButton2.disable();
		master_jual_rawat_createForm.PrintOnlyButton.disable();
		master_jual_rawat_createForm.PrintOnlyButton2.disable();
		
		//jika detail sudah ada 1, maka referal akan mengikuti row sebelumnya
		if(detail_jual_rawatListEditorGrid.selModel.getCount() == 1)
		{
		// temp ini berfungsi utk menyimpan ID dari referal yang terakhir kali diinput. Jika program di Refresh / Cancel, maka akan kembali ke kondisi semula
		var temp_rawat = combo_referal_kasir.getValue(1);
		var edit_detail_jual_rawat= new detail_jual_rawatListEditorGrid.store.recordType({
			drawat_id		:0,
			drawat_rawat	:'',
			drawat_jumlah	:1,
			drawat_harga	:0,
			drawat_subtotal	:0,
			drawat_diskon_jenis: '',
			drawat_diskon	:0,
			drawat_subtotal_net	:0,
			drawat_karyawan:'',
			drawat_sales : temp_rawat
		});
		editor_detail_jual_rawat.stopEditing();
		detail_jual_rawat_DataStore.insert(0, edit_detail_jual_rawat);
		detail_jual_rawatListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_jual_rawat.startEditing(0);
		}
		//jika data masih kosong, maka masuk ke state ini
		else{
		var edit_detail_jual_rawat= new detail_jual_rawatListEditorGrid.store.recordType({
			drawat_id		:0,
			drawat_rawat	:'',
			drawat_jumlah	:1,
			drawat_harga	:0,
			drawat_subtotal	:0,
			drawat_diskon_jenis: '',
			drawat_diskon	:0,
			drawat_subtotal_net	:0,
			drawat_karyawan:'',
			drawat_sales : ''
		});
		editor_detail_jual_rawat.stopEditing();
		detail_jual_rawat_DataStore.insert(0, edit_detail_jual_rawat);
		detail_jual_rawatListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_jual_rawat.startEditing(0);
		}
	}
	
	//function for refresh detail
	function refresh_detail_jual_rawat(){
		detail_jual_rawat_DataStore.commitChanges();
		detail_jual_rawatListEditorGrid.getView().refresh();
	}
	//eof
		
	/* Function for Delete Confirm of detail */
	function detail_jual_rawat_confirm_delete(){
		// only one record is selected here
		if(detail_jual_rawatListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', detail_jual_rawat_delete);
		}
		else {
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
	function detail_jual_rawat_delete(btn){
            if(btn=='yes'){
                if(detail_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('drawat_dtrawat')=='' && detail_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('drawat_id')!==''){
					var selections = detail_jual_rawatListEditorGrid.selModel.getSelections();
                    var prez = [];
					var drawat_master = [];
                    for(i = 0; i< detail_jual_rawatListEditorGrid.selModel.getCount(); i++){
						var record = selections[i];
                        prez.push(selections[i].json.drawat_id);
						drawat_master.push(selections[i].json.drawat_master);
                    }
                    var encoded_array = Ext.encode(prez);
					var encoded_array_drawat_master = Ext.encode(drawat_master);
					detail_jual_rawat_DataStore.remove(selections[0]);
                    Ext.Ajax.request({
                        waitMsg: 'Mohon tunggu...',
						timeout: 72000,
                        url: 'index.php?c=c_master_jual_rawat&m=get_action', 
                        params: {
							task: "DDELETE",
							ids:  encoded_array,
							drawat_master: encoded_array_drawat_master
						},
                        success: function(response){
                            var result=eval(response.responseText);
                            switch(result){
                                case 1:  // Success : simply reload
									load_total_bayar();
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
                    
                }else if(detail_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('drawat_id')==''){
                    var s = detail_jual_rawatListEditorGrid.getSelectionModel().getSelections();
                    for(var i = 0, r; r = s[i]; i++){
                        detail_jual_rawat_DataStore.remove(r);
                    }
                }else if(detail_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('drawat_dtrawat')!==''
						 && detail_jual_rawatListEditorGrid.getSelectionModel().getSelected().get('drawat_id')!==''){
					//sementara detail hasil inputan Tindakan bisa di-delete
					var selections = detail_jual_rawatListEditorGrid.selModel.getSelections();
                    var prez = [];
					var drawat_master = [];
                    for(i = 0; i< detail_jual_rawatListEditorGrid.selModel.getCount(); i++){
                        prez.push(selections[i].json.drawat_id);
						drawat_master.push(selections[i].json.drawat_master);
                    }
                    var encoded_array = Ext.encode(prez);
					var encoded_array_drawat_master = Ext.encode(drawat_master);
					detail_jual_rawat_DataStore.remove(selections[0]);
                    Ext.Ajax.request({
                        waitMsg: 'Mohon tunggu...',
						timeout: 72000,
                        url: 'index.php?c=c_master_jual_rawat&m=get_action', 
                        params: {
							task: "DDELETE",
							ids:  encoded_array,
							drawat_master: encoded_array_drawat_master
						},
                        success: function(response){
                            var result=eval(response.responseText);
							switch(result){
                                case 1:  // Success : simply reload
									load_total_bayar();
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
				}else{
                    Ext.MessageBox.show({
                        title: 'Warning',
                        //msg: 'Silakan menghubungi bagian Tindakan', //ini untuk inputan dari Tindakan
						msg: 'Tidak diketahui kesalahannya', //sementara
                        buttons: Ext.MessageBox.OK,
                        animEl: 'save',
                        icon: Ext.MessageBox.WARNING
                    });
                }
            } 
            detail_jual_rawat_DataStore.commitChanges();
	}
	//eof
	
	function update_group_carabayar_jual_rawat(){
		var value=jrawat_caraField.getValue();
		master_jual_rawat_tunaiGroup.setVisible(false);
		master_jual_rawat_cardGroup.setVisible(false);
		master_jual_rawat_cekGroup.setVisible(false);
		master_jual_rawat_transferGroup.setVisible(false);
		master_jual_rawat_kwitansiGroup.setVisible(false);
		master_jual_rawat_voucherGroup.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jrawat_tunai_nilaiField.reset();
		jrawat_tunai_nilai_cfField.reset();
		jrawat_card_nilaiField.reset();
		jrawat_card_nilai_cfField.reset();
		jrawat_cek_nilaiField.reset();
		jrawat_cek_nilai_cfField.reset();
		jrawat_transfer_nilaiField.reset();
		jrawat_transfer_nilai_cfField.reset();
		jrawat_kwitansi_nilaiField.reset();
		jrawat_kwitansi_nilai_cfField.reset();
		jrawat_voucher_cashbackField.reset();
		
		if(value=='card'){
			master_jual_rawat_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_rawat_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			master_jual_rawat_transferGroup.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_rawat_kwitansiGroup.setVisible(true);
		}else if(value=='voucher'){
			master_jual_rawat_voucherGroup.setVisible(true);
		}else if(value=='tunai'){
			master_jual_rawat_tunaiGroup.setVisible(true);
		}
	}
	
	function update_group_carabayar2_jual_rawat(){
		var value=jrawat_cara2Field.getValue();
		master_jual_rawat_tunai2Group.setVisible(false);
		master_jual_rawat_card2Group.setVisible(false);
		master_jual_rawat_cek2Group.setVisible(false);
		master_jual_rawat_transfer2Group.setVisible(false);
		master_jual_rawat_kwitansi2Group.setVisible(false);
		master_jual_rawat_voucher2Group.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jrawat_tunai_nilai2Field.reset();
		jrawat_tunai_nilai2_cfField.reset();
		jrawat_card_nilai2Field.reset();
		jrawat_card_nilai2_cfField.reset();
		jrawat_cek_nilai2Field.reset();
		jrawat_cek_nilai2_cfField.reset();
		jrawat_transfer_nilai2Field.reset();
		jrawat_transfer_nilai2_cfField.reset();
		jrawat_kwitansi_nilai2Field.reset();
		jrawat_kwitansi_nilai2_cfField.reset();
		jrawat_voucher_cashback2Field.reset();
		jrawat_voucher_cashback2_cfField.reset();
		
		if(value=='card'){
			master_jual_rawat_card2Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_rawat_cek2Group.setVisible(true);
		}else if(value=='transfer'){
			master_jual_rawat_transfer2Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_rawat_kwitansi2Group.setVisible(true);
		}else if(value=='voucher'){
			master_jual_rawat_voucher2Group.setVisible(true);
		}else if(value=='tunai'){
			master_jual_rawat_tunai2Group.setVisible(true);
		}
	}
	
	function update_group_carabayar3_jual_rawat(){
		var value=jrawat_cara3Field.getValue();
		master_jual_rawat_tunai3Group.setVisible(false);
		master_jual_rawat_card3Group.setVisible(false);
		master_jual_rawat_cek3Group.setVisible(false);
		master_jual_rawat_transfer3Group.setVisible(false);
		master_jual_rawat_kwitansi3Group.setVisible(false);
		master_jual_rawat_voucher3Group.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		jrawat_tunai_nilai3Field.reset();
		jrawat_tunai_nilai3_cfField.reset();
		jrawat_card_nilai3Field.reset();
		jrawat_card_nilai3_cfField.reset();
		jrawat_cek_nilai3Field.reset();
		jrawat_cek_nilai3_cfField.reset();
		jrawat_transfer_nilai3Field.reset();
		jrawat_transfer_nilai3_cfField.reset();
		jrawat_kwitansi_nilai3Field.reset();
		jrawat_kwitansi_nilai3_cfField.reset();
		jrawat_voucher_cashback3Field.reset();
		jrawat_voucher_cashback3_cfField.reset();
		
		if(value=='card'){
			master_jual_rawat_card3Group.setVisible(true);
		}else if(value=='cek/giro'){
			master_jual_rawat_cek3Group.setVisible(true);
		}else if(value=='transfer'){
			master_jual_rawat_transfer3Group.setVisible(true);
		}else if(value=='kwitansi'){
			master_jual_rawat_kwitansi3Group.setVisible(true);
		}else if(value=='voucher'){
			master_jual_rawat_voucher3Group.setVisible(true);
		}else if(value=='tunai'){
			master_jual_rawat_tunai3Group.setVisible(true);
		}
	}
	
	function load_total_rawat_bayar(){
		var jumlah_item=0;
		var subtotal_harga=0;
		var total_harga=0;
		var total_hutang=0;
		var total_bayar=0;
		var total_harga2=0;
		var total_bayar2=0;
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
		
		var detail_jual_rawat_record;
		for(i=0;i<detail_jual_rawat_DataStore.getCount();i++){
			detail_jual_rawat_record=detail_jual_rawat_DataStore.getAt(i);
			var j=cbo_drawat_rawatDataStore.findExact('drawat_rawat_value',detail_jual_rawat_record.data.drawat_rawat,0);
			if(j>=0){
				detail_jual_rawat_record.data.drawat_harga=cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_harga;
				if(detail_jual_rawat_record.data.drawat_diskon==""){
					if(jrawat_cust_nomemberField.getValue()!=""){
						if(cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dm!==0){
							detail_jual_rawat_record.data.drawat_diskon=cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_dm;
							detail_jual_rawat_record.data.drawat_diskon_jenis='Member';
						}
					}else{
							detail_jual_rawat_record.data.drawat_diskon=cbo_drawat_rawatDataStore.getAt(j).data.drawat_rawat_du;
							detail_jual_rawat_record.data.drawat_diskon_jenis='Umum';
					}
				}
			}
			jumlah_item=jumlah_item+eval(detail_jual_rawat_record.data.drawat_jumlah);
			subtotal_harga=subtotal_harga+eval(detail_jual_rawat_record.data.drawat_jumlah*detail_jual_rawat_record.data.drawat_harga*(100-detail_jual_rawat_record.data.drawat_diskon)/100);
		}
		jrawat_jumlahField.setValue(jumlah_item);
		jrawat_jumlahLabel.setValue(jumlah_item);
		jrawat_subTotalField.setValue(subtotal_harga);
		jrawat_subTotal_cfField.setValue(CurrencyFormatted(subtotal_harga));
		jrawat_subTotalLabel.setValue(CurrencyFormatted(subtotal_harga));
		total_harga=subtotal_harga - jrawat_cashback_medis_num.getValue() - jrawat_cashback_num.getValue();
		total_harga=(total_harga>0?Math.round(total_harga):0);
		jrawat_totalField.setValue(total_harga);		
		jrawat_total_cfField.setValue(CurrencyFormatted(total_harga));
		jrawat_TotalLabel.setValue(CurrencyFormatted(total_harga));
		
		transfer_nilai=jrawat_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=jrawat_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;
		
		transfer_nilai2=jrawat_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=jrawat_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		
		transfer_nilai3=jrawat_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=jrawat_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		
		kwitansi_nilai=jrawat_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=jrawat_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		
		kwitansi_nilai2=jrawat_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=jrawat_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		
		kwitansi_nilai3=jrawat_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=jrawat_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		
		card_nilai=jrawat_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=jrawat_card_nilaiField.getValue();
		else
			card_nilai=0;
		
		card_nilai2=jrawat_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=jrawat_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		
		card_nilai3=jrawat_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=jrawat_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		
		cek_nilai=jrawat_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=jrawat_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		
		cek_nilai2=jrawat_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=jrawat_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		
		cek_nilai3=jrawat_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=jrawat_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		
		voucher_nilai=jrawat_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=jrawat_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		
		voucher_nilai2=jrawat_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=jrawat_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		
		voucher_nilai3=jrawat_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=jrawat_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;

		tunai_nilai=jrawat_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=jrawat_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;

		tunai_nilai2=jrawat_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=jrawat_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;

		tunai_nilai3=jrawat_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=jrawat_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;

		total_bayar=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		total_bayar=(total_bayar>0?Math.round(total_bayar):0);
		jrawat_bayarField.setValue(total_bayar);
		jrawat_bayar_cfField.setValue(CurrencyFormatted(total_bayar));
		jrawat_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar));

		total_hutang=total_harga-total_bayar;
		total_hutang=(total_hutang>0?Math.round(total_hutang):0);
		jrawat_hutangField.setValue(total_hutang);
		jrawat_hutang_cfField.setValue(CurrencyFormatted(total_hutang));
		jrawat_HutangLabel.setValue(CurrencyFormatted(total_hutang));
		
		if(total_bayar>total_harga){
			jrawat_pesanLabel.setText("Kelebihan Jumlah Bayar");
		}else if(total_bayar<total_harga || total_bayar==total_harga){
			jrawat_pesanLabel.setText("");
		}
		if(total_bayar==total_harga){
			jrawat_lunasLabel.setText("LUNAS");
		}else if(total_bayar!==total_harga){
			jrawat_lunasLabel.setText("");
		}
	}
	
	function load_dstore_jrawat(){
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
		drawat_hargaField.setDisabled(true);
		drawat_hargaField.setReadOnly(true);
		var voucher_rp_field = jrawat_cashback_num.getValue();
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		var voucher_rp_medis_field = jrawat_cashback_medis_num.getValue();
		if(voucher_rp_medis_field==''){
			voucher_rp_medis_field = 0;
		}
		
		var total_bayar_field = jrawat_bayarField.getValue();
		var jumlah_item = 0;
		var sub_total_field = 0;
		var total_biaya_field = 0;
		var total_hutang_field = 0;		
		var total_medis = 0;
		var total_nonmedis = 0;
		var subtotal_dpp_field= 0;
		var total_voucher_field = 0;
		var total_voucher_medis=0;
		var total_voucher_nonmedis=0;
		var voucher_dpp=0;
		var subtotal_medis_field=0;
		var subtotal_nonmedis_field=0;
		var ppn = 0;
		
		for(i=0;i<detail_jual_rawat_DataStore.getCount();i++){
			jumlah_item+=detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah;
			sub_total_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah * detail_jual_rawat_DataStore.getAt(i).data.drawat_harga * ((100 - detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon)/100);
			if (detail_jual_rawat_DataStore.getAt(i).data.kategori_nama == 'Medis'){
				total_medis+= detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah * detail_jual_rawat_DataStore.getAt(i).data.drawat_harga * ((100 - detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon)/100) - jrawat_cashback_medis_num.getValue();
				subtotal_medis_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net; //hitung subtotal medis
			}else if (detail_jual_rawat_DataStore.getAt(i).data.kategori_nama == 'Non Medis'){
				total_nonmedis+= detail_jual_rawat_DataStore.getAt(i).data.drawat_jumlah * detail_jual_rawat_DataStore.getAt(i).data.drawat_harga * ((100 - detail_jual_rawat_DataStore.getAt(i).data.drawat_diskon)/100);
				subtotal_dpp_field+=(detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net)/1.1;
				voucher_dpp+=((jrawat_cashback_num.getValue())/1.1);
				subtotal_nonmedis_field+=detail_jual_rawat_DataStore.getAt(i).data.drawat_subtotal_net - subtotal_dpp_field; //hitung subtotal nonmedis
			}
		}
		jrawat_jumlahLabel.setValue(jumlah_item);
		
		ppn = subtotal_dpp_field*0.1; //hitung ppn
		ppn = (ppn>0?Math.round(ppn):0);
		jrawat_ppn_Field.setValue(ppn);
		jrawat_ppn_cfField.setValue(CurrencyFormatted(ppn));
		
		jrawat_subTotalField.setValue(sub_total_field);
		jrawat_subTotal_cfField.setValue(CurrencyFormatted(sub_total_field));
		jrawat_subTotalLabel.setValue(CurrencyFormatted(sub_total_field));
		jrawat_subTotal_medisField.setValue(subtotal_medis_field); //subtotal medis
		jrawat_subTotal_medis_cfField.setValue(CurrencyFormatted(subtotal_medis_field));
		subtotal_nonmedis_field = subtotal_dpp_field - voucher_dpp;
		subtotal_nonmedis_field = (subtotal_nonmedis_field>0?Math.round(subtotal_nonmedis_field):0);
		jrawat_subTotal_nonmedisField.setValue(subtotal_nonmedis_field);
		jrawat_dpp_Field.setValue(subtotal_dpp_field);
		jrawat_dpp_cfField.setValue(CurrencyFormatted(subtotal_dpp_field));
		jrawat_cashback_num.setValue(voucher_dpp);	
		
		total_voucher_medis = jrawat_cashback_medis_num.getValue();
		total_voucher_nonmedis = jrawat_cashback_num.getValue();
		total_voucher_field = total_voucher_medis + total_voucher_nonmedis; //hitung total voucher
		jrawat_voucher_total_cfField.setValue(total_voucher_field);
		jrawat_voucherTotalLabel.setValue(total_voucher_field);
				
		total_biaya_field = sub_total_field - voucher_rp_medis_field - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		jrawat_totalField.setValue(total_biaya_field);
		jrawat_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		jrawat_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		
		total_hutang_field = total_biaya_field - total_bayar_field;
		jrawat_hutangField.setValue(total_hutang_field);
		jrawat_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jrawat_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
		
		total_medis=total_medis-total_voucher_medis;
		jrawat_total_medisField.setValue(total_medis);
		jrawat_total_medis_cfField.setValue(CurrencyFormatted(total_medis));
		
		jrawat_total_nonmedisField.setValue(total_nonmedis);
		jrawat_total_nonmedis_cfField.setValue(CurrencyFormatted(total_nonmedis));
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
		var sub_total_biaya_field = jrawat_subTotalField.getValue();
		var voucher_rp_field = jrawat_cashback_num.getValue();
		var voucher_rp_medis_field = jrawat_cashback_medis_num.getValue();
		var total_bayar_field = jrawat_bayarField.getValue();
		var total_text_voucher_field = 0; 
		
		if(voucher_rp_field==''){
			voucher_rp_field = 0;
		}
		if(voucher_rp_medis_field==''){
			voucher_rp_medis_field = 0;
		}
		
		var total_biaya_field = 0;
		var total_hutang_field = 0;
		
		total_text_voucher_field=voucher_rp_field + voucher_rp_medis_field;
		total_text_voucher_field=(total_text_voucher_field>0?Math.round(total_text_voucher_field):0);
		jrawat_voucher_totalField.setValue(total_text_voucher_field);
		jrawat_voucher_total_cfField.setValue(CurrencyFormatted(total_text_voucher_field));
		jrawat_voucherTotalLabel.setValue(CurrencyFormatted(total_text_voucher_field));
		total_biaya_field += sub_total_biaya_field - voucher_rp_medis_field - voucher_rp_field;
		total_biaya_field = (total_biaya_field>0?Math.round(total_biaya_field):0);
		jrawat_totalField.setValue(total_biaya_field);
		jrawat_total_cfField.setValue(CurrencyFormatted(total_biaya_field));
		jrawat_TotalLabel.setValue(CurrencyFormatted(total_biaya_field));
		
		total_hutang_field = total_biaya_field - total_bayar_field;
		jrawat_hutangField.setValue(total_hutang_field);
		jrawat_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jrawat_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
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
		var total_biaya_field = jrawat_totalField.getValue();
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
		
		voucher_rp_field=jrawat_cashback_num.getValue();
		if(/^\d+$/.test(voucher_rp_field))
			voucher_rp_field=jrawat_cashback_num.getValue();
		else
			voucher_rp_field=0;
			
		voucher_rp_medis_field=jrawat_cashback_medis_num.getValue();
		if(/^\d+$/.test(voucher_rp_medis_field))
			voucher_rp_medis_field=jrawat_cashback_medis_num.getValue();
		else
			voucher_rp_medis_field=0;
		transfer_nilai=jrawat_transfer_nilaiField.getValue();
		if(/^\d+$/.test(transfer_nilai))
			transfer_nilai=jrawat_transfer_nilaiField.getValue();
		else
			transfer_nilai=0;
		
		transfer_nilai2=jrawat_transfer_nilai2Field.getValue();
		if(/^\d+$/.test(transfer_nilai2))
			transfer_nilai2=jrawat_transfer_nilai2Field.getValue();
		else
			transfer_nilai2=0;
		
		transfer_nilai3=jrawat_transfer_nilai3Field.getValue();
		if(/^\d+$/.test(transfer_nilai3))
			transfer_nilai3=jrawat_transfer_nilai3Field.getValue();
		else
			transfer_nilai3=0;
		
		kwitansi_nilai=jrawat_kwitansi_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_nilai))
			kwitansi_nilai=jrawat_kwitansi_nilaiField.getValue();
		else
			kwitansi_nilai=0;
		
		kwitansi_nilai2=jrawat_kwitansi_nilai2Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai2))
			kwitansi_nilai2=jrawat_kwitansi_nilai2Field.getValue();
		else
			kwitansi_nilai2=0;
		
		kwitansi_nilai3=jrawat_kwitansi_nilai3Field.getValue();
		if(/^\d+$/.test(kwitansi_nilai3))
			kwitansi_nilai3=jrawat_kwitansi_nilai3Field.getValue();
		else
			kwitansi_nilai3=0;
		
		card_nilai=jrawat_card_nilaiField.getValue();
		if(/^\d+$/.test(card_nilai))
			card_nilai=jrawat_card_nilaiField.getValue();
		else
			card_nilai=0;
		
		card_nilai2=jrawat_card_nilai2Field.getValue();
		if(/^\d+$/.test(card_nilai2))
			card_nilai2=jrawat_card_nilai2Field.getValue();
		else
			card_nilai2=0;
		
		card_nilai3=jrawat_card_nilai3Field.getValue();
		if(/^\d+$/.test(card_nilai3))
			card_nilai3=jrawat_card_nilai3Field.getValue();
		else
			card_nilai3=0;
		
		cek_nilai=jrawat_cek_nilaiField.getValue();
		if(/^\d+$/.test(cek_nilai))
			cek_nilai=jrawat_cek_nilaiField.getValue();
		else
			cek_nilai=0;
		
		cek_nilai2=jrawat_cek_nilai2Field.getValue();
		if(/^\d+$/.test(cek_nilai2))
			cek_nilai2=jrawat_cek_nilai2Field.getValue();
		else
			cek_nilai2=0;
		
		cek_nilai3=jrawat_cek_nilai3Field.getValue();
		if(/^\d+$/.test(cek_nilai3))
			cek_nilai3=jrawat_cek_nilai3Field.getValue();
		else
			cek_nilai3=0;
		
		voucher_nilai=jrawat_voucher_cashbackField.getValue();
		if(/^\d+$/.test(voucher_nilai))
			voucher_nilai=jrawat_voucher_cashbackField.getValue();
		else
			voucher_nilai=0;
		
		voucher_nilai2=jrawat_voucher_cashback2Field.getValue();
		if(/^\d+$/.test(voucher_nilai2))
			voucher_nilai2=jrawat_voucher_cashback2Field.getValue();
		else
			voucher_nilai2=0;
		
		voucher_nilai3=jrawat_voucher_cashback3Field.getValue();
		if(/^\d+$/.test(voucher_nilai3))
			voucher_nilai3=jrawat_voucher_cashback3Field.getValue();
		else
			voucher_nilai3=0;
			
		tunai_nilai=jrawat_tunai_nilaiField.getValue();
		if(/^\d+$/.test(tunai_nilai))
			tunai_nilai=jrawat_tunai_nilaiField.getValue();
		else
			tunai_nilai=0;
			
		tunai_nilai2=jrawat_tunai_nilai2Field.getValue();
		if(/^\d+$/.test(tunai_nilai2))
			tunai_nilai2=jrawat_tunai_nilai2Field.getValue();
		else
			tunai_nilai2=0;
			
		tunai_nilai3=jrawat_tunai_nilai3Field.getValue();
		if(/^\d+$/.test(tunai_nilai3))
			tunai_nilai3=jrawat_tunai_nilai3Field.getValue();
		else
			tunai_nilai3=0;
			
		total_bayar_field=transfer_nilai+transfer_nilai2+transfer_nilai3+kwitansi_nilai+kwitansi_nilai2+kwitansi_nilai3+card_nilai+card_nilai2+card_nilai3+cek_nilai+cek_nilai2+cek_nilai3+voucher_nilai+voucher_nilai2+voucher_nilai3+tunai_nilai+tunai_nilai2+tunai_nilai3;
		total_bayar_field=(total_bayar_field>0?Math.round(total_bayar_field):0);
		jrawat_bayarField.setValue(total_bayar_field);
		jrawat_bayar_cfField.setValue(CurrencyFormatted(total_bayar_field));
		jrawat_TotalBayarLabel.setValue(CurrencyFormatted(total_bayar_field));
		
		total_hutang_field=total_biaya_field-total_bayar_field;
		total_hutang_field=(total_hutang_field>0?Math.round(total_hutang_field):0);
		jrawat_hutangField.setValue(total_hutang_field);
		jrawat_hutang_cfField.setValue(CurrencyFormatted(total_hutang_field));
		jrawat_HutangLabel.setValue(CurrencyFormatted(total_hutang_field));
		
		if(total_bayar_field>total_biaya_field){
			jrawat_pesanLabel.setText("Kelebihan Jumlah Bayar");
		}else if(total_bayar_field<total_biaya_field || total_bayar_field==total_biaya_field){
			jrawat_pesanLabel.setText("");
		}
		if(total_bayar_field==total_biaya_field){
			jrawat_lunasLabel.setText("LUNAS");
		}else if(total_bayar_field!==total_biaya_field){
			jrawat_lunasLabel.setText("");
		}
	}
	
	//event on update of detail data store
    detail_jual_rawat_DataStore.on("update",load_dstore_jrawat);	
	//jrawat_caraField.on("select",update_group_carabayar_jual_rawat);
	//jrawat_cara2Field.on("select",update_group_carabayar2_jual_rawat);
	//jrawat_cara3Field.on("select",update_group_carabayar3_jual_rawat);
	/*Sistem baru, dimana setiap kali user mengganti cara bayar, maka akan meng-reset ulang total perhitungan, hal ini dilakukan agar tidak terjadi bug(cara bayar sudah diisi nominal,lalu diganti ke cara bayar lain, lalu sudah mengurangi total biaya dan mengisi total bayar, sehingga ketika di save / print maka total bayar / total biaya sudah terakumulasi, namun cara bayarnya masih 0 (ditabel jual2 masih 0). Coba nyalakan comment diatas utk membuktikan bug tersebut */
	jrawat_caraField.on("select",function(){
		update_group_carabayar_jual_rawat();
		load_total_biaya();
		load_total_bayar();
		//load_dstore_jrawat();
	});
	jrawat_cara2Field.on("select",function(){
		update_group_carabayar2_jual_rawat();
		load_total_biaya();
		load_total_bayar();
		//load_dstore_jrawat();
	});
	jrawat_cara3Field.on("select",function(){
		update_group_carabayar3_jual_rawat();
		load_total_biaya();
		load_total_bayar();
		//load_dstore_jrawat();
	});
	
	jrawat_karyawanField.on("select",function(){
		var karyawan_id=jrawat_karyawanField.getValue();		
		if(karyawan_id!==0){
			karyawanDataStore.load({
					params : { karyawan_id: karyawan_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(karyawanDataStore.getCount()){
								jrawat_karyawan_record=karyawanDataStore.getAt(0).data;
								jrawat_nikkaryawanField.setValue(jrawat_karyawan_record.karyawan_no);
							}else{
								jrawat_cust_nomemberField.setValue("");
							}
						}
					}
			}); }
	});
	
	jrawat_custField.on("select",function(){
		var cust_id=jrawat_custField.getValue();
		if(cust_id!==0){
			memberDataStore.load({
					params : { member_cust: cust_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(memberDataStore.getCount()){
								jrawat_member_record=memberDataStore.getAt(0).data;
								jrawat_cust_nomemberField.setValue(jrawat_member_record.member_no);
								jrawat_valid_memberField.setValue(jrawat_member_record.member_valid);
								jrawat_cust_ultahField.setValue(jrawat_member_record.cust_tgllahir);
								jrawat_cust_priorityField.setValue(jrawat_member_record.cust_priority_star);
								if (cust_id== '9'){
									jrawat_karyawanField.setDisabled(false);
									jrawat_cust_priorityLabel.setText("");
								}
								else if (cust_id !== '9' && jrawat_cust_priorityField.getValue()=='*') {
									jrawat_cust_priorityLabel.setText("*");
									jrawat_karyawanField.setDisabled(true);
								}
								else {
									jrawat_karyawanField.setDisabled(true);
									jrawat_karyawanField.setValue(null);
									jrawat_nikkaryawanField.setValue(null);
									jrawat_cust_priorityLabel.setText("");
								}
							}else{
								jrawat_cust_nomemberField.setValue("");
								jrawat_valid_memberField.setValue("");
								jrawat_cust_ultahField.setValue("");
								jrawat_cust_priorityLabel.setText("");
							}
						}
					}
			}); 
		}
		
		cbo_cust=cbo_cust_jual_rawat_DataStore.findExact('cust_id',jrawat_custField.getValue(),0);
		if(cbo_cust>-1){
			jrawat_cek_namaField.setValue(cbo_cust_jual_rawat_DataStore.getAt(cbo_cust).data.cust_nama);
			jrawat_cek_nama2Field.setValue(cbo_cust_jual_rawat_DataStore.getAt(cbo_cust).data.cust_nama);
			jrawat_cek_nama3Field.setValue(cbo_cust_jual_rawat_DataStore.getAt(cbo_cust).data.cust_nama);
			jrawat_transfer_namaField.setValue(cbo_cust_jual_rawat_DataStore.getAt(cbo_cust).data.cust_nama);
			jrawat_transfer_nama2Field.setValue(cbo_cust_jual_rawat_DataStore.getAt(cbo_cust).data.cust_nama);
			jrawat_transfer_nama3Field.setValue(cbo_cust_jual_rawat_DataStore.getAt(cbo_cust).data.cust_nama);
		}
	});
	
	function show_windowGrid(){
		master_jual_rawat_DataStore.load({
			params: {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if(success){
					master_jual_rawat_createWindow.show();
				}
			}
		});	// load DataStore
	}
	
	/* START Detail Pengambilan Paket */
	var detail_ambil_paket_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intopeprodukan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'dapaket_id', type: 'int', mapping: 'dapaket_id'}, 
            {name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'}, 
			{name: 'paket_nama', type: 'string', mapping: 'paket_nama'}, 
			{name: 'rawat_nama', type: 'string', mapping: 'rawat_nama'}, 
			{name: 'dapaket_jumlah', type: 'int', mapping: 'dapaket_jumlah'}, 
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_display', type: 'string', mapping: 'cust_display'},
			{name: 'harga_satuan', type: 'float', mapping: 'harga_satuan'},
			{name: 'dpp', type: 'float', mapping: 'dpp'},
			{name: 'total_harga_satuan', type: 'float', mapping: 'total_harga_satuan'},
			{name: 'sub_tot_dpp', type: 'float', mapping: 'sub_tot_dpp'},
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'},
			{name: 'dapaket_nobukti_medis', type: 'string', mapping: 'dapaket_nobukti_medis'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_ambil_paket_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_ambil_paketDataStore = new Ext.data.Store({
		id: 'detail_ambil_paketDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_jual_rawat&m=detail_ambil_paket_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: pageS},
		reader: detail_ambil_paket_reader,
		sortInfo:{field: 'jpaket_nobukti', direction: "ASC"}
	});
	/* End of Function */
	
	paket_dpp_Field=new Ext.form.NumberField();
	paket_subtotalField=new Ext.form.NumberField();
	paket_kategori_field=new Ext.form.TextField();
	
	detail_ambil_paketColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'jpaket_nobukti',
			width: 100,	//250,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Nama Paket' + '</div>',
			dataIndex: 'paket_nama',
			width: 250,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Pemilik Paket' + '</div>',
			dataIndex: 'cust_display',
			width: 200,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'rawat_nama',
			width: 250,	//100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Jns' + '</div>',
			dataIndex: 'kategori_nama',
			editor: paket_kategori_field,
			width: 60			
		},
		{
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'dapaket_jumlah',
			width: 50,	//100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Pemakai' + '</div>',
			dataIndex: 'cust_nama',
			width: 200, //150,
			sortable: true,
			reaOnly: true
		},
		{
			header: '<div align="center">' + 'Hrg Sat (Rp)' + '</div>',
			dataIndex: 'harga_satuan',
			width:90, //150,
			sortable: true,
			reaOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'DPP (Rp)' + '</div>',
			dataIndex: 'harga_satuan',
			width: 90,
			sortable: true,
			renderer: function(v, params, record){
				var record_dpp = record.data.harga_satuan/1.1;
				record_dpp = (record_dpp>0?Math.round(record_dpp):0);
				return Ext.util.Format.number(record_dpp,'0,000');
			}
		}
		,{
			align: 'Right',
			header: '<div align="center">' + 'Sub Tot (Rp)' + '</div>',
			dataIndex: 'total_harga_satuan',
			width: 120,
			sortable: true,
			readOnly : true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},{
			align: 'Right',
			header: '<div align="center">' + 'Sub Tot DPP (Rp)' + '</div>',
			dataIndex: 'sub_tot_dpp',
			width: 120,
			sortable: true,
			readOnly : true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		}]
	);
	detail_ambil_paketColumnModel.defaultSortable= true;
	
	//declaration of detail list editor grid
	detail_ambil_paketListGrid =  new Ext.grid.GridPanel({
		id: 'detail_ambil_paketListGrid',
		el: 'fp_detail_ambil_paket',
		title: 'Informasi Pengambilan Paket',
		height: 150,	//250,
		width: 1180, //940,	//938,
		autoScroll: true,
		store: detail_ambil_paketDataStore, // DataStore
		colModel: detail_ambil_paketColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: detail_ambil_paketDataStore,
			displayInfo: true
		})
	});
	/* END Detail Pengambilan Paket */
	
	/* Function for retrieve create Window Panel*/ 
	master_jual_rawat_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 950,
		items: [master_jual_rawat_masterGroup,jrawat_groomingGroup, detail_jual_rawatListEditorGrid,detail_ambil_paketListGrid,master_jual_rawat_bayarGroup],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JUALRAWAT'))){ ?>
			{
				text: 'Print Only2',
				ref: '../PrintOnlyButton2',
				handler: print_only2
			},{
				text: 'Print Only',
				ref: '../PrintOnlyButton',
				handler: print_only
			},
			{
				xtype:'spacer',
				width: 670
			},
			{
				text: 'Save and Print 2',
				ref: '../savePrintButton2',
				handler: save_andPrint2
			},
			{
				text: 'Save and Print',
				disabled : true,
				ref: '../savePrintButton',
				handler: save_andPrint
			},
			{
				text: 'Save',
				ref: '../save_btn',
				handler: save_button
			},
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_jual_rawat_DataStore.reload();
					master_jual_rawat_reset_form();
					master_cara_bayarTabPanel.setActiveTab(0);
					master_jual_rawat_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/

	/* Function for retrieve create Window Form */
	master_jual_rawat_createWindow= new Ext.Window({
		id: 'master_jual_rawat_createWindow',
		title: jrawat_post2db+'Penjualan Perawatan',
		closable:true,
		closeAction: 'hide',
		width:1220, //965,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_jual_rawat_create',
		items: master_jual_rawat_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function master_jual_rawat_list_search(){
		var jrawat_nobukti_search=null;
		var jrawat_cust_search=null;
		var jrawat_diskon_search=null;
		var jrawat_cara_search=null;
		var jrawat_keterangan_search=null;
		var jrawat_stat_dok_search=null;
		var jrawat_tgl_start_search="";
		var jrawat_tgl_end_search="";

		if(jrawat_nobuktiSearchField.getValue()!==null){jrawat_nobukti_search=jrawat_nobuktiSearchField.getValue();}
		if(jrawat_custSearchField.getValue()!==null){jrawat_cust_search=jrawat_custSearchField.getValue();}
		if(jrawat_diskonSearchField.getValue()!==null){jrawat_diskon_search=jrawat_diskonSearchField.getValue();}
		if(jrawat_caraSearchField.getValue()!==null){jrawat_cara_search=jrawat_caraSearchField.getValue();}
		if(jrawat_keteranganSearchField.getValue()!==null){jrawat_keterangan_search=jrawat_keteranganSearchField.getValue();}
		if(jrawat_stat_dokSearchField.getValue()!==null){jrawat_stat_dok_search=jrawat_stat_dokSearchField.getValue();}
		if(Ext.getCmp('jrawat_tanggalStartAppSearchField').getValue()!==""){jrawat_tgl_start_search=Ext.getCmp('jrawat_tanggalStartAppSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('jrawat_tanggalEndAppSearchField').getValue()!==""){jrawat_tgl_end_search=Ext.getCmp('jrawat_tanggalEndAppSearchField').getValue().format('Y-m-d');}
		// change the store parameters
		master_jual_rawat_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			jrawat_nobukti	:	jrawat_nobukti_search, 
			jrawat_cust	:	jrawat_cust_search, 
			jrawat_diskon	:	jrawat_diskon_search, 
			jrawat_cara	:	jrawat_cara_search, 
			jrawat_keterangan	:	jrawat_keterangan_search,
			jrawat_stat_dok		:	jrawat_stat_dok_search,
			jrawat_tgl_start	: 	jrawat_tgl_start_search,
			jrawat_tgl_end	: 	jrawat_tgl_end_search
		};
		// Cause the datastore to do another query : 
		master_jual_rawat_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function master_jual_rawat_reset_search(){
		master_jual_rawat_DataStore.baseParams = { task: 'LIST' };
		master_jual_rawat_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_jual_rawat_searchWindow.close();
	};
	/* End of Fuction */

	function master_jual_rawat_reset_SearchForm(){
		jrawat_nobuktiSearchField.reset();
		jrawat_nobuktiSearchField.setValue(null);
		jrawat_custSearchField.reset();
		jrawat_custSearchField.setValue(null);
		jrawat_diskonSearchField.reset();
		jrawat_diskonSearchField.setValue(null);
		jrawat_caraSearchField.reset();
		jrawat_caraSearchField.setValue(null);
		jrawat_keteranganSearchField.reset();
		jrawat_keteranganSearchField.setValue(null);
		jrawat_stat_dokSearchField.reset();
		jrawat_stat_dokSearchField.setValue(null);
		Ext.getCmp('jrawat_tanggalStartAppSearchField').reset();
		Ext.getCmp('jrawat_tanggalEndAppSearchField').reset();
		Ext.getCmp('jrawat_tanggalEndAppSearchField').setValue(today);
	}
	
	/* Field for search */
	/* Identify  jrawat_id Search Field */
	jrawat_idSearchField= new Ext.form.NumberField({
		id: 'jrawat_idSearchField',
		fieldLabel: 'Jrawat Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  jrawat_nobukti Search Field */
	jrawat_nobuktiSearchField= new Ext.form.TextField({
		id: 'jrawat_nobuktiSearchField',
		fieldLabel: 'No Faktur',
		maxLength: 30,
		anchor: '95%'
	});
	/* Identify  jrawat_cust Search Field */
	jrawat_custSearchField= new Ext.form.ComboBox({
		id: 'jrawat_custSearchField',
		fieldLabel: 'Customer',
		store: cbo_cust_jual_rawat_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_jual_rawat_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  jpaket_tanggal Search Field */
	jrawat_tanggalStartAppSearchField= new Ext.form.DateField({
		id: 'jrawat_tanggalStartAppSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE
	});
	jrawat_tanggalEndAppSearchField= new Ext.form.DateField({
		id: 'jrawat_tanggalEndAppSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		minValue: MIN_CREATE_DATE	
	});
	
	/* Identify  jrawat_diskon Search Field */
	jrawat_diskonSearchField= new Ext.form.NumberField({
		id: 'jrawat_diskonSearchField',
		fieldLabel: 'Diskon',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width:96,
		maskRe: /([0-9]+)$/
	});
	/* Identify  jrawat_cara Search Field */
	jrawat_caraSearchField= new Ext.form.ComboBox({
		id: 'jrawat_caraSearchField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jrawat_cara'],
			data:[['tunai','Tunai'],['kwitansi','Kwitansi'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer'],['voucher','Voucher']]
		}),
		mode: 'local',
		displayField: 'jrawat_cara',
		valueField: 'value',
		width:96,
		triggerAction: 'all'	 
	});
	/* Identify  jrawat_keterangan Search Field */
	jrawat_keteranganSearchField= new Ext.form.TextArea({
		id: 'jrawat_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
	jrawat_stat_dokSearchField= new Ext.form.ComboBox({
		id: 'jrawat_stat_dokSearchField',
		fieldLabel: 'Status Dokumen',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jrawat_stat_dok'],
			data:[['Terbuka','Terbuka'], ['Tertutup','Tertutup'], ['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'jrawat_stat_dok',
		valueField: 'value',
		width: 96,
		triggerAction: 'all'	 	
	});
	
	/* Function for retrieve search Form Panel */
	master_jual_rawat_searchForm = new Ext.FormPanel({
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
				items: [jrawat_nobuktiSearchField, jrawat_custSearchField, 
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
									jrawat_tanggalStartAppSearchField
								]
							},
							{
								columnWidth:0.30,
								layout: 'form',
								border:false,
								labelWidth:30,
								defaultType: 'datefield',
								items: [						
									jrawat_tanggalEndAppSearchField
								]
							}							
							]
						},
						jrawat_caraSearchField, jrawat_keteranganSearchField, jrawat_stat_dokSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_jual_rawat_list_search
			},{
				text: 'Close',
				handler: function(){
					master_jual_rawat_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_jual_rawat_searchWindow = new Ext.Window({
		title: 'Pencarian Penjualan Perawatan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_jual_rawat_search',
		items: master_jual_rawat_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_jual_rawat_searchWindow.isVisible()){
			master_jual_rawat_reset_SearchForm();
			master_jual_rawat_searchWindow.show();
		} else {
			master_jual_rawat_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function master_jual_rawat_print(){
		var searchquery = "";
		var jrawat_nobukti_print=null;
		var jrawat_cust_print=null;
		var jrawat_diskon_print=null;
		var jrawat_cara_print=null;
		var jrawat_keterangan_print=null;
		var jrawat_stat_dok_print=null;
		var jrawat_tgl_start_print="";
		var jrawat_tgl_end_print="";
		var win;              
		// check if we do have some search data...
		if(master_jual_rawat_DataStore.baseParams.query!==null){searchquery = master_jual_rawat_DataStore.baseParams.query;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_nobukti!==null){jrawat_nobukti_print = master_jual_rawat_DataStore.baseParams.jrawat_nobukti;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_cust!==null){jrawat_cust_print = master_jual_rawat_DataStore.baseParams.jrawat_cust;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_diskon!==null){jrawat_diskon_print = master_jual_rawat_DataStore.baseParams.jrawat_diskon;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_cara!==null){jrawat_cara_print = master_jual_rawat_DataStore.baseParams.jrawat_cara;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_keterangan!==null){jrawat_keterangan_print = master_jual_rawat_DataStore.baseParams.jrawat_keterangan;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_stat_dok!==null){jrawat_stat_dok_print = master_jual_rawat_DataStore.baseParams.jrawat_stat_dok;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_tgl_start!==""){jrawat_tgl_start_print = master_jual_rawat_DataStore.baseParams.jrawat_tgl_start;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_tgl_end!==""){jrawat_tgl_end_print = master_jual_rawat_DataStore.baseParams.jrawat_tgl_end;}
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		timeout: 72000,
		url: 'index.php?c=c_master_jual_rawat&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			jrawat_nobukti	:	jrawat_nobukti_print,
			jrawat_cust	:	jrawat_cust_print,
			jrawat_diskon	:	jrawat_diskon_print,
			jrawat_cara	:	jrawat_cara_print,
			jrawat_keterangan	:	jrawat_keterangan_print,
			jrawat_stat_dok		:	jrawat_stat_dok_print,
			jrawat_tgl_start	: 	jrawat_tgl_start_print,
			jrawat_tgl_end	: 	jrawat_tgl_end_print,
		  	currentlisting: master_jual_rawat_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/master_jual_rawatlist.html','master_jual_rawatlist','height=400,width=1100,resizable=1,scrollbars=1, menubar=1');
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
	function master_jual_rawat_export_excel(){
		var searchquery = "";
		var jrawat_nobukti_2excel=null;
		var jrawat_cust_2excel=null;
		var jrawat_diskon_2excel=null;
		var jrawat_cara_2excel=null;
		var jrawat_keterangan_2excel=null;
		var jrawat_stat_dok_2excel=null;
		var jrawat_tgl_start_2excel="";
		var jrawat_tgl_end_2excel="";
		var win;              
		// check if we do have some 2excel data...
		if(master_jual_rawat_DataStore.baseParams.query!==null){searchquery = master_jual_rawat_DataStore.baseParams.query;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_nobukti!==null){jrawat_nobukti_2excel = master_jual_rawat_DataStore.baseParams.jrawat_nobukti;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_cust!==null){jrawat_cust_2excel = master_jual_rawat_DataStore.baseParams.jrawat_cust;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_diskon!==null){jrawat_diskon_2excel = master_jual_rawat_DataStore.baseParams.jrawat_diskon;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_cara!==null){jrawat_cara_2excel = master_jual_rawat_DataStore.baseParams.jrawat_cara;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_keterangan!==null){jrawat_keterangan_2excel = master_jual_rawat_DataStore.baseParams.jrawat_keterangan;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_stat_dok!==null){jrawat_stat_dok_2excel = master_jual_rawat_DataStore.baseParams.jrawat_stat_dok;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_tgl_start!==""){jrawat_tgl_start_2excel = master_jual_rawat_DataStore.baseParams.jrawat_tgl_start;}
		if(master_jual_rawat_DataStore.baseParams.jrawat_tgl_end!==""){jrawat_tgl_end_2excel = master_jual_rawat_DataStore.baseParams.jrawat_tgl_end;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		timeout: 72000,
		url: 'index.php?c=c_master_jual_rawat&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			jrawat_nobukti	:	jrawat_nobukti_2excel, 
			jrawat_cust	:	jrawat_cust_2excel, 
			jrawat_diskon	:	jrawat_diskon_2excel, 
			jrawat_cara	:	jrawat_cara_2excel, 
			jrawat_keterangan	:	jrawat_keterangan_2excel,
			jrawat_stat_dok		:	jrawat_stat_dok_2excel,
			jrawat_tgl_start	: 	jrawat_tgl_start_2excel,
			jrawat_tgl_end	: 	jrawat_tgl_end_2excel,
		  	currentlisting: master_jual_rawat_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	function jrawat_btn_cancel(){
		master_jual_rawat_reset_form();
		detail_jual_rawat_DataStore.load({params: {master_id:-1}});
		jrawat_caraField.setValue("card");
		master_jual_rawat_cardGroup.setVisible(true);
		master_cara_bayarTabPanel.setActiveTab(0);
		jrawat_post2db="CREATE";
		jrawat_cashback_num.setValue(0);
		jrawat_cashback_medis_num.setValue(0);
		jrawat_pesanLabel.setText('');
		jrawat_lunasLabel.setText('');
		jrawat_cust_priorityLabel.setText("");
	}
	
	Ext.Ajax.request({
			url: 'index.php?c=c_master_jual_rawat&m=get_info_pajak',
			timeout: 60000,
			success: function(response){
				var result=eval(response.responseText);
			switch(result){
			case 1 :
				// kondisi pajak aktif
				temp_pajakField.setValue('1');
				master_jual_rawat_createForm.savePrintButton.hide();
				master_jual_rawat_createForm.savePrintButton2.show();
				master_jual_rawat_createForm.PrintOnlyButton.hide();
				master_jual_rawat_createForm.PrintOnlyButton2.show();
				detail_jual_rawat_ColumnModel.setHidden(2, false);
				detail_jual_rawat_ColumnModel.setHidden(5, false);
				detail_jual_rawat_ColumnModel.setHidden(10, false);
				detail_ambil_paketColumnModel.setHidden(4, false);
				detail_ambil_paketColumnModel.setHidden(7, false);
				detail_ambil_paketColumnModel.setHidden(8, false);
				detail_ambil_paketColumnModel.setHidden(9, false);
				detail_ambil_paketColumnModel.setHidden(10, false);
				master_jual_rawat_ColumnModel.setHidden(2, false);
				master_jual_rawat_ColumnModel.setHidden(3, false);
				break;
			default :
				// kondisi non pajak
				temp_pajakField.setValue('0');
				master_jual_rawat_createForm.savePrintButton.show();
				master_jual_rawat_createForm.savePrintButton2.hide();
				master_jual_rawat_createForm.PrintOnlyButton2.hide();
				master_jual_rawat_createForm.PrintOnlyButton.show();
				detail_jual_rawat_ColumnModel.setHidden(2, true);
				detail_jual_rawat_ColumnModel.setHidden(5, true);
				detail_jual_rawat_ColumnModel.setHidden(10, true);
				detail_ambil_paketColumnModel.setHidden(4, true);
				detail_ambil_paketColumnModel.setHidden(7, true);
				detail_ambil_paketColumnModel.setHidden(8, true);
				detail_ambil_paketColumnModel.setHidden(9, true);
				detail_ambil_paketColumnModel.setHidden(10, true);
				master_jual_rawat_ColumnModel.setHidden(2, true);
				master_jual_rawat_ColumnModel.setHidden(3, false);
			};
			}
		});
	master_jual_rawatListEditorGrid.render();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_jual_rawat"></div>
         <div id="fp_detail_jual_rawat"></div>
		 <div id="fp_detail_ambil_paket"></div>
		<div id="elwindow_master_jual_rawat_create"></div>
        <div id="elwindow_master_jual_rawat_search"></div>
    </div>
</div>
</body>