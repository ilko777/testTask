<?php

class Constants
{
    const REDIS = [
        "host" => "redis",
        "port" =>"6379",
    ];

    const MYSQL = [
        "user" => "",
        "password" => "",
        "dataBase" => "",
        "table" => "test",
        "host" => "",
    ];

    public static $fibonacci = [
        "messageLimit" => 2000,
        "timeout" => 100, //100000,
        "redisKey" => "fibonacci",
        "column" => "count_fib",
    ];

    public static $primes = [
        "messageLimit" => 5000,
        "timeout" => 200,//200000,
        "redisKey" => "primes",
        "column" => "count_prime",
        "maxRange" => 1000000,
    ];
}
