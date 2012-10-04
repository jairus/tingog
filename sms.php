<?
	function pre($x){
		echo "<pre>";
		if(is_array($x)) print_r($x);
		else echo $x;
		echo "</pre>";
	}
	
	function query_main($query){
		$main = mysql_connect("localhost", "tingog_nmg", "tingognmg") or die("Could not connect : " . mysql_error());
		mysql_select_db("tingog_main",$main);
	
		$result = mysql_query($query) or die("Query failed : " . mysql_error() . "<br>Query: <b>$query</b>");
		return $result;
	}
	
	function query($query){
		$result = mysql_query($query) or die("Query failed : " . mysql_error() . "<br>Query: <b>$query</b>");
		return $result;
	}
	
	function sendSMS($number, $sms, $telco, $tariff, $tid){
		#$sms = substr($sms, 0, 160);
		$sms = urlencode($sms);
		#$url = "";
		#$url = "http://api.clickatell.com/http/sendmsg?user=DirectOpen&password=D0SMS911&api_id=3269103&to=$number$&text=$sms";
		#$url = "http://50.57.48.228/myportal_sms/gateways/sun_message_cast/tingog/outgoing.php?SUB_Mobtel=".$number."&SMS_Message_String=".urlencode($sms);
		$url = "http://74.86.63.102/~txtcircu/sms_out.php?telco=".$telco."&tariff=".$tariff."&SUB_Mobtel=".$number."&SMS_Message_String=".$sms."&CSP_Txid=".$tid."";
		#echo $url;
		#echo "<br>";
		echo "<!-- ".file_get_contents($url)." -->";
	}
	
	function getNameFromNumber($number){
		$name = "";
		return $name;
	}
	
	function createUser($no,$brgy,$name,$age,$gender){
		$result = query("INSERT INTO sms_user(`name`,`mobile`,`barangay`,`age`,`gender`) VALUES('".$name."','".$no."','".$brgy."','".$age."','".$gender."')");
		return true;
	}
	
	function smsOutInfo($number, $rep, $telco, $tariff, $tid, $title){
		pre("<strong>".htmlentities($title)."</strong>");
		pre("Number: ".$number);
		pre("Telco: ".$telco);
		pre("Tariff: ".$tariff);
		pre("Trasaction ID: ".$tid);
		pre("<strong>Message:</strong>");
		pre(htmlentities($rep));
	}
	
	$link = mysql_connect("localhost", "tingog_nmg", "tingognmg") or die("Could not connect : " . mysql_error());
	mysql_select_db("tingog_tabaco",$link);
	
	
	$allow = false;
	$allowed_keywords = array(
		'TINGOG HELP',
		'TINGOG INFO',
		'TINGOG REP',
		'TINGOG ACTION',
		'TINGOG LOCATION',
		'TINGOG REG',
		'TINGOG TAB',
		'TINGOG ADS'
	);
	
	$sms = trim($_GET['SMS_Message_String']);
	$telco = $_GET['telco'];
	$tid = $_GET['CSP_Txid'];
	$number = trim($_GET['SUB_Mobtel']);


	
	/************** jairus **************/
	
	$smstemp = trim(strtolower($sms));
	$smstemp = preg_replace("/\s+/i", " ", $smstemp);


	$municipalities[] = "tab";
	$municipalities[] = "ads";

	//default api
	$url = "http://".$municipalities[0].".tingog.ph/backend/admin/createticket/sms/?".$_SERVER["QUERY_STRING"];

	foreach($municipalities as $municipality){
		if(
			strpos($smstemp, "tingog ".$municipality)!==false
			|| strpos($smstemp, "tingog reg ".$municipality)!==false 
			|| strpos($smstemp, "tingog rep ".$municipality)!==false
			|| strpos($smstemp, "tingog action ".$municipality)!==false
			)
		{
			$url = "http://".$municipality.".tingog.ph/backend/admin/createticket/sms/?".$_SERVER["QUERY_STRING"];
			break;
		}
	}


	
	//echo $url; 
	$handle = fopen(dirname(__FILE__)."/_smslogs/test.txt", "w+");
	fwrite($handle, $url);
	fclose($handle);

	file_get_contents($url);


	exit();

	/************** / jairus **************/
	
	$smstemp = strtolower($sms);
	
	foreach($allowed_keywords as $k=> $v){
		if( (strpos($smstemp, strtolower($v))!==false) && ($v!=='TINGOG') ){
			$allow = true;
		}
	}
	
			if(isset($_GET['SUB_Mobtel']) && isset($_GET['SMS_Message_String']) && isset($_GET['CSP_Txid']) && $allow){
				query("INSERT INTO sms_router(`SUB_Mobtel`,`SMS_Message_String`,`CSP_Txid`,`date`) VALUES('".mysql_escape_string($_GET['SUB_Mobtel'])."','".mysql_escape_string($_GET['SMS_Message_String'])."','".mysql_escape_string($_GET['CSP_Txid'])."',NOW())");
				
				$tingog_url = "http://www.tingog.ph/";
				/*
				TINGOG TAB /<barangay> /<report>
				*/
				if(strpos($smstemp, "tingog tab")!==false){
					$sms = trim($sms);
					$sms = substr($sms,7);
					$smsarr = explode("/", $sms);
					#pre($smsarr[0]);
					if(strtolower($smsarr[0])!='tab'){
						$rep = "Sorry, invalid location. Ito ang mga valid Tingog Locations:

 TAB – Tabaco,
 ADS – Agusan del Sur.

Para magpadala ng report, i-text ang TINGOG <LOCATION> <barangay>/<report>. Ex. TINGOG TAB basud/ walang tao sa opisina. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					
					elseif(!strlen($smsarr[1])){
						$rep = "Sorry, mali ang format na iyong ginamit. Para magpadala ng report, i-text ang TINGOG <LOCATION>/<barangay>/<report >. Ex. TINGOG TAB basud/ maganda ang inyong serbisyo. Ipadala sa 2015. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					else{
						//get name from registered number
						$name = getNameFromNumber($number);
						$array['name'] = $name;
						$array['description'] = trim($smsarr[2]);
						$array['number'] = $number;
						$array['location'] = trim($smsarr[1]);
						$array['source'] = 'SMS';
						query("INSERT INTO tickets(`name`,`description`,`number`,`location`,`source`,`date`) VALUES('".$array['name']."','".$array['description']."','".$array['number']."','".$array['location']."','".$array['source']."',NOW())",$tab);
						$ticketno = mysql_insert_id();
						$ticketno = substr("000000".$ticketno, -6);
						$rep = "Salamat sa iyong report. Ito ay ipaparating sa kinauukulan para sa kanilang aksyon. Tandaan ang iyong report number ".$ticketno.". Makakatanggap ka pa ng mga mensahe tungkol sa iyong report. Maaari ding alamin ang updates sa iyong report sa website ng TINGOG 2015 ".$tingog_url;
					}
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG <LOCATION> /<barangay> /<report>");
				}
				
				elseif(strpos($smstemp, "tingog ads")!==false){
					$sms = trim($sms);
					$sms = substr($sms,7);
					$smsarr = explode("/", $sms);
					#pre($smsarr[0]);
					if(strtolower($smsarr[0])!='ads'){
						$rep = "Sorry, invalid location. Ito ang mga valid Tingog Locations:

 TAB – Tabaco,
 ADS – Agusan del Sur.

Para magpadala ng report, i-text ang TINGOG <LOCATION> <barangay>/<report>. Ex. TINGOG ADS RAWIS/ walang tao sa opisina. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					
					elseif(!strlen($smsarr[1])){
						$rep = "Sorry, mali ang format na iyong ginamit. Para magpadala ng report, i-text ang TINGOG <LOCATION>/<barangay>/<report >. Ex. TINGOG ADS RAWIS/ maganda ang inyong serbisyo. Ipadala sa 2015. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
					}
					else{
						//get name from registered number
						$name = getNameFromNumber($number);
						$array['name'] = $name;
						$array['description'] = trim($smsarr[2]);
						$array['number'] = $number;
						$array['location'] = trim($smsarr[1]);
						$array['source'] = 'SMS';
						query("INSERT INTO tickets(`name`,`description`,`number`,`location`,`source`,`date`) VALUES('".$array['name']."','".$array['description']."','".$array['number']."','".$array['location']."','".$array['source']."',NOW())",$tab);
						$ticketno = mysql_insert_id();
						$ticketno = substr("000000".$ticketno, -6);
						$rep = "Salamat sa iyong report. Ito ay ipaparating sa kinauukulan para sa kanilang aksyon. Tandaan ang iyong report number ".$ticketno.". Makakatanggap ka pa ng mga mensahe tungkol sa iyong report. Maaari ding alamin ang updates sa iyong report sa website ng TINGOG 2015 ".$tingog_url;
					}
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG <LOCATION> /<barangay> /<report>");
				}
				
				//tingog reg
				/*
				TINGOG REG
				*/
				if(strpos($smstemp, "tingog reg")!==false){
					$smsarr = explode("/", $sms);
					if(!trim($smsarr[1]) || !trim($smsarr[2]) || !trim($smsarr[3]) || !trim($smsarr[4])){
						$rep = "Sorry, mali ang format na iyong ginamit sa pag-register. I-text ang TINGOG REG <LOCATION>/<username>/<barangay>/<age>/<gender> Ex. TINGOG REG ADS/mscruz/mapaga/30/F sa 2015. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						sendSMS($number, $rep, $telco, 1, $tid);
						smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG REG");
					}else{
						$check = query("SELECT * FROM sms_user WHERE `mobile`='".$number."'");
						if(mysql_num_rows($check)){
							$rep = "Hi! Ikaw ay naka-register na sa TINGOG 2015. Para makapagpadala ng report, i-txt ang TINGOG <LOCATION>/<barangay>/<report> Ex. TINGOG ADS/mscruz/walang tao sa health center at i-send sa 2015. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
							sendSMS($number, $rep, $telco, 1, $tid);
							smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG REG");
						}else{
							createUser($number, $smsarr[1],$smsarr[2],$smsarr[3],$smsarr[4]);
							$rep = "Maraming salamat sa pag-register sa Tingog. Ang pagbibigay mo ng iyong impormasyon ay makakatulong upang mas mapabuti ang aming serbisyo. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
							sendSMS($number, $rep, $telco, 1, $tid);
							smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG REG");
						}
					}
				}
				
				//tingog help
				/*
				TINGOG HELP
				*/
				else if(strpos($smstemp, "tingog help")!==false){
					$rep = "TINGOG 2015 Keywords:\n";
					$rep .= "TINGOG LOCATION -  para sa listahan ng mga lokasyon at instruction sa pagpapadala ng report\n";
					$rep .= "TINGOG REP - instruction para mag-reply sa 2015\n";
					$rep .= "TINGOG REG - instruction para makapag-register\n";
					$rep .= "TINGOG ON - para makapag-subscribe\n";
					$rep .= "TINGOG OFF - para mag-unsubscribe\n";
					$rep .= "I-send sa 2015. P1.00/txt";
					sendSMS($number, $rep, $telco, 0, $tid);
					smsOutInfo($number, $rep, $telco, 0, $tid, "TINGOG HELP");
				}
				
				//tingog on
				/*
				TINGOG ON
				*/
				else if(strpos($smstemp, "tingog on")!==false){
					$rep = "Hello! Ikaw ay naka-subscribe sa TINGOG 2015. Kung nais mag-unsubscribe, i-text ang TINGOG OFF sa 2015 for free. Para sa ibang keywords i-text ang TINGOG HELP. P1/txt

Para sa iba pang impormasyon, mag-log on sa website ng TINGOG 2015 ".$tingog_url;
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG ON");
				}
				//tingog off
				/*
				TINGOG OFF
				*/
				else if(strpos($smstemp, "tingog off")!==false){
					$rep = "Hello! Ikaw ay hindi naka-subscribe sa TINGOG 2015. Kung nais mong mag-subscribe at makatanggap ng mga advisory, announcement at balita i-text ang TINGOG ON sa 2015 for free. Para sa ibang keywords i-text ang TINGOG HELP. P1/txt

Para sa iba pang impormasyon, mag-log on sa website ng TINGOG 2015 ".$tingog_url;
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG OFF");
				}
				//TINGOG REP 
				/*
				TINGOG REP 
				//TINGOG REP <report#><report code>/<message>
				*/
				else if(strpos($smstemp, "tingog rep")!==false){
					$sms = trim($sms);
					$sms = substr($sms,10);
					$smsarr = explode("/", $sms);
					$id = $smsarr[1];
					$reply = $smsarr[2];
					$check = query("SELECT * FROM tickets WHERE id='".$id."'");
					if(mysql_num_rows($check)){
						if(strlen($reply)){
							query("INSERT INTO  tickets_msg(`tid`,`type`,`msg`,`date`,`smsno`) VALUES('".$id."','Reply Message','".$reply."',NOW(),'".$number."')");
							$rep = "Salamat sa iyong mensahe. Ikaw ay makakatanggap ng sagot mula sa TINGOG 2015 maya-maya lamang. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}else{
							$rep = "Sorry, mali ang format na iyong ginamit. Para mag-reply, i-text ang TINGOG REP<report#><report code>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}
					}else{
						$rep = "Sorry, mali ang report number. I-check ang report number na ibinigay sa iyo.  Para mag-reply, i-text ang TINGOG REP <report code>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						
					}
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG REP");
				}
				//tingog action
				/*
				//TINGOG ACTION <report code>/<message>
				TINGOG ACTION 
				*/
				else if(strpos($smstemp, "tingog action")!==false){
					$sms = trim($sms);
					$sms = substr($sms,13);
					$smsarr = explode("/", $sms);
					$id = $smsarr[1];
					$reply = $smsarr[2];
					$check = query("SELECT * FROM tickets WHERE id='".$id."'");
					if(mysql_num_rows($check)){
						if(strlen($reply)){
							query("INSERT INTO  tickets_msg(`tid`,`type`,`msg`,`date`,`smsno`) VALUES('".$id."','SMS Reply','".$reply."',NOW(),'".$number."')");
							$rep = "Salamat sa iyong pagresponde. Ipaaalam namin agad ang resulta ng estado ng report na naiulat. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}else{
							$rep = "Sorry, mali ang format na iyong ginamit. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG REP <report#><report code>/<message>. Ex. TINGOG REP 12345/ salamat! Para sa listahan ng iba pang keywords, text TINGOG HELP. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
						}
					}else{
						$rep = "Sorry, mali ang report number. I-check ang report number na iyong nais bigyan ng ulat. Para magbigay ulat tungkol sa isang report, i-text ang TINGOG ACTION <report#><report code>/<message>. Ex. TINGOG REP 12345/ salamat! P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free";
						
					}
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG REP");
				}
				/*
				TINGOG LOCATION
				*/
				else if(strpos($smstemp, "tingog location")!==false){
					$rep = "Ito ang mga kasaling Tingog Locations. TAB – Tabaco, ADS – Agusan del Sur. Para magpadala ng report, txt TINGOG <LOCATION>/<barangay>/<report >. Ex. TINGOG TAB/basud/ maganda ang inyong serbisyo. Para sa listahan ng iba pang keywords, text TINGOG HELP. P1/tx";
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "TINGOG LOCATION");
				}
				
				//mysubs
				/*
				MYSUBS
				*/
				else if(strpos($smstemp, "mysubs")!==false){
					$rep = "You are currently subscribed to the ff 2015 services:
TINGOG
To unsubscribe from a service, text <service name> OFF Ex.TINGOG OFF.";
					sendSMS($number, $rep, $telco, 1, $tid);
					smsOutInfo($number, $rep, $telco, 1, $tid, "MYSUBS");
				}
				else{
					$rep = "Welcome sa TINGOG 2015! Para magpadala ng report, i-text ang TINGOG <LOCATION>/<barangay>/<report>. Ex. TINGOG TAB/ basud/ walang tao sa opisina. I-send sa 2015. Para sa listahan ng Tingog location, text TINGOG LOCATION. Para makatanggap ng advisory, announcement at balita mula sa Tingog 2015, reply TINGOG ON. Para sa iba pang keywords, text TINGOG HELP. P1/txt";
					sendSMS($number, $rep, $telco, 0, $tid);
					smsOutInfo($number, $rep, $telco, 0, $tid, "TINGOG");
				}
		}
		elseif(!$allow){
			//tingog
			/*
			TINGOG
			*/
			#pre($smsarr);
			if($smstemp=="tingog"){
				$rep = "Welcome sa TINGOG 2015! Para magpadala ng report, i-text ang TINGOG <LOCATION>/<barangay>/<report>. Ex. TINGOG TAB/ basud/ walang tao sa opisina. I-send sa 2015. Para sa listahan ng Tingog location, text TINGOG LOCATION. Para makatanggap ng advisory, announcement at balita mula sa Tingog 2015, reply TINGOG ON. Para sa iba pang keywords, text TINGOG HELP. P1/txt";
				sendSMS($number, $rep, $telco, 0, $tid);
				smsOutInfo($number, $rep, $telco, 0, $tid, "TINGOG");
			}else{
				$rep = "Sorry, invalid location. Ito ang mga valid Tingog Locations:

 TAB – Tabaco,
 ADS – Agusan del Sur.

Para magpadala ng report, i-text ang TINGOG <LOCATION> <barangay>/<report>. Ex. TINGOG TAB basud/ walang tao sa opisina. P1/txt.

Para sa listahan ng keywords, i-text ang TINGOG sa 2015 for free.";
				sendSMS($number, $rep, $telco, 1, $tid);
				smsOutInfo($number, $rep, $telco, 1, $tid, "INVALID LOCATION");
			}
		}
		/*else{
			$rep = "Welcome sa TINGOG 2015! Ipadinig ang boses sa kinauukulan!
List of keywords:
TINGOG REG <LOCATION>/<username>/<barangay>/
<age>/ <gender> - para makapag-register
TINGOG <LOCATION>/<barangay>/<report>- para magpadala ng report. 
TINGOG REP <report#><report code>/<message>-para mag-reply o mag follow-up sa report
TINGOG LOCATION -  para sa listahan ng mga lokasyon

I-text <keyword> at i-send sa 2015. P1/txt.";
			sendSMS($number, $rep, $telco, 0, $tid);
			smsOutInfo($number, $rep, $telco, 0, $tid, "INVALID KEYWORD: NO ROUTE");
		}*/
	#pre(htmlentities($rep));
	mysql_close($link);
?>