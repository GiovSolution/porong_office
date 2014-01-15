<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: users View
	+ Description	: For record view
	+ Filename 		: v_users.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 15:35:27
	
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
var ptindakan_terapis_DataStore;
var ptindakan_terapis_ColumnModel;
var ptindakan_terapisListEditorGrid;
var ptindakan_terapis_createForm;
var ptindakan_terapis_createWindow;
var ptindakan_terapis_searchForm;
var ptindakan_terapis_searchWindow;
var ptindakan_terapis_SelectedRow;
var ptindakan_terapis_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=30;

/* declare variable here */
//var user_idField;
//var user_nameField;
//var user_passwdField;
//var user_karyawanField;
//var user_logField;
//var user_groupsField;
//var user_aktifField;
//var user_idSearchField;
//var user_nameSearchField;
//var user_passwdSearchField;
//var user_karyawanSearchField;
//var user_logSearchField;
//var user_groupsSearchField;
//var user_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function ptindakan_terapis_update(oGrid_event){

	var tindakan_adjusment_update=null;
	var adj_id_update_pk="";

	
	adj_id_update_pk = oGrid_event.record.data.adj_id;

	if(oGrid_event.record.data.adj_count!== null){tindakan_adjusment_update = oGrid_event.record.data.adj_count;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_penyesuaian_tindakan&m=get_action',
			params: {
				task: "UPDATE",
				adj_id	: adj_id_update_pk,				
			
				adj_count :tindakan_adjusment_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						ptindakan_terapis_DataStore.commitChanges();
						ptindakan_terapis_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   //msg: 'We could\'t not save the users.',
							   msg: 'Data penyesuaian tindakan tidak dapat disimpan',
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
	/*function users_create(){
		if(is_users_form_valid()){
		
		//var user_id_create_pk=null;
		//var user_name_create=null;
		//var user_passwd_create=null;
		//var user_karyawan_create=null;
		//var user_groups_create=null;
		//var user_aktif_create=null;

		user_id_create_pk=get_pk_id();
		//if(user_nameField.getValue()!== null){user_name_create = user_nameField.getValue();}
		//if(user_passwdField.getValue()!== null){user_passwd_create = user_passwdField.getValue();}
		//if(user_karyawanField.getValue()!== null){user_karyawan_create = user_karyawanField.getValue();}
		//if(user_groupsField.getValue()!== null){user_groups_create = user_groupsField.getValue();}
		//if(user_aktifField.getValue()!== null){user_aktif_create = user_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_penyesuaian_tindakan&m=get_action',
				params: {
					task: post2db,
					user_id	: user_id_create_pk,	
					user_name	: user_name_create,	
					user_passwd	: user_passwd_create,	
					user_karyawan	: user_karyawan_create,			
					user_groups	: user_groups_create,	
					user_aktif	: user_aktif_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							//Ext.MessageBox.alert(post2db+' OK','The Users was '+msg+' successfully.');
							Ext.MessageBox.alert(post2db+' OK', 'Data user berhasil disimpan');
							ptindakan_terapis_DataStore.reload();
							ptindakan_terapis_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   //msg: 'We could\'t not '+msg+' the Users.',
							   msg: 'Data user tidak bisa disimpan',
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
				//msg: 'Your Form is not valid!.',
				msg: 'Form anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}*/
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return ptindakan_terapisListEditorGrid.getSelectionModel().getSelected().get('adj_id');
		else 
			return 0;
	}
	/* End of Function  */
  
	/* Function for Check if the form is valid */
	function is_users_form_valid(){
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	/*function display_form_window(){
		if(!ptindakan_terapis_createWindow.isVisible()){
			users_reset_form();
			post2db='CREATE';
			msg='created';
			ptindakan_terapis_createWindow.show();
		} else {
			ptindakan_terapis_createWindow.toFront();
		}
	}*/
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function users_confirm_delete(){
		// only one users is selected here
		if(ptindakan_terapisListEditorGrid.selModel.getCount() == 1){
//			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', users_delete);
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', users_delete);
		} else if(ptindakan_terapisListEditorGrid.selModel.getCount() > 1){
//			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', users_delete);
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', users_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'You can\'t really delete something you haven\'t selected?',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function users_confirm_update(){
		/* only one record is selected here */
		if(ptindakan_terapisListEditorGrid.selModel.getCount() == 1) {
			users_set_form();
			post2db='UPDATE';
			msg='updated';
			ptindakan_terapis_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'You can\'t really update something you haven\'t selected?',
				msg: 'Anda belum memilih data yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function users_delete(btn){
		if(btn=='yes'){
			var selections = ptindakan_terapisListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< ptindakan_terapisListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.user_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_penyesuaian_tindakan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							ptindakan_terapis_DataStore.reload();
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
	ptindakan_terapis_DataStore = new Ext.data.Store({
		id: 'ptindakan_terapis_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penyesuaian_tindakan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'adj_id'
		},[
		/* dataIndex => insert intousers_ColumnModel, Mapping => for initiate table column */ 
			{name: 'adj_id', type: 'int', mapping: 'adj_id'},
			{name: 'adj_bln', type: 'date', dateFormat: 'Y-m', mapping: 'adj_bln'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'adj_count', type: 'float', mapping: 'adj_count'},
			{name: 'terapis_count', type: 'float', mapping: 'terapis_count'},
			{name: 'new_count', type: 'float', mapping: 'new_count'},
		]),
		sortInfo:{field: 'karyawan_username', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_user_karyawanDataStore = new Ext.data.Store({
		id: 'cbo_user_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penyesuaian_tindakan&m=get_karyawan_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'}
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	
	cbo_user_search_karyawanDataStore = new Ext.data.Store({
		id: 'cbo_user_search_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penyesuaian_tindakan&m=get_user_karyawan_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'}
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	
	var user_karyawan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{karyawan_nama}</b><br /></span>',
            'No.Karyawan: {karyawan_no}&nbsp;&nbsp;&nbsp;',
        '</div></tpl>'
    );
	
	var combo_dapp_tgl_medis=new Ext.form.DateField({
		format: 'Y-m'
	});
	combo_dapp_tgl_medis.on('select', function(){
		ptindakan_terapis_DataStore.load({params:{tgl_app:combo_dapp_tgl_medis.getValue().format('Y-m')}});
		//combo_dapp_tgl_medis.setValue(combo_dapp_tgl_medis.getValue().format('Y-m-d'));
	});
	
	cbo_user_groupDataStore = new Ext.data.Store({
	id: 'cbo_user_groupDataStore',
	proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_penyesuaian_tindakan&m=get_usergroups_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'user_group_value', type: 'int', mapping: 'group_id'},
			{name: 'user_group_display', type: 'string', mapping: 'group_name'}
		]),
	sortInfo:{field: 'user_group_display', direction: "ASC"}
	});
    
	
  	/* Function for Identify of Window Column Model */
	ptindakan_terapis_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'adj_id',
			width: 20,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Bulan',
			dataIndex: 'adj_bln',
			width: 80,
			sortable: true,
			hidden: true,
			renderer: Ext.util.Format.dateRenderer('Y-m'),
			editor: new Ext.form.DateField({
				format: 'Y-m'
			})
		},
		
		{
			align : 'Right',
			header: '<div align="center">' + 'Terapis Count(saat ini)' + '</div>',
			dataIndex: 'terapis_count',
			width: 60,	//150,
			sortable: true,
			
		},
		
		{
			header: '<div align="center">' + 'Therapist' + '</div>',
			dataIndex: 'karyawan_username',
			width: 100,	//150,
			sortable: true,
		
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Selisih' + '</div>',
			dataIndex: 'adj_count',
			width: 60,	//150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: true,
				blankText: '0',
				maxLength: 11
				//maskRe: /([0-9]+)$/
			})
		},
		
		{
			align : 'Right',
			header: '<div align="center">' + 'New Count' + '</div>',
			dataIndex: 'new_count',
			width: 60,	//150,
			sortable: true,
			
		}
		]
	);
	ptindakan_terapis_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	ptindakan_terapisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'ptindakan_terapisListEditorGrid',
		el: 'fp_users',
		title: 'Daftar Penyesuaian Tindakan Non Medis',
		autoHeight: true,
		store: ptindakan_terapis_DataStore, // DataStore
		cm: ptindakan_terapis_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 450,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: ptindakan_terapis_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
	{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: users_reset_search,
			iconCls:'icon-refresh'
		}
		]
	});
	ptindakan_terapisListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	ptindakan_terapis_ContextMenu = new Ext.menu.Menu({
		id: 'users_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: users_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: users_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onusers_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		ptindakan_terapis_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		ptindakan_terapis_SelectedRow=rowIndex;
		ptindakan_terapis_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function users_editContextMenu(){
      ptindakan_terapisListEditorGrid.startEditing(ptindakan_terapis_SelectedRow,1);
  	}
	/* End of Function */
  	
	ptindakan_terapisListEditorGrid.addListener('rowcontextmenu', onusers_ListEditGridContextMenu);
	ptindakan_terapis_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	ptindakan_terapisListEditorGrid.on('afteredit', ptindakan_terapis_update); // inLine Editing Record
	
	/* Identify  user_name Field */
	/*user_nameField= new Ext.form.TextField({
		id: 'user_nameField',
		fieldLabel: 'User Name',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});*/

	/* Identify  user_passwd Field */
	/*user_passwdField= new Ext.form.TextField({
		id: 'user_passwdField',
		fieldLabel: 'Password',
		maxLength: 50,
		anchor: '95%',
		inputType: 'password'
	});*/

		/* Identify  user_karyawan Field */
	/*user_karyawanField= new Ext.form.ComboBox({
		id: 'user_karyawanField',
		fieldLabel: 'Nama Karyawan',
		store: cbo_user_karyawanDataStore,
		mode: 'remote',
		displayField:'karyawan_nama',
		valueField: 'karyawan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: user_karyawan_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});*/
	/* Identify  user_log Field */
	/*user_logField= new Ext.form.DateField({
		id: 'user_logField',
		fieldLabel: 'Last Log',
		format : 'Y-m-d',
		readOnly: true,
		hideTrigger: true
	});*/
	/* Identify  user_groups Field */
	/*user_groupsField= new Ext.form.ComboBox({
		id: 'user_groupsField',
		fieldLabel: 'Group',
		typeAhead: true,
		triggerAction: 'all',
		store: cbo_user_groupDataStore,
		mode: 'remote',
		editable:false,
		displayField: 'user_group_display',
		valueField: 'user_group_value',
		lazyRender:true,
		width: 120,
		listClass: 'x-combo-list-small'
	});*/
	/* Identify  user_aktif Field */
	/*user_aktifField= new Ext.form.ComboBox({
		id: 'user_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['user_aktif_value', 'user_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'user_aktif_display',
		valueField: 'user_aktif_value',
		allowBlank: false,
		width: 80,
		triggerAction: 'all'	
	});*/
  	
	/* Function for retrieve create Window Panel*/ 
	ptindakan_terapis_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 350,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false
			}
			]
		}]
		,
		buttons: [{
				text: 'Save and Close'
				//handler: users_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					ptindakan_terapis_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	ptindakan_terapis_createWindow= new Ext.Window({
		id: 'ptindakan_terapis_createWindow',
		title: post2db+'Users',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_users_create',
		items: ptindakan_terapis_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function users_list_search(){
		// render according to a SQL date format.
		var user_id_search=null;
		var user_name_search=null;
		var user_passwd_search=null;
		var user_karyawan_search=null;
		var user_log_search_date="";
		var user_groups_search=null;
		var user_aktif_search=null;

		//if(user_idSearchField.getValue()!==null){user_id_search=user_idSearchField.getValue();}
		//if(user_nameSearchField.getValue()!==null){user_name_search=user_nameSearchField.getValue();}
		//if(user_passwdSearchField.getValue()!==null){user_passwd_search=user_passwdSearchField.getValue();}
		//if(user_karyawanSearchField.getValue()!==null){user_karyawan_search=user_karyawanSearchField.getValue();}
		//if(user_logSearchField.getValue()!==""){user_log_search_date=user_logSearchField.getValue().format('Y-m-d');}
		//if(user_groupsSearchField.getValue()!==null){user_groups_search=user_groupsSearchField.getValue();}
		//if(user_aktifSearchField.getValue()!==null){user_aktif_search=user_aktifSearchField.getValue();}
		// change the store parameters
		ptindakan_terapis_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			user_id	:	user_id_search, 
			user_name	:	user_name_search, 
			user_passwd	:	user_passwd_search, 
			user_karyawan	:	user_karyawan_search, 
			user_log	:	user_log_search_date, 
			user_groups	:	user_groups_search, 
			user_aktif	:	user_aktif_search 
};
		// Cause the datastore to do another query : 
		ptindakan_terapis_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function users_reset_search(){
		// reset the store parameters
		ptindakan_terapis_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		ptindakan_terapis_DataStore.reload({params: {start: 0, limit: pageS}});
		ptindakan_terapis_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  user_id Search Field */
	/*user_idSearchField= new Ext.form.NumberField({
		id: 'user_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});*/
	/* Identify  user_name Search Field */
	/*user_nameSearchField= new Ext.form.TextField({
		id: 'user_nameSearchField',
		fieldLabel: 'User Name',
		maxLength: 50,
		anchor: '95%'
	
	});*/
	
	/* Identify  user_karyawan Search Field */
	/*user_karyawanSearchField= new Ext.form.ComboBox({
		id: 'user_karyawanSearchField',
		fieldLabel: 'Nama Karyawan',
		store: cbo_user_search_karyawanDataStore,
		mode: 'remote',
		displayField:'karyawan_nama',
		valueField: 'karyawan_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: user_karyawan_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});*/
	/* Identify  user_log Search Field */
	/*user_logSearchField= new Ext.form.DateField({
		id: 'user_logSearchField',
		fieldLabel: 'Last Log',
		format : 'Y-m-d'
	
	});*/
	/* Identify  user_groups Search Field */
	/*user_groupsSearchField= new Ext.form.NumberField({
		id: 'user_groupsSearchField',
		fieldLabel: 'Group',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});*/
	/* Identify  user_aktif Search Field */
	/*user_aktifSearchField= new Ext.form.ComboBox({
		id: 'user_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'user_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'user_aktif',
		valueField: 'value',
		width: 80,
		triggerAction: 'all'	 
	
	});*/
    
	/* Function for retrieve search Form Panel */
	ptindakan_terapis_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 350,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: users_list_search
			},{
				text: 'Close',
				handler: function(){
					ptindakan_terapis_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	ptindakan_terapis_searchWindow = new Ext.Window({
		title: 'users Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_users_search',
		items: ptindakan_terapis_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!ptindakan_terapis_searchWindow.isVisible()){
			ptindakan_terapis_searchWindow.show();
		} else {
			ptindakan_terapis_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function users_print(){
		var searchquery = "";
		var user_name_print=null;
		var user_karyawan_print=null;
		var user_log_print_date="";
		var user_groups_print=null;
		var user_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(ptindakan_terapis_DataStore.baseParams.query!==null){searchquery = ptindakan_terapis_DataStore.baseParams.query;}
		if(ptindakan_terapis_DataStore.baseParams.user_name!==null){user_name_print = ptindakan_terapis_DataStore.baseParams.user_name;}
		if(ptindakan_terapis_DataStore.baseParams.user_karyawan!==null){user_karyawan_print = ptindakan_terapis_DataStore.baseParams.user_karyawan;}
		if(ptindakan_terapis_DataStore.baseParams.user_log!==""){user_log_print_date = ptindakan_terapis_DataStore.baseParams.user_log;}
		if(ptindakan_terapis_DataStore.baseParams.user_groups!==null){user_groups_print = ptindakan_terapis_DataStore.baseParams.user_groups;}
		if(ptindakan_terapis_DataStore.baseParams.user_aktif!==null){user_aktif_print = ptindakan_terapis_DataStore.baseParams.user_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_penyesuaian_tindakan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			user_name : user_name_print,
			user_karyawan : user_karyawan_print,
		  	user_log : user_log_print_date, 
			user_groups : user_groups_print,
			user_aktif : user_aktif_print,
		  	currentlisting: ptindakan_terapis_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./userslist.html','userslist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function users_export_excel(){
		var searchquery = "";
		var user_name_2excel=null;
		var user_karyawan_2excel=null;
		var user_log_2excel_date="";
		var user_groups_2excel=null;
		var user_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(ptindakan_terapis_DataStore.baseParams.query!==null){searchquery = ptindakan_terapis_DataStore.baseParams.query;}
		if(ptindakan_terapis_DataStore.baseParams.user_name!==null){user_name_2excel = ptindakan_terapis_DataStore.baseParams.user_name;}
		if(ptindakan_terapis_DataStore.baseParams.user_karyawan!==null){user_karyawan_2excel = ptindakan_terapis_DataStore.baseParams.user_karyawan;}
		if(ptindakan_terapis_DataStore.baseParams.user_log!==""){user_log_2excel_date = ptindakan_terapis_DataStore.baseParams.user_log;}
		if(ptindakan_terapis_DataStore.baseParams.user_groups!==null){user_groups_2excel = ptindakan_terapis_DataStore.baseParams.user_groups;}
		if(ptindakan_terapis_DataStore.baseParams.user_aktif!==null){user_aktif_2excel = ptindakan_terapis_DataStore.baseParams.user_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_penyesuaian_tindakan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			user_name : user_name_2excel,
			user_karyawan : user_karyawan_2excel,
		  	user_log : user_log_2excel_date, 
			user_groups : user_groups_2excel,
			user_aktif : user_aktif_2excel,
		  	currentlisting: ptindakan_terapis_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_users"></div>
		<div id="elwindow_users_create"></div>
        <div id="elwindow_users_search"></div>
    </div>
</div>
</body>
