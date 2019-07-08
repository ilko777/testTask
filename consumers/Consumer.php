<?php

declare(strict_types=1);

require_once(dirname(__FILE__).'/../Db.php');
require_once(dirname(__FILE__).'/../Redis.php');


class Consumer
{
    public function processMessages(string $consumer) :void
    {
        $db = new Db;
        $redis = new Redis;

        foreach ($db->checkIfLimitReached($consumer) as $notReached) {
            if ($notReached) {
                if ($redis->listLenth($consumer) > 0) {
                    $number = $redis->get($consumer);
                    $db->updateEntity($consumer, $number);
                }
            } else {
                $db->checkIfLimitReached($consumer)->send('stop');

                return;
            }
        }
    }
}
