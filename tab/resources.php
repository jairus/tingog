<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header_tabaco.php"); ?>
    <div id="site_content_1">
    	<?php include_once(dirname(__FILE__)."/includes/left_sidebar_tabaco.php"); ?>
        <div id="right_content">
            <p class="text_6" style="padding:20px 0px;">Resources</p>
            <div id="main_resources_box">
                <div id="sub_aboutus" style="text-align:center;">
                	<p style="padding-bottom:10px;">
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
                    </p>
                    <p style="padding:0px 10px 3px; text-align:left;"><a href="resourcesfullarticle.php?resource_id=1" class="link_3">Venus Raj, newest ambassador for UN Philippines campaign</a></p>
                    <p style="padding:0px 10px 0px; text-align:left;" class="text_3">Tabaco City, Albay: Along with being the Department of Social Welfare and Development's ambassador for...</p>
                </div>
                <!--<div id="sub_message" style="text-align:center;">
                	<p style="padding-bottom:10px;"><iframe width="350" height="250" src="http://www.youtube.com/embed/Dh2u9hpBEio?wmode=transparent" frameborder="0" allowfullscreen></iframe></p>
                    <p style="padding:0px 10px 3px; text-align:left;"><a href="mainresourcesfullarticle.php" class="link_3">Resource 2</a></p>
                    <p style="padding:0px 10px 0px; text-align:left;" class="text_3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu turpis lectus, sed tincidunt nulla. Sed vel orci...</p>
                </div>-->
            </div>
            <!--<div id="main_resources_box">
                <div id="sub_aboutus" style="text-align:center;">
                	<p style="padding-bottom:10px;"><iframe width="350" height="250" src="http://www.youtube.com/embed/Dh2u9hpBEio?wmode=transparent" frameborder="0" allowfullscreen></iframe></p>
                    <p style="padding:0px 10px 3px; text-align:left;"><a href="mainresourcesfullarticle.php" class="link_3">Resource 3</a></p>
                    <p style="padding:0px 10px 0px; text-align:left;" class="text_3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu turpis lectus, sed tincidunt nulla. Sed vel orci...</p>
                </div>
                <div id="sub_message" style="text-align:center;">
                	<p style="padding-bottom:10px;"><iframe width="350" height="250" src="http://www.youtube.com/embed/Dh2u9hpBEio?wmode=transparent" frameborder="0" allowfullscreen></iframe></p>
                    <p style="padding:0px 10px 3px; text-align:left;"><a href="mainresourcesfullarticle.php" class="link_3">Resource 4</a></p>
                    <p style="padding:0px 10px 0px; text-align:left;" class="text_3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu turpis lectus, sed tincidunt nulla. Sed vel orci...</p>
                </div>
            </div>-->
        </div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>