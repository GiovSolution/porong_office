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
var tindakan_medisDataStore;
var tindakan_medisColumnModel;
var tindakanListEditorGrid;
var tindakan_medis_createForm;
var tindakan_medis_createWindow;
var tindakan_medis_searchForm;
var tindakan_medis_searchWindow;
var tindakan_medisSelectedRow;
var tindakan_medisContextMenu;
//for detail data
var tindakan_medis_detail_DataStore;
var tindakan_medisdetailListEditorGrid;
var tindakan_medisdetail_ColumnModel;
var tindakan_medis_detail_proxy;
var tindakan_medis_detail_writer;
var tindakan_medis_detail_reader;
var editor_tindakan_medis_detail;

//declare konstant

var today=new Date().format('d-m-Y');

var tmedis_post2db = '';
var msg = '';
var pageS_tmedis=100;

/* declare variable here for Field*/
var trawat_medis_idField;
var trawat_medis_custField;
var trawat_medis_keteranganField;
var trawat_medis_idSearchField;
var trawat_medis_custSearchField;
var trawat_medis_dokterSearchField;
var trawat_medis_keteranganSearchField;

var var_dokter_dstore = true;
var var_perawatan_medis_dstore = true;
var var_perawatan_nonmedis_inmedis_dstore = true;
var var_dtindakan_jnonmedis_dstore = true;
var var_dtindakan_medis_dstore = true;

