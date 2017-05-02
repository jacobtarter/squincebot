<?php
$output= shell_exec('gpio readall');
$newoutput = (explode("|",$output));
print_r($newoutput);

$index=0;
$line=1;
$gpio=array();
$gpioPin=array();
foreach($newoutput as $value)
{
	if ($index > 12)
	{
			if ($line ==2)
			{
        $gpioPin['bcm']=$value;
        print_r($gpioPin);

			}
      elseif ($line==3)
      {
        $gpioPin['wpi']=$value;
        print_r($gpioPin);

      }
      elseif ($line==4)
      {
        $gpioPin['name']=$value;
        print_r($gpioPin);

      }
      elseif ($line==5)
      {
        $gpioPin['mode']=$value;
        print_r($gpioPin);

      }
      elseif ($line==6)
      {
        $gpioPin['value']=$value;
        print_r($gpioPin);

      }
      elseif ($line==7)
      print_r($gpioPin);

      {
        $gpioPin['phyiscal']=$value;
        print_r($gpioPin);
        $gpio=$gpioPin;
        print_r($gpio);
        $gpioPin=array();
      }

      if($line == 9)
      {
        $gpioPin['physical']=$value;
      }
      elseif($line==10)
      {
        $gpioPin['value']=$value;
      }
      elseif($line==11)
      {
        $gpioPin['mode']=$value;
      }
      elseif($line==12)
      {
        $gpioPin['name']=$value;
      }
      elseif($line==13)
      {
        $gpioPin['wpi']=$value;
      }
      elseif($line==14)
      {
        $gpioPin['bcm']=$value;
        $gpio=$gpioPin;
        print_r($gpio);
        print_r($gpioPin);
        $gpioPin=array();
        $line=0;

      }
      else {
        $line++;
        echo($value);

      }


	}

}

foreach($gpio as $x => $x_value) {
    echo "Key=" . $x . ", Value=" . $x_value;
    echo "<br>";
}
print_r($gpio);
?>
