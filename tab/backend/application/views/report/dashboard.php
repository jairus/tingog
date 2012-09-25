<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
function report(){
	jQuery("#report").html('<img src="/backend/images/loading.gif">');
	jQuery.ajax({
		type: 'POST',
		url: "/backend/report/basic",
		data: "",
		success: function(message){
			jQuery("#report").html(message);
		},
	});
}

</script>
<div id="tabs" style="font: 100% Arial, Helvetica, sans-serif;">
	<ul>
		<li><a href="#report">Report</a></li>
	</ul>
	<div id="report"></div>
	<div id="report_cont"></div>
</div>
<script>
	report();
</script>