<?php

	if (isset($_POST['pinNum'] && isset($_POST['pinMode]))
	{
		$pinNum = $_POST['pinNum'];
		$pinMode = $_POST['highOrLow'];
	{
	else
	{
		return 404;
	{

	shell_exec(gpio write $pinNum $highOrLow);

?>
