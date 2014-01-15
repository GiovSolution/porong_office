<?
/* 	
	+ Module  		: Waiting List View
	+ Description	: For record view
	+ Filename 		: v_waiting_list.php
 	+ Author  		: Fred
	
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
			padding:1px 1px 1px 1px;
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
			margin:0 0 1px 1px;
			width:100px;
			display:block;
			clear:none;
		}
		.blue-row .x-grid3-cell-inner{
	      color:blue;
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
var waiting_list_DataStore;
var waiting_list_ColumnModel;
var waiting_list_ListEditorGrid;
var waiting_list_createForm;
var waiting_list_createWindow;
var waiting_list_searchForm;
var waiting_list_searchWindow;
var waiting_list_SelectedRow;
var waiting_list_ContextMenu;
//for detail data

//declare konstant
var waiting_list_post2db = '';
var msg = '';
var pageS=100;

/* declare variable here for Field*/
var wl_idField;
var wl_customerField;
var wl_tanggalField;
var app_caraField;
var wl_keteranganField;

var dt = new Date();

var var_dokter_dstore = true;
var var_terapis_dstore = true;
var var_detail_medis_dstore = true;
var var_detail_nonmedis_dstore = true;
var var_dmedis_insert = true;
var var_dnonmedis_insert = true;

var wl_status_inline_beforeedit = '';
var dapp_kategori_inline_beforeedit = '';
var dapp_dokter_id_inline_beforeedit = '';
var dapp_terapis_id_inline_beforeedit = '';

