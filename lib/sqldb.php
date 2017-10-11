<?php

function authsql ($user, $password)
{

	global $db;

	$xuser = strtolower($user);
	$data = array( $xuser, $password);
	$query = "SELECT id, admin FROM user WHERE email='$xuser' AND password='$password'";
        $result = $db->query($query);
	if($result->numRows())
	{
		$row = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
		$_SESSION['privilege'] = $row['admin'];
	        return $row['id'];
	}
	else
	{
	        return false;
	}
}
?>
