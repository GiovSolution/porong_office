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
var users_DataStore;
var users_ColumnModel;
var usersListEditorGrid;
var users_createForm;
var users_createWindow;
var users_searchForm;
var users_searchWindow;
var users_SelectedRow;
var users_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var user_idField;
var user_nameField;
var user_passwdField;
var user_karyawanField;
var user_logField;
var user_groupsField;
var user_aktifField;
var user_idSearchField;
var user_nameSearchField;
var user_passwdSearchField;
var user_karyawanSearchField;
var user_logSearchField;
var user_groupsSearchField;
var user_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function users_update(oGrid_event){
	var user_id_update_pk="";
	var user_name_update=null;
	//var user_passwd_update=null;
	var user_karyawan_update=null;
	var user_log_update_date="";
	var user_groups_update=null;
	var user_aktif_update=null;

	if(oGrid_event.record.data.user_id!== null){user_id_update = oGrid_event.record.data.user_id;}
	if(oGrid_event.record.data.user_name!== null){user_name_update = oGrid_event.record.data.user_name;}
	//if(oGrid_event.record.data.user_passwd!== null){user_passwd_update = oGrid_event.record.data.user_passwd;}
	if(oGrid_event.record.data.user_karyawan!== null){user_karyawan_update = oGrid_event.record.data.user_karyawan;}
	//if(oGrid_event.record.data.user_log!== ""){user_log_update_date = oGrid_event.record.data.user_log.format('Y-m-d');}
	if(oGrid_event.record.data.user_groups!== null){user_groups_update = oGrid_event.record.data.user_groups;}
	if(oGrid_event.record.data.user_aktif!== null){user_aktif_update = oGrid_event.record.data.user_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_users&m=get_action',
			params: {
				task: "UPDATE",
				user_id			: user_id_update,				
				user_name		: user_name_update,		
				//user_passwd	:user_passwd_update,		
				user_karyawan	: user_karyawan_update,		
				//user_log		: user_log_update_date,				
				user_groups		: user_groups_update,		
				user_aktif		: user_aktif_update		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						users_DataStore.commitChanges();
						users_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   //msg: 'We could\'t not save the users.',
							   msg: 'Data user tidak dapat disimpan',
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
	function users_create(){
		if(is_users_form_valid()){
		
		var user_id_create_pk=null;
		var user_name_create=null;
		var user_passwd_create=null;
		var user_karyawan_create=null;
		var user_groups_create=null;
		var user_aktif_create=null;

		user_id_create_pk=get_pk_id();
		if(user_nameField.getValue()!== null){user_name_create = user_nameField.getValue();}
		if(user_passwdField.getValue()!== null){user_passwd_create = user_passwdField.getValue();}
		if(user_karyawanField.getValue()!== null){user_karyawan_create = user_karyawanField.getValue();}
		if(user_groupsField.getValue()!== null){user_groups_create = user_groupsField.getValue();}
		if(user_aktifField.getValue()!== null){user_aktif_create = user_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_users&m=get_action',
				params: {
					task			: post2db,
					user_id			: user_id_create_pk,	
					user_name		: user_name_create,	
					user_passwd		: user_passwd_create,	
					user_karyawan	: user_karyawan_create,			
					user_groups		: user_groups_create,	
					user_aktif		: user_aktif_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							//Ext.MessageBox.alert(post2db+' OK','The Users was '+msg+' successfully.');
							Ext.MessageBox.alert(post2db+' OK', 'Data user berhasil disimpan');
							users_DataStore.reload();
							users_createWindow.hide();
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
				//msg: 'Isian belum sempurna!.',
				msg: 'Form anda belum lengkap',
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
			return usersListEditorGrid.getSelectionModel().getSelected().get('user_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function users_reset_form(){
		user_nameField.reset();
		user_nameField.setValue(null);
		user_passwdField.reset();
		user_passwdField.setValue(null);
		user_karyawanField.reset();
		user_karyawanField.setValue(null);
		user_groupsField.reset();
		user_groupsField.setValue(null);
		user_aktifField.reset();
		user_aktifField.setValue('Aktif');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function users_set_form(){
		user_nameField.setValue(usersListEditorGrid.getSelectionModel().getSelected().get('user_name'));
		//user_passwdField.setValue('******');
		user_karyawanField.setValue(usersListEditorGrid.getSelectionModel().getSelected().get('user_karyawan'));
		user_logField.setValue(usersListEditorGrid.getSelectionModel().getSelected().get('user_log'));
		user_groupsField.setValue(usersListEditorGrid.getSelectionModel().getSelected().get('user_groups'));
		user_aktifField.setValue(usersListEditorGrid.getSelectionModel().getSelected().get('user_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_users_form_valid(){
		return (user_nameField.isValid() && user_groupsField.isValid() && user_karyawanField.isValid() && user_aktifField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!users_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			users_reset_form();
			
			users_createWindow.show();
		} else {
			users_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function users_confirm_delete(){
		// only one users is selected here
		if(usersListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', users_delete);
			//Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', users_delete);
		} else if(usersListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', users_delete);
			//Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', users_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				//msg: 'Anda belum memilih data yang akan dihapus',
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
		if(usersListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			users_set_form();
			
			users_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				//msg: 'Anda belum memilih data yang akan diubah',
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
			var selections = usersListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< usersListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.user_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_users&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							users_DataStore.reload();
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
	users_DataStore = new Ext.data.Store({
		id: 'users_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_users&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'user_id'
		},[
			{name: 'user_id', type: 'int', mapping: 'user_id'},
			{name: 'user_name', type: 'string', mapping: 'user_name'},
			{name: 'user_passwd', type: 'string', mapping: 'user_passwd'},
			{name: 'user_karyawan', type: 'string', mapping: 'karyawan_nama'},
			{name: 'user_groups', type: 'string', mapping: 'group_name'},
			{name: 'user_aktif', type: 'string', mapping: 'user_aktif'}
		]),
		sortInfo:{field: 'user_id', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_user_karyawanDataStore = new Ext.data.Store({
		id: 'cbo_user_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_users&m=get_karyawan_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'}
		]),
		sortInfo:{field: 'karyawan_no', direction: "ASC"}
	});
	
	cbo_user_search_karyawanDataStore = new Ext.data.Store({
		id: 'cbo_user_search_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_users&m=get_user_karyawan_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
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
	
	
	cbo_user_groupDataStore = new Ext.data.Store({
	id: 'cbo_user_groupDataStore',
	proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_users&m=get_usergroups_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
			{name: 'user_group_value', type: 'int', mapping: 'group_id'},
			{name: 'user_group_display', type: 'string', mapping: 'group_name'}
		]),
	sortInfo:{field: 'user_group_display', direction: "ASC"}
	});
    
  	/* Function for Identify of Window Column Model */
	users_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'user_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'User Name' + '</div>',
			dataIndex: 'user_name',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Nama Karyawan' + '</div>',
			dataIndex: 'user_karyawan',
			width: 200,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Group' + '</div>',
			dataIndex: 'user_groups',
			width: 200,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
			,
			editor: new Ext.form.ComboBox({
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
			})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'user_aktif',
			width: 80,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['user_aktif_value', 'user_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
				editable:false,
               	displayField: 'user_aktif_display',
               	valueField: 'user_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		}]
	);
	users_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	usersListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'usersListEditorGrid',
		el: 'fp_users',
		title: 'Daftar User',
		autoHeight: true,
		store: users_DataStore, // DataStore
		cm: users_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: users_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: users_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: users_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: users_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: users_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: users_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: users_print  
		}
		]
	});
	usersListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	users_ContextMenu = new Ext.menu.Menu({
		id: 'users_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: users_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: users_confirm_delete 
		},
		<?php } ?>
		'-',
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
		users_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		users_SelectedRow=rowIndex;
		users_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function users_editContextMenu(){
      usersListEditorGrid.startEditing(users_SelectedRow,1);
  	}
	/* End of Function */
  	
	usersListEditorGrid.addListener('rowcontextmenu', onusers_ListEditGridContextMenu);
	users_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	usersListEditorGrid.on('afteredit', users_update); // inLine Editing Record
	
	/* Identify  user_name Field */
	user_nameField= new Ext.form.TextField({
		id: 'user_nameField',
		fieldLabel: 'User Name',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});

	/* Identify  user_passwd Field */
	user_passwdField= new Ext.form.TextField({
		id: 'user_passwdField',
		fieldLabel: 'Password',
		maxLength: 50,
		anchor: '95%',
		inputType: 'password'
	});

		/* Identify  user_karyawan Field */
	user_karyawanField= new Ext.form.ComboBox({
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
	});
	/* Identify  user_log Field */
	user_logField= new Ext.form.DateField({
		id: 'user_logField',
		fieldLabel: 'Last Log',
		format : 'Y-m-d',
		readOnly: true,
		hideTrigger: true
	});
	/* Identify  user_groups Field */
	user_groupsField= new Ext.form.ComboBox({
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
		allowBlank: false,
		listClass: 'x-combo-list-small'
	});
	/* Identify  user_aktif Field */
	user_aktifField= new Ext.form.ComboBox({
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
	});
  	
	/* Function for retrieve create Window Panel*/ 
	users_createForm = new Ext.FormPanel({
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
				border:false,
				items: [user_nameField, user_passwdField, user_karyawanField, user_groupsField, user_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_USER'))){ ?>
			{
				text: 'Save and Close',
				handler: users_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					users_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	users_createWindow= new Ext.Window({
		id: 'users_createWindow',
		title: post2db+' User',
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
		items: users_createForm
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

		if(user_idSearchField.getValue()!==null){user_id_search=user_idSearchField.getValue();}
		if(user_nameSearchField.getValue()!==null){user_name_search=user_nameSearchField.getValue();}
		if(user_karyawanSearchField.getValue()!==null){user_karyawan_search=user_karyawanSearchField.getValue();}
		if(user_logSearchField.getValue()!==""){user_log_search_date=user_logSearchField.getValue().format('Y-m-d');}
		if(user_groupsSearchField.getValue()!==null){user_groups_search=user_groupsSearchField.getValue();}
		if(user_aktifSearchField.getValue()!==null){user_aktif_search=user_aktifSearchField.getValue();}
		// change the store parameters
		users_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			user_id			:	user_id_search, 
			user_name		:	user_name_search, 
			user_karyawan	:	user_karyawan_search, 
			user_log		:	user_log_search_date, 
			user_groups		:	user_groups_search, 
			user_aktif		:	user_aktif_search 
		};
		// Cause the datastore to do another query : 
		users_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function users_reset_search(){
		// reset the store parameters
		users_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		users_DataStore.reload({params: {start: 0, limit: pageS}});
		users_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  user_id Search Field */
	user_idSearchField= new Ext.form.NumberField({
		id: 'user_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  user_name Search Field */
	user_nameSearchField= new Ext.form.TextField({
		id: 'user_nameSearchField',
		fieldLabel: 'Username',
		maxLength: 50,
		anchor: '95%'
	
	});
	
	/* Identify  user_karyawan Search Field */
	user_karyawanSearchField= new Ext.form.ComboBox({
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
	});
	/* Identify  user_log Search Field */
	user_logSearchField= new Ext.form.DateField({
		id: 'user_logSearchField',
		fieldLabel: 'Last Log',
		format : 'Y-m-d'
	
	});
	/* Identify  user_groups Search Field */
	user_groupsSearchField= new Ext.form.ComboBox({
		id: 'user_groupsSearchField',
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
		allowBlank: false,
		listClass: 'x-combo-list-small'
	
	});
	/* Identify  user_aktif Search Field */
	user_aktifSearchField= new Ext.form.ComboBox({
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
	
	});
    
	/* Function for retrieve search Form Panel */
	users_searchForm = new Ext.FormPanel({
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
				border:false,
				items: [user_nameSearchField, user_karyawanSearchField, user_groupsSearchField, user_aktifSearchField] 
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
					users_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	users_searchWindow = new Ext.Window({
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
		items: users_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!users_searchWindow.isVisible()){
			users_searchWindow.show();
		} else {
			users_searchWindow.toFront();
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
		if(users_DataStore.baseParams.query!==null){searchquery = users_DataStore.baseParams.query;}
		if(users_DataStore.baseParams.user_name!==null){user_name_print = users_DataStore.baseParams.user_name;}
		if(users_DataStore.baseParams.user_karyawan!==null){user_karyawan_print = users_DataStore.baseParams.user_karyawan;}
		if(users_DataStore.baseParams.user_log!==""){user_log_print_date = users_DataStore.baseParams.user_log;}
		if(users_DataStore.baseParams.user_groups!==null){user_groups_print = users_DataStore.baseParams.user_groups;}
		if(users_DataStore.baseParams.user_aktif!==null){user_aktif_print = users_DataStore.baseParams.user_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_users&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			user_name : user_name_print,
			user_karyawan : user_karyawan_print,
		  	user_log : user_log_print_date, 
			user_groups : user_groups_print,
			user_aktif : user_aktif_print,
		  	currentlisting: users_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./userslist.html','userslist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function users_export_excel(){
		var searchquery = "";
		var user_name_2excel=null;
		var user_karyawan_2excel=null;
		var user_log_2excel_date="";
		var user_groups_2excel=null;
		var user_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(users_DataStore.baseParams.query!==null){searchquery = users_DataStore.baseParams.query;}
		if(users_DataStore.baseParams.user_name!==null){user_name_2excel = users_DataStore.baseParams.user_name;}
		if(users_DataStore.baseParams.user_karyawan!==null){user_karyawan_2excel = users_DataStore.baseParams.user_karyawan;}
		if(users_DataStore.baseParams.user_log!==""){user_log_2excel_date = users_DataStore.baseParams.user_log;}
		if(users_DataStore.baseParams.user_groups!==null){user_groups_2excel = users_DataStore.baseParams.user_groups;}
		if(users_DataStore.baseParams.user_aktif!==null){user_aktif_2excel = users_DataStore.baseParams.user_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_users&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			user_name : user_name_2excel,
			user_karyawan : user_karyawan_2excel,
		  	user_log : user_log_2excel_date, 
			user_groups : user_groups_2excel,
			user_aktif : user_aktif_2excel,
		  	currentlisting: users_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_users"></div>
		<div id="elwindow_users_create"></div>
        <div id="elwindow_users_search"></div>
    </div>
</div>
</body>
