<?php
	include ("./lib/database.php");
	include ("./lib/functions.php");
	include ("./lib/defines.php");
	$bookId = $_POST['bookId'];
	$message = $_POST['body'];
	if (!isset($confDesc)) $confDesc = "";
	$local_phone = LOCAL_PHONE;
	$local_support = LOCAL_SUPPORT;
	$srv_phone = PHONENUM;

	$query = "SELECT confDesc, confOwner, confno, pin, adminpin, starttime, endtime, b.adminopts, maxUser, u.first_name AS ofn, u.last_name AS oln, u.email AS oem FROM booking b, user u WHERE bookid = '$bookId' AND b.clientId = u.id";
	$result=$db->query($query);
       	$row = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	extract($row);
	$starttime = strtotime($starttime);
	$endtime = strtotime($endtime);
	if (use24h()) {
         	$starttime = litteral_day(date("l", $starttime)).date(" d/m/Y H:i:s", $starttime);
         	$endtime = litteral_day(date("l", $endtime)).date(" d/m/Y H:i:s", $endtime);
	} else {
		$starttime = date("l M d, Y h:i:s A", $starttime);
		$endtime = date("l M d, Y h:i:s A", $endtime);
	}

	$admpwline = _("Admin Password").":  $adminpin\n";
	$msg_body = "$ofn $oln "._("has invited you to the following conference call").":\n\n";
	$msg_body .= _("Conference Name").":  $confdesc \n";
	$msg_body .= _("Conference Number").":  $confno\n";
	$msg_body .= $admpwline;
	$msg_body .= _("Conference Password").":  $pin\n";
	$msg_body .= _("Start Date and Time").":  $starttime\n";
	$msg_body .= _("End Date and Time").":  $endtime\n";
	$msg_body .= _("Participants").":  $maxuser\n";
	$msg_body .= "--------------------------------------------------\n";
	$msg_body .= _("Dial In Info")." :\n\n";
	$msg_body .= _("You will then prompted for the conference and pin numbers")."\n";
	if(strchr($adminopts,"r"))
	{
		$msg_body .= _("This conference will be recorded. After the conference is complete").",\n";
		$msg_body .= _("you may listen to the recording by").":\n\n";
		$msg_body .= _("Click").WEBROOT."listen.php?confno=$confno&pin=$pin \n";
		$msg_body .= "\n\n";
	}
	$msg_body .= _("The conference call can be accessed by calling")." $srv_phone.  \n";
	$msg_body .= _("Please contact")." $local_support "._("at")." $local_phone "._("for assistance").". \n\n";
	$msg_body .= $message;
	$recipient = "\"$ofn $ofn\" <$oem>";
	mail($recipient, _("Administrator").": $confdesc", $msg_body,"From: $oem\r\n");

	$msg_body = str_replace($admpwline, "", $msg_body);
	$query = "SELECT u.first_name, u.last_name, u.email, u.telephone FROM user u, participants p
		WHERE u.id = p.user_id AND p.book_id = '$bookId'";
	$result=$db->query($query);
       	while($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
       	{
		extract($row);
		$recipient = "\"$first_name $last_name\" <$email>";
		mail($recipient, _("Conference Call").": $confdesc", $msg_body,"From: $oem\r\n");
	}
	echo "<p>"._("The following message has been sent to all invited participants")."</p>";
	echo "<pre>$msg_body</pre>";
?>
