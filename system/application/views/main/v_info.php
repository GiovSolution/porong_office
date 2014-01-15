<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: info View
	+ Description	: For record view
	+ Filename 		: v_info.php
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
var info_createForm;
var info_createWindow;
var auto_cust_no_DataStore;

Ext.onReady(function(){
  Ext.QuickTips.init();
  	
   function is_infoFormValid(){
		return true;
	}
	
	info_idField= new Ext.form.NumberField({
		id: 'info_idField',
		name: 'info_id',
		hidden: true
	});
	
	
	info_namaField= new Ext.form.TextField({
		id: 'info_namaField',
		name: 'info_nama',
		fieldLabel: 'Nama',
		anchor: '95%',
		readOnly : true
	});
	
	info_alamatField= new Ext.form.TextField({
		id: 'info_alamatField',
		name: 'info_alamat',
		fieldLabel: 'Alamat',
		anchor: '95%',
		readOnly : true
	});
	
	info_id_cabangField= new Ext.form.TextField({
		id: 'info_id_cabangField',
		fieldLabel: 'ID Cabang',
		name: 'info_cabang',
		anchor: '95%',
		readOnly : true,
		//hidden : true
	});
	
	
	cbo_cabangDataStore = new Ext.data.Store({
		id: 'cbo_cabangDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_info&m=get_cabang_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'cabang_display', type: 'string', mapping: 'cabang_nama'},
			{name: 'cabang_value', type: 'int', mapping: 'cabang_id'},
		]),
		sortInfo:{field: 'cabang_display', direction: "ASC"}
	});
	
	var cabang_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cabang_display}</b></span>',
        '</div></tpl>'
    );
	
	//auto no
	auto_cabang_DataStore = new Ext.data.Store({
		id: 'auto_cabang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_info&m=get_auto_cabang', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'cabang_nama', type: 'string', mapping: 'cabang_nama'},
			{name: 'cabang_alamat', type: 'string', mapping: 'cabang_alamat'},
			{name: 'cabang_id', type: 'string', mapping: 'cabang_id'}
		]),
		sortInfo:{field: 'cabang_nama', direction: "ASC"}
	});
	
	
	
	function load_cust_no(){
		if(cabangField.getValue()!=''){
			auto_cabang_DataStore.load({
					params : { cabang_id: cabangField.getValue() },
					callback: function(opts, success, response)  {
						 if (success) {
							if(auto_cabang_DataStore.getCount()){
								info_auto_nama=auto_cabang_DataStore.getAt(0).data;
								info_namaField.setValue(info_auto_nama.cabang_nama);
								info_alamatField.setValue(info_auto_nama.cabang_alamat);
								info_id_cabangField.setValue(info_auto_nama.cabang_id);
							}
						}
					}
			}); 
		}
	}
	
	cabangField= new Ext.form.ComboBox({
		id: 'cabangField',
		fieldLabel: 'Cabang',
		store: cbo_cabangDataStore,
		mode: 'remote',
		displayField:'cabang_display',
		valueField: 'cabang_value',
        typeAhead: false,
        loadingText: 'Searching...',
        //pageSize:10,
        hideTrigger:false,
        tpl: cabang_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:false,
		anchor: '95%'
	});
	
	/* Function for retrieve Add Window Panel*/
	info_createForm = new Ext.FormPanel({
		url: 'index.php?c=c_info&m=get_detail_info',
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,
		reader: new Ext.data.JsonReader({
			root: 'results',
			id: 'info_id'
		},
		
		[
			{name: 'info_id', type: 'int', mapping: 'info_id'},
			{name: 'info_nama', type: 'string', mapping: 'info_nama'},
			{name: 'info_alamat', type: 'string', mapping: 'info_alamat'},
			{name: 'info_notelp', type: 'string', mapping: 'info_notelp'},
			{name: 'info_nofax', type: 'string', mapping: 'info_nofax'},
			{name: 'info_email', type: 'string', mapping: 'info_email'},
			{name: 'info_website', type: 'string', mapping: 'info_website'},
			{name: 'info_slogan', type: 'string', mapping: 'info_slogan'},
			{name: 'info_logo', type: 'string', mapping: 'info_logo'},
			{name: 'info_icon', type: 'string', mapping: 'info_icon'},
			{name: 'info_background', type: 'string', mapping: 'info_background'},
			{name: 'info_theme', type: 'string', mapping: 'info_theme'},
			{name: 'info_cabang', type: 'string', mapping: 'info_cabang'}
		]
	
		),
		
		items: [{
			layout:'column',
			border:false,
			items:[{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [info_namaField, info_alamatField, info_id_cabangField,
				{
					xtype: 'textfield',
					id: 'info_sloganField',
					fieldLabel: 'Slogan',
					name: 'info_slogan',
					maxLength: 250,
					anchor: '95%'
				},
				info_idField,cabangField
				]
			}]
		}],
		buttons: [
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_INFO'))){ ?>
			{
				text: 'Save and Close',
				handler: function(){
					if(info_createForm.getForm().isValid()){
					   info_createForm.getForm().submit({
							url: 'index.php?c=c_info&m=info_update',
							waitMsg: 'Info Updating...!',
							success: function(){
								Ext.Msg.show({
										title:'OK',
										msg: 'Update Info Sukses...!',
										buttons: Ext.Msg.OK,
										fn: function(btn, text){
											mainPanel.remove(mainPanel.getActiveTab().getId());
										}
									});
							},
							failure: function(){
								//var result=response.responseText;
								Ext.MessageBox.show({
									   title: 'Error',
									   msg: 'Tidak bisa terhubung dengan database server Error: ',
									   buttons: Ext.MessageBox.OK,
									   animEl: 'database',
									   icon: Ext.MessageBox.ERROR
								});	
							}        
						});
					}
				}
			},
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					info_createWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End Function*/
	
	cabangField.on("select",function(){
		load_cust_no();
		g=auto_cabang_DataStore.find('cabang_id',cabangField.getValue());
		if(g>-1)
			cabangField.setValue(auto_cust_no_DataStore.getAt(j).cabangField);
		else
			cabangField.setValue("");
	});
	
	/* Function for retrieve Add Window Form */
	info_createWindow= new Ext.Window({
		id: 'info_createWindow',
		title: 'Update Info Setting',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_info_create',
		items: info_createForm
	});
	
	info_createForm.getForm().load();
  	info_createWindow.show();

});

	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_info_create"></div>
    </div>
</div>
</body>