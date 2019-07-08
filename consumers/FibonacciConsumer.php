<?php

require_once(dirname(__FILE__).'/Consumer.php');

$fibonacci = new Consumer;
$fibonacci->processMessages("fibonacci");
