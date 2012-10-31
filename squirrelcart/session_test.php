<?
 session_save_path("/home/users/web/b1461/ipw.sportsin/phpsessions");
session_start();
session_register("SESSION");

if (! isset($SC)) {
	$SC["count"] = 0;
	echo "<li>Counter initialized, please reload this page to see it increment";
} else {
	echo "<li>Waking up session $PHPSESSID";
	$SC["count"]++;
}
echo "<li>The counter is now $SC[count] ";
?>