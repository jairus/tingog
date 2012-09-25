<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Status Reports</title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});

google.setOnLoadCallback(drawChart1);
function drawChart1() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Day');
	data.addColumn('number', 'Share of positive feedback vs actionable reports');
	data.addColumn('number', 'Share of reports among concerned offices');
	data.addColumn('number', 'Share of reports among barangays');
	data.addColumn('number', 'Share of unresolved reports among concerned offices');
	data.addColumn('number', 'Share of unresolved reports across barangays');
	data.addColumn('number', 'Share of resolved reports among concerned offices');
	data.addColumn('number', 'Share of resolved reports across barangays');
	data.addRows([
		['Sun', 11, 2, 2, 2, 2, 2, 100],
		['Mon', 100000, 40, 50000, 200000, 40, 50000, 100],
		['Tue', 5398, 3432, 3432, 234, 3432, 3432, 100],
		['Wed', 9865, 43211, 1234, 23432, 43211, 1234, 100],
		['Thu', 11, 2, 2, 2, 100000, 2, 100],
		['Fri', 11, 2, 2, 2, 2, 2, 50000],
		['Sat', 11, 2, 2, 2, 2, 2, 2000]
	]);
	
	var options = {
		title: 'Share Report(s)'
	};
	
	var chart = new google.visualization.LineChart(document.getElementById('div_statusofreports_sharesline'));
	chart.draw(data, options);
}

google.setOnLoadCallback(drawChart2);
function drawChart2() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Task');
	data.addColumn('number', 'Share Reports');
	data.addRows([
		['Share of positive feedback vs actionable reports',    25],
		['Share of reports among concerned offices',            25],
		['Share of reports among barangays',                    10],
		['Share of unresolved reports among concerned offices', 10],
		['Share of unresolved reports across barangays',        10],
		['Share of resolved reports among concerned offices',   10],
		['Share of resolved reports across barangays',          10]
	]);
	
	var options = {
		title: 'Share Report(s)'
	};
	
	var chart = new google.visualization.PieChart(document.getElementById('div_statusofreports_sharespie'));
	chart.draw(data, options);
}
</script>
</head>

<body>
<div style="width:900px; height:auto; float:left;">
    <div id="div_statusofreports_sharesline" style="width:900px; height:300px; float:left;"></div>
</div>
<div style="width:900px; height:auto; float:left;">
    <div id="div_statusofreports_sharespie" style="width:900px; height:300px; float:left;"></div>
</div>
</body>
</html>