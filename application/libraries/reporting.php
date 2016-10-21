<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reporting {
    public $sql;

    function Reporting(){}

    function getDefaultFilterCompare($type, $field, $filter)
    {
        $where = '';

        switch ($type)
        {
            case 'bigint' :
            case 'decimal' :
            case 'double' :
            case 'float' :
            case 'int' :
                $where = "$field = $filter AND ";
                break;
            case 'char' :
            case 'varchar' :
            case 'tinytext' :
            case 'text' :
            case 'mediumtext' :
            case 'longtext' :
                $where = "$field like '%$filter%' AND ";
                break;
            case 'timestamp' :
            case 'datetime' :
                $date = json_decode($filter);

                // We could decode, means no inputs for DatePickers were selected.
                if(is_array($date))
                {
                    // Selected Date
                    if($date[0]->date_type == 5)
                    {
                        $where = "date($field) = '{$date[0]->start_date}' AND ";
                    }

                    // Selected Date to Date
                    if($date[0]->date_type == 6)
                    {
                        $where = "$field >= '{$date[0]->start_date}' AND $field <= '{$date[0]->end_date}' AND ";
                    }
                }
                else
                {
                    $dateNow = date("Y-m-d");

                    // Today
                    if($date == 1)
                    {
                        $where = "date($field) = '$dateNow' AND ";
                    }
                }
                break;
        }

        return $where;
    }

    function generateWhere($selected_filters)
    {
        if($selected_filters)
        {
            $where_fields = '';

            foreach ($selected_filters as $field => $filter) {

                $type = substr(strrchr($field, "_"), 1);
                $field = str_replace('_'.$type,"",$field);

                if($filter != "")
                    $where_fields .= $this->getDefaultFilterCompare($type, $field, $filter);
            }

            $where_fields = rtrim($where_fields, "AND ");
        }

        return $where_fields;
    }

} 