<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: outbox View
	+ Description	: For record view
	+ Filename 		: v_outbox.php
 	+ creator  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
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
var outbox_DataStore;
var outbox_ColumnModel;
var outboxListEditorGrid;
var outbox_saveForm;
var outbox_saveWindow;
var outbox_searchForm;
var outbox_searchWindow;
var outbox_SelectedRow;
var outbox_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var outbox_idField;
var outbox_destinationField;
var outbox_messageField;
var outbox_dateField;
var outbox_idSearchField;
var outbox_destinationSearchField;
var outbox_messageSearchField;
var outbox_dateSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function outbox_inline_update(oGrid_event){
		var outbox_id_update_pk="";
		var outbox_destination_update=null;
		var outbox_message_update=null;
		var outbox_date_update_date="";

		outbox_id_update_pk = oGrid_event.record.data.ID;
		if(oGrid_event.record.data.outbox_destination!== null){outbox_destination_update = oGrid_event.record.data.outbox_destination;}
		if(oGrid_event.record.data.outbox_message!== null){outbox_message_update = oGrid_event.record.data.outbox_message;}
	 	if(oGrid_event.record.data.outbox_date!== ""){outbox_date_update_date =oGrid_event.record.data.outbox_date.format('Y-m-d');}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_outbox&m=get_action',
			params: {
				ID	: outbox_id_update_pk, 
				outbox_destination	:outbox_destination_update,
				outbox_message	:outbox_message_update,
				outbox_date	: outbox_date_update_date, 
				task: "UPDATE"
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						outbox_DataStore.commitChanges();
						outbox_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not save the Outbox.',
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
  	/* End of Function */
  
  	/* Function for add and edit data form, open window form */
	function outbox_save(){
	
		if(is_outbox_form_valid()){	
			var outbox_id_field_pk=null; 
			var outbox_destination_field=null; 
			var outbox_message_field=null; 
			var outbox_date_field_date=""; 

			outbox_id_field_pk=get_pk_id();
			if(outbox_destinationField.getValue()!== null){outbox_destination_field = outbox_destinationField.getValue();} 
			if(outbox_messageField.getValue()!== null){outbox_message_field = outbox_messageField.getValue();} 
			if(outbox_dateField.getValue()!== ""){outbox_date_field_date = outbox_dateField.getValue().format('Y-m-d');} 

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_outbox&m=get_action',
				params: {
					ID	: outbox_id_field_pk, 
					outbox_destination	: outbox_destination_field, 
					outbox_message	: outbox_message_field, 
					outbox_date	: outbox_date_field_date, 
					task: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The Outbox was '+post2db+' successfully.');
							outbox_DataStore.reload();
							outbox_saveWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the Outbox.',
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
		if(post2db=='UPDATE')
			return outboxListEditorGrid.getSelectionModel().getSelected().get('ID');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function outbox_reset_form(){
		outbox_destinationField.reset();
		outbox_destinationField.setValue(null);
		outbox_messageField.reset();
		outbox_messageField.setValue(null);
		outbox_dateField.reset();
		outbox_dateField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function outbox_set_form(){
		outbox_destinationField.setValue(outboxListEditorGrid.getSelectionModel().getSelected().get('outbox_destination'));
		outbox_messageField.setValue(outboxListEditorGrid.getSelectionModel().getSelected().get('outbox_message'));
		outbox_dateField.setValue(outboxListEditorGrid.getSelectionModel().getSelected().get('outbox_date'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_outbox_form_valid(){
		return (true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!outbox_saveWindow.isVisible()){
			outbox_reset_form();
			post2db='CREATE';
			msg='created';
			outbox_saveWindow.show();
		} else {
			outbox_saveWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function outbox_confirm_delete(){
		// only one outbox is selected here
		if(outboxListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', outbox_delete);
		} else if(outboxListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', outbox_delete);
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

	function outbox_confirm_delete_all(){
		// only one outbox is selected here
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus semua data?', outbox_delete_all);
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function outbox_confirm_update(){
		/* only one record is selected here */
		if(outboxListEditorGrid.selModel.getCount() == 1) {
			outbox_set_form();
			post2db='UPDATE';
			msg='updated';
			outbox_saveWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really update something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function outbox_delete(btn){
		if(btn=='yes'){
			var selections = outboxListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< outboxListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.ID);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_outbox&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							outbox_DataStore.reload();
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
		}  
	}

	function outbox_delete_all(btn){
		if(btn=='yes'){
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_outbox&m=get_action', 
				params: { task: "DELETE ALL" }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							outbox_DataStore.reload();
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
		}  
	}

  	/* End of Function */
  
  /* Identify status unsent*/
	outbox_status_unsentField=new Ext.form.TextField({
		id: 'outbox_status_unsentField',
		name: 'outbox_status_unsentField',
		fieldLabel: '<b>Unsent</b>',
		width: 60,
		readOnly: true
	});
	
	/* Identify status sent*/
	outbox_status_sentField=new Ext.form.TextField({
		id: 'outbox_status_sentField',
		//name: 'outbox_status_sentField',
		fieldLabel: '<b>Sent</b>',
		width: 60,
		readOnly: true
	});
	
	/* Identify status failed*/
	outbox_status_failedField=new Ext.form.TextField({
		id: 'outbox_status_failedField',
		name: 'outbox_status_failedField',
		fieldLabel: '<b>Failed</b>',
		width: 60,
		readOnly: true
	});
  
  

/* Function for Retrieve DataStore */
	outbox_DataStore = new Ext.data.Store({
		id: 'outbox_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_outbox&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'ID'
		},[
		/* dataIndex => insert intooutbox_ColumnModel, Mapping => for initiate table column */ 
			{name: 'ID', type: 'int', mapping: 'ID'}, 
			{name: 'outbox_cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'outbox_cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'outbox_destination', type: 'string', mapping: 'outbox_destination'}, 
			{name: 'outbox_message', type: 'string', mapping: 'outbox_message'}, 
			{name: 'outbox_date', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'outbox_date'}, 
			{name: 'outbox_status', type: 'string', mapping: 'outbox_status'}, 
			{name: 'outbox_creator', type: 'string', mapping: 'outbox_creator'}, 
			{name: 'outbox_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'outbox_date_create'}, 
			{name: 'outbox_update', type: 'string', mapping: 'outbox_update'}, 
			{name: 'outbox_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'outbox_date_update'}, 
			{name: 'outbox_revised', type: 'int', mapping: 'outbox_revised'} 
		]),
//		sortInfo:{field: 'ID', direction: "DESC"}
	});
	
	/* Function for Retrieve DataStore */
	outbox_status_sentDataStore = new Ext.data.Store({
		id: 'outbox_status_sentDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_outbox&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "STATUS_SENT", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intooutbox_ColumnModel, Mapping => for initiate table column */ 
			//{name: 'ID', type: 'int', mapping: 'ID'}, 
			{name: 'status_sent', type: 'int', mapping: 'status_sent'}
		])
	});
	
	
	/* Function for Retrieve DataStore */
	outbox_status_unsentDataStore = new Ext.data.Store({
		id: 'outbox_status_unsentDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_outbox&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "STATUS_UNSENT", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intooutbox_ColumnModel, Mapping => for initiate table column */ 
			{name: 'status_unsent', type: 'int', mapping: 'status_unsent'}
		])
	});
	
	
	/* Function for Retrieve DataStore */
	outbox_status_failedDataStore = new Ext.data.Store({
		id: 'outbox_status_failedDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_outbox&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "STATUS_FAILED", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intooutbox_ColumnModel, Mapping => for initiate table column */ 
			{name: 'status_failed', type: 'int', mapping: 'status_failed'}
		])
	});
	
  	/* Function for Identify of Window Column Model */
	outbox_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'ID',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">Tanggal Kirim</div>',
			dataIndex: 'outbox_date',
			width: 60,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">Isi Pesan</div>',
			dataIndex: 'outbox_message',
			width: 300,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No Cust</div>',
			dataIndex: 'outbox_cust_no',
			width: 60,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Customer</div>',
			dataIndex: 'outbox_cust_nama',
			width: 160,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No HP</div>',
			dataIndex: 'outbox_destination',
			width: 60,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Status</div>',
			dataIndex: 'outbox_status',
			width: 60,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Creator',
			dataIndex: 'outbox_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'outbox_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'outbox_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'outbox_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'outbox_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	outbox_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	outboxListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'outboxListEditorGrid',
		el: 'fp_outbox',
		title: 'Outbox',
		autoHeight: true,
		store: outbox_DataStore, // DataStore
		cm: outbox_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: outbox_DataStore,
			//handler : load_status_all(),
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: outbox_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Delete All',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: outbox_confirm_delete_all   // Confirm before deleting
		}, '-', {
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: outbox_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: outbox_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: outbox_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: outbox_print  
		},
		'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
		{
			'text':'Unsent : '
		},
		outbox_status_unsentField,
		{
			'text':'Sent : '
		},
		outbox_status_sentField,
		{
			'text':'Failed : '
		},
		outbox_status_failedField		
		]
	});
	outboxListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	outbox_ContextMenu = new Ext.menu.Menu({
		id: 'outbox_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: outbox_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: outbox_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: outbox_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onoutbox_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		outbox_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		outbox_SelectedRow=rowIndex;
		outbox_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function outbox_editContextMenu(){
		//outboxListEditorGrid.startEditing(outbox_SelectedRow,1);
		outbox_confirm_update();
  	}
	/* End of Function */
  	
	outboxListEditorGrid.addListener('rowcontextmenu', onoutbox_ListEditGridContextMenu);
	outbox_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	//load_status_all();
	outbox_status_sentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_sent =outbox_status_sentDataStore.getAt(0).data;
						outbox_status_sentField.setValue(auto_status_sent.status_sent);
				}
			}
	});
	
	outbox_status_unsentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_unsent =outbox_status_unsentDataStore.getAt(0).data;
						outbox_status_unsentField.setValue(auto_status_unsent.status_unsent);
				}
			}
	});
	
	outbox_status_failedDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_failed =outbox_status_failedDataStore.getAt(0).data;
						outbox_status_failedField.setValue(auto_status_failed.status_failed);
				}
			}
	});
					
	outboxListEditorGrid.on('afteredit', outbox_inline_update); // inLine Editing Record
	
	/* Identify  outbox_destination Field */
	outbox_destinationField= new Ext.form.TextField({
		id: 'outbox_destinationField',
		fieldLabel: 'Destination',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  outbox_message Field */
	outbox_messageField= new Ext.form.TextArea({
		id: 'outbox_messageField',
		fieldLabel: 'Message',
		height: 60,
		grow: false,
		anchor: '95%'
	});
	/* Identify  outbox_date Field */
	outbox_dateField= new Ext.form.DateField({
		id: 'outbox_dateField',
		fieldLabel: 'Date',
		format : 'Y-m-d'
	});
	
	

	/* Function for retrieve create Window Panel*/ 
	outbox_saveForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [outbox_destinationField, outbox_messageField, outbox_dateField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: outbox_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					outbox_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	outbox_saveWindow= new Ext.Window({
		id: 'outbox_saveWindow',
		title: post2db+'Outbox',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_outbox_save',
		items: outbox_saveForm
	});
	/* End Window */
	
	/* Function for action list search */
	function outbox_list_search(){
		// render according to a SQL date format.
		var outbox_id_search=null;
		var outbox_destination_search=null;
		var outbox_message_search=null;
		var outbox_date_search_date="";

		if(outbox_idSearchField.getValue()!==null){outbox_id_search=outbox_idSearchField.getValue();}
		if(outbox_destinationSearchField.getValue()!==null){outbox_destination_search=outbox_destinationSearchField.getValue();}
		if(outbox_messageSearchField.getValue()!==null){outbox_message_search=outbox_messageSearchField.getValue();}
		if(outbox_dateSearchField.getValue()!==""){outbox_date_search_date=outbox_dateSearchField.getValue().format('Y-m-d');}
		// change the store parameters
		outbox_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			ID	:	outbox_id_search, 
			outbox_destination	:	outbox_destination_search, 
			outbox_message	:	outbox_message_search, 
			outbox_date	:	outbox_date_search_date
		};
		// Cause the datastore to do another query : 
		outbox_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function outbox_reset_search(){
		// reset the store parameters
		outbox_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		outbox_DataStore.reload({params: {start: 0, limit: pageS}});
		outbox_status_sentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_sent =outbox_status_sentDataStore.getAt(0).data;
						outbox_status_sentField.setValue(auto_status_sent.status_sent);
				}
			}
	});
	
	outbox_status_unsentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_unsent =outbox_status_unsentDataStore.getAt(0).data;
						outbox_status_unsentField.setValue(auto_status_unsent.status_unsent);
				}
			}
	});
	
	outbox_status_failedDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_failed =outbox_status_failedDataStore.getAt(0).data;
						outbox_status_failedField.setValue(auto_status_failed.status_failed);
				}
			}
	});
		
		outbox_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  outbox_id Search Field */
	outbox_idSearchField= new Ext.form.NumberField({
		id: 'outbox_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  outbox_destination Search Field */
	outbox_destinationSearchField= new Ext.form.TextField({
		id: 'outbox_destinationSearchField',
		fieldLabel: 'Destination',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  outbox_message Search Field */
	outbox_messageSearchField= new Ext.form.TextField({
		id: 'outbox_messageSearchField',
		fieldLabel: 'Message',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  outbox_date Search Field */
	outbox_dateSearchField= new Ext.form.DateField({
		id: 'outbox_dateSearchField',
		fieldLabel: 'Date',
		format : 'Y-m-d',
	
	});
    
	/* Function for retrieve search Form Panel */
	outbox_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [outbox_destinationSearchField, outbox_messageSearchField, outbox_dateSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: outbox_list_search
			},{
				text: 'Close',
				handler: function(){
					outbox_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	outbox_searchWindow = new Ext.Window({
		title: 'Outbox Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_outbox_search',
		items: outbox_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!outbox_searchWindow.isVisible()){
			outbox_searchWindow.show();
		} else {
			outbox_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function outbox_print(){
		var searchquery = "";
		var outbox_destination_print=null;
		var outbox_message_print=null;
		var outbox_date_print_date="";
		var win;              
		// check if we do have some search data...
		if(outbox_DataStore.baseParams.query!==null){searchquery = outbox_DataStore.baseParams.query;}
		if(outbox_DataStore.baseParams.outbox_destination!==null){outbox_destination_print = outbox_DataStore.baseParams.outbox_destination;}
		if(outbox_DataStore.baseParams.outbox_message!==null){outbox_message_print = outbox_DataStore.baseParams.outbox_message;}
		if(outbox_DataStore.baseParams.outbox_date!==""){outbox_date_print_date = outbox_DataStore.baseParams.outbox_date;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_outbox&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			outbox_destination : outbox_destination_print,
			outbox_message : outbox_message_print,
		  	outbox_date : outbox_date_print_date, 
		  	currentlisting: outbox_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/outbox_printlist.html','outboxlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				win.print();
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
	function outbox_export_excel(){
		var searchquery = "";
		var outbox_destination_2excel=null;
		var outbox_message_2excel=null;
		var outbox_date_2excel_date="";
		var win;              
		// check if we do have some search data...
		if(outbox_DataStore.baseParams.query!==null){searchquery = outbox_DataStore.baseParams.query;}
		if(outbox_DataStore.baseParams.outbox_destination!==null){outbox_destination_2excel = outbox_DataStore.baseParams.outbox_destination;}
		if(outbox_DataStore.baseParams.outbox_message!==null){outbox_message_2excel = outbox_DataStore.baseParams.outbox_message;}
		if(outbox_DataStore.baseParams.outbox_date!==""){outbox_date_2excel_date = outbox_DataStore.baseParams.outbox_date;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_outbox&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			outbox_destination : outbox_destination_2excel,
			outbox_message : outbox_message_2excel,
		  	outbox_date : outbox_date_2excel_date, 
		  	currentlisting: outbox_DataStore.baseParams.task // this tells us if we are searching or not
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
	

	
	/*
	function load_status_all(){
	outbox_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	outbox_status_sentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_sent =outbox_status_sentDataStore.getAt(0).data;
						outbox_status_sentField.setValue(auto_status_sent.status_sent);
				}
			}
	});
	
	outbox_status_unsentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_unsent =outbox_status_unsentDataStore.getAt(0).data;
						outbox_status_unsentField.setValue(auto_status_unsent.status_unsent);
				}
			}
	});
	
	outbox_status_failedDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_failed =outbox_status_failedDataStore.getAt(0).data;
						outbox_status_failedField.setValue(auto_status_failed.status_failed);
				}
			}
	});
	
	}*/
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_outbox"></div>
		<div id="elwindow_outbox_save"></div>
        <div id="elwindow_outbox_search"></div>
    </div>
</div>
</body>