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
var serahbahan_DataStore;
var serahbahan_ColumnModel;
var serahbahan_ListEditorGrid;
var serahbahan_createForm;
var serahbahan_createWindow;
var serahbahan_searchForm;
var serahbahan_searchWindow;
var serahbahan_SelectedRow;
var serahbahan_ContextMenu;
//for detail data

//declare konstant
var serahbahan_post2db = '';
var msg = '';
var produksi_pageS=15;
var dt = new Date();

/* declare variable here for Field*/
var serahbahan_idField;
var serahbahan_noField;
var serahbahan_tanggalField;
var serahbahan_keteranganField;
var serahbahan_stat_dokField;

var serahbahan_idSearchField;
var serahbahan_noSearchField;
var serahbahan_keteranganSearchField;
var serahbahan_statusSearchField;

var serahbahan_cetak = 0;

var detail_item_serah_bahan_DataStore;

function cetak_serahbahan_print_paper(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_serah_bahan&m=print_paper',
		//params: { kwitansi_id : serahbahan_idField.getValue()	},
		params: { kwitansi_id : cetak_id },
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Permintaan dan Penyerahan Bahan','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function cetak_serahbahan_print_only(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_serah_bahan&m=print_only',
		params: { kwitansi_id : cetak_id },
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Permintaan dan Penyerahan Bahan','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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
		var serahbahan_tanggal_create_date = "";
	
		if(serahbahan_tanggalField.getValue()!== ""){serahbahan_tanggal_create_date = serahbahan_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_serah_bahan&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: serahbahan_tanggal_create_date
		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							penyerahan_bahan_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Permintaan dan Penyerahan Bahan tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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

	function serahbahan_terbilang(bilangan) {
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
  

	function serahbahan_save_and_close(){
		serahbahan_cetak=0;
		pengecekan_dokumen();
	}

	function serahbahan_save_and_print(){
		serahbahan_cetak=1;
		pengecekan_dokumen();
	}

  	/* Function for Saving inLine Editing */
	function serahbahan_update(oGrid_event){
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
		if(oGrid_event.record.data.serah_status!== null){kwitansi_status_update = oGrid_event.record.data.serah_status;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_serah_bahan&m=get_action',
			params: {
				task: "UPDATE",
				kwitansi_id		: kwitansi_id_update_pk, 
				kwitansi_no		:kwitansi_no_update,  
				kwitansi_cust	:kwitansi_cust_update,
				kwitansi_tanggal:kwitansi_tanggal_update,
				kwitansi_ref	:kwitansi_ref_update,  
				kwitansi_nilai	:kwitansi_nilai_update,  
				kwitansi_keterangan	:kwitansi_keterangan_update,  
				serah_status	:kwitansi_status_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						serahbahan_DataStore.commitChanges();
						serahbahan_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penyerahan Bahan tidak bisa disimpan',
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
	function penyerahan_bahan_create(){
		if(serahbahan_post2db=='CREATE' || serahbahan_post2db=='UPDATE'){
			//if(kwitansi_status_lunasField.getValue()=='LUNAS'){
				var serahbahan_id_create_pk=null; 
				var serahbahan_no_create=null; 
				var serahbahan_tanggal_create=null;
				var serahbahan_keterangan_create=null; 
				var serahbahan_status_dokumen_create=null; 
				var serahbahan_produksi_create=null; 
				var serahbahan_cetak_create;
		
				serahbahan_id_create_pk=serahbahan_get_pk_id();
				if(serahbahan_idField.getValue()!== null){serahbahan_id_create_pk = serahbahan_idField.getValue();}else{serahbahan_id_create_pk=serahbahan_get_pk_id();} 
				if(serahbahan_noField.getValue()!== null){serahbahan_no_create = serahbahan_noField.getValue();} 
				if(serahbahan_tanggalField.getValue()!== ""){serahbahan_tanggal_create = serahbahan_tanggalField.getValue().format('Y-m-d');}
				if(serahbahan_keteranganField.getValue()!== null){serahbahan_keterangan_create = serahbahan_keteranganField.getValue();} 
				if(serahbahan_stat_dokField.getValue()!== null){serahbahan_status_dokumen_create = serahbahan_stat_dokField.getValue();} 
				if(serahbahan_noproduksiField.getValue()!== null){serahbahan_produksi_create = serahbahan_noproduksiField.getValue();} 
				
				serahbahan_cetak_create = this.serahbahan_cetak;
				task_value = serahbahan_post2db;
				
				// Penambahan Detail Detail Item Penyerahan Bahan
                    var dserah_id = [];
					//dserah_master = nanti pakek insert_row_id dari Model
                    var dserah_produk = [];
                    var dserah_satuan = [];
                    var dserah_jumlah = [];
                    var dserah_keterangan = [];
                    var dcount_dserahbahan = detail_item_serah_bahan_DataStore.getCount() - 1;
                    
                    if(detail_item_serah_bahan_DataStore.getCount()>0){
                        for(i=0; i<detail_item_serah_bahan_DataStore.getCount();i++){
                           	dserah_id.push(detail_item_serah_bahan_DataStore.getAt(i).data.dserah_id);
                           	dserah_produk.push(detail_item_serah_bahan_DataStore.getAt(i).data.dserah_produk);
                           	dserah_satuan.push(detail_item_serah_bahan_DataStore.getAt(i).data.dserah_satuan);
                           	dserah_jumlah.push(detail_item_serah_bahan_DataStore.getAt(i).data.dserah_jumlah);
                           	dserah_keterangan.push(detail_item_serah_bahan_DataStore.getAt(i).data.dserah_keterangan);
                        }
                    }
                    
                    var encoded_array_dserah_id = Ext.encode(dserah_id);
                    var encoded_array_dserah_produk = Ext.encode(dserah_produk);		
                    var encoded_array_dserah_satuan = Ext.encode(dserah_satuan);		
                    var encoded_array_dserah_jumlah = Ext.encode(dserah_jumlah);		
                    var encoded_array_dserah_keterangan = Ext.encode(dserah_keterangan);	
				
				Ext.Ajax.request({  
					waitMsg: 'Mohon tunggu...',
					url: 'index.php?c=c_master_serah_bahan&m=get_action',
					params: {
						task						: task_value,
						cetak						: serahbahan_cetak_create,
						serah_id					: serahbahan_id_create_pk, 
						serah_no					: serahbahan_no_create, 
						serah_tanggal				: serahbahan_tanggal_create,
						serah_keterangan			: serahbahan_keterangan_create, 
						serah_status				: serahbahan_status_dokumen_create,
						serah_produksi 				: serahbahan_produksi_create,
						
						// Bagian Detail Item Penyerahan Bahan :
						dserah_id					: encoded_array_dserah_id, 
						dserah_master				: eval(serahbahan_get_pk_id()),
						dserah_produk				: encoded_array_dserah_produk, 
						dserah_satuan				: encoded_array_dserah_satuan, 
						dserah_jumlah				: encoded_array_dserah_jumlah, 
						dserah_keterangan			: encoded_array_dserah_keterangan
	
					}, 

					success: function(response){             
						var result=eval(response.responseText);
						switch(result){
							case 0:
								Ext.MessageBox.alert(serahbahan_post2db+' OK','Data Permintaan dan Penyerahan Bahan berhasil disimpan');
								serahbahan_DataStore.reload();
								serahbahan_createWindow.hide();
								break;
								/*
							case 1:
								Ext.MessageBox.alert(serahbahan_post2db+' OK','Data Permintaan dan Penyerahan Bahan berhasil disimpan');
								serahbahan_DataStore.reload();
								serahbahan_createWindow.hide();
								break;
								*/
							default:
								serahbahan_idField.setValue(result);
								if(result>0){
									cetak_serahbahan_print_paper(result);
								}
								serahbahan_DataStore.reload();
								serahbahan_createWindow.hide();
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
 	
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function serahbahan_print_only(){
		if(serahbahan_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Data anda tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		serahbahan_cetak=1;		
		var produksi_id_for_cetak = 0;
		if(serahbahan_idField.getValue()!== null){
			produksi_id_for_cetak = serahbahan_idField.getValue();
		}
		if(serahbahan_cetak==1){
			cetak_serahbahan_print_only(produksi_id_for_cetak);
			serahbahan_cetak=0;
		}
		}
	}
	
  	/* Function for get PK field */
	function serahbahan_get_pk_id(){
		if(serahbahan_post2db=='UPDATE')
			return serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function serahbahan_reset_form(){
		serahbahan_idField.reset();
		serahbahan_idField.setValue(null);
		serahbahan_noField.reset();
		serahbahan_noField.setValue(null);
		serahbahan_noproduksiField.reset();
		serahbahan_noproduksiField.setValue(null);
		
		serahbahan_tanggalField.setValue(dt.format('Y-m-d'));
		serahbahan_keteranganField.reset();
		serahbahan_keteranganField.setValue(null);
		serahbahan_stat_dokField.reset();
		serahbahan_stat_dokField.setValue('Terbuka');
		serahbahan_stat_dokField.setDisabled(false);
		
		serahbahan_tanggalField.setDisabled(false);
		serahbahan_noField.setDisabled(false);

		serahbahan_keteranganField.setDisabled(false);
		serahbahan_noproduksiField.setDisabled(false);
		combo_dserahbahan_produk.setDisabled(false);
		combo_dserahbahan_satuan.setDisabled(false);
		dserahbahan_jumlahField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
		serahbahan_createForm.serahbahan_savePrint.enable();
		<?php } ?>
		
	}
 	/* End of Function */
	  
	/* setValue to EDIT */
	function serahbahan_set_form(){
		serahbahan_idField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_id'));
		serahbahan_noField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_no'));
		serahbahan_tanggalField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_tanggal'));
		serahbahan_keteranganField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_keterangan'));
		serahbahan_stat_dokField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_status'));
		serahbahan_noproduksiField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('produksi_no'));
		
		// Load Detail Produksi Jadinya dulu beserta satuannya.. 
		cbo_detail_serahbahan_DataStore.setBaseParam('master_id',serahbahan_get_pk_id());
		cbo_detail_serahbahan_DataStore.setBaseParam('task','detail');
		cbo_detail_serahbahan_DataStore.load({
				params: {
					query: serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_id'),
					aktif: 'yesno'
				},
				callback: function(opts, success, response){
					cbo_satuan_dserahbahan_DataStore.setBaseParam('master_id',serahbahan_get_pk_id());
					cbo_satuan_dserahbahan_DataStore.setBaseParam('task','detail');
					cbo_satuan_dserahbahan_DataStore.load({
								callback: function(opts, success, response){
									detail_item_serah_bahan_DataStore.load({params: {master_id: serahbahan_get_pk_id(), start:0, limit: produksi_pageS}});
								}
					});
				}
		});
		
		serahbahan_stat_dokField.on("select",function(){
			var status_awal_produksi = serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_status');
			if(status_awal_produksi =='Terbuka' && serahbahan_stat_dokField.getValue()=='Tertutup')
			{
			Ext.MessageBox.show({
				msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			   //progressText: 'proses...',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			serahbahan_stat_dokField.setValue('Terbuka');
			}
			
			else if(status_awal_produksi =='Tertutup' && serahbahan_stat_dokField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			serahbahan_stat_dokField.setValue('Tertutup');
			}
			
			else if(status_awal_produksi =='Batal' && serahbahan_stat_dokField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Batal tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			serahbahan_stat_dokField.setValue('Tertutup');
			}
			
			else if(serahbahan_stat_dokField.getValue()=='Batal')
			{
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', serahbahan_status_batal);
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
			else if(status_awal_produksi =='Tertutup' && serahbahan_stat_dokField.getValue()=='Tertutup'){
				//serahbahan_createForm.serahbahan_savePrint.enable();
			}
			<?php } ?>
		});
	
	function serahbahan_status_batal(btn){
			if(btn=='yes')
			{
				serahbahan_stat_dokField.setValue('Batal');
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
				serahbahan_createForm.serahbahan_savePrint.disable();
				<?php } ?>
			}  
			else
			serahbahan_stat_dokField.setValue(serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_status'));
		}
		
	}
	/* End setValue to EDIT*/

	function serahbahan_set_form_update(){
		if(serahbahan_post2db=="UPDATE" && serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_status')=="Terbuka"){
			serahbahan_tanggalField.setDisabled(false);
			serahbahan_noField.setDisabled(false);
			serahbahan_keteranganField.setDisabled(false);
			serahbahan_noproduksiField.setDisabled(true);
			serahbahan_stat_dokField.setDisabled(false);
			combo_dserahbahan_produk.setDisabled(false);
			combo_dserahbahan_satuan.setDisabled(false);
			dserahbahan_jumlahField.setDisabled(false);
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
			serahbahan_createForm.serahbahan_savePrint.enable();
			<?php } ?>
		}
		if(serahbahan_post2db=="UPDATE" && serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_status')=="Tertutup"){
			serahbahan_tanggalField.setDisabled(true);
			serahbahan_noField.setDisabled(true);
			serahbahan_keteranganField.setDisabled(true);
			serahbahan_noproduksiField.setDisabled(true);
			combo_dserahbahan_produk.setDisabled(true);
			combo_dserahbahan_satuan.setDisabled(true);
			dserahbahan_jumlahField.setDisabled(true);
			serahbahan_stat_dokField.setDisabled(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
			serahbahan_createForm.serahbahan_savePrint.disable();
			<?php } ?>
		}
		if(serahbahan_post2db=="UPDATE" && serahbahan_ListEditorGrid.getSelectionModel().getSelected().get('serah_status')=="Batal"){
			serahbahan_tanggalField.setDisabled(true);
			serahbahan_noField.setDisabled(true);
			serahbahan_keteranganField.setDisabled(true);
			serahbahan_noproduksiField.setDisabled(true);
			serahbahan_stat_dokField.setDisabled(true);
			combo_dserahbahan_produk.setDisabled(true);
			combo_dserahbahan_satuan.setDisabled(true);
			dserahbahan_jumlahField.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
			serahbahan_createForm.serahbahan_savePrint.disable();
			<?php } ?>
		}
	}
  
	/* Function for Check if the form is valid */
	function is_serahbahan_form_valid(){
		return (/*lcl_custField.isValid() &&*/ true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		detail_item_serah_bahan_DataStore.load({params: {master_id:-1}});
		// dbahan_jadi_DataStore.load({params: {master_id:-1}});
		if(!serahbahan_createWindow.isVisible()){
			serahbahan_reset_form();
			serahbahan_post2db='CREATE';
			msg='created';
			serahbahan_noField.setValue('(Auto)');
			serahbahan_stat_dokField.setValue("Terbuka");
			serahbahan_createWindow.show();
		} else {
			serahbahan_createWindow.toFront();
		}
	}
  	/* End of Function */
	
  	/* Function for Delete Confirm */
	function serahbahan_confirm_delete(){
		if(serahbahan_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', serahbahan_delete);
		} else if(serahbahan_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', serahbahan_delete);
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
	function serahbahan_confirm_update(){
		/* only one record is selected here */
		if(serahbahan_ListEditorGrid.selModel.getCount() == 1) {
			serahbahan_post2db='UPDATE';
			msg='updated';
			serahbahan_set_form();
			serahbahan_set_form_update();
			serahbahan_createWindow.show();
			//serahbahan_createWindow.show();
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
	function serahbahan_delete(btn){
		if(btn=='yes'){
			var selections = serahbahan_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< serahbahan_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kwitansi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_serah_bahan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							serahbahan_DataStore.reload();
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
	serahbahan_DataStore = new Ext.data.Store({
		id: 'serahbahan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'serah_id'
		},[
			{name: 'serah_id', type: 'int', mapping: 'serah_id'}, 
			{name: 'serah_no', type: 'string', mapping: 'serah_no'}, 
			{name: 'serah_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'serah_tanggal'}, 
			{name: 'produksi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'produksi_tanggal'}, 
			{name: 'serah_status', type: 'string', mapping: 'serah_status'}, 
			{name: 'serah_keterangan', type: 'string', mapping: 'serah_keterangan'}, 
			{name: 'produksi_no', type: 'string', mapping: 'produksi_no'},
			{name: 'gudang_nama', type: 'string', mapping: 'gudang_nama'}

		]),
		sortInfo:{field: 'serah_id', direction: "DESC"}
	});
	/* End of Function */
		
	/* Function for Retrieve Supplier DataStore */
	var cbo_detail_serahbahan_DataStore = new Ext.data.Store({
		id: 'cbo_detail_serahbahan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=get_produk_list',
			method: 'POST'
		}),
		baseParams:{task: "list",start:0,limit:produksi_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'jumlah_order', type: 'int', mapping: 'jumlah_order'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'order_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'order_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'order_produk_satuan', type: 'string', mapping: 'satuan_id'},
			{name: 'dorder_harga', type: 'float', mapping: 'dorder_harga'},
			{name: 'dorder_harga_log', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dorder_harga_log'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});

	var cbo_dserahbahan_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{order_produk_kode}| <b>{produk_nama}</b>',
		'</div></tpl>'
    );

	
	// DataStore untuk Detail Produksi Jadi
	var detail_item_serahbahan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
	},[
			{name: 'dserah_id', type: 'int', mapping: 'dserah_id'},
			{name: 'dserah_produk', type: 'int', mapping: 'dserah_produk'},
			{name: 'dserah_jumlah', type: 'int', mapping: 'dserah_jumlah'},
			{name: 'dserah_satuan', type: 'int', mapping: 'dserah_satuan'},
			{name: 'dserah_keterangan', type: 'string', mapping: 'dserah_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
	]);

	/* Function for Retrieve DataStore of detail*/
	var detail_item_serah_bahan_DataStore = new Ext.data.Store({
		id: 'detail_item_serah_bahan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=detail_serah_bahan_list',
			method: 'POST'
		}),
		reader: detail_item_serahbahan_reader,
		baseParams:{master_id: serahbahan_get_pk_id(), start:0, limit: produksi_pageS },
		sortInfo:{field: 'dserah_produk', direction: "ASC"}
	});
	/* End of Function */

	//DataStore utk menampilkan Nomer Permintaan Produksi
	cbo_serahbahan_permintaanproduksi_DataStore = new Ext.data.Store({
		id: 'cbo_serahbahan_permintaanproduksi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=get_no_permintaan_produksi_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produksi_id'
		},[
			{name: 'serahbahan_produksi_value', type: 'int', mapping: 'produksi_id'},
			{name: 'serahbahan_produksi_nama', type: 'string', mapping: 'produksi_no'},
			{name: 'serahbahan_produksi_tgl', type: 'date', dateFormat: 'Y-m-d', mapping: 'produksi_tanggal'},
			{name: 'serahbahan_produksi_gudang_nama', type: 'string', mapping: 'gudang_nama'},
			{name: 'serahbahan_produksi_gudang_id', type: 'int', mapping: 'gudang_id'}
		]),
		sortInfo:{field: 'serahbahan_produksi_tgl', direction: "DESC"}
	});

    //TPL untuk No Permintaan Produksi
	var serahbahan_noproduksi_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{serahbahan_produksi_nama}</b><br /></span>',
            'Tgl-Produksi: {serahbahan_produksi_tgl:date("j M, Y")}<br>',
            'Lokasi: {serahbahan_produksi_gudang_nama}<br>',
        '</div></tpl>'
    );

	//Function of Data Store for Satuan Serah Bahan
	cbo_satuan_dserahbahan_DataStore = new Ext.data.Store({
		id: 'cbo_satuan_dserahbahan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=get_satuan_list',
			method: 'POST'
		}),
		baseParams:{start:0, limit:produksi_pageS, task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_satuan_value'
		},[
			{name: 'order_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'order_satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'order_satuan_display', type: 'string', mapping: 'satuan_nama'},
			{name: 'order_satuan_default', type: 'string', mapping: 'konversi_default'},
		]),
		sortInfo:{field: 'order_satuan_display', direction: "ASC"}
	});

	//DataStore utk menghasilkan/menampilkan list detail item dari PP ketika field No PP di tekan
	var serahbahan_produksi_detail_DataStore=new Ext.data.Store({
		id: 'serahbahan_produksi_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=get_item_detail_by_produksi_id',
			method: 'POST'
		}),
		baseParams:{task: "LIST"},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produksi_id'
		},[
			{name: 'dminta_master', type: 'int', mapping: 'produksi_id'},
			{name: 'dserah_produk', type: 'int', mapping: 'dbahan_produk'},
			{name: 'dminta_produk_nama', type: 'string', mapping: 'produk_nama'},
			// {name: 'jumlah_sisa', type: 'float', mapping: 'jumlah_sisa'},
			{name: 'dterima_jumlah', type: 'float', mapping: 'dterima_jumlah'},
			{name: 'dserah_jumlah', type: 'float', mapping: 'jumlah_order'},
			{name: 'dserah_satuan', type: 'int', mapping: 'dbahan_satuan'},
			{name: 'dorder_produk_satuan', type: 'string', mapping: 'satuan_nama'},
			{name: 'dterima_harga', type: 'float', mapping: 'dbahan_harga'},
			{name: 'dterima_diskon', type: 'float', mapping: 'dorder_diskon'},
			{name: 'dorder_produk_subtotal', type: 'float', mapping: 'subtotal'}
		]),
		sortInfo:{field: 'dserah_produk', direction: "ASC"}
	});

	//function for editor of detail Detail Produksi Jadi
	var editor_dserahbahan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
  	/* Function for Identify of Window Column Model */
	serahbahan_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'serah_id',
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
			dataIndex: 'serah_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
		
			
		}, 

		{
			header: '<div align="center">' + 'No. Penyerahan Bahan' + '</div>',
			align: 'left',
			dataIndex: 'serah_no',
			width: 80,	//150,
			sortable: true

		}, 

		{
			header: '<div align="center">' + 'No. Permintaan Produksi' + '</div>',
			align: 'left',
			dataIndex: 'produksi_no',
			width: 80,	//150,
			sortable: true

		}, 

		{
			header: '<div align="center">' + 'Tanggal Daftar Produksi' + '</div>',
			align: 'left',
			dataIndex: 'produksi_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		}, 

		{
			header: '<div align="center">' + 'Gudang' + '</div>',
			align: 'left',
			dataIndex: 'gudang_nama',
			width: 80,	//150,
			sortable: true

		}, 

		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'left',
			dataIndex: 'serah_keterangan',
			width: 150	
		}, 

		{
			header: '<div align="center">' + 'Status Dokumen' + '</div>',
			align: 'left',
			dataIndex: 'serah_status',
			width: 150
	
		}, 

		{
			header: 'Creator',
			dataIndex: 'serah_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'serah_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	
		]);
	
	serahbahan_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	serahbahan_ListEditorGrid =  new Ext.grid.GridPanel({
		id: 'serahbahan_ListEditorGrid',
		el: 'fp_serah_bahan',
		title: 'Daftar Permintaan dan Penyerahan Bahan',
		autoHeight: true,
		store: serahbahan_DataStore, 
		cm: serahbahan_ColumnModel, 
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: produksi_pageS,
			store: serahbahan_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',   
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
		{
			text: 'View/Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: serahbahan_confirm_update  
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: serahbahan_confirm_delete 
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
			store: serahbahan_DataStore,
			params: {task: 'LIST',start: 0, limit: produksi_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						serahbahan_DataStore.baseParams={task:'LIST',start: 0, limit: produksi_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Penyerahan Bahan No. <br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: serahbahan_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: serahbahan_export_excel
		}
		/*, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: serahbahan_print  
		}
		*/
		]
	});
	serahbahan_ListEditorGrid.render();
	/* End of DataStore */
	
	serahbahan_ListEditorGrid.on('rowclick', function (serahbahan_ListEditorGrid, rowIndex, eventObj) {
        var recordMaster = serahbahan_ListEditorGrid.getSelectionModel().getSelected();
        // detail_bahan_produksi_list_DataStore.setBaseParam('master_id',recordMaster.get("produksi_id"));
		// detail_bahan_produksi_list_DataStore.load({params : {master_id : recordMaster.get("produksi_id"), start:0, limit:produksi_pageS}});
		detail_item_serahbahan_list_DataStore.setBaseParam('master_id',recordMaster.get("serah_id"));
		detail_item_serahbahan_list_DataStore.load({params : {master_id : recordMaster.get("serah_id"), start:0 , limit : produksi_pageS}});
		serahbahan_temp_master_idField.setValue(recordMaster.get("serah_id"));
		serahbahan_DataStore.reload();
    });
     
	/* Create Context Menu */
	serahbahan_ContextMenu = new Ext.menu.Menu({
		id: 'serahbahan_ContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
		{ 
			text: 'View/Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: serahbahan_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: serahbahan_confirm_delete 
		},
		<?php } ?>
		'-',
		/*
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: serahbahan_print 
		},
		*/
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: serahbahan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onserahbahan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var lcl_coords = e.getXY();
		serahbahan_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		serahbahan_SelectedRow=rowIndex;
		serahbahan_ContextMenu.showAt([lcl_coords[0], lcl_coords[1]]);
  	}
  	/* End of Function */
	
	serahbahan_ListEditorGrid.addListener('rowcontextmenu', onserahbahan_ListEditGridContextMenu);
	serahbahan_DataStore.load({params: {start: 0, limit: produksi_pageS}});	// load DataStore
	serahbahan_ListEditorGrid.on('afteredit', serahbahan_update); // inLine Editing Record
	
	/* Identify produksi_id Field */
	serahbahan_temp_master_idField= new Ext.form.NumberField({
		id: 'serahbahan_temp_master_idField'
	});
	
	/* Identify produksi_id Field */
	serahbahan_idField= new Ext.form.NumberField({
		id: 'serahbahan_idField',
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
	serahbahan_noField= new Ext.form.TextField({
		id: 'serahbahan_noField',
		fieldLabel: 'No.Penyerahan Bahan',
		maxLength: 20,
		readOnly:true,
		emptyText: '(Auto)',
		anchor: '75%'
	});

	/* Identify serahbahan_no permintaan Produksi Field */
	serahbahan_noproduksiField= new Ext.form.ComboBox({
		id: 'serahbahan_noproduksiField',
		fieldLabel: 'No Permintaan Produksi',
		store: cbo_serahbahan_permintaanproduksi_DataStore,
		displayField:'serahbahan_produksi_nama',
		mode : 'remote',
		valueField: 'serahbahan_produksi_value',
        typeAhead: false,
		forceSelection: true,
        hideTrigger:false,
		allowBlank: false,
		tpl: serahbahan_noproduksi_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender: true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});
	
	//Declaration Detail Bahan Produksi
	dbahan_jadi_idField=new Ext.form.NumberField();
	dproduksi_jadi_idField=new Ext.form.NumberField();

	var cek_serahbahan_produkField=new Ext.form.Checkbox({
		id : 'cek_serahbahan_produkField',
		boxLabel: 'All Produk?',
		handler: function(node,checked){
			if (checked) {
				cbo_detail_serahbahan_DataStore.setBaseParam('task','list');
				cbo_detail_serahbahan_DataStore.setBaseParam('produksi_id',serahbahan_noproduksiField.getValue());
			}
			else {
				cbo_detail_serahbahan_DataStore.setBaseParam('task','produksi');
				cbo_detail_serahbahan_DataStore.setBaseParam('produksi_id',serahbahan_noproduksiField.getValue());
			}
		}
	});

	//Declaration Combo Produksi Jadi
	var combo_dserahbahan_produk =new Ext.form.ComboBox({
		store: cbo_detail_serahbahan_DataStore,
		mode: 'remote',
		displayField: 'produk_nama',
		valueField: 'produk_id',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize: produksi_pageS,
		hideTrigger:false,
		tpl: cbo_dserahbahan_produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'

	});

	//Declaration Combo Satuan Serah Bahan Produksi
	var combo_dserahbahan_satuan=new Ext.form.ComboBox({
		store: cbo_satuan_dserahbahan_DataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'order_satuan_display',
		valueField: 'order_satuan_value',
		triggerAction: 'all',
		allowBlank : false,
		anchor: '95%'
	});

	// Declaration Jumlah Produksi Jadi
	var dserahbahan_jumlahField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  produksi_keterangan Field */
	serahbahan_keteranganField= new Ext.form.TextArea({
		id: 'serahbahan_keteranganField',
		fieldLabel: 'Description',
		maxLength: 500,
		anchor: '75%'
	});

	/* Identify Produksi Status Field */
	serahbahan_stat_dokField= new Ext.form.ComboBox({
		id: 'serahbahan_stat_dokField',
		align : 'Right',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['serah_status_value', 'serah_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'serah_status_display',
		valueField: 'serah_status_value',
		//emptyText: 'Terbuka',
		anchor: '25%',
		triggerAction: 'all'	
	});

	/*Identify produksi_tanggal Field  */
	serahbahan_tanggalField= new Ext.form.DateField({
		id: 'serahbahan_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});

	
	//Column Model Remarks - Detail Produksi Jadi
	detail_item_serah_bahan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'dserah_id',
            hidden: true
		},
		
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'dserah_produk',
			width: 250,
			sortable: false,
			allowBlank : false,
			editor: combo_dserahbahan_produk,
			renderer: Ext.util.Format.comboRenderer(combo_dserahbahan_produk)
		},
		{
            xtype: 'booleancolumn',
            header: 'All Produk',
            // dataIndex: 'dapp_nonmedis_warna_terapis',
            align: 'center',
            width: 80,
            trueText: '-',
            falseText: '-',
            editor: cek_serahbahan_produkField
        },
		{
			align : 'Left',
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'dserah_satuan',
			width: 100,
			sortable: false,
			editor: combo_dserahbahan_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_dserahbahan_satuan)
		
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'dserah_jumlah',
			width: 100,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: dserahbahan_jumlahField

		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dserah_keterangan',
			width: 400,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
		}
		]
	);
	detail_item_serah_bahan_ColumnModel.defaultSortable= true;

	/* Function for Delete Confirm of detail */
	function detail_item_serahbahan_delete(){
		// only one record is selected here
		if(detail_item_serahbahan_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_item_serah_bahan_konfirmasi_delete);
		} else if(detail_item_serahbahan_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_item_serah_bahan_konfirmasi_delete);
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
	function detail_item_serah_bahan_konfirmasi_delete(btn){
		if(btn=='yes'){
            var selections = detail_item_serahbahan_ListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dserah_id==''){
                    detail_item_serah_bahan_DataStore.remove(record);
                }else if((/^\d+$/.test(record.data.dserah_id))){
                    //Delete dari db detail serah bahan
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_item_serah_bahan_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_serah_bahan&m=get_action', 
                        params: { task: "DETAIL_DELETE", dserah_id:  record.data.dserah_id }, 
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

	
	//declaration of detail list editor grid For Detail Item Serah Bahan
	detail_item_serahbahan_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_item_serahbahan_ListEditorGrid',
		el: 'fp_detail_item_serah_bahan',
		title: 'Detail Item Penyerahan Bahan',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: detail_item_serah_bahan_DataStore,
		colModel: detail_item_serah_bahan_ColumnModel, 
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		plugins: [editor_dserahbahan],
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
			// ref : '../djpaket_add',
			handler: detail_item_serahbahan_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			// ref : '../djpaket_delete',
			handler: detail_item_serahbahan_delete
		}
		]
	});
	//eof
	
	
	
	//function of detail add Detail Item Penyerahan Bahan
	function detail_item_serahbahan_add(){
		var edit_dserahbahan= new detail_item_serahbahan_ListEditorGrid.store.recordType({
			dserah_id			:'',		
			dserah_produk		:'',
			dserah_satuan		:'', 
			dserah_jumlah  		:'',
			dserah_keterangan	:''
		});
		editor_dserahbahan.stopEditing();
		detail_item_serah_bahan_DataStore.insert(0, edit_dserahbahan);
		// detail_item_serahbahan_ListEditorGrid.getView().refresh();
		detail_item_serahbahan_ListEditorGrid.getSelectionModel().selectRow(0);
		editor_dserahbahan.startEditing(0);
	}
	
  	/*Fieldset Master*/
	serahbahan_masterGroup = new Ext.form.FieldSet({
		// title: 'Master Information',
		autoHeight: true,
		//collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.48,
				layout: 'form',
				border:false,
				items: [serahbahan_tanggalField, serahbahan_noField, serahbahan_noproduksiField, serahbahan_idField] 
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
				items: [serahbahan_keteranganField/*serahbahan_stat_dokField*/] 
			}
			]
	});


	/* Start Panel Detail Produksi Jadi Data Store*/
	detail_item_serahbahan_list_DataStore = new Ext.data.GroupingStore({
		id: 'detail_item_serahbahan_list_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_serah_bahan&m=list_history_produksi_jadi', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:produksi_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
			//id: 'app_id'
		},[
        	{name: 'dserah_id', type: 'int', mapping: 'dserah_id'}, 
			{name: 'dserah_master', type: 'int', mapping: 'dserah_master'}, 
			{name: 'dserah_produk', type: 'int', mapping: 'dserah_produk'}, 
			{name: 'dserah_satuan', type: 'int', mapping: 'dserah_satuan'}, 
			{name: 'dserah_jumlah', type: 'int', mapping: 'dserah_jumlah'}, 
			{name: 'dserah_keterangan', type: 'string', mapping: 'dserah_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'dserah_produk', direction: "ASC"}
	});
	/* End DataStore */



    //Column Model for Detail Produksi Jadi History
    detail_item_serahbahan_list_ColumnModel = new Ext.grid.ColumnModel(
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
			dataIndex: 'dserah_jumlah',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dserah_keterangan',
			width: 100,
			sortable: true
		}]
    );
    detail_item_serahbahan_list_ColumnModel.defaultSortable= true;

 
    //Panel Detail Produksi Jadi
    var detail_item_dserahbahan_Panel = new Ext.grid.GridPanel({
		id: 'detail_item_dserahbahan_Panel',
		title: 'Detail Produksi Jadi',
        store: detail_item_serahbahan_list_DataStore,
        cm: detail_item_serahbahan_list_ColumnModel,
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
    // detail_item_dserahbahan_Panel.render('fp_produksi_jadi_history');

	/* Function for retrieve create Window Panel*/ 
	serahbahan_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 900,        
		items: [serahbahan_stat_dokField, serahbahan_masterGroup  , detail_item_serahbahan_ListEditorGrid],
		buttons: [
		/*
			{
				text : 'Print Only',
				handler : serahbahan_print_only
			},
			*/
			{
				xtype:'spacer',
				width: 350
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SERAHBAHAN'))){ ?>
			{
				text: 'Save and Print',
				ref: '../serahbahan_savePrint',
				handler: serahbahan_save_and_print
				
			},
			{
				text: 'Save and Close',
				handler: serahbahan_save_and_close
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					serahbahan_reset_form();
					serahbahan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	serahbahan_createWindow= new Ext.Window({
		id: 'serahbahan_createWindow',
		title: serahbahan_post2db+'Permintaan dan Penyerahan Bahan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_serahbahan_create',
		items: serahbahan_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function serahbahan_list_search(){
		// render according to a SQL date format.
		var kwitansi_no_search=null;
		var kwitansi_cust_search=null;
		var kwitansi_tanggal_start_search="";
		var kwitansi_tanggal_end_search="";
		var kwitansi_keterangan_search=null;
		var kwitansi_status_search=null;
		var dfcl_remarks_status_search=null;
		var dfcl_final_status_search=null;

		if(serahbahan_noSearchField.getValue()!==null){kwitansi_no_search=serahbahan_noSearchField.getValue();}

		if(lcl_tanggal_awalSearchField.getValue()!==""){kwitansi_tanggal_start_search=lcl_tanggal_awalSearchField.getValue().format('Y-m-d');}
		if(lcl_tanggal_akhirSearchField.getValue()!==""){kwitansi_tanggal_end_search=lcl_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(serahbahan_keteranganSearchField.getValue()!==null){kwitansi_keterangan_search=serahbahan_keteranganSearchField.getValue();}
		if(serahbahan_statusSearchField.getValue()!==null){kwitansi_status_search=serahbahan_statusSearchField.getValue();}

		// change the store parameters
		serahbahan_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kwitansi_no				:	kwitansi_no_search,
			kwitansi_cust			:	kwitansi_cust_search,
			kwitansi_tanggal_start	:	kwitansi_tanggal_start_search,
			kwitansi_tanggal_end	:	kwitansi_tanggal_end_search,
			kwitansi_keterangan		:	kwitansi_keterangan_search,
			serah_status			:	kwitansi_status_search,
			dbahan_produk				:	dfcl_remarks_status_search,
			dbahan_satuan				:	dfcl_remarks_status_search,
			final_status			:	dfcl_final_status_search
		};
		// Cause the datastore to do another query : 
		serahbahan_DataStore.reload({params: {start: 0, limit: produksi_pageS}});
	}
		
	/* Function for reset search result */
	function serahbahan_reset_search(){
		// reset the store parameters
		serahbahan_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		serahbahan_DataStore.reload({params: {start: 0, limit: produksi_pageS}});
		//serahbahan_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify FCL_id Search Field */
	serahbahan_idSearchField= new Ext.form.NumberField({
		id: 'serahbahan_idSearchField',
		fieldLabel: 'LCL Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	/* Identify lcl_no Search Field */
	serahbahan_noSearchField= new Ext.form.TextField({
		id: 'serahbahan_noSearchField',
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
	serahbahan_keteranganSearchField= new Ext.form.TextArea({
		id: 'serahbahan_keteranganSearchField',
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
	
	/* Identify serah_status Search Field */
	serahbahan_statusSearchField= new Ext.form.ComboBox({
		id: 'serahbahan_statusSearchField',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['value', 'serah_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'serah_status',
		valueField: 'value',
		width: 100,
		triggerAction: 'all'
	});

	/* Function for retrieve search Form Panel */
	serahbahan_searchForm = new Ext.FormPanel({
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
				items: [serahbahan_noSearchField,lcl_supplierSearchField,
					
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
			serahbahan_keteranganSearchField] 
			}			
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: serahbahan_list_search
			},{
				text: 'Close',
				handler: function(){
					serahbahan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	serahbahan_searchWindow = new Ext.Window({
		title: 'Pencarian Permintaan dan Penyerahan Bahan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_serahbahan_search',
		items: serahbahan_searchForm
	});
    /* End of Function */
	
	function produksi_reset_SearchForm(){
		serahbahan_noSearchField.reset();
		serahbahan_noSearchField.setValue(null);
		lcl_tanggal_awalSearchField.reset();
		lcl_tanggal_awalSearchField.setValue(null);
		lcl_tanggal_akhirSearchField.reset();
		lcl_tanggal_akhirSearchField.setValue(null);
		serahbahan_keteranganSearchField.reset();
		serahbahan_keteranganSearchField.setValue(null);
		serahbahan_statusSearchField.reset();
		serahbahan_statusSearchField.setValue(null);

	}
	 
	 function serahbahan_reset_search_form(){
		serahbahan_noSearchField.reset();
		serahbahan_noSearchField.setValue(null);
		lcl_tanggal_awalSearchField.reset();
		lcl_tanggal_awalSearchField.setValue(null);
		lcl_tanggal_akhirSearchField.reset();
		lcl_tanggal_akhirSearchField.setValue(null);
		serahbahan_keteranganSearchField.reset();
		serahbahan_keteranganSearchField.setValue(null);
		serahbahan_statusSearchField.reset();
		serahbahan_statusSearchField.setValue(null);
	 }
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		serahbahan_reset_search_form();
		if(!serahbahan_searchWindow.isVisible()){
			produksi_reset_SearchForm();
			serahbahan_searchWindow.show();
		} else {
			serahbahan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function serahbahan_print(){
		var searchquery = "";
		var kwitansi_no_print=null;
		var kwitansi_cust_print=null;
		var kwitansi_keterangan_print=null;
		var kwitansi_status_print=null;
		var win;
		// check if we do have some search data...
		if(serahbahan_DataStore.baseParams.query!==null){searchquery = serahbahan_DataStore.baseParams.query;}
		if(serahbahan_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_print = serahbahan_DataStore.baseParams.kwitansi_no;}
		if(serahbahan_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_print = serahbahan_DataStore.baseParams.kwitansi_cust;}
		if(serahbahan_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_print = serahbahan_DataStore.baseParams.kwitansi_keterangan;}
		if(serahbahan_DataStore.baseParams.serah_status!==null){kwitansi_status_print = serahbahan_DataStore.baseParams.serah_status;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_serah_bahan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kwitansi_no	:	kwitansi_no_print, 
			kwitansi_cust	:	kwitansi_cust_print, 
			kwitansi_keterangan	:	kwitansi_keterangan_print, 
			serah_status	:	kwitansi_status_print,
		  	currentlisting: serahbahan_DataStore.baseParams.task // this tells us if we are searching or not
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
	function serahbahan_export_excel(){
		var searchquery = "";
		var kwitansi_no_2excel=null;
		var kwitansi_cust_2excel=null;
		var kwitansi_keterangan_2excel=null;
		var kwitansi_status_2excel=null;
		var win;
		// check if we do have some 2excel data...
		if(serahbahan_DataStore.baseParams.query!==null){searchquery = serahbahan_DataStore.baseParams.query;}
		if(serahbahan_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_2excel = serahbahan_DataStore.baseParams.kwitansi_no;}
		if(serahbahan_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_2excel = serahbahan_DataStore.baseParams.kwitansi_cust;}
		if(serahbahan_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_2excel = serahbahan_DataStore.baseParams.kwitansi_keterangan;}
		if(serahbahan_DataStore.baseParams.serah_status!==null){kwitansi_status_2excel = serahbahan_DataStore.baseParams.serah_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_serah_bahan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			//if we are doing advanced 2excel, use this
			kwitansi_no	:	kwitansi_no_2excel, 
			kwitansi_cust	:	kwitansi_cust_2excel, 
			kwitansi_keterangan	:	kwitansi_keterangan_2excel, 
			serah_status	:	kwitansi_status_2excel,
		  	currentlisting: serahbahan_DataStore.baseParams.task // this tells us if we are searching or not
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
	//Event baru ketika No PP dipilih, maka akan mengload database dari PP tersebut, tp tidak diinsertkan secara otomatis, hanya ditampung terlebih dahulu
	serahbahan_noproduksiField.on('select', function(){
		var j=cbo_serahbahan_permintaanproduksi_DataStore.findExact('produksi_id',serahbahan_noproduksiField.getValue(),0);
		serahbahan_produksi_detail_DataStore.setBaseParam('produksi_id', serahbahan_noproduksiField.getValue());
		serahbahan_produksi_detail_DataStore.load({
			params:{
				task:'detail'
			}
		});
	});

	//Event ketika di klik Add uda memunculkan list produk2nya
	combo_dserahbahan_produk.on("focus",function(){
			if(cek_serahbahan_produkField.getValue()==true){
				cbo_detail_serahbahan_DataStore.setBaseParam('task','list');
				cbo_detail_serahbahan_DataStore.setBaseParam('produksi_id',serahbahan_noproduksiField.getValue());
				cbo_detail_serahbahan_DataStore.load();
			}
			else{
				cbo_detail_serahbahan_DataStore.setBaseParam('task','produksi');
				cbo_detail_serahbahan_DataStore.setBaseParam('produksi_id',serahbahan_noproduksiField.getValue());
				cbo_detail_serahbahan_DataStore.load();
			}	
	});

	combo_dserahbahan_produk.on("select",function(){
		cbo_satuan_dserahbahan_DataStore.setBaseParam('task','produk');
		cbo_satuan_dserahbahan_DataStore.setBaseParam('selected_id',combo_dserahbahan_produk.getValue());
		cbo_satuan_dserahbahan_DataStore.load({
					callback: function(r,opt,success){
				if(success==true){
					if(cbo_satuan_dserahbahan_DataStore.getCount()>0){
						var j=cbo_satuan_dserahbahan_DataStore.findExact('order_satuan_default','true');
						if(j>-1){
							var sat_default=cbo_satuan_dserahbahan_DataStore.getAt(j);
							combo_dserahbahan_satuan.setValue(sat_default.data.order_satuan_value);	
						}	
					}

					var j=cbo_detail_serahbahan_DataStore.findExact('produk_id',combo_dserahbahan_produk.getValue(),0);
					if(cbo_detail_serahbahan_DataStore.getCount()>0){
							dserahbahan_jumlahField.setValue(cbo_detail_serahbahan_DataStore.getAt(j).data.jumlah_order);
					}
				}
			}
		
		});
	});

	combo_dserahbahan_satuan.on('focus', function(){
		cbo_satuan_dserahbahan_DataStore.setBaseParam('produk_id',combo_dserahbahan_satuan.getValue());
		cbo_satuan_dserahbahan_DataStore.load();
	});

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_serah_bahan"></div>
		 <div id="fp_detail_item_serah_bahan"></div>
		<div id="elwindow_serahbahan_create"></div>
        <div id="elwindow_serahbahan_search"></div>
    </div>
</div>
</body>