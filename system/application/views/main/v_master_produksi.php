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

Ext.namespace('Ext.ux.plugin');

Ext.ux.plugin.triggerfieldTooltip = function(config){
    Ext.apply(this, config);
};

Ext.extend(Ext.ux.plugin.triggerfieldTooltip, Ext.util.Observable,{
    init: function(component){
        this.component = component;
        this.component.on('render', this.onRender, this);
    },
    
    //private
    onRender: function(){
        if(this.component.tooltip){
            if(typeof this.component.tooltip == 'object'){
                Ext.QuickTips.register(Ext.apply({
                      target: this.component.trigger
                }, this.component.tooltip));
            } else {
                this.component.trigger.dom[this.component.tooltipType] = this.component.tooltip;
            }
        }
    }
}); 

Ext.apply(Ext.form.VTypes, {
    daterange : function(val, field) {
        var date = field.parseDate(val);

        if(!date){
            return;
        }
        if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
            var start = Ext.getCmp(field.startDateField);
            start.setMaxValue(date);
            start.validate();
            this.dateRangeMax = date;
        } 
        else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
            var end = Ext.getCmp(field.endDateField);
            end.setMinValue(date);
            end.validate();
            this.dateRangeMin = date;
        }
        return true;
    }
});

/* declare function */		
var produksi_DataStore;
var produksi_ColumnModel;
var produksi_ListEditorGrid;
var produksi_createForm;
var produksi_createWindow;
var produksi_searchForm;
var produksi_searchWindow;
var produksi_SelectedRow;
var produksi_ContextMenu;
//for detail data

//declare konstant
var produksi_post2db = '';
var msg = '';
var produksi_pageS=15;
var dt = new Date();

/* declare variable here for Field*/
var produksi_idField;
var produksi_noField;
var produksi_tanggalField;
var produksi_keteranganField;
var produksi_gudang_asalField;
var produksi_gudang_tujuanField;
var produksi_status_dokumenField;

var produksi_idSearchField;
var produksi_noSearchField;
var produksi_keteranganSearchField;
var produksi_statusSearchField;

var produksi_cetak = 0;

var produksi_gudang_tujuanDataStore;
var produksi_gudang_asalDataStore;
var detail_produksi_jadi_DataStore;

