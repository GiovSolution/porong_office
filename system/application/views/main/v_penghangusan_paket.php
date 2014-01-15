<?php
/* 	
	+ Module  		: Penghangusan Paket View
	+ Description	: For record view
	+ Filename 		: Penghangusan Paket .php
 	+ creator  		: Fred
	
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
var penghangusan_paketListEditorGrid;
var penghangusan_paket_DataStore;
var penghangusan_paket_ColumnModel;
var penghangusan_paket_saveForm;
var penghangusan_paket_saveWindow;
var penghangusan_paket_idField;
//var perpanjangan_hari_Field;
var penghangusan_paket_paketField;
var penghangusan_paket_tglField;
var penghangusan_paket_keteranganField;

//declare konstant
var penghangusan_post2db = 'CREATE';
//var penghangusan_post2db = '';
var penghangusan_pageS=15;

/* declare variable here for Field*/

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

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


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
  	/* Function for add and edit data form, open window form */
	function penghangusan_paket_save(){
	
		if(is_penghangusan_paket_form_valid()){	

			var penghangusan_paket_id_create_pk=null;
			var penghangusan_paket_dpaket_id_create = null;
			//var perpanjang_paket_hari_field = null;
			//var cust_point_field = null;
			var penghangusan_paket_tgl_create="";
			var penghangusan_paket_ket_create=null;
			var penghangusan_paket_dpaket_master_create=null;
			var penghangusan_paket_sisa_sebelum_create=null;
			var penghangusan_paket_paket_id_create=null;
			var penghangusan_paket_cust_id_create=null;
			
			if(penghangusan_paket_idField.getValue()!== null){penghangusan_paket_id_create_pk = penghangusan_paket_idField.getValue();}
			//if(perpanjangan_hari_Field.getValue()!==null){perpanjang_paket_hari_field=perpanjangan_hari_Field.getValue();}
			if(penghangusan_paket_paketField.getValue()!==null){penghangusan_paket_dpaket_id_create=penghangusan_paket_paketField.getValue();}
			if(penghangusan_paket_keteranganField.getValue()!== null){penghangusan_paket_ket_create = penghangusan_paket_keteranganField.getValue();}
			if(penghangusan_paket_tglField.getValue()!== ""){penghangusan_paket_tgl_create = penghangusan_paket_tglField.getValue().format('Y-m-d');}
			if(penghangusan_paket_dpaket_masterField.getValue()!==null){penghangusan_paket_dpaket_master_create=penghangusan_paket_dpaket_masterField.getValue();}
			if(penghangusan_paket_sisa_sebelumField.getValue()!==null){penghangusan_paket_sisa_sebelum_create=penghangusan_paket_sisa_sebelumField.getValue();}
			if(penghangusan_paket_paket_idField.getValue()!==null){penghangusan_paket_paket_id_create=penghangusan_paket_paket_idField.getValue();}
			if(penghangusan_paket_cust_idField.getValue()!==null){penghangusan_paket_cust_id_create=penghangusan_paket_cust_idField.getValue();}
	
										
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_penghangusan_paket&m=get_action',
				params: {
	
					task: penghangusan_post2db,
					penghangusan_id			: penghangusan_paket_id_create_pk,		
					penghangusan_dpaket_id	: penghangusan_paket_dpaket_id_create,
					//perpanjang_hari			: perpanjang_paket_hari_field,
					//cust_point				: cust_point_field,
					penghangusan_tanggal		: penghangusan_paket_tgl_create,					
					penghangusan_keterangan		: penghangusan_paket_ket_create,
					penghangusan_dpaket_master	: penghangusan_paket_dpaket_master_create,
					penghangusan_sisa_sebelum	: penghangusan_paket_sisa_sebelum_create,
					penghangusan_paket_id		: penghangusan_paket_paket_id_create,
					penghangusan_cust_id		: penghangusan_paket_cust_id_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					if(result==1){
						Ext.MessageBox.alert(penghangusan_post2db+' OK','Penghapusan Paket berhasil dilakukan.');
						penghangusan_paket_DataStore.reload();
						penghangusan_paket_saveWindow.hide();
					}
					else if(result==2)
					{
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Penghapusan Paket tidak dapat dilakukan, karena sudah pernah dilakukan Penghapusan Paket sebelumnya',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
						penghangusan_paket_DataStore.reload();
						penghangusan_paket_saveWindow.hide();
					}
					else
					{
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'Penghapusan Paket tidak dapat dilakukan',
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
				}                      
			});
			
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form Anda belum lengkap.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
    
	
	/* Function for get PK field */
	function get_pk_id(){
		if(penghangusan_post2db=='CREATE')
			return penghangusan_paketListEditorGrid.getSelectionModel().getSelected().get('penghangusan_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function penghangusan_paket_reset_form(){
		penghangusan_paket_idField.reset();
		penghangusan_paket_idField.setValue(null);
		//perpanjangan_hari_Field.reset();
		//perpanjangan_hari_Field.setValue(null);
		penghangusan_paket_paketField.reset();
		penghangusan_paket_paketField.setValue(null);
		penghangusan_paket_keteranganField.reset();
		penghangusan_paket_keteranganField.setValue(null);
	}
 	/* End of Function */

	/* Function for Check if the form is valid */
	function is_penghangusan_paket_form_valid(){
		return (true &&  penghangusan_paket_paketField.isValid() && penghangusan_paket_keteranganField.isValid() && true);
	}
  	/* End of Function */
  
	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!penghangusan_paket_saveWindow.isVisible()){
			penghangusan_paket_reset_form();
			penghangusan_paket_saveWindow.show();
		} else {
			penghangusan_paket_saveWindow.toFront();
		}
	}
  	/* End Function */
  
	function penghangusan_paket_confirm_save(){
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan penghapusan paket ini?', penghangusan_paket_button);
	}
	
	function penghangusan_paket_button(btn){
		if(btn=='yes'){
			penghangusan_paket_save();
		}
	
	}
	
	/* Combobox utk menampilkan paket2 yang sisanya tidak minus / tidak 0*/ 
	cbo_list_paket_hangusDataStore = new Ext.data.Store({
		id: 'cbo_list_paket_hangusDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penghangusan_paket&m=get_paket_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:penghangusan_pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dpaket_id'
		},[
			{name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'}, 
			{name: 'jpaket_tanggal', type: 'date', dateFormat:'Y-m-d', mapping: 'jpaket_tanggal'},
			{name: 'dpaket_kadaluarsa', type: 'date', dateFormat:'Y-m-d', mapping: 'dpaket_kadaluarsa'}, 
			{name: 'tanggal_hangus', type: 'date', dateFormat:'Y-m-d', mapping: 'tanggal_hangus'}, 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'}, 
			{name: 'paket_kode', type: 'string', mapping: 'paket_kode'},
			{name: 'paket_nama_cust', type: 'string', mapping: 'paket_nama_cust'},
			{name: 'paket_nama', type: 'string', mapping: 'paket_nama'},
			{name: 'dpaket_id', type: 'int', mapping: 'dpaket_id'},
			{name: 'dpaket_sisa_paket', type: 'int', mapping: 'dpaket_sisa_paket'},
			{name: 'dpaket_jumlah', type: 'int', mapping: 'dpaket_jumlah'},
			{name: 'dpaket_master', type: 'int', mapping: 'dpaket_master'},
			{name: 'dpaket_paket', type: 'int', mapping: 'dpaket_paket'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var list_paket_hangus_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{jpaket_nobukti} | Pemilik : {cust_nama} ({cust_no}) | <b>{paket_nama}</b> | Sisa : {dpaket_sisa_paket} | Tgl Hangus : {tanggal_hangus:date("j M Y")}',
		'</div></tpl>'
    );
	
	cbo_list_info_data_paket_hangusDataStore = new Ext.data.Store({
		id: 'cbo_list_info_data_paket_hangusDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penghangusan_paket&m=get_info_paket_by_paket_id', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:penghangusan_pageS, paket_id : 0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dpaket_id'
		},[
			{name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'}, 
			{name: 'jpaket_tanggal', type: 'date', dateFormat:'Y-m-d', mapping: 'jpaket_tanggal'},
			{name: 'dpaket_kadaluarsa', type: 'date', dateFormat:'Y-m-d', mapping: 'dpaket_kadaluarsa'}, 
			{name: 'tanggal_hangus', type: 'date', dateFormat:'Y-m-d', mapping: 'tanggal_hangus'}, 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'}, 
			{name: 'paket_kode', type: 'string', mapping: 'paket_kode'},
			{name: 'paket_id', type: 'int', mapping: 'paket_id'},
			{name: 'paket_nama_cust', type: 'string', mapping: 'paket_nama_cust'},
			{name: 'paket_nama', type: 'string', mapping: 'paket_nama'},
			{name: 'dpaket_id', type: 'int', mapping: 'dpaket_id'},
			{name: 'dpaket_sisa_paket', type: 'int', mapping: 'dpaket_sisa_paket'},
			{name: 'dpaket_jumlah', type: 'int', mapping: 'dpaket_jumlah'},
			{name: 'dpaket_master', type: 'int', mapping: 'dpaket_master'},
			{name: 'dpaket_paket', type: 'int', mapping: 'dpaket_paket'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	
	
	penghangusan_paket_DataStore = new Ext.data.Store({
		id: 'penghangusan_paket_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penghangusan_paket&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: penghangusan_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'penghangusan_id', type: 'int', mapping: 'penghangusan_id'},
			{name: 'penghangusan_tanggal', type: 'date', mapping: 'penghangusan_tanggal'},
			{name: 'penghangusan_sisa_sebelum', type: 'int', mapping: 'penghangusan_sisa_sebelum'},
			{name: 'penghangusan_dpaket_id', type: 'int', mapping: 'penghangusan_dpaket_id'},
			{name: 'penghangusan_keterangan', type: 'string', mapping: 'penghangusan_keterangan'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_display', type: 'string', mapping: 'cust_display'},
			{name: 'paket_display', type: 'string', mapping: 'paket_display'},
			{name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'},
			{name: 'paket_nama', type: 'string', mapping: 'paket_nama'},
			{name: 'dpaket_kadaluarsa', type: 'date', dateFormat:'Y-m-d', mapping: 'dpaket_kadaluarsa'},
			{name: 'jpaket_tanggal', type: 'date', dateFormat:'Y-m-d', mapping: 'jpaket_tanggal'},
			{name: 'tanggal_hangus', type: 'date', dateFormat:'Y-m-d', mapping: 'tanggal_hangus'},
			{name: 'kadaluarsa_sebelum', type: 'date', dateFormat:'Y-m-d', mapping: 'kadaluarsa_sebelum'}
		]),
		sortInfo:{field: 'penghangusan_tanggal', direction: "DESC"}
	});
	/* End of Function */
	
	penghangusan_paket_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Tgl Penghapusan</div>',
			dataIndex: 'penghangusan_tanggal',
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			width: 60,
			sortable: true
			
		}, 

		{
			header: '<div align="center">Customer</div>',
			dataIndex: 'cust_display',
			width: 130,
			sortable: true
		
		}, 

		{
			header: '<div align="center">Paket</div>',
			dataIndex: 'paket_display',
			width: 165,
			sortable: true
		
		}, 
		{
			header: '<div align="center">Tgl Faktur</div>',
			dataIndex: 'jpaket_tanggal',
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			width: 45,
			sortable: true
			
		}, 
		
		{
			header: '<div align="center">Sisa</div>',
			dataIndex: 'penghangusan_sisa_sebelum',
			align: 'right',
			width: 40,
			sortable: true
		
		}, 
		
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'penghangusan_keterangan',
			width: 160,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 200
          	})
		
		}
		]
	);
	penghangusan_paket_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	penghangusan_paketListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'penghangusan_paketListEditorGrid',
		el: 'fp_penghangusan_paket',
		title: 'Daftar Paket yang Telah Dihapuskan (Write-Off)',
		autoHeight: true,
		store: penghangusan_paket_DataStore, // DataStore
		cm: penghangusan_paket_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,
		autoHeight: true,
		bbar: new Ext.PagingToolbar({
			pageSize: penghangusan_pageS,
			store: penghangusan_paket_DataStore,
			displayInfo: true
		}),
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',
			handler: display_form_search_window 
		},'-', /*{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			iconCls:'icon-refresh',
			disabled : true
		}*/]
	});
	penghangusan_paketListEditorGrid.render();
	
	//penghangusan_paketListEditorGrid.addListener('rowcontextmenu', onjoincustomer_ListEditGridContextMenu);
	penghangusan_paket_DataStore.load({params: {start: 0, limit: penghangusan_pageS}});

	penghangusan_paket_dpaket_masterField = new Ext.form.NumberField();
	penghangusan_paket_sisa_sebelumField = new Ext.form.NumberField();
	penghangusan_paket_paket_idField = new Ext.form.NumberField();
	penghangusan_paket_cust_idField = new Ext.form.NumberField();
	/* Identify  penghangusan_id Field */
	penghangusan_paket_idField= new Ext.form.NumberField({
		id: 'penghangusan_paket_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	penghangusan_paket_paketField = new Ext.form.ComboBox({
		fieldLabel: 'Paket Hangus yang akan Dihapuskan (Write-Off)',
		store: cbo_list_paket_hangusDataStore,
		mode: 'remote',
		displayField:'paket_nama_cust',
		valueField: 'dpaket_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: list_paket_hangus_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
		
	});
	
	penghangusan_paket_paketField.on("select",function(){
		var dpaket_id=penghangusan_paket_paketField.getValue();
		if(dpaket_id!==0){
			cbo_list_info_data_paket_hangusDataStore.load({
					params : { paket_id: dpaket_id},
					callback: function(opts, success, response)  {
						 if (success) {
							if(cbo_list_info_data_paket_hangusDataStore.getCount()){
								penghangusan_paket_record=cbo_list_info_data_paket_hangusDataStore.getAt(0).data;
								penghangusan_paket_dpaket_masterField.setValue(penghangusan_paket_record.dpaket_master);
								penghangusan_paket_sisa_sebelumField.setValue(penghangusan_paket_record.dpaket_sisa_paket);
								penghangusan_paket_paket_idField.setValue(penghangusan_paket_record.paket_id);
								penghangusan_paket_cust_idField.setValue(penghangusan_paket_record.cust_id);
							}else{
								//jproduk_cust_nomemberField.setValue("");
								//jproduk_valid_memberField.setValue("");
							}
						}
					}
			}); 
		}
	});
	
	
	penghangusan_paket_tglField= new Ext.form.DateField({
		id: 'penghangusan_paket_tglField',
		fieldLabel: 'Tanggal Penghapusan',
		format : 'd-m-Y',
		disabled : true,
		value : today
	});
	
	penghangusan_paket_keteranganField= new Ext.form.TextArea({
		id: 'penghangusan_paket_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 200,
		allowBlank : false,
		anchor: '95%'
	});
		
	/* Function for retrieve create Window Panel*/ 
	penghangusan_paket_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [penghangusan_paket_idField,penghangusan_paket_tglField, penghangusan_paket_paketField, penghangusan_paket_keteranganField] 
			}
			],
		buttons: [{
				text: 'Save',
				handler : penghangusan_paket_confirm_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					penghangusan_paket_saveWindow.hide();
					//mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	penghangusan_paket_saveWindow= new Ext.Window({
		id: 'penghangusan_paket_saveWindow',
		title:'Daftar Paket yang Akan Dihapuskan (Write-Off)',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_penghangusan_paket_save',
		items: penghangusan_paket_saveForm
	});
	/* End Window */


});
	</script>
<body>
<div>
	<div class="col">
		 <div id="fp_penghangusan_paket"></div>
		<div id="elwindow_penghangusan_paket_save"></div>
    </div>
</div>
</body>
</html>