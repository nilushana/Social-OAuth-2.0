<?php
	session_start();
	session_unset();
	session_destroy();
	unset($_COOKIE['session_cookie']);


	setcookie('PHPSESSID', '', time() - 3600, '/');
    setcookie('session_cookie', '', time() - 3600, '/');
    setcookie('csrf_token', '', time() - 3600, '/','www.assignment02.com',true);
    setcookie('profile', '', time() - 3600, '/','www.assignment03.com',true);
	header("Location:index.php");
   	exit;


?>
