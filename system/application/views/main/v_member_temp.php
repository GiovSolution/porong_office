<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member_temp View
	+ Description	: For record view
	+ Filename 		: v_member_temp.php
 	+ creator  		: 
 	+ Created on 22/Apr/2010 10:01:41
	
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
var member_temp_DataStore;
var member_temp_ColumnModel;
var member_tempListEditorGrid;
var member_temp_saveForm;
var member_temp_saveWindow;
var member_temp_searchForm;
var member_temp_SelectedRow;

//declare konstant
var mtemp_post2db = '';
var msg = '';
var mtemp_pageS=15;

/* declare variable here for Field*/
var membert_idField;
var membert_custField;
var membert_noField;
var membert_registerField;
var membert_validField;
var membert_jenisField;
var membert_statusField;
var membert_idSearchField;
var membert_custSearchField;
var membert_noSearchField;
var membert_registerSearchField;
var membert_validSearchField;
var membert_jenisSearchField;
var membert_statusSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function member_temp_inline_update(oGrid_event){
		var membert_id_update_pk="";
		var membert_cust_update=null;
		var membert_no_update=null;
		var membert_register_update_date="";
		var membert_valid_update_date="";
		var membert_jenis_update=null;
		var membert_status_update=null;
		var membert_check_daftar_update=null;

		membert_id_update_pk = oGrid_event.record.data.membert_id;
		if(oGrid_event.record.data.membert_cust!== null){membert_cust_update = oGrid_event.record.data.membert_cust;}
		if(oGrid_event.record.data.membert_no!== null){membert_no_update = oGrid_event.record.data.membert_no;}
	 	if(oGrid_event.record.data.membert_register!== ""){membert_register_update_date =oGrid_event.record.data.membert_register.format('Y-m-d');}
	 	if(oGrid_event.record.data.membert_valid!== ""){membert_valid_update_date =oGrid_event.record.data.membert_valid.format('Y-m-d');}
		if(oGrid_event.record.data.membert_jenis!== null){membert_jenis_update = oGrid_event.record.data.membert_jenis;}
		if(oGrid_event.record.data.membert_status!== null){membert_status_update = oGrid_event.record.data.membert_status;}
		membert_check_daftar_update = oGrid_event.record.data.membert_check_daftar;

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_member_temp&m=get_action',
			params: {
				membert_id	: membert_id_update_pk, 
				membert_cust	:membert_cust_update,
				membert_no	:membert_no_update,
				membert_register	: membert_register_update_date, 
				membert_valid	: membert_valid_update_date, 
				membert_jenis	:membert_jenis_update,
				membert_status	:membert_status_update,
				membert_check_daftar 	: membert_check_daftar_update,
				task: "UPDATE"
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						member_temp_DataStore.commitChanges();
						member_temp_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not save the Member Temp.',
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
	function member_temp_save(){
	
		if(is_member_temp_form_valid()){	
			var membert_id_field_pk=null; 
			var membert_cust_field=null; 
			var membert_no_field=null; 
			var membert_register_field_date=""; 
			var membert_valid_field_date=""; 
			var membert_jenis_field=null; 
			var membert_status_field=null; 

			membert_id_field_pk=get_pk_id();
			if(membert_custField.getValue()!== null){membert_cust_field = membert_custField.getValue();} 
			if(membert_noField.getValue()!== null){membert_no_field = membert_noField.getValue();} 
			if(membert_registerField.getValue()!== ""){membert_register_field_date = membert_registerField.getValue().format('Y-m-d');} 
			if(membert_validField.getValue()!== ""){membert_valid_field_date = membert_validField.getValue().format('Y-m-d');} 
			if(membert_jenisField.getValue()!== null){membert_jenis_field = membert_jenisField.getValue();} 
			if(membert_statusField.getValue()!== null){membert_status_field = membert_statusField.getValue();} 

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_member_temp&m=get_action',
				params: {
					membert_id	: membert_id_field_pk, 
					membert_cust	: membert_cust_field, 
					membert_no	: membert_no_field, 
					membert_register	: membert_register_field_date, 
					membert_valid	: membert_valid_field_date, 
					membert_jenis	: membert_jenis_field, 
					membert_status	: membert_status_field, 
					task: mtemp_post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(mtemp_post2db+' OK','The Member Temp was '+mtemp_post2db+' successfully.');
							member_temp_DataStore.reload();
							member_temp_saveWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the Member Temp.',
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
		if(mtemp_post2db=='UPDATE')
			return member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function member_temp_reset_form(){
		membert_custField.reset();
		membert_custField.setValue(null);
		membert_noField.reset();
		membert_noField.setValue(null);
		membert_registerField.reset();
		membert_registerField.setValue(null);
		membert_validField.reset();
		membert_validField.setValue(null);
		membert_jenisField.reset();
		membert_jenisField.setValue(null);
		membert_statusField.reset();
		membert_statusField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function member_temp_set_form(){
		membert_custField.setValue(member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_cust'));
		membert_noField.setValue(member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_no'));
		membert_registerField.setValue(member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_register'));
		membert_validField.setValue(member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_valid'));
		membert_jenisField.setValue(member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_jenis'));
		membert_statusField.setValue(member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_status'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_member_temp_form_valid(){
		return (true &&  membert_custField.isValid() && membert_noField.isValid() && true &&  true &&  true &&  true  );
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function member_temp_delete(btn){
		if(btn=='yes'){
			var selections = member_tempListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< member_tempListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.membert_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_member_temp&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							member_temp_DataStore.reload();
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
	member_temp_DataStore = new Ext.data.Store({
		id: 'member_temp_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_member_temp&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'membert_id'
		},[
		/* dataIndex => insert intomember_temp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'membert_id', type: 'int', mapping: 'membert_id'}, 
			{name: 'membert_cust', type: 'int', mapping: 'membert_cust'}, 
			{name: 'membert_cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'membert_cust_nama', type: 'string', mapping: 'cust_nama'}, 
			{name: 'membert_no', type: 'string', mapping: 'membert_no'}, 
			{name: 'member_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_valid'}, 
			{name: 'membert_register', type: 'date', dateFormat: 'Y-m-d', mapping: 'membert_register'}, 
			{name: 'membert_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'membert_valid'}, 
			{name: 'membert_jenis', type: 'string', mapping: 'membert_jenis'}, 
			{name: 'membert_status', type: 'string', mapping: 'membert_status'},
			{name: 'membert_check_daftar', type: 'string', mapping: 'membert_check_daftar'}
		]),
		sortInfo:{field: 'membert_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	member_temp_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'membert_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'membert_cust_no',
			width: 60,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'membert_cust_nama',
			width: 200,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'membert_no',
			width: 100,
			sortable: true,
			renderer: function(value, cell, record){
				return value.substring(0,6) + '-' + value.substring(6,12) + '-' + value.substring(12);
			}
		}, 
		{
			header: '<div align="center">' + 'Member Valid' + '</div>',
			dataIndex: 'member_valid',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		}, 
		{
			header: '<div align="center">' + 'Tgl Daftar' + '</div>',
			dataIndex: 'membert_register',
			width: 70,
			sortable: true,
			hidden: true, //krn sptnya tidak berguna
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		}, 
		{
			header: '<div align="center">' + 'Tgl Valid' + '</div>',
			dataIndex: 'membert_valid',
			width: 70,
			sortable: true,
			hidden: true, //krn sptnya tidak berguna
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		}, 
		{
			header: '<div align="center">' + 'Jenis' + '</div>',
			dataIndex: 'membert_jenis',
			width: 80,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'membert_status',
			width: 80,
			hidden: true, //krn sptnya tidak berguna
			sortable: true
		},
		{
			xtype: 'booleancolumn',
			header: 'Daftarkan',
			dataIndex: 'membert_check_daftar',
			width: 60,	//65,
			align: 'center',
			trueText: 'Yes',
			falseText: 'No',
			editor: {
                xtype: 'checkbox'
            }
		} ]);
	
	member_temp_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	member_tempListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'member_tempListEditorGrid',
		el: 'fp_member_temp',
		title: 'Pendaftaran Member',
		autoHeight: true,
		store: member_temp_DataStore, // DataStore
		cm: member_temp_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: mtemp_pageS,
			store: member_temp_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		
			new Ext.app.SearchField({
			store: member_temp_DataStore,
			params: {task: 'LIST',start: 0, limit: mtemp_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						member_temp_DataStore.baseParams={task:'LIST',start: 0, limit: mtemp_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search by'});
				Ext.get(this.id).set({qtip:'- No Customer<br>- Nama Customer'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: member_temp_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Cetak Formulir',
			tooltip: 'Cetak Formulir Pendaftaran Miracle Member Card',
			handler: member_temp_print_form,
			iconCls:'icon-print'
		}
		]
	});
	member_tempListEditorGrid.render();
	/* End of DataStore */
     	
	/* function for editing row via context menu */
	function member_temp_editContextMenu(){
		//member_tempListEditorGrid.startEditing(member_temp_SelectedRow,1);
  	}
	/* End of Function */
  	
	member_temp_DataStore.load({params: {start: 0, limit: mtemp_pageS}});	// load DataStore
	member_tempListEditorGrid.on('afteredit', member_temp_inline_update); // inLine Editing Record
	
	/* Identify  membert_cust Field */
	membert_custField= new Ext.form.NumberField({
		id: 'membert_custField',
		fieldLabel: 'Membert Cust',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  membert_no Field */
	membert_noField= new Ext.form.TextField({
		id: 'membert_noField',
		fieldLabel: 'Membert No',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  membert_register Field */
	membert_registerField= new Ext.form.DateField({
		id: 'membert_registerField',
		fieldLabel: 'Membert Register',
		format : 'Y-m-d',
	});
	/* Identify  membert_valid Field */
	membert_validField= new Ext.form.DateField({
		id: 'membert_validField',
		fieldLabel: 'Membert Valid',
		format : 'Y-m-d',
	});
	/* Identify  membert_jenis Field */
	membert_jenisField= new Ext.form.ComboBox({
		id: 'membert_jenisField',
		fieldLabel: 'Membert Jenis',
		store:new Ext.data.SimpleStore({
			fields:['membert_jenis_value', 'membert_jenis_display'],
			data:[['perpanjangan','perpanjangan'],['baru','baru']]
		}),
		mode: 'local',
		displayField: 'membert_jenis_display',
		valueField: 'membert_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  membert_status Field */
	membert_statusField= new Ext.form.ComboBox({
		id: 'membert_statusField',
		fieldLabel: 'Membert Status',
		store:new Ext.data.SimpleStore({
			fields:['membert_status_value', 'membert_status_display'],
			data:[['Daftar','Daftar'],['Cetak','Cetak'],['Aktif','Aktif']]
		}),
		mode: 'local',
		displayField: 'membert_status_display',
		valueField: 'membert_status_value',
		anchor: '95%',
		triggerAction: 'all'	
	});

	
	/* Function for retrieve create Window Panel*/ 
	member_temp_saveForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [membert_custField, membert_noField, membert_registerField, membert_validField, membert_jenisField, membert_statusField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: member_temp_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					member_temp_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	member_temp_saveWindow= new Ext.Window({
		id: 'member_temp_saveWindow',
		title: mtemp_post2db+'Member Temp',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_member_temp_save',
		items: member_temp_saveForm
	});
	/* End Window */
	
	/* Function for reset search result */
	function member_temp_reset_search(){
		// reset the store parameters
		member_temp_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		member_temp_DataStore.reload({params: {start: 0, limit: mtemp_pageS}});
	};
	/* End of Fuction */
	
	/* Function for print List Grid */
	function member_temp_print_form(){
		if(member_tempListEditorGrid.selModel.getCount() == 1) {
			var searchquery = "";
			var member_cust_print=null;
			var win;              
			// check if we do have some search data...
			if(member_temp_DataStore.baseParams.query!==null){searchquery = member_temp_DataStore.baseParams.query;}
			if(member_temp_DataStore.baseParams.cabang_nama!==null){member_cust_print = member_tempListEditorGrid.getSelectionModel().getSelected().get('membert_cust');}
		
			Ext.Ajax.request({   
			waitMsg: 'Please Wait...',
			url: 'index.php?c=c_member_temp&m=get_action',
			params: {
				task			: "PRINT_MEMBER",
				query			: searchquery,                    		
				membert_cust	: member_cust_print,
				currentlisting	: member_temp_DataStore.baseParams.task // this tells us if we are searching or not
			}, 
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					win = window.open('./print/member_temp_printlist.html','memberlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
					
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
	/* Enf Function */
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_member_temp"></div>
		<div id="elwindow_member_temp_save"></div>
        <div id="elwindow_member_temp_search"></div>
    </div>
</div>
</body>