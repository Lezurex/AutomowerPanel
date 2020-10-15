<?php


class SpamProtection {

    public static function isSpam($ip) {
        $spamData = json_decode(file_get_contents("spamdata.json"), true);

        $item = self::contains($spamData, $ip);
        if (null != $item) {
            $current = round(microtime(true) * 1000);
            if ($item['lastAccess'] < ($current - 3000)) {
                self::updateEntry($ip);
                return false;
            } else {
                self::updateEntry($ip);
                return true;
            }
        } else
            return false;

    }

    private static function contains($spamData, $ip) {
        foreach ($spamData as $item) {
            if ($item['ip'] == $ip) {
                return $item;
            }
        }
        array_push($spamData, array("ip" => $ip, "lastAccess" => round(microtime(true) * 1000)));
        file_put_contents("spamdata.json", json_encode($spamData));
        return null;
    }

    private static function updateEntry($ip) {
        $spamData = json_decode(file_get_contents("spamdata.json"), true);
        foreach ($spamData as $key => $item) {
            if ($item['ip'] == $ip) {
                $spamData[$key]['lastAccess'] = round(microtime(true) * 1000);
                file_put_contents("spamdata.json", json_encode($spamData));
            }
        }
    }
}