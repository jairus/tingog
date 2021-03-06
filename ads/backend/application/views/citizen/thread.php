<?php
	#pre($messages);
?>
<style>
.orig_message{
	background-color:#FFF;
	border-bottom:1px solid #e9ffca;
}

.class_1{
	background-color:#f7f7f7;
	border-bottom:1px solid #CCC;
}

.class_2{
	background-color:#FFF;
	border-bottom:1px solid #e9ffca;
}
.internal_message{
	background:#669FFF;
}
.park_message{
	background:#FF3300;	
}
.reply_message{
	background:#66CFFF;
}
.dispatch_message{
	background:#66FFFF;
}

.assign_message{
	background:yellow;
}

.resolve_message{
	background:green;
}
.sms_reply{
	background:#33CC66;
}
.email_reply{
	background:#33CC66;
	
}
.message_from{
	width:150px;
	font-weight:bold;
}
#thethread td{
	vertical-align:top;
	text-align:left;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	padding:20px;
}
</style>
<table width='100%' id='thethread' cellspacing="0">
<tr class='orig_message'>
	<td class='message_from'>
		<?php 
			echo $ticket['name']."<br>";
			if(trim($ticket['email'])){
				echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#666; text-decoration:none;">'.$ticket['email'].'</span>'."<br>";
			}
			if(trim($ticket['number'])){
				echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#900; text-decoration:none;">'.$ticket['number'].'</span>'."<br>";
			}
		?>
		</span>
	</td>
	<td class='message'>
		<?php echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#666; text-decoration:none;">'.$ticket['description'].'</span>'; ?>
	</td>
</tr>
<?php
	#pre($messages);
	if(is_array($messages)){
		$t = count($messages);
		for($i=0; $i<$t; $i++){
			?>
			<tr class="<?php
			if($i%2==0){
				echo 'class_1'; 
			}else{
				echo 'class_2'; 
			}
			?>">
				<td class='message_from'>
					<?php 
						//if from system
						if($messages[$i]['user']){
							echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#666; text-decoration:none;">'.$messages[$i]['user_login'].'</span>'."<br>";
							echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#900; text-decoration:none;">'.$messages[$i]['label'].'</span>';
						}
						//if from reporter
						else{
							echo $ticket['name']."<br>";
							if(trim($ticket['email'])){
								echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#900; text-decoration:none;">'.$ticket['email'].'</span>'."<br>";
							}
							if(trim($ticket['number'])){
								echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#900; text-decoration:none;">'.$ticket['number'].'</span>'."<br>";
							}
						}
					?>
				</td>
				<td class='message'>
					<?php
						echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#666; text-decoration:none;">'.nl2br(htmlentities($messages[$i]['msg'])).'</span>';
					?>
				</td>
			</tr>
			<?php
		}
	}
?>