<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Utilities
{
    function Utilities(){}

    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
    {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    function short_string($string, $length)
    {
        if (strlen($string) > $length)
            $string =  substr($string, 0, $length) . '...';

        return $string;
    }

    function get_percentage($base, $x)
    {
        return ($base)? ($x * 100) / $base : 0;
    }

    function get_percentage_val($base_val, $perc_desired)
    {
        return ($perc_desired * $base_val) / 100;
    }

    function reduce_decimal($value){
        return ($value)? number_format($value, 2, '.', '') : 0;
    }
}