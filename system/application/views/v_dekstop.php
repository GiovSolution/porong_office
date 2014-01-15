<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Porong Wei - Information System</title>
	<?=css_asset('ext-all.css');?>
    <?=css_asset('docs.css','main');?>
    <? //=css_asset('forms.css');?>
    <?=css_asset('mmcal.css');?>
   	<?=css_asset('xtheme-slate.css');?>
	<?=css_asset('file-upload.css');?>
	<?=css_asset('MultiSelect.css');?>
	<?=css_asset('GroupSummary.css');?>
    <?=css_asset('ColumnNodeUI.css');?>
      
    <?=js_asset('ext-base.js');?>
    <?=js_asset('ext-all.js');?>
    <?=js_asset('App.js');?>
	<?=js_asset('TabCloseMenu.js');?>
	<?=js_asset('FileUploadField.js');?>
	<?=js_asset('SearchField.js');?>
	<?=js_asset('RowExpander.js');?>
    <?=js_asset('RowEditor.js');?>
	<?=js_asset('CheckColumn.js');?>
    <?=js_asset('ColumnNodeUI.js');?>
    <?=js_asset('MultiSelect.js');?>
    <?=js_asset('ItemSelector.js');?>
    <?=js_asset('InputTextMask.js');?>
	<?=js_asset('currency.js');?>
	<?=js_asset('GroupSummary.js');?>
<script type="text/javascript">
	var s = document.createElement("script");
	s.type = 'text/javascript';
	s.src = "./assets/js/locale/ext-lang-id.js";
	s.charset = "ascii";
	document.getElementsByTagName("head")[0].appendChild(s);
	

</script>
    <?=js_asset('PagingMemoryProxy.js');?>
  	<link rel="shortcut icon" href="<?=base_url();?>favicon.ico" />

	<style type="text/css">
	html, body {
        font:normal 12px verdana;
        margin:0;
        padding:0;
        border:0 none;
        overflow:hidden;
        height:100%;
    }
	p {
	    margin:5px;
	}
    .style1 {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 14px;
	}
    .style2 {
		font-size: large;
		font-family: "Courier New", Courier, monospace;
	}
	.style5 {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: small;
		color: #AF4046;
	}
	<?php
	if(count($menus)){
		foreach($menus as $allmenu){
			$icon_file=file_exists(image_asset_url("icons/".$allmenu["menu_iconmenu"])) && $allmenu["menu_iconmenu"]!=="" ? image_asset_url("icons/".$allmenu["menu_iconmenu"]):image_asset_url("icons/grid.png");
	echo "\t .icon-".$allmenu["menu_id"]."{ background-image:url(".$icon_file.") !important; } \n";
		}
	}
	
	if(count($submenus)){
		foreach($submenus as $allmenu){
			$icon_file=file_exists(image_asset_url("icons/".$allmenu["menu_iconmenu"])) && $allmenu["menu_iconmenu"]!=="" ? image_asset_url("icons/".$allmenu["menu_iconmenu"]):image_asset_url("icons/grid.png");
	echo "\t .icon-".$allmenu["menu_id"]."{ background-image:url(".$icon_file.") !important; } \n";
		}
	}
	
	?>
    </style>
	
<script>
 
Ext.onReady(function(){

	/*Data Store khusus utk menampung welcome mesage */
	welcome_messageDataStore = new Ext.data.Store({
		id: 'welcome_messageDataStore ',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_welcome_msg&m=get_welcome_message', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results'
		},[
			{name: 'welcome_id', type: 'int', mapping: 'welcome_id'},
			{name: 'welcome_msg', type: 'string', mapping: 'welcome_msg'},
			{name: 'welcome_title', type: 'string', mapping: 'welcome_title'},
			{name: 'welcome_icon', type: 'string', mapping: 'welcome_icon'}
		]),
		sortInfo:{field: 'welcome_id', direction: "ASC"}
	});
	
	welcome_messageDataStore.load({
				params: {task : "LIST", menu_id: 0},
					callback: function(opts, success, response)  {
						if (success) {							
							if(welcome_messageDataStore.getCount()){
								if (welcome_messageDataStore.getAt(0).data.welcome_icon == 'INFO') {
									var icon = Ext.MessageBox.INFO;
								} else if (welcome_messageDataStore.getAt(0).data.welcome_icon == 'WARNING'){
									var icon = Ext.MessageBox.WARNING;
								} else if (welcome_messageDataStore.getAt(0).data.welcome_icon == 'QUESTION'){
									var icon = Ext.MessageBox.QUESTION;
								} else if (welcome_messageDataStore.getAt(0).data.welcome_icon == 'ERROR'){
									var icon = Ext.MessageBox.ERROR;
								}
							
								Ext.MessageBox.show({
									title: welcome_messageDataStore.getAt(0).data.welcome_title,
									msg: welcome_messageDataStore.getAt(0).data.welcome_msg,
									buttons: Ext.MessageBox.OK,
									animEl: 'save',
									icon: icon
								});
							}
						  }
					  }
				});	
				
	});

</script> 	
	
	
	
   
	<?php $this->load->view('menus')?>
</head>
<body>
	<div id="loading-mask" style=""></div>
	<div id="loading">
		<div class="loading-indicator">
			<img src="<?=image_asset_url('extanim32.gif','main');?>" width="32" height="32" style="margin-right:8px;" align="absmiddle"/>
			Loading...
		</div>
	</div> 
  	<div id="north">
    	<div class="api-title style1 style2" style="float:left; margin-left:10px;">
			<p class="style5"><font style="font-weight:bold"><? $info=$this->m_public_function->get_info(); if($info!==""){ echo $info->info_nama; }?></font>, <?php if($info!==""){ echo $info->info_alamat;  }?>&nbsp;&nbsp;
            </p>
		</div>
		<div style="float:right; margin-right:10px; margin-top:5px; color:#AF4046;"> 
<!--        Welcome --> 
        Selamat datang,
        <font style="font-weight:bold"><?=$_SESSION[SESSION_USERID]." (".$_SESSION[SESSION_GROUPNAMA].")";?></font>&nbsp;
<!--        [ <a  onClick="return confirm('Are you sure to logout?'); " href="index.php?c=c_login&m=logout" style="color:#AF4046">Logout</a> ]-->
 		[<a  onclick="return confirm('Are you sure to logout?'); " href="index.php?c=c_login&m=logout" style="color:#AF4046">Keluar</a>]
        </div>
  	</div>
  	<div id="props-panel" style="width:200px;height:200px;overflow:hidden;"></div>
    <div id="main"></div>
 
</body>
</html>