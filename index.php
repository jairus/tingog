<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="javascripts/jquery.js"></script>
<style type="text/css">
html, body, #mapdiv {
	width:100%;
	height:100%;
	margin:0;
	font-family:verdana;
	font-size:11px;
}
</style>
<script type="text/javascript">
function getFullList(action){
	if(action=="open"){
		jQuery('#keywords').show();
	}else if(action=="close"){
		jQuery('#keywords').hide();
	}
}
</script>
</head>

<body>
<!-- FULL LIST KEYWORDS -->
<center>
<table width="100%" height="1750" id="keywords" style="display:none; position:absolute; top:0; left:0; z-index:10000; background-image:url(images/overlay.png);">
    <tr>
        <td>
        	<div id="keyword_bg">
            	<div id="keyword_corners"><img src="images/top_left.png" border="0" /></div>
                <div id="keyword_top"></div>
                <div id="keyword_corners"><img src="images/top_right.png" border="0" /></div>
                <div id="keyword_content" class="text_17">
                	<p style="text-align:right;"><img src="images/btn_close.jpg" border="0" alt="Close" title="Close" onclick="getFullList('close');" style="cursor:pointer;" /></p>
                    <div style="padding:0px 20px 20px;">
                    	<p style="padding-bottom:20px;" class="text_18"><b>Welcome</b></p>
                        <p style="padding-bottom:20px;" class="text_19">To get started</p>
                        <p style="text-indent:20px;">Text TINGOG to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a welcome message and instructions on how to send reports, subscribe to alerts, and receive a list of valid keywords.</p>
                        <p style="padding-bottom:20px;" class="text_19">To receive a list of valid keywords</p>
                        <p style="text-indent:20px;">Text TINGOG HELP to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a list of valid keywords for TINGOG 2015 SMS reporting service.</p>
                        <p style="padding-bottom:20px;" class="text_19">To receive a list of TINGOG locations</p>
                        <p style="text-indent:20px;">Text TINGOG LOCATION to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a list of participating TINGOG locations.</p>
                        <p style="padding-bottom:20px;" class="text_18"><b>Registration</b></p>
                        <p style="padding-bottom:20px;" class="text_19">To receive instructions on how to register</p>
                        <p style="text-indent:20px;">Text TINGOG REG to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive instructions on how to register to TINGOG 2015 SMS reporting service.</p>
                        <p style="padding-bottom:20px;" class="text_19">To register</p>
                        <p style="text-indent:20px;">Text TINGOG REG &lt;LOCATION&gt;/&lt;barangay&gt;/&lt;name&gt;/&lt;age&gt;/&lt;gender&gt; and send to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a confirmation message upon successful registration.</p>
                        <p style="padding-bottom:20px;" class="text_18"><b>Reporting</b></p>
                        <p style="padding-bottom:20px;" class="text_19">To send report</p>
                        <p style="text-indent:20px;">Text TINGOG &lt;LOCATION&gt;/&lt;BARANGAY&gt;/&lt;REPORT&gt; and send to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive an auto-acknowledgment containing your report number once your message is received by the system. Keep the report number for updates and further instructions on your report.</p>
                        <p style="padding-bottom:20px;" class="text_19">To receive instructions on how to send confirmation/feedback/more information on the report</p>
                        <p style="text-indent:20px;">Text TINGOG REP to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive instructions on how to send confirmation, feedback, and/or more information on the report.</p>
                        <p style="padding-bottom:20px;" class="text_19">To send confirmation/feedback/more information on the report</p>
                        <p style="text-indent:20px;">Text TINGOG REP &lt;report#&gt;/&lt;message&gt; and send to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a confirmation message on your report.</p>
                        <!--<p style="padding-bottom:20px;" class="text_18"><b>Subscription</b></p>
                        <p style="padding-bottom:20px;" class="text_19">To subscribe to TINGOG 2015 weekly alerts</p>
                        <p style="text-indent:20px;">Text TINGOG ON to 2015. (P1/txt)</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a confirmation of your subscription to TINGOG 2015 news, advisories, updates, and announcements.</p>
                        <p style="padding-bottom:20px;" class="text_19">To unsubscribe to TINGOG 2015 weekly alerts</p>
                        <p style="text-indent:20px;">Text TINGOG OFF to 2015 for free.</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive a confirmation of your request to unsubscribe to TINGOG 2015 news, advisories, updates, and announcements.</p>
                        <p style="padding-bottom:20px;" class="text_19">To check current subscription</p>
                        <p style="text-indent:20px;">Text MYSUBS to 2015 for free.</p>
                        <p style="padding-bottom:20px; text-indent:20px;">You will receive your current subscription status to TINGOG 2015.</p>-->
                    </div>
                </div>
                <div id="keyword_corners"><img src="images/bottom_left.png" border="0" /></div>
                <div id="keyword_bottom"></div>
                <div id="keyword_corners"><img src="images/bottom_right.png" border="0" /></div>
            </div>
        </td>
    </tr>
