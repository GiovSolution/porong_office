
<script type="text/javascript">
Ext.BLANK_IMAGE_URL = 'assets/images/s.gif';

Docs = {};
Docs.icons = {"Icons":"icon-frm"};

DocPanel = Ext.extend(Ext.Panel, {
	closable: true,
	autoScroll:true,

	initComponent : function(){
		var ps = this.cclass.split('.');
		this.title = ps[ps.length-1];

		DocPanel.superclass.initComponent.call(this);
	},

	scrollToMember : function(member){
		var el = Ext.fly(this.cclass + '-' + member);
		if(el){
			var top = (el.getOffsetsTo(this.body)[1]) + this.body.dom.scrollTop;
			this.body.scrollTo('top', top-25, {duration:.75, callback: this.hlMember.createDelegate(this, [member])});
		}
	},

	scrollToSection : function(id){
		var el = Ext.getDom(id);
		if(el){
			var top = (Ext.fly(el).getOffsetsTo(this.body)[1]) + this.body.dom.scrollTop;
			this.body.scrollTo('top', top-25, {duration:.5, callback: function(){
				Ext.fly(el).next('h2').pause(.2).highlight('#8DB2E3', {attr:'color'});
			}});
		}
	},

	hlMember : function(member){
		var el = Ext.fly(this.cclass + '-' + member);
		if(el){
			el.up('tr').highlight('#cadaf9');
		}
	}
});
	
MainPanel = function() {
	MainPanel.superclass.constructor.call(this, {
		id:'doc-body',
		region:'center',
		margins:'0 5 0 0',
		resizeTabs: true,
		minTabWidth: 160,
		tabWidth: 160,
		plugins: new Ext.ux.TabCloseMenu(),
		enableTabScroll: true,
		activeTab: 0,

		items: {
			id:'welcome-panel',
//			title: 'Welcome Home',
			title: 'Home',
			<? if(file_exists("./uploads/".$background) && $background!==""){?>
			style: 'background: url(./uploads/<?=$background;?>)',
			<? }else{ ?>
			style: 'background: url(assets/wallpapers/desktop.jpg)',
			<? } ?>
			iconCls:'icon-docs',
			autoScroll: true
		}
	});
};

Ext.extend(MainPanel, Ext.TabPanel, {
	initEvents : function(){
		MainPanel.superclass.initEvents.call(this);
		this.body.on('click', this.onClick, this);
	},

	onClick: function(e, target){
		if(target = e.getTarget('a:not(.exi)', 3)){
			var cls = Ext.fly(target).getAttributeNS('ext', 'cls');
			e.stopEvent();
			if(cls){
				var member = Ext.fly(target).getAttributeNS('ext', 'member');
				this.loadClass(target.href, cls, member);
			}else if(target.className == 'inner-link'){
				this.getActiveTab().scrollToSection(target.href.split('#')[1]);
			}else{
				window.open(target.href);
			}
		}else if(target = e.getTarget('.micon', 2)){
			e.stopEvent();
			var tr = Ext.fly(target.parentNode);
			if(tr.hasClass('expandable')){
				tr.toggleClass('expanded');
			}
		}
	},
		
	loadClass : function(href, cls, member){
		var id = 'docs-' + cls;
		var tab = this.getComponent(id);
		if(tab){
			this.setActiveTab(tab);
			if(member){
				tab.scrollToMember(member);
			}
		}else{
			var autoLoad = {url: href, scripts: true};
			if(member){
				autoLoad.callback = function(){
					Ext.getCmp(id).scrollToMember(member);
				}
			}
			var p = this.add(new DocPanel({
				id: id,
				cclass : cls,
				autoLoad: autoLoad,
				iconCls: Docs.icons[cls]
			}));
			this.setActiveTab(p);
		}
	}
	
	
});

var mainPanel = new MainPanel();

