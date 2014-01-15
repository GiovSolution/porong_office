<?php
/* 	
	+ Module  		: crm_setup View
	+ Description	: For record view
	+ Filename 		: v_crm_setup.php
 	+ creator  		:  Fred

	
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

var crm_setup_DataStore;
var crm_setup_saveForm;
var crm_setup_saveWindow;

//declare konstant
var post2db = 'UPDATE';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var setcrm_idField;
var setcrm_frequency_yearField;
var setcrm_frequency_monthField;
var setcrm_frequency_morethan_Field;
var setcrm_frequency_equal_Field;
var setcrm_frequency_lessthan_Field;

var setcrm_recency_daysField;
var setcrm_recency_morethan_Field;
//var setcrm_recency_equal_Field;
var setcrm_recency_lessthan_Field;

var setcrm_spending_daysField;
var setcrm_spending_morethan_Field;
var setcrm_spending_equal_Field;
var setcrm_spending_lessthan_Field;

var setcrm_highmargin_treatment1Field;
var setcrm_highmargin_treatment2Field;
var setcrm_highmargin_morethan_Field;
var setcrm_highmargin_equal_Field;
var setcrm_highmargin_lessthan_Field;

var setcrm_referaldate_personField;
var setcrm_referaldate_monthField;
var setcrm_referaldate_morethan_Field;
var setcrm_referaldate_equal_Field;
var setcrm_referaldate_lessthan_Field;

var setcrm_kerewelan_high_Field;
var setcrm_kerewelan_normal_Field;
var setcrm_kerewelan_low_Field;

var setcrm_disiplin_high_Field;
var setcrm_disiplin_normal_Field;
var setcrm_disiplin_low_Field;
var setcrm_disiplin_daysField;
var setcrm_disiplin_persentase_pembatalan_Field;
var setcrm_disiplin_batal_value_morethan_Field;
var setcrm_disiplin_batal_value_lessthan_Field;
var setcrm_disiplin_menit_telat_Field;
var setcrm_disiplin_persentase_telat_Field;
var setcrm_disiplin_telat_value_morethan_Field;
var setcrm_disiplin_telat_value_lessthan_Field;

var setcrm_jenistreatment_monthField;
var setcrm_jenistreatment_nonmedisField;
var setcrm_jenistreatment_medisField;
var setcrm_jenistreatment_morethan_Field;
var setcrm_jenistreatment_equal_Field;
var setcrm_jenistreatment_lessthan_Field;

var set_crm_result_nilai_atas_Field;
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	/* Function for add and edit data form, open window form */
	function crm_setup_save(){
	
		if(is_crm_setup_form_valid()){	
			var setcrm_id_field_pk=null; 
			var setcrm_frequency_year_field=null; 
			var setcrm_frequency_month_field=null;
			var setcrm_frequency_morethan_field_save=null;
			var setcrm_frequency_equal_field_save=null;
			var setcrm_frequency_lessthan_field_save=null;
			
			var setcrm_recency_month_field=null;
			var setcrm_recency_morethan_field_save=null;
			var setcrm_recency_equal_field_save=null;
			var setcrm_recency_lessthan_field_save=null;
			
			var setcrm_spending_day_field=null;
			var setcrm_spending_morethan_field_save=null;
			var setcrm_spending_equal_field_save=null;
			var setcrm_spending_lessthan_field_save=null;
			
			var setcrm_highmargin_treatment1Field_save=null;
			var setcrm_highmargin_treatment2Field_save=null;
			var setcrm_highmargin_morethan_Field_save=null;
			var setcrm_highmargin_equal_Field_save=null;
			var setcrm_highmargin_lessthan_Field_save=null;
			
			var setcrm_referaldate_personField_save=null;
			var setcrm_referaldate_monthField_save=null;
			var setcrm_referaldate_morethan_Field_save=null;
			var setcrm_referaldate_equal_Field_save=null;
			var setcrm_referaldate_lessthan_Field_save=null;
			
			var setcrm_kerewelan_high_Field_save=null;
			var setcrm_kerewelan_normal_Field_save=null;
			var setcrm_kerewelan_low_Field_save=null;
			
			//var setcrm_disiplin_high_Field_save=null;
			//var setcrm_disiplin_normal_Field_save=null;
			//var setcrm_disiplin_low_Field_save=null;
			var setcrm_disiplin_daysField_save=null;
			var setcrm_disiplin_persentase_pembatalan_Field_save=null;
			var setcrm_disiplin_batal_value_morethan_Field_save=null;
			var setcrm_disiplin_batal_value_lessthan_Field_save=null;
			var setcrm_disiplin_menit_telat_Field_save=null;
			var setcrm_disiplin_persentase_telat_Field_save=null;
			var setcrm_disiplin_telat_value_morethan_Field_save=null;
			var setcrm_disiplin_telat_value_lessthan_Field_save=null;
			
			var setcrm_jenistreatment_monthField_save=null;
			var setcrm_jenistreatment_nonmedisField_save=null;
			var setcrm_jenistreatment_medisField_save=null;
			var setcrm_jenistreatment_morethan_Field_save=null;
			var setcrm_jenistreatment_equal_Field_save=null;
			var setcrm_jenistreatment_lessthan_Field_save=null;
			
			var setcrm_result_nilai_atas_Field_save=null;
			var setcrm_result_nilai_bawah_Field_save=null;
			

			if(setcrm_frequency_yearField.getValue()!== null){setcrm_frequency_year_field = setcrm_frequency_yearField.getValue();}
			if(setcrm_frequency_monthField.getValue()!== null){setcrm_frequency_month_field = setcrm_frequency_monthField.getValue();}
			if(setcrm_frequency_morethan_Field.getValue()!== null){setcrm_frequency_morethan_field_save = setcrm_frequency_morethan_Field.getValue();}
			if(setcrm_frequency_equal_Field.getValue()!== null){setcrm_frequency_equal_field_save = setcrm_frequency_equal_Field.getValue();}
			if(setcrm_frequency_lessthan_Field.getValue()!== null){setcrm_frequency_lessthan_field_save = setcrm_frequency_lessthan_Field.getValue();}
			
			if(setcrm_recency_daysField.getValue()!== null){setcrm_recency_month_field = setcrm_recency_daysField.getValue();} 
			if(setcrm_recency_morethan_Field.getValue()!== null){setcrm_recency_morethan_field_save = setcrm_recency_morethan_Field.getValue();}
			//if(setcrm_recency_equal_Field.getValue()!== null){setcrm_recency_equal_field_save = setcrm_recency_equal_Field.getValue();}			
			if(setcrm_recency_lessthan_Field.getValue()!== null){setcrm_recency_lessthan_field_save = setcrm_recency_lessthan_Field.getValue();}
			
			if(setcrm_spending_daysField.getValue()!== null){setcrm_spending_day_field = setcrm_spending_daysField.getValue();} 
			if(setcrm_spending_morethan_Field.getValue()!== null){setcrm_spending_morethan_field_save = setcrm_spending_morethan_Field.getValue();} 
			if(setcrm_spending_equal_Field.getValue()!== null){setcrm_spending_equal_field_save = setcrm_spending_equal_Field.getValue();}
			if(setcrm_spending_lessthan_Field.getValue()!== null){setcrm_spending_lessthan_field_save = setcrm_spending_lessthan_Field.getValue();}
						
			if(setcrm_highmargin_treatment1Field.getValue()!== null){setcrm_highmargin_treatment1Field_save = setcrm_highmargin_treatment1Field.getValue();}
			if(setcrm_highmargin_treatment2Field.getValue()!== null){setcrm_highmargin_treatment2Field_save = setcrm_highmargin_treatment2Field.getValue();}
			if(setcrm_highmargin_morethan_Field.getValue()!== null){setcrm_highmargin_morethan_Field_save = setcrm_highmargin_morethan_Field.getValue();}
			if(setcrm_highmargin_equal_Field.getValue()!== null){setcrm_highmargin_equal_Field_save = setcrm_highmargin_equal_Field.getValue();}
			if(setcrm_highmargin_lessthan_Field.getValue()!== null){setcrm_highmargin_lessthan_Field_save = setcrm_highmargin_lessthan_Field.getValue();}			
						
			if(setcrm_referaldate_personField.getValue()!== null){setcrm_referaldate_personField_save = setcrm_referaldate_personField.getValue();}
			if(setcrm_referaldate_monthField.getValue()!== null){setcrm_referaldate_monthField_save = setcrm_referaldate_monthField.getValue();}
			if(setcrm_referaldate_morethan_Field.getValue()!== null){setcrm_referaldate_morethan_Field_save = setcrm_referaldate_morethan_Field.getValue();}
			if(setcrm_referaldate_equal_Field.getValue()!== null){setcrm_referaldate_equal_Field_save = setcrm_referaldate_equal_Field.getValue();}
			if(setcrm_referaldate_lessthan_Field.getValue()!== null){setcrm_referaldate_lessthan_Field_save = setcrm_referaldate_lessthan_Field.getValue();}			
						
			if(setcrm_kerewelan_high_Field.getValue()!== null){setcrm_kerewelan_high_Field_save = setcrm_kerewelan_high_Field.getValue();} 
			if(setcrm_kerewelan_normal_Field.getValue()!== null){setcrm_kerewelan_normal_Field_save = setcrm_kerewelan_normal_Field.getValue();}
			if(setcrm_kerewelan_low_Field.getValue()!== null){setcrm_kerewelan_low_Field_save = setcrm_kerewelan_low_Field.getValue();}
		
			//if(setcrm_disiplin_high_Field.getValue()!== null){setcrm_disiplin_high_Field_save = setcrm_disiplin_high_Field.getValue();} 
			//if(setcrm_disiplin_normal_Field.getValue()!== null){setcrm_disiplin_normal_Field_save = setcrm_disiplin_normal_Field.getValue();}
			//if(setcrm_disiplin_low_Field.getValue()!== null){setcrm_disiplin_low_Field_save = setcrm_disiplin_low_Field.getValue();}
			if(setcrm_disiplin_daysField.getValue()!== null){setcrm_disiplin_daysField_save = setcrm_disiplin_daysField.getValue();}
			if(setcrm_disiplin_persentase_pembatalan_Field.getValue()!== null){setcrm_disiplin_persentase_pembatalan_Field_save = setcrm_disiplin_persentase_pembatalan_Field.getValue();}
			if(setcrm_disiplin_batal_value_morethan_Field.getValue()!== null){setcrm_disiplin_batal_value_morethan_Field_save = setcrm_disiplin_batal_value_morethan_Field.getValue();}
			if(setcrm_disiplin_batal_value_lessthan_Field.getValue()!== null){setcrm_disiplin_batal_value_lessthan_Field_save = setcrm_disiplin_batal_value_lessthan_Field.getValue();}
			if(setcrm_disiplin_menit_telat_Field.getValue()!== null){setcrm_disiplin_menit_telat_Field_save = setcrm_disiplin_menit_telat_Field.getValue();}
			if(setcrm_disiplin_persentase_telat_Field.getValue()!== null){setcrm_disiplin_persentase_telat_Field_save = setcrm_disiplin_persentase_telat_Field.getValue();}
			if(setcrm_disiplin_telat_value_morethan_Field.getValue()!== null){setcrm_disiplin_telat_value_morethan_Field_save = setcrm_disiplin_telat_value_morethan_Field.getValue();}
			if(setcrm_disiplin_telat_value_lessthan_Field.getValue()!== null){setcrm_disiplin_telat_value_lessthan_Field_save = setcrm_disiplin_telat_value_lessthan_Field.getValue();}
			

			if(setcrm_jenistreatment_monthField.getValue()!== null){setcrm_jenistreatment_monthField_save = setcrm_jenistreatment_monthField.getValue();} 
			if(setcrm_jenistreatment_nonmedisField.getValue()!== null){setcrm_jenistreatment_nonmedisField_save = setcrm_jenistreatment_nonmedisField.getValue();}
			if(setcrm_jenistreatment_medisField.getValue()!== null){setcrm_jenistreatment_medisField_save = setcrm_jenistreatment_medisField.getValue();}
			if(setcrm_jenistreatment_morethan_Field.getValue()!== null){setcrm_jenistreatment_morethan_Field_save = setcrm_jenistreatment_morethan_Field.getValue();} 
			if(setcrm_jenistreatment_equal_Field.getValue()!== null){setcrm_jenistreatment_equal_Field_save = setcrm_jenistreatment_equal_Field.getValue();}
			if(setcrm_jenistreatment_lessthan_Field.getValue()!== null){setcrm_jenistreatment_lessthan_Field_save = setcrm_jenistreatment_lessthan_Field.getValue();}
			
			if(setcrm_result_nilai_atas_Field.getValue()!== null){setcrm_result_nilai_atas_Field_save = setcrm_result_nilai_atas_Field.getValue();}
			if(setcrm_result_nilai_bawah_Field.getValue()!== null){setcrm_result_nilai_bawah_Field_save = setcrm_result_nilai_bawah_Field.getValue();} 
			
			
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_crm_setup&m=get_action',
				params: {
					setcrm_id							: setcrm_id_field_pk, 
					setcrm_frequency_count				: setcrm_frequency_year_field,
					setcrm_frequency_days				: setcrm_frequency_month_field,
					setcrm_frequency_value_morethan		: setcrm_frequency_morethan_field_save, 
					setcrm_frequency_value_equal		: setcrm_frequency_equal_field_save,
					setcrm_frequency_value_lessthan		: setcrm_frequency_lessthan_field_save,
					setcrm_recency_days					: setcrm_recency_month_field,
					setcrm_recency_value_morethan		: setcrm_recency_morethan_field_save,
					//setcrm_recency_value_equal			: setcrm_recency_equal_field_save,
					setcrm_recency_value_lessthan		: setcrm_recency_lessthan_field_save,
					setcrm_spending_days				: setcrm_spending_day_field,
					setcrm_spending_value_morethan		: setcrm_spending_morethan_field_save,
					setcrm_spending_value_equal			: setcrm_spending_equal_field_save,
					setcrm_spending_value_lessthan		: setcrm_spending_lessthan_field_save,
					setcrm_highmargin_treatment			: setcrm_highmargin_treatment1Field_save,
					setcrm_highmargin_days				: setcrm_highmargin_treatment2Field_save,
					setcrm_highmargin_value_morethan	: setcrm_highmargin_morethan_Field_save,
					setcrm_highmargin_value_equal		: setcrm_highmargin_equal_Field_save,
					setcrm_highmargin_value_lessthan	: setcrm_highmargin_lessthan_Field_save,
					setcrm_referal_person				: setcrm_referaldate_personField_save,
					setcrm_referal_days					: setcrm_referaldate_monthField_save,
					setcrm_referal_morethan				: setcrm_referaldate_morethan_Field_save,
					setcrm_referal_equal				: setcrm_referaldate_equal_Field_save,
					setcrm_referal_lessthan				: setcrm_referaldate_lessthan_Field_save,
					setcrm_kerewelan_high				: setcrm_kerewelan_high_Field_save,
					setcrm_kerewelan_normal				: setcrm_kerewelan_normal_Field_save,
					setcrm_kerewelan_low				: setcrm_kerewelan_low_Field_save,
					//setcrm_disiplin_high				: setcrm_disiplin_high_Field_save,
					//setcrm_disiplin_normal				: setcrm_disiplin_normal_Field_save,
					//setcrm_disiplin_low					: setcrm_disiplin_low_Field_save,
					setcrm_disiplin_days				: setcrm_disiplin_daysField_save,
					setcrm_disiplin_persentase_pembatalan : setcrm_disiplin_persentase_pembatalan_Field_save,
					setcrm_disiplin_batal_value_morethan: setcrm_disiplin_batal_value_morethan_Field_save,
					setcrm_disiplin_batal_value_lessthan: setcrm_disiplin_batal_value_lessthan_Field_save,
					setcrm_disiplin_menit_telat			: setcrm_disiplin_menit_telat_Field_save,
					setcrm_disiplin_persentase_telat	: setcrm_disiplin_persentase_telat_Field_save,
					setcrm_disiplin_telat_value_morethan: setcrm_disiplin_telat_value_morethan_Field_save,
					setcrm_disiplin_telat_value_lessthan: setcrm_disiplin_telat_value_lessthan_Field_save,
					setcrm_treatment_days				: setcrm_jenistreatment_monthField_save,
					setcrm_treatment_nonmedis			: setcrm_jenistreatment_nonmedisField_save,
					setcrm_treatment_medis				: setcrm_jenistreatment_medisField_save,
					setcrm_treatment_morethan			: setcrm_jenistreatment_morethan_Field_save,
					setcrm_treatment_equal				: setcrm_jenistreatment_equal_Field_save,
					setcrm_treatment_lessthan			: setcrm_jenistreatment_lessthan_Field_save,
					setcrm_result_nilai_atas			: setcrm_result_nilai_atas_Field_save,
					setcrm_result_nilai_bawah			: setcrm_result_nilai_bawah_Field_save,
					task						: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Setup CRM berhasil disimpan.');
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' CRM Setup.',
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
	function is_crm_setup_form_valid(){
		return (setcrm_frequency_yearField.isValid());
	}
  	/* End of Function */
  
	crm_setup_DataStore = new Ext.data.Store({
		id: 'crm_setup_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_crm_setup&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'setcrm_id'
		},[
		/* dataIndex => insert intomember_setup_ColumnModel, Mapping => for initiate table column */ 
			{name: 'setcrm_id', type: 'int', mapping: 'setcrm_id'}, 
			{name: 'setcrm_frequency_count', type: 'float', mapping: 'setcrm_frequency_count'}, 
			{name: 'setcrm_frequency_days', type: 'float', mapping: 'setcrm_frequency_days'}, 
			{name: 'setcrm_frequency_value_morethan', type: 'float', mapping: 'setcrm_frequency_value_morethan'},
			{name: 'setcrm_frequency_value_equal', type: 'float', mapping: 'setcrm_frequency_value_equal'}, 
			{name: 'setcrm_frequency_value_lessthan', type: 'float', mapping: 'setcrm_frequency_value_lessthan'}, 
			{name: 'setcrm_recency_days', type: 'float', mapping: 'setcrm_recency_days'}, 
			{name: 'setcrm_recency_value_morethan', type: 'float', mapping: 'setcrm_recency_value_morethan'},
			//{name: 'setcrm_recency_value_equal', type: 'float', mapping: 'setcrm_recency_value_equal'},
			{name: 'setcrm_recency_value_lessthan', type: 'float', mapping: 'setcrm_recency_value_lessthan'},
			{name: 'setcrm_spending_days', type: 'float', mapping: 'setcrm_spending_days'}, 
			{name: 'setcrm_spending_value_morethan', type: 'float', mapping: 'setcrm_spending_value_morethan'},
			{name: 'setcrm_spending_value_equal', type: 'float', mapping: 'setcrm_spending_value_equal'},
			{name: 'setcrm_spending_value_lessthan', type: 'float', mapping: 'setcrm_spending_value_lessthan'}, 
			{name: 'setcrm_highmargin_treatment', type: 'float', mapping: 'setcrm_highmargin_treatment'},
			{name: 'setcrm_highmargin_days', type: 'float', mapping: 'setcrm_highmargin_days'},
			{name: 'setcrm_highmargin_value_morethan', type: 'float', mapping: 'setcrm_highmargin_value_morethan'},
			{name: 'setcrm_highmargin_value_equal', type: 'float', mapping: 'setcrm_highmargin_value_equal'},
			{name: 'setcrm_highmargin_value_lessthan', type: 'float', mapping: 'setcrm_highmargin_value_lessthan'},
			{name: 'setcrm_referal_person', type: 'float', mapping: 'setcrm_referal_person'}, 
			{name: 'setcrm_referal_days', type: 'float', mapping: 'setcrm_referal_days'}, 
			{name: 'setcrm_referal_morethan', type: 'float', mapping: 'setcrm_referal_morethan'},
			{name: 'setcrm_referal_equal', type: 'float', mapping: 'setcrm_referal_equal'}, 
			{name: 'setcrm_referal_lessthan', type: 'float', mapping: 'setcrm_referal_lessthan'}, 
			{name: 'setcrm_kerewelan_high', type: 'float', mapping: 'setcrm_kerewelan_high'}, 
			{name: 'setcrm_kerewelan_normal', type: 'float', mapping: 'setcrm_kerewelan_normal'},
			{name: 'setcrm_kerewelan_low', type: 'float', mapping: 'setcrm_kerewelan_low'},
			{name: 'setcrm_disiplin_days', type: 'float', mapping: 'setcrm_disiplin_days'},
			{name: 'setcrm_disiplin_persentase_pembatalan', type: 'float', mapping: 'setcrm_disiplin_persentase_pembatalan'},
			{name: 'setcrm_disiplin_persentase_telat', type: 'float', mapping: 'setcrm_disiplin_persentase_telat'}, 
			{name: 'setcrm_disiplin_menit_telat', type: 'float', mapping: 'setcrm_disiplin_menit_telat'},
			{name: 'setcrm_disiplin_batal_value_morethan', type: 'float', mapping: 'setcrm_disiplin_batal_value_morethan'},
			{name: 'setcrm_disiplin_batal_value_lessthan', type: 'float', mapping: 'setcrm_disiplin_batal_value_lessthan'},
			{name: 'setcrm_disiplin_telat_value_morethan', type: 'float', mapping: 'setcrm_disiplin_telat_value_morethan'},
			{name: 'setcrm_disiplin_telat_value_lessthan', type: 'float', mapping: 'setcrm_disiplin_telat_value_lessthan'},
			{name: 'setcrm_treatment_days', type: 'float', mapping: 'setcrm_treatment_days'}, 
			{name: 'setcrm_treatment_nonmedis', type: 'float', mapping: 'setcrm_treatment_nonmedis'},
			{name: 'setcrm_treatment_medis', type: 'float', mapping: 'setcrm_treatment_medis'}, 
			{name: 'setcrm_treatment_morethan', type: 'float', mapping: 'setcrm_treatment_morethan'}, 
			{name: 'setcrm_treatment_equal', type: 'float', mapping: 'setcrm_treatment_equal'}, 
			{name: 'setcrm_treatment_lessthan', type: 'float', mapping: 'setcrm_treatment_lessthan'},
			{name: 'setcrm_result_nilai_atas', type: 'float', mapping: 'setcrm_result_nilai_atas'},
			{name: 'setcrm_result_nilai_bawah', type: 'float', mapping: 'setcrm_result_nilai_bawah'},
			{name: 'setcrm_author', type: 'string', mapping: 'setcrm_author'}, 
			{name: 'setcrm_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setcrm_date_create'}, 
			{name: 'setcrm_update', type: 'string', mapping: 'setcrm_update'}, 
			{name: 'setcrm_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setcrm_date_update'}, 
			{name: 'setcrm_revised', type: 'int', mapping: 'setcrm_revised'}
		]),
		sortInfo:{field: 'setcrm_id', direction: "DESC"}
	});
  
  
  	
	setcrm_frequency_yearField=new Ext.form.NumberField({
		id: 'setcrm_frequency_yearField',
		name : 'setcrm_frequency_count',
		anchor : '25%',
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11,
		width : 50
	});
    
	setcrm_frequency_monthField=new Ext.form.NumberField({
		id: 'setcrm_frequency_monthField',
		name : 'setcrm_frequency_days',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	
	});
		
	setcrm_frequency_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_frequency_morethan_Field',
		name: 'setcrm_frequency_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> > </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_frequency_equal_Field= new Ext.form.NumberField({
		id: 'setcrm_frequency_equal_Field',
		name: 'setcrm_frequency_value_equal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> = </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_frequency_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_frequency_lessthan_Field',
		name: 'setcrm_frequency_value_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < </span>',
		allowNegatife : false,
		blankText: '7,5',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_recency_daysField=new Ext.form.NumberField({
		id: 'setcrm_recency_daysField',
		name : 'setcrm_recency_days',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_recency_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_recency_morethan_Field',
		name: 'setcrm_recency_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> > </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	/*
	setcrm_recency_equal_Field= new Ext.form.NumberField({
		id: 'setcrm_recency_equal_Field',
		name: 'setcrm_recency_value_equal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> = </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	*/
	setcrm_recency_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_recency_lessthan_Field',
		name: 'setcrm_recency_value_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> <= </span>',
		allowNegatife : false,
		blankText: '7,5',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_spending_daysField=new Ext.form.NumberField({
		id: 'setcrm_spending_daysField',
		name : 'setcrm_spending_days',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	
	
	setcrm_spending_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_spending_morethan_Field',
		name: 'setcrm_spending_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> > Average </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_spending_equal_Field= new Ext.form.NumberField({
		id: 'setcrm_spending_equal_Field',
		name: 'setcrm_spending_value_equal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> = Average </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_spending_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_spending_lessthan_Field',
		name: 'setcrm_spending_value_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < Average </span>',
		allowNegatife : false,
		blankText: '7,5',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_highmargin_treatment1Field=new Ext.form.NumberField({
		id: 'setcrm_highmargin_treatment1Field',
		name : 'setcrm_highmargin_treatment',
		anchor : '25%',
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11,
		width : 50
	});
	
	setcrm_highmargin_treatment2Field=new Ext.form.NumberField({
		id: 'setcrm_highmargin_treatment2Field',
		name : 'setcrm_highmargin_days',
		anchor : '25%',
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11,
		width : 50
	});
	
	setcrm_highmargin_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_highmargin_morethan_Field',
		name: 'setcrm_highmargin_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> > </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_highmargin_equal_Field= new Ext.form.NumberField({
		id: 'setcrm_highmargin_equal_Field',
		name: 'setcrm_highmargin_value_equal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> = </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_highmargin_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_highmargin_lessthan_Field',
		name: 'setcrm_highmargin_value_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < </span>',
		allowNegatife : false,
		blankText: '7,5',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_referaldate_personField=new Ext.form.NumberField({
		id: 'setcrm_referaldate_personField',
		name : 'setcrm_referal_person',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_referaldate_monthField=new Ext.form.NumberField({
		id: 'setcrm_referaldate_monthField',
		name : 'setcrm_referal_days',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_referaldate_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_referaldate_morethan_Field',
		name: 'setcrm_referal_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> > </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_referaldate_equal_Field= new Ext.form.NumberField({
		id: 'setcrm_referaldate_equal_Field',
		name: 'setcrm_referal_equal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> = </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_referaldate_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_referaldate_lessthan_Field',
		name: 'setcrm_referal_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < </span>',
		allowNegatife : false,
		blankText: '7,5',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_kerewelan_high_Field= new Ext.form.NumberField({
		id: 'setcrm_kerewelan_high_Field',
		name: 'setcrm_kerewelan_high',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> High </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_kerewelan_normal_Field= new Ext.form.NumberField({
		id: 'setcrm_kerewelan_normal_Field',
		name: 'setcrm_kerewelan_normal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Normal </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_kerewelan_low_Field= new Ext.form.NumberField({
		id: 'setcrm_kerewelan_low_Field',
		name: 'setcrm_kerewelan_low',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Low </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	
	/*
	setcrm_disiplin_high_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_high_Field',
		name: 'setcrm_disiplin_high',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> High </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_disiplin_normal_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_normal_Field',
		name: 'setcrm_disiplin_normal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Normal </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_disiplin_low_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_low_Field',
		name: 'setcrm_disiplin_low',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Low </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});*/
	
	setcrm_disiplin_daysField=new Ext.form.NumberField({
		id: 'setcrm_disiplin_daysField',
		name : 'setcrm_disiplin_days',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_disiplin_persentase_pembatalan_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_persentase_pembatalan_Field',
		name: 'setcrm_disiplin_persentase_pembatalan',
		//fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Pembatalan </span>',
		allowNegatife : false,
		//blankText: '15',
		allowDecimals: true,
		anchor: '15%',
		width : 30,
		maxLength : 11		
	});
	
	setcrm_disiplin_batal_value_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_batal_value_morethan_Field',
		name: 'setcrm_disiplin_batal_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> >= </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_disiplin_batal_value_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_batal_value_lessthan_Field',
		name: 'setcrm_disiplin_batal_value_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_disiplin_persentase_telat_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_persentase_telat_Field',
		name: 'setcrm_disiplin_persentase_telat',
		//fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Telat </span>',
		allowNegatife : false,
		//blankText: '15',
		allowDecimals: true,
		anchor: '15%',
		width : 30,
		maxLength : 11		
	});
	
	setcrm_disiplin_menit_telat_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_menit_telat_Field',
		name: 'setcrm_disiplin_menit_telat',
		//fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> Telat </span>',
		allowNegatife : false,
		//blankText: '15',
		allowDecimals: true,
		anchor: '20%',
		width : 40,
		maxLength : 11		
	});
	
	
	setcrm_disiplin_telat_value_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_telat_value_morethan_Field',
		name: 'setcrm_disiplin_telat_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> >= </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_disiplin_telat_value_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_disiplin_telat_value_lessthan_Field',
		name: 'setcrm_disiplin_telat_value_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	
	setcrm_jenistreatment_monthField=new Ext.form.NumberField({
		id: 'setcrm_jenistreatment_monthField',
		name : 'setcrm_treatment_days',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_jenistreatment_nonmedisField=new Ext.form.NumberField({
		id: 'setcrm_jenistreatment_nonmedisField',
		name : 'setcrm_treatment_nonmedis',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_jenistreatment_medisField=new Ext.form.NumberField({
		id: 'setcrm_jenistreatment_medisField',
		name : 'setcrm_treatment_medis',
		anchor : '25%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11
	});
	
	setcrm_jenistreatment_morethan_Field= new Ext.form.NumberField({
		id: 'setcrm_jenistreatment_morethan_Field',
		name: 'setcrm_treatment_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> > Non Medis & > Medis </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_jenistreatment_equal_Field= new Ext.form.NumberField({
		id: 'setcrm_jenistreatment_equal_Field',
		name: 'setcrm_treatment_equal',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> = Non Medis & = Medis </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	setcrm_jenistreatment_lessthan_Field= new Ext.form.NumberField({
		id: 'setcrm_jenistreatment_lessthan_Field',
		name: 'setcrm_treatment_lessthan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> < Non Medis || < Medis </span>',
		allowNegatife : false,
		blankText: '15',
		allowDecimals: true,
		anchor: '65%',
		maskRe: /([0-9]+)$/
	});
	
	
	setcrm_result_nilai_atas_Field= new Ext.form.NumberField({		
		id: 'setcrm_result_nilai_atas_Field',
		name : 'setcrm_result_nilai_atas',
		anchor : '65%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11

	});
	
	setcrm_result_nilai_bawah_Field= new Ext.form.NumberField({		
		id: 'setcrm_result_nilai_bawah_Field',
		name : 'setcrm_result_nilai_bawah',
		anchor : '65%',
		width : 50,
		allowDecimals : true,
		allowNegative : false,
		maxLength : 11

	});
	
	set_crm_frequency_label_divideField=new Ext.form.Label({ html: '&nbsp; / &nbsp;'});
	set_crm_highmargin_treatment1_label_divideField=new Ext.form.Label({ html: 'Treatment &nbsp;'});
	set_crm_highmargin_treatment2_label_divideField=new Ext.form.Label({ html: '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Treatment &nbsp;'});
	set_crm_highmargin_label_divideField=new Ext.form.Label({ html: '/ &nbsp;'});
	set_crm_referaldate_label_divideField=new Ext.form.Label({ html: '&nbsp; / &nbsp;'});
	set_crm_disiplin_label_pembatalanField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Pembatalan<b> &nbsp;'});
	set_crm_disiplin_label_telatField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Keterlambatan<b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	set_crm_disiplin_label_telat_menitField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Batas Keterlambatan<b> &nbsp;'});
	
	set_crm_frequency_label_monthField=new Ext.form.Label({ html: '&nbsp; days'});
	set_crm_recency_label_daysField=new Ext.form.Label({ html: '&nbsp; days'});
	set_crm_spending_label_daysField=new Ext.form.Label({ html: '&nbsp; days'});
	set_crm_highmargin_label_monthField=new Ext.form.Label({ html: '&nbsp; days'});
	set_crm_referaldate_label_personField=new Ext.form.Label({ html: '&nbsp; cust'});
	set_crm_referaldate_label_monthField=new Ext.form.Label({ html: '&nbsp; days'});
	set_crm_disiplin_label_daysField=new Ext.form.Label({ html: '&nbsp; days <br> <br> <br>'});
	set_crm_jenistreatment_label_monthField=new Ext.form.Label({ html: '&nbsp; days <br> <br>'});
	
	set_crm_frequency_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_recency_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_spending_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_highmargin_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_referaldate_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_kerewelan_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_disiplin_label_value_batalField=new Ext.form.Label({ html: 'Value : &nbsp; '});
	set_crm_disiplin_label_value_telatField=new Ext.form.Label({ html: 'Value : &nbsp; '});
	set_crm_result_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	set_crm_jenistreatment_label_valueField=new Ext.form.Label({ html: '<br>Value : &nbsp; '});
	
	set_crm_disiplin_label_persentase_batalField=new Ext.form.Label({ html: '%'});
	set_crm_disiplin_label_persentase_telatField=new Ext.form.Label({ html: '%'});
	set_crm_disiplin_label_menit_telatField=new Ext.form.Label({ html: 'menit<br> <br>'});
	
	set_crm_disiplin_batasField=new Ext.form.Label({ html: '<br> --------------------------------------------------------------------------------------------------------------------<br><br>'});
	
	set_crm_result_label_coreField=new Ext.form.Label({ html: '&nbsp; Core > &nbsp;'});
	set_crm_result_label_mediumField=new Ext.form.Label({ html: '&nbsp; >= Medium >= &nbsp;'});
	set_crm_result_label_lowField=new Ext.form.Label({ html: '&nbsp; > Low &nbsp;'});
	
	set_crm_jenistreatment_label_nonmedisField=new Ext.form.Label({ html: '&nbsp; Non Medis &nbsp; &nbsp; &nbsp; &nbsp;'});
	set_crm_jenistreatment_label_medisField=new Ext.form.Label({ html: '&nbsp; Medis'});
	
	set_crm_frequency_setField=new Ext.form.FieldSet({
		id:'set_crm_frequency_setField',
		title: 'Frequency',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{	
			   		layout	: 'column',
					border: false,
					items	: [setcrm_frequency_yearField, set_crm_frequency_label_divideField, setcrm_frequency_monthField,set_crm_frequency_label_monthField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_frequency_label_valueField , setcrm_frequency_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_frequency_equal_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_frequency_lessthan_Field]
			   },
		]
	});
	
	set_crm_recency_setField=new Ext.form.FieldSet({
		id:'set_crm_recency_setField',
		title: 'Recency',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [setcrm_recency_daysField,set_crm_recency_label_daysField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_recency_label_valueField,setcrm_recency_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_recency_lessthan_Field]
			   },
		]
	});
	
	
	set_crm_spending_setField=new Ext.form.FieldSet({
		id:'set_crm_spending_setField',
		title: 'Spending',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[	{
					layout : 'column',
					border : false,
					items : [setcrm_spending_daysField, set_crm_spending_label_daysField]
				},
				{
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_spending_label_valueField ,setcrm_spending_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_spending_equal_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_spending_lessthan_Field]
			   },
			
		]
	});
	
	set_crm_highmargin_setField=new Ext.form.FieldSet({
		id:'set_crm_highmargin_setField',
		title: 'High Margin',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{	
			   		layout	: 'column',
					border: false,
					items	: [set_crm_highmargin_treatment1_label_divideField, setcrm_highmargin_treatment1Field,set_crm_highmargin_treatment2_label_divideField, set_crm_highmargin_label_divideField,setcrm_highmargin_treatment2Field,set_crm_highmargin_label_monthField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_highmargin_label_valueField , setcrm_highmargin_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_highmargin_equal_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_highmargin_lessthan_Field]
			   }
		]
	});
	
	set_crm_referaldate_setField=new Ext.form.FieldSet({
		id:'set_crm_referaldate_setField',
		title: 'Referal Rate',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [setcrm_referaldate_personField,set_crm_referaldate_label_personField,set_crm_referaldate_label_divideField,setcrm_referaldate_monthField,set_crm_referaldate_label_monthField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_referaldate_label_valueField , setcrm_referaldate_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_referaldate_equal_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_referaldate_lessthan_Field]
			   },
		]
	});
	
	set_crm_kerewelan_setField=new Ext.form.FieldSet({
		id:'set_crm_kerewelan_setField',
		title: 'Kerewelan',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_kerewelan_label_valueField ,setcrm_kerewelan_high_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_kerewelan_normal_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_kerewelan_low_Field]
			   },
			
		]
	});
	
	
	set_crm_disiplin_setField=new Ext.form.FieldSet({
		id:'set_crm_disiplin_setField',
		title: 'Disiplin',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
				   layout	: 'column',
				   border: false,
				   items	: [setcrm_disiplin_daysField, set_crm_disiplin_label_daysField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [set_crm_disiplin_label_pembatalanField, setcrm_disiplin_persentase_pembatalan_Field,set_crm_disiplin_label_persentase_batalField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_disiplin_label_value_batalField, setcrm_disiplin_batal_value_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_disiplin_batal_value_lessthan_Field,set_crm_disiplin_batasField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [set_crm_disiplin_label_telat_menitField, setcrm_disiplin_menit_telat_Field, set_crm_disiplin_label_menit_telatField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [set_crm_disiplin_label_telatField, setcrm_disiplin_persentase_telat_Field,set_crm_disiplin_label_persentase_telatField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_disiplin_label_value_telatField, setcrm_disiplin_telat_value_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_disiplin_telat_value_lessthan_Field]
			   },
			
		]
	});
	
	set_crm_jenis_treatment_setField=new Ext.form.FieldSet({
		id:'set_crm_jenis_treatment_setField',
		title: 'Jenis Treatment (Treatment Utama)',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
				   layout	: 'column',
				   border: false,
				   items	: [setcrm_jenistreatment_monthField ,set_crm_jenistreatment_label_monthField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [setcrm_jenistreatment_nonmedisField, set_crm_jenistreatment_label_nonmedisField , setcrm_jenistreatment_medisField, set_crm_jenistreatment_label_medisField]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [set_crm_jenistreatment_label_valueField,setcrm_jenistreatment_morethan_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_jenistreatment_equal_Field]
			   },
			     {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_jenistreatment_lessthan_Field]
			   },
		]
	});
	
	set_crm_result_setField=new Ext.form.FieldSet({
		id:'set_crm_result_setField',
		title: 'Result',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
				   layout	: 'column',
				   border: false,
				   items	: [set_crm_result_label_coreField, setcrm_result_nilai_atas_Field, set_crm_result_label_mediumField, setcrm_result_nilai_bawah_Field, set_crm_result_label_lowField]
			   }
			   /*,
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_disiplin_normal_Field]
			   },
			   {
				   layout	: 'form',
				   border: false,
				   items	: [setcrm_disiplin_low_Field]
			   },*/
			
		]
	});
	
	
	
	/* Function for retrieve create Window Panel*/ 
	crm_setup_saveForm = new Ext.FormPanel({
		url: 'index.php?c=c_crm_setup&m=get_action',
		baseParams:{task: "LIST", start: 0, limit: 1},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'setcrm_id'
		},[
		/* dataIndex => insert intomember_setup_ColumnModel, Mapping => for initiate table column */ 
			{name: 'setcrm_id', type: 'int', mapping: 'setcrm_id'}, 
			{name: 'setcrm_frequency_count', type: 'float', mapping: 'setcrm_frequency_count'}, 
			{name: 'setcrm_frequency_days', type: 'float', mapping: 'setcrm_frequency_days'}, 
			{name: 'setcrm_frequency_value_morethan', type: 'float', mapping: 'setcrm_frequency_value_morethan'},
			{name: 'setcrm_frequency_value_equal', type: 'float', mapping: 'setcrm_frequency_value_equal'}, 
			{name: 'setcrm_frequency_value_lessthan', type: 'float', mapping: 'setcrm_frequency_value_lessthan'}, 
			{name: 'setcrm_recency_days', type: 'float', mapping: 'setcrm_recency_days'}, 
			{name: 'setcrm_recency_value_morethan', type: 'float', mapping: 'setcrm_recency_value_morethan'},
			{name: 'setcrm_recency_value_equal', type: 'float', mapping: 'setcrm_recency_value_equal'},
			{name: 'setcrm_recency_value_lessthan', type: 'float', mapping: 'setcrm_recency_value_lessthan'},
			{name: 'setcrm_spending_days', type: 'float', mapping: 'setcrm_spending_days'}, 
			{name: 'setcrm_spending_value_morethan', type: 'float', mapping: 'setcrm_spending_value_morethan'},
			{name: 'setcrm_spending_value_equal', type: 'float', mapping: 'setcrm_spending_value_equal'},
			{name: 'setcrm_spending_value_lessthan', type: 'float', mapping: 'setcrm_spending_value_lessthan'}, 
			{name: 'setcrm_highmargin_treatment', type: 'float', mapping: 'setcrm_highmargin_treatment'},
			{name: 'setcrm_highmargin_days', type: 'float', mapping: 'setcrm_highmargin_days'},
			{name: 'setcrm_highmargin_value_morethan', type: 'float', mapping: 'setcrm_highmargin_value_morethan'},
			{name: 'setcrm_highmargin_value_equal', type: 'float', mapping: 'setcrm_highmargin_value_equal'},
			{name: 'setcrm_highmargin_value_lessthan', type: 'float', mapping: 'setcrm_highmargin_value_lessthan'},
			{name: 'setcrm_referal_person', type: 'float', mapping: 'setcrm_referal_person'}, 
			{name: 'setcrm_referal_days', type: 'float', mapping: 'setcrm_referal_days'}, 
			{name: 'setcrm_referal_morethan', type: 'float', mapping: 'setcrm_referal_morethan'},
			{name: 'setcrm_referal_equal', type: 'float', mapping: 'setcrm_referal_equal'}, 
			{name: 'setcrm_referal_lessthan', type: 'float', mapping: 'setcrm_referal_lessthan'}, 
			{name: 'setcrm_kerewelan_high', type: 'float', mapping: 'setcrm_kerewelan_high'}, 
			{name: 'setcrm_kerewelan_normal', type: 'float', mapping: 'setcrm_kerewelan_normal'},
			{name: 'setcrm_kerewelan_low', type: 'float', mapping: 'setcrm_kerewelan_low'},
			{name: 'setcrm_disiplin_days', type: 'float', mapping: 'setcrm_disiplin_days'},
			{name: 'setcrm_disiplin_persentase_pembatalan', type: 'float', mapping: 'setcrm_disiplin_persentase_pembatalan'},
			{name: 'setcrm_disiplin_persentase_telat', type: 'float', mapping: 'setcrm_disiplin_persentase_telat'}, 
			{name: 'setcrm_disiplin_menit_telat', type: 'float', mapping: 'setcrm_disiplin_menit_telat'},
			{name: 'setcrm_disiplin_batal_value_morethan', type: 'float', mapping: 'setcrm_disiplin_batal_value_morethan'},
			{name: 'setcrm_disiplin_batal_value_lessthan', type: 'float', mapping: 'setcrm_disiplin_batal_value_lessthan'},
			{name: 'setcrm_disiplin_telat_value_morethan', type: 'float', mapping: 'setcrm_disiplin_telat_value_morethan'},
			{name: 'setcrm_disiplin_telat_value_lessthan', type: 'float', mapping: 'setcrm_disiplin_telat_value_lessthan'},
			{name: 'setcrm_treatment_days', type: 'float', mapping: 'setcrm_treatment_days'}, 
			{name: 'setcrm_treatment_nonmedis', type: 'float', mapping: 'setcrm_treatment_nonmedis'},
			{name: 'setcrm_treatment_medis', type: 'float', mapping: 'setcrm_treatment_medis'}, 
			{name: 'setcrm_treatment_morethan', type: 'float', mapping: 'setcrm_treatment_morethan'}, 
			{name: 'setcrm_treatment_equal', type: 'float', mapping: 'setcrm_treatment_equal'}, 
			{name: 'setcrm_treatment_lessthan', type: 'float', mapping: 'setcrm_treatment_lessthan'},
			{name: 'setcrm_result_nilai_atas', type: 'float', mapping: 'setcrm_result_nilai_atas'},
			{name: 'setcrm_result_nilai_bawah', type: 'float', mapping: 'setcrm_result_nilai_bawah'},
			{name: 'setcrm_author', type: 'string', mapping: 'setcrm_author'}, 
			{name: 'setcrm_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setcrm_date_create'}, 
			{name: 'setcrm_update', type: 'string', mapping: 'setcrm_update'}, 
			{name: 'setcrm_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'setcrm_date_update'}, 
			{name: 'setcrm_revised', type: 'int', mapping: 'setcrm_revised'} 
		]),
		labelAlign: 'left',
		labelWidth: 250,
		bodyStyle:'padding:5px',
		autoHeight:true,
		layout : 'column',
		width: 500,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [set_crm_frequency_setField,set_crm_recency_setField,set_crm_spending_setField,set_crm_highmargin_setField,set_crm_referaldate_setField,set_crm_kerewelan_setField,set_crm_disiplin_setField,set_crm_jenis_treatment_setField, set_crm_result_setField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: function(){
					crm_setup_save();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
			,{
				text: 'Cancel',
				handler: function(){
					crm_setup_saveWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
					
				}
			}
		]
	});
	/* End  of Function*/
	
	
	
	/* Function for retrieve create Window Form */
	crm_setup_saveWindow= new Ext.Window({
		id: 'crm_setup_saveWindow',
		title: post2db+' CRM Setup',
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
		renderTo: 'elwindow_crm_setup_save',
		items: crm_setup_saveForm
	});
	/* End Window */
	crm_setup_saveForm.getForm().load();
	crm_setup_saveWindow.show();
/*	crm_setup_saveWindow.on("hide",function(){
		mainPanel.remove(mainPanel.getActiveTab().getId());										
	});*/
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_crm_setup"></div>
		<div id="elwindow_crm_setup_save"></div>
        <div id="elwindow_crm_setup_search"></div>
    </div>
</div>
</body>
</html>