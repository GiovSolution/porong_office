<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: sent_item View
	+ Description	: For record view
	+ Filename 		: v_sent_item.php
 	+ creator  		: Natalie
 	+ Created on 20/Apr/2011 14:17
	
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
var sent_item_DataStore;
var sent_item_ColumnModel;
var sent_itemListEditorGrid;
var sent_item_saveForm;
var sent_item_saveWindow;
var sent_item_searchForm;
var sent_item_resendForm;
var sent_item_searchWindow;
var sent_item_SelectedRow;
var sent_item_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var sent_item_idField;
var sent_item_destinationField;
var sent_item_messageField;
var sent_item_dateField;
var sent_item_idSearchField;
var sent_item_destinationSearchField;
var sent_item_messageSearchField;
var sent_item_dateSearchField;
var sent_item_tglEndSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	/*function sent_item_inline_update(oGrid_event){
		var sent_item_id_update_pk="";
		var sent_item_destination_update=null;
		var sent_item_message_update=null;
		var sent_item_date_update_date="";

		sent_item_id_update_pk = oGrid_event.record.data.ID;
		if(oGrid_event.record.data.DestinationNumber!== null){sent_item_destination_update = oGrid_event.record.data.DestinationNumber;}
		if(oGrid_event.record.data.TextDecoded!== null){sent_item_message_update = oGrid_event.record.data.TextDecoded;}
	 	if(oGrid_event.record.data.SendingDateTime!== ""){sent_item_date_update_date =oGrid_event.record.data.SendingDateTime.format('Y-m-d H:i:s');}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_sent_item&m=get_action',
			params: {
				ID	: sent_item_id_update_pk, 
				DestinationNumber	:sent_item_destination_update,
				TextDecoded	:sent_item_message_update,
				SendingDateTime	: sent_item_date_update_date, 
				task: "UPDATE"
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						sent_item_DataStore.commitChanges();
						sent_item_DataStore.reload();
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
	}*/
  	/* End of Function */
  
  	/* Function for add and edit data form, open window form */
	function sent_item_save(){
	
		if(is_sent_item_form_valid()){	
			var sent_item_id_field_pk=null; 
			var sent_item_destination_field=null; 
			var sent_item_message_field=null; 
			var sent_item_date_field_date=""; 

			sent_item_id_field_pk=get_pk_id();
			if(sent_item_destinationField.getValue()!== null){sent_item_destination_field = sent_item_destinationField.getValue();} 
			if(sent_item_messageField.getValue()!== null){sent_item_message_field = sent_item_messageField.getValue();} 
			if(sent_item_dateField.getValue()!== ""){sent_item_date_field_date = sent_item_dateField.getValue().format('Y-m-d H:i:s');} 

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_sent_item&m=get_action',
				params: {
					ID	: sent_item_id_field_pk, 
					DestinationNumber	: sent_item_destination_field, 
					TextDecoded	: sent_item_message_field, 
					SendingDateTime	: sent_item_date_field_date, 
					task: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The Outbox was '+post2db+' successfully.');
							sent_item_DataStore.reload();
							sent_item_saveWindow.hide();
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
			return sent_itemListEditorGrid.getSelectionModel().getSelected().get('ID');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function sent_item_reset_form(){
		sent_item_destinationField.reset();
		sent_item_destinationField.setValue(null);
		sent_item_messageField.reset();
		sent_item_messageField.setValue(null);
		sent_item_dateField.reset();
		sent_item_dateField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function sent_item_set_form(){
		sent_item_destinationField.setValue(sent_itemListEditorGrid.getSelectionModel().getSelected().get('DestinationNumber'));
		sent_item_messageField.setValue(sent_itemListEditorGrid.getSelectionModel().getSelected().get('TextDecoded'));
		sent_item_dateField.setValue(sent_itemListEditorGrid.getSelectionModel().getSelected().get('SendingDateTime'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_sent_item_form_valid(){
		return (true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!sent_item_saveWindow.isVisible()){
			sent_item_reset_form();
			post2db='CREATE';
			msg='created';
			sent_item_saveWindow.show();
		} else {
			sent_item_saveWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function sent_item_confirm_delete(){
		// only one sent_item is selected here
		if(sent_itemListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', sent_item_delete);
		} else if(sent_itemListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', sent_item_delete);
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

	function sent_item_confirm_delete_all(){
		// only one sent_item is selected here
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus semua data?', sent_item_delete_all);
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function sent_item_confirm_update(){
		/* only one record is selected here */
		if(sent_itemListEditorGrid.selModel.getCount() == 1) {
			sent_item_set_form();
			post2db='UPDATE';
			msg='updated';
			sent_item_saveWindow.show();
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
	function sent_item_delete(btn){
		if(btn=='yes'){
			var selections = sent_itemListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< sent_itemListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.ID);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_sent_item&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							sent_item_DataStore.reload();
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

	function sent_item_delete_all(btn){
		if(btn=='yes'){
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_sent_item&m=get_action', 
				params: { task: "DELETE ALL" }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							sent_item_DataStore.reload();
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
	/*sent_item_status_unsentField=new Ext.form.TextField({
		id: 'sent_item_status_unsentField',
		name: 'sent_item_status_unsentField',
		fieldLabel: '<b>Unsent</b>',
		width: 60,
		readOnly: true
	});*/
	
	/* Identify status sent*/
/*	sent_item_status_sentField=new Ext.form.TextField({
		id: 'sent_item_status_sentField',
		//name: 'sent_item_status_sentField',
		fieldLabel: '<b>Sent</b>',
		width: 60,
		readOnly: true
	});*/
	
	/* Identify status failed*/
/*	sent_item_status_failedField=new Ext.form.TextField({
		id: 'sent_item_status_failedField',
		name: 'sent_item_status_failedField',
		fieldLabel: '<b>Failed</b>',
		width: 60,
		readOnly: true
	});*/
  

/* Function for Retrieve DataStore */
	sent_item_DataStore = new Ext.data.Store({
		id: 'sent_item_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_sent_item&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'ID'
		},[
		/* dataIndex => insert intosent_item_ColumnModel, Mapping => for initiate table column */ 
			{name: 'ID', type: 'int', mapping: 'ID'}, 
			{name: 'sent_item_cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'sent_item_cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'DestinationNumber', type: 'string', mapping: 'DestinationNumber'}, 
			{name: 'TextDecoded', type: 'string', mapping: 'TextDecoded'}, 
			{name: 'SendingDateTime', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'SendingDateTime'},
			{name: 'sent_item_status', type: 'string', mapping: 'sent_item_status'}, 
			{name: 'sent_item_creator', type: 'string', mapping: 'sent_item_creator'}, 
			{name: 'sent_item_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'sent_item_date_create'}, 
			{name: 'sent_item_update', type: 'string', mapping: 'sent_item_update'}, 
			{name: 'sent_item_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'sent_item_date_update'}, 
			{name: 'sent_item_revised', type: 'int', mapping: 'sent_item_revised'},
			{name: 'Status', type: 'string', mapping: 'Status'}
		]),
		sortInfo:{field: 'SendingDateTime', direction: "DESC"}
	});
	
	/* Function for Retrieve DataStore */
	sent_item_status_sentDataStore = new Ext.data.Store({
		id: 'sent_item_status_sentDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_sent_item&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "STATUS_SENT", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intosent_item_ColumnModel, Mapping => for initiate table column */ 
			//{name: 'ID', type: 'int', mapping: 'ID'}, 
			{name: 'status_sent', type: 'int', mapping: 'status_sent'}
		])
	});
	
	
	/* Function for Retrieve DataStore */
	sent_item_status_unsentDataStore = new Ext.data.Store({
		id: 'sent_item_status_unsentDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_sent_item&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "STATUS_UNSENT", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intosent_item_ColumnModel, Mapping => for initiate table column */ 
			{name: 'status_unsent', type: 'int', mapping: 'status_unsent'}
		])
	});
	
	
	/* Function for Retrieve DataStore */
	sent_item_status_failedDataStore = new Ext.data.Store({
		id: 'sent_item_status_failedDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_sent_item&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "STATUS_FAILED", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intosent_item_ColumnModel, Mapping => for initiate table column */ 
			{name: 'status_failed', type: 'int', mapping: 'status_failed'}
		])
	});
	
  	/* Function for Identify of Window Column Model */
	sent_item_ColumnModel = new Ext.grid.ColumnModel(
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
			dataIndex: 'SendingDateTime',
			width: 55,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y H:i'),
			readOnly: true
		},
		{
			header: '<div align="center">Isi Pesan</div>',
			dataIndex: 'TextDecoded',
			width: 300,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Client Card</div>',
			dataIndex: 'sent_item_cust_no',
			width: 40,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Nama Customer</div>',
			dataIndex: 'sent_item_cust_nama',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No HP</div>',
			dataIndex: 'DestinationNumber',
			width: 50,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Status',
			dataIndex: 'Status',
			width: 60,
			sortable: true,
			//hidden: true,
			readOnly: true
		} /*,
		{
			header: 'Create on',
			dataIndex: 'sent_item_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'sent_item_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'sent_item_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'sent_item_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	*/]);
	
	sent_item_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	sent_itemListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'sent_itemListEditorGrid',
		el: 'fp_sent_item',
		title: 'Sent Item',
		autoHeight: true,
		store: sent_item_DataStore, // DataStore
		cm: sent_item_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: sent_item_DataStore,
			//handler : load_status_all(),
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: sent_item_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Delete All',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: sent_item_confirm_delete_all   // Confirm before deleting
		}, '-', {
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: sent_item_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: sent_item_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: sent_item_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: sent_item_print  
		}, '-',{
			text: 'Resend',
			tooltip: 'Resend SMS',
			//iconCls:'icon-print',
			handler: sent_item_resend  
		}/*,
		'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
		{
			'text':'Unsent : '
		},
		sent_item_status_unsentField,
		{
			'text':'Sent : '
		},
		sent_item_status_sentField,
		{
			'text':'Failed : '
		},
		sent_item_status_failedField	*/	
		]
	});
	sent_itemListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	sent_item_ContextMenu = new Ext.menu.Menu({
		id: 'sent_item_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: sent_item_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: sent_item_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: sent_item_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onsent_item_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		sent_item_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		sent_item_SelectedRow=rowIndex;
		sent_item_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function sent_item_editContextMenu(){
		//sent_itemListEditorGrid.startEditing(sent_item_SelectedRow,1);
		sent_item_confirm_update();
  	}
	/* End of Function */
  	
	sent_itemListEditorGrid.addListener('rowcontextmenu', onsent_item_ListEditGridContextMenu);
	sent_item_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	//load_status_all();
	/*sent_item_status_sentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_sent =sent_item_status_sentDataStore.getAt(0).data;
						sent_item_status_sentField.setValue(auto_status_sent.status_sent);
				}
			}
	});
	
	sent_item_status_unsentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_unsent =sent_item_status_unsentDataStore.getAt(0).data;
						sent_item_status_unsentField.setValue(auto_status_unsent.status_unsent);
				}
			}
	});
	
	sent_item_status_failedDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_failed =sent_item_status_failedDataStore.getAt(0).data;
						sent_item_status_failedField.setValue(auto_status_failed.status_failed);
				}
			}
	});*/
					
	//sent_itemListEditorGrid.on('afteredit', sent_item_inline_update); // inLine Editing Record
	
	/* Identify  sent_item_destination Field */
	sent_item_destinationField= new Ext.form.TextField({
		id: 'sent_item_destinationField',
		fieldLabel: 'No HP',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  sent_item_message Field */
	sent_item_messageField= new Ext.form.TextArea({
		id: 'sent_item_messageField',
		fieldLabel: 'Isi Pesan',
		height: 60,
		grow: false,
		anchor: '95%'
	});
	/* Identify  sent_item_date Field */
	sent_item_dateField= new Ext.form.DateField({
		id: 'sent_item_dateField',
		fieldLabel: 'Tanggal Kirim',
		format : 'Y-m-d H:i:s'
	});
	
	

	/* Function for retrieve create Window Panel*/ 
	sent_item_saveForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [sent_item_destinationField, sent_item_messageField, sent_item_dateField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: sent_item_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					sent_item_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	sent_item_saveWindow= new Ext.Window({
		id: 'sent_item_saveWindow',
		title: post2db+'Sent Item',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_sent_item_save',
		items: sent_item_saveForm
	});
	/* End Window */
	
	/* Function for action list search */
	function sent_item_list_search(){
		// render according to a SQL date format.
		var sent_item_id_search=null;
		var sent_item_destination_search=null;
		var sent_item_message_search=null;
		var sent_item_date_search_date="";
		var sent_item_date_end_search_date="";
		var sent_item_status_search=null;
		var sent_item_time_end_search=null;
		var sent_item_time_search=null;

		if(sent_item_idSearchField.getValue()!==null){sent_item_id_search=sent_item_idSearchField.getValue();}
		if(sent_item_destinationSearchField.getValue()!==null){sent_item_destination_search=sent_item_destinationSearchField.getValue();}
		if(sent_item_messageSearchField.getValue()!==null){sent_item_message_search=sent_item_messageSearchField.getValue();}
		if(sent_item_dateSearchField.getValue()!==""){sent_item_date_search_date=sent_item_dateSearchField.getValue().format('Y-m-d');}
		if(sent_item_tglEndSearchField.getValue()!==""){sent_item_date_end_search_date=sent_item_tglEndSearchField.getValue().format('Y-m-d');}
		if(sent_item_statusSearchField.getValue()!==null){sent_item_status_search=sent_item_statusSearchField.getValue();}
		if(sent_item_jam_awal.getValue()!==null){sent_item_time_search=sent_item_jam_awal.getValue();}
		if(sent_item_jam_akhir.getValue()!==null){sent_item_time_end_search=sent_item_jam_akhir.getValue();}
		
		// change the store parameters
		sent_item_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			ID	:	sent_item_id_search, 
			DestinationNumber	:	sent_item_destination_search, 
			TextDecoded	:	sent_item_message_search, 
			SendingDateTime	:	sent_item_date_search_date,
			SendingDateTimeEnd : sent_item_date_end_search_date,
			SendingTime	:	sent_item_time_search,
			SendingTimeEnd : sent_item_time_end_search,
			Status : sent_item_status_search
		};
		// Cause the datastore to do another query : 
		sent_item_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function sent_item_reset_search(){
		// reset the store parameters
		sent_item_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		sent_item_DataStore.reload({params: {start: 0, limit: pageS}});
		//sent_item_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  sent_item_id Search Field */
	sent_item_idSearchField= new Ext.form.NumberField({
		id: 'sent_item_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  sent_item_destination Search Field */
	sent_item_destinationSearchField= new Ext.form.TextField({
		id: 'sent_item_destinationSearchField',
		fieldLabel: 'No HP',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  sent_item_message Search Field */
	sent_item_messageSearchField= new Ext.form.TextField({
		id: 'sent_item_messageSearchField',
		fieldLabel: 'Isi Pesan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  sent_item_date Search Field */
	sent_item_dateSearchField= new Ext.form.DateField({
		id: 'sent_item_dateSearchField',
		format : 'd-m-Y',
	});
	/* Identify  sent_item_date end Search Field */
	sent_item_tglEndSearchField= new Ext.form.DateField({
		id: 'sent_item_tglEndSearchField',
		format: 'd-m-Y'
	});
	
	resend_labelField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	sent_item_jam_awal=new Ext.form.TimeField({
		format: 'H:i',
		minValue: '7:00',
		maxValue: '21:00',
		//emptyText: 'Jam Awal',
		increment: 30,
		width: 75
	});
	
	sent_item_jam_akhir=new Ext.form.TimeField({
		format: 'H:i',
		minValue: '7:00',
		maxValue: '21:00',
		//emptyText: 'Jam Akhir',
		increment: 30,
		width: 75
	});
	
	resend2_labelField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	tgl_labelField=new Ext.form.Label({html: 'Tanggal : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	jam_labelField=new Ext.form.Label({html: 'Jam : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});	
	
	sent_item_opsiField=new Ext.form.FieldSet({
		id:'sent_item_opsiField',
		title: 'Pengiriman SMS',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		//border : false,
		//frame: false,
		items: [{
			layout:'form',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [tgl_labelField, sent_item_dateSearchField, resend_labelField, sent_item_tglEndSearchField] 
			},
			{xtype: 'spacer',height:5},
			{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [jam_labelField, sent_item_jam_awal, resend2_labelField, sent_item_jam_akhir] 
			}
			]
		}]
		//items:[sent_item_dateSearchField, resend_labelField, sent_item_tglEndSearchField]
	});
	
	/* Identify  status sms Field */
	sent_item_statusSearchField= new Ext.form.ComboBox({
		id: 'sent_item_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['status_value', 'status_display'],
			data:[['SendingOKNoReport','SendingOKNoReport'],['SendingError','SendingError'],['SendingOK','SendingOK']]
		}),
		mode: 'local',
		displayField: 'status_display',
		valueField: 'status_value',
		anchor: '70%',
		triggerAction: 'all'	
	});
    
	/* Function for retrieve search Form Panel */
	sent_item_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 370,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [sent_item_destinationSearchField, sent_item_messageSearchField, sent_item_opsiField, sent_item_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: sent_item_list_search
			},{
				text: 'Close',
				handler: function(){
					sent_item_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	
	/* Function for retrieve search Window Form, used for andvaced search */
	sent_item_searchWindow = new Ext.Window({
		title: 'Sent Item Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_sent_item_search',
		items: sent_item_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!sent_item_searchWindow.isVisible()){
			sent_item_searchWindow.show();
		} else {
			sent_item_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function sent_item_print(){
		var searchquery = "";
		var sent_item_destination_print=null;
		var sent_item_message_print=null;
		var sent_item_date_print_date="";
		var win;              
		// check if we do have some search data...
		if(sent_item_DataStore.baseParams.query!==null){searchquery = sent_item_DataStore.baseParams.query;}
		if(sent_item_DataStore.baseParams.DestinationNumber!==null){sent_item_destination_print = sent_item_DataStore.baseParams.DestinationNumber;}
		if(sent_item_DataStore.baseParams.TextDecoded!==null){sent_item_message_print = sent_item_DataStore.baseParams.TextDecoded;}
		if(sent_item_DataStore.baseParams.SendingDateTime!==""){sent_item_date_print_date = sent_item_DataStore.baseParams.SendingDateTime;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_sent_item&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			DestinationNumber : sent_item_destination_print,
			TextDecoded : sent_item_message_print,
		  	SendingDateTime : sent_item_date_print_date, 
		  	currentlisting: sent_item_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/sent_item_printlist.html','sent_itemlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	
	/* Function for print List Grid */
	function sent_item_resend(){
	Ext.MessageBox.show({
		msg: 'Sedang memproses data untuk dicetak.. Mohon tunggu.. ',
		progressText: 'proses...',
		width:350,
		wait:true
	});
		var searchquery = "";
		var sent_item_destination_print=null;
		var sent_item_message_print=null;
		var sent_item_date_print_date="";
		var sent_item_date_end_print_date="";
		var sent_item_status_print=null;
		var sent_item_time_end_print=null;
		var sent_item_time_print=null;
		var win;              
		// check if we do have some search data...
		if(sent_item_DataStore.baseParams.query!==null){searchquery = sent_item_DataStore.baseParams.query;}
		if(sent_item_DataStore.baseParams.DestinationNumber!==null){sent_item_destination_print = sent_item_DataStore.baseParams.DestinationNumber;}
		if(sent_item_DataStore.baseParams.TextDecoded!==null){sent_item_message_print = sent_item_DataStore.baseParams.TextDecoded;}
		if(sent_item_DataStore.baseParams.SendingDateTime!==""){sent_item_date_print_date = sent_item_DataStore.baseParams.SendingDateTime;}
		if(sent_item_tglEndSearchField.getValue()!==""){sent_item_date_end_print_date=sent_item_tglEndSearchField.getValue().format('Y-m-d');}
		if(sent_item_statusSearchField.getValue()!==null){sent_item_status_print=sent_item_statusSearchField.getValue();}
		if(sent_item_jam_awal.getValue()!==null){sent_item_time_print=sent_item_jam_awal.getValue();}
		if(sent_item_jam_akhir.getValue()!==null){sent_item_time_end_print=sent_item_jam_akhir.getValue();}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_sent_item&m=get_action',
		params: {
			task: "RESEND",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			DestinationNumber : sent_item_destination_print,
			TextDecoded : sent_item_message_print,
		  	SendingDateTime : sent_item_date_print_date,
			SendingDateTimeEnd : sent_item_date_end_print_date,
			SendingTime	:	sent_item_time_print,
			SendingTimeEnd : sent_item_time_end_print,
			Status : sent_item_status_print,
		  	currentlisting: sent_item_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
				case 1:
					Ext.MessageBox.alert('RESEND SMS'+' OK','SMS telah dikirim ulang dan dipindahkan ke Outbox.');
					sent_item_DataStore.baseParams = { task: 'LIST' };
					sent_item_DataStore.reload({params: {start: 0, limit: pageS}});
					break;
				case 2:
					Ext.MessageBox.alert('WARNING'+' OK','Pengiriman ulang SMS tidak boleh melebihi batas maksimum 1000 SMS, lakukan penyaringan data kembali melalui Adv Search.');
					break;
				case 3:
					Ext.MessageBox.alert('WARNING'+' OK','Ada SMS dengan status selain "SendingError", jika ingin mengirimkan ulang SMS dengan status selain "SendingError", dapat melalui New SMS / Draft.');
					break;
				default:
					Ext.MessageBox.show({
					   title: 'Warning',
					   msg: 'Resend SMS tidak dapat dilakukan',
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
	function sent_item_export_excel(){
		var searchquery = "";
		var sent_item_destination_2excel=null;
		var sent_item_message_2excel=null;
		var sent_item_date_2excel_date="";
		var win;              
		// check if we do have some search data...
		if(sent_item_DataStore.baseParams.query!==null){searchquery = sent_item_DataStore.baseParams.query;}
		if(sent_item_DataStore.baseParams.DestinationNumber!==null){sent_item_destination_2excel = sent_item_DataStore.baseParams.DestinationNumber;}
		if(sent_item_DataStore.baseParams.TextDecoded!==null){sent_item_message_2excel = sent_item_DataStore.baseParams.TextDecoded;}
		if(sent_item_DataStore.baseParams.SendingDateTime!==""){sent_item_date_2excel_date = sent_item_DataStore.baseParams.SendingDateTime;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_sent_item&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			DestinationNumber : sent_item_destination_2excel,
			TextDecoded : sent_item_message_2excel,
		  	SendingDateTime : sent_item_date_2excel_date, 
		  	currentlisting: sent_item_DataStore.baseParams.task // this tells us if we are searching or not
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
	sent_item_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	sent_item_status_sentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_sent =sent_item_status_sentDataStore.getAt(0).data;
						sent_item_status_sentField.setValue(auto_status_sent.status_sent);
				}
			}
	});
	
	sent_item_status_unsentDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_unsent =sent_item_status_unsentDataStore.getAt(0).data;
						sent_item_status_unsentField.setValue(auto_status_unsent.status_unsent);
				}
			}
	});
	
	sent_item_status_failedDataStore.load({
		params : {start: 0, limit: pageS},
			callback: function(opts, success, response){
				if (success) {
						auto_status_failed =sent_item_status_failedDataStore.getAt(0).data;
						sent_item_status_failedField.setValue(auto_status_failed.status_failed);
				}
			}
	});
	
	}*/
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_sent_item"></div>
		<div id="elwindow_sent_item_save"></div>
        <div id="elwindow_sent_item_search"></div>
		<div id="elwindow_sent_item_resend"></div>
    </div>
</div>
</body>