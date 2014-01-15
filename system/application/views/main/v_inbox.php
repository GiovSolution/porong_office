<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: inbox View
	+ Description	: For record view
	+ Filename 		: v_inbox.php
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
var inbox_DataStore;
var inbox_ColumnModel;
var inboxListEditorGrid;
var inbox_saveForm;
var inbox_saveWindow;
var inbox_searchForm;
var inbox_searchWindow;
var inbox_replyWindow;
var inbox_SelectedRow;
var inbox_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var inbox_idField;
var inbox_senderField;
var inbox_messageField;
var inbox_dateField;
var inbox_idSearchField;
var inbox_senderSearchField;
var inbox_messageSearchField;
var inbox_dateSearchField;
var max_isi=320;
var dua_sms = 'no';

var taskinbox = {
	run: function(){
	   inbox_DataStore.load({params:{start:0,limit:pageS}});
	},
	interval: 50
}
var runinbox = new Ext.util.TaskRunner();


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
//   runinbox.start(taskinbox); //ditutup sementara, karena selalu refresh ke hal 1 misalnya kita sudah ke hal 2 dst. 2010-08-04
  
  /* Function for add and edit data form, open window form */
	function inbox_save(post2db){
	
		if(is_inbox_form_valid()){
			var inbox_pk="";
			var inbox_status="";
			var inbox_pengirim="";
			var inbox_isi="";
			var inbox_id_temp="";
			var balas=1;
			
			if(inbox_detailField.getValue()!=="") inbox_isi=inbox_detailField.getValue();
			if(inbox_idField.getValue()!=="") inbox_id_temp=inbox_idField.getValue();
			inbox_pengirim=inbox_pengirimField.getValue();
			
			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_inbox&m=inbox_save',
				timeout: 3600000,
				params: {
					inbox_pengirim	: inbox_pengirim,
					inbox_isi	: inbox_isi,
					inbox_status: inbox_status,
					inbox_id :inbox_id_temp,
					inbox_task	: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							if (post2db=='send') {
								Ext.MessageBox.alert(post2db+' OK','Send SMS sukses. Cek di Outbox untuk status pengiriman');
							}
							else {
								Ext.MessageBox.alert(post2db+' OK','New SMS berhasil disimpan di Draft SMS');
							}
							inbox_saveWindow.hide();
							inbox_DataStore.reload();
							//mainPanel.remove(mainPanel.getActiveTab().getId());
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'New SMS tidak bisa disimpan',
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
			
		} else {
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
  
	function inboxreply_set_form(){
		inbox_pengirimField.setValue(inboxListEditorGrid.getSelectionModel().getSelected().get('SenderNumber'));	
		inbox_idField.setValue(inboxListEditorGrid.getSelectionModel().getSelected().get('ID'));
		inbox_detailField.reset();
		inbox_count_isiField.reset();
	}  
	
	function is_inbox_form_valid(){
		return (inbox_detailField.isValid());
	}
  
  	/* Function for Delete Confirm */
	function inbox_confirm_delete(){
		// only one inbox is selected here
		if(inboxListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', inbox_delete);
		} else if(inboxListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', inbox_delete);
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
  	/* End of Function */
  
	/* Function for Update Confirm */
	function inbox_confirm_reply(){
		//Ext.getCmp('btn_saveclose').setVisible(false);
		/* only one record is selected here */
		if(inboxListEditorGrid.selModel.getCount() == 1) {
			inboxreply_set_form();
			display_form_save_window();
			
			//msg='updated';
			
			//customer_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
//				msg: 'Tidak ada data yang dipilih untuk diedit',
				msg: 'Anda belum memilih pesan yang akan dibalas',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
	
  	/* Function for Delete Record */
	function inbox_delete(btn){
		if(btn=='yes'){
			var selections = inboxListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< inboxListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.ID);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_inbox&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							inbox_DataStore.reload();
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
	inbox_DataStore = new Ext.data.Store({
		id: 'inbox_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_inbox&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'ID'
		},[
			{name: 'ID', type: 'int', mapping: 'ID'}, 
			{name: 'SenderNumber', type: 'string', mapping: 'SenderNumber'}, 
			{name: 'TextDecoded', type: 'string', mapping: 'TextDecoded'}, 
			{name: 'ReceivingDateTime', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'ReceivingDateTime'}, 
			{name: 'inbox_creator', type: 'string', mapping: 'inbox_creator'}, 
			{name: 'inbox_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'inbox_date_create'}, 
			{name: 'inbox_update', type: 'string', mapping: 'inbox_update'}, 
			{name: 'inbox_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'inbox_date_update'}, 
			{name: 'inbox_revised', type: 'int', mapping: 'inbox_revised'},
			{name: 'inbox_status', type: 'string', mapping: 'inbox_status'},
		]),
		sortInfo:{field: 'ID', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	inbox_ColumnModel = new Ext.grid.ColumnModel(
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
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'ReceivingDateTime',
			width: 20,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('m/d/Y H:i:s'),
			readOnly: true
		}, 
		{
			header: '<div align="center">Pengirim</div>',
			dataIndex: 'SenderNumber',
			width: 30,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Isi Pesan</div>',
			dataIndex: 'TextDecoded',
			width: 210,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Status</div>',
			dataIndex: 'inbox_status',
			width: 20,
			sortable: true,
			readOnly: true
		},
		{
			header: 'Creator',
			dataIndex: 'inbox_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'inbox_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'inbox_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'inbox_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'inbox_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	inbox_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	inboxListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'inboxListEditorGrid',
		el: 'fp_inbox',
		title: 'Inbox SMS',
		autoHeight: true,
		store: inbox_DataStore, // DataStore
		cm: inbox_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: inbox_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Reply',
			tooltip: 'Reply selected record',
			iconCls:'icon-notes',
			handler: inbox_confirm_reply 
		}, '-',
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_INBOX'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: inbox_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: inbox_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: inbox_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: inbox_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: inbox_print  
		}
		]
	});
	inboxListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	inbox_ContextMenu = new Ext.menu.Menu({
		id: 'inbox_ListEditorGridContextMenu',
		items: [
		{
			text: 'Reply',
			tooltip: 'Reply selected record',
			iconCls:'icon-notes',
			handler: inbox_confirm_reply 
		}, '-',
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_INBOX'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: inbox_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: inbox_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: inbox_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function oninbox_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		inbox_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		inbox_SelectedRow=rowIndex;
		inbox_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function inbox_editContextMenu(){
		//inboxListEditorGrid.startEditing(inbox_SelectedRow,1);
		inbox_confirm_update();
  	}
	/* End of Function */
  	
	inboxListEditorGrid.addListener('rowcontextmenu', oninbox_ListEditGridContextMenu);
	inbox_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
		
	/* Function for action list search */
	function inbox_list_search(){
		// render according to a SQL date format.
		var inbox_id_search=null;
		var inbox_sender_search=null;
		var inbox_message_search=null;
		var inbox_date_search_date="";

		if(inbox_idSearchField.getValue()!==null){inbox_id_search=inbox_idSearchField.getValue();}
		if(inbox_senderSearchField.getValue()!==null){inbox_sender_search=inbox_senderSearchField.getValue();}
		if(inbox_messageSearchField.getValue()!==null){inbox_message_search=inbox_messageSearchField.getValue();}
		if(inbox_dateSearchField.getValue()!==""){inbox_date_search_date=inbox_dateSearchField.getValue().format('Y-m-d');}
		// change the store parameters
		inbox_DataStore.baseParams = {
			task: 'SEARCH',
			inbox_id	:	inbox_id_search, 
			SenderNumber	:	inbox_sender_search, 
			TextDecoded	:	inbox_message_search, 
			inbox_date	:	inbox_date_search_date
		};
		// Cause the datastore to do another query : 
		inbox_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function inbox_reset_search(){
		// reset the store parameters
		inbox_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		// Cause the datastore to do another query : 
		inbox_DataStore.reload({params: {start: 0, limit: pageS}});
		inbox_searchWindow.close();
	};
	/* End of Fuction */
	
	function inbox_reset_form(){
		inbox_pengirimField.reset();
		inbox_detailField.reset();
		inbox_count_isiField.reset();
	}
	
	/* Field for search */
	/* Identify  inbox_id Search Field */
	inbox_idSearchField= new Ext.form.NumberField({
		id: 'inbox_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  inbox_sender Search Field */
	inbox_senderSearchField= new Ext.form.TextField({
		id: 'inbox_senderSearchField',
		fieldLabel: 'Sender',
		maxLength: 25,
		anchor: '95%'
	
	});
	/* Identify  inbox_message Search Field */
	inbox_messageSearchField= new Ext.form.TextField({
		id: 'inbox_messageSearchField',
		fieldLabel: 'Message',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  inbox_date Search Field */
	inbox_dateSearchField= new Ext.form.DateField({
		id: 'inbox_dateSearchField',
		fieldLabel: 'Date',
		format : 'Y-m-d'
	
	});
    
	/* Function for retrieve search Form Panel */
	inbox_searchForm = new Ext.FormPanel({
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
				items: [inbox_senderSearchField, inbox_messageSearchField, inbox_dateSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: inbox_list_search
			},{
				text: 'Close',
				handler: function(){
					inbox_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	
	inbox_idField = new Ext.form.NumberField({
	id: 'inbox_idField'
	});
	
	inbox_pengirimField= new Ext.form.TextArea({
		id: 'inbox_pengirimField',
		fieldLabel: 'Pengirim',
		bodyStyle:'padding:5px',
		width:150,
		//anchor: '95%',
		height:20,
		allowBlank: false,
		readOnly : true
	});
	
	inbox_detailField= new Ext.form.TextArea({
		id: 'inbox_detailField',
		fieldLabel: 'Isi Pesan',
		maxLength: 500,
		bodyStyle:'padding:5px',
		anchor: '95%',
		allowBlank: false,
		enableKeyEvents: true,
		maxLength: 320
	});
	
	inbox_count_isiField= new Ext.form.NumberField({
		width: 40
	});
	
	inbox_detailField.on('keyup', function(){
		var isi_length = inbox_detailField.getValue().length;
		var sisa_length = max_isi - isi_length;
		inbox_count_isiField.setValue(isi_length);
		if(dua_sms=='no' && isi_length==161){
			//* satu sms terlewati /
			Ext.Msg.alert('Content SMS', 'Pengiriman = 2 SMS.');
			dua_sms = 'yes';
		}else if(isi_length==321){
			//* dua sms terlewati /
			Ext.MessageBox.show({
				title: 'Warning',
				width: 200,
				msg: 'Maksimal pengiriman adalah 2 SMS.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			 });
		}else if(isi_length==160 && dua_sms=='yes'){
			dua_sms = 'no';
		}
	});
	

	/* Function for retrieve reply Form Panel */
	inbox_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
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
				items: [inbox_pengirimField, inbox_detailField, inbox_count_isiField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Send',
				handler: function(){ inbox_save('send'); }
			},{
				text: 'Save to Draft',
				handler: function(){ inbox_save('draft'); }
			}
			,{
				text: 'Cancel',
				handler: function(){
					//mainPanel.remove(mainPanel.getActiveTab().getId());
					inbox_reset_form();
					inbox_saveWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 

	/* Function for retrieve create Window Form */
	inbox_saveWindow= new Ext.Window({
		id: 'inbox_saveWindow',
		title: 'Reply SMS',
		closable:false,
		closeAction: 'close',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_inbox_save',
		items: inbox_saveForm
	});
	/* End Window */
	

	//inbox_saveWindow.show();
	//sms_count_isiField.setValue(max_isi);
	
	/* Function for retrieve search Window Form, used for andvaced search */
	inbox_searchWindow = new Ext.Window({
		title: 'Pencarian Inbox SMS',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_inbox_search',
		items: inbox_searchForm
	});
    /* End of Function */ 
	
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!inbox_searchWindow.isVisible()){
			inbox_searchWindow.show();
		} else {
			inbox_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for Displaying  Search Window Form */
	function display_form_save_window(){
		if(!inbox_saveWindow.isVisible()){
			inbox_saveWindow.show();
		} else {
			inbox_saveWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function inbox_print(){
		var searchquery = "";
		var inbox_sender_print=null;
		var inbox_message_print=null;
		var inbox_date_print_date="";
		var win;              
		// check if we do have some search data...
		if(inbox_DataStore.baseParams.query!==null){searchquery = inbox_DataStore.baseParams.query;}
		if(inbox_DataStore.baseParams.SenderNumber!==null){inbox_sender_print = inbox_DataStore.baseParams.SenderNumber;}
		if(inbox_DataStore.baseParams.TextDecoded!==null){inbox_message_print = inbox_DataStore.baseParams.TextDecoded;}
		if(inbox_DataStore.baseParams.inbox_date!==""){inbox_date_print_date = inbox_DataStore.baseParams.inbox_date;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_inbox&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			SenderNumber : inbox_sender_print,
			TextDecoded : inbox_message_print,
		  	inbox_date : inbox_date_print_date, 
		  	currentlisting: inbox_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/inbox_printlist.html','inboxlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function inbox_export_excel(){
		var searchquery = "";
		var inbox_sender_2excel=null;
		var inbox_message_2excel=null;
		var inbox_date_2excel_date="";
		var win;              
		// check if we do have some search data...
		if(inbox_DataStore.baseParams.query!==null){searchquery = inbox_DataStore.baseParams.query;}
		if(inbox_DataStore.baseParams.SenderNumber!==null){inbox_sender_2excel = inbox_DataStore.baseParams.SenderNumber;}
		if(inbox_DataStore.baseParams.TextDecoded!==null){inbox_message_2excel = inbox_DataStore.baseParams.TextDecoded;}
		if(inbox_DataStore.baseParams.inbox_date!==""){inbox_date_2excel_date = inbox_DataStore.baseParams.inbox_date;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_inbox&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			SenderNumber : inbox_sender_2excel,
			TextDecoded : inbox_message_2excel,
		  	inbox_date : inbox_date_2excel_date, 
		  	currentlisting: inbox_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	mainPanel.on('remove', function(){
//		runinbox.stop(taskinbox); //ditutup sementara, karena selalu refresh ke hal 1 misalnya kita sudah ke hal 2 dst. 2010-08-04
	});
	//mainPanel.remove(mainPanel.getActiveTab().getId());
	
	/*End of Function */
});



	

	</script>
<body>
<div>
	<div class="col">
        <div id="fp_inbox"></div>
		<div id="elwindow_inbox_save"></div>
        <div id="elwindow_inbox_search"></div>
    </div>
</div>
</body>