</table>
</center>
<!-- END OF FULL LIST KEYWORDS -->

<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header.php"); ?>
    <div id="site_content_1">
    	<?php include_once(dirname(__FILE__)."/includes/left_sidebar.php"); ?>
        <div id="right_content">
        	<div id="index_aboutus">
            	<div id="index_aboutus_title" class="text_5">CITIZEN ACTION FOR GOVERNANCE</div>
                <div id="index_aboutus_text" class="text_7">
                	<p class="text_6" style="padding-bottom:15px;">Tingog is a Citizens' Feedback Platform</p>
                    <p style="padding-bottom:15px;">that aims to ensure service delivery, especially in the achievement of the Millennium Development Goals (MDG) at the grassroots, by allowing citizens to report on, monitor, and send feedback on government services through the use of SMS and the Internet.</p>
                    <p>The initiative is named after the Bicolano and Cebuano word for "voice," to emphasize the objective of empowering ordinary citizens with a voice in the development process. "2015" refers to the short code to which citizens can send their text messages, as well as the year by which the MDGs should be achieved.</p>
                </div>
                <div id="index_aboutus_img"><img src="images/aboutus.jpg" width="300" height="221" border="0" alt="Tingog is a Citizens' Feedback Platform" title="Tingog is a Citizens' Feedback Platform" /></div>
            </div>
            <div id="index_howtoissue">
            	<div id="index_howtoissue_title" class="text_8">HOW TO ISSUE A REPORT</div>
                <div id="index_howtoissue_description" class="text_7">You can now evaluate the quality of government service delivery in your community. Speak out and make your voice heard by reporting a concern or sending feedback.</div>
                <div id="index_howtoissue_steps_img">
                    <div style="padding-bottom:9px;"><img src="images/howtoissue_step1.png" width="183" height="110" border="0" alt="See" title="See" /></div>
                    <div style="padding-bottom:9px;"><img src="images/howtoissue_step2.png" width="183" height="110" border="0" alt="Report" title="Report" /></div>
                    <div><img src="images/howtoissue_step3.png" width="186" height="53" border="0" alt="Respond" title="Respond" /></div>
                </div>
                <div id="index_howtoissue_steps_text">
                	<p class="text_9" style="padding-bottom:10px;">&raquo; VIA WEB</p>
                    <p class="text_7" style="padding:0px 0px 10px 15px;">Select a city from the drop-down menu. You will be redirected to the subdomain of the locality you are in.</p>
                    <p class="text_9" style="padding-bottom:10px;">&raquo; VIA SMS</p>
                    <p class="text_7" style="padding:0px 0px 10px 15px;">Text <span class="text_10">TINGOG &lt;LOCATION&gt;/&lt;BARANGAY&gt;/&lt;REPORT&gt;</span> and send to <span class="text_10">2015</span>.</p>
                    <p class="text_11" style="padding:0px 0px 10px 15px;">Click <a style="cursor:pointer;" onclick="getFullList('open');" class="link_4">here</a> to see full list of keywords.</p>
                    <p class="text_11" style="padding-left:15px;">*disclosure of name is optional</p>
                    <p class="text_11" style="padding-left:15px;">*open to <b>Smart, Talk&amp;Text, Globe, Touch Mobile, Sun</b> subscribers</p>
                    <p class="text_11" style="padding:0px 0px 5px 15px;">*SMS are subject to ₱1 charging</p>
                    <p class="text_11" style="padding-left:15px;">You will receive an auto-acknowledgment once your message is received by the system.</p>
                </div>
                <div id="index_howtoissue_cellphone_img"><img src="images/howtoissue_cellphone.png" width="163" height="292" border="0" alt="HOW TO ISSUE A REPORT" title="HOW TO ISSUE A REPORT" /></div>
            </div>
            <div id="index_issuemaptracking">
            	<div id="index_howtoissue_title" class="text_8">ISSUE MAP TRACKING</div>
                <div id="index_issuemaptracking_map">
                	<?php
					function std2arr($obj){
						$s = serialize($obj);
						$s = str_replace('O:8:"stdClass"', 'a', $s);
						return unserialize($s);
					}
					
					include('includes/Snoopy.class.php');
					
					$snoopy = new Snoopy();

					$snoopy->httpmethod = "GET";
					$snoopy->submit("http://tingog2015.nmgdev.com/ticket/barangay");
					
					$contents = $snoopy->results;
					$contents = std2arr(json_decode($contents));
					
					$contentarr = array();
					foreach($contents as $k=>$v){
						$print = array();
						
						$xstring = "<table width='300' border='0' cellspacing='0' cellpadding='0' style='font-family:verdana; font-size:11px;'>
						  <tr>
							<td width='110'><b>Location Name</b></td>
							<td>: ".$v['name']."</td>
						  </tr>
						  <tr>
							<td colspan='2'>&nbsp;</td>
						  </tr>
						  <tr bgcolor='#f6f6f6'>
							<td><div style='padding:5px;'><b>Total</b></div></td>
							<td>: ".$v['total']."</td>
						  </tr>
						</table>";
						
						$xstring = str_replace("\n", "", $xstring);
						$xstring = str_replace("\r", "", $xstring);
						
						$print['lat']     = $v['lat'];
						$print['lng']     = $v['long'];
						$print['total']   = $v['total'];
						$print['xstring'] = $xstring;
						
						$contentarr[] = $print;
					}
					?>
                    <div id="mapdiv"></div>
					<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
                    <script>
                    map = new OpenLayers.Map("mapdiv");
                    map.addLayer(new OpenLayers.Layer.OSM());
                    
                    epsg4326 =  new OpenLayers.Projection("EPSG:4326");
                    projectTo = map.getProjectionObject();
                    
                    var lonLat = new OpenLayers.LonLat( <?php echo $contentarr[0]['lng']; ?>, <?php echo $contentarr[0]['lat']; ?> ).transform(epsg4326, projectTo);
                    
                    var zoom = 14;
                    map.setCenter (lonLat, zoom);
                    
                    var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
                    
					<?php
					$t = count($contentarr);
					
					if($t){
						for($i=0;$i<$t;$i++){
					?>
					//ICONS
                    var feature = new OpenLayers.Feature.Vector(
                        new OpenLayers.Geometry.Point( <?php echo $contentarr[$i]['lng']; ?>, <?php echo $contentarr[$i]['lat']; ?> ).transform(epsg4326, projectTo),
                        {description: "<?php echo $contentarr[$i]['xstring']; ?>"} ,
                        {externalGraphic: 'images/map_markers/<?php echo $contentarr[$i]['total']; ?>.png', graphicHeight: 63, graphicWidth: 50, graphicXOffset:-12, graphicYOffset:-25 }
                    ); 
                    vectorLayer.addFeatures(feature);
					//END OF ICONS
					<?php
						}
					}
					?>
                    
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
            <div id="index_news">
            	<div id="index_newsandresources_title" class="text_8">NEWS</div>
                <div id="index_news_article">
                	<p><a href="newsfullarticle.php?news_id=1" class="link_1">Venus Raj speaks out for poor children, MDGs</a></p>
                    <p class="text_12" style="padding-bottom:5px;">November 8, 2011</p>
                    <p class="text_7">MANILA, Philippines - Along with being the DSWD's ambassador for poor children, Venus Raj is also...</p>
                </div>
                <div id="index_news_article">
                	<p><a href="newsfullarticle.php?news_id=2" class="link_1">Venus Raj, newest ambassador for UN Philippines campaign </a></p>
                    <p class="text_12" style="padding-bottom:5px;">November 09, 2011</p>
                    <p class="text_7">Tabaco City, Albay: Along with being the Department of Social Welfare and Development's ambassador...</p>
                </div>
                <div id="index_news_article">
                	<p><a href="newsfullarticle.php?news_id=3" class="link_1">Your voice can now be heard </a></p>
                    <p class="text_12" style="padding-bottom:5px;">October 23, 2011</p>
                    <p class="text_7">I'm honored to be the spokesperson for Tingog 2015, a program that aims to improve government services in...</p>
                </div>
                <!--<div id="index_news_article">
                	<p><a href="newsfullarticle.php?news_id=4" class="link_1">Venus Raj is spokesperson for UN program</a></p>
                    <p class="text_12" style="padding-bottom:5px;">October 19, 2011</p>
                    <p class="text_7">MANILA, Philippines - Miss Universe 2010 fourth runner-up Venus Raj was chosen to be the spokesperson....</p>
                </div>
                <div id="index_news_article">
                	<p><a href="newsfullarticle.php?news_id=5" class="link_1">Bicol town taps online, SMS tools for feedback</a></p>
                    <p class="text_12" style="padding-bottom:5px;">October 21, 2011</p>
                    <p class="text_7">The city of Tabaco in Albay recently unveiled a SMS and online citizen feedback initiative that allow citizens....</p>
                </div>
                <div id="index_news_article">
                	<p><a href="newsfullarticle.php?news_id=6" class="link_1">Venus Raj Newest Ambassador for UN Philippines TINGOG 2015 Campaign</a></p>
                    <p class="text_12" style="padding-bottom:5px;">October 26, 2011</p>
                    <p class="text_7">Miss Universe 2010 4th runner-up Venus Raj joins hands with United Nations Philippines as she becomes the newest....</p>
                </div>-->
            </div>
            <div id="index_resources">
            	<div id="index_newsandresources_title" class="text_8">RESOURCES</div>
                <div id="index_resources_video">
                	<script src="javascripts/AC_RunActiveContent.js" language="javascript"></script>
               		<script language="javascript">
						if (AC_FL_RunContent == 0) {
							alert("This page requires AC_RunActiveContent.js.");
						} else {
							AC_FL_RunContent(
								'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
								'width', '205',
								'height', '200',
								'src', 'video_player',
								'quality', 'high',
								'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
								'align', 'middle',
								'play', 'true',
								'loop', 'true',
								'scale', 'showall',
								'wmode', 'transparent',
								'devicefont', 'false',
								'id', 'video_player',
								'bgcolor', '#ffffff',
								'name', 'video_player',
								'menu', 'true',
								'allowFullScreen', 'false',
								'allowScriptAccess','sameDomain',
								'movie', 'flash/video_player?video=../videos/UN_Footage.flv',
								'salign', ''
								);
						}
					</script>
					<noscript>
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="205" height="200" id="video_player" align="middle">
						<param name="allowScriptAccess" value="sameDomain" />
						<param name="allowFullScreen" value="false" />
						<param name="movie" value="flash/video_player.swf?video=../videos/UN_Footage.flv" />
						<param name="quality" value="high" />
						<param name="bgcolor" value="#ffffff" />
						<embed src="flash/video_player.swf?video=../videos/UN_Footage.flv" quality="high" bgcolor="#ffffff" width="205" height="200" name="video_player" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
						</object>
					</noscript>
                </div>
                <div id="index_resources_textandbtn">
                	<p class="text_7" style="padding-bottom:15px;">Venus Raj, newest ambassador for UN Philippines campaign</p>
                    <p><a href="resourcesfullarticle.php?resource_id=1"><img src="images/buttons/index_learn_more.jpg" width="122" height="33" border="0" alt="Learn More" title="Learn More" /></a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>