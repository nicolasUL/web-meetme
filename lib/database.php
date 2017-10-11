<?php
include_once 'MDB2.php';
$database = 'meetme';
$host = 'localhost';
$username = 'root';
$password = '';
$dsn = "mysql://$username:$password@$host/$database";
$db = MDB2::connect($dsn);
if (MDB2::isError($db))
{
        die ($db->getMessage());
}
?>
