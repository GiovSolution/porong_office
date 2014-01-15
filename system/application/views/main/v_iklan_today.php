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
var iklan_today_DataStore;
var iklan_today_ColumnModel;
var iklan_todayListEditorGrid;
var iklan_today_saveForm;
var iklan_today_saveWindow;
var iklan_today_searchForm;
var iklan_today_searchWindow;
var iklan_today_SelectedRow;
var iklan_today_ContextMenu;

//declare konstant
var post2db = 'UPDATE';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var iklantoday_idField;
var iklantoday_keteranganField;
var iklantoday_tanggalField;
/*var setmember_transhariField;
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
*/
var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

Ext.apply(Ext.form.VTypes, {
    daterange : function(val, field) {
        var date = field.parseDate(val);

        if(!date){
            return;
        }
        if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
            var start = Ext.getCmp(field.startDateField);
            start.setMaxValue(date);
            start.validate();
            this.dateRangeMax = date;
        } 
        else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
            var end = Ext.getCmp(field.endDateField);
            end.setMinValue(date);
            end.validate();
            this.dateRangeMin = date;
        }
        return true;
    }
});




/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	/* Function for add and edit data form, open window form */
	function iklan_today_save(){
	
		if(is_iklantoday_form_valid()){	
			var setmember_id_field_pk=null;
			var iklantoday_id_field_pk=null;
			var iklantoday_tanggal_field="";
			var iklantoday_keterangan_field=null;
			/*var setmember_transhari_field=null; 
			var setmember_pointhari_field=null;
			var setmember_transbulan_field=null; 
			var setmember_pointbulan_field=null;
			var setmember_periodeaktif_field=null; 
			var setmember_periodetenggang_field=null; 
			var setmember_transtenggang_field=null;
			var	setmember_pointtenggang_field=null;*/

			//if(setmember_transhariField.getValue()!== null){setmember_transhari_field = setmember_transhariField.getValue();}
			if(iklantoday_tanggalField.getValue()!==""){iklantoday_tanggal_field = iklantoday_tanggalField.getValue().format('Y-m-d');}
			if(iklantoday_keteranganField.getValue()!== null){iklantoday_keterangan_field = iklantoday_keteranganField.getValue();}
			//if(setmember_pointhariField.getValue()!== null){setmember_pointhari_field = setmember_pointhariField.getValue();} 
			//if(setmember_transbulanField.getValue()!== null){setmember_transbulan_field = setmember_transbulanField.getValue();} 
			//if(setmember_pointbulanField.getValue()!== null){setmember_pointbulan_field = setmember_pointbulanField.getValue();} 
			//if(setmember_periodeaktifField.getValue()!== null){setmember_periodeaktif_field = setmember_periodeaktifField.getValue();} 
			//if(setmember_periodetenggangField.getValue()!== null){setmember_periodetenggang_field = setmember_periodetenggangField.getValue();} 
			//if(setmember_transtenggangField.getValue()!== null){setmember_transtenggang_field = setmember_transtenggangField.getValue();}
			//if(setmember_pointtenggangField.getValue()!== null){setmember_pointtenggang_field = setmember_pointtenggangField.getValue();} 
						
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_iklan_today&m=get_action',
				params: {
					//setmember_id				: setmember_id_field_pk,
					iklantoday_id				: iklantoday_id_field_pk,
					iklantoday_tanggal			: iklantoday_tanggal_field,
					iklantoday_keterangan		: iklantoday_keterangan_field,
					/*setmember_transhari			: setmember_transhari_field,
					setmember_pointhari			: setmember_pointhari_field,
					setmember_transbulan		: setmember_transbulan_field,
					setmember_pointbulan		: setmember_pointbulan_field,
					setmember_periodeaktif		: setmember_periodeaktif_field, 
					setmember_periodetenggang	: setmember_periodetenggang_field,
					setmember_transtenggang		: setmember_transtenggang_field,
					setmember_pointtenggang		: setmember_pointtenggang_field,*/
					task						: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Promo Hari Ini berhasil disimpan.');
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' Promo Hari Ini.',
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
    
	/* Function for Check if the form is valid */
	function is_iklantoday_form_valid(){
		return (iklantoday_keteranganField.isValid());
	}
  	/* End of Function */
  
	/* Function for Retrieve DataStore */
	iklan_today_DataStore = new Ext.data.Store({
		id: 'iklan_today_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_iklan_today&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'iklantoday_id'
		},[
		/* dataIndex => insert intoiklan_today_ColumnModel, Mapping => for initiate table column */ 
			//{name: 'setmember_id', type: 'int', mapping: 'setmember_id'},
			{name: 'iklantoday_id', type: 'int', mapping: 'iklantoday_id'},
			{name: 'iklantoday_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'iklantoday_tanggal'},
			{name: 'iklantoday_keterangan', type: 'string', mapping: 'iklantoday_keterangan'}, 	
			{name: 'iklantoday_author', type: 'string', mapping: 'iklantoday_author'}, 
			{name: 'iklantoday_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'iklantoday_date_create'}, 
			{name: 'iklantoday_update', type: 'string', mapping: 'setmember_update'}, 
			{name: 'iklantoday_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'iklantoday_date_update'}, 
			{name: 'iklantoday_revised', type: 'int', mapping: 'iklantoday_revised'}	
			/*{name: 'setmember_transhari', type: 'float', mapping: 'setmember_transhari'}, 
			{name: 'setmember_pointhari', type: 'int', mapping: 'setmember_pointhari'}, 
			{name: 'setmember_transbulan', type: 'float', mapping: 'setmember_transbulan'},
			{name: 'setmember_pointbulan', type: 'int', mapping: 'setmember_pointbulan'}, 
			{name: 'setmember_periodeaktif', type: 'int', mapping: 'setmember_periodeaktif'}, 
			{name: 'setmember_periodetenggang', type: 'int', mapping: 'setmember_periodetenggang'}, 
			{name: 'setmember_transtenggang', type: 'float', mapping: 'setmember_transtenggang'},
			{name: 'setmember_pointtenggang', type: 'int', mapping: 'setmember_pointtenggang'},
			{name: 'setmember_author', type: 'string', mapping: 'setmember_author'}, 
			{name: 'setmember_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setmember_date_create'}, 
			{name: 'setmember_update', type: 'string', mapping: 'setmember_update'}, 
			{name: 'setmember_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setmember_date_update'}, 
			{name: 'setmember_revised', type: 'int', mapping: 'setmember_revised'} */
		]),
		sortInfo:{field: 'iklantoday_id', direction: "DESC"}
	});
	/* End of Function */
    
  	
	/* Identify  setmember_transhari Field */
	/*setmember_transhariField= new Ext.form.NumberField({
		id: 'setmember_transhariField',
		name: 'setmember_transhari',
		fieldLabel: 'Transaksi Minimum  1 Hari',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	iklantoday_tanggalField = new Ext.form.DateField({
		id: 'iklantoday_tanggalField',
		name : 'iklantoday_tanggal',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
        vtype: 'daterange',
		allowBlank: false,
		width: 100
       // endDateField: 'rpt_terimakas_tglakhirField'
	});
	
	iklantoday_keteranganField= new Ext.form.TextArea({
		id: 'iklantoday_keteranganField',
		name : 'iklantoday_keterangan',
		fieldLabel: 'Promo',
		allowBlank : false,
		maxLength: 250,
		anchor: '95%'
	});
	
	
	
	
	/*setmember_pointhariField= new Ext.form.NumberField({
		id: 'setmember_pointhariField',
		name: 'setmember_pointhari',
		fieldLabel: 'Point Minimum  1 Hari',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	/* Identify  setmember_transbulan Field */
	/*setmember_transbulanField= new Ext.form.NumberField({
		id: 'setmember_transbulanField',
		name: 'setmember_transbulan',
		fieldLabel: 'Transaksi Minimum 1 Bulan',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	setmember_pointbulanField= new Ext.form.NumberField({
		id: 'setmember_pointbulanField',
		name: 'setmember_pointbulan',
		fieldLabel: 'Point Minimum  1 Bulan',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	/* Identify  setmember_periodeaktif Field */
	/*setmember_periodeaktifField= new Ext.form.NumberField({
		id: 'setmember_periodeaktifField',
		name: 'setmember_periodeaktif',
		fieldLabel: 'Masa Aktif (Hari)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	/* Identify  setmember_periodetenggang Field */
	/*setmember_periodetenggangField= new Ext.form.NumberField({
		id: 'setmember_periodetenggangField',
		name:'setmember_periodetenggang',
		fieldLabel: 'Masa Tenggang (Hari)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	/* Identify  setmember_transtenggang Field */
	/*setmember_transtenggangField= new Ext.form.NumberField({
		id: 'setmember_transtenggangField',
		name: 'setmember_transtenggang',
		fieldLabel: 'Transaksi minimal masa Tenggang',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	setmember_pointtenggangField= new Ext.form.NumberField({
		id: 'setmember_pointtenggangField',
		name: 'setmember_pointtenggang',
		fieldLabel: 'Point Minimum  masa tenggang',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	/* Function for retrieve create Window Panel*/ 
	iklan_today_saveForm = new Ext.FormPanel({
		url: 'index.php?c=c_iklan_today&m=get_action',
		baseParams:{task: "LIST", start: 0, limit: 1},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'iklantoday_id'
		},[
		/* dataIndex => insert intoiklan_today_ColumnModel, Mapping => for initiate table column */ 
			//{name: 'setmember_id', type: 'int', mapping: 'setmember_id'}, 
			{name: 'iklantoday_id', type: 'int', mapping: 'iklantoday_id'},
			{name: 'iklantoday_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'iklantoday_tanggal'},
			{name: 'iklantoday_keterangan', type: 'string', mapping: 'iklantoday_keterangan'}, 	
			{name: 'iklantoday_author', type: 'string', mapping: 'iklantoday_author'}, 
			{name: 'iklantoday_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'iklantoday_date_create'}, 
			{name: 'iklantoday_update', type: 'string', mapping: 'setmember_update'}, 
			{name: 'iklantoday_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'iklantoday_date_update'}, 
			{name: 'iklantoday_revised', type: 'int', mapping: 'iklantoday_revised'}
			/*{name: 'setmember_transhari', type: 'float', mapping: 'setmember_transhari'}, 
			{name: 'setmember_pointhari', type: 'int', mapping: 'setmember_pointhari'}, 
			{name: 'setmember_transbulan', type: 'float', mapping: 'setmember_transbulan'},
			{name: 'setmember_pointbulan', type: 'int', mapping: 'setmember_pointbulan'}, 
			{name: 'setmember_periodeaktif', type: 'int', mapping: 'setmember_periodeaktif'}, 
			{name: 'setmember_periodetenggang', type: 'int', mapping: 'setmember_periodetenggang'}, 
			{name: 'setmember_transtenggang', type: 'float', mapping: 'setmember_transtenggang'},
			{name: 'setmember_pointtenggang', type: 'int', mapping: 'setmember_pointtenggang'},
			{name: 'setmember_author', type: 'string', mapping: 'setmember_author'}, 
			{name: 'setmember_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setmember_date_create'}, 
			{name: 'setmember_update', type: 'string', mapping: 'setmember_update'}, 
			{name: 'setmember_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setmember_date_update'}, 
			{name: 'setmember_revised', type: 'int', mapping: 'setmember_revised'} */
		]),
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [iklantoday_tanggalField, iklantoday_keteranganField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: function(){
					iklan_today_save();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
			,{
				text: 'Cancel',
				handler: function(){
					iklan_today_saveWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	
	
	/* Function for retrieve create Window Form */
	iklan_today_saveWindow= new Ext.Window({
		id: 'iklan_today_saveWindow',
		title: post2db+' Promo Hari Ini',
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
		renderTo: 'elwindow_iklantoday_save',
		items: iklan_today_saveForm
	});
	/* End Window */
	iklan_today_saveForm.getForm().load();
	iklan_today_saveWindow.show();
/*	iklan_today_saveWindow.on("hide",function(){
		mainPanel.remove(mainPanel.getActiveTab().getId());										
	});*/
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_iklan_today"></div>
		<div id="elwindow_iklantoday_save"></div>
        <div id="elwindow_iklantoday_search"></div>
    </div>
</div>
</body>
</html>