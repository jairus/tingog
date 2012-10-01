<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once(dirname(__FILE__)."/includes/head_script.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/styles_1.css" />
<script src="javascripts/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<div id="outer">
	<?php include_once(dirname(__FILE__)."/includes/header_agusandelsur.php"); ?>
    <div id="site_content_1">
    	<?php include_once(dirname(__FILE__)."/includes/left_sidebar_agusandelsur.php"); ?>
        <div id="right_content">
            <p class="text_6" style="padding:20px 0px;">Resources</p>
            <div id="aboutus">
            	<?php if($_GET['resource_id']==1){ ?>
            	<div id="main_resources_video">
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
                <div>
                	<p style="padding-bottom:10px;" class="text_4">Venus Raj, newest ambassador for UN Philippines campaign</p>
                    <p style="text-align:justify;" class="text_3">
                    	Tabaco City, Albay: Along with being the Department of Social Welfare and Development's ambassador for poor children, Venus Raj is also the newest ambassador for TINGOG 2015-a citizens feedback-focused campaign of the United Nations (UN) Philippines launched in Tabaco City, Albay. With the cooperation of the local government and the NGO Social Watch Philippines, the campaign is first ever in the Southeast Asia after India and Kenya (in Africa).<br /><br />


                        TINGOG 2105 is an integrated SMS and online citizen feedback initiative supported by Social Watch Philippines and the United Nations Millennium Campaign (UNMC). The global citizen feedback initiative was a product of the 2010 Millennium Development Goals (MDG) Summit in New York, where world leaders agreed that accelerating achievement of the MDGs required ensuring transparency and accountability, and citizen involvement in social development. The initiative aims to use information and communications technology to empower citizens to report on delivery of services and expect timely response from local governments.<br /><br />
                        
                        Growing up in poor condition, Venus absolutely recognizes the value of this campaign. She emphasized that other important needs of the family can be addressed by the good cause of TINGOG as an efficient medium of communicating health issues and problems.<br /><br />
                        
                        Venus explains in an interview, "Sobrang laking tulong. Kapag magsasaka ka lang and then 'yong asawa mo ay simpleng housewife lang, hindi mo na iisipin 'yong pambitamina ng mga anak mo. Ang iisipin mo, 'yong kakainin nila araw-araw, 'yong basic needs ng mga anak mo. At least kung mayroong mga ganitong proyekto, sila na 'yong sasalo sa mga ganitong pangangailangan."<br /><br />
                        
                        Venus Raj graced the Solidarity Walk as the opening activity of the launch of TINGOG 2015. Participated also by contingents led by Mayor Lagman-Luistro, Board Member Bongao representing Gov. Salceda, the walk symbolized the unity of all the stakeholders that need to work together harmoniously towards the success of TINGOG 2015.<br /><br />
                        
                        Marching to the beat of their own drum and bugle corps, the contingents made up of over 1, 200 participants converged at the Tabaco City Terrace for the launch program. Attendees were organized to form the Philippine flag in the beginning of the program to represent citizenry and national pride as the launch is the first to occur in the entire Southeast Asia.<br /><br />
                        
                        This week is also recognized as the celebration of the UN week. As major focused of the organization to combat poverty by 2015, the MDGs are time-bound, concrete and specific goals that 189 world leaders committed at the United Nations Summit in September 2000. These goals are: 1) end extreme poverty and hunger; 2) achieve universal primary education; 3) promote gender equality and empower women; 4) reduce child mortality; 5) improve maternal health; 6) combat HIV/AIDS, malaria and other diseases; 7) ensure environmental sustainability and 8) develop a global partnership for development. For the Tabaco pilot, however, TINGOG 2015 will focus on delivery of services related to MDGs 4, 5 and 6, specifically on HIV/AIDS.
                    </p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php include_once(dirname(__FILE__)."/includes/footer.php"); ?>
</div>
</body>
</html>