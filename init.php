<?php

require_once(dirname(__FILE__).'/Constants.php');

/*
 * Check mysql connection before start
 */
try {
    $mysql = new PDO(
        "mysql:dbname=" . (Constants::MYSQL)["dataBase"] . ";host=". (Constants::MYSQL)["host"],
        (Constants::MYSQL)["user"],
        (Constants::MYSQL)["password"]
    );
} catch (PDOException $e) {
    echo "Db connection has failed: \n" . $e->getMessage();
    die();
}

$mysql = null;

/*
 * Check redis connection before start
 */

exec("redis-cli -v || exit 1", $out, $exitCode);

if ($exitCode > 0) {
    echo "Can't connect to redis.\n" . $out;
    die();
}

/*
 *  Start scripts
 */

exec("php producers/PrimesProducer.php &  \
    php consumers/PrimeConsumer.php &  \
    php producers/FibonacciProducer.php & \
    php consumers/FibonacciConsumer.php &",
    $out,
    $exitCode
);

if ($exitCode > 0) {
    echo "Something went wrong.\n" . $out;
    die();
}
