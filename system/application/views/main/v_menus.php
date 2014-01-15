<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: menus View
	+ Description	: For record view
	+ Filename 		: v_menus.php
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
var menus_DataStore;
var menus_ColumnModel;
var menusListEditorGrid;
var menus_createForm;
var menus_createWindow;
var menus_searchForm;
var menus_searchWindow;
var menus_SelectedRow;
var menus_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var menu_idField;
var menu_parentField;
var menu_positionField;
var menu_titleField;
var menu_linkField;
var menu_catField;
var menu_confirmField;
var menu_leftpanelField;
var menu_iconpanelField;
var menu_iconmenuField;
var menu_idSearchField;
var menu_parentSearchField;
var menu_positionSearchField;
var menu_titleSearchField;
var menu_linkSearchField;
var menu_catSearchField;
var menu_confirmSearchField;
var menu_leftpanelSearchField;
var menu_iconpanelSearchField;
var menu_iconmenuSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function menus_update(oGrid_event){
	var menu_id_update_pk="";
	var menu_parent_update=null;
	var menu_position_update=null;
	var menu_title_update=null;
	var menu_link_update=null;
	var menu_cat_update=null;
	var menu_confirm_update=null;
	var menu_leftpanel_update=null;
	var menu_iconpanel_update=null;
	var menu_iconmenu_update=null;

	menu_id_update_pk = get_pk_id();
	if(oGrid_event.record.data.menu_parent!== null){menu_parent_update = oGrid_event.record.data.menu_parent;}
	if(oGrid_event.record.data.menu_position!== null){menu_position_update = oGrid_event.record.data.menu_position;}
	if(oGrid_event.record.data.menu_title!== null){menu_title_update = oGrid_event.record.data.menu_title;}
	if(oGrid_event.record.data.menu_link!== null){menu_link_update = oGrid_event.record.data.menu_link;}
	if(oGrid_event.record.data.menu_cat!== null){menu_cat_update = oGrid_event.record.data.menu_cat;}
	if(oGrid_event.record.data.menu_confirm!== null){menu_confirm_update = oGrid_event.record.data.menu_confirm;}
	if(oGrid_event.record.data.menu_leftpanel!== null){menu_leftpanel_update = oGrid_event.record.data.menu_leftpanel;}
	if(oGrid_event.record.data.menu_iconpanel!== null){menu_iconpanel_update = oGrid_event.record.data.menu_iconpanel;}
	if(oGrid_event.record.data.menu_iconmenu!== null){menu_iconmenu_update = oGrid_event.record.data.menu_iconmenu;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_menus&m=get_action',
			params: {
				task: "UPDATE",
				menu_id	: get_pk_id(),				menu_parent	:menu_parent_update,		
				menu_position	:menu_position_update,		
				menu_title	:menu_title_update,		
				menu_link	:menu_link_update,		
				menu_cat	:menu_cat_update,		
				menu_confirm	:menu_confirm_update,		
				menu_leftpanel	:menu_leftpanel_update,		
				menu_iconpanel	:menu_iconpanel_update,		
				menu_iconmenu	:menu_iconmenu_update		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						menus_DataStore.commitChanges();
						menus_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not save the menus.',
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
	function menus_create(){
		if(is_menus_form_valid()){
		
		var menu_id_create_pk=null;
		var menu_parent_create=null;
		var menu_position_create=null;
		var menu_title_create=null;
		var menu_link_create=null;
		var menu_cat_create=null;
		var menu_confirm_create=null;
		var menu_leftpanel_create=null;
		var menu_iconpanel_create=null;
		var menu_iconmenu_create=null;

		menu_id_create_pk=get_pk_id();
		if(menu_parentField.getValue()!== null){menu_parent_create = menu_parentField.getValue();}
		if(menu_positionField.getValue()!== null){menu_position_create = menu_positionField.getValue();}
		if(menu_titleField.getValue()!== null){menu_title_create = menu_titleField.getValue();}
		if(menu_linkField.getValue()!== null){menu_link_create = menu_linkField.getValue();}
		if(menu_catField.getValue()!== null){menu_cat_create = menu_catField.getValue();}
		if(menu_confirmField.getValue()!== null){menu_confirm_create = menu_confirmField.getValue();}
		if(menu_leftpanelField.getValue()!== null){menu_leftpanel_create = menu_leftpanelField.getValue();}
		if(menu_iconpanelField.getValue()!== null){menu_iconpanel_create = menu_iconpanelField.getValue();}
		if(menu_iconmenuField.getValue()!== null){menu_iconmenu_create = menu_iconmenuField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_menus&m=get_action',
				params: {
					task: post2db,
					menu_id	: menu_id_create_pk,	
					menu_parent	: menu_parent_create,	
					menu_position	: menu_position_create,	
					menu_title	: menu_title_create,	
					menu_link	: menu_link_create,	
					menu_cat	: menu_cat_create,	
					menu_confirm	: menu_confirm_create,	
					menu_leftpanel	: menu_leftpanel_create,	
					menu_iconpanel	: menu_iconpanel_create,	
					menu_iconmenu	: menu_iconmenu_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The Menus was '+msg+' successfully.');
							menus_DataStore.reload();
							menus_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the Menus.',
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
			return menusListEditorGrid.getSelectionModel().getSelected().get('menu_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function menus_reset_form(){
		menu_parentField.reset();
		menu_positionField.reset();
		menu_titleField.reset();
		menu_linkField.reset();
		menu_catField.reset();
		menu_confirmField.reset();
		menu_leftpanelField.reset();
		menu_iconpanelField.reset();
		menu_iconmenuField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function menus_set_form(){
		menu_parentField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_parent'));
		menu_positionField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_position'));
		menu_titleField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_title'));
		menu_linkField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_link'));
		menu_catField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_cat'));
		menu_confirmField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_confirm'));
		menu_leftpanelField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_leftpanel'));
		menu_iconpanelField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_iconpanel'));
		menu_iconmenuField.setValue(menusListEditorGrid.getSelectionModel().getSelected().get('menu_iconmenu'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_menus_form_valid(){
		return (true &&  menu_parentField.isValid() && menu_positionField.isValid() && menu_titleField.isValid() && menu_linkField.isValid() && menu_catField.isValid() && menu_confirmField.isValid() && menu_leftpanelField.isValid() && true &&  true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!menus_createWindow.isVisible()){
			menus_reset_form();
			post2db='CREATE';
			msg='created';
			menus_createWindow.show();
		} else {
			menus_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function menus_confirm_delete(){
		// only one menus is selected here
		if(menusListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', menus_delete);
		} else if(menusListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', menus_delete);
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
	function menus_confirm_update(){
		/* only one record is selected here */
		if(menusListEditorGrid.selModel.getCount() == 1) {
			menus_set_form();
			post2db='UPDATE';
			msg='updated';
			menus_createWindow.show();
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
	function menus_delete(btn){
		if(btn=='yes'){
			var selections = menusListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< menusListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.menu_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_menus&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							menus_DataStore.reload();
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
	menus_DataStore = new Ext.data.Store({
		id: 'menus_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_menus&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'menu_id'
		},[
		/* dataIndex => insert intomenus_ColumnModel, Mapping => for initiate table column */ 
			{name: 'menu_id', type: 'int', mapping: 'menu_id'},
			{name: 'menu_parent', type: 'int', mapping: 'menu_parent'},
			{name: 'menu_position', type: 'int', mapping: 'menu_position'},
			{name: 'menu_title', type: 'string', mapping: 'menu_title'},
			{name: 'menu_link', type: 'string', mapping: 'menu_link'},
			{name: 'menu_cat', type: 'string', mapping: 'menu_cat'},
			{name: 'menu_confirm', type: 'string', mapping: 'menu_confirm'},
			{name: 'menu_leftpanel', type: 'string', mapping: 'menu_leftpanel'},
			{name: 'menu_iconpanel', type: 'string', mapping: 'menu_iconpanel'},
			{name: 'menu_iconmenu', type: 'string', mapping: 'menu_iconmenu'}
		]),
		sortInfo:{field: 'menu_id', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	menus_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'menu_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},
		{
			header: 'Menu Parent',
			dataIndex: 'menu_parent',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowBlank: false,
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Menu Position',
			dataIndex: 'menu_position',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowBlank: false,
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Menu Title',
			dataIndex: 'menu_title',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 250
          	})
		},
		{
			header: 'Menu Link',
			dataIndex: 'menu_link',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 250
          	})
		},
		{
			header: 'Menu Cat',
			dataIndex: 'menu_cat',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['menu_cat_value', 'menu_cat_display'],
					data: [['window','window'],['url','url']]
					}),
				mode: 'local',
               	displayField: 'menu_cat_display',
               	valueField: 'menu_cat_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Menu Confirm',
			dataIndex: 'menu_confirm',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['menu_confirm_value', 'menu_confirm_display'],
					data: [['Y','Y'],['N','N']]
					}),
				mode: 'local',
               	displayField: 'menu_confirm_display',
               	valueField: 'menu_confirm_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Menu Leftpanel',
			dataIndex: 'menu_leftpanel',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['menu_leftpanel_value', 'menu_leftpanel_display'],
					data: [['N','N'],['Y','Y']]
					}),
				mode: 'local',
               	displayField: 'menu_leftpanel_display',
               	valueField: 'menu_leftpanel_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Menu Iconpanel',
			dataIndex: 'menu_iconpanel',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
		},
		{
			header: 'Menu Iconmenu',
			dataIndex: 'menu_iconmenu',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
		}]
	);
	menus_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	menusListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'menusListEditorGrid',
		el: 'fp_menus',
		title: 'List Of Menus',
		autoHeight: true,
		store: menus_DataStore, // DataStore
		cm: menus_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: menus_DataStore,
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
			handler: menus_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: menus_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: menus_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: menus_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: menus_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: menus_print  
		}
		]
	});
	menusListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	menus_ContextMenu = new Ext.menu.Menu({
		id: 'menus_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: menus_confirm_update 
		},
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: menus_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: menus_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: menus_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmenus_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		menus_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		menus_SelectedRow=rowIndex;
		menus_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function menus_editContextMenu(){
      menusListEditorGrid.startEditing(menus_SelectedRow,1);
  	}
	/* End of Function */
  	
	menusListEditorGrid.addListener('rowcontextmenu', onmenus_ListEditGridContextMenu);
	menus_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	menusListEditorGrid.on('afteredit', menus_update); // inLine Editing Record
	
	/* Identify  menu_parent Field */
	menu_parentField= new Ext.form.NumberField({
		id: 'menu_parentField',
		fieldLabel: 'Menu Parent',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  menu_position Field */
	menu_positionField= new Ext.form.NumberField({
		id: 'menu_positionField',
		fieldLabel: 'Menu Position',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  menu_title Field */
	menu_titleField= new Ext.form.TextField({
		id: 'menu_titleField',
		fieldLabel: 'Menu Title',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  menu_link Field */
	menu_linkField= new Ext.form.TextField({
		id: 'menu_linkField',
		fieldLabel: 'Menu Link',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  menu_cat Field */
	menu_catField= new Ext.form.ComboBox({
		id: 'menu_catField',
		fieldLabel: 'Menu Cat',
		store:new Ext.data.SimpleStore({
			fields:['menu_cat_value', 'menu_cat_display'],
			data:[['window','window'],['url','url']]
		}),
		mode: 'local',
		displayField: 'menu_cat_display',
		valueField: 'menu_cat_value',
		allowBlank: false,
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  menu_confirm Field */
	menu_confirmField= new Ext.form.ComboBox({
		id: 'menu_confirmField',
		fieldLabel: 'Menu Confirm',
		store:new Ext.data.SimpleStore({
			fields:['menu_confirm_value', 'menu_confirm_display'],
			data:[['Y','Y'],['N','N']]
		}),
		mode: 'local',
		displayField: 'menu_confirm_display',
		valueField: 'menu_confirm_value',
		allowBlank: false,
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  menu_leftpanel Field */
	menu_leftpanelField= new Ext.form.ComboBox({
		id: 'menu_leftpanelField',
		fieldLabel: 'Menu Leftpanel',
		store:new Ext.data.SimpleStore({
			fields:['menu_leftpanel_value', 'menu_leftpanel_display'],
			data:[['N','N'],['Y','Y']]
		}),
		mode: 'local',
		displayField: 'menu_leftpanel_display',
		valueField: 'menu_leftpanel_value',
		allowBlank: false,
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  menu_iconpanel Field */
	menu_iconpanelField= new Ext.form.TextField({
		id: 'menu_iconpanelField',
		fieldLabel: 'Menu Iconpanel',
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  menu_iconmenu Field */
	menu_iconmenuField= new Ext.form.TextField({
		id: 'menu_iconmenuField',
		fieldLabel: 'Menu Iconmenu',
		maxLength: 50,
		anchor: '95%'
	});
  	
	/* Function for retrieve create Window Panel*/ 
	menus_createForm = new Ext.FormPanel({
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
				items: [menu_parentField, menu_positionField, menu_titleField, menu_linkField, menu_catField, menu_confirmField, menu_leftpanelField, menu_iconpanelField, menu_iconmenuField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Save and Close',
				handler: menus_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					menus_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	menus_createWindow= new Ext.Window({
		id: 'menus_createWindow',
		title: post2db+'Menus',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_menus_create',
		items: menus_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function menus_list_search(){
		// render according to a SQL date format.
		var menu_id_search=null;
		var menu_parent_search=null;
		var menu_position_search=null;
		var menu_title_search=null;
		var menu_link_search=null;
		var menu_cat_search=null;
		var menu_confirm_search=null;
		var menu_leftpanel_search=null;
		var menu_iconpanel_search=null;
		var menu_iconmenu_search=null;

		if(menu_idSearchField.getValue()!==null){menu_id_search=menu_idSearchField.getValue();}
		if(menu_parentSearchField.getValue()!==null){menu_parent_search=menu_parentSearchField.getValue();}
		if(menu_positionSearchField.getValue()!==null){menu_position_search=menu_positionSearchField.getValue();}
		if(menu_titleSearchField.getValue()!==null){menu_title_search=menu_titleSearchField.getValue();}
		if(menu_linkSearchField.getValue()!==null){menu_link_search=menu_linkSearchField.getValue();}
		if(menu_catSearchField.getValue()!==null){menu_cat_search=menu_catSearchField.getValue();}
		if(menu_confirmSearchField.getValue()!==null){menu_confirm_search=menu_confirmSearchField.getValue();}
		if(menu_leftpanelSearchField.getValue()!==null){menu_leftpanel_search=menu_leftpanelSearchField.getValue();}
		if(menu_iconpanelSearchField.getValue()!==null){menu_iconpanel_search=menu_iconpanelSearchField.getValue();}
		if(menu_iconmenuSearchField.getValue()!==null){menu_iconmenu_search=menu_iconmenuSearchField.getValue();}
		// change the store parameters
		menus_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			menu_id	:	menu_id_search, 
			menu_parent	:	menu_parent_search, 
			menu_position	:	menu_position_search, 
			menu_title	:	menu_title_search, 
			menu_link	:	menu_link_search, 
			menu_cat	:	menu_cat_search, 
			menu_confirm	:	menu_confirm_search, 
			menu_leftpanel	:	menu_leftpanel_search, 
			menu_iconpanel	:	menu_iconpanel_search, 
			menu_iconmenu	:	menu_iconmenu_search 
};
		// Cause the datastore to do another query : 
		menus_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function menus_reset_search(){
		// reset the store parameters
		menus_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		menus_DataStore.reload({params: {start: 0, limit: pageS}});
		menus_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  menu_id Search Field */
	menu_idSearchField= new Ext.form.NumberField({
		id: 'menu_idSearchField',
		fieldLabel: 'Menu Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  menu_parent Search Field */
	menu_parentSearchField= new Ext.form.NumberField({
		id: 'menu_parentSearchField',
		fieldLabel: 'Menu Parent',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  menu_position Search Field */
	menu_positionSearchField= new Ext.form.NumberField({
		id: 'menu_positionSearchField',
		fieldLabel: 'Menu Position',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  menu_title Search Field */
	menu_titleSearchField= new Ext.form.TextField({
		id: 'menu_titleSearchField',
		fieldLabel: 'Menu Title',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  menu_link Search Field */
	menu_linkSearchField= new Ext.form.TextField({
		id: 'menu_linkSearchField',
		fieldLabel: 'Menu Link',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  menu_cat Search Field */
	menu_catSearchField= new Ext.form.ComboBox({
		id: 'menu_catSearchField',
		fieldLabel: 'Menu Cat',
		store:new Ext.data.SimpleStore({
			fields:['value', 'menu_cat'],
			data:[['window','window'],['url','url']]
		}),
		mode: 'local',
		displayField: 'menu_cat',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  menu_confirm Search Field */
	menu_confirmSearchField= new Ext.form.ComboBox({
		id: 'menu_confirmSearchField',
		fieldLabel: 'Menu Confirm',
		store:new Ext.data.SimpleStore({
			fields:['value', 'menu_confirm'],
			data:[['Y','Y'],['N','N']]
		}),
		mode: 'local',
		displayField: 'menu_confirm',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  menu_leftpanel Search Field */
	menu_leftpanelSearchField= new Ext.form.ComboBox({
		id: 'menu_leftpanelSearchField',
		fieldLabel: 'Menu Leftpanel',
		store:new Ext.data.SimpleStore({
			fields:['value', 'menu_leftpanel'],
			data:[['N','N'],['Y','Y']]
		}),
		mode: 'local',
		displayField: 'menu_leftpanel',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  menu_iconpanel Search Field */
	menu_iconpanelSearchField= new Ext.form.TextField({
		id: 'menu_iconpanelSearchField',
		fieldLabel: 'Menu Iconpanel',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  menu_iconmenu Search Field */
	menu_iconmenuSearchField= new Ext.form.TextField({
		id: 'menu_iconmenuSearchField',
		fieldLabel: 'Menu Iconmenu',
		maxLength: 50,
		anchor: '95%'
	
	});
    
	/* Function for retrieve search Form Panel */
	menus_searchForm = new Ext.FormPanel({
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
				items: [menu_parentSearchField, menu_positionSearchField, menu_titleSearchField, menu_linkSearchField, menu_catSearchField, menu_confirmSearchField, menu_leftpanelSearchField, menu_iconpanelSearchField, menu_iconmenuSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: menus_list_search
			},{
				text: 'Close',
				handler: function(){
					menus_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	menus_searchWindow = new Ext.Window({
		title: 'menus Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_menus_search',
		items: menus_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!menus_searchWindow.isVisible()){
			menus_searchWindow.show();
		} else {
			menus_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function menus_print(){
		var searchquery = "";
		var menu_parent_print=null;
		var menu_position_print=null;
		var menu_title_print=null;
		var menu_link_print=null;
		var menu_cat_print=null;
		var menu_confirm_print=null;
		var menu_leftpanel_print=null;
		var menu_iconpanel_print=null;
		var menu_iconmenu_print=null;
		var win;              
		// check if we do have some search data...
		if(menus_DataStore.baseParams.query!==null){searchquery = menus_DataStore.baseParams.query;}
		if(menus_DataStore.baseParams.menu_parent!==null){menu_parent_print = menus_DataStore.baseParams.menu_parent;}
		if(menus_DataStore.baseParams.menu_position!==null){menu_position_print = menus_DataStore.baseParams.menu_position;}
		if(menus_DataStore.baseParams.menu_title!==null){menu_title_print = menus_DataStore.baseParams.menu_title;}
		if(menus_DataStore.baseParams.menu_link!==null){menu_link_print = menus_DataStore.baseParams.menu_link;}
		if(menus_DataStore.baseParams.menu_cat!==null){menu_cat_print = menus_DataStore.baseParams.menu_cat;}
		if(menus_DataStore.baseParams.menu_confirm!==null){menu_confirm_print = menus_DataStore.baseParams.menu_confirm;}
		if(menus_DataStore.baseParams.menu_leftpanel!==null){menu_leftpanel_print = menus_DataStore.baseParams.menu_leftpanel;}
		if(menus_DataStore.baseParams.menu_iconpanel!==null){menu_iconpanel_print = menus_DataStore.baseParams.menu_iconpanel;}
		if(menus_DataStore.baseParams.menu_iconmenu!==null){menu_iconmenu_print = menus_DataStore.baseParams.menu_iconmenu;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_menus&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			menu_parent : menu_parent_print,
			menu_position : menu_position_print,
			menu_title : menu_title_print,
			menu_link : menu_link_print,
			menu_cat : menu_cat_print,
			menu_confirm : menu_confirm_print,
			menu_leftpanel : menu_leftpanel_print,
			menu_iconpanel : menu_iconpanel_print,
			menu_iconmenu : menu_iconmenu_print,
		  	currentlisting: menus_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./menuslist.html','menuslist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function menus_export_excel(){
		var searchquery = "";
		var menu_parent_2excel=null;
		var menu_position_2excel=null;
		var menu_title_2excel=null;
		var menu_link_2excel=null;
		var menu_cat_2excel=null;
		var menu_confirm_2excel=null;
		var menu_leftpanel_2excel=null;
		var menu_iconpanel_2excel=null;
		var menu_iconmenu_2excel=null;
		var win;              
		// check if we do have some search data...
		if(menus_DataStore.baseParams.query!==null){searchquery = menus_DataStore.baseParams.query;}
		if(menus_DataStore.baseParams.menu_parent!==null){menu_parent_2excel = menus_DataStore.baseParams.menu_parent;}
		if(menus_DataStore.baseParams.menu_position!==null){menu_position_2excel = menus_DataStore.baseParams.menu_position;}
		if(menus_DataStore.baseParams.menu_title!==null){menu_title_2excel = menus_DataStore.baseParams.menu_title;}
		if(menus_DataStore.baseParams.menu_link!==null){menu_link_2excel = menus_DataStore.baseParams.menu_link;}
		if(menus_DataStore.baseParams.menu_cat!==null){menu_cat_2excel = menus_DataStore.baseParams.menu_cat;}
		if(menus_DataStore.baseParams.menu_confirm!==null){menu_confirm_2excel = menus_DataStore.baseParams.menu_confirm;}
		if(menus_DataStore.baseParams.menu_leftpanel!==null){menu_leftpanel_2excel = menus_DataStore.baseParams.menu_leftpanel;}
		if(menus_DataStore.baseParams.menu_iconpanel!==null){menu_iconpanel_2excel = menus_DataStore.baseParams.menu_iconpanel;}
		if(menus_DataStore.baseParams.menu_iconmenu!==null){menu_iconmenu_2excel = menus_DataStore.baseParams.menu_iconmenu;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_menus&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			menu_parent : menu_parent_2excel,
			menu_position : menu_position_2excel,
			menu_title : menu_title_2excel,
			menu_link : menu_link_2excel,
			menu_cat : menu_cat_2excel,
			menu_confirm : menu_confirm_2excel,
			menu_leftpanel : menu_leftpanel_2excel,
			menu_iconpanel : menu_iconpanel_2excel,
			menu_iconmenu : menu_iconmenu_2excel,
		  	currentlisting: menus_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_menus"></div>
		<div id="elwindow_menus_create"></div>
        <div id="elwindow_menus_search"></div>
    </div>
</div>
</body>