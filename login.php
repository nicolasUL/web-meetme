<?php
include ("./lib/defines.php");

ob_start();
require_once('./CAS/CAS.php');

phpCAS::setDebug('/var/www/html/web-meetme/CAS.log');

phpCAS::client(CAS_VERSION_2_0,CAS_SERVER,443,'',false);

if (!isset($_SESSION['authenticated'])) {
	phpCAS::setNoCasServerValidation();
	phpCAS::forceAuthentication();
	$_SESSION['authenticated']=true;
	$_SESSION['login']=phpCAS::getUser();
	$_SESSION['userid']=$_SESSION['login'];
	
}


header("Location:".WEBROOT);
ob_end_flush();
?>
