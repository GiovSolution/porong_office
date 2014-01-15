<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: initial_assessment View
	+ Description	: For record view
	+ Filename 		: v_initial_assessment.php
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
var initial_assessment_DataStore;
var initial_assessment_ColumnModel;
var initial_assessmentListEditorGrid;
var initial_assessment_createForm;
var initial_assessment_createWindow;
var initial_assessment_searchForm;
var initial_assessment_searchWindow;
var initial_assessment_SelectedRow;
var initial_assessment_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var init_customerField;
var init_tanggalField;
var init_olehField;
var init_kulitwarnaField;
var init_kulittypeField;
var init_kulitminyakField;
var init_kulitpipiField;
var init_kulittField;
var init_kulittebalField;
var init_kulitrapuhField;
var init_kulitkendurField;
var init_melasmatypeField;
var init_melasmacentrofacialField;
var init_melasmamalarField;
var init_melasmamandibularField;
var init_hipepidermalField;
var init_hipdermalField;
var init_hippihField;
var init_hiplingkarmataField;
var init_hypopigmentField;
var init_acneField;
var init_acnelesionsField;
var init_acnetelangiectasisField;
var init_acnelocationField;
var init_wringkleslinesField;
var init_wringklesdinamicsField;
var init_wringklesstaticField;
var init_wringklesfoldField;
var init_wringkleslainField;
var init_otherskinlesionsField;
var init_cellulitegradeField;
var init_cellulitelocationField;
var init_strectmarkField;
var init_hairproblemField;
var init_heightField;
var init_weightField;
var init_idealweightField;
var init_bmiField;
var init_miscField;
var init_diagnosisField;
var init_ddxField;
var init_treatmentplanField;
var init_customerSearchField;
var init_tanggalSearchField;
var init_olehSearchField;
var init_kulitwarnaSearchField;
var init_kulittypeSearchField;
var init_kulitminyakSearchField;
var init_kulitpipiSearchField;
var init_kulittSearchField;
var init_kulittebalSearchField;
var init_kulitrapuhSearchField;
var init_kulitkendurSearchField;
var init_melasmatypeSearchField;
var init_melasmacentrofacialSearchField;
var init_melasmamalarSearchField;
var init_melasmamandibularSearchField;
var init_hipepidermalSearchField;
var init_hipdermalSearchField;
var init_hippihSearchField;
var init_hiplingkarmataSearchField;
var init_hypopigmentSearchField;
var init_acneSearchField;
var init_acnelesionsSearchField;
var init_acnetelangiectasisSearchField;
var init_acnelocationSearchField;
var init_wringkleslinesSearchField;
var init_wringklesdinamicsSearchField;
var init_wringklesstaticSearchField;
var init_wringklesfoldSearchField;
var init_wringkleslainSearchField;
var init_otherskinlesionsSearchField;
var init_cellulitegradeSearchField;
var init_cellulitelocationSearchField;
var init_strectmarkSearchField;
var init_hairproblemSearchField;
var init_heightSearchField;
var init_weightSearchField;
var init_idealweightSearchField;
var init_bmiSearchField;
var init_miscSearchField;
var init_diagnosisSearchField;
var init_ddxSearchField;
var init_treatmentplanSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function initial_assessment_update(oGrid_event){
	var init_customer_update_pk="";
	var init_tanggal_update_pk="";
	var init_oleh_update=null;
	var init_kulitwarna_update=null;
	var init_kulittype_update=null;
	var init_kulitminyak_update=null;
	var init_kulitpipi_update=null;
	var init_kulitt_update=null;
	var init_kulittebal_update=null;
	var init_kulitrapuh_update=null;
	var init_kulitkendur_update=null;
	var init_melasmatype_update=null;
	var init_melasmacentrofacial_update=null;
	var init_melasmamalar_update=null;
	var init_melasmamandibular_update=null;
	var init_hipepidermal_update=null;
	var init_hipdermal_update=null;
	var init_hippih_update=null;
	var init_hiplingkarmata_update=null;
	var init_hypopigment_update=null;
	var init_acne_update=null;
	var init_acnelesions_update=null;
	var init_acnetelangiectasis_update=null;
	var init_acnelocation_update=null;
	var init_wringkleslines_update=null;
	var init_wringklesdinamics_update=null;
	var init_wringklesstatic_update=null;
	var init_wringklesfold_update=null;
	var init_wringkleslain_update=null;
	var init_otherskinlesions_update=null;
	var init_cellulitegrade_update=null;
	var init_cellulitelocation_update=null;
	var init_strectmark_update=null;
	var init_hairproblem_update=null;
	var init_height_update=null;
	var init_weight_update=null;
	var init_idealweight_update=null;
	var init_bmi_update=null;
	var init_misc_update=null;
	var init_diagnosis_update=null;
	var init_ddx_update=null;
	var init_treatmentplan_update=null;

	init_customer_update_pk = get_pk_id();
	init_tanggal_update_pk = get_pk_id();
	if(oGrid_event.record.data.init_oleh!== null){init_oleh_update = oGrid_event.record.data.init_oleh;}
	if(oGrid_event.record.data.init_kulitwarna!== null){init_kulitwarna_update = oGrid_event.record.data.init_kulitwarna;}
	if(oGrid_event.record.data.init_kulittype!== null){init_kulittype_update = oGrid_event.record.data.init_kulittype;}
	if(oGrid_event.record.data.init_kulitminyak!== null){init_kulitminyak_update = oGrid_event.record.data.init_kulitminyak;}
	if(oGrid_event.record.data.init_kulitpipi!== null){init_kulitpipi_update = oGrid_event.record.data.init_kulitpipi;}
	if(oGrid_event.record.data.init_kulitt!== null){init_kulitt_update = oGrid_event.record.data.init_kulitt;}
	if(oGrid_event.record.data.init_kulittebal!== null){init_kulittebal_update = oGrid_event.record.data.init_kulittebal;}
	if(oGrid_event.record.data.init_kulitrapuh!== null){init_kulitrapuh_update = oGrid_event.record.data.init_kulitrapuh;}
	if(oGrid_event.record.data.init_kulitkendur!== null){init_kulitkendur_update = oGrid_event.record.data.init_kulitkendur;}
	if(oGrid_event.record.data.init_melasmatype!== null){init_melasmatype_update = oGrid_event.record.data.init_melasmatype;}
	if(oGrid_event.record.data.init_melasmacentrofacial!== null){init_melasmacentrofacial_update = oGrid_event.record.data.init_melasmacentrofacial;}
	if(oGrid_event.record.data.init_melasmamalar!== null){init_melasmamalar_update = oGrid_event.record.data.init_melasmamalar;}
	if(oGrid_event.record.data.init_melasmamandibular!== null){init_melasmamandibular_update = oGrid_event.record.data.init_melasmamandibular;}
	if(oGrid_event.record.data.init_hipepidermal!== null){init_hipepidermal_update = oGrid_event.record.data.init_hipepidermal;}
	if(oGrid_event.record.data.init_hipdermal!== null){init_hipdermal_update = oGrid_event.record.data.init_hipdermal;}
	if(oGrid_event.record.data.init_hippih!== null){init_hippih_update = oGrid_event.record.data.init_hippih;}
	if(oGrid_event.record.data.init_hiplingkarmata!== null){init_hiplingkarmata_update = oGrid_event.record.data.init_hiplingkarmata;}
	if(oGrid_event.record.data.init_hypopigment!== null){init_hypopigment_update = oGrid_event.record.data.init_hypopigment;}
	if(oGrid_event.record.data.init_acne!== null){init_acne_update = oGrid_event.record.data.init_acne;}
	if(oGrid_event.record.data.init_acnelesions!== null){init_acnelesions_update = oGrid_event.record.data.init_acnelesions;}
	if(oGrid_event.record.data.init_acnetelangiectasis!== null){init_acnetelangiectasis_update = oGrid_event.record.data.init_acnetelangiectasis;}
	if(oGrid_event.record.data.init_acnelocation!== null){init_acnelocation_update = oGrid_event.record.data.init_acnelocation;}
	if(oGrid_event.record.data.init_wringkleslines!== null){init_wringkleslines_update = oGrid_event.record.data.init_wringkleslines;}
	if(oGrid_event.record.data.init_wringklesdinamics!== null){init_wringklesdinamics_update = oGrid_event.record.data.init_wringklesdinamics;}
	if(oGrid_event.record.data.init_wringklesstatic!== null){init_wringklesstatic_update = oGrid_event.record.data.init_wringklesstatic;}
	if(oGrid_event.record.data.init_wringklesfold!== null){init_wringklesfold_update = oGrid_event.record.data.init_wringklesfold;}
	if(oGrid_event.record.data.init_wringkleslain!== null){init_wringkleslain_update = oGrid_event.record.data.init_wringkleslain;}
	if(oGrid_event.record.data.init_otherskinlesions!== null){init_otherskinlesions_update = oGrid_event.record.data.init_otherskinlesions;}
	if(oGrid_event.record.data.init_cellulitegrade!== null){init_cellulitegrade_update = oGrid_event.record.data.init_cellulitegrade;}
	if(oGrid_event.record.data.init_cellulitelocation!== null){init_cellulitelocation_update = oGrid_event.record.data.init_cellulitelocation;}
	if(oGrid_event.record.data.init_strectmark!== null){init_strectmark_update = oGrid_event.record.data.init_strectmark;}
	if(oGrid_event.record.data.init_hairproblem!== null){init_hairproblem_update = oGrid_event.record.data.init_hairproblem;}
	if(oGrid_event.record.data.init_height!== null){init_height_update = oGrid_event.record.data.init_height;}
	if(oGrid_event.record.data.init_weight!== null){init_weight_update = oGrid_event.record.data.init_weight;}
	if(oGrid_event.record.data.init_idealweight!== null){init_idealweight_update = oGrid_event.record.data.init_idealweight;}
	if(oGrid_event.record.data.init_bmi!== null){init_bmi_update = oGrid_event.record.data.init_bmi;}
	if(oGrid_event.record.data.init_misc!== null){init_misc_update = oGrid_event.record.data.init_misc;}
	if(oGrid_event.record.data.init_diagnosis!== null){init_diagnosis_update = oGrid_event.record.data.init_diagnosis;}
	if(oGrid_event.record.data.init_ddx!== null){init_ddx_update = oGrid_event.record.data.init_ddx;}
	if(oGrid_event.record.data.init_treatmentplan!== null){init_treatmentplan_update = oGrid_event.record.data.init_treatmentplan;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_initial_assessment&m=get_action',
			params: {
				task: "UPDATE",
				init_customer	: get_pk_id(),				init_tanggal	: get_pk_id(),				init_oleh	:init_oleh_update,		
				init_kulitwarna	:init_kulitwarna_update,		
				init_kulittype	:init_kulittype_update,		
				init_kulitminyak	:init_kulitminyak_update,		
				init_kulitpipi	:init_kulitpipi_update,		
				init_kulitt	:init_kulitt_update,		
				init_kulittebal	:init_kulittebal_update,		
				init_kulitrapuh	:init_kulitrapuh_update,		
				init_kulitkendur	:init_kulitkendur_update,		
				init_melasmatype	:init_melasmatype_update,		
				init_melasmacentrofacial	:init_melasmacentrofacial_update,		
				init_melasmamalar	:init_melasmamalar_update,		
				init_melasmamandibular	:init_melasmamandibular_update,		
				init_hipepidermal	:init_hipepidermal_update,		
				init_hipdermal	:init_hipdermal_update,		
				init_hippih	:init_hippih_update,		
				init_hiplingkarmata	:init_hiplingkarmata_update,		
				init_hypopigment	:init_hypopigment_update,		
				init_acne	:init_acne_update,		
				init_acnelesions	:init_acnelesions_update,		
				init_acnetelangiectasis	:init_acnetelangiectasis_update,		
				init_acnelocation	:init_acnelocation_update,		
				init_wringkleslines	:init_wringkleslines_update,		
				init_wringklesdinamics	:init_wringklesdinamics_update,		
				init_wringklesstatic	:init_wringklesstatic_update,		
				init_wringklesfold	:init_wringklesfold_update,		
				init_wringkleslain	:init_wringkleslain_update,		
				init_otherskinlesions	:init_otherskinlesions_update,		
				init_cellulitegrade	:init_cellulitegrade_update,		
				init_cellulitelocation	:init_cellulitelocation_update,		
				init_strectmark	:init_strectmark_update,		
				init_hairproblem	:init_hairproblem_update,		
				init_height	:init_height_update,		
				init_weight	:init_weight_update,		
				init_idealweight	:init_idealweight_update,		
				init_bmi	:init_bmi_update,		
				init_misc	:init_misc_update,		
				init_diagnosis	:init_diagnosis_update,		
				init_ddx	:init_ddx_update,		
				init_treatmentplan	:init_treatmentplan_update		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						initial_assessment_DataStore.commitChanges();
						initial_assessment_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not save the initial_assessment.',
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
	function initial_assessment_create(){
		if(is_initial_assessment_form_valid()){
		
		var init_customer_create=null;
		var init_tanggal_create_date="";
		var init_oleh_create=null;
		var init_kulitwarna_create=null;
		var init_kulittype_create=null;
		var init_kulitminyak_create=null;
		var init_kulitpipi_create=null;
		var init_kulitt_create=null;
		var init_kulittebal_create=null;
		var init_kulitrapuh_create=null;
		var init_kulitkendur_create=null;
		var init_melasmatype_create=null;
		var init_melasmacentrofacial_create=null;
		var init_melasmamalar_create=null;
		var init_melasmamandibular_create=null;
		var init_hipepidermal_create=null;
		var init_hipdermal_create=null;
		var init_hippih_create=null;
		var init_hiplingkarmata_create=null;
		var init_hypopigment_create=null;
		var init_acne_create=null;
		var init_acnelesions_create=null;
		var init_acnetelangiectasis_create=null;
		var init_acnelocation_create=null;
		var init_wringkleslines_create=null;
		var init_wringklesdinamics_create=null;
		var init_wringklesstatic_create=null;
		var init_wringklesfold_create=null;
		var init_wringkleslain_create=null;
		var init_otherskinlesions_create=null;
		var init_cellulitegrade_create=null;
		var init_cellulitelocation_create=null;
		var init_strectmark_create=null;
		var init_hairproblem_create=null;
		var init_height_create=null;
		var init_weight_create=null;
		var init_idealweight_create=null;
		var init_bmi_create=null;
		var init_misc_create=null;
		var init_diagnosis_create=null;
		var init_ddx_create=null;
		var init_treatmentplan_create=null;

		if(init_customerField.getValue()!== null){init_customer_create = init_customerField.getValue();}
		if(init_tanggalField.getValue()!== ""){init_tanggal_create_date = init_tanggalField.getValue().format('Y-m-d');}
		if(init_olehField.getValue()!== null){init_oleh_create = init_olehField.getValue();}
		if(init_kulitwarnaField.getValue()!== null){init_kulitwarna_create = init_kulitwarnaField.getValue();}
		if(init_kulittypeField.getValue()!== null){init_kulittype_create = init_kulittypeField.getValue();}
		if(init_kulitminyakField.getValue()!== null){init_kulitminyak_create = init_kulitminyakField.getValue();}
		if(init_kulitpipiField.getValue()!== null){init_kulitpipi_create = init_kulitpipiField.getValue();}
		if(init_kulittField.getValue()!== null){init_kulitt_create = init_kulittField.getValue();}
		if(init_kulittebalField.getValue()!== null){init_kulittebal_create = init_kulittebalField.getValue();}
		if(init_kulitrapuhField.getValue()!== null){init_kulitrapuh_create = init_kulitrapuhField.getValue();}
		if(init_kulitkendurField.getValue()!== null){init_kulitkendur_create = init_kulitkendurField.getValue();}
		if(init_melasmatypeField.getValue()!== null){init_melasmatype_create = init_melasmatypeField.getValue();}
		if(init_melasmacentrofacialField.getValue()!== null){init_melasmacentrofacial_create = init_melasmacentrofacialField.getValue();}
		if(init_melasmamalarField.getValue()!== null){init_melasmamalar_create = init_melasmamalarField.getValue();}
		if(init_melasmamandibularField.getValue()!== null){init_melasmamandibular_create = init_melasmamandibularField.getValue();}
		if(init_hipepidermalField.getValue()!== null){init_hipepidermal_create = init_hipepidermalField.getValue();}
		if(init_hipdermalField.getValue()!== null){init_hipdermal_create = init_hipdermalField.getValue();}
		if(init_hippihField.getValue()!== null){init_hippih_create = init_hippihField.getValue();}
		if(init_hiplingkarmataField.getValue()!== null){init_hiplingkarmata_create = init_hiplingkarmataField.getValue();}
		if(init_hypopigmentField.getValue()!== null){init_hypopigment_create = init_hypopigmentField.getValue();}
		if(init_acneField.getValue()!== null){init_acne_create = init_acneField.getValue();}
		if(init_acnelesionsField.getValue()!== null){init_acnelesions_create = init_acnelesionsField.getValue();}
		if(init_acnetelangiectasisField.getValue()!== null){init_acnetelangiectasis_create = init_acnetelangiectasisField.getValue();}
		if(init_acnelocationField.getValue()!== null){init_acnelocation_create = init_acnelocationField.getValue();}
		if(init_wringkleslinesField.getValue()!== null){init_wringkleslines_create = init_wringkleslinesField.getValue();}
		if(init_wringklesdinamicsField.getValue()!== null){init_wringklesdinamics_create = init_wringklesdinamicsField.getValue();}
		if(init_wringklesstaticField.getValue()!== null){init_wringklesstatic_create = init_wringklesstaticField.getValue();}
		if(init_wringklesfoldField.getValue()!== null){init_wringklesfold_create = init_wringklesfoldField.getValue();}
		if(init_wringkleslainField.getValue()!== null){init_wringkleslain_create = init_wringkleslainField.getValue();}
		if(init_otherskinlesionsField.getValue()!== null){init_otherskinlesions_create = init_otherskinlesionsField.getValue();}
		if(init_cellulitegradeField.getValue()!== null){init_cellulitegrade_create = init_cellulitegradeField.getValue();}
		if(init_cellulitelocationField.getValue()!== null){init_cellulitelocation_create = init_cellulitelocationField.getValue();}
		if(init_strectmarkField.getValue()!== null){init_strectmark_create = init_strectmarkField.getValue();}
		if(init_hairproblemField.getValue()!== null){init_hairproblem_create = init_hairproblemField.getValue();}
		if(init_heightField.getValue()!== null){init_height_create = init_heightField.getValue();}
		if(init_weightField.getValue()!== null){init_weight_create = init_weightField.getValue();}
		if(init_idealweightField.getValue()!== null){init_idealweight_create = init_idealweightField.getValue();}
		if(init_bmiField.getValue()!== null){init_bmi_create = init_bmiField.getValue();}
		if(init_miscField.getValue()!== null){init_misc_create = init_miscField.getValue();}
		if(init_diagnosisField.getValue()!== null){init_diagnosis_create = init_diagnosisField.getValue();}
		if(init_ddxField.getValue()!== null){init_ddx_create = init_ddxField.getValue();}
		if(init_treatmentplanField.getValue()!== null){init_treatmentplan_create = init_treatmentplanField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_initial_assessment&m=get_action',
				params: {
					task: post2db,
					init_customer	: init_customer_create_pk,	
					init_tanggal	: init_tanggal_create_pk,	
					init_oleh	: init_oleh_create,	
					init_kulitwarna	: init_kulitwarna_create,	
					init_kulittype	: init_kulittype_create,	
					init_kulitminyak	: init_kulitminyak_create,	
					init_kulitpipi	: init_kulitpipi_create,	
					init_kulitt	: init_kulitt_create,	
					init_kulittebal	: init_kulittebal_create,	
					init_kulitrapuh	: init_kulitrapuh_create,	
					init_kulitkendur	: init_kulitkendur_create,	
					init_melasmatype	: init_melasmatype_create,	
					init_melasmacentrofacial	: init_melasmacentrofacial_create,	
					init_melasmamalar	: init_melasmamalar_create,	
					init_melasmamandibular	: init_melasmamandibular_create,	
					init_hipepidermal	: init_hipepidermal_create,	
					init_hipdermal	: init_hipdermal_create,	
					init_hippih	: init_hippih_create,	
					init_hiplingkarmata	: init_hiplingkarmata_create,	
					init_hypopigment	: init_hypopigment_create,	
					init_acne	: init_acne_create,	
					init_acnelesions	: init_acnelesions_create,	
					init_acnetelangiectasis	: init_acnetelangiectasis_create,	
					init_acnelocation	: init_acnelocation_create,	
					init_wringkleslines	: init_wringkleslines_create,	
					init_wringklesdinamics	: init_wringklesdinamics_create,	
					init_wringklesstatic	: init_wringklesstatic_create,	
					init_wringklesfold	: init_wringklesfold_create,	
					init_wringkleslain	: init_wringkleslain_create,	
					init_otherskinlesions	: init_otherskinlesions_create,	
					init_cellulitegrade	: init_cellulitegrade_create,	
					init_cellulitelocation	: init_cellulitelocation_create,	
					init_strectmark	: init_strectmark_create,	
					init_hairproblem	: init_hairproblem_create,	
					init_height	: init_height_create,	
					init_weight	: init_weight_create,	
					init_idealweight	: init_idealweight_create,	
					init_bmi	: init_bmi_create,	
					init_misc	: init_misc_create,	
					init_diagnosis	: init_diagnosis_create,	
					init_ddx	: init_ddx_create,	
					init_treatmentplan	: init_treatmentplan_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','The Initial_assessment was '+msg+' successfully.');
							initial_assessment_DataStore.reload();
							initial_assessment_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not '+msg+' the Initial_assessment.',
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
		if(post2db=='UPDATE')
			return initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_customer,init_tanggal');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function initial_assessment_reset_form(){
		init_olehField.reset();
		init_kulitwarnaField.reset();
		init_kulittypeField.reset();
		init_kulitminyakField.reset();
		init_kulitpipiField.reset();
		init_kulittField.reset();
		init_kulittebalField.reset();
		init_kulitrapuhField.reset();
		init_kulitkendurField.reset();
		init_melasmatypeField.reset();
		init_melasmacentrofacialField.reset();
		init_melasmamalarField.reset();
		init_melasmamandibularField.reset();
		init_hipepidermalField.reset();
		init_hipdermalField.reset();
		init_hippihField.reset();
		init_hiplingkarmataField.reset();
		init_hypopigmentField.reset();
		init_acneField.reset();
		init_acnelesionsField.reset();
		init_acnetelangiectasisField.reset();
		init_acnelocationField.reset();
		init_wringkleslinesField.reset();
		init_wringklesdinamicsField.reset();
		init_wringklesstaticField.reset();
		init_wringklesfoldField.reset();
		init_wringkleslainField.reset();
		init_otherskinlesionsField.reset();
		init_cellulitegradeField.reset();
		init_cellulitelocationField.reset();
		init_strectmarkField.reset();
		init_hairproblemField.reset();
		init_heightField.reset();
		init_weightField.reset();
		init_idealweightField.reset();
		init_bmiField.reset();
		init_miscField.reset();
		init_diagnosisField.reset();
		init_ddxField.reset();
		init_treatmentplanField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function initial_assessment_set_form(){
		init_customerField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_customer'));
		init_tanggalField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_tanggal'));
		init_olehField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_oleh'));
		init_kulitwarnaField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulitwarna'));
		init_kulittypeField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulittype'));
		init_kulitminyakField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulitminyak'));
		init_kulitpipiField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulitpipi'));
		init_kulittField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulitt'));
		init_kulittebalField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulittebal'));
		init_kulitrapuhField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulitrapuh'));
		init_kulitkendurField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_kulitkendur'));
		init_melasmatypeField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_melasmatype'));
		init_melasmacentrofacialField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_melasmacentrofacial'));
		init_melasmamalarField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_melasmamalar'));
		init_melasmamandibularField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_melasmamandibular'));
		init_hipepidermalField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_hipepidermal'));
		init_hipdermalField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_hipdermal'));
		init_hippihField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_hippih'));
		init_hiplingkarmataField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_hiplingkarmata'));
		init_hypopigmentField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_hypopigment'));
		init_acneField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_acne'));
		init_acnelesionsField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_acnelesions'));
		init_acnetelangiectasisField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_acnetelangiectasis'));
		init_acnelocationField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_acnelocation'));
		init_wringkleslinesField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_wringkleslines'));
		init_wringklesdinamicsField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_wringklesdinamics'));
		init_wringklesstaticField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_wringklesstatic'));
		init_wringklesfoldField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_wringklesfold'));
		init_wringkleslainField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_wringkleslain'));
		init_otherskinlesionsField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_otherskinlesions'));
		init_cellulitegradeField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_cellulitegrade'));
		init_cellulitelocationField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_cellulitelocation'));
		init_strectmarkField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_strectmark'));
		init_hairproblemField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_hairproblem'));
		init_heightField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_height'));
		init_weightField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_weight'));
		init_idealweightField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_idealweight'));
		init_bmiField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_bmi'));
		init_miscField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_misc'));
		init_diagnosisField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_diagnosis'));
		init_ddxField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_ddx'));
		init_treatmentplanField.setValue(initial_assessmentListEditorGrid.getSelectionModel().getSelected().get('init_treatmentplan'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_initial_assessment_form_valid(){
		return (init_customerField.isValid() && init_tanggalField.isValid() && true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true &&  true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!initial_assessment_createWindow.isVisible()){
			initial_assessment_reset_form();
			post2db='CREATE';
			msg='created';
			initial_assessment_createWindow.show();
		} else {
			initial_assessment_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function initial_assessment_confirm_delete(){
		// only one initial_assessment is selected here
		if(initial_assessmentListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', initial_assessment_delete);
		} else if(initial_assessmentListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', initial_assessment_delete);
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
	function initial_assessment_confirm_update(){
		/* only one record is selected here */
		if(initial_assessmentListEditorGrid.selModel.getCount() == 1) {
			initial_assessment_set_form();
			post2db='UPDATE';
			msg='updated';
			initial_assessment_createWindow.show();
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
	function initial_assessment_delete(btn){
		if(btn=='yes'){
			var selections = initial_assessmentListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< initial_assessmentListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.init_customer,init_tanggal);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_initial_assessment&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							initial_assessment_DataStore.reload();
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
	initial_assessment_DataStore = new Ext.data.Store({
		id: 'initial_assessment_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_initial_assessment&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'init_customer,init_tanggal'
		},[
		/* dataIndex => insert intoinitial_assessment_ColumnModel, Mapping => for initiate table column */ 
			{name: 'init_customer', type: 'int', mapping: 'init_customer'},
			{name: 'init_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'init_tanggal'},
			{name: 'init_oleh', type: 'string', mapping: 'init_oleh'},
			{name: 'init_kulitwarna', type: 'string', mapping: 'init_kulitwarna'},
			{name: 'init_kulittype', type: 'string', mapping: 'init_kulittype'},
			{name: 'init_kulitminyak', type: 'string', mapping: 'init_kulitminyak'},
			{name: 'init_kulitpipi', type: 'string', mapping: 'init_kulitpipi'},
			{name: 'init_kulitt', type: 'string', mapping: 'init_kulitt'},
			{name: 'init_kulittebal', type: 'string', mapping: 'init_kulittebal'},
			{name: 'init_kulitrapuh', type: 'string', mapping: 'init_kulitrapuh'},
			{name: 'init_kulitkendur', type: 'string', mapping: 'init_kulitkendur'},
			{name: 'init_melasmatype', type: 'string', mapping: 'init_melasmatype'},
			{name: 'init_melasmacentrofacial', type: 'string', mapping: 'init_melasmacentrofacial'},
			{name: 'init_melasmamalar', type: 'string', mapping: 'init_melasmamalar'},
			{name: 'init_melasmamandibular', type: 'string', mapping: 'init_melasmamandibular'},
			{name: 'init_hipepidermal', type: 'string', mapping: 'init_hipepidermal'},
			{name: 'init_hipdermal', type: 'string', mapping: 'init_hipdermal'},
			{name: 'init_hippih', type: 'string', mapping: 'init_hippih'},
			{name: 'init_hiplingkarmata', type: 'string', mapping: 'init_hiplingkarmata'},
			{name: 'init_hypopigment', type: 'string', mapping: 'init_hypopigment'},
			{name: 'init_acne', type: 'string', mapping: 'init_acne'},
			{name: 'init_acnelesions', type: 'string', mapping: 'init_acnelesions'},
			{name: 'init_acnetelangiectasis', type: 'string', mapping: 'init_acnetelangiectasis'},
			{name: 'init_acnelocation', type: 'string', mapping: 'init_acnelocation'},
			{name: 'init_wringkleslines', type: 'string', mapping: 'init_wringkleslines'},
			{name: 'init_wringklesdinamics', type: 'string', mapping: 'init_wringklesdinamics'},
			{name: 'init_wringklesstatic', type: 'string', mapping: 'init_wringklesstatic'},
			{name: 'init_wringklesfold', type: 'string', mapping: 'init_wringklesfold'},
			{name: 'init_wringkleslain', type: 'string', mapping: 'init_wringkleslain'},
			{name: 'init_otherskinlesions', type: 'string', mapping: 'init_otherskinlesions'},
			{name: 'init_cellulitegrade', type: 'string', mapping: 'init_cellulitegrade'},
			{name: 'init_cellulitelocation', type: 'string', mapping: 'init_cellulitelocation'},
			{name: 'init_strectmark', type: 'string', mapping: 'init_strectmark'},
			{name: 'init_hairproblem', type: 'string', mapping: 'init_hairproblem'},
			{name: 'init_height', type: 'float', mapping: 'init_height'},
			{name: 'init_weight', type: 'float', mapping: 'init_weight'},
			{name: 'init_idealweight', type: 'float', mapping: 'init_idealweight'},
			{name: 'init_bmi', type: 'float', mapping: 'init_bmi'},
			{name: 'init_misc', type: 'string', mapping: 'init_misc'},
			{name: 'init_diagnosis', type: 'string', mapping: 'init_diagnosis'},
			{name: 'init_ddx', type: 'string', mapping: 'init_ddx'},
			{name: 'init_treatmentplan', type: 'string', mapping: 'init_treatmentplan'}
		]),
		sortInfo:{field: 'init_customer,init_tanggal', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	initial_assessment_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'init_customer,init_tanggal',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},
		{
			header: 'Init Oleh',
			dataIndex: 'init_oleh',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Kulitwarna',
			dataIndex: 'init_kulitwarna',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Kulittype',
			dataIndex: 'init_kulittype',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulittype_value', 'init_kulittype_display'],
					data: [['I','I'],['II','II'],['III','III'],['IV','IV'],['V','V'],['VI','VI']]
					}),
				mode: 'local',
               	displayField: 'init_kulittype_display',
               	valueField: 'init_kulittype_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Kulitminyak',
			dataIndex: 'init_kulitminyak',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulitminyak_value', 'init_kulitminyak_display'],
					data: [['kering','kering'],['normal','normal'],['kombinasi berminyak','kombinasi berminyak'],['berminyak','berminyak']]
					}),
				mode: 'local',
               	displayField: 'init_kulitminyak_display',
               	valueField: 'init_kulitminyak_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Kulitpipi',
			dataIndex: 'init_kulitpipi',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulitpipi_value', 'init_kulitpipi_display'],
					data: [['berminyak','berminyak'],['normal','normal'],['kering','kering']]
					}),
				mode: 'local',
               	displayField: 'init_kulitpipi_display',
               	valueField: 'init_kulitpipi_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Kulitt',
			dataIndex: 'init_kulitt',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulitt_value', 'init_kulitt_display'],
					data: [['berminyak','berminyak'],['normal','normal'],['kering','kering']]
					}),
				mode: 'local',
               	displayField: 'init_kulitt_display',
               	valueField: 'init_kulitt_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Kulittebal',
			dataIndex: 'init_kulittebal',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulittebal_value', 'init_kulittebal_display'],
					data: [['tipis','tipis'],['sedang','sedang'],['tebal','tebal']]
					}),
				mode: 'local',
               	displayField: 'init_kulittebal_display',
               	valueField: 'init_kulittebal_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Kulitrapuh',
			dataIndex: 'init_kulitrapuh',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulitrapuh_value', 'init_kulitrapuh_display'],
					data: [['normal','normal'],['rapuh','rapuh']]
					}),
				mode: 'local',
               	displayField: 'init_kulitrapuh_display',
               	valueField: 'init_kulitrapuh_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Kulitkendur',
			dataIndex: 'init_kulitkendur',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_kulitkendur_value', 'init_kulitkendur_display'],
					data: [['kencang','kencang'],['kendur','kendur']]
					}),
				mode: 'local',
               	displayField: 'init_kulitkendur_display',
               	valueField: 'init_kulitkendur_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Melasmatype',
			dataIndex: 'init_melasmatype',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_melasmatype_value', 'init_melasmatype_display'],
					data: [['epidermal','epidermal'],['dermal','dermal'],['mixed melasma','mixed melasma'],['indeterminate','indeterminate']]
					}),
				mode: 'local',
               	displayField: 'init_melasmatype_display',
               	valueField: 'init_melasmatype_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Melasmacentrofacial',
			dataIndex: 'init_melasmacentrofacial',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_melasmacentrofacial_value', 'init_melasmacentrofacial_display'],
					data: [['forehead','forehead'],['nose','nose'],['superior lip','superior lip'],['chin','chin']]
					}),
				mode: 'local',
               	displayField: 'init_melasmacentrofacial_display',
               	valueField: 'init_melasmacentrofacial_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Melasmamalar',
			dataIndex: 'init_melasmamalar',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_melasmamalar_value', 'init_melasmamalar_display'],
					data: [['right cheek','right cheek'],['left cheek','left cheek']]
					}),
				mode: 'local',
               	displayField: 'init_melasmamalar_display',
               	valueField: 'init_melasmamalar_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Melasmamandibular',
			dataIndex: 'init_melasmamandibular',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_melasmamandibular_value', 'init_melasmamandibular_display'],
					data: [['right mandibula','right mandibula'],['left mandibula','left mandibula']]
					}),
				mode: 'local',
               	displayField: 'init_melasmamandibular_display',
               	valueField: 'init_melasmamandibular_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Hipepidermal',
			dataIndex: 'init_hipepidermal',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
		},
		{
			header: 'Init Hipdermal',
			dataIndex: 'init_hipdermal',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
		},
		{
			header: 'Init Hippih',
			dataIndex: 'init_hippih',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_hippih_value', 'init_hippih_display'],
					data: [['y','y'],['t','t']]
					}),
				mode: 'local',
               	displayField: 'init_hippih_display',
               	valueField: 'init_hippih_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Hiplingkarmata',
			dataIndex: 'init_hiplingkarmata',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_hiplingkarmata_value', 'init_hiplingkarmata_display'],
					data: [['y','y'],['t','t']]
					}),
				mode: 'local',
               	displayField: 'init_hiplingkarmata_display',
               	valueField: 'init_hiplingkarmata_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Hypopigment',
			dataIndex: 'init_hypopigment',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
		},
		{
			header: 'Init Acne',
			dataIndex: 'init_acne',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_acne_value', 'init_acne_display'],
					data: [['polymorphic','polymorphic'],['monomorphic','monomorphic']]
					}),
				mode: 'local',
               	displayField: 'init_acne_display',
               	valueField: 'init_acne_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Acnelesions',
			dataIndex: 'init_acnelesions',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
		},
		{
			header: 'Init Acnetelangiectasis',
			dataIndex: 'init_acnetelangiectasis',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_acnetelangiectasis_value', 'init_acnetelangiectasis_display'],
					data: [['y','y'],['n','n']]
					}),
				mode: 'local',
               	displayField: 'init_acnetelangiectasis_display',
               	valueField: 'init_acnetelangiectasis_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Acnelocation',
			dataIndex: 'init_acnelocation',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_acnelocation_value', 'init_acnelocation_display'],
					data: [['face','face'],['back','back'],['neck','neck'],['upper arm','upper arm'],['back','back']]
					}),
				mode: 'local',
               	displayField: 'init_acnelocation_display',
               	valueField: 'init_acnelocation_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Wringkleslines',
			dataIndex: 'init_wringkleslines',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Wringklesdinamics',
			dataIndex: 'init_wringklesdinamics',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 200
          	})
		},
		{
			header: 'Init Wringklesstatic',
			dataIndex: 'init_wringklesstatic',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_wringklesstatic_value', 'init_wringklesstatic_display'],
					data: [['horizontal forehead lines','horizontal forehead lines'],['glabellar lines','glabellar lines']]
					}),
				mode: 'local',
               	displayField: 'init_wringklesstatic_display',
               	valueField: 'init_wringklesstatic_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Wringklesfold',
			dataIndex: 'init_wringklesfold',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_wringklesfold_value', 'init_wringklesfold_display'],
					data: [['deep nasolabial fold','deep nasolabial fold'],['marionette lines','marionette lines']]
					}),
				mode: 'local',
               	displayField: 'init_wringklesfold_display',
               	valueField: 'init_wringklesfold_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Wringkleslain',
			dataIndex: 'init_wringkleslain',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Otherskinlesions',
			dataIndex: 'init_otherskinlesions',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
		},
		{
			header: 'Init Cellulitegrade',
			dataIndex: 'init_cellulitegrade',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_cellulitegrade_value', 'init_cellulitegrade_display'],
					data: [['I','I'],['II','II'],['III','III'],['IV','IV']]
					}),
				mode: 'local',
               	displayField: 'init_cellulitegrade_display',
               	valueField: 'init_cellulitegrade_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Cellulitelocation',
			dataIndex: 'init_cellulitelocation',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['init_cellulitelocation_value', 'init_cellulitelocation_display'],
					data: [['upper arm','upper arm'],['buttocks','buttocks'],['thighs','thighs']]
					}),
				mode: 'local',
               	displayField: 'init_cellulitelocation_display',
               	valueField: 'init_cellulitelocation_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: 'Init Strectmark',
			dataIndex: 'init_strectmark',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		},
		{
			header: 'Init Hairproblem',
			dataIndex: 'init_hairproblem',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Height',
			dataIndex: 'init_height',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 12,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Init Weight',
			dataIndex: 'init_weight',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 12,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Init Idealweight',
			dataIndex: 'init_idealweight',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 12,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Init Bmi',
			dataIndex: 'init_bmi',
			width: 150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 12,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: 'Init Misc',
			dataIndex: 'init_misc',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Diagnosis',
			dataIndex: 'init_diagnosis',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Ddx',
			dataIndex: 'init_ddx',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		},
		{
			header: 'Init Treatmentplan',
			dataIndex: 'init_treatmentplan',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
		}]
	);
	initial_assessment_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	initial_assessmentListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'initial_assessmentListEditorGrid',
		el: 'fp_initial_assessment',
		title: 'List Of Initial_assessment',
		autoHeight: true,
		store: initial_assessment_DataStore, // DataStore
		cm: initial_assessment_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 2100,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: initial_assessment_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: initial_assessment_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: initial_assessment_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: initial_assessment_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: initial_assessment_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: initial_assessment_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: initial_assessment_print  
		}
		]
	});
	initial_assessmentListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	initial_assessment_ContextMenu = new Ext.menu.Menu({
		id: 'initial_assessment_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: initial_assessment_confirm_update 
		},
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: initial_assessment_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: initial_assessment_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: initial_assessment_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function oninitial_assessment_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		initial_assessment_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		initial_assessment_SelectedRow=rowIndex;
		initial_assessment_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function initial_assessment_editContextMenu(){
      initial_assessmentListEditorGrid.startEditing(initial_assessment_SelectedRow,1);
  	}
	/* End of Function */
  	
	initial_assessmentListEditorGrid.addListener('rowcontextmenu', oninitial_assessment_ListEditGridContextMenu);
	initial_assessment_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	initial_assessmentListEditorGrid.on('afteredit', initial_assessment_update); // inLine Editing Record
	
	/* Identify  init_customer Field */
	init_customerField= new Ext.form.NumberField({
		id: 'init_customerField',
		fieldLabel: 'Init Customer',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  init_tanggal Field */
	init_tanggalField= new Ext.form.DateField({
		id: 'init_tanggalField',
		fieldLabel: 'Init Tanggal',
		format : 'Y-m-d',
		allowBlank: false,
	});
	/* Identify  init_oleh Field */
	init_olehField= new Ext.form.TextField({
		id: 'init_olehField',
		fieldLabel: 'Init Oleh',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_kulitwarna Field */
	init_kulitwarnaField= new Ext.form.TextField({
		id: 'init_kulitwarnaField',
		fieldLabel: 'Init Kulitwarna',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_kulittype Field */
	init_kulittypeField= new Ext.form.ComboBox({
		id: 'init_kulittypeField',
		fieldLabel: 'Init Kulittype',
		store:new Ext.data.SimpleStore({
			fields:['init_kulittype_value', 'init_kulittype_display'],
			data:[['I','I'],['II','II'],['III','III'],['IV','IV'],['V','V'],['VI','VI']]
		}),
		mode: 'local',
		displayField: 'init_kulittype_display',
		valueField: 'init_kulittype_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_kulitminyak Field */
	init_kulitminyakField= new Ext.form.ComboBox({
		id: 'init_kulitminyakField',
		fieldLabel: 'Init Kulitminyak',
		store:new Ext.data.SimpleStore({
			fields:['init_kulitminyak_value', 'init_kulitminyak_display'],
			data:[['kering','kering'],['normal','normal'],['kombinasi berminyak','kombinasi berminyak'],['berminyak','berminyak']]
		}),
		mode: 'local',
		displayField: 'init_kulitminyak_display',
		valueField: 'init_kulitminyak_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_kulitpipi Field */
	init_kulitpipiField= new Ext.form.ComboBox({
		id: 'init_kulitpipiField',
		fieldLabel: 'Init Kulitpipi',
		store:new Ext.data.SimpleStore({
			fields:['init_kulitpipi_value', 'init_kulitpipi_display'],
			data:[['berminyak','berminyak'],['normal','normal'],['kering','kering']]
		}),
		mode: 'local',
		displayField: 'init_kulitpipi_display',
		valueField: 'init_kulitpipi_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_kulitt Field */
	init_kulittField= new Ext.form.ComboBox({
		id: 'init_kulittField',
		fieldLabel: 'Init Kulitt',
		store:new Ext.data.SimpleStore({
			fields:['init_kulitt_value', 'init_kulitt_display'],
			data:[['berminyak','berminyak'],['normal','normal'],['kering','kering']]
		}),
		mode: 'local',
		displayField: 'init_kulitt_display',
		valueField: 'init_kulitt_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_kulittebal Field */
	init_kulittebalField= new Ext.form.ComboBox({
		id: 'init_kulittebalField',
		fieldLabel: 'Init Kulittebal',
		store:new Ext.data.SimpleStore({
			fields:['init_kulittebal_value', 'init_kulittebal_display'],
			data:[['tipis','tipis'],['sedang','sedang'],['tebal','tebal']]
		}),
		mode: 'local',
		displayField: 'init_kulittebal_display',
		valueField: 'init_kulittebal_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_kulitrapuh Field */
	init_kulitrapuhField= new Ext.form.ComboBox({
		id: 'init_kulitrapuhField',
		fieldLabel: 'Init Kulitrapuh',
		store:new Ext.data.SimpleStore({
			fields:['init_kulitrapuh_value', 'init_kulitrapuh_display'],
			data:[['normal','normal'],['rapuh','rapuh']]
		}),
		mode: 'local',
		displayField: 'init_kulitrapuh_display',
		valueField: 'init_kulitrapuh_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_kulitkendur Field */
	init_kulitkendurField= new Ext.form.ComboBox({
		id: 'init_kulitkendurField',
		fieldLabel: 'Init Kulitkendur',
		store:new Ext.data.SimpleStore({
			fields:['init_kulitkendur_value', 'init_kulitkendur_display'],
			data:[['kencang','kencang'],['kendur','kendur']]
		}),
		mode: 'local',
		displayField: 'init_kulitkendur_display',
		valueField: 'init_kulitkendur_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_melasmatype Field */
	init_melasmatypeField= new Ext.form.ComboBox({
		id: 'init_melasmatypeField',
		fieldLabel: 'Init Melasmatype',
		store:new Ext.data.SimpleStore({
			fields:['init_melasmatype_value', 'init_melasmatype_display'],
			data:[['epidermal','epidermal'],['dermal','dermal'],['mixed melasma','mixed melasma'],['indeterminate','indeterminate']]
		}),
		mode: 'local',
		displayField: 'init_melasmatype_display',
		valueField: 'init_melasmatype_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_melasmacentrofacial Field */
	init_melasmacentrofacialField= new Ext.form.ComboBox({
		id: 'init_melasmacentrofacialField',
		fieldLabel: 'Init Melasmacentrofacial',
		store:new Ext.data.SimpleStore({
			fields:['init_melasmacentrofacial_value', 'init_melasmacentrofacial_display'],
			data:[['forehead','forehead'],['nose','nose'],['superior lip','superior lip'],['chin','chin']]
		}),
		mode: 'local',
		displayField: 'init_melasmacentrofacial_display',
		valueField: 'init_melasmacentrofacial_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_melasmamalar Field */
	init_melasmamalarField= new Ext.form.ComboBox({
		id: 'init_melasmamalarField',
		fieldLabel: 'Init Melasmamalar',
		store:new Ext.data.SimpleStore({
			fields:['init_melasmamalar_value', 'init_melasmamalar_display'],
			data:[['right cheek','right cheek'],['left cheek','left cheek']]
		}),
		mode: 'local',
		displayField: 'init_melasmamalar_display',
		valueField: 'init_melasmamalar_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_melasmamandibular Field */
	init_melasmamandibularField= new Ext.form.ComboBox({
		id: 'init_melasmamandibularField',
		fieldLabel: 'Init Melasmamandibular',
		store:new Ext.data.SimpleStore({
			fields:['init_melasmamandibular_value', 'init_melasmamandibular_display'],
			data:[['right mandibula','right mandibula'],['left mandibula','left mandibula']]
		}),
		mode: 'local',
		displayField: 'init_melasmamandibular_display',
		valueField: 'init_melasmamandibular_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_hipepidermal Field */
	init_hipepidermalField= new Ext.form.TextField({
		id: 'init_hipepidermalField',
		fieldLabel: 'Init Hipepidermal',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  init_hipdermal Field */
	init_hipdermalField= new Ext.form.TextField({
		id: 'init_hipdermalField',
		fieldLabel: 'Init Hipdermal',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  init_hippih Field */
	init_hippihField= new Ext.form.ComboBox({
		id: 'init_hippihField',
		fieldLabel: 'Init Hippih',
		store:new Ext.data.SimpleStore({
			fields:['init_hippih_value', 'init_hippih_display'],
			data:[['y','y'],['t','t']]
		}),
		mode: 'local',
		displayField: 'init_hippih_display',
		valueField: 'init_hippih_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_hiplingkarmata Field */
	init_hiplingkarmataField= new Ext.form.ComboBox({
		id: 'init_hiplingkarmataField',
		fieldLabel: 'Init Hiplingkarmata',
		store:new Ext.data.SimpleStore({
			fields:['init_hiplingkarmata_value', 'init_hiplingkarmata_display'],
			data:[['y','y'],['t','t']]
		}),
		mode: 'local',
		displayField: 'init_hiplingkarmata_display',
		valueField: 'init_hiplingkarmata_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_hypopigment Field */
	init_hypopigmentField= new Ext.form.TextField({
		id: 'init_hypopigmentField',
		fieldLabel: 'Init Hypopigment',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  init_acne Field */
	init_acneField= new Ext.form.ComboBox({
		id: 'init_acneField',
		fieldLabel: 'Init Acne',
		store:new Ext.data.SimpleStore({
			fields:['init_acne_value', 'init_acne_display'],
			data:[['polymorphic','polymorphic'],['monomorphic','monomorphic']]
		}),
		mode: 'local',
		displayField: 'init_acne_display',
		valueField: 'init_acne_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_acnelesions Field */
	init_acnelesionsField= new Ext.form.TextField({
		id: 'init_acnelesionsField',
		fieldLabel: 'Init Acnelesions',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  init_acnetelangiectasis Field */
	init_acnetelangiectasisField= new Ext.form.ComboBox({
		id: 'init_acnetelangiectasisField',
		fieldLabel: 'Init Acnetelangiectasis',
		store:new Ext.data.SimpleStore({
			fields:['init_acnetelangiectasis_value', 'init_acnetelangiectasis_display'],
			data:[['y','y'],['n','n']]
		}),
		mode: 'local',
		displayField: 'init_acnetelangiectasis_display',
		valueField: 'init_acnetelangiectasis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_acnelocation Field */
	init_acnelocationField= new Ext.form.ComboBox({
		id: 'init_acnelocationField',
		fieldLabel: 'Init Acnelocation',
		store:new Ext.data.SimpleStore({
			fields:['init_acnelocation_value', 'init_acnelocation_display'],
			data:[['face','face'],['back','back'],['neck','neck'],['upper arm','upper arm'],['back','back']]
		}),
		mode: 'local',
		displayField: 'init_acnelocation_display',
		valueField: 'init_acnelocation_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_wringkleslines Field */
	init_wringkleslinesField= new Ext.form.TextField({
		id: 'init_wringkleslinesField',
		fieldLabel: 'Init Wringkleslines',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_wringklesdinamics Field */
	init_wringklesdinamicsField= new Ext.form.TextField({
		id: 'init_wringklesdinamicsField',
		fieldLabel: 'Init Wringklesdinamics',
		maxLength: 200,
		anchor: '95%'
	});
	/* Identify  init_wringklesstatic Field */
	init_wringklesstaticField= new Ext.form.ComboBox({
		id: 'init_wringklesstaticField',
		fieldLabel: 'Init Wringklesstatic',
		store:new Ext.data.SimpleStore({
			fields:['init_wringklesstatic_value', 'init_wringklesstatic_display'],
			data:[['horizontal forehead lines','horizontal forehead lines'],['glabellar lines','glabellar lines']]
		}),
		mode: 'local',
		displayField: 'init_wringklesstatic_display',
		valueField: 'init_wringklesstatic_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_wringklesfold Field */
	init_wringklesfoldField= new Ext.form.ComboBox({
		id: 'init_wringklesfoldField',
		fieldLabel: 'Init Wringklesfold',
		store:new Ext.data.SimpleStore({
			fields:['init_wringklesfold_value', 'init_wringklesfold_display'],
			data:[['deep nasolabial fold','deep nasolabial fold'],['marionette lines','marionette lines']]
		}),
		mode: 'local',
		displayField: 'init_wringklesfold_display',
		valueField: 'init_wringklesfold_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_wringkleslain Field */
	init_wringkleslainField= new Ext.form.TextField({
		id: 'init_wringkleslainField',
		fieldLabel: 'Init Wringkleslain',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_otherskinlesions Field */
	init_otherskinlesionsField= new Ext.form.TextField({
		id: 'init_otherskinlesionsField',
		fieldLabel: 'Init Otherskinlesions',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  init_cellulitegrade Field */
	init_cellulitegradeField= new Ext.form.ComboBox({
		id: 'init_cellulitegradeField',
		fieldLabel: 'Init Cellulitegrade',
		store:new Ext.data.SimpleStore({
			fields:['init_cellulitegrade_value', 'init_cellulitegrade_display'],
			data:[['I','I'],['II','II'],['III','III'],['IV','IV']]
		}),
		mode: 'local',
		displayField: 'init_cellulitegrade_display',
		valueField: 'init_cellulitegrade_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_cellulitelocation Field */
	init_cellulitelocationField= new Ext.form.ComboBox({
		id: 'init_cellulitelocationField',
		fieldLabel: 'Init Cellulitelocation',
		store:new Ext.data.SimpleStore({
			fields:['init_cellulitelocation_value', 'init_cellulitelocation_display'],
			data:[['upper arm','upper arm'],['buttocks','buttocks'],['thighs','thighs']]
		}),
		mode: 'local',
		displayField: 'init_cellulitelocation_display',
		valueField: 'init_cellulitelocation_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  init_strectmark Field */
	init_strectmarkField= new Ext.form.TextField({
		id: 'init_strectmarkField',
		fieldLabel: 'Init Strectmark',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  init_hairproblem Field */
	init_hairproblemField= new Ext.form.TextField({
		id: 'init_hairproblemField',
		fieldLabel: 'Init Hairproblem',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_height Field */
	init_heightField= new Ext.form.NumberField({
		id: 'init_heightField',
		fieldLabel: 'Init Height',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  init_weight Field */
	init_weightField= new Ext.form.NumberField({
		id: 'init_weightField',
		fieldLabel: 'Init Weight',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  init_idealweight Field */
	init_idealweightField= new Ext.form.NumberField({
		id: 'init_idealweightField',
		fieldLabel: 'Init Idealweight',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  init_bmi Field */
	init_bmiField= new Ext.form.NumberField({
		id: 'init_bmiField',
		fieldLabel: 'Init Bmi',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  init_misc Field */
	init_miscField= new Ext.form.TextField({
		id: 'init_miscField',
		fieldLabel: 'Init Misc',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_diagnosis Field */
	init_diagnosisField= new Ext.form.TextField({
		id: 'init_diagnosisField',
		fieldLabel: 'Init Diagnosis',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_ddx Field */
	init_ddxField= new Ext.form.TextField({
		id: 'init_ddxField',
		fieldLabel: 'Init Ddx',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  init_treatmentplan Field */
	init_treatmentplanField= new Ext.form.TextField({
		id: 'init_treatmentplanField',
		fieldLabel: 'Init Treatmentplan',
		maxLength: 500,
		anchor: '95%'
	});
  	
	/* Function for retrieve create Window Panel*/ 
	initial_assessment_createForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1500,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				items: [init_customerFieldinit_tanggalField, init_olehField, init_kulitwarnaField, init_kulittypeField, init_kulitminyakField, init_kulitpipiField, init_kulittField, init_kulittebalField, init_kulitrapuhField, init_kulitkendurField] 
			}
			,{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				items: [init_melasmatypeField, init_melasmacentrofacialField, init_melasmamalarField, init_melasmamandibularField, init_hipepidermalField, init_hipdermalField, init_hippihField, init_hiplingkarmataField, init_hypopigmentField, init_acneField] 
			}
			,{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				items: [init_acnelesionsField, init_acnetelangiectasisField, init_acnelocationField, init_wringkleslinesField, init_wringklesdinamicsField, init_wringklesstaticField, init_wringklesfoldField, init_wringkleslainField, init_otherskinlesionsField, init_cellulitegradeField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Save and Close',
				handler: initial_assessment_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					initial_assessment_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	initial_assessment_createWindow= new Ext.Window({
		id: 'initial_assessment_createWindow',
		title: post2db+'Initial_assessment',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_initial_assessment_create',
		items: initial_assessment_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function initial_assessment_list_search(){
		// render according to a SQL date format.
		var init_customer_search=null;
		var init_tanggal_search_date="";
		var init_oleh_search=null;
		var init_kulitwarna_search=null;
		var init_kulittype_search=null;
		var init_kulitminyak_search=null;
		var init_kulitpipi_search=null;
		var init_kulitt_search=null;
		var init_kulittebal_search=null;
		var init_kulitrapuh_search=null;
		var init_kulitkendur_search=null;
		var init_melasmatype_search=null;
		var init_melasmacentrofacial_search=null;
		var init_melasmamalar_search=null;
		var init_melasmamandibular_search=null;
		var init_hipepidermal_search=null;
		var init_hipdermal_search=null;
		var init_hippih_search=null;
		var init_hiplingkarmata_search=null;
		var init_hypopigment_search=null;
		var init_acne_search=null;
		var init_acnelesions_search=null;
		var init_acnetelangiectasis_search=null;
		var init_acnelocation_search=null;
		var init_wringkleslines_search=null;
		var init_wringklesdinamics_search=null;
		var init_wringklesstatic_search=null;
		var init_wringklesfold_search=null;
		var init_wringkleslain_search=null;
		var init_otherskinlesions_search=null;
		var init_cellulitegrade_search=null;
		var init_cellulitelocation_search=null;
		var init_strectmark_search=null;
		var init_hairproblem_search=null;
		var init_height_search=null;
		var init_weight_search=null;
		var init_idealweight_search=null;
		var init_bmi_search=null;
		var init_misc_search=null;
		var init_diagnosis_search=null;
		var init_ddx_search=null;
		var init_treatmentplan_search=null;

		if(init_customerSearchField.getValue()!==null){init_customer_search=init_customerSearchField.getValue();}
		if(init_tanggalSearchField.getValue()!==""){init_tanggal_search_date=init_tanggalSearchField.getValue().format('Y-m-d');}
		if(init_olehSearchField.getValue()!==null){init_oleh_search=init_olehSearchField.getValue();}
		if(init_kulitwarnaSearchField.getValue()!==null){init_kulitwarna_search=init_kulitwarnaSearchField.getValue();}
		if(init_kulittypeSearchField.getValue()!==null){init_kulittype_search=init_kulittypeSearchField.getValue();}
		if(init_kulitminyakSearchField.getValue()!==null){init_kulitminyak_search=init_kulitminyakSearchField.getValue();}
		if(init_kulitpipiSearchField.getValue()!==null){init_kulitpipi_search=init_kulitpipiSearchField.getValue();}
		if(init_kulittSearchField.getValue()!==null){init_kulitt_search=init_kulittSearchField.getValue();}
		if(init_kulittebalSearchField.getValue()!==null){init_kulittebal_search=init_kulittebalSearchField.getValue();}
		if(init_kulitrapuhSearchField.getValue()!==null){init_kulitrapuh_search=init_kulitrapuhSearchField.getValue();}
		if(init_kulitkendurSearchField.getValue()!==null){init_kulitkendur_search=init_kulitkendurSearchField.getValue();}
		if(init_melasmatypeSearchField.getValue()!==null){init_melasmatype_search=init_melasmatypeSearchField.getValue();}
		if(init_melasmacentrofacialSearchField.getValue()!==null){init_melasmacentrofacial_search=init_melasmacentrofacialSearchField.getValue();}
		if(init_melasmamalarSearchField.getValue()!==null){init_melasmamalar_search=init_melasmamalarSearchField.getValue();}
		if(init_melasmamandibularSearchField.getValue()!==null){init_melasmamandibular_search=init_melasmamandibularSearchField.getValue();}
		if(init_hipepidermalSearchField.getValue()!==null){init_hipepidermal_search=init_hipepidermalSearchField.getValue();}
		if(init_hipdermalSearchField.getValue()!==null){init_hipdermal_search=init_hipdermalSearchField.getValue();}
		if(init_hippihSearchField.getValue()!==null){init_hippih_search=init_hippihSearchField.getValue();}
		if(init_hiplingkarmataSearchField.getValue()!==null){init_hiplingkarmata_search=init_hiplingkarmataSearchField.getValue();}
		if(init_hypopigmentSearchField.getValue()!==null){init_hypopigment_search=init_hypopigmentSearchField.getValue();}
		if(init_acneSearchField.getValue()!==null){init_acne_search=init_acneSearchField.getValue();}
		if(init_acnelesionsSearchField.getValue()!==null){init_acnelesions_search=init_acnelesionsSearchField.getValue();}
		if(init_acnetelangiectasisSearchField.getValue()!==null){init_acnetelangiectasis_search=init_acnetelangiectasisSearchField.getValue();}
		if(init_acnelocationSearchField.getValue()!==null){init_acnelocation_search=init_acnelocationSearchField.getValue();}
		if(init_wringkleslinesSearchField.getValue()!==null){init_wringkleslines_search=init_wringkleslinesSearchField.getValue();}
		if(init_wringklesdinamicsSearchField.getValue()!==null){init_wringklesdinamics_search=init_wringklesdinamicsSearchField.getValue();}
		if(init_wringklesstaticSearchField.getValue()!==null){init_wringklesstatic_search=init_wringklesstaticSearchField.getValue();}
		if(init_wringklesfoldSearchField.getValue()!==null){init_wringklesfold_search=init_wringklesfoldSearchField.getValue();}
		if(init_wringkleslainSearchField.getValue()!==null){init_wringkleslain_search=init_wringkleslainSearchField.getValue();}
		if(init_otherskinlesionsSearchField.getValue()!==null){init_otherskinlesions_search=init_otherskinlesionsSearchField.getValue();}
		if(init_cellulitegradeSearchField.getValue()!==null){init_cellulitegrade_search=init_cellulitegradeSearchField.getValue();}
		if(init_cellulitelocationSearchField.getValue()!==null){init_cellulitelocation_search=init_cellulitelocationSearchField.getValue();}
		if(init_strectmarkSearchField.getValue()!==null){init_strectmark_search=init_strectmarkSearchField.getValue();}
		if(init_hairproblemSearchField.getValue()!==null){init_hairproblem_search=init_hairproblemSearchField.getValue();}
		if(init_heightSearchField.getValue()!==null){init_height_search=init_heightSearchField.getValue();}
		if(init_weightSearchField.getValue()!==null){init_weight_search=init_weightSearchField.getValue();}
		if(init_idealweightSearchField.getValue()!==null){init_idealweight_search=init_idealweightSearchField.getValue();}
		if(init_bmiSearchField.getValue()!==null){init_bmi_search=init_bmiSearchField.getValue();}
		if(init_miscSearchField.getValue()!==null){init_misc_search=init_miscSearchField.getValue();}
		if(init_diagnosisSearchField.getValue()!==null){init_diagnosis_search=init_diagnosisSearchField.getValue();}
		if(init_ddxSearchField.getValue()!==null){init_ddx_search=init_ddxSearchField.getValue();}
		if(init_treatmentplanSearchField.getValue()!==null){init_treatmentplan_search=init_treatmentplanSearchField.getValue();}
		// change the store parameters
		initial_assessment_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			init_customer	:	init_customer_search, 
			init_tanggal	:	init_tanggal_search_date, 
			init_oleh	:	init_oleh_search, 
			init_kulitwarna	:	init_kulitwarna_search, 
			init_kulittype	:	init_kulittype_search, 
			init_kulitminyak	:	init_kulitminyak_search, 
			init_kulitpipi	:	init_kulitpipi_search, 
			init_kulitt	:	init_kulitt_search, 
			init_kulittebal	:	init_kulittebal_search, 
			init_kulitrapuh	:	init_kulitrapuh_search, 
			init_kulitkendur	:	init_kulitkendur_search, 
			init_melasmatype	:	init_melasmatype_search, 
			init_melasmacentrofacial	:	init_melasmacentrofacial_search, 
			init_melasmamalar	:	init_melasmamalar_search, 
			init_melasmamandibular	:	init_melasmamandibular_search, 
			init_hipepidermal	:	init_hipepidermal_search, 
			init_hipdermal	:	init_hipdermal_search, 
			init_hippih	:	init_hippih_search, 
			init_hiplingkarmata	:	init_hiplingkarmata_search, 
			init_hypopigment	:	init_hypopigment_search, 
			init_acne	:	init_acne_search, 
			init_acnelesions	:	init_acnelesions_search, 
			init_acnetelangiectasis	:	init_acnetelangiectasis_search, 
			init_acnelocation	:	init_acnelocation_search, 
			init_wringkleslines	:	init_wringkleslines_search, 
			init_wringklesdinamics	:	init_wringklesdinamics_search, 
			init_wringklesstatic	:	init_wringklesstatic_search, 
			init_wringklesfold	:	init_wringklesfold_search, 
			init_wringkleslain	:	init_wringkleslain_search, 
			init_otherskinlesions	:	init_otherskinlesions_search, 
			init_cellulitegrade	:	init_cellulitegrade_search, 
			init_cellulitelocation	:	init_cellulitelocation_search, 
			init_strectmark	:	init_strectmark_search, 
			init_hairproblem	:	init_hairproblem_search, 
			init_height	:	init_height_search, 
			init_weight	:	init_weight_search, 
			init_idealweight	:	init_idealweight_search, 
			init_bmi	:	init_bmi_search, 
			init_misc	:	init_misc_search, 
			init_diagnosis	:	init_diagnosis_search, 
			init_ddx	:	init_ddx_search, 
			init_treatmentplan	:	init_treatmentplan_search 
};
		// Cause the datastore to do another query : 
		initial_assessment_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function initial_assessment_reset_search(){
		// reset the store parameters
		initial_assessment_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		initial_assessment_DataStore.reload({params: {start: 0, limit: pageS}});
		initial_assessment_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  init_customer Search Field */
	init_customerSearchField= new Ext.form.NumberField({
		id: 'init_customerSearchField',
		fieldLabel: 'Init Customer',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  init_tanggal Search Field */
	init_tanggalSearchField= new Ext.form.DateField({
		id: 'init_tanggalSearchField',
		fieldLabel: 'Init Tanggal',
		format : 'Y-m-d',
	
	});
	/* Identify  init_oleh Search Field */
	init_olehSearchField= new Ext.form.TextField({
		id: 'init_olehSearchField',
		fieldLabel: 'Init Oleh',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_kulitwarna Search Field */
	init_kulitwarnaSearchField= new Ext.form.TextField({
		id: 'init_kulitwarnaSearchField',
		fieldLabel: 'Init Kulitwarna',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_kulittype Search Field */
	init_kulittypeSearchField= new Ext.form.ComboBox({
		id: 'init_kulittypeSearchField',
		fieldLabel: 'Init Kulittype',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulittype'],
			data:[['I','I'],['II','II'],['III','III'],['IV','IV'],['V','V'],['VI','VI']]
		}),
		mode: 'local',
		displayField: 'init_kulittype',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_kulitminyak Search Field */
	init_kulitminyakSearchField= new Ext.form.ComboBox({
		id: 'init_kulitminyakSearchField',
		fieldLabel: 'Init Kulitminyak',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulitminyak'],
			data:[['kering','kering'],['normal','normal'],['kombinasi berminyak','kombinasi berminyak'],['berminyak','berminyak']]
		}),
		mode: 'local',
		displayField: 'init_kulitminyak',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_kulitpipi Search Field */
	init_kulitpipiSearchField= new Ext.form.ComboBox({
		id: 'init_kulitpipiSearchField',
		fieldLabel: 'Init Kulitpipi',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulitpipi'],
			data:[['berminyak','berminyak'],['normal','normal'],['kering','kering']]
		}),
		mode: 'local',
		displayField: 'init_kulitpipi',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_kulitt Search Field */
	init_kulittSearchField= new Ext.form.ComboBox({
		id: 'init_kulittSearchField',
		fieldLabel: 'Init Kulitt',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulitt'],
			data:[['berminyak','berminyak'],['normal','normal'],['kering','kering']]
		}),
		mode: 'local',
		displayField: 'init_kulitt',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_kulittebal Search Field */
	init_kulittebalSearchField= new Ext.form.ComboBox({
		id: 'init_kulittebalSearchField',
		fieldLabel: 'Init Kulittebal',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulittebal'],
			data:[['tipis','tipis'],['sedang','sedang'],['tebal','tebal']]
		}),
		mode: 'local',
		displayField: 'init_kulittebal',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_kulitrapuh Search Field */
	init_kulitrapuhSearchField= new Ext.form.ComboBox({
		id: 'init_kulitrapuhSearchField',
		fieldLabel: 'Init Kulitrapuh',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulitrapuh'],
			data:[['normal','normal'],['rapuh','rapuh']]
		}),
		mode: 'local',
		displayField: 'init_kulitrapuh',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_kulitkendur Search Field */
	init_kulitkendurSearchField= new Ext.form.ComboBox({
		id: 'init_kulitkendurSearchField',
		fieldLabel: 'Init Kulitkendur',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_kulitkendur'],
			data:[['kencang','kencang'],['kendur','kendur']]
		}),
		mode: 'local',
		displayField: 'init_kulitkendur',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_melasmatype Search Field */
	init_melasmatypeSearchField= new Ext.form.ComboBox({
		id: 'init_melasmatypeSearchField',
		fieldLabel: 'Init Melasmatype',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_melasmatype'],
			data:[['epidermal','epidermal'],['dermal','dermal'],['mixed melasma','mixed melasma'],['indeterminate','indeterminate']]
		}),
		mode: 'local',
		displayField: 'init_melasmatype',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_melasmacentrofacial Search Field */
	init_melasmacentrofacialSearchField= new Ext.form.ComboBox({
		id: 'init_melasmacentrofacialSearchField',
		fieldLabel: 'Init Melasmacentrofacial',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_melasmacentrofacial'],
			data:[['forehead','forehead'],['nose','nose'],['superior lip','superior lip'],['chin','chin']]
		}),
		mode: 'local',
		displayField: 'init_melasmacentrofacial',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_melasmamalar Search Field */
	init_melasmamalarSearchField= new Ext.form.ComboBox({
		id: 'init_melasmamalarSearchField',
		fieldLabel: 'Init Melasmamalar',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_melasmamalar'],
			data:[['right cheek','right cheek'],['left cheek','left cheek']]
		}),
		mode: 'local',
		displayField: 'init_melasmamalar',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_melasmamandibular Search Field */
	init_melasmamandibularSearchField= new Ext.form.ComboBox({
		id: 'init_melasmamandibularSearchField',
		fieldLabel: 'Init Melasmamandibular',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_melasmamandibular'],
			data:[['right mandibula','right mandibula'],['left mandibula','left mandibula']]
		}),
		mode: 'local',
		displayField: 'init_melasmamandibular',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_hipepidermal Search Field */
	init_hipepidermalSearchField= new Ext.form.TextField({
		id: 'init_hipepidermalSearchField',
		fieldLabel: 'Init Hipepidermal',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  init_hipdermal Search Field */
	init_hipdermalSearchField= new Ext.form.TextField({
		id: 'init_hipdermalSearchField',
		fieldLabel: 'Init Hipdermal',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  init_hippih Search Field */
	init_hippihSearchField= new Ext.form.ComboBox({
		id: 'init_hippihSearchField',
		fieldLabel: 'Init Hippih',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_hippih'],
			data:[['y','y'],['t','t']]
		}),
		mode: 'local',
		displayField: 'init_hippih',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_hiplingkarmata Search Field */
	init_hiplingkarmataSearchField= new Ext.form.ComboBox({
		id: 'init_hiplingkarmataSearchField',
		fieldLabel: 'Init Hiplingkarmata',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_hiplingkarmata'],
			data:[['y','y'],['t','t']]
		}),
		mode: 'local',
		displayField: 'init_hiplingkarmata',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_hypopigment Search Field */
	init_hypopigmentSearchField= new Ext.form.TextField({
		id: 'init_hypopigmentSearchField',
		fieldLabel: 'Init Hypopigment',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  init_acne Search Field */
	init_acneSearchField= new Ext.form.ComboBox({
		id: 'init_acneSearchField',
		fieldLabel: 'Init Acne',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_acne'],
			data:[['polymorphic','polymorphic'],['monomorphic','monomorphic']]
		}),
		mode: 'local',
		displayField: 'init_acne',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_acnelesions Search Field */
	init_acnelesionsSearchField= new Ext.form.TextField({
		id: 'init_acnelesionsSearchField',
		fieldLabel: 'Init Acnelesions',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  init_acnetelangiectasis Search Field */
	init_acnetelangiectasisSearchField= new Ext.form.ComboBox({
		id: 'init_acnetelangiectasisSearchField',
		fieldLabel: 'Init Acnetelangiectasis',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_acnetelangiectasis'],
			data:[['y','y'],['n','n']]
		}),
		mode: 'local',
		displayField: 'init_acnetelangiectasis',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_acnelocation Search Field */
	init_acnelocationSearchField= new Ext.form.ComboBox({
		id: 'init_acnelocationSearchField',
		fieldLabel: 'Init Acnelocation',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_acnelocation'],
			data:[['face','face'],['back','back'],['neck','neck'],['upper arm','upper arm'],['back','back']]
		}),
		mode: 'local',
		displayField: 'init_acnelocation',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_wringkleslines Search Field */
	init_wringkleslinesSearchField= new Ext.form.TextField({
		id: 'init_wringkleslinesSearchField',
		fieldLabel: 'Init Wringkleslines',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_wringklesdinamics Search Field */
	init_wringklesdinamicsSearchField= new Ext.form.TextField({
		id: 'init_wringklesdinamicsSearchField',
		fieldLabel: 'Init Wringklesdinamics',
		maxLength: 200,
		anchor: '95%'
	
	});
	/* Identify  init_wringklesstatic Search Field */
	init_wringklesstaticSearchField= new Ext.form.ComboBox({
		id: 'init_wringklesstaticSearchField',
		fieldLabel: 'Init Wringklesstatic',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_wringklesstatic'],
			data:[['horizontal forehead lines','horizontal forehead lines'],['glabellar lines','glabellar lines']]
		}),
		mode: 'local',
		displayField: 'init_wringklesstatic',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_wringklesfold Search Field */
	init_wringklesfoldSearchField= new Ext.form.ComboBox({
		id: 'init_wringklesfoldSearchField',
		fieldLabel: 'Init Wringklesfold',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_wringklesfold'],
			data:[['deep nasolabial fold','deep nasolabial fold'],['marionette lines','marionette lines']]
		}),
		mode: 'local',
		displayField: 'init_wringklesfold',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_wringkleslain Search Field */
	init_wringkleslainSearchField= new Ext.form.TextField({
		id: 'init_wringkleslainSearchField',
		fieldLabel: 'Init Wringkleslain',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_otherskinlesions Search Field */
	init_otherskinlesionsSearchField= new Ext.form.TextField({
		id: 'init_otherskinlesionsSearchField',
		fieldLabel: 'Init Otherskinlesions',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  init_cellulitegrade Search Field */
	init_cellulitegradeSearchField= new Ext.form.ComboBox({
		id: 'init_cellulitegradeSearchField',
		fieldLabel: 'Init Cellulitegrade',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_cellulitegrade'],
			data:[['I','I'],['II','II'],['III','III'],['IV','IV']]
		}),
		mode: 'local',
		displayField: 'init_cellulitegrade',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_cellulitelocation Search Field */
	init_cellulitelocationSearchField= new Ext.form.ComboBox({
		id: 'init_cellulitelocationSearchField',
		fieldLabel: 'Init Cellulitelocation',
		store:new Ext.data.SimpleStore({
			fields:['value', 'init_cellulitelocation'],
			data:[['upper arm','upper arm'],['buttocks','buttocks'],['thighs','thighs']]
		}),
		mode: 'local',
		displayField: 'init_cellulitelocation',
		valueField: 'value',
		anchor: '95%',
		triggerAction: 'all'	 
	
	});
	/* Identify  init_strectmark Search Field */
	init_strectmarkSearchField= new Ext.form.TextField({
		id: 'init_strectmarkSearchField',
		fieldLabel: 'Init Strectmark',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  init_hairproblem Search Field */
	init_hairproblemSearchField= new Ext.form.TextField({
		id: 'init_hairproblemSearchField',
		fieldLabel: 'Init Hairproblem',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_height Search Field */
	init_heightSearchField= new Ext.form.NumberField({
		id: 'init_heightSearchField',
		fieldLabel: 'Init Height',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  init_weight Search Field */
	init_weightSearchField= new Ext.form.NumberField({
		id: 'init_weightSearchField',
		fieldLabel: 'Init Weight',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  init_idealweight Search Field */
	init_idealweightSearchField= new Ext.form.NumberField({
		id: 'init_idealweightSearchField',
		fieldLabel: 'Init Idealweight',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  init_bmi Search Field */
	init_bmiSearchField= new Ext.form.NumberField({
		id: 'init_bmiSearchField',
		fieldLabel: 'Init Bmi',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  init_misc Search Field */
	init_miscSearchField= new Ext.form.TextField({
		id: 'init_miscSearchField',
		fieldLabel: 'Init Misc',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_diagnosis Search Field */
	init_diagnosisSearchField= new Ext.form.TextField({
		id: 'init_diagnosisSearchField',
		fieldLabel: 'Init Diagnosis',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_ddx Search Field */
	init_ddxSearchField= new Ext.form.TextField({
		id: 'init_ddxSearchField',
		fieldLabel: 'Init Ddx',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  init_treatmentplan Search Field */
	init_treatmentplanSearchField= new Ext.form.TextField({
		id: 'init_treatmentplanSearchField',
		fieldLabel: 'Init Treatmentplan',
		maxLength: 500,
		anchor: '95%'
	
	});
    
	/* Function for retrieve search Form Panel */
	initial_assessment_searchForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1500,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				items: [init_customerSearchFieldinit_tanggalSearchField, init_olehSearchField, init_kulitwarnaSearchField, init_kulittypeSearchField, init_kulitminyakSearchField, init_kulitpipiSearchField, init_kulittSearchField, init_kulittebalSearchField, init_kulitrapuhSearchField, init_kulitkendurSearchField] 
			}
			,{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				items: [init_melasmatypeSearchField, init_melasmacentrofacialSearchField, init_melasmamalarSearchField, init_melasmamandibularSearchField, init_hipepidermalSearchField, init_hipdermalSearchField, init_hippihSearchField, init_hiplingkarmataSearchField, init_hypopigmentSearchField, init_acneSearchField] 
			}
			,{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				items: [init_acnelesionsSearchField, init_acnetelangiectasisSearchField, init_acnelocationSearchField, init_wringkleslinesSearchField, init_wringklesdinamicsSearchField, init_wringklesstaticSearchField, init_wringklesfoldSearchField, init_wringkleslainSearchField, init_otherskinlesionsSearchField, init_cellulitegradeSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: initial_assessment_list_search
			},{
				text: 'Close',
				handler: function(){
					initial_assessment_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	initial_assessment_searchWindow = new Ext.Window({
		title: 'initial_assessment Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_initial_assessment_search',
		items: initial_assessment_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!initial_assessment_searchWindow.isVisible()){
			initial_assessment_searchWindow.show();
		} else {
			initial_assessment_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function initial_assessment_print(){
		var searchquery = "";
		var init_customer_print=null;
		var init_tanggal_print_date="";
		var init_oleh_print=null;
		var init_kulitwarna_print=null;
		var init_kulittype_print=null;
		var init_kulitminyak_print=null;
		var init_kulitpipi_print=null;
		var init_kulitt_print=null;
		var init_kulittebal_print=null;
		var init_kulitrapuh_print=null;
		var init_kulitkendur_print=null;
		var init_melasmatype_print=null;
		var init_melasmacentrofacial_print=null;
		var init_melasmamalar_print=null;
		var init_melasmamandibular_print=null;
		var init_hipepidermal_print=null;
		var init_hipdermal_print=null;
		var init_hippih_print=null;
		var init_hiplingkarmata_print=null;
		var init_hypopigment_print=null;
		var init_acne_print=null;
		var init_acnelesions_print=null;
		var init_acnetelangiectasis_print=null;
		var init_acnelocation_print=null;
		var init_wringkleslines_print=null;
		var init_wringklesdinamics_print=null;
		var init_wringklesstatic_print=null;
		var init_wringklesfold_print=null;
		var init_wringkleslain_print=null;
		var init_otherskinlesions_print=null;
		var init_cellulitegrade_print=null;
		var init_cellulitelocation_print=null;
		var init_strectmark_print=null;
		var init_hairproblem_print=null;
		var init_height_print=null;
		var init_weight_print=null;
		var init_idealweight_print=null;
		var init_bmi_print=null;
		var init_misc_print=null;
		var init_diagnosis_print=null;
		var init_ddx_print=null;
		var init_treatmentplan_print=null;
		var win;              
		// check if we do have some search data...
		if(initial_assessment_DataStore.baseParams.query!==null){searchquery = initial_assessment_DataStore.baseParams.query;}
		if(initial_assessment_DataStore.baseParams.init_customer!==null){init_customer_print = initial_assessment_DataStore.baseParams.init_customer;}
		if(initial_assessment_DataStore.baseParams.init_tanggal!==""){init_tanggal_print_date = initial_assessment_DataStore.baseParams.init_tanggal;}
		if(initial_assessment_DataStore.baseParams.init_oleh!==null){init_oleh_print = initial_assessment_DataStore.baseParams.init_oleh;}
		if(initial_assessment_DataStore.baseParams.init_kulitwarna!==null){init_kulitwarna_print = initial_assessment_DataStore.baseParams.init_kulitwarna;}
		if(initial_assessment_DataStore.baseParams.init_kulittype!==null){init_kulittype_print = initial_assessment_DataStore.baseParams.init_kulittype;}
		if(initial_assessment_DataStore.baseParams.init_kulitminyak!==null){init_kulitminyak_print = initial_assessment_DataStore.baseParams.init_kulitminyak;}
		if(initial_assessment_DataStore.baseParams.init_kulitpipi!==null){init_kulitpipi_print = initial_assessment_DataStore.baseParams.init_kulitpipi;}
		if(initial_assessment_DataStore.baseParams.init_kulitt!==null){init_kulitt_print = initial_assessment_DataStore.baseParams.init_kulitt;}
		if(initial_assessment_DataStore.baseParams.init_kulittebal!==null){init_kulittebal_print = initial_assessment_DataStore.baseParams.init_kulittebal;}
		if(initial_assessment_DataStore.baseParams.init_kulitrapuh!==null){init_kulitrapuh_print = initial_assessment_DataStore.baseParams.init_kulitrapuh;}
		if(initial_assessment_DataStore.baseParams.init_kulitkendur!==null){init_kulitkendur_print = initial_assessment_DataStore.baseParams.init_kulitkendur;}
		if(initial_assessment_DataStore.baseParams.init_melasmatype!==null){init_melasmatype_print = initial_assessment_DataStore.baseParams.init_melasmatype;}
		if(initial_assessment_DataStore.baseParams.init_melasmacentrofacial!==null){init_melasmacentrofacial_print = initial_assessment_DataStore.baseParams.init_melasmacentrofacial;}
		if(initial_assessment_DataStore.baseParams.init_melasmamalar!==null){init_melasmamalar_print = initial_assessment_DataStore.baseParams.init_melasmamalar;}
		if(initial_assessment_DataStore.baseParams.init_melasmamandibular!==null){init_melasmamandibular_print = initial_assessment_DataStore.baseParams.init_melasmamandibular;}
		if(initial_assessment_DataStore.baseParams.init_hipepidermal!==null){init_hipepidermal_print = initial_assessment_DataStore.baseParams.init_hipepidermal;}
		if(initial_assessment_DataStore.baseParams.init_hipdermal!==null){init_hipdermal_print = initial_assessment_DataStore.baseParams.init_hipdermal;}
		if(initial_assessment_DataStore.baseParams.init_hippih!==null){init_hippih_print = initial_assessment_DataStore.baseParams.init_hippih;}
		if(initial_assessment_DataStore.baseParams.init_hiplingkarmata!==null){init_hiplingkarmata_print = initial_assessment_DataStore.baseParams.init_hiplingkarmata;}
		if(initial_assessment_DataStore.baseParams.init_hypopigment!==null){init_hypopigment_print = initial_assessment_DataStore.baseParams.init_hypopigment;}
		if(initial_assessment_DataStore.baseParams.init_acne!==null){init_acne_print = initial_assessment_DataStore.baseParams.init_acne;}
		if(initial_assessment_DataStore.baseParams.init_acnelesions!==null){init_acnelesions_print = initial_assessment_DataStore.baseParams.init_acnelesions;}
		if(initial_assessment_DataStore.baseParams.init_acnetelangiectasis!==null){init_acnetelangiectasis_print = initial_assessment_DataStore.baseParams.init_acnetelangiectasis;}
		if(initial_assessment_DataStore.baseParams.init_acnelocation!==null){init_acnelocation_print = initial_assessment_DataStore.baseParams.init_acnelocation;}
		if(initial_assessment_DataStore.baseParams.init_wringkleslines!==null){init_wringkleslines_print = initial_assessment_DataStore.baseParams.init_wringkleslines;}
		if(initial_assessment_DataStore.baseParams.init_wringklesdinamics!==null){init_wringklesdinamics_print = initial_assessment_DataStore.baseParams.init_wringklesdinamics;}
		if(initial_assessment_DataStore.baseParams.init_wringklesstatic!==null){init_wringklesstatic_print = initial_assessment_DataStore.baseParams.init_wringklesstatic;}
		if(initial_assessment_DataStore.baseParams.init_wringklesfold!==null){init_wringklesfold_print = initial_assessment_DataStore.baseParams.init_wringklesfold;}
		if(initial_assessment_DataStore.baseParams.init_wringkleslain!==null){init_wringkleslain_print = initial_assessment_DataStore.baseParams.init_wringkleslain;}
		if(initial_assessment_DataStore.baseParams.init_otherskinlesions!==null){init_otherskinlesions_print = initial_assessment_DataStore.baseParams.init_otherskinlesions;}
		if(initial_assessment_DataStore.baseParams.init_cellulitegrade!==null){init_cellulitegrade_print = initial_assessment_DataStore.baseParams.init_cellulitegrade;}
		if(initial_assessment_DataStore.baseParams.init_cellulitelocation!==null){init_cellulitelocation_print = initial_assessment_DataStore.baseParams.init_cellulitelocation;}
		if(initial_assessment_DataStore.baseParams.init_strectmark!==null){init_strectmark_print = initial_assessment_DataStore.baseParams.init_strectmark;}
		if(initial_assessment_DataStore.baseParams.init_hairproblem!==null){init_hairproblem_print = initial_assessment_DataStore.baseParams.init_hairproblem;}
		if(initial_assessment_DataStore.baseParams.init_height!==null){init_height_print = initial_assessment_DataStore.baseParams.init_height;}
		if(initial_assessment_DataStore.baseParams.init_weight!==null){init_weight_print = initial_assessment_DataStore.baseParams.init_weight;}
		if(initial_assessment_DataStore.baseParams.init_idealweight!==null){init_idealweight_print = initial_assessment_DataStore.baseParams.init_idealweight;}
		if(initial_assessment_DataStore.baseParams.init_bmi!==null){init_bmi_print = initial_assessment_DataStore.baseParams.init_bmi;}
		if(initial_assessment_DataStore.baseParams.init_misc!==null){init_misc_print = initial_assessment_DataStore.baseParams.init_misc;}
		if(initial_assessment_DataStore.baseParams.init_diagnosis!==null){init_diagnosis_print = initial_assessment_DataStore.baseParams.init_diagnosis;}
		if(initial_assessment_DataStore.baseParams.init_ddx!==null){init_ddx_print = initial_assessment_DataStore.baseParams.init_ddx;}
		if(initial_assessment_DataStore.baseParams.init_treatmentplan!==null){init_treatmentplan_print = initial_assessment_DataStore.baseParams.init_treatmentplan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_initial_assessment&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			init_customer : init_customer_print,
		  	init_tanggal : init_tanggal_print_date, 
			init_oleh : init_oleh_print,
			init_kulitwarna : init_kulitwarna_print,
			init_kulittype : init_kulittype_print,
			init_kulitminyak : init_kulitminyak_print,
			init_kulitpipi : init_kulitpipi_print,
			init_kulitt : init_kulitt_print,
			init_kulittebal : init_kulittebal_print,
			init_kulitrapuh : init_kulitrapuh_print,
			init_kulitkendur : init_kulitkendur_print,
			init_melasmatype : init_melasmatype_print,
			init_melasmacentrofacial : init_melasmacentrofacial_print,
			init_melasmamalar : init_melasmamalar_print,
			init_melasmamandibular : init_melasmamandibular_print,
			init_hipepidermal : init_hipepidermal_print,
			init_hipdermal : init_hipdermal_print,
			init_hippih : init_hippih_print,
			init_hiplingkarmata : init_hiplingkarmata_print,
			init_hypopigment : init_hypopigment_print,
			init_acne : init_acne_print,
			init_acnelesions : init_acnelesions_print,
			init_acnetelangiectasis : init_acnetelangiectasis_print,
			init_acnelocation : init_acnelocation_print,
			init_wringkleslines : init_wringkleslines_print,
			init_wringklesdinamics : init_wringklesdinamics_print,
			init_wringklesstatic : init_wringklesstatic_print,
			init_wringklesfold : init_wringklesfold_print,
			init_wringkleslain : init_wringkleslain_print,
			init_otherskinlesions : init_otherskinlesions_print,
			init_cellulitegrade : init_cellulitegrade_print,
			init_cellulitelocation : init_cellulitelocation_print,
			init_strectmark : init_strectmark_print,
			init_hairproblem : init_hairproblem_print,
			init_height : init_height_print,
			init_weight : init_weight_print,
			init_idealweight : init_idealweight_print,
			init_bmi : init_bmi_print,
			init_misc : init_misc_print,
			init_diagnosis : init_diagnosis_print,
			init_ddx : init_ddx_print,
			init_treatmentplan : init_treatmentplan_print,
		  	currentlisting: initial_assessment_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./initial_assessmentlist.html','initial_assessmentlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function initial_assessment_export_excel(){
		var searchquery = "";
		var init_customer_2excel=null;
		var init_tanggal_2excel_date="";
		var init_oleh_2excel=null;
		var init_kulitwarna_2excel=null;
		var init_kulittype_2excel=null;
		var init_kulitminyak_2excel=null;
		var init_kulitpipi_2excel=null;
		var init_kulitt_2excel=null;
		var init_kulittebal_2excel=null;
		var init_kulitrapuh_2excel=null;
		var init_kulitkendur_2excel=null;
		var init_melasmatype_2excel=null;
		var init_melasmacentrofacial_2excel=null;
		var init_melasmamalar_2excel=null;
		var init_melasmamandibular_2excel=null;
		var init_hipepidermal_2excel=null;
		var init_hipdermal_2excel=null;
		var init_hippih_2excel=null;
		var init_hiplingkarmata_2excel=null;
		var init_hypopigment_2excel=null;
		var init_acne_2excel=null;
		var init_acnelesions_2excel=null;
		var init_acnetelangiectasis_2excel=null;
		var init_acnelocation_2excel=null;
		var init_wringkleslines_2excel=null;
		var init_wringklesdinamics_2excel=null;
		var init_wringklesstatic_2excel=null;
		var init_wringklesfold_2excel=null;
		var init_wringkleslain_2excel=null;
		var init_otherskinlesions_2excel=null;
		var init_cellulitegrade_2excel=null;
		var init_cellulitelocation_2excel=null;
		var init_strectmark_2excel=null;
		var init_hairproblem_2excel=null;
		var init_height_2excel=null;
		var init_weight_2excel=null;
		var init_idealweight_2excel=null;
		var init_bmi_2excel=null;
		var init_misc_2excel=null;
		var init_diagnosis_2excel=null;
		var init_ddx_2excel=null;
		var init_treatmentplan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(initial_assessment_DataStore.baseParams.query!==null){searchquery = initial_assessment_DataStore.baseParams.query;}
		if(initial_assessment_DataStore.baseParams.init_customer!==null){init_customer_2excel = initial_assessment_DataStore.baseParams.init_customer;}
		if(initial_assessment_DataStore.baseParams.init_tanggal!==""){init_tanggal_2excel_date = initial_assessment_DataStore.baseParams.init_tanggal;}
		if(initial_assessment_DataStore.baseParams.init_oleh!==null){init_oleh_2excel = initial_assessment_DataStore.baseParams.init_oleh;}
		if(initial_assessment_DataStore.baseParams.init_kulitwarna!==null){init_kulitwarna_2excel = initial_assessment_DataStore.baseParams.init_kulitwarna;}
		if(initial_assessment_DataStore.baseParams.init_kulittype!==null){init_kulittype_2excel = initial_assessment_DataStore.baseParams.init_kulittype;}
		if(initial_assessment_DataStore.baseParams.init_kulitminyak!==null){init_kulitminyak_2excel = initial_assessment_DataStore.baseParams.init_kulitminyak;}
		if(initial_assessment_DataStore.baseParams.init_kulitpipi!==null){init_kulitpipi_2excel = initial_assessment_DataStore.baseParams.init_kulitpipi;}
		if(initial_assessment_DataStore.baseParams.init_kulitt!==null){init_kulitt_2excel = initial_assessment_DataStore.baseParams.init_kulitt;}
		if(initial_assessment_DataStore.baseParams.init_kulittebal!==null){init_kulittebal_2excel = initial_assessment_DataStore.baseParams.init_kulittebal;}
		if(initial_assessment_DataStore.baseParams.init_kulitrapuh!==null){init_kulitrapuh_2excel = initial_assessment_DataStore.baseParams.init_kulitrapuh;}
		if(initial_assessment_DataStore.baseParams.init_kulitkendur!==null){init_kulitkendur_2excel = initial_assessment_DataStore.baseParams.init_kulitkendur;}
		if(initial_assessment_DataStore.baseParams.init_melasmatype!==null){init_melasmatype_2excel = initial_assessment_DataStore.baseParams.init_melasmatype;}
		if(initial_assessment_DataStore.baseParams.init_melasmacentrofacial!==null){init_melasmacentrofacial_2excel = initial_assessment_DataStore.baseParams.init_melasmacentrofacial;}
		if(initial_assessment_DataStore.baseParams.init_melasmamalar!==null){init_melasmamalar_2excel = initial_assessment_DataStore.baseParams.init_melasmamalar;}
		if(initial_assessment_DataStore.baseParams.init_melasmamandibular!==null){init_melasmamandibular_2excel = initial_assessment_DataStore.baseParams.init_melasmamandibular;}
		if(initial_assessment_DataStore.baseParams.init_hipepidermal!==null){init_hipepidermal_2excel = initial_assessment_DataStore.baseParams.init_hipepidermal;}
		if(initial_assessment_DataStore.baseParams.init_hipdermal!==null){init_hipdermal_2excel = initial_assessment_DataStore.baseParams.init_hipdermal;}
		if(initial_assessment_DataStore.baseParams.init_hippih!==null){init_hippih_2excel = initial_assessment_DataStore.baseParams.init_hippih;}
		if(initial_assessment_DataStore.baseParams.init_hiplingkarmata!==null){init_hiplingkarmata_2excel = initial_assessment_DataStore.baseParams.init_hiplingkarmata;}
		if(initial_assessment_DataStore.baseParams.init_hypopigment!==null){init_hypopigment_2excel = initial_assessment_DataStore.baseParams.init_hypopigment;}
		if(initial_assessment_DataStore.baseParams.init_acne!==null){init_acne_2excel = initial_assessment_DataStore.baseParams.init_acne;}
		if(initial_assessment_DataStore.baseParams.init_acnelesions!==null){init_acnelesions_2excel = initial_assessment_DataStore.baseParams.init_acnelesions;}
		if(initial_assessment_DataStore.baseParams.init_acnetelangiectasis!==null){init_acnetelangiectasis_2excel = initial_assessment_DataStore.baseParams.init_acnetelangiectasis;}
		if(initial_assessment_DataStore.baseParams.init_acnelocation!==null){init_acnelocation_2excel = initial_assessment_DataStore.baseParams.init_acnelocation;}
		if(initial_assessment_DataStore.baseParams.init_wringkleslines!==null){init_wringkleslines_2excel = initial_assessment_DataStore.baseParams.init_wringkleslines;}
		if(initial_assessment_DataStore.baseParams.init_wringklesdinamics!==null){init_wringklesdinamics_2excel = initial_assessment_DataStore.baseParams.init_wringklesdinamics;}
		if(initial_assessment_DataStore.baseParams.init_wringklesstatic!==null){init_wringklesstatic_2excel = initial_assessment_DataStore.baseParams.init_wringklesstatic;}
		if(initial_assessment_DataStore.baseParams.init_wringklesfold!==null){init_wringklesfold_2excel = initial_assessment_DataStore.baseParams.init_wringklesfold;}
		if(initial_assessment_DataStore.baseParams.init_wringkleslain!==null){init_wringkleslain_2excel = initial_assessment_DataStore.baseParams.init_wringkleslain;}
		if(initial_assessment_DataStore.baseParams.init_otherskinlesions!==null){init_otherskinlesions_2excel = initial_assessment_DataStore.baseParams.init_otherskinlesions;}
		if(initial_assessment_DataStore.baseParams.init_cellulitegrade!==null){init_cellulitegrade_2excel = initial_assessment_DataStore.baseParams.init_cellulitegrade;}
		if(initial_assessment_DataStore.baseParams.init_cellulitelocation!==null){init_cellulitelocation_2excel = initial_assessment_DataStore.baseParams.init_cellulitelocation;}
		if(initial_assessment_DataStore.baseParams.init_strectmark!==null){init_strectmark_2excel = initial_assessment_DataStore.baseParams.init_strectmark;}
		if(initial_assessment_DataStore.baseParams.init_hairproblem!==null){init_hairproblem_2excel = initial_assessment_DataStore.baseParams.init_hairproblem;}
		if(initial_assessment_DataStore.baseParams.init_height!==null){init_height_2excel = initial_assessment_DataStore.baseParams.init_height;}
		if(initial_assessment_DataStore.baseParams.init_weight!==null){init_weight_2excel = initial_assessment_DataStore.baseParams.init_weight;}
		if(initial_assessment_DataStore.baseParams.init_idealweight!==null){init_idealweight_2excel = initial_assessment_DataStore.baseParams.init_idealweight;}
		if(initial_assessment_DataStore.baseParams.init_bmi!==null){init_bmi_2excel = initial_assessment_DataStore.baseParams.init_bmi;}
		if(initial_assessment_DataStore.baseParams.init_misc!==null){init_misc_2excel = initial_assessment_DataStore.baseParams.init_misc;}
		if(initial_assessment_DataStore.baseParams.init_diagnosis!==null){init_diagnosis_2excel = initial_assessment_DataStore.baseParams.init_diagnosis;}
		if(initial_assessment_DataStore.baseParams.init_ddx!==null){init_ddx_2excel = initial_assessment_DataStore.baseParams.init_ddx;}
		if(initial_assessment_DataStore.baseParams.init_treatmentplan!==null){init_treatmentplan_2excel = initial_assessment_DataStore.baseParams.init_treatmentplan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_initial_assessment&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			init_customer : init_customer_2excel,
		  	init_tanggal : init_tanggal_2excel_date, 
			init_oleh : init_oleh_2excel,
			init_kulitwarna : init_kulitwarna_2excel,
			init_kulittype : init_kulittype_2excel,
			init_kulitminyak : init_kulitminyak_2excel,
			init_kulitpipi : init_kulitpipi_2excel,
			init_kulitt : init_kulitt_2excel,
			init_kulittebal : init_kulittebal_2excel,
			init_kulitrapuh : init_kulitrapuh_2excel,
			init_kulitkendur : init_kulitkendur_2excel,
			init_melasmatype : init_melasmatype_2excel,
			init_melasmacentrofacial : init_melasmacentrofacial_2excel,
			init_melasmamalar : init_melasmamalar_2excel,
			init_melasmamandibular : init_melasmamandibular_2excel,
			init_hipepidermal : init_hipepidermal_2excel,
			init_hipdermal : init_hipdermal_2excel,
			init_hippih : init_hippih_2excel,
			init_hiplingkarmata : init_hiplingkarmata_2excel,
			init_hypopigment : init_hypopigment_2excel,
			init_acne : init_acne_2excel,
			init_acnelesions : init_acnelesions_2excel,
			init_acnetelangiectasis : init_acnetelangiectasis_2excel,
			init_acnelocation : init_acnelocation_2excel,
			init_wringkleslines : init_wringkleslines_2excel,
			init_wringklesdinamics : init_wringklesdinamics_2excel,
			init_wringklesstatic : init_wringklesstatic_2excel,
			init_wringklesfold : init_wringklesfold_2excel,
			init_wringkleslain : init_wringkleslain_2excel,
			init_otherskinlesions : init_otherskinlesions_2excel,
			init_cellulitegrade : init_cellulitegrade_2excel,
			init_cellulitelocation : init_cellulitelocation_2excel,
			init_strectmark : init_strectmark_2excel,
			init_hairproblem : init_hairproblem_2excel,
			init_height : init_height_2excel,
			init_weight : init_weight_2excel,
			init_idealweight : init_idealweight_2excel,
			init_bmi : init_bmi_2excel,
			init_misc : init_misc_2excel,
			init_diagnosis : init_diagnosis_2excel,
			init_ddx : init_ddx_2excel,
			init_treatmentplan : init_treatmentplan_2excel,
		  	currentlisting: initial_assessment_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_initial_assessment"></div>
		<div id="elwindow_initial_assessment_create"></div>
        <div id="elwindow_initial_assessment_search"></div>
    </div>
</div>
</body>