Ext.util.Format.comboRenderer = function(combo){
	return function(value){
		var record = combo.findRecord(combo.valueField, value);
		return record ? record.get(combo.displayField) : combo.valueNotFoundText;
	}
}


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
  	/* Function for Saving inLine Editing */
	function appointment_update(oGrid_event){
		//waiting_list_ListEditorGrid.setDisabled(true);
		var date_now = dt.format('Y-m-d');
		var wl_id_update_pk="";
		var wl_date_update="";
		var wl_keterangan_update=null;
		var wl_status_update="";

		var dapp_locked_update=0;
		var dapp_counter_update=true;
		var dapp_warna_terapis_update="";
		
		wl_id_update_pk = oGrid_event.record.data.wl_id;
	 	if(oGrid_event.record.data.wl_date!== ""){wl_date_update =oGrid_event.record.data.wl_date.format('Y-m-d');}
		if(oGrid_event.record.data.wl_keterangan!== null){wl_keterangan_update = oGrid_event.record.data.wl_keterangan;}
		if(oGrid_event.record.data.wl_status!== ""){wl_status_update = oGrid_event.record.data.wl_status;}
		dapp_locked_update = oGrid_event.record.data.dapp_locked;
		dapp_counter_update = oGrid_event.record.data.dapp_counter;
		dapp_warna_terapis_update = oGrid_event.record.data.dapp_warna_terapis;
		
		if(this.wl_status_inline_beforeedit=='Appointment' && (wl_status_update=='Waiting List' || wl_status_update=='Appointment')){
				waiting_list_DataStore.reload();
				Ext.MessageBox.show({
					title: 'Warning',
					width: 330,
					msg: 'Status yang sudah "Appointment" tidak boleh di-Edit dan hanya dapat di "Batal"',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
			}
		
		else{
			Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_waiting_list&m=get_action',
			params: {
				task: "UPDATE",
				wl_id			: wl_id_update_pk,
				wl_status		: wl_status_update,	
				wl_keterangan	: wl_keterangan_update,
				wl_date			: wl_date_update,
				mode_edit		: 'update_list'

			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						waiting_list_DataStore.commitChanges();
						waiting_list_DataStore.reload();
						Ext.MessageBox.show({
							   title: 'INFO',
							   width: 330,
							   msg: 'Update telah sukses dilakukan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.INFO
							});
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   //msg: 'We could\'t not save the users.',
							   msg: 'Data Waiting List tidak dapat disimpan',
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
  
  	/* Function for add data, open window create form */
	function waiting_list_create(){
		//wl_id_create_pk=get_pk_id();
		
		if(is_appointment_form_valid())
		{
            var wl_id_create_pk=null; 
            var wl_customer_create=null; 
            var wl_tanggal_create_date="";
			var wl_karyawan_id_create=null;
			var wl_perawatan_id_create=null;
            var app_cara_create=null; 
            var wl_keterangan_create=null; 
            
            if(wl_idField.getValue()!== null){wl_id_create_pk = wl_idField.getValue();}else{wl_id_create_pk=get_pk_id();} 
            if(wl_customerField.getValue()!== null){wl_customer_create = wl_customerField.getValue();} 
			if(combo_wl_dokter.getValue()!== null){wl_karyawan_id_create = combo_wl_dokter.getValue();} 
			if(combo_wl_perawatan_medis.getValue()!== null){wl_perawatan_id_create = combo_wl_perawatan_medis.getValue();} 
            if(wl_tanggalField.getValue()!== ""){wl_tanggal_create_date = wl_tanggalField.getValue().format('Y-m-d');} 
            if(app_caraField.getValue()!== null){app_cara_create = app_caraField.getValue();} 
            if(wl_keteranganField.getValue()!== null){wl_keterangan_create = wl_keteranganField.getValue();}
            
            Ext.Ajax.request({  
                waitMsg: 'Mohon tunggu...',
                url: 'index.php?c=c_waiting_list&m=get_action',
                params: {
                    task: waiting_list_post2db,
                    wl_id	: wl_id_create_pk, 
                    wl_customer	: wl_customer_create, 
					karyawan_id	: wl_karyawan_id_create,
					rawat_id	: wl_perawatan_id_create,
                    wl_tanggal	: wl_tanggal_create_date,
                    wl_keterangan	: wl_keterangan_create
                    
                }, 
                success: function(response){             
                    var result=eval(response.responseText);
                    switch(result){
                        case 1:
							Ext.MessageBox.alert(waiting_list_post2db+' OK','Data Waiting List berhasil disimpan');
							waiting_list_DataStore.reload();
							waiting_list_createWindow.hide();
                            break;
                        default:
                            //Ext.MessageBox.hide();
							waiting_list_createWindow.setDisabled(false);
                            Ext.MessageBox.show({
                               title: 'Warning',
                               msg: 'Data Waiting List tidak bisa disimpan',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'save',
                               icon: Ext.MessageBox.WARNING
                            });
                            break;
                    }
                },
                failure: function(response){
                    //Ext.MessageBox.hide();
					waiting_list_createWindow.setDisabled(false);
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
				//Ext.MessageBox.hide();
				waiting_list_createWindow.setDisabled(false);
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Ada data yang belum diinputkan',
					buttons: Ext.MessageBox.OK,
					minWidth: 250,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
			}
	}
 	/* End of Function */
  
	/*Function for waiting_list_down */
	function waitinglist_down(){
		
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_waiting_list&m=get_action',
			params: {
				task: "DOWN",
				wl_id		: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_id'),
				karyawan_id	: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('karyawan_id'),
				wl_priority	: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_priority'),
				wl_date		: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_date').format('Y-m-d')
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(waiting_list_post2db+' OK','Priority berhasil diupdate');
						waiting_list_DataStore.reload();
						break;
					case 2:
						Ext.MessageBox.alert('Priority tidak bisa di update, karena sudah berada di priority paling bawah');
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Update Priority tidak dapat dilakukan',
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
  
	/*Function for waiting_list_up */
	function waitinglist_up(){
	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_waiting_list&m=get_action',
			params: {
				task: "UP",
				wl_id		: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_id'),
				karyawan_id	: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('karyawan_id'),
				wl_priority	: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_priority'),
				wl_date		: waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_date').format('Y-m-d')
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(waiting_list_post2db+' OK','Priority berhasil diupdate');
						waiting_list_DataStore.reload();
						break;
					case 2:
						Ext.MessageBox.alert('Priority tidak bisa di update, karena sudah berada di priority paling atas');
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Update Priority tidak dapat dilakukan',
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
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(waiting_list_post2db=='UPDATE'){
			return waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_id');
		}else {
			return 0;
		}
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function waiting_list_reset_form(){
		wl_idField.reset();
		wl_idField.setValue(null);
		wl_customerField.reset();
		wl_customerField.setValue(null);
		wl_tanggalField.reset();
		wl_tanggalField.setValue(null);
		combo_wl_dokter.reset();
		combo_wl_dokter.setValue(null);
		combo_wl_perawatan_medis.reset();
		combo_wl_perawatan_medis.setValue(null);
		wl_keteranganField.reset();
		wl_keteranganField.setValue(null);
		
		wl_customerField.setDisabled(false);
		combo_wl_dokter.setDisabled(false);
		combo_wl_perawatan_medis.setDisabled(false);
	}
 	/* End of Function */
 	
	/* setValue to EDIT */
	function waiting_list_set_form(){
		wl_idField.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_id'));
		wl_customerField.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('cust_nama'));
		wl_customer_idField.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('cust_id'));
		wl_tanggalField.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_date'));
		combo_wl_dokter.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('karyawan_username'));
		combo_wl_perawatan_medis.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('rawat_nama'));
		wl_keteranganField.setValue(waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_keterangan'));
		if(waiting_list_post2db=='UPDATE'){
			wl_customerField.setDisabled(true);
			combo_wl_dokter.setDisabled(true);
			combo_wl_perawatan_medis.setDisabled(true);
		}else{
			wl_customerField.setDisabled(false);
			combo_wl_dokter.setDisabled(false);
			combo_wl_perawatan_medis.setDisabled(false);
		}
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_appointment_form_valid(){
		//return (wl_customerField.isValid() && app_cust_namaBaruField.isValid());
		return true;
	}
  	/* End of Function */
  	
	function window_enable(){
		if(var_dokter_dstore==true && var_terapis_dstore==true && var_detail_medis_dstore==true && var_detail_nonmedis_dstore==true){
			waiting_list_createWindow.setDisabled(false);
		}
	}
	
	function detail_insert_finish(){
		if(var_dmedis_insert==true && var_dnonmedis_insert==true){
			waiting_list_createWindow.setDisabled(false);
		}
	}
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
       
		dwl_dokterDataStore.reload();

		if(!waiting_list_createWindow.isVisible()){
			waiting_list_post2db='CREATE';
		
			waiting_list_reset_form();
			wl_tanggalField.setValue(dt.dateFormat('Y-m-d'));
			//app_caraField.setValue('Telp');
			msg='created';
			waiting_list_createWindow.show();
		} else {
			waiting_list_createWindow.toFront();
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function waiting_list_confirm_update(){
		waiting_list_post2db='UPDATE';
 
		/* only one record is selected here */
		dwl_dokterDataStore.load();
		//dapp_terapisDataStore.load();
		if(waiting_list_ListEditorGrid.selModel.getCount() == 1) {
			
			cbo_dwl_rawat_medisDataStore.load({
				params:{query:waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_id')},
				callback: function(opts, success, response){
					if(success){
									waiting_list_set_form();
					}
				}
			});
			
			waiting_list_post2db='UPDATE';
			msg='updated';
			waiting_list_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
//				msg: 'Tidak ada data yang dipilih untuk diedit',
				msg: 'Anda belum memilih data yang akan diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	waiting_list_DataStore = new Ext.data.GroupingStore({
		id: 'waiting_list_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_waiting_list&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
			//id: 'wl_id'
		},[
			{name: 'wl_id', type: 'int', mapping: 'wl_id'}, 
			{name: 'wl_priority', type: 'int', mapping: 'wl_priority'}, 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'rawat_id', type: 'int', mapping: 'rawat_id'}, 
			{name: 'rawat_nama', type: 'string', mapping: 'rawat_nama'}, 		
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'}, 
			{name: 'dokter_nama', type: 'string', mapping: 'dokter_nama'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'dokter_no', type: 'string', mapping: 'dokter_no'},
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'}, 
			{name: 'wl_status', type: 'string', mapping: 'wl_status'},
			{name: 'wl_date', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'wl_date'}, 
			{name: 'wl_keterangan', type: 'string', mapping: 'wl_keterangan'}, 
			{name: 'wl_creator', type: 'string', mapping: 'wl_creator'}, 
			{name: 'wl_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'wl_date_create'}, 
			{name: 'wl_update', type: 'string', mapping: 'wl_update'}, 
			{name: 'wl_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'wl_date_update'}, 
			{name: 'wl_revised', type: 'int', mapping: 'wl_revised'},
			{name: 'rawat_warna', type: 'int', mapping: 'rawat_warna'}
		]),
		sortInfo:{field: 'wl_date', direction: "DESC"},
		groupField: 'karyawan_username'
	});
	/* End of Function */
	
	//ComboBox ambil data Customer
	cbo_wl_customerDataStore = new Ext.data.Store({
		id: 'cbo_wl_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_waiting_list&m=get_customer_list', 
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
	//Template yang akan tampil di ComboBox
	var customer_wl_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            'Alamat: {cust_alamat}<br/>Telp Rumah: {cust_telprumah}',
        '</div></tpl>'
    );

	dwl_dokterDataStore = new Ext.data.Store({
		id: 'dwl_dokterDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_waiting_list&m=get_dokter_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'dokter_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'dokter_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'dokter_value', type: 'int', mapping: 'karyawan_id'},
			{name: 'dokter_count', type: 'int', mapping: 'dokter_count'}
		]),
		sortInfo:{field: 'dokter_display', direction: "ASC"}
	});
	var wl_dokter_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            //'<span><b>{dokter_username}</b> | {dokter_display} | <b>{dokter_count}</b>',
			'<span>{dokter_username}',
        '</div></tpl>'
    );
	
	cbo_dwl_rawat_medisDataStore = new Ext.data.Store({
		id: 'cbo_dwl_rawat_medisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_waiting_list&m=get_rawat_medis_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'dapp_rawat_value', type: 'int', mapping: 'rawat_id'},
			{name: 'dapp_rawat_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'dapp_rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'dapp_rawat_group', type: 'string', mapping: 'group_nama'},
			{name: 'dapp_rawat_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'dapp_rawat_du', type: 'float', mapping: 'rawat_du'},
			{name: 'dapp_rawat_dm', type: 'float', mapping: 'rawat_dm'},
			{name: 'dapp_rawat_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'dapp_rawat_display', direction: "ASC"}
	});
	
	var wl_perawatan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dapp_rawat_kode}| <b>{dapp_rawat_display}</b>',
		'</div></tpl>'
    );
	
	
	dwl_dokterDataStore.on('beforeload', function(){
		var_dokter_dstore = false;
		//waiting_list_createWindow.setDisabled(true);
		waiting_list_createWindow.setDisabled(false);
	});
	dwl_dokterDataStore.on('load', function(opts, success, response){
		if(success){
			var_dokter_dstore = true;
			window_enable();
		}
	});

	
  	/* Function for Identify of Window Column Model */
	waiting_list_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: 'Tgl WL',
			dataIndex: 'wl_date',
			width: 70,
			sortable: false,
			hidden: false,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_APP'))){ ?>
			,
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'rawat_nama',
			width: 210,
			sortable: false,
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.rawat_warna==1){
					return '<span style="color:red;">' + value + '</span>';
				}
				if(record.data.rawat_warna==2){
					return '<span style="color:black;"><b>' + value + '</b></span>';
				}
				return value;
			}
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'cust_no',
			width: 70,
			sortable: false,
			renderer: disable_color
		}, 
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'cust_nama',
			width: 160,
			sortable: false,
			renderer: disable_color
		}, 
		{
	
			header: 'Dokter',
			dataIndex: 'karyawan_username',
			width: 80,
			sortable: false
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_APP'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				store: dwl_dokterDataStore,
				mode: 'remote',
				tpl: wl_dokter_tpl,
				displayField: 'dokter_username',
				valueField: 'dokter_value',
				loadingText: 'Searching...',
				itemSelector: 'div.search-item',
				triggerAction: 'all',
				anchor: '95%'
			})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'wl_status',
			width: 80,
			sortable: true,
			//editable : true,
			renderer: ch_status,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['wl_status_value', 'wl_status_display'],
					data: [['Appointment','Appointment'],['Waiting List','Waiting List'],['Batal','Batal']]
					}),
				mode: 'local',
				editable : false,
               	displayField: 'wl_status_display',
               	valueField: 'wl_status_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		}, 	
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'wl_keterangan',
			width: 220,
			ref: '../wl_cm_keterangan',
			sortable: false,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
		}, 
			{
			align : 'Center',
			header: '<div align="center">' + 'Priority' + '</div>',
			dataIndex: 'wl_priority',
			width: 40,	//150,
			sortable: true

		}
		]);
	
	waiting_list_ColumnModel.defaultSortable= true;
	/* End of Function */
	var width_listGrid=500;
	function width_list(){
		return 1100;
	}

	function ch_status(val){
		if(val=="Appointment"){
			return '<span style="color:green;"><b>' + val + '</b></span>';
		}else if(val=="Batal"){
			return '<span style="color:red;"><b>' + val + '</b></span>';
		}else if(val=="Waiting List"){
			return '<span style="color:black;"><b>' + val + '</b></span>';
		}
		return val;
	}

	function disable_color(value, cell){
		cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
		return value;
	}
	
	
	tbar_dokter_wl_Field= new Ext.form.DateField({
		id: 'tbar_dokter_wl_Field',
		fieldLabel: 'Tgl Waiting List',
		format : 'd-m-Y',
		emptyText: 'Tgl Waiting List',
		ref: '../appDokterTgl'
	});
	
	/*
	tbar_wl_tglField= new Ext.form.DateField({
		id: 'tbar_wl_tglField',
		fieldLabel: 'Tgl Waiting List',
		format : 'd-m-Y',
		emptyText: 'Tgl App',
		hidden:true,
		ref: '../appNonMedisTgl'
	});
	*/
    
	/* Declare DataStore and  show datagrid list */
	waiting_list_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'waiting_list_ListEditorGrid',
		el: 'fp_waiting_list',
		title: 'Daftar Waiting List',
		autoHeight: true,
		store: waiting_list_DataStore, // DataStore
		cm: waiting_list_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		//viewConfig: { forceFit:true},
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
	  	width: 1220,
	  	//autoWidth: true,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: waiting_list_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_APP'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		/*
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_APP'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			disabled:false,
			handler: waiting_list_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		*/
		/*
		{
			text: 'Adv Search',
			tooltip: 'Pencarian detail',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}
		*/
		'-', 
		
			new Ext.app.SearchField({
			id: 'wl_simpleSearch',
			store: waiting_list_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){			
						waiting_list_DataStore.setBaseParam('wl_jenis_rawat','');
						waiting_list_DataStore.setBaseParam('wl_tgl_app','');
						waiting_list_DataStore.setBaseParam('karyawan_id','');
						waiting_list_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
						waiting_list_DataStore.groupBy('karyawan_username');
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search by (Khusus untuk hari ini)'});
				Ext.get(this.id).set({qtip:'- Client Card<br>- Nama Cust<br>- Nickname Dokter<br>'});
				}
			},
			width: 120
		}),
		
		'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: wl_reset_search,
			iconCls:'icon-refresh'
		},'-', '-',tbar_dokter_wl_Field, '-',{
			xtype: 'combo',
			id: 'wl_cbo_dokter',
			text: 'Pilihan Dokter',
			emptyText: 'Pilihan Dokter',
			width: 200,
			store: dwl_dokterDataStore,
            fieldLabel: 'ComboBox Dokter',
            mode: 'remote',
			tpl: wl_dokter_tpl,
			displayField: 'dokter_username',
			valueField: 'dokter_value',
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all'
		}, '-','-', '' , '' , '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '-', 
		{
			text: 'Up',
			tooltip: 'Menaikkan urutan Waiting List',
			iconCls:'icon-adds',
			disabled : false,
			ref : '../wl_up',
			handler: waitinglist_up  
		}, '-', 
		{
			text: 'Down',
			tooltip: 'Menurunkan urutan Waiting List',
			iconCls:'icon-delete',
			disabled : false,
			ref : '../wl_down',
			handler: waitinglist_down  
		}, '-'

		]
	});
	waiting_list_ListEditorGrid.render();
	
	waiting_list_ListEditorGrid.on('rowdblclick', function(){
		this.wl_status_inline_beforeedit = waiting_list_ListEditorGrid.getSelectionModel().getSelected().get('wl_status');

	});
	
	waiting_list_ListEditorGrid.on('rowclick', function(){
		var recordMaster = waiting_list_ListEditorGrid.getSelectionModel().getSelected();
		if(recordMaster.get("wl_status") == 'Batal'){
			waiting_list_ListEditorGrid.wl_up.disable();
			waiting_list_ListEditorGrid.wl_down.disable();
			waiting_list_ColumnModel.setEditable(0, false);
			waiting_list_ColumnModel.setEditable(1, false);
			waiting_list_ColumnModel.setEditable(2, false);
			waiting_list_ColumnModel.setEditable(3, false);
			waiting_list_ColumnModel.setEditable(4, false);
			waiting_list_ColumnModel.setEditable(5, false);
			waiting_list_ColumnModel.setEditable(6, false);
			waiting_list_ColumnModel.setEditable(7, false);
		
		}
		else if(recordMaster.get("wl_priority") == 1 && recordMaster.get("wl_status") == 'Waiting List'){
			waiting_list_ListEditorGrid.wl_up.disable();
			//waiting_list_ListEditorGrid.wl_down.disable();
		}
		else if(recordMaster.get("wl_priority") > 1 && recordMaster.get("wl_status") == 'Waiting List'){
			waiting_list_ListEditorGrid.wl_up.enable();
			waiting_list_ListEditorGrid.wl_down.enable();
		}
		else if(recordMaster.get("wl_status") == 'Appointment'){
			waiting_list_ListEditorGrid.wl_up.disable();
			waiting_list_ListEditorGrid.wl_down.disable();
			waiting_list_ColumnModel.setEditable(0, false);
			waiting_list_ColumnModel.setEditable(1, false);
			waiting_list_ColumnModel.setEditable(2, false);
			waiting_list_ColumnModel.setEditable(3, false);
			waiting_list_ColumnModel.setEditable(4, false);
			waiting_list_ColumnModel.setEditable(5, true);
			waiting_list_ColumnModel.setEditable(6, true);
			waiting_list_ColumnModel.setEditable(7, false);
		}

	});
	
	
	Ext.getCmp('wl_cbo_dokter').on('select', function(){
		waiting_list_DataStore.setBaseParam('query',Ext.getCmp('wl_cbo_dokter').getValue());
		waiting_list_DataStore.load({params: {
			task: 'LIST',
			start: 0,
			limit: pageS,
			query: '',
			karyawan_id: Ext.getCmp('wl_cbo_dokter').getValue(),
			wl_tgl_app: tbar_dokter_wl_Field.getValue()
		}});
	});
	
	tbar_dokter_wl_Field.on('select',function(){
		//waiting_list_DataStore.setBaseParam('query',Ext.getCmp('wl_cbo_dokter').getValue());
		Ext.getCmp('wl_simpleSearch').reset();
		Ext.getCmp('wl_cbo_dokter').reset();
		waiting_list_DataStore.setBaseParam('query','');
		waiting_list_DataStore.setBaseParam('wl_tgl_app',tbar_dokter_wl_Field.getValue());
		waiting_list_DataStore.setBaseParam('karyawan_id','');
		waiting_list_DataStore.load({params: {
			task: 'LIST',
			start: 0,
			limit: pageS
		}});
	});
	
	/*
	tbar_wl_tglField.on('select',function(){
		Ext.getCmp('wl_simpleSearch').reset();
		Ext.getCmp('wl_cbo_dokter').reset();
		waiting_list_DataStore.setBaseParam('query','');
		waiting_list_DataStore.setBaseParam('wl_tgl_app',tbar_wl_tglField.getValue());
		waiting_list_DataStore.setBaseParam('karyawan_id','');
		waiting_list_DataStore.load({params: {
			task: 'LIST',
			start: 0,
			limit: pageS
		}});
	});
	*/
     
	/* Create Context Menu */
	waiting_list_ContextMenu = new Ext.menu.Menu({
		id: 'waiting_list_ContextMenu',
		items: [
		{
			text: 'Up',
			tooltip: 'Menaikkan urutan Waiting List',
			iconCls:'icon-adds',
			disabled : false,
			ref : '../context_wl_up',
			handler: waitinglist_up
		}, '-', 
		{
			text: 'Down',
			tooltip: 'Menurunkan urutan Waiting List',
			iconCls:'icon-delete',
			disabled : false,
			ref : '../context_wl_down',
			handler: waitinglist_down
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onwl_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		waiting_list_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		waiting_list_SelectedRow=rowIndex;
		waiting_list_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function wl_editContextMenu(){
		//waiting_list_ListEditorGrid.startEditing(waiting_list_SelectedRow,1);
		waiting_list_confirm_update();
  	}
	/* End of Function */
  	
	waiting_list_ListEditorGrid.addListener('rowcontextmenu', onwl_ListEditGridContextMenu);
	waiting_list_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	waiting_list_ListEditorGrid.on('afteredit', appointment_update); // inLine Editing Record
	
	/*
	waiting_list_ContextMenu.on('click', function(){
		var recordMaster = waiting_list_ContextMenu.getSelectionModel().getSelected();

		if(recordMaster.get("wl_status") == 'Batal' || recordMaster.get("wl_status") == 'Appointment'){

			waiting_list_ContextMenu.context_wl_up.disable();
			waiting_list_ContextMenu.context_wl_down.disable();
		}
		else if(recordMaster.get("wl_priority") == 1 && recordMaster.get("wl_status") == 'Waiting List'){

			waiting_list_ContextMenu.context_wl_up.disable();
			waiting_list_ContextMenu.context_wl_down.disable();
		}
		else if(recordMaster.get("wl_priority") > 1 && recordMaster.get("wl_status") == 'Waiting List'){

			waiting_list_ContextMenu.context_wl_up.enable();
			waiting_list_ContextMenu.context_wl_down.enable();
		}
	});
	*/
	
	/* Identify  app_id Field */
	wl_idField= new Ext.form.NumberField({
		id: 'wl_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  app_customer Field */
	wl_customerField= new Ext.form.ComboBox({
		//id: 'wl_customerField',
		fieldLabel: 'Customer',
		store: cbo_wl_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_wl_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		anchor: '95%',
		queryDelay:1200,
		forceSelection: true,
		listeners:{
			render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Cust<br>- Nama Cust<br>- No Telp Rumah<br>- No Telp Kantor<br>- No HP'});
			}
		}
	});
	wl_customer_idField=new Ext.form.NumberField();
	/* Identify  app_tanggal Field */
	wl_tanggalField= new Ext.form.DateField({
		id: 'wl_tanggalField',
		fieldLabel: 'Tgl Waiting List',
		format : 'd-m-Y',
	});
	/* Identify  app_cara Field */
	app_caraField= new Ext.form.ComboBox({
		id: 'app_caraField',
		fieldLabel: 'Cara',
		store:new Ext.data.SimpleStore({
			fields:['app_cara_value', 'app_cara_display'],
			data:[['Telp','Telp'],['Update','In-Day Telp'],['Datang','Walk-in'],['Rekomendasi','Rekomendasi']]
		}),
		mode: 'local',
		name:'app_cara',
		displayField: 'app_cara_display',
		valueField: 'app_cara_value',
		width: 100,
		triggerAction: 'all'	
	});
	
	var combo_wl_dokter=new Ext.form.ComboBox({
			fieldLabel: 'Dokter',
			store: dwl_dokterDataStore,
			mode: 'local',
			tpl: wl_dokter_tpl,
			displayField: 'dokter_username',
			valueField: 'dokter_value',
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			anchor: '95%'
	});
	
	var combo_wl_perawatan_medis=new Ext.form.ComboBox({
			fieldLabel : 'Perawatan',
			store: cbo_dwl_rawat_medisDataStore,
			mode: 'remote',
			displayField: 'dapp_rawat_display',
			valueField: 'dapp_rawat_value',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:15,
			hideTrigger:false,
			tpl: wl_perawatan_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			allowBlank: true,
			listClass: 'x-combo-list-small',
			anchor: '95%'

	});
	
	/* Identify  app_keterangan Field */
	wl_keteranganField= new Ext.form.TextArea({
		id: 'wl_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
  	/*Fieldset Master*/
	waiting_list_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [wl_tanggalField, combo_wl_dokter, wl_customerField, combo_wl_perawatan_medis] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [wl_keteranganField, wl_idField] 
			}
			]
	
	});


	/* Function for retrieve create Window Panel*/ 
	waiting_list_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 950,        
		items: [waiting_list_masterGroup],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_APP'))){ ?>
			{
				id: 'wl_saveClose',
				text: 'Save and Close',
				handler: waiting_list_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					waiting_list_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_APP'))){ ?>
	Ext.getCmp('wl_saveClose').on('click', function(){
		/*Ext.MessageBox.show({
           title: 'Please wait',
           msg: 'Loading items...',
           progressText: 'Initializing...',
           width:300,
		   wait:true,
		   waitConfig: {interval:200},
           closable:false
       });*/
		//waiting_list_createWindow.setDisabled(true);
		waiting_list_createWindow.setDisabled(false);
	});
	<?php } ?>
	
	/* Function for retrieve create Window Form */
	waiting_list_createWindow= new Ext.Window({
		id: 'waiting_list_createWindow',
		title: waiting_list_post2db+'Waiting List',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_waiting_list_create',
		items: waiting_list_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function appointment_list_search(){
		// render according to a SQL date format.
		var app_rawat_medis_search=null;
		var app_rawat_nonmedis_search=null;
		
		if(app_perawatan_medisSearchField.getValue()!==null){app_rawat_medis_search=app_perawatan_medisSearchField.getValue();}

		// change the store parameters
		waiting_list_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			app_rawat_medis	: app_rawat_medis_search,
			app_rawat_nonmedis	: app_rawat_nonmedis_search,
			app_terapis	:	app_terapis_search

		};
		// Cause the datastore to do another query : 
		waiting_list_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function wl_reset_search(){
		Ext.getCmp('wl_cbo_dokter').reset();
		tbar_dokter_wl_Field.reset();
		// reset the store parameters
		waiting_list_DataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		waiting_list_DataStore.groupBy('karyawan_username');
		// Cause the datastore to do another query : 
		waiting_list_DataStore.reload({params: {start: 0, limit: pageS}});
		waiting_list_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	app_perawatan_medisSearchField= new Ext.form.ComboBox({
		id: 'app_perawatan_medisSearchField',
		fieldLabel: 'Perawatan Medis',
		store: cbo_dwl_rawat_medisDataStore,
		mode: 'remote',
		displayField: 'dapp_rawat_display',
		valueField: 'dapp_rawat_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:10,
		hideTrigger:false,
		//tpl: rawat_jual_rawat_tpl,
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});

    
	/* Function for retrieve search Form Panel */
	waiting_list_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 130,
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
					{
						layout:'column',
						border:false,
						items:[
								{
									columnWidth:0.5,
									layout: 'form',
									labelWidth:130,
									border:false,
									defaultType: 'datefield',
									items: [] 
								},
								{
									columnWidth:0.5,
									layout: 'form',
									labelWidth:15,
									border:false,
									defaultType: 'datefield',
									items: [] 
								}]
					},app_perawatan_medisSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: function(){
					appointment_list_search();
					waiting_list_searchWindow.hide();
				}
			},{
				text: 'Close',
				handler: function(){
					waiting_list_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	waiting_list_searchWindow = new Ext.Window({
		title: 'Pencarian Waiting List',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_waiting_list_search',
		items: waiting_list_searchForm
	});
    /* End of Function */ 
    
	function waiting_list_reset_formSearch(){

	}
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!waiting_list_searchWindow.isVisible()){
			waiting_list_reset_formSearch();
			waiting_list_searchWindow.show();
		} else {
			waiting_list_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function appointment_print(){
		var searchquery = "";
		// render according to a SQL date format.
		var app_customer_print=null;
		var app_tanggal_print_date="";
		var app_cara_print=null;
		var app_kategori_print=null;
		var app_dokter_print=null;
		var app_terapis_print=null;
		var app_tgl_start_reservasi_print=null;
		var app_tgl_end_reservasi_print=null;
		var app_tgl_start_app_print=null;
		var app_tgl_end_app_print=null;
		var app_rawat_medis_print=null;
		var app_rawat_nonmedis_print=null;
		var win;              
		// check if we do have some search data...
		if(waiting_list_DataStore.baseParams.query!==null){searchquery = waiting_list_DataStore.baseParams.query;}
		if(waiting_list_DataStore.baseParams.app_customer!==null){app_customer_print = waiting_list_DataStore.baseParams.app_customer;}
		if(waiting_list_DataStore.baseParams.app_cara!==null){app_cara_print = waiting_list_DataStore.baseParams.app_cara;}
		if(waiting_list_DataStore.baseParams.wl_jenis_rawat!==null){app_kategori_print = waiting_list_DataStore.baseParams.wl_jenis_rawat;}
		if(waiting_list_DataStore.baseParams.app_dokter!==null){app_dokter_print = waiting_list_DataStore.baseParams.app_dokter;}
		if(waiting_list_DataStore.baseParams.app_terapis!==null){app_terapis_print = waiting_list_DataStore.baseParams.app_terapis;}
		if(waiting_list_DataStore.baseParams.app_rawat_medis!==null){app_rawat_medis_print = waiting_list_DataStore.baseParams.app_rawat_medis;}
		if(waiting_list_DataStore.baseParams.app_rawat_nonmedis!==null){app_rawat_nonmedis_print = waiting_list_DataStore.baseParams.app_rawat_nonmedis;}
		if(waiting_list_DataStore.baseParams.app_tgl_start_reservasi!=""){app_tgl_start_reservasi_print = waiting_list_DataStore.baseParams.app_tgl_start_reservasi;}
		if(waiting_list_DataStore.baseParams.app_tgl_end_reservasi!==""){app_tgl_end_reservasi_print = waiting_list_DataStore.baseParams.app_tgl_end_reservasi;}
		if(waiting_list_DataStore.baseParams.app_tgl_start_app!==""){app_tgl_start_app_print = waiting_list_DataStore.baseParams.app_tgl_start_app;}
		if(waiting_list_DataStore.baseParams.app_tgl_end_app!==""){app_tgl_end_app_print = waiting_list_DataStore.baseParams.app_tgl_end_app;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_waiting_list&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			app_customer	:	app_customer_print,
			app_rawat_medis	: app_rawat_medis_print,
			app_rawat_nonmedis	: app_rawat_nonmedis_print,
			app_cara	:	app_cara_print,
			wl_jenis_rawat	:	app_kategori_print,
			app_dokter	:	app_dokter_print,
			app_terapis	:	app_terapis_print,
			app_tgl_start_reservasi	: app_tgl_start_reservasi_print,
			app_tgl_end_reservasi	: app_tgl_end_reservasi_print,
			app_tgl_start_app	: app_tgl_start_app_print,
			app_tgl_end_app	: app_tgl_end_app_print,
			wl_tgl_app		: waiting_list_DataStore.baseParams.wl_tgl_app,
		  	currentlisting: waiting_list_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/appointmentlist.html','appointmentlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function appointment_export_excel(){
		var searchquery = "";
		var app_customer_2excel=null;
		var app_tanggal_2excel_date="";
		var app_cara_2excel=null;
		var app_kategori_2excel=null;
		var app_dokter_2excel=null;
		var app_terapis_2excel=null;
		var app_tgl_start_reservasi_2excel=null;
		var app_tgl_end_reservasi_2excel=null;
		var app_tgl_start_app_2excel=null;
		var app_tgl_end_app_2excel=null;
		var app_rawat_medis_2excel=null;
		var app_rawat_nonmedis_2excel=null;
		var win;              
		// check if we do have some search data...
		if(waiting_list_DataStore.baseParams.query!==null){searchquery = waiting_list_DataStore.baseParams.query;}
		if(waiting_list_DataStore.baseParams.app_customer!==null){app_customer_2excel = waiting_list_DataStore.baseParams.app_customer;}
		if(waiting_list_DataStore.baseParams.app_cara!==null){app_cara_2excel = waiting_list_DataStore.baseParams.app_cara;}
		if(waiting_list_DataStore.baseParams.wl_jenis_rawat!==null){app_kategori_2excel = waiting_list_DataStore.baseParams.wl_jenis_rawat;}
		if(waiting_list_DataStore.baseParams.app_dokter!==null){app_dokter_2excel = waiting_list_DataStore.baseParams.app_dokter;}
		if(waiting_list_DataStore.baseParams.app_terapis!==null){app_terapis_2excel = waiting_list_DataStore.baseParams.app_terapis;}
		if(waiting_list_DataStore.baseParams.app_rawat_medis!==null){app_rawat_medis_2excel = waiting_list_DataStore.baseParams.app_rawat_medis;}
		if(waiting_list_DataStore.baseParams.app_rawat_nonmedis!==null){app_rawat_nonmedis_2excel = waiting_list_DataStore.baseParams.app_rawat_nonmedis;}
		if(waiting_list_DataStore.baseParams.app_tgl_start_reservasi!=""){app_tgl_start_reservasi_2excel = waiting_list_DataStore.baseParams.app_tgl_start_reservasi;}
		if(waiting_list_DataStore.baseParams.app_tgl_end_reservasi!==""){app_tgl_end_reservasi_2excel = waiting_list_DataStore.baseParams.app_tgl_end_reservasi;}
		if(waiting_list_DataStore.baseParams.app_tgl_start_app!==""){app_tgl_start_app_2excel = waiting_list_DataStore.baseParams.app_tgl_start_app;}
		if(waiting_list_DataStore.baseParams.app_tgl_end_app!==""){app_tgl_end_app_2excel = waiting_list_DataStore.baseParams.app_tgl_end_app;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_waiting_list&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			app_customer	:	app_customer_2excel,
			app_rawat_medis	: app_rawat_medis_2excel,
			app_rawat_nonmedis	: app_rawat_nonmedis_2excel,
			app_cara	:	app_cara_2excel,
			wl_jenis_rawat	:	app_kategori_2excel,
			app_dokter	:	app_dokter_2excel,
			app_terapis	:	app_terapis_2excel,
			app_tgl_start_reservasi	: app_tgl_start_reservasi_2excel,
			app_tgl_end_reservasi	: app_tgl_end_reservasi_2excel,
			app_tgl_start_app	: app_tgl_start_app_2excel,
			app_tgl_end_app	: app_tgl_end_app_2excel,
			wl_tgl_app		: waiting_list_DataStore.baseParams.wl_tgl_app,
		  	currentlisting: waiting_list_DataStore.baseParams.task // this tells us if we are searching or not
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

	new Ext.ToolTip({
		target:Ext.get('help_customer'),
		title: 'Search-By',
		dismissDelay: 15000,
		html: '- No Customer<br>- Nama Customer<br>- Telp Rumah<br>- Telp Kantor<br>- HP',
		trackMouse: true
		});
	new Ext.ToolTip({
		target:Ext.get('medis'),
		title: 'Search-By',
		dismissDelay: 15000,
		html: '- Kode Perawatan<br>- Nama Perawatan',
		trackMouse: true
		});
	new Ext.ToolTip({
		target:Ext.get('nonmedis'),
		title: 'Search-By',
		dismissDelay: 15000,
		html: '- Kode Perawatan<br>- Nama Perawatan',
		trackMouse: true
		});
	Ext.QuickTips.init();
	
	//column_set_editable();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_waiting_list"></div>
        <div id="fp_waiting_list_detail_medis"></div>
		<div id="fp_waiting_list_detail_nonmedis"></div>
		<div id="elwindow_waiting_list_create"></div>
        <div id="elwindow_waiting_list_search"></div>
    </div>
</div>
</body>