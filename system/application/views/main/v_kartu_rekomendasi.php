<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: tindakan View
	+ Description	: For record view
	+ Filename 		: v_tindakan.php
 	+ Author  		: masongbee
 	+ Created on 27/Oct/2009 14:21:34
	
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
Ext.namespace('Ext.ux.plugin');

Ext.ux.plugin.triggerfieldTooltip = function(config){
    Ext.apply(this, config);
};

Ext.extend(Ext.ux.plugin.triggerfieldTooltip, Ext.util.Observable,{
    init: function(component){
        this.component = component;
        this.component.on('render', this.onRender, this);
    },
    
    //private
    onRender: function(){
        if(this.component.tooltip){
            if(typeof this.component.tooltip == 'object'){
                Ext.QuickTips.register(Ext.apply({
                      target: this.component.trigger
                }, this.component.tooltip));
            } else {
                this.component.trigger.dom[this.component.tooltipType] = this.component.tooltip;
            }
        }
    }
}); 

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
        /*
         * Always return true since we're only using this vtype to set the
         * min/max allowed values (these are tested for after the vtype test)
         */
        return true;
    }
});
/* declare function */		
var kartu_rekomendasiDataStore;
var kartu_rekomendasiColumnModel;
var rekomendasiListEditorGrid;
var kartu_rekomendasi_createForm;
var kartu_rekomendasi_createWindow;
var kartu_rekomendasi_searchForm;
var kartu_rekomendasi_searchWindow;
var kartu_rekomendasiSelectedRow;
var kartu_rekomendasiContextMenu;
//for detail data
var rekomendasi_medisdetail_DataStore;
var rekomendasi_medisdetailListEditorGrid;
var rekomendasi_medistdetail_ColumnModel;
var rekomendasi_produkdetail_DataStore;
var rekomendasi_produkdetailListEditorGrid;
var rekomendasi_produkdetail_ColumnModel;
var kartu_rekomendasi_detail_proxy;
var rekomendasi_medis_detail_writer;
var kartu_rekomendasi_detail_reader;
var editor_rekomendasi_medis_detail;
var editor_detail_produk;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

var dt = new Date();