function cetak_produksi_print_paper(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_produksi&m=print_paper',
		//params: { kwitansi_id : produksi_idField.getValue()	},
		params: { kwitansi_id : cetak_id },
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Cetak Kwitansi','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function cetak_produksi_print_only(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_produksi&m=print_only',
		params: { kwitansi_id : cetak_id },
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Cetak Kwitansi','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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
	
	// define a custom summary function
    Ext.ux.grid.GroupSummary.Calculations['totalCost'] = function(v, record, field){
        return v + (record.data.estimate * record.data.rate);
    };

	// utilize custom extension for Group Summary
    var summary = new Ext.ux.grid.GroupSummary();

	Ext.util.Format.comboRenderer = function(combo){
  		//jproduk_bankDataStore.load();
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
	
	/*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var produksi_tanggal_create_date = "";
	
		if(produksi_tanggalField.getValue()!== ""){produksi_tanggal_create_date = produksi_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_produksi&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: produksi_tanggal_create_date
		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							produksi_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Persiapan Produksi tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
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

	function produksi_terbilang(bilangan) {
		bilangan    = String(bilangan);
		var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
		var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
		var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
		
		var panjang_bilangan = bilangan.length;
		
		/* pengujian panjang bilangan */
		if (panjang_bilangan > 15) {
			kaLimat = "Diluar Batas";
			return kaLimat;
		}
		
		/* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
		for (i = 1; i <= panjang_bilangan; i++) {
			angka[i] = bilangan.substr(-(i),1);
		}
		
		i = 1;
		j = 0;
		kaLimat = "";
		
		/* mulai proses iterasi terhadap array angka */
		while (i <= panjang_bilangan) {
			subkaLimat = "";
			kata1 = "";
			kata2 = "";
			kata3 = "";
			
			/* untuk Ratusan */
			if (angka[i+2] != "0") {
				if (angka[i+2] == "1") {
					kata1 = "Seratus";
				} else {
					kata1 = kata[angka[i+2]] + " Ratus";
				}
			}
			
			/* untuk Puluhan atau Belasan */
			if (angka[i+1] != "0") {
				if (angka[i+1] == "1") {
					if (angka[i] == "0") {
						kata2 = "Sepuluh";
					} else if (angka[i] == "1") {
						kata2 = "Sebelas";
					} else {
						kata2 = kata[angka[i]] + " Belas";
					}
				} else {
					kata2 = kata[angka[i+1]] + " Puluh";
				}
			}
			
			/* untuk Satuan */
			if (angka[i] != "0") {
				if (angka[i+1] != "1") {
					kata3 = kata[angka[i]];
				}
			}
			
			/* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
			if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
				subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
			}
			
			/* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
			kaLimat = subkaLimat + kaLimat;
			i = i + 3;
			j = j + 1;
		
		}
		
		/* mengganti Satu Ribu jadi Seribu jika diperlukan */
		if ((angka[5] == "0") && (angka[6] == "0")) {
			kaLimat = kaLimat.replace("Satu Ribu","Seribu");
		}
		
		return kaLimat + "Rupiah";
	}
  

	function save_and_close(){
		produksi_cetak=0;
		pengecekan_dokumen();
	}

	function save_and_print(){
		produksi_cetak=1;
		pengecekan_dokumen();
	}

  	/* Function for Saving inLine Editing */
	function produksi_update(oGrid_event){
		var kwitansi_id_update_pk="";
		var kwitansi_no_update=null;
		var kwitansi_cust_update=null;
		var kwitansi_tanggal_update="";
		var kwitansi_ref_update=null;
		var kwitansi_nilai_update=null;
		var kwitansi_keterangan_update=null;
		var kwitansi_status_update=null;

		kwitansi_id_update_pk = oGrid_event.record.data.kwitansi_id;
		if(oGrid_event.record.data.kwitansi_no!== null){kwitansi_no_update = oGrid_event.record.data.kwitansi_no;}
		if(oGrid_event.record.data.kwitansi_cust!== null){kwitansi_cust_update = oGrid_event.record.data.kwitansi_cust;}
		if(oGrid_event.record.data.kwitansi_tanggal!== ""){kwitansi_tanggal_update =oGrid_event.record.data.kwitansi_tanggal.format('Y-m-d');}
		if(oGrid_event.record.data.kwitansi_ref!== null){kwitansi_ref_update = oGrid_event.record.data.kwitansi_ref;}
		if(oGrid_event.record.data.kwitansi_nilai!== null){kwitansi_nilai_update = oGrid_event.record.data.kwitansi_nilai;}
		if(oGrid_event.record.data.kwitansi_keterangan!== null){kwitansi_keterangan_update = oGrid_event.record.data.kwitansi_keterangan;}
		if(oGrid_event.record.data.produksi_status!== null){kwitansi_status_update = oGrid_event.record.data.produksi_status;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_produksi&m=get_action',
			params: {
				task: "UPDATE",
				kwitansi_id	: kwitansi_id_update_pk, 
				kwitansi_no	:kwitansi_no_update,  
				kwitansi_cust	:kwitansi_cust_update,
				kwitansi_tanggal:kwitansi_tanggal_update,
				kwitansi_ref	:kwitansi_ref_update,  
				kwitansi_nilai	:kwitansi_nilai_update,  
				kwitansi_keterangan	:kwitansi_keterangan_update,  
				produksi_status	:kwitansi_status_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						produksi_DataStore.commitChanges();
						produksi_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data LCL tidak bisa disimpan',
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
	function produksi_create(){
		if(produksi_post2db=='CREATE' || produksi_post2db=='UPDATE'){
			//if(kwitansi_status_lunasField.getValue()=='LUNAS'){
				var produksi_id_create_pk=null; 
				var produksi_no_create=null; 
				var produksi_gudang_asal_create=null; 
				var produksi_gudang_tujuan_create=null; 
				var produksi_tanggal_create=null;
				var produksi_keterangan_create=null; 
				var produksi_status_dokumen_create=null; 
				var produksi_cetak_create;
		
				produksi_id_create_pk=get_pk_id();
				if(produksi_idField.getValue()!== null){produksi_id_create_pk = produksi_idField.getValue();}else{produksi_id_create_pk=get_pk_id();} 
				if(produksi_noField.getValue()!== null){produksi_no_create = produksi_noField.getValue();} 
				if(produksi_gudang_asalField.getValue()!== null){produksi_gudang_asal_create = produksi_gudang_asalField.getValue();} 
				if(produksi_gudang_tujuanField.getValue()!== null){produksi_gudang_tujuan_create = produksi_gudang_tujuanField.getValue();} 
				if(produksi_tanggalField.getValue()!== ""){produksi_tanggal_create = produksi_tanggalField.getValue().format('Y-m-d');}
				if(produksi_keteranganField.getValue()!== null){produksi_keterangan_create = produksi_keteranganField.getValue();} 
				if(produksi_status_dokumenField.getValue()!== null){produksi_status_dokumen_create = produksi_status_dokumenField.getValue();} 
				
				produksi_cetak_create = this.produksi_cetak;
				task_value = produksi_post2db;
				
				// Penambahan Detail Bahan Produksi
                    var dbahan_id = [];
					//dbahan_master = nanti pakek insert_row_id dari Model
                    var dbahan_produk = [];
                    var dbahan_satuan = [];
                    var dbahan_jumlah = [];
                    var dbahan_keterangan = [];
                    var dcount_dbahan = dbahan_jadi_DataStore.getCount() - 1;
                    
                    if(dbahan_jadi_DataStore.getCount()>0){
                        for(i=0; i<dbahan_jadi_DataStore.getCount();i++){
                           	dbahan_id.push(dbahan_jadi_DataStore.getAt(i).data.dbahan_id);
                           	dbahan_produk.push(dbahan_jadi_DataStore.getAt(i).data.dbahan_produk);
                           	dbahan_satuan.push(dbahan_jadi_DataStore.getAt(i).data.dbahan_satuan);
                           	dbahan_jumlah.push(dbahan_jadi_DataStore.getAt(i).data.dbahan_jumlah);
                           	dbahan_keterangan.push(dbahan_jadi_DataStore.getAt(i).data.dbahan_keterangan);
                        }
                    }
                    
                    var encoded_array_dbahan_id = Ext.encode(dbahan_id);
                    var encoded_array_dbahan_produk = Ext.encode(dbahan_produk);		
                    var encoded_array_ddbahan_satuan = Ext.encode(dbahan_satuan);		
                    var encoded_array_dbahan_jumlah = Ext.encode(dbahan_jumlah);		
                    var encoded_array_dbahan_keterangan = Ext.encode(dbahan_keterangan);	

				// Penambahan Detail Detail Produksi Jadi
                    var djadi_id = [];
					//djadi_master = nanti pakek insert_row_id dari Model
                    var djadi_produk = [];
                    var djadi_satuan = [];
                    var djadi_jumlah = [];
                    var djadi_keterangan = [];
                    var dcount_djadi = detail_produksi_jadi_DataStore.getCount() - 1;
                    
                    if(detail_produksi_jadi_DataStore.getCount()>0){
                        for(i=0; i<detail_produksi_jadi_DataStore.getCount();i++){
                           	djadi_id.push(detail_produksi_jadi_DataStore.getAt(i).data.djadi_id);
                           	djadi_produk.push(detail_produksi_jadi_DataStore.getAt(i).data.djadi_produk);
                           	djadi_satuan.push(detail_produksi_jadi_DataStore.getAt(i).data.djadi_satuan);
                           	djadi_jumlah.push(detail_produksi_jadi_DataStore.getAt(i).data.djadi_jumlah);
                           	djadi_keterangan.push(detail_produksi_jadi_DataStore.getAt(i).data.djadi_keterangan);
                        }
                    }
                    
                    var encoded_array_djadi_id = Ext.encode(djadi_id);
                    var encoded_array_djadi_produk = Ext.encode(djadi_produk);		
                    var encoded_array_djadi_satuan = Ext.encode(djadi_satuan);		
                    var encoded_array_djadi_jumlah = Ext.encode(djadi_jumlah);		
                    var encoded_array_djadi_keterangan = Ext.encode(djadi_keterangan);	
				
				Ext.Ajax.request({  
					waitMsg: 'Mohon tunggu...',
					url: 'index.php?c=c_master_produksi&m=get_action',
					params: {
						task						: task_value,
						cetak						: produksi_cetak_create,
						produksi_id					: produksi_id_create_pk, 
						produksi_no					: produksi_no_create, 
						produksi_gudang_asal		: produksi_gudang_asal_create, 
						produksi_gudang_tujuan		: produksi_gudang_tujuan_create, 
						produksi_tanggal			: produksi_tanggal_create,
						produksi_keterangan			: produksi_keterangan_create, 
						produksi_status				: produksi_status_dokumen_create,
		
						// Bagian Detail Bahan Produksi :
						dbahan_id						: encoded_array_dbahan_id, 
						dbahan_master					: eval(get_pk_id()),
						dbahan_produk					: encoded_array_dbahan_produk, 
						dbahan_satuan					: encoded_array_ddbahan_satuan, 
						dbahan_jumlah					: encoded_array_dbahan_jumlah, 
						dbahan_keterangan				: encoded_array_dbahan_keterangan,
						
						// Bagian Detail Produksi Jadi :
						djadi_id					: encoded_array_djadi_id, 
						djadi_master				: eval(get_pk_id()),
						djadi_produk				: encoded_array_djadi_produk, 
						djadi_satuan				: encoded_array_djadi_satuan, 
						djadi_jumlah				: encoded_array_djadi_jumlah, 
						djadi_keterangan			: encoded_array_djadi_keterangan
	
					}, 

					success: function(response){             
						var result=eval(response.responseText);
						switch(result){
							case 0:
								Ext.MessageBox.alert(produksi_post2db+' OK','Data Persiapan Produksi berhasil disimpan');
								produksi_DataStore.reload();
								produksi_createWindow.hide();
								break;
							case 1:
								Ext.MessageBox.alert(produksi_post2db+' OK','Data Persiapan Produksi berhasil disimpan');
								produksi_DataStore.reload();
								produksi_createWindow.hide();
								break;
							default:
								produksi_idField.setValue(result);
								if(result>0){
									cetak_produksi_print_paper(result);
								}
								produksi_DataStore.reload();
								produksi_createWindow.hide();
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

		else {
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
 	
	function save_and_print(){
		produksi_cetak = 1;
		pengecekan_dokumen();
	}
  
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function print_only(){
		if(produksi_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Data anda tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		produksi_cetak=1;		
		var produksi_id_for_cetak = 0;
		if(produksi_idField.getValue()!== null){
			produksi_id_for_cetak = produksi_idField.getValue();
		}
		if(produksi_cetak==1){
			cetak_produksi_print_only(produksi_id_for_cetak);
			produksi_cetak=0;
		}
		}
	}
	
  	/* Function for get PK field */
	function get_pk_id(){
		if(produksi_post2db=='UPDATE')
			return produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function produksi_reset_form(){
		produksi_idField.reset();
		produksi_idField.setValue(null);
		produksi_noField.reset();
		produksi_noField.setValue(null);
		
		produksi_tanggalField.setValue(dt.format('Y-m-d'));
		produksi_keteranganField.reset();
		produksi_keteranganField.setValue(null);
		produksi_gudang_asalField.reset();
		produksi_gudang_asalField.setValue(null);
		produksi_gudang_tujuanField.reset();
		produksi_gudang_tujuanField.setValue(null);
		produksi_status_dokumenField.reset();
		produksi_status_dokumenField.setValue('Terbuka');
		produksi_status_dokumenField.setDisabled(false);
		
		produksi_tanggalField.setDisabled(false);
		produksi_noField.setDisabled(false);

		produksi_keteranganField.setDisabled(false);
		produksi_gudang_asalField.setDisabled(false);
		produksi_gudang_tujuanField.setDisabled(false);
		combo_dbahan_jadi.setDisabled(false);
		combo_satuan_bahan_jadi.setDisabled(false);
		djumlah_bahan_jadiField.setDisabled(false);
		combo_produk_jadi.setDisabled(false);
		combo_satuan_produksi_jadi.setDisabled(false);
		djumlah_produksi_jadiField.setDisabled(false);
		//produksi_status_dokumenField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
		//produksi_createForm.produksi_savePrint.enable();
		<?php } ?>
		
	}
 	/* End of Function */
	  
	/* setValue to EDIT */
	function produksi_set_form(){
		produksi_idField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_id'));
		produksi_noField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_no'));
		produksi_tanggalField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_tanggal'));
		produksi_keteranganField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_keterangan'));
		produksi_status_dokumenField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_status'));
		produksi_gudang_asalField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('gudang_asal_nama'));
		produksi_gudang_tujuanField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('gudang_tujuan_nama'));
		
		// Load Detail Bahan Produksinya dulu beserta satuannya.. 
		cbo_dbahan_jadiDataStore.load({
				params: {
					query: produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
					cbo_satuan_bahan_jadiDataStore.setBaseParam('produk_id', 0);
					cbo_satuan_bahan_jadiDataStore.setBaseParam('query', produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_id'));
					cbo_satuan_bahan_jadiDataStore.load({
								callback: function(opts, success, response){
									dbahan_jadi_DataStore.load({params: {master_id: get_pk_id(), start:0, limit: produksi_pageS}});
								}
					});
				}
		});


		// Load Detail Produksi Jadinya dulu beserta satuannya.. 
		cbo_produksi_jadiDataStore.load({
				params: {
					query: produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
					cbo_satuan_produksi_jadiDataStore.setBaseParam('produk_id', 0);
					cbo_satuan_produksi_jadiDataStore.setBaseParam('query', produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_id'));
					cbo_satuan_produksi_jadiDataStore.load({
								callback: function(opts, success, response){
									detail_produksi_jadi_DataStore.load({params: {master_id: get_pk_id(), start:0, limit: produksi_pageS}});
								}
					});
				}
		});


		//dbahan_jadi_DataStore.load({params: {master_id: get_pk_id(), start:0, limit: produksi_pageS}});
		//detail_produksi_jadi_DataStore.load({params: {master_id: get_pk_id(), start:0, limit: produksi_pageS}});
		
		produksi_status_dokumenField.on("select",function(){
			var status_awal_produksi = produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_status');
			if(status_awal_produksi =='Terbuka' && produksi_status_dokumenField.getValue()=='Tertutup')
			{
			Ext.MessageBox.show({
				msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			   //progressText: 'proses...',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			produksi_status_dokumenField.setValue('Terbuka');
			}
			
			else if(status_awal_produksi =='Tertutup' && produksi_status_dokumenField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			produksi_status_dokumenField.setValue('Tertutup');
			}
			
			else if(status_awal_produksi =='Batal' && produksi_status_dokumenField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Batal tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			produksi_status_dokumenField.setValue('Tertutup');
			}
			
			else if(produksi_status_dokumenField.getValue()=='Batal')
			{
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', produksi_status_batal);
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
			else if(status_awal_produksi =='Tertutup' && produksi_status_dokumenField.getValue()=='Tertutup'){
				
				//produksi_createForm.produksi_savePrint.enable();
			}
			<?php } ?>
			
		});
	}
		
	function produksi_status_batal(btn){
			if(btn=='yes')
			{
				produksi_status_dokumenField.setValue('Batal');
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
				//produksi_createForm.produksi_savePrint.disable();
				<?php } ?>
			}  
			else
			produksi_status_dokumenField.setValue(produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_status'));
		}
		
	
	/* End setValue to EDIT*/
	
	function produksi_set_form_update(){
		if(produksi_post2db=="UPDATE" && produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_status')=="Terbuka"){
			produksi_tanggalField.setDisabled(false);
			produksi_noField.setDisabled(false);
			produksi_keteranganField.setDisabled(false);
			produksi_gudang_asalField.setDisabled(false);
			produksi_gudang_tujuanField.setDisabled(false);
			produksi_status_dokumenField.setDisabled(false);
			combo_dbahan_jadi.setDisabled(false);
			combo_satuan_bahan_jadi.setDisabled(false);
			djumlah_bahan_jadiField.setDisabled(false);
			combo_produk_jadi.setDisabled(false);
			combo_satuan_produksi_jadi.setDisabled(false);
			djumlah_produksi_jadiField.setDisabled(false);
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
			produksi_createForm.produksi_savePrint.enable();
			<?php } ?>
		}
		if(produksi_post2db=="UPDATE" && produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_status')=="Tertutup"){
			produksi_tanggalField.setDisabled(true);
			produksi_noField.setDisabled(true);
			produksi_keteranganField.setDisabled(true);
			produksi_gudang_asalField.setDisabled(true);
			produksi_gudang_tujuanField.setDisabled(true);
			combo_dbahan_jadi.setDisabled(true);
			combo_satuan_bahan_jadi.setDisabled(true);
			djumlah_bahan_jadiField.setDisabled(true);
			combo_produk_jadi.setDisabled(true);
			combo_satuan_produksi_jadi.setDisabled(true);
			djumlah_produksi_jadiField.setDisabled(true);
			produksi_status_dokumenField.setDisabled(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
			produksi_createForm.produksi_savePrint.disable();
			<?php } ?>
		}
		if(produksi_post2db=="UPDATE" && produksi_ListEditorGrid.getSelectionModel().getSelected().get('produksi_status')=="Batal"){
			produksi_tanggalField.setDisabled(true);
			produksi_noField.setDisabled(true);
			produksi_keteranganField.setDisabled(true);
			produksi_gudang_asalField.setDisabled(true);
			produksi_gudang_tujuanField.setDisabled(true);
			combo_dbahan_jadi.setDisabled(true);
			combo_satuan_bahan_jadi.setDisabled(true);
			djumlah_bahan_jadiField.setDisabled(true);
			combo_produk_jadi.setDisabled(true);
			combo_satuan_produksi_jadi.setDisabled(true);
			djumlah_produksi_jadiField.setDisabled(true);
			produksi_status_dokumenField.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
			produksi_createForm.produksi_savePrint.disable();
			<?php } ?>
		}
	}
  
	/* Function for Check if the form is valid */
	function is_produksi_form_valid(){
		return (/*lcl_custField.isValid() &&*/ true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		detail_produksi_jadi_DataStore.load({params: {master_id:-1}});
		dbahan_jadi_DataStore.load({params: {master_id:-1}});
		if(!produksi_createWindow.isVisible()){
			produksi_reset_form();
			produksi_post2db='CREATE';
			msg='created';
			produksi_noField.setValue('(Auto)');
			produksi_status_dokumenField.setValue("Terbuka");
			produksi_createWindow.show();
		} else {
			produksi_createWindow.toFront();
		}
	}
  	/* End of Function */
	
  	/* Function for Delete Confirm */
	function produksi_confirm_delete(){
		if(produksi_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', produksi_delete);
		} else if(produksi_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', produksi_delete);
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
	function produksi_confirm_update(){
		/* only one record is selected here */
		if(produksi_ListEditorGrid.selModel.getCount() == 1) {
			produksi_post2db='UPDATE';
			msg='updated';
			produksi_set_form();
			produksi_set_form_update();
			produksi_createWindow.show();
			//produksi_createWindow.show();
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
	function produksi_delete(btn){
		if(btn=='yes'){
			var selections = produksi_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< produksi_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kwitansi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_produksi&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							produksi_DataStore.reload();
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
	produksi_DataStore = new Ext.data.Store({
		id: 'produksi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produksi_id'
		},[
			{name: 'produksi_id', type: 'int', mapping: 'produksi_id'}, 
			{name: 'produksi_no', type: 'string', mapping: 'produksi_no'}, 
			{name: 'produksi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'produksi_tanggal'}, 
			{name: 'produksi_status', type: 'string', mapping: 'produksi_status'}, 
			{name: 'produksi_keterangan', type: 'string', mapping: 'produksi_keterangan'}, 
			{name: 'gudang_asal_nama', type: 'string', mapping: 'gudang_asal_nama'},
			{name: 'gudang_tujuan_nama', type: 'string', mapping: 'gudang_tujuan_nama'},
			{name: 'produksi_gudang_asal', type: 'int', mapping: 'produksi_gudang_asal'},
			{name: 'produksi_gudang_tujuan', type: 'int', mapping: 'produksi_gudang_tujuan'}

		]),
		sortInfo:{field: 'produksi_id', direction: "DESC"}
	});
	/* End of Function */
		
	// DataStore Combo Produk - Detail Bahan Produksi
	cbo_dbahan_jadiDataStore = new Ext.data.Store({
		id: 'cbo_dbahan_jadiDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_produk_bahan_list', 
			method: 'POST'
		}),baseParams: {aktif: 'yes', start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'dbahan_produksi_value', type: 'int', mapping: 'produk_id'},
			{name: 'dbahan_produksi_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'dbahan_produksi_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'dbahan_produksi_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'dproduk_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'dproduk_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'dbahan_produksi_display', type: 'string', mapping: 'produk_nama'},
			{name: 'dproduk_edit_harga', type: 'float', mapping: 'produk_edit_harga'}
		]),
		sortInfo:{field: 'dbahan_produksi_display', direction: "ASC"}
	});
	var cbo_produk_bahan_jadi_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dbahan_produksi_kode}| <b>{dbahan_produksi_display}</b>',
		'</div></tpl>'
    );


	// DataStore Combo Produk - Detail Produksi Jadi
	cbo_produksi_jadiDataStore = new Ext.data.Store({
		id: 'cbo_produksi_jadiDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_produk_jadi_list', 
			method: 'POST'
		}),baseParams: {aktif: 'yes', start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'djadi_produksi_value', type: 'int', mapping: 'produk_id'},
			{name: 'djadi_produksi_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'djadi_produksi_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'djadi_produksi_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'dproduk_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'dproduk_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'djadi_produksi_display', type: 'string', mapping: 'produk_nama'},
			{name: 'dproduk_edit_harga', type: 'float', mapping: 'produk_edit_harga'}
		]),
		sortInfo:{field: 'djadi_produksi_display', direction: "ASC"}
	});
	var cbo_produk_jadi_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{djadi_produksi_kode}| <b>{djadi_produksi_display}</b>',
		'</div></tpl>'
    );


	// DataStore untuk Bahan Jadi Produksi
	var dbahan_jadi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dbahan_id'
	},[
			{name: 'dbahan_id', type: 'int', mapping: 'dbahan_id'},
			{name: 'dbahan_produk', type: 'int', mapping: 'dbahan_produk'},
			{name: 'dbahan_satuan', type: 'int', mapping: 'dbahan_satuan'},
			{name: 'dbahan_jumlah', type: 'int', mapping: 'dbahan_jumlah'},
			{name: 'dbahan_keterangan', type: 'string', mapping: 'dbahan_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'},
	]);

	/* Function for Retrieve DataStore of detail*/
	dbahan_jadi_DataStore = new Ext.data.Store({
		id: 'dbahan_jadi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=detail_bahan_jadi_produksi_list',
			method: 'POST'
		}),
		reader: dbahan_jadi_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: produksi_pageS },
		sortInfo:{field: 'dbahan_produk', direction: "ASC"}
	});
	/* End of Function */
	
	// DataStore untuk Detail Produksi Jadi
	var detail_produksi_jadi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
	},[
			{name: 'djadi_id', type: 'int', mapping: 'djadi_id'},
			{name: 'djadi_produk', type: 'int', mapping: 'djadi_produk'},
			{name: 'djadi_jumlah', type: 'int', mapping: 'djadi_jumlah'},
			{name: 'djadi_satuan', type: 'int', mapping: 'djadi_satuan'},
			{name: 'djadi_keterangan', type: 'string', mapping: 'djadi_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}

	]);

	/* Function for Retrieve DataStore of detail*/
	detail_produksi_jadi_DataStore = new Ext.data.Store({
		id: 'detail_produksi_jadi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=detail_produksi_jadi_list',
			method: 'POST'
		}),
		reader: detail_produksi_jadi_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: produksi_pageS },
		sortInfo:{field: 'djadi_produk', direction: "ASC"}
	});
	/* End of Function */

	 // Data Store Gudang Tujuannya
    produksi_gudang_tujuanDataStore = new Ext.data.Store({
		id: 'produksi_gudang_tujuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_gudang_tujuan_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'gudang_tujuan_display', type: 'string', mapping: 'gudang_nama'},
			{name: 'gudang_tujuan_value', type: 'int', mapping: 'gudang_id'},
			{name: 'terima_gudang_lokasi', type: 'string', mapping: 'gudang_lokasi'},
			{name: 'terima_gudang_keterangan', type: 'string', mapping: 'gudang_keterangan'},
		]),
		sortInfo:{field: 'gudang_tujuan_value', direction: "ASC"}
	}); 

	// Data Store Gudang Awal nya
    produksi_gudang_asalDataStore = new Ext.data.Store({
		id: 'produksi_gudang_asalDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_gudang_asal_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'gudang_asal_display', type: 'string', mapping: 'gudang_nama'},
			{name: 'gudang_asal_value', type: 'int', mapping: 'gudang_id'},
			{name: 'terima_gudang_lokasi', type: 'string', mapping: 'gudang_lokasi'},
			{name: 'terima_gudang_keterangan', type: 'string', mapping: 'gudang_keterangan'},
		]),
		sortInfo:{field: 'gudang_asal_value', direction: "ASC"}
	});

    //TPL untuk Gudang Tujuan
	var produksi_gudang_tujuan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{gudang_tujuan_display}</b><br /></span>',
            'Lokasi: {terima_gudang_lokasi}<br>',
        '</div></tpl>'
    );

    //TPL untuk Gudang Asal
	var produksi_gudang_asal_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{gudang_asal_display}</b><br /></span>',
            'Lokasi: {terima_gudang_lokasi}<br>',
        '</div></tpl>'
    );

	//Function for retrive DataStore of Satuan Bahan Jadi Produksi
	cbo_satuan_bahan_jadiDataStore = new Ext.data.Store({
		id: 'cbo_satuan_bahan_jadiDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_satuan_bybahan_jadi_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'dbahan_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'dbahan_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'dbahan_satuan_nilai', type: 'float', mapping: 'konversi_nilai'},
			{name: 'dbahan_satuan_display', type: 'string', mapping: 'satuan_kode'},
			{name: 'dbahan_satuan_default', type: 'string', mapping: 'konversi_default'},
			{name: 'dbahan_satuan_harga', type: 'float', mapping: 'produk_harga'}
		]),
		sortInfo:{field: 'dbahan_satuan_default', direction: "DESC"}
	});

	//Function for retrive DataStore of Satuan Produksi Jadi
	cbo_satuan_produksi_jadiDataStore = new Ext.data.Store({
		id: 'cbo_satuan_produksi_jadiDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=get_satuan_byproduksi_jadi_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'djadi_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'djadi_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'djadi_satuan_nilai', type: 'float', mapping: 'konversi_nilai'},
			{name: 'djadi_satuan_display', type: 'string', mapping: 'satuan_kode'},
			{name: 'djadi_satuan_default', type: 'string', mapping: 'konversi_default'},
			{name: 'djadi_satuan_harga', type: 'float', mapping: 'produk_harga'}
		]),
		sortInfo:{field: 'djadi_satuan_default', direction: "DESC"}
	});

	//function for editor of detail Bahan Jadi
	var editor_dbahan_jadi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	//function for editor of detail Detail Produksi Jadi
	var editor_dproduksi_jadi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
  	/* Function for Identify of Window Column Model */
	produksi_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'produksi_id',
			width: 40,
			/*
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
				*/
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			align: 'left',
			dataIndex: 'produksi_tanggal',
			width: 70,	//150,
			sortable: true,
			//renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			
			renderer: function(value, cell, record){
				// cell.css = "readonlycell";
				if(record.data.produksi_status=='Tertutup'){
					return '<span style="color:green;">' + value.dateFormat('d-m-Y') + '</span>';
				}
				if(record.data.produksi_status=='Terbuka'){
					return value.dateFormat('d-m-Y');
				}
				return value.dateFormat('d-m-Y');
			}
			
		}, 
		{
			header: '<div align="center">' + 'Produksi No.' + '</div>',
			align: 'left',
			dataIndex: 'produksi_no',
			width: 80,	//150,
			sortable: true
			/*
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.produksi_status=='Tertutup'){
					return '<span style="color:green;">' + value + '</span>';
				}
				if(record.data.produksi_status=='Terbuka'){
					return value;
				}
				return value;
			}
			*/
		}, 
		{
			header: '<div align="center">' + 'Gudang Asal' + '</div>',
			align: 'left',
			dataIndex: 'gudang_asal_nama',
			width: 80,	//150,
			sortable: true
			/*
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.produksi_status=='Tertutup'){
					return '<span style="color:green;">' + value + '</span>';
				}
				if(record.data.produksi_status=='Terbuka'){
					return value;
				}
				return value;
			}
			*/
		}, 
		{
			header: '<div align="center">' + 'Gudang Tujuan' + '</div>',
			align: 'left',
			dataIndex: 'gudang_tujuan_nama',
			width: 80,	//150,
			sortable: true
			/*
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.produksi_status=='Tertutup'){
					return '<span style="color:green;">' + value + '</span>';
				}
				if(record.data.produksi_status=='Terbuka'){
					return value;
				}
				return value;
			}
			*/
		}, 
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'left',
			dataIndex: 'produksi_keterangan',
			width: 150	
			/*
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.produksi_status=='Tertutup'){
					return '<span style="color:green;">' + value + '</span>';
				}
				if(record.data.produksi_status=='Terbuka'){
					return value;
				}
				return value;
			}
			*/
		}, 
			{
			header: '<div align="center">' + 'Status' + '</div>',
			align: 'left',
			dataIndex: 'produksi_status',
			width: 150
			/*
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.produksi_status=='Tertutup'){
					return '<span style="color:green;">' + value + '</span>';
				}
				if(record.data.produksi_status=='Terbuka'){
					return value;
				}
				return value;
			}
			*/
		}, 
		{
			header: 'Creator',
			dataIndex: 'produksi_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'produksi_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	
		]);
	
	produksi_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	produksi_ListEditorGrid =  new Ext.grid.GridPanel({
		id: 'produksi_ListEditorGrid',
		el: 'fp_produksi',
		title: 'Daftar Persiapan Produksi',
		autoHeight: true,
		store: produksi_DataStore, 
		cm: produksi_ColumnModel, 
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: produksi_pageS,
			store: produksi_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',   
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
		{
			text: 'View/Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: produksi_confirm_update  
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: produksi_confirm_delete 
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			disabled : true,
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: produksi_DataStore,
			params: {task: 'LIST',start: 0, limit: produksi_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						produksi_DataStore.baseParams={task:'LIST',start: 0, limit: produksi_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Produksi No. <br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: produksi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: produksi_export_excel
		}
		/*, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produksi_print  
		}
		*/
		]
	});
	produksi_ListEditorGrid.render();
	/* End of DataStore */
	
	produksi_ListEditorGrid.on('rowclick', function (produksi_ListEditorGrid, rowIndex, eventObj) {
        var recordMaster = produksi_ListEditorGrid.getSelectionModel().getSelected();
        detail_bahan_produksi_list_DataStore.setBaseParam('master_id',recordMaster.get("produksi_id"));
		detail_bahan_produksi_list_DataStore.load({params : {master_id : recordMaster.get("produksi_id"), start:0, limit:produksi_pageS}});
		detail_produksi_jadi_list_DataStore.setBaseParam('master_id',recordMaster.get("produksi_id"));
		detail_produksi_jadi_list_DataStore.load({params : {master_id : recordMaster.get("produksi_id"), start:0 , limit : produksi_pageS}});
		produksi_temp_master_idField.setValue(recordMaster.get("produksi_id"));
		produksi_DataStore.reload();
    });
     
	/* Create Context Menu */
	produksi_ContextMenu = new Ext.menu.Menu({
		id: 'produksi_ContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
		{ 
			text: 'View/Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: produksi_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: produksi_confirm_delete 
		},
		<?php } ?>
		'-',
		/*
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: produksi_print 
		},
		*/
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: produksi_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onproduksi_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var lcl_coords = e.getXY();
		produksi_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		produksi_SelectedRow=rowIndex;
		produksi_ContextMenu.showAt([lcl_coords[0], lcl_coords[1]]);
  	}
  	/* End of Function */
	
	produksi_ListEditorGrid.addListener('rowcontextmenu', onproduksi_ListEditGridContextMenu);
	produksi_DataStore.load({params: {start: 0, limit: produksi_pageS}});	// load DataStore
	produksi_ListEditorGrid.on('afteredit', produksi_update); // inLine Editing Record
	
	/* Identify produksi_id Field */
	produksi_temp_master_idField= new Ext.form.NumberField({
		id: 'produksi_temp_master_idField'
	});
	
	/* Identify produksi_id Field */
	produksi_idField= new Ext.form.NumberField({
		id: 'produksi_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify produksi_no Field */
	produksi_noField= new Ext.form.TextField({
		id: 'produksi_noField',
		fieldLabel: 'Produksi No.',
		maxLength: 20,
		readOnly:true,
		emptyText: '(Auto)',
		anchor: '75%'
	});

	//Produski Gudang Asal Field
	produksi_gudang_asalField= new Ext.form.ComboBox({
		id: 'produksi_gudang_asalField',
		fieldLabel: 'Gudang Asal',
		index : 4,
		store:produksi_gudang_asalDataStore,
		mode: 'remote',
		displayField: 'gudang_asal_display',
		valueField: 'gudang_asal_value',
		typeAhead: false,
        hideTrigger:false,
		tpl: produksi_gudang_asal_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});

	//Produski Gudang Tujuan Field
	produksi_gudang_tujuanField= new Ext.form.ComboBox({
		id: 'produksi_gudang_tujuanField',
		fieldLabel: 'Gudang Tujuan',
		index : 4,
		store:produksi_gudang_tujuanDataStore,
		mode: 'remote',
		displayField: 'gudang_tujuan_display',
		valueField: 'gudang_tujuan_value',
		typeAhead: false,
        hideTrigger:false,
		tpl: produksi_gudang_tujuan_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});
	
	//Declaration Detail Bahan Produksi
	dbahan_jadi_idField=new Ext.form.NumberField();
	dproduksi_jadi_idField=new Ext.form.NumberField();

	//Declaration Combo Bahan Jadi Produksi
	var combo_dbahan_jadi =new Ext.form.ComboBox({
		store: cbo_dbahan_jadiDataStore,
		mode: 'remote',
		displayField: 'dbahan_produksi_display',
		valueField: 'dbahan_produksi_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize: produksi_pageS,
		hideTrigger:false,
		tpl: cbo_produk_bahan_jadi_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	//Declaration Combo Produksi Jadi
	var combo_produk_jadi =new Ext.form.ComboBox({
		store: cbo_produksi_jadiDataStore,
		mode: 'remote',
		displayField: 'djadi_produksi_display',
		valueField: 'djadi_produksi_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize: produksi_pageS,
		hideTrigger:false,
		tpl: cbo_produk_jadi_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	//Declaration Combo Satuan Bahan Jadi Produksi
	var combo_satuan_bahan_jadi=new Ext.form.ComboBox({
		store: cbo_satuan_bahan_jadiDataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'dbahan_satuan_display',
		valueField: 'dbahan_satuan_value',
		triggerAction: 'all',
		allowBlank : false,
		anchor: '95%'
	});

	//Declaration Combo Satuan Produksi Jadi
	var combo_satuan_produksi_jadi=new Ext.form.ComboBox({
		store: cbo_satuan_produksi_jadiDataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'djadi_satuan_display',
		valueField: 'djadi_satuan_value',
		triggerAction: 'all',
		allowBlank : false,
		anchor: '95%'
	});

	//Declaration Jumlah Bahan Produksi
	var djumlah_bahan_jadiField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});

	// Declaration Jumlah Produksi Jadi
	var djumlah_produksi_jadiField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produksi_keterangan Field */
	produksi_keteranganField= new Ext.form.TextArea({
		id: 'produksi_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '75%'
	});

	/* Identify Produksi Status Field */
	produksi_status_dokumenField= new Ext.form.ComboBox({
		id: 'produksi_status_dokumenField',
		align : 'Right',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['produksi_status_value', 'produksi_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'produksi_status_display',
		valueField: 'produksi_status_value',
		//emptyText: 'Terbuka',
		anchor: '25%',
		triggerAction: 'all'	
	});

	/*Identify produksi_tanggal Field  */
	produksi_tanggalField= new Ext.form.DateField({
		id: 'produksi_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});

	//Column Model Bahan Jadi - detail Bahan Jadi Produksi
	detail_bahan_jadi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'dbahan_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'dbahan_produk',
			width: 180,
			sortable: false,
			allowBlank : false,
			editor: combo_dbahan_jadi,
			renderer: Ext.util.Format.comboRenderer(combo_dbahan_jadi)
		},

		{
			align :'Left',
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'dbahan_satuan',
			width: 100,
			sortable: false,
			editor: combo_satuan_bahan_jadi,
			renderer: Ext.util.Format.comboRenderer(combo_satuan_bahan_jadi)
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'dbahan_jumlah',
			width: 100,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: djumlah_bahan_jadiField
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dbahan_keterangan',
			width: 400,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
		}

		]
	);
	detail_bahan_jadi_ColumnModel.defaultSortable= true;
	//eof
	
	//Column Model Remarks - Detail Produksi Jadi
	detail_produksi_jadi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'djadi_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'djadi_produk',
			width: 180,
			sortable: false,
			allowBlank : false,
			editor: combo_produk_jadi,
			renderer: Ext.util.Format.comboRenderer(combo_produk_jadi)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'djadi_satuan',
			width: 100,
			sortable: false,
			editor: combo_satuan_produksi_jadi,
			renderer: Ext.util.Format.comboRenderer(combo_satuan_produksi_jadi)
		
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'djadi_jumlah',
			width: 100,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: djumlah_produksi_jadiField

		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'djadi_keterangan',
			width: 400,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
		}

		]
	);
	detail_produksi_jadi_ColumnModel.defaultSortable= true;
	
	//declaration of detail list editor grid
	detail_bahan_jadiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_bahan_jadiListEditorGrid',
		el: 'fp_dbahan_jadi',
		title: 'Detail Bahan Produksi',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: dbahan_jadi_DataStore, 
		colModel: detail_bahan_jadi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		plugins: [editor_dbahan_jadi],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false}
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_bahan_jadi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_pers_bahan_produksi_delete
		}
		]
	});
	//eof

	/* Function for Delete Confirm of detail */
	function detail_pers_bahan_produksi_delete(){
		// only one record is selected here
		if(detail_bahan_jadiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_bahan_produksi_konfirm_delete);
		} else if(detail_bahan_jadiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_bahan_produksi_konfirm_delete);
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

	/* Function for Delete Confirm of detail */
	function detail_pers_produksi_jadi_delete(){
		// only one record is selected here
		if(detail_produksi_jadiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_produksi_jadi_konfirm_delete);
		} else if(detail_produksi_jadiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_produksi_jadi_konfirm_delete);
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

	//function for Delete of detail
	function detail_bahan_produksi_konfirm_delete(btn){
		if(btn=='yes'){
            var selections = detail_bahan_jadiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dbahan_id==''){
                    dbahan_jadi_DataStore.remove(record);
                }else if((/^\d+$/.test(record.data.dbahan_id))){
                    //Delete dari db.detail_remarks_lcl
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    dbahan_jadi_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_produksi&m=get_action', 
                        params: { task: "DDELETE", dbahan_id:  record.data.dbahan_id }, 
                        success: function(response){
                            var result=eval(response.responseText);
                            switch(result){
                                case 1:  // Success : simply reload
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

	//function for Delete of detail
	function detail_produksi_jadi_konfirm_delete(btn){
		if(btn=='yes'){
            var selections = detail_produksi_jadiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.djadi_id==''){
                    detail_produksi_jadi_DataStore.remove(record);
                }else if((/^\d+$/.test(record.data.djadi_id))){
                    //Delete dari db.detail_final_status
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_produksi_jadi_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_produksi&m=get_action', 
                        params: { task: "DDELETE_FSTATUS", djadi_id:  record.data.djadi_id }, 
                        success: function(response){
                            var result=eval(response.responseText);
                            switch(result){
                                case 1:  // Success : simply reload
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

	//declaration of detail list editor grid For Detail Produksi Jadi
	detail_produksi_jadiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_produksi_jadiListEditorGrid',
		el: 'fp_produksi_jadi',
		title: 'Detail Produksi Jadi',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: detail_produksi_jadi_DataStore,
		colModel: detail_produksi_jadi_ColumnModel, 
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		plugins: [editor_dproduksi_jadi],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false}
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_pers_produksi_jadi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			handler: detail_pers_produksi_jadi_delete
		}
		]
	});
	//eof
	
	//function of detail add Bahan Produksi
	function detail_bahan_jadi_add(){
		var edit_dbahan_jadi= new detail_bahan_jadiListEditorGrid.store.recordType({
			dbahan_id		:'',		
			dbahan_produk	:'',
			dbahan_satuan	:'',
			dbahan_jumlah	:'',
			dbahan_keterangan	:''
		});
		editor_dbahan_jadi.stopEditing();
		dbahan_jadi_DataStore.insert(0, edit_dbahan_jadi);
		// detail_bahan_jadiListEditorGrid.getView().refresh();
		detail_bahan_jadiListEditorGrid.getSelectionModel().selectRow(0);
		editor_dbahan_jadi.startEditing(0);
	}
	
	//function of detail add Detail Produksi Jadi
	function detail_pers_produksi_jadi_add(){
		var edit_lcl_fs= new detail_produksi_jadiListEditorGrid.store.recordType({
			djadi_id			:'',		
			djadi_produk		:'',
			djadi_satuan		:'', 
			djadi_jumlah  		:'',
			djadi_keterangan	:''
		});
		editor_dproduksi_jadi.stopEditing();
		detail_produksi_jadi_DataStore.insert(0, edit_lcl_fs);
		// detail_produksi_jadiListEditorGrid.getView().refresh();
		detail_produksi_jadiListEditorGrid.getSelectionModel().selectRow(0);
		editor_dproduksi_jadi.startEditing(0);
	}
	
  	/*Fieldset Master*/
	persiapan_produksi_MasterGroup = new Ext.form.FieldSet({
		// title: 'Master Information',
		autoHeight: true,
		//collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.48,
				layout: 'form',
				border:false,
				items: [produksi_tanggalField, produksi_noField, produksi_gudang_asalField, produksi_gudang_tujuanField, produksi_idField] 
			},
			{
				columnWidth:0.02,
				layout: 'form',
				border:false,
				items: [{xtype: 'spacer',height:10}] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [produksi_keteranganField/*produksi_status_dokumenField*/] 
			}
			]
	});
	
	/* Start History List Bahan Produksi */
	detail_bahan_produksi_list_DataStore = new Ext.data.GroupingStore({
		id: 'detail_bahan_produksi_list_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=list_history_bahan_produksi', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:produksi_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
		},[
        	{name: 'dbahan_id', type: 'int', mapping: 'dbahan_id'}, 
			{name: 'dbahan_master', type: 'int', mapping: 'dbahan_master'}, 
			{name: 'dbahan_produk', type: 'int', mapping: 'dbahan_produk'}, 
			{name: 'dbahan_satuan', type: 'int', mapping: 'dbahan_satuan'}, 
			{name: 'dbahan_jumlah', type: 'int', mapping: 'dbahan_jumlah'}, 
			{name: 'dbahan_keterangan', type: 'string', mapping: 'dbahan_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'dbahan_produk', direction: "ASC"}
	});
	/* End DataStore */

	/* Start Panel Detail Produksi Jadi Data Store*/
	detail_produksi_jadi_list_DataStore = new Ext.data.GroupingStore({
		id: 'detail_produksi_jadi_list_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_produksi&m=list_history_produksi_jadi', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:produksi_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
			//id: 'app_id'
		},[
        	{name: 'djadi_id', type: 'int', mapping: 'djadi_id'}, 
			{name: 'djadi_master', type: 'int', mapping: 'djadi_master'}, 
			{name: 'djadi_produk', type: 'int', mapping: 'djadi_produk'}, 
			{name: 'djadi_satuan', type: 'int', mapping: 'djadi_satuan'}, 
			{name: 'djadi_jumlah', type: 'int', mapping: 'djadi_jumlah'}, 
			{name: 'djadi_keterangan', type: 'string', mapping: 'djadi_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'djadi_produk', direction: "ASC"}
	});
	/* End DataStore */

	//ColumnModel for Detail Bahan Produksi History
	detail_bahan_produksi_list_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'produk_nama',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'satuan_nama',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Jumlah' + '</div>',
			dataIndex: 'dbahan_jumlah',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dbahan_keterangan',
			width: 100,
			sortable: true
		}]
    );
    detail_bahan_produksi_list_ColumnModel.defaultSortable= true;

    //Column Model for Detail Produksi Jadi History
    detail_produksi_jadi_list_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'produk_nama',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'satuan_nama',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Jumlah' + '</div>',
			dataIndex: 'djadi_jumlah',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'djadi_keterangan',
			width: 100,
			sortable: true
		}]
    );
    detail_produksi_jadi_list_ColumnModel.defaultSortable= true;

    // Panel Detail Bahan Produksi
	var detail_bahan_produksi_remarks_Panel = new Ext.grid.GridPanel({
		id: 'detail_bahan_produksi_remarks_Panel',
		title: 'Detail Bahan Produksi',
        store: detail_bahan_produksi_list_DataStore,
        cm: detail_bahan_produksi_list_ColumnModel,
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
		plugins: summary,
        stripeRows: true,
        autoExpandColumn: 'customer_nama',
        autoHeight: true,
		style: 'margin-top: 10px',
        width: 1200	//800
    });
    detail_bahan_produksi_remarks_Panel.render('fp_bahan_produksi_history');

    //Panel Detail Produksi Jadi
    var detail_produksi_jadi_Panel = new Ext.grid.GridPanel({
		id: 'detail_produksi_jadi_Panel',
		title: 'Detail Produksi Jadi',
        store: detail_produksi_jadi_list_DataStore,
        cm: detail_produksi_jadi_list_ColumnModel,
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
		plugins: summary,
        stripeRows: true,
        autoExpandColumn: 'customer_nama',
        autoHeight: true,
		style: 'margin-top: 10px',
        width: 1200	//800
    });
    detail_produksi_jadi_Panel.render('fp_produksi_jadi_history');

	/* Function for retrieve create Window Panel*/ 
	produksi_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 900,        
		items: [ produksi_status_dokumenField, persiapan_produksi_MasterGroup , detail_bahan_jadiListEditorGrid , detail_produksi_jadiListEditorGrid],
		buttons: [
		
			{
				text : 'Print Only',
				ref : '../produksi_printonly',
				handler : print_only
			},
			{
				xtype:'spacer',
				width: 500
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PRODUKSI'))){ ?>
			{
				text: 'Save and Print',
				ref: '../produksi_savePrint',
				handler: save_and_print
				
			},
			{
				text: 'Save and Close',
				handler: save_and_close
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					produksi_reset_form();
					produksi_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	produksi_createWindow= new Ext.Window({
		id: 'produksi_createWindow',
		title: produksi_post2db+'Persiapan Produksi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_produksi_create',
		items: produksi_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function produksi_list_search(){
		// render according to a SQL date format.
		var kwitansi_no_search=null;
		var kwitansi_cust_search=null;
		var kwitansi_tanggal_start_search="";
		var kwitansi_tanggal_end_search="";
		var kwitansi_keterangan_search=null;
		var kwitansi_status_search=null;
		var dfcl_remarks_status_search=null;
		var dfcl_final_status_search=null;

		if(produksi_noSearchField.getValue()!==null){kwitansi_no_search=produksi_noSearchField.getValue();}

		if(lcl_tanggal_awalSearchField.getValue()!==""){kwitansi_tanggal_start_search=lcl_tanggal_awalSearchField.getValue().format('Y-m-d');}
		if(lcl_tanggal_akhirSearchField.getValue()!==""){kwitansi_tanggal_end_search=lcl_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(produksi_keteranganSearchField.getValue()!==null){kwitansi_keterangan_search=produksi_keteranganSearchField.getValue();}
		if(produksi_statusSearchField.getValue()!==null){kwitansi_status_search=produksi_statusSearchField.getValue();}

		// change the store parameters
		produksi_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kwitansi_no				:	kwitansi_no_search,
			kwitansi_cust			:	kwitansi_cust_search,
			kwitansi_tanggal_start	:	kwitansi_tanggal_start_search,
			kwitansi_tanggal_end	:	kwitansi_tanggal_end_search,
			kwitansi_keterangan		:	kwitansi_keterangan_search,
			produksi_status			:	kwitansi_status_search,
			dbahan_produk			:	dfcl_remarks_status_search,
			dbahan_satuan			:	dfcl_remarks_status_search,
			final_status			:	dfcl_final_status_search
		};
		// Cause the datastore to do another query : 
		produksi_DataStore.reload({params: {start: 0, limit: produksi_pageS}});
	}
		
	/* Function for reset search result */
	function produksi_reset_search(){
		// reset the store parameters
		produksi_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		produksi_DataStore.reload({params: {start: 0, limit: produksi_pageS}});
		//produksi_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify FCL_id Search Field */
	produksi_idSearchField= new Ext.form.NumberField({
		id: 'produksi_idSearchField',
		fieldLabel: 'LCL Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/	
	});

	/* Identify lcl_no Search Field */
	produksi_noSearchField= new Ext.form.TextField({
		id: 'produksi_noSearchField',
		fieldLabel: 'Import Code',
		maxLength: 20,
		anchor: '95%'
	});

	/* Identify  lcl_supplierSearchField */
	lcl_supplierSearchField= new Ext.form.ComboBox({
		id: 'lcl_supplierSearchField',
		fieldLabel: 'Supplier',
		//store: cbo_lcl_supplierDataStore,
		mode: 'remote',
		displayField:'cust_firstname',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
       // tpl: lcl_supplier_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});
	
	/* Identify produksi_keterangan Search Field */
	produksi_keteranganSearchField= new Ext.form.TextArea({
		id: 'produksi_keteranganSearchField',
		fieldLabel: 'Description of Goods',
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify  lcl_tanggal Search Field */
	lcl_tanggal_awalSearchField= new Ext.form.DateField({
		id: 'lcl_tanggal_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
	});
	lcl_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'lcl_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
	});
	
	/* Identify produksi_status Search Field */
	produksi_statusSearchField= new Ext.form.ComboBox({
		id: 'produksi_statusSearchField',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['value', 'produksi_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'produksi_status',
		valueField: 'value',
		width: 100,
		triggerAction: 'all'
	});

	/* Function for retrieve search Form Panel */
	produksi_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 100,
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
				items: [produksi_noSearchField,lcl_supplierSearchField,
					
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
								lcl_tanggal_awalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								lcl_tanggal_akhirSearchField
							]
						}							
				        ]
					},
			produksi_keteranganSearchField] 
			}			
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: produksi_list_search
			},{
				text: 'Close',
				handler: function(){
					produksi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	produksi_searchWindow = new Ext.Window({
		title: 'Pencarian Daftar Persiapan Produksi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_produksi_search',
		items: produksi_searchForm
	});
    /* End of Function */
	
	function produksi_reset_SearchForm(){
		produksi_noSearchField.reset();
		produksi_noSearchField.setValue(null);
		lcl_tanggal_awalSearchField.reset();
		lcl_tanggal_awalSearchField.setValue(null);
		lcl_tanggal_akhirSearchField.reset();
		lcl_tanggal_akhirSearchField.setValue(null);
		produksi_keteranganSearchField.reset();
		produksi_keteranganSearchField.setValue(null);
		produksi_statusSearchField.reset();
		produksi_statusSearchField.setValue(null);
	}
	 
	 function produksi_reset_search_form(){
		produksi_noSearchField.reset();
		produksi_noSearchField.setValue(null);
		lcl_tanggal_awalSearchField.reset();
		lcl_tanggal_awalSearchField.setValue(null);
		lcl_tanggal_akhirSearchField.reset();
		lcl_tanggal_akhirSearchField.setValue(null);
		produksi_keteranganSearchField.reset();
		produksi_keteranganSearchField.setValue(null);
		produksi_statusSearchField.reset();
		produksi_statusSearchField.setValue(null);
	 }
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		produksi_reset_search_form();
		if(!produksi_searchWindow.isVisible()){
			produksi_reset_SearchForm();
			produksi_searchWindow.show();
		} else {
			produksi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function produksi_print(){
		var searchquery = "";
		var kwitansi_no_print=null;
		var kwitansi_cust_print=null;
		var kwitansi_keterangan_print=null;
		var kwitansi_status_print=null;
		var win;              
		// check if we do have some search data...
		if(produksi_DataStore.baseParams.query!==null){searchquery = produksi_DataStore.baseParams.query;}
		if(produksi_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_print = produksi_DataStore.baseParams.kwitansi_no;}
		if(produksi_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_print = produksi_DataStore.baseParams.kwitansi_cust;}
		if(produksi_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_print = produksi_DataStore.baseParams.kwitansi_keterangan;}
		if(produksi_DataStore.baseParams.produksi_status!==null){kwitansi_status_print = produksi_DataStore.baseParams.produksi_status;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_produksi&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kwitansi_no	:	kwitansi_no_print, 
			kwitansi_cust	:	kwitansi_cust_print, 
			kwitansi_keterangan	:	kwitansi_keterangan_print, 
			produksi_status	:	kwitansi_status_print,
		  	currentlisting: produksi_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/cetak_kwitansilist.html','cetak_kwitansilist','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	function produksi_export_excel(){
		var searchquery = "";
		var kwitansi_no_2excel=null;
		var kwitansi_cust_2excel=null;
		var kwitansi_keterangan_2excel=null;
		var kwitansi_status_2excel=null;
		var win;
		// check if we do have some 2excel data...
		if(produksi_DataStore.baseParams.query!==null){searchquery = produksi_DataStore.baseParams.query;}
		if(produksi_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_2excel = produksi_DataStore.baseParams.kwitansi_no;}
		if(produksi_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_2excel = produksi_DataStore.baseParams.kwitansi_cust;}
		if(produksi_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_2excel = produksi_DataStore.baseParams.kwitansi_keterangan;}
		if(produksi_DataStore.baseParams.produksi_status!==null){kwitansi_status_2excel = produksi_DataStore.baseParams.produksi_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_produksi&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			//if we are doing advanced 2excel, use this
			kwitansi_no	:	kwitansi_no_2excel, 
			kwitansi_cust	:	kwitansi_cust_2excel, 
			kwitansi_keterangan	:	kwitansi_keterangan_2excel, 
			produksi_status	:	kwitansi_status_2excel,
		  	currentlisting: produksi_DataStore.baseParams.task // this tells us if we are searching or not
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

	/*Event Function*/
	combo_dbahan_jadi.on('select',function(){
		var j=cbo_dbahan_jadiDataStore.findExact('dbahan_produksi_value',combo_dbahan_jadi.getValue(),0);

            //Untuk me-lock screen sementara, menunggu data selesai di-load ==> setelah selesai di-load, hide Ext.MessageBox.show() di bawah ini
			detail_bahan_jadiListEditorGrid.setDisabled(true);
			editor_dbahan_jadi.disable();
			
            dbahan_jadi_idField.setValue(cbo_dbahan_jadiDataStore.getAt(j).data.dbahan_produksi_value);
			cbo_satuan_bahan_jadiDataStore.load({
				params: {produk_id:dbahan_jadi_idField.getValue()},
				callback: function(opts, success, response){
					if(success){
                        djumlah_bahan_jadiField.setValue(1);
						var nilai_default=0;
                        var st=cbo_satuan_bahan_jadiDataStore.findExact('dbahan_satuan_default','true',0);
                        if(cbo_satuan_bahan_jadiDataStore.getCount()>=0){
                            nilai_default=cbo_satuan_bahan_jadiDataStore.getAt(st).data.dbahan_satuan_nilai;
                            if(nilai_default===1){
		
								detail_bahan_jadiListEditorGrid.setDisabled(false);
								editor_dbahan_jadi.enable();
								
                            }else if(nilai_default!==1){
								detail_bahan_jadiListEditorGrid.setDisabled(false);
								editor_dbahan_jadi.enable();
                            }else{
								detail_bahan_jadiListEditorGrid.setDisabled(false);
								editor_dbahan_jadi.enable();
                            }
                            combo_satuan_bahan_jadi.setValue(cbo_satuan_bahan_jadiDataStore.getAt(st).data.dbahan_satuan_value);
                        }else{
							detail_bahan_jadiListEditorGrid.setDisabled(false);
								editor_dbahan_jadi.enable();
                        }
					}else{
						detail_bahan_jadiListEditorGrid.setDisabled(false);
								editor_dbahan_jadi.enable();
                    }
				}
			});	
		window.refresh(); //Fungsi ini adalah memancing error, dimana tujuannya agar harga dan satuan pada detail muncul. Setelah muncul error ini, maka akan ada console.clear() agar tidak membingungkan user.. 
	});

	combo_satuan_bahan_jadi.on('focus', function(){
		cbo_satuan_bahan_jadiDataStore.setBaseParam('produk_id',combo_dbahan_jadi.getValue());
		cbo_satuan_bahan_jadiDataStore.load();
	});

	combo_produk_jadi.on('select',function(){
		var j=cbo_produksi_jadiDataStore.findExact('djadi_produksi_value',combo_produk_jadi.getValue(),0);

            //Untuk me-lock screen sementara, menunggu data selesai di-load ==> setelah selesai di-load, hide Ext.MessageBox.show() di bawah ini
			detail_produksi_jadiListEditorGrid.setDisabled(true);
			editor_dproduksi_jadi.disable();
			
            dproduksi_jadi_idField.setValue(cbo_produksi_jadiDataStore.getAt(j).data.djadi_produksi_value);
			cbo_satuan_produksi_jadiDataStore.load({
				params: {produk_id:dproduksi_jadi_idField.getValue()},
				callback: function(opts, success, response){
					if(success){
                        djumlah_produksi_jadiField.setValue(1);
						var nilai_default_jadi=0;
                        var st=cbo_satuan_produksi_jadiDataStore.findExact('djadi_satuan_default','true',0);
                        if(cbo_satuan_produksi_jadiDataStore.getCount()>=0){
                            nilai_default_jadi=cbo_satuan_produksi_jadiDataStore.getAt(st).data.djadi_satuan_nilai;
                            if(nilai_default_jadi===1){
		
								detail_produksi_jadiListEditorGrid.setDisabled(false);
								editor_dproduksi_jadi.enable();
								
                            }else if(nilai_default_jadi!==1){
								detail_produksi_jadiListEditorGrid.setDisabled(false);
								editor_dproduksi_jadi.enable();
                            }else{
								detail_produksi_jadiListEditorGrid.setDisabled(false);
								editor_dproduksi_jadi.enable();
                            }
                            combo_satuan_produksi_jadi.setValue(cbo_satuan_produksi_jadiDataStore.getAt(st).data.djadi_satuan_value);
                        }else{
							detail_produksi_jadiListEditorGrid.setDisabled(false);
								editor_dproduksi_jadi.enable();
                        }
					}else{
						detail_produksi_jadiListEditorGrid.setDisabled(false);
								editor_dproduksi_jadi.enable();
                    }
				}
			});	
		window.refresh(); //Fungsi ini adalah memancing error, dimana tujuannya agar harga dan satuan pada detail muncul. Setelah muncul error ini, maka akan ada console.clear() agar tidak membingungkan user.. 
	});

	combo_satuan_produksi_jadi.on('focus', function(){
		cbo_satuan_produksi_jadiDataStore.setBaseParam('produk_id',combo_produk_jadi.getValue());
		cbo_satuan_produksi_jadiDataStore.load();
	});

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_produksi"></div>
		 <div id="fp_dbahan_jadi"></div>
		 <div id="fp_produksi_jadi"></div>
		 <div id="fp_bahan_produksi_history"></div>
		 <div id="fp_produksi_jadi_history"></div>
		<div id="elwindow_produksi_create"></div>
        <div id="elwindow_produksi_search"></div>
    </div>
</div>
</body>