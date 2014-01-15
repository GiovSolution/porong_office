<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: bank View
	+ Description	: For record view
	+ Filename 		: v_bank.php
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
var golongan_DataStore;
var golongan_ColumnModel;
var golonganListEditorGrid;
var golongan_createForm;
var golongan_createWindow;
var golongan_searchForm;
var golongan_searchWindow;
var golongan_SelectedRow;
var golongan_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var golongan_idField;
var golongan_kodeField;
var golongan_namaField;
var golongan_groomingField;
var golongan_keteranganField;
var bank_aktifField;
var golongan_namaSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function golongan_update(oGrid_event){
	var golongan_id_update_pk="";
	var golongan_nama_update=null;
	var golongan_grooming_update=null;
	var golongan_keterangan_update=null;

	golongan_id_update_pk = oGrid_event.record.data.id_golongan;
	if(oGrid_event.record.data.nama_golongan!== null){golongan_nama_update = oGrid_event.record.data.nama_golongan;}
	if(oGrid_event.record.data.grooming_golongan!== null){golongan_grooming_update = oGrid_event.record.data.grooming_golongan;}
	if(oGrid_event.record.data.keterangan_golongan!== null){golongan_keterangan_update = oGrid_event.record.data.keterangan_golongan;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_golongan&m=get_action',
			params: {
				task: "UPDATE",
				id_golongan	: golongan_id_update_pk,					
				nama_golongan	:golongan_nama_update,		
				grooming_golongan	:golongan_grooming_update,		
				keterangan_golongan	:golongan_keterangan_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						golongan_DataStore.commitChanges();
						golongan_DataStore.reload();
						break;
					case 2:
						golongan_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not save the bank.',
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
  
  	/* Function for add data, open window create form */
	function golongan_create(){
		if(is_golongan_form_valid()){
		
		var golongan_id_create_pk=null;
		var golongan_nama_create=null;
		var golongan_grooming_create=null;
		var golongan_keterangan_create=null;

		golongan_id_create_pk=get_pk_id();
		if(golongan_namaField.getValue()!== null){golongan_nama_create = golongan_namaField.getValue();}
		if(golongan_groomingField.getValue()!== null){golongan_grooming_create = golongan_groomingField.getValue();}
		if(golongan_keteranganField.getValue()!== null){golongan_keterangan_create = golongan_keteranganField.getValue();}

		Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_golongan&m=get_action',
				params: {
					task: post2db,
					id_golongan	: golongan_id_create_pk,		
					nama_golongan	: golongan_nama_create,	
					grooming_golongan	: golongan_grooming_create,	
					keterangan_golongan	: golongan_keterangan_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The Golongan was '+msg+' successfully.');
							golongan_DataStore.reload();
							golongan_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the Golongan.',
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
			return golonganListEditorGrid.getSelectionModel().getSelected().get('id_golongan');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function golongan_reset_form(){
		golongan_kodeField.reset();
		golongan_kodeField.setValue(null);
		golongan_namaField.reset();
		golongan_namaField.setValue(null);
		golongan_groomingField.reset();
		golongan_groomingField.setValue(null);
		golongan_keteranganField.reset();
		golongan_keteranganField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function golongan_set_form(){
		golongan_kodeField.setValue(golonganListEditorGrid.getSelectionModel().getSelected().get('id_golongan'));
		golongan_namaField.setValue(golonganListEditorGrid.getSelectionModel().getSelected().get('nama_golongan'));
		golongan_groomingField.setValue(golonganListEditorGrid.getSelectionModel().getSelected().get('grooming_golongan'));
		golongan_keteranganField.setValue(golonganListEditorGrid.getSelectionModel().getSelected().get('keterangan_golongan'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_golongan_form_valid(){
		return (golongan_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!golongan_createWindow.isVisible()){
			golongan_reset_form();
			post2db='CREATE';
			msg='created';
			golongan_createWindow.show();
		} else {
			golongan_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function golongan_confirm_delete(){
		// only one bank is selected here
		if(golonganListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', golongan_delete);
		} else if(golonganListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', golongan_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function golongan_confirm_update(){
		/* only one record is selected here */
		if(golonganListEditorGrid.selModel.getCount() == 1) {
			golongan_set_form();
			post2db='UPDATE';
			msg='updated';
			golongan_createWindow.show();
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
	function golongan_delete(btn){
		if(btn=='yes'){
			var selections = golonganListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< golonganListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.id_golongan);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_golongan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							golongan_DataStore.reload();
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
  
	/* Function for Retrieve DataStore */
	golongan_DataStore = new Ext.data.Store({
		id: 'golongan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_golongan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intogolongan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'id_golongan', type: 'int', mapping: 'id_golongan'},
			{name: 'nama_golongan', type: 'string', mapping: 'nama_golongan'},
			{name: 'grooming_golongan', type: 'float', mapping: 'grooming_golongan'},
			{name: 'keterangan_golongan', type: 'string', mapping: 'keterangan_golongan'},
			{name: 'golongan_creator', type: 'string', mapping: 'golongan_creator'},
			{name: 'golongan_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'golongan_date_create'},
			{name: 'golongan_update', type: 'string', mapping: 'golongan_update'},
			{name: 'golongan_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'golongan_date_update'},
			{name: 'golongan_revised', type: 'int', mapping: 'golongan_revised'}
		]),
		sortInfo:{field: 'id_golongan', direction: "ASC"}
	});
	/* End of Function */
	

  	/* Function for Identify of Window Column Model */
	golongan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Golongan' + '</div>',
			dataIndex: 'nama_golongan',
			width: 100,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Grooming (Rp)' + '</div>',
			dataIndex: 'grooming_golongan',
			width: 100,
			sortable: true,
			renderer: function(val){
				return Ext.util.Format.number(val,'0,000.00');
			},
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 22,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Keterangan',
			dataIndex: 'keterangan_golongan',
			width: 150,
			hidden: true,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: true,
				maxLength: 500
			})
		},
		{
			header: 'Creator',
			dataIndex: 'golongan_creator',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Create on',
			dataIndex: 'golongan_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Last Update by',
			dataIndex: 'golongan_update',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Last Update on',
			dataIndex: 'golongan_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Revised',
			dataIndex: 'golongan_revised',
			width: 150,
			sortable: true,
			hidden:true
		}]
	);
	golongan_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	golonganListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'golonganListEditorGrid',
		el: 'fp_bank',
		title: 'Daftar Golongan',
		autoHeight: true,
		store: golongan_DataStore, // DataStore
		cm: golongan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 350,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: golongan_DataStore,
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
			handler: golongan_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled:true,
			handler: golongan_confirm_delete   // Confirm before deleting
		}, /*{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		},*/ '-', 
			new Ext.app.SearchField({
			store: golongan_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						golongan_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'-Nama Golongan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: golongan_reset_search,
			iconCls:'icon-refresh'
		}/*,'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: golongan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: golongan_print  
		}*/
		]
	});
	golonganListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	golongan_ContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: golongan_confirm_update 
		},
		/*{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: golongan_confirm_delete 
		},
		*/'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: golongan_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: golongan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ongolongan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		golongan_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		golongan_SelectedRow=rowIndex;
		golongan_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function golongan_editContextMenu(){
      golonganListEditorGrid.startEditing(golongan_SelectedRow,1);
  	}
	/* End of Function */
  	
	golonganListEditorGrid.addListener('rowcontextmenu', ongolongan_ListEditGridContextMenu);
	golongan_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	golonganListEditorGrid.on('afteredit', golongan_update); // inLine Editing Record
	
	//cbo_bank_akunDataStore.load();
	
	/* Identify  bank_kode Field */
	golongan_kodeField= new Ext.form.ComboBox({
		id: 'golongan_kodeField',
		fieldLabel: 'Kode Golongan',
		store: golongan_DataStore,
		mode: 'remote',
		editable:false,
		//displayField: 'bank_akun_display',
		//valueField: 'bank_akun_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	/* Identify  bank_atasnama Field */
	golongan_namaField= new Ext.form.TextField({
		id: 'golongan_namaField',
		fieldLabel: 'Golongan <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  bank_saldo Field */
	golongan_groomingField= new Ext.form.NumberField({
		id: 'golongan_groomingField',
		fieldLabel: 'Grooming',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: true,
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/,
		decimalSeparator : '.',
		decimalPrecision : 2,
		itemCls : 'rmoney'

			
	});
	/* Identify  bank_keterangan Field */
	golongan_keteranganField= new Ext.form.TextArea({
		id: 'golongan_keteranganField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});

	/* Function for retrieve create Window Panel*/ 
	golongan_createForm = new Ext.FormPanel({
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
				items: [golongan_namaField, golongan_groomingField, golongan_keteranganField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Save and Close',
				handler: golongan_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					golongan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	golongan_createWindow= new Ext.Window({
		id: 'golongan_createWindow',
		title: post2db+'Golongan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_golongan_create',
		items: golongan_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function golongan_list_search(){
		// render according to a SQL date format.
		var golongan_nama_search=null;

		if(golongan_namaSearchField.getValue()!==null){golongan_nama_search=golongan_namaSearchField.getValue();}
		// change the store parameters
		golongan_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			bank_atasnama	:	golongan_nama_search
		};
		// Cause the datastore to do another query : 
		golongan_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function golongan_reset_search(){
		// reset the store parameters
		golongan_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		golongan_DataStore.reload({params: {start: 0, limit: pageS}});
		//golongan_searchWindow.close();
	};
	/* End of Fuction */
	
	function golongan_reset_searchForm(){
		golongan_namaSearchField.reset();
		golongan_namaSearchField.setValue(null);
	}
	
	/* Field for search */
	
	/* Identify  bank_atasnama Search Field */
	golongan_namaSearchField= new Ext.form.TextField({
		id: 'golongan_namaSearchField',
		fieldLabel: 'Nama Golongan',
		maxLength: 250,
		anchor: '95%'
	
	});
	

	/* Function for retrieve search Form Panel */
	golongan_searchForm = new Ext.FormPanel({
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
				items: [golongan_namaSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: golongan_list_search
			},{
				text: 'Close',
				handler: function(){
					golongan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	golongan_searchWindow = new Ext.Window({
		title: 'Pencarian Golongan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_bank_search',
		items: golongan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!golongan_searchWindow.isVisible()){
			golongan_reset_searchForm();
			golongan_searchWindow.show();
		} else {
			golongan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function golongan_print(){
		var searchquery = "";
		var bank_kode_print=null;
		var bank_nama_print=null;
		var bank_norek_print=null;
		var bank_atasnama_print=null;
		var bank_saldo_print=null;
		var bank_keterangan_print=null;
		var bank_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(golongan_DataStore.baseParams.query!==null){searchquery = golongan_DataStore.baseParams.query;}
		if(golongan_DataStore.baseParams.bank_kode!==null){bank_kode_print = golongan_DataStore.baseParams.bank_kode;}
		if(golongan_DataStore.baseParams.bank_nama!==null){bank_nama_print = golongan_DataStore.baseParams.bank_nama;}
		if(golongan_DataStore.baseParams.bank_norek!==null){bank_norek_print = golongan_DataStore.baseParams.bank_norek;}
		if(golongan_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_print = golongan_DataStore.baseParams.bank_atasnama;}
		if(golongan_DataStore.baseParams.bank_saldo!==null){bank_saldo_print = golongan_DataStore.baseParams.bank_saldo;}
		if(golongan_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_print = golongan_DataStore.baseParams.bank_keterangan;}
		if(golongan_DataStore.baseParams.bank_aktif!==null){bank_aktif_print = golongan_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_golongan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			bank_kode : bank_kode_print,
			bank_nama : bank_nama_print,
			bank_norek : bank_norek_print,
			bank_atasnama : bank_atasnama_print,
			bank_saldo : bank_saldo_print,
			bank_keterangan : bank_keterangan_print,
			bank_aktif : bank_aktif_print,
		  	currentlisting: golongan_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./banklist.html','banklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function golongan_export_excel(){
		var searchquery = "";
		var bank_kode_2excel=null;
		var bank_nama_2excel=null;
		var bank_norek_2excel=null;
		var bank_atasnama_2excel=null;
		var bank_saldo_2excel=null;
		var bank_keterangan_2excel=null;
		var bank_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(golongan_DataStore.baseParams.query!==null){searchquery = golongan_DataStore.baseParams.query;}
		if(golongan_DataStore.baseParams.bank_kode!==null){bank_kode_2excel = golongan_DataStore.baseParams.bank_kode;}
		if(golongan_DataStore.baseParams.bank_nama!==null){bank_nama_2excel = golongan_DataStore.baseParams.bank_nama;}
		if(golongan_DataStore.baseParams.bank_norek!==null){bank_norek_2excel = golongan_DataStore.baseParams.bank_norek;}
		if(golongan_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_2excel = golongan_DataStore.baseParams.bank_atasnama;}
		if(golongan_DataStore.baseParams.bank_saldo!==null){bank_saldo_2excel = golongan_DataStore.baseParams.bank_saldo;}
		if(golongan_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_2excel = golongan_DataStore.baseParams.bank_keterangan;}
		if(golongan_DataStore.baseParams.bank_aktif!==null){bank_aktif_2excel = golongan_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_golongan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			bank_kode : bank_kode_2excel,
			bank_nama : bank_nama_2excel,
			bank_norek : bank_norek_2excel,
			bank_atasnama : bank_atasnama_2excel,
			bank_saldo : bank_saldo_2excel,
			bank_keterangan : bank_keterangan_2excel,
			bank_aktif : bank_aktif_2excel,
		  	currentlisting: golongan_DataStore.baseParams.task // this tells us if we are searching or not
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
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_bank"></div>
		<div id="elwindow_golongan_create"></div>
        <div id="elwindow_bank_search"></div>
    </div>
</div>
</body>