/* declare variable here for Field*/
//var trawat_medis_idField;
var card_idField;
var rekomendasi_custField;
var rekomendasi_dokterField;
var rekomendasi_keteranganField;
var trawat_medis_idSearchField;
var trawat_medis_custSearchField;
var trawat_medis_keteranganSearchField;
var acneField;
var pigmentationField;
var wot_foreheadField;
var wot_crowsfeetField;
var wot_glabellar_frown_linesField;
var smilelinesField;
var fullerlipsField;
var shunkeneyeField;
var shunkencheekField;
var saggingcheekField;
var looseneckField;
var necklinesField;
var droopyeyesField;
var darkcirclesField;
var acnescarsField;
var permanenthair_removalField;
var tattooremovalField;
var waistsizeField;
var thighsizeField;
var tummysizeField;
var breastsizeField;
var legveinsField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function rekomendasi_update(oGrid_event){
		var trawat_id_update_pk="";
		var card_id_update_pk="";
		var rekomendasi_cust_update=null;
		var rekomendasi_keterangan_update=null;
		var dtrawat_status_update=null;
		var card_cust_id_update=null;
		var dtrawat_perawatan_id_update=null;
		var drawatm_perawatan_update=null;
		var drawatm_id_update=null;
		var perawatan_harga_update=null;
		var perawatan_du_update=null;
		var perawatan_dm_update=null;
		var cust_member_update=null;
		var drawatm_keterangan_update=null;
		var dtrawat_dapp_update="";
		var dtrawat_dokter_update=null;
		var dtrawat_dokter_id_update=null;
		var dtrawat_ambil_paket_update="";

		card_id_update_pk = oGrid_event.record.data.card_id;
		if(oGrid_event.record.data.card_cust!== null){rekomendasi_cust_update = oGrid_event.record.data.card_cust;}
		if(oGrid_event.record.data.card_keterangan!== null){rekomendasi_keterangan_update = oGrid_event.record.data.card_keterangan;}
		dtrawat_status_update = oGrid_event.record.data.dtrawat_status;
		card_cust_id_update = oGrid_event.record.data.card_cust_id;
		dtrawat_perawatan_id_update = oGrid_event.record.data.dtrawat_perawatan_id;
		drawatm_perawatan_update = oGrid_event.record.data.drawatm_perawatan;
		drawatm_id_update = oGrid_event.record.data.drawatm_id;
		perawatan_harga_update = oGrid_event.record.data.perawatan_harga;
		perawatan_du_update = oGrid_event.record.data.perawatan_du;
		perawatan_dm_update = oGrid_event.record.data.perawatan_dm;
		cust_member_update = oGrid_event.record.data.cust_member;
		if(oGrid_event.record.data.drawatm_keterangan!== null){drawatm_keterangan_update = oGrid_event.record.data.drawatm_keterangan;}
		dtrawat_dapp_update = oGrid_event.record.data.dtrawat_dapp;
		dtrawat_dokter_update = oGrid_event.record.data.dtrawat_petugas1;
		dtrawat_dokter_id_update = oGrid_event.record.data.dtrawat_petugas1_id;
		dtrawat_ambil_paket_update = oGrid_event.record.data.dtrawat_ambil_paket;
		apaket_id_update = oGrid_event.record.data.apaket_id;
		sapaket_id_update = oGrid_event.record.data.sapaket_id;
		sapaket_item_update = oGrid_event.record.data.sapaket_item;

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kartu_rekomendasi&m=get_action',
			params: {
				task: "UPDATE",
				mode_edit: "update_list",
				//trawat_id	: trawat_id_update_pk, 
				card_id		: card_id_update_pk,
				card_cust	:rekomendasi_cust_update,  
				card_keterangan	:rekomendasi_keterangan_update,  
				dtrawat_status	:dtrawat_status_update,
				card_cust_id	:card_cust_id_update,
				dtrawat_perawatan_id	:dtrawat_perawatan_id_update,
				drawatm_perawatan	:drawatm_perawatan_update,
				drawatm_id	:drawatm_id_update,
				rawat_harga	:perawatan_harga_update,
				rawat_du	:perawatan_du_update,
				rawat_dm	:perawatan_dm_update,
				cust_member	:cust_member_update,
				drawatm_keterangan	:drawatm_keterangan_update,
				dtrawat_dapp	: dtrawat_dapp_update,
				dtrawat_dokter : dtrawat_dokter_update,
				dtrawat_dokter_id : dtrawat_dokter_id_update,
				dtrawat_ambil_paket	: dtrawat_ambil_paket_update,
				apaket_id	: apaket_id_update,
				sapaket_id	: sapaket_id_update,
				sapaket_item	: sapaket_item_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					
					default:
						kartu_rekomendasiDataStore.commitChanges();
						kartu_rekomendasiDataStore.reload();
						rekomendasi_perawatan_medisDataStore.reload();
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
  
  	/* Function for add data, open window create form */
	function rekomendasi_create(){
	
		if(is_rekomendasiform_valid()){	
		var trawat_id_create=null; 
		var card_id_create=null;
		var rekomendasi_cust_create=null; 
		var rekomendasi_keterangan_create=null; 
		var rekomendasi_dokter_create=null;

		if(card_idField.getValue()!== null){trawat_id_create = card_idField.getValue();}else{trawat_id_create=get_pk_id();} 
		if(rekomendasi_custField.getValue()!== null){rekomendasi_cust_create = rekomendasi_custField.getValue();} 
		if(rekomendasi_dokterField.getValue()!== null){rekomendasi_dokter_create = rekomendasi_dokterField.getValue();}
		if(rekomendasi_keteranganField.getValue()!== null){rekomendasi_keterangan_create = rekomendasi_keteranganField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kartu_rekomendasi&m=get_action',
			params: {
				task: post2db,
				card_id	: trawat_id_create, 
				card_cust	: rekomendasi_cust_create,
				card_dokter : rekomendasi_dokter_create,
				card_keterangan	: rekomendasi_keterangan_create,
				card_wl1			: acneField.getValue(),
				card_wl2			: pigmentationField.getValue(),
				card_wl3			: wot_foreheadField.getValue(),
				card_wl4			: wot_crowsfeetField.getValue(),
				card_wl5			: wot_glabellar_frown_linesField.getValue(),
				card_wl6			: smilelinesField.getValue(),
				card_wl7			: fullerlipsField.getValue(),
				card_wl8			: shunkeneyeField.getValue(),
				card_wl9			: shunkencheekField.getValue(),
				card_wl10			: saggingcheekField.getValue(),
				card_wl11			: looseneckField.getValue(),
				card_wl12			: necklinesField.getValue(),
				card_wl13			: droopyeyesField.getValue(),
				card_wl14			: darkcirclesField.getValue(),
				card_wl15			: acnescarsField.getValue(),
				card_wl16			: permanenthair_removalField.getValue(),
				card_wl17			: tattooremovalField.getValue(),
				card_wl18			: waistsizeField.getValue(),
				card_wl19			: thighsizeField.getValue(),
				card_wl20			: tummysizeField.getValue(),
				card_wl21			: breastsizeField.getValue(),
				card_wl22			: legveinsField.getValue(),
		
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						rekomendasi_medisdetail_insert();
						rekomendasi_nonmedisdetail_insert();
						rekomendasi_produkdetail_insert();
						kartu_rekomendasi_createWindow.hide();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Tindakan.',
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
		if(post2db=='UPDATE')
			return rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function rekomendasi_reset_form(){
		card_idField.reset();
		card_idField.setValue(null);
		rekomendasi_custField.reset();
		rekomendasi_custField.setValue(null);
		rekomendasi_dokterField.reset();
		rekomendasi_dokterField.setValue(null);
		rekomendasi_keteranganField.reset();
		rekomendasi_keteranganField.setValue(null);
		acneField.reset();
		acneField.setValue(null);
		pigmentationField.reset();
		pigmentationField.setValue(null);
		wot_foreheadField.reset();
		wot_foreheadField.setValue(null);
		wot_crowsfeetField.reset();
		wot_crowsfeetField.setValue(null);
		wot_glabellar_frown_linesField.reset();
		wot_glabellar_frown_linesField.setValue(null);
		smilelinesField.reset();
		smilelinesField.setValue(null);
		fullerlipsField.reset();
		fullerlipsField.setValue(null);
		shunkeneyeField.reset();
		shunkeneyeField.setValue(null);
		shunkencheekField.reset();
		shunkencheekField.setValue(null);
		saggingcheekField.reset();
		saggingcheekField.setValue(null);
		looseneckField.reset();
		looseneckField.setValue(null);
		necklinesField.reset();
		necklinesField.setValue(null);
		droopyeyesField.reset();
		droopyeyesField.setValue(null);
		darkcirclesField.reset();
		darkcirclesField.setValue(null);
		acnescarsField.reset();
		acnescarsField.setValue(null);
		permanenthair_removalField.reset();
		permanenthair_removalField.setValue(null);
		tattooremovalField.reset();
		tattooremovalField.setValue(null);
		waistsizeField.reset();
		waistsizeField.setValue(null);
		thighsizeField.reset();
		thighsizeField.setValue(null);
		tummysizeField.reset();
		tummysizeField.setValue(null);
		breastsizeField.reset();
		breastsizeField.setValue(null);
		legveinsField.reset();
		legveinsField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function rekomendasi_set_form(){
		card_idField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_id'));
		rekomendasi_custField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_cust'));
		rekomendasi_dokterField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_dokter'));
		rekomendasi_custidField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_cust_id'));
		rekomendasi_keteranganField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_keterangan'));
		acneField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl1'));
		pigmentationField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl2'));
		wot_foreheadField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl3'));
		wot_crowsfeetField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl4'));
		wot_glabellar_frown_linesField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl5'));
		smilelinesField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl6'));
		fullerlipsField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl7'));
		shunkeneyeField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl8'));
		shunkencheekField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl9'));
		saggingcheekField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl10'));
		looseneckField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl11'));
		necklinesField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl12'));
		droopyeyesField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl13'));
		darkcirclesField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl14'));
		acnescarsField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl15'));
		permanenthair_removalField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl16'));
		tattooremovalField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl17'));
		waistsizeField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl18'));
		thighsizeField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl19'));
		tummysizeField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl20'));
		breastsizeField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl21'));
		legveinsField.setValue(rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_wl22'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_rekomendasiform_valid(){
		return (true &&  rekomendasi_custField.isValid() && true &&  true &&  true &&  true &&  true &&  true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!kartu_rekomendasi_createWindow.isVisible()){
			rekomendasi_medisdetail_DataStore.load({
				params: {master_id:0, start:0, limit:pageS}
			});
			rekomendasi_reset_form();
			post2db='CREATE';
			msg='created';
			kartu_rekomendasi_createWindow.show();
		} else {
			kartu_rekomendasi_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function rekomendasi_confirm_delete(){
		// only one tindakan is selected here
		if(rekomendasiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', rekomendasi_delete);
		} else if(rekomendasiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', rekomendasi_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function rekomendasi_confirm_update(){
		/* only one record is selected here */
		var get_card_id=rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_id');
		
		cbo_rekomendasi_dokterDataStore.load();
		if(rekomendasiListEditorGrid.selModel.getCount() == 1) {
			rekomendasi_perawatan_medisDataStore.load({params:{query:rekomendasiListEditorGrid.getSelectionModel().getSelected().get('card_id')}});
			rekomendasi_set_form();
			post2db='UPDATE';
			rekomendasi_medisdetail_DataStore.load({params : {master_id : eval(get_pk_id()), start:0, limit:pageS}});
			rekomendasi_nonmedisdetail_DataStore.load({params : {master_id : eval(get_pk_id()), start:0, limit:pageS}});
			rekomendasi_produkdetail_DataStore.load({params : {master_id : eval(get_pk_id()), start:0, limit:pageS}});
			msg='updated';
			kartu_rekomendasi_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really update something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function rekomendasi_delete(btn){
		if(btn=='yes'){
			var selections = rekomendasiListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< rekomendasiListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.card_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_kartu_rekomendasi&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							kartu_rekomendasiDataStore.reload();
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
  	
	Ext.util.Format.comboRenderer = function(combo){
	
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	kartu_rekomendasiDataStore = new Ext.data.Store({
		id: 'kartu_rekomendasiDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'card_id'
		},[
		/* dataIndex => insert intokartu_rekomendasiColumnModel, Mapping => for initiate table column */ 
			{name: 'card_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'card_cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'card_keterangan', type: 'string', mapping: 'card_keterangan'}, 
			{name: 'card_id', type: 'int', mapping: 'card_id'},
			{name: 'card_dokter', type: 'string', mapping: 'karyawan_username'},
			{name: 'card_wl1', type: 'int', mapping: 'card_wl1'},
			{name: 'card_wl2', type: 'int', mapping: 'card_wl2'},
			{name: 'card_wl3', type: 'int', mapping: 'card_wl3'},
			{name: 'card_wl4', type: 'int', mapping: 'card_wl4'},
			{name: 'card_wl5', type: 'int', mapping: 'card_wl5'},
			{name: 'card_wl6', type: 'int', mapping: 'card_wl6'},
			{name: 'card_wl7', type: 'int', mapping: 'card_wl7'},
			{name: 'card_wl8', type: 'int', mapping: 'card_wl8'},
			{name: 'card_wl9', type: 'int', mapping: 'card_wl9'},
			{name: 'card_wl10', type: 'int', mapping: 'card_wl10'},
			{name: 'card_wl11', type: 'int', mapping: 'card_wl11'},
			{name: 'card_wl12', type: 'int', mapping: 'card_wl12'},
			{name: 'card_wl13', type: 'int', mapping: 'card_wl13'},
			{name: 'card_wl14', type: 'int', mapping: 'card_wl14'},
			{name: 'card_wl15', type: 'int', mapping: 'card_wl15'},
			{name: 'card_wl16', type: 'int', mapping: 'card_wl16'},
			{name: 'card_wl17', type: 'int', mapping: 'card_wl17'},
			{name: 'card_wl18', type: 'int', mapping: 'card_wl18'},
			{name: 'card_wl19', type: 'int', mapping: 'card_wl19'},
			{name: 'card_wl20', type: 'int', mapping: 'card_wl20'},
			{name: 'card_wl21', type: 'int', mapping: 'card_wl21'},
			{name: 'card_wl22', type: 'int', mapping: 'card_wl22'},
			{name: 'card_creator', type: 'string', mapping: 'card_creator'}, 
			{name: 'card_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'card_date_create'}, 
			{name: 'card_update', type: 'string', mapping: 'card_update'}, 
			{name: 'card_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'card_date_update'}, 
			{name: 'card_revised', type: 'int', mapping: 'card_revised'}
		]),
		sortInfo:{field: 'card_cust_no', direction: "ASC"}
	});
	/* End of Function */
	
	//ComboBox ambil data Customer
	cbo_rekomendasi_customerDataStore = new Ext.data.Store({
		id: 'cbo_rekomendasi_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_customer_list', 
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
	var customer_rekomendasi_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            /*'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',*/
        '</div></tpl>'
    );
	
	rekomendasi_perawatan_medisDataStore = new Ext.data.Store({
		id: 'rekomendasi_perawatan_medisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_tindakan_medis_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'perawatan_value', type: 'int', mapping: 'rawat_id'},
			{name: 'perawatan_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'perawatan_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'perawatan_group', type: 'string', mapping: 'group_nama'},
			{name: 'perawatan_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'perawatan_du', type: 'float', mapping: 'rawat_du'},
			{name: 'perawatan_dm', type: 'float', mapping: 'rawat_dm'},
			{name: 'perawatan_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'perawatan_display', direction: "ASC"}
	});
	var rekomendasi_perawatan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{perawatan_kode}| <b>{perawatan_display}</b>',
		'</div></tpl>'
    );

	cbo_rekomendasi_dokterDataStore = new Ext.data.Store({
		id: 'cbo_rekomendasi_dokterDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_dokter_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'}
		]),
		sortInfo:{field: 'karyawan_display', direction: "ASC"}
	});
	var dokter_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{karyawan_username}</b> | {karyawan_display} | <b>{karyawan_jmltindakan}</b></span>',
        '</div></tpl>'
    );
    
  	/* Function for Identify of Window Column Model */
	kartu_rekomendasiColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'No Customer' + '</div>',
			dataIndex: 'card_cust_no',
			width: 80,	//210,
			sortable: true
			
		}, 
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'card_cust',
			width: 120,	//210,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Dokter' + '</div>',
			dataIndex: 'card_dokter',
			width: 80,
			sortable: true,
			editable:false
		}, 
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'card_keterangan',
			width: 185,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		}, 
		{
			header: 'Creator',
			dataIndex: 'card_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Tanggal',
			dataIndex: 'card_date_create',
			width: 150,
			renderer: Ext.util.Format.dateRenderer('Y-m-d H:i:s'),
			sortable: true,
			hidden: false
		}, 
		{
			header: 'Update',
			dataIndex: 'card_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Date Update',
			dataIndex: 'card_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'card_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	kartu_rekomendasiColumnModel.defaultSortable= true;
	/* End of Function */
	function ch_status(val){
		if(val=="selesai"){
			return '<span style="color:blue;"><b>' + val + '</b></span>';
		}else if(val=="siap"){
			return '<span style="color:green;"><b>' + val + '</b></span>';
		}else if(val=="datang"){
			return '<span style="color:red;"><b>' + val + '</b></span>';
		}else if(val=="batal"){
			return '<span style="color:black;"><b>' + val + '</b></span>';
		}
		return val;
	}
    
	/* Declare DataStore and  show datagrid list */
	rekomendasiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rekomendasiListEditorGrid',
		el: 'fp_kartu_rekomendasi',
		title: 'Daftar Kartu Rekomendasi',
		autoHeight: true,
		store: kartu_rekomendasiDataStore, // DataStore
		cm: kartu_rekomendasiColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1000,	//970,
		bbar: new Ext.PagingToolbar({
			disabled:false,
			store: kartu_rekomendasiDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			disabled:false,
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: rekomendasi_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: rekomendasi_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			disabled: false,
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: kartu_rekomendasiDataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						kartu_rekomendasiDataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama Customer<br>- Nama Dokter'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: rekomendasi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: rekomendasi_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: rekomendasi_print  
		}
		]
	});
	rekomendasiListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	kartu_rekomendasiContextMenu = new Ext.menu.Menu({
		id: 'tindakan_medisListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: rekomendasi_editContextMenu 
		},
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: rekomendasi_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: rekomendasi_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: rekomendasi_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onrekomendasi_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		kartu_rekomendasiContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		kartu_rekomendasiSelectedRow=rowIndex;
		kartu_rekomendasiContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function rekomendasi_editContextMenu(){
		//rekomendasiListEditorGrid.startEditing(kartu_rekomendasiSelectedRow,1);
		rekomendasi_confirm_update();
  	}
	/* End of Function */
  	
	rekomendasiListEditorGrid.addListener('rowcontextmenu', onrekomendasi_ListEditGridContextMenu);
	kartu_rekomendasiDataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	rekomendasiListEditorGrid.on('afteredit', rekomendasi_update); // inLine Editing Record
	
	/* Identify  card_id Field */
	card_idField= new Ext.form.NumberField({
		id: 'card_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  card_cust Field */
	rekomendasi_custField= new Ext.form.ComboBox({
		//id: 'rekomendasi_custField',
		fieldLabel: 'Customer <span id="help_customer" style="font-size:11px;color:#F00">[?]</span>',
		store: cbo_rekomendasi_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_rekomendasi_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:false,
		anchor: '95%'
	});
	
	rekomendasi_dokterField= new Ext.form.ComboBox({
		//id: 'rekomendasi_dokterField',
		fieldLabel: 'Dokter',
		store: cbo_rekomendasi_dokterDataStore,
		mode: 'remote',
		displayField:'karyawan_username',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: dokter_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:false,
		anchor: '95%'
	});
	rekomendasi_custidField= new Ext.form.NumberField();

	/* Identify  card_keterangan Field */
	rekomendasi_keteranganField= new Ext.form.TextArea({
		id: 'rekomendasi_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	acneField= new Ext.form.Checkbox({
		id: 'acneField',
		boxLabel: 'Acne?',
		maxLength: 250,
		anchor: '95%'
	});
	pigmentationField= new Ext.form.Checkbox({
		id: 'pigmentationField',
		boxLabel: 'Pigmentation?',
		maxLength: 250,
		anchor: '95%'
	});
	wot_foreheadField= new Ext.form.Checkbox({
		id: 'wot_foreheadField',
		boxLabel: 'Wrinkles on the forehead?',
		maxLength: 250,
		anchor: '95%'
	});
	wot_crowsfeetField= new Ext.form.Checkbox({
		id: 'wot_crowsfeetField',
		boxLabel: 'Wrinkles on the crows feet?',
		maxLength: 250,
		anchor: '95%'
	});
	wot_glabellar_frown_linesField= new Ext.form.Checkbox({
		id: 'wot_glabellar_frown_linesField',
		boxLabel: 'Wrinkles on the glabellar frown lines?',
		maxLength: 250,
		anchor: '95%'
	});
	smilelinesField= new Ext.form.Checkbox({
		id: 'smilelinesField',
		boxLabel: 'Smile lines?',
		maxLength: 250,
		anchor: '95%'
	});
	fullerlipsField= new Ext.form.Checkbox({
		id: 'fullerlipsField',
		boxLabel: 'Fuller lips?',
		maxLength: 250,
		anchor: '95%'
	});
	shunkeneyeField= new Ext.form.Checkbox({
		id: 'shunkeneyeField',
		boxLabel: 'Shunken Eye?',
		maxLength: 250,
		anchor: '95%'
	});
	shunkencheekField= new Ext.form.Checkbox({
		id: 'shunkencheekField',
		boxLabel: 'Shunken Cheek?',
		maxLength: 250,
		anchor: '95%'
	});
	saggingcheekField= new Ext.form.Checkbox({
		id: 'saggingcheekField',
		boxLabel: 'Sagging Cheek?',
		maxLength: 250,
		anchor: '95%'
	});
	looseneckField= new Ext.form.Checkbox({
		id: 'looseneckField',
		boxLabel: 'Loose neck?',
		maxLength: 250,
		anchor: '95%'
	});
	necklinesField= new Ext.form.Checkbox({
		id: 'necklinesField',
		boxLabel: 'Neck lines?',
		maxLength: 250,
		anchor: '95%'
	});
	droopyeyesField= new Ext.form.Checkbox({
		id: 'droopyeyesField',
		boxLabel: 'Droopy eyes?',
		maxLength: 250,
		anchor: '95%'
	});
	darkcirclesField= new Ext.form.Checkbox({
		id: 'darkcirclesField',
		boxLabel: 'Dark circles?',
		maxLength: 250,
		anchor: '95%'
	});
	acnescarsField= new Ext.form.Checkbox({
		id: 'acnescarsField',
		boxLabel: 'Acne scars?',
		maxLength: 250,
		anchor: '95%'
	});
	permanenthair_removalField= new Ext.form.Checkbox({
		id: 'permanenthair_removalField',
		boxLabel: 'Permanent hair removal?',
		maxLength: 250,
		anchor: '95%'
	});
	tattooremovalField= new Ext.form.Checkbox({
		id: 'tattooremovalField',
		boxLabel: 'Tattoo removal?',
		maxLength: 250,
		anchor: '95%'
	});
	waistsizeField= new Ext.form.Checkbox({
		id: 'waistsizeField',
		boxLabel: 'Waist size?',
		maxLength: 250,
		anchor: '95%'
	});
	thighsizeField= new Ext.form.Checkbox({
		id: 'thighsizeField',
		boxLabel: 'Thigh size?',
		maxLength: 250,
		anchor: '95%'
	});
	tummysizeField= new Ext.form.Checkbox({
		id: 'tummysizeField',
		boxLabel: 'Tummy size?',
		maxLength: 250,
		anchor: '95%'
	});
	breastsizeField= new Ext.form.Checkbox({
		id: 'breastsizeField',
		boxLabel: 'Breast size?',
		maxLength: 250,
		anchor: '95%'
	});
	legveinsField= new Ext.form.Checkbox({
		id: 'legveinsField',
		boxLabel: 'Leg veins?',
		maxLength: 250,
		anchor: '95%'
	});
	
  	/*Fieldset Master*/
	rekomendasi_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [rekomendasi_custField, rekomendasi_dokterField, rekomendasi_keteranganField, card_idField, acneField, pigmentationField, wot_foreheadField, wot_crowsfeetField, wot_glabellar_frown_linesField, darkcirclesField, waistsizeField, thighsizeField] 
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[smilelinesField, fullerlipsField, shunkeneyeField, shunkencheekField, saggingcheekField, looseneckField, necklinesField, droopyeyesField, acnescarsField, permanenthair_removalField, tattooremovalField, tummysizeField, breastsizeField, legveinsField]
			   }
			]
	});
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var kartu_rekomendasi_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'drawatm_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'drawatm_id', type: 'int', mapping: 'drawatm_id'}, 
			{name: 'drawatm_master', type: 'int', mapping: 'drawatm_master'}, 
			{name: 'drawatm_perawatan', type: 'int', mapping: 'drawatm_perawatan'}, 
			{name: 'drawatm_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'drawatm_tanggal'},
			{name: 'drawatm_keterangan', type: 'string', mapping: 'drawatm_keterangan'},
	]);
	//eof
	
	//function for json writer of detail
	var rekomendasi_medis_detail_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	rekomendasi_medisdetail_DataStore = new Ext.data.Store({
		id: 'rekomendasi_medisdetail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=detail_rekomendasi_detail_list', 
			method: 'POST'
		}),
		reader: kartu_rekomendasi_detail_reader,
		baseParams:{master_id: card_idField.getValue()},
		sortInfo:{field: 'drawatm_id', direction: "ASC"}
	});
	/* End of Function */
	
	var combo_dapp_tgl_medis=new Ext.form.DateField({
		format: 'd-m-Y'
	});
	
	var combo_dapp_tgl_nonmedis=new Ext.form.DateField({
		format: 'd-m-Y'
	});

	var combo_dapp_tgl_produk=new Ext.form.DateField({
		format: 'd-m-Y'
	});
	
	//function for editor of detail
	var editor_rekomendasi_medis_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_rekomendasi_rawatmedis_DataStore = new Ext.data.Store({
		id: 'cbo_rekomendasi_rawatmedis_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_tindakan_medis_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'trawat_rawat_value', type: 'int', mapping: 'rawat_id'},
			{name: 'trawat_rawat_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'trawat_rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'trawat_rawat_group', type: 'string', mapping: 'group_nama'},
			{name: 'trawat_rawat_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'trawat_rawat_du', type: 'float', mapping: 'rawat_du'},
			{name: 'trawat_rawat_dm', type: 'float', mapping: 'rawat_dm'},
			{name: 'trawat_rawat_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'trawat_rawat_display', direction: "ASC"}
	});
	var cbo_rekomendasi_perawatan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{trawat_rawat_kode}| <b>{trawat_rawat_display}</b>',
		'</div></tpl>'
    );

	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{dproduk_produk_kode}| <b>{dproduk_produk_display}</b>',
		'</div></tpl>'
    );

	var combo_rawat_medis=new Ext.form.ComboBox({
			store: rekomendasi_perawatan_medisDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'perawatan_display',
			valueField: 'perawatan_value',
			loadingText: 'Searching...',
			pageSize:10,
			hideTrigger:false,
			tpl: rekomendasi_perawatan_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
	});
	
	//declaration of detail coloumn model
	rekomendasi_medistdetail_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Perawatan Medis' + '</div>',
			dataIndex: 'drawatm_perawatan',
			width: 300,	//270,
			sortable: true,
			editor: combo_rawat_medis,
			renderer: Ext.util.Format.comboRenderer(combo_rawat_medis)
		},
		{
			header: '<div align="center">' + 'Tgl Rekomendasi' + '</div>',
			dataIndex: 'drawatm_tanggal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: combo_dapp_tgl_medis
		},	
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'drawatm_keterangan',
			width: 200,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		}]
	);
	rekomendasi_medistdetail_ColumnModel.defaultSortable= true;
	//eof

	//declaration of detail list editor grid
	rekomendasi_medisdetailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rekomendasi_medisdetailListEditorGrid',
		el: 'fp_kartu_rekomendasi_detail',
		title: 'Detail Rekomendasi Medis',
		height: 200,
		width: 888,
		autoScroll: true,
		store: rekomendasi_medisdetail_DataStore, // DataStore
		colModel: rekomendasi_medistdetail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_rekomendasi_medis_detail],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		/*bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: rekomendasi_medisdetail_DataStore,
			displayInfo: true
		}),*/
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: rekomendasi_medisdetail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled: false,
			handler: rekomendasi_medisdetail_confirm_delete
		}
		]
	});
	//eof
	
	//function of detail add
	function rekomendasi_medisdetail_add(){
		var edit_rekomendasi_medisdetail= new rekomendasi_medisdetailListEditorGrid.store.recordType({
			drawatm_id	:'',		
			drawatm_master	:'',		
			drawatm_perawatan	:'',		
			drawatm_tanggal	: dt.dateFormat('Y-m-d'),
			drawatm_keterangan	: ''
		});
		editor_rekomendasi_medis_detail.stopEditing();
		rekomendasi_medisdetail_DataStore.insert(0, edit_rekomendasi_medisdetail);
		rekomendasi_medisdetailListEditorGrid.getView().refresh();
		rekomendasi_medisdetailListEditorGrid.getSelectionModel().selectRow(0);
		editor_rekomendasi_medis_detail.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_rekomendasi_medisdetail(){
		//rekomendasi_medisdetail_DataStore.commitChanges();
		//rekomendasi_medisdetailListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function rekomendasi_medisdetail_insert(){
		for(i=0;i<rekomendasi_medisdetail_DataStore.getCount();i++){
			rekomendasi_medisdetail_record=rekomendasi_medisdetail_DataStore.getAt(i);
			if(rekomendasi_medisdetail_record.data.dtrawat_perawatan!=""){
				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kartu_rekomendasi&m=detail_rekomendasi_medisdetail_insert',
					params:{
					drawatm_id	: rekomendasi_medisdetail_record.data.drawatm_id, 
					drawatm_master	: eval(card_idField.getValue()), 
					drawatm_perawatan	: rekomendasi_medisdetail_record.data.drawatm_perawatan, 
					drawatm_tanggal	: rekomendasi_medisdetail_record.data.drawatm_tanggal.format('Y-m-d'),
					drawatm_keterangan	: rekomendasi_medisdetail_record.data.drawatm_keterangan
					},
					callback: function(opts, success, response){
						if(success){
							kartu_rekomendasiDataStore.reload();
						}
					}
				});
			}
		}
	}
	//eof
	
	//function for purge detail
	function rekomendasi_medisdetail_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kartu_rekomendasi&m=detail_rekomendasi_medisdetail_purge',
			params:{ master_id: eval(card_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					rekomendasi_medisdetail_insert();
					kartu_rekomendasiDataStore.reload();
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function rekomendasi_medisdetail_confirm_delete(){
		// only one record is selected here
		if(rekomendasi_medisdetailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', rekomendasi_medisdetail_delete);
		} else if(rekomendasi_medisdetailListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', rekomendasi_medisdetail_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function rekomendasi_medisdetail_delete(btn){
		if(btn=='yes'){
			var s = rekomendasi_medisdetailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				rekomendasi_medisdetail_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	rekomendasi_medisdetail_DataStore.on('update', refresh_rekomendasi_medisdetail);
	
	/* START NonMedis Detail */
	/*Detail Declaration */
	// Function for json reader of detail
	var rekomendasi_nonmedis_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'drawatn_id', type: 'int', mapping: 'drawatn_id'}, 
			{name: 'drawatn_master', type: 'int', mapping: 'drawatn_master'}, 
			{name: 'drawatn_perawatan', type: 'int', mapping: 'drawatn_perawatan'}, 
			{name: 'drawatn_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'drawatn_tanggal'},
			{name: 'drawatn_keterangan', type: 'string', mapping: 'drawatn_keterangan'} 
	]);
	//eof
	
	//function for json writer of detail
	var rekomendasi_nonmedis_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	rekomendasi_nonmedisdetail_DataStore = new Ext.data.Store({
		id: 'rekomendasi_nonmedisdetail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=rekomendasi_nonmedis_list', 
			method: 'POST'
		}),
		reader: rekomendasi_nonmedis_reader,
		baseParams:{master_id: card_idField.getValue()},
		sortInfo:{field: 'drawatn_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_rekomendasi_nonmedis= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	

	cbo_rekomendasi_rawat_nonmedisDataStore = new Ext.data.Store({
		id: 'cbo_rekomendasi_rawat_nonmedisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_nonmedis_in_rekomendasi_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'perawatan_value', type: 'int', mapping: 'rawat_id'},
			{name: 'perawatan_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'perawatan_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'perawatan_group', type: 'string', mapping: 'group_nama'},
			{name: 'perawatan_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'perawatan_du', type: 'float', mapping: 'rawat_du'},
			{name: 'perawatan_dm', type: 'float', mapping: 'rawat_dm'},
			{name: 'perawatan_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'perawatan_display', direction: "ASC"}
	});
	var rekomendasi_rawat_nonmedis_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{perawatan_kode}| <b>{perawatan_display}</b>',
		'</div></tpl>'
    );
	
	var combo_rekomendasi_detail_nonmedis=new Ext.form.ComboBox({
			store: cbo_rekomendasi_rawat_nonmedisDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'perawatan_display',
			valueField: 'perawatan_value',
			tpl: rekomendasi_rawat_nonmedis_tpl,
			loadingText: 'Searching...',
			hideTrigger:false,
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small'
	});
	
	//declaration of detail coloumn model
	rekomendasi_nonmedis_detailColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Perawatan Non Medis' + '</div>',
			dataIndex: 'drawatn_perawatan',
			width: 290,
			sortable: true,
			editor: combo_rekomendasi_detail_nonmedis,
			renderer: Ext.util.Format.comboRenderer(combo_rekomendasi_detail_nonmedis)
		},
		{
			header: '<div align="center">' + 'Tgl Rekomendasi' + '</div>',
			dataIndex: 'drawatn_tanggal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: combo_dapp_tgl_nonmedis
		},
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'drawatn_keterangan',
			width: 200,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		}]
	);
	rekomendasi_nonmedis_detailColumnModel.defaultSortable= true;
	//eof
	
	//declaration of detail list editor grid
	rekomendasi_nonmedisListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'rekomendasi_nonmedisListEditorGrid',
		el: 'fp_dkartu_rekomendasi',
		title: 'Detail Rekomendasi Non Medis',
		height: 200,
		width: 888,
		autoScroll: true,
		store: rekomendasi_nonmedisdetail_DataStore, // DataStore
		colModel: rekomendasi_nonmedis_detailColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_rekomendasi_nonmedis],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		/*bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: rekomendasi_nonmedisdetail_DataStore,
			displayInfo: true
		}),*/
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: rekomendasi_nonmedis_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: rekomendasi_nonmedis_confirm_delete
		}
		]
	});
	//eof
	
	//function of detail add
	function rekomendasi_nonmedis_add(){
		var edit_rekomendasi_nonmedis_detail= new rekomendasi_nonmedisListEditorGrid.store.recordType({
			drawatn_perawatan	:'',
			drawatn_keterangan	:'',
			drawatn_id	:'',		
			drawatn_master	:'',				
			drawatn_tanggal	: dt.dateFormat('Y-m-d')
			
		});
		editor_rekomendasi_nonmedis.stopEditing();
		rekomendasi_nonmedisdetail_DataStore.insert(0, edit_rekomendasi_nonmedis_detail);
		rekomendasi_nonmedisListEditorGrid.getView().refresh();
		rekomendasi_nonmedisListEditorGrid.getSelectionModel().selectRow(0);
		editor_rekomendasi_nonmedis.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_rekomendasi_nonmedis(){
		//rekomendasi_nonmedisdetail_DataStore.commitChanges();
		//rekomendasi_nonmedisListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function rekomendasi_nonmedisdetail_insert(){
	for(i=0;i<rekomendasi_nonmedisdetail_DataStore.getCount();i++){
			rekomendasi_nonmedis_detail_record=rekomendasi_nonmedisdetail_DataStore.getAt(i);
			if(rekomendasi_nonmedis_detail_record.data.dtrawat_perawatan!=""){
				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kartu_rekomendasi&m=rekomendasi_nonmedisdetail_insert',
					params:{
					drawatn_id	: rekomendasi_nonmedis_detail_record.data.drawatn_id, 
					drawatn_master	: eval(card_idField.getValue()), 
					drawatn_perawatan	: rekomendasi_nonmedis_detail_record.data.drawatn_perawatan, 
					drawatn_tanggal	: rekomendasi_nonmedis_detail_record.data.drawatn_tanggal.format('Y-m-d'),
					drawatn_keterangan	: rekomendasi_nonmedis_detail_record.data.drawatn_keterangan
					},
					callback: function(opts, success, response){
						if(success){
							kartu_rekomendasiDataStore.reload();
						}
					}
				});
			}
		}	
	}
	//eof
	
	//function for purge detail
	function rekomendasi_nonmedis_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kartu_rekomendasi&m=detail_rekomendasi_nonmedis_detail_purge',
			params:{ master_id: eval(card_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					rekomendasi_nonmedisdetail_DataStore.reload();
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function rekomendasi_nonmedis_confirm_delete(){
		// only one record is selected here
		if(rekomendasi_nonmedisListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', rekomendasi_nonmedis_delete);
		} else if(rekomendasi_nonmedisListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', rekomendasi_nonmedis_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function rekomendasi_nonmedis_delete(btn){
		if(btn=='yes'){
			var s = rekomendasi_nonmedisListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				rekomendasi_nonmedisdetail_DataStore.remove(r);
			}
		}  
	}
	//eof
	//event on update of detail data store
	rekomendasi_nonmedisdetail_DataStore.on('update', refresh_rekomendasi_nonmedis);
	/* END JUAL DETAIL_NON-MEDIS */
	
	//function for json writer of detail
	var produk_detail_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	var detail_rekomendasi_produk_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dproduk_id'
	},[
	/* dataIndex => insert intopeprodukan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'dproduk_id', type: 'int', mapping: 'dproduk_id'}, 
			{name: 'dproduk_master', type: 'int', mapping: 'dproduk_master'}, 
			{name: 'dproduk_produk', type: 'int', mapping: 'dproduk_produk'}, 
			{name: 'dproduk_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'dproduk_tanggal'},
			{name: 'dproduk_keterangan', type: 'string', mapping: 'dproduk_keterangan'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_rekomendasi_produk_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	var editor_detail_produk= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_rekomendasi_produkDataStore = new Ext.data.Store({
		id: 'cbo_rekomendasi_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=get_produk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'dproduk_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'dproduk_produk_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'dproduk_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'dproduk_produk_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'dproduk_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'dproduk_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'dproduk_produk_du', type: 'float', mapping: 'produk_du'},
			{name: 'dproduk_produk_dm', type: 'float', mapping: 'produk_dm'},
			{name: 'dproduk_produk_display', type: 'string', mapping: 'produk_nama'}
		]),
		sortInfo:{field: 'dproduk_produk_display', direction: "ASC"}
	});
	
	/* Function for Retrieve DataStore of detail*/
	rekomendasi_produkdetail_DataStore = new Ext.data.Store({
		id: 'rekomendasi_produkdetail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_rekomendasi&m=detail_produk_list', 
			method: 'POST'
		}),
		reader: detail_rekomendasi_produk_reader,
		baseParams:{master_id: card_idField.getValue()},
		sortInfo:{field: 'dproduk_id', direction: "ASC"}
	});
	
	var combo_rekomendasi_detailproduk=new Ext.form.ComboBox({
			store: cbo_rekomendasi_produkDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'dproduk_produk_display',
			valueField: 'dproduk_produk_value',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:pageS,
			hideTrigger:false,
			tpl: produk_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});

	rekomendasi_detail_produk_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'dproduk_produk',
			width: 300, //250
			sortable: true,
			allowBlank: false,
			editor: combo_rekomendasi_detailproduk,
			renderer: Ext.util.Format.comboRenderer(combo_rekomendasi_detailproduk)
		},
		{
			header: '<div align="center">' + 'Tgl Rekomendasi' + '</div>',
			dataIndex: 'dproduk_tanggal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			editor: combo_dapp_tgl_produk
		},
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'dproduk_keterangan',
			width: 200,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		}]
	);
	rekomendasi_detail_produk_ColumnModel.defaultSortable= true;
	//eof
	
	rekomendasi_detail_produkListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rekomendasi_detail_produkListEditorGrid',
		el: 'fp_detail_produk',
		title: 'Detail Rekomendasi Produk',
		height: 200,
		width: 888,
		autoScroll: true,
		store: rekomendasi_produkdetail_DataStore, // DataStore
		colModel: rekomendasi_detail_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_produk],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		/*bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: rekomendasi_produkdetail_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: rekomendasi_detailproduk_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: rekomendasi_detailproduk_confirm_delete
		}
		]
	});
	//eof
	
	function refresh_detail_produk(){
		//rekomendasi_nonmedisdetail_DataStore.commitChanges();
		//rekomendasi_nonmedisListEditorGrid.getView().refresh();
	}
	
	function rekomendasi_detailproduk_add(){
		var edit_detail_jual_produk= new rekomendasi_detail_produkListEditorGrid.store.recordType({
			dproduk_id	:'',		
			dproduk_master	:'',		
			dproduk_produk	:'',
			dproduk_tanggal	: dt.dateFormat('Y-m-d'),
			dproduk_keterangan	:''	
		});
		editor_detail_produk.stopEditing();
		rekomendasi_produkdetail_DataStore.insert(0, edit_detail_jual_produk);
		rekomendasi_detail_produkListEditorGrid.getView().refresh();
		rekomendasi_detail_produkListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_produk.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_detail_jual_produk(){
		rekomendasi_produkdetail_DataStore.commitChanges();
		rekomendasi_detail_produkListEditorGrid.getView().refresh();
	}
	//eof

	function rekomendasi_produkdetail_insert(){
		if(rekomendasi_produkdetail_DataStore.getCount()!=0){
			for(i=0;i<rekomendasi_produkdetail_DataStore.getCount();i++){
				produk_detail_record=rekomendasi_produkdetail_DataStore.getAt(i);
				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_kartu_rekomendasi&m=rekomendasi_produkdetail_insert',
					params:{
					dproduk_id	: produk_detail_record.data.dproduk_id, 
					dproduk_master	: eval(card_idField.getValue()), 
					dproduk_produk	: produk_detail_record.data.dproduk_produk,
					dproduk_tanggal	: produk_detail_record.data.dproduk_tanggal.format('Y-m-d'),
					dproduk_keterangan	: produk_detail_record.data.dproduk_keterangan
					}
				});
			}
		}/*else if(rekomendasi_produkdetail_DataStore.getCount()==0){
			detail_produk_purge();
		}*/
	}
	
	function detail_produk_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kartu_rekomendasi&m=detail_produk_purge',
			params:{ master_id: eval(card_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					rekomendasi_produkdetail_DataStore.reload();
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function rekomendasi_detailproduk_confirm_delete(){
		// only one record is selected here
		if(rekomendasi_detail_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete this record?', produk_delete);
		} else if(rekomendasi_detail_produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Are you sure to delete these records?', produk_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'You can\'t really delete something you haven\'t selected?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function produk_delete(btn){
		if(btn=='yes'){
			var s = rekomendasi_detail_produkListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				rekomendasi_produkdetail_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	rekomendasi_produkdetail_DataStore.on('update', refresh_detail_produk);
	/* END PRODUK DETAIL*/
	
	var detail_tab_rekomendasi = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [rekomendasi_medisdetailListEditorGrid,rekomendasi_nonmedisListEditorGrid, rekomendasi_detail_produkListEditorGrid]
	});
	
	/* Function for retrieve create Window Panel*/ 
	kartu_rekomendasi_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 930,        
		items: [rekomendasi_masterGroup, detail_tab_rekomendasi]
		,
		buttons: [{
				text: 'Save and Close',
				handler: rekomendasi_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					kartu_rekomendasi_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	kartu_rekomendasi_createWindow= new Ext.Window({
		id: 'kartu_rekomendasi_createWindow',
		title: post2db+'Kartu Rekomendasi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kartu_rekomendasi_create',
		items: kartu_rekomendasi_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function tindakan_medislist_search(){
		// render according to a SQL date format.
		var trawat_id_search=null;
		var card_cust_search=null;
		var trawat_tgl_start_app_search=null;
		var trawat_tgl_end_app_search=null;
		var trawat_rawat_search=null;
		var trawat_dokter_search=null;
		var trawat_status_search=null;

		if(trawat_medis_idSearchField.getValue()!==null){trawat_id_search=trawat_medis_idSearchField.getValue();}
		if(trawat_medis_custSearchField.getValue()!==null){card_cust_search=trawat_medis_custSearchField.getValue();}
		if(Ext.getCmp('trawat_medis_tglStartAppSearchField').getValue()!==null){trawat_tgl_start_app_search=Ext.getCmp('trawat_medis_tglStartAppSearchField').getValue();}
		if(Ext.getCmp('trawat_medis_tglEndAppSearchField').getValue()!==null){trawat_tgl_end_app_search=Ext.getCmp('trawat_medis_tglEndAppSearchField').getValue();}
		if(trawat_medis_rawatSearchField.getValue()!==null){trawat_rawat_search=trawat_medis_rawatSearchField.getValue();}
		if(trawat_medis_dokterSearchField.getValue()!==null){trawat_dokter_search=trawat_medis_dokterSearchField.getValue();}
		if(trawat_medis_statusSearchField.getValue()!==null){trawat_status_search=trawat_medis_statusSearchField.getValue();}
		// change the store parameters
		kartu_rekomendasiDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			trawat_id	:	trawat_id_search, 
			card_cust	:	card_cust_search, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_search,
			trawat_tglapp_end	: 	trawat_tgl_end_app_search,
			trawat_rawat	:	trawat_rawat_search,
			trawat_dokter	:	trawat_dokter_search,
			trawat_status	:	trawat_status_search
		};
		// Cause the datastore to do another query : 
		kartu_rekomendasiDataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function rekomendasi_reset_search(){
		// reset the store parameters
		kartu_rekomendasiDataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		// Cause the datastore to do another query : 
		kartu_rekomendasiDataStore.reload({params: {start: 0, limit: pageS}});
		kartu_rekomendasi_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  trawat_id Search Field */
	trawat_medis_idSearchField= new Ext.form.NumberField({
		id: 'trawat_medis_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  card_cust Search Field */
	trawat_medis_custSearchField= new Ext.form.ComboBox({
		//id: 'rekomendasi_custField',
		fieldLabel: 'Customer',
		store: cbo_rekomendasi_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_rekomendasi_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		anchor: '95%'
	});
	trawat_medis_rawatSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Perawatan',
		store: rekomendasi_perawatan_medisDataStore,
		mode: 'remote',
		displayField:'perawatan_display',
		valueField: 'perawatan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: rekomendasi_perawatan_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		width: 214
	});
	trawat_medis_dokterSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Dokter',
		store: cbo_rekomendasi_dokterDataStore,
		mode: 'remote',
		displayField:'karyawan_username',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: dokter_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		width: 214
	});
	trawat_medis_statusSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Status',
		store: new Ext.data.SimpleStore({
			fields:['dtrawat_status_value', 'dtrawat_status_display'],
			data: [['batal','batal'],['selesai','selesai'],['datang','datang'],['siap','siap']]
			}),
		mode: 'local',
		displayField:'dtrawat_status_display',
		valueField: 'dtrawat_status_value',
        typeAhead: false,
        hideTrigger:false,
        //applyTo: 'search',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		width: 94
	});
	
	/* Identify  card_keterangan Search Field */
	trawat_medis_keteranganSearchField= new Ext.form.TextArea({
		id: 'trawat_medis_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
    
	/* Function for retrieve search Form Panel */
	kartu_rekomendasi_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 640,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [trawat_medis_custSearchField,
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:0.33,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
							    {
									fieldLabel: 'Tanggal Appointment',
							        name: 'trawat_medis_tglStartAppSearchField',
							        id: 'trawat_medis_tglStartAppSearchField',
							        vtype: 'daterange',
							        endDateField: 'trawat_medis_tglEndAppSearchField' // id of the end date field
							    }] 
						},
						{
							columnWidth:0.30,
							layout: 'form',
							labelWidth:20,
							border:false,
							defaultType: 'datefield',
							items: [
						      	{
									fieldLabel: 's/d',
							        name: 'trawat_medis_tglEndAppSearchField',
							        id: 'trawat_medis_tglEndAppSearchField',
							        vtype: 'daterange',
							        startDateField: 'trawat_medis_tglStartAppSearchField' // id of the end date field
							    }] 
						}]},
						trawat_medis_rawatSearchField,trawat_medis_dokterSearchField,trawat_medis_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: tindakan_medislist_search
			},{
				text: 'Close',
				handler: function(){
					kartu_rekomendasi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 

	function tindakan_medis_reset_formSearch(){
		trawat_medis_idSearchField.reset();
		trawat_medis_idSearchField.setValue(null);
		trawat_medis_custSearchField.reset();
		trawat_medis_custSearchField.setValue(null);
		trawat_medis_keteranganSearchField.reset();
		trawat_medis_keteranganSearchField.setValue(null);
		trawat_medis_rawatSearchField.reset();
		trawat_medis_rawatSearchField.setValue(null);
		Ext.getCmp('trawat_medis_tglStartAppSearchField').reset();
		Ext.getCmp('trawat_medis_tglStartAppSearchField').setValue(null);
		Ext.getCmp('trawat_medis_tglEndAppSearchField').reset();
		Ext.getCmp('trawat_medis_tglEndAppSearchField').setValue(null);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	kartu_rekomendasi_searchWindow = new Ext.Window({
		title: 'tindakan Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_kartu_rekomendasi_search',
		items: kartu_rekomendasi_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!kartu_rekomendasi_searchWindow.isVisible()){
			tindakan_medis_reset_formSearch();
			kartu_rekomendasi_searchWindow.show();
		} else {
			kartu_rekomendasi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function rekomendasi_print(){
		var searchquery = "";
		var card_cust_print=null;
		var card_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(kartu_rekomendasiDataStore.baseParams.query!==null){searchquery = kartu_rekomendasiDataStore.baseParams.query;}
		if(kartu_rekomendasiDataStore.baseParams.card_cust!==null){card_cust_print = kartu_rekomendasiDataStore.baseParams.card_cust;}
		if(kartu_rekomendasiDataStore.baseParams.card_keterangan!==null){card_keterangan_print = kartu_rekomendasiDataStore.baseParams.card_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kartu_rekomendasi&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			card_cust : card_cust_print,
			card_keterangan : card_keterangan_print,
		  	currentlisting: kartu_rekomendasiDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./tindakanlist.html','tindakanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				win.print();
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Unable to print the grid!',
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
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function rekomendasi_export_excel(){
		var searchquery = "";
		var card_cust_2excel=null;
		var card_keterangan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(kartu_rekomendasiDataStore.baseParams.query!==null){searchquery = kartu_rekomendasiDataStore.baseParams.query;}
		if(kartu_rekomendasiDataStore.baseParams.card_cust!==null){card_cust_2excel = kartu_rekomendasiDataStore.baseParams.card_cust;}
		if(kartu_rekomendasiDataStore.baseParams.card_keterangan!==null){card_keterangan_2excel = kartu_rekomendasiDataStore.baseParams.card_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kartu_rekomendasi&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			card_cust : card_cust_2excel,
			card_keterangan : card_keterangan_2excel,
		  	currentlisting: kartu_rekomendasiDataStore.baseParams.task // this tells us if we are searching or not
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
					msg: 'Unable to convert excel the grid!',
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
	/*End of Function */
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_kartu_rekomendasi"></div>
         <div id="fp_kartu_rekomendasi_detail"></div>
		 <div id="fp_detail_produk"></div>
		 <div id="fp_dkartu_rekomendasi"></div>
		<div id="elwindow_kartu_rekomendasi_create"></div>
        <div id="elwindow_kartu_rekomendasi_search"></div>
    </div>
</div>
</body>