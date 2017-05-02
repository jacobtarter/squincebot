<?php include_once("index.php");

		$pinNum = $_POST['pinNum'];
		$pinMode = $_POST['pinMode'];

	shell_exec("gpio mode $pinNum $pinMode");
	print_r($_POST);
	print $pinNum;
	print $pinMode;


?>
