<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: akun_setup View
	+ Description	: For record view
	+ Filename 		: v_akun_setup.php
 	+ creator  		: 
 	+ Created on 18/Oct/2010 13:31:54
	
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
var akun_setup_saveForm;
var akun_setup_saveWindow;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var setup_idField;
var setup_periode_tahunField;
var setup_periode_awalField;
var setup_periode_akhirField;
var setup_idSearchField;
var setup_periode_tahunSearchField;
var setup_periode_awalSearchField;
var setup_periode_akhirSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for add and edit data form, open window form */
	function akun_setup_save(){
	
		if(is_akun_setup_form_valid()){	
			var setup_id_field_pk=null; 
			var setup_periode_tahun_field=null; 
			var setup_periode_awal_field_date=""; 
			var setup_periode_akhir_field_date=""; 

			if(setup_periode_tahunField.getValue()!== null){setup_periode_tahun_field = setup_periode_tahunField.getValue();} 
			if(setup_periode_awalField.getValue()!== ""){setup_periode_awal_field_date = setup_periode_awalField.getValue().format('Y-m-d');} 
			if(setup_periode_akhirField.getValue()!== ""){setup_periode_akhir_field_date = setup_periode_akhirField.getValue().format('Y-m-d');} 

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_akun_setup&m=get_action',
				params: {
					setup_periode_tahun	: setup_periode_tahun_field, 
					setup_periode_awal	: setup_periode_awal_field_date, 
					setup_periode_akhir	: setup_periode_akhir_field_date, 
					task: 'UPDATE'
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Setup Akun sukses disimpan !.');
							akun_setup_saveWindow.hide();
							mainPanel.remove(mainPanel.getActiveTab().getId());
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Setup akun gagal disimpan.',
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
						   msg: 'Tidak dapat terhubung dengan database !.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
			
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form tidak lengkap!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  
	/* Function for Check if the form is valid */
	function is_akun_setup_form_valid(){
		return (setup_periode_tahunField.isValid() &&  
				setup_periode_awalField.isValid() &&  
				setup_periode_akhirField.isValid());
	}
  	/* End of Function */

 	/* Identify  setup_periode_tahun Field */
	setup_periode_tahunField= new Ext.form.ComboBox({
		id: 'setup_periode_tahunField',
		fieldLabel: 'Periode Tahun',
		name: 'setup_periode_tahun',
		maxLength: 4,
		anchor: '85%',
		store:new Ext.data.SimpleStore({
			fields:['cbo_tahun'],
			data: [['2010'],['2011'],['2012'],['2013'],['2014']]
		}),
		mode: 'local',
		displayField: 'cbo_tahun',
		triggerAction: 'all',
		lazyRender:true,
		editable: false,
		valueField: 'cbo_tahun',
		allowBlank: false
	});
	/* Identify  setup_periode_awal Field */
	setup_periode_awalField= new Ext.form.DateField({
		id: 'setup_periode_awalField',
		fieldLabel: 'Tanggal awal periode',
		name: 'setup_periode_awal',
		format : 'Y-m-d',
		allowBlank: false
	});
	/* Identify  setup_periode_akhir Field */
	setup_periode_akhirField= new Ext.form.DateField({
		id: 'setup_periode_akhirField',
		fieldLabel: 'Tanggal akhir periode',
		name: 'setup_periode_akhir',
		format : 'Y-m-d',
		allowBlank: false
	});

	
	/* Function for retrieve create Window Panel*/ 
	akun_setup_saveForm = new Ext.FormPanel({
		url: 'index.php?c=c_akun_setup&m=get_akun_setup',
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		labelWidth: 150,
		width: 300, 
		reader: new Ext.data.JsonReader({
			root: 'results',
			id: 'info_id'
		},
		[
			{name: 'setup_id', type: 'int', mapping: 'setup_id'},
			{name: 'setup_periode_tahun', type: 'string', mapping: 'setup_periode_tahun'},
			{name: 'setup_periode_awal', type: 'date', dateFormat: 'Y-m-d', mapping: 'setup_periode_awal'},
			{name: 'setup_periode_akhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'setup_periode_akhir'}
		]
		),
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [setup_periode_tahunField, setup_periode_awalField, setup_periode_akhirField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: akun_setup_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					akun_setup_saveWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	akun_setup_saveWindow= new Ext.Window({
		id: 'akun_setup_saveWindow',
		title: post2db+' Setup Periode Akun',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_akun_setup_save',
		items: akun_setup_saveForm
	});
	/* End Window */
	
	akun_setup_saveForm.getForm().load();
  	akun_setup_saveWindow.show();
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_akun_setup"></div>
		<div id="elwindow_akun_setup_save"></div>
        <div id="elwindow_akun_setup_search"></div>
    </div>
</div>
</body>
</html>