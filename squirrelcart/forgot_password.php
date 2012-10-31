<?
// purpose of this file is to decide whether or not to call the forgot password function, based on variables passed via a POST or GET
if ($forgot_pw && !$SC[user]) {
	forgot_pw();
}
?>