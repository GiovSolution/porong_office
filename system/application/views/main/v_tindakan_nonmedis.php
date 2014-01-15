<?
/* 	
	Miracle IT Team
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
var tindakan_nonmedis_DataStore;
var tindakan_nonmedis_ColumnModel;
var tindakan_nonmedisListEditorGrid;
var tindakan_nonmedis_createForm;
var tindakan_nonmedis_createWindow;
var tindakan_nonmedis_searchForm;
var tindakan_nonmedis_searchWindow;
var tindakan_nonmedis_SelectedRow;
var tindakan_nonmedisContextMenu;
//for detail data
var tindakan_nonmedis_detail_DataStor;
var tindakan_nonmedis_detailListEditorGrid;
var tindakan_nonmedis_detail_ColumnModel;
var tindakan_nonmedis_detail_proxy;
var tindakan_nonmedis_detail_writer;
var tindakan_nonmedis_detail_reader;
var editor_tindakan_nonmedis_detail;

//declare konstant
var today=new Date().format('d-m-Y');

var tnonmedis_post2db = '';
var msg = '';
var pageS=100;
var bts_group=<?=$_SESSION[SESSION_GROUPID];?>;

/* declare variable here for Field*/
var trawat_nonmedis_idField;
var trawat_nonmedis_custField;
var trawat_nonmedis_keteranganField;
var trawat_nonmedis_idSearchField;
var trawat_nonmedis_custSearchField;
var trawat_nonmedis_terapisSearchField;
var trawat_nonmedis_keteranganSearchField;

var var_perawatan_nonmedis_dstore = true;
var var_terapis_dstore = true;
var var_dtindakan_nonmedis_dstore = true;

