<?php

namespace App\Http\Utils;

trait Connection
{
    public function keycode($data, $kata1, $kata2, $marked)
    {
        $length = strlen($data);
        for ($a = 0; $a < $length; $a = $a + 2) {
            if (isset($data[$a])) {
                $kata1 = $kata1 . $data[$a];
            }
            if (isset($data[$a + 1])) {
                $kata2 = $data[$a + 1] . $kata2;
            }
        }
        return str_replace($marked, '', $kata1 . $kata2);
    }

    public function config($keycode)
    {
        $key = explode(";", $keycode);
        return $db = [
            "driver" => $key[1],
            "host" => $key[2],
            "port" => $key[3],
            "database" => $key[4],
            "username" => $key[5],
            "password" => $key[6],
            "charset" => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix" => "",
            "strict" => false,
        ];
    }
}
