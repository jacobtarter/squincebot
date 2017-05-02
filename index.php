<?php include_once("bootstrap.php");
echo date('Y-m-d H:i:s');
$pinNum = $_POST['pinNum'];
$pinMode = $_POST['pinMode'];
$pinOnOrOff = $_POST['pinOnOrOff'];
$DEBUG=false;
if($pinNum && $pinMode)
{
	exec("gpio mode $pinNum $pinMode");
	if($DEBUG)
	{
	print_r($_POST);
	print $pinNum;
	print $pinMode;
	}
}
elseif($pinNum && $pinOnOrOff)
{
	exec("gpio write $pinNum $pinOnOrOff");
	if($DEBUG)
	{
	print_r($_POST);
	print "gpio write $pinNum $pinOnOrOff";
	}

}
elseif($pinNum)
{
	if($DEBUG)
	{
	print $pinNum;
	print "just num";
	print_r($_POST);
	}
}
elseif($pinOnOrOff)
{
	if($DEBUG)
	{
	print $pinOnOrOff;
	print "just on off";
	print_r($_POST);
	}
}
?>
<br />
<br />

<?php $output= shell_exec('gpio readall');
$newoutput = (explode("|",$output)); //index 1-11 are the headers
$checkinput = (explode(" ",$pinOnOrOff));
$checkin = str_split($pinOnOrOff);
if ($DEBUG)
{
print_r($checkin);
print_r($checkinput);
}
//print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
//print "<input type='number' id='pinNum' name='pinNum'>Pin Number (wPi)";
//print "<input type='radio' id = 'pinMode' name='pinMode' value='in'>INPUT \n";
//print "<input type='radio' id = 'pinMode' name='pinMode' value='out'>OUTPUT \n";
//print "<input type='submit' display='Submit'>";
//print "</form>";

//print "<form id='pinSetForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
//print "<input type='number' id='pinNum' name='pinNum'>Pin Number (wPi)";
//print "<input type='radio' id='pinOnOrOff' name='pinOnOrOff' value='1'>ON (1)\n";
//print "<input type='radio' id='pinOnOrOff' name='pinOnOrOff' value='0'>OFF (0)\n";
//print "<input type='submit'>";
//print "</form>";
?>


