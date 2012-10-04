<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
<style type="text/css">
html, body, #mapdiv {
	width:100%;
	height:100%;
	margin:0;
	font-family:verdana;
	font-size:11px;
}
</style>
</head>

<body>
<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header.php"); ?>
    <div id="site_content_1">
    	<?php include_once(dirname(__FILE__)."/includes/left_sidebar.php"); ?>
        <div id="right_content">
            <p class="text_6" style="padding:20px 0px;">Issue Tracking</p>
            <div id="index_issuemaptracking_map">
                <div id="mapdiv"></div>
                <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
                <script>
                map = new OpenLayers.Map("mapdiv");
                map.addLayer(new OpenLayers.Layer.OSM());
                
                epsg4326 =  new OpenLayers.Projection("EPSG:4326");
                projectTo = map.getProjectionObject();
                
                var lonLat = new OpenLayers.LonLat( 125.16, 6.09421 ).transform(epsg4326, projectTo);
                
                var zoom = 14;
                map.setCenter (lonLat, zoom);
                
                var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
                
                //ICONS
                var feature = new OpenLayers.Feature.Vector(
                    new OpenLayers.Geometry.Point( 125.16, 6.09421 ).transform(epsg4326, projectTo),
                    {description: "bubble goes here"} ,
                    {externalGraphic: 'images/icon_location.png', graphicHeight: 15, graphicWidth: 12, graphicXOffset:-12, graphicYOffset:-25  }
                );    
                vectorLayer.addFeatures(feature);
                //END OF ICONS
                
                map.addLayer(vectorLayer);
                
                var controls = {
                    selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
                };
                
                function createPopup(feature) {
                    feature.popup = new OpenLayers.Popup.FramedCloud("pop",
                        feature.geometry.getBounds().getCenterLonLat(),
                        null,
                        '<div class="markerContent">'+feature.attributes.description+'</div>',
                        null,
                        true,
                        function() { controls['selector'].unselectAll(); }
                    );
                    
                    map.addPopup(feature.popup);
                }
                
                function destroyPopup(feature) {
                    feature.popup.destroy();
                    feature.popup = null;
                }
                
                map.addControl(controls['selector']);
                controls['selector'].activate();
                </script>
            </div>
            <div id="index_issuemaptracking_btn"><a href="mainsubmitreport.php"><img src="images/buttons/index_submit_report.jpg" width="122" height="33" border="0" alt="Submit Report" title="Submit Report" /></a> <a href="mainmyreports.php"><img src="images/buttons/index_track_report.jpg" width="145" height="33" border="0" alt="Track My Report" title="Track My Report" /></a></div>
        </div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>