var dnonmedis_status_inline_beforeedit = '';

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function tindakan_nonmedis_update(oGrid_event){
		tindakan_nonmedisListEditorGrid.setDisabled(true);
		var trawat_id_update_pk="";
		var dtrawat_id_update=null;
		var dtrawat_perawatan_update=null;
		var dtrawat_perawatan_id_update=null;
		var trawat_cust_id_update=null;
		var dpaket_id_update=null;
		var dtrawat_terapis_update=null;
		var dtrawat_terapis_id_update=null;
		var dtrawat_jam_update=null;
		var dtrawat_keterangan_update=null;
		var dtrawat_ambil_paket_update="";
		var dtrawat_jumlah_update=1;
		
		var dtrawat_status_update=null;
		
		trawat_id_update_pk = oGrid_event.record.data.trawat_id;
		dtrawat_id_update = oGrid_event.record.data.dtrawat_id;
		dtrawat_perawatan_update = oGrid_event.record.data.dtrawat_perawatan;
		dtrawat_perawatan_id_update = oGrid_event.record.data.dtrawat_perawatan_id;
		trawat_cust_id_update = oGrid_event.record.data.trawat_cust_id;
		dpaket_id_update = tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get("dtrawat_dpaket_id");
		dtrawat_terapis_update = oGrid_event.record.data.dtrawat_petugas2;
		dtrawat_terapis_id_update = oGrid_event.record.data.dtrawat_petugas2_id;
		if(oGrid_event.record.data.dtrawat_jam!== null){dtrawat_jam_update = oGrid_event.record.data.dtrawat_jam;}
		if(oGrid_event.record.data.dtrawat_keterangan!== null){dtrawat_keterangan_update = oGrid_event.record.data.dtrawat_keterangan;}
		dtrawat_ambil_paket_update = oGrid_event.record.data.dtrawat_ambil_paket;
		dtrawat_jumlah_update = oGrid_event.record.data.dtrawat_jumlah;
		
		dtrawat_status_update = oGrid_event.record.data.dtrawat_status;
		
		if(this.dnonmedis_status_inline_beforeedit=='selesai' && dtrawat_status_update=='selesai'){
			//Editing ketika status = 'selesai' ==> tidak diperbolehkan
			tindakan_nonmedis_DataStore.reload();
			tindakan_nonmedisListEditorGrid.setDisabled(false);
			Ext.MessageBox.show({
				title: 'Warning',
				width: 330,
				msg: 'Status yang sudah "selesai" tidak boleh di-Edit. Ubah status ke selain "selesai" terlebih dahulu, kemudian lakukan editing.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}else if((this.dnonmedis_status_inline_beforeedit=='selesai' && dtrawat_status_update!=='selesai') || this.dnonmedis_status_inline_beforeedit!=='selesai'){
			//Perubahan status dari 'selesai' menjadi !='selesai' ATAU status sebelumnya di DB !='selesai'
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_tindakan_nonmedis&m=get_action',
				params: {
					task: "UPDATE",
					mode_edit: "update_list",
					trawat_id	: trawat_id_update_pk,
					dtrawat_id	:dtrawat_id_update,
					dtrawat_perawatan	:dtrawat_perawatan_update,
					dtrawat_perawatan_id	:dtrawat_perawatan_id_update,
					dpaket_id		: dpaket_id_update,
					dtrawat_dpaket_id		: nonmedis_combo_list_paket.getValue(),
					trawat_cust_id		: trawat_cust_id_update,
					dtrawat_terapis	: dtrawat_terapis_update,
					dtrawat_terapis_id	: dtrawat_terapis_id_update,
					dtrawat_jam	: dtrawat_jam_update,
					dtrawat_keterangan	:dtrawat_keterangan_update,
					dtrawat_ambil_paket	: dtrawat_ambil_paket_update,
					dtrawat_status	:dtrawat_status_update,
					dtrawat_jumlah	:dtrawat_jumlah_update
				}, 
				success: function(response){							
					var result=eval(response.responseText);
					switch(result){
						case 1:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'INFO',
							   width: 330,
							   msg: 'Update telah sukses dilakukan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.INFO
							});
							break;
						case 0:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'INFO',
							   width: 330,
							   msg: 'Tidak Ada data yang diupdate.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.INFO
							});
							break;
						case -1:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 450,
							   msg: 'Customer dengan perawatan yang dipilih, \"tidak ada\" dalam paket. <br/>Atau Sisa Paket tidak mencukupi untuk diambil.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							break;
						case -2:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 330,
							   msg: 'Data yang dipilih Tidak Ditemukan di Database.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							break;
						case -3:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 330,
							   msg: 'Data yang dipilih Tidak Bisa di-Edit, <br/>karena sudah melalui proses printing Faktur di Kasir.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							break;
							
						case -4:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 330,
							   msg: 'Isi paket tidak cukup untuk diambil.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							break;		
							
						default:
							tindakan_nonmedis_DataStore.reload();
							tindakan_nonmedisListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'We could\'t not save the tindakan.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							break;
					}
				},
				failure: function(response){
					tindakan_nonmedis_DataStore.reload();
					tindakan_nonmedisListEditorGrid.setDisabled(false);
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
		}else{
			tindakan_nonmedis_DataStore.reload();
			tindakan_nonmedisListEditorGrid.setDisabled(false);
			Ext.MessageBox.show({
				title: 'Error',
				msg: 'Belum diketahui kesalahannya.',
				buttons: Ext.MessageBox.OK,
				animEl: 'database',
				icon: Ext.MessageBox.ERROR
			 });	
		}
		
	}
  	/* End of Function */
  
  	/* Function for add data, open window create form */
	function tindakan_nonmedis_create(){
		/*for(i=0;i<tindakan_nonmedis_detail_DataStore.getCount();i++){
			appointment_detail_nonmedis_record=tindakan_nonmedis_detail_DataStore.getAt(i);
			if(!/^\d+$/.test(appointment_detail_nonmedis_record.data.dtrawat_perawatan)){
				//dtnonmedis_rawat='ada';
			}
		}*/
		
		//* penampungan data Detail List Tindakan Non Medis /
		var dtrawat_nonmedis_id=[];
		var dtrawat_nonmedis_perawatan=[];
		var dtrawat_nonmedis_petugas2=[];
		var dtrawat_nonmedis_jam=[];
		var dtrawat_nonmedis_status=[];
		var dtrawat_nonmedis_keterangan=[];
		var nonmedis_jumlah=[];
		
		var dcount = tindakan_nonmedis_detail_DataStore.getCount();
		
		if(dcount>0){
			for(i=0; i<dcount;i++){
				if((/^\d+$/.test(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan))
				   && tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==undefined
				   && tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==''
				   && tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==0){
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_id==undefined){
						dtrawat_nonmedis_id.push('');
					}else{
						dtrawat_nonmedis_id.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_id);
					}
					
					dtrawat_nonmedis_perawatan.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan);
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_petugas2==undefined){
						dtrawat_nonmedis_petugas2.push('');
					}else{
						dtrawat_nonmedis_petugas2.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_petugas2);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_jam==undefined){
						dtrawat_nonmedis_jam.push('');
					}else{
						dtrawat_nonmedis_jam.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_jam);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_status==undefined){
						dtrawat_nonmedis_status.push('');
					}else{
						dtrawat_nonmedis_status.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_status);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_keterangan==undefined){
						dtrawat_nonmedis_keterangan.push('');
					}else{
						dtrawat_nonmedis_keterangan.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_keterangan);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.jumlah==undefined || tindakan_nonmedis_detail_DataStore.getAt(i).data.jumlah==0){
						nonmedis_jumlah.push(1);
					}else{
						nonmedis_jumlah.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.jumlah);
					}
				}
				
				if(i==(dcount-1)){
					trawat_id_create = -1;
					if(tnonmedis_post2db=='UPDATE'){
						trawat_id_create = tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
					}
					
					//tampungan array dari List Detail Tindakan Non Medis
					var encoded_array_dtrawat_nonmedis_id = Ext.encode(dtrawat_nonmedis_id);
					var encoded_array_dtrawat_nonmedis_perawatan = Ext.encode(dtrawat_nonmedis_perawatan);
					var encoded_array_dtrawat_nonmedis_petugas2 = Ext.encode(dtrawat_nonmedis_petugas2);
					var encoded_array_dtrawat_nonmedis_jam = Ext.encode(dtrawat_nonmedis_jam);
					var encoded_array_dtrawat_nonmedis_status = Ext.encode(dtrawat_nonmedis_status);
					var encoded_array_dtrawat_nonmedis_keterangan = Ext.encode(dtrawat_nonmedis_keterangan);
					var encoded_array_nonmedis_jumlah = Ext.encode(nonmedis_jumlah);
					
					if(trawat_id_create>0){
						var trawat_cust_create=null; 
						var trawat_keterangan_create=null;
						
						if(trawat_nonmedis_custField.getValue()!== null){trawat_cust_create = trawat_nonmedis_custField.getValue();} 
						if(trawat_nonmedis_keteranganField.getValue()!== null){trawat_keterangan_create = trawat_nonmedis_keteranganField.getValue();}
						
						Ext.Ajax.request({  
							waitMsg: 'Please wait...',
							url: 'index.php?c=c_tindakan_nonmedis&m=get_action',
							params: {
								task: tnonmedis_post2db,
								mode_edit: 'update_form',
								trawat_id	: trawat_id_create, 
								trawat_cust	: trawat_cust_create, 
								trawat_keterangan	: trawat_keterangan_create,
								
								dtrawat_nonmedis_id	: encoded_array_dtrawat_nonmedis_id,
								dtrawat_nonmedis_perawatan	: encoded_array_dtrawat_nonmedis_perawatan,
								dtrawat_nonmedis_petugas2	: encoded_array_dtrawat_nonmedis_petugas2,
								dtrawat_nonmedis_jam	: encoded_array_dtrawat_nonmedis_jam,
								dtrawat_nonmedis_status	: encoded_array_dtrawat_nonmedis_status,
								dtrawat_nonmedis_keterangan	: encoded_array_dtrawat_nonmedis_keterangan,
								nonmedis_jumlah	: encoded_array_nonmedis_jumlah
							}, 
							success: function(response){
								var result=eval(response.responseText);
								switch(result){
									case 0:
										tindakan_nonmedis_createWindow.hide();
										tindakan_nonmedis_DataStore.reload();
										tindakan_nonmedis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Tidak ada data yang diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									case 1:
										tindakan_nonmedis_createWindow.hide();
										tindakan_nonmedis_DataStore.reload();
										tindakan_nonmedis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Data Master Tindakan sukses diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									case 2:
										tindakan_nonmedis_createWindow.hide();
										tindakan_nonmedis_DataStore.reload();
										tindakan_nonmedis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Data Master Tindakan dan Detail Tindakan Non Medis telah sukses diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									case 3:
										tindakan_nonmedis_createWindow.hide();
										tindakan_nonmedis_DataStore.reload();
										tindakan_nonmedis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Data Master Tindakan, Detail Tindakan Medis, dan Detail Tindakan Non Medis telah sukses diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									default:
										tindakan_nonmedis_createWindow.hide();
										tindakan_nonmedis_DataStore.reload();
										tindakan_nonmedis_createWindow.setDisabled(false);
										//Ext.MessageBox.hide();
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
								//Ext.MessageBox.hide();
								tindakan_nonmedis_createWindow.hide();
								tindakan_nonmedis_DataStore.reload();
								tindakan_nonmedis_createWindow.setDisabled(false);
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
					}else {
						//Ext.MessageBox.hide();
						tindakan_nonmedis_createWindow.hide();
						tindakan_nonmedis_DataStore.reload();
						tindakan_nonmedis_createWindow.setDisabled(false);
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Isian belum sempurna!.',
							buttons: Ext.MessageBox.OK,
							animEl: 'save',
							icon: Ext.MessageBox.WARNING
						});
					}
					
				}
			}
		}
		
	}
 	/* End of Function */
  
	function check_absensi(){
		if(bts_group==31 || bts_group==1){
			tindakan_nonmedisListEditorGrid.button_absensi.enable();
		}else{
			tindakan_nonmedisListEditorGrid.button_absensi.disable();
		}
	}
	
  
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(tnonmedis_post2db=='UPDATE')
			return tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function tindakan_nonmedis_reset_form(){
		trawat_nonmedis_idField.reset();
		trawat_nonmedis_idField.setValue(null);
		trawat_nonmedis_custField.reset();
		trawat_nonmedis_custField.setValue(null);
		trawat_nonmedis_keteranganField.reset();
		trawat_nonmedis_keteranganField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function tindakan_nonmedis_set_form(){
		trawat_nonmedis_idField.setValue(tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_id'));
		trawat_nonmedis_custField.setValue(tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_cust'));
		trawat_nonmedis_custidField.setValue(tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_cust_id'));
		trawat_nonmedis_keteranganField.setValue(tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_keterangan'));
		trawat_nonmedis_dpaket_idField.setValue(tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('dtrawat_dpaket_id'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_tindakan_nonmedis_form_valid(){
		return (trawat_nonmedis_custField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!tindakan_nonmedis_createWindow.isVisible()){
			
			tnonmedis_post2db='CREATE';
			msg='created';
			tindakan_nonmedis_reset_form();
			
			tindakan_nonmedis_createWindow.show();
		} else {
			tindakan_nonmedis_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function tindakan_nonmedis_confirm_delete(){
		// only one tindakan_nonmedis is selected here
		if(tindakan_nonmedisListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', tindakan_nonmedis_delete);
		} else if(tindakan_nonmedisListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', tindakan_nonmedis_delete);
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
	function tindakan_nonmedis_confirm_update(){
		/* only one record is selected here */
		
		if(tindakan_nonmedisListEditorGrid.selModel.getCount() == 1) {
			trawat_nonmedis_perawatanDataStore.load({
				params:{query:tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('trawat_id')},
				callback: function(opts, success, response){
					cbo_dtrawat_petugas_nonmedisDataStore.load({
						callback: function(opts, success, response){
							tindakan_nonmedis_detail_DataStore.load({params : {master_id : eval(get_pk_id()), start:0, limit:pageS}});
						}
					});
				}
			});
			//cbo_dtrawat_perawatan_nonmedisDataStore.load();
			
			tnonmedis_post2db='UPDATE';
			msg='updated';
			tindakan_nonmedis_set_form();
			tindakan_nonmedis_createWindow.show();
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
	function tindakan_nonmedis_delete(btn){
		if(btn=='yes'){
			var selections = tindakan_nonmedisListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< tindakan_nonmedisListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.trawat_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_tindakan_nonmedis&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							tindakan_nonmedis_DataStore.reload();
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
  	
	Ext.util.Format.comboRenderer = function(combo){
		//trawat_nonmedis_perawatanDataStore.load();
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	tindakan_nonmedis_DataStore = new Ext.data.Store({
		id: 'tindakan_nonmedis_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
			{name: 'trawat_id', type: 'int', mapping: 'trawat_id'}, 
			{name: 'trawat_cust_id', type: 'int', mapping: 'trawat_cust'}, 
			{name: 'trawat_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'trawat_cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'trawat_cust_priority_star', type: 'string', mapping: 'cust_priority_star'},
			{name: 'trawat_keterangan', type: 'string', mapping: 'trawat_keterangan'}, 
			{name: 'trawat_creator', type: 'string', mapping: 'trawat_creator'}, 
			{name: 'trawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'trawat_date_create'}, 
			{name: 'trawat_update', type: 'string', mapping: 'trawat_update'}, 
			{name: 'trawat_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'trawat_date_update'}, 
			{name: 'trawat_revised', type: 'int', mapping: 'trawat_revised'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'dtrawat_dapp', type: 'int', mapping: 'dtrawat_dapp'},
			{name: 'dtrawat_perawatan_id', type: 'int', mapping: 'dtrawat_perawatan'},
			{name: 'dtrawat_perawatan', type: 'string', mapping: 'rawat_nama'},
			{name: 'dtrawat_petugas2', type: 'string', mapping: 'terapis_username'},
			{name: 'dtrawat_petugas2_id', type: 'int', mapping: 'terapis_id'},
			{name: 'dtrawat_jam', type: 'string', mapping: 'dtrawat_jam'},
			{name: 'dtrawat_jam_datang', type: 'string', mapping: 'dtrawat_jam_datang'},
			{name: 'dtrawat_tglapp', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_tglapp'},
			{name: 'dtrawat_status', type: 'string', mapping: 'dtrawat_status'},
			{name: 'perawatan_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'perawatan_du', type: 'int', mapping: 'rawat_du'},
			{name: 'perawatan_dm', type: 'int', mapping: 'rawat_dm'},
			{name: 'dtrawat_dpaket_id', type: 'int', mapping: 'dtrawat_dpaket_id'},
			{name: 'paket_nama', type: 'string', mapping: 'paket_nama'},
			{name: 'cust_member', type: 'string', mapping: 'cust_member'},
			{name: 'dtrawat_keterangan', type: 'string', mapping: 'dtrawat_keterangan'},
			{name: 'dtrawat_ambil_paket', type: 'string', mapping: 'dtrawat_ambil_paket'},
			{name: 'cust_punya_paket', type: 'string', mapping: 'cust_punya_paket'},
			{name: 'dapaket_dpaket', type: 'int', mapping: 'dpaket_id'},
			{name: 'dapaket_jpaket', type: 'int', mapping: 'dpaket_master'},
			{name: 'dapaket_paket', type: 'int', mapping: 'dpaket_paket'},
			{name: 'dtrawat_edit', type: 'string', mapping: 'dtrawat_edit'},
			{name: 'dtrawat_jumlah', type: 'int', mapping: 'jumlah'},
			{name: 'dtrawat_jam_siap', type: 'string', mapping: 'dtrawat_jam_siap'},
			{name: 'dtrawat_jam_selesai', type: 'string', mapping: 'dtrawat_jam_selesai'},
			{name: 'est_jam_selesai', type: 'string', mapping: 'est_jam_selesai'}
		])/*,
		sortInfo:{field: 'dtrawat_id', direction: "DESC"}*/
	});
	/* End of Function */
	
	//ComboBox ambil data Customer
	cbo_tnonmedis_cutomerDataStore = new Ext.data.Store({
		id: 'cbo_tnonmedis_cutomerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
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
	var customer_tnonmedis_tpl = new Ext.XTemplate(
       '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            /*'Alamat: {cust_alamat}',*/
        '</div></tpl>'
    );
	
	/*Datastore utk list paket customer */
	nonmedis_listpaket_customerDataStore = new Ext.data.Store({
		id: 'nonmedis_listpaket_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_customer_paket_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'rawat_id'
		},[
			{name: 'perawatan_value', type: 'int', mapping: 'rawat_id'},
			{name: 'perawatan_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'perawatan_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'perawatan_group', type: 'string', mapping: 'group_nama'},
			{name: 'perawatan_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'},
			{name: 'paket_display', type: 'string', mapping: 'paket_nama'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'dpaket_id', type: 'int', mapping: 'dpaket_id'},
			{name: 'dpaket_sisa_paket', type: 'int', mapping: 'dpaket_sisa_paket'},
			{name: 'dpaket_kadaluarsa', type: 'date', dateFormat:'Y-m-d', mapping: 'dpaket_kadaluarsa'}, 
			{name: 'perawatan_du', type: 'float', mapping: 'rawat_du'},
			{name: 'perawatan_dm', type: 'float', mapping: 'rawat_dm'},
			{name: 'perawatan_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'perawatan_display', direction: "ASC"}
	});
	var nonmedis_cust_listpaket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{jpaket_nobukti} | Pemilik : {cust_nama} | <b>{paket_display}</b> | Sisa : {dpaket_sisa_paket} | Kadaluarsa : {dpaket_kadaluarsa:date("j M, Y")}',
		'</div></tpl>'
    );
	
	
	trawat_nonmedis_perawatanDataStore = new Ext.data.Store({
		id: 'trawat_nonmedis_perawatanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_tindakan_nonmedis_list', 
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
	var cbo_trawat_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{perawatan_kode}| <b>{perawatan_display}</b>',
		'</div></tpl>'
    );
	/*var cbo_trawat_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{perawatan_kode}</b>| {perawatan_display}<br/>Group: {perawatan_group}<br/>',
			'Kategori: {perawatan_kategori}</span>',
		'</div></tpl>'
    );*/
	trawat_nonmedis_perawatanDataStore.on('beforeload', function(){
		var_perawatan_nonmedis_dstore = false;
		tindakan_nonmedis_createWindow.setDisabled(true);
	});
	trawat_nonmedis_perawatanDataStore.on('load', function(opts, success, response){
		if(success){
			var_perawatan_nonmedis_dstore = true;
			window_nonmedis_editing_lock();
		}
	});

	dtrawat_karyawanDataStore = new Ext.data.Store({
		id: 'dtrawat_karyawanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_terapis_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'}
		]),
		sortInfo:{field: 'karyawan_display', direction: "ASC"}
	});
    var karyawan_terapis_tpl = new Ext.XTemplate(
            '<tpl for="."><div class="search-item">',
            //    '<span><b>{karyawan_username}</b> | {karyawan_display} | <b>{karyawan_jmltindakan}</b></span>',
                '<span>{karyawan_username}</span>',
            '</div></tpl>'
        );
    
	
	/* combo utk melihat daftar paket yg dimiliki customer*/
	var nonmedis_combo_list_paket=new Ext.form.ComboBox({
			store: nonmedis_listpaket_customerDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'paket_display',
			valueField: 'dpaket_id',
			loadingText: 'Searching...',
			pageSize:10,
			hideTrigger:false,
			tpl: nonmedis_cust_listpaket_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			maskRe: /([^0-9]+)$/
	});
	
	
	
  	/* Function for Identify of Window Column Model */
	tindakan_nonmedis_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">' + 'No Cust' + '</div>',	//'No.Customer',
			readOnly: true,
			dataIndex: 'trawat_cust_no',
			width: 65,	//75,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},
		{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: 'trawat_cust_priority_star',
			width: 10,
			align: 'right',
			sortable: false,
			renderer: function(value, cell, record){
				cell.css = "readonlycell";
				if(record.data.trawat_cust_priority_star == '*'){
					return '<span style="color:red;"><b><font size = 4>' + value + '</span>';
				}				
				return value;
			}
		}, 
		{
			header: '<div align="center">' + 'Customer',
			dataIndex: 'trawat_cust',
			width: 170,	//210,
			sortable: true,
			editable:false,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'dtrawat_perawatan',
			width: 185,	//210,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				store: trawat_nonmedis_perawatanDataStore,
				mode: 'remote',
				displayField: 'perawatan_display',
				valueField: 'perawatan_value',
				tpl : cbo_trawat_rawat_tpl,
				itemSelector: 'div.search-item',
				pageSize:15,
				loadingText: 'Searching...',
				triggerAction: 'all',
				anchor: '95%'
			})
			<?php } ?>
		},
		
		{
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'dtrawat_jumlah',
			width: 30,	//150,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: true,
				blankText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: '<div align="center">' + 'Terapis' + '</div>',
			dataIndex: 'dtrawat_petugas2',
			width: 70,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				store: dtrawat_karyawanDataStore,
				mode: 'remote',
				typeAhead: true,
				displayField: 'karyawan_username',
				valueField: 'karyawan_value',
				tpl: karyawan_terapis_tpl,
				loadingText: 'Searching...',
				itemSelector: 'div.search-item',
				triggerAction: 'all',
				anchor: '95%'
				
			})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'App' + '</div>',
			dataIndex: 'dtrawat_jam',
			width: 50,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Datang' + '</div>',
			dataIndex: 'dtrawat_jam_datang',
			width: 50,
			sortable: true,
			renderer: function(value, cell, record){
				return '<span style="color:red;">' + value.substring(0,5) + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'dtrawat_status',
			width: 60,
			sortable: true,
            renderer: ch_status
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['dtrawat_status_value', 'dtrawat_status_display'],
					data: [['datang','datang'],['tindakan','tindakan'],['selesai','selesai'],['batal','batal']]
					}),
				mode: 'local',
				editable: false,
               	displayField: 'dtrawat_status_display',
               	valueField: 'dtrawat_status_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Tind' + '</div>',
			dataIndex: 'dtrawat_jam_siap',
			align: 'center',
			width: 50,
			sortable: true,
			//hidden: true,
			renderer: function(value, cell, record){
				return '<span style="color:green;">' + value.substring(0,5) + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Est Sls' + '</div>',
			dataIndex: 'est_jam_selesai',
			align: 'center',
			width: 50,
			sortable: true,
			//hidden: true,
			renderer: function(value, cell, record){
				return '<span style="color:blue;">' + value.substring(0,5) + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Sls' + '</div>',
			dataIndex: 'dtrawat_jam_selesai',
			align: 'center',
			width: 50,
			sortable: true,
			//hidden: true,
			renderer: function(value, cell, record){
				return '<span style="color:blue;"><b>' + value.substring(0,5) + '</b></span>';
			}
		},  
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'dtrawat_keterangan',
			width: 185,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		}, 
		{
			header: 'Tgl App',
			dataIndex: 'dtrawat_tglapp',
			width: 80,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			sortable: true,
			hidden: true
		}, 
		{
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
			header: '<div align="center">' + 'Ambil Paket' + '</div>',
			dataIndex: 'paket_nama',
			width: 185,	//210,
			sortable: true,
			editor : nonmedis_combo_list_paket
			<?php } ?>
			
		},
		{
			header: '<div align="center">' + 'Stat Kasir' + '</div>',
			dataIndex: 'dtrawat_edit',
			width: 60,	//55,
			sortable: false
		},
		{
			header: 'Creator',
			dataIndex: 'trawat_creator',
			width: 60,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Create on',
			dataIndex: 'trawat_date_create',
			width: 60,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'trawat_update',
			width: 60,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'trawat_date_update',
			width: 60,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'trawat_revised',
			width: 60,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	tindakan_nonmedis_ColumnModel.defaultSortable= true;
	/* End of Function */
	function ch_status(val){
		if(val=="selesai"){
			return '<span style="color:blue;"><b>' + val + '</b></span>';
		}else if(val=="tindakan"){
			return '<span style="color:green;"><b>' + val + '</b></span>';
		}else if(val=="datang"){
			return '<span style="color:red;"><b>' + val + '</b></span>';
		}else if(val=="batal"){
			return '<span style="color:black;"><b>' + val + '</b></span>';
		}
		return val;
	}
    
	/* Declare DataStore and  show datagrid list */
	tindakan_nonmedisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'tindakan_nonmedisListEditorGrid',
		el: 'fp_tindakan_nonmedis',
		title: 'Daftar Tindakan Non Medis',
		autoHeight: true,
		store: tindakan_nonmedis_DataStore, // DataStore
		cm: tindakan_nonmedis_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1305,	//970,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: tindakan_nonmedis_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: tindakan_nonmedis_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: tindakan_nonmedis_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						tindakan_nonmedis_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama Customer<br>- Nama Perawatan<br>- Nama Dokter<br>- Status'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: tindakan_nonmedis_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: tindakan_nonmedis_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: tindakan_nonmedis_print  
		}, '-',{
			text: 'Absensi',
			tooltip: 'Absensi Therapist',
			iconCls:'',
			ref: '../button_absensi',
			//handler: tindakan_nonmedis_print  
			handler: function(){window.open("../Add-on/absensi/index.php")} 
		}
		]
	});
	tindakan_nonmedisListEditorGrid.render();
	/* End of DataStore */
	/*
	tindakan_nonmedisListEditorGrid.on('rowdblclick', function(){
		//nonmedis_listpaket_customerDataStore.load({params : {trawat_cust_id : trawat_nonmedis_cust_idField.getValue(), dtrawat_rawat_id : trawat_nonmedis_perawatan_idField.getValue()}});
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	

		nonmedis_listpaket_customerDataStore.load({
					params : {
						trawat_cust_id 		: trawat_nonmedis_cust_idField.getValue(),
						dtrawat_rawat_id 	: trawat_nonmedis_perawatan_idField.getValue()
					},
					callback: function(opts, success, response)  {
						  if (success) {
							Ext.MessageBox.hide();
						  }
					  }
				});
	});
	*/

	tindakan_nonmedisListEditorGrid.on('rowclick', function(){
		var non_recordMaster = tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected();
		trawat_nonmedis_cust_idField.setValue(non_recordMaster.get("trawat_cust_id"));
		trawat_nonmedis_perawatan_idField.setValue(non_recordMaster.get("dtrawat_perawatan_id"));
		nonmedis_combo_list_paket.setValue(tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get("dtrawat_dpaket_id"));
		this.dnonmedis_status_inline_beforeedit = tindakan_nonmedisListEditorGrid.getSelectionModel().getSelected().get('dtrawat_status');
	});
	
		
	nonmedis_combo_list_paket.on('beforeshow',function(){
		nonmedis_combo_list_paket.setEditable(true);
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		nonmedis_listpaket_customerDataStore.load({
					params : {
						trawat_cust_id 		: trawat_nonmedis_cust_idField.getValue(),
						dtrawat_rawat_id 	: trawat_nonmedis_perawatan_idField.getValue()
					},
					callback: function(opts, success, response)  {
						  if (success) {
							Ext.MessageBox.hide();
							nonmedis_combo_list_paket.setEditable(false);
						  }
					  }
				});
	});
	
	/* Create Context Menu */
	tindakan_nonmedisContextMenu = new Ext.menu.Menu({
		id: 'tindakan_nonmedis_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: tindakan_nonmedis_editContextMenu 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: tindakan_nonmedis_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: tindakan_nonmedis_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ontindakan_nonmedis_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		tindakan_nonmedisContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		tindakan_nonmedis_SelectedRow=rowIndex;
		tindakan_nonmedisContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function tindakan_nonmedis_editContextMenu(){
		//tindakan_nonmedisListEditorGrid.startEditing(tindakan_nonmedis_SelectedRow,1);
		tindakan_nonmedis_confirm_update();
  	}
	/* End of Function */
  	
	tindakan_nonmedisListEditorGrid.addListener('rowcontextmenu', ontindakan_nonmedis_ListEditGridContextMenu);
	tindakan_nonmedis_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	tindakan_nonmedisListEditorGrid.on('afteredit', tindakan_nonmedis_update); // inLine Editing Record
	check_absensi();
	
	
	trawat_nonmedis_cust_idField= new Ext.form.NumberField();
	trawat_nonmedis_perawatan_idField= new Ext.form.NumberField();
	
	/* Identify  dpaket_id Field */
	trawat_nonmedis_dpaket_idField= new Ext.form.TextField();
	
	
	
	/* Identify  trawat_id Field */
	trawat_nonmedis_idField= new Ext.form.NumberField({
		id: 'trawat_nonmedis_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  trawat_cust Field */
	trawat_nonmedis_custField= new Ext.form.ComboBox({
		//id: 'trawat_nonmedis_custField',
		fieldLabel: 'Customer <span id="help_customer" style="font-size:11px;color:#F00">[?]</span>',
		store: cbo_tnonmedis_cutomerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tnonmedis_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:true,
		anchor: '95%'
	});
	trawat_nonmedis_custidField= new Ext.form.NumberField();
	/* Identify  trawat_appointment Field */
//	trawat_nonmedis_appointmentField= new Ext.form.ComboBox({
//		id: 'trawat_nonmedis_appointmentField',
//		fieldLabel: 'Appointment',
//		store:new Ext.data.SimpleStore({
//			fields:['trawat_appointment_value', 'trawat_appointment_display'],
//			data:[['Medis','Medis'],['Non Medis','Non Medis']]
//		}),
//		mode: 'local',
//		displayField: 'trawat_appointment_display',
//		valueField: 'trawat_appointment_value',
//		anchor: '95%',
//		triggerAction: 'all'	
//	});
	/* Identify  trawat_keterangan Field */
	trawat_nonmedis_keteranganField= new Ext.form.TextArea({
		id: 'trawat_nonmedis_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
  	/*Fieldset Master*/
	tindakan_nonmedis_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [trawat_nonmedis_custField, trawat_nonmedis_keteranganField, trawat_nonmedis_idField] 
			}
			]
	
	});
		
	// Function for json reader of detail
	var tindakan_nonmedis_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'}, 
			{name: 'dtrawat_master', type: 'int', mapping: 'dtrawat_master'}, 
			{name: 'dtrawat_perawatan', type: 'int', mapping: 'dtrawat_perawatan'}, 
			{name: 'dtrawat_petugas1', type: 'int', mapping: 'dtrawat_petugas1'}, 
			{name: 'dtrawat_petugas2', type: 'int', mapping: 'dtrawat_petugas2'}, 
			{name: 'dtrawat_jam', type: 'string', mapping: 'dtrawat_jam'}, 
			{name: 'dtrawat_jam_datang', type: 'string', mapping: 'dtrawat_jam_datang'}, 
			{name: 'dtrawat_kategori', type: 'string', mapping: 'dtrawat_kategori'}, 
			{name: 'dtrawat_status', type: 'string', mapping: 'dtrawat_status'},
			{name: 'dtrawat_keterangan', type: 'string', mapping: 'dtrawat_keterangan'},
			{name: 'dtrawat_ambil_paket', type: 'bool', mapping: 'dtrawat_ambil_paket'},
			{name: 'jumlah', type: 'int', mapping: 'jumlah'}
	]);
	//eof
	
	//function for json writer of detail
	var tindakan_nonmedis_detail_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	tindakan_nonmedis_detail_DataStore = new Ext.data.Store({
		id: 'tindakan_nonmedis_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=detail_tindakan_detail_list', 
			method: 'POST'
		}),
		reader: tindakan_nonmedis_detail_reader,
		baseParams:{master_id: trawat_nonmedis_idField.getValue()},
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	tindakan_nonmedis_detail_DataStore.on('beforeload', function(){
		var_dtindakan_nonmedis_dstore = false;
		tindakan_nonmedis_createWindow.setDisabled(true);
	});
	tindakan_nonmedis_detail_DataStore.on('load', function(opts, success, response){
		if(success){
			var_dtindakan_nonmedis_dstore = true;
			window_nonmedis_editing_lock();
		}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_tindakan_nonmedis_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_dtrawat_perawatan_nonmedisDataStore = new Ext.data.Store({
		id: 'cbo_dtrawat_perawatan_nonmedisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_perawatan_nonmedis_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			//dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column  
			{name: 'dtrawat_perawatan_value', type: 'int', mapping: 'rawat_id'},
			{name: 'dtrawat_perawatan_display', type: 'string', mapping: 'rawat_nama'}
		]),
		sortInfo:{field: 'dtrawat_perawatan_display', direction: "ASC"}
	});
	
	cbo_dtrawat_petugas_nonmedisDataStore = new Ext.data.Store({
		id: 'cbo_dtrawat_petugas_nonmedisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_nonmedis&m=get_terapis_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
			{name: 'dtrawat_karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'dtrawat_karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'dtrawat_karyawan_value', type: 'int', mapping: 'karyawan_id'},
			{name: 'dtrawat_karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'}
		]),
		sortInfo:{field: 'dtrawat_karyawan_display', direction: "ASC"}
	});
	var karyawan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            //'<span><b>{dtrawat_karyawan_username}</b> | {dtrawat_karyawan_display} | <b>{dtrawat_karyawan_jmltindakan}</b></span>',
			'<span>{dtrawat_karyawan_username}</span>',
        '</div></tpl>'
    );
	cbo_dtrawat_petugas_nonmedisDataStore.on('beforeload', function(){
		var_terapis_dstore = false;
		tindakan_nonmedis_createWindow.setDisabled(true);
	});
	cbo_dtrawat_petugas_nonmedisDataStore.on('load', function(opts, success, response){
		if(success){
			var_terapis_dstore = true;
			window_nonmedis_editing_lock();
		}
	});
	
	var combo_dtrawat_perawatan=new Ext.form.ComboBox({
			store: trawat_nonmedis_perawatanDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'perawatan_display',
			valueField: 'perawatan_value',
			loadingText: 'Searching...',
			pageSize:10,
			hideTrigger:false,
			tpl: cbo_trawat_rawat_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			maskRe: /([^0-9]+)$/
	});
	
	var combo_dapp_terapis=new Ext.form.ComboBox({
			store: cbo_dtrawat_petugas_nonmedisDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'dtrawat_karyawan_username',
			valueField: 'dtrawat_karyawan_value',
			tpl: karyawan_tpl,
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all'
	});
	
	var checkColumn = new Ext.grid.CheckColumn({
		header: 'Ambil Paket',
		dataIndex: 'dtrawat_ambil_paket',
		hidden: true,
		width: 75
	});
	
	//declaration of detail coloumn model
	tindakan_nonmedis_detail_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center" style="color:#F00">' + 'Perawatan' + '</div>',
			dataIndex: 'dtrawat_perawatan',
			width: 300,	//290,
			sortable: false,
			editor: combo_dtrawat_perawatan,
			renderer: Ext.util.Format.comboRenderer(combo_dtrawat_perawatan)
		},
		{
			header: '<div align="center">' + 'Jumlah' + '</div>',
			align: 'right',
			dataIndex: 'jumlah',
			width: 60,
			sortable: false,
			editor: new Ext.form.NumberField({
				maxLength: 2,
				allowNegative: false
			})
		},
		{
			header: '<div align="center">' + 'Terapis' + '</div>',
			dataIndex: 'dtrawat_petugas2',
			width: 100,	//200,
			sortable: false,
			editor: combo_dapp_terapis,
			renderer: Ext.util.Format.comboRenderer(combo_dapp_terapis)
		},
		{
			header: '<div align="center">' + 'App' + '</div>',
			dataIndex: 'dtrawat_jam',
			width: 60,	//100,
			sortable: false,
			editor: new Ext.form.TimeField({
				format: 'H:i:s',
				minValue: '7:00',
				maxValue: '21:00',
				increment: 30,
				width: 94
			})
		},
		{
			header: '<div align="center">' + 'Jam Datang' + '</div>',
			dataIndex: 'dtrawat_jam_datang',
			width: 60,	//100,
			sortable: false
			/*editor: new Ext.form.TimeField({
				format: 'H:i:s',
				minValue: '7:00',
				maxValue: '21:00',
				increment: 30,
				width: 94
			})*/
		},
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'dtrawat_status',
			width: 80,	//100,
			sortable: false,
			editable:false,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['dtrawat_status_value', 'dtrawat_status_display'],
					data: [['datang','datang'],['tindakan','tindakan'],['selesai','selesai'],['batal','batal']]
					}),
				mode: 'local',
               	displayField: 'dtrawat_status_display',
               	valueField: 'dtrawat_status_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
		},
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'dtrawat_keterangan',
			width: 240,
			sortable: false,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		}]
	);
	tindakan_nonmedis_detail_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	tindakan_nonmedis_detailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'tindakan_nonmedis_detailListEditorGrid',
		el: 'fp_tindakan_nonmedis_detail',
		title: 'Detail Tindakan Non Medis',
		height: 250,
		width: 920,
		autoScroll: true,
		store: tindakan_nonmedis_detail_DataStore, // DataStore
		colModel: tindakan_nonmedis_detail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_tindakan_nonmedis_detail],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: tindakan_nonmedis_detail_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: tindakan_nonmedis_detail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: tindakan_nonmedis_detail_confirm_delete
		},
		<?php } ?>
		'-',
		'<span style="color:white;">Warning: <b>Pada form ini user tidak diperkenankan mengubah perawatan yang sudah selesai.</b></span>'
		]
	});
	//eof
	
	
	//function of detail add
	function tindakan_nonmedis_detail_add(){
		var edit_tindakan_nonmedis_detail= new tindakan_nonmedis_detailListEditorGrid.store.recordType({
			dtrawat_perawatan	:'',
			jumlah	: 1,
			dtrawat_petugas2	:'',
			dtrawat_jam	:'',
			dtrawat_status	:'datang',
			dtrawat_keterangan	:''
		});
		editor_tindakan_nonmedis_detail.stopEditing();
		tindakan_nonmedis_detail_DataStore.insert(0, edit_tindakan_nonmedis_detail);
		//tindakan_nonmedis_detailListEditorGrid.getView().refresh();
		tindakan_nonmedis_detailListEditorGrid.getSelectionModel().selectRow(0);
		editor_tindakan_nonmedis_detail.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_tindakan_nonmedis_detail(){
		//tindakan_nonmedis_detail_DataStore.commitChanges();
		//tindakan_nonmedis_detailListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function tindakan_nonmedis_detail_insert(){
		var dtrawat_id=[];
		var dtrawat_perawatan=[];
		var dtrawat_petugas2=[];
		var dtrawat_jam=[];
		var dtrawat_status=[];
		var dtrawat_keterangan=[];
		var jumlah=[];
		
		var dcount = tindakan_nonmedis_detail_DataStore.getCount() - 1;
		
		if(tindakan_nonmedis_detail_DataStore.getCount()>0){
			for(i=0; i<tindakan_nonmedis_detail_DataStore.getCount();i++){
				if((/^\d+$/.test(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan))
				   && tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==undefined
				   && tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==''
				   && tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==0){
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_id==undefined){
						dtrawat_id.push('');
					}else{
						dtrawat_id.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_id);
					}
					
					dtrawat_perawatan.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_perawatan);
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_petugas2==undefined){
						dtrawat_petugas2.push('');
					}else{
						dtrawat_petugas2.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_petugas2);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_jam==undefined){
						dtrawat_jam.push('');
					}else{
						dtrawat_jam.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_jam);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_status==undefined){
						dtrawat_status.push('');
					}else{
						dtrawat_status.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_status);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_keterangan==undefined){
						dtrawat_keterangan.push('');
					}else{
						dtrawat_keterangan.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.dtrawat_keterangan);
					}
					
					if(tindakan_nonmedis_detail_DataStore.getAt(i).data.jumlah==undefined || tindakan_nonmedis_detail_DataStore.getAt(i).data.jumlah==0){
						jumlah.push(1);
					}else{
						jumlah.push(tindakan_nonmedis_detail_DataStore.getAt(i).data.jumlah);
					}
				}
				
				if(i==dcount){
					var encoded_array_dtrawat_id = Ext.encode(dtrawat_id);
					var encoded_array_dtrawat_perawatan = Ext.encode(dtrawat_perawatan);
					var encoded_array_dtrawat_petugas2 = Ext.encode(dtrawat_petugas2);
					var encoded_array_dtrawat_jam = Ext.encode(dtrawat_jam);
					var encoded_array_dtrawat_status = Ext.encode(dtrawat_status);
					var encoded_array_dtrawat_keterangan = Ext.encode(dtrawat_keterangan);
					var encoded_array_jumlah = Ext.encode(jumlah);
					
					Ext.Ajax.request({
						waitMsg: 'Please wait...',
						url: 'index.php?c=c_tindakan_nonmedis&m=detail_tindakan_nonmedis_detail_insert',
						params:{
						dtrawat_id	: encoded_array_dtrawat_id,
						dtrawat_master	: eval(trawat_nonmedis_idField.getValue()),
						dtrawat_perawatan	: encoded_array_dtrawat_perawatan,
						dtrawat_petugas2	: encoded_array_dtrawat_petugas2,
						dtrawat_jam	: encoded_array_dtrawat_jam,
						dtrawat_status	: encoded_array_dtrawat_status,
						dtrawat_keterangan	: encoded_array_dtrawat_keterangan,
						dtrawat_cust	: trawat_nonmedis_custidField.getValue(),
						jumlah	: encoded_array_jumlah
						},
						success: function(response){
							var result=eval(response.responseText);
							if(result==1){
								tindakan_nonmedis_DataStore.reload();
								//Ext.MessageBox.hide();
								tindakan_nonmedis_createWindow.hide();
								tindakan_nonmedis_createWindow.setDisabled(false);
							}else{
								tindakan_medisDataStore.reload();
								//Ext.MessageBox.hide();
								tindakan_nonmedis_createWindow.hide();
								tindakan_nonmedis_createWindow.setDisabled(false);
								Ext.MessageBox.show({
									title: 'Error',
									msg: 'Data detail tindakan medis tidak bisa disimpan.',
									buttons: Ext.MessageBox.OK,
									animEl: 'database',
									icon: Ext.MessageBox.ERROR
								});	
							}
						},
						failure: function(response){
							//Ext.MessageBox.hide();
							tindakan_nonmedis_createWindow.hide();
							tindakan_nonmedis_createWindow.setDisabled(false);
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
		}
		
	}
	//eof
	
	//function for purge detail
	function tindakan_nonmedis_detail_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_tindakan_nonmedis&m=detail_tindakan_nonmedis_detail_purge',
			params:{ master_id: eval(trawat_nonmedis_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					tindakan_nonmedis_detail_insert();
					tindakan_nonmedis_DataStore.reload();
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function tindakan_nonmedis_detail_confirm_delete(){
		// only one record is selected here
		if(tindakan_nonmedis_detailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', tindakan_nonmedis_detail_delete);
		} else if(tindakan_nonmedis_detailListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', tindakan_nonmedis_detail_delete);
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
	//eof
	
	//function for Delete of detail
	function tindakan_nonmedis_detail_delete(btn){
		if(btn=='yes'){
			var s = tindakan_nonmedis_detailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				tindakan_nonmedis_detail_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	tindakan_nonmedis_detail_DataStore.on('update', refresh_tindakan_nonmedis_detail);
	
	/* Function for retrieve create Window Panel*/ 
	tindakan_nonmedis_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 930,        
		items: [tindakan_nonmedis_masterGroup,tindakan_nonmedis_detailListEditorGrid]
		,
		buttons: [
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
			{
				id: 'tnonmedis_saveClose',
				text: 'Save and Close',
				ref: '../saveCloseBtn',
				handler: tindakan_nonmedis_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					tindakan_nonmedis_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_NONMEDIS'))){ ?>
	Ext.getCmp('tnonmedis_saveClose').on('click', function(){
		/*Ext.MessageBox.show({
           title: 'Please wait',
           msg: 'Loading items...',
           progressText: 'Initializing...',
           width:300,
		   wait:true,
		   waitConfig: {interval:200},
           closable:false
       });*/
		tindakan_nonmedis_createWindow.setDisabled(true);
	});
	<?php } ?>
	
	/* Function for retrieve create Window Form */
	tindakan_nonmedis_createWindow= new Ext.Window({
		id: 'tindakan_nonmedis_createWindow',
		title: tnonmedis_post2db+'Tindakan Non Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_tindakan_nonmedis_create',
		items: tindakan_nonmedis_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function tindakan_nonmedis_list_search(){
		// render according to a SQL date format.
		var trawat_cust_search=null;
		var trawat_tgl_start_app_search=null;
		var trawat_tgl_end_app_search=null;
		var trawat_rawat_search=null;
		var trawat_terapis_search=null;
		var trawat_status_search=null;

		if(trawat_nonmedis_custSearchField.getValue()!==null){trawat_cust_search=trawat_nonmedis_custSearchField.getValue();}
		if(Ext.getCmp('trawat_nonmedis_tglStartAppSearchField').getValue()!==null){trawat_tgl_start_app_search=Ext.getCmp('trawat_nonmedis_tglStartAppSearchField').getValue();}
		if(Ext.getCmp('trawat_nonmedis_tglEndAppSearchField').getValue()!==null){trawat_tgl_end_app_search=Ext.getCmp('trawat_nonmedis_tglEndAppSearchField').getValue();}
		if(trawat_nonmedis_rawatSearchField.getValue()!==null){trawat_rawat_search=trawat_nonmedis_rawatSearchField.getValue();}
		if(trawat_nonmedis_terapisSearchField.getValue()!==null){trawat_terapis_search=trawat_nonmedis_terapisSearchField.getValue();}
		if(trawat_nonmedis_statusSearchField.getValue()!==null){trawat_status_search=trawat_nonmedis_statusSearchField.getValue();}
		// change the store parameters
		tindakan_nonmedis_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			trawat_cust	:	trawat_cust_search, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_search,
			trawat_tglapp_end	: 	trawat_tgl_end_app_search,
			trawat_rawat	:	trawat_rawat_search,
			trawat_terapis	:	trawat_terapis_search,
			trawat_status	:	trawat_status_search
		};
		// Cause the datastore to do another query : 
		tindakan_nonmedis_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function tindakan_nonmedis_reset_search(){
		// reset the store parameters
		tindakan_nonmedis_DataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		// Cause the datastore to do another query : 
		tindakan_nonmedis_DataStore.reload({params: {start: 0, limit: pageS}});
		//tindakan_nonmedis_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  trawat_id Search Field */
	trawat_nonmedis_idSearchField= new Ext.form.NumberField({
		id: 'trawat_nonmedis_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  trawat_cust Search Field */
	trawat_nonmedis_custSearchField= new Ext.form.ComboBox({
		//id: 'trawat_medis_custField',
		fieldLabel: 'Customer',
		store: cbo_tnonmedis_cutomerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tnonmedis_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		anchor: '95%'
	});
	trawat_nonmedis_rawatSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Perawatan',
		store: trawat_nonmedis_perawatanDataStore,
		mode: 'remote',
		displayField:'perawatan_display',
		valueField: 'perawatan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: cbo_trawat_rawat_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		width: 214
	});
	trawat_nonmedis_terapisSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Terapis',
		store: dtrawat_karyawanDataStore,
		mode: 'remote',
		displayField:'karyawan_username',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: karyawan_terapis_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		width: 214
	});
	trawat_nonmedis_statusSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Status',
		store: new Ext.data.SimpleStore({
			fields:['dtrawat_status_value', 'dtrawat_status_display'],
			data: [['datang','datang'],['tindakan','tindakan'],['selesai','selesai'],['batal','batal']]
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
	/* Identify  trawat_keterangan Search Field */
	trawat_nonmedis_keteranganSearchField= new Ext.form.TextArea({
		id: 'trawat_nonmedis_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
    
	/* Function for retrieve search Form Panel */
	tindakan_nonmedis_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 540,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [trawat_nonmedis_custSearchField,
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:0.40,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
							    {
									fieldLabel: 'Tgl App',
							        name: 'trawat_nonmedis_tglStartAppSearchField',
							        id: 'trawat_nonmedis_tglStartAppSearchField',
							        vtype: 'daterange',
									format: 'd-m-Y',
							        endDateField: 'trawat_nonmedis_tglEndAppSearchField' // id of the end date field
							    }] 
						},
						{
							columnWidth:0.40,
							layout: 'form',
							labelWidth:20,
							border:false,
							defaultType: 'datefield',
							items: [
						      	{
									fieldLabel: 's/d',
							        name: 'trawat_nonmedis_tglEndAppSearchField',
							        id: 'trawat_nonmedis_tglEndAppSearchField',
							        vtype: 'daterange',
							        format: 'd-m-Y',
									value : today,
							        startDateField: 'trawat_nonmedis_tglStartAppSearchField' // id of the end date field
							    }] 
						}]},
						trawat_nonmedis_rawatSearchField,trawat_nonmedis_terapisSearchField,trawat_nonmedis_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: tindakan_nonmedis_list_search
			},{
				text: 'Close',
				handler: function(){
					tindakan_nonmedis_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	function tindakan_nonmedis_reset_formSearch(){
		trawat_nonmedis_idSearchField.reset();
		trawat_nonmedis_idSearchField.setValue(null);
		trawat_nonmedis_custSearchField.reset();
		trawat_nonmedis_custSearchField.setValue(null);
		trawat_nonmedis_terapisSearchField.reset();
		trawat_nonmedis_terapisSearchField.setValue(null);
		trawat_nonmedis_keteranganSearchField.reset();
		trawat_nonmedis_keteranganSearchField.setValue(null);
		Ext.getCmp('trawat_nonmedis_tglStartAppSearchField').reset();
		Ext.getCmp('trawat_nonmedis_tglStartAppSearchField').setValue(null);
		Ext.getCmp('trawat_nonmedis_tglEndAppSearchField').reset();
		Ext.getCmp('trawat_nonmedis_tglEndAppSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	tindakan_nonmedis_searchWindow = new Ext.Window({
		title: 'Pencarian Tindakan Non Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_tindakan_nonmedis_search',
		items: tindakan_nonmedis_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!tindakan_nonmedis_searchWindow.isVisible()){
			tindakan_nonmedis_reset_formSearch();
			tindakan_nonmedis_searchWindow.show();
		} else {
			tindakan_nonmedis_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function tindakan_nonmedis_print(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_tgl_start_app_print=null;
		var trawat_tgl_end_app_print=null;
		var trawat_rawat_print=null;
		var trawat_terapis_print=null;
		var trawat_status_print=null;
		var win;              
		// check if we do have some search data...
		if(tindakan_nonmedis_DataStore.baseParams.query!==null){searchquery = tindakan_nonmedis_DataStore.baseParams.query;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_cust!==null){trawat_cust_print = tindakan_nonmedis_DataStore.baseParams.trawat_cust;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_start!==null){trawat_tgl_start_app_print = tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_start;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_end!==null){trawat_tgl_end_app_print = tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_end;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_rawat!==null){trawat_rawat_print = tindakan_nonmedis_DataStore.baseParams.trawat_rawat;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_terapis!==null){trawat_terapis_print = tindakan_nonmedis_DataStore.baseParams.trawat_terapis;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_status!==null){trawat_status_print = tindakan_nonmedis_DataStore.baseParams.trawat_status;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_tindakan_nonmedis&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust	:	trawat_cust_print, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_print,
			trawat_tglapp_end	: 	trawat_tgl_end_app_print,
			trawat_rawat	:	trawat_rawat_print,
			trawat_terapis	:	trawat_terapis_print,
			trawat_status	:	trawat_status_print,
		  	currentlisting: tindakan_nonmedis_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/tindakan_nonmedislist.html','tindakan_nonmedislist','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	function tindakan_nonmedis_export_excel(){
		var searchquery = "";
		var trawat_cust_2excel=null;
		var trawat_tgl_start_app_2excel=null;
		var trawat_tgl_end_app_2excel=null;
		var trawat_rawat_2excel=null;
		var trawat_terapis_2excel=null;
		var trawat_status_2excel=null;
		var win;              
		// check if we do have some search data...
		if(tindakan_nonmedis_DataStore.baseParams.query!==null){searchquery = tindakan_nonmedis_DataStore.baseParams.query;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_cust!==null){trawat_cust_2excel = tindakan_nonmedis_DataStore.baseParams.trawat_cust;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_start!==null){trawat_tgl_start_app_2excel = tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_start;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_end!==null){trawat_tgl_end_app_2excel = tindakan_nonmedis_DataStore.baseParams.trawat_tglapp_end;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_rawat!==null){trawat_rawat_2excel = tindakan_nonmedis_DataStore.baseParams.trawat_rawat;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_terapis!==null){trawat_terapis_2excel = tindakan_nonmedis_DataStore.baseParams.trawat_terapis;}
		if(tindakan_nonmedis_DataStore.baseParams.trawat_status!==null){trawat_status_2excel = tindakan_nonmedis_DataStore.baseParams.trawat_status;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_tindakan_nonmedis&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust	:	trawat_cust_2excel, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_2excel,
			trawat_tglapp_end	: 	trawat_tgl_end_app_2excel,
			trawat_rawat	:	trawat_rawat_2excel,
			trawat_terapis	:	trawat_terapis_2excel,
			trawat_status	:	trawat_status_2excel,
		  	currentlisting: tindakan_nonmedis_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	/* START Screen Lock Function*/
	function window_nonmedis_editing_lock(){
		if(var_terapis_dstore==true && var_perawatan_nonmedis_dstore==true && var_dtindakan_nonmedis_dstore==true){
			tindakan_nonmedis_createWindow.setDisabled(false);
		}
	}
	
	
	/* END Screen Lock Function */
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_tindakan_nonmedis"></div>
         <div id="fp_tindakan_nonmedis_detail"></div>
		<div id="elwindow_tindakan_nonmedis_create"></div>
        <div id="elwindow_tindakan_nonmedis_search"></div>
    </div>
</div>
</body>