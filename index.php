<?php
include_once('assets/config.php');

$page = @$_GET['page'];
switch ($page) {
	case null:
	case "home":
		$getpage = "pages/home";
		break;
	case "register":
		$getpage = "pages/register";
		break;
	case "downloads":
		$getpage = "pages/downloads";
		break;
	case "chat":
		$getpage = "pages/chat";	
		break;
	case "vote":
		$getpage = "pages/vote";	
		break;
	case "donate":
		$getpage = "pages/donate";	
		break;		
	default:
		$getpage = "pages/home";
		break;
}

include_once('assets/top.php');
include_once($getpage.".php");
include_once('assets/bottom.php');
?>