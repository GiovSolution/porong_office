<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Highcharts lib examples</title>
	<style type="text/css">
		a, a:link, a:visited {
			color: #444;
			text-decoration: none;
		}
		a:hover {
			color: #000;
		}
		.left {
			float: left;
		}
		#menu {
			width: 20%;
		}
		#g_render {
			width: 80%;
		}
		li {
			margin-bottom: 1em;
		}
	</style>
	<!-- <script type="text/javascript" src="http://www.google.com/jsapi"></script>-->
	<script type="text/javascript" src="http://localhost/porong_office/assets/js/jquery-1.6.4.min.js"></script>
	<!-- <script type="text/javascript" src="../../assets/js/jquery-1.5.2.min.js">
		google.load("jquery", "1.4.4");
	</script>-->
	<!--<script type="text/javascript" src="http://www.highcharts.com/js/highcharts.js"></script>-->
    <script type="text/javascript" src="http://localhost/porong_office/assets/js/highcharts.js"></script>
    <!-- <script type="text/javascript" src="http://localhost/porong_office/assets/modules/main/js/exporting.js"></script> -->
</head>
<body>
	<div id="g_render"  class="left">
		<script type="text/javascript">
$(function(){
Highcharts.setOptions({"credits":{"enabled":true,"text":"this page has been viewed for 7 times","href":"#"}});
var chart_1 = new Highcharts.Chart({"series":[{"name":"Medis","data":[]},{"name":"Non Medis","data":[]},{"name":"Surgery","data":[]},{"name":"Anti Aging","data":[]},{"name":"Produk","data":[]},{"name":"Lain-Lain","data":[]},{"name":"Total","data":[]}],"chart":{"renderTo":"hc_chart_1","type":"line","width":1170,"height":380},"title":{"text":"Laporan Net Sales November"},"xAxis":{"categories":[]},"yAxis":{"title":{"text":"Nominal"}}});
});
</script>
<div id="hc_chart_1"></div>
			</div>
</body>
</html>