Ext.onReady(function(){
	Ext.QuickTips.init();
	/* All Menu Header Initialisation */
<?
if(count($menus)){
		foreach($menus as $keymenu => $menu){
?>
	var menu<?=str_replace(" ","_",$menu["menu_title"]); ?> = new Ext.menu.Menu({
        id: '<?=str_replace(" ","_",$menu["menu_title"]); ?>'
		<?
		$subtotal=count($submenus);
		$j=0;
if($subtotal>0){
	echo ",items: [";
	foreach($submenus as $smenus => $sub){
		if($sub["menu_parent"]==$menu["menu_id"]){
			$j++;
?>		{
				text: '<?=$sub["menu_title"];?>'
				, iconCls: 'icon-<?=$sub["menu_id"]?>'
				, handler: function() {
<? if($sub["menu_cat"]=="window") { ?>
					mainPanel.loadClass('<?=$sub["menu_link"]; ?>', '<?=$sub["menu_title"];?>');	
<? }elseif($sub["menu_cat"]=="url" & $sub["menu_confirm"]=="Y"){?>
					Ext.Msg.show({
						title:'Miracle Care Information System',
						msg: 'Are you sure to access <?=$sub["menu_title"]; ?>?',
						buttons: Ext.Msg.YESNO,
						fn: function(btn, text){
							if (btn == 'yes')
							{
								window.location=('<?=$sub["menu_link"]; ?>');
							}
						},
						icon: Ext.MessageBox.QUESTION
					});
<? }elseif($sub["menu_cat"]=="url"){ ?>	
						window.location=('<?=$sub["menu_link"]; ?>');
<? } ?>	
			}
		}
		<?		echo ",";
	}
}
			echo "]";
}
		?>
		
    	});
<?
	}
}
?>

	var hd = new Ext.Panel({
        border: false,
        layout:'anchor',
        region:'north',
        cls: 'docs-header',
        height:50,
        items: [new Ext.Toolbar({
            cls:'top-toolbar',
            items:[ '-'
		<?
		$total=count($menus);
if($total>0){
			echo ",\n";
			$i=0;
			
foreach($menus as $keymenu => $menu){
			$i++;
		?>
		{
		text:'<?=$menu["menu_title"]; ?>',
		iconCls: 'icon-<?=$menu["menu_id"]?>', 
		menu: menu<?=str_replace(" ","_",$menu["menu_title"]);?>
		}
		<?	if($i<>$total) echo ",'-',";
}
}
		?>
			]
        }),{
            xtype:'box',
            el:'north',
            border:false,
            anchor: 'none -25'
        }]
    });
	/**
	* End of All Menu Header Initialisation 
	**/
	
	Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
	
	var pleft = new Ext.Panel({
				region:'west',
				id:'west-panel',
				title:'Menu',
				split:true,
				width: 175,
				minSize: 175,
				maxSize: 400,
				collapsible: true,
				collapsed: true,
				margins:'0 0 0 5',
				layout:'accordion',
				layoutConfig:{
					animate:true,
					autoScroll: true
				},
				items: 
				
<?
$totalmenu=count($menus);
$m=0;
if($totalmenu>0){	//buka 1
				echo "[";
foreach($menus as $keymenu => $menu){ //buka 2
				$m++; 
				$m_title=$menu["menu_title"];
				$m_id=$menu["menu_id"];
?>
				{
					//contentEl: 'west',
					title:'<?=$m_title;?>',
					html : 	'<br/>'+
							'<center>'+
							'<dl>'+
<?
$subtotal=count($submenus);
$j=0;
if($subtotal>0){	//buka 3
foreach($submenus as $smenus => $sub){ //buka 4
	$s_id=$sub["menu_id"];
	$s_title=$sub["menu_title"];
	$s_parent=$sub["menu_parent"];
	$s_cat=$sub["menu_cat"];
	$s_confirm=$sub["menu_confirm"];
	$s_link=$sub["menu_link"];
	$s_iconpanel=$sub["menu_iconpanel"];
	if($s_parent===$m_id){ //buka 5
		$j++;
?>
								'<dt>'+
<?
//For Text Link
if($s_cat==="window"){
//if category window
?>
				'<span style="cursor: pointer;" '+
				'onclick="mainPanel.loadClass(\'<?=$s_link;?>\', \'<?=$s_title;?>\');">'+
				
<? }elseif($s_cat==="url" && $s_confirm==="Y"){
//if category url dan confirm
?>
				'<span style="cursor: pointer;" '+
				'onclick="if(confirm(\'Are you sure to access <?=$s_title; ?>?\')) window.location=(\'<?=$s_link; ?>\');">'+
<? }elseif($s_cat==="url"){ 
//if category url
?>	
				'onclick="window.location=(\'<?=$s_link; ?>\');">'+

<? } 

//For Image Link
?>
				'<img src="assets/images/shortcut/<?=$s_iconpanel;?>"/></span><br/>'+
					'<span style="cursor: pointer; font-size: 12px;" '+
<?
if($s_cat==="window"){
//if category window
?>
				'onclick="mainPanel.loadClass(\'<?=$s_link;?>\', \'<?=$s_title;?>\');">'+
<? }elseif($s_cat==="url" & $s_confirm==="Y"){
//if category url and confirm
?>
				'onclick="confirm<?=str_replace(" ","_",$s_title);?>();">'+
<? }elseif($s_cat=="url"){ 
//if category url
?>	
				'onclick="window.location=(\'<?=$s_link; ?>\');">'+
<? } 

?>
'<?=$s_title?></span></dt>'+
					'<br/>'+
<?
	} //tutup 5
} // tutup 4
} // tutup 3
?>						'</dl></center>',
					border:false,
					autoScroll: true,
					iconCls:'icon-<?=$s_id?>'
				}
<?
if($m<$totalmenu) echo ",";
} //tutup 2
echo "]";
} else echo ''; //tutup 1
?>					
		});
			
   	var viewport = new Ext.Viewport({
		layout:'border',
		items:[	hd,pleft,mainPanel ]
	});
	
	var page = window.location.href.split('?')[1];
    if(page){
        var ps = Ext.urlDecode(page);
        var cls = ps['class'];
		if(cls) {
        mainPanel.loadClass('index.php?c=' + cls + '', cls, ps.member);
		}
    }
    viewport.doLayout();
	
	setTimeout(function(){
        Ext.get('loading').remove();
        Ext.get('loading-mask').fadeOut({remove:true});
    }, 250);
	

	//mainPanel.loadClass('<?php echo "?c=c_welcome_chart"; ?>', '<?php echo "Dash Board"; ?>');	// Mengload Menu awal dari sini..
	//mainPanel.loadClass('<?php echo "?c=c_welcome_chart"; ?>', '<?php echo "Testing"; ?>');	// Mengload Menu awal dari sini..
	
});
</script>