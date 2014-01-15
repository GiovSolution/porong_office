<?php
/* 	
	+ Module  		: crm Generator View
	+ Description	: For record view
	+ Filename 		: v_crm_generator.php
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
var crm_generatorListEditorGrid;
var crm_generator_DataStore;
var crm_generator_ColumnModel;
var crm_generator_saveForm;
var crm_generator_saveWindow;
var crm_generator_idField;
//var joincustomer_customer_tujuan_Field;
var crm_generator_customerField;
//var joincustomer_pointField;
var crm_generator_tanggalField;
//var joincustomer_keteranganField;


//declare konstant
var post2db_crm_generator = 'CREATE';
var msg = '';
var pageS=15;

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
	function crm_generator_save(){
	
		if(is_crm_generator_form_valid()){	

			var crm_generator_id_create_pk=null;
			var crm_generator_cust_field = null;
			var cust_tujuan_id_field = null;
			var cust_point_field = null;
			var crm_generator_date_create="";
			var joincustomer_keterangan_create=null;
			
			if(crm_generator_idField.getValue()!== null){crm_generator_id_create_pk = crm_generator_idField.getValue();}
			//if(joincustomer_customer_tujuan_Field.getValue()!==null){cust_tujuan_id_field=joincustomer_customer_tujuan_Field.getValue();}
			//if(joincustomer_pointField.getValue()!==null){cust_point_field=joincustomer_pointField.getValue();}
			if(crm_generator_customerField.getValue()!==null){crm_generator_cust_field=crm_generator_customerField.getValue();}
			//if(joincustomer_keteranganField.getValue()!== null){joincustomer_keterangan_create = joincustomer_keteranganField.getValue();}
			if(crm_generator_tanggalField.getValue()!== ""){crm_generator_date_create = crm_generator_tanggalField.getValue().format('Y-m-d');}				
										
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_crm_generator&m=get_action',
				params: {
	
					task: post2db_crm_generator,
					crmvalue_id	: crm_generator_id_create_pk,		
					crmvalue_cust	: crm_generator_cust_field,
					//cust_tujuan_id	: cust_tujuan_id_field,
					//cust_point		: cust_point_field,
					crmvalue_date	: crm_generator_date_create				
					//join_keterangan	: joincustomer_keterangan_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db_crm_generator+' OK','Generate nilai CRM berhasil dilakukan.');
							crm_generator_DataStore.reload();
							crm_generator_saveWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Generate nilai CRM tidak dapat dilakukan',
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
    

	
	/* Function for get PK field */
	function get_pk_id(){
		if(post2db_crm_generator=='CREATE')
			return crm_generatorListEditorGrid.getSelectionModel().getSelected().get('crmvalue_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function crm_generator_reset_form(){
		crm_generator_idField.reset();
		crm_generator_idField.setValue(null);
		//joincustomer_customer_tujuan_Field.reset();
		//joincustomer_customer_tujuan_Field.setValue(null);
		crm_generator_customerField.reset();
		crm_generator_customerField.setValue(null);
		//joincustomer_keteranganField.reset();
		//joincustomer_keteranganField.setValue(null);
	}
 	/* End of Function */
	
	
	
	/* setValue to EDIT */
	function crm_generator_set_form(){
		crm_generator_idField.setValue(crm_generatorListEditorGrid.getSelectionModel().getSelected().get('crmvalue_id'));
		//joincustomer_customer_tujuan_Field.setValue(crm_generatorListEditorGrid.getSelectionModel().getSelected().get('join_cust_asal'));
		crm_generator_customerField.setValue(crm_generatorListEditorGrid.getSelectionModel().getSelected().get('join_cust_tujuan'));
		//joincustomer_keteranganField.setValue(crm_generatorListEditorGrid.getSelectionModel().getSelected().get('join_keterangan'));
		crm_generator_tanggalField.setValue(crm_generatorListEditorGrid.getSelectionModel().getSelected().get('join_tanggal'));
	}
	/* End setValue to EDIT*/
	
	/* Function for Check if the form is valid */
	function is_crm_generator_form_valid(){
		return (true &&  crm_generator_customerField.isValid() && true);
	}
  	/* End of Function */
  
	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!crm_generator_saveWindow.isVisible()){
			crm_generator_reset_form();
			crm_generator_saveWindow.show();
		} else {
			crm_generator_saveWindow.toFront();
		}
	}
  	/* End Function */
  
	function crm_generator_confirm_save(){
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan generate nilai CRM pada customer ini?', crm_generator_button);
	}
	
	function crm_generator_button(btn){
		if(btn=='yes'){
			crm_generator_save();
		}
	
	}
	
	//ComboBox ambil data Customer
	cbo_crm_generator_customerDataStore = new Ext.data.Store({
		id: 'cbo_crm_generator_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_crm_generator&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS }, // parameter yang di $_POST ke Controller
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
	var crm_generator_customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
	cbo_crm_generator_customerDataStore2 = new Ext.data.Store({
		id: 'cbo_crm_generator_customerDataStore2',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_crm_generator&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS }, // parameter yang di $_POST ke Controller
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
	var crm_generator_customer_tpl2 = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
	/*
	set_cust_point_DataStore = new Ext.data.Store({
		id: 'set_cust_point_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_crm_generator&m=set_cust_point', 
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
	*/
	
	crm_generator_DataStore = new Ext.data.Store({
		id: 'crm_generator_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_crm_generator&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'crmvalue_id', type: 'int', mapping: 'crmvalue_id'},
			{name: 'crmvalue_date', type: 'date',dateFormat: 'Y-m-d H:i:s', mapping: 'crmvalue_date'},
			{name: 'crmvalue_cust_no', type: 'string', mapping: 'crmvalue_cust_no'},
			{name: 'crmvalue_cust', type: 'string', mapping: 'crmvalue_cust'},
			{name: 'crmvalue_frequency', type: 'float', mapping: 'crmvalue_frequency'},
			{name: 'crmvalue_recency', type: 'float', mapping: 'crmvalue_recency'},
			{name: 'crmvalue_spending', type: 'float', mapping: 'crmvalue_spending'},
			{name: 'crmvalue_highmargin', type: 'float', mapping: 'crmvalue_highmargin'},
			{name: 'crmvalue_referal', type: 'float', mapping: 'crmvalue_referal'},
			{name: 'crmvalue_kerewelan', type: 'float', mapping: 'crmvalue_kerewelan'},
			{name: 'crmvalue_disiplin_batal', type: 'float', mapping: 'crmvalue_disiplin_batal'},
			{name: 'crmvalue_disiplin_telat', type: 'float', mapping: 'crmvalue_disiplin_telat'},
			{name: 'crmvalue_treatment', type: 'float', mapping: 'crmvalue_treatment'},
			{name: 'crmvalue_frequency_real', type: 'int', mapping: 'crmvalue_frequency_real'},
			{name: 'crmvalue_recency_real', type: 'float', mapping: 'crmvalue_recency_real'},
			{name: 'crmvalue_spending_real_rp', type: 'float', mapping: 'crmvalue_spending_real_rp'},
			{name: 'crmvalue_spending_real_kunj', type: 'float', mapping: 'crmvalue_spending_real_kunj'},
			{name: 'crmvalue_highmargin_real', type: 'float', mapping: 'crmvalue_highmargin_real'},
			{name: 'crmvalue_referal_real', type: 'float', mapping: 'crmvalue_referal_real'},
			{name: 'crmvalue_kerewelan_real', type: 'string', mapping: 'crmvalue_kerewelan_real'},
			{name: 'crmvalue_disiplin_batal_real', type: 'float', mapping: 'crmvalue_disiplin_batal_real'},
			{name: 'crmvalue_disiplin_telat_real', type: 'float', mapping: 'crmvalue_disiplin_telat_real'},
			{name: 'crmvalue_treatment', type: 'float', mapping: 'crmvalue_treatment'},
			{name: 'crmvalue_total', type: 'float', mapping: 'crmvalue_total'},
			{name: 'crmvalue_priority', type: 'string', mapping: 'crmvalue_priority'}
		]),
		sortInfo:{field: 'crmvalue_id', direction: "ASC"}
	});
	/* End of Function */
	
	crm_generator_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'crmvalue_date',
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			width: 80,
			sortable: true	
		}, 
		{
			header: '<div align="center">No Cust</div>',
			dataIndex: 'crmvalue_cust_no',
			width: 80,
			sortable: true		
		}, 
		{
			header: '<div align="center">Customer</div>',
			dataIndex: 'crmvalue_cust',
			width: 200,
			sortable: true		
		}, 
		{
			header: '<div align="center">Freq</div>',
			align: 'right',
			dataIndex: 'crmvalue_frequency',
			width: 60,
			sortable: true		
		}, 		
		{
			header: '<div align="center">Rec</div>',
			align: 'right',
			dataIndex: 'crmvalue_recency',
			width: 60,
			sortable: true
		},		
		{
			header: '<div align="center">Spend</div>',
			align: 'right',
			dataIndex: 'crmvalue_spending',
			width: 60,
			sortable: true
		}, 		
		{
			header: '<div align="center">High M</div>',
			align: 'right',
			dataIndex: 'crmvalue_highmargin',
			width: 60,
			sortable: true
		}, 		
		{
			header: '<div align="center">Ref</div>',
			align: 'right',
			dataIndex: 'crmvalue_referal',
			width: 60,
			sortable: true
		}, 		
		{
			header: '<div align="center">Fret</div>',
			align: 'right',
			dataIndex: 'crmvalue_kerewelan',
			width: 60,
			sortable: true
		}, 		
		{
			header: '<div align="center">Batal</div>',
			align: 'right',
			dataIndex: 'crmvalue_disiplin_batal',
			width: 60,
			sortable: true
		}, 	
		{
			header: '<div align="center">! On Time</div>',
			align: 'right',
			dataIndex: 'crmvalue_disiplin_telat',
			width: 60,
			sortable: true
		}, 	
		{
			header: '<div align="center">Tx Utama</div>',
			align: 'right',
			dataIndex: 'crmvalue_treatment',
			width: 60,
			sortable: true
		},
		{
			header: '<div align="center">Total</div>',
			align: 'right',
			dataIndex: 'crmvalue_total',
			width: 60,
			sortable: true
		},
		{
			header: '<div align="center">Priority</div>',
			dataIndex: 'crmvalue_priority',
			width: 80,
			sortable: true		
		}, 
		{
			header: '<div align="center">Freq Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_frequency_real',
			width: 60,
			hidden: true,
			sortable: true		
		}, 		
		{
			header: '<div align="center">Rec Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_recency_real',
			width: 60,
			hidden: true,
			sortable: true
		},		
		{
			header: '<div align="center">Spend Rp</div>',
			align: 'right',
			dataIndex: 'crmvalue_spending_real_rp',
			width: 80,
			hidden: true,
			sortable: true
		}, 		
		{
			header: '<div align="center">Spend Kunj</div>',
			align: 'right',
			dataIndex: 'crmvalue_spending_real_kunj',
			width: 60,
			hidden: true,
			sortable: true
		}, 		
		{
			header: '<div align="center">HM Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_highmargin_real',
			width: 60,
			hidden: true,
			sortable: true
		}, 		
		{
			header: '<div align="center">Ref Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_referal_real',
			width: 60,
			hidden: true,
			sortable: true
		}, 		
		{
			header: '<div align="center">Fret Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_kerewelan_real',
			width: 80,
			hidden: true,
			sortable: true
		}, 		
		{
			header: '<div align="center">Batal Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_disiplin_batal_real',
			width: 60,
			hidden: true,
			sortable: true
		}, 	
		{
			header: '<div align="center">!On Time Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_disiplin_telat_real',
			width: 60,
			hidden: true,
			sortable: true
		}, 	
		{
			header: '<div align="center">Tx Utama Value</div>',
			align: 'right',
			dataIndex: 'crmvalue_treatment_real',
			width: 60,
			hidden: true,
			sortable: true
		},
		
				
		]
	);
	crm_generator_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	crm_generatorListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'crm_generatorListEditorGrid',
		el: 'fp_vu_crm_generator',
		title: 'Daftar CRM Value',
		autoHeight: true,
		store: crm_generator_DataStore, // DataStore
		cm: crm_generator_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		autoHeight: true,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: crm_generator_DataStore,
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
	crm_generatorListEditorGrid.render();
	
	/* Event while selected row via context menu */
	function oncrm_generator_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		crm_generator_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		crm_generator_SelectedRow=rowIndex;
		crm_generator_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function crm_generator_editContextMenu(){
      crm_generatorListEditorGrid.startEditing(crm_generator_SelectedRow,1);
  	}
	/* End of Function */
  	
	crm_generatorListEditorGrid.addListener('rowcontextmenu', oncrm_generator_ListEditGridContextMenu);
	crm_generator_DataStore.load({params: {start: 0, limit: pageS}});
	

	/* Identify  join_id Field */
	crm_generator_idField= new Ext.form.NumberField({
		id: 'crm_generator_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	crm_generator_customerField = new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_crm_generator_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: crm_generator_customer_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	/*
	joincustomer_customer_tujuan_Field = new Ext.form.ComboBox({
		fieldLabel: 'Customer tujuan',
		store: cbo_crm_generator_customerDataStore2,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: crm_generator_customer_tpl2,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '90%'
	});
	*/
	/*
	joincustomer_pointField= new Ext.form.NumberField({
		id: 'joincustomer_pointField',
		//store: cbo_crm_generator_customerDataStore2,
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
	*/
	
	crm_generator_tanggalField= new Ext.form.DateField({
		id: 'crm_generator_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
		disabled : true,
		value : today
	});
	
	/*
	joincustomer_keteranganField= new Ext.form.TextArea({
		id: 'joincustomer_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 200,
		anchor: '95%'
	});
	*/
	crm_generator_infoketeranganField=new Ext.form.Label({ html: '<br><br> *Klik tombol "Generate" untuk memproses nilai CRM'});

	/* Function for retrieve create Window Panel*/ 
	crm_generator_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [crm_generator_idField,crm_generator_tanggalField, crm_generator_customerField, crm_generator_infoketeranganField] 
			}
			],
		buttons: [{
				text: 'Generate',
				handler : crm_generator_confirm_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					crm_generator_saveWindow.hide();
					//mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	crm_generator_saveWindow= new Ext.Window({
		id: 'crm_generator_saveWindow',
		title:'Add Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_crm_generator_save',
		items: crm_generator_saveForm
	});
	/* End Window */
	
	//crm_generator_saveWindow.show();
	/*
	crm_generator_customerField.on("select",function(){
		load_set_cust_point();
		j=set_cust_point_DataStore.find('cust_id', crm_generator_customerField.getValue());
		if(j>-1)
			joincustomer_pointField.setValue(set_cust_point_DataStore.getAt(j).cust_point);
		else
			joincustomer_pointField.setValue("");
	
	});
	*/
	
});
	</script>
<body>
<div>
	<div class="col">
		 <div id="fp_vu_crm_generator"></div>
		<div id="elwindow_crm_generator_save"></div>
    </div>
</div>
</body>
</html>