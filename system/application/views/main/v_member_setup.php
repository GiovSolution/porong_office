<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member_setup View
	+ Description	: For record view
	+ Filename 		: v_member_setup.php
 	+ creator  		: 
 	+ Created on 06/Apr/2010 12:55:05
	
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
var member_setup_DataStore;
var member_setup_ColumnModel;
var member_setupListEditorGrid;
var member_setup_saveForm;
var member_setup_saveWindow;
var member_setup_searchForm;
var member_setup_searchWindow;
var member_setup_SelectedRow;
var member_setup_ContextMenu;

//declare konstant
var post2db = 'UPDATE';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var setmember_idField;
var setmember_transhariField;
var setmember_transbulanField;
var setmember_periodeaktifField;
var setmember_periodetenggangField;
var setmember_transtenggangField;
var setmember_idSearchField;
var setmember_transhariSearchField;
var setmember_transbulanSearchField;
var setmember_periodeaktifSearchField;
var setmember_periodetenggangSearchField;
var setmember_transtenggangSearchField;
var setmember_mintransxField;
var setmember_mintransrpField;
var setmember_waktuField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	/* Function for add and edit data form, open window form */
	function member_setup_save(){
	
		if(is_member_setup_form_valid()){	
			var setmember_id_field_pk=null; 
			var setmember_transhari_field=null; 
			var setmember_pointhari_field=null;
			var setmember_periodeaktif_field=null; 
			var setmember_periodetenggang_field=null; 
			var setmember_transtenggang_field=null;
			var	setmember_pointtenggang_field=null;
			var	setmember_rp_perpoint_field=null;
			var	setmember_point_perrp_field=null;
			var setmember_mintransx_field=null;
			var setmember_mintransrp_field=null;
			var setmember_waktu_field=null;

			if(setmember_transhariField.getValue()!== null){setmember_transhari_field = convertToNumber(setmember_transhariField.getValue());}
			if(setmember_pointhariField.getValue()!== null){setmember_pointhari_field = convertToNumber(setmember_pointhariField.getValue());} 
			if(setmember_periodeaktifField.getValue()!== null){setmember_periodeaktif_field = convertToNumber(setmember_periodeaktifField.getValue());} 
			if(setmember_periodetenggangField.getValue()!== null){setmember_periodetenggang_field = convertToNumber(setmember_periodetenggangField.getValue());} 
			if(setmember_transtenggangField.getValue()!== null){setmember_transtenggang_field = convertToNumber(setmember_transtenggangField.getValue());}
			if(setmember_pointtenggangField.getValue()!== null){setmember_pointtenggang_field = convertToNumber(setmember_pointtenggangField.getValue());} 
			if(setmember_rp_perpointField.getValue()!== null){setmember_rp_perpoint_field = convertToNumber(setmember_rp_perpointField.getValue());}
			if(setmember_point_perrpField.getValue()!== null){setmember_point_perrp_field = convertToNumber(setmember_point_perrpField.getValue());}
			if(setmember_mintransxField.getValue()!== null){setmember_mintransx_field = convertToNumber(setmember_mintransxField.getValue());}
			if(setmember_mintransrpField.getValue()!== null){setmember_mintransrp_field = convertToNumber(setmember_mintransrpField.getValue());}
			if(setmember_waktuField.getValue()!== null){setmember_waktu_field = convertToNumber(setmember_waktuField.getValue());}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_member_setup&m=get_action',
				params: {
					setmember_id				: setmember_id_field_pk, 
					setmember_transhari			: setmember_transhari_field,
					setmember_pointhari			: setmember_pointhari_field,
					setmember_periodeaktif		: setmember_periodeaktif_field, 
					setmember_periodetenggang	: setmember_periodetenggang_field,
					setmember_transtenggang		: setmember_transtenggang_field,
					setmember_pointtenggang		: setmember_pointtenggang_field,
					setmember_rp_perpoint		: setmember_rp_perpoint_field,
					setmember_point_perrp		: setmember_point_perrp_field,
					setmember_mintransx			: setmember_mintransx_field,
					setmember_mintransrp		: setmember_mintransrp_field,
					setmember_waktu				: setmember_waktu_field,
					task						: post2db

				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Setup Member berhasil disimpan.');
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' Member Setup.',
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
    
	/* Function for Check if the form is valid */
	function is_member_setup_form_valid(){
		return (setmember_transhariField.isValid());
	}
  	/* End of Function */
  
 	
	/* Identify  setmember_transhari Field */
	setmember_transhariField= new Ext.form.TextField({
		id: 'setmember_transhariField',
		name: 'setmember_transhari',
		fieldLabel: 'Transaksi Minimum  1 Hari',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_pointhariField= new Ext.form.TextField({
		id: 'setmember_pointhariField',
		name: 'setmember_pointhari',
		fieldLabel: 'Point Minimum  1 Hari',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_registerField=new Ext.form.FieldSet({
		id:'setmember_registerField',
		name: 'setmember_registerField',
		title: 'Syarat Pendaftaran Member',
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items:[setmember_transhariField, setmember_pointhariField]
	});
	
	
	/* Identify  setmember_periodeaktif Field */
	setmember_periodeaktifField= new Ext.form.TextField({
		id: 'setmember_periodeaktifField',
		name: 'setmember_periodeaktif',
		fieldLabel: 'Masa Aktif (Hari)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  setmember_periodetenggang Field */
	setmember_periodetenggangField= new Ext.form.TextField({
		id: 'setmember_periodetenggangField',
		name:'setmember_periodetenggang',
		fieldLabel: 'Masa Tenggang (Hari)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  setmember_transtenggang Field */
	setmember_transtenggangField= new Ext.form.TextField({
		id: 'setmember_transtenggangField',
		name: 'setmember_transtenggang',
		fieldLabel: 'Transaksi deposit minimum',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	setmember_pointtenggangField= new Ext.form.TextField({
		id: 'setmember_pointtenggangField',
		name: 'setmember_pointtenggang',
		fieldLabel: 'Point deposit minimum',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_reloadField=new Ext.form.FieldSet({
		id:'setmember_reloadField',
		name: 'setmember_reloadField',
		title: 'Syarat Perpanjangan Member',
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items:[setmember_transtenggangField, setmember_pointtenggangField]
	});
	
	setmember_periodeField=new Ext.form.FieldSet({
		id:'setmember_periodeField',
		name: 'setmember_periodeField',
		title: 'Periode Member',
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items:[setmember_periodeaktifField, setmember_periodetenggangField]
	});
	
	
	setmember_rp_perpointField= new Ext.form.TextField({
		id: 'setmember_rp_perpointField',
		name: 'setmember_rp_perpoint',
		fieldLabel: 'Jumlah Rupiah',
		allowBlank: false,
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_rupiah_perpointField=new Ext.form.FieldSet({
		id:'setmember_rupiah_perpointField',
		name: 'setmember_rupiah_perpointField',
		title: 'Set Rupiah per 1-Point',
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items:[setmember_rp_perpointField]
	});
	
	setmember_point_perrpField= new Ext.form.TextField({
		id: 'setmember_point_perrpField',
		name: 'setmember_point_perrp',
		fieldLabel: 'Jumlah Rupiah',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		blankText: '0',
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	setmember_point_perrupiahField=new Ext.form.FieldSet({
		id:'setmember_point_perrupiahField',
		name: 'setmember_point_perrupiahField',
		title: 'Set 1-Poin per Rupiah',
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items:[setmember_point_perrpField]
	});
	
	/* Identify  setmember_pointhangus Field */
	setmember_mintransxField= new Ext.form.TextField({
		id: 'setmember_mintransxField',
		name: 'setmember_mintransx',
		fieldLabel: 'Min Transaksi (x)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_mintransrpField= new Ext.form.TextField({
		id: 'setmember_mintransrpField',
		name: 'setmember_mintransrp',
		fieldLabel: 'Min Transaksi (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_waktuField= new Ext.form.TextField({
		id: 'setmember_waktuField',
		name: 'setmember_waktu',
		fieldLabel: 'Jangka Waktu (hari)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_pointhangusField=new Ext.form.FieldSet({
		id:'setmember_pointhangus',
		name: 'setmember_pointhangus',
		title: 'Point Hangus',
		layout: 'form',
		bodyStyle: 'padding: 5px;',
		items:[setmember_mintransxField, setmember_mintransrpField, setmember_waktuField]
	});
	
	
	/* Function for retrieve create Window Panel*/ 
	member_setup_saveForm = new Ext.FormPanel({
		url: 'index.php?c=c_member_setup&m=get_action',
		baseParams:{task: "LIST", start: 0, limit: 1},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'setmember_id'
		},[
			{name: 'setmember_id', type: 'int', mapping: 'setmember_id'}, 
			{name: 'setmember_transhari', type: 'string', mapping: 'setmember_transhari'}, 
			{name: 'setmember_pointhari', type: 'string', mapping: 'setmember_pointhari'}, 
			{name: 'setmember_transbulan', type: 'string', mapping: 'setmember_transbulan'},
			{name: 'setmember_pointbulan', type: 'string', mapping: 'setmember_pointbulan'}, 
			{name: 'setmember_periodeaktif', type: 'string', mapping: 'setmember_periodeaktif'}, 
			{name: 'setmember_periodetenggang', type: 'string', mapping: 'setmember_periodetenggang'}, 
			{name: 'setmember_transtenggang', type: 'string', mapping: 'setmember_transtenggang'},
			{name: 'setmember_pointtenggang', type: 'string', mapping: 'setmember_pointtenggang'},
			{name: 'setmember_rp_perpoint', type: 'string', mapping: 'setmember_rp_perpoint'},
			{name: 'setmember_point_perrp', type: 'string', mapping: 'setmember_point_perrp'},
			{name: 'setmember_mintransx', type: 'string', mapping: 'setmember_mintransx'},
			{name: 'setmember_mintransrp', type: 'string', mapping: 'setmember_mintransrp'},
			{name: 'setmember_waktu', type: 'string', mapping: 'setmember_waktu'}
		]),
		labelAlign: 'left',
		labelWidth: 200,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [setmember_registerField,setmember_reloadField,setmember_periodeField,setmember_rupiah_perpointField,setmember_point_perrupiahField, setmember_pointhangusField] 
			}
			],
		buttons: [
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEMBERSETUP'))){ ?>
			{
				text: 'Save and Close',
				handler: function(){
					member_setup_save();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					member_setup_saveWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
					
				}
			}
		]
	});
	/* End  of Function*/
	
	
	
	/* Function for retrieve create Window Form */
	member_setup_saveWindow= new Ext.Window({
		id: 'member_setup_saveWindow',
		title: post2db+' Member Setup',
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
		renderTo: 'elwindow_member_setup_save',
		items: member_setup_saveForm
	});
	/* End Window */
	
/*	member_setup_saveWindow.on("hide",function(){
		mainPanel.remove(mainPanel.getActiveTab().getId());										
	});*/

	setmember_transhariField.on('focus',function(){ setmember_transhariField.setValue(convertToNumber(setmember_transhariField.getValue())); });
	setmember_transhariField.on('blur',function(){ setmember_transhariField.setValue(CurrencyFormatted(setmember_transhariField.getValue())); });
	
	setmember_pointhariField.on('focus',function(){ setmember_pointhariField.setValue(convertToNumber(setmember_pointhariField.getValue())); });
	setmember_pointhariField.on('blur',function(){ setmember_pointhariField.setValue(CurrencyFormatted(setmember_pointhariField.getValue())); });
	
	setmember_periodeaktifField.on('focus',function(){ setmember_periodeaktifField.setValue(convertToNumber(setmember_periodeaktifField.getValue())); });
	setmember_periodeaktifField.on('blur',function(){ setmember_periodeaktifField.setValue(CurrencyFormatted(setmember_periodeaktifField.getValue())); });
	
	setmember_periodetenggangField.on('focus',function(){ setmember_periodetenggangField.setValue(convertToNumber(setmember_periodetenggangField.getValue())); });
	setmember_periodetenggangField.on('blur',function(){ setmember_periodetenggangField.setValue(CurrencyFormatted(setmember_periodetenggangField.getValue())); });
	
	setmember_transtenggangField.on('focus',function(){ setmember_transtenggangField.setValue(convertToNumber(setmember_transtenggangField.getValue())); });
	setmember_transtenggangField.on('blur',function(){ setmember_transtenggangField.setValue(CurrencyFormatted(setmember_transtenggangField.getValue())); });
	
	setmember_pointtenggangField.on('focus',function(){ setmember_pointtenggangField.setValue(convertToNumber(setmember_pointtenggangField.getValue())); });
	setmember_pointtenggangField.on('blur',function(){ setmember_pointtenggangField.setValue(CurrencyFormatted(setmember_pointtenggangField.getValue())); });
	
	setmember_rp_perpointField.on('focus',function(){ setmember_rp_perpointField.setValue(convertToNumber(setmember_rp_perpointField.getValue())); });
	setmember_rp_perpointField.on('blur',function(){ setmember_rp_perpointField.setValue(CurrencyFormatted(setmember_rp_perpointField.getValue())); });
	
	setmember_mintransxField.on('focus',function(){ setmember_mintransxField.setValue(convertToNumber(setmember_mintransxField.getValue())); });
	setmember_mintransxField.on('blur',function(){ setmember_mintransxField.setValue(CurrencyFormatted(setmember_mintransxField.getValue())); });
	
	setmember_mintransrpField.on('focus',function(){ setmember_mintransrpField.setValue(convertToNumber(setmember_mintransrpField.getValue())); });
	setmember_mintransrpField.on('blur',function(){ setmember_mintransrpField.setValue(CurrencyFormatted(setmember_mintransrpField.getValue())); });

	setmember_waktuField.on('focus',function(){ setmember_waktuField.setValue(convertToNumber(setmember_waktuField.getValue())); });
	setmember_waktuField.on('blur',function(){ setmember_waktuField.setValue(CurrencyFormatted(setmember_waktuField.getValue())); });

	setmember_point_perrpField.on('focus',function(){ setmember_point_perrpField.setValue(convertToNumber(setmember_point_perrpField.getValue())); });
	setmember_point_perrpField.on('blur',function(){ setmember_point_perrpField.setValue(CurrencyFormatted(setmember_point_perrpField.getValue())); });

	
	member_setup_saveForm.getForm().load();
	member_setup_saveWindow.show();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_member_setup"></div>
		<div id="elwindow_member_setup_save"></div>
        <div id="elwindow_member_setup_search"></div>
    </div>
</div>
</body>
</html>