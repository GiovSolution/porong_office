<?php
/* 	
	+ Module  		: transaksi_setting View
	+ Description	: For record view
	+ Filename 		: v_transaksi_setting.php
 	+ creator  		:  Nat

	
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

var transaksi_setting_DataStore;
var transaksi_setting_saveForm;
var transaksi_setting_saveWindow;

//declare konstant
var post2db = 'UPDATE';
var msg = '';

/* declare variable here for Field*/

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	/* Function for add and edit data form, open window form */
	function transaksi_setting_save(){
	
		if(is_transaksi_setting_form_valid()){	
			var trans_op_days_field		= null; 
			var mb_days_field			= null;
			var kembali_poin_days	= null;
			
			if(trans_days_Field.getValue()!== null){trans_op_days_field = trans_days_Field.getValue();}
			if(mutasi_barang_days_Field.getValue()!== null){mb_days_field = mutasi_barang_days_Field.getValue();}
			if(kembali_poin_days_Field.getValue()!== null){kembali_poin_days = kembali_poin_days_Field.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_transaksi_setting&m=get_action',
				params: {
					trans_op_days	: trans_op_days_field, 
					mb_days			: mb_days_field,
					kembali_poin_days : kembali_poin_days,
					task			: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Transaction Setting berhasil disimpan.');
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Transaction Setting tidak dapat disimpan',
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
				msg: 'Form Anda belum valid',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
    
	/*function transaksi_setting_reset_form(){
	
		transaksi_setting_DataStore.load({
		
		if(transaksi_setting_DataStore.getCount()){
			info_op=transaksi_setting_DataStore.getAt(0).data;
			trans_days_Field.setValue(info_op.trans_op_days);
		}
		});
	}
 	/* End of Function */
	
	/* Function for Check if the form is valid */
	function is_transaksi_setting_form_valid(){
		return (trans_days_Field.isValid());
	}
  	/* End of Function */
  
  /* Function for Displaying  create Window Form */
	/*function display_form_window(){
		transaksi_setting_reset_form();
	}
  	/* End of Function */
  
	transaksi_setting_DataStore = new Ext.data.Store({
		id: 'transaksi_setting_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_transaksi_setting&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			//id: 'setcrm_id'
		},[
		/* dataIndex => insert intomember_setup_ColumnModel, Mapping => for initiate table column */ 

			{name: 'trans_op_days', type: 'string', mapping: 'trans_op_days'}, 
			{name: 'mb_days', type: 'int', mapping: 'mb_days'},
			{name: 'kembali_poin_days', type: 'int', mapping: 'kembali_poin_days'},
			{name: 'trans_author', type: 'string', mapping: 'trans_author'}, 
			{name: 'trans_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'trans_date_create'}, 
			{name: 'trans_update', type: 'string', mapping: 'trans_update'}, 
			{name: 'trans_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'trans_date_update'}, 
			{name: 'trans_revised', type: 'int', mapping: 'trans_revised'} 
		]),
		sortInfo:{field: 'trans_op_days', direction: "DESC"}
	});
	
	trans_days_Field= new Ext.form.NumberField({
		id: 'trans_days_Field',
		name: 'trans_op_days',
		fieldLabel: 'Masa Berlaku OP',
		allowNegatife : false,
		allowDecimals: true,
		anchor: '20%',
		width : 40,
		maxLength : 11		
	});
	
	mutasi_barang_days_Field= new Ext.form.NumberField({
		id: 'mutasi_barang_days_Field',
		name: 'mb_days',
		fieldLabel: 'Penguncian Mutasi Barang',
		allowNegatife : false,
		allowDecimals: true,
		anchor: '20%',
		width : 40,
		maxLength : 11		
	});
	
	kembali_poin_days_Field= new Ext.form.NumberField({
		id: 'kembali_poin_days_Field',
		name: 'kembali_poin_days',
		fieldLabel: 'Penguncian Pengembalian Poin Hangus',
		allowNegatife : false,
		allowDecimals: true,
		anchor: '20%',
		width : 40,
		maxLength : 11		
	});

	set_trans_label_transField			= new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Masa berlaku OP : &nbsp;'});
	set_mb_labelField					= new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Penguncian Mutasi Barang : &nbsp;'});
	set_kembali_poin_labelField			= new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Penguncian Pengembalian Poin Hangus : &nbsp;'});
	set_trans_label_daysField			= new Ext.form.Label({ html: '&nbsp; hari<br> <br>'});
	set_mb_label_daysField				= new Ext.form.Label({ html: '&nbsp; hari<br> <br>'});
	set_kembali_poin_label_daysField	= new Ext.form.Label({ html: '&nbsp; hari<br> <br>'});
	
	
	/* Function for retrieve create Window Panel*/ 
	transaksi_setting_saveForm = new Ext.FormPanel({
		url: 'index.php?c=c_transaksi_setting&m=get_action',
		baseParams:{task: "LIST", start: 0, limit: 1},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			//id: 'setcrm_id'
		},[
		/* dataIndex => insert intomember_setup_ColumnModel, Mapping => for initiate table column */ 
			{name: 'trans_op_days', type: 'string', mapping: 'trans_op_days'},
			{name: 'mb_days', type: 'int', mapping: 'mb_days'},			
			{name: 'kembali_poin_days', type: 'int', mapping: 'kembali_poin_days'},			
			{name: 'trans_author', type: 'string', mapping: 'trans_author'}, 
			{name: 'trans_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'trans_date_create'}, 
			{name: 'trans_update', type: 'string', mapping: 'trans_update'}, 
			{name: 'trans_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'trans_date_update'}, 
			{name: 'trans_revised', type: 'int', mapping: 'trans_revised'} 
		]),
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		layout : 'column',
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					set_trans_label_transField, trans_days_Field, set_trans_label_daysField,
					set_mb_labelField, mutasi_barang_days_Field, set_mb_label_daysField,
					set_kembali_poin_labelField, kembali_poin_days_Field, set_kembali_poin_label_daysField, ] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: function(){
					transaksi_setting_save();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
			,{
				text: 'Cancel',
				handler: function(){
					transaksi_setting_saveWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
					
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	transaksi_setting_saveWindow= new Ext.Window({
		id: 'transaksi_setting_saveWindow',
		title: 'Transaction Setting',
		closable:true,
		closeAction: 'hide',
		closable: false,
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_transaksi_setting_save',
		items: transaksi_setting_saveForm
	});
	/* End Window */
	transaksi_setting_saveForm.getForm().load();
	transaksi_setting_saveWindow.show();
/*	transaksi_setting_saveWindow.on("hide",function(){
		mainPanel.remove(mainPanel.getActiveTab().getId());										
	});*/
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_transaksi_setting"></div>
		<div id="elwindow_transaksi_setting_save"></div>
        <div id="elwindow_transaksi_setting_search"></div>
    </div>
</div>
</body>
</html>