<?php
$pinValue = array("39"=>"7", "40"=>"7", "63"=>"0 ", "64"=>"0 ", "67"=>"1", "68"=>"1", "75"=>"2", "76"=>"2", "87"=>"3", "88"=>"3", "91=>4", "92"=>"4", "103"=>5, "104"=>5, "127"=>6, "128"=>6, "171"=>"21", "183"=>22, "188"=>26, "195"=>23, "207"=>"24", "212"=>"27", "218"=>"25", "224"=>"11", "236"=>"29" );
$modeIndex = array(39,63,68,75,87,92,104,128,171,183,188,195,207,212,219,224,236);
$inOutIndex = array(40,64,69,76,88,93,105,129,172,184,189,196,208,213,220,225,237);
$index=0;
$line=1;
$gpioData=array();
foreach($newoutput as $value)
{
	if (index > 12)
	{
			if ($line ==1)
			{
				print "start of line <br />";
			}
			print "index: ";
			print "$index <br />";
			print "value: ";
			print "$value <br />";
			print "line: ";
			print "$line <br />";


			if($line == 13)
			{
				print " LINE ------------<br /><br /><br />";
				$line = 0;
			}
			print "<br />";
			$index++;
			$line++;
	}

}
//GPIO table
/*
print "<div class='row'>";
print "<div class='col-sm-6 col-md-5'>";
print "<div class='panel panel-default'>";
print "<div class='panel-heading'>GPIO Pins Info & Status</div>";
print "<div class=;table-responsive'>";
print "<table class='table table-hover'>";
print "<thead>";
print "<tr>";
print "<th>";
print $newoutput[2];
print "</th>";
print "<th>";
print $newoutput[3];
print "</th>";
print "<th>";
print $newoutput[4];
print "</th>";
print "<th>";
print $newoutput[5];
print "</th>";
print "</tr>";
print "<tbody>";
print "<tr>";
print "<td>";
print $newoutput[56];
print "</td>";
print "<td>";
print $newoutput[57];
print "</td>";
print "<td>";
print $newoutput[58];
$md;
if (preg_match("/IN/", $newoutput[58]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[58]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='7'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[59];
$md;
if (preg_match("/1/", $newoutput[59]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[59]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='7'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";
print "<tr>";
print "<td>";
print $newoutput[84];
print "</td>";
print "<td>";
print $newoutput[85];
print "</td>";
print "<td>";
print $newoutput[86];
$md;
if (preg_match("/IN/", $newoutput[86]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[86]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='0 '>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[87];
$md;
if (preg_match("/1/", $newoutput[87]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[87]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='0 '>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[94];
print "</td>";
print "<td>";
print $newoutput[93];
print "</td>";
print "<td>";
print $newoutput[92];
$md;
if (preg_match("/IN/", $newoutput[92]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[92]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='1'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";


print "<td>";
print $newoutput[91];
$md;
if (preg_match("/1/", $newoutput[91]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[91]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='1'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[98];
print "</td>";
print "<td>";
print $newoutput[99];
print "</td>";
print "<td>";
print $newoutput[100];
$md;
if (preg_match("/IN/", $newoutput[100]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[100]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='2'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[101];
$md;
if (preg_match("/1/", $newoutput[101]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[101]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='2'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[112];
print "</td>";
print "<td>";
print $newoutput[113];
print "</td>";
print "<td>";
print $newoutput[114];
$md;
if (preg_match("/IN/", $newoutput[114]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[114]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='3'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[115];
$md;
if (preg_match("/1/", $newoutput[115]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[115]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='3'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[122];
print "</td>";
print "<td>";
print $newoutput[121];
print "</td>";
print "<td>";
print $newoutput[120];
$md;
if (preg_match("/IN/", $newoutput[120]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[120]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='4'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[119];
$md;
if (preg_match("/1/", $newoutput[119]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[119]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='$pinValue[$index]'>";
print "<input type='hidden', name='pinOnOrOff', value='4'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[136];
print "</td>";
print "<td>";
print $newoutput[135];
print "</td>";
print "<td>";
print $newoutput[134];
$md;
if (preg_match("/IN/", $newoutput[134]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[134]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='5'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[133];
$md;
if (preg_match("/1/", $newoutput[133]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[133]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='5'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[164];
print "</td>";
print "<td>";
print $newoutput[163];
print "</td>";
print "<td>";
print $newoutput[162];
$md;
if (preg_match("/IN/", $newoutput[162]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[162]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='6'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[161];
$md;
if (preg_match("/1/", $newoutput[161]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[161]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='6'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[210];
print "</td>";
print "<td>";
print $newoutput[211];
print "</td>";
print "<td>";
print $newoutput[212];
$md;
if (preg_match("/IN/", $newoutput[212]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[212]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='21'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[213];
$md;
if (preg_match("/1/", $newoutput[213]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[213]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='21'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";
print "</tbody>";
print "</table>";
print "</div></div></div></div>";





print "<div class='col-sm-6 col-md-5'>";
print "<div class='panel panel-default'>";
print "<div class='panel-heading'>GPIO Pins Info & Status</div>";
print "<div class=;table-responsive'>";
print "<table class='table table-hover'>";
print "<thead>";
print "<tr>";
print "<th>";
print $newoutput[2];
print "</th>";
print "<th>";
print $newoutput[3];
print "</th>";
print "<th>";
print $newoutput[4];
print "</th>";
print "<th>";
print $newoutput[5];
print "</th>";
print "</tr>";
print "<tbody>";
print "<tr>";
print "<td>";
print $newoutput[224];
print "</td>";
print "<td>";
print $newoutput[225];
print "</td>";
print "<td>";
print $newoutput[226];
$md;
if (preg_match("/IN/", $newoutput[226]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[226]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='22'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[227];
$md;
if (preg_match("/1/", $newoutput[227]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[227]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='22'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[234];
print "</td>";
print "<td>";
print $newoutput[233];
print "</td>";
print "<td>";
print $newoutput[232];
$md;
if (preg_match("/IN/", $newoutput[232]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[232]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='26'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[231];
$md;
if (preg_match("/1/", $newoutput[231]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[231]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='26'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[238];
print "</td>";
print "<td>";
print $newoutput[239];
print "</td>";
print "<td>";
print $newoutput[240];
$md;
if (preg_match("/IN/", $newoutput[240]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[240]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='23'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[241];
$md;
if (preg_match("/1/", $newoutput[241]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[241]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='23'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[252];
print "</td>";
print "<td>";
print $newoutput[253];
print "</td>";
print "<td>";
print $newoutput[254];
$md;
if (preg_match("/IN/", $newoutput[254]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[254]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='24'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[255];
$md;
if (preg_match("/1/", $newoutput[255]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[255]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='24'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[262];
print "</td>";
print "<td>";
print $newoutput[261];
print "</td>";
print "<td>";
print $newoutput[260];
$md;
if (preg_match("/IN/",  $newoutput[260]))
{
	$md = "out";
}
if (preg_match("/OUT/",  $newoutput[260]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='27'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[259];
$md;
if (preg_match("/1/", $newoutput[259]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[259]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='27'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";


print "<tr>";
print "<td>";
print $newoutput[266];
print "</td>";
print "<td>";
print $newoutput[267];
print "</td>";
print "<td>";
print $newoutput[268];
$md;
if (preg_match("/IN/", $newoutput[268]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[268]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='$25'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[269];
$md;
if (preg_match("/1/", $newoutput[269]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[269]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='25'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[276];
print "</td>";
print "<td>";
print $newoutput[275];
print "</td>";
print "<td>";
print $newoutput[274];
$md;
if (preg_match("/IN/", $newoutput[274]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[274]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='28'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[273];
$md;
if (preg_match("/1/", $newoutput[273]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[273]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='28'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

print "<tr>";
print "<td>";
print $newoutput[290];
print "</td>";
print "<td>";
print $newoutput[289];
print "</td>";
print "<td>";
print $newoutput[288];
$md;
if (preg_match("/IN/", $newoutput[288]))
{
	$md = "out";
}
if (preg_match("/OUT/", $newoutput[288]))
{
	$md = "in";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='29'>";
print "<input type='hidden', name='pinMode', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";
print "</td>";
print "<td>";
print $newoutput[287];
$md;
if (preg_match("/1/", $newoutput[287]))
{
	$md = "0 ";
}
if (preg_match("/0/", $newoutput[287]))
{
	$md = "1 ";
}
else {
//								print "value: ";
//								print $value;
}
print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
print "<input type='hidden', name='pinNum', value='29'>";
print "<input type='hidden', name='pinOnOrOff', value='$md'>";
print "<button type='submit' class='btn btn-primary'>";
print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
print "</button>";
print "</form>";

print "</td>";
print "</tr>";

*/



