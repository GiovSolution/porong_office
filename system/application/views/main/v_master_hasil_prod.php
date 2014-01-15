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
var hasilprod_DataStore;
var hasilprod_ColumnModel;
var hasilprod_ListEditorGrid;
var hasilprod_createForm;
var hasilprod_createWindow;
var hasilprod_searchForm;
var hasilprod_searchWindow;
var hasilprod_SelectedRow;
var hasilprod_ContextMenu;
//for detail data

//declare konstant
var hasilprod_post2db = '';
var msg = '';
var hasilprod_pageS=15;
var dt = new Date();

/*declare variable here for Field*/
var hasilprod_idField;
var hasilprod_noField;
var hasilprod_tanggalField;
var hasilprod_keteranganField;
var hasilprod_stat_dokField;

var hasilprod_idSearchField;
var hasilprod_noSearchField;
var hasilprod_keteranganSearchField;
var hasilprod_statusSearchField;

var hasilprod_cetak = 0;

var detail_hasilprod_DataStore;

function cetak_hasilprod_print_paper(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_hasil_prod&m=print_paper',
		//params: { kwitansi_id : hasilprod_idField.getValue()	},
		params: { kwitansi_id : cetak_id },
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Hasil Produksi','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
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

function cetak_hasilprod_print_only(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_hasil_prod&m=print_only',
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
	
		if(hasilprod_tanggalField.getValue()!== ""){serahbahan_tanggal_create_date = hasilprod_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_hasil_prod&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: serahbahan_tanggal_create_date
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							hasilprod_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Hasil Produksi tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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

	function hasilprod_terbilang(bilangan) {
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
  

	function hasilprod_save_and_close(){
		hasilprod_cetak=0;
		pengecekan_dokumen();
	}

	function hasilprod_save_and_print(){
		hasilprod_cetak=1;
		pengecekan_dokumen();
	}

  	/* Function for Saving inLine Editing */
	function hasilprod_update(oGrid_event){
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
		if(oGrid_event.record.data.hasil_status!== null){kwitansi_status_update = oGrid_event.record.data.hasil_status;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_hasil_prod&m=get_action',
			params: {
				task: "UPDATE",
				kwitansi_id		: kwitansi_id_update_pk, 
				kwitansi_no		:kwitansi_no_update,  
				kwitansi_cust	:kwitansi_cust_update,
				kwitansi_tanggal:kwitansi_tanggal_update,
				kwitansi_ref	:kwitansi_ref_update,  
				kwitansi_nilai	:kwitansi_nilai_update,  
				kwitansi_keterangan	:kwitansi_keterangan_update,  
				hasil_status	:kwitansi_status_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						hasilprod_DataStore.commitChanges();
						hasilprod_DataStore.reload();
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
	function hasilprod_create(){
		if(hasilprod_post2db=='CREATE' || hasilprod_post2db=='UPDATE'){
			//if(kwitansi_status_lunasField.getValue()=='LUNAS'){
				var hasilprod_id_create_pk=null; 
				var hasilprod_no_create=null; 
				var hasilprod_tanggal_create=null;
				var hasilprod_keterangan_create=null; 
				var hasilprod_status_dok_create=null; 
				var hasilprod_produksi_create=null; 
				var hasilprod_cetak_create;
		
				hasilprod_id_create_pk=hasilprod_get_pk_id();
				if(hasilprod_idField.getValue()!== null){hasilprod_id_create_pk = hasilprod_idField.getValue();}else{hasilprod_id_create_pk=hasilprod_get_pk_id();} 
				if(hasilprod_noField.getValue()!== null){hasilprod_no_create = hasilprod_noField.getValue();} 
				if(hasilprod_tanggalField.getValue()!== ""){hasilprod_tanggal_create = hasilprod_tanggalField.getValue().format('Y-m-d');}
				if(hasilprod_keteranganField.getValue()!== null){hasilprod_keterangan_create = hasilprod_keteranganField.getValue();} 
				if(hasilprod_stat_dokField.getValue()!== null){hasilprod_status_dok_create = hasilprod_stat_dokField.getValue();} 
				if(hasilprod_noproduksiField.getValue()!== null){hasilprod_produksi_create = hasilprod_noproduksiField.getValue();} 
				
				hasilprod_cetak_create = this.hasilprod_cetak;
				task_value = hasilprod_post2db;
				
				// Penambahan Detail Detail Hasil Produksi
                    var dhasil_id = [];
					//dhasil_master = nanti pakek insert_row_id dari Model
                    var dhasil_produk = [];
                    var dhasil_satuan = [];
                    var dhasil_jumlah = [];
                    var dhasil_keterangan = [];
                    var dcount_dserahbahan = detail_hasilprod_DataStore.getCount() - 1;
                    
                    if(detail_hasilprod_DataStore.getCount()>0){
                        for(i=0; i<detail_hasilprod_DataStore.getCount();i++){
                           	dhasil_id.push(detail_hasilprod_DataStore.getAt(i).data.dhasil_id);
                           	dhasil_produk.push(detail_hasilprod_DataStore.getAt(i).data.dhasil_produk);
                           	dhasil_satuan.push(detail_hasilprod_DataStore.getAt(i).data.dhasil_satuan);
                           	dhasil_jumlah.push(detail_hasilprod_DataStore.getAt(i).data.dhasil_jumlah);
                           	dhasil_keterangan.push(detail_hasilprod_DataStore.getAt(i).data.dhasil_keterangan);
                        }
                    }
                    
                    var encoded_array_dhasil_id = Ext.encode(dhasil_id);
                    var encoded_array_dhasil_produk = Ext.encode(dhasil_produk);		
                    var encoded_array_dhasil_satuan = Ext.encode(dhasil_satuan);		
                    var encoded_array_dhasil_jumlah = Ext.encode(dhasil_jumlah);		
                    var encoded_array_dhasil_keterangan = Ext.encode(dhasil_keterangan);	
				
				Ext.Ajax.request({  
					waitMsg: 'Mohon tunggu...',
					url: 'index.php?c=c_master_hasil_prod&m=get_action',
					params: {
						task						: task_value,
						cetak						: hasilprod_cetak_create,
						hasil_id					: hasilprod_id_create_pk, 
						hasil_no					: hasilprod_no_create, 
						hasil_tanggal				: hasilprod_tanggal_create,
						hasil_keterangan			: hasilprod_keterangan_create, 
						hasil_status				: hasilprod_status_dok_create,
						hasil_produksi 				: hasilprod_produksi_create,
						
						// Bagian Detail Item Penyerahan Bahan :
						dhasil_id					: encoded_array_dhasil_id, 
						dhasil_master				: eval(hasilprod_get_pk_id()),
						dhasil_produk				: encoded_array_dhasil_produk, 
						dhasil_satuan				: encoded_array_dhasil_satuan, 
						dhasil_jumlah				: encoded_array_dhasil_jumlah, 
						dhasil_keterangan			: encoded_array_dhasil_keterangan
					}, 

					success: function(response){             
						var result=eval(response.responseText);
						switch(result){
							case 0:
								Ext.MessageBox.alert(hasilprod_post2db+' OK','Data Hasil Produksi berhasil disimpan');
								hasilprod_DataStore.reload();
								hasilprod_createWindow.hide();
								break;
								/*
							case 1:
								Ext.MessageBox.alert(hasilprod_post2db+' OK','Data Permintaan dan Penyerahan Bahan berhasil disimpan');
								hasilprod_DataStore.reload();
								hasilprod_createWindow.hide();
								break;
								*/
							default:
								hasilprod_idField.setValue(result);
								if(result>0){
									cetak_hasilprod_print_paper(result);
								}
								hasilprod_DataStore.reload();
								hasilprod_createWindow.hide();
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
	function hasilprod_print_only(){
		if(hasilprod_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Data anda tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		hasilprod_cetak=1;		
		var produksi_id_for_cetak = 0;
		if(hasilprod_idField.getValue()!== null){
			produksi_id_for_cetak = hasilprod_idField.getValue();
		}
		if(hasilprod_cetak==1){
			cetak_hasilprod_print_only(produksi_id_for_cetak);
			hasilprod_cetak=0;
		}
		}
	}
	
  	/* Function for get PK field */
	function hasilprod_get_pk_id(){
		if(hasilprod_post2db=='UPDATE')
			return hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function hasilprod_reset_form(){
		hasilprod_idField.reset();
		hasilprod_idField.setValue(null);
		hasilprod_noField.reset();
		hasilprod_noField.setValue(null);
		hasilprod_noproduksiField.reset();
		hasilprod_noproduksiField.setValue(null);
		
		hasilprod_tanggalField.setValue(dt.format('Y-m-d'));
		hasilprod_keteranganField.reset();
		hasilprod_keteranganField.setValue(null);
		hasilprod_stat_dokField.reset();
		hasilprod_stat_dokField.setValue('Terbuka');
		hasilprod_stat_dokField.setDisabled(false);
		
		hasilprod_tanggalField.setDisabled(false);
		hasilprod_noField.setDisabled(false);

		hasilprod_keteranganField.setDisabled(false);
		hasilprod_noproduksiField.setDisabled(false);
		combo_dhasilprod_produk.setDisabled(false);
		combo_dhasilprod_satuan.setDisabled(false);
		dhasilprod_jumlahField.setDisabled(false);
		dhasilprod_jumlah_orderField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
		hasilprod_createForm.hasilprod_savePrint.enable();
		<?php } ?>
		
	}
 	/* End of Function */
	  
	/* setValue to EDIT */
	function hasilprod_set_form(){
		hasilprod_idField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_id'));
		hasilprod_noField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_no'));
		hasilprod_tanggalField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_tanggal'));
		hasilprod_keteranganField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_keterangan'));
		hasilprod_stat_dokField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_status'));
		hasilprod_noproduksiField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('produksi_no'));
		
		// Load Detail Produk hasil produksi nya dulu, baru satuannya
		cbo_dhasilprod_produk_DataStore.setBaseParam('master_id',hasilprod_get_pk_id());
		cbo_dhasilprod_produk_DataStore.setBaseParam('task','detail');
		cbo_dhasilprod_produk_DataStore.load({
				params: {
					query: hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_id'),
					aktif: 'yesno'
				},
				//Jika berhasil, load data storenya detail satuan.. 
				callback: function(opts, success, response){
					cbo_dhasilprod_satuan_DataStore.setBaseParam('master_id',hasilprod_get_pk_id());
					cbo_dhasilprod_satuan_DataStore.setBaseParam('task','detail');
					cbo_dhasilprod_satuan_DataStore.load({
								callback: function(opts, success, response){
									detail_hasilprod_DataStore.load({params: {master_id: hasilprod_get_pk_id(), start:0, limit: hasilprod_pageS}});
								}
					});
				}
		});
		
		hasilprod_stat_dokField.on("select",function(){
			var status_awal_produksi = hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_status');
			if(status_awal_produksi =='Terbuka' && hasilprod_stat_dokField.getValue()=='Tertutup')
			{
			Ext.MessageBox.show({
				msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			   //progressText: 'proses...',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			hasilprod_stat_dokField.setValue('Terbuka');
			}
			
			else if(status_awal_produksi =='Tertutup' && hasilprod_stat_dokField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			hasilprod_stat_dokField.setValue('Tertutup');
			}
			
			else if(status_awal_produksi =='Batal' && hasilprod_stat_dokField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Batal tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			hasilprod_stat_dokField.setValue('Tertutup');
			}
			
			else if(hasilprod_stat_dokField.getValue()=='Batal')
			{
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', hasilprod_status_batal);
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
			else if(status_awal_produksi =='Tertutup' && hasilprod_stat_dokField.getValue()=='Tertutup'){
				//hasilprod_createForm.hasilprod_savePrint.enable();
			}
			<?php } ?>
		});
	
	function hasilprod_status_batal(btn){
			if(btn=='yes')
			{
				hasilprod_stat_dokField.setValue('Batal');
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
				hasilprod_createForm.hasilprod_savePrint.disable();
				<?php } ?>
			}  
			else
			hasilprod_stat_dokField.setValue(hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_status'));
		}
		
	}
	/* End setValue to EDIT*/

	function hasilprod_set_form_update(){
		if(hasilprod_post2db=="UPDATE" && hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_status')=="Terbuka"){
			hasilprod_tanggalField.setDisabled(false);
			hasilprod_noField.setDisabled(false);
			hasilprod_keteranganField.setDisabled(false);
			hasilprod_noproduksiField.setDisabled(true);
			hasilprod_stat_dokField.setDisabled(false);
			combo_dhasilprod_produk.setDisabled(false);
			combo_dhasilprod_satuan.setDisabled(false);
			dhasilprod_jumlahField.setDisabled(false);
			dhasilprod_jumlah_orderField.setDisabled(false);
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
			hasilprod_createForm.hasilprod_savePrint.enable();
			<?php } ?>
		}
		if(hasilprod_post2db=="UPDATE" && hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_status')=="Tertutup"){
			hasilprod_tanggalField.setDisabled(true);
			hasilprod_noField.setDisabled(true);
			hasilprod_keteranganField.setDisabled(true);
			hasilprod_noproduksiField.setDisabled(true);
			combo_dhasilprod_produk.setDisabled(true);
			combo_dhasilprod_satuan.setDisabled(true);
			dhasilprod_jumlahField.setDisabled(true);
			dhasilprod_jumlah_orderField.setDisabled(true);
			hasilprod_stat_dokField.setDisabled(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
			hasilprod_createForm.hasilprod_savePrint.disable();
			<?php } ?>
		}
		if(hasilprod_post2db=="UPDATE" && hasilprod_ListEditorGrid.getSelectionModel().getSelected().get('hasil_status')=="Batal"){
			hasilprod_tanggalField.setDisabled(true);
			hasilprod_noField.setDisabled(true);
			hasilprod_keteranganField.setDisabled(true);
			hasilprod_noproduksiField.setDisabled(true);
			hasilprod_stat_dokField.setDisabled(true);
			combo_dhasilprod_produk.setDisabled(true);
			combo_dhasilprod_satuan.setDisabled(true);
			dhasilprod_jumlahField.setDisabled(true);
			dhasilprod_jumlah_orderField.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
			hasilprod_createForm.hasilprod_savePrint.disable();
			<?php } ?>
		}
	}
  
	/* Function for Check if the form is valid */
	function is_hasilprod_form_valid(){
		return (/*lcl_custField.isValid() &&*/ true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		detail_hasilprod_DataStore.load({params: {master_id:-1}});
		if(!hasilprod_createWindow.isVisible()){
			hasilprod_reset_form();
			hasilprod_post2db='CREATE';
			msg='created';
			hasilprod_noField.setValue('(Auto)');
			hasilprod_stat_dokField.setValue("Terbuka");
			hasilprod_createWindow.show();
		} else {
			hasilprod_createWindow.toFront();
		}
	}
  	/* End of Function */
	
  	/* Function for Delete Confirm */
	function hasilprod_confirm_delete(){
		if(hasilprod_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', hasilprod_delete);
		} else if(hasilprod_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', hasilprod_delete);
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
	function hasilprod_confirm_update(){
		/* only one record is selected here */
		if(hasilprod_ListEditorGrid.selModel.getCount() == 1) {
			hasilprod_post2db='UPDATE';
			msg='updated';
			hasilprod_set_form();
			hasilprod_set_form_update();
			hasilprod_createWindow.show();
			//hasilprod_createWindow.show();
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
	function hasilprod_delete(btn){
		if(btn=='yes'){
			var selections = hasilprod_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< hasilprod_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kwitansi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_hasil_prod&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							hasilprod_DataStore.reload();
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
    
	/* Function for Retrieve Hasil Produksi DataStore */
	hasilprod_DataStore = new Ext.data.Store({
		id: 'hasilprod_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'hasil_id'
		},[
			{name: 'hasil_id', type: 'int', mapping: 'hasil_id'}, 
			{name: 'hasil_no', type: 'string', mapping: 'hasil_no'}, 
			{name: 'hasil_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'hasil_tanggal'}, 
			{name: 'produksi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'produksi_tanggal'}, 
			{name: 'hasil_status', type: 'string', mapping: 'hasil_status'}, 
			{name: 'hasil_keterangan', type: 'string', mapping: 'hasil_keterangan'}, 
			{name: 'produksi_no', type: 'string', mapping: 'produksi_no'}

		]),
		sortInfo:{field: 'hasil_id', direction: "DESC"}
	});
	/* End of Function */
		
	/* Function for Retrieve Produk DataStore */
	var cbo_dhasilprod_produk_DataStore = new Ext.data.Store({
		id: 'cbo_dhasilprod_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=get_produk_list',
			method: 'POST'
		}),
		baseParams:{task: "list",start:0,limit:hasilprod_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'jumlah_order', type: 'int', mapping: 'jumlah_order'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produksi_produk_kode', type: 'string', mapping: 'produk_kode'},
			// {name: 'order_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'order_produk_satuan', type: 'string', mapping: 'satuan_id'},
			{name: 'dorder_harga', type: 'float', mapping: 'dorder_harga'},
			{name: 'dorder_harga_log', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dorder_harga_log'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});

	var cbo_dhasilprod_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{produksi_produk_kode}| <b>{produk_nama}</b>',
		'</div></tpl>'
    );

	// DataStore Reader untuk Detail Hasil Produksi
	var detail_dhasilprod_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
	},[
			{name: 'dhasil_id', type: 'int', mapping: 'dhasil_id'},
			{name: 'dhasil_produk', type: 'int', mapping: 'dhasil_produk'},
			{name: 'dhasil_jumlah', type: 'int', mapping: 'dhasil_jumlah'},
			{name: 'dhasil_satuan', type: 'int', mapping: 'dhasil_satuan'},
			{name: 'dhasil_keterangan', type: 'string', mapping: 'dhasil_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
	]);

	/* Function for Retrieve DataStore of detail*/
	var detail_hasilprod_DataStore = new Ext.data.Store({
		id: 'detail_hasilprod_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=detail_hasil_produksi_list',
			method: 'POST'
		}),
		reader: detail_dhasilprod_reader,
		baseParams:{master_id: hasilprod_get_pk_id(), start:0, limit: hasilprod_pageS },
		sortInfo:{field: 'dhasil_produk', direction: "ASC"}
	});
	/* End of Function */

	//DataStore utk menampilkan Nomer Permintaan Produksi
	cbo_hasilprod_permintaanprod_DataStore = new Ext.data.Store({
		id: 'cbo_hasilprod_permintaanprod_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=get_no_permintaan_produksi_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produksi_id'
		},[
			{name: 'hasilprod_produksi_value', type: 'int', mapping: 'produksi_id'},
			{name: 'hasilprod_produksi_nama', type: 'string', mapping: 'produksi_no'},
			{name: 'hasilprod_produksi_tgl', type: 'date', dateFormat: 'Y-m-d', mapping: 'produksi_tanggal'},
			{name: 'hasilprod_produksi_gudang_nama', type: 'string', mapping: 'gudang_nama'},
			{name: 'hasilprod_produksi_gudang_id', type: 'int', mapping: 'gudang_id'}
		]),
		sortInfo:{field: 'hasilprod_produksi_tgl', direction: "DESC"}
	});

    //TPL untuk No Permintaan Produksi
	var hasilprod_noproduksi_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{hasilprod_produksi_nama}</b><br /></span>',
            'Tgl-Produksi: {hasilprod_produksi_tgl:date("j M, Y")}<br>',
            'Lokasi: {hasilprod_produksi_gudang_nama}<br>',
        '</div></tpl>'
    );

	//Function of Data Store for Satuan Hasil Produksi
	cbo_dhasilprod_satuan_DataStore = new Ext.data.Store({
		id: 'cbo_dhasilprod_satuan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=get_satuan_list',
			method: 'POST'
		}),
		baseParams:{start:0, limit:hasilprod_pageS, task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'hasilprod_satuan_value'
		},[
			{name: 'hasilprod_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'order_satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'hasilprod_satuan_display', type: 'string', mapping: 'satuan_nama'},
			{name: 'order_satuan_default', type: 'string', mapping: 'konversi_default'},
		]),
		sortInfo:{field: 'hasilprod_satuan_display', direction: "ASC"}
	});

	//DataStore utk menghasilkan/menampilkan list detail item dari PP ketika field No PP di tekan
	var hasilprod_permintaanprod_list_detail_DataStore=new Ext.data.Store({
		id: 'hasilprod_permintaanprod_list_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=get_item_detail_by_produksi_id',
			method: 'POST'
		}),
		baseParams:{task: "LIST"},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produksi_id'
		},[
			{name: 'dminta_master', type: 'int', mapping: 'produksi_id'},
			{name: 'dhasil_produk', type: 'int', mapping: 'djadi_produk'},
			{name: 'dminta_produk_nama', type: 'string', mapping: 'produk_nama'},
			// {name: 'jumlah_sisa', type: 'float', mapping: 'jumlah_sisa'},
			{name: 'dterima_jumlah', type: 'float', mapping: 'dterima_jumlah'},
			{name: 'dhasil_jumlah_order', type: 'float', mapping: 'jumlah_order'},
			{name: 'dhasil_jumlah', type: 'float', mapping: 'dhasil_jumlah'},
			{name: 'dhasil_satuan', type: 'int', mapping: 'djadi_satuan'},
			{name: 'dorder_produk_satuan', type: 'string', mapping: 'satuan_nama'},
			{name: 'dterima_harga', type: 'float', mapping: 'djadi_harga'},
			{name: 'dterima_diskon', type: 'float', mapping: 'dorder_diskon'},
			{name: 'dorder_produk_subtotal', type: 'float', mapping: 'subtotal'}
		]),
		sortInfo:{field: 'dhasil_produk', direction: "ASC"}
	});

	//function for editor of detail Detail Hasil Produksi
	var editor_dhasilprod= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
  	/* Function for Identify of Window Column Model */
	hasilprod_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'hasil_id',
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
			dataIndex: 'hasil_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
		
			
		}, 

		{
			header: '<div align="center">' + 'No. Hasil Produksi' + '</div>',
			align: 'left',
			dataIndex: 'hasil_no',
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
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'left',
			dataIndex: 'hasil_keterangan',
			width: 150	
		}, 

		{
			header: '<div align="center">' + 'Status Dokumen' + '</div>',
			align: 'left',
			dataIndex: 'hasil_status',
			width: 150
	
		}, 

		{
			header: 'Creator',
			dataIndex: 'hasil_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'hasil_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	
		]);
	
	hasilprod_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	hasilprod_ListEditorGrid =  new Ext.grid.GridPanel({
		id: 'hasilprod_ListEditorGrid',
		el: 'fp_hasil_produksi',
		title: 'Daftar Hasil Produksi',
		autoHeight: true,
		store: hasilprod_DataStore, 
		cm: hasilprod_ColumnModel, 
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: hasilprod_pageS,
			store: hasilprod_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',   
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
		{
			text: 'View/Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: hasilprod_confirm_update  
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: hasilprod_confirm_delete 
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
			store: hasilprod_DataStore,
			params: {task: 'LIST',start: 0, limit: hasilprod_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						hasilprod_DataStore.baseParams={task:'LIST',start: 0, limit: hasilprod_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Hasil Produksi No. <br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: hasilprod_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: hasilprod_export_excel
		}
		/*, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: hasilprod_print  
		}
		*/
		]
	});
	hasilprod_ListEditorGrid.render();
	/* End of DataStore */
	
	hasilprod_ListEditorGrid.on('rowclick', function (hasilprod_ListEditorGrid, rowIndex, eventObj) {
        var recordMaster = hasilprod_ListEditorGrid.getSelectionModel().getSelected();
        // detail_bahan_produksi_list_DataStore.setBaseParam('master_id',recordMaster.get("produksi_id"));
		// detail_bahan_produksi_list_DataStore.load({params : {master_id : recordMaster.get("produksi_id"), start:0, limit:hasilprod_pageS}});
		detail_item_hasilprod_list_DataStore.setBaseParam('master_id',recordMaster.get("hasil_id"));
		detail_item_hasilprod_list_DataStore.load({params : {master_id : recordMaster.get("hasil_id"), start:0 , limit : hasilprod_pageS}});
		hasilprod_temp_master_idField.setValue(recordMaster.get("hasil_id"));
		hasilprod_DataStore.reload();
    });
     
	/* Create Context Menu */
	hasilprod_ContextMenu = new Ext.menu.Menu({
		id: 'hasilprod_ContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
		{ 
			text: 'View/Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: hasilprod_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: hasilprod_confirm_delete 
		},
		<?php } ?>
		'-',
		/*
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: hasilprod_print 
		},
		*/
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: hasilprod_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onhasilprod_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var hasilprod_coords = e.getXY();
		hasilprod_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		hasilprod_SelectedRow=rowIndex;
		hasilprod_ContextMenu.showAt([hasilprod_coords[0], hasilprod_coords[1]]);
  	}
  	/* End of Function */
	
	hasilprod_ListEditorGrid.addListener('rowcontextmenu', onhasilprod_ListEditGridContextMenu);
	hasilprod_DataStore.load({params: {start: 0, limit: hasilprod_pageS}});	// load DataStore
	hasilprod_ListEditorGrid.on('afteredit', hasilprod_update); // inLine Editing Record
	
	/* Identify hasilproduksi ID Field */
	hasilprod_temp_master_idField= new Ext.form.NumberField({
		id: 'hasilprod_temp_master_idField'
	});
	
	/* Identify hasil Produksi ID Field */
	hasilprod_idField= new Ext.form.NumberField({
		id: 'hasilprod_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify Hasil Produksi No Field */
	hasilprod_noField= new Ext.form.TextField({
		id: 'hasilprod_noField',
		fieldLabel: 'No.Hasil Produksi',
		maxLength: 20,
		readOnly:true,
		emptyText: '(Auto)',
		anchor: '75%'
	});

	/* Identify Hasilprod NO permintaan Produksi Field */
	hasilprod_noproduksiField= new Ext.form.ComboBox({
		id: 'hasilprod_noproduksiField',
		fieldLabel: 'No Permintaan Produksi',
		store: cbo_hasilprod_permintaanprod_DataStore,
		displayField:'hasilprod_produksi_nama',
		mode : 'remote',
		valueField: 'hasilprod_produksi_value',
        typeAhead: false,
		forceSelection: true,
        hideTrigger:false,
		allowBlank: false,
		tpl: hasilprod_noproduksi_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender: true,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});
	
	//Declaration Detail Hasil Produksi

	var cek_hasilprod_produkField=new Ext.form.Checkbox({
		id : 'cek_hasilprod_produkField',
		boxLabel: 'All Produk?',
		handler: function(node,checked){
			if (checked) {
				cbo_dhasilprod_produk_DataStore.setBaseParam('task','list');
				cbo_dhasilprod_produk_DataStore.setBaseParam('produksi_id',hasilprod_noproduksiField.getValue());
			}
			else {
				cbo_dhasilprod_produk_DataStore.setBaseParam('task','produksi');
				cbo_dhasilprod_produk_DataStore.setBaseParam('produksi_id',hasilprod_noproduksiField.getValue());
			}
		}
	});

	//Declaration Combo Hasil Produksi Produk
	var combo_dhasilprod_produk =new Ext.form.ComboBox({
		store: cbo_dhasilprod_produk_DataStore,
		mode: 'remote',
		displayField: 'produk_nama',
		valueField: 'produk_id',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize: hasilprod_pageS,
		hideTrigger:false,
		tpl: cbo_dhasilprod_produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		enableKeyEvents: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	//Declaration Combo Satuan Hasil Produksi
	var combo_dhasilprod_satuan=new Ext.form.ComboBox({
		store: cbo_dhasilprod_satuan_DataStore,
		mode:'local',
		typeAhead: true,
		displayField: 'hasilprod_satuan_display',
		valueField: 'hasilprod_satuan_value',
		triggerAction: 'all',
		allowBlank : false,
		anchor: '95%'
	});

	// Declaration Jumlah Produksi Jadi
	var dhasilprod_jumlahField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	//Ini event ketika menginput jumlah lebih dari jumlah order maka tidak bisa
	/*
	dhasilprod_jumlahField.on('keyup', function(){
		if(this.getRawValue() > dhasilprod_jumlah_orderField.getValue()){
			this.setRawValue(dhasilprod_jumlah_orderField.getValue());
		}
	});
	*/

	// Declaration Jumlah Order dari Permintaan Produksinya
	var dhasilprod_jumlah_orderField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify Hasil Produksi Keterangan Field */
	hasilprod_keteranganField= new Ext.form.TextArea({
		id: 'hasilprod_keteranganField',
		fieldLabel: 'Description',
		maxLength: 500,
		anchor: '75%'
	});

	/* Identify Produksi Status Field */
	hasilprod_stat_dokField= new Ext.form.ComboBox({
		id: 'hasilprod_stat_dokField',
		align : 'Right',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['hasilprod_status_value', 'hasilprod_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'hasilprod_status_display',
		valueField: 'hasilprod_status_value',
		//emptyText: 'Terbuka',
		anchor: '25%',
		triggerAction: 'all'	
	});

	/*Identify Hasil Produksi Tanggal Field  */
	hasilprod_tanggalField= new Ext.form.DateField({
		id: 'hasilprod_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});

	//Column Model Remarks - Detail Hasil Produksi
	detail_item_hasilprod_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'dhasil_id',
            hidden: true
		},
		
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Produk' + '</div>',
			dataIndex: 'dhasil_produk',
			width: 250,
			sortable: false,
			allowBlank : false,
			editor: combo_dhasilprod_produk,
			renderer: Ext.util.Format.comboRenderer(combo_dhasilprod_produk)
		},
		/*
		{
            xtype: 'booleancolumn',
            header: 'All Produk',
            // dataIndex: 'dapp_nonmedis_warna_terapis',
            align: 'center',
            width: 80,
            trueText: '-',
            falseText: '-',
            editor: cek_hasilprod_produkField
        },
        */
		{
			align : 'Left',
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'dhasil_satuan',
			width: 100,
			sortable: false,
			editor: combo_dhasilprod_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_dhasilprod_satuan)
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml Hasilnya' + '</div>',
			dataIndex: 'dhasil_jumlah',
			width: 100,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: dhasilprod_jumlahField
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml Order' + '</div>',
			dataIndex: 'dhasil_jumlah_order',
			width: 100,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: dhasilprod_jumlah_orderField
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dhasil_keterangan',
			width: 400,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
		}
		]
	);
	detail_item_hasilprod_ColumnModel.defaultSortable= true;

	/* Function for Delete Confirm of detail */
	function detail_item_dhasilprod_delete(){
		// only one record is selected here
		if(detail_item_dhasilprod_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_item_dhasilprod_konfirmasi_del);
		} else if(detail_item_dhasilprod_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_item_dhasilprod_konfirmasi_del);
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
	function detail_item_dhasilprod_konfirmasi_del(btn){
		if(btn=='yes'){
            var selections = detail_item_dhasilprod_ListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.dhasil_id==''){
                    detail_hasilprod_DataStore.remove(record);
                }else if((/^\d+$/.test(record.data.dhasil_id))){
                    //Delete dari db detail Hasil Produksi
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    detail_hasilprod_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_master_hasil_prod&m=get_action', 
                        params: { task: "DETAIL_DELETE", dhasil_id:  record.data.dhasil_id }, 
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
	detail_item_dhasilprod_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_item_dhasilprod_ListEditorGrid',
		el: 'fp_detail_item_dhasilprod',
		title: 'Detail Item Hasil Produksi',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: detail_hasilprod_DataStore,
		colModel: detail_item_hasilprod_ColumnModel, 
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		plugins: [editor_dhasilprod],
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
			handler: detail_item_dhasilprod_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			// ref : '../djpaket_delete',
			handler: detail_item_dhasilprod_delete
		}
		]
	});
	//eof
	

	//function of detail add Detail Item Hasil Produksi
	function detail_item_dhasilprod_add(){
		var edit_dhasilprod= new detail_item_dhasilprod_ListEditorGrid.store.recordType({
			dhasil_id			:'',		
			dhasil_produk		:'',
			dhasil_satuan		:'', 
			dhasil_jumlah  		:'',
			dhasil_keterangan	:''
		});
		editor_dhasilprod.stopEditing();
		detail_hasilprod_DataStore.insert(0, edit_dhasilprod);
		// detail_item_dhasilprod_ListEditorGrid.getView().refresh();
		detail_item_dhasilprod_ListEditorGrid.getSelectionModel().selectRow(0);
		editor_dhasilprod.startEditing(0);
	}
	
  	/*Fieldset Master*/
	hasilprod_masterGroup = new Ext.form.FieldSet({
		// title: 'Master Information',
		autoHeight: true,
		//collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.48,
				layout: 'form',
				border:false,
				items: [hasilprod_tanggalField, hasilprod_noField, hasilprod_noproduksiField, hasilprod_idField] 
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
				items: [hasilprod_keteranganField/*hasilprod_stat_dokField*/] 
			}
			]
	});

	/* Start Panel Detail Hasil Produksi Data Store*/
	detail_item_hasilprod_list_DataStore = new Ext.data.GroupingStore({
		id: 'detail_item_hasilprod_list_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_hasil_prod&m=list_history_produksi_jadi', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:hasilprod_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
			//id: 'app_id'
		},[
        	{name: 'dhasil_id', type: 'int', mapping: 'dhasil_id'}, 
			{name: 'dhasil_master', type: 'int', mapping: 'dhasil_master'}, 
			{name: 'dhasil_produk', type: 'int', mapping: 'dhasil_produk'}, 
			{name: 'dhasil_satuan', type: 'int', mapping: 'dhasil_satuan'}, 
			{name: 'dhasil_jumlah', type: 'int', mapping: 'dhasil_jumlah'}, 
			{name: 'dhasil_keterangan', type: 'string', mapping: 'dhasil_keterangan'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'dhasil_produk', direction: "ASC"}
	});
	/* End DataStore */

    //Column Model for Detail Produksi Jadi History
    detail_item_hasilprod_list_ColumnModel = new Ext.grid.ColumnModel(
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
			dataIndex: 'dhasil_jumlah',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'dhasil_keterangan',
			width: 100,
			sortable: true
		}]
    );
    detail_item_hasilprod_list_ColumnModel.defaultSortable= true;

    //Panel Detail Hasil Produksi
    var detail_item_dhasilprod_Panel = new Ext.grid.GridPanel({
		id: 'detail_item_dhasilprod_Panel',
		title: 'Detail Produksi Jadi',
        store: detail_item_hasilprod_list_DataStore,
        cm: detail_item_hasilprod_list_ColumnModel,
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
    // detail_item_dhasilprod_Panel.render('fp_produksi_jadi_history');

	/* Function for retrieve create Window Panel*/ 
	hasilprod_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 900,        
		items: [hasilprod_stat_dokField, hasilprod_masterGroup  , detail_item_dhasilprod_ListEditorGrid],
		buttons: [
		/*
			{
				text : 'Print Only',
				handler : hasilprod_print_only
			},
			*/
			{
				xtype:'spacer',
				width: 350
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_HASILPROD'))){ ?>
			{
				text: 'Save and Print',
				ref: '../hasilprod_savePrint',
				handler: hasilprod_save_and_print
				
			},
			{
				text: 'Save and Close',
				handler: hasilprod_save_and_close
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					hasilprod_reset_form();
					hasilprod_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	hasilprod_createWindow= new Ext.Window({
		id: 'hasilprod_createWindow',
		title: hasilprod_post2db+'Hasil Produksi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindows_hasilprod_create',
		items: hasilprod_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function hasilprod_list_search(){
		// render according to a SQL date format.
		var kwitansi_no_search=null;
		var kwitansi_cust_search=null;
		var kwitansi_tanggal_start_search="";
		var kwitansi_tanggal_end_search="";
		var kwitansi_keterangan_search=null;
		var kwitansi_status_search=null;
		var dfcl_remarks_status_search=null;
		var dfcl_final_status_search=null;

		if(hasilprod_noSearchField.getValue()!==null){kwitansi_no_search=hasilprod_noSearchField.getValue();}

		if(hasilprod_tanggal_awalSearchField.getValue()!==""){kwitansi_tanggal_start_search=hasilprod_tanggal_awalSearchField.getValue().format('Y-m-d');}
		if(hasilprod_tanggal_akhirSearchField.getValue()!==""){kwitansi_tanggal_end_search=hasilprod_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(hasilprod_keteranganSearchField.getValue()!==null){kwitansi_keterangan_search=hasilprod_keteranganSearchField.getValue();}
		if(hasilprod_statusSearchField.getValue()!==null){kwitansi_status_search=hasilprod_statusSearchField.getValue();}

		// change the store parameters
		hasilprod_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kwitansi_no				:	kwitansi_no_search,
			kwitansi_cust			:	kwitansi_cust_search,
			kwitansi_tanggal_start	:	kwitansi_tanggal_start_search,
			kwitansi_tanggal_end	:	kwitansi_tanggal_end_search,
			kwitansi_keterangan		:	kwitansi_keterangan_search,
			hasil_status			:	kwitansi_status_search,
			dbahan_produk			:	dfcl_remarks_status_search,
			dbahan_satuan			:	dfcl_remarks_status_search,
			final_status			:	dfcl_final_status_search
		};
		// Cause the datastore to do another query : 
		hasilprod_DataStore.reload({params: {start: 0, limit: hasilprod_pageS}});
	}
		
	/* Function for reset search result */
	function hasilprod_reset_search(){
		// reset the store parameters
		hasilprod_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		hasilprod_DataStore.reload({params: {start: 0, limit: hasilprod_pageS}});
		//hasilprod_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify Hasil Produksi ID Search Field */
	hasilprod_idSearchField= new Ext.form.NumberField({
		id: 'hasilprod_idSearchField',
		fieldLabel: 'Hasil Produksi ID',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	/* Identify Hasil Produksi NO Search Field */
	hasilprod_noSearchField= new Ext.form.TextField({
		id: 'hasilprod_noSearchField',
		fieldLabel: 'No.Hasil Produksi',
		maxLength: 20,
		anchor: '95%'
	});

	/* Identify  */
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
	
	/* Identify Hasil Produksi Keterangan Search Field */
	hasilprod_keteranganSearchField= new Ext.form.TextArea({
		id: 'hasilprod_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify Hasil Produksi Tanggal Awal Search Field */
	hasilprod_tanggal_awalSearchField= new Ext.form.DateField({
		id: 'hasilprod_tanggal_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
	});
	hasilprod_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'hasilprod_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
	});
	
	/* Identify hasil_status Search Field */
	hasilprod_statusSearchField= new Ext.form.ComboBox({
		id: 'hasilprod_statusSearchField',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['value', 'hasil_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'hasil_status',
		valueField: 'value',
		width: 100,
		triggerAction: 'all'
	});

	/* Function for retrieve search Form Panel */
	hasilprod_searchForm = new Ext.FormPanel({
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
				items: [hasilprod_noSearchField,lcl_supplierSearchField,
					
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
								hasilprod_tanggal_awalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								hasilprod_tanggal_akhirSearchField
							]
						}								
				        ]
					},
			hasilprod_keteranganSearchField] 
			}			
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: hasilprod_list_search
			},{
				text: 'Close',
				handler: function(){
					hasilprod_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	hasilprod_searchWindow = new Ext.Window({
		title: 'Pencarian Hasil Produksi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_hasilprod_search',
		items: hasilprod_searchForm
	});
    /* End of Function */
	
	function hasilprod_reset_SearchForm(){
		hasilprod_noSearchField.reset();
		hasilprod_noSearchField.setValue(null);
		hasilprod_tanggal_awalSearchField.reset();
		hasilprod_tanggal_awalSearchField.setValue(null);
		hasilprod_tanggal_akhirSearchField.reset();
		hasilprod_tanggal_akhirSearchField.setValue(null);
		hasilprod_keteranganSearchField.reset();
		hasilprod_keteranganSearchField.setValue(null);
		hasilprod_statusSearchField.reset();
		hasilprod_statusSearchField.setValue(null);

	}
	 
	 function hasilprod_reset_search_form(){
		hasilprod_noSearchField.reset();
		hasilprod_noSearchField.setValue(null);
		hasilprod_tanggal_awalSearchField.reset();
		hasilprod_tanggal_awalSearchField.setValue(null);
		hasilprod_tanggal_akhirSearchField.reset();
		hasilprod_tanggal_akhirSearchField.setValue(null);
		hasilprod_keteranganSearchField.reset();
		hasilprod_keteranganSearchField.setValue(null);
		hasilprod_statusSearchField.reset();
		hasilprod_statusSearchField.setValue(null);
	 }
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		hasilprod_reset_search_form();
		if(!hasilprod_searchWindow.isVisible()){
			hasilprod_reset_SearchForm();
			hasilprod_searchWindow.show();
		} else {
			hasilprod_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function hasilprod_print(){
		var searchquery = "";
		var kwitansi_no_print=null;
		var kwitansi_cust_print=null;
		var kwitansi_keterangan_print=null;
		var kwitansi_status_print=null;
		var win;
		// check if we do have some search data...
		if(hasilprod_DataStore.baseParams.query!==null){searchquery = hasilprod_DataStore.baseParams.query;}
		if(hasilprod_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_print = hasilprod_DataStore.baseParams.kwitansi_no;}
		if(hasilprod_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_print = hasilprod_DataStore.baseParams.kwitansi_cust;}
		if(hasilprod_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_print = hasilprod_DataStore.baseParams.kwitansi_keterangan;}
		if(hasilprod_DataStore.baseParams.hasil_status!==null){kwitansi_status_print = hasilprod_DataStore.baseParams.hasil_status;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_hasil_prod&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kwitansi_no	:	kwitansi_no_print, 
			kwitansi_cust	:	kwitansi_cust_print, 
			kwitansi_keterangan	:	kwitansi_keterangan_print, 
			hasil_status	:	kwitansi_status_print,
		  	currentlisting: hasilprod_DataStore.baseParams.task // this tells us if we are searching or not
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
	function hasilprod_export_excel(){
		var searchquery = "";
		var kwitansi_no_2excel=null;
		var kwitansi_cust_2excel=null;
		var kwitansi_keterangan_2excel=null;
		var kwitansi_status_2excel=null;
		var win;
		// check if we do have some 2excel data...
		if(hasilprod_DataStore.baseParams.query!==null){searchquery = hasilprod_DataStore.baseParams.query;}
		if(hasilprod_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_2excel = hasilprod_DataStore.baseParams.kwitansi_no;}
		if(hasilprod_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_2excel = hasilprod_DataStore.baseParams.kwitansi_cust;}
		if(hasilprod_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_2excel = hasilprod_DataStore.baseParams.kwitansi_keterangan;}
		if(hasilprod_DataStore.baseParams.hasil_status!==null){kwitansi_status_2excel = hasilprod_DataStore.baseParams.hasil_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_hasil_prod&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			//if we are doing advanced 2excel, use this
			kwitansi_no	:	kwitansi_no_2excel, 
			kwitansi_cust	:	kwitansi_cust_2excel, 
			kwitansi_keterangan	:	kwitansi_keterangan_2excel, 
			hasil_status	:	kwitansi_status_2excel,
		  	currentlisting: hasilprod_DataStore.baseParams.task // this tells us if we are searching or not
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
	hasilprod_noproduksiField.on('select', function(){
		// Apa disini ditambahin clear datastore detailnya dulu?? 
		var j=cbo_hasilprod_permintaanprod_DataStore.findExact('produksi_id',hasilprod_noproduksiField.getValue(),0);
		hasilprod_permintaanprod_list_detail_DataStore.setBaseParam('produksi_id', hasilprod_noproduksiField.getValue());
		hasilprod_permintaanprod_list_detail_DataStore.load({
			params:{
				task:'detail'
			}
		});
	});

	//Event ketika di klik Add uda memunculkan list produk2nya
	combo_dhasilprod_produk.on("focus",function(){
			if(cek_hasilprod_produkField.getValue()==true){
				cbo_dhasilprod_produk_DataStore.setBaseParam('task','list');
				cbo_dhasilprod_produk_DataStore.setBaseParam('produksi_id',hasilprod_noproduksiField.getValue());
				cbo_dhasilprod_produk_DataStore.load();
			}
			else{
				cbo_dhasilprod_produk_DataStore.setBaseParam('task','produksi');
				cbo_dhasilprod_produk_DataStore.setBaseParam('produksi_id',hasilprod_noproduksiField.getValue());
				cbo_dhasilprod_produk_DataStore.load();
			}	
	});

	combo_dhasilprod_produk.on("select",function(){
		cbo_dhasilprod_satuan_DataStore.setBaseParam('task','produk');
		cbo_dhasilprod_satuan_DataStore.setBaseParam('selected_id',combo_dhasilprod_produk.getValue());
		cbo_dhasilprod_satuan_DataStore.load({
					callback: function(r,opt,success){
				if(success==true){
					if(cbo_dhasilprod_satuan_DataStore.getCount()>0){
						var j=cbo_dhasilprod_satuan_DataStore.findExact('order_satuan_default','true');
						if(j>-1){
							var sat_default=cbo_dhasilprod_satuan_DataStore.getAt(j);
							combo_dhasilprod_satuan.setValue(sat_default.data.hasilprod_satuan_value);	
						}
					}

					var j=cbo_dhasilprod_produk_DataStore.findExact('produk_id',combo_dhasilprod_produk.getValue(),0);
					if(cbo_dhasilprod_produk_DataStore.getCount()>0){
							dhasilprod_jumlahField.setValue(cbo_dhasilprod_produk_DataStore.getAt(j).data.jumlah_order);
							dhasilprod_jumlah_orderField.setValue(cbo_dhasilprod_produk_DataStore.getAt(j).data.jumlah_order);
					}
				}
			}
		
		});
	});

	combo_dhasilprod_satuan.on('focus', function(){
		cbo_dhasilprod_satuan_DataStore.setBaseParam('produk_id',combo_dhasilprod_satuan.getValue());
		cbo_dhasilprod_satuan_DataStore.load();
	});

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_hasil_produksi"></div>
		 <div id="fp_detail_item_dhasilprod"></div>
		<div id="elwindows_hasilprod_create"></div>
        <div id="elwindow_hasilprod_search"></div>
    </div>
</div>
</body>