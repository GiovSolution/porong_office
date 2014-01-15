<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member View
	+ Description	: For record view
	+ Filename 		: v_member.php
 	+ Author  		: 
 	+ Created on 01/Sep/2009 10:36:44
	
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
var member_DataStore;
var member_ColumnModel;
var memberListEditorGrid;
var member_createForm;
var member_createWindow;
var member_searchForm;
var member_searchWindow;
var member_SelectedRow;
var member_ContextMenu;
//for detail data
var _DataStor;
var ListEditorGrid;
var _ColumnModel;
var _proxy;
var _writer;
var _reader;
var editor_;

//declare konstant
var member_post2db = '';
var msg = '';
var member_pageS=15;

/* declare variable here for Field*/
var member_idField;
var member_custField;
var member_noField;
var member_registerField;
var member_validField;
var member_nota_refField;
var member_pointField;
var member_jenisField;
var member_statusField;
var member_tglcetakField;
//var member_tglserahterimaField;
var member_idSearchField;
var member_custSearchField;
var member_noSearchField;
var member_registerSearchField;
var member_register_endSearchField;
var member_validSearchField;
var member_valid_endSearchField;
var member_nota_refSearchField;
var member_pointSearchField;
var member_jenisSearchField;
var member_statusSearchField;
var member_tglcetakSearchField;
var member_tglcetak_endSearchField;
//var member_tglserahterimaSearchField;
//var member_tglserahterima_endSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function member_update(oGrid_event){
		var member_id_update_pk="";
		var member_cust_update=null;
		var member_no_update=null;
		var member_register_update_date="";
		var member_valid_update_date="";
		var member_nota_ref_update=null;
		var member_point_update=null;
		var member_jenis_update=null;
		var member_status_update=null;
		var member_tglserahterima_update_date="";
		
		member_id_update_pk = oGrid_event.record.data.member_id;
		if(oGrid_event.record.data.member_cust!== null){member_cust_update = oGrid_event.record.data.member_cust;}
		if(oGrid_event.record.data.member_no!== null){member_no_update = oGrid_event.record.data.member_no;}
	 	if(oGrid_event.record.data.member_register!== ""){member_register_update_date =oGrid_event.record.data.member_register.format('Y-m-d');}
	 	if(oGrid_event.record.data.member_valid!== ""){member_valid_update_date =oGrid_event.record.data.member_valid.format('Y-m-d');}
		if(oGrid_event.record.data.member_nota_ref!== null){member_nota_ref_update = oGrid_event.record.data.member_nota_ref;}
		if(oGrid_event.record.data.member_point!== null){member_point_update = oGrid_event.record.data.member_point;}
		if(oGrid_event.record.data.member_jenis!== null){member_jenis_update = oGrid_event.record.data.member_jenis;}
		if(oGrid_event.record.data.member_status!== null){member_status_update = oGrid_event.record.data.member_status;}
	 	//if(oGrid_event.record.data.member_tglserahterima!== ""){member_tglserahterima_update_date =oGrid_event.record.data.member_tglserahterima.format('Y-m-d');}
		member_no_update = member_no_update.replace('-','','gi'); // untuk menghapus karakter '-' saat inLine edit, sehingga yg dibawa ke db hanya nomornya

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_member&m=get_action',
			params: {
				task: "UPDATE",
				member_id		: member_id_update_pk, 
				member_cust		: member_cust_update,  
				member_no		: member_no_update,  
				member_register	: member_register_update_date, 
				member_valid	: member_valid_update_date, 
				member_nota_ref	: member_nota_ref_update,  
				member_point	: member_point_update,  
				member_jenis	: member_jenis_update,  
				member_status	: member_status_update//,  
				//member_tglserahterima	: member_tglserahterima_update_date, 
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						member_DataStore.commitChanges();
						member_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not save the member.',
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
	function member_create(){
	
		if(is_member_form_valid()){	
		var member_id_create_pk=null; 
		var member_cust_create=null; 
		var member_no_create=null; 
		var member_register_create_date=""; 
		var member_valid_create_date=""; 
		var member_nota_ref_create=null; 
		var member_point_create=null; 
		var member_jenis_create=null; 
		var member_status_create=null; 
		var member_tglserahterima_create_date=""; 

		member_id_create_pk=get_pk_id(); 
		if(member_custField.getValue()!== null){member_cust_create = member_custField.getValue();} 
		if(member_noField.getValue()!== null){member_no_create = member_noField.getValue();} 
		if(member_registerField.getValue()!== ""){member_register_create_date = member_registerField.getValue().format('Y-m-d');} 
		if(member_validField.getValue()!== ""){member_valid_create_date = member_validField.getValue().format('Y-m-d');} 
		if(member_nota_refField.getValue()!== null){member_nota_ref_create = member_nota_refField.getValue();} 
		if(member_pointField.getValue()!== null){member_point_create = member_pointField.getValue();} 
		if(member_jenisField.getValue()!== null){member_jenis_create = member_jenisField.getValue();} 
		if(member_statusField.getValue()!== null){member_status_create = member_statusField.getValue();} 
		//if(member_tglserahterimaField.getValue()!== ""){member_tglserahterima_create_date = member_tglserahterimaField.getValue().format('Y-m-d');} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_member&m=get_action',
			params: {
				task			: member_post2db,
				member_id		: member_id_create_pk, 
				member_cust		: member_cust_create, 
				member_no		: member_no_create, 
				member_register	: member_register_create_date, 
				member_valid	: member_valid_create_date, 
				member_nota_ref	: member_nota_ref_create, 
				member_point	: member_point_create, 
				member_jenis	: member_jenis_create, 
				member_status	: member_status_create, 
				member_tglserahterima	: member_tglserahterima_create_date 
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(member_post2db+' OK','The Member was '+msg+' successfully.');
						member_DataStore.reload();
						member_createWindow.hide();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Member.',
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
	
	/* Function ADD member tanpa transaksi */
	function member_add(){
	
		if(is_member_form_valid()){	
		var member_add_cust_add=null;

		if(member_add_custField.getValue()!== null){member_add_cust_add = member_add_custField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_member&m=get_action',
			params: {
				task			: 'MEMBERADD',
				member_cust		: member_add_cust_add
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(' OK','The Member was add successfully.');
						member_DataStore.reload();
						member_addWindow.hide();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Member.',
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
		if(member_post2db=='UPDATE')
			return memberListEditorGrid.getSelectionModel().getSelected().get('member_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function member_reset_form(){
		member_idField.reset();
		member_idField.setValue(null);
		member_custField.reset();
		member_custField.setValue(null);
		member_noField.reset();
		member_noField.setValue(null);
		member_registerField.reset();
		member_registerField.setValue(null);
		member_validField.reset();
		member_validField.setValue(null);
		member_nota_refField.reset();
		member_nota_refField.setValue(null);
		member_pointField.reset();
		member_pointField.setValue(null);
		member_jenisField.reset();
		member_jenisField.setValue(null);
		member_statusField.reset();
		member_statusField.setValue(null);
		//member_tglserahterimaField.reset();
		//member_tglserahterimaField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function member_set_form(){
		member_idField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_id'));
		member_custField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_cust'));
		member_noField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_no'));
		member_registerField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_register'));
		member_validField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_valid'));
		member_nota_refField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_nota_ref'));
		member_pointField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_point'));
		member_jenisField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_jenis'));
		member_statusField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_status'));
		//member_tglserahterimaField.setValue(memberListEditorGrid.getSelectionModel().getSelected().get('member_tglserahterima'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_member_form_valid(){
		return ( true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!member_createWindow.isVisible()){
			member_post2db='CREATE';
			msg='created';
			member_reset_form();
			member_addWindow.show();
		} else {
			member_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function member_confirm_delete(){
		// only one member is selected here
		if(memberListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', member_delete);
		} else if(memberListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', member_delete);
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
	function member_confirm_update(){
		/* only one record is selected here */
		if(memberListEditorGrid.selModel.getCount() == 1) {
			member_post2db='UPDATE';
			msg='updated';
			member_set_form();
			member_createWindow.show();
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
	function member_delete(btn){
		if(btn=='yes'){
			var selections = memberListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< memberListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.member_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_member&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							member_DataStore.reload();
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
	member_DataStore = new Ext.data.Store({
		id: 'member_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_member&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: member_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'member_id'
		},[
		/* dataIndex => insert intomember_ColumnModel, Mapping => for initiate table column */ 
			{name: 'member_id', type: 'int', mapping: 'member_id'}, 
			{name: 'member_cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'member_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'member_no', type: 'string', mapping: 'member_no'}, 
			{name: 'member_register', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_register'}, 
			{name: 'member_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_valid'}, 
			{name: 'member_nota_ref', type: 'string', mapping: 'member_nota_ref'}, 
			{name: 'member_point', type: 'int', mapping: 'member_point'}, 
			{name: 'member_jenis', type: 'string', mapping: 'member_jenis'}, 
			{name: 'member_status', type: 'string', mapping: 'member_status'}, 
			{name: 'member_tglcetak', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_tglcetak'}, 
			//{name: 'member_tglserahterima', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_tglserahterima'}, 
			{name: 'member_creator', type: 'string', mapping: 'member_creator'}, 
			{name: 'member_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_date_create'}, 
			{name: 'member_update', type: 'string', mapping: 'member_update'}, 
			{name: 'member_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_date_update'}, 
			{name: 'member_revised', type: 'int', mapping: 'member_revised'} 
		]),
		//sortInfo:{field: 'member_id', direction: "DESC"}
	});
	/* End of Function */
	
	//ComboBox ambil data Customer
	member_add_customerDataStore = new Ext.data.Store({
		id: 'member_add_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_member&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var member_add_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br />Tgl Lahir: {cust_tgllahir:date("j M Y")}</span>',
            /*'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',*/
        '</div></tpl>'
    );
	
	var list_member_noField = new Ext.form.TextField({
		allowDecimals: false,
		allowNegative: false,
		allowBlank: false,
		blankText: '0',
		maxLength: 18,
		readOnly: false,
		maskRe: /([0-9, ]+)$/
	});
    
  	/* Function for Identify of Window Column Model */
	member_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'member_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">No Cust</div>',
			dataIndex: 'member_cust_no',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Customer</div>',
			dataIndex: 'member_cust',
			width: 200,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No Member</div>',
			dataIndex: 'member_no',
			width: 100,
			sortable: true,
			editor: list_member_noField
		}, 
		{
			header: '<div align="center">Tgl Daftar</div>',	//'<div align="center">Register</div>',
			dataIndex: 'member_register',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		{
			header: '<div align="center">Tgl Valid</div>',
			dataIndex: 'member_valid',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		{
			header: '<div align="center">Ref Nota</div>',
			dataIndex: 'member_nota_ref',
			width: 80,	//150,
			sortable: true,
			hidden: true,
			editor: new Ext.form.TextArea({
				maxLength: 250
          	})
		}, 
		{
			header: '<div align="center">Poin</div>',
			dataIndex: 'member_point',
			align: 'right',
			width: 60,
			sortable: true,
			hidden: true,
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
			header: '<div align="center">Jenis</div>',
			dataIndex: 'member_jenis',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Status</div>',
			dataIndex: 'member_status',
			width: 80,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['member_status_value', 'member_status_display'],
					//data: [['tidak aktif','tidak aktif'],['print','print'],['aktif','aktif'],['register','register']]
					//data: [['Daftar', 'Daftar'], ['Cetak', 'Cetak'], ['Serah Terima', 'Serah Terima']]
					data: [['Daftar', 'Daftar'], ['Cetak', 'Cetak']]
					}),
				mode: 'local',
               	displayField: 'member_status_display',
               	valueField: 'member_status_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		}, 
		{
			header: '<div align="center">Tgl Cetak</div>',
			dataIndex: 'member_tglcetak',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
/*		{
			header: '<div align="center">Tgl Penyerahan</div>',
			dataIndex: 'member_tglserahterima',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
*/		{
			header: 'Creator',
			dataIndex: 'member_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Create om',
			dataIndex: 'member_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'member_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Lat Update on',
			dataIndex: 'member_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'member_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	member_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	memberListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'memberListEditorGrid',
		el: 'fp_member',
		title: 'Daftar Cetak Member',
		autoHeight: true,
		store: member_DataStore, // DataStore
		cm: member_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//1024,
		bbar: new Ext.PagingToolbar({
			pageSize: member_pageS,
			store: member_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		/*{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: member_confirm_update   // Confirm before updating
		},'-',*/
		
/*		'-',{
			//text: 'Aktivasi',
			text: 'Serah Terima',
			//tooltip: 'Aktifkan Kartu Member yang statusnya cetak menjadi aktif',
			tooltip: 'Menyerahkan kartu member yang sudah tercetak',
			iconCls:'icon-valid',
			handler: member_aktivasi
		}, 
		'-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: member_confirm_delete   // Confirm before deleting
		}, 
*/
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: member_DataStore,
			params: {task: 'LIST',start: 0, limit: member_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						member_DataStore.baseParams={task:'LIST',start: 0, limit: member_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No Cust<br>- Nama Cust<br>- No Member'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: member_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: member_export_excel
		},
		/*'-', 
		{
			text: 'Print: Status Daftar',
			//tooltip: 'Aktifkan Member yang teregister dan set status masa pencetakan',
			tooltip: 'Cetak khusus yang masih berstatus Daftar',
			iconCls:'icon-print',
			//iconCls:'icon-aktivasi ',
			hidden : true,
			handler: member_cetak_kartu
		},*/
		'-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			//disabled : true,
			iconCls:'icon-print',
			handler: member_print  
		}
		]
	});
	memberListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	member_ContextMenu = new Ext.menu.Menu({
		id: 'member_ListEditorGridContextMenu',
		items: [
/*		{ 
			text: 'Serah Terima', tooltip: 'Penyerahan Member Card ke Customer', 
			iconCls:'icon-update',
			handler: member_aktivasi 
		},
*/		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: member_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: member_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: member_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmember_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		member_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		member_SelectedRow=rowIndex;
		member_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function member_editContextMenu(){
		memberListEditorGrid.startEditing(member_SelectedRow,1);
  	}
	/* End of Function */
  	
	memberListEditorGrid.addListener('rowcontextmenu', onmember_ListEditGridContextMenu);
	member_DataStore.load({params: {start: 0, limit: member_pageS}});	// load DataStore
	memberListEditorGrid.on('afteredit', member_update); // inLine Editing Record
	
	/* Identify  member_id Field */
	member_idField= new Ext.form.NumberField({
		id: 'member_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  member_cust Field */
	member_custField= new Ext.form.TextField({
		id: 'member_custField',
		fieldLabel: 'Customer',
		readOnly: true,
		anchor: '95%'
	});
	/* Identify  member_no Field */
	member_noField= new Ext.form.TextField({
		id: 'member_noField',
		fieldLabel: 'No Member',
		emptyText: '(auto)',
		maxLength: 50,
		allowBlank: false,
		readOnly: true,
		anchor: '95%'
	});
	/* Identify  member_register Field */
	member_registerField= new Ext.form.DateField({
		id: 'member_registerField',
		fieldLabel: 'Tanggal Daftar',
		format : 'd-m-Y',
		hideTrigger: true,
		readOnly: true
	});
	/* Identify  member_valid Field */
	member_validField= new Ext.form.DateField({
		id: 'member_validField',
		fieldLabel: 'Tanggal Valid',
		format : 'd-m-Y',
		hideTrigger: true,
		readOnly: true
	});
	/* Identify  member_nota_ref Field */
	member_nota_refField= new Ext.form.TextArea({
		id: 'member_nota_refField',
		fieldLabel: 'Referensi Nota Pembelian',
		maxLength: 50,
		anchor: '95%'
	});
	/* Identify  member_point Field */
	member_pointField= new Ext.form.NumberField({
		id: 'member_pointField',
		fieldLabel: 'Poin',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  member_jenis Field */
	member_jenisField= new Ext.form.ComboBox({
		id: 'member_jenisField',
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['member_jenis_value', 'member_jenis_display'],
			data:[['perpanjangan','perpanjangan'],['baru','baru']]
		}),
		mode: 'local',
		displayField: 'member_jenis_display',
		valueField: 'member_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  member_status Field */
	member_statusField= new Ext.form.ComboBox({
		id: 'member_statusField',
		fieldLabel: 'Status Kartu',
		store:new Ext.data.SimpleStore({
			fields:['member_status_value', 'member_status_display'],
			//data:[['tidak aktif','tidak aktif'],['print','print'],['aktif','aktif'],['register','register']]
			//data: [['Daftar', 'Daftar'], ['Cetak', 'Cetak'], ['Serah Terima', 'Serah Terima']]
			data: [['Daftar', 'Daftar'], ['Cetak', 'Cetak']]
		}),
		mode: 'local',
		displayField: 'member_status_display',
		valueField: 'member_status_value',
		anchor: '95%',
		triggerAction: 'all'	
	});

	member_tglcetakField= new Ext.form.DateField({
		id: 'member_tglcetakField',
		fieldLabel: 'Tanggal Cetak',
		format : 'Y-m-d'
	});
	
	/* Identify  member_tglserahterima Field */
/*	member_tglserahterimaField= new Ext.form.DateField({
		id: 'member_tglserahterimaField',
		fieldLabel: 'Tanggal Penyerahan',
		format : 'Y-m-d'
	});
*/
	/* Identify  member_add_customer Field */
	member_add_custField= new Ext.form.ComboBox({
		id: 'member_add_custField',
		fieldLabel: 'Customer',
		store: member_add_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: member_add_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		anchor: '95%',
		queryDelay:1200,
		listeners:{
			/*beforequery: function(qe){
	            delete qe.combo.lastQuery;
	        },*/
			specialkey: function(f,e){
				if(e.getKey() == e.ENTER){
					member_add_customerDataStore.load({params: {query:member_add_custField.getValue()}});
	            }
			},
			render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No.Customer<br>- Nama Customer<br>- No.Telp Rumah<br>- No.Telp Kantor<br>- No.HP'});
			}
		}
	});

	
	/* Function for retrieve create Window Panel*/ 
	member_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		layout: 'column',
		width: 800,        
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [member_custField, member_noField, member_registerField, member_validField,member_nota_refField] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [member_pointField, member_jenisField, member_statusField, //member_tglserahterimaField,
						member_idField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: member_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					member_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Panel*/ 
	member_addForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		layout: 'column',
		width: 400,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [member_add_custField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: member_add
			}
			,{
				text: 'Cancel',
				handler: function(){
					member_addWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	member_createWindow= new Ext.Window({
		id: 'member_createWindow',
		title: member_post2db+'Member',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_member_create',
		items: member_createForm
	});
	/* End Window */
	
	/* Function for retrieve create Window Form */
	member_addWindow= new Ext.Window({
		id: 'member_addWindow',
		title: 'Add Member',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_member_create',
		items: member_addForm
	});
	/* End Window */
	
	/* Function for action list search */
	function member_list_search(){
		// render according to a SQL date format.
		var member_id_search=null;
		var member_cust_search=null;
		var member_no_search=null;
		var member_register_search_date="";
		var member_register_end_search_date="";
		var member_valid_search_date="";
		var member_valid_end_search_date="";
		var member_nota_ref_search=null;
		var member_point_search=null;
		var member_jenis_search=null;
		var member_status_search=null;
		var member_tglcetak_search_date="";
		var member_tglcetak_end_search_date="";
		//var member_tglserahterima_search_date="";
		//var member_tglserahterima_end_search_date="";

		if(member_idSearchField.getValue()!==null){member_id_search=member_idSearchField.getValue();}
		if(member_custSearchField.getValue()!==null){member_cust_search=member_custSearchField.getValue();}
		if(member_noSearchField.getValue()!==null){member_no_search=member_noSearchField.getValue();}
		if(member_registerSearchField.getValue()!==""){member_register_search_date=member_registerSearchField.getValue().format('Y-m-d');}
		if(member_register_endSearchField.getValue()!==""){member_register_end_search_date=member_register_endSearchField.getValue().format('Y-m-d');}
		if(member_validSearchField.getValue()!==""){member_valid_search_date=member_validSearchField.getValue().format('Y-m-d');}
		if(member_valid_endSearchField.getValue()!==""){member_valid_end_search_date=member_valid_endSearchField.getValue().format('Y-m-d');}
		if(member_nota_refSearchField.getValue()!==null){member_nota_ref_search=member_nota_refSearchField.getValue();}
		if(member_pointSearchField.getValue()!==null){member_point_search=member_pointSearchField.getValue();}
		if(member_jenisSearchField.getValue()!==null){member_jenis_search=member_jenisSearchField.getValue();}
		if(member_statusSearchField.getValue()!==null){member_status_search=member_statusSearchField.getValue();}
		if(member_tglcetakSearchField.getValue()!==""){member_tglcetak_search_date=member_tglcetakSearchField.getValue().format('Y-m-d');}
		if(member_tglcetak_endSearchField.getValue()!==""){member_tglcetak_end_search_date=member_tglcetak_endSearchField.getValue().format('Y-m-d');}
		//if(member_tglserahterimaSearchField.getValue()!==""){member_tglserahterima_search_date=member_tglserahterimaSearchField.getValue().format('Y-m-d');}
		//if(member_tglserahterima_endSearchField.getValue()!==""){member_tglserahterima_end_search_date=member_tglserahterima_endSearchField.getValue().format('Y-m-d');}
		// change the store parameters
		member_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			member_id	:	member_id_search, 
			member_cust	:	member_cust_search, 
			member_no	:	member_no_search, 
			member_register	:	member_register_search_date, 
			member_register_end			:	member_register_end_search_date, 
			member_valid	:	member_valid_search_date, 
			member_valid_end			:	member_valid_end_search_date, 
			member_nota_ref	:	member_nota_ref_search, 
			member_point	:	member_point_search, 
			member_jenis	:	member_jenis_search, 
			member_status	:	member_status_search, 
			member_tglcetak	:	member_tglcetak_search_date, 
			member_tglcetak_end	:	member_tglcetak_end_search_date
			//member_tglserahterima	:	member_tglserahterima_search_date, 
			//member_tglserahterima_end	:	member_tglserahterima_end_search_date,
		};
		// Cause the datastore to do another query : 
		member_DataStore.reload({params: {start: 0, limit: member_pageS}});
	}
		
	/* Function for reset search result */
	function member_reset_search(){
		// reset the store parameters
		member_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		member_DataStore.reload({params: {start: 0, limit: member_pageS}});
		//member_searchWindow.close();
	};
	/* End of Fuction */

	function member_reset_SearchForm(){
		member_custSearchField.reset();
		member_noSearchField.reset();
		member_registerSearchField.reset();
		member_register_endSearchField.reset();
		member_validSearchField.reset();
		member_valid_endSearchField.reset();
		member_nota_refSearchField.reset();
		member_pointSearchField.reset();
		member_jenisSearchField.reset();
		member_statusSearchField.reset();
		member_tglcetakSearchField.reset();
		member_tglcetak_endSearchField.reset();
		//member_tglserahterimaSearchField.reset();
		//member_tglserahterima_endSearchField.reset();
	}

	
	/* Field for search */
	/* Identify  member_id Search Field */
	member_idSearchField= new Ext.form.NumberField({
		id: 'member_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	
	member_custSearchField= new Ext.form.ComboBox({
		id: 'member_custSearchField',
		fieldLabel: 'Customer',
		store: member_add_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: member_add_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});	

	/* Identify  member_cust Search Field */
/*	member_custSearchField= new Ext.form.TextField({
		id: 'member_custSearchField',
		fieldLabel: 'Customer',
		allowNegatife : false,
		allowDecimals: false,
		anchor: '95%'	
	});
*/
	/* Identify  member_no Search Field */
	member_noSearchField= new Ext.form.TextField({
		id: 'member_noSearchField',
		fieldLabel: 'No Member',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  member_register Search Field */
	member_registerSearchField= new Ext.form.DateField({
		id: 'member_registerSearchField',
		fieldLabel: 'Tanggal Daftar',
		format : 'd-m-Y'
	
	});
	member_register_endSearchField= new Ext.form.DateField({
		id: 'member_register_endSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'	
	});
	/* Identify  member_valid Search Field */
	member_validSearchField= new Ext.form.DateField({
		id: 'member_validSearchField',
		fieldLabel: 'Tanggal Valid',
		format : 'd-m-Y'	
	});
	member_valid_endSearchField= new Ext.form.DateField({
		id: 'member_valid_endSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'	
	});

	/* Identify  member_nota_ref Search Field */
	member_nota_refSearchField= new Ext.form.TextField({
		id: 'member_nota_refSearchField',
		fieldLabel: 'Referensi Nota Transaksi',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  member_point Search Field */
	member_pointSearchField= new Ext.form.NumberField({
		id: 'member_pointSearchField',
		fieldLabel: 'Poin',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  member_jenis Search Field */
	member_jenisSearchField= new Ext.form.ComboBox({
		id: 'member_jenisSearchField',
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['value', 'member_jenis'],
			data:[['perpanjangan','Perpanjangan'],['baru','Baru']]
		}),
		mode: 'local',
		displayField: 'member_jenis',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  member_status Search Field */
	member_statusSearchField= new Ext.form.ComboBox({
		id: 'member_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'member_status'],
		//	data:[['tidak aktif','Tidak aktif'],['print','Print'],['aktif','Aktif'],['register','Register']]
			//data: [['Daftar', 'Daftar'], ['Cetak', 'Cetak'], ['Serah Terima', 'Serah Terima']]
			data: [['Daftar', 'Daftar'], ['Cetak', 'Cetak']]
		}),
		mode: 'local',
		displayField: 'member_status',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});

	member_tglcetakSearchField= new Ext.form.DateField({
		id: 'member_tglcetakSearchField',
		fieldLabel: 'Tgl Cetak',
		format : 'd-m-Y'
	});
	member_tglcetak_endSearchField= new Ext.form.DateField({
		id: 'member_tglcetak_endSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'	
	});
	
	/* Search Form*/
	member_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 100,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,
		layout: 'form',
		items: [member_custSearchField, 
			member_noSearchField,
			member_jenisSearchField,
			member_statusSearchField,
			{
				layout:'column',
				border:false,
				items:[
					{
						layout: 'form',
						border: false,
						items:[member_registerSearchField]
					},{
						 layout: 'form',
						 border: false,
						 labelWidth: 15,
						 bodyStyle:'padding-left:3px',
						 labelSeparator: ' ', 
						 items:[member_register_endSearchField]
					}]
			},
			{
				layout:'column',
				border:false,
				items:[
					{
						layout: 'form',
						border: false,
						items:[member_validSearchField]
					},{
						 layout: 'form',
						 border: false,
						 labelWidth: 15,
						 bodyStyle:'padding-left:3px',
						 labelSeparator: ' ', 
						 items:[member_valid_endSearchField]
					}]
			},
			{
				layout:'column',
				border:false,
				items:[
					{
						layout: 'form',
						border: false,
						items:[member_tglcetakSearchField]
					},{
						 layout: 'form',
						 border: false,
						 labelWidth: 15,
						 bodyStyle:'padding-left:3px',
						 labelSeparator: ' ', 
						 items:[member_tglcetak_endSearchField]
					}]
			}
		]
		,
		buttons: [{
				text: 'Search',
				handler: member_list_search
			},{
				text: 'Close',
				handler: function(){
					member_searchWindow.hide();
				}
			}
		]
	});
	/* End Search Form */
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	member_searchWindow = new Ext.Window({
		title: 'Pencarian Member',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_member_search',
		items: member_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!member_searchWindow.isVisible()){
			member_reset_SearchForm();
			member_searchWindow.show();
		} else {
			member_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	
	/* Function for aktivasi Grid */
	function member_aktivasi(){
		if(memberListEditorGrid.selModel.getCount() == 1) {
			Ext.Ajax.request({
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_member&m=member_aktivasi',
				params: {
					member_id : memberListEditorGrid.getSelectionModel().getSelected().get('member_id')
				}, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Serah terima customer berhasil disimpan',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.OK
						});
						member_DataStore.reload();
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
	
	function cetak_kartu_confirm(btn){
		if(btn=='yes'){
			Ext.Ajax.request({   
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_member&m=member_cetak',
			success: function(response){              
				var result=eval(response.responseText);
				switch(result){
				case 1:
					member_DataStore.reload();
					win = window.open('./print/member_cetak_printlist.html','cetaklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
					//
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
	}
	
	/* Function for print List Grid */
	function member_cetak_kartu(){
		Ext.Msg.show({
		  	title:'Cetak: Status Daftar',
		   	msg: 'Anda yakin untuk mencetak semua kartu yang masih berstatus Daftar?',
		   	buttons: Ext.Msg.YESNO,
		   	fn: cetak_kartu_confirm,
		   	animEl: 'elId',
		   	icon: Ext.MessageBox.QUESTION
		});
		/*Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_member&m=member_cetak',
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				member_DataStore.reload();
				win = window.open('./print/member_cetak_printlist.html','cetaklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
		});*/
	}
	/* Enf Function */
	
	/* Function for print List Grid */
	function member_print(){
		var searchquery = "";
		var member_cust_print=null;
		var member_no_print=null;
		var member_register_print_date="";
		var member_register_end_print_date="";
		var member_valid_print_date="";
		var member_valid_end_print_date="";
		var member_nota_ref_print=null;
		var member_point_print=null;
		var member_jenis_print=null;
		var member_status_print=null;
		var member_tglcetak_print_date="";
		var member_tglcetak_end_print_date="";
		//var member_tglserahterima_print_date="";
		var win;              
		// check if we do have some search data...
		if(member_DataStore.baseParams.query!==null){searchquery = member_DataStore.baseParams.query;}
		if(member_DataStore.baseParams.member_cust!==null){member_cust_print = member_DataStore.baseParams.member_cust;}
		if(member_DataStore.baseParams.member_no!==null){member_no_print = member_DataStore.baseParams.member_no;}
		if(member_DataStore.baseParams.member_register!==""){member_register_print_date = member_DataStore.baseParams.member_register;}
		if(member_DataStore.baseParams.member_register_end!==""){member_register_end_print_date = member_DataStore.baseParams.member_register_end;}
		if(member_DataStore.baseParams.member_valid!==""){member_valid_print_date = member_DataStore.baseParams.member_valid;}
		if(member_DataStore.baseParams.member_valid_end!==""){member_valid_end_print_date = member_DataStore.baseParams.member_valid_end;}
		if(member_DataStore.baseParams.member_nota_ref!==null){member_nota_ref_print = member_DataStore.baseParams.member_nota_ref;}
		if(member_DataStore.baseParams.member_point!==null){member_point_print = member_DataStore.baseParams.member_point;}
		if(member_DataStore.baseParams.member_jenis!==null){member_jenis_print = member_DataStore.baseParams.member_jenis;}
		if(member_DataStore.baseParams.member_status!==null){member_status_print = member_DataStore.baseParams.member_status;}
		if(member_DataStore.baseParams.member_tglcetak!==""){member_tglcetak_print_date = member_DataStore.baseParams.member_tglcetak;}
		if(member_DataStore.baseParams.member_tglcetak_end!==""){member_tglcetak_end_print_date = member_DataStore.baseParams.member_tglcetak_end;}
		//if(member_DataStore.baseParams.member_tglserahterima!==""){member_tglserahterima_print_date = member_DataStore.baseParams.member_tglserahterima;}

		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_member&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			member_cust : member_cust_print,
			member_no : member_no_print,
		  	member_register : member_register_print_date,
			member_register_end : member_register_end_print_date, 
		  	member_valid : member_valid_print_date,
			member_valid_end : member_valid_end_print_date, 
			member_nota_ref : member_nota_ref_print,
			member_point : member_point_print,
			member_jenis : member_jenis_print,
			member_status : member_status_print,
		  	member_tglcetak : member_tglcetak_print_date, 
		  	member_tglcetak_end : member_tglcetak_end_print_date, 
		  	//member_tglserahterima : member_tglserahterima_print_date, 
		  	currentlisting: member_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/member_printlist.html','memberlist','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
				//
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
	function member_export_excel(){
		var searchquery = "";
		var member_cust_2excel=null;
		var member_no_2excel=null;
		var member_register_2excel_date="";
		var member_register_end_2excel_date="";
		var member_valid_2excel_date="";
		var member_valid_end_2excel_date="";
		var member_nota_ref_2excel=null;
		var member_point_2excel=null;
		var member_jenis_2excel=null;
		var member_status_2excel=null;
		var member_tglcetak_2excel_date="";
		var member_tglcetak_end_2excel_date="";
		//var member_tglserahterima_2excel_date="";
		var win;              
		// check if we do have some search data...
		if(member_DataStore.baseParams.query!==null){searchquery = member_DataStore.baseParams.query;}
		if(member_DataStore.baseParams.member_cust!==null){member_cust_2excel = member_DataStore.baseParams.member_cust;}
		if(member_DataStore.baseParams.member_no!==null){member_no_2excel = member_DataStore.baseParams.member_no;}
		if(member_DataStore.baseParams.member_register!==""){member_register_2excel_date = member_DataStore.baseParams.member_register;}
		if(member_DataStore.baseParams.member_register_end!==""){member_register_end_2excel_date = member_DataStore.baseParams.member_register_end;}
		if(member_DataStore.baseParams.member_valid!==""){member_valid_2excel_date = member_DataStore.baseParams.member_valid;}
		if(member_DataStore.baseParams.member_valid_end!==""){member_valid_end_2excel_date = member_DataStore.baseParams.member_valid_end;}
		if(member_DataStore.baseParams.member_nota_ref!==null){member_nota_ref_2excel = member_DataStore.baseParams.member_nota_ref;}
		if(member_DataStore.baseParams.member_point!==null){member_point_2excel = member_DataStore.baseParams.member_point;}
		if(member_DataStore.baseParams.member_jenis!==null){member_jenis_2excel = member_DataStore.baseParams.member_jenis;}
		if(member_DataStore.baseParams.member_status!==null){member_status_2excel = member_DataStore.baseParams.member_status;}
		if(member_DataStore.baseParams.member_tglcetak!==""){member_tglcetak_2excel_date = member_DataStore.baseParams.member_tglcetak;}
		if(member_DataStore.baseParams.member_tglcetak_end!==""){member_tglcetak_end_2excel_date = member_DataStore.baseParams.member_tglcetak_end;}
		//if(member_DataStore.baseParams.member_tglserahterima!==""){member_tglserahterima_2excel_date = member_DataStore.baseParams.member_tglserahterima;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_member&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			member_cust : member_cust_2excel,
			member_no : member_no_2excel,
		  	member_register : member_register_2excel_date,
			member_register_end : member_register_end_2excel_date, 
		  	member_valid : member_valid_2excel_date,
			member_valid_end : member_valid_end_2excel_date, 
			member_nota_ref : member_nota_ref_2excel,
			member_point : member_point_2excel,
			member_jenis : member_jenis_2excel,
			member_status : member_status_2excel,
		  	member_tglcetak : member_tglcetak_2excel_date, 
		  	member_tglcetak_end : member_tglcetak_end_2excel_date, 
		  	//member_tglserahterima : member_tglserahterima_2excel_date, 
		  	currentlisting: member_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_member"></div>
		<div id="elwindow_member_create"></div>
        <div id="elwindow_member_search"></div>
    </div>
</div>
</body>