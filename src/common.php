<?php

namespace PhalconPoll {

    function ip2hex($ip)
    {
        $ips = explode('.', $ip);
        return sprintf("%02X%02X%02X%02X", intval($ips[0]), intval($ips[1]), intval($ips[2]), intval($ips[3]));
    }
}
