<?php
/* 	
	+ Module  		: Absensi BT Setup
	+ Description	: For record view
	+ Filename 		: v_absensi_bt.php
 	+ creator  		: Isaac
	
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
var absensi_btListEditorGrid;
var absensi_bt_DataStore;
var sr_setup_ColumnModel;
var absensi_bt_saveForm;
var absensi_bt_saveWindow;
var sr_setup_idField;
var absensi_bt_tahunField;
var absensi_bt_bulanField;


//declare konstant
var absensi_bt_post2db = 'CREATE';
var msg = '';
var absensi_bt_pageS=100;

/* declare variable here for Field*/

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
	
	/* Function for Saving inLine Editing */
	function absensi_bt_update(oGrid_event){
		var absensi_bt_update_pk="";
		var absensi_shift_1_update=null;
		var absensi_shift_2_update=null;
		var absensi_shift_3_update=null;
		var absensi_shift_4_update=null;
		var absensi_shift_5_update=null;
		var absensi_shift_6_update=null;
		var absensi_shift_7_update=null;
		var absensi_shift_8_update=null;
		var absensi_shift_9_update=null;
		var absensi_shift_10_update=null;
		var absensi_shift_11_update=null;
		var absensi_shift_12_update=null;
		var absensi_shift_13_update=null;
		var absensi_shift_14_update=null;
		var absensi_shift_15_update=null;
		var absensi_shift_16_update=null;
		var absensi_shift_17_update=null;
		var absensi_shift_18_update=null;
		var absensi_shift_19_update=null;
		var absensi_shift_20_update=null;
		var absensi_shift_21_update=null;
		var absensi_shift_22_update=null;
		var absensi_shift_23_update=null;
		var absensi_shift_24_update=null;
		var absensi_shift_25_update=null;
		var absensi_shift_26_update=null;
		var absensi_shift_27_update=null;
		var absensi_shift_28_update=null;
		var absensi_shift_29_update=null;
		var absensi_shift_30_update=null;
		var absensi_shift_31_update=null;

		
		absensi_bt_update_pk = oGrid_event.record.data.absensi_id;
		if(oGrid_event.record.data.absensi_shift_1!== null){absensi_shift_1_update = oGrid_event.record.data.absensi_shift_1;}
		if(oGrid_event.record.data.absensi_shift_2!== null){absensi_shift_2_update = oGrid_event.record.data.absensi_shift_2;}
		if(oGrid_event.record.data.absensi_shift_3!== null){absensi_shift_3_update = oGrid_event.record.data.absensi_shift_3;}
		if(oGrid_event.record.data.absensi_shift_4!== null){absensi_shift_4_update = oGrid_event.record.data.absensi_shift_4;}
		if(oGrid_event.record.data.absensi_shift_5!== null){absensi_shift_5_update = oGrid_event.record.data.absensi_shift_5;}
		if(oGrid_event.record.data.absensi_shift_6!== null){absensi_shift_6_update = oGrid_event.record.data.absensi_shift_6;}
		if(oGrid_event.record.data.absensi_shift_7!== null){absensi_shift_7_update = oGrid_event.record.data.absensi_shift_7;}
		if(oGrid_event.record.data.absensi_shift_8!== null){absensi_shift_8_update = oGrid_event.record.data.absensi_shift_8;}
		if(oGrid_event.record.data.absensi_shift_9!== null){absensi_shift_9_update = oGrid_event.record.data.absensi_shift_9;}
		if(oGrid_event.record.data.absensi_shift_10!== null){absensi_shift_10_update = oGrid_event.record.data.absensi_shift_10;}
		if(oGrid_event.record.data.absensi_shift_11!== null){absensi_shift_11_update = oGrid_event.record.data.absensi_shift_11;}
		if(oGrid_event.record.data.absensi_shift_12!== null){absensi_shift_12_update = oGrid_event.record.data.absensi_shift_12;}
		if(oGrid_event.record.data.absensi_shift_13!== null){absensi_shift_13_update = oGrid_event.record.data.absensi_shift_13;}
		if(oGrid_event.record.data.absensi_shift_14!== null){absensi_shift_14_update = oGrid_event.record.data.absensi_shift_14;}
		if(oGrid_event.record.data.absensi_shift_15!== null){absensi_shift_15_update = oGrid_event.record.data.absensi_shift_15;}
		if(oGrid_event.record.data.absensi_shift_16!== null){absensi_shift_16_update = oGrid_event.record.data.absensi_shift_16;}
		if(oGrid_event.record.data.absensi_shift_17!== null){absensi_shift_17_update = oGrid_event.record.data.absensi_shift_17;}
		if(oGrid_event.record.data.absensi_shift_18!== null){absensi_shift_18_update = oGrid_event.record.data.absensi_shift_18;}
		if(oGrid_event.record.data.absensi_shift_19!== null){absensi_shift_19_update = oGrid_event.record.data.absensi_shift_19;}
		if(oGrid_event.record.data.absensi_shift_20!== null){absensi_shift_20_update = oGrid_event.record.data.absensi_shift_20;}
		if(oGrid_event.record.data.absensi_shift_21!== null){absensi_shift_21_update = oGrid_event.record.data.absensi_shift_21;}
		if(oGrid_event.record.data.absensi_shift_22!== null){absensi_shift_22_update = oGrid_event.record.data.absensi_shift_22;}
		if(oGrid_event.record.data.absensi_shift_23!== null){absensi_shift_23_update = oGrid_event.record.data.absensi_shift_23;}
		if(oGrid_event.record.data.absensi_shift_24!== null){absensi_shift_24_update = oGrid_event.record.data.absensi_shift_24;}
		if(oGrid_event.record.data.absensi_shift_25!== null){absensi_shift_25_update = oGrid_event.record.data.absensi_shift_25;}
		if(oGrid_event.record.data.absensi_shift_26!== null){absensi_shift_26_update = oGrid_event.record.data.absensi_shift_26;}
		if(oGrid_event.record.data.absensi_shift_27!== null){absensi_shift_27_update = oGrid_event.record.data.absensi_shift_27;}
		if(oGrid_event.record.data.absensi_shift_28!== null){absensi_shift_28_update = oGrid_event.record.data.absensi_shift_28;}
		if(oGrid_event.record.data.absensi_shift_29!== null){absensi_shift_29_update = oGrid_event.record.data.absensi_shift_29;}
		if(oGrid_event.record.data.absensi_shift_30!== null){absensi_shift_30_update = oGrid_event.record.data.absensi_shift_30;}
		if(oGrid_event.record.data.absensi_shift_31!== null){absensi_shift_31_update = oGrid_event.record.data.absensi_shift_31;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_absensi_bt&m=get_action',
			params: {
				task: "UPDATE",
				mode_edit			: "update_list",
				absensi_id	  		: absensi_bt_update_pk,
				absensi_shift_1		: absensi_shift_1_update,
				absensi_shift_2		: absensi_shift_2_update,
				absensi_shift_3		: absensi_shift_3_update,
				absensi_shift_4		: absensi_shift_4_update,
				absensi_shift_5		: absensi_shift_5_update,
				absensi_shift_6		: absensi_shift_6_update,
				absensi_shift_7		: absensi_shift_7_update,
				absensi_shift_8		: absensi_shift_8_update,
				absensi_shift_9		: absensi_shift_9_update,
				absensi_shift_10	: absensi_shift_10_update,
				absensi_shift_11	: absensi_shift_11_update,
				absensi_shift_12	: absensi_shift_12_update,
				absensi_shift_13	: absensi_shift_13_update,
				absensi_shift_14	: absensi_shift_14_update,
				absensi_shift_15	: absensi_shift_15_update,
				absensi_shift_16	: absensi_shift_16_update,
				absensi_shift_17	: absensi_shift_17_update,
				absensi_shift_18	: absensi_shift_18_update,
				absensi_shift_19	: absensi_shift_19_update,
				absensi_shift_20	: absensi_shift_20_update,
				absensi_shift_21	: absensi_shift_21_update,
				absensi_shift_22	: absensi_shift_22_update,
				absensi_shift_23	: absensi_shift_23_update,
				absensi_shift_24	: absensi_shift_24_update,
				absensi_shift_25	: absensi_shift_25_update,
				absensi_shift_26	: absensi_shift_26_update,
				absensi_shift_27	: absensi_shift_27_update,
				absensi_shift_28	: absensi_shift_28_update,
				absensi_shift_29	: absensi_shift_29_update,
				absensi_shift_30	: absensi_shift_30_update,
				absensi_shift_31	: absensi_shift_31_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					default:
						absensi_bt_DataStore.commitChanges();
						absensi_bt_DataStore.reload();
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
	
	function absensi_bt_search(){
		
		Ext.MessageBox.show({
			msg:   'Sedang mencari data, mohon tunggu...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		absensi_bt_DataStore.setBaseParam('query',Ext.getCmp('cbo_tahun').getValue());
		absensi_bt_DataStore.setBaseParam('query',Ext.getCmp('cbo_bulan').getValue());
		absensi_bt_DataStore.load({
			params: {
				task: 'LIST',
				start: 0,
				limit: absensi_bt_pageS,
				query: '',
				tahun: Ext.getCmp('cbo_tahun').getValue(),
				bulan: Ext.getCmp('cbo_bulan').getValue()
			},
			callback: function(r,opt,success){
				if(success==true){
					Ext.MessageBox.hide();
				}
			}
		});	
		
		
	}

  	/* Function for add and edit data form, open window form */
	function absensi_bt_save(){
	
		if(is_absensi_bt_form_valid()){	

			var absensi_bt_bulan_create=null;
			var absensi_bt_tahun_create=null;
			
			//if(sr_setup_idField.getValue()!== null){sr_setup_id_create_pk = sr_setup_idField.getValue();}
			if(absensi_bt_tahunField.getValue()!== null){absensi_bt_tahun_create = absensi_bt_tahunField.getValue();}	
			if(absensi_bt_bulanField.getValue()!== null){absensi_bt_bulan_create = absensi_bt_bulanField.getValue();}			
										
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_absensi_bt&m=get_action',
				params: {
					task: "CREATE",
					//absensi_id	: sr_setup_id_create_pk,
					absensi_bt_bulan : absensi_bt_bulan_create,
					absensi_bt_tahun : absensi_bt_tahun_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(absensi_bt_post2db+' OK','Daftar Absensi berhasil ditambahkan.');
							//absensi_bt_DataStore.reload();
							absensi_bt_saveWindow.hide();
							tahunDataStore.load();
							break;
						default:

							//absensi_bt_DataStore.reload();
							absensi_bt_saveWindow.hide();
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Bulan dan Tahun yang dimasukkan sudah ada, Terapis yang belum ada di Absensi saja yang akan ditambahkan ke Daftar Absensi',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});							
							
							tahunDataStore.load();
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
		if(absensi_bt_post2db=='CREATE')
			return absensi_btListEditorGrid.getSelectionModel().getSelected().get('absensi_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function absensi_bt_reset_form(){
		absensi_bt_tahunField.reset();
		absensi_bt_tahunField.setValue('Pilih Tahun');
		absensi_bt_bulanField.reset();
		absensi_bt_bulanField.setValue('Pilih Bulan');
	}
 	/* End of Function */
	
	/* setValue to EDIT */
	function sr_setup_set_form(){
		sr_setup_idField.setValue(absensi_btListEditorGrid.getSelectionModel().getSelected().get('absensi_id'));
		absensi_bt_tahunField.setValue(absensi_btListEditorGrid.getSelectionModel().getSelected().get('setsr_tahun'));
	}
	/* End setValue to EDIT*/
	
	/* Function for Check if the form is valid */
	function is_absensi_bt_form_valid(){
		return (true && absensi_bt_tahunField.isValid() && true);
	}
  	/* End of Function */
  
	/* Function for Displaying  Search Window Form */
	function display_form_add_window(){
		if(!absensi_bt_saveWindow.isVisible()){
			absensi_bt_reset_form();
			absensi_bt_saveWindow.show();
		} else {
			absensi_bt_saveWindow.toFront();
		}
	}
  	/* End Function */
  
	function sr_setup_confirm_save(){
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan penambahan Daftar Absensi ini?', sr_setup_button);
	}
	
	function sr_setup_button(btn){
		if(btn=='yes'){
			absensi_bt_save();
		}
	}
	
	tahunDataStore = new Ext.data.Store({
		id: 'tahunDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_absensi_bt&m=get_tahun_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 20 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'tahun', type: 'string', mapping: 'tahun'},
		]),
		//sortInfo:{field: 'dokter_display', direction: "ASC"}
	});
	
	var tahun_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
			'<span>{tahun}',
        '</div></tpl>'
    );
	
	var bulan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
			'<span>{display_bulan}',
        '</div></tpl>'
    );

	absensi_bt_DataStore = new Ext.data.Store({
		id: 'absensi_bt_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_absensi_bt&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: absensi_bt_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'absensi_id', type: 'int', mapping: 'absensi_id'},
			{name: 'absensi_karyawan_id', type: 'int', mapping: 'absensi_karyawan_id'},
			{name: 'absensi_karyawan_nama', type: 'string', mapping: 'absensi_karyawan_nama'},
			{name: 'absensi_bulan', type: 'int', mapping: 'absensi_bulan'},
			{name: 'absensi_tahun', type: 'int', mapping: 'absensi_tahun'},
			{name: 'absensi_nama', type: 'string', mapping: 'absensi_nama'},
			{name: 'absensi_shift_1', type: 'string', mapping: 'absensi_shift_1'},
			{name: 'absensi_shift_2', type: 'string', mapping: 'absensi_shift_2'},
			{name: 'absensi_shift_3', type: 'string', mapping: 'absensi_shift_3'},
			{name: 'absensi_shift_4', type: 'string', mapping: 'absensi_shift_4'},
			{name: 'absensi_shift_5', type: 'string', mapping: 'absensi_shift_5'},
			{name: 'absensi_shift_6', type: 'string', mapping: 'absensi_shift_6'},
			{name: 'absensi_shift_7', type: 'string', mapping: 'absensi_shift_7'},
			{name: 'absensi_shift_8', type: 'string', mapping: 'absensi_shift_8'},
			{name: 'absensi_shift_9', type: 'string', mapping: 'absensi_shift_9'},
			{name: 'absensi_shift_10', type: 'string', mapping: 'absensi_shift_10'},
			{name: 'absensi_shift_11', type: 'string', mapping: 'absensi_shift_11'},
			{name: 'absensi_shift_12', type: 'string', mapping: 'absensi_shift_12'},
			{name: 'absensi_shift_13', type: 'string', mapping: 'absensi_shift_13'},
			{name: 'absensi_shift_14', type: 'string', mapping: 'absensi_shift_14'},
			{name: 'absensi_shift_15', type: 'string', mapping: 'absensi_shift_15'},
			{name: 'absensi_shift_16', type: 'string', mapping: 'absensi_shift_16'},
			{name: 'absensi_shift_17', type: 'string', mapping: 'absensi_shift_17'},
			{name: 'absensi_shift_18', type: 'string', mapping: 'absensi_shift_18'},
			{name: 'absensi_shift_19', type: 'string', mapping: 'absensi_shift_19'},
			{name: 'absensi_shift_20', type: 'string', mapping: 'absensi_shift_20'},
			{name: 'absensi_shift_21', type: 'string', mapping: 'absensi_shift_21'},
			{name: 'absensi_shift_22', type: 'string', mapping: 'absensi_shift_22'},
			{name: 'absensi_shift_23', type: 'string', mapping: 'absensi_shift_23'},
			{name: 'absensi_shift_24', type: 'string', mapping: 'absensi_shift_24'},
			{name: 'absensi_shift_25', type: 'string', mapping: 'absensi_shift_25'},
			{name: 'absensi_shift_26', type: 'string', mapping: 'absensi_shift_26'},
			{name: 'absensi_shift_27', type: 'string', mapping: 'absensi_shift_27'},
			{name: 'absensi_shift_28', type: 'string', mapping: 'absensi_shift_28'},
			{name: 'absensi_shift_29', type: 'string', mapping: 'absensi_shift_29'},
			{name: 'absensi_shift_30', type: 'string', mapping: 'absensi_shift_30'},
			{name: 'absensi_shift_31', type: 'string', mapping: 'absensi_shift_31'},
		]),
		sortInfo:{field: 'absensi_id', direction: "ASC"}
	});
	/* End of Function */

	
	sr_setup_ColumnModel = new Ext.grid.ColumnModel(
		[
		/*{
			header: '<div align="center">Tahun</div>',
			dataIndex: 'setsr_tahun',
			width: 40,
			hidden : true,
			sortable: true
			
		}, */
		{
			header: '<div align="center">Nama</div>',
			dataIndex: 'absensi_karyawan_nama',
			width: 100,
			sortable: true
		
		}, 
		{
			header: '<div align="center">Bulan</div>',
			dataIndex: 'absensi_bulan',
			width: 50,
			align: 'right',
			sortable: true,
			readonly: true,
			hidden : true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
			}
		}, 
		
		{
			header: '<div align="center">Tahun</div>',
			dataIndex: 'absensi_tahun',
			width: 50,
			align: 'right',
			sortable: true,
			readOnly: true,
			hidden : true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">1</div>',
			dataIndex: 'absensi_shift_1',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
			}		
		}, 
		{
			header: '<div align="center">2</div>',
			dataIndex: 'absensi_shift_2',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">3</div>',
			dataIndex: 'absensi_shift_3',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">4</div>',
			dataIndex: 'absensi_shift_4',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">5</div>',
			dataIndex: 'absensi_shift_5',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">6</div>',
			dataIndex: 'absensi_shift_6',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">7</div>',
			dataIndex: 'absensi_shift_7',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">8</div>',
			dataIndex: 'absensi_shift_8',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">9</div>',
			dataIndex: 'absensi_shift_9',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">10</div>',
			dataIndex: 'absensi_shift_10',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">11</div>',
			dataIndex: 'absensi_shift_11',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">12</div>',
			dataIndex: 'absensi_shift_12',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">13</div>',
			dataIndex: 'absensi_shift_13',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">14</div>',
			dataIndex: 'absensi_shift_14',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">15</div>',
			dataIndex: 'absensi_shift_15',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">16</div>',
			dataIndex: 'absensi_shift_16',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">17</div>',
			dataIndex: 'absensi_shift_17',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">18</div>',
			dataIndex: 'absensi_shift_18',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">19</div>',
			dataIndex: 'absensi_shift_19',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">20</div>',
			dataIndex: 'absensi_shift_20',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">21</div>',
			dataIndex: 'absensi_shift_21',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">22</div>',
			dataIndex: 'absensi_shift_22',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">23</div>',
			dataIndex: 'absensi_shift_23',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">24</div>',
			dataIndex: 'absensi_shift_24',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">25</div>',
			dataIndex: 'absensi_shift_25',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">26</div>',
			dataIndex: 'absensi_shift_26',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">27</div>',
			dataIndex: 'absensi_shift_27',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">28</div>',
			dataIndex: 'absensi_shift_28',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">29</div>',
			dataIndex: 'absensi_shift_29',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">30</div>',
			dataIndex: 'absensi_shift_30',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}, 
		{
			header: '<div align="center">31</div>',
			dataIndex: 'absensi_shift_31',
			width: 20,
			align: 'right',
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['value', 'display'],
					data: [['P','P'],['S','S'],['M','M'],['OFF','OFF'],['CT','CT']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'display',
               	valueField: 'value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
			}),
			renderer: function(val){
					return '<span>'+ val +'</span>';
				}		
		}
		]
	);
	sr_setup_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	absensi_btListEditorGrid = new Ext.grid.EditorGridPanel({
		id: 'absensi_btListEditorGrid',
		el: 'fp_vu_absensi_bt',
		title: 'Absensi Therapis',
		autoHeight: true,
		store: absensi_bt_DataStore, // DataStore
		cm: sr_setup_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: absensi_bt_pageS,
			store: absensi_bt_DataStore,
			displayInfo: true
		}),
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',
			handler: display_form_add_window 
		},
		'-',
		{
			'text':'Tahun : '
		},{
			xtype: 'combo',
			id: 'cbo_tahun',
			text: 'Pilih Tahun',
			emptyText: 'Pilih Tahun',
			width: 100,
			store: tahunDataStore,
            fieldLabel: 'ComboBox Tahun',
            mode: 'remote',
			tpl: tahun_tpl,
			displayField: 'tahun',
			valueField: 'tahun',
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all'
		},
		'-',
		{
			'text':'Bulan : '
		},{
			xtype: 'combo',
			id: 'cbo_bulan',
			text: 'Pilih Bulan',
			emptyText: 'Pilih Bulan',
			width: 100,
			disabled: false,
			store:new Ext.data.SimpleStore({
				fields:['value_bulan', 'display_bulan'],
				data:[['1','Januari'],['2','Pebruari'],['3','Maret'],['4','April'],['5','Mei'],['6','Juni'],['7','Juli'],['8','Agustus'],['9','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
				}),
            fieldLabel: 'ComboBox Bulan',
            mode: 'local',
			tpl: bulan_tpl,
			displayField: 'display_bulan',
			valueField: 'value_bulan',
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all'
		},
		'-',{
			text: 'Search',
			tooltip: 'Search',
			iconCls:'icon-search',
			handler: absensi_bt_search
		}
		/*{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			iconCls:'icon-refresh',
			disabled : true
		}*/]
	});
	absensi_btListEditorGrid.render();
	/*
	rpt_jproduk_bulanField=new Ext.form.ComboBox({
		id:'rpt_jproduk_bulanField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		value: thismonth,
		width: 100,
		triggerAction: 'all'
	});
	*/
	
	/* Event while selected row via context menu */
	function onsr_setup_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		sr_setup_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		sr_setup_SelectedRow=rowIndex;
		sr_setup_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function sr_setup_editContextMenu(){
      absensi_btListEditorGrid.startEditing(sr_setup_SelectedRow,1);
  	}
	/* End of Function */
  	
	absensi_btListEditorGrid.addListener('rowcontextmenu', onsr_setup_ListEditGridContextMenu);
	//absensi_bt_DataStore.load({params: {start: 0, limit: absensi_bt_pageS}});
	/*
	Ext.getCmp('cbo_tahun').on('select', function(){
		
		Ext.MessageBox.show({
			msg:   'Sedang mencari data, mohon tunggu...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		
		absensi_bt_DataStore.setBaseParam('query',Ext.getCmp('cbo_tahun').getValue());
		absensi_bt_DataStore.setBaseParam('query',Ext.getCmp('cbo_bulan').getValue());
		
		absensi_bt_DataStore.load({
			params: {
				task: 'LIST',
				start: 0,
				limit: absensi_bt_pageS,
				query: '',
				tahun: Ext.getCmp('cbo_tahun').getValue(),
				bulan: Ext.getCmp('cbo_bulan').getValue()
			},
			callback: function(r,opt,success){
				if(success==true){
					Ext.MessageBox.hide();
				}
			}
		});		
		
	});
	*/
	
	// event bulan
	/*
	Ext.getCmp('cbo_bulan').on('select', function(){
		Ext.MessageBox.show({
			msg:   'Sedang mencari data, mohon tunggu...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		absensi_bt_DataStore.setBaseParam('query',Ext.getCmp('cbo_tahun').getValue());
		absensi_bt_DataStore.setBaseParam('query',Ext.getCmp('cbo_bulan').getValue());
		absensi_bt_DataStore.load({
			params: {
				task: 'LIST',
				start: 0,
				limit: absensi_bt_pageS,
				query: '',
				tahun: Ext.getCmp('cbo_tahun').getValue(),
				bulan: Ext.getCmp('cbo_bulan').getValue()
			},
			callback: function(r,opt,success){
				if(success==true){
					Ext.MessageBox.hide();
				}
			}
		});		
	});
	*/
	absensi_btListEditorGrid.on('afteredit', absensi_bt_update); 
	
	/* Identify  absensi_id Field */
	sr_setup_idField= new Ext.form.NumberField({
		id: 'sr_setup_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	absensi_bt_tahunField= new Ext.form.ComboBox({
		id: 'absensi_bt_tahunField',
		fieldLabel: 'Tahun',
		width: 100,
		text: 'Pilih Tahun',
		emptyText: 'Pilih Tahun',
		disabled: false,
		store:new Ext.data.SimpleStore({
			fields:['tahun', 'tahun'],
			data:[['2011','2011'],['2012','2012'],['2013','2013'],['2014','2014'],['2015','2015'],['2016','2016'],['2017','2017'],['2018','2018'],['2019','2019'],['2020','2020'],['2021','2021'],['2022','2022'],['2023','2023'],['2024','2024'],['2025','2025']]
		}),
        mode: 'local',
		tpl: tahun_tpl,
		displayField: 'tahun',
		valueField: 'tahun',
		loadingText: 'Searching...',
		itemSelector: 'div.search-item',
		triggerAction: 'all'
	});
	
	absensi_bt_bulanField= new Ext.form.ComboBox({
		id: 'absensi_bt_bulanField',
		fieldLabel: ' Bulan',
		width: 100,
		text: 'Pilih Bulan',
		emptyText: 'Pilih Bulan',
		disabled: false,
		store:new Ext.data.SimpleStore({
			fields:['value_bulan', 'display_bulan'],
			data:[['1','Januari'],['2','Pebruari'],['3','Maret'],['4','April'],['5','Mei'],['6','Juni'],['7','Juli'],['8','Agustus'],['9','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
        mode: 'local',
		tpl: bulan_tpl,
		displayField: 'display_bulan',
		valueField: 'value_bulan',
		loadingText: 'Searching...',
		itemSelector: 'div.search-item',
		triggerAction: 'all'
	});
		
		
	//sr_setup_infoketeranganField=new Ext.form.Label({ html: '<br><br> *Tahun hanya bisa diinputkan sekali saja'});

	/* Function for retrieve create Window Panel*/ 
	absensi_bt_saveForm = new Ext.FormPanel({
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
				items: [sr_setup_idField, absensi_bt_bulanField, absensi_bt_tahunField] 
			}
			],
		buttons: [{
				text: 'Create',
				handler : sr_setup_confirm_save
			}
			,{
				text: 'Cancel',
				handler: function(){
					absensi_bt_saveWindow.hide();
					//mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	absensi_bt_saveWindow= new Ext.Window({
		id: 'absensi_bt_saveWindow',
		title:'Add Absensi Therapis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_absensi_bt_save',
		items: absensi_bt_saveForm
	});
	/* End Window */
	
	//absensi_bt_saveWindow.show();
	//tahunDataStore.reload();
	
});
	</script>
<body>
<div>
	<div class="col">
		 <div id="fp_vu_absensi_bt"></div>
		<div id="elwindow_absensi_bt_save"></div>
    </div>
</div>
</body>
</html>