print "</tbody>";
print "</table>";
print "</div></div></div></div></div>";

//GPIO table
print "<div class='row'>";
print "<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>";
print "<div class='panel panel-default'>";
print "<div class='panel-heading'>GPIO Pins Info & Status</div>";
print "<div class=;table-responsive'>";
print "<table class='table table-hover'>";
print "<thead>";
print "<tr>";
//Print out columnn headers
	for($i=1; $i<12; $i++) {
		print "<th>";
		print $newoutput[$i];
		print "</th>";
	}
print "</tr>";
print "</thead>";
print "<tbody>";
$count=0; //used to skip header info
$line=0; //keep track of "column"
$linecount=0; // keep track of "row"
$index=0;
foreach( $newoutput as $value ) {
	if ($count>12 && $linecount<20) //skip the title/header text and stop before footer
	{
		//for each entry we want a new td open/close, and we must start a tr at the beginning of each row and close it at the end of each row
		if ($line==0){
		  print "<tr>";
		  print "<td>";
//			print "index: ";
//			print "$index";
		  print "$value";
//			print "line: ";
//			print "$line";

		  print "</td>";
			$index++;
		  $line++;
		}
		else
		{
			  if($line==3 || $line==4 || $line==8 || $line==9)  //add bold for mode and value entries
				{
				    print "<td>";
//						print "index: ";
//						print "$index";
				    print "<b>";
				    print "$value";
//						print "line: ";
//						print "$line";
			 	    print "</b>";

						if ($index==39 || $index==63 || $index==68 || $index==75 || $index==87 || $index==92 || $index==104 || $index==128 || $index==171 || $index==183 || $index==188 || $index==195 || $index==207 || $index==212 || $index==219 || $index==224 || $index==236)
						{
							$md;
							if (preg_match("/IN/", $value))
							{
								$md = "out";
							}
						  if (preg_match("/OUT/", $value))
							{
								$md = "in";
							}
							else {
//								print "value: ";
//								print $value;
							}
							print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
							print "<input type='hidden', name='pinNum', value='$pinValue[$index]'>";
							print "<input type='hidden', name='pinMode', value='$md'>";
							print "<button type='submit' class='btn btn-primary'>";
							print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
							print "</button>";
							print "</form>";


						}
						if ($index==40 || $index==64 || $index==67 || $index==76 || $index==88 || $index==91 || $index==103 || $index==127 || $index==172 || $index==184 || $index==187 || $index==196 || $index==208 || $index==211 || $index==220 || $index==223 || $index==235)
						{
							$md;
							if (preg_match("/1/", $value))
							{
								$md = "0 ";
							}
						  if (preg_match("/0/", $value))
							{
								$md = "1 ";
							}
							else {
//								print "value: ";
//								print $value;
							}
							print "<form id='pinModeForm' action='$_SERVER[PHP_SELF]' method='post'>\n";
							print "<input type='hidden', name='pinNum', value='$pinValue[$index]'>";
							print "<input type='hidden', name='pinOnOrOff', value='$md'>";
							print "<button type='submit' class='btn btn-primary'>";
							print "<span class='glyphicon glyphicon-off' aria-hidden='true'></span>";
							print "</button>";
							print "</form>";


						}
						    print "</td>";
				    $line++;
						$index++;

			   }
			  elseif($line==5) // start of multi column section, leave td open
				{
				    print "<td>";
//						print "index: ";
//						print "$index";
				    print "$value";
				    print " || ";
//						print "line: ";
//						print "$line";
						$index++;
				    $line++;
			  }
			  elseif($line==6) // middle of multi column
				{
//						print "line: ";
//						print "$line";
						$line++;

				}
			  elseif($line==7) // end multicolumn, close off td
				{
//					print "index: ";
//					print "$index";
			    	print " $value";
//						print "line: ";
//						print "$line";
				    print "</td>";
				    $line++;
						$index++;
			  }
			  elseif ($line==13)  //end of row, no column here, but close the tr
			  {
//					print "line: ";
//					print "$line";
			  		print "</tr>";
		        $line=0;
						$linecount++;
			  }
				else // 2,3,10,11,12 -> the other rows, just open/close td
				{
				print "<td>";
//				print "index: ";
//				print "$index";
				print "$value";
//				print "line: ";
//				print "$line";
				print "</td>";
				   	$line++;
						$index++;
				}
		}

	}
	  $count++;
}

print "</tbody></table></div></div></div></div>";

include_once("bootstrapend.php");
?>
