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
        /*
         * Always return true since we're only using this vtype to set the
         * min/max allowed values (these are tested for after the vtype test)
         */
        return true;
    }
});



/* declare function */		
var cetak_kwitansi_DataStore;
var cetak_kwitansi_ColumnModel;
var cetak_kwitansiListEditorGrid;
var cetak_kwitansi_createForm;
var cetak_kwitansi_createWindow;
var cetak_kwitansi_searchForm;
var cetak_kwitansi_searchWindow;
var cetak_kwitansi_SelectedRow;
var cetak_kwitansi_ContextMenu;
//for detail data
var jual_kwitansi_DataStor;
var jual_kwitansiListEditorGrid;
var jual_kwitansi_ColumnModel;
var jual_kwitansi_proxy;
var jual_kwitansi_writer;
var jual_kwitansi_reader;
var editor_jual_kwitansi;

//declare konstant
var kwitansi_post2db = '';
var msg = '';
var kwitansi_pageS=15;
var dt = new Date();

/* declare variable here for Field*/
var kwitansi_idField;
var kwitansi_noField;
var kwitansi_custField;
var kwitansi_tanggalField;
var kwitansi_refField;
var kwitansi_nilaiField;
var kwitansi_keteranganField;
var kwitansi_statusField;
var kwitansi_idSearchField;
var kwitansi_noSearchField;
var kwitansi_custSearchField;
var kwitansi_nilaiSearchField;
var kwitansi_keteranganSearchField;
var kwitansi_statusSearchField;

var kwitansi_cetak = 0;

