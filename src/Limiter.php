<?php


namespace Avitotask;


class Limiter {

    private $db;
    private $interval;
    private $maxConnections;

    public function __construct(int $interval, int $maxConnections) {
        $this->db = Database::getConnection();
        $this->interval = $interval;
        $this->maxConnections = $maxConnections;
    }

    private function getIPv4() : string {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;

        return $ip;
    }

    public function isLimit() : bool {
        $ipv4 = $this->getIPv4();
        $result = $this->db->query("SELECT `ipv4`, `timelimit`, `connections` FROM `apilimiter` WHERE `ipv4` = '" . $ipv4 . "'");
        $result = $result->fetch();
        if ($result) {
            if (time() < ($result['timelimit'] + $this->interval)) {
                if ($result['connections'] < $this->maxConnections) {
                    $connections = $result['connections'] + 1;
                    $this->db->query("UPDATE `apilimiter` SET `connections`={$connections} WHERE `ipv4` = '" . $ipv4 . "'");
                    return false;
                } else {
                    return true;
                }
            } else {
                $time = time();
                $this->db->query("UPDATE `apilimiter` SET `connections`=1, `timelimit`={$time} WHERE `ipv4` = '" . $ipv4 . "'");
                return false;
            }
        }
        $time = time();
        $this->db->query("INSERT INTO `apilimiter`(`ipv4`, `timelimit`, `connections`) VALUES ('" . $ipv4 . "', {$time}, 1)");
        return false;
    }


}