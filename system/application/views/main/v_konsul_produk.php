<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: konsul_produk View
	+ Description	: For record view
	+ Filename 		: v_konsul_produk.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 14/Jul/2009 15:33:36
	
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
var konsul_produk_DataStore;
var konsul_produk_ColumnModel;
var konsul_produkListEditorGrid;
var konsul_produk_createForm;
var konsul_produk_createWindow;
var konsul_produk_searchForm;
var konsul_produk_searchWindow;
var konsul_produk_SelectedRow;
var konsul_produk_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var kpakai_konsulField;
var kpakai_produkField;
var kpakai_jumlahField;
var kpakai_konsulSearchField;
var kpakai_produkSearchField;
var kpakai_jumlahSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function konsul_produk_update(oGrid_event){
	var kpakai_konsul_update_pk="";
	var kpakai_produk_update_pk="";
	var kpakai_jumlah_update=null;

	kpakai_konsul_update_pk = get_pk_id();
	kpakai_produk_update_pk = get_pk_id();
	if(oGrid_event.record.data.kpakai_jumlah!== null){kpakai_jumlah_update = oGrid_event.record.data.kpakai_jumlah;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_konsul_produk&m=get_action',
			params: {
				task: "UPDATE",
				kpakai_konsul	: get_pk_id(),				kpakai_produk	: get_pk_id(),				kpakai_jumlah	:kpakai_jumlah_update		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						konsul_produk_DataStore.commitChanges();
						konsul_produk_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not save the konsul_produk.',
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
	function konsul_produk_create(){
		if(is_konsul_produk_form_valid()){
		
		var kpakai_konsul_create=null;
		var kpakai_produk_create=null;
		var kpakai_jumlah_create=null;

		if(kpakai_konsulField.getValue()!== null){kpakai_konsul_create = kpakai_konsulField.getValue();}
		if(kpakai_produkField.getValue()!== null){kpakai_produk_create = kpakai_produkField.getValue();}
		if(kpakai_jumlahField.getValue()!== null){kpakai_jumlah_create = kpakai_jumlahField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_konsul_produk&m=get_action',
				params: {
					task: post2db,
					kpakai_konsul	: kpakai_konsul_create_pk,	
					kpakai_produk	: kpakai_produk_create_pk,	
					kpakai_jumlah	: kpakai_jumlah_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The Konsul_produk was '+msg+' successfully.');
							konsul_produk_DataStore.reload();
							konsul_produk_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the Konsul_produk.',
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
				msg: 'Isian belum sempurna!.',
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
			return konsul_produkListEditorGrid.getSelectionModel().getSelected().get('kpakai_konsul,kpakai_produk');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function konsul_produk_reset_form(){
		kpakai_jumlahField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function konsul_produk_set_form(){
		kpakai_konsulField.setValue(konsul_produkListEditorGrid.getSelectionModel().getSelected().get('kpakai_konsul'));
		kpakai_produkField.setValue(konsul_produkListEditorGrid.getSelectionModel().getSelected().get('kpakai_produk'));
		kpakai_jumlahField.setValue(konsul_produkListEditorGrid.getSelectionModel().getSelected().get('kpakai_jumlah'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_konsul_produk_form_valid(){
		return (kpakai_konsulField.isValid() && kpakai_produkField.isValid() && true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!konsul_produk_createWindow.isVisible()){
			konsul_produk_reset_form();
			post2db='CREATE';
			msg='created';
			konsul_produk_createWindow.show();
		} else {
			konsul_produk_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function konsul_produk_confirm_delete(){
		// only one konsul_produk is selected here
		if(konsul_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', konsul_produk_delete);
		} else if(konsul_produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', konsul_produk_delete);
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
	function konsul_produk_confirm_update(){
		/* only one record is selected here */
		if(konsul_produkListEditorGrid.selModel.getCount() == 1) {
			konsul_produk_set_form();
			post2db='UPDATE';
			msg='updated';
			konsul_produk_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function konsul_produk_delete(btn){
		if(btn=='yes'){
			var selections = konsul_produkListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< konsul_produkListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kpakai_konsul,kpakai_produk);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_konsul_produk&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							konsul_produk_DataStore.reload();
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
	konsul_produk_DataStore = new Ext.data.Store({
		id: 'konsul_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_konsul_produk&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kpakai_konsul,kpakai_produk'
		},[
		/* dataIndex => insert intokonsul_produk_ColumnModel, Mapping => for initiate table column */ 
			{name: 'kpakai_konsul', type: 'int', mapping: 'kpakai_konsul'},
			{name: 'kpakai_produk', type: 'int', mapping: 'kpakai_produk'},
			{name: 'kpakai_jumlah', type: 'int', mapping: 'kpakai_jumlah'}
		]),
		sortInfo:{field: 'kpakai_konsul,kpakai_produk', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	konsul_produk_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'kpakai_konsul,kpakai_produk',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},
		{
			header: 'Kpakai Jumlah',
			dataIndex: 'kpakai_jumlah',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		}]
	);
	konsul_produk_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	konsul_produkListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'konsul_produkListEditorGrid',
		el: 'fp_konsul_produk',
		title: 'List Of Konsul_produk',
		autoHeight: true,
		store: konsul_produk_DataStore, // DataStore
		cm: konsul_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: konsul_produk_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: konsul_produk_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: konsul_produk_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: konsul_produk_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: konsul_produk_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: konsul_produk_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: konsul_produk_print  
		}
		]
	});
	konsul_produkListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	konsul_produk_ContextMenu = new Ext.menu.Menu({
		id: 'konsul_produk_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: konsul_produk_confirm_update 
		},
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: konsul_produk_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: konsul_produk_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: konsul_produk_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onkonsul_produk_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		konsul_produk_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		konsul_produk_SelectedRow=rowIndex;
		konsul_produk_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function konsul_produk_editContextMenu(){
      konsul_produkListEditorGrid.startEditing(konsul_produk_SelectedRow,1);
  	}
	/* End of Function */
  	
	konsul_produkListEditorGrid.addListener('rowcontextmenu', onkonsul_produk_ListEditGridContextMenu);
	konsul_produk_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	konsul_produkListEditorGrid.on('afteredit', konsul_produk_update); // inLine Editing Record
	
	/* Identify  kpakai_konsul Field */
	kpakai_konsulField= new Ext.form.NumberField({
		id: 'kpakai_konsulField',
		fieldLabel: 'Kpakai Konsul',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  kpakai_produk Field */
	kpakai_produkField= new Ext.form.NumberField({
		id: 'kpakai_produkField',
		fieldLabel: 'Kpakai Produk',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  kpakai_jumlah Field */
	kpakai_jumlahField= new Ext.form.NumberField({
		id: 'kpakai_jumlahField',
		fieldLabel: 'Kpakai Jumlah',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
  	
	/* Function for retrieve create Window Panel*/ 
	konsul_produk_createForm = new Ext.FormPanel({
		labelAlign: 'top',
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
				items: [kpakai_konsulFieldkpakai_produkField, kpakai_jumlahField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Save and Close',
				handler: konsul_produk_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					konsul_produk_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	konsul_produk_createWindow= new Ext.Window({
		id: 'konsul_produk_createWindow',
		title: post2db+'Konsul_produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_konsul_produk_create',
		items: konsul_produk_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function konsul_produk_list_search(){
		// render according to a SQL date format.
		var kpakai_konsul_search=null;
		var kpakai_produk_search=null;
		var kpakai_jumlah_search=null;

		if(kpakai_konsulSearchField.getValue()!==null){kpakai_konsul_search=kpakai_konsulSearchField.getValue();}
		if(kpakai_produkSearchField.getValue()!==null){kpakai_produk_search=kpakai_produkSearchField.getValue();}
		if(kpakai_jumlahSearchField.getValue()!==null){kpakai_jumlah_search=kpakai_jumlahSearchField.getValue();}
		// change the store parameters
		konsul_produk_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			kpakai_konsul	:	kpakai_konsul_search, 
			kpakai_produk	:	kpakai_produk_search, 
			kpakai_jumlah	:	kpakai_jumlah_search 
};
		// Cause the datastore to do another query : 
		konsul_produk_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function konsul_produk_reset_search(){
		// reset the store parameters
		konsul_produk_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		konsul_produk_DataStore.reload({params: {start: 0, limit: pageS}});
		konsul_produk_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  kpakai_konsul Search Field */
	kpakai_konsulSearchField= new Ext.form.NumberField({
		id: 'kpakai_konsulSearchField',
		fieldLabel: 'Kpakai Konsul',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  kpakai_produk Search Field */
	kpakai_produkSearchField= new Ext.form.NumberField({
		id: 'kpakai_produkSearchField',
		fieldLabel: 'Kpakai Produk',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  kpakai_jumlah Search Field */
	kpakai_jumlahSearchField= new Ext.form.NumberField({
		id: 'kpakai_jumlahSearchField',
		fieldLabel: 'Kpakai Jumlah',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
    
	/* Function for retrieve search Form Panel */
	konsul_produk_searchForm = new Ext.FormPanel({
		labelAlign: 'top',
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
				items: [kpakai_konsulSearchFieldkpakai_produkSearchField, kpakai_jumlahSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: konsul_produk_list_search
			},{
				text: 'Close',
				handler: function(){
					konsul_produk_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	konsul_produk_searchWindow = new Ext.Window({
		title: 'konsul_produk Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_konsul_produk_search',
		items: konsul_produk_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!konsul_produk_searchWindow.isVisible()){
			konsul_produk_searchWindow.show();
		} else {
			konsul_produk_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function konsul_produk_print(){
		var searchquery = "";
		var kpakai_konsul_print=null;
		var kpakai_produk_print=null;
		var kpakai_jumlah_print=null;
		var win;              
		// check if we do have some search data...
		if(konsul_produk_DataStore.baseParams.query!==null){searchquery = konsul_produk_DataStore.baseParams.query;}
		if(konsul_produk_DataStore.baseParams.kpakai_konsul!==null){kpakai_konsul_print = konsul_produk_DataStore.baseParams.kpakai_konsul;}
		if(konsul_produk_DataStore.baseParams.kpakai_produk!==null){kpakai_produk_print = konsul_produk_DataStore.baseParams.kpakai_produk;}
		if(konsul_produk_DataStore.baseParams.kpakai_jumlah!==null){kpakai_jumlah_print = konsul_produk_DataStore.baseParams.kpakai_jumlah;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_konsul_produk&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kpakai_konsul : kpakai_konsul_print,
			kpakai_produk : kpakai_produk_print,
			kpakai_jumlah : kpakai_jumlah_print,
		  	currentlisting: konsul_produk_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./konsul_produklist.html','konsul_produklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function konsul_produk_export_excel(){
		var searchquery = "";
		var kpakai_konsul_2excel=null;
		var kpakai_produk_2excel=null;
		var kpakai_jumlah_2excel=null;
		var win;              
		// check if we do have some search data...
		if(konsul_produk_DataStore.baseParams.query!==null){searchquery = konsul_produk_DataStore.baseParams.query;}
		if(konsul_produk_DataStore.baseParams.kpakai_konsul!==null){kpakai_konsul_2excel = konsul_produk_DataStore.baseParams.kpakai_konsul;}
		if(konsul_produk_DataStore.baseParams.kpakai_produk!==null){kpakai_produk_2excel = konsul_produk_DataStore.baseParams.kpakai_produk;}
		if(konsul_produk_DataStore.baseParams.kpakai_jumlah!==null){kpakai_jumlah_2excel = konsul_produk_DataStore.baseParams.kpakai_jumlah;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_konsul_produk&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kpakai_konsul : kpakai_konsul_2excel,
			kpakai_produk : kpakai_produk_2excel,
			kpakai_jumlah : kpakai_jumlah_2excel,
		  	currentlisting: konsul_produk_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_konsul_produk"></div>
		<div id="elwindow_konsul_produk_create"></div>
        <div id="elwindow_konsul_produk_search"></div>
    </div>
</div>
</body>