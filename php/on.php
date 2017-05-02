<?php
require_once 'vendor/autoload.php';
use PiPHP\GPIO\GPIO;
use PiPHP\GPIO\Pin\OutputPinInterface;
use PiPHP\GPIO\Pin\InputPinInterface;

$gpio = new GPIO();
$pwmpin = $gpio->getOutputPin(17);
$en1pin = $gpio->getOutputPin(22);
$en2pin = $gpio->getOutputPin(27);

$pwmpin->setValue(PinInterface::VALUE_HIGH);
$en1pin->setValue(PinInterface::VALUE_HIGH);
$en2pin->setValue(PinInterface::VALUE_LOW);
?>