var dmedis_status_inline_beforeedit = '';
trawat_cust_idField= new Ext.form.NumberField();
trawat_perawatan_idField= new Ext.form.NumberField();

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function tindakan_medis_update(oGrid_event){
	
		tindakanListEditorGrid.setDisabled(true);
		var trawat_id_update_pk="";
		var dtrawat_id_update=null;
		var dtrawat_perawatan_update=null;
		var dtrawat_perawatan_id_update=null;
		var trawat_cust_id_update=null;
		var dtrawat_dokter_update=null;
		var dtrawat_dokter_id_update=null;
		var dtrawat_jam_update=null;
		var dtrawat_keterangan_update=null;
		var dtrawat_dpaket_id_update=null;
		var dpaket_id_update=null;
		var dtrawat_ambil_paket_update="";
		var dtrawat_jumlah_update=null;
		var dtrawat_status_update='';
		
		trawat_id_update_pk = oGrid_event.record.data.trawat_id;
		dtrawat_id_update = oGrid_event.record.data.dtrawat_id;
		dtrawat_perawatan_update = oGrid_event.record.data.dtrawat_perawatan;
		dtrawat_perawatan_id_update = oGrid_event.record.data.dtrawat_perawatan_id;
		dtrawat_dpaket_id_update = oGrid_event.record.data.paket_nama;
		//dpaket_id_update = oGrid_event.record.data.dtrawat_dpaket_id;
		dpaket_id_update = tindakanListEditorGrid.getSelectionModel().getSelected().get("dtrawat_dpaket_id");
		trawat_cust_id_update = oGrid_event.record.data.trawat_cust_id;
		dtrawat_dokter_update = oGrid_event.record.data.dtrawat_petugas1;
		dtrawat_dokter_id_update = oGrid_event.record.data.dtrawat_petugas1_id;
		if(oGrid_event.record.data.dtrawat_jam!== null){dtrawat_jam_update = oGrid_event.record.data.dtrawat_jam;}
		if(oGrid_event.record.data.dtrawat_keterangan!== null){dtrawat_keterangan_update = oGrid_event.record.data.dtrawat_keterangan;}
		//if(trawat_dpaket_idField.getValue()!== null){trawat_info_nobukti_update = trawat_dpaket_idField.getValue();} 
		dtrawat_ambil_paket_update = oGrid_event.record.data.dtrawat_ambil_paket;
		dtrawat_jumlah_update = oGrid_event.record.data.dtrawat_jumlah;
		
		dtrawat_status_update = oGrid_event.record.data.dtrawat_status;
		if(dmedis_status_inline_beforeedit=='selesai' && dtrawat_status_update=='selesai'){
			//Editing ketika status = 'selesai' ==> tidak diperbolehkan
			tindakan_medisDataStore.reload();
			tindakanListEditorGrid.setDisabled(false);
			Ext.MessageBox.show({
				title: 'Warning',
				width: 330,
				msg: 'Status yang sudah "selesai" tidak boleh di-Edit. Ubah status ke selain "selesai" terlebih dahulu, kemudian lakukan editing.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}else if((dmedis_status_inline_beforeedit=='selesai' && dtrawat_status_update!=='selesai') || dmedis_status_inline_beforeedit!=='selesai'){
			//Perubahan status dari 'selesai' menjadi !='selesai' ATAU status sebelumnya di DB !='selesai'
			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_tindakan_medis&m=get_action',
				params: {
					task: "UPDATE",
					mode_edit: "update_list",
					trawat_id	: trawat_id_update_pk,
					dtrawat_id	:dtrawat_id_update,
					dtrawat_perawatan	:dtrawat_perawatan_update,
					dtrawat_perawatan_id	:dtrawat_perawatan_id_update,
					trawat_cust_id		: trawat_cust_id_update,
					/* dtrawat_dpaket_id ini digunakan hanya utk mengganti Ambil Paket*/
					dtrawat_dpaket_id		: combo_list_paket.getValue(),
					dpaket_id		: dpaket_id_update,
					dtrawat_dokter : dtrawat_dokter_update,
					dtrawat_dokter_id : dtrawat_dokter_id_update,
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
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
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
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
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
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
							Ext.MessageBox.show({
							   title: 'Warning',
							   width: 330,
							   msg: 'Customer dengan perawatan yang dipilih, <br/>\"tidak ada\" dalam paket.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
							break;
						case -2:
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
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
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
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
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
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
							tindakan_medisDataStore.reload();
							tindakanListEditorGrid.setDisabled(false);
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
					tindakan_medisDataStore.reload();
					tindakanListEditorGrid.setDisabled(false);
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
			tindakan_medisDataStore.reload();
			tindakanListEditorGrid.setDisabled(false);
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
	function tindakan_medis_create(){
		//* penampungan data Detail List Tindakan Medis /
		var dtrawat_medis_id=[];
		var dtrawat_medis_perawatan=[];
		var dtrawat_medis_jumlah=[];
		var dtrawat_medis_petugas1=[];
		var dtrawat_medis_jamreservasi=[];
		var dtrawat_medis_status=[];
		var dtrawat_medis_keterangan=[];
		
		//* penampungan data Detail List Tindakan Non Medis /
		var dtrawat_nonmedis_id = [];
		var dtrawat_nonmedis_perawatan = [];
		var dtrawat_nonmedis_suster = [];
		var dtrawat_nonmedis_keterangan = [];
		var dtrawat_nonmedis_jumlah = [];
		var dtrawat_nonmedis_status = [];
		
		var dcount = 0;
		//var dcount_medis = tindakan_medis_detail_DataStore.getCount() - 1;
		var dcount_medis = tindakan_medis_detail_DataStore.getCount();
		var dcount_nonmedis = dtindakan_jual_nonmedisDataStore.getCount();
		
		if(dcount_medis>dcount_nonmedis){
			dcount = dcount_medis;
		}else if(dcount_medis<dcount_nonmedis){
			dcount = dcount_nonmedis;
		}else{
			dcount = dcount_medis;
		}
		
		if(dcount>0){
			for(i=0; i<dcount;i++){
				//Detail List Tindakan Medis
				if(i<dcount_medis){
					if((/^\d+$/.test(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan))
					   && tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==undefined
					   && tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==''
					   && tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==0){
						
						if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_id==undefined){
							dtrawat_medis_id.push('');
						}else{
							dtrawat_medis_id.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_id);
						}
						
						dtrawat_medis_perawatan.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan);
						
						if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_petugas1==undefined){
							dtrawat_medis_petugas1.push('');
						}else{
							dtrawat_medis_petugas1.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_petugas1);
						}
						
						if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jam==undefined){
							dtrawat_medis_jamreservasi.push('');
						}else{
							dtrawat_medis_jamreservasi.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jam);
						}
						
						if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_status==undefined){
							dtrawat_medis_status.push('');
						}else{
							dtrawat_medis_status.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_status);
						}
						
						if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jumlah==undefined || tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jumlah==0){
							dtrawat_medis_jumlah.push(1);
						}else{
							dtrawat_medis_jumlah.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jumlah);
						}
						
						if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_keterangan==undefined){
							dtrawat_medis_keterangan.push('');
						}else{
							dtrawat_medis_keterangan.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_keterangan);
						}
					}
				}
				
				//Detail List Tindakan Non Medis
				if(i<dcount_nonmedis){
					if((/^\d+$/.test(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan))
					   && dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan!==undefined
					   && dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan!==''
					   && dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan!==0){
						
						if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_id==undefined){
							dtrawat_nonmedis_id.push('');
						}else{
							dtrawat_nonmedis_id.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_id);
						}
						
						dtrawat_nonmedis_perawatan.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan);
						dtrawat_nonmedis_suster.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_petugas1);
						
						if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_keterangan==undefined){
							dtrawat_nonmedis_keterangan.push('');
						}else{
							dtrawat_nonmedis_keterangan.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_keterangan);
						}
						
						if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_jumlah==undefined || dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_jumlah==0){
							dtrawat_nonmedis_jumlah.push(1);
						}else{
							dtrawat_nonmedis_jumlah.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_jumlah);
						}
						
						if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_status==undefined){
							dtrawat_nonmedis_status.push('tindakan');
						}else{
							dtrawat_nonmedis_status.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_status);
						}
					}
				}
				
				//jika penampungan data-data di List Detail sudah selesai, maka mulai proses input ke Database
				if(i==(dcount-1)){
					var trawat_id_create = -1;
					if(tmedis_post2db=='UPDATE'){
						trawat_id_create = tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
					}
					
					//tampungan array dari List Detail Tindakan Medis
					var encoded_array_dtrawat_medis_id = Ext.encode(dtrawat_medis_id);
					var encoded_array_dtrawat_medis_perawatan = Ext.encode(dtrawat_medis_perawatan);
					var encoded_array_dtrawat_medis_jumlah = Ext.encode(dtrawat_medis_jumlah);
					var encoded_array_dtrawat_medis_petugas1 = Ext.encode(dtrawat_medis_petugas1);
					var encoded_array_dtrawat_medis_jamreservasi = Ext.encode(dtrawat_medis_jamreservasi);
					var encoded_array_dtrawat_medis_status = Ext.encode(dtrawat_medis_status);
					var encoded_array_dtrawat_medis_keterangan = Ext.encode(dtrawat_medis_keterangan);
					
					//tampungan array dari List Detail Tindakan Non Medis
					var encoded_array_dtrawat_nonmedis_id = Ext.encode(dtrawat_nonmedis_id);
					var encoded_array_dtrawat_nonmedis_perawatan = Ext.encode(dtrawat_nonmedis_perawatan);
					var encoded_array_dtrawat_nonmedis_suster = Ext.encode(dtrawat_nonmedis_suster);
					var encoded_array_dtrawat_nonmedis_keterangan = Ext.encode(dtrawat_nonmedis_keterangan);
					var encoded_array_dtrawat_nonmedis_jumlah = Ext.encode(dtrawat_nonmedis_jumlah);
					var encoded_array_dtrawat_nonmedis_status = Ext.encode(dtrawat_nonmedis_status);
					
					if(trawat_id_create>0){
						var trawat_cust_create=null; 
						var trawat_keterangan_create=null;
						
						//if(trawat_medis_custField.getValue()!== null){trawat_cust_create = trawat_medis_custField.getValue();}
						trawat_cust_create = trawat_medis_custidField.getValue();
						if(trawat_medis_keteranganField.getValue()!== null){trawat_keterangan_create = trawat_medis_keteranganField.getValue();}
						
						Ext.Ajax.request({
							waitMsg: 'Please wait...',
							url: 'index.php?c=c_tindakan_medis&m=get_action',
							params: {
								task: tmedis_post2db,
								mode_edit					: 'update_form',
								trawat_id					: trawat_id_create, 
								trawat_cust					: trawat_cust_create, 
								trawat_keterangan			: trawat_keterangan_create,
								
								dtrawat_medis_id			: encoded_array_dtrawat_medis_id,
								dtrawat_medis_perawatan		: encoded_array_dtrawat_medis_perawatan,
								dtrawat_medis_jumlah		: encoded_array_dtrawat_medis_jumlah,
								dtrawat_medis_petugas1		: encoded_array_dtrawat_medis_petugas1,
								dtrawat_medis_jamreservasi	: encoded_array_dtrawat_medis_jamreservasi,
								dtrawat_medis_status		: encoded_array_dtrawat_medis_status,
								dtrawat_medis_keterangan	: encoded_array_dtrawat_medis_keterangan,
								
								dtrawat_nonmedis_id			: encoded_array_dtrawat_nonmedis_id,
								dtrawat_nonmedis_perawatan	: encoded_array_dtrawat_nonmedis_perawatan,
								dtrawat_nonmedis_suster		: encoded_array_dtrawat_nonmedis_suster,
								dtrawat_nonmedis_keterangan	: encoded_array_dtrawat_nonmedis_keterangan,
								dtrawat_nonmedis_jumlah		: encoded_array_dtrawat_nonmedis_jumlah,
								dtrawat_nonmedis_status		: encoded_array_dtrawat_nonmedis_status
							}, 
							success: function(response){
								var result=eval(response.responseText);
								switch(result){
									case 0:
										tindakan_medis_createWindow.hide();
										tindakan_medisDataStore.reload();
										tindakan_medis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Tidak ada data yang diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									case 1:
										//tindakan_medisdetail_insert();
										//tindakan_medis_createWindow.hide();
										tindakan_medis_createWindow.hide();
										tindakan_medisDataStore.reload();
										tindakan_medis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Data Master Tindakan sukses diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									case 2:
										tindakan_medis_createWindow.hide();
										tindakan_medisDataStore.reload();
										tindakan_medis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Data Master Tindakan dan Detail Tindakan Medis telah sukses diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									case 3:
										tindakan_medis_createWindow.hide();
										tindakan_medisDataStore.reload();
										tindakan_medis_createWindow.setDisabled(false);
										Ext.MessageBox.show({
										   title: 'INFO',
										   msg: 'Data Master Tindakan, Detail Tindakan Medis, dan Detail Tindakan Non Medis telah sukses diupdate.',
										   buttons: Ext.MessageBox.OK,
										   animEl: 'save',
										   icon: Ext.MessageBox.INFO
										});
										break;
									default:
										tindakan_medis_createWindow.hide();
										tindakan_medisDataStore.reload();
										tindakan_medis_createWindow.setDisabled(false);
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
								tindakan_medis_createWindow.hide();
								tindakan_medisDataStore.reload();
								tindakan_medis_createWindow.setDisabled(false);
								//Ext.MessageBox.hide();
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
						tindakan_medis_createWindow.hide();
						tindakan_medisDataStore.reload();
						tindakan_medis_createWindow.setDisabled(false);
						//Ext.MessageBox.hide();
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
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(tmedis_post2db=='UPDATE')
			return tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function tindakan_medisreset_form(){
		trawat_medis_idField.reset();
		trawat_medis_idField.setValue(null);
		trawat_medis_custField.reset();
		trawat_medis_custField.setValue(null);
		trawat_medis_custidField.reset();
		trawat_medis_custidField.setValue(null);
		trawat_medis_keteranganField.reset();
		trawat_medis_keteranganField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function tindakan_medis_set_form(){
		trawat_medis_idField.setValue(tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_id'));
		trawat_medis_custField.setValue(tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_cust'));
		trawat_medis_custidField.setValue(tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_cust_id'));
		trawat_medis_keteranganField.setValue(tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_keterangan'));
		trawat_dpaket_idField.setValue(tindakanListEditorGrid.getSelectionModel().getSelected().get('dtrawat_dpaket_id'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_tindakan_medisform_valid(){
		return (true &&  trawat_medis_custField.isValid() && true &&  true &&  true &&  true &&  true &&  true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!tindakan_medis_createWindow.isVisible()){
			tindakan_medis_detail_DataStore.load({
				params: {master_id:0, start:0, limit:pageS_tmedis}
			});
			tindakan_medisreset_form();
			tmedis_post2db='CREATE';
			msg='created';
			tindakan_medis_createWindow.show();
		} else {
			tindakan_medis_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function tindakan_medisconfirm_delete(){
		// only one tindakan is selected here
		if(tindakanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', tindakan_medisdelete);
		} else if(tindakanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', tindakan_medisdelete);
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
	function tindakan_medisconfirm_update(){
		/* only one record is selected here */
		cbo_dtindakan_terapisDataStore.load();
		cbo_dtindakan_dokterDataStore.load();
		if(tindakanListEditorGrid.selModel.getCount() == 1) {
			var get_trawat_id=tindakanListEditorGrid.getSelectionModel().getSelected().get('trawat_id');
			trawat_medis_perawatanDataStore.load({
				params:{query:get_trawat_id},
				callback: function(opts, success, response){
					if(success){
						tindakan_medis_detail_DataStore.load({params : {master_id : eval(get_pk_id()), start:0, limit:pageS_tmedis}});
					}
				}
			});
			cbo_perawatan_dtjnonmedisDataStore.load({
				params:{query:get_trawat_id},
				callback: function(opts, success, response){
					if(success){
						dtindakan_jual_nonmedisDataStore.load({params : {master_id : eval(get_pk_id()), start:0, limit:pageS_tmedis}});
					}
				}
			});
			tindakan_medis_set_form();
			tmedis_post2db='UPDATE';
			msg='updated';
			tindakan_medis_createWindow.show();
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
	function tindakan_medisdelete(btn){
		if(btn=='yes'){
			var selections = tindakanListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< tindakanListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.trawat_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_tindakan_medis&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							tindakan_medisDataStore.reload();
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
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	tindakan_medisDataStore = new Ext.data.Store({
		id: 'tindakan_medisDataStore',
		timeout: 3600,
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS_tmedis}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intotindakan_medisColumnModel, Mapping => for initiate table column */ 
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
			{name: 'jpaket_nobukti', type: 'string', mapping: 'jpaket_nobukti'},
			{name: 'dtrawat_petugas1', type: 'string', mapping: 'dokter_username'},
			{name: 'dtrawat_petugas1_id', type: 'int', mapping: 'dokter_id'},
			{name: 'dtrawat_jam', type: 'string', mapping: 'dtrawat_jam'},
			{name: 'dtrawat_jam_datang', type: 'string', mapping: 'dtrawat_jam_datang'},
			{name: 'dtrawat_jam_siap', type: 'string', mapping: 'dtrawat_jam_siap'},
			{name: 'dtrawat_jam_selesai', type: 'string', mapping: 'dtrawat_jam_selesai'},
			{name: 'est_jam_selesai', type: 'string', mapping: 'est_jam_selesai'},
			{name: 'dtrawat_tglapp', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_tglapp'},
			{name: 'dtrawat_status', type: 'string', mapping: 'dtrawat_status'},
			{name: 'perawatan_harga', type: 'float', mapping: 'rawat_harga'},
			{name: 'perawatan_du', type: 'int', mapping: 'rawat_du'},
			{name: 'perawatan_dm', type: 'int', mapping: 'rawat_dm'},
			{name: 'cust_member', type: 'string', mapping: 'cust_member'},
			{name: 'dtrawat_keterangan', type: 'string', mapping: 'dtrawat_keterangan'},
			{name: 'dtrawat_ambil_paket', type: 'string', mapping: 'dtrawat_ambil_paket'},
			{name: 'dtrawat_dpaket_id', type: 'int', mapping: 'dtrawat_dpaket_id'},
			{name: 'paket_nama', type: 'string', mapping: 'paket_nama'},
			{name: 'dtrawat_edit', type: 'string', mapping: 'dtrawat_edit'},
			{name: 'dtrawat_jumlah', type: 'int', mapping: 'dtrawat_jumlah'}
		])/*,
		sortInfo:{field: 'dtrawat_id', direction: "DESC"}*/
	});
	/* End of Function */
	
	//ComboBox ambil data Customer
	cbo_tmedis_cutomerDataStore = new Ext.data.Store({
		id: 'cbo_tmedis_cutomerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_customer_list', 
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
	var customer_tmedis_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            /*'Alamat: {cust_alamat}',*/
        '</div></tpl>'
    );
	
	trawat_medis_perawatanDataStore = new Ext.data.Store({
		id: 'trawat_medis_perawatanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_tindakan_medis_list', 
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
	var trawat_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{perawatan_kode}| <b>{perawatan_display}</b>',
		'</div></tpl>'
    );
	trawat_medis_perawatanDataStore.on('beforeload', function(){
		var_perawatan_medis_dstore = false;
		tindakan_medis_createWindow.setDisabled(true);
	});
	trawat_medis_perawatanDataStore.on('load', function(opts, success, response){
		if(success){
			var_perawatan_medis_dstore = true;
			window_medis_editing_lock();
		}
	});

	/*Datastore utk list paket customer */
	medis_listpaket_customerDataStore = new Ext.data.Store({
		id: 'medis_listpaket_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_customer_paket_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15, trawat_cust_id : trawat_cust_idField.getValue(), dtrawat_rawat_id : trawat_perawatan_idField.getValue()},
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
	var customer_listpaket_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{jpaket_nobukti} | Pemilik : {cust_nama} | <b>{paket_display}</b> | Sisa : {dpaket_sisa_paket} | Kadaluarsa : {dpaket_kadaluarsa:date("j M, Y")}',
		'</div></tpl>'
    );
	
	
	cbo_dtindakan_dokterDataStore = new Ext.data.Store({
		id: 'cbo_dtindakan_dokterDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_dokter_list', 
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
	cbo_dtindakan_dokterDataStore.on('beforeload', function(){
		var_dokter_dstore = false;
		tindakan_medis_createWindow.setDisabled(true);
	});
	cbo_dtindakan_dokterDataStore.on('load', function(opts, success, response){
		if(success){
			var_dokter_dstore = true;
			window_medis_editing_lock();
		}
	});
	
	/* combo utk melihat daftar paket yg dimiliki customer*/
	var combo_list_paket=new Ext.form.ComboBox({
			store: medis_listpaket_customerDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'paket_display',
			valueField: 'dpaket_id',
			loadingText: 'Searching...',
			pageSize:10,
			hideTrigger:false,
			tpl: customer_listpaket_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			//listClass: 'x-combo-list-small',
			maskRe: /([^0-9]+)$/
	});

  	/* Function for Identify of Window Column Model */
	tindakan_medisColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">' + 'No Cust' + '</div>', //'No. Customer',
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
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'trawat_cust',
			width: 170,	//210,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'dtrawat_perawatan',
			width: 185,	//210,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				store: trawat_medis_perawatanDataStore,
				mode: 'remote',
				displayField: 'perawatan_display',
				valueField: 'perawatan_value',
				tpl: trawat_rawat_tpl,
				itemSelector: 'div.search-item',
				loadingText: 'Searching...',
				pageSize:15,
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
			header: '<div align="center">' + 'Dokter' + '</div>',
			dataIndex: 'dtrawat_petugas1',
			width: 70,
			sortable: true,
			editable:true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				store: cbo_dtindakan_dokterDataStore,
				mode: 'remote',
				displayField: 'karyawan_username',
				valueField: 'karyawan_value',
				loadingText: 'Searching...',
				triggerAction: 'all',
				anchor: '95%'
			})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'App' + '</div>',
			dataIndex: 'dtrawat_jam',
			align: 'center',
			width: 50,
			sortable: true,
			renderer: function(value, cell, record){
				return value.substring(0,5);
			}
		}, 
		{
			header: '<div align="center">' + 'Dtg' + '</div>',
			dataIndex: 'dtrawat_jam_datang',
			align: 'center',
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
			renderer: ch_status_tindakan
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
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
			width: 150,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			sortable: true,
			hidden: true
		}, 
		{
			
			header: '<div align="center">' + 'Ambil Paket' + '</div>',
			dataIndex: 'paket_nama',
			width: 185,	//210,
			sortable: true,
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
			editor : combo_list_paket
			//renderer: Ext.util.Format.comboRenderer(combo_list_paket)
			<?php } ?>
			
		}, 
		/*
		{
			xtype: 'booleancolumn',
			header: 'Ambil Paket',
			dataIndex: 'dtrawat_ambil_paket',
			width: 60,	//65,
			align: 'center',
			trueText: 'Yes',
			falseText: 'No'
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
			,
			editor: {
                xtype: 'checkbox'
            }
			<?php } ?>
		},*/
		/*
		{
			header: '<div align="center">' + 'Info Paket' + '</div>',
			dataIndex: 'cust_punya_paket',
			width: 60,	//55,
			sortable: false,
			hidden: true
		},*/
		{
			header: '<div align="center">' + 'Stat Kasir' + '</div>',
			dataIndex: 'dtrawat_edit',
			width: 60,	//55,
			sortable: false
		},
		{
			header: 'Creator',
			dataIndex: 'trawat_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'trawat_date_create',
			width: 150,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			sortable: true,
			hidden: true
		}, 
		{
			header: 'Last Update By',
			dataIndex: 'trawat_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'trawat_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'trawat_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	tindakan_medisColumnModel.defaultSortable= true;
	/* End of Function */
	function ch_status_tindakan(val){
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
	tindakanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'tindakanListEditorGrid',
		el: 'fp_tindakan',
		title: 'Daftar Tindakan Medis',
		autoHeight: true,
		store: tindakan_medisDataStore, // DataStore
		cm: tindakan_medisColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1305,	//970,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_tmedis,
			disabled:true,
			store: tindakan_medisDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: tindakan_medisconfirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Pencarian detail',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: tindakan_medisDataStore,
			params: {task: 'LIST',start: 0, limit: pageS_tmedis},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						tindakan_medisDataStore.baseParams={task:'LIST',start: 0, limit: pageS_tmedis};
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
			handler: tindakan_medisreset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: tindakan_medisexport_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: tindakan_medisprint  
		}
		]
	});
	tindakanListEditorGrid.render();
	/* End of DataStore */
	
	tindakanListEditorGrid.on('rowclick', function(){
		var recordMaster = tindakanListEditorGrid.getSelectionModel().getSelected();

		trawat_cust_idField.setValue(recordMaster.get("trawat_cust_id"));
		trawat_perawatan_idField.setValue(recordMaster.get("dtrawat_perawatan_id"));
		combo_list_paket.setValue(tindakanListEditorGrid.getSelectionModel().getSelected().get("dtrawat_dpaket_id"));
		dmedis_status_inline_beforeedit = tindakanListEditorGrid.getSelectionModel().getSelected().get('dtrawat_status');

	});
	/*
	tindakanListEditorGrid.on('rowdblclick', function(tindakanListEditorGrid, rowIndex,columnIndex, eventObj){	
	
	});
	*/
	
	combo_list_paket.on('beforeshow',function(){
		//combo_list_paket.setDisabled(true);
		combo_list_paket.setEditable(true);
		//combo_list_paket.hide()
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		medis_listpaket_customerDataStore.load({
					params : {
						trawat_cust_id 		: trawat_cust_idField.getValue(),
						dtrawat_rawat_id 	: trawat_perawatan_idField.getValue()
					},
					callback: function(opts, success, response)  {
						  if (success) {
							Ext.MessageBox.hide();
							//combo_list_paket.setDisabled(false);
							combo_list_paket.setEditable(false);
							//combo_list_paket.getListParent();
							//alert('masuk sini?');
						  }
					  }
				});
	
		//medis_listpaket_customerDataStore.load({params : {trawat_cust_id : trawat_cust_idField.getValue(), dtrawat_rawat_id : trawat_perawatan_idField.getValue()}});
	});
	/*
	combo_list_paket.on('select' ,function(){
		combo_list_paket.collapse(true);
	});
	*/

	/* Create Context Menu */
	tindakan_medisContextMenu = new Ext.menu.Menu({
		id: 'tindakan_medisListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: tindakan_mediseditContextMenu 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: tindakan_medisprint 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: tindakan_medisexport_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ontindakan_medisListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		tindakan_medisContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		tindakan_medisSelectedRow=rowIndex;
		tindakan_medisContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function tindakan_mediseditContextMenu(){
		//tindakanListEditorGrid.startEditing(tindakan_medisSelectedRow,1);
		tindakan_medisconfirm_update();
  	}
	/* End of Function */
  	
	tindakanListEditorGrid.addListener('rowcontextmenu', ontindakan_medisListEditGridContextMenu);
	tindakan_medisDataStore.load({params: {start: 0, limit: pageS_tmedis}});	// load DataStore
	tindakanListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
	
	
	/* Identify  dpaket_id Field */
	trawat_dpaket_idField= new Ext.form.TextField();
	
	
	/* Identify  trawat_id Field */
	trawat_medis_idField= new Ext.form.NumberField({
		id: 'trawat_medis_idField',
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
	trawat_medis_custField= new Ext.form.ComboBox({
		//id: 'trawat_medis_custField',
		fieldLabel: 'Customer <span id="help_customer" style="font-size:11px;color:#F00">[?]</span>',
		store: cbo_tmedis_cutomerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tmedis_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:true,
		anchor: '95%'
	});
	trawat_medis_custidField= new Ext.form.NumberField();
	/* Identify  trawat_keterangan Field */
	trawat_medis_keteranganField= new Ext.form.TextArea({
		id: 'trawat_medis_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
  	/*Fieldset Master*/
	tindakan_medismasterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [trawat_medis_custField, trawat_medis_keteranganField, trawat_medis_idField] 
			}
			]
	
	});
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var tindakan_medis_detail_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'}, 
			{name: 'dtrawat_master', type: 'int', mapping: 'dtrawat_master'}, 
			{name: 'dtrawat_perawatan', type: 'int', mapping: 'dtrawat_perawatan'}, 
			{name: 'dtrawat_jumlah', type: 'int', mapping: 'dtrawat_jumlah'}, 
			{name: 'dtrawat_petugas1', type: 'int', mapping: 'dtrawat_petugas1'}, 
			{name: 'dtrawat_jam', type: 'string', mapping: 'dtrawat_jam'}, 
			{name: 'dtrawat_jam_datang', type: 'string', mapping: 'dtrawat_jam_datang'}, 
			{name: 'dtrawat_kategori', type: 'string', mapping: 'dtrawat_kategori'}, 
			{name: 'dtrawat_status', type: 'string', mapping: 'dtrawat_status'},
			{name: 'dtrawat_keterangan', type: 'string', mapping: 'dtrawat_keterangan'},
			{name: 'dtrawat_ambil_paket', type: 'bool', mapping: 'dtrawat_ambil_paket'}
	]);
	//eof
	
	//function for json writer of detail
	var tindakan_medis_detail_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	tindakan_medis_detail_DataStore = new Ext.data.Store({
		id: 'tindakan_medis_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=detail_tindakan_detail_list', 
			method: 'POST'
		}),
		reader: tindakan_medis_detail_reader,
		baseParams:{master_id: trawat_medis_idField.getValue()},
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	/* End of Function */
	tindakan_medis_detail_DataStore.on('beforeload', function(){
		var_dtindakan_medis_dstore = false;
		tindakan_medis_createWindow.setDisabled(true);
	});
	tindakan_medis_detail_DataStore.on('load', function(opts, success, response){
		if(success){
			var_dtindakan_medis_dstore = true;
			window_medis_editing_lock();
		}
	});
	
	//function for editor of detail
	var editor_tindakan_medis_detail= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_dapp_dokterDataStore = new Ext.data.Store({
		id: 'cbo_dapp_dokterDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_dokter_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'dokter_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'dokter_value', type: 'int', mapping: 'karyawan_id'}
		]),
		sortInfo:{field: 'dokter_display', direction: "ASC"}
	});
	
	cbo_dtindakan_terapisDataStore = new Ext.data.Store({
		id: 'cbo_dtindakan_terapisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_terapis_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'dtrawat_karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'dtrawat_karyawan_value', type: 'int', mapping: 'karyawan_id'},
			{name: 'dtrawat_karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'}
		]),
		sortInfo:{field: 'dtrawat_karyawan_display', direction: "ASC"}
	});
	
	/*cbo_trawat_rawatDataStore = new Ext.data.Store({
		id: 'cbo_trawat_rawatDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_tindakan_medis_list', 
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
	var cbo_trawat_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{trawat_rawat_kode}| <b>{trawat_rawat_display}</b>',
		'</div></tpl>'
    );*/
	/*var cbo_trawat_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{perawatan_kode}</b>| {perawatan_display}<br/>Group: {perawatan_group}<br/>',
			'Kategori: {perawatan_kategori}</span>',
		'</div></tpl>'
    );*/
	
	var combo_trawat_rawat=new Ext.form.ComboBox({
			store: trawat_medis_perawatanDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'perawatan_display',
			valueField: 'perawatan_value',
			loadingText: 'Searching...',
			pageSize:10,
			hideTrigger:false,
			tpl: trawat_rawat_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			maskRe: /([^0-9]+)$/
	});
	

	var combo_dapp_dokter=new Ext.form.ComboBox({
			store: cbo_dtindakan_dokterDataStore,
			mode: 'remote',
			displayField: 'karyawan_username',
			valueField: 'karyawan_value',
			tpl: dokter_tpl,
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			anchor: '95%'
	});
	
	var checkColumn = new Ext.grid.CheckColumn({
		header: 'Ambil Paket',
		dataIndex: 'dtrawat_ambil_paket',
		hidden: true,
		width: 75
	});
	
	
	var dtindakan_medis_jmlField= new Ext.form.NumberField({
		id: 'dtindakan_medis_jmlField',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	//declaration of detail coloumn model
	tindakan_medisdetail_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'dtrawat_perawatan',
			width: 300,	//270,
			sortable: true,
			editor: combo_trawat_rawat,
			renderer: Ext.util.Format.comboRenderer(combo_trawat_rawat)
		},
		{
			header: 'Jml',
			dataIndex: 'dtrawat_jumlah',
			width: 50,
			sortable: true,
			editor: dtindakan_medis_jmlField
		},
		{
			header: '<div align="center">' + 'Dokter' + '</div>',
			dataIndex: 'dtrawat_petugas1',
			width: 80,	//200,
			sortable: true,
			editor: combo_dapp_dokter,
			renderer: Ext.util.Format.comboRenderer(combo_dapp_dokter)
		},
		{
			header: '<div align="center">' + 'App' + '</div>',
			dataIndex: 'dtrawat_jam',
			width: 60,	//100,
			sortable: true,
			editor: new Ext.form.TimeField({
				format: 'H:i:s',
				minValue: '7:00',
				maxValue: '21:00',
				increment: 30,
				width: 94
			})
		},
		{
			header: '<div align="center">' + 'Datang' + '</div>',
			dataIndex: 'dtrawat_jam_datang',
			width: 60,	//100,
			sortable: true
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
			sortable: true,
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
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		},checkColumn]
	);
	tindakan_medisdetail_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	tindakan_medisdetailListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'tindakan_medisdetailListEditorGrid',
		el: 'fp_tindakan_medisdetail',
		title: 'Detail Tindakan Medis',
		height: 200,
		width: 888,
		autoScroll: true,
		store: tindakan_medis_detail_DataStore, // DataStore
		colModel: tindakan_medisdetail_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_tindakan_medis_detail,checkColumn],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		,
		tbar: [
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: tindakan_medisdetail_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: tindakan_medisdetail_confirm_delete
		},'-',
		<?php } ?>
		//'<span style="color:white;">WARNING: <b>List Detail di bawah ini Tidak Boleh di-Edit, hanya boleh Add Baru.</b></span>'
		'<span style="color:white;">Warning: <b>Pada form ini user tidak diperkenankan mengubah perawatan yang sudah selesai.</b></span>'
		]
	});
	//eof
	
	
	//function of detail add
	function tindakan_medisdetail_add(){
		var edit_tindakan_medisdetail= new tindakan_medisdetailListEditorGrid.store.recordType({
			dtrawat_perawatan	:'',
			dtrawat_jumlah		:1,
			dtrawat_petugas1	:'',		
			dtrawat_jam	:'',		
			dtrawat_status	:'datang',
			dtrawat_keterangan	: ''
		});
		editor_tindakan_medis_detail.stopEditing();
		tindakan_medis_detail_DataStore.insert(0, edit_tindakan_medisdetail);
		//tindakan_medisdetailListEditorGrid.getView().refresh();
		tindakan_medisdetailListEditorGrid.getSelectionModel().selectRow(0);
		editor_tindakan_medis_detail.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_tindakan_medisdetail(){
		//tindakan_medis_detail_DataStore.commitChanges();
		//tindakan_medisdetailListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function tindakan_medisdetail_insert(){
		var dtrawat_id=[];
		var dtrawat_perawatan=[];
		var dtrawat_jumlah=[];
		var dtrawat_petugas1=[];
		var dtrawat_jamreservasi=[];
		var dtrawat_status=[];
		var dtrawat_keterangan=[];
		
		var dcount = tindakan_medis_detail_DataStore.getCount() - 1;
		
		if(tindakan_medis_detail_DataStore.getCount()>0){
			for(i=0; i<tindakan_medis_detail_DataStore.getCount();i++){
				if((/^\d+$/.test(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan))
				   && tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==undefined
				   && tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==''
				   && tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan!==0){
					if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_id==undefined){
						dtrawat_id.push('');
					}else{
						dtrawat_id.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_id);
					}
					
					dtrawat_perawatan.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_perawatan);
					
					if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_petugas1==undefined){
						dtrawat_petugas1.push('');
					}else{
						dtrawat_petugas1.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_petugas1);
					}
					
					if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jam==undefined){
						dtrawat_jamreservasi.push('');
					}else{
						dtrawat_jamreservasi.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jam);
					}
					
					if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_status==undefined){
						dtrawat_status.push('');
					}else{
						dtrawat_status.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_status);
					}
					
					if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jumlah==undefined || tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jumlah==0){
						dtrawat_jumlah.push(1);
					}else{
						dtrawat_jumlah.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_jumlah);
					}
					
					if(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_keterangan==undefined){
						dtrawat_keterangan.push('');
					}else{
						dtrawat_keterangan.push(tindakan_medis_detail_DataStore.getAt(i).data.dtrawat_keterangan);
					}
				}
				
				if(i==dcount){
					var encoded_array_dtrawat_id = Ext.encode(dtrawat_id);
					var encoded_array_dtrawat_perawatan = Ext.encode(dtrawat_perawatan);
					var encoded_array_dtrawat_jumlah = Ext.encode(dtrawat_jumlah);
					var encoded_array_dtrawat_petugas1 = Ext.encode(dtrawat_petugas1);
					var encoded_array_dtrawat_jamreservasi = Ext.encode(dtrawat_jamreservasi);
					var encoded_array_dtrawat_status = Ext.encode(dtrawat_status);
					var encoded_array_dtrawat_keterangan = Ext.encode(dtrawat_keterangan);
					
					Ext.Ajax.request({
						waitMsg: 'Please wait...',
						url: 'index.php?c=c_tindakan_medis&m=detail_tindakan_medis_detail_insert',
						params:{
						dtrawat_id	: encoded_array_dtrawat_id,
						dtrawat_master	: eval(trawat_medis_idField.getValue()), 
						dtrawat_perawatan	: encoded_array_dtrawat_perawatan,
						dtrawat_jumlah		: encoded_array_dtrawat_jumlah,
						dtrawat_petugas1	: encoded_array_dtrawat_petugas1,
						dtrawat_jamreservasi	: encoded_array_dtrawat_jamreservasi,
						dtrawat_status	: encoded_array_dtrawat_status,
						dtrawat_keterangan	: encoded_array_dtrawat_keterangan,
						dtrawat_cust	: trawat_medis_custidField.getValue()
						},
						success: function(response){
							var result=eval(response.responseText);
							if(result==1){
								dtindakan_jual_nonmedis_insert();
								tindakan_medisDataStore.reload();
							}else if(result==0){
								tindakan_medis_createWindow.hide();
								tindakan_medisDataStore.reload();
								//Ext.MessageBox.hide();
								tindakan_medis_createWindow.setDisabled(false);
							}else{
								tindakan_medis_createWindow.hide();
								tindakan_medisDataStore.reload();
								//Ext.MessageBox.hide();
								tindakan_medis_createWindow.setDisabled(false);
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
							tindakan_medis_createWindow.hide();
							//Ext.MessageBox.hide();
							tindakan_medis_createWindow.setDisabled(false);
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
	function tindakan_medisdetail_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_tindakan_medis&m=detail_tindakan_medis_detail_purge',
			params:{ master_id: eval(trawat_medis_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					tindakan_medisdetail_insert();
					tindakan_medisDataStore.reload();
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function tindakan_medisdetail_confirm_delete(){
		// only one record is selected here
		if(tindakan_medisdetailListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', tindakan_medisdetail_delete);
		} else if(tindakan_medisdetailListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', tindakan_medisdetail_delete);
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
	function tindakan_medisdetail_delete(btn){
		if(btn=='yes'){
			var s = tindakan_medisdetailListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				tindakan_medis_detail_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	tindakan_medis_detail_DataStore.on('update', refresh_tindakan_medisdetail);
	
	/* START JUAL DETAIL_NON-MEDIS */
	/*Detail Declaration */
		
	// Function for json reader of detail
	var dtindakan_jual_nonmedis_reader=new Ext.data.JsonReader({
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
			{name: 'dtrawat_karyawan_username', type: 'string', mapping: 'dokter_username'}, 
			{name: 'dtrawat_jam', type: 'string', mapping: 'dtrawat_jam'}, 
			{name: 'dtrawat_kategori', type: 'string', mapping: 'dtrawat_kategori'}, 
			{name: 'dtrawat_status', type: 'string', mapping: 'dtrawat_status'},
			{name: 'dtrawat_keterangan', type: 'string', mapping: 'dtrawat_keterangan'},
			{name: 'dtrawat_jumlah', type: 'int', mapping: 'dtrawat_jumlah'}
	]);
	//eof
	
	//function for json writer of detail
	var dtindakan_jual_nonmedis_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	dtindakan_jual_nonmedisDataStore = new Ext.data.Store({
		id: 'dtindakan_jual_nonmedisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=dtindakan_jual_nonmedis_list', 
			method: 'POST'
		}),
		reader: dtindakan_jual_nonmedis_reader,
		baseParams:{master_id: trawat_medis_idField.getValue()},
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	/* End of Function */
	dtindakan_jual_nonmedisDataStore.on('beforeload', function(){
		var_dtindakan_jnonmedis_dstore = false;
		tindakan_medis_createWindow.setDisabled(true);
	});
	dtindakan_jual_nonmedisDataStore.on('load', function(opts, success, response){
		if(success){
			var_dtindakan_jnonmedis_dstore = true;
			window_medis_editing_lock();
		}
	});
	
	//function for editor of detail
	var editor_dtindakan_jual_nonmedis= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	var terapis_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{dtrawat_karyawan_username}</b> | {dtrawat_karyawan_display}</span>',
        '</div></tpl>'
    );
	
	cbo_perawatan_dtjnonmedisDataStore = new Ext.data.Store({
		id: 'cbo_perawatan_dtjnonmedisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_tindakan_medis&m=get_nonmedis_in_tmedis_list', 
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
	var rawat_dtjnonmedis_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{perawatan_kode}| <b>{perawatan_display}</b>',
		'</div></tpl>'
    );
	cbo_perawatan_dtjnonmedisDataStore.on('beforeload', function(){
		var_perawatan_nonmedis_inmedis_dstore = false;
		tindakan_medis_createWindow.setDisabled(true);
	});
	cbo_perawatan_dtjnonmedisDataStore.on('load', function(opts, success, response){
		if(success){
			var_perawatan_nonmedis_inmedis_dstore = true;
			window_medis_editing_lock();
		}
	});
	
	var combo_perawatan_dtjnonmedis=new Ext.form.ComboBox({
			store: cbo_perawatan_dtjnonmedisDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'perawatan_display',
			valueField: 'perawatan_value',
			tpl: rawat_dtjnonmedis_tpl,
			loadingText: 'Searching...',
			pageSize:15,
			hideTrigger:false,
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			maskRe: /([^0-9]+)$/
	});
	
	var combo_dtindakan_terapis=new Ext.form.ComboBox({
			store: cbo_dtindakan_terapisDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'dtrawat_karyawan_username',
			valueField: 'dtrawat_karyawan_value',
			tpl: terapis_tpl,
			loadingText: 'Searching...',
			itemSelector: 'div.search-item',
			triggerAction: 'all'
	});
	
	var dtindakan_nonmedisField= new Ext.form.NumberField({
		id: 'dtindakan_nonmedisField',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	//declaration of detail coloumn model
	tindakan_nonmedis_detailColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'dtrawat_perawatan',
			width: 400,
			sortable: true,
			editor: combo_perawatan_dtjnonmedis,
			renderer: Ext.util.Format.comboRenderer(combo_perawatan_dtjnonmedis)
		},
		{
			header: 'Jumlah',
			dataIndex: 'dtrawat_jumlah',
			width: 60,
			sortable: true,
			editor: dtindakan_nonmedisField
		},
		{
			header: '<div align="center">' + 'Suster' + '</div>',
			dataIndex: 'dtrawat_petugas1',
			width: 100,	//200,
			sortable: false,
			editor: combo_dtindakan_terapis,
			renderer: Ext.util.Format.comboRenderer(combo_dtindakan_terapis)
		},
		{
			header: '<div align="center">' + 'Detail Keterangan' + '</div>',
			dataIndex: 'dtrawat_keterangan',
			width: 428,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		}]
	);
	tindakan_nonmedis_detailColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	dtindakan_jual_nonmedisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'dtindakan_jual_nonmedisListEditorGrid',
		el: 'fp_dtindakan_jual_nonmedis',
		title: 'Detail Tindakan Non Medis',
		height: 200,
		width: 888,
		autoScroll: true,
		store: dtindakan_jual_nonmedisDataStore, // DataStore
		colModel: tindakan_nonmedis_detailColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_dtindakan_jual_nonmedis],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		,
		tbar: [
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: dtindakan_jual_nonmedis_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled: true,
			handler: dtindakan_jual_nonmedis_confirm_delete
		},'-',
		<?php } ?>
		//'<span style="color:white;">WARNING: <b>List Detail di bawah ini Boleh di-Edit hanya untuk status Yang Bukan "selesai".</b></span>'
		'<span style="color:white;">Warning: <b>Pada form ini user tidak diperkenankan mengubah perawatan yang sudah selesai.</b></span>'
		]
	});
	//eof
	
	
	//function of detail add
	function dtindakan_jual_nonmedis_add(){
		var edit_tindakan_nonmedis_detail= new dtindakan_jual_nonmedisListEditorGrid.store.recordType({
			dtrawat_perawatan	:'',
			dtrawat_petugas1	: 5,
			dtrawat_jumlah		: 1,
			dtrawat_keterangan	:''		
		});
		editor_dtindakan_jual_nonmedis.stopEditing();
		dtindakan_jual_nonmedisDataStore.insert(0, edit_tindakan_nonmedis_detail);
		//dtindakan_jual_nonmedisListEditorGrid.getView().refresh();
		dtindakan_jual_nonmedisListEditorGrid.getSelectionModel().selectRow(0);
		editor_dtindakan_jual_nonmedis.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_dtindakan_jual_nonmedis(){
		//dtindakan_jual_nonmedisDataStore.commitChanges();
		//dtindakan_jual_nonmedisListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function dtindakan_jual_nonmedis_insert(){
		var dtrawat_id = [];
		var dtrawat_perawatan = [];
		var dtrawat_keterangan = [];
		var dtrawat_jumlah = [];
		
		var dcount = dtindakan_jual_nonmedisDataStore.getCount() - 1;
		
		if(dtindakan_jual_nonmedisDataStore.getCount()>0){
			for(i=0; i<dtindakan_jual_nonmedisDataStore.getCount();i++){
				if((/^\d+$/.test(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan))
				   && dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan!==undefined
				   && dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan!==''
				   && dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan!==0){
					if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_id==undefined){
						dtrawat_id.push('');
					}else{
						dtrawat_id.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_id);
					}
					
					dtrawat_perawatan.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_perawatan);
					
					if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_keterangan==undefined){
						dtrawat_keterangan.push('');
					}else{
						dtrawat_keterangan.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_keterangan);
					}
					
					if(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_jumlah==undefined || dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_jumlah==0){
						dtrawat_jumlah.push(1);
					}else{
						dtrawat_jumlah.push(dtindakan_jual_nonmedisDataStore.getAt(i).data.dtrawat_jumlah);
					}
				}
				
				if(i==dcount){
					var encoded_array_dtrawat_id = Ext.encode(dtrawat_id);
					var encoded_array_dtrawat_perawatan = Ext.encode(dtrawat_perawatan);
					var encoded_array_dtrawat_keterangan = Ext.encode(dtrawat_keterangan);
					var encoded_array_dtrawat_jumlah = Ext.encode(dtrawat_jumlah);
					
					Ext.Ajax.request({
						waitMsg: 'Please wait...',
						url: 'index.php?c=c_tindakan_medis&m=detail_dtindakan_jual_nonmedis_insert',
						params:{
							dtrawat_id	: encoded_array_dtrawat_id,
							dtrawat_master	: eval(trawat_medis_idField.getValue()),
							dtrawat_perawatan	: encoded_array_dtrawat_perawatan,
							dtrawat_keterangan	: encoded_array_dtrawat_keterangan,
							dtrawat_jumlah	: encoded_array_dtrawat_jumlah,
							customer_id	: trawat_medis_custidField.getValue()
						},
						callback: function(opts, success, response){
							if(success){
								tindakan_medis_createWindow.hide();
								tindakan_medisDataStore.reload();
								//Ext.MessageBox.hide();
								tindakan_medis_createWindow.setDisabled(false);
								Ext.MessageBox.alert(' OK','Data telah selesai diproses.');
							}
						}
					});
				}
			}
		}else if(dtindakan_jual_nonmedisDataStore.getCount()==0){
			dtindakan_jual_nonmedis_purge();
		}
		
		
		/*if(dtindakan_jual_nonmedisDataStore.getCount()!=0){
			for(i=0;i<dtindakan_jual_nonmedisDataStore.getCount();i++){
				tindakan_nonmedis_detail_record=dtindakan_jual_nonmedisDataStore.getAt(i);
				Ext.Ajax.request({
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_tindakan_medis&m=detail_dtindakan_jual_nonmedis_insert',
					params:{
					dtrawat_id	: tindakan_nonmedis_detail_record.data.dtrawat_id, 
					dtrawat_master	: eval(trawat_medis_idField.getValue()), 
					dtrawat_perawatan	: tindakan_nonmedis_detail_record.data.dtrawat_perawatan, 
					dtrawat_keterangan	: tindakan_nonmedis_detail_record.data.dtrawat_keterangan,
					customer_id	: trawat_medis_custidField.getValue(),
					dtrawat_jumlah	: tindakan_nonmedis_detail_record.data.dtrawat_jumlah
					},
					callback: function(opts, success, response){
						tindakan_medisDataStore.reload();
					}
				});
			}
		}else if(dtindakan_jual_nonmedisDataStore.getCount()==0){
			dtindakan_jual_nonmedis_purge();
		}*/
	}
	//eof
	
	//function for purge detail
	function dtindakan_jual_nonmedis_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_tindakan_medis&m=detail_tindakan_nonmedis_detail_purge',
			params:{ master_id: eval(trawat_medis_idField.getValue()) },
			callback: function(opts, success, response){
				if(success){
					tindakan_medis_createWindow.hide();
					//dtindakan_jual_nonmedis_insert();
					//dtindakan_jual_nonmedisDataStore.reload();
					tindakan_medisDataStore.reload();
					//Ext.MessageBox.hide();
					tindakan_medis_createWindow.setDisabled(false);
				}
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function dtindakan_jual_nonmedis_confirm_delete(){
		// only one record is selected here
		if(dtindakan_jual_nonmedisListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', dtindakan_jual_nonmedis_delete);
		} /*else if(dtindakan_jual_nonmedisListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', dtindakan_jual_nonmedis_delete);
		}*/ else {
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
	function dtindakan_jual_nonmedis_delete(btn){
		if(btn=='yes'){
			if((/^\d+$/.test(dtindakan_jual_nonmedisListEditorGrid.getSelectionModel().getSelected().get('dtrawat_id')))==false){
				var s = dtindakan_jual_nonmedisListEditorGrid.getSelectionModel().getSelections();
				for(var i = 0, r; r = s[i]; i++){
					dtindakan_jual_nonmedisDataStore.remove(r);
				}
			}else{
				Ext.MessageBox.show({
					title: 'Warning',
					width: 300,
					msg: 'Data tidak bisa didelete, <br/>silakan dibatalkan di List Tindakan Medis.',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	dtindakan_jual_nonmedisDataStore.on('update', refresh_dtindakan_jual_nonmedis);
	/* END JUAL DETAIL_NON-MEDIS */
	
	var detail_tab_tindakan = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [tindakan_medisdetailListEditorGrid,dtindakan_jual_nonmedisListEditorGrid]
	});
	
	/* Function for retrieve create Window Panel*/ 
	tindakan_medis_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 930,        
		items: [tindakan_medismasterGroup, detail_tab_tindakan]
		,
		buttons: [
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
			{
				id: 'tmedis_saveClose',
				text: 'Save and Close',
				handler: tindakan_medis_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					tindakan_medis_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_MEDIS'))){ ?>
	Ext.getCmp('tmedis_saveClose').on('click', function(){
		/*Ext.MessageBox.show({
           title: 'Please wait',
           msg: 'Loading items...',
           progressText: 'Initializing...',
           width:300,
		   wait:true,
		   waitConfig: {interval:200},
           closable:false
       });*/
		tindakan_medis_createWindow.setDisabled(true);
	});
	<?php } ?>
	
	
	/* Function for retrieve create Window Form */
	tindakan_medis_createWindow= new Ext.Window({
		id: 'tindakan_medis_createWindow',
		title: tmedis_post2db+'Tindakan Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_tindakan_medis_create',
		items: tindakan_medis_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function tindakan_medislist_search(){
		// render according to a SQL date format.
		var trawat_cust_search=null;
		//var trawat_keterangan_search=null;
		var trawat_tgl_start_app_search=null;
		var trawat_tgl_end_app_search=null;
		var trawat_rawat_search=null;
		var trawat_dokter_search=null;
		var trawat_status_search=null;

		if(trawat_medis_custSearchField.getValue()!==null){trawat_cust_search=trawat_medis_custSearchField.getValue();}
		//if(trawat_medis_keteranganSearchField.getValue()!==null){trawat_keterangan_search=trawat_medis_keteranganSearchField.getValue();}
		if(Ext.getCmp('trawat_medis_tglStartAppSearchField').getValue()!==null){trawat_tgl_start_app_search=Ext.getCmp('trawat_medis_tglStartAppSearchField').getValue();}
		if(Ext.getCmp('trawat_medis_tglEndAppSearchField').getValue()!==null){trawat_tgl_end_app_search=Ext.getCmp('trawat_medis_tglEndAppSearchField').getValue();}
		if(trawat_medis_rawatSearchField.getValue()!==null){trawat_rawat_search=trawat_medis_rawatSearchField.getValue();}
		if(trawat_medis_dokterSearchField.getValue()!==null){trawat_dokter_search=trawat_medis_dokterSearchField.getValue();}
		if(trawat_medis_statusSearchField.getValue()!==null){trawat_status_search=trawat_medis_statusSearchField.getValue();}
		// change the store parameters
		tindakan_medisDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			trawat_cust	:	trawat_cust_search, 
			//trawat_keterangan	:	trawat_keterangan_search, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_search,
			trawat_tglapp_end	: 	trawat_tgl_end_app_search,
			trawat_rawat	:	trawat_rawat_search,
			trawat_dokter	:	trawat_dokter_search,
			trawat_status	:	trawat_status_search
		};
		// Cause the datastore to do another query : 
		tindakan_medisDataStore.reload({params: {start: 0, limit: pageS_tmedis}});
	}
		
	/* Function for reset search result */
	function tindakan_medisreset_search(){
		// reset the store parameters
		tindakan_medisDataStore.baseParams = { task: 'LIST',start:0,limit:pageS_tmedis };
		// Cause the datastore to do another query : 
		tindakan_medisDataStore.reload({params: {start: 0, limit: pageS_tmedis}});
		//tindakan_medis_searchWindow.close();
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
	/* Identify  trawat_cust Search Field */
	trawat_medis_custSearchField= new Ext.form.ComboBox({
		//id: 'trawat_medis_custField',
		fieldLabel: 'Customer',
		store: cbo_tmedis_cutomerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tmedis_tpl,
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
		store: trawat_medis_perawatanDataStore,
		mode: 'remote',
		displayField:'perawatan_display',
		valueField: 'perawatan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: trawat_rawat_tpl,
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
		store: cbo_dtindakan_dokterDataStore,
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
	trawat_medis_keteranganSearchField= new Ext.form.TextArea({
		id: 'trawat_medis_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
    
	/* Function for retrieve search Form Panel */
	tindakan_medis_searchForm = new Ext.FormPanel({
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
									fieldLabel: 'Tgl App',
							        name: 'trawat_medis_tglStartAppSearchField',
							        id: 'trawat_medis_tglStartAppSearchField',
							        vtype: 'daterange',
							        format: 'd-m-Y',
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
							        format: 'd-m-Y',
							        value : today,
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
					tindakan_medis_searchWindow.hide();
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
		trawat_medis_dokterSearchField.reset();
		trawat_medis_dokterSearchField.setValue(null);
		trawat_medis_keteranganSearchField.reset();
		trawat_medis_keteranganSearchField.setValue(null);
		trawat_medis_rawatSearchField.reset();
		trawat_medis_rawatSearchField.setValue(null);
		Ext.getCmp('trawat_medis_tglStartAppSearchField').reset();
		Ext.getCmp('trawat_medis_tglStartAppSearchField').setValue(null);
		Ext.getCmp('trawat_medis_tglEndAppSearchField').reset();
		Ext.getCmp('trawat_medis_tglEndAppSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	tindakan_medis_searchWindow = new Ext.Window({
		title: 'Pencarian Tindakan Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_tindakan_medis_search',
		items: tindakan_medis_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!tindakan_medis_searchWindow.isVisible()){
			tindakan_medis_reset_formSearch();
			tindakan_medis_searchWindow.show();
		} else {
			tindakan_medis_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function tindakan_medisprint(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_tgl_start_app_print=null;
		var trawat_tgl_end_app_print=null;
		var trawat_rawat_print=null;
		var trawat_dokter_print=null;
		var trawat_status_print=null;
		var win;              
		// check if we do have some search data...
		if(tindakan_medisDataStore.baseParams.query!==null){searchquery = tindakan_medisDataStore.baseParams.query;}
		if(tindakan_medisDataStore.baseParams.trawat_cust!==null){trawat_cust_print = tindakan_medisDataStore.baseParams.trawat_cust;}
		if(tindakan_medisDataStore.baseParams.trawat_tglapp_start!==null){trawat_tgl_start_app_print = tindakan_medisDataStore.baseParams.trawat_tglapp_start;}
		if(tindakan_medisDataStore.baseParams.trawat_tglapp_end!==null){trawat_tgl_end_app_print = tindakan_medisDataStore.baseParams.trawat_tglapp_end;}
		if(tindakan_medisDataStore.baseParams.trawat_rawat!==null){trawat_rawat_print = tindakan_medisDataStore.baseParams.trawat_rawat;}
		if(tindakan_medisDataStore.baseParams.trawat_dokter!==null){trawat_dokter_print = tindakan_medisDataStore.baseParams.trawat_dokter;}
		if(tindakan_medisDataStore.baseParams.trawat_status!==null){trawat_status_print = tindakan_medisDataStore.baseParams.trawat_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_tindakan_medis&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust	:	trawat_cust_print, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_print,
			trawat_tglapp_end	: 	trawat_tgl_end_app_print,
			trawat_rawat	:	trawat_rawat_print,
			trawat_dokter	:	trawat_dokter_print,
			trawat_status	:	trawat_status_print,
		  	currentlisting: tindakan_medisDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/tindakan_medislist.html','tindakanlist','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
				//
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
	function tindakan_medisexport_excel(){
		var searchquery = "";
		var trawat_cust_2excel=null;
		var trawat_tgl_start_app_2excel=null;
		var trawat_tgl_end_app_2excel=null;
		var trawat_rawat_2excel=null;
		var trawat_dokter_2excel=null;
		var trawat_status_2excel=null;
		var win;              
		// check if we do have some search data...
		if(tindakan_medisDataStore.baseParams.query!==null){searchquery = tindakan_medisDataStore.baseParams.query;}
		if(tindakan_medisDataStore.baseParams.trawat_cust!==null){trawat_cust_2excel = tindakan_medisDataStore.baseParams.trawat_cust;}
		if(tindakan_medisDataStore.baseParams.trawat_tglapp_start!==null){trawat_tgl_start_app_2excel = tindakan_medisDataStore.baseParams.trawat_tglapp_start;}
		if(tindakan_medisDataStore.baseParams.trawat_tglapp_end!==null){trawat_tgl_end_app_2excel = tindakan_medisDataStore.baseParams.trawat_tglapp_end;}
		if(tindakan_medisDataStore.baseParams.trawat_rawat!==null){trawat_rawat_2excel = tindakan_medisDataStore.baseParams.trawat_rawat;}
		if(tindakan_medisDataStore.baseParams.trawat_dokter!==null){trawat_dokter_2excel = tindakan_medisDataStore.baseParams.trawat_dokter;}
		if(tindakan_medisDataStore.baseParams.trawat_status!==null){trawat_status_2excel = tindakan_medisDataStore.baseParams.trawat_status;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_tindakan_medis&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_cust	:	trawat_cust_2excel, 
			trawat_tglapp_start	: 	trawat_tgl_start_app_2excel,
			trawat_tglapp_end	: 	trawat_tgl_end_app_2excel,
			trawat_rawat	:	trawat_rawat_2excel,
			trawat_dokter	:	trawat_dokter_2excel,
			trawat_status	:	trawat_status_2excel,
		  	currentlisting: tindakan_medisDataStore.baseParams.task // this tells us if we are searching or not
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
	function window_medis_editing_lock(){
		if(var_dokter_dstore==true && var_perawatan_medis_dstore==true && var_perawatan_nonmedis_inmedis_dstore==true
		   && var_dtindakan_medis_dstore==true && var_dtindakan_jnonmedis_dstore==true){
			tindakan_medis_createWindow.setDisabled(false);
		}
	}
	
	/* END Screen Lock Function */

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_tindakan"></div>
         <div id="fp_tindakan_medisdetail"></div>
		 <div id="fp_dtindakan_jual_nonmedis"></div>
		<div id="elwindow_tindakan_medis_create"></div>
        <div id="elwindow_tindakan_medis_search"></div>
    </div>
</div>
</body>