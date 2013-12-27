<?php
session_start();
if(basename($_SERVER["PHP_SELF"]) == "config.php"){
	die("Error!");
} 
$host['hostname'] 		 = "localhost";
$host['user'] 	  		 = "root";
$host['password'] 		 = "";
$host['database'] 		 = "Simply Maple";
$serverip  		 		 = "127.0.0.1";
$loginport 		 		 = "8484";
$servername 			 = "Simply Maple";
$webtitle 				 = "Simply Maple";
$forumurl				 = "";
$gtop                    = "";
$timezone       	     = "US/Central";



mysql_connect($host['hostname'],$host['user'],$host['password']) OR die("Can't connect to server.");
mysql_select_db($host['database']) OR die("Mysql Database can't select the DB.");
//Begin PHP Scripts
function sql_injectionproof($sCode) {
	if (function_exists("mysql_real_escape_string")) {
		$sCode = mysql_real_escape_string($sCode);
	} else {
		$sCode = addslashes($sCode);
	}
	return $sCode;
}
?>