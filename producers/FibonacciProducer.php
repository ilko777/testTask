<?php

require_once(dirname(__FILE__).'/../Constants.php');
require_once(dirname(__FILE__).'/../Redis.php');

function fibonacciNumbersGenerator($limit)
{
    $numbers = [0,1,1];

    for ($i = 0; $i <= $limit -1; $i++) {
        if ($i < 3) {
            yield $numbers[$i];
        } else {
            $numbers[$i] = bcadd($numbers[$i - 1], $numbers[$i - 2]);
            yield $numbers[$i];
        }
    }
}

function fillQueuebyFibonacci($limit, $interval)
{
    $redis = new Redis;

    foreach (fibonacciNumbersGenerator($limit) as $fibonacci) {
        $redis->set("fibonacci", $fibonacci);
        usleep($interval);
    }
}

fillQueuebyFibonacci((Constants::$fibonacci)["messageLimit"], (Constants::$fibonacci)["timeout"]);
