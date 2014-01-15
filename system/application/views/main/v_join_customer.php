<?php
/* 	
	+ Module  		: join_customer View
	+ Description	: For record view
	+ Filename 		: v_join_customer.php
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
var join_customerListEditorGrid;
var join_customer_DataStore;
var join_customer_ColumnModel;
var joincustomer_saveForm;
var joincustomer_saveWindow;
var joincustomer_idField;
var joincustomer_customer_tujuan_Field;
var joincustomer_customer_awal_Field;
var joincustomer_pointField;
var joincustomer_tanggalField;
var joincustomer_keteranganField;


//declare konstant
var join_customer_post2db = 'CREATE';
var msg = '';
var join_customer_pageS=15;

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
	function join_customer_save(){
	
		if(is_joincustomer_form_valid()){	

			var joincustomer_id_create_pk=null;
			var cust_asal_id_field = null;
			var cust_tujuan_id_field = null;
			var cust_point_field = null;
			var joincustomer_tanggal_create="";
			var joincustomer_keterangan_create=null;
			
			if(joincustomer_idField.getValue()!== null){joincustomer_id_create_pk = joincustomer_idField.getValue();}
			if(joincustomer_customer_tujuan_Field.getValue()!==null){cust_tujuan_id_field=joincustomer_customer_tujuan_Field.getValue();}
			if(joincustomer_pointField.getValue()!==null){cust_point_field=joincustomer_pointField.getValue();}
			if(joincustomer_customer_awal_Field.getValue()!==null){cust_asal_id_field=joincustomer_customer_awal_Field.getValue();}
			if(joincustomer_keteranganField.getValue()!== null){joincustomer_keterangan_create = joincustomer_keteranganField.getValue();}
			if(joincustomer_tanggalField.getValue()!== ""){joincustomer_tanggal_create = joincustomer_tanggalField.getValue().format('Y-m-d');}				
										
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_join_customer&m=get_action',
				params: {
	
					task: join_customer_post2db,
					join_id	: joincustomer_id_create_pk,		
					cust_asal_id	: cust_asal_id_field,
					cust_tujuan_id	: cust_tujuan_id_field,
					cust_point		: cust_point_field,
					join_tanggal	: joincustomer_tanggal_create,					
					join_keterangan	: joincustomer_keterangan_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(join_customer_post2db+' OK','Penggabungan Customer berhasil dilakukan.');
							join_customer_DataStore.reload();
							joincustomer_saveWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Penggabungan Customer tidak dapat dilakukan',
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
			
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Your Form is not valid!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
    
	function load_set_cust_point(){
		if(joincustomer_customer_awal_Field.getValue()!=''){
			set_cust_point_DataStore.load({
					params : { cust_id : joincustomer_customer_awal_Field.getValue() },
					callback: function(opts, success, response)  {
						 if (success) {
							if(set_cust_point_DataStore.getCount()){
								auto_cust_point=set_cust_point_DataStore.getAt(0).data;
								joincustomer_pointField.setValue(auto_cust_point.cust_point);
							}
						}
					}
			}); 
		}
	}
	
	
	
	
	/* Function for get PK field */
	function get_pk_id(){
		if(join_customer_post2db=='CREATE')
			return join_customerListEditorGrid.getSelectionModel().getSelected().get('join_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function joincustomer_reset_form(){
		joincustomer_idField.reset();
		joincustomer_idField.setValue(null);
		joincustomer_customer_tujuan_Field.reset();
		joincustomer_customer_tujuan_Field.setValue(null);
		joincustomer_customer_awal_Field.reset();
		joincustomer_customer_awal_Field.setValue(null);
		joincustomer_keteranganField.reset();
		joincustomer_keteranganField.setValue(null);
	}
 	/* End of Function */
	
	
	
	/* setValue to EDIT */
	function joincustomer_set_form(){
		joincustomer_idField.setValue(join_customerListEditorGrid.getSelectionModel().getSelected().get('join_id'));
		joincustomer_customer_tujuan_Field.setValue(join_customerListEditorGrid.getSelectionModel().getSelected().get('join_cust_asal'));
		joincustomer_customer_awal_Field.setValue(join_customerListEditorGrid.getSelectionModel().getSelected().get('join_cust_tujuan'));
		joincustomer_keteranganField.setValue(join_customerListEditorGrid.getSelectionModel().getSelected().get('join_keterangan'));
		joincustomer_tanggalField.setValue(join_customerListEditorGrid.getSelectionModel().getSelected().get('join_tanggal'));
	}
	/* End setValue to EDIT*/
	
	/* Function for Check if the form is valid */
	function is_joincustomer_form_valid(){
		return (true &&  joincustomer_customer_awal_Field.isValid() && joincustomer_customer_tujuan_Field.isValid() && true);
	}
  	/* End of Function */
  
	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!joincustomer_saveWindow.isVisible()){
			joincustomer_reset_form();
			joincustomer_saveWindow.show();
		} else {
			joincustomer_saveWindow.toFront();
		}
	}
  	/* End Function */
  
	function join_customer_confirm_save(){
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan penggabungan customer ini?', join_customer_button);
	}
	
	function join_customer_button(btn){
		if(btn=='yes'){
			join_customer_save();
		}
	
	}
	
	//ComboBox ambil data Customer
	cbo_joincustomer_customerDataStore = new Ext.data.Store({
		id: 'cbo_joincustomer_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_join_customer&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:join_customer_pageS }, // parameter yang di $_POST ke Controller
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
	//Template yang akan tampil di ComboBox
	var joincustomer_customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            'Alamat: {cust_alamat}<br/>Telp Rumah: {cust_telprumah}',
        '</div></tpl>'
    );
	
	cbo_joincustomer_customerDataStore2 = new Ext.data.Store({
		id: 'cbo_joincustomer_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_join_customer&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:join_customer_pageS }, // parameter yang di $_POST ke Controller
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
			{name: 'cust_point', type: 'int', mapping: 'cust_point'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var joincustomer_customer_tpl2 = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            'Alamat: {cust_alamat}<br/>Telp Rumah: {cust_telprumah}',
        '</div></tpl>'
    );
	
	/* Identify datastore utk ngeset cust_point */
	set_cust_point_DataStore = new Ext.data.Store({
		id: 'set_cust_point_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_join_customer&m=set_cust_point', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'cust_point', type: 'int', mapping: 'cust_point'}
		]),
		sortInfo:{field: 'cust_point', direction: "ASC"}
	});
	
	

	join_customer_DataStore = new Ext.data.Store({
		id: 'join_customer_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_join_customer&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: join_customer_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'join_id', type: 'int', mapping: 'join_id'},
			{name: 'join_tanggal', type: 'date', mapping: 'join_tanggal'},
			{name: 'join_cust_asal', type: 'int', mapping: 'join_cust_asal'},
			{name: 'join_cust_tujuan', type: 'int', mapping: 'join_cust_tujuan'},
			{name: 'join_keterangan', type: 'string', mapping: 'join_keterangan'},
			{name: 'cust_nama_asal', type: 'string', mapping: 'cust_nama_asal'},
			{name: 'cust_nama_tujuan', type: 'string', mapping: 'cust_nama_tujuan'}
		]),
		sortInfo:{field: 'join_id', direction: "ASC"}
	});
	/* End of Function */
	
	join_customer_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'join_tanggal',
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			width: 70,
			sortable: true
			
		}, 
		{
			header: '<div align="center">Customer Asal</div>',
			dataIndex: 'cust_nama_asal',
			width: 100,
			sortable: true
		
		}, 
		{
			header: '<div align="center">Customer Tujuan</div>',
			dataIndex: 'cust_nama_tujuan',
			width: 100,
			sortable: true
		
		}, 
		
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'join_keterangan',
			width: 250,
			sortable: true
		
		}
		]
	);
	join_customer_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	join_customerListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'join_customerListEditorGrid',
		el: 'fp_vu_penggabungan_customer',
		title: 'Penggabungan Customer',
		autoHeight: true,
		store: join_customer_DataStore, // DataStore
		cm: join_customer_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		autoHeight: true,
		bbar: new Ext.PagingToolbar({
			pageSize: join_customer_pageS,
			store: join_customer_DataStore,
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
	join_customerListEditorGrid.render();
	
	/* Event while selected row via context menu */
	function onjoincustomer_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		joincustomer_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		joincustomer_SelectedRow=rowIndex;
		joincustomer_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function joincustomer_editContextMenu(){
      join_customerListEditorGrid.startEditing(joincustomer_SelectedRow,1);
  	}
	/* End of Function */
  	
	join_customerListEditorGrid.addListener('rowcontextmenu', onjoincustomer_ListEditGridContextMenu);
	join_customer_DataStore.load({params: {start: 0, limit: join_customer_pageS}});
	

	/* Identify  join_id Field */
	joincustomer_idField= new Ext.form.NumberField({
		id: 'joincustomer_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	joincustomer_customer_awal_Field = new Ext.form.ComboBox({
		fieldLabel: 'Customer yang akan digabungkan',
		store: cbo_joincustomer_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: joincustomer_customer_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	
	joincustomer_customer_tujuan_Field = new Ext.form.ComboBox({
		fieldLabel: 'Customer tujuan',
		store: cbo_joincustomer_customerDataStore2,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: joincustomer_customer_tpl2,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	
	joincustomer_pointField= new Ext.form.NumberField({
		id: 'joincustomer_pointField',
		//store: cbo_joincustomer_customerDataStore2,
		//valueField: 'cust_point',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	
	joincustomer_tanggalField= new Ext.form.DateField({
		id: 'joincustomer_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		disabled : true,
		value : today
	});
	
	joincustomer_keteranganField= new Ext.form.TextArea({
		id: 'joincustomer_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 200,
		anchor: '95%'
	});
		
	joincustomer_infoketeranganField=new Ext.form.Label({ html: '<br><br> *Customer asal yang telah digabungkan akan diubah menjadi "Tidak Aktif" <br><br>*Jika customer asal adalah member, maka customer tujuan perlu didaftarkan lagi sebagai member dan sesuaikan nomor member baru dengan nomor member customer asal'});

	/* Function for retrieve create Window Panel*/ 
	joincustomer_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [joincustomer_idField,joincustomer_tanggalField, joincustomer_customer_awal_Field, joincustomer_customer_tujuan_Field, joincustomer_pointField, joincustomer_keteranganField, joincustomer_infoketeranganField] 
			}
			],
		buttons: [{
				text: 'Gabungkan',
				handler : join_customer_confirm_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					joincustomer_saveWindow.hide();
					//mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	joincustomer_saveWindow= new Ext.Window({
		id: 'joincustomer_saveWindow',
		title:'Penggabungan Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_joincustomer_save',
		items: joincustomer_saveForm
	});
	/* End Window */
	
	//joincustomer_saveWindow.show();
	
	joincustomer_customer_awal_Field.on("select",function(){
		load_set_cust_point();
		j=set_cust_point_DataStore.find('cust_id', joincustomer_customer_awal_Field.getValue());
		if(j>-1)
			joincustomer_pointField.setValue(set_cust_point_DataStore.getAt(j).cust_point);
		else
			joincustomer_pointField.setValue("");
	
	});
	
	
});
	</script>
<body>
<div>
	<div class="col">
		 <div id="fp_vu_penggabungan_customer"></div>
		<div id="elwindow_joincustomer_save"></div>
    </div>
</div>
</body>
</html>