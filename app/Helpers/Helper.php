<?php

namespace App\Helpers;

class Helper
{

    public function getRandomStudent($length)
    {
        $today = date('YmdHis');
        $characters = sprintf("%0.9s",str_shuffle(rand(12,30000) * time()));
        $main = $today. "" . $characters;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($main) - 1);
            $randomString .= $main[$index];
        }
        return $randomString;
    }

}