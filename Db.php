<?php

declare(strict_types=1);

require_once(dirname(__FILE__).'/Constants.php');

class Db
{
    protected $mysql = Constants::MYSQL;

    protected $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    private function connect() :?PDO
    {
        $mysql = new PDO(
            "mysql:dbname=" . $this->mysql["dataBase"] . ";host=". $this->mysql["host"],
            $this->mysql["user"],
            $this->mysql["password"],
            $this->options
        );

        return $mysql;
    }

    public function updateEntity(string $entityName, string $entityValue) :void
    {
        $mysql = $this->connect();

        $mysql->beginTransaction();

        $stmt = $mysql->prepare("SELECT `sum` FROM `test` FOR UPDATE");

        if ($stmt->execute([])) {
            $sum = bcadd($entityValue, $stmt->fetch(PDO::FETCH_ASSOC)["sum"]);
        }

        $column = (Constants::$$entityName)['column'];

        $update = $mysql->prepare("UPDATE `test` SET `sum` = :sum, $column = $column + 1");

        $update->execute([':sum' => $sum]);

        $mysql->commit();
    }

    public function checkIfLimitReached($entityName) :?Generator
    {
        $mysql = $this->connect();
        $column = (Constants::$$entityName)['column'];
        $limit = (Constants::$$entityName)['messageLimit'];

        while (true) {
            $yield = yield $mysql->query("SELECT {$column} FROM test")->fetchObject()->{$column} < $limit;
            if ($yield == 'stop') {
                return;
            }
        }
    }
}
