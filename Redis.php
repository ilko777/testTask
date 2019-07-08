<?php

declare(strict_types=1);

require_once(dirname(__FILE__).'/Constants.php');

class Redis
{

    public function isInstalled(): bool
    {
        exec("redis-cli -v || exit 1", $out, $exitCode);

        return ($exitCode > 0) ? false : true;
    }

    private function run(string $cmd): string
    {
        return system(
            "redis-cli -h " . Constants::REDIS["host"] . " -p " . Constants::REDIS["port"] . " " . $cmd,
            $out
        );
    }

    public function set(string $entityName, string $entityValue): void
    {
        $this->run("RPUSH ".(Constants::$$entityName)["redisKey"] . " " . $entityValue);
    }

    public function get(string $entityName) :string
    {
        return $this->run("LPOP ".(Constants::$$entityName)["redisKey"]);
    }

    public function listLenth(string $entityName) :int
    {
        return (int) $this->run("LLEN ".(Constants::$$entityName)["redisKey"] . " | awk '{print}'");
    }
}
