<?php

require_once(dirname(__FILE__).'/Consumer.php');

$prime = new Consumer;
$prime->processMessages("primes");
