<?php

require_once(dirname(__FILE__).'/../Constants.php');
require_once(dirname(__FILE__).'/../Redis.php');

/*
 * Sieve of Eratosthenes
 */
function primeNumbersGenerator()
{
    $maxRange = (Constants::$primes)["maxRange"];
    $numbers = range(0, $maxRange);
    $i = 2;

    while ($i <= $maxRange) {
        if ($numbers[$i] != 0) {
            $yield = yield $numbers[$i];
            if ($yield == 'stop') {
                return;
            }
        }
        $j = $i << 1;
        while ($j <= $maxRange) {
            $numbers[$j] = 0;
            $j += $i;
        }
        ++$i;
    }
}

function fillQueueByPrimes($limit, $interval)
{
    $redis = new Redis;
    $counter = 0;

    foreach (primeNumbersGenerator() as $prime) {
        if ($counter == $limit) {
            primeNumbersGenerator()->send('stop');
            return;
        }
        ++$counter;

        $redis->set("primes", $prime);

        usleep($interval);
    }
}


fillQueueByPrimes((Constants::$primes)["messageLimit"], (Constants::$primes)["timeout"]);