function cetak_kwitansi_print_paper(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_cetak_kwitansi&m=print_paper',
		//params: { kwitansi_id : kwitansi_idField.getValue()	},
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


function cetak_kwitansi_print_only(cetak_id){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_cetak_kwitansi&m=print_only',
		//params: { kwitansi_id : kwitansi_idField.getValue()	},
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
		var kwitansi_tanggal_create_date = "";
	
		if(kwitansi_tanggalField.getValue()!== ""){kwitansi_tanggal_create_date = kwitansi_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_cetak_kwitansi&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: kwitansi_tanggal_create_date
		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							cetak_kwitansi_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Cetak Kwitansi tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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

	

	function terbilang(bilangan) {
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
  
  	/* Function for Saving inLine Editing */
	function cetak_kwitansi_update(oGrid_event){
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
		if(oGrid_event.record.data.kwitansi_status!== null){kwitansi_status_update = oGrid_event.record.data.kwitansi_status;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_cetak_kwitansi&m=get_action',
			params: {
				task: "UPDATE",
				kwitansi_id	: kwitansi_id_update_pk, 
				kwitansi_no	:kwitansi_no_update,  
				kwitansi_cust	:kwitansi_cust_update,
				kwitansi_tanggal:kwitansi_tanggal_update,
				kwitansi_ref	:kwitansi_ref_update,  
				kwitansi_nilai	:kwitansi_nilai_update,  
				kwitansi_keterangan	:kwitansi_keterangan_update,  
				kwitansi_status	:kwitansi_status_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						cetak_kwitansi_DataStore.commitChanges();
						cetak_kwitansi_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data kuitansi tidak bisa disimpan',
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
	function cetak_kwitansi_create(){
		if(((/^\d+$/.test(kwitansi_custField.getValue()) && kwitansi_post2db=='CREATE') || kwitansi_post2db=='UPDATE') && kwitansi_statusField.getValue()=='Terbuka'){
			if(kwitansi_status_lunasField.getValue()=='LUNAS'){
				var kwitansi_id_create_pk=null; 
				var kwitansi_no_create=null; 
				var kwitansi_cust_create=null; 
				var kwitansi_tanggal_create=null;
				var kwitansi_ref_create=null; 
				var kwitansi_nilai_create=null; 
				var kwitansi_keterangan_create=null; 
				var kwitansi_status_create=null; 
				var kwitansi_cara_create=null;
				// Bayar Tunai
				var kwitansi_tunai_nilai_create=null;
				// Bayar Card/Kartu Kredit
				var kwitansi_card_nama_create="";
				var kwitansi_card_edc_create="";
				var kwitansi_card_no_create="";
				var kwitansi_card_nilai_create=null;
				// Bayar Cek
				var kwitansi_cek_nama_create=null;
				var kwitansi_cek_nomor_create="";
				var kwitansi_cek_valid_create="";
				var kwitansi_cek_bank_create="";
				var kwitansi_cek_nilai_create=null;
				// Bayar Transfer
				var kwitansi_transfer_bank_create="";
				var kwitansi_transfer_nama_create=null;
				var kwitansi_transfer_nilai_create=null;
				
				var kwitansi_total_bayar_create=null;
				var kwitansi_cetak_create;
		
				kwitansi_id_create_pk=get_pk_id();
				if(kwitansi_idField.getValue()!== null){kwitansi_id_create = kwitansi_idField.getValue();}else{kwitansi_id_create_pk=get_pk_id();} 
				if(kwitansi_noField.getValue()!== null){kwitansi_no_create = kwitansi_noField.getValue();} 
				if(kwitansi_custField.getValue()!== null){kwitansi_cust_create = kwitansi_custField.getValue();}
				if(kwitansi_tanggalField.getValue()!== ""){kwitansi_tanggal_create = kwitansi_tanggalField.getValue().format('Y-m-d');}
				if(kwitansi_refField.getValue()!== null){kwitansi_ref_create = kwitansi_refField.getValue();} 
				if(kwitansi_nilaiField.getValue()!== null){kwitansi_nilai_create = kwitansi_nilaiField.getValue();} 
				if(kwitansi_keteranganField.getValue()!== null){kwitansi_keterangan_create = kwitansi_keteranganField.getValue();} 
				if(kwitansi_statusField.getValue()!== null){kwitansi_status_create = kwitansi_statusField.getValue();} 
				if(kwitansi_caraField.getValue()!== null){kwitansi_cara_create = kwitansi_caraField.getValue();} 
				
				if(kwitansi_tunai_nilaiField.getValue()!== null){kwitansi_tunai_nilai_create = kwitansi_tunai_nilaiField.getValue();}
				
				if(kwitansi_card_namaField.getValue()!== ""){kwitansi_card_nama_create = kwitansi_card_namaField.getValue();} 
				if(kwitansi_card_edcField.getValue()!==""){kwitansi_card_edc_create = kwitansi_card_edcField.getValue();} 
				if(kwitansi_card_noField.getValue()!==""){kwitansi_card_no_create = kwitansi_card_noField.getValue();}
				if(kwitansi_card_nilaiField.getValue()!==null){kwitansi_card_nilai_create = kwitansi_card_nilaiField.getValue();} 
				
				if(kwitansi_cek_namaField.getValue()!== null){kwitansi_cek_nama_create = kwitansi_cek_namaField.getValue();} 
				if(kwitansi_cek_noField.getValue()!== ""){kwitansi_cek_nomor_create = kwitansi_cek_noField.getValue();} 
				if(kwitansi_cek_validField.getValue()!== ""){kwitansi_cek_valid_create = kwitansi_cek_validField.getValue().format('Y-m-d');} 
				if(kwitansi_cek_bankField.getValue()!== ""){kwitansi_cek_bank_create = kwitansi_cek_bankField.getValue();} 
				if(kwitansi_cek_nilaiField.getValue()!== null){kwitansi_cek_nilai_create = kwitansi_cek_nilaiField.getValue();} 
				
				if(kwitansi_transfer_bankField.getValue()!== ""){kwitansi_transfer_bank_create = kwitansi_transfer_bankField.getValue();} 
				if(kwitansi_transfer_namaField.getValue()!== null){kwitansi_transfer_nama_create = kwitansi_transfer_namaField.getValue();}
				if(kwitansi_transfer_nilaiField.getValue()!== null){kwitansi_transfer_nilai_create = kwitansi_transfer_nilaiField.getValue();} 
				
				if(kwitansi_total_bayarField.getValue()!== null){kwitansi_total_bayar_create = kwitansi_total_bayarField.getValue();}
				
				kwitansi_cetak_create = this.kwitansi_cetak;
				task_value = kwitansi_post2db;
				
				Ext.Ajax.request({  
					waitMsg: 'Mohon tunggu...',
					url: 'index.php?c=c_cetak_kwitansi&m=get_action',
					params: {
						task: task_value,
						cetak	: kwitansi_cetak_create,
						kwitansi_id	: kwitansi_id_create_pk, 
						kwitansi_no	: kwitansi_no_create, 
						kwitansi_cust	: kwitansi_cust_create,
						kwitansi_tanggal: kwitansi_tanggal_create,
						kwitansi_ref	: kwitansi_ref_create, 
						kwitansi_nilai	: kwitansi_nilai_create, 
						kwitansi_keterangan	: kwitansi_keterangan_create, 
						kwitansi_status	: kwitansi_status_create, 
						kwitansi_cara		: 	kwitansi_cara_create,
						kwitansi_bayar	: kwitansi_total_bayar_create,
						// Bayar Tunai
						kwitansi_tunai_nilai	:	kwitansi_tunai_nilai_create,
						// Bayar Card/Kartu Kredit
						kwitansi_card_nama	: 	kwitansi_card_nama_create,
						kwitansi_card_edc	:	kwitansi_card_edc_create,
						kwitansi_card_no		:	kwitansi_card_no_create,
						kwitansi_card_nilai	:	kwitansi_card_nilai_create,
						// Bayar Cek/Giro
						kwitansi_cek_nama	: 	kwitansi_cek_nama_create,
						kwitansi_cek_no		:	kwitansi_cek_nomor_create,
						kwitansi_cek_valid	: 	kwitansi_cek_valid_create,
						kwitansi_cek_bank	:	kwitansi_cek_bank_create,
						kwitansi_cek_nilai	:	kwitansi_cek_nilai_create,
						// Bayar Transfer
						kwitansi_transfer_bank	:	kwitansi_transfer_bank_create,
						kwitansi_transfer_nama	:	kwitansi_transfer_nama_create,
						kwitansi_transfer_nilai	:	kwitansi_transfer_nilai_create
					}, 

					success: function(response){             
						var result=eval(response.responseText);
						switch(result){
							case 1:
								//jual_kwitansi_purge()
								//jual_kwitansi_insert();
								Ext.MessageBox.alert(kwitansi_post2db+' OK','Data kuitansi berhasil disimpan');
								cetak_kwitansi_DataStore.reload();
								cetak_kwitansi_createWindow.hide();
								break;
							case 0:
								//jual_kwitansi_purge()
								//jual_kwitansi_insert();
								Ext.MessageBox.alert(kwitansi_post2db+' OK','Data kuitansi berhasil disimpan');
								cetak_kwitansi_DataStore.reload();
								cetak_kwitansi_createWindow.hide();
								break;
							default:
								kwitansi_idField.setValue(result);
								if(result>0){
									cetak_kwitansi_print_paper(result);
								}
								cetak_kwitansi_DataStore.reload();
								cetak_kwitansi_createWindow.hide();
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
			}else{
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Data tidak bisa disimpan, karena pembayaran kuitansi belum Lunas.',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
			}
		}else if(kwitansi_post2db=='UPDATE' && kwitansi_statusField.getValue()=='Tertutup'){
			var kwitansi_id_cetak = get_pk_id();
			cetak_kwitansi_print_paper(kwitansi_id_cetak);
			cetak_kwitansi_DataStore.reload();
			cetak_kwitansi_createWindow.hide();
		}else if(is_cetak_kwitansi_form_valid() && kwitansi_statusField.getValue()=='Batal'){
			var kwitansi_id_create_pk=null; 
			var kwitansi_status_create=null; 
			
			kwitansi_id_create_pk=get_pk_id();
			if(kwitansi_statusField.getValue()!== null){kwitansi_status_create = kwitansi_statusField.getValue();} 
			
			kwitansi_cetak_create = this.kwitansi_cetak;
			task_value = kwitansi_post2db;
			
			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_cetak_kwitansi&m=get_action',
				params: {
					task: 'BATAL',
					kwitansi_id	: kwitansi_id_create_pk, 
					kwitansi_status	: kwitansi_status_create
					
				}, 
				success: function(response){             
					var result=eval(response.responseText);
							if(result==0){
					
							//jual_kwitansi_purge()
							//jual_kwitansi_insert();
							Ext.MessageBox.alert(kwitansi_post2db+' OK','Data kuitansi berhasil di-Batalkan');
							cetak_kwitansi_DataStore.reload();
							cetak_kwitansi_createWindow.hide();
						}
						else if(result==10){
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Data Kuitansi tidak dapat dibatal-kan, karena sudah pernah terpanggil di faktur penjualan',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							
						}
						else{
							Ext.MessageBox.alert(kwitansi_post2db+' Warning','Tidak ada data yang di-Update');
							cetak_kwitansi_DataStore.reload();
							cetak_kwitansi_createWindow.hide();
							
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
 	/* End of Function */
 	
	function save_and_print(){
		kwitansi_cetak = 1;
		pengecekan_dokumen();
	}
  
	//function ini untuk melakukan print saja, tanpa perlu melakukan proses pengecekan dokumen.. 
	function print_only(){
		if(kwitansi_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
		kwitansi_cetak=1;		
		var kwitansi_id_for_cetak = 0;
		if(kwitansi_idField.getValue()!== null){
			kwitansi_id_for_cetak = kwitansi_idField.getValue();
		}
		if(kwitansi_cetak==1){
			cetak_kwitansi_print_only(kwitansi_id_for_cetak);
			kwitansi_cetak=0;
		}
		}
		//jproduk_btn_cancel();	
	}
	
  
  
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(kwitansi_post2db=='UPDATE')
			return cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function cetak_kwitansi_reset_form(){
		kwitansi_idField.reset();
		kwitansi_idField.setValue(null);
		kwitansi_noField.reset();
		kwitansi_noField.setValue(null);
		kwitansi_custField.reset();
		kwitansi_custField.setValue(null);
		kwitansi_tanggalField.setValue(dt.format('Y-m-d'));
		kwitansi_refField.reset();
		kwitansi_refField.setValue(null);
		kwitansi_nilaiField.reset();
		kwitansi_nilaiField.setValue(0);
		kwitansi_nilai_cfField.reset();
		kwitansi_nilai_cfField.setValue(0);
		kwitansi_keteranganField.reset();
		kwitansi_keteranganField.setValue(null);
		kwitansi_statusField.reset();
		kwitansi_statusField.setValue('Terbuka');
		
		kwitansi_total_nilaiField.reset();
		kwitansi_total_nilaiField.setValue(0);
		kwitansi_total_nilai_cfField.reset();
		kwitansi_total_nilai_cfField.setValue(null);
		kwitansi_total_bayarField.reset();
		kwitansi_total_bayarField.setValue(0);
		kwitansi_total_bayar_cfField.reset();
		kwitansi_total_bayar_cfField.setValue(null);
		
		kwitansi_status_lunasLabel.setText("");
		kwitansi_status_lunasField.reset();
		kwitansi_status_lunasField.setValue("");
		
		tunai_jual_kwitansi_reset_form();
		
		card_jual_kwitansi_reset_form();
		
		cek_jual_kwitansi_reset_form();
		
		transfer_jual_kwitansi_reset_form();
		
		kwitansi_caraField.setValue("");
		update_group_carabayar_kwitansi();
		kwitansi_tanggalField.setDisabled(false);
		kwitansi_custField.setDisabled(false);
		kwitansi_nilai_cfField.setDisabled(false);
		kwitansi_noField.setDisabled(false);
		kwitansi_cara_bayarTabPanel.setDisabled(false);
		kwitansi_bayar_tunaiGroup.setDisabled(false);
		kwitansi_keteranganField.setDisabled(false);
		kwitansi_statusField.setDisabled(false);
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		cetak_kwitansi_createForm.kwitansi_savePrint.enable();
		cetak_kwitansi_createForm.kwitansi_printOnly.disable();
		
		<?php } ?>
		
	}
 	/* End of Function */
	
	function tunai_jual_kwitansi_reset_form(){
		kwitansi_tunai_nilaiField.reset();
		kwitansi_tunai_nilai_cfField.reset();
	}
	
	function card_jual_kwitansi_reset_form(){
		kwitansi_card_namaField.reset();
		kwitansi_card_edcField.reset();
		kwitansi_card_noField.reset();
		kwitansi_card_nilaiField.reset();
		kwitansi_card_nilai_cfField.reset();
	}
	
	function cek_jual_kwitansi_reset_form(){
		kwitansi_cek_namaField.reset();
		kwitansi_cek_noField.reset();
		kwitansi_cek_validField.reset();
		kwitansi_cek_bankField.reset();
		kwitansi_cek_nilaiField.reset();
		kwitansi_cek_nilai_cfField.reset();
	}
	
	function transfer_jual_kwitansi_reset_form(){
		kwitansi_transfer_bankField.reset();
		kwitansi_transfer_namaField.reset();
		kwitansi_transfer_nilaiField.reset();
		kwitansi_transfer_nilai_cfField.reset();
	}
	
	function update_group_carabayar_kwitansi(){
		var value=kwitansi_caraField.getValue();
		kwitansi_bayar_tunaiGroup.setVisible(false);
		kwitansi_bayar_cardGroup.setVisible(false);
		kwitansi_bayar_cekGroup.setVisible(false);
		kwitansi_bayar_transferGroup.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		kwitansi_tunai_nilaiField.reset();
		kwitansi_tunai_nilai_cfField.reset();
		kwitansi_card_nilaiField.reset();
		kwitansi_card_nilai_cfField.reset();
		kwitansi_cek_nilaiField.reset();
		kwitansi_cek_nilai_cfField.reset();
		kwitansi_transfer_nilaiField.reset();
		kwitansi_transfer_nilai_cfField.reset();
		
		if(value=='card'){
			kwitansi_bayar_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			kwitansi_bayar_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			kwitansi_bayar_transferGroup.setVisible(true);
		}else if(value=='tunai'){
			kwitansi_bayar_tunaiGroup.setVisible(true);
		}
	}
  
	/* setValue to EDIT */
	function cetak_kwitansi_set_form(){
		kwitansi_idField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_id'));
		kwitansi_noField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_no'));
		kwitansi_custField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('cust_nama'));
		kwitansi_tanggalField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_tanggal'));
		kwitansi_refField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_ref'));
		kwitansi_nilaiField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
		kwitansi_nilai_cfField.setValue(CurrencyFormatted(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai')));
		kwitansi_keteranganField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_keterangan'));
		kwitansi_statusField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status'));
		kwitansi_caraField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_cara'));
		
		update_group_carabayar_kwitansi();
		
		switch(kwitansi_caraField.getValue()){
			case 'card' :
				card_jual_produk_DataStore.load({
					params : { no_faktur: kwitansi_noField.getValue() },
					callback: function(opts, success, response)  {
						 if (success) { 
							if(card_jual_produk_DataStore.getCount()){
								kwitansi_card_record=card_jual_produk_DataStore.getAt(0).data;
								kwitansi_card_namaField.setValue(kwitansi_card_record.jcard_nama);
								kwitansi_card_edcField.setValue(kwitansi_card_record.jcard_edc);
								kwitansi_card_noField.setValue(kwitansi_card_record.jcard_no);
								kwitansi_card_nilaiField.setValue(kwitansi_card_record.jcard_nilai);
								kwitansi_card_nilai_cfField.setValue(CurrencyFormatted(kwitansi_card_record.jcard_nilai));
								
								//load_pembayaran();
								kwitansi_total_nilaiField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
								kwitansi_total_nilai_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
								kwitansi_total_bayarField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
								kwitansi_total_bayar_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
								if(kwitansi_total_nilaiField.getValue()==kwitansi_total_bayarField.getValue() && kwitansi_total_bayarField.getValue()!=0){
									kwitansi_status_lunasLabel.setText("LUNAS");
									kwitansi_status_lunasField.setValue("LUNAS");
								}else{
									kwitansi_status_lunasLabel.setText("");
									kwitansi_status_lunasField.setValue("");
								}
							}
						 }
					}
				});
				break;
			case 'cek/giro':
				cek_jual_produk_DataStore.load({
					params : { no_faktur: kwitansi_noField.getValue() },
					callback: function(opts, success, response)  {
							if (success) {
								if(cek_jual_produk_DataStore.getCount()){
									kwitansi_cek_record=cek_jual_produk_DataStore.getAt(0).data;
									kwitansi_cek_namaField.setValue(kwitansi_cek_record.jcek_nama);
									kwitansi_cek_noField.setValue(kwitansi_cek_record.jcek_no);
									kwitansi_cek_validField.setValue(kwitansi_cek_record.jcek_valid);
									kwitansi_cek_bankField.setValue(kwitansi_cek_record.jcek_bank);
									kwitansi_cek_nilaiField.setValue(kwitansi_cek_record.jcek_nilai);
									kwitansi_cek_nilai_cfField.setValue(CurrencyFormatted(kwitansi_cek_record.jcek_nilai));
									
									//load_pembayaran();
									kwitansi_total_nilaiField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
									kwitansi_total_nilai_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
									kwitansi_total_bayarField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
									kwitansi_total_bayar_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
									if(kwitansi_total_nilaiField.getValue()==kwitansi_total_bayarField.getValue() && kwitansi_total_bayarField.getValue()!=0){
										kwitansi_status_lunasLabel.setText("LUNAS");
										kwitansi_status_lunasField.setValue("LUNAS");
									}else{
										kwitansi_status_lunasLabel.setText("");
										kwitansi_status_lunasField.setValue("");
									}
								}
							}
					 	}
				  });
				break;								
			case 'transfer' :
				transfer_jual_produk_DataStore.load({
						params : { no_faktur: kwitansi_noField.getValue() },
					  	callback: function(opts, success, response)  {
							if (success) {
									if(transfer_jual_produk_DataStore.getCount()){
										kwitansi_transfer_record=transfer_jual_produk_DataStore.getAt(0);
										kwitansi_transfer_bankField.setValue(kwitansi_transfer_record.data.jtransfer_bank);
										kwitansi_transfer_namaField.setValue(kwitansi_transfer_record.data.jtransfer_nama);
										kwitansi_transfer_nilaiField.setValue(kwitansi_transfer_record.data.jtransfer_nilai);
										kwitansi_transfer_nilai_cfField.setValue(CurrencyFormatted(kwitansi_transfer_record.data.jtransfer_nilai));
										
										//load_pembayaran();
										kwitansi_total_nilaiField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
										kwitansi_total_nilai_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
										kwitansi_total_bayarField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
										kwitansi_total_bayar_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
										if(kwitansi_total_nilaiField.getValue()==kwitansi_total_bayarField.getValue() && kwitansi_total_bayarField.getValue()!=0){
											kwitansi_status_lunasLabel.setText("LUNAS");
											kwitansi_status_lunasField.setValue("LUNAS");
										}else{
											kwitansi_status_lunasLabel.setText("");
											kwitansi_status_lunasField.setValue("");
										}
									}
							}
					 	}
				  });
				break;
			case 'tunai' :
				tunai_jual_produk_DataStore.load({
						params : { no_faktur: kwitansi_noField.getValue() },
					  	callback: function(opts, success, response)  {
							if (success) {
									if(tunai_jual_produk_DataStore.getCount()){
										kwitansi_tunai_record=tunai_jual_produk_DataStore.getAt(0);
										kwitansi_tunai_nilaiField.setValue(kwitansi_tunai_record.data.jtunai_nilai);
										kwitansi_tunai_nilai_cfField.setValue(CurrencyFormatted(kwitansi_tunai_record.data.jtunai_nilai));
										
										//load_pembayaran();
										kwitansi_total_nilaiField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
										kwitansi_total_nilai_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
										kwitansi_total_bayarField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
										kwitansi_total_bayar_cfField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_bayar'));
										if(kwitansi_total_nilaiField.getValue()==kwitansi_total_bayarField.getValue() && kwitansi_total_bayarField.getValue()!=0){
											kwitansi_status_lunasLabel.setText("LUNAS");
											kwitansi_status_lunasField.setValue("LUNAS");
										}else{
											kwitansi_status_lunasLabel.setText("");
											kwitansi_status_lunasField.setValue("");
										}
									}
							}
					 	}
				  });
				break;
		}
		
		
		kwitansi_statusField.on("select",function(){
			var status_awal_kwitansi = cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status');
			if(status_awal_kwitansi =='Terbuka' && kwitansi_statusField.getValue()=='Tertutup')
			{
			Ext.MessageBox.show({
				msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			   //progressText: 'proses...',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			kwitansi_statusField.setValue('Terbuka');
			}
			
			else if(status_awal_kwitansi =='Tertutup' && kwitansi_statusField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			kwitansi_statusField.setValue('Tertutup');
			}
			
			else if(status_awal_kwitansi =='Batal' && kwitansi_statusField.getValue()=='Terbuka')
			{
			Ext.MessageBox.show({
				msg: 'Status dokumen yang sudah Tertutup tidak dapat diganti Terbuka',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			   });
			kwitansi_statusField.setValue('Tertutup');
			}
			
			else if(kwitansi_statusField.getValue()=='Batal')
			{
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', kwitansi_status_batal);
			}
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			else if(status_awal_kwitansi =='Tertutup' && kwitansi_statusField.getValue()=='Tertutup'){
				
				cetak_kwitansi_createForm.kwitansi_savePrint.enable();
				cetak_kwitansi_createForm.kwitansi_printOnly.disable();
			}
			<?php } ?>
			
		});
		
		function kwitansi_status_batal(btn){
			if(btn=='yes')
			{
				kwitansi_statusField.setValue('Batal');
				<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
				cetak_kwitansi_createForm.kwitansi_savePrint.disable();
				cetak_kwitansi_createForm.kwitansi_printOnly.enable();
				<?php } ?>
			}  
			else
			kwitansi_statusField.setValue(cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status'));
		}
		
	}
	/* End setValue to EDIT*/
	
	function cetak_kwitansi_set_form_update(){
		if(kwitansi_post2db=="UPDATE" && cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status')=="Terbuka"){
			kwitansi_tanggalField.setDisabled(false);
			kwitansi_custField.setDisabled(false);
			kwitansi_nilai_cfField.setDisabled(false);
			kwitansi_cara_bayarTabPanel.setDisabled(false);
			kwitansi_noField.setDisabled(false);
			kwitansi_keteranganField.setDisabled(false);
			kwitansi_statusField.setDisabled(false);
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			cetak_kwitansi_createForm.kwitansi_savePrint.enable();
			cetak_kwitansi_createForm.kwitansi_printOnly.disable();
			<?php } ?>
		}
		if(kwitansi_post2db=="UPDATE" && cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status')=="Tertutup"){
			kwitansi_tanggalField.setDisabled(true);
			kwitansi_custField.setDisabled(true);
			kwitansi_nilai_cfField.setDisabled(true);
			kwitansi_cara_bayarTabPanel.setDisabled(true);
			kwitansi_noField.setDisabled(true);
			kwitansi_keteranganField.setDisabled(true);
			kwitansi_statusField.setDisabled(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			cetak_kwitansi_createForm.kwitansi_savePrint.disable();
			cetak_kwitansi_createForm.kwitansi_printOnly.enable();
			<?php } ?>
			
		}
		if(kwitansi_post2db=="UPDATE" && cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status')=="Batal"){
			kwitansi_tanggalField.setDisabled(true);
			kwitansi_custField.setDisabled(true);
			kwitansi_nilai_cfField.setDisabled(true);
			kwitansi_cara_bayarTabPanel.setDisabled(true);
			kwitansi_noField.setDisabled(true);
			kwitansi_keteranganField.setDisabled(true);
			kwitansi_statusField.setDisabled(true);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			cetak_kwitansi_createForm.kwitansi_savePrint.disable();
			cetak_kwitansi_createForm.kwitansi_printOnly.enable();
			<?php } ?>
		
		}
		/*
		if(kwitansi_post2db=='UPDATE' &&
		   ((cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status')=='Tertutup') || (cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status')=='Batal'))){
			kwitansi_tanggalField.setDisabled(true);
			kwitansi_custField.setDisabled(true);
			kwitansi_nilai_cfField.setDisabled(true);
			kwitansi_cara_bayarTabPanel.setDisabled(true);
			kwitansi_post2db='UPDATE';
		}else if((kwitansi_post2db=='UPDATE') && (cetak_kwitansiListEditorGrid.getSelectionModel().getSelected().get('kwitansi_status')=='Terbuka')){
			kwitansi_tanggalField.setDisabled(false);
			kwitansi_custField.setDisabled(false);
			kwitansi_nilai_cfField.setDisabled(false);
			kwitansi_cara_bayarTabPanel.setDisabled(false);
			kwitansi_post2db='UPDATE';
		}else if(kwitansi_post2db=='CREATE' ){
			kwitansi_tanggalField.setDisabled(false);
			kwitansi_custField.setDisabled(false);
			kwitansi_nilai_cfField.setDisabled(false);
			kwitansi_cara_bayarTabPanel.setDisabled(false);
			kwitansi_post2db='CREATE';
		}*/
	}
  
	/* Function for Check if the form is valid */
	function is_cetak_kwitansi_form_valid(){
		return (kwitansi_custField.isValid() && true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		cbo_custDataStore.load();
		jual_kwitansi_DataStore.load({params : {master_id : 0, start:0, limit:kwitansi_pageS}});
		if(!cetak_kwitansi_createWindow.isVisible()){
			cetak_kwitansi_reset_form();
			kwitansi_caraField.setValue("card");
			kwitansi_bayar_cardGroup.setVisible(true);
			kwitansi_post2db='CREATE';
			msg='created';
			kwitansi_noField.setValue('(Auto)');
			kwitansi_statusField.setValue("Terbuka");
			cetak_kwitansi_createWindow.show();
		} else {
			cetak_kwitansi_createWindow.toFront();
		}
	}
  	/* End of Function */
	
	/* Reset form before loading */
	function cetak_kwitansi_adj_reset_form(){
		kwitansi_adj_nilaiField.reset();
		kwitansi_adj_keteranganField.setValue(null);
	}
 	/* End of Function */
	
	/* Function for Displaying  Adjustment Window Form */
	function adj_kwitansi(){
		if(!cetak_kwitansi_adj_saveWindow.isVisible()){
			post2db='ADJ';
			cetak_kwitansi_adj_reset_form();
			cetak_kwitansi_adj_saveWindow.show();
		} else {
			cetak_kwitansi_adj_saveWindow.toFront();
		}
	}
  	/* End of Function */
	
	/* Identify  kwitansi_nilai Field */
	
	kwitansi_adj_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_adj_nilai_cfField',
		fieldLabel: 'Nilai (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				kwitansi_adj_nilaiField.setValue(cf_tonumber);
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	kwitansi_adj_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_adj_nilaiField',
		fieldLabel: 'Nilai (Rp)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: true,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  kwitansi_keterangan Field */
	kwitansi_adj_keteranganField= new Ext.form.TextArea({
		id: 'kwitansi_adj_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	/*Function for pengecekan status ADJ */
	function adj_kwitansi_save(){

		var selections = cetak_kwitansiListEditorGrid.selModel.getSelections();
		var kwitansi_id = [];
		var dapaket_stat_dok = [];
		var kwitansi_adj_nilai_create = null;
		var kwitansi_adj_ket_create = null;
		for(i = 0; i< cetak_kwitansiListEditorGrid.selModel.getCount(); i++){
			kwitansi_id.push(selections[i].json.kwitansi_id);
			if(kwitansi_adj_keteranganField.getValue()!== null){kwitansi_adj_ket_create = kwitansi_adj_keteranganField.getValue();}
			if(kwitansi_adj_nilaiField.getValue()!== null){kwitansi_adj_nilai_create = kwitansi_adj_nilaiField.getValue();} 
		}
		var encoded_array_kwitansi_id = Ext.encode(kwitansi_id);

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_cetak_kwitansi&m=get_action',
			params: {
				task: "ADJ",
				kwitansi_id	: temp_master_id.getValue(),
				adj_kwitansi_ket : kwitansi_adj_ket_create,
				adj_kwitansi_nilai : kwitansi_adj_nilai_create
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert('Information','Adjustment Kwitansi berhasil disimpan');
						cetak_kwitansi_adj_saveWindow.hide();
						//ambil_paket_DataStore.reload();
						//detail_ambil_paketStore.load({params: {dapaket_dpaket: dapaket_dpaket_idField.getValue()}});
						break;
					case 2:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Status tidak bisa dirubah, hubungi admin',
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
	
	/* Function for retrieve create Window Panel*/
	kwitansi_adj_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kwitansi_adj_nilai_cfField,kwitansi_adj_keteranganField]
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			{
				text: 'Save and Close',
				handler: adj_kwitansi_save
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					cetak_kwitansi_adj_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	cetak_kwitansi_adj_saveWindow= new Ext.Window({
		id: 'cetak_kwitansi_adj_saveWindow',
		title: 'Adjustment Kwitansi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kwitansi_adj_save',
		items: kwitansi_adj_saveForm
	});
	/* End Window */
 
  	/* Function for Delete Confirm */
	function cetak_kwitansi_confirm_delete(){
		// only one cetak_kwitansi is selected here
		if(cetak_kwitansiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', cetak_kwitansi_delete);
		} else if(cetak_kwitansiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', cetak_kwitansi_delete);
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
	function cetak_kwitansi_confirm_update(){
		/* only one record is selected here */
		if(cetak_kwitansiListEditorGrid.selModel.getCount() == 1) {
			cetak_kwitansi_set_form();
			kwitansi_post2db='UPDATE';
			jual_kwitansi_DataStore.setBaseParam('master_id',eval(get_pk_id()));
			jual_kwitansi_DataStore.load({
				params : {master_id : eval(get_pk_id()), start:0, limit:kwitansi_pageS},
				callback: function(opts, success, response){
					if(success){
						cetak_kwitansi_set_form_update();
						cetak_kwitansi_createWindow.show();
					}
				}
			});
			msg='updated';
			//cetak_kwitansi_createWindow.show();
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
	function cetak_kwitansi_delete(btn){
		if(btn=='yes'){
			var selections = cetak_kwitansiListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< cetak_kwitansiListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kwitansi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_cetak_kwitansi&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							cetak_kwitansi_DataStore.reload();
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
	cetak_kwitansi_DataStore = new Ext.data.Store({
		id: 'cetak_kwitansi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kwitansi_id'
		},[
			{name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'}, 
			{name: 'kwitansi_no', type: 'string', mapping: 'kwitansi_no'}, 
			{name: 'kwitansi_cust', type: 'int', mapping: 'kwitansi_cust'},
			{name: 'kwitansi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'kwitansi_tanggal'}, 
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'kwitansi_cara', type: 'string', mapping: 'kwitansi_cara'}, 
			{name: 'kwitansi_nilai', type: 'float', mapping: 'kwitansi_nilai'}, 
			{name: 'kwitansi_bayar', type: 'float', mapping: 'kwitansi_bayar'}, 
			{name: 'kwitansi_keterangan', type: 'string', mapping: 'kwitansi_keterangan'}, 
			{name: 'kwitansi_status', type: 'string', mapping: 'kwitansi_status'},
			{name: 'total_terpakai', type: 'int', mapping: 'total_terpakai'},
			{name: 'total_sisa', type: 'int', mapping: 'total_sisa'},
			{name: 'kwitansi_creator', type: 'string', mapping: 'kwitansi_creator'}, 
			{name: 'kwitansi_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'kwitansi_date_create'}, 
			{name: 'kwitansi_update', type: 'string', mapping: 'kwitansi_update'}, 
			{name: 'kwitansi_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kwitansi_date_update'}, 
			{name: 'kwitansi_revised', type: 'int', mapping: 'kwitansi_revised'} 
		]),
		sortInfo:{field: 'kwitansi_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_custDataStore = new Ext.data.Store({
		id: 'cbo_custDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_customer_list', 
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
	var customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
 //           '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
 //           'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat}',
        '</div></tpl>'
    );
	
	/* GET Bank-List.Store */
	kwitansi_bankDataStore = new Ext.data.Store({
		id:'kwitansi_bankDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_bank_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
		/* dataIndex => insert intomaster_jual_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'kwitansi_bank_value', type: 'int', mapping: 'mbank_id'}, 
			{name: 'kwitansi_bank_display', type: 'string', mapping: 'mbank_nama'}
		]),
		sortInfo:{field: 'kwitansi_bank_display', direction: "DESC"}
		});
	/* END GET Bank-List.Store */
	
	/* Function for Retrieve Kwitansi DataStore */
	card_jual_produk_DataStore = new Ext.data.Store({
		id: 'card_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_card_by_ref', 
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
	cek_jual_produk_DataStore = new Ext.data.Store({
		id: 'cek_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_cek_by_ref', 
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
	transfer_jual_produk_DataStore = new Ext.data.Store({
		id: 'transfer_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_transfer_by_ref', 
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
	tunai_jual_produk_DataStore = new Ext.data.Store({
		id: 'tunai_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=get_tunai_by_ref', 
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
    
  	/* Function for Identify of Window Column Model */
	cetak_kwitansi_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'kwitansi_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'kwitansi_tanggal',
			width: 80,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		}, 
		{
			header: '<div align="center">' + 'No Kuitansi' + '</div>',
			dataIndex: 'kwitansi_no',
			width: 80,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 20
          	})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'cust_no',
			width: 80,	//210,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'cust_nama',
			width: 200,	//210,
			sortable: true
		}, 
		{
			header: 'Ref',
			dataIndex: 'kwitansi_ref',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
			<?php }?>
		}, 
		{
			header: '<div align="center">' + 'Nilai (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'kwitansi_nilai',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000')			
		}, 
		{
			header: '<div align="center">' + 'Sisa (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'total_sisa',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000')			
		}, 
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kwitansi_keterangan',
			width: 200,	//210,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
			<?php } ?>
		}, 
		{
			header: 'Stat Dok',
			dataIndex: 'kwitansi_status',
			width: 80,	//55,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['kwitansi_status_value', 'kwitansi_status_display'],
					data: [['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
					}),
				mode: 'local',
               	displayField: 'kwitansi_status_display',
               	valueField: 'kwitansi_status_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		}, 
		{
			header: 'Creator',
			dataIndex: 'kwitansi_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'kwitansi_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'kwitansi_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'kwitansi_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'kwitansi_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	cetak_kwitansi_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	cetak_kwitansiListEditorGrid =  new Ext.grid.GridPanel({
		id: 'cetak_kwitansiListEditorGrid',
		el: 'fp_cetak_kwitansi',
		title: 'Daftar Kuitansi',
		autoHeight: true,
		store: cetak_kwitansi_DataStore, // DataStore
		cm: cetak_kwitansi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: kwitansi_pageS,
			store: cetak_kwitansi_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: cetak_kwitansi_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: cetak_kwitansi_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: cetak_kwitansi_DataStore,
			params: {task: 'LIST',start: 0, limit: kwitansi_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						cetak_kwitansi_DataStore.baseParams={task:'LIST',start: 0, limit: kwitansi_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Kuitansi<br>- Nama Customer<br>- No Customer<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: cetak_kwitansi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: cetak_kwitansi_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: cetak_kwitansi_print  
		}
		]
	});
	cetak_kwitansiListEditorGrid.render();
	/* End of DataStore */
	
	cetak_kwitansiListEditorGrid.on('rowclick', function (cetak_kwitansiListEditorGrid, rowIndex, eventObj) {
        var recordMaster = cetak_kwitansiListEditorGrid.getSelectionModel().getSelected();
        detail_pakai_kwitansiStore.setBaseParam('master_id',recordMaster.get("kwitansi_id"));
		detail_pakai_kwitansiStore.load({params : {master_id : recordMaster.get("kwitansi_id"), start:0, limit:kwitansi_pageS}});
		temp_master_id.setValue(recordMaster.get("kwitansi_id"));
		cetak_kwitansi_DataStore.reload();
    });
     
	/* Create Context Menu */
	cetak_kwitansi_ContextMenu = new Ext.menu.Menu({
		id: 'cetak_kwitansi_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: cetak_kwitansi_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: cetak_kwitansi_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: cetak_kwitansi_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: cetak_kwitansi_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function oncetak_kwitansi_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		cetak_kwitansi_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		cetak_kwitansi_SelectedRow=rowIndex;
		cetak_kwitansi_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function cetak_kwitansi_editContextMenu(){
		//cetak_kwitansiListEditorGrid.startEditing(cetak_kwitansi_SelectedRow,1);
		cetak_kwitansi_confirm_update();
  	}
	/* End of Function */
  	
	cetak_kwitansiListEditorGrid.addListener('rowcontextmenu', oncetak_kwitansi_ListEditGridContextMenu);
	cetak_kwitansi_DataStore.load({params: {start: 0, limit: kwitansi_pageS}});	// load DataStore
	cetak_kwitansiListEditorGrid.on('afteredit', cetak_kwitansi_update); // inLine Editing Record
	
	/* Identify  kwitansi_id Field */
	temp_master_id= new Ext.form.NumberField({
		id: 'temp_master_id'
	});
	
	/* Identify  kwitansi_id Field */
	kwitansi_idField= new Ext.form.NumberField({
		id: 'kwitansi_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  kwitansi_no Field */
	kwitansi_noField= new Ext.form.TextField({
		id: 'kwitansi_noField',
		fieldLabel: 'No Kuitansi',
		maxLength: 20,
		readOnly:true,
		emptyText: '(Auto)',
		anchor: '100%'
	});
	/* Identify  kwitansi_cust Field */
	kwitansi_custField= new Ext.form.ComboBox({
		id: 'kwitansi_custField',
		fieldLabel: 'Customer',
		store: cbo_custDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '100%'
	});
	/* Identify  kwitansi_ref Field */
	kwitansi_refField= new Ext.form.NumberField({
		id: 'kwitansi_refField',
		fieldLabel: 'Ref',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
				anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_nilai_cfField',
		fieldLabel: 'Nilai (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		emptyText: '0',
		itemCls: 'rmoney',
		anchor: '100%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				kwitansi_nilaiField.setValue(cf_tonumber);
				kwitansi_total_nilaiField.setValue(cf_tonumber);
				load_pembayaran();
				
				var label_terbilang = terbilang(cf_tonumber);
				kwitansi_terbilangLabel.setText(label_terbilang);
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	/* Identify  kwitansi_nilai Field */
	kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_nilaiField',
		fieldLabel: 'Nilai (Rp)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: true,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  kwitansi_keterangan Field */
	kwitansi_keteranganField= new Ext.form.TextArea({
		id: 'kwitansi_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  kwitansi_status Field */
	kwitansi_statusField= new Ext.form.ComboBox({
		id: 'kwitansi_statusField',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['kwitansi_status_value', 'kwitansi_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'kwitansi_status_display',
		valueField: 'kwitansi_status_value',
		//emptyText: 'Terbuka',
		anchor: '95%',
		triggerAction: 'all'	
	});

	kwitansi_total_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_total_nilai_cfField',
		fieldLabel: '<b>Total (Rp)</b>',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	kwitansi_total_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_total_nilaiField',
		enableKeyEvents: true,
		fieldLabel: '<b>Total (Rp)</b>',
		allowBlank: true,
		width : 120,
		readOnly : true,
		itemCls : 'rmoney',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  kwitansi_total_nilai Field */
	/*
	kwitansi_total_nilaiField= new Ext.ux.form.CFTextField({
		id: 'kwitansi_total_nilaiField',
		fieldLabel: '<b>Total (Rp)</b>',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		itemCls: 'rmoney',
		width: 120
	});
	*/
	
	
	/*Identify kwitansi_tanggal Field  */
	kwitansi_tanggalField= new Ext.form.DateField({
		id: 'kwitansi_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	
	
	kwitansi_total_bayar_cfField= new Ext.form.TextField({
		id: 'kwitansi_total_bayar_cfField',
		fieldLabel: 'Total Bayar (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	kwitansi_total_bayarField= new Ext.form.NumberField({
		id: 'kwitansi_total_bayarField',
		enableKeyEvents: true,
		fieldLabel: 'Total Bayar (Rp)',
		allowBlank: true,
		width : 120,
		readOnly : true,
		itemCls : 'rmoney',
		maskRe: /([0-9]+)$/
	});
	
	
	
	/* Identify  kwitansi_total_bayar Field */
	/*
	kwitansi_total_bayarField= new Ext.ux.form.CFTextField({
		id: 'kwitansi_total_bayarField',
		fieldLabel: 'Total Bayar (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		itemCls: 'rmoney',
		width: 120
	});
	*/
	
	
	kwitansi_status_lunasLabel= new Ext.form.Label({
		ctCls: 'status_lunas'
	});
	kwitansi_status_lunasField= new Ext.form.TextField();
	
	/*kwitansi_nilaiField.on('keyup', function(){
		kwitansi_total_nilaiField.setValue(kwitansi_nilaiField.getValue());
	});*/
	kwitansi_terbilangLabel= new Ext.form.Label();
	
	//START Bayar Tunai
	kwitansi_tunai_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_tunai_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				kwitansi_tunai_nilaiField.setValue(cf_tonumber);
				load_pembayaran();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	kwitansi_tunai_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_tunai_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	kwitansi_bayar_tunaiGroup = new Ext.form.FieldSet({
		title: 'Tunai',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '99%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kwitansi_tunai_nilai_cfField] 
			}
		]
	
	});
	// END Bayar Tunai
	
	// START Bayar Card
	kwitansi_card_namaField= new Ext.form.ComboBox({
		id: 'kwitansi_card_namaField',
		fieldLabel: 'Jenis Kartu',
		store:new Ext.data.SimpleStore({
			fields:['kwitansi_card_value', 'kwitansi_card_display'],
			data:[['VISA','VISA'],['MASTERCARD','MASTERCARD'],['Debit','Debit']]
		}),
		mode: 'local',
		displayField: 'kwitansi_card_display',
		valueField: 'kwitansi_card_value',
		allowBlank: true,
		width: 110,
		triggerAction: 'all',
		lazyRenderer: true
	});
	
		
	kwitansi_card_edcField= new Ext.form.ComboBox({
		id: 'kwitansi_card_edcField',
		fieldLabel: 'EDC',
		store:new Ext.data.SimpleStore({
			fields:['kwitansi_card_edc_value', 'kwitansi_card_edc_display'],
			data:[['1','1'],['2','2'],['3','3']]
		}),
		mode: 'local',
		displayField: 'kwitansi_card_edc_display',
		valueField: 'kwitansi_card_edc_value',
		allowBlank: true,
		width: 110,
		triggerAction: 'all',
		lazyRenderer: true
	});

	kwitansi_card_noField= new Ext.form.TextField({
		id: 'kwitansi_card_noField',
		fieldLabel: 'No. Kartu',
		maxLength: 30,
		anchor: '95%'
	});
	
	kwitansi_card_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_card_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				kwitansi_card_nilaiField.setValue(cf_tonumber);
				load_pembayaran();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	kwitansi_card_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_card_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	kwitansi_bayar_cardGroup= new Ext.form.FieldSet({
		title: 'Credit Card',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '99%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kwitansi_card_namaField,kwitansi_card_edcField,kwitansi_card_noField,kwitansi_card_nilai_cfField] 
			}
		]
	
	});
	// END Bayar Card
	// START Bayar Cek
	kwitansi_cek_namaField= new Ext.form.TextField({
		id: 'kwitansi_cek_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%'
	});
	
	kwitansi_cek_noField= new Ext.form.TextField({
		id: 'kwitansi_cek_noField',
		fieldLabel: 'No. Cek/Giro',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	kwitansi_cek_validField= new Ext.form.DateField({
		id: 'kwitansi_cek_validField',
		allowBlank: true,
		fieldLabel: 'Valid',
		format: 'Y-m-d'
	});
	
	kwitansi_cek_bankField= new Ext.form.ComboBox({
		id: 'kwitansi_cek_bankField',
		fieldLabel: 'Bank',
		store: kwitansi_bankDataStore,
		mode: 'remote',
		displayField: 'kwitansi_bank_display',
		valueField: 'kwitansi_bank_value',
		allowBlank: true,
		anchor: '69%',
		triggerAction: 'all'
	});
	
	kwitansi_cek_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_cek_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				kwitansi_cek_nilaiField.setValue(cf_tonumber);
				load_pembayaran();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	kwitansi_cek_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_cek_nilaiField',
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	
	kwitansi_bayar_cekGroup = new Ext.form.FieldSet({
		title: 'Check/Giro',
		collapsible: true,
		layout:'column',
		anchor: '99%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kwitansi_cek_namaField,kwitansi_cek_noField,kwitansi_cek_validField,kwitansi_cek_bankField,kwitansi_cek_nilai_cfField] 
			}
		]
	
	});
	// END Bayar Cek
	
	// START Bayar Transfer
	kwitansi_transfer_bankField= new Ext.form.ComboBox({
		id: 'kwitansi_transfer_bankField',
		fieldLabel: 'Bank',
		store: kwitansi_bankDataStore,
		mode: 'remote',
		displayField: 'kwitansi_bank_display',
		valueField: 'kwitansi_bank_value',
		allowBlank: true,
		anchor: '69%',
		triggerAction: 'all',
		lazyRenderer: true
	});

	kwitansi_transfer_namaField= new Ext.form.TextField({
		id: 'kwitansi_transfer_namaField',
		fieldLabel: 'Atas Nama',
		allowBlank: true,
		anchor: '95%',
		maxLength: 50
	});
	
	kwitansi_transfer_nilai_cfField= new Ext.form.TextField({
		id: 'kwitansi_transfer_nilai_cfField',
		fieldLabel: 'Jumlah (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		anchor: '95%',
		listeners: {
			'keyup': function(){
				var cf_tonumber = convertToNumber(this.getValue());
				kwitansi_transfer_nilaiField.setValue(cf_tonumber);
				load_pembayaran();
				
				var number_tocf = CurrencyFormatted(this.getValue());
				this.setRawValue(number_tocf);
			}
		},
		maskRe: /([0-9]+)$/ 
	});
	kwitansi_transfer_nilaiField= new Ext.form.NumberField({
		id: 'kwitansi_transfer_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Jumlah (Rp)',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	kwitansi_bayar_transferGroup= new Ext.form.FieldSet({
		title: 'Transfer',
		collapsible: true,
		layout:'column',
		anchor: '99%',
		hidden: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kwitansi_transfer_bankField,kwitansi_transfer_namaField,kwitansi_transfer_nilai_cfField] 
			}
		]
	
	});
	// END Bayar Transfer
	
	/* Identify  kwitansi_cara Field */
	kwitansi_caraField= new Ext.form.ComboBox({
		id: 'kwitansi_caraField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['kwitansi_cara_value', 'kwitansi_cara_display'],
			data:[['tunai','Tunai'],['card','Kartu Kredit'],['cek/giro','Cek/Giro'],['transfer','Transfer'],['retur','Retur']]
		}),
		mode: 'local',
		displayField: 'kwitansi_cara_display',
		valueField: 'kwitansi_cara_value',
		editable: false,
		anchor: '65%',
		//width: 60,
		triggerAction: 'all'	
	});
	kwitansi_caraField.on('select', function(){
		var value=kwitansi_caraField.getValue();
		kwitansi_bayar_tunaiGroup.setVisible(false);
		kwitansi_bayar_cardGroup.setVisible(false);
		kwitansi_bayar_cekGroup.setVisible(false);
		kwitansi_bayar_transferGroup.setVisible(false);
		//RESET Nilai di Cara Bayar-1
		/*kwitansi_tunai_nilaiField.reset();
		kwitansi_tunai_nilai_cfField.reset();
		kwitansi_card_nilaiField.reset();
		kwitansi_card_nilai_cfField.reset();
		kwitansi_cek_nilaiField.reset();
		kwitansi_cek_nilai_cfField.reset();
		kwitansi_transfer_nilaiField.reset();
		kwitansi_transfer_nilai_cfField.reset();*/
		
		tunai_jual_kwitansi_reset_form();
		
		card_jual_kwitansi_reset_form();
		
		cek_jual_kwitansi_reset_form();
		
		transfer_jual_kwitansi_reset_form();
		
		if(value=='card'){
			kwitansi_bayar_cardGroup.setVisible(true);
		}else if(value=='cek/giro'){
			kwitansi_bayar_cekGroup.setVisible(true);
		}else if(value=='transfer'){
			kwitansi_bayar_transferGroup.setVisible(true);
		}else if(value=='tunai'){
			kwitansi_bayar_tunaiGroup.setVisible(true);
		}
		load_pembayaran();
	});
	
	kwitansi_cara_bayarTabPanel = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		//autoHeigth: true,
		frame: true,
		height: 242,
		width: 350,
		defaults:{bodyStyle:'padding:10px'},
		items:[{
                title:'Cara Bayar',
                layout:'form',
				frame: true,
                defaults: {width: 200},
                defaultType: 'textfield',

                items: [kwitansi_caraField,kwitansi_bayar_tunaiGroup,kwitansi_bayar_cardGroup,kwitansi_bayar_cekGroup,kwitansi_bayar_transferGroup]
            }]
	});
	
	kwitansi_bayarGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		frame: true,
		items:[
			   {
				columnWidth:0.6,
				layout: 'form',
				border:false,
				items: [kwitansi_cara_bayarTabPanel] 
			}
			,{
				columnWidth:0.4,
				labelWidth: 100,
				layout: 'form',
    			labelPad: 8,
				baseCls: 'x-plain',
				border:false,
				anchor: '100%',
				labelAlign: 'left',
				items: [{xtype: 'spacer',height:10}, kwitansi_status_lunasLabel] 
			}
			]
	
	});
	
  	/*Fieldset Master*/
	cetak_kwitansi_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.48,
				layout: 'form',
				border:false,
				items: [kwitansi_tanggalField, kwitansi_noField, kwitansi_custField, kwitansi_nilai_cfField, kwitansi_terbilangLabel, kwitansi_idField] 
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
				items: [kwitansi_keteranganField, kwitansi_statusField] 
			}
			]
	
	});
	
	kwitansi_tunai_nilaiField.on('keyup', load_pembayaran);
	kwitansi_card_nilaiField.on('keyup', load_pembayaran);
	kwitansi_cek_nilaiField.on('keyup', load_pembayaran);
	kwitansi_transfer_nilaiField.on('keyup', load_pembayaran);
	
	function load_pembayaran(){
		/*var kwitansi_tunai_nilai=0;
		var kwitansi_card_nilai=0;
		var kwitansi_cek_nilai=0;
		var kwitansi_transfer_nilai=0;*/
		var total_bayar=0;
		
		kwitansi_tunai_nilai=kwitansi_tunai_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_tunai_nilai))
			kwitansi_tunai_nilai=kwitansi_tunai_nilaiField.getValue();
		else
			kwitansi_tunai_nilai=0;
		
		kwitansi_card_nilai=kwitansi_card_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_card_nilai))
			kwitansi_card_nilai=kwitansi_card_nilaiField.getValue();
		else
			kwitansi_card_nilai=0;
		
		kwitansi_cek_nilai=kwitansi_cek_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_cek_nilai))
			kwitansi_cek_nilai=kwitansi_cek_nilaiField.getValue();
		else
			kwitansi_cek_nilai=0;
		
		kwitansi_transfer_nilai=kwitansi_transfer_nilaiField.getValue();
		if(/^\d+$/.test(kwitansi_transfer_nilai))
			kwitansi_transfer_nilai=kwitansi_transfer_nilaiField.getValue();
		else
			kwitansi_transfer_nilai=0;
		
		total_bayar=kwitansi_tunai_nilai+kwitansi_card_nilai+kwitansi_cek_nilai+kwitansi_transfer_nilai;
		total_bayar=(total_bayar>0?Math.round(total_bayar):0);
		kwitansi_total_bayarField.setValue(total_bayar);
		kwitansi_total_bayar_cfField.setValue(CurrencyFormatted(total_bayar));
		if(kwitansi_total_nilaiField.getValue()==total_bayar && total_bayar!=0){
			kwitansi_status_lunasLabel.setText("LUNAS");
			kwitansi_status_lunasField.setValue("LUNAS");
		}else{
			kwitansi_status_lunasLabel.setText("");
			kwitansi_status_lunasField.setValue("");
		}
		
	}
	
	/* START History Pemakaian Kwitansi*/
	/* Start History DataStore */
	detail_pakai_kwitansiStore = new Ext.data.GroupingStore({
		id: 'detail_pakai_kwitansiStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=detail_jual_kwitansi_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:kwitansi_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
			//id: 'app_id'
		},[
        	{name: 'jkwitansi_id', type: 'int', mapping: 'jkwitansi_id'}, 
			{name: 'jkwitansi_master', type: 'int', mapping: 'jkwitansi_master'}, 
			{name: 'jkwitansi_ref', type: 'string', mapping: 'jkwitansi_ref'}, 
			{name: 'jkwitansi_nilai', type: 'float', mapping: 'jkwitansi_nilai'}, 
			{name: 'customer_id', type: 'int', mapping: 'customer_id'}, 
			{name: 'customer_nama', type: 'string', mapping: 'customer_nama'}, 
			{name: 'customer_no', type: 'string', mapping: 'customer_no'}, 
			{name: 'jkwitansi_creator', type: 'string', mapping: 'jkwitansi_creator'}, 
			{name: 'jkwitansi_keterangan', type: 'string', mapping: 'jkwitansi_keterangan'}, 
			{name: 'jkwitansi_date_create', type: 'date', dateFormat: 'd-m-Y', mapping: 'jkwitansi_date_create'}, 
			{name: 'jkwitansi_update', type: 'string', mapping: 'jkwitansi_update'}, 
			{name: 'jkwitansi_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'jkwitansi_date_update'}, 
			{name: 'jkwitansi_revised', type: 'int', mapping: 'jkwitansi_revised'} 
		]),
		sortInfo:{field: 'customer_nama', direction: "ASC"},
		groupField: 'customer_nama'
	});
	/* End DataStore */
	//detail_pakai_kwitansiStore.load({params: {master_id: '0'}});
	
	detail_pakai_kwitansiColumnModel = new Ext.grid.ColumnModel(
		[
/*
		{
			header: '<div align="center">' + 'Tgl Adj' + '</div>',
			dataIndex: 'jkwitansi_date_create',
			width: 50,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		},
*/
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',	//'Referensi',
			dataIndex: 'jkwitansi_ref',
			width: 80,	//150,
			sortable: true,
			summaryType: 'count',
			summaryRenderer: function(v, params, data){
				return ((v === 0 || v > 1) ? '(' + v +'x Pemakaian)' : '(1x Pemakaian)');
			}
		},
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'customer_no',
			width: 80,
			sortable: true
		},
		{
			header: 'Customer',
			dataIndex: 'customer_nama',
			width: 150,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'jkwitansi_keterangan',
			width: 130,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Nilai (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jkwitansi_nilai',
			width: 80,	//150,
			sortable: true,
			summaryType: 'sum',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			summaryRenderer: function(v, params, data){
				return 'Total: &nbsp;&nbsp;&nbsp;'+Ext.util.Format.number(v, '0,000');
			}
		}]
    );
    detail_pakai_kwitansiColumnModel.defaultSortable= true;

	var history_pakai_kwitansiPanel = new Ext.grid.GridPanel({
		id: 'history_pakai_kwitansiPanel',
		title: 'Detail Pemakaian Kuitansi',
        store: detail_pakai_kwitansiStore,
        cm: detail_pakai_kwitansiColumnModel,
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
		plugins: summary,
        stripeRows: true,
        autoExpandColumn: 'customer_nama',
        autoHeight: true,
		style: 'margin-top: 10px',
        width: 1220	//800
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_AMBILPAKET'))){ ?>
		,tbar: [
				{
					text: 'Adjustment',
					tooltip: 'Mengubah status menjadi Adj',
					iconCls:'icon-update',    				// this is defined in our styles.css
					handler: adj_kwitansi
				}
			]
		<?php } ?>
    });
    history_pakai_kwitansiPanel.render('history_pakai_kwitansi');

	/* END History Pemakaian Kwitansi */
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var jual_kwitansi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'jkwitansi_id', type: 'int', mapping: 'jkwitansi_id'}, 
			{name: 'jkwitansi_master', type: 'int', mapping: 'jkwitansi_master'}, 
			{name: 'jkwitansi_ref', type: 'string', mapping: 'jkwitansi_ref'}, 
			{name: 'jkwitansi_nilai', type: 'float', mapping: 'jkwitansi_nilai'}, 			
			{name: 'customer_id', type: 'int', mapping: 'customer_id'}, 
			{name: 'customer_nama', type: 'string', mapping: 'customer_nama'}, 
			{name: 'customer_no', type: 'string', mapping: 'customer_no'}, 
			{name: 'jkwitansi_creator', type: 'string', mapping: 'jkwitansi_creator'}, 
			{name: 'jkwitansi_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'jkwitansi_date_create'}, 
			{name: 'jkwitansi_update', type: 'string', mapping: 'jkwitansi_update'}, 
			{name: 'jkwitansi_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'jkwitansi_date_update'}, 
			{name: 'jkwitansi_revised', type: 'int', mapping: 'jkwitansi_revised'} 
	]);
	//eof
	
	//function for json writer of detail
	var jual_kwitansi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	jual_kwitansi_DataStore = new Ext.data.Store({
		id: 'jual_kwitansi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cetak_kwitansi&m=detail_jual_kwitansi_list', 
			method: 'POST'
		}),
		reader: jual_kwitansi_reader,
		baseParams:{master_id: kwitansi_idField.getValue()},
		sortInfo:{field: 'jkwitansi_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_jual_kwitansi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	//declaration of detail coloumn model
	jual_kwitansi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',	//'Referensi',
			dataIndex: 'jkwitansi_ref',
			width: 80,	//150,
			sortable: true,
/*			editor: new Ext.form.TextField({
				maxLength: 50
          	})
*/		},
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'customer_no',
			width: 80,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'customer_nama',
			width: 200,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Nilai (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'jkwitansi_nilai',
			width: 100,	//150,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000')			
		}
/*		{
			header: 'Jkwitansi Creator',
			dataIndex: 'jkwitansi_creator',
			width: 150,
			sortable: true,
			hidden:true,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
		},
		{
			header: 'Jkwitansi Date Create',
			dataIndex: 'jkwitansi_date_create',
			width: 150,
			sortable: true,
			hidden:true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new Ext.form.DateField({
				format: 'Y-m-d'
			})
		},
		{
			header: 'Jkwitansi Update',
			dataIndex: 'jkwitansi_update',
			width: 150,
			sortable: true,
			hidden:true,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
		},
		{
			header: 'Jkwitansi Date Update',
			dataIndex: 'jkwitansi_date_update',
			width: 150,
			sortable: true,
			hidden:true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new Ext.form.DateField({
				format: 'Y-m-d'
			})
		},
		{
			header: 'Jkwitansi Revised',
			dataIndex: 'jkwitansi_revised',
			width: 150,
			sortable: true,
			hidden:true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		}*/]
	);
	jual_kwitansi_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
//	jual_kwitansiListEditorGrid =  new Ext.grid.EditorGridPanel({
	jual_kwitansiListEditorGrid =  new Ext.grid.GridPanel({
		id: 'jual_kwitansiListEditorGrid',
		el: 'fp_jual_kwitansi',
		title: 'Detail Pemakaian Kuitansi',
		height: 250,
		width: 690,
		autoScroll: true,
		store: jual_kwitansi_DataStore, // DataStore
		colModel: jual_kwitansi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		//plugins: [editor_jual_kwitansi],
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}/*,
		bbar: new Ext.PagingToolbar({
			pageSize: kwitansi_pageS,
			store: jual_kwitansi_DataStore,
			displayInfo: true
		})*/
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			disabled: true,
			handler: jual_kwitansi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: jual_kwitansi_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function jual_kwitansi_add(){
		var edit_jual_kwitansi= new jual_kwitansiListEditorGrid.store.recordType({
			jkwitansi_id	:'',		
			jkwitansi_master	:'',		
			jkwitansi_no	:'',		
			jkwitansi_nilai	:'',		
			jkwitansi_ref	:'',		
			jkwitansi_creator	:'',		
			jkwitansi_date_create	:'',		
			jkwitansi_update	:'',		
			jkwitansi_date_update	:'',		
			jkwitansi_revised	:''		
		});
		editor_jual_kwitansi.stopEditing();
		jual_kwitansi_DataStore.insert(0, edit_jual_kwitansi);
		jual_kwitansiListEditorGrid.getView().refresh();
		jual_kwitansiListEditorGrid.getSelectionModel().selectRow(0);
		editor_jual_kwitansi.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_jual_kwitansi(){
		jual_kwitansi_DataStore.commitChanges();
		jual_kwitansiListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function jual_kwitansi_insert(){
		for(i=0;i<jual_kwitansi_DataStore.getCount();i++){
			jual_kwitansi_record=jual_kwitansi_DataStore.getAt(i);
			Ext.Ajax.request({
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_cetak_kwitansi&m=detail_jual_kwitansi_insert',
				params:{
				jkwitansi_id	: jual_kwitansi_record.data.jkwitansi_id, 
				jkwitansi_master	: jual_kwitansi_record.data.jkwitansi_master, 
				jkwitansi_no	: eval(kwitansi_idField.getValue()), 
				jkwitansi_nilai	: jual_kwitansi_record.data.jkwitansi_nilai, 
				jkwitansi_ref	: jual_kwitansi_record.data.jkwitansi_ref, 
				jkwitansi_creator	: jual_kwitansi_record.data.jkwitansi_creator, 
				jkwitansi_date_create	: jual_kwitansi_record.data.jkwitansi_date_create.format('Y-m-d'),
				jkwitansi_update	: jual_kwitansi_record.data.jkwitansi_update, 
				jkwitansi_date_update	: jual_kwitansi_record.data.jkwitansi_date_update.format('Y-m-d'),
				jkwitansi_revised	: jual_kwitansi_record.data.jkwitansi_revised 
				
				}
			});
		}
	}
	//eof
	
	//function for purge detail
	function jual_kwitansi_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_cetak_kwitansi&m=detail_jual_kwitansi_purge',
			params:{ master_id: eval(kwitansi_idField.getValue()) }
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function jual_kwitansi_confirm_delete(){
		// only one record is selected here
		if(jual_kwitansiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', jual_kwitansi_delete);
		} else if(jual_kwitansiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', jual_kwitansi_delete);
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
	function jual_kwitansi_delete(btn){
		if(btn=='yes'){
			var s = jual_kwitansiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				jual_kwitansi_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	jual_kwitansi_DataStore.on('update', refresh_jual_kwitansi);
	
	/* Function for retrieve create Window Panel*/ 
	cetak_kwitansi_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,        
		items: [cetak_kwitansi_masterGroup, kwitansi_bayarGroup]
		,
		buttons: [
		
			{
				text : 'Print Only',
				ref: '../kwitansi_printOnly',
				handler : print_only
			},
			{
				xtype:'spacer',
				width: 350
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KUITANSI'))){ ?>
			{
				text: 'Save and Print',
				ref: '../kwitansi_savePrint',
				handler: save_and_print
				
			},{
				text: 'Save and Close',
				handler: pengecekan_dokumen
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					cetak_kwitansi_reset_form();
					cetak_kwitansi_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	cetak_kwitansi_createWindow= new Ext.Window({
		id: 'cetak_kwitansi_createWindow',
		title: kwitansi_post2db+'Cetak Kuitansi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_cetak_kwitansi_create',
		items: cetak_kwitansi_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function cetak_kwitansi_list_search(){
		// render according to a SQL date format.
		var kwitansi_no_search=null;
		var kwitansi_cust_search=null;
		var kwitansi_tanggal_start_search="";
		var kwitansi_tanggal_end_search="";
		var kwitansi_keterangan_search=null;
		var kwitansi_status_search=null;

		if(kwitansi_noSearchField.getValue()!==null){kwitansi_no_search=kwitansi_noSearchField.getValue();}
		if(kwitansi_custSearchField.getValue()!==null){kwitansi_cust_search=kwitansi_custSearchField.getValue();}
		if(kwitansi_tanggalSearchField.getValue()!==""){kwitansi_tanggal_start_search=kwitansi_tanggalSearchField.getValue().format('Y-m-d');}
		if(kwitansi_tanggal_akhirSearchField.getValue()!==""){kwitansi_tanggal_end_search=kwitansi_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(kwitansi_keteranganSearchField.getValue()!==null){kwitansi_keterangan_search=kwitansi_keteranganSearchField.getValue();}
		if(kwitansi_statusSearchField.getValue()!==null){kwitansi_status_search=kwitansi_statusSearchField.getValue();}
		// change the store parameters
		cetak_kwitansi_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kwitansi_no				:	kwitansi_no_search,
			kwitansi_cust			:	kwitansi_cust_search,
			kwitansi_tanggal_start	:	kwitansi_tanggal_start_search,
			kwitansi_tanggal_end	:	kwitansi_tanggal_end_search,
			kwitansi_keterangan		:	kwitansi_keterangan_search,
			kwitansi_status			:	kwitansi_status_search
		};
		// Cause the datastore to do another query : 
		cetak_kwitansi_DataStore.reload({params: {start: 0, limit: kwitansi_pageS}});
	}
		
	/* Function for reset search result */
	function cetak_kwitansi_reset_search(){
		// reset the store parameters
		cetak_kwitansi_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		cetak_kwitansi_DataStore.reload({params: {start: 0, limit: kwitansi_pageS}});
		//cetak_kwitansi_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  kwitansi_id Search Field */
	kwitansi_idSearchField= new Ext.form.NumberField({
		id: 'kwitansi_idSearchField',
		fieldLabel: 'Kwitansi Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  kwitansi_no Search Field */
	kwitansi_noSearchField= new Ext.form.TextField({
		id: 'kwitansi_noSearchField',
		fieldLabel: 'No Kuitansi',
		maxLength: 20,
		anchor: '95%'
	
	});
	/* Identify  kwitansi_cust Search Field */
	kwitansi_custSearchField= new Ext.form.ComboBox({
		id: 'kwitansi_custSearchField',
		fieldLabel: 'Customer',
		store: cbo_custDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		allowBlank: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  kwitansi_keterangan Search Field */
	kwitansi_keteranganSearchField= new Ext.form.TextArea({
		id: 'kwitansi_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify  kwitansi_tanggal Search Field */
	kwitansi_tanggalSearchField= new Ext.form.DateField({
		id: 'kwitansi_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
	});
	kwitansi_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'kwitansi_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
	});
	
	/* Identify  kwitansi_status Search Field */
	kwitansi_statusSearchField= new Ext.form.ComboBox({
		id: 'kwitansi_statusSearchField',
		fieldLabel: 'Stat Dok',
		store:new Ext.data.SimpleStore({
			fields:['value', 'kwitansi_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'kwitansi_status',
		valueField: 'value',
		width: 100,
		triggerAction: 'all'
	
	});
    
	/* Function for retrieve search Form Panel */
	cetak_kwitansi_searchForm = new Ext.FormPanel({
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
				items: [kwitansi_noSearchField, kwitansi_custSearchField,
					
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
								kwitansi_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [						
								kwitansi_tanggal_akhirSearchField
							]
						}						
								
				        ]
					},


			kwitansi_keteranganSearchField, kwitansi_statusSearchField] 
			}			
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: cetak_kwitansi_list_search
			},{
				text: 'Close',
				handler: function(){
					cetak_kwitansi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	cetak_kwitansi_searchWindow = new Ext.Window({
		title: 'Pencarian Cetak Kuitansi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_cetak_kwitansi_search',
		items: cetak_kwitansi_searchForm
	});
    /* End of Function */
	
	function cetak_kwitansi_reset_SearchForm(){
		kwitansi_noSearchField.reset();
		kwitansi_noSearchField.setValue(null);
		kwitansi_custSearchField.reset();
		kwitansi_custSearchField.setValue(null);
		kwitansi_tanggalSearchField.reset();
		kwitansi_tanggalSearchField.setValue(null);
		kwitansi_tanggal_akhirSearchField.reset();
		kwitansi_tanggal_akhirSearchField.setValue(null);
		kwitansi_keteranganSearchField.reset();
		kwitansi_keteranganSearchField.setValue(null);
		kwitansi_statusSearchField.reset();
		kwitansi_statusSearchField.setValue(null);
	}
	 
	 function cetak_kwitansi_reset_search_form(){
		kwitansi_noSearchField.reset();
		kwitansi_noSearchField.setValue(null);
		kwitansi_custSearchField.reset();
		kwitansi_custSearchField.setValue(null);
		kwitansi_tanggalSearchField.reset();
		kwitansi_tanggalSearchField.setValue(null);
		kwitansi_tanggal_akhirSearchField.reset();
		kwitansi_tanggal_akhirSearchField.setValue(null);
		kwitansi_keteranganSearchField.reset();
		kwitansi_keteranganSearchField.setValue(null);
		kwitansi_statusSearchField.reset();
		kwitansi_statusSearchField.setValue(null);
	 }
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		cetak_kwitansi_reset_search_form();
		if(!cetak_kwitansi_searchWindow.isVisible()){
			cetak_kwitansi_reset_SearchForm();
			cetak_kwitansi_searchWindow.show();
		} else {
			cetak_kwitansi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function cetak_kwitansi_print(){
		var searchquery = "";
		var kwitansi_no_print=null;
		var kwitansi_cust_print=null;
		var kwitansi_keterangan_print=null;
		var kwitansi_status_print=null;
		var win;              
		// check if we do have some search data...
		if(cetak_kwitansi_DataStore.baseParams.query!==null){searchquery = cetak_kwitansi_DataStore.baseParams.query;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_print = cetak_kwitansi_DataStore.baseParams.kwitansi_no;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_print = cetak_kwitansi_DataStore.baseParams.kwitansi_cust;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_print = cetak_kwitansi_DataStore.baseParams.kwitansi_keterangan;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_status!==null){kwitansi_status_print = cetak_kwitansi_DataStore.baseParams.kwitansi_status;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_cetak_kwitansi&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kwitansi_no	:	kwitansi_no_print, 
			kwitansi_cust	:	kwitansi_cust_print, 
			kwitansi_keterangan	:	kwitansi_keterangan_print, 
			kwitansi_status	:	kwitansi_status_print,
		  	currentlisting: cetak_kwitansi_DataStore.baseParams.task // this tells us if we are searching or not
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
	function cetak_kwitansi_export_excel(){
		var searchquery = "";
		var kwitansi_no_2excel=null;
		var kwitansi_cust_2excel=null;
		var kwitansi_keterangan_2excel=null;
		var kwitansi_status_2excel=null;
		var win;
		// check if we do have some 2excel data...
		if(cetak_kwitansi_DataStore.baseParams.query!==null){searchquery = cetak_kwitansi_DataStore.baseParams.query;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_no!==null){kwitansi_no_2excel = cetak_kwitansi_DataStore.baseParams.kwitansi_no;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_cust!==null){kwitansi_cust_2excel = cetak_kwitansi_DataStore.baseParams.kwitansi_cust;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_keterangan!==null){kwitansi_keterangan_2excel = cetak_kwitansi_DataStore.baseParams.kwitansi_keterangan;}
		if(cetak_kwitansi_DataStore.baseParams.kwitansi_status!==null){kwitansi_status_2excel = cetak_kwitansi_DataStore.baseParams.kwitansi_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_cetak_kwitansi&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			//if we are doing advanced 2excel, use this
			kwitansi_no	:	kwitansi_no_2excel, 
			kwitansi_cust	:	kwitansi_cust_2excel, 
			kwitansi_keterangan	:	kwitansi_keterangan_2excel, 
			kwitansi_status	:	kwitansi_status_2excel,
		  	currentlisting: cetak_kwitansi_DataStore.baseParams.task // this tells us if we are searching or not
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
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_cetak_kwitansi"></div>
         <div id="fp_jual_kwitansi"></div>
		 <div id="history_pakai_kwitansi"></div>
		<div id="elwindow_cetak_kwitansi_create"></div>
        <div id="elwindow_cetak_kwitansi_search"></div>
		<div id="elwindow_kwitansi_adj_save"></div>
    </div>
</div>
</body>