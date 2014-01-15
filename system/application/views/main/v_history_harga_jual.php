<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: history_harga_jual View
	+ Description	: For record view
	+ Filename 		: v_history_harga_jual.php
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
var history_harga_jual_DataStore;
var history_harga_jual_ColumnModel;
var history_harga_jualListEditorGrid;
var history_harga_jual_createForm;
var history_harga_jual_createWindow;
var history_harga_jual_searchForm;
var history_harga_jual_searchWindow;
var history_harga_jual_SelectedRow;
var history_harga_jual_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var hjual_noField;
var hjual_tanggalField;
var hjual_hargaField;
var hjual_jenisField;
var hjual_updateField;
var hjual_date_updateField;
var hjual_revisedField;
var hjual_noSearchField;
var hjual_tanggalSearchField;
var hjual_hargaSearchField;
var hjual_jenisSearchField;
var hjual_updateSearchField;
var hjual_date_updateSearchField;
var hjual_revisedSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function history_harga_jual_update(oGrid_event){
	var hjual_no_update_pk="";
	var hjual_tanggal_update_pk="";
	var hjual_harga_update=null;
	var hjual_jenis_update=null;
	var hjual_update_update=null;
	var hjual_date_update_update_date="";
	var hjual_revised_update=null;

	hjual_no_update_pk = get_pk_id();
	hjual_tanggal_update_pk = get_pk_id();
	if(oGrid_event.record.data.hjual_harga!== null){hjual_harga_update = oGrid_event.record.data.hjual_harga;}
	if(oGrid_event.record.data.hjual_jenis!== null){hjual_jenis_update = oGrid_event.record.data.hjual_jenis;}
	if(oGrid_event.record.data.hjual_update!== null){hjual_update_update = oGrid_event.record.data.hjual_update;}
	 if(oGrid_event.record.data.hjual_date_update!== ""){hjual_date_update_update_date = oGrid_event.record.data.hjual_date_update.format('Y-m-d');}
	if(oGrid_event.record.data.hjual_revised!== null){hjual_revised_update = oGrid_event.record.data.hjual_revised;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_history_harga_jual&m=get_action',
			params: {
				task: "UPDATE",
				hjual_no	: get_pk_id(),				hjual_tanggal	: get_pk_id(),				hjual_harga	:hjual_harga_update,		
				hjual_jenis	:hjual_jenis_update,		
				hjual_update	:hjual_update_update,		
				hjual_date_update	: hjual_date_update_update_date,				hjual_revised	:hjual_revised_update		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						history_harga_jual_DataStore.commitChanges();
						history_harga_jual_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not save the history_harga_jual.',
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
	function history_harga_jual_create(){
		if(is_history_harga_jual_form_valid()){
		
		var hjual_no_create=null;
		var hjual_tanggal_create_date="";
		var hjual_harga_create=null;
		var hjual_jenis_create=null;
		var hjual_update_create=null;
		var hjual_date_update_create_date="";
		var hjual_revised_create=null;

		if(hjual_noField.getValue()!== null){hjual_no_create = hjual_noField.getValue();}
		if(hjual_tanggalField.getValue()!== ""){hjual_tanggal_create_date = hjual_tanggalField.getValue().format('Y-m-d');}
		if(hjual_hargaField.getValue()!== null){hjual_harga_create = hjual_hargaField.getValue();}
		if(hjual_jenisField.getValue()!== null){hjual_jenis_create = hjual_jenisField.getValue();}
		if(hjual_updateField.getValue()!== null){hjual_update_create = hjual_updateField.getValue();}
		if(hjual_date_updateField.getValue()!== ""){hjual_date_update_create_date = hjual_date_updateField.getValue().format('Y-m-d');}
		if(hjual_revisedField.getValue()!== null){hjual_revised_create = hjual_revisedField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_history_harga_jual&m=get_action',
				params: {
					task: post2db,
					hjual_no	: hjual_no_create_pk,	
					hjual_tanggal	: hjual_tanggal_create_pk,	
					hjual_harga	: hjual_harga_create,	
					hjual_jenis	: hjual_jenis_create,	
					hjual_update	: hjual_update_create,	
					hjual_date_update	: hjual_date_update_create_date,					hjual_revised	: hjual_revised_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The History_harga_jual was '+msg+' successfully.');
							history_harga_jual_DataStore.reload();
							history_harga_jual_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the History_harga_jual.',
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
			return history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_no,hjual_tanggal');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function history_harga_jual_reset_form(){
		hjual_hargaField.reset();
		hjual_jenisField.reset();
		hjual_updateField.reset();
		hjual_date_updateField.reset();
		hjual_revisedField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function history_harga_jual_set_form(){
		hjual_noField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_no'));
		hjual_tanggalField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_tanggal'));
		hjual_hargaField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_harga'));
		hjual_jenisField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_jenis'));
		hjual_updateField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_update'));
		hjual_date_updateField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_date_update'));
		hjual_revisedField.setValue(history_harga_jualListEditorGrid.getSelectionModel().getSelected().get('hjual_revised'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_history_harga_jual_form_valid(){
		return (hjual_noField.isValid() && hjual_tanggalField.isValid() && true &&  true &&  true &&  true &&  true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!history_harga_jual_createWindow.isVisible()){
			history_harga_jual_reset_form();
			post2db='CREATE';
			msg='created';
			history_harga_jual_createWindow.show();
		} else {
			history_harga_jual_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function history_harga_jual_confirm_delete(){
		// only one history_harga_jual is selected here
		if(history_harga_jualListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', history_harga_jual_delete);
		} else if(history_harga_jualListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', history_harga_jual_delete);
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
	function history_harga_jual_confirm_update(){
		/* only one record is selected here */
		if(history_harga_jualListEditorGrid.selModel.getCount() == 1) {
			history_harga_jual_set_form();
			post2db='UPDATE';
			msg='updated';
			history_harga_jual_createWindow.show();
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
	function history_harga_jual_delete(btn){
		if(btn=='yes'){
			var selections = history_harga_jualListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< history_harga_jualListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.hjual_no,hjual_tanggal);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_history_harga_jual&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							history_harga_jual_DataStore.reload();
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
	history_harga_jual_DataStore = new Ext.data.Store({
		id: 'history_harga_jual_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_history_harga_jual&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'hjual_no,hjual_tanggal'
		},[
		/* dataIndex => insert intohistory_harga_jual_ColumnModel, Mapping => for initiate table column */ 
			{name: 'hjual_no', type: 'string', mapping: 'hjual_no'},
			{name: 'hjual_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'hjual_tanggal'},
			{name: 'hjual_harga', type: 'float', mapping: 'hjual_harga'},
			{name: 'hjual_jenis', type: 'string', mapping: 'hjual_jenis'},
			{name: 'hjual_update', type: 'string', mapping: 'hjual_update'},
			{name: 'hjual_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'hjual_date_update'},
			{name: 'hjual_revised', type: 'int', mapping: 'hjual_revised'}
		]),
		sortInfo:{field: 'hjual_no,hjual_tanggal', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	history_harga_jual_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'hjual_no,hjual_tanggal',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},
		{
			header: 'Hjual Harga',
			dataIndex: 'hjual_harga',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 22,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Hjual Jenis',
			dataIndex: 'hjual_jenis',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['hjual_jenis_value', 'hjual_jenis_display'],
					data: [['produk','produk'],['perawatan','perawatan'],['paket','paket']]
					}),
				mode: 'local',
               	displayField: 'hjual_jenis_display',
               	valueField: 'hjual_jenis_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Hjual Update',
			dataIndex: 'hjual_update',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
		},
		{
			header: 'Hjual Date Update',
			dataIndex: 'hjual_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: new Ext.form.DateField({
				format: 'Y-m-d'
			})
		},
		{
			header: 'Hjual Revised',
			dataIndex: 'hjual_revised',
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
	history_harga_jual_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	history_harga_jualListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'history_harga_jualListEditorGrid',
		el: 'fp_history_harga_jual',
		title: 'List Of History_harga_jual',
		autoHeight: true,
		store: history_harga_jual_DataStore, // DataStore
		cm: history_harga_jual_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: history_harga_jual_DataStore,
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
			handler: history_harga_jual_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: history_harga_jual_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: history_harga_jual_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: history_harga_jual_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: history_harga_jual_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: history_harga_jual_print  
		}
		]
	});
	history_harga_jualListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	history_harga_jual_ContextMenu = new Ext.menu.Menu({
		id: 'history_harga_jual_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: history_harga_jual_confirm_update 
		},
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: history_harga_jual_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: history_harga_jual_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: history_harga_jual_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onhistory_harga_jual_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		history_harga_jual_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		history_harga_jual_SelectedRow=rowIndex;
		history_harga_jual_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function history_harga_jual_editContextMenu(){
      history_harga_jualListEditorGrid.startEditing(history_harga_jual_SelectedRow,1);
  	}
	/* End of Function */
  	
	history_harga_jualListEditorGrid.addListener('rowcontextmenu', onhistory_harga_jual_ListEditGridContextMenu);
	history_harga_jual_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	history_harga_jualListEditorGrid.on('afteredit', history_harga_jual_update); // inLine Editing Record
	
	/* Identify  hjual_no Field */
	hjual_noField= new Ext.form.TextField({
		id: 'hjual_noField',
		fieldLabel: 'Hjual No',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  hjual_tanggal Field */
	hjual_tanggalField= new Ext.form.DateField({
		id: 'hjual_tanggalField',
		fieldLabel: 'Hjual Tanggal',
		format : 'Y-m-d',
		allowBlank: false,
	});
	/* Identify  hjual_harga Field */
	hjual_hargaField= new Ext.form.NumberField({
		id: 'hjual_hargaField',
		fieldLabel: 'Hjual Harga',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  hjual_jenis Field */
	hjual_jenisField= new Ext.form.ComboBox({
		id: 'hjual_jenisField',
		fieldLabel: 'Hjual Jenis',
		store:new Ext.data.SimpleStore({
			fields:['hjual_jenis_value', 'hjual_jenis_display'],
			data:[['produk','produk'],['perawatan','perawatan'],['paket','paket']]
		}),
		mode: 'local',
		displayField: 'hjual_jenis_display',
		valueField: 'hjual_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  hjual_update Field */
	hjual_updateField= new Ext.form.TextField({
		id: 'hjual_updateField',
		fieldLabel: 'Hjual Update',
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  hjual_date_update Field */
	hjual_date_updateField= new Ext.form.DateField({
		id: 'hjual_date_updateField',
		fieldLabel: 'Hjual Date Update',
		format : 'Y-m-d',
	});
	/* Identify  hjual_revised Field */
	hjual_revisedField= new Ext.form.NumberField({
		id: 'hjual_revisedField',
		fieldLabel: 'Hjual Revised',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
  	
	/* Function for retrieve create Window Panel*/ 
	history_harga_jual_createForm = new Ext.FormPanel({
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
				items: [hjual_noFieldhjual_tanggalField, hjual_hargaField, hjual_jenisField, hjual_updateField, hjual_date_updateField, hjual_revisedField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Save and Close',
				handler: history_harga_jual_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					history_harga_jual_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	history_harga_jual_createWindow= new Ext.Window({
		id: 'history_harga_jual_createWindow',
		title: post2db+'History_harga_jual',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_history_harga_jual_create',
		items: history_harga_jual_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function history_harga_jual_list_search(){
		// render according to a SQL date format.
		var hjual_no_search=null;
		var hjual_tanggal_search_date="";
		var hjual_harga_search=null;
		var hjual_jenis_search=null;
		var hjual_update_search=null;
		var hjual_date_update_search_date="";
		var hjual_revised_search=null;

		if(hjual_noSearchField.getValue()!==null){hjual_no_search=hjual_noSearchField.getValue();}
		if(hjual_tanggalSearchField.getValue()!==""){hjual_tanggal_search_date=hjual_tanggalSearchField.getValue().format('Y-m-d');}
		if(hjual_hargaSearchField.getValue()!==null){hjual_harga_search=hjual_hargaSearchField.getValue();}
		if(hjual_jenisSearchField.getValue()!==null){hjual_jenis_search=hjual_jenisSearchField.getValue();}
		if(hjual_updateSearchField.getValue()!==null){hjual_update_search=hjual_updateSearchField.getValue();}
		if(hjual_date_updateSearchField.getValue()!==""){hjual_date_update_search_date=hjual_date_updateSearchField.getValue().format('Y-m-d');}
		if(hjual_revisedSearchField.getValue()!==null){hjual_revised_search=hjual_revisedSearchField.getValue();}
		// change the store parameters
		history_harga_jual_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			hjual_no	:	hjual_no_search, 
			hjual_tanggal	:	hjual_tanggal_search_date, 
			hjual_harga	:	hjual_harga_search, 
			hjual_jenis	:	hjual_jenis_search, 
			hjual_update	:	hjual_update_search, 
			hjual_date_update	:	hjual_date_update_search_date, 
			hjual_revised	:	hjual_revised_search 
};
		// Cause the datastore to do another query : 
		history_harga_jual_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function history_harga_jual_reset_search(){
		// reset the store parameters
		history_harga_jual_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		history_harga_jual_DataStore.reload({params: {start: 0, limit: pageS}});
		history_harga_jual_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  hjual_no Search Field */
	hjual_noSearchField= new Ext.form.TextField({
		id: 'hjual_noSearchField',
		fieldLabel: 'Hjual No',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  hjual_tanggal Search Field */
	hjual_tanggalSearchField= new Ext.form.DateField({
		id: 'hjual_tanggalSearchField',
		fieldLabel: 'Hjual Tanggal',
		format : 'Y-m-d',
	
	});
	/* Identify  hjual_harga Search Field */
	hjual_hargaSearchField= new Ext.form.NumberField({
		id: 'hjual_hargaSearchField',
		fieldLabel: 'Hjual Harga',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  hjual_jenis Search Field */
	hjual_jenisSearchField= new Ext.form.ComboBox({
		id: 'hjual_jenisSearchField',
		fieldLabel: 'Hjual Jenis',
		store:new Ext.data.SimpleStore({
			fields:['value', 'hjual_jenis'],
			data:[['produk','produk'],['perawatan','perawatan'],['paket','paket']]
		}),
		mode: 'local',
		displayField: 'hjual_jenis',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  hjual_update Search Field */
	hjual_updateSearchField= new Ext.form.TextField({
		id: 'hjual_updateSearchField',
		fieldLabel: 'Hjual Update',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  hjual_date_update Search Field */
	hjual_date_updateSearchField= new Ext.form.DateField({
		id: 'hjual_date_updateSearchField',
		fieldLabel: 'Hjual Date Update',
		format : 'Y-m-d',
	
	});
	/* Identify  hjual_revised Search Field */
	hjual_revisedSearchField= new Ext.form.NumberField({
		id: 'hjual_revisedSearchField',
		fieldLabel: 'Hjual Revised',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
    
	/* Function for retrieve search Form Panel */
	history_harga_jual_searchForm = new Ext.FormPanel({
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
				items: [hjual_noSearchFieldhjual_tanggalSearchField, hjual_hargaSearchField, hjual_jenisSearchField, hjual_updateSearchField, hjual_date_updateSearchField, hjual_revisedSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: history_harga_jual_list_search
			},{
				text: 'Close',
				handler: function(){
					history_harga_jual_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	history_harga_jual_searchWindow = new Ext.Window({
		title: 'history_harga_jual Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_history_harga_jual_search',
		items: history_harga_jual_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!history_harga_jual_searchWindow.isVisible()){
			history_harga_jual_searchWindow.show();
		} else {
			history_harga_jual_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function history_harga_jual_print(){
		var searchquery = "";
		var hjual_no_print=null;
		var hjual_tanggal_print_date="";
		var hjual_harga_print=null;
		var hjual_jenis_print=null;
		var hjual_update_print=null;
		var hjual_date_update_print_date="";
		var hjual_revised_print=null;
		var win;              
		// check if we do have some search data...
		if(history_harga_jual_DataStore.baseParams.query!==null){searchquery = history_harga_jual_DataStore.baseParams.query;}
		if(history_harga_jual_DataStore.baseParams.hjual_no!==null){hjual_no_print = history_harga_jual_DataStore.baseParams.hjual_no;}
		if(history_harga_jual_DataStore.baseParams.hjual_tanggal!==""){hjual_tanggal_print_date = history_harga_jual_DataStore.baseParams.hjual_tanggal;}
		if(history_harga_jual_DataStore.baseParams.hjual_harga!==null){hjual_harga_print = history_harga_jual_DataStore.baseParams.hjual_harga;}
		if(history_harga_jual_DataStore.baseParams.hjual_jenis!==null){hjual_jenis_print = history_harga_jual_DataStore.baseParams.hjual_jenis;}
		if(history_harga_jual_DataStore.baseParams.hjual_update!==null){hjual_update_print = history_harga_jual_DataStore.baseParams.hjual_update;}
		if(history_harga_jual_DataStore.baseParams.hjual_date_update!==""){hjual_date_update_print_date = history_harga_jual_DataStore.baseParams.hjual_date_update;}
		if(history_harga_jual_DataStore.baseParams.hjual_revised!==null){hjual_revised_print = history_harga_jual_DataStore.baseParams.hjual_revised;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_history_harga_jual&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			hjual_no : hjual_no_print,
		  	hjual_tanggal : hjual_tanggal_print_date, 
			hjual_harga : hjual_harga_print,
			hjual_jenis : hjual_jenis_print,
			hjual_update : hjual_update_print,
		  	hjual_date_update : hjual_date_update_print_date, 
			hjual_revised : hjual_revised_print,
		  	currentlisting: history_harga_jual_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./history_harga_juallist.html','history_harga_juallist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function history_harga_jual_export_excel(){
		var searchquery = "";
		var hjual_no_2excel=null;
		var hjual_tanggal_2excel_date="";
		var hjual_harga_2excel=null;
		var hjual_jenis_2excel=null;
		var hjual_update_2excel=null;
		var hjual_date_update_2excel_date="";
		var hjual_revised_2excel=null;
		var win;              
		// check if we do have some search data...
		if(history_harga_jual_DataStore.baseParams.query!==null){searchquery = history_harga_jual_DataStore.baseParams.query;}
		if(history_harga_jual_DataStore.baseParams.hjual_no!==null){hjual_no_2excel = history_harga_jual_DataStore.baseParams.hjual_no;}
		if(history_harga_jual_DataStore.baseParams.hjual_tanggal!==""){hjual_tanggal_2excel_date = history_harga_jual_DataStore.baseParams.hjual_tanggal;}
		if(history_harga_jual_DataStore.baseParams.hjual_harga!==null){hjual_harga_2excel = history_harga_jual_DataStore.baseParams.hjual_harga;}
		if(history_harga_jual_DataStore.baseParams.hjual_jenis!==null){hjual_jenis_2excel = history_harga_jual_DataStore.baseParams.hjual_jenis;}
		if(history_harga_jual_DataStore.baseParams.hjual_update!==null){hjual_update_2excel = history_harga_jual_DataStore.baseParams.hjual_update;}
		if(history_harga_jual_DataStore.baseParams.hjual_date_update!==""){hjual_date_update_2excel_date = history_harga_jual_DataStore.baseParams.hjual_date_update;}
		if(history_harga_jual_DataStore.baseParams.hjual_revised!==null){hjual_revised_2excel = history_harga_jual_DataStore.baseParams.hjual_revised;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_history_harga_jual&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			hjual_no : hjual_no_2excel,
		  	hjual_tanggal : hjual_tanggal_2excel_date, 
			hjual_harga : hjual_harga_2excel,
			hjual_jenis : hjual_jenis_2excel,
			hjual_update : hjual_update_2excel,
		  	hjual_date_update : hjual_date_update_2excel_date, 
			hjual_revised : hjual_revised_2excel,
		  	currentlisting: history_harga_jual_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_history_harga_jual"></div>
		<div id="elwindow_history_harga_jual_create"></div>
        <div id="elwindow_history_harga_jual_search"></div>
    </div>
</div>
</body>