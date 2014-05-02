<?
//auto_prepend_file = C:\xampp\htdocs\loanit\protect\prepend.php

// stops any attempts to use "HTTP://" or "$_SERVER" in the address bar.
if (preg_match('%(http://)|(_SERVER)%i', $_SERVER["REQUEST_URI"])) 
	{
	$fp=@fopen($_SERVER["DOCUMENT_ROOT"].'/equipment/protect/ban.txt','a');
	fputs($fp,$_SERVER["REMOTE_ADDR"].", ".date('Y-m-d H:i:s').", ".$_SERVER["REQUEST_URI"]."\r\n");
	@fclose($fp);		
	header("HTTP/1.0 404 Not Found");
	exit;
	} //END if (preg_match('%(http://)|(_SERVER)%i', $_SERVER[REQUEST_URI